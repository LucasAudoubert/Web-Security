<?php
function connectDB(): PDO {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=botanica', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("DB connection error: " . $e->getMessage());
    }
}

function getOrdersWithPlants(PDO $pdo, int $user_id): array {
    $stmt = $pdo->prepare("
        SELECT 
            o.id AS order_id,
            o.status AS order_status,
            o.created_at AS order_date,
            p.id AS plant_id,
            p.name AS plant_name,
            p.description AS plant_description,
            oi.price_at_purchase,
            oi.quantity
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN plants p ON oi.plant_id = p.id
        WHERE o.user_id = :user_id
        ORDER BY o.created_at DESC, p.name ASC
    ");
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function removeItemFromOrder(PDO $pdo, int $order_id, int $plant_id): void {
    $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = :order_id AND plant_id = :plant_id");
    $stmt->execute(['order_id' => $order_id, 'plant_id' => $plant_id]);
}

function deleteOrder(PDO $pdo, int $order_id): void {
    $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = :order_id");
    $stmt->execute(['order_id' => $order_id]);

    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = :order_id");
    $stmt->execute(['order_id' => $order_id]);
}