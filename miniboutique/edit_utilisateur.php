<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db_conn.php';  // Connexion à la base de données

// Récupérer l'ID de l'utilisateur
$id_utilisateur = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = $_POST['role'];

    // Mise à jour de l'utilisateur
    $sql = "UPDATE utilisateurs SET nom = ?, email = ?, role = ? WHERE id_utilisateur = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $nom, $email, $role, $id_utilisateur);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: admin_utilisateurs.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'utilisateur.";
    }
}

// Récupérer les informations de l'utilisateur
$sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_utilisateur);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$utilisateur = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
</head>
<body>
    <h2>Modifier Utilisateur</h2>
    <form method="POST" action="edit_utilisateur.php?id=<?php echo $id_utilisateur; ?>">
        <label>Nom</label>
        <input type="text" name="nom" value="<?php echo $utilisateur['nom']; ?>" required><br>
        
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $utilisateur['email']; ?>" required><br>
        
        <label>Rôle</label>
        <select name="role">
            <option value="client" <?php if ($utilisateur['role'] == 'client') echo 'selected'; ?>>Client</option>
            <option value="admin" <?php if ($utilisateur['role'] == 'admin') echo 'selected'; ?>>Admin</option>
        </select><br>

        <button type="submit">Modifier</button>
        <button  class="btn ">Retour</button>
    </form>
</body>
</html>

<?php
mysqli_close($conn);
?>
