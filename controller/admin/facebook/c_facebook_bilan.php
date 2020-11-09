<?php
if (isset($_SESSION['user'])) {
    include 'model/m_pagesFB.php';
    include 'model/m_compteFB.php';
    $username = htmlspecialchars($_SESSION['user']);
    $view = 'admin/facebook/v_bilan';
    $listePageFB = getPagesFB_BDD();
    $selectPageFB = '';
    foreach ($listePageFB as $pageFB) {
        $token = getToken($pageFB['id_comptes']);
        $selectPageFB.= '<option value="' . $pageFB[0] . '" data-value="' . $token . '" data-nom="' . $pageFB[1] . '">' . $pageFB[1] . '</option>';
    }
}
?>