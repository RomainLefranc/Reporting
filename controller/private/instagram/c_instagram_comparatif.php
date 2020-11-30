<?php

    /* Dependances de la page */
    include 'model/m_pagesInsta.php';
    include 'model/m_compteFB.php';

    /* Récuperation de toutes les comptes Instagram */
    $listePageInsta = getPagesInsta_BDD();
?>