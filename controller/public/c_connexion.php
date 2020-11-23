<?php

    include "model/m_utilisateurs.php";
    if (isset($_SESSION['user'])) {
        header ('location: index.php?a=a'); 
    } elseif (isset($_POST["id"]) && isset($_POST['mdp'])) {
        require_once 'vendor/google/recaptcha/src/autoload.php';
        $recaptcha = new \ReCaptcha\ReCaptcha('6LeQn-EZAAAAAJIPWyMdK0NjEGgmIGbIEWti3_Ee');
        $cleCaptcha = htmlspecialchars($_POST['g-recaptcha-response']);
        $resp = $recaptcha->verify($cleCaptcha);
        if ($resp->isSuccess()) {
            $id = htmlspecialchars($_POST['id']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $user = getUsers($id);
            if (empty($user)) {
                $_POST["erreur"] = 1;
            } else {
                if (password_verify($mdp,$user[0]['mdp'])) {
                    $_SESSION["user"] = $user[0]['pseudo'];
                    header ('location: index.php?a=a'); 
                } else {
                    $_POST["erreur"] = 1;
                }
            }
        } else {
            $_POST["erreur"] = 2;
        }
    }
?>