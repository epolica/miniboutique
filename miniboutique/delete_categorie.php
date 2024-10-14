<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

$id_categorie = $_GET['id'];  // Récupérer l'ID de la catégorie

// D'abord, supprimer les articles associés à la catégorie
$sql_delete_articles = "DELETE FROM articles WHERE id_categorie = ?";
$stmt_delete_articles = mysqli_prepare($conn, $sql_delete_articles);

if (!$stmt_delete_articles) {
    die("Erreur lors de la préparation de la suppression des articles associés : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt_delete_articles, "i", $id_categorie);

if (!mysqli_stmt_execute($stmt_delete_articles)) {
    die("Erreur lors de la suppression des articles associés : " . mysqli_error($conn));
}

mysqli_stmt_close($stmt_delete_articles);

// Ensuite, supprimer la catégorie de la table categories
$sql = "DELETE FROM categories WHERE id_categorie = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erreur lors de la préparation de la requête : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id_categorie);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin_categories.php");
    exit();
} else {
    // Afficher une erreur plus détaillée en cas de problème lors de la suppression
    echo "Erreur lors de la suppression de la catégorie : " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
