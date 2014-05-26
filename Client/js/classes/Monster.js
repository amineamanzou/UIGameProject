function Monster(id ,url, x, y, direction) {
	this.ide = id;

	this.x = x; // (en cases)
	this.y = y; // (en cases)
	this.direction = direction;
	
	// Chargement de l'image dans l'attribut image
	this.image = new Image();
	this.image.referenceDuMonstre = this;
	this.image.onload = function() {
		if(!this.complete) 
			throw "Erreur chargement sprite - \"" + url + "\".";
		
		this.referenceDuMonstre.largeur = this.width / 4;
		this.referenceDuMonstre.hauteur = this.height / 4;
	}

	this.image.src = "sprites/" + url;
	this.etatAnimation = -1;

	this.pdv = 20;
	this.totalPdv = 15;
	this.degat = 5;
	this.portee = 2;
}

Monster.prototype.dessinerMonstre = function(context) {
	var frame = 0; // Numéro de l'image à prendre pour l'animation
	var decalageX = 0, decalageY = 0; // Décalage à appliquer à la position du Monster
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
	
		
	// Ici se trouvera le code de dessin du Monster
	context.drawImage(
	this.image, 
	this.largeur * frame, this.direction * this.hauteur, // Point d'origine du rectangle source à prendre dans notre image
	this.largeur, this.hauteur, // Taille du rectangle source (c'est la taille du Monster)
	(this.x * TAILLE_TILE) - (this.largeur / 2) + (TAILLE_TILE/2) + decalageX, (this.y * TAILLE_TILE) - this.hauteur + (TAILLE_TILE*2/3) + decalageY, // Point de destination (dépend de la taille du Monster)
	this.largeur, this.hauteur // Taille du rectangle destination (c'est la taille du Monster)
	);

	tmonstreX=15;
	
	//point de vie
   	context.fillStyle = "red";
   	var x = (this.x * TAILLE_TILE) - (this.largeur / 2) + (TAILLE_TILE/2) + decalageX + 6;
	var y = (this.y * TAILLE_TILE) - this.hauteur + (TAILLE_TILE*2/3) + decalageY - 10;
   	context.fillRect(x, y, tmonstreX, tailleY);

   	context.fillStyle = "green";
   	var pdv = (this.pdv/this.totalPdv) * tmonstreX;
   	var x = (this.x * TAILLE_TILE) - (this.largeur / 2) + (TAILLE_TILE/2) + decalageX + 6;
	var y = (this.y * TAILLE_TILE) - this.hauteur + (TAILLE_TILE*2/3) + decalageY - 10;
   	context.fillRect(x, y, pdv, tailleY);
}

Monster.prototype.getCoordonneesAdjacentes = function(direction)  {
	var coord = {'x' : this.x, 'y' : this.y};
	switch(direction) {
		case DIRECTION.BAS : 
			coord.y++;
			break;
		case DIRECTION.GAUCHE : 
			coord.x--;
			break;
		case DIRECTION.DROITE : 
			coord.x++;
			break;
		case DIRECTION.HAUT : 
			coord.y--;
			break;
	}
	return coord;
}
	
Monster.prototype.deplacer = function(direction, map) {
	// On ne peut pas se déplacer si un mouvement est déjà en cours !
	if(this.etatAnimation >= 0) {
		return false;
	}

	// On change la direction du Monster
	this.direction = direction;
		
	// On vérifie que la case demandée est bien située dans la carte
	var prochaineCase = this.getCoordonneesAdjacentes(direction);
	if(prochaineCase.x < 0 || prochaineCase.y < 0 || prochaineCase.x >= map.getLargeur() || prochaineCase.y >= map.getHauteur()) {
		// On retourne un booléen indiquant que le déplacement ne s'est pas fait, 
		return false;
	}
	//On vérifie que le joueur peut se déplacer sur cette case
	if(map.walkable[prochaineCase.y][prochaineCase.x] == 0) {
		// On retourne un booléen indiquant que le déplacement ne s'est pas fait, 
		return false;
	}
	
	// On commence l'animation
	this.etatAnimation = 1;
		
	// On effectue le déplacement
	this.x = prochaineCase.x;
	this.y = prochaineCase.y;
		
	return true;
}

