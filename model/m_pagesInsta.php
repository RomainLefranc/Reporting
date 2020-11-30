<?php
include 'pdo.php';

function ajouterPageInsta($idPageFB,$idPageInsta,$nomPageInsta){
    global $pdo;
    $requete = $pdo->prepare("
        INSERT INTO reporting_pagesInsta(id, nom, id_pagesFB) 
        VALUES (:idPageInsta, :nom, :idPageFB)
    ");
    $requete->bindParam(':idPageInsta',$idPageInsta);
    $requete->bindParam(':nom',$nomPageInsta);
    $requete->bindParam(':idPageFB',$idPageFB);
    $requete->execute();
}
function getPagesInsta_BDD(){
    global $pdo;
    $requete = $pdo->prepare("SELECT * FROM reporting_pagesInsta INNER JOIN reporting_pagesFB ON reporting_pagesInsta.id_pagesFB = reporting_pagesFB.id");
    $requete->execute();
    $resultat = $requete->fetchall();
    return $resultat;
}
?>