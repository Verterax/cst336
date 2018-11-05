<?php
    $backgroundImage = "img/sea.jpg";
    include 'api/pixabayAPI.php';
    
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $imageURLs = getImageURLS($keyword, $_GET['layout']);
        $backgroundImage = $imageURLs[array_rand($imageURLs)];
    }
    elseif (isset($_GET['catagory']) && !empty($_GET['catagory']))
    {
        $catagory = $_GET['catagory'];
        $imageURLs = getImageURLS($catagory, $_GET['layout']);
        $backgroundImage = $imageURLs[array_rand($imageURLs)];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Image Carousel</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            @import url("css/styles.css");
            body {
                background-image: url('<?=$backgroundImage ?>');
            }
            
            h3 {
                color: blue;
                font-size: 24px;
                background-color: white;
                margin: 0 auto;
                margin-bottom: 20px;
                width: 50%;
                border: 3px solid blue;
            }
            .btn {
                margin-top: 40px;
            }
        </style>
    </head>
    
    <body>
        <br/><br/>
        <?php
            if (isset($imageURLs) && empty($_GET['keyword']) && empty($_GET['catagory']))
            {
                echo "<h3>Please enter a keyword or select a catagory.</h3>";
                echo '<a href="index.php"><button class="btn btn-danger">Go Back</button></a>';
            }
            elseif (!isset($imageURLs)) {
                
                echo "<h3> Type a keyword to display a slideshow <br/> with random images from Pixabay.com </h3>";
                ?>
                
                <!--HTML GOES HERE-->
                <form method="GET">
                    <input type="text" name="keyword" placeholder="Keyword" value=""/>
                    <input type="radio" name="layout" value="horizontal" id="hlayout" >
                    <label for="hlayout"> Horizontal </label>
                    
                    <input type="radio" name="layout" value="vertical" id="vlayout" >
                    <label for="vlayout"> Vertical </label>
            
                    <select name="catagory">
                        <option value ="">Select One</option>
                        <option value="sea">Sea</option>
                        <option value="forest">Forest</option>
                        <option value="mountain">Mountain</option>
                        <option value="snow">Snow</option>
                    </select>
                    <input type="submit" value="Search"/>
                </form>
               
                <?php
            } 
            else {
                 // Display Carousel Here
                 
                if (isset($keyword) && !empty($keyword))
                    echo "<h3>You searched: " . $keyword . "</h3>";
                else
                    echo "<h3>You searched: " . $catagory . "</h3>";
                 
            ?>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!--Indicators Here-->
                <ol class="carousel-indicators">
                    <?php
                    for ($i =0; $i < 7; $i++) {
                        echo "<li data-target='#carousel-example-generic' data-slide-to='$i'";
                        echo ($i==0)? " class='active'":"";
                        echo "></li>";
                    }
                    ?>
                </ol>
                
                <!--Wrapper for Images-->
                <div class="carousel-inner" role="listbox">
                    <?php
                        for ($i=0; $i < 7; $i++) {
                            do {
                                $randomIndex = rand(0, count($imageURLs));
                            }
                            while (!isset($imageURLs[$randomIndex]));
                        
                            echo '<div class="carousel-item ';
                            echo ($i == 0)?"active": "";
                            echo '">';
                            echo '<img src="' . $imageURLs[$randomIndex] . '">';
                            echo '</div>';
                            unset($imageURLs[$randomIndex]);
                        }
                  ?>
                </div>
                
                <!--Controls here-->
                <a class="left carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                
                <a href="index.php"><button class="btn btn-danger">Go Back</button></a>
            </div>
  
            <?php
                } // End of else statement
            ?>
            <br/>
            
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>