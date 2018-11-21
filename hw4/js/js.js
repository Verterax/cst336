var killCount = 0;
var gameScreen;
var output;

var bullets;

var ship;
var enemies = new Array();

var gameTimer;

var leftArrowDown = false;
var rightArrowDown = false;

var bg1, bg2;
const BG_SPEED = 4;

const GS_WIDTH = 800;
const GS_HEIGHT = 600;

$(document).keypress(function(e) {
	if (e.charCode == 32)
		fire();
});

$(document).keydown(function(e) {
	if (e.keyCode == 37) leftArrowDown = true;
	if (e.keyCode == 39) rightArrowDown = true;
});


$(document).keyup(function(e) {
	if (e.keyCode == 37) leftArrowDown = false;
	if (e.keyCode == 39) rightArrowDown = false;
});

function init(){
	gameScreen = $("#gameScreen")[0];
	
	//gameScreen = document.getElementById('gameScreen');
	gameScreen.style.width = GS_WIDTH + 'px';
	gameScreen.style.height = GS_HEIGHT + 'px';
	
	bg1 = document.createElement('IMG');
	//bg1 = $.create("IMG");
	
	bg1.src = 'img/bg.jpg';
	bg1.className = 'gameObject';
	bg1.style.width = '800px';
	bg1.style.height = '1422px';
	bg1.style.top = '0px';
	bg1.style.left = '0px';
	gameScreen.appendChild(bg1);
	
	bg2 = document.createElement('IMG');
	bg2.src = 'img/bg.jpg';
	bg2.className = 'gameObject';
	bg2.style.width = '800px';
	bg2.style.height = '1422px';
	bg2.style.left = '0px';
	bg2.style.top = '-1422px';
	//bg2.style.zIndex = -1;
	gameScreen.appendChild(bg2);
	
	bullets = document.createElement('DIV');
	bullets.className = 'gameObject';
	bullets.style.width = gameScreen.style.width;
	bullets.style.height = gameScreen.style.height;
	bullets.style.left = '0px';
	bullets.style.top = '0px';
	gameScreen.appendChild(bullets);

	output = document.getElementById('output');

	ship = document.createElement('IMG');
	ship.src = 'img/ship.gif';
	ship.className = 'gameObject';
	ship.style.width = '68px';
	ship.style.height = '68px';
	ship.style.top = '500px';
	ship.style.left = '366px';
	gameScreen.appendChild(ship);
	
	// Add enemy ships
	for(var i = 0; i< 10;i++) {
		var enemy = new Image();
		enemy.className = 'gameObject';
		enemy.style.width = '64px';
		enemy.style.height = '64px';
		enemy.src = 'img/enemyShip.gif';
		gameScreen.appendChild(enemy);
		placeEnemyShip(enemy);
		enemies[i] = enemy;
	}

	gameTimer = setInterval(gameloop, 50);
}


function gameloop(){
    scrollBG();
	shipMovement();
	moveBullets();
	moveEnemies();
}

function updateKillCount() {
	killCount++;
	$("#killCount").html("KILL COUNT: " + killCount);
}

function hittest(a, b) {
	var aW = parseInt(a.style.width, 10);
	var aH = parseInt(a.style.height, 10);
	// get centerpoint of obj a
	var aX = parseInt(a.style.left, 10) + aW/2;
	var aY = parseInt(a.style.top, 10) + aH/2;
	//get radius of obj a (avg of height and width/2)
	var aR = (aW + aH) / 4;
	
	var bW = parseInt(b.style.width, 10);
	var bH = parseInt(b.style.height, 10);
	// get centerpoint of obj b
	var bX = parseInt(b.style.left, 10) + bW/2;
	var bY = parseInt(b.style.top, 10) + bH/2;
	//get radius of obj b (avg of height and width/2)
	var bR = (bW + bH) / 4;
	
	var minDistance = aR + bR;
	
	var cXs = (aX - bX) * (aX - bX); // change in x squared.
	var cYs = (aY - bY) * (aY - bY); // change in y squared.
	var distance = Math.sqrt(cXs + cYs);
	
	if (distance < minDistance)
		return true;
	else
		return false;
}

function placeEnemyShip(e) {
	e.speed = Math.floor(Math.random() * 10) + 6;
	
	var maxX = GS_WIDTH - parseInt(e.style.width, 10);
	var newX = Math.floor(Math.random() * maxX);
	e.style.left = newX + 'px';
	
	var newY = Math.floor(Math.random()*600) - 1000;
	e.style.top = newY + 'px';
}

function moveEnemies() {
	for (var i=0; i < enemies.length; i++) {
		var newY = parseInt(enemies[i].style.top, 10);
		if (newY > GS_HEIGHT)
			placeEnemyShip(enemies[i]);
		else
			enemies[i].style.top = newY + enemies[i].speed + 'px';
			
		if (hittest(enemies[i], ship)) {
			explode(ship);
			explode(enemies[i]);
			ship.style.top = '-10000px';
			placeEnemyShip(enemies[i]);
			gameOver();
		}
	}
}

function gameOver() {
	$(".playAgain").append("<button class='center-block btn btn-warning' type='button' onclick='location.reload();'>PLAY AGAIN</button>")
}

function explode(obj) {
	var explosion = document.createElement('IMG');
	explosion.src = 'img/explosion.gif?x=' + Date.now();
	explosion.className = 'gameObject';
	explosion.style.width = obj.style.width;
	explosion.style.height = obj.style.height;
	explosion.style.left = obj.style.left;
	explosion.style.top = obj.style.top;
	gameScreen.appendChild(explosion);
}

function shipMovement() {
	if(leftArrowDown){
	    
		var newX = parseInt(ship.style.left);
		
		if(newX > 0) 
		    ship.style.left = newX - 20 + 'px';
		else 
		    ship.style.left = '0px';
	}

	if(rightArrowDown){
	    
		var newX = parseInt(ship.style.left);
		var maxX = GS_WIDTH - parseInt(ship.style.width);
		
		if(newX <  maxX) 
		    ship.style.left = newX + 20 + 'px';
		else 
		ship.style.left = maxX + 'px';
	}
}

function scrollBG() {
    
    var bgY = parseInt(bg1.style.top) + BG_SPEED;
    if (bgY > GS_HEIGHT) {
        bg1.style.top = -1 * parseInt(bg1.style.height) + 'px';
    } else {
        bg1.style.top = bgY + 'px';
    }
    
    bgY = parseInt(bg2.style.top) + BG_SPEED;
    if (bgY > GS_HEIGHT) {
        bg2.style.top = -1 * parseInt(bg2.style.height) + 'px';
    } else {
        bg2.style.top = bgY + 'px';
    }
}

function moveBullets() {
	var b = bullets.children;
	for(var i = 0; i < b.length; i++) {
		var newY = parseInt(b[i].style.top, 10) - b[i].speed;
		if (newY < 0) 
			bullets.removeChild(b[i]);
		else
			b[i].style.top = newY + 'px';
			for(var j=0; j<enemies.length; j++) {
				if(hittest(b[i], enemies[j])) {
					updateKillCount();
					bullets.removeChild(b[i]);
					explode(enemies[j]);
					placeEnemyShip(enemies[j]);
					break;
				}
			}
	}
	output.innerHTML = b.length;
}

function fire() {
    
    var bulletWidth = 4;
    var bulletHeight = 10;
    var bullet = document.createElement('DIV');
    bullet.className = 'gameObject';
    bullet.style.backgroundColor = 'yellow';
    bullet.style.width = bulletWidth + 'px';
    bullet.style.height = bulletHeight + 'px';
    bullet.speed = 20;
    bullet.style.top = (parseInt(ship.style.top, 10) - bulletHeight) + 'px';
    var shipX = parseInt(ship.style.left, 10) + parseInt(ship.style.width, 10)/2;
    bullet.style.left = (shipX - bulletWidth/2) + 'px';
    bullets.appendChild(bullet);
    console.log("YES");
}

