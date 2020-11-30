
<?php

/* Dependances de la page*/
include 'model/m_pagesInsta.php';
include 'model/m_pagesFB.php';

/* Récuperation de toutes les comptes Instagram dans la BDD*/
$listePagesInsta = getPagesInsta_BDD();

/* Récuperation de toutes les pages Facebook dans la BDD */
$listePagesFB = getPagesFB_BDD();

?>
