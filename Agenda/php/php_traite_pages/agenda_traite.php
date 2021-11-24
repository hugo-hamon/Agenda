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

    //Récuperation des données du formulaire
    $event_input_title = !empty($_POST['title']) ? $_POST['title'] : NULL;
    $event_input_desc = !empty($_POST['description']) ? $_POST['description'] : "";
    $event_input_place = !empty($_POST['place']) ? $_POST['place'] : "";

    $event_input_start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : NULL;
    $event_input_start_time = !empty($_POST['start_time']) ? $_POST['start_time'] : NULL;

    $event_input_end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : NULL;
    $event_input_end_time = !empty($_POST['end_time']) ? $_POST['end_time'] : NULL;

    $statue = ["", "", ""];

    if ($event_input_title == NULL) {
        $statue[0] = "Titre vide";
    }

    $date1 = strtotime($event_input_start_date." ".$event_input_start_time);
    $date2 = strtotime($event_input_end_date." ".$event_input_end_time);

    if ($event_input_start_date == NULL || $event_input_start_time == NULL
        || $event_input_end_date == NULL || $event_input_end_time == NULL) {
        $statue[1] = "Un des champs n'a pas été remplis !";
    } else if ($date2 - $date1 < 0) {
        $statue[1] = "Un des champs a mal été remplis !";
    }
    if ($statue[0] == "" && $statue[1] == "" && !empty($_SESSION['user_id'])){
        $start_date = date('Y-m-d H:i:s', $date1);
        $end_date = date('Y-m-d H:i:s', $date2);
        $user_id = $_SESSION['user_id'];

        $reqprep = $bdd_conn->prepare("INSERT INTO evenement (`title`, `description`, `place`, `start_date`, `end_date`, `user_id`) VALUES (?, ?, ?, ?, ?, ?)");
        $reqvalue = $reqprep->execute(array($event_input_title, $event_input_desc, $event_input_place, $start_date, $end_date, $user_id));

        $statue[2] = "Événement créé avec succès";
        $_SESSION['add_event_statue'] = $statue;
        header('Location: ../php_pages/agenda.php');
    } else if (empty($_SESSION['user_id'])){
        $_SESSION['login_statue'] = "Veuillez d'abord vous connectez";
        header('Location: ../php_pages/login.php');
    } else {
        $_SESSION['add_event_statue'] = $statue;
        header('Location: ../php_pages/agenda.php');
    }
    unset($bdd_conn);
?>