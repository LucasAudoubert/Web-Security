<?php

require_once __DIR__ . '/../../model/plant_model.php';

session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../view/login.php');
    exit;
}

$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $image_path = $_POST['image_url'] ?? 'public/plants/default.png';

    if (empty($name) || empty($description) || $price <= 0 || $stock < 0) {
        $_SESSION['error'] = 'Tous les champs obligatoires doivent être remplis correctement.';
        header('Location: ../../view/admin.php');
        exit;
    }

    if (createPlant($pdo, $name, $description, $price, $stock, $image_path)) {
        $_SESSION['success'] = 'Plante ajoutée avec succès !';
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'ajout de la plante.';
    }

    header('Location: ../../view/admin.php');
    exit;
}
