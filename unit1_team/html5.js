var size = 35;
var numCols = 10;
var numRows = 18;
var direction = 0;
var x = 0;
var y = 0;


var KEY = { RIGHT: 39 };

window.onload = function(){

	for(i=0;i<180;i++){
		var c = document.createElement("canvas");
		c.setAttribute('id','id'+(i+1));
		c.setAttribute('width',size);
		c.setAttribute('height',size);
		c.className = i;

		document.getElementById("screen").appendChild(c);

		var ctx=c.getContext('2d');
		ctx.fillStyle='#FFFFFF';
		
		ctx.fillRect(0,0,size-3,size);
	}

	beginGame();
	document.addEventListener('keydown', keydown, false);

	document.getElementById("newGame").onclick = newGame;
}

function beginGame() {
	var i=0;
	var interval = setInterval(function () {
		x = i;
		y = 4;
		drawT(); 
		i++; 
		undrawT();
		if (i > 17) clearInterval(interval);}, 500);
}

function newGame() {

}

function getID(row, col) {
	return col + (row * numCols);
}

function draw(row, col) {
	var i = getID(row, col);
	var c = document.getElementById("id"+i.toString());
	var ctx = c.getContext('2d');
	ctx.fillStyle='red';
	ctx.fillRect(0,0,size-3,size);
}

function undraw(row, col) {
	var i = getID(row, col);
	var c = document.getElementById("id"+i.toString());
	var ctx = c.getContext('2d');
	ctx.fillStyle='#FFFFFF';
	ctx.fillRect(0,0,size-3,size);
}

function undrawT() {
	if (direction == 0) {
		if (x > 1) {
			undraw(x-2, y);
			undraw(x-2, y+1);
			undraw(x-2, y-1);
		}
	} else if (direction == 1) {
		if (x > 2) {
			undraw(x-3, y);
			undraw(x-2, y-1);
		}
	} else if (direction == 2) {
		if (x > 1) {
			undraw(x-1, y-1);
			undraw(x-1, y+1);
			undraw(x-2, y);
		}
	} else if (direction == 3) {
		if (x > 2) {
			undraw(x-3, y);
			undraw(x-2, y+1);
		}
	}
}

function drawT() {
	if (direction == 0) {
		if (x >= 2) {
			draw(x, y);
			draw(x-1, y);
			draw(x-1, y+1);
			draw(x-1, y-1);
		}
	} else if (direction == 1) {
		if (x >= 2) {
			draw(x, y);
			draw(x-1, y-1);
			draw(x-1, y);
			draw(x-2, y);
		}
	} else if (direction == 2) {
		if (x >= 2) {
			draw(x, y);
			draw(x, y-1);
			draw(x, y+1);
			draw(x-1, y);
		}
	} else if (direction == 3) {
		if (x >= 2) {
			draw(x, y);
			draw(x-1, y);
			draw(x-1, y+1);
			draw(x-2, y);
		}
	}
}



function keydown(ev) {
	if (ev.keyCode == KEY.RIGHT) {
		if (direction == 0) {
			undraw(x-1, y+1);
			direction = 1;
			drawT();
		} else if (direction == 1) {
			undraw(x-1, y);
			undraw(x-1,y-1);
			undraw(x-2,y);
			direction = 2;
			drawT();
		} else if (direction == 2) {
			undraw(x, y-1);
			undraw(x, y+1);
			direction = 3;
			drawT();
		} else if (direction == 3) {
			undraw(x-2, y);
			direction = 0;
			drawT();
		}
	}
}

