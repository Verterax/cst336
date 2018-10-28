<?php
    
    function newGame() 
    {
        $cookieName = "Mario3Babyyyyyy!!";
        $cards = initCards();
        $saveCardsCookie = implode(",", $cards);
        setcookie($cookieName, $saveCardsCookie, time() + 84600, "/");
        return $cards;
    }
    
    function loadCards() 
    {
        $cookieName = "Mario3Babyyyyyy!!";
        if(!isset($_COOKIE[$cookieName]))
            return newGame();
        else
            return explode(",", $_COOKIE[$cookieName]);
    }
    
    function saveCards($currentCards)
    {
        $cookieName = "Mario3Babyyyyyy!!";
        $saveCardsCookie = implode(",", $currentCards);
        setcookie($cookieName, $saveCardsCookie, time() + 84600, "/");
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
    
    // Check for matches and mismatches
    function mutate(&$cards, $tableIndex)
    {
        // First ensure the card clicked on is negative.
        if ($cards[$tableIndex] > 0)
            return null;
            
        // Make it positive, and mark it times neg 11.
        // It was neg, neg x neg = pos N*11.
        // It has been marked to either be a match, or a mismatch
        $cards[$tableIndex] *= -11;
    }
    
    function forceWin(&$cards){
        for ($i = 0; $i < 18; $i++)
        {
            if ($cards[$i] < 0)
                $cards[$i] *= -1;
            if ($cards[$i] % 11 == 0)
                $cards[$i] /= 11;
        }
    }
    
    function displayCards() 
    {
        //newgame();
        $cards = loadCards();
        $arg = getArgument();

        if ($arg != null)
        {
            mutate($cards, $arg);
        }
        
        //forceWin($cards);
        
        $tableIndex = 0;
        echo "<table>";
        for ($tr = 0; $tr < 3; $tr++)
        {
            echo "<tr>";
            for ($tc = 0; $tc < 6; $tc++)
            {
                echo "<td>";
                
                $cardId = $cards[$tableIndex];
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
        
        // Execute post results.
        // Play Result Audio
        $match = checkMatch($cards);
        if($match < 0)
        {
            echo "<script>window.onload = function(){playMismatch();};</script>";
            flipBack($cards);
            saveCards($cards);
        }
        elseif ($match > 0)
        {
            // Match
            $matchCode = getMatchCode($cards);
            echo "<script>window.onload = function(){playMatch('$matchCode');};</script>";
            keepFlipped($cards);
            saveCards($cards);
        }
        else // Do nothing, just one card is flipped.
        {
            saveCards($cards);
        }

        if (didWin($cards))
        {
            echo "<script>window.onload = function(){playWin();};</script>";
            newgame();
        }
    }
    
    function getArgument(){
        $arg = $_GET['tableIndex'];
        if (isset($arg))
            return $arg;
        else
            return null;
    }
    
    //Flip back over mismatched cards
    function flipBack(&$cards)
    {
        for ($i = 0; $i < 18; $i++)
            if ($cards[$i] % 11 == 0)
                $cards[$i] /= -11;
    }
    
    function keepFlipped(&$cards)
    {
        for ($i = 0; $i < 18; $i++)
            if ($cards[$i] % 11 == 0)
                $cards[$i] /= 11;
    }
    
    function getMatchCode($cards)
    {
        for ($i = 0; $i < 18; $i++)
            if($cards[$i] % 11 == 0)
                return getCardName($cards[$i]);

        return null;
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
    
    function checkMatch($cards)
    {
        $count = 0;
        $compareCards = array();
        for ($i = 0; $i < 18; $i++)
        {
            if ($cards[$i] % 11 == 0)
            {
                array_push($compareCards, $cards[$i]);
                $count = count($compareCards);
            }
        }
        
        if ($count == 2 && $compareCards[0] == $compareCards[1])
            return 1;
        elseif ($count >= 2)
            return -1;
        else
            return 0;
    }
    
    function didWin($cards)
    {
        for ($i = 0; $i < 18; $i++)
            if ($cards[$i] < 0)
                return false;
        
        return true;
    }

?>