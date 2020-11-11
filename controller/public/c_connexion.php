<?php

    include "model/m_utilisateurs.php";
    
    if (isset($_POST["id"]) && isset($_POST['mdp'])) {
        require_once 'vendor/google/recaptcha/src/autoload.php';
        $recaptcha = new \ReCaptcha\ReCaptcha('6LeQn-EZAAAAAJIPWyMdK0NjEGgmIGbIEWti3_Ee');
     
        $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
        if ($resp->isSuccess()) {

            $id = htmlspecialchars($_POST['id']);
            $mdp = htmlspecialchars($_POST['mdp']);

            if (Connexion($id, $mdp)) {
                $id_utilisateur = getIdUtilisateur($id,$mdp);
                $_SESSION["user"] = getPseudoUser($id_utilisateur);
                header ('location: index.php?a=a');
            } else {
                $_POST["erreur"] = 1;
            }
        } else {
            $_POST["erreur"] = 1;
        }
    }
?>