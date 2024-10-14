<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

// Afficher toutes les commandes
$sql = "SELECT * FROM commandes";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Commandes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Gestion des Commandes</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>ID Utilisateur</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id_commande']; ?></td>
                    <td><?php echo $row['id_utilisateur']; ?></td>
                    <td><?php echo $row['date_commande']; ?></td>
                    <td><?php echo $row['total']; ?> €</td>
                    <td><?php echo $row['statut']; ?></td>
                    <td>
                        <a href="edit_commande.php?id=<?php echo $row['id_commande']; ?>" class="btn btn-warning">Modifier</a>
                        <a href="delete_commande.php?id=<?php echo $row['id_commande']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande?');">Supprimer</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="admin.php" class="btn btn-danger">Retour</a>

    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
