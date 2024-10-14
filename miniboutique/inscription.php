<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_conn.php';  // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérifier si l'email existe déjà
    $sql_check = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    
    if (!$stmt_check) {
        die("Erreur lors de la préparation de la requête de vérification : " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Hashage du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Définir le rôle par défaut pour les nouveaux utilisateurs
        $role = 'client'; // Tu peux changer 'client' en tout autre rôle par défaut

        // Insérer l'utilisateur dans la base de données avec un rôle
        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            die("Erreur lors de la préparation de la requête d'insertion : " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "ssss", $nom, $email, $mot_de_passe_hash, $role);

        if (mysqli_stmt_execute($stmt)) {
            // Récupérer l'ID de l'utilisateur inséré
            $id_utilisateur = mysqli_insert_id($conn);

            // Stocker les informations dans la session pour connecter automatiquement l'utilisateur
            $_SESSION['id_utilisateur'] = $id_utilisateur;
            $_SESSION['nom'] = $nom;
            $_SESSION['role'] = $role;  // Rôle par défaut (client)

            // Rediriger vers la page d'accueil après l'inscription réussie
            header('Location: index.php');
            exit();
        } else {
            echo "Erreur lors de l'inscription.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_stmt_close($stmt_check);
    mysqli_close($conn);
}
?>

<!-- Formulaire d'inscription -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Inscription</h2>
        <form method="POST" action="inscription.php">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="mot_de_passe" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>
</html>
