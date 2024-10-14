<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

$id_article = $_GET['id'];  // Récupérer l'ID de l'article

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $prix = $_POST['prix'];
    $id_categorie = $_POST['id_categorie'];

    // Mise à jour de l'article
    $sql = "UPDATE articles SET nom = ?, description = ?, prix = ?, id_categorie = ? WHERE id_article = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdii", $nom, $description, $prix, $id_categorie, $id_article);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: admin_articles.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'article.";
    }
}

// Récupérer les informations de l'article
$sql = "SELECT * FROM articles WHERE id_article = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_article);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$article = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Article</title>
</head>
<body>
    <h2>Modifier Article</h2>
    <form method="POST" action="edit_article.php?id=<?php echo $id_article; ?>">
        <label>Nom</label>
        <input type="text" name="nom" value="<?php echo $article['nom']; ?>" required><br>
        
        <label>Description</label>
        <textarea name="description" required><?php echo $article['description']; ?></textarea><br>
        
        <label>Prix</label>
        <input type="number" step="0.01" name="prix" value="<?php echo $article['prix']; ?>" required><br>
        
        <label>Catégorie</label>
        <input type="number" name="id_categorie" value="<?php echo $article['id_categorie']; ?>" required><br>

        <button type="submit">Modifier</button>
        <button  class="btn ">Retour</button>
    </form>
</body>
</html>

<?php
mysqli_close($conn);
?>
