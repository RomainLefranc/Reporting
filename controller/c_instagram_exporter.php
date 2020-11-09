<?php
if (isset($_SESSION['user'])) {
    include 'model/m_pagesInsta.php';
    include 'model/m_compteFB.php';
    $username = htmlspecialchars($_SESSION['user']);
    $view = 'instagram/v_exporter';
    $listePageInsta = getPagesInsta_BDD();
    $selectPageInsta = '';
    foreach ($listePageInsta as $pageInsta) {
        $token = getToken($pageInsta['id_comptes']);
        $selectPageInsta.= '<option value="' . $pageInsta[0] . '" data-value="' . $token . '" data-nom="' . $pageInsta[1] . '">' . $pageInsta[1] . '</option>';
    }
}
?>