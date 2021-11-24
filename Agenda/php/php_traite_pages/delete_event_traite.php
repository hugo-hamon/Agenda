<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include '../php_pages/bdd.php';

    //Connection à la base de donnée
    try {
        $dsn = "mysql:host=" . $serveur . ";dbname=" . $bdd_name;
        $bdd_conn = new PDO($dsn, $login, $mdp);
    } catch (PDOException $e) {
        exit('Erreur : ' . $e->getMessage());
    }

    if (isset($_GET['ajax'])) {
        $event_id = $_GET['event_id'];
    } else {
        $event_id = -1;
    }

    $delete_query = "DELETE FROM evenement where `id`=$event_id";
    $bdd_conn->query($delete_query);
    unset($bdd_conn);
?>