<!DOCTYPE html>
<html lang="en">
    <head>
        <title> 777 Slot Machine </title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        
        <?php 
            for ($i=0; $i<3; $i++){
                $val = rand(0,2);
                displaySymbol($val);
            }

            
            function displaySymbol($randomValue){
            //     if ($randomValue == 0){
            //         echo '<img src="img/seven.png" alt="seven" title="Seven" width="70 />"<br>';
            //     } else if ($randomValue == 1) {
            //         echo '<img src="img/cherry.png" alt="cherry" title="Cherry" width="70 />"<br>';
            //     } else {
            //         echo '<img src="img/lemon.png" alt="lemon" title="Lemon" width="70 />"<br>' ;
            //     }
                
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
                }
                echo "<img src='img/$symbol.png' alt='$symbol' title='" . ucfirst($symbol). "' width='70' />" ;
                
            }
        ?>
    </body>
</html>