<?php
    include 'inc/phpFuncs.php';
    include 'inc/header.php';
    
    $petList = getPetList();
?>
        
        <!--Add carousel component-->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!--Indicators Here-->
            <ol class="carousel-indicators">
                <?php
                for ($i = 0 ; $i < count($petList); $i++) {
                    echo "<li data-target='#carousel-example-generic' data-slide-to='$i'";
                    echo ($i==0)? " class='active'":"";
                    echo "></li>";
                }
                ?>
            </ol>
            
            <div class="carousel-inner" role="listbox">
                <?php
                        for ($i=0; $i < count($petList); $i++) {
                            echo '<div class="carousel-item ';
                            echo ($i == 0)?"active": "";
                            echo '">';
                            echo '<img src="img/' . $petList[$i]['pictureURL'] .'">';
                            echo '</div>';
                        }
                  ?>
            </div>
        </div>
        
        <!--<a class="left carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">-->
        <a class="left carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <!--<a class="right carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">-->
        <a class="right carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        
        
        <br><br>
        <a class="btn btn-outline-primary" href="pets.php" role="button">Adopt Now!</a>
        <br><br>
        <hr>
        
<?php
    include 'inc/footer.php';
?>