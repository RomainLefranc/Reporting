<?php
    /* Vérification que l'utilisateur est connecté */
    if (isset($_SESSION['connecté']) && htmlspecialchars($_SESSION['connecté']) == true) {
        $username = htmlspecialchars($_SESSION['user']);
        include 'admin/'.$controller.'.php';
    } else {
        $view = '../public/v_403';
    }
?>