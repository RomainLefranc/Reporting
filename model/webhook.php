<?php
include 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $raw_payload = file_get_contents('php://input');
    global $pdo;
    $requete = $pdo->prepare("INSERT INTO storieInsta (json) VALUES (:json)");
    $requete->execute(["json" => $raw_payload]); 

} else {
    trigger_error("Invalid request!");
}
?>