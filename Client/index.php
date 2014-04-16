<!DOCTYPE html>
<html>
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>UI Game Project</title>
        <link media="screen" href="./css/style.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="./library/buzz.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="./css/bootstrap-3.1.1-dist/js/bootstrap.js"></script>


        <link href="./css/bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/signin.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/icons.css" />
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <script src="js/modernizr.custom.js"></script>

        <script type="text/javascript">
          $(document).ready(function(){
            $("#game").hide();
            $(".menu").hide();
         });

          function begin() {
            $("#game").show();
            $(".connexion").hide("slow");
            $(".menu").show();
          }
        </script>

    </head>
    <body>

      <div class="container menu">
        <nav id="bt-menu" class="bt-menu">
          <a href="#" class="bt-menu-trigger"><span>Menu</span></a>
          <ul>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Badges</a></li>
            <li><a href="#">Classement</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
          <ul>
            <li><a href="http://www.twitter.com/" class="bt-icon icon-twitter">Twitter</a></li>
            <li><a href="https://plus.google.com/" class="bt-icon icon-gplus">Google+</a></li>
            <li><a href="http://www.facebook.com/pages/" class="bt-icon icon-facebook">Facebook</a></li>
            <li><a href="https://github.com/" class="bt-icon icon-github">icon-github</a></li>
          </ul>
        </nav>
      </div>

      <div class="connexion">
        <form class="form-signin ombre" role="form">
          <input type="text" class="form-control" placeholder="Votre login"  >
          <input type="password" class="form-control" placeholder="Votre mot de passe" >
          <button class="btn btn-lg btn-danger btn-block" type="submit" onclick="begin(); return false;">Se connecter</button>
        </form>

        <form class="form-signin form2 ombre" role="form">
          <button class="btn btn-lg btn-warning btn-block" data-toggle="modal" data-target="#inscription" onclick="return false;">S'inscrire</button>
        </form>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="inscription">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                  <div class="inscr">
                    <form class="form-signin form-signin2" role="form">
                      <input type="text" class="form-control textForm" placeholder="Choisir un login" >
                      <input type="password" class="form-control" placeholder="Choisir un mot de passe" >
                      <input type="password" class="form-control" placeholder="Repeter le mot de passe" >
                      <input type="text" class="form-control textForm" placeholder="Saisir votre adresse mail" >
                      <button class="btn btn-lg btn-warning btn-block" type="submit" onclick="begin(); return false;">S'inscrire</button>
                    </form>
                  </div>
            </div>      
          </div>
        </div>
      </div>


      <div id="game">
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
      </div>

    </body>

    <script src="js/classie.js"></script>
    <script src="js/borderMenu.js"></script>

</html>