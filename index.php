<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Portnotes | The worlds first collegiate note-taking web app!</title>
        <meta name="description" content="Take notes online with ease. Features goodies like intelligent flash-card quizzing and practice test maker based on your notes!">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/note.css">
        <link rel="stylesheet" href="css/dash.css">

        <script src="js/libs/jquery-1.7.1.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <div id="wrapper">
            <header>
                <header>
                <a href="index.php"><img src="img/header-logo.png" alt="Portnotes home"></a>
            </header>


            <?php

                //error_reporting(E_ERROR | E_PARSE);

                session_start();
                
                require_once("config/db.php"); // include the configs / constants for the database connection
                require_once("classes/Login.php"); // load the login class

                $login = new Login();

                if ($login->isUserLoggedIn()) {    
                    include("views/dash.php");
                } else {
                    include_once("views/login.php");
                }
            ?>

        </div>
    </body>
</html>