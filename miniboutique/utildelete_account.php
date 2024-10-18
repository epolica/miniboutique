<?php
session_start();
if (!isset($_SESSION['id_utilisateur'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
include 'db_conn.php'; // Assurez-vous que $conn est utilisé dans ce fichier pour la connexion

// Vérification de la connexion
if (!$conn) {
    die("Échec de connexion: " . mysqli_connect_error());
}

// Récupérer l'ID utilisateur de la session
$user_id = $_SESSION['id_utilisateur'];

// Supprimer l'utilisateur de la base de données
if (isset($_POST['delete_account'])) {
    // Supprimer les commandes associées à cet utilisateur
    $stmt1 = $conn->prepare("DELETE FROM commandes WHERE id_utilisateur = ?");
    $stmt1->bind_param("i", $user_id);
    
    if ($stmt1->execute()) {
        // Ensuite, supprimer l'utilisateur
        $stmt2 = $conn->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt2->bind_param("i", $user_id);

        if ($stmt2->execute()) {
            // Si la suppression est réussie, détruire la session et rediriger vers la page d'accueil
            session_destroy();
            header("Location: index.php?message=Compte supprimé avec succès.");
            exit();
        } else {
            echo "Erreur lors de la suppression du compte : " . $stmt2->error;
        }

        $stmt2->close();
    } else {
        echo "Erreur lors de la suppression des commandes : " . $stmt1->error;
    }

    $stmt1->close();
}

$conn->close();
?>
