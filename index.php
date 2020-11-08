<?php

session_start();
require_once __DIR__ . '/Facebook/autoload.php';

$navigations = array (
    ['action' => "c","controller" => "connexion"],
    ['action' => "a","controller" => "admin"],
    ['action' => "l","controller" => "lier"],
    ['action' => "d","controller" => "deconnexion"]
);

$actionEstValide = false;
if (isset($_GET["a"])) {
    $action = htmlspecialchars($_GET["a"]);
    $action = strtolower($action);

    foreach ($navigations as $navigation) {
        if ($navigation["action"] == $action) {
            include 'controller/c_'.$navigation["controller"].'.php';
            include "view/v_$view.php";
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