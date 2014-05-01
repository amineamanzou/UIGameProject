function Tileset(url) {
	this.image = new Image();
	this.image.referenceDuTileset = this;
	this.image.onload = function() {
		if(!this.complete) 
			throw new Error("Erreur chargement tilset - \"" + url + "\".");
		
		// Largeur du tileset en tiles
		this.referenceDuTileset.largeur = this.width / TAILLE_TILE;
		
	}
	this.image.src = "tilesets/" + url;
}

// Méthode de dessin du tile numéro "numero" dans le contexte 2D "context" aux coordonnées x et y
Tileset.prototype.dessinerTile = function(numero, context, xDestination, yDestination) {
	var xSourceEnTiles = numero % this.largeur;
	if(xSourceEnTiles == 0) xSourceEnTiles = this.largeur;
	var ySourceEnTiles = Math.ceil(numero / this.largeur);
	
	var xSource = (xSourceEnTiles - 1) * TAILLE_TILE;
	var ySource = (ySourceEnTiles - 1) * TAILLE_TILE;
	
	context.drawImage(this.image, xSource, ySource, TAILLE_TILE, TAILLE_TILE, xDestination, yDestination, TAILLE_TILE, TAILLE_TILE);
}
