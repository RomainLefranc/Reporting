<?php
    include "pdo.php";
    
    function Connexion ($login,$mdp) {
        global $pdo;
        $requete = $pdo->prepare('SELECT IF((SELECT COUNT(*) FROM users WHERE login = :login AND mdp = :mdp) > 0, TRUE, FALSE)');
        $requete->execute(['login' => $login, "mdp" => $mdp]);
        $resultat = $requete->fetchall();
        return $resultat[0][0];
    }

    function getRoleUser($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('SELECT Id_Role_Utilisateurs FROM utilisateurs WHERE id_utilisateur = :id_utilisateur');
        $requete->execute(['id_utilisateur' => $id_utilisateur]);
        $resultat = $requete->fetchall();
        return $resultat[0][0];
    }

    function getListeUsers() {
        global $pdo;
        $requete = $pdo->prepare('SELECT id_utilisateur, pseudo, login, mdp, libRole, libSociete FROM (utilisateurs INNER JOIN role_utilisateurs ON utilisateurs.Id_Role_Utilisateurs = role_utilisateurs.Id_Role_Utilisateurs ) INNER JOIN Societe ON utilisateurs.Id_Societe = societe.Id_Societe');
        $requete->execute();
        $resultat = $requete->fetchall();
        return $resultat;
    }
    function UserExiste($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('SELECT IF((SELECT COUNT(*) FROM utilisateurs WHERE id_utilisateur = :id_utilisateur) > 0, TRUE, FALSE)');
        $requete->execute(['id_utilisateur' => $id_utilisateur]);
        $resultat = $requete->fetchall();
        return $resultat[0][0];
    }

    function addUser($pseudo, $login, $mdp, $societe, $role) {
        global $pdo;
        $requete = $pdo->prepare('INSERT INTO utilisateurs (pseudo, login, mdp, id_role_utilisateurs, id_societe) VALUES (:pseudo, :login, :mdp, :role, :societe)');
        $requete->execute(['pseudo' => $pseudo,'login' => $login,'mdp' => $mdp,'role' => $role,'societe' => $societe]);
    }

    function deleteUser($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur');
        $requete->execute(['id_utilisateur' => $id_utilisateur]);
    }

    function getUser($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('SELECT pseudo, login, mdp, utilisateurs.Id_Role_Utilisateurs AS Id_Role_Utilisateurs, libRole,utilisateurs.Id_Societe AS Id_Societe, libSociete FROM (utilisateurs INNER JOIN role_utilisateurs ON utilisateurs.Id_Role_Utilisateurs = role_utilisateurs.Id_Role_Utilisateurs ) INNER JOIN Societe ON utilisateurs.Id_Societe = societe.Id_Societe WHERE id_utilisateur = :id_utilisateur');
        $requete->execute(['id_utilisateur' => $id_utilisateur]);
        $resultat = $requete->fetchall();
        return $resultat[0];
    }

    function updateUser($pseudo, $login, $mdp, $societe, $role) {
        global $pdo;
        $requete = $pdo->prepare('UPDATE utilisateurs SET pseudo = :pseudo, mdp = :mdp, Id_Role_Utilisateurs = :role, Id_Societe = :societe WHERE login = :login');
        $requete->execute(['pseudo' => $pseudo, 'login' => $login, 'mdp' => $mdp, 'role' => $role, 'societe' => $societe]);
    }

    function getListeUtilisateur() {
        global $pdo;
        $requete = $pdo->prepare('SELECT * FROM users');
        $requete->execute();
        $resultat = $requete->fetchall();
        return $resultat;
    }
    function getPseudoUser($id_utilisateur) {
        global $pdo;
        $requete = $pdo->prepare('SELECT pseudo FROM users WHERE id = :id_utilisateur');
        $requete->execute(['id_utilisateur' => $id_utilisateur]);
        $resultat = $requete->fetchall();
        return $resultat[0][0];
    }
    function getIdUtilisateur($id, $mdp) {
        global $pdo;
        $requete = $pdo->prepare('SELECT id FROM users WHERE login = :login AND mdp = :mdp');
        $requete->execute(['login' => $id, "mdp" => $mdp]);
        $resultat = $requete->fetchall();
        return $resultat[0][0];
    }

    function getUsers($login) {
        global $pdo;
        $requete = $pdo->prepare('SELECT * FROM users WHERE login = :login');
        $requete->execute(['login' => $login]);
        $resultat = $requete->fetchall();
        return $resultat;
    }



?>