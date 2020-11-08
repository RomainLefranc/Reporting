<?php
    include "model/m_utilisateurs.php";

    if (isset($_POST["submitConnexion"])) {

        $id = htmlspecialchars($_POST['id']);
        $mdp = htmlspecialchars($_POST['mdp']);
        
        if (Connexion($id, $mdp)) {
            $id_utilisateur = getIdUtilisateur($id,$mdp);
            $_SESSION["user"] = getPseudoUser($id_utilisateur);
            header ('location: index.php?a=A');
        } else {
            $_POST["erreur"] = 1;
        }
    }
    $view = 'v_connexion';
?>