<?php
// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "miniboutique";

// Connexion à MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("Échec de connexion: " . mysqli_connect_error());
}

// Insertion des utilisateurs avec mot de passe hashé
$sql_users = "
INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES
('Alice Dupont', 'alice@example.com', '" . password_hash('adminpass1', PASSWORD_DEFAULT) . "', 'admin'),
('admin', 'admin@example.com', '" . password_hash('admin', PASSWORD_DEFAULT) . "', 'admin'),
('Bob Martin', 'bob@example.com', '" . password_hash('clientpass1', PASSWORD_DEFAULT) . "', 'client'),
('Clara Faure', 'clara@example.com', '" . password_hash('clientpass2', PASSWORD_DEFAULT) . "', 'client'),
('David Lefevre', 'david@example.com', '" . password_hash('clientpass3', PASSWORD_DEFAULT) . "', 'client'),
('Eva Durand', 'eva@example.com', '" . password_hash('adminpass2', PASSWORD_DEFAULT) . "', 'admin');
";

// Insertion des catégories
$sql_categories = "
INSERT INTO categories (nom) VALUES
('Roses'),
('Tulipes'),
('Lys'),
('Orchidées'),
('Marguerites');
";

// Insertion des articles avec chemin d'image correct
$sql_articles = "
INSERT INTO articles (nom, description, prix, image, id_categorie) VALUES
('Bouquet de Roses', 'Un bouquet composé de roses rouges', 29.99, 'images/roses.jpg', 1),
('Bouquet de Tulipes', 'Un bouquet de magnifiques tulipes colorées', 19.99, 'images/tulipes.jpg', 2),
('Bouquet de Lys', 'Lys blancs élégants, parfait pour un cadeau', 34.99, 'images/lys.jpg', 3),
('Orchidées en pot', 'Une orchidée en pot, facile à entretenir', 24.99, 'images/orchidees.jpg', 4),
('Bouquet de Marguerites', 'Un bouquet de marguerites fraîches', 14.99, 'images/marguerites.jpg', 5);
";

// Insertion des commandes
$sql_commandes = "
INSERT INTO commandes (id_utilisateur, total, statut) VALUES
(2, 49.98, 'en_attente'),
(3, 34.99, 'en_attente'),
(4, 44.98, 'traitée'),
(2, 19.99, 'livrée'),
(5, 29.99, 'en_attente');
";

// Insertion des articles commandés
$sql_commandes_articles = "
INSERT INTO commandes_articles (id_commande, id_article, quantite, prix_unitaire) VALUES
(1, 1, 1, 29.99),
(1, 2, 1, 19.99),
(2, 3, 1, 34.99),
(3, 4, 1, 24.99),
(3, 5, 1, 14.99),
(4, 2, 1, 19.99),
(5, 1, 1, 29.99);
";

// Exécuter les requêtes d'insertion séparément
if (mysqli_query($conn, $sql_users)) {
    echo "Utilisateurs insérés avec succès.<br>";
} else {
    echo "Erreur lors de l'insertion des utilisateurs: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $sql_categories)) {
    echo "Catégories insérées avec succès.<br>";
} else {
    echo "Erreur lors de l'insertion des catégories: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $sql_articles)) {
    echo "Articles insérés avec succès.<br>";
} else {
    echo "Erreur lors de l'insertion des articles: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $sql_commandes)) {
    echo "Commandes insérées avec succès.<br>";
} else {
    echo "Erreur lors de l'insertion des commandes: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $sql_commandes_articles)) {
    echo "Articles commandés insérés avec succès.<br>";
} else {
    echo "Erreur lors de l'insertion des articles commandés: " . mysqli_error($conn) . "<br>";
}

// Fermeture de la connexion
mysqli_close($conn);
?>
