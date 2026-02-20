<?php
session_start();

// Rediriger vers login si pas connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'http://localhost/Web%20Security%20Project/view/admin.php';
    header('Location: ./login.php?redirect_to=' . urlencode('http://localhost/Web%20Security%20Project/view/admin.php'));
    exit;
}

require_once __DIR__ . '/../model/plant_model.php';
require_once __DIR__ . '/../model/user_model.php';

$pdo = connectDB();
$plants = getAllPlants($pdo);
$users = getAllUsers($pdo);

// Afficher les messages de succès/erreur
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Botanica</title>
    <link rel="stylesheet" href="../public/style.css" />
    <link rel="stylesheet" href="../public/forms.css" />
    <link rel="stylesheet" href="../public/style/admin.css" />
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Panel Admin</h1>
            <a href="./logout.php" class="logout-btn">Déconnexion</a>
        </div>

        <?php if ($success): ?>
            <div class="message success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Section Ajouter Plante -->
        <div class="admin-section">
            <h2>➕ Ajouter une Nouvelle Plante</h2>
            <form method="POST" action="../controller/plant/add.php">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="name">Nom de la plante *</label>
                        <input type="text" id="name" name="name" required placeholder="Ex: Monstera Deliciosa" />
                    </div>
                    <div class="form-group">
                        <label for="price">Prix (€) *</label>
                        <input type="number" id="price" name="price" step="0.01" required placeholder="Ex: 15.99" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required placeholder="Décrivez la plante..."></textarea>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="stock">Stock *</label>
                        <input type="number" id="stock" name="stock" required min="0" placeholder="Ex: 10" />
                    </div>
                    <div class="form-group">
                        <label for="image_url">URL Image</label>
                        <input type="text" id="image_url" name="image_url" placeholder="public/plants/plant.png" />
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Ajouter Plante</button>
                </div>
            </form>
        </div>

        <!-- Section Gestion Plantes -->
        <div class="admin-section">
            <h2>🌱 Gestion des Plantes</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plants as $plant): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($plant['id']); ?></td>
                                <td><?php echo htmlspecialchars($plant['name']); ?></td>
                                <td><?php echo number_format($plant['price'], 2, ',', ' '); ?> €</td>
                                <td><?php echo htmlspecialchars($plant['stock']); ?></td>
                                <td><?php echo htmlspecialchars(substr($plant['description'], 0, 50)); ?>...</td>
                                <td>
                                    <div class="action-buttons">
                                        <form method="POST" action="../controller/plant/delete.php" style="margin: 0;" onsubmit="return confirm('Confirmer la suppression ?')">}
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($plant['id']); ?>" />
                                            <button type="submit" class="btn btn-danger btn-small">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($plants)): ?>
                <p style="text-align: center; color: #6b7280; margin-top: 20px;">Aucune plante disponible.</p>
            <?php endif; ?>
        </div>

        <!-- Section Gestion Utilisateurs -->
        <div class="admin-section">
            <h2>👥 Gestion des Utilisateurs</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (empty($users)): ?>
                <p style="text-align: center; color: #6b7280; margin-top: 20px;">Aucun utilisateur disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
