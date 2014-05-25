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
