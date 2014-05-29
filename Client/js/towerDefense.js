/* ------------------------- */
/* OPTION DE LA CARTE (JSON) */
/* ------------------------- */
var musicName = "./sound/MusicHalo.mp3";
var mapName = "premiere";
var gold = 1000;

var mobName = new Array("personnage","test");
var mobNb= new Array(1,2);
var mob = new Array(mobName,mobNb);
/* ------------------------- */


var idIncrementTower = 1;
var idIncrementMonster = 1;

var map = new Map(mapName);
var monstre = new Array();
var tourPos = new Array();

var monstre1 = new Monster(idIncrementMonster, "personnage.png", 7, 14, DIRECTION.BAS);
idIncrementMonster += 1;
monstre.push(monstre1);
map.addMonstre(monstre1);

var tour = new Tower(idIncrementTower, "test.png", 14, 7, DIRECTION.BAS);
idIncrementTower += 1;
tourPos.push(tour);
map.addTour(tour);

//Placement des tours
window.onclick = function() {
	if(choix != 0 && placementActive) {
		var x = Math.floor(((event.clientX/TAILLE_TILE) * 480) / window.innerWidth); //32*15=480
		var y = Math.floor(((event.clientY/TAILLE_TILE) * 480) / window.innerHeight);
		if (map.isWalkable(x,y)) {
			tour = new Tower(idIncrementTower, tiles, x, y, DIRECTION.BAS);
			idIncrementTower += 1;
			tourPos.push(tour);
			map.addTour(tour);
		}

		placementActive = false;
		choix = 0;
		tourSelectionnee.style.backgroundColor = 'transparent';
	}
}

function plusCourtChemin() {
	var graph = new Graph(map.walkable);
	var start = graph.nodes[monstre1.x][monstre1.y];
	var end = graph.nodes[tourPos[0].x][tourPos[0].y]; //14,7
	var result = astar.search(graph.nodes, start, end);
	return result;
}

function plusCourtChemin4Coins(i) {
	var monstreX = monstre1.x;
	var monstreY = monstre1.y;

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

	if((tourPos[i].y)-1 >0) {
		var endH = graph.nodes[tourPos[i].x][(tourPos[i].y)-1];
		resultH = astar.search(graph.nodes, start, endH);
		h = resultH.length;
		if(h==0 && (tourPos[i].x != monstreX || (tourPos[i].y)-1 != monstreY))
			h = 999;
	} else {
		h = 999;
	}
	
	if((tourPos[i].y)+1 <15) {
		var endB = graph.nodes[tourPos[i].x][(tourPos[i].y)+1]; 
		resultB = astar.search(graph.nodes, start, endB);
		b = resultB.length;
		if(b==0 && (tourPos[i].x != monstreX || (tourPos[i].y)+1 != monstreY))
			b = 999;
	} else {
		b = 999;
	}
	
	if((tourPos[i].x)-1 >0) {
		var endG = graph.nodes[(tourPos[i].x)-1][tourPos[i].y];
		resultG = astar.search(graph.nodes, start, endG);
		g = resultG.length;
		if(g==0 && ((tourPos[i].x)-1 != monstreX || tourPos[i].y != monstreY))
			g = 999;
	} else {
		g = 999;
	}
	 
	if((tourPos[i].x)+1 <15) {
		var endD = graph.nodes[(tourPos[i].x)+1][tourPos[i].y]; 
		resultD = astar.search(graph.nodes, start, endD);
		d = resultD.length;
		if(d==0 && ((tourPos[i].x)+1 != monstreX || tourPos[i].y != monstreY))
			d = 999;
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

function allTowerPCM() {
	var cheminTmp;
	var chemin = plusCourtChemin4Coins(0);

	for (i=1; i<tourPos.length; i++) {
		cheminTmp = plusCourtChemin4Coins(i);
		if(cheminTmp.length < chemin.length) {
			chemin = cheminTmp;
		}
	}

	return chemin;
}

function deplacementPCM() {
	if(tourPos.length > 0) {
		//var chemin = plusCourtChemin4Coins(0);
		var chemin = allTowerPCM();
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
}

function attaque() {
	//monstres attaque tours
	for(i=0; i<tourPos.length; i++) {
		for(j=0; j<monstre.length; j++) {
			var portee = distance(monstre[j], tourPos[i]);
			if(portee <= monstre[j].portee) {
				tourPos[i].pdv -= monstre[j].degat;
				monstre[j].pdv -= tourPos[i].degat;
			}

			if(tourPos[i].pdv <=0) {
				map.deleteTour(tourPos[i].ide);

				var bfr = [];
			   	for(var j = 0; j < tourPos.length; j++) {
			      	if(tourPos[j].ide != tourPos[i].ide) {
			       		bfr.push(tourPos[j]);
			      	}
			   	}

	   			tourPos = bfr;
			}

			if(monstre[j].pdv <=0) {
				map.deleteMonstre(monstre[j].ide);

				var bfr = [];
			   	for(var j = 0; j < monstre.length; j++) {
			      	if(monstre[j].ide != monstre[i].ide) {
			       		bfr.push(monstre[j]);
			      	}
			   	}

	   			monstre = bfr;
			}
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
