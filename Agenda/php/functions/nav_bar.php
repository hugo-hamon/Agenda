<?php 
    if(!isset($_SESSION)){
        session_start();
    }   

    function show_nav_bar()
    {
        // Récupération de si l'utilisateur est connécté ou non
        $is_user_connect = !empty($_SESSION['user_id']) ? true : false;

        // Choix du message pour la déconnexion ou la connexion
        $connection_message = '<li><a href="login.php">Connexion</a></li>';
        $disconnection_message = '<li><a href="deconnexion.php">Déconnexion</a></li>';
        $login_message = ($is_user_connect) ? $disconnection_message : $connection_message;

        // Affichage de la navbar
        echo '<nav>
            <div class="menu">
                <input type="checkbox" id="check">
                <div class="logo"><a href="home.php">Agenda</a></div>
                <ul>
                    <label class="button cancel" for="check"><i class="fas fa-times"></i></label>
                    <li><a href="home.php">Accueil</a></li>
                    <li><a href="agenda.php">Agenda</a></li>
                    <li><a href="evenement.php">Événements</a></li>
                    <li><a href="settings.php">Préférences</a></li>
                    ' . $login_message . '
                </ul>
                <label class="button bars" for="check"><i class="fas fa-bars"></i></label>
            </div>
        </nav>';
    }
?>