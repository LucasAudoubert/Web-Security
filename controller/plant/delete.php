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
    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {
        $_SESSION['error'] = 'ID de plante invalide.';
        header('Location: ../../view/admin.php');
        exit;
    }

    if (deletePlant($pdo, $id)) {
        $_SESSION['success'] = 'Plante supprimée avec succès !';
    } else {
        $_SESSION['error'] = 'Erreur lors de la suppression de la plante.';
    }

    header('Location: ../../view/admin.php');
    exit;
}
