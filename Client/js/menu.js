var choix = 0;
var tiles = "";

function choixSprites() {
	if(choix == 1) {
		tiles = "test.png";
	} else if(choix == 2) {
		tiles = "monster.png";
	} else if(choix == 3) {
		tiles = "fairy.png";
	} else if(choix == 4) {
		tiles = "dog.png";
	} 
}

function selection(e) {
	e.style.backgroundColor='#FF8000';
	e.style.borderRadius= '10px';
}

function deselection(e) {
	e.style.backgroundColor='transparent';
}

function choixTour(no) {
	choix = no;
	choixSprites();
}

//Placement des tours
window.onclick = function() {
	if(choix != 0) {
		var x = Math.floor(((event.clientX/TAILLE_TILE) * 480) / window.innerWidth);
		var y = Math.floor(((event.clientY/TAILLE_TILE) * 480) / window.innerHeight);
		
		var tour = new Tower(tiles, x, y, DIRECTION.BAS);
		tourPos.push(new Array(x,y));
		map.addTour(tour);
	}
}