<?php

function connectDB(): PDO {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=botanica', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

// Add to cart (uses orders + order_items)
function addToCart(PDO $pdo, int $user_id, int $plant_id, int $quantity): bool
{
    try {

            $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT price FROM plants WHERE id = :plant_id");
        $stmt->execute(['plant_id' => $plant_id]);
        $plant = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$plant) {
            return false;
        }

        $price = $plant['price'];

        $stmt = $pdo->prepare("
            SELECT id FROM orders 
            WHERE user_id = :user_id 
            AND status = 'PENDING'
            LIMIT 1
        ");
        $stmt->execute(['user_id' => $user_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $order_id = $order['id'];
        } else {
            // Create new order
            $stmt = $pdo->prepare("
                INSERT INTO orders (user_id, total_price, status)
                VALUES (:user_id, 0, 'PENDING')
            ");
            $stmt->execute(['user_id' => $user_id]);
            $order_id = $pdo->lastInsertId();
        }

        $stmt = $pdo->prepare("
            SELECT quantity FROM order_items
            WHERE order_id = :order_id
            AND plant_id = :plant_id
        ");
        $stmt->execute([
            'order_id' => $order_id,
            'plant_id' => $plant_id
        ]);

        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {

            $new_quantity = $existing['quantity'] + $quantity;

            $stmt = $pdo->prepare("
                UPDATE order_items
                SET quantity = :quantity
                WHERE order_id = :order_id
                AND plant_id = :plant_id
            ");

            $stmt->execute([
                'quantity' => $new_quantity,
                'order_id' => $order_id,
                'plant_id' => $plant_id
            ]);

        } else {

            $stmt = $pdo->prepare("
                INSERT INTO order_items
                (order_id, plant_id, quantity, price_at_purchase)
                VALUES (:order_id, :plant_id, :quantity, :price)
            ");

            $stmt->execute([
                'order_id' => $order_id,
                'plant_id' => $plant_id,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }

        $stmt = $pdo->prepare("
            UPDATE orders
            SET total_price = (
                SELECT SUM(quantity * price_at_purchase)
                FROM order_items
                WHERE order_id = :order_id
            )
            WHERE id = :order_id
        ");

        $stmt = $pdo->prepare("UPDATE plants SET stock = stock - :quantity WHERE id = :plant_id");

        $stmt->execute([
            'quantity' => $quantity,
            'plant_id' => $plant_id
        ]);

        $pdo->commit();

        return true;

    } catch (Exception $e) {

        $pdo->rollBack();
        return false;
    }
}