<?php

    /* Dependance de la page */
    include 'model/m_pagesInsta.php';
    include 'model/m_compteFB.php';

    $listePageInsta = getPagesInsta_BDD();
    $selectPageInsta = '';

    foreach ($listePageInsta as $pageInsta) {
        $token = getToken($pageInsta['id_comptes']);
        $selectPageInsta.= '<option value="' . $pageInsta[0] . '" data-value="' . $token . '" data-nom="' . $pageInsta[1] . '">' . $pageInsta[1] . '</option>';
    }
?>