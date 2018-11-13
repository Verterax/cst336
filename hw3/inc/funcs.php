<?php

    $nSets = 2;
    
    function gatherResponses() {
        global $nSets;
        $responses = array();
        $maxID = $nSets * 11;
        for ($qID = 0; $qID < $maxID; $qID++) {
            if (isset($_POST['q'.$qID])) {
                $responses['q'.$qID] = $_POST['q'.$qID];
            }
        }
        return $responses;
    }
    
    function displayScore($qna, $responses) 
    {
        global $nSets;
        if (!isset($responses))
            return;
        
        $score = calcScore($qna, $responses);
        if ($score < 0)
            return;
        
        $scoreMax = $nSets * 3;
        $percentage = $score / $scoreMax;
        
        if ($percentage == 1.0) {
            $msg = "You made a perfect score!\n Way to go, Minecraft Steve!!";
            $color = "best"; 
        }
        elseif ($percentage >= 0.6) {
            $msg = "Grats! You scored ".$score." / ".$scoreMax."! Can you do better?";
            $color = "better"; 
        }
        else {
            $msg = "You scored ".$score."/".$scoreMax.". Try inspecting the source code to help you cheat and score higher!";
            $color = "bad"; 
        }
        
        echo "<div id='score' class='pane ".$color."'>".PHP_EOL;
        echo "<h1>".$msg."</h2>".PHP_EOL;
        echo "<a href ='index.php'><button class='btn btn-success'>Try Again</button></a>".PHP_EOL;
        echo "</div>".PHP_EOL;
    }

    function displayQuiz($qna, $responses) {
        global $nSets;
        echo "<br>";
        $quizIndex = 0;
        
        if (isset($responses)) {
            $score = calcScore($qna, $responses);
            
            if ($score > -1)
                newGame();
        }
        
        
        for ($setId = 0; $setId < $nSets; $setId++) {
            displayTextQuestion($qna, $quizIndex, $responses);
            displayListQuestion($qna, $quizIndex, $responses);
            displayRadioQuestion($qna, $quizIndex, $responses);
        }
    }

    
    function calcScore($qna, $responses)
    {
        global $nSets;
        $nMax = $nSets * 11;
        $lookAhead = 1;
        $score = 0;
        
        
        for ($i=0; $i < $nMax; $i++) {
            $qID = 'q'.$i;
            if (isset($responses[$qID]))
            {
                $userInput = strtolower($responses[$qID]);
                
                if ($lookAhead == 1)
                    $correctAnswer = explode(" ", $qna[$i])[0];
                elseif ($lookAhead == 2)
                    $correctAnswer = explode(" ", $qna[$i+4])[0];
                else {
                    $correctAnswer = explode(" ", $qna[$i+4])[0];
                    $lookAhead = 0;
                }
                 
                $lookAhead++;
                
                if (empty($userInput))
                    return -1;
                if (strpos($userInput, $correctAnswer) > -1)
                    $score++;
                    
                
            }
        }
        
        return $score;
    }
    
    function displayTextQuestion($qna, &$quizIndex, $responses) {
        $qID = "q".$quizIndex;
        if (isset($responses))  {
            $userInput = strtolower($responses[$qID]);
        }
        
        echo "<div class='question'>".PHP_EOL;
        echo "<label for='".$qID."'>".PHP_EOL;
        echo "Please type the name of this block.<br>".PHP_EOL;
        echo "<img class='blockImg' src='img/blocks/" . $qna[$quizIndex].".png'><br>".PHP_EOL;;
        echo "<input id='".$qID."'type='text' name='".$qID."' value='".$userInput."'><br>".PHP_EOL;
        
        
        if (isset($responses))
        {
            if (isset($responses[$qID]) && !empty($responses[$qID])) {
                $correctAnswer = explode(" ", $qna[$quizIndex])[0];
                if (strpos($userInput, $correctAnswer) > -1) {
                    echo "<img class='textImg' src='img/chk.png'>".PHP_EOL;
                } else {
                    echo "<img class='textImg' src='img/x.png'>".PHP_EOL;
                }
            } else {
                echo "<h1 class='bad'>ANSWER NOT MARKED</h1>";
            }
        }
        
        echo "</label>".PHP_EOL;
        echo "</div>".PHP_EOL;
        echo "<br><hr>".PHP_EOL;
        $quizIndex++;
    }
    
    function displayListQuestion($qna, &$quizIndex, $responses) {
        $qID = "q".$quizIndex;
        if (isset($responses))  {
            $userInput = strtolower($responses[$qID]);
        }
        
        echo "<div class='question'>".PHP_EOL;
        echo "Select the correct name of this block.<br>".PHP_EOL;
        echo "<label for='".$qID."'>".PHP_EOL;
        echo "<img class='blockImg' src='img/blocks/" . $qna[$quizIndex+4].".png'><br>".PHP_EOL;
        echo "<select id='".$qID."'name='".$qID."'>".PHP_EOL;
        echo "<option value=''>".PHP_EOL; // Empty starting position.
        for($itemN = $quizIndex; $itemN < $quizIndex+4; $itemN++) {
            if ($userInput == $qna[$itemN])
                echo "<option value='".$qna[$itemN]."' selected>".ucfirst($qna[$itemN])."</option>".PHP_EOL;
            else
                echo "<option value='".$qna[$itemN]."'>".ucfirst($qna[$itemN])."</option>".PHP_EOL;
        }
        echo "</select><br>".PHP_EOL;
        
        if (isset($responses))
        {
            if (isset($responses[$qID]) && !empty($responses[$qID])) {
                $correctAnswer = explode(" ", $qna[$quizIndex+4])[0];
                if (strpos($userInput, $correctAnswer) > -1) {
                    echo "<img class='textImg' src='img/chk.png'>".PHP_EOL;
                } else {
                    echo "<img class='textImg' src='img/x.png'>".PHP_EOL;
                }
            } else {
                echo "<h1>ANSWER NOT MARKED</h1>";
            }
        }
        
        echo "</label>".PHP_EOL;
        echo "</div>".PHP_EOL;
        echo "<hr>".PHP_EOL;
        $quizIndex+=5;
    }
    
    function displayRadioQuestion($qna, &$quizIndex, $responses) {
        $qID = "q".$quizIndex;
        if (isset($responses))  {
            $userInput = strtolower($responses[$qID]);
        }
        
        echo "<div class='question'>".PHP_EOL;
        echo "Select which of these is the <span class='highlight'>".ucfirst($qna[$quizIndex+4])."</span> block.<br>".PHP_EOL;
        for($itemN = $quizIndex; $itemN < $quizIndex+4; $itemN++) {
            echo "<span class='radioItem'>".PHP_EOL;
            echo "<label for='rad".$itemN."'>".PHP_EOL;
            echo "<img class='blockImg radioItem' src='img/blocks/" . $qna[$itemN].".png'>".PHP_EOL;
            echo "<br>".PHP_EOL;
            
            if ($userInput == $qna[$itemN])
                echo "<input id='rad".$itemN."' class='radioButton' checked='checked' type='radio' name='".$qID."' value='".$qna[$itemN]."'>".PHP_EOL;
            else
                echo "<input id='rad".$itemN."' class='radioButton' type='radio' name='".$qID."' value='".$qna[$itemN]."'>".PHP_EOL;
            echo "</label>".PHP_EOL;
            echo "</span>".PHP_EOL;
        }
        
        if (isset($responses))
        {
            if (isset($responses[$qID]) && !empty($responses[$qID])) {
                echo "<br>".PHP_EOL;
                $correctAnswer = explode(" ", $qna[$quizIndex+4])[0];
                if (strpos($userInput, $correctAnswer) > -1) {
                    echo "<img class='textImg' src='img/chk.png'>".PHP_EOL;
                } else {
                    echo "<img class='textImg' src='img/x.png'>".PHP_EOL;
                }
            } else {
                echo "<h1>ANSWER NOT MARKED</h1>";
            }
        }
        
        echo "</div>".PHP_EOL;
        echo "<hr>".PHP_EOL;
        $quizIndex+=5;
    }

    
    function initQNA() {
        global $nSets;
        $names = getNames();
        $namesCount = count($names) - 1;
        $qna = array();

        $bottomIndex = 0;
        for ($i = 0; $i < $nSets; $i++)
        {
            // Add text question
            array_push($qna, $names[$bottomIndex]);
            $bottomIndex+=1;
            
            for ($rd = 0; $rd < 2; $rd++)
            {
                // Add radio and dropdown questions
                for($k = 0; $k < 4; $k++)
                {
                    array_push($qna, $names[$bottomIndex]);
                    $bottomIndex++;
                }
            
                // Add dropdown answer
                array_push($qna, $qna[rand($bottomIndex-4,$bottomIndex-1)]);
                $bottomIndex++;
            }
        }
        
        return $qna;
    }
    
    function newGame() 
    {
        $cookieName = "MinecraftQuiz";
        $qna = initQNA();
        $saveQuizCookie = implode(",", $qna);
        setcookie($cookieName, $saveQuizCookie, time() + 84600, "/");
        return $qna;
    }
    
    function loadQNA() 
    {
        $cookieName = "MinecraftQuiz";
        if(!isset($_COOKIE[$cookieName]))
            return newGame();
        else
            return explode(",", $_COOKIE[$cookieName]);
    }
    
    function saveQNA($qna)
    {
        $cookieName = "MinecraftQuiz";
        $saveQNACookie = implode(",", $qna);
        setcookie($cookieName, $saveQNACookie, time() + 84600, "/");
    }
    
    function getNames()
    {
        $namesArr = array("bookshelf","brick","cactus","cobblestone","crafting table","dirt",
            "glass","glowstone","gold","grass","gravel","iron","lapis lazuli","netherrack",
            "obsidian","oven","redstone","sand","plank","wood","wool");
            $count = count($namesArr) - 1;
            
        for($i = 0; $i < 1001; $i++)
        {
            $indexA = rand(0, $count);
            $indexB = rand(0, $count);
            
            if ($indexA == 21 || $indexB == 21)
                echo "<h1>WTF</h1>";
            
            $temp = $namesArr[$indexA];
            $namesArr[$indexA] = $namesArr[$indexB];
            $namesArr[$indexB] = $temp;
        }
        
        return $namesArr;
    }
    

?>