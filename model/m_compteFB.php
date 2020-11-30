<?php
include 'pdo.php';
function getListeComptesFB(){
    global $pdo;
    $requete = $pdo->prepare("SELECT * FROM reporting_comptesFB");
    $requete->execute();
    $resultat = $requete->fetchall();
    return $resultat;
}
function ajouterCompteFB($id, $nom, $jeton){
    global $pdo;
    $requete = $pdo->prepare("INSERT INTO reporting_comptesFB(id, nom, jeton) VALUES (:id, :nom, :jeton)");
    $requete->bindParam(':id',$id);
    $requete->bindParam(':nom',$nom);
    $requete->bindParam(':jeton',$jeton);
    $requete->execute();
}
function getToken($id){
    global $pdo;
    $requete = $pdo->prepare("SELECT jeton FROM reporting_comptesFB WHERE id = :id");
    $requete->bindParam(':id',$id);
    $requete->execute();
    $resultat = $requete->fetchall();
    return $resultat[0]['jeton'];
}

function setToken($id, $token){
    global $pdo;
    $requete = $pdo->prepare("UPDATE reporting_comptesFB SET jeton = :token WHERE id = :id");
    $requete->bindParam(':token',$token);
    $requete->bindParam(':id',$id);
    $requete->execute();
}
function getComptesFB($id){
    global $pdo;
    $requete = $pdo->prepare("SELECT * FROM reporting_comptesFB WHERE id = :id");
    $requete->bindParam(':id',$id);
    $requete->execute();
    $resultat = $requete->fetchall();
    return $resultat[0]['jeton'];
}
?>