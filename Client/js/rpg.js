var map = new Map("premiere");

var joueur = new Personnage("personnage.png", 7, 14, DIRECTION.BAS);
map.addPersonnage(joueur);

window.onload = function() {
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');

	canvas.width  = map.getLargeur() * TAILLE_TILE;
	canvas.height = map.getHauteur() * TAILLE_TILE;
	
	setInterval(function() {
		map.dessinerMap(ctx);
	}, 40);
	
	// Gestion du clavier
	window.onkeydown = function(event) {
		var e = event || window.event;
		var key = e.which || e.keyCode;
		switch(key) {
		case 122 : case 90 : // Flèche haut, z, Z
			joueur.deplacer(DIRECTION.HAUT, map);
			break;
		case 115 : case 83 : // Flèche bas, s, S
			joueur.deplacer(DIRECTION.BAS, map);
			break;
		case 113 : case 81 : // Flèche gauche, q, Q
			joueur.deplacer(DIRECTION.GAUCHE, map);
			break;
		case 100 : case 68 : // Flèche droite, d, D
			joueur.deplacer(DIRECTION.DROITE, map);
			break;
		default : 
			return true;
		}
	}	

}

