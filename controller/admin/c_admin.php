<?php
    if (isset($_SESSION['user'])) {
        $view = 'admin/v_admin';
        $username = htmlspecialchars($_SESSION['user']);
    }
?>