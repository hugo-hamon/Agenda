<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include '../functions/nav_bar.php';
    include '../functions/get_event.php';
    $add_event_statue =  !empty($_SESSION['add_event_statue']) ? $_SESSION['add_event_statue'] : ["", "", ""];
    unset($_SESSION['add_event_statue']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/agenda.css">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/agenda.js"></script>

    <script>
        var global_event_array = [
            <?php
                if (isset($user_event_query)){
                    while ($event_list_query = $user_event_query->fetch()){
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
    <!-- Nav Bar!-->
    <?php show_nav_bar() ?>

    <!-- Heure d'été / hiver!-->
    <p id="summer_winter_time"></p>

    <!-- Agenda!-->
    <div id="main_div">
        <div id="agenda_div">
            <div id="button_month">
                <img id="back_month_button" src="../../src/back.png" alt="back">
                <span id="date_list">
                    <select name="month_list" id="month_list" selected="selected">
                    </select>
                    <select name="year_list" id="year_list">
                    </select>
                </span>

                <img id="next_month_button" src="../../src/next.png" alt="next">
            </div>
            <table id="agenda_table">
                <thead id="agenda_thead">
                    <tr id="agenda_thead_tr">
                        <td>Lun</td>
                        <td>Mar</td>
                        <td>Mer</td>
                        <td>Jeu</td>
                        <td>Ven</td>
                        <td>Sam</td>
                        <td>Dim</td>
                    </tr>
                </thead>
                <tbody id="agenda_tbody">

                </tbody>
            </table>
        </div>

        <div id="evenement_div">
            <form action="../php_traite_pages/agenda_traite.php" method="post">
                <p id="event_caption">Ajouter un événement</p>
                <div id="event_fields_div">
                    <div id="event_title_div">
                        <input id="event_title" type="text" name="title" placeholder='<?php echo !empty($add_event_statue[0]) ? $add_event_statue[0] : "Titre"; ?>'>
                    </div>
                    <div id="event_desc_div">
                        <input id="event_desc" type="text" name="description" placeholder="Description">
                    </div>
                    <div id="event_place_div">
                        <input id="event_place" type="text" name="place" placeholder="Lieu">
                    </div>
                    <p id="event_date_caption">Du</p>
                    <div id="event_time_div">
                        <input id="event_date" type="date" name="start_date">
                        <input id="event_time" type="time" name="start_time">
                    </div>
                    <p id="event_date_caption">au</p>
                    <div id="event_time_div">
                        <input id="event_date" type="date" name="end_date">
                        <input id="event_time" type="time" name="end_time">
                    </div>
                    <p id="add_event_error"><?php echo (!empty($add_event_statue[0]) || !empty( $add_event_statue[1])) ? "Un ou des champs sont incorrect" : ""; ?></p>
                    <p id="add_event_success"><?php echo !empty($add_event_statue[2]) ? $add_event_statue[2] : ""; ?></p>
                    <input id="event_submit" type="submit" value="Ajouter !">
                </div>
                
            </form>
        </div>
    </div>


</body>

</html>