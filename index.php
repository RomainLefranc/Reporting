<?php

session_start();
require_once __DIR__ . '/Facebook/autoload.php';

$navigations = array (
    ['action' => "c","controller" => "c_connexion"],
    ['action' => "a","controller" => "admin/c_admin"],
    ['action' => "l","controller" => "admin/c_lier"],
    ['action' => "d","controller" => "admin/c_deconnexion"],
    ['action' => "ib","controller" => "admin/instagram/c_instagram_bilan"],
    ['action' => "icsv","controller" => "admin/instagram/c_instagram_csv"],
    ['action' => "ie","controller" => "admin/instagram/c_instagram_exporter"],
    ['action' => "fb","controller" => "admin/facebook/c_facebook_bilan"],
    ['action' => "fcsv","controller" => "admin/facebook/c_facebook_csv"],
    ['action' => "fe","controller" => "admin/facebook/c_facebook_exporter"]


);

$actionEstValide = false;
if (isset($_GET["a"])) {
    $action = htmlspecialchars($_GET["a"]);
    $action = strtolower($action);

    foreach ($navigations as $navigation) {
        if ($navigation["action"] == $action) {
            include 'controller/'.$navigation["controller"].'.php';
            include "view/$view.php";
            $actionEstValide = true;
        }
    }
    if (!$actionEstValide) {
        include "view/v_404.php";
    }
} else {
    header("location: index.php?a=C");
}
?>