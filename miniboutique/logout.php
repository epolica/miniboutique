<?php
session_start();
session_destroy();  // Détruire toutes les sessions en cours
header("Location: index.php");  // Rediriger vers la page d'accueil après la déconnexion
exit();
?>
