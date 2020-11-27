<?php
    include "model/m_api.php";

    if (isset($_GET['idPageInsta']) && isset($_GET['dateDebut']) && isset($_GET['dateFin'])) {
        
        /* Nettoyage des données reçus */
        $idPageInsta = htmlspecialchars($_GET['idPageInsta']);
        $dateDebut = htmlspecialchars($_GET['dateDebut']);
        $dateFin = htmlspecialchars($_GET['dateFin']);
        
        /* Vérification de la validité de la periode choisi */
        if ($dateDebut < $dateFin) {
            /* Récuperation des stories de la periode pour la page Instagram */
            $resultat = getStories($idPageInsta,$dateDebut,$dateFin);
        } else {
            $resultat['success'] = false;
            $resultat['message'] = "parametre invalide";
        }
    } else {
        $resultat['success'] = false;
        $resultat['message'] = "Il manque des parametres";
    }
?>