<?php
session_start();
require_once("../../model/user_model.php");

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

        $_SESSION['userID'] = $user['id']; 

        echo "<p>Login successful</p>";
    var_dump($_SESSION);
        header("Location: http://localhost/Web-Security/");
        // exit();

    } else {

        echo "Incorrect credentials";

        // session_unset();
        // session_destroy();
        exit();
    }
}
