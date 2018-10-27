<?php include 'inc/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Mario 3 Card Game</title>
        <link rel="stylesheet" href="css/styles.css">
        <audio id="hoverSound"> <source src="audio/select.mp3" type="audio/mpeg"> </audio>
        <audio id="cardFlip"> <source src="audio/flip.mp3" type="audio/mpeg">" </audio>
    </head>
    <body>
        <div id="bg-stripes">
            <!--Music-->
            <audio autoplay loop>
                <source src="audio/songloop2.mp3" type="audio/mpeg">
            </audio>
            
            <div id="play-space">
                <?php cardTest(); ?>
            </div>
        </div>
        <img id="play-bar" src="img/bottom_bar.png" alt=""/>
    </body>
    
    <script>
        var hoverSound = document.getElementById("hoverSound");
        var clickSound = document.getElementById("cardFlip");
        function playHoverSound() {
            hoverSound.play();
        }
        function playClickSound(){
            clickSound.play();
        }
    </script>
    
</html>