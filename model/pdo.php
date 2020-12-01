<?php
    try {
        $pdo = new PDO('mysql:host=nautiluspznautsw.mysql.db;dbname=nautiluspznautsw;charset=utf8mb4', 'nautiluspznautsw', 'nautSW2017');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur : '.$e->getMessage());
    }
?>