 <?php  require_once('../controller/user/profile.php');
//  session_start();
 ?> 

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/profile.css">
    <title>My profile</title>



</head>
<body>
    <div class="profile-page">
        <a class="back-link" href="../index.php">&larr; Home</a>
    <div class="profile-content">
    <h1>Your Botanica Profile</h1>
    <div class="info-card"> 
        <h2>Personal Information</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <a href="./logout.php">Logout<img src="../public/icons/logout.gif" alt="Logout"></a>
        </div>
</div>
    </div>
</body>
</html>