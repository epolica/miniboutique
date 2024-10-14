<?php
session_start();
include 'db_conn.php';  // Connexion à la base de données

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: login.php");
    exit();
}

// Vérifier que le panier n'est pas vide
if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
    $id_utilisateur = $_SESSION['id_utilisateur'];
    $total = 0;

    // Calculer le total de la commande
    foreach ($_SESSION['panier'] as $id_article => $quantite) {
        $sql = "SELECT prix FROM articles WHERE id_article = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_article);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $article = mysqli_fetch_assoc($result);
        $total += $article['prix'] * $quantite;
    }

    // Insérer la commande dans la table 'commandes'
    $sql = "INSERT INTO commandes (id_utilisateur, total, statut) VALUES (?, ?, 'en_attente')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "id", $id_utilisateur, $total);

    if (mysqli_stmt_execute($stmt)) {
        // Récupérer l'ID de la commande insérée
        $id_commande = mysqli_insert_id($conn);

        // Insérer chaque article dans la table 'commandes_articles'
        foreach ($_SESSION['panier'] as $id_article => $quantite) {
            $sql = "INSERT INTO commandes_articles (id_commande, id_article, quantite, prix_unitaire) VALUES (?, ?, ?, (SELECT prix FROM articles WHERE id_article = ?))";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iiii", $id_commande, $id_article, $quantite, $id_article);
            mysqli_stmt_execute($stmt);
        }

        // Vider le panier
        unset($_SESSION['panier']);

        echo "Commande validée avec succès.";
        header("Location: index.php");  // Rediriger après validation
        exit();
    } else {
        echo "Erreur lors de la validation de la commande.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Votre panier est vide.";
}

mysqli_close($conn);
?>
