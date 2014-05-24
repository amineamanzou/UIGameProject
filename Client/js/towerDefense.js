var map = new Map("premiere");

var monstre1 = new Monster("personnage.png", 7, 14, DIRECTION.BAS);
map.addMonstre(monstre1);

var tourPos = new Array();
var tour = new Tower("test.png", 14, 7, DIRECTION.BAS);
tourPos.push(new Array(14,7));
map.addTour(tour);

function plusCourtChemin() {
	var graph = new Graph(map.walkable);
	var start = graph.nodes[monstre1.x][monstre1.y];
	var end = graph.nodes[tourPos[0][0]][tourPos[0][1]]; //14,7
	var result = astar.search(graph.nodes, start, end);
	return result;
}

function deplacementPCM() {
	var chemin = plusCourtChemin();
	monstre1X = monstre1.x;
	monstre1Y = monstre1.y;
	x = chemin[0].x;
	y = chemin[0].y;

	if(y<monstre1Y) {
		//alert("haut");
		monstre1.deplacer(DIRECTION.HAUT, map);
	} else if(y>monstre1Y) {
		//alert("bas");
		monstre1.deplacer(DIRECTION.BAS, map);
	} else if(x<monstre1X) {
		//alert("gauche");
		monstre1.deplacer(DIRECTION.GAUCHE, map);
	} else if (x>monstre1X) {
		//alert("droite");
		monstre1.deplacer(DIRECTION.DROITE, map);
	}
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
