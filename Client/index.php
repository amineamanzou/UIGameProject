<!DOCTYPE html>
<html>
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>UI Game Project</title>
        <link media="screen" href="./css/style.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="./library/buzz.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

    </head>
    <body>

        <canvas id="mapCanvas"></canvas>

        <script>

          var mySound = new buzz.sound("./sound/MusicHalo.mp3");

          mySound.play()
              .fadeIn()
              .loop()
              .bind( "timeupdate", function() {
                 var timer = buzz.toTimer( this.getTime() );
                 document.getElementById( "timer" ).innerHTML = timer;
              });

          window.onresize = resizeOk;
          function resizeOk() {
              location.assign(location.href);
          } 

          var canvas = document.getElementById('mapCanvas');
          canvas.width = $(window).width();
          canvas.height = $(window).height();

          var context = canvas.getContext('2d');

    	   	function writeMessage(canvas, message) {
    	    	  var context = canvas.getContext('2d');
    	        context.clearRect(0, 0, canvas.width, canvas.height);
    	        context.font = '18pt Calibri';
    	        context.fillStyle = '#F5A9A9';
    	        context.fillText(message, 10, 35);
    	   	}

          function getMousePos(canvas, evt) {
            	var rect = canvas.getBoundingClientRect();
            	return {
              		x: evt.clientX - rect.left,
              		y: evt.clientY - rect.top
            	};
          }

          canvas.addEventListener('click', function(evt) {
            var mousePos = getMousePos(canvas, evt);
            var context = canvas.getContext('2d');
            var img = document.createElement('img');
            img.src = './img/pion.png';

            context.drawImage(img, mousePos.x , mousePos.y);
           
            //Sauvegarde du territoire en base
            jQuery.ajax({
                type: 'GET',
                url: './module/addTerritory.php',
                data: {
                  x: mousePos.x, 
                  y: mousePos.y,
                  larg: $(window).width(),
                  longu: $(window).height()
                }, 
                success: function(data, textStatus, jqXHR) {
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  alert("Erreur AJAX !!");
                }
            });
          }, false);

        </script>

        <?php
          session_start();
          $db = mysql_connect('localhost', 'root', 'root');
          mysql_select_db('UIGameProject',$db);

          //Lecture des territoires en base
          $sql = "SELECT x,y,larg,longu FROM pos_territoires";
          $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          while($data = mysql_fetch_assoc($req)) {
              echo "<script>";
              echo "var x = ".$data['x']." * $(window).width() / ".$data['larg'].";";
              echo "var y = ".$data['y']." * $(window).height() / ".$data['longu'].";";
              echo "var img = document.createElement('img');";
              echo "img.src = './img/pion.png';";
              echo "context.drawImage(img, x , y);";
              echo "</script>";
          }
        ?>

    </body>
</html>