<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include '../functions/nav_bar.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css">
    <title>Agenda</title>
</head>

<body>
    <!-- Nav Bar!-->
    <?php show_nav_bar() ?>

    <!-- Carte pour naviguer!-->
    <div id="card-container">
        
        <div class="card card-2">
            <div class="card-logo card-2-logo"></div>
            <div class="title">Agenda</div>
            <div class="sub-title">Programmer avec style !</div>
            <form action="../php_traite_pages/home_traite.php" method="post">
                <input type="hidden" name="card_id" value="2">
                <input type="submit" class="card-button card-2-button" value="Voir votre agenda">
            </form>
        </div>
        <div class="card card-3">
            <div class="card-logo card-3-logo"></div>
            <div class="title">Événements</div>
            <div class="sub-title">Visualiser et organiser vos rappels.</div>
            <form action="../php_traite_pages/home_traite.php" method="post">
                <input type="hidden" name="card_id" value="3">
                <input type="submit" class="card-button card-3-button" value="Voir vos événements">
            </form>
        </div>
        <div class="card card-1">
            <div class="card-logo card-1-logo"></div>
            <div class="title">Mes préférences</div>
            <div class="sub-title">Changer votre interface à votre guise.</div>
            <form action="../php_traite_pages/home_traite.php" method="post">
                <input type="hidden" name="card_id" value="1">
                <input type="submit" class="card-button card-1-button" value="Modifier vos paramètres">
            </form>
        </div>
        
    </div>

</body>

</html>