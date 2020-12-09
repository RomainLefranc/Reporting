<?php

include "model/m_utilisateurs.php";

/* Dictionnaire de message
GET
1 => Ajout effectué
2 => Suppression effectué
3 => Modification effectué
4 => Cette utilisateur n'existe pas
*/
if ($username == "admin") {
    if (isset($_GET['crud'])) {
        $crud = htmlspecialchars($_GET['crud']);
        switch ($crud) {
            case 'c': /* CAS => CREATE */
                if (isset($_POST['submitCreateUtilisateur'])) {
                    $pseudo = htmlspecialchars($_POST['pseudo']);
                    $login = htmlspecialchars($_POST['login']);
                    if (loginEstUtilise($login)) {
                        $_POST['msg'] = 1;
                    } else {
                        $mdp = htmlspecialchars($_POST['mdp']);
                        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
                        ajouterUtilisateur($pseudo, $login, $mdp);
                        header("location: index.php?a=ga&msg=1");
                    }
                }
                break;
            case 'u':
            case 'd':
                $id_utilisateur = htmlspecialchars($_GET['iu']);
                /* verification que l'id utilisateur correspond a une utilisateur */
                if (utilisateurExiste($id_utilisateur)) {
                    $utilisateur = getUtilisateur($id_utilisateur);
                    switch ($crud) {
                        case 'u': /* CAS => UPDATE */
                            if (isset($_POST['submitUpdateUtilisateur'])) {
                                $login = htmlspecialchars($_POST['login']);
                                $mdp = htmlspecialchars($_POST['mdp']);
                                if ($mdp !== $utilisateur['mdp']) {
                                    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
                                }
                                modifierUtilisateur($login, $mdp, $id_utilisateur);
                                header("location: index.php?a=ga&msg=3"); 
                            }                        
                            break;
                        case 'd': /* CAS => DELETE */
                            if (isset($_POST['submitDeleteUtilisateur'])) {
                                supprimerUtilisateur($id_utilisateur);
                                header("location: index.php?a=ga&msg=2"); 
                            }
                            break;
                    }
                } else {
                    header("location: index.php?a=ga&msg=4"); 
                }
                break;
            default:
                $view = '../public/v_404';
                break;
        }
    } else { /* CAS READ+ */
        $listeUtilisateur = getListeUtilisateur();
    }
} else {
    $view = '../public/v_403';
}

?>