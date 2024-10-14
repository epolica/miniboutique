<?php
session_start();
// Vérifier si l'utilisateur est connecté et a le rôle d'admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    // Si l'utilisateur n'est pas connecté ou n'est pas admin, rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données (vérifier le chemin)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Boutique de Fleurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Administration - Gestion du site</h1>

       <!-- Section pour gérer les utilisateurs -->
       <h2 class="mt-4">Gestion des utilisateurs</h2>
        <a href="admin_utilisateurs.php" class="btn btn-primary mb-3">Voir et Gérer les Utilisateurs</a>
        
        <!-- Section pour gérer les articles -->
        <h2 class="mt-4">Gestion des articles</h2>
        <a href="admin_articles.php" class="btn btn-primary mb-3">Voir et Gérer les Articles</a>

        <!-- Section pour gérer les catégories -->
        <h2 class="mt-4">Gestion des catégories</h2>
        <a href="admin_categories.php" class="btn btn-primary mb-3">Voir et Gérer les Catégories</a>

        <!-- Section pour gérer les commandes -->
        <h2 class="mt-4">Gestion des commandes</h2>
        <a href="admin_commandes.php" class="btn btn-primary mb-3">Voir et Gérer les Commandes</a>

        <!-- Déconnexion -->
        <h2 class="mt-5">Déconnexion</h2>
        <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
    </div>
</body>
</html>
