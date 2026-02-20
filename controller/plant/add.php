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
    $image_path = 'default.png';

    // upload image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['image']['name']);
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = mime_content_type($file_tmp);
        
        // c'est une image?? 
        $accepted_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($file_type, $accepted_types)) {
            $upload_dir = __DIR__ . '/../../public/plants/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $unique_name = time() . '_' . $file_name;
            $file_path = $upload_dir . $unique_name;
            
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Stocker seulement le nom de fichier en base de données
                $image_path = $unique_name;
            } else {
                $_SESSION['error'] = 'Erreur du téléchargement de image.';
                header('Location: ../../view/admin.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Le fichier doit être une image (JPEG, PNG, GIF, WebP).';
            header('Location: ../../view/admin.php');
            exit;
        }
    }

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