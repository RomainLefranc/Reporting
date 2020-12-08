<?php
    include "pdo.php";

    function getUser($login) {
        global $pdo;
        $requete = $pdo->prepare('SELECT * FROM reporting_users WHERE login = :login');
        $requete->execute(['login' => $login]);
        $resultat = $requete->fetchall();
        return $resultat;
    }

    function getListeUtilisateur() {
        global $pdo;
        $requete = $pdo->prepare('SELECT * FROM reporting_users');
        $requete->execute();
        $resultat = $requete->fetchall();
        return $resultat;
    }
    function utilisateurExiste($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('
            SELECT 
                IF((
                    SELECT 
                    COUNT(*) 
                    FROM reporting_users 
                    WHERE id = :id
                ) > 0, TRUE, FALSE)');
        $requete->execute(['id' => $id_utilisateur]);
        $resultat = $requete->fetchall();
        return $resultat[0][0];
    }

    function getUtilisateur($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('SELECT * FROM reporting_users WHERE id = :id');
        $requete->execute(['id' => $id_utilisateur]);
        $resultat = $requete->fetchall();
        return $resultat[0];
    }
    function ajouterUtilisateur($pseudo, $login, $mdp) {
        global $pdo;
        $requete = $pdo->prepare('INSERT INTO reporting_users (pseudo, login, mdp) VALUES (:pseudo, :login, :mdp)');
        $requete->execute([
            ':pseudo' => $pseudo,
            ':login' => $login, 
            ':mdp' => $mdp
        ]);
    }

    function modifierUtilisateur($login, $mdp, $id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('UPDATE reporting_users SET login = :login, mdp = :mdp WHERE id = :id');
        $requete->execute([
            ':login' => $login,
            ':mdp' => $mdp,
            ':id' => $id_utilisateur
        ]);
    }

    function supprimerUtilisateur($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('DELETE FROM reporting_users WHERE id = :id');
        $requete->execute([':id' => $id_utilisateur]);
    }

    function loginEstUtilise($login) {
        global $pdo;
        $requete = $pdo->prepare('
            SELECT IF((SELECT COUNT(*) FROM reporting_users WHERE login = :login) > 0, TRUE, FALSE)');
        $requete->execute(['login' => $login]);
        $resultat = $requete->fetchall();
        return $resultat[0][0];
    } 
?>