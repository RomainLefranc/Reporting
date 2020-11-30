<?php
    include "pdo.php";
    /* 
    M : Récupère les stories
    O : array contenant les données
    I : code equipier
     */
    function getStories($idCompteInstagram,$dateDebut,$dateFin) {
        global $pdo;
        $requete = $pdo->prepare('
            SELECT 
                date, 
                impression, 
                reach
                FROM reporting_storiesInsta 
                WHERE id_pagesInsta = :id_pagesInsta AND date BETWEEN :dateDebut AND :dateFin
                ORDER BY date
        ');
        $requete->execute([
            "id_pagesInsta" => $idCompteInstagram,
            "dateDebut" => $dateDebut,
            "dateFin" => $dateFin
        ]);
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        $retour['success'] = true;
        $retour['message'] = "Voici les stories";
        $retour['resultat']['nb'] = count($resultat);
        $retour['resultat']['stories'] = $resultat;
        return $retour;
    }
?>