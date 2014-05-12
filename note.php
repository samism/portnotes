<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Portnotes | The worlds first collegiate note-taking web app!</title>
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/note.css">

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

            <div id="note-wrapper">
                <header>
                    <h2 title="Edit title">
                        <span id="nb">
                            <?php echo $_GET['notebook'] . ':'; ?>
                        </span>
                        <span id="page-title" contenteditable>
                        <?php
                            echo isset($_GET['page']) ? $_GET['page'] : "title";
                        ?>
                        </span>
                    </h2>
                </header>
                <section id="note" contenteditable='true'>
    			</section>
            </div>

			<section id="buttons">
				<a href="#">Save notes</a>
			</section>
        </div>
    </body>
</html>