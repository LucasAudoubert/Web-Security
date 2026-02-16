<?php
// user_model.php

// Connect to database
function connectDB(): PDO {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=projet_secu', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

// Get user by email
function getUserByEmail(PDO $pdo, string $email): ?array {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

// Check if email exists
function checkEmailExists(PDO $pdo, string $email): bool {
    return getUserByEmail($pdo, $email) !== null;
}

// Create a new user
function createUser(PDO $pdo, string $prenom, string $nom, string $email, string $motdepasse): bool {
    if (checkEmailExists($pdo, $email)) {
        return false;
    }
    $hashedPassword = password_hash($motdepasse, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO users (prenom, nom, email, motdepasse)
        VALUES (:prenom, :nom, :email, :motdepasse)
    ");
    return $stmt->execute([
        'prenom' => $prenom,
        'nom' => $nom,
        'email' => $email,
        'motdepasse' => $hashedPassword
    ]);
}

// Get all users
function getAllUsers(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id, prenom, nom, email, role FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
