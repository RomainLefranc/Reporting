<?php
    if (isset($_SESSION['user'])) {
        $username = htmlspecialchars($_SESSION['user']);
        include 'admin/'.$controller.'.php';
    } else {
        $view = '../public/v_403';
    }
?>


