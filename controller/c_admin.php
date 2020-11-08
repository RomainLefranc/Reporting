<?php
    if (isset($_SESSION['user'])) {
        $view = 'admin';
        $username = htmlspecialchars($_SESSION['user']);
    }
?>