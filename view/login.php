<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/forms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="section-1">
    <div class="banner">
        <div class="auth-card">
            <h1>Connexion</h1>

            <form method="post" action="../controller/user/login.php<?php echo isset($_GET['redirect_to']) ? '?redirect_to=' . urlencode($_GET['redirect_to']) : ''; ?>">
                <input type="email" name="email" placeholder="Email" required class="input-field">
                <input type="password" name="pass" placeholder="Mot de passe" required class="input-field">
                <button type="submit" name="login" class="btn-primary">Se connecter</button>
            </form>

            <a href="./signup.php" class="auth-link">Pas de compte ? S'inscrire</a>
        </div>
    </div>
</div>

</body>
</html>