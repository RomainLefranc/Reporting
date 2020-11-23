<?php
include 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $raw_payload = file_get_contents('php://input');
    $json = json_decode($raw_payload, true);

    $idPageInsta = $json['entry'][0]['id'];
    $idMedia = $json['entry'][0]['changes'][0]['value']['media_id'];
    $timestamp = $json['entry'][0]['time'];
    date_default_timezone_set('Indian/Reunion');
    $date = date("Y-m-d H:i:s", $timestamp);
    $date = new DateTime($date);
    $date->sub(new DateInterval('P1D'));
    $date = $date->format('Y-m-d H:i:s');
    $impression = $json['entry'][0]['changes'][0]['value']['impressions'];
    $reach = $json['entry'][0]['changes'][0]['value']['reach'];

    global $pdo;
    $requete = $pdo->prepare("
        INSERT 
            INTO storiesInsta (id, id_pagesInsta, date, impression, reach) 
            VALUES (:id, :id_pagesInsta, :date, :impression, :reach)
    ");
    $requete->execute([
        "id"                => $idMedia,
        "id_pagesInsta"     => $idPageInsta,
        "date"              => $date,
        "impression"        => $impression,
        "reach"             => $reach
    ]);
} else {
    trigger_error("Invalid request!");
}
?>