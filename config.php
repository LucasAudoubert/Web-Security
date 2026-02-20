<?php
// config.php - Connexion centralisée à la base de données

if (!function_exists('connectDB')) {
    function connectDB(): PDO {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=botanica', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}
