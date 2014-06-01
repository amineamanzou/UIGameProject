var choix = 0;
var tiles = "";
var placementActive = false;
var tourSelectionnee;

var xm = -9999;
var ym = -9999;

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
	if(choix == 0) { 
		e.style.backgroundColor = '#FF8000';
		e.style.borderRadius = '10px';
	}
	placementActive = false;
}

function deselection(e) {
	if(choix == 0) { 
		e.style.backgroundColor = 'transparent';
	}
	placementActive = true;
}

function choixTour(no, e) {
	if(tourSelectionnee == e) {
		tourSelectionnee.style.backgroundColor = 'transparent';
		tourSelectionnee = null;
		choix = 0;
		choixTour(no, e);
		canvas.onmousemove = null;
		xm = -9999;
		ym = -9999;
	}

	if(choix == 0) { 
		tourSelectionnee = e;
		tourSelectionnee.style.backgroundColor = 'green';
		tourSelectionnee.style.borderRadius = '10px';
		choix = no;
		choixSprites();
		canvas.onmousemove = positionOk;
	} else {
		tourSelectionnee.style.backgroundColor = 'transparent';
		choix = 0;
		choixTour(no, e);
		xm = -9999;
		ym = -9999;
	}	
}

function goChange() {
	var btGo = document.getElementById('btGo');
	var spanGo = document.getElementById('spanGo');
	spanGo.className = "imgSound glyphicon glyphicon-forward";
}
