<?php
session_start();
require_once(__DIR__ . '/../../model/user_model.php');


    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $pdo = connectDB();
    $user = getUserById($pdo, $_SESSION['user_id']);
    if (!$user) {
        header('Location: login.php');
        exit();
    }

    // require 'view/profile.php';