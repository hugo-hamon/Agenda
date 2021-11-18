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

    $user_event_query = NULL;

    if(!empty($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $user_event_query = $bdd_conn->query("SELECT * FROM evenement WHERE `user_id` = '$user_id'"); 
    }
        

?>