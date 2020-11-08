<?php
include 'pdo.php';
function getListeComptesFB(){
    global $pdo;
    $requete = $pdo->prepare("SELECT * FROM comptesFB");
    $requete->execute();
    $resultat = $requete->fetchall();
    return $resultat;
}
function ajouterCompteFB($id, $nom, $jeton){
    global $pdo;
    $requete = $pdo->prepare("INSERT INTO comptesFB(id, nom, jeton) VALUES (:id, :nom, :jeton)");
    $requete->bindParam(':id',$id);
    $requete->bindParam(':nom',$nom);
    $requete->bindParam(':jeton',$jeton);
    $requete->execute();
}
function getToken($id){
    global $pdo;
    $requete = $pdo->prepare("SELECT jeton FROM comptesFB WHERE id = :id");
    $requete->bindParam(':id',$id);
    $requete->execute();
    $resultat = $requete->fetchall();
    return $resultat[0]['jeton'];
}

function setToken($id, $token){
    global $pdo;
    $requete = $pdo->prepare("UPDATE comptesFB SET jeton = :token WHERE id = :id");
    $requete->bindParam(':token',$token);
    $requete->bindParam(':id',$id);
    $requete->execute();
}

function getPagesFB_BDD(){
    global $pdo;
    $requete = $pdo->prepare("SELECT * FROM pagesFB");
    $requete->execute();
    $resultat = $requete->fetchall();
    return $resultat;
}

function ajouterPageFB($id,$nom,$idC){
    global $pdo;

    $requete = $pdo->prepare("INSERT INTO pagesFB(id, nom, id_comptes) VALUES (:id, :nom, :idC)");
    $requete->bindParam(':id',$id);
    $requete->bindParam(':nom',$nom);
    $requete->bindParam(':idC',$idC);

    $requete->execute();
}


?>