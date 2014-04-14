<!DOCTYPE html>
<html>
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>UI Game Project</title>
        <link media="screen" href="./css/style.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

    </head>
    <body>

    <canvas id="mapCanvas"></canvas>
    <script>
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

      	var canvas = document.getElementById('mapCanvas');
      	canvas.width = $(window).width();
		canvas.height = $(window).height();

      	var context = canvas.getContext('2d');

      	//Pour afficher les coordonnées de la souris
      	/*
      	canvas.addEventListener('mousemove', function(evt) {
	        var mousePos = getMousePos(canvas, evt);
	        var message = 'Position de la souris: (' + mousePos.x + ',' + mousePos.y + ')';
	        writeMessage(canvas, message);
      	}, false);
		*/

      	canvas.addEventListener('click', function(evt) {
	        var mousePos = getMousePos(canvas, evt);
	        var context = canvas.getContext('2d');

			var img = document.createElement('img');
			img.src = './img/pion.png';

	        context.drawImage(img, mousePos.x , mousePos.y);
      	}, false);
    </script>

    </body>
</html>