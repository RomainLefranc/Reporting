<?php

    /* Dependances de la page */
    include 'model/m_pagesFB.php';
    include 'model/m_compteFB.php';

    /* Récuperation de toute les pages Facebook */
    $listePageFB = getPagesFB_BDD();
?>