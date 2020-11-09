<?php
include 'pdo.php';
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