<?php
    if(!isset($_SESSION)){
        session_start();
    }
    include '../php_pages/bdd.php';

    //Connection à la base de donnée
    try {
        $dsn = "mysql:host=".$serveur.";dbname=".$bdd_name;
        $bdd_conn = new PDO($dsn, $login, $mdp);
    }
    catch(PDOException $e) {
        exit('Erreur : '.$e->getMessage());
    }

    //Récuperation des données du formulaire
    $user_input_email = !empty($_POST['mail']) ? $_POST['mail'] : NULL;
    $user_input_password = !empty($_POST['password']) ? $_POST['password'] : NULL;
    $statue = "";

    $user_info_query = $bdd_conn->query("SELECT id, mdp FROM utilisateurs WHERE email = '$user_input_email'");
    if ($user_info_query != false) {
        $etu = $user_info_query->fetch();
        if (!empty($etu['id'])) {
            $is_pwd_correct = password_verify($user_input_password, $etu['mdp']);
            if ($is_pwd_correct) {
                $_SESSION['user_id'] = $etu['id'];
                $_SESSION['pseudo'] = $etu['pseudo'];
            } else {
                $statue = "Erreur de saisie";
            }
        } else {
            $statue = "Erreur de saisie";
        }
    } else {
        $statue = "Erreur lors de la connexions";
    }
    if ($statue == "") {
        header('Location: ../php_pages/home.php');
    } else {
        $_SESSION['login_statue'] = $statue;
        header('Location: ../php_pages/login.php');
    }
    unset($bdd_conn);
?>