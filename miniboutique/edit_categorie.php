<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

$id_categorie = $_GET['id'];  // Récupérer l'ID de la catégorie

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);

    // Mise à jour de la catégorie
    $sql = "UPDATE categories SET nom = ? WHERE id_categorie = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nom, $id_categorie);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: admin_categories.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la catégorie.";
    }
}

// Récupérer les informations de la catégorie
$sql = "SELECT * FROM categories WHERE id_categorie = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_categorie);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$categorie = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Catégorie</title>
</head>
<body>
    <h2>Modifier Catégorie</h2>
    <form method="POST" action="edit_categorie.php?id=<?php echo $id_categorie; ?>">
        <label>Nom</label>
        <input type="text" name="nom" value="<?php echo $categorie['nom']; ?>" required><br>
        <button type="submit">Modifier</button>
        <button  class="btn ">Retour</button>
    </form>
</body>
</html>

<?php
mysqli_close($conn);
?>
