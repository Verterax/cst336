<?php include 'inc/funcs.php'; 
    
    $qna = loadQNA();
    if (isset($_POST['q0'])) {
        $userResponses = gatherResponses();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Minecraft Block Quiz! </title>
        <meta charset = "utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class ="pane" id="header">
            <a href='index.php'>Minecraft Block Quizlet</a>
        </div>
            <?php displayScore($qna, $userResponses); ?>
        <form id="main" class="pane" method="post">
            <?php displayQuiz($qna, $userResponses); ?>
            <div id="submitButton">
            <input class="btn btn-success btn-submit" type="submit">
            </div>
        </form>
        <div class ="pane "id="footer">
            CST-336. 2018 &copy; Caldwell <br/>
            <strong>Disclaimer:</strong> The content of webpage is used for academic purposes only.<br/>
            <img src="img/csumb_logo.png" alt="CSUMB Otter Logo" />
        </div>
    </body>