<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

// Afficher toutes les catégories
$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Catégories</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Gestion des Catégories</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id_categorie']; ?></td>
                    <td><?php echo $row['nom']; ?></td>
                    <td>
                        <a href="edit_categorie.php?id=<?php echo $row['id_categorie']; ?>" class="btn btn-warning">Modifier</a>
                        <a href="delete_categorie.php?id=<?php echo $row['id_categorie']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?');">Supprimer</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="add_categorie.php" class="btn btn-success">Ajouter une Catégorie</a>
        <a href="admin.php" class="btn btn-danger">Retour</a>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
