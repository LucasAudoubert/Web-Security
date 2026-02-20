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

//create
function createPlant(PDO $pdo, string $name, string $description, floadt $price, int $stock, string $image_path): bool {
    $stmt = $pdo->prepare("
        INSERT INTO plants (name, description, price, stock, image_url)
        VALUES (:name, :description, :image_path)
    ");
    return $stmt->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'stock' => $stock,
        'image_url' => $image_path
    ]);
}

//read_exif_data

//all
function getAllPlants(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM plants");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//oneplant
function getPlantById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT 
    p.id,
    p.name AS plant_name,
    p.price,
    p.stock,
    c.name AS category_name
FROM plant p
JOIN plant_categories pc ON p.id = pc.plant_id
JOIN categories c ON pc.category_id = c.id WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

//update stock add or rem
function updatePlantStock(PDO $pdo, int $id, int $new_stock): bool {
    $stmt = $pdo->prepare("UPDATE plants SET stock = :stock WHERE id = :id");
    return $stmt->execute([
        'id' => $id,
        'stock' => $new_stock
    ]);
}

