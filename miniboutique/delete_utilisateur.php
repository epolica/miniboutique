<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

$id_utilisateur = $_GET['id'];  // Récupérer l'ID de l'utilisateur

// Supprimer l'utilisateur
$sql = "DELETE FROM utilisateurs WHERE id_utilisateur = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_utilisateur);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin_utilisateurs.php");
    exit();
} else {
    echo "Erreur lors de la suppression de l'utilisateur.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
