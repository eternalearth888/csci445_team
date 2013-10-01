var size = 35;
var numCols = 10;
var numRows = 18;
var direction = 0;
var x = 0;
var y = 0;
var colors = ["blocks/jupiter.png", "blocks/venus.png", "blocks/moon.png", 
		"blocks/mars.png", "blocks/mercury.png", "blocks/neptune.png", "blocks/saturn.png"];
var nextImage = ["nextImage/jupiter.png", "nextImage/venus.png", "nextImage/moon.png", 
		"nextImage/mars.png", "nextImage/mercury.png", "nextImage/neptune.png", "nextImage/saturn.png"];
var pieces = ["T", "S", "O", "I", "J", "L", "Z"]
var count = 6;
var next = 1;
var lines = 0;

var availableCount = 0;

var active = false;

//T 
var dT = [[2,[0, -1, -1, -1],[0, 0, 1, -1]],[2,[0, -1, -1, -2],[0, -1, 0, 0]],
		[2,[0, 0, 0, -1],[0, -1, 1, 0]],[2,[0, -1, -1, -2],[0, 0, 1, 0]]];
var uT = [[1,[-2, -2, -2],[0, 1, -1]],[2,[-3, -2],[0, -1]],
		[1,[-1, -1, -2],[-1, 1, 0]],[2,[-3, -2],[0, 1]]];		
var rT = [[[-1],[1]],[[-1, -1, -2],[0, -1, 0]],[[0, 0],[-1, 1]],[[-2],[0]]];
var rightT = [[[-1, 0],[-2, -1]],[[-2, -1, 0],[-1, -2, -1]],
		[[0, -1],[-2, -1]],[[-2, -1, 0],[-1, -1, -1]]];
var leftT = [[[-1, 0],[2, 1]],[[-2, -1, 0],[1, 1, 1]],
		[[0, -1],[2, 1]],[[-2, -1, 0],[1, 2, 1]]];
var sidesT = [[-1, 1, -1, 0],[-1, 0, -1, 0],[-1, 1, -1, 0],[0, 1, -1, 0]];

var T = [dT, uT, rT, rightT, leftT, sidesT];

//O	
var dO = [[2,[0, -1, -1, 0],[0, -1, 0, -1]],[2,[0, -1, -1, 0],[0, -1, 0, -1]],
		[2,[0, -1, -1, 0],[0, -1, 0, -1]],[2,[0, -1, -1, 0],[0, -1, 0, -1]]];
var uO = [[2,[-2, -2],[-1, 0]],[2,[-2, -2],[-1, 0]],
		[2,[-2, -2],[-1, 0]],[2,[-2, -2],[-1, 0]]];
var rO = [[[],[]],[[],[]],[[],[]],[[],[]]];
var rightO = [[[-1, 0],[-2, -2]],[[-1, 0],[-2, -2]],
		[[-1, 0],[-2, -2]],[[-1, 0],[-2, -2]]];
var leftO = [[[-1, 0],[1, 1]],[[-1, 0],[1, 1]],
		[[-1, 0],[1, 1]],[[-1, 0],[1, 1]]];
var sidesO = [[-1, 0, -1, 0],[-1, 0, -1, 0],[-1, 0, -1, 0],[-1, 0, -1, 0]];

var O = [dO, uO, rO, rightO, leftO, sidesO];
	
//S	
var dS = [[2,[0, -1, 0, -1],[0, 0, -1, 1]],[2,[0, -1, -1, -2],[0, 0, -1, -1]],
		[2,[0, -1, 0, -1],[0, 0, -1, 1]],[2,[0, -1, -1, -2],[0, 0, -1, -1]]];
var uS = [[2,[-1,-2,-2],[-1,0,1]], [2,[-3,-2],[-1,0]], 
		[2,[-1,-2,-2],[-1,0,1]], [2,[-3,-2],[-1,0]]];
var rS = [[[0,-1],[-1,1]],[[-2,-1],[-1,-1]], [[0,-1],[-1,1]], [[-2,-1],[-1,-1]]];
var rightS = [[[0,-1],[-2,-1]], [[-2,-1,0],[-2,-2,-1]], 
		[[0,-1],[-2,-1]], [[-2,-1,0],[-2,-2,-1]]];
var leftS = [[[-1,0],[2,1]],[[-2,-1,0],[0,1,1]],
		[[-1,0],[2,1]],[[-2,-1,0],[0,1,1]]];
var sidesS = [[-1, 1, -1, 0],[-1, 0, -2, 0],[-1, 1, -1, 0],[-1, 0, -2, 0]];

var S = [dS, uS, rS, rightS, leftS, sidesS];

//Z	
var dZ = [[2,[-1, -1, 0, 0],[-1, 0, 0, 1]],[2,[-2, -1, -1, 0],[1, 1, 0, 0]],
		[2,[-1, -1, 0, 0],[-1, 0, 0, 1]],[2,[-2, -1, -1, 0],[1, 1, 0, 0]]];
var uZ = [[2,[-2,-2,-1],[-1,0,1]],[2,[-3,-2],[1,0]], 
		[2,[-2,-2,-1],[-1,0,1]],[2,[-3,-2],[1,0]]];
var rZ = [[[-1,0],[-1,1]],[[-2,-1],[1,1]], [[-1,0],[-1,1]],[[-2,-1],[1,1]]];
var rightZ = [[[-1,0],[-2,-1]], [[-2,-1,0],[0,-1,-1]], 
		[[-1,0],[-2,-1]], [[-2,-1,0],[0,-1,-1]]];
var leftZ = [[[-1,0],[1,2]],[[-2,-1,0],[2,2,1]],
		[[-1,0],[1,2]],[[-2,-1,0],[2,2,1]]];
var sidesZ = [[-1, 1, -1, 0],[0, 1, -2, 0],[-1, 1, -1, 0],[0, 1, -2, 0]];

var Z = [dZ, uZ, rZ, rightZ, leftZ, sidesZ];

//I	
var dI = [[2,[-1, 1, 2, 0],[0, 0, 0, 0]],[1,[0, 0, 0, 0],[-1, 1, 2, 0]],
		[2,[-1, 1, 2, 0],[0, 0, 0, 0]],[1,[0, 0, 0, 0],[-1, 1, 2, 0]]];
var uI = [[2,[-2],[0]],[1,[-1,-1,-1,-1],[-1,1,2,0]], 
		[2,[-2],[0]],[1,[-1,-1,-1,-1],[-1,1,2,0]]];
var rI = [[[-1,1,2],[0,0,0]],[[0,0,0],[-1,1,2]], [[-1,1,2],[0,0,0]],[[0,0,0],[-1,1,2]]];
var rightI = [[[-1,1,2,0],[-1,-1,-1,-1]], [[0],[-2]], 
		[[-1,1,2,0],[-1,-1,-1,-1]], [[0],[-2]]];
var leftI = [[[-1,1,2,0],[1,1,1,1]],[[0],[3]],
		[[-1,1,2,0],[1,1,1,1]],[[0],[3]]];
var sidesI = [[0, 0, -1, 2],[-1, 2, 0, 0],[0, 0, -1, 2],[-1, 2, 0, 0]];

var I = [dI, uI, rI, rightI, leftI, sidesI];

//J	
var dJ = [[2,[0, -1, 1, 1],[0, 0, 0, -1]],[2,[0, 0, 0, -1],[0, -1, 1, -1]],
		[2,[0, -1, 1, -1],[0, 0, 0, 1]],[2,[0, 0, 0, 1],[0, -1, 1, 1]]];
var uJ = [[2,[-2,0],[0,-1]],[2,[-2,-1,-1],[-1,0,1]], 
		[2,[-2,-2],[0,1]],[2,[-1,-1,-1],[-1,0,1]]];
var rJ = [[[-1,1,1],[0,0,-1]],[[-1,0,0],[-1,-1,1]], [[-1,-1,1],[0,1,0]],[[0,0,1],[-1,1,1]]];
var rightJ = [[[-1,0,1],[-1,-1,-2]], [[-1,0],[-2,-2]], 
		[[-1,0,1],[-1,-1,-1]],[[0,1],[-2,0]]];
var leftJ = [[[-1,0,1],[1,1,1]],[[-1,0],[0,2]],
		[[-1,0,1],[2,1,1]],[[0,1],[2,2]]];
var sidesJ = [[-1, 0, -1, 1],[-1, 1, -1, 0],[0, 1, -1, 1],[-1, 1, 0, 1]];

var J = [dJ, uJ, rJ, rightJ, leftJ, sidesJ];

//L	
var dL = [[2,[-1, 0, 1, 1],[0, 0, 0, 1]],[1,[0, 0, 0, 1],[-1, 0, 1, -1]],
		[2,[-1, -1, 0, 1],[-1, 0, 0, 0]],[1,[0, 0, 0, -1],[-1, 0, 1, 1]]];
var uL = [[2,[-2,0],[0,1]],[1,[-1,-1,-1],[-1,0,1]], 
		[2,[-2,-2],[-1,0]],[1,[-1,-1,-2],[-1,0,1]]];
var rL = [[[-1,1,1],[0,0,1]], [[0,1,0],[-1,-1,1]], [[-1,-1,1],[-1,0,0]], [[0,0,-1],[-1,1,1]]];
var rightL = [[[-1,0,1],[-1,-1,-1]], [[0,1],[-2,-2]], 
		[[-1,0,1],[-2,-1,-1]], [[-1,0],[0,-2]]];
var leftL = [[[-1,0,1],[1,1,2]], [[0,1],[2,0]], 
		[[-1,0,1],[1,1,1]], [[-1,0],[2,2]]];
var sidesL = [[0, 1, -1, 1],[-1, 1, 0, 1],[-1, 0, -1, 1],[-1, 1, -1, 0]];

var L = [dL, uL, rL, rightL, leftL, sidesL];

var currentPiece = L;

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
	active = false;
	initialSetup();
	//beginGame();
	document.addEventListener('keydown', keydown, false);

	window.addEventLIstener("keydown", function(e) {
		if ([32, 37, 38, 39, 40].indexOf(e.keyCode) > -1) {
			e.preventDefault();
		}
	}, false);

	document.getElementById("newGame").onclick = newGame;
}

function beginGame() {
	setCurrentPiece(pieces[count]);
	var available = true;
	//var availableRight = true;
	var i=2;
	y=5;
	var interval = setInterval(function () {
		//alert(i);
		x = i;
		available = checkDraw(currentPiece[0]);
		//availableRight = checkDraw(currentPiece[3]);
		//alert("Available: " + available);
		//alert(i + " " + currentPiece[5][direction][3]);
		loadNext();
		if (available == true) {
			availableCount = 0;
			drawPiece(currentPiece[0]);
			i++; 
			undrawPiece(currentPiece[1]);
		} else { 
			availableCount++;
			x--;
			setOccupied(currentPiece[0]);
			checkRowComplete();
			count = next;
			next = generateRandom();
			setCurrentPiece(pieces[count]);
			i=2;
			y=5;
			direction = 0;}
		if (i + currentPiece[5][direction][3] > 17) {
			setOccupied(currentPiece[0]); 
			checkRowComplete();
			count = next;			
			next = generateRandom(); 
			setCurrentPiece(pieces[count]);
			i=2;
			y=5;
			direction = 0;}
		if (availableCount >= 2) {clearInterval(interval);}
		}, 150);
}

function initialSetup() {
	count = generateRandom();
	next = generateRandom();
	//alert("Got Randoms: " + count + " " + next);
	var c = document.createElement("canvas");
	c.setAttribute('id','nextPiece');
	c.setAttribute('width',100);
	c.setAttribute('height',100);
	c.className = 'nextPiece';
	document.getElementById("next").appendChild(c);
	var ctx=c.getContext('2d');
	var image = new Image();
	image.src = nextImage[count];
	ctx.drawImage(image, 0, 0);
	//alert("drew canvas");
}

function newGame() {
	location.reload();
}

function lineCount() {
	document.getElementById("lines").innerHTML = lines;	
}

function loadNext() { 
	var c = document.getElementById("nextPiece");
	var ctx = c.getContext('2d');
	var image = new Image();
	image.src = nextImage[next];
	ctx.drawImage(image, 0, 0);
}

function setCurrentPiece(piece) {
	switch (piece) {
		case "T": currentPiece = T;
			break;
		case "S": currentPiece = S;
			break;
		case "O": currentPiece = O;
			break;
		case "I": currentPiece = I;
			break;
		case "J": currentPiece = J;
			break;
		case "L": currentPiece = L;
			break;
		case "Z": currentPiece = Z;
			break;
	}
}

function generateRandom() {
	return Math.floor(Math.random()*7);
}

function checkRowComplete() {
	//alert("YOooooooUUUUuuuuuuuuu");
	for (i=0;i<numRows;i++) {
		//alert("for loop: " + i);
		var count = 0;
		for (j=1;j<=numCols;j++) {
			//alert("for loop 2: " + j);
			var id = getID(i, j);
			var c = document.getElementById("id"+id.toString());
			var occupied = c.getAttribute('occupied');
			if (occupied == "true") { 
				count++;
				//alert("count " + count);
			}
		}
		if (count == 10) {
			for (j=1;j<=numCols;j++) {
				//alert("UNDRAW: " + j);
				undraw(i, j);
				setUnoccupied(i, j);
				//shiftRows();
			}
			lines++;
			lineCount();
		}
	}
	//alert("Done");
}

function shiftRows(row) {
	for (i=row-1;i>=0;i--) {
		
	}
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

function setUnoccupied(i, j) {
	var id = getID(i, j);
	var c = document.getElementById("id"+id.toString());
	c.setAttribute('occupied', false);
}

function checkDraw(piece) {
	//Up Down Checking
	for (i=0;i<4;i++) {
		var id = getID(x + piece[direction][1][i], y + piece[direction][2][i]);
		var c = document.getElementById("id"+id.toString());
		var occupied = c.getAttribute('occupied');
		//alert(i + " " + occupied);
		if (occupied == "true") { 
			return false;
			//alert("RETURNNNNNNNNNNNN");
		}
	}
	return true;
}

function checkRight(piece) {
	for (i=0;i<4;i++) {
		//alert(i);
		var id = getID(x + piece[direction][1][i], y + piece[direction][2][i] + 1);
		if (id == NaN) {
			alert("ID = NAN " + x + piece[direction][1][i] + ", " + y + piece[direction][2][i] + 1);
			return false;
		}
		//alert(y + piece[direction][1][i] + 1);
		var c = document.getElementById("id"+id.toString());
		var occupied = c.getAttribute('occupied');
		//alert(i + " " + occupied);
		if (occupied == "true") {
			return false;
		}
	}
	return true;
}

function checkLeft(piece) {
	for (i=0;i<4;i++) {
		//alert(i);
		var id = getID(x + piece[direction][1][i], y + piece[direction][2][i] - 1);
		//alert(y + piece[direction][1][i] + 1);
		if (id == NaN) {
			return false;
		}
		var c = document.getElementById("id"+id.toString());
		var occupied = c.getAttribute('occupied');
		//alert(i + " " + occupied);
		if (occupied == "true") {
			return false;
		}
	}
	return true;
}

function checkRotate(piece, sides) {
	if (direction == 3) {
		var tempDir = 0;
	} else {
		var tempDir = direction + 1;
	}
	for (i=0;i<4;i++) {
		//alert(i);
		var id = getID(x + piece[tempDir][1][i], y + piece[tempDir][2][i]);
		//alert(y + piece[direction][1][i] + 1);
		if (id == NaN) {
			return false;
		}
		var c = document.getElementById("id"+id.toString());
		var occupied = c.getAttribute('occupied');
		//alert(i + " " + occupied);
		if (occupied == "true") {
			return false;
		}
	}
	if (y == 1 && sides[tempDir][0] != 0) {
		return false;
	}
	if (y == 10 && sides[tempDir][1] != 0) {
		return false;
	}
	if (x == 17 && sides[tempDir][3] != 0) {
		return false;
	}

	return true;
}

function draw(row, col) {
	var i = getID(row, col);
	var c = document.getElementById("id"+i.toString());
	var ctx = c.getContext('2d');
	var image = new Image();
	image.src = colors[count];
	ctx.drawImage(image, 0, 0);
}

function undraw(row, col) {
	var i = getID(row, col);
	var c = document.getElementById("id"+i.toString());
	var ctx = c.getContext('2d');
	ctx.clearRect(0, 0, size, size);
	ctx.fillStyle='#FFFFFF';
	ctx.fillRect(0,0,size-3,size);
	c.setAttribute('occupied', false);
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
		if (checkRotate(currentPiece[0], currentPiece[5]) == true) {
			rotatePiece(currentPiece[2], currentPiece[0]);
		}
	} else if (ev.keyCode == KEY.RIGHT) {
		if (checkRight(currentPiece[0]) == true) {
			movePieceRight(currentPiece[5], currentPiece[3], currentPiece[0]);
		}
	} else if (ev.keyCode == KEY.LEFT) {
		if (checkLeft(currentPiece[0]) == true) {
			movePieceLeft(currentPiece[5], currentPiece[4], currentPiece[0]);
		}
	} else if (ev.keyCode == KEY.SPACE) {
		if (active == false) {
			active = true;
			beginGame();
		}
	}
}

