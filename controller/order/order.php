<?php

require_once "../../model/order_model.php"; // adjust path if needed

session_start();

// 🔥 CREATE PDO CONNECTION
$pdo = connectDB();

if (isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {

    $userID = $_SESSION['userID'];
    $plant_id = (int)$_POST['plant_id'];

    if (addToCart($pdo, $userID, $plant_id, 1)) {
        echo "Added to cart!";
    } else {
        echo "Error adding to cart.";
    }
}