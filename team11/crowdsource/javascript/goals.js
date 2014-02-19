

windows.onload = function() {
	var c = document.createElement("canvas");
	c.setAttribute('id', 'id'+1);
	c.setAttribute('width', 200);
	c.setAttribute('height', 200);
	c.className = i;
	document.getElementById("panel_td1").appendChild(c);

	var ctx = c.getContext('2d');
	ctx.fillStyle='#FFFFFF';
	ctx.fillRect(0, 0, 200, 200);	
}
