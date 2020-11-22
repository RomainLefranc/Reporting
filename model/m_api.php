<?php
    include "pdo.php";
    /* 
    M : Récupère les stories
    O : array contenant les données
    I : code equipier
     */
    function getStories($idCompteInstagram,$dateDebut,$dateFin) {
        global $pdo;
        $requete = $pdo->prepare('SELECT libQuest, reponse FROM qdp INNER JOIN equipier ON qdp.codeEq = equipier.codeEq WHERE equipier.codeEq = :codeEq');
        $requete->execute(["codeEq" => $codeEq]);
        $resultat = $requete->fetchall(); 
        $retour['success'] = true;
        $retour['message'] = "Voici les stories";
        $retour['resultat']['nb'] = count($resultat);
        $retour['resultat']['qdp'] = $resultat;
        return $retour;
    }
?>