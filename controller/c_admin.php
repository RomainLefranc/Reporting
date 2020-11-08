<?php
    if (isset($_SESSION['user'])) {
        $view = 'v_admin';
        $username = htmlspecialchars($_SESSION['user']);
    }
?>