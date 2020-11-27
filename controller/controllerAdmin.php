<?php
    /* Vérification que l'utilisateur est connecté */
    if (isset($_SESSION['reporting_connecté']) && htmlspecialchars($_SESSION['reporting_connecté']) == true) {
        $username = htmlspecialchars($_SESSION['reporting_user']);
        include 'admin/'.$controller.'.php';
    } else {
        $view = '../public/v_403';
    }
?>