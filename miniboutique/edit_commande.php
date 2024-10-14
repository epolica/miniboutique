<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

$id_commande = $_GET['id'];  // Récupérer l'ID de la commande

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $statut = $_POST['statut'];

    // Mise à jour de la commande
    $sql = "UPDATE commandes SET statut = ? WHERE id_commande = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $statut, $id_commande);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: admin_commandes.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la commande.";
    }
}

// Récupérer les informations de la commande
$sql = "SELECT * FROM commandes WHERE id_commande = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_commande);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$commande = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Commande</title>
</head>
<body>
    <h2>Modifier Commande</h2>
    <form method="POST" action="edit_commande.php?id=<?php echo $id_commande; ?>">
        <label>Statut</label>
        <select name="statut">
            <option value="en_attente" <?php if ($commande['statut'] == 'en_attente') echo 'selected'; ?>>En attente</option>
            <option value="traitée" <?php if ($commande['statut'] == 'traitée') echo 'selected'; ?>>Traitée</option>
            <option value="livrée" <?php if ($commande['statut'] == 'livrée') echo 'selected'; ?>>Livrée</option>
        </select><br>

        <button type="submit">Modifier</button>
        <button  class="btn ">Retour</button>
    </form>
</body>

</html>

<?php
mysqli_close($conn);
?>
