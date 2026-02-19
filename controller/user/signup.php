<?php
$email = $_POST['email'] ?? '';
$pass  = $_POST['pass'] ?? '';
$fName = $_POST['fName'] ?? '';
$lName = $_POST['lName'] ?? '';
$userType = $_POST['userType'] ?? 'user'; 

$emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$namePattern  = "/^[a-zA-ZÀ-ÿ\s'-]{2,20}$/";
$passPattern  = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#?!@$%^&*-]).{8,}$/";

if (!preg_match($emailPattern, $email)) {
    echo "Invalid email address.";
    exit;
}

if (!preg_match($passPattern, $pass)) {
    echo "Password must be at least 8 characters, with uppercase, lowercase, number, and symbol.";
    exit;
}

if (!preg_match($namePattern, $fName) || !preg_match($namePattern, $lName)) {
    echo "Invalid format for first or last name.";
    exit;
}

require_once("../../model/user_model.php");
$pdo = connectDB(); 

if (!checkEmailExists($pdo, $email)) {
    createUser($pdo, $fName, $lName, $email, $pass); 
    echo "<p>Signup successful!</p>";
    // header('Location: ../../view/login_view.php');
    die();
} else {
    echo "Email already exists.";
}
?>
