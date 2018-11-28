<?php

    function getPetList() {
        include 'dbConnection.php';
        $conn = getDatabaseConnection("ottermart");
    
        $sql = "SELECT *
                FROM pets";
    
        $statement = $conn->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        return $records;
    }
?>