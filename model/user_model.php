<?php
// user_model.php

// Connect to database
function connectDB(): PDO {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=botanica', 'root', '');
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
function createUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password_hash): bool {
    if (checkEmailExists($pdo, $email)) {
        return false;
    }
    $hashedPassword = password_hash($password_hash, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO users (first_name, last_name, email, password_hash)
        VALUES (:first_name, :last_name, :email, :password_hash)
    ");
    return $stmt->execute([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password_hash' => $hashedPassword
    ]);
}

function login(PDO $pdo, string $email, string $password): ?array {
    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE email = :email LIMIT 1"
    );
    $stmt->execute([
        'email' => trim(strtolower($email))
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        return null;
    }
    if (!password_verify($password, $user['password_hash'])) {
        return null;
    }
    return $user;
}

// Get all users
function getAllUsers(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id, first_name, last_name, email, role FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//get user by id
function getUserById(PDO $pdo, int $id) {
    $stmt = $pdo->prepare("SELECT id, first_name, last_name, email FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
