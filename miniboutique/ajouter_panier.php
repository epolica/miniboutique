<?php
session_start();

// Vérifier si la session du panier existe, sinon la créer
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Récupérer les informations de l'article depuis la requête POST
if (isset($_POST['id_article']) && isset($_POST['quantite'])) {
    $id_article = $_POST['id_article'];
    $quantite = $_POST['quantite'];

    // Ajouter l'article au panier (ou mettre à jour la quantité si l'article existe déjà)
    if (isset($_SESSION['panier'][$id_article])) {
        $_SESSION['panier'][$id_article] += $quantite;
    } else {
        $_SESSION['panier'][$id_article] = $quantite;
    }

    echo "Article ajouté au panier.";
} else {
    echo "Aucun article sélectionné.";
}

// Redirection vers la page d'accueil (ou vers une page panier)
header('Location: index.php');
exit();
?>
