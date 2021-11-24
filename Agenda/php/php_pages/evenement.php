<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (empty($_SESSION['user_id'])) {
        $_SESSION['login_statue'] = "Veuilez d'abord vous connecter";
        header('Location: ../php_pages/login.php');
    }
    include '../functions/nav_bar.php';
    include '../functions/get_event.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/event.css">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/event.js"></script>

    <script>
        var global_event_array = [
            <?php
            if (isset($user_event_query)) {
                while ($event_list_query = $user_event_query->fetch()) {
                    $event_id = $event_list_query["id"];
                    $event_title = htmlspecialchars($event_list_query["title"], ENT_QUOTES);
                    $event_description = htmlspecialchars($event_list_query["description"], ENT_QUOTES);
                    $event_place = htmlspecialchars($event_list_query["place"], ENT_QUOTES);
                    $event_start_date = $event_list_query["start_date"];
                    $event_end_date = $event_list_query["end_date"];
                    echo "['$event_id','$event_title','$event_description','$event_place','$event_start_date','$event_end_date',],";
                }
            }
            ?>
        ];
    </script>
    <title>Agenda</title>
</head>

<body>
    <pre id="data"></pre>
    <!-- Nav Bar!-->
    <?php show_nav_bar() ?>

    <div id="main"> 
    </div>

</body>

</html>