/* ------------------------- */
/* OPTION DE LA CARTE (JSON) */
/* ------------------------- */
var musicName = "./sound/MusicHalo.mp3";
var mapName = "premiere";
var gold = 1000;

var mobName = new Array("personnage","test");
var mobNb= new Array(1,2);
var mob = new Array(mobName,mobNb);
var timeInterval=3000;
/* ------------------------- */

var idIncrementPrincipalTower = 1;
var idIncrementTower = 1;
var idIncrementMonster = 1;

var map = new Map(mapName);
var monstre = new Array();
var principalTower = new Array();
var tourPos = new Array();

mobFrequency();

var tourP = new PrincipalTower(idIncrementTower, "princess.png", 8, 3, DIRECTION.BAS);
idIncrementPrincipalTower += 1;
principalTower.push(tourP);
map.addTourPrincipale(tourP);

//Placement des tours
window.onclick = function() {
	if(choix != 0 && placementActive) {
		var x = Math.floor(((event.clientX/TAILLE_TILE) * 480) / window.innerWidth); //32*15=480
		var y = Math.floor(((event.clientY/TAILLE_TILE) * 480) / window.innerHeight);
		if (!map.isWalkable(x,y)) {
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

function plusCourtChemin4Coins(i,mx,my) {
	var monstreX = mx;
	var monstreY = my;

	var graph = new Graph(map.walkable);
	var start = graph.nodes[mx][my];

	var resultH;
	var resultB;
	var resultG;
	var resultD;

	var h;
	var b;
	var g;
	var d;

	if((principalTower[i].y)-1 >0) {
		var endH = graph.nodes[principalTower[i].x][(principalTower[i].y)-1];
		resultH = astar.search(graph.nodes, start, endH);
		h = resultH.length;
		if(h==0 && (principalTower[i].x != monstreX || (principalTower[i].y)-1 != monstreY))
			h = 999;
	} else {
		h = 999;
	}
	
	if((principalTower[i].y)+1 <15) {
		var endB = graph.nodes[principalTower[i].x][(principalTower[i].y)+1]; 
		resultB = astar.search(graph.nodes, start, endB);
		b = resultB.length;
		if(b==0 && (principalTower[i].x != monstreX || (principalTower[i].y)+1 != monstreY))
			b = 999;
	} else {
		b = 999;
	}
	
	if((principalTower[i].x)-1 >0) {
		var endG = graph.nodes[(principalTower[i].x)-1][principalTower[i].y];
		resultG = astar.search(graph.nodes, start, endG);
		g = resultG.length;
		if(g==0 && ((principalTower[i].x)-1 != monstreX || principalTower[i].y != monstreY))
			g = 999;
	} else {
		g = 999;
	}
	 
	if((principalTower[i].x)+1 <15) {
		var endD = graph.nodes[(principalTower[i].x)+1][principalTower[i].y]; 
		resultD = astar.search(graph.nodes, start, endD);
		d = resultD.length;
		if(d==0 && ((principalTower[i].x)+1 != monstreX || principalTower[i].y != monstreY))
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

function move() {
	if(monstre.length > 0) {
		for(z=0; z<monstre.length; z++) {
			monstreIt = monstre[z];
			monstreX = monstre[z].x;
			monstreY = monstre[z].y;
			var chemin = allTower(monstreX, monstreY);
			if (typeof chemin !== 'undefined') {
				if(chemin.length > 0) {
					x = chemin[0].x;
					y = chemin[0].y;

					if(y<monstreY) {
						monstreIt.deplacer(DIRECTION.HAUT, map);
					} else if(y>monstreY) {
						monstreIt.deplacer(DIRECTION.BAS, map);
					} else if(x<monstreX) {
						monstreIt.deplacer(DIRECTION.GAUCHE, map);
					} else if (x>monstreX) {
						monstreIt.deplacer(DIRECTION.DROITE, map);
					}
				}
			}
		}	
	}
}

function allTower(mx,my) {
	var cheminTmp;
	var chemin;

	for (i=0; i<principalTower.length; i++) {
		if(i==0) {
			chemin = plusCourtChemin4Coins(0,mx,my);
		}
		cheminTmp = plusCourtChemin4Coins(i,mx,my);
		if(cheminTmp.length < chemin.length) {
			chemin = cheminTmp;
		}
	}

	return chemin;
}

function attaque() {
	//monstres attaque tours
	for(i=0; i<principalTower.length; i++) {
		for(j=0; j<monstre.length; j++) {
			var portee = distance(monstre[j], principalTower[i]);

			if(portee <= 1) {
				principalTower[i].pdv -= (monstre[j].degat)*2;

				map.deleteMonstre(monstre[j].ide);

				var bfr = [];
			   	for(var j = 0; j < monstre.length; j++) {
			      	if(monstre[j].ide != monstre[i].ide) {
			       		bfr.push(monstre[j]);
			      	}
			   	}

	   			monstre = bfr;
	   			break;
			}

			if(portee <= monstre[j].portee) {
				principalTower[i].pdv -= monstre[j].degat;
				monstre[j].pdv -= principalTower[i].degat;
			}

			if(principalTower[i].pdv <=0) {
				map.deleteTourPrincipale(principalTower[i].ide);

				var bfr = [];
			   	for(var j = 0; j < principalTower.length; j++) {
			      	if(principalTower[j].ide != principalTower[i].ide) {
			       		bfr.push(principalTower[j]);
			      	}
			   	}

	   			principalTower = bfr;
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

	for(i=0; i<tourPos.length; i++) {
		for(j=0; j<monstre.length; j++) {
			var portee = distance(monstre[j], tourPos[i]);
			if(portee <= monstre[j].portee) {
				monstre[j].pdv -= tourPos[i].degat;
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

function mobFrequency() {
	if(principalTower.length > 0) { 
		var monstreX = new Monster(idIncrementMonster, "personnage.png", 7, 14, DIRECTION.BAS);
		idIncrementMonster += 1;
		monstre.push(monstreX);
		map.addMonstre(monstreX);
	}
}

window.onload = function() {
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');

	canvas.width  = map.getLargeur() * TAILLE_TILE;
	canvas.height = map.getHauteur() * TAILLE_TILE;
	
	setInterval(function() {
		map.dessinerMap(ctx);
		move();
	}, 40);

	setInterval(function() {
		attaque();
	}, 1000);

	setInterval(function() {
		mobFrequency();
	}, timeInterval);
	
	// Gestion du clavier
	window.onkeydown = function(event) {
		var e = event || window.event;
		var key = e.which || e.keyCode;
		switch(key) {
		case 122 : case 90 : // Fl�che haut, z, Z
			monstre[0].deplacer(DIRECTION.HAUT, map);
			break;
		case 115 : case 83 : // Fl�che bas, s, S
			monstre[0].deplacer(DIRECTION.BAS, map);
			break;
		case 113 : case 81 : // Fl�che gauche, q, Q
			monstre[0].deplacer(DIRECTION.GAUCHE, map);
			break;
		case 100 : case 68 : // Fl�che droite, d, D
			monstre[0].deplacer(DIRECTION.DROITE, map);
			break;
		default : 
			return true;
		}
	}	

}
