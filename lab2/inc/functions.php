<?php
            
            function play() {
                for ($i=1; $i<4; $i++){
                 ${"randVal" . $i} = rand(0,3);
                    displaySymbol(${"randVal" . $i}, $i);
                }
                displayPoints($randVal1, $randVal2, $randVal3);
            }

            function displaySymbol($randomValue, $pos){
                switch($randomValue){
                    case 0:
                        $symbol = "seven";
                        break;
                    case 1:
                        $symbol = "cherry";
                        break;
                    case 2:
                        $symbol = "lemon";
                        break;
                    case 3:
                        $symbol = "bar";
                }
                echo "<img id='reel$pos'src='img/$symbol.png' alt='$symbol' title='" . ucfirst($symbol). "' width='70' />" ;
            }

            function displayPoints($randVal1, $randVal2, $randVal3){
                echo "<div id='output'>";
                if ($randVal1 == $randVal2 && $randVal2 == $randVal3) {
                    switch ($randVal1){
                        case 0: $totalPoints = 1000;
                            echo "<h1>Jackpot!</h1>";
                            
                            echo "<audio autoplay> <source src='/lab2/audio/winning.mp3' type='audio/mpeg'> </audio>";
                            break;
                        case 1: $totalPoints = 500;
                            break;
                        case 2: $totalPoints = 250;
                            break;
                        case 3: $totalPoints = 900;
                            break;
                    }
                    
                    echo "<h2>You won $totalPoints points!!</h2>";
                } else {
                    echo "<h3>Try Again!</h3>";
                }
                echo "</div>";
            }    
?>