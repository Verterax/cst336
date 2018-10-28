<?php
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
    
    function getArgument(){
        $arg = $_GET['tableIndex'];
        if (isset($arg))
        {
            return $arg;
        }
        else
        {
            return null;
        }
            
        
    }
    
    // Check for matches and mismatches
    function mutate(&$cards, $tableIndex)
    {
        // First ensure the card clicked on is negative.
        if ($cards[$tableIndex] > 0)
            return null;
            
        // Make it positive, and mark it x11.
        $cards[$tableIndex] *= -11;
    
        //Return the sound to play, if any.
        for ($i = 0; $i < 18; $i++)
        {
            if ($cards[$i] % 11 == 0 && $i != $tableIndex)
            {
                // Two cards are flipped. Do they match?
                if ($cards[$i] == $cards[$tableIndex])
                {
                    // Match (Set to face value by dividing by 11.)
                    $cardId[$i] /= 11;
                    $cardId[$tableIndex] /= 11;
                    
                    if ($cardId[$i] == 1)
                    {
                        return "oneup";
                    }
                    return "match";
                        
                }
                else // No match.
                {
                    return "mismatch";
                }
            }
        }
        
        return "flip";
    }
    
    function displayCards($showAll) 
    {
        $cards = loadCards();
        $arg = getArgument();
        
        if ($arg != null)
        {
            $result = mutate($cards, $arg);
            if ($result != null)
            {
                saveCards($cards);
            }
        }
        
        $tableIndex = 0;
        echo "<table>";
        for ($tr = 0; $tr < 3; $tr++)
        {
            echo "<tr>";
            for ($tc = 0; $tc < 6; $tc++)
            {
                echo "<td>";
                
                $cardId = $cards[$tableIndex];
                if ($showAll)
                {
                    $cardId = abs($cardId);
                }
                
                $cardName = getCardName($cardId);
                
                if ($cardId < 0)
                {
                    echo "<img onmouseover='playHoverSound()' onclick='playClickSound($tableIndex)' class='card cardback' src='img/cardback.png'/>";
                }
                else
                {
                    echo "<img class='card' src='img/$cardName.png'/>";
                }
                
                $tableIndex++;
                
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
        // Play Result Audio
        // printCards($cards);
        
    }
    
    function loadCards() 
    {
        $cookieName = "Mario3Babyyyyyy!!";
        if(!isset($_COOKIE[$cookieName]))
        {
            return newGame();
        }
        else
        {
            return explode(",", $_COOKIE[$cookieName]);
        }
    }
    
    function saveCards($currentCards)
    {
        $cookieName = "Mario3Babyyyyyy!!";
        $saveCardsCookie = implode(",", $currentCards);
        setcookie($cookieName, $saveCardsCookie, time() + 84600, "/");
    }
    
    function newGame() 
    {
        $cookieName = "Mario3Babyyyyyy!!";
        $cards = initCards();
        $saveCardsCookie = implode(",", $cards);
        setcookie($cookieName, $saveCardsCookie, time() + 84600, "/");
        return $cards;
    }
    
    function initCards() 
    {
        $cards = array(-1,-1,-2,-2,-3,-3,-4,-4,-4,-4,-5,-5,-5,-5,-6,-6,-6,-6);
        for ($i = 0; $i < 1000; $i++)
        {
            $indexA = mt_rand(0,17);
            $indexB = mt_rand(0,17);
            $temp = $cards[$indexA];
            $cards[$indexA] = $cards[$indexB];
            $cards[$indexB] = $temp;
        }
        return $cards;
    }
    
    function getCardName($cardId)
    {
        switch($cardId)
        {
            case 1:
            case 11:
                return "oneup";
            case 2:
            case 22:
                return "coin10";
            case 3:
            case 33:
                return "coin20";
            case 4:
            case 44:
                return "mushroom";
            case 5:
            case 55:
                return "flower";
            case 6:
            case 66:
                return "star";
            default:
                return "cardback";
        }
    }
    
    function printCards($input) {
        print_r($input);
    }
    

?>