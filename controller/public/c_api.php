<?php
    include "model/m_api.php";
    if (isset($_GET['idPageInsta']) && isset($_GET['dateDebut']) && isset($_GET['dateFin'])) {
        $idPageInsta = htmlspecialchars($_GET['idPageInsta']);
        $dateDebut = htmlspecialchars($_GET['dateDebut']);
        $dateFin = htmlspecialchars($_GET['dateFin']);
        if ($dateDebut < $dateFin) {
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