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
            <h1>Inscription</h1>
            <form method="post" action="user_controller.php">
                <input type="text" name="prenom" placeholder="Prénom" required class="input-field">
                <input type="text" name="nom" placeholder="Nom" required class="input-field">
                <input type="email" name="email" placeholder="Email" required class="input-field">
                <input type="password" name="motdepasse" placeholder="Mot de passe" required class="input-field">
                <button type="submit" name="signup" class="btn-primary">S'inscrire</button>
            </form>

            <a href="user_controller.php" class="auth-link">Déjà un compte ? Se connecter</a>
        </div>
    </div>
</div>
</body>
</html>
