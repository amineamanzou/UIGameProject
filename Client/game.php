<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>UIGameProject</title>
		<link rel="stylesheet" type="text/css" href="css/game.css" />

		<link href="./css/bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/icons.css" />
        <link rel="stylesheet" type="text/css" href="css/style2.css" />

		<!--[if lt IE 9]><script src="js/excanvas.compiled.js"></script><![endif]-->

		<script type="text/javascript" src="js/jquery.1.8.3.min.js"></script>
		<script type="text/javascript" src="js/json.js"></script>
		<script type="text/javascript" src="./library/buzz.js"></script>
		<script src="./css/bootstrap-3.1.1-dist/js/bootstrap.js"></script>
		<script src="js/modernizr.custom.js"></script>
		
		<script type="text/javascript" src="js/constantes.js"></script>
		<script type="text/javascript" src="js/classes/Personnage.js"></script>
		<script type="text/javascript" src="js/classes/Tileset.js"></script>
		<script type="text/javascript" src="js/classes/Map.js"></script>
		<script type="text/javascript" src="js/moteur.js"></script>
		<script type="text/javascript" src="js/rpg.js"></script>

		<script type="text/javascript">

          	var mySound = new buzz.sound("./sound/MusicHalo.mp3");

          	mySound.play()
              	.fadeIn()
              	.loop()
              	.bind( "timeupdate", function() {
                 var timer = buzz.toTimer( this.getTime() );
                 document.getElementById( "timer" ).innerHTML = timer;
             	});

          	var music = true;

          	function musicGestion() {
            	if(music) {
              		$(".imgSound").removeClass('glyphicon-volume-up').addClass('glyphicon-volume-off');
              		for(var i in buzz.sounds) {
                  		buzz.sounds[i].mute();
              		}
              		music=false;
            	} else {
              		$(".imgSound").removeClass('glyphicon-volume-off').addClass('glyphicon-volume-up');
              		for(var i in buzz.sounds) {
                  		buzz.sounds[i].unmute();
              		}
              		music=true;
            	}
          	}
        </script>

	</head>
	<body>

		<?php require_once 'include/menu.php'; ?>
		<canvas id="canvas" width="600" height="600">Votre navigateur ne supporte pas le conteneur canvas d'HTML 5.</canvas>

	</body>

	<script src="js/classie.js"></script>
    <script src="js/borderMenu.js"></script>

</html>