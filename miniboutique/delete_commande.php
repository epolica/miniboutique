<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

$id_commande = $_GET['id'];  // Récupérer l'ID de la commande

// D'abord, supprimer les articles associés à la commande
$sql_delete_articles_commande = "DELETE FROM commandes_articles WHERE id_commande = ?";
$stmt_delete_articles_commande = mysqli_prepare($conn, $sql_delete_articles_commande);

if (!$stmt_delete_articles_commande) {
    die("Erreur lors de la préparation de la suppression des articles associés à la commande : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt_delete_articles_commande, "i", $id_commande);

if (!mysqli_stmt_execute($stmt_delete_articles_commande)) {
    die("Erreur lors de la suppression des articles associés à la commande : " . mysqli_error($conn));
}

mysqli_stmt_close($stmt_delete_articles_commande);

// Ensuite, supprimer la commande de la table commandes
$sql = "DELETE FROM commandes WHERE id_commande = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erreur lors de la préparation de la requête : " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id_commande);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin_commandes.php");
    exit();
} else {
    // Afficher une erreur plus détaillée en cas de problème lors de la suppression
    echo "Erreur lors de la suppression de la commande : " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
