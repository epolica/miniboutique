<?php
// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "miniboutique";

// Connexion à MySQL
$conn = mysqli_connect($servername, $username, $password);

// Vérification de la connexion
if (!$conn) {
    die("Échec de connexion: " . mysqli_connect_error());
}

// Création de la base de données si elle n'existe pas
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "Base de données créée avec succès.";
} else {
    echo "Erreur de création de la base de données: " . mysqli_error($conn);
}

// Sélection de la base de données
mysqli_select_db($conn, $dbname);

// Création des tables
$sql = "
-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);

-- Table des catégories
CREATE TABLE IF NOT EXISTS categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table des articles
CREATE TABLE IF NOT EXISTS articles (
    id_article INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    id_categorie INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie)
);

-- Table des commandes
CREATE TABLE IF NOT EXISTS commandes (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    statut VARCHAR(50) DEFAULT 'en_attente',
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

-- Table des articles commandés
CREATE TABLE IF NOT EXISTS commandes_articles (
    id_commande INT NOT NULL,
    id_article INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id_commande, id_article),
    FOREIGN KEY (id_commande) REFERENCES commandes(id_commande),
    FOREIGN KEY (id_article) REFERENCES articles(id_article)
);
";

// Exécution des requêtes
if (mysqli_multi_query($conn, $sql)) {
    echo "Tables créées avec succès.";
} else {
    echo "Erreur lors de la création des tables: " . mysqli_error($conn);
}

// Fermeture de la connexion
mysqli_close($conn);
?>
