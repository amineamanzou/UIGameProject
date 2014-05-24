function Map(nom) {
	 var mapJsonData = $.ajax({
		url: "./maps/" + nom + ".json",
		async: false
	 }).responseText;
	
	var mapData = JSON.parse(mapJsonData);
	this.tileset = new Tileset(mapData.tileset);
	this.terrain = mapData.terrain;
	this.walkable = mapData.walkable;

	// Liste des personnages présents sur le terrain.
	this.monstres = new Array();

	this.tours = new Array();
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
}

// Pour ajouter un monstre
Map.prototype.addMonstre = function(monstre) {
	this.monstres.push(monstre);
}

Map.prototype.addTour = function(tour) {
	this.tours.push(tour);
}