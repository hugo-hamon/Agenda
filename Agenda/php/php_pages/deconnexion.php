<?php 
    if(!isset($_SESSION)){
        session_start();
    }

    // Traite la déconnexion d'une personnes
    if (isset($_SESSION['user_id'])) {
        session_unset();
        session_destroy();
    }
    header('Location: home.php');
?>