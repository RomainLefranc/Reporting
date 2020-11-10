<?php
    if (isset($_SESSION['user'])) {
        include 'model/m_pagesInsta.php';
        include 'model/m_compteFB.php';
        $username = htmlspecialchars($_SESSION['user']);
        $view = 'admin/instagram/v_comparatif';
        $listePageInsta = getPagesInsta_BDD();
    }
?>