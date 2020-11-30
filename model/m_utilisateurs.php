<?php
    include "pdo.php";

    function getUser($login) {
        global $pdo;
        $requete = $pdo->prepare('SELECT * FROM reporting_users WHERE login = :login');
        $requete->execute(['login' => $login]);
        $resultat = $requete->fetchall();
        return $resultat;
    }



?>