<?php
    if (isset($_SESSION['user'])) {
        include 'model/m_pagesInsta.php';
        include 'model/m_compteFB.php';
        $username = htmlspecialchars($_SESSION['user']);
        $view = 'admin/facebook/v_comparatif';
        $listePageFB = getPagesInsta_BDD();
    }
?>