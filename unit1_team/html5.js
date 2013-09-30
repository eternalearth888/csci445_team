var size = 35;
var numCols = 10;
var numRows = 18;
var direction = 0;
var x = 0;
var y = 0;
var colors = ["green", "orange", "yellow", "red", "blue", "cyan", "purple"];
var count = 0;

//T 
var T = [[2,[0, -1, -1, -1],[0, 0, 1, -1]],[2,[0, -1, -1, -2],[0, -1, 0, 0]],
		[2,[0, 0, 0, -1],[0, -1, 1, 0]],[2,[0, -1, -1, -2],[0, 0, 1, 0]]];
var uT = [[1,[-2, -2, -2],[0, 1, -1]],[2,[-3, -2],[0, -1]],
		[1,[-1, -1, -2],[-1, 1, 0]],[2,[-3, -2],[0, 1]]];		
var rT = [[[-1],[1]],[[-1, -1, -2],[0, -1, 0]],[[0, 0],[-1, 1]],[[-2],[0]]];
var rightT = [[[-1, 0],[-2, -1]],[[-2, -1, 0],[-1, -2, -1]],
		[[0, -1],[-2, -1]],[[-2, -1, 0],[-1, -1, -1]]];
var leftT = [[[-1, 0],[2, 1]],[[-2, -1, 0],[1, 1, 1]],
		[[0, -1],[2, 1]],[[-2, -1, 0],[1, 2, 1]]];
var sidesT = [[-1, 1, -1, 0],[-1, 0, -1, 1],[-1, 1, -1, 0],[0, 1, -1, 1]];
	
//O	
var O = [[2,[0, -1, -1, 0],[0, -1, 0, -1]],[2,[0, -1, -1, 0],[0, -1, 0, -1]],
		[2,[0, -1, -1, 0],[0, -1, 0, -1]],[2,[0, -1, -1, 0],[0, -1, 0, -1]]];
var uO = [[2,[-2, -2],[-1, 0]],[2,[-2, -2],[-1, 0]],
		[2,[-2, -2],[-1, 0]],[2,[-2, -2],[-1, 0]]];
var rO = [[[],[]],[[],[]],[[],[]],[[],[]]];
var rightO = [[[-1, 0],[-2, -2]],[[-1, 0],[-2, -2]],
		[[-1, 0],[-2, -2]],[[-1, 0],[-2, -2]]];
var leftO = [[[-1, 0],[1, 1]],[[-1, 0],[1, 1]],
		[[-1, 0],[1, 1]],[[-1, 0],[1, 1]]];
var sidesO = [[-1, 0, -1, 0],[-1, 0, -1, 0],[-1, 0, -1, 0],[-1, 0, -1, 0]];
	
//S	
var S = [[2,[0, -1, 0, -1],[0, 0, -1, 1]],[2,[0, -1, -1, -2],[0, 0, -1, -1]],
		[2,[0, -1, 0, -1],[0, 0, -1, 1]],[2,[0, -1, -1, -2],[0, 0, -1, -1]]];
var uS = [[2,[-1,-2,-2],[-1,0,1]], [2,[-3,-2],[-1,0]], 
		[2,[-1,-2,-2],[-1,0,1]], [2,[-3,-2],[-1,0]]];
var rS = [[[0,-1],[-1,1]],[[-2,-1],[-1,-1]], [[0,-1],[-1,1]], [[-2,-1],[-1,-1]]];
var rightS = [[[0,-1],[-2,-1]], [[-2,-1,0],[-2,-2,-1]], 
		[[0,-1],[-2,-1]], [[-2,-1,0],[-2,-2,-1]]];
var leftS = [[[-1,0],[2,1]],[[-2,-1,0],[0,1,1]],
		[[-1,0],[2,1]],[[-2,-1,0],[0,1,1]]];
var sidesS = [[-1, 1, -1, 0],[-1, 0, -2, 0],[-1, 1, -1, 0],[-1, 0, -2, 0]];

//Z	
var Z = [[2,[-1, -1, 0, 0],[-1, 0, 0, 1]],[2,[-2, -1, -1, 0],[1, 1, 0, 0]],
		[2,[-1, -1, 0, 0],[-1, 0, 0, 1]],[2,[-2, -1, -1, 0],[1, 1, 0, 0]]];
var uZ = [[2,[-2,-2,-1],[-1,0,1]],[2,[-3,-2],[1,0]], 
		[2,[-2,-2,-1],[-1,0,1]],[2,[-3,-2],[1,0]]];
var rZ = [[[-1,0],[-1,1]],[[-2,-1],[1,1]], [[-1,0],[-1,1]],[[-2,-1],[1,1]]];
var rightZ = [[[-1,0],[-2,-1]], [[-2,-1,0],[0,-1,-1]], 
		[[-1,0],[-2,-1]], [[-2,-1,0],[0,-1,-1]]];
var leftZ = [[[-1,0],[1,2]],[[-2,-1,0],[2,2,1]],
		[[-1,0],[1,2]],[[-2,-1,0],[2,2,1]]];
var sidesZ = [[-1, 1, -1, 0],[0, 1, -2, 0],[-1, 1, -1, 0],[0, 1, -2, 0]];

//I	
var I = [[2,[-1, 1, 2, 0],[0, 0, 0, 0]],[1,[0, 0, 0, 0],[-1, 1, 2, 0]],
		[2,[-1, 1, 2, 0],[0, 0, 0, 0]],[1,[0, 0, 0, 0],[-1, 1, 2, 0]]];
var uI = [[2,[-2],[0]],[1,[-1,-1,-1,-1],[-1,1,2,0]], 
		[2,[-2],[0]],[1,[-1,-1,-1,-1],[-1,1,2,0]]];
var rI = [[[-1,1,2],[0,0,0]],[[0,0,0],[-1,1,2]], [[-1,1,2],[0,0,0]],[[0,0,0],[-1,1,2]]];
var rightI = [[[-1,1,2,0],[-1,-1,-1,-1]], [[0],[-2]], 
		[[-1,1,2,0],[-1,-1,-1,-1]], [[0],[-2]]];
var leftI = [[[-1,1,2,0],[1,1,1,1]],[[0],[3]],
		[[-1,1,2,0],[1,1,1,1]],[[0],[3]]];
var sidesI = [[0, 0, -1, 2],[-1, 2, 0, 0],[0, 0, -1, 2],[-1, 2, 0, 0]];

//J	
var J = [[2,[0, -1, 1, 1],[0, 0, 0, -1]],[2,[0, 0, 0, -1],[0, -1, 1, -1]],
		[2,[0, -1, 1, -1],[0, 0, 0, 1]],[2,[0, 0, 0, 1],[0, -1, 1, 1]]];
var uJ = [[2,[-2,0],[0,-1]],[2,[-2,-1,-1],[-1,0,1]], 
		[2,[-2,-2],[0,1]],[2,[-1,-1,-1],[-1,0,1]]];
var rJ = [[[-1,1,1],[0,0,-1]],[[-1,0,0],[-1,-1,1]], [[-1,-1,1],[0,1,0]],[[0,0,1],[-1,1,1]]];
var rightJ = [[[-1,0,1],[-1,-1,-2]], [[-1,0],[-2,-2]], 
		[[-1,0,1],[-1,-1,-1]],[[0,1],[-2,0]]];
var leftJ = [[[-1,0,1],[1,1,1]],[[-1,0],[0,2]],
		[[-1,0,1],[2,1,1]],[[0,1],[2,2]]];
var sidesJ = [[-1, 0, -1, 1],[-1, 1, -1, 0],[0, 1, -1, 1],[-1, 1, 0, 1]];

//L	
var L = [[2,[-1, 0, 1, 1],[0, 0, 0, 1]],[1,[0, 0, 0, 1],[-1, 0, 1, -1]],
		[2,[-1, -1, 0, 1],[-1, 0, 0, 0]],[1,[0, 0, 0, -1],[-1, 0, 1, 1]]];
var uL = [[2,[-2,0],[0,1]],[1,[-1,-1,-1],[-1,0,1]], 
		[2,[-2,-2],[-1,0]],[1,[-1,-1,-2],[-1,0,1]]];
var rL = [[[-1,1,1],[0,0,1]], [[0,1,0],[-1,-1,1]], [[-1,-1,1],[-1,0,0]], [[0,0,-1],[-1,1,1]]];
var rightL = [[[-1,0,1],[-1,-1,-1]], [[0,1],[-2,-2]], 
		[[-1,0,1],[-2,-1,-1]], [[-1,0],[0,-2]]];
var leftL = [[[-1,0,1],[1,1,2]], [[0,1],[2,0]], 
		[[-1,0,1],[1,1,1]], [[-1,0],[2,2]]];
var sidesL = [[0, 1, -1, 1],[-1, 1, 0, 1],[-1, 0, -1, 1],[-1, 1, -1, 0]];

var KEY = { LEFT: 37, UP: 38, RIGHT: 39, SPACE: 32 };

window.onload = function(){

	for(i=0;i<180;i++){
		var c = document.createElement("canvas");
		c.setAttribute('id','id'+(i+1));
		c.setAttribute('width',size);
		c.setAttribute('height',size);
		c.setAttribute('occupied', false);
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
	var available = true;
	var i=2;
	y=5;
	var interval = setInterval(function () {
		//alert(i);
		x = i;
		available = checkDraw(T);
		//alert("Available: " + available);
		if (available == true) {
			drawPiece(T);
			i++; 
			undrawPiece(uT);
		} else { x--; setOccupied(T); i=2; }	
		if (i + sidesT[direction][3] > 17) {setOccupied(T); i=2;}}, 300);
		//clearInterval(interval);
}

function newGame() {

}

function getID(row, col) {
	return col + (row * numCols);
}

function setOccupied(piece) {
	for (i=0;i<4;i++) {
		var id = getID(x + piece[direction][1][i], y + piece[direction][2][i]);
		var c = document.getElementById("id"+id.toString());
		c.setAttribute('occupied', true);
	}
}

function checkDraw(piece) {
	for (i=0;i<4;i++) {
		var id = getID(x + piece[direction][1][i], y + piece[direction][2][i]);
		var c = document.getElementById("id"+id.toString());
		var occupied = c.getAttribute('occupied');
		//alert(i + " " + occupied);
		if (occupied == "true") { 
			return false;
			alert("RETURNNNNNNNNNNNN");
		}
	}
	return true;
}

function draw(row, col) {
	var i = getID(row, col);
	var c = document.getElementById("id"+i.toString());
	var ctx = c.getContext('2d');
	ctx.fillStyle=colors[count];
	ctx.fillRect(0,0,size-3,size);
}

function undraw(row, col) {
	var i = getID(row, col);
	var c = document.getElementById("id"+i.toString());
	var ctx = c.getContext('2d');
	ctx.fillStyle='#FFFFFF';
	ctx.fillRect(0,0,size-3,size);
}

function undrawPiece(piece) {
	if (x > piece[direction][0]) {
		for (i=0;i<piece[direction][1].length;i++) {
			undraw(x + piece[direction][1][i], y + piece[direction][2][i]);
		}
	}
}

function drawPiece(piece) {
	if (x >= piece[direction][0]) { 
		draw(x + piece[direction][1][0], y + piece[direction][2][0]);
		draw(x + piece[direction][1][1], y + piece[direction][2][1]);
		draw(x + piece[direction][1][2], y + piece[direction][2][2]);
		draw(x + piece[direction][1][3], y + piece[direction][2][3]);
	}
}

function movePieceRight(Mpiece, right, piece) {
	if (y + Mpiece[direction][1] < 10) {
		y++;
	}
	for (i=0;i<right[direction][0].length;i++) {
		undraw(x + right[direction][0][i], y + right[direction][1][i]);
	}
	drawPiece(piece);
}

function movePieceLeft(Mpiece, left, piece) {
	if (y + Mpiece[direction][0] > 1) {
		y--;
	}
	for (i=0;i<left[direction][0].length;i++) {
		undraw(x + left[direction][0][i], y + left[direction][1][i]);
	}
	drawPiece(piece);
}

function rotatePiece(Rpiece, piece) {
	for (i=0;i<Rpiece[direction][0].length;i++) {
		undraw(x + Rpiece[direction][0][i], y + Rpiece[direction][1][i]);
	}
	if (direction == 3) {
		direction = 0;
	} else {
		direction++;
	}
	drawPiece(piece);
}

function keydown(ev) {
	if (ev.keyCode == KEY.UP) {
		rotatePiece(rT, T);
	} else if (ev.keyCode == KEY.RIGHT) {
		movePieceRight(sidesT, rightT, T);
	} else if (ev.keyCode == KEY.LEFT) {
		movePieceLeft(sidesT, leftT, T);
	} else if (ev.keyCode == KEY.SPACE) {
		alert("Game is Paused");
	}
}

