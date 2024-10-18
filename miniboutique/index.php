<?php
// Inclure la connexion à la base de données
include 'db_conn.php';  // Assurez-vous que ce fichier existe et contient la bonne connexion
session_start();  // Démarrer la session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique de Fleurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .card img {
            max-height: 200px;
            object-fit: cover;
        }
        .footer {
            margin-top: 50px;
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
        }
        .header {
            background-color: #28a745;
            padding: 20px 0;
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 2.5rem;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <!-- En-tête de la boutique -->
    <div class="header">
        <h1>Bienvenue à la Boutique de Fleurs</h1>
        <p>Découvrez notre sélection de fleurs pour toutes les occasions</p>
    </div>

    <div class="container">
        <!-- Section pour afficher les articles (fleurs) -->
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-4">Nos Fleurs</h2>
                
                <div class="row">
                    <?php
                    // Requête SQL pour récupérer les articles
                    $sql = "SELECT * FROM articles";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        // Affichage des articles sous forme de cartes
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                            <div class='col-md-6'>
                                <div class='card mb-4'>
                                    <img src='" . $row['image'] . "' class='card-img-top' alt='Image de " . $row['nom'] . "'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>" . $row['nom'] . "</h5>
                                        <p class='card-text'>" . $row['description'] . "</p>
                                        <p class='card-text'><strong>Prix: " . $row['prix'] . " €</strong></p>
                                        <form method='POST' action='ajouter_panier.php'>
                                            <input type='hidden' name='id_article' value='" . $row['id_article'] . "'>
                                            <input type='number' name='quantite' value='1' min='1' class='form-control mb-2'>
                                            <button type='submit' class='btn btn-primary'>Ajouter au panier</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        echo "<p>Aucun article trouvé.</p>";
                    }

                    // Fermeture de la connexion à la base de données
                    mysqli_close($conn);
                    ?>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Section de connexion utilisateur -->
                <h2 class="mb-4">Connexion</h2>
                <?php
                // Afficher un message de bienvenue si l'utilisateur est connecté
                if (isset($_SESSION['id_utilisateur'])) {
                    echo "<p>Bienvenue, " . $_SESSION['nom'] . " !</p>";
                    echo "<a href='logout.php' class='btn btn-danger'>Se déconnecter</a>";
                    echo '<form action="utildelete_account.php" method="POST" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.\');">';
                    echo '<input type="submit" name="delete_account" value="Supprimer mon compte" class="btn btn-danger mt-2">';
                    echo '</form>';
                } else {
                    // Si l'utilisateur n'est pas connecté, afficher les liens de connexion et d'inscription
                    echo "<a href='login.php' class='btn btn-success'>Se connecter</a>";
                    echo "<a href='inscription.php' class='btn btn-primary ml-2'>S'inscrire</a>";
                }
                ?>

                <!-- Lien vers le panier -->
                <a href='panier.php' class='btn btn-primary mt-4'>Voir le panier</a>
            </div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>&copy; 2024 Boutique de Fleurs - Tous droits réservés</p>
    </div>

    <!-- Bootstrap JS (facultatif, pour améliorer l'interactivité) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
