<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    

    <title>Bootstrap Design</title>

    <!-- Bootstrap core CSS -->
    <link href="format/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="navbar-fixed-top.css" rel="stylesheet">

  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Rabmer</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
		  
		  <?php

		  include('menu/menu.php')
		  ?>
      </div>
    </nav>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">

        <?php
        include 'pages/conf.php';
        include 'pages/function.php';
		if(isset($_GET['seite']))
		{
			switch($_GET['seite'])
			{
        case 'searchFilm': include('pages/searchFilm.php'); break;
        case 'searchSchauspieler': include('pages/searchSchauspieler.php'); break;
				default: include('pages/home.php'); break;
			}
		} else {
			/* First call */
			include('pages/home.php'); 
		}
		
		?>
      </div>

    </div> <!-- /container -->
  </body>
</html>
