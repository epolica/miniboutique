<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

$id_article = $_GET['id'];  // Récupérer l'ID de l'article

// D'abord, supprimer l'article de la table des commandes_articles s'il existe
$sql_delete_commandes = "DELETE FROM commandes_articles WHERE id_article = ?";
$stmt_delete_commandes = mysqli_prepare($conn, $sql_delete_commandes);

if (!$stmt_delete_commandes) {
    die("Erreur lors de la préparation de la suppression dans commandes_articles : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt_delete_commandes, "i", $id_article);

if (!mysqli_stmt_execute($stmt_delete_commandes)) {
    die("Erreur lors de la suppression dans commandes_articles : " . mysqli_error($conn));
}

mysqli_stmt_close($stmt_delete_commandes);

// Ensuite, supprimer l'article de la table articles
$sql = "DELETE FROM articles WHERE id_article = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erreur lors de la préparation de la requête : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id_article);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin_articles.php");
    exit();
} else {
    // Afficher une erreur plus détaillée en cas de problème lors de la suppression
    echo "Erreur lors de la suppression de l'article : " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
