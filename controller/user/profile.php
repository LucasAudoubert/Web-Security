<?php
session_start();
require_once(__DIR__ . '/../../model/user_model.php');


    if (!isset($_SESSION['userID'])) {
        // header('Location: login.php');
        // exit();
    }

    $pdo = connectDB();
    $user = getUserById($pdo, $_SESSION['userID']);
    if (!$user) {
        header('Location: login.php');
        var_dump($_SESSION['userID'] );
        exit();
    }

    // require 'view/profile.php';