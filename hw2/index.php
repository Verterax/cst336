<?php include 'inc/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Mario 3 Card Game</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
        <audio id="hoverSound"> <source src="audio/select.mp3" type="audio/mpeg"> </audio>
        <audio id="cardFlip"> <source src="audio/flip.mp3" type="audio/mpeg">" </audio>
        <audio id="mismatch"> <source src="audio/mismatch.mp3" type="audio/mpeg">" </audio>
        <audio id="match"> <source src="audio/match.mp3" type="audio/mpeg">" </audio>
        <audio id="oneup"> <source src="audio/oneup.mp3" type="audio/mpeg">" </audio>
        <audio id="win"> <source src="audio/win.mp3" type="audio/mpeg">" </audio>
    </head>
    <!--<body>-->
    <body onload="playMusic()">
        <div id="bg-stripes">
            <!--Music-->
            <!--<audio autoplay loop>-->
            <!--    <source src="audio/songloop2.mp3" type="audio/mpeg">-->
            <!--</audio>-->
            
            <div id="play-space">
                <?php 
                    displayCards(); 
                ?>
            </div>
        </div>
        <img id="play-bar" src="img/bottom_bar.png" alt=""/>
        
        <footer>
            <div>
            <hr>
            CST-336. 2018 &copy; Caldwell <br/>
            <strong>Disclaimer:</strong> The information in this webpage is used for academic purposes only.<br/>
            <img src="img/csumb_logo.png" alt="CSUMB Otter Logo" />
            </div>
        </footer>
    </body>
    

    
    <script>
        var hoverSound = document.getElementById("hoverSound");
        var clickSound = document.getElementById("cardFlip");
        var mismatch = document.getElementById("mismatch");
        var match = document.getElementById("match");
        var oneup = document.getElementById("oneup");
        var win = document.getElementById("win");
        var music = new Audio("audio/songloop2.mp3");
        function playHoverSound() {
            hoverSound.play();
        }
        function playClickSound(tableIndex){
            clickSound.play();
            setTimeout(function() { redirect(tableIndex); }, 450);
        }
        function redirect(tableIndex) {
            if (typeof tableIndex === "undefined")
                window.location.href = 'index.php';
            else
                window.location.href = 'index.php?tableIndex=' + tableIndex;
        }
        function playMismatch() {
            mismatch.play();
            setTimeout(function() { redirect(); }, 800);
        }
        function playMatch(cardName) {
            if (cardName == "oneup")
                oneup.play();
            else
                match.play();
        }
        function playWin() {
            win.play();
            setTimeout(function() { redirect(); }, 4000);
        }
        function playMusic(){
            music.loop = true;
            music.play();
        }
    </script>
</html>