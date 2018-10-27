<?php

    function play() {
        echo "testing";
    }
    
    function cardTest()
    {
        echo "<table>";
        for ($tr = 0; $tr < 3; $tr++)
        {
            echo "<tr>";
            for ($tc = 0; $tc < 6; $tc++)
            {
                echo "<td>";
                echo "<img onmouseover='playHoverSound()' onclick='playClickSound()' class='card cardback' src='img/cardback.png'/>";
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

?>