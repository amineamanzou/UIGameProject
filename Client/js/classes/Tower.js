var tailleX = 20;

function Tower(id, url, x, y, direction) {
	this.ide = id;

	this.x = x; // (en cases)
	this.y = y; // (en cases)
	this.direction = direction;
	
	// Chargement de l'image dans l'attribut image
	this.image = new Image();
	this.image.referenceTour = this;
	this.image.onload = function() {
		if(!this.complete) 
			throw "Erreur chargement sprite - \"" + url + "\".";
		
		this.referenceTour.largeur = this.width / 4;
		this.referenceTour.hauteur = this.height / 4;
	}

	this.image.src = "sprites/" + url;
	this.etatAnimation = -1;

	this.pdv = 15;
	this.totalPdv = 15;
	this.degat = 5;
	this.portee = 5;
}

Tower.prototype.dessinerTower = function(context) {
	var frame = 0; // Numéro de l'image à prendre pour l'animation
	var decalageX = 0, decalageY = 0; // Décalage à appliquer à la position du Tower
	if(this.etatAnimation >= DUREE_DEPLACEMENT) {
		// Si le déplacement a atteint ou dépassé le temps nécessaire pour s'effectuer, on le termine
		this.etatAnimation = -1;
	} else if(this.etatAnimation >= 0) {
		// On calcule l'image (frame) de l'animation à afficher
		frame = Math.floor(this.etatAnimation / DUREE_ANIMATION);
		if(frame > 3) {
			frame %= DUREE_ANIMATION;
		}
		
		// Nombre de pixels restant à parcourir entre les deux cases
		var pixelsAParcourir = TAILLE_TILE - (TAILLE_TILE * (this.etatAnimation / DUREE_DEPLACEMENT));
		
		// À partir de ce nombre, on définit le décalage en x et y.
		// NOTE : Si vous connaissez une manière plus élégante que ces quatre conditions, je suis preneur
		if(this.direction == DIRECTION.HAUT) {
			decalageY = pixelsAParcourir;
		} else if(this.direction == DIRECTION.BAS) {
			decalageY = -pixelsAParcourir;
		} else if(this.direction == DIRECTION.GAUCHE) {
			decalageX = pixelsAParcourir;
		} else if(this.direction == DIRECTION.DROITE) {
			decalageX = -pixelsAParcourir;
		}
		
		this.etatAnimation++;
	}
	/*
	* Si aucune des deux conditions n'est vraie, c'est qu'on est immobile, 
	* donc il nous suffit de garder les valeurs 0 pour les variables 
	* frame, decalageX et decalageY
	*/
	
		
	// Ici se trouvera le code de dessin du Tower
	context.drawImage(
	this.image, 
	this.largeur * frame, this.direction * this.hauteur, // Point d'origine du rectangle source à prendre dans notre image
	this.largeur, this.hauteur, // Taille du rectangle source (c'est la taille du Tower)
	(this.x * TAILLE_TILE) - (this.largeur / 2) + (TAILLE_TILE/2) + decalageX, (this.y * TAILLE_TILE) - this.hauteur + (TAILLE_TILE*2/3) + decalageY, // Point de destination (dépend de la taille du Tower)
	this.largeur, this.hauteur // Taille du rectangle destination (c'est la taille du Tower)
	);

    //point de vie
   	context.fillStyle = "red";
   	var x = (this.x * TAILLE_TILE) - (this.largeur / 2) + (TAILLE_TILE/2) + decalageX + 6;
	var y = (this.y * TAILLE_TILE) - this.hauteur + (TAILLE_TILE*2/3) + decalageY - 10;
   	context.fillRect(x, y, tailleX, 10);

   	context.fillStyle = "green";
   	var pdv = (this.pdv/this.totalPdv) * tailleX;
   	var x = (this.x * TAILLE_TILE) - (this.largeur / 2) + (TAILLE_TILE/2) + decalageX + 6;
	var y = (this.y * TAILLE_TILE) - this.hauteur + (TAILLE_TILE*2/3) + decalageY - 10;
   	context.fillRect(x, y, pdv, 10);

}

