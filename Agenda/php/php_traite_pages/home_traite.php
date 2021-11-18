<?php
    if(!isset($_SESSION)){
        session_start();
    }

    $card_id = !empty($_POST['card_id']) ? $_POST['card_id'] : NULL;

    if($card_id == 2){
        header('Location: ../php_pages/agenda.php');
    }
    else if ($card_id == 3 and !empty($_SESSION['user_id'])){
        header('Location: ../php_pages/evenement.php');
    }
    else if ($card_id == 1 and !empty($_SESSION['user_id'])){
        header('Location: ../php_pages/settings.php');
    } else {
        $_SESSION['login_statue'] = "Veuilez d'abord vous connecter";
        header('Location: ../php_pages/login.php');  
    }
?>