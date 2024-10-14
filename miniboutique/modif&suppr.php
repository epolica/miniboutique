<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_article = $_POST['id_article'];
    $nouvelle_quantite = $_POST['quantite'];
    
    if (isset($_SESSION['panier'][$id_article])) {
        if ($nouvelle_quantite > 0) {
            $_SESSION['panier'][$id_article] = $nouvelle_quantite;
        } else {
            unset($_SESSION['panier'][$id_article]); // Supprime l'article si quantité = 0
        }
    }
    echo "Panier mis à jour.";
}
?>
