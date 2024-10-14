<?php
// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";  // Nom d'utilisateur MySQL
$password = "root";      // Mot de passe MySQL (laisser vide si aucun mot de passe)
$dbname = "miniboutique";  // Nom de ta base de données

// Créer la connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
?>
