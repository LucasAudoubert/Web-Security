<?php
require_once 'user_model.php';

$pdo = connectDB();

//Create user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $motdepasse = $_POST['motdepasse'] ?? '';

    if (createUser($pdo, $prenom, $nom, $email, $motdepasse)) {
        $message = "Utilisateur créé avec succès.";
    } else {
        $message = "Erreur : email déjà utilisé ou données invalides.";
    }

    include 'user_view.php';
    exit;
}

//Get user by email
if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $_GET['email'];
    $user = getUserByEmail($pdo, $email);

    if (!$user) {
        die('<p>Utilisateur non trouvé.</p>');
    }

    include 'user_view.php';
    exit;
}

$users = getAllUsers($pdo);
include 'user_list_view.php';
