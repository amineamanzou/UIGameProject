function Map(nom) {
	 var mapJsonData = $.ajax({
		url: "./maps/" + nom + ".json",
		async: false
	 }).responseText;
	
	var mapData = JSON.parse(mapJsonData);
	this.tileset = new Tileset(mapData.tileset);
	this.terrain = mapData.terrain;
	this.walkable = mapData.walkable;

	this.monstres = new Array();
	this.tours = new Array();
	this.toursPrincipales = new Array();
}

Map.prototype.getHauteur = function() {
	return this.terrain.length;
}
Map.prototype.getLargeur = function() {
	return this.terrain[0].length;
}

Map.prototype.dessinerMap = function(context) {
	for(var i = 0, l = this.terrain.length ; i < l ; i++) {
		var ligne = this.terrain[i];
		var y = i * TAILLE_TILE;
		for(var j = 0, k = ligne.length ; j < k ; j++) {
			this.tileset.dessinerTile(ligne[j], context, j * TAILLE_TILE, y);
		}
	}
	
	// Dessin des monstres 
	for(var i = 0, l = this.monstres.length ; i < l ; i++) {
		this.monstres[i].dessinerMonstre(context);
	}

	for(var i = 0, l = this.tours.length ; i < l ; i++) {
		this.tours[i].dessinerTower(context);
	}

		for(var i = 0, l = this.toursPrincipales.length ; i < l ; i++) {
		this.toursPrincipales[i].dessinerTowerPrincipale(context);
	}
}

Map.prototype.isWalkable = function(x, y) {
	return (this.walkable[x][y] == 1);
}

// Pour ajouter un monstre
Map.prototype.addMonstre = function(monstre) {
	this.monstres.push(monstre);
}

Map.prototype.addTour = function(tour) {
	this.tours.push(tour);
}

Map.prototype.addTourPrincipale = function(tour) {
	this.toursPrincipales.push(tour);
}

Map.prototype.deleteTour = function(id) {
	var bfr = [];

   	for(var i = 0; i < this.tours.length; i++) {
      	if(this.tours[i].ide != id) {
       		bfr.push(this.tours[i]);
      	}
   	}

   	this.tours = bfr;
}

Map.prototype.deleteTourPrincipale = function(id) {
	var bfr = [];

   	for(var i = 0; i < this.toursPrincipales.length; i++) {
      	if(this.toursPrincipales[i].ide != id) {
       		bfr.push(this.toursPrincipales[i]);
      	}
   	}

   	this.toursPrincipales = bfr;
}

Map.prototype.deleteMonstre = function(id) {
	var bfr = [];

   	for(var i = 0; i < this.monstres.length; i++) {
      	if(this.monstres[i].ide != id) {
       		bfr.push(this.monstres[i]);
      	}
   	}

   	this.monstres = bfr;
}