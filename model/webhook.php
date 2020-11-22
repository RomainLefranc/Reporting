<?php
include 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $raw_payload = file_get_contents('php://input');
    $json = json_decode($raw_payload, true);

    $idPageInsta = $json['entry'][0]['id'];
    $idMedia = $json['entry'][0]['changes'][0]['value']['media_id'];
    $date = $json['entry'][0]['time'];
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