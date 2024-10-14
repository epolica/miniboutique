<?php
session_start();
include 'db_conn.php';  // Connexion à la base de données

// Vérifier si le panier contient des articles
if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
    $total = 0;

    echo "<h1>Mon Panier</h1>";
    echo "<table class='table'>";
    echo "<thead><tr><th>Article</th><th>Quantité</th><th>Prix</th><th>Sous-total</th></tr></thead>";
    echo "<tbody>";

    // Boucle sur les articles dans le panier
    foreach ($_SESSION['panier'] as $id_article => $quantite) {
        // Récupérer les détails de l'article depuis la base de données
        $sql = "SELECT * FROM articles WHERE id_article = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_article);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $article = mysqli_fetch_assoc($result);

        $sous_total = $article['prix'] * $quantite;
        $total += $sous_total;

        echo "<tr>";
        echo "<td>{$article['nom']}</td>";
        echo "<td>{$quantite}</td>";
        echo "<td>{$article['prix']} €</td>";
        echo "<td>{$sous_total} €</td>";
        echo "</tr>";
    }

    echo "<tr><td colspan='3'>Total</td><td>{$total} €</td></tr>";
    echo "</tbody>";
    echo "</table>";

    // Si l'utilisateur est connecté, afficher le bouton de validation
    if (isset($_SESSION['id_utilisateur'])) {
        echo "<form method='POST' action='valider_commande.php'>";
        echo "<button type='submit' class='btn btn-primary'>Valider la commande</button>";
        echo "</form>";
    } else {
        echo "<p>Vous devez être connecté pour valider votre commande.</p>";
        echo "<a href='login.php' class='btn btn-success'>Se connecter</a>";
    }
} else {
    echo "<p>Votre panier est vide.</p>";
}

mysqli_close($conn);
?>
