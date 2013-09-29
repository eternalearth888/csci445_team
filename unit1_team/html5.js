var size = 35;
var numCols = 10;
var numRows = 18;
var direction = 0;
var x = 0;
var y = 0;
var colors = ["green", "orange", "yellow", "red", "blue", "cyan", "purple"];
var count = 4;

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

var KEY = { LEFT: 37, UP: 38, RIGHT: 39 };

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
	var i=2;
	y=5;
	var interval = setInterval(function () {
		x = i;
		drawPiece(O); 
		i++; 
		undrawPiece(uO);
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
		rotatePiece(rO, O);
	} else if (ev.keyCode == KEY.RIGHT) {
		movePieceRight(sidesO, rightO, O);
	} else if (ev.keyCode == KEY.LEFT) {
		movePieceLeft(sidesO, leftO, O);
	}
}

