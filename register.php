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

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <div id="wrapper">
            <header>
                <a href="index.php"><img src="img/header-logo.png" alt="Portnotes home"></a>
            </header>

            
				<?php

					// include the configs / constants for the database connection
					require_once("config/db.php");

					// load the registration class
					require_once("classes/Registration.php");

					// create the registration object. when this object is created, it will do all registration stuff automaticly
					// so this single line handles the entire registration process.
					$registration = new Registration();

					// showing the register view (with the registration form, and messages/errors)
					include("views/register.php");
				?>



		<script src="js/vendor/jquery-1.9.1.min.js"></script>
	    <script src="js/main.js"></script>
    </body>
</html>