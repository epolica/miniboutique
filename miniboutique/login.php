<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_conn.php';  // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête pour récupérer l'utilisateur avec l'email fourni
    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Vérification de la préparation de la requête
    if (!$stmt) {
        die("Erreur lors de la préparation de la requête : " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    

    if ($row = mysqli_fetch_assoc($result)) {
        // Vérifier si le mot de passe est correct
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            // Stocker les informations dans la session
            $_SESSION['id_utilisateur'] = $row['id_utilisateur'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['role'] = $row['role'];  // Stocker le rôle dans la session

            // Rediriger vers la page d'accueil ou la page admin si connecté
            header('Location: admin.php');
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!-- Formulaire de connexion -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="mot_de_passe" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Se connecter</button>
        </form>
    </div>
</body>
</html>
