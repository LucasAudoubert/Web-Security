<?php
session_start();

if (!isset($_SESSION['userID'])) {
    die("User not logged in.");
}

require_once __DIR__ . '/../../model/cart_model.php';

$user_id = $_SESSION['userID'];  // <- use session key as given
$pdo = connectDB();

// Remove an item from an order
if (isset($_POST['remove_item']) && isset($_POST['order_id'])) {
    $order_id = (int)$_POST['order_id'];
    $plant_id = (int)$_POST['remove_item'];
    removeItemFromOrder($pdo, $order_id, $plant_id);
}

// Delete an order
if (isset($_POST['delete_order'])) {
    $order_id = (int)$_POST['delete_order'];
    deleteOrder($pdo, $order_id);
}

// Fetch all orders with items for this user
$cartItems = getOrdersWithPlants($pdo, $user_id);

// require_once __DIR__ . '/../../view/cart/cart_view.php';