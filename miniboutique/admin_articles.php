<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

// Afficher tous les articles
$sql = "SELECT * FROM articles";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Articles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Gestion des Articles</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id_article']; ?></td>
                    <td><?php echo $row['nom']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['prix']; ?> €</td>
                    <td><?php echo $row['id_categorie']; ?></td>
                    <td>
                        <a href="edit_article.php?id=<?php echo $row['id_article']; ?>" class="btn btn-warning">Modifier</a>
                        <a href="delete_article.php?id=<?php echo $row['id_article']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article?');">Supprimer</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="add_article.php" class="btn btn-success">Ajouter un Article</a>
        <a href="admin.php" class="btn btn-danger">Retour</a>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
