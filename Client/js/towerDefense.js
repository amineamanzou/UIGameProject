var map = new Map("premiere");

var monstre1 = new Monster("personnage.png", 7, 14, DIRECTION.BAS);
map.addMonstre(monstre1);

var tourPos = new Array();
var tour = new Tower("test.png", 14, 7, DIRECTION.BAS);
tourPos.push(tour);
map.addTour(tour);

function plusCourtChemin() {
	var graph = new Graph(map.walkable);
	var start = graph.nodes[monstre1.x][monstre1.y];
	var end = graph.nodes[tourPos[0].x][tourPos[0].y]; //14,7
	var result = astar.search(graph.nodes, start, end);
	return result;
}

function plusCourtChemin4Coins() {
	var graph = new Graph(map.walkable);
	var start = graph.nodes[monstre1.x][monstre1.y];

	var resultH;
	var resultB;
	var resultG;
	var resultD;

	var h;
	var b;
	var g;
	var d;

	if((tourPos[0].y)-1 >0) {
		var endH = graph.nodes[tourPos[0].x][(tourPos[0].y)-1];
		resultH = astar.search(graph.nodes, start, endH);
		h = resultH.length;
	} else {
		h = 999;
	}
	
	if((tourPos[0].y)+1 <15) {
		var endB = graph.nodes[tourPos[0].x][(tourPos[0].y)+1]; 
		resultB = astar.search(graph.nodes, start, endB);
		b = resultB.length;
	} else {
		b = 999;
	}
	
	if((tourPos[0].x)-1 >0) {
		var endG = graph.nodes[(tourPos[0].x)-1][tourPos[0].y];
		resultG = astar.search(graph.nodes, start, endG);
		g = resultG.length;
	} else {
		g = 999;
	}
	 
	if((tourPos[0].x)+1 <15) {
		var endD = graph.nodes[(tourPos[0].x)+1][tourPos[0].y]; 
		resultD = astar.search(graph.nodes, start, endD);
		d = resultD.length;
	} else {
		d = 999;
	}
	
	if(h<=b && h<=g && h<=d) {
		return resultH;
	} else if(b<=h && b<=g && b<=d) {
		return resultB;
	} else if(g<=h && g<=b && g<=d) {
		return resultG;
	} else {
		return resultD;
	}

}

function deplacementPCM() {
	var chemin = plusCourtChemin4Coins();
	monstre1X = monstre1.x;
	monstre1Y = monstre1.y;
	x = chemin[0].x;
	y = chemin[0].y;

	if(y<monstre1Y) {
		monstre1.deplacer(DIRECTION.HAUT, map);
	} else if(y>monstre1Y) {
		monstre1.deplacer(DIRECTION.BAS, map);
	} else if(x<monstre1X) {
		monstre1.deplacer(DIRECTION.GAUCHE, map);
	} else if (x>monstre1X) {
		monstre1.deplacer(DIRECTION.DROITE, map);
	}
}

function attaque() {
	for(i=0; i<tourPos.length; i++) {
		var portee = distance(monstre1, tourPos[i]);
		if(portee <= monstre1.portee) {
			tourPos[i].pdv -= monstre1.degat;
		}
		if(tourPos[i].pdv <=0) {
			map.deleteTour(tourPos[i].ide);
		}
	}
}

function distance(point1, point2) {
  	var xs = 0;
  	var ys = 0;
 
  	xs = point2.x - point1.x;
  	xs = xs * xs;
 
  	ys = point2.y - point1.y;
  	ys = ys * ys;
 
  	return Math.sqrt( xs + ys );
}

window.onload = function() {
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');

	canvas.width  = map.getLargeur() * TAILLE_TILE;
	canvas.height = map.getHauteur() * TAILLE_TILE;
	
	setInterval(function() {
		map.dessinerMap(ctx);
		deplacementPCM();
	}, 40);

	setInterval(function() {
		attaque();
	}, 1000);
	
	// Gestion du clavier
	window.onkeydown = function(event) {
		var e = event || window.event;
		var key = e.which || e.keyCode;
		switch(key) {
		case 122 : case 90 : // Flèche haut, z, Z
			monstre1.deplacer(DIRECTION.HAUT, map);
			break;
		case 115 : case 83 : // Flèche bas, s, S
			monstre1.deplacer(DIRECTION.BAS, map);
			break;
		case 113 : case 81 : // Flèche gauche, q, Q
			monstre1.deplacer(DIRECTION.GAUCHE, map);
			break;
		case 100 : case 68 : // Flèche droite, d, D
			monstre1.deplacer(DIRECTION.DROITE, map);
			break;
		default : 
			return true;
		}
	}	

}
