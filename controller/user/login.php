<?php
session_start();
require_once("../../model/user_model.php");

if (isset($_SESSION['user_id'])) {
    $redirect = $_GET['redirect_to'] ?? 'http://localhost/Web%20Security%20Project/';
    header("Location: $redirect");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['pass'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<p>Please fill in all fields.</p>";
        exit();
    }

    $pdo = connectDB();

    $user = login($pdo, $email, $password);

    if (!empty($user)) {

        $_SESSION['user_id'] = $user['id'];

        $redirect = $_GET['redirect_to'] ?? 'http://localhost/Web%20Security%20Project/';
        header("Location: $redirect");
        exit();
    } else {
        echo "Incorrect credentials";
        exit();
    }
}