<?php

    include 'dbConnection.php';
    
    $conn = getDatabaseConnection("ottermart");
    
    
    function displayCategories() {
        global $conn;
        
        $sql = "SELECT catId, catName from om_category ORDER BY catName";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($records); // For checking what is fetched.
        
        foreach($records as $record) {
            echo "<option value='".$record["catId"]."'>".$record["catName"]."</option>";
        }
    }
    
    function displaySearchResults() {
        global $conn;
        
        if (isset($_GET['searchForm'])) {
            echo "<h3>Products Found: </h3>";
            
            //Query below prevents SQL injection style attack?
            $namedParams = array();
            
            $sql = "SELECT * FROM om_product WHERE 1";
            
            // Checks if user typed something for product.
            if (!empty($_GET['product'])) {
                $sql .= " AND (productName LIKE :productName";
                $sql .= " OR productDescription LIKE :productName)";
                $namedParams[":productName"] = "%".$_GET['product'] . "%";
            }
            
            // Checks if user typed something for category
            if (!empty($_GET['category'])) {
                $sql .= " AND catId = :categoryId";
                $namedParams[":categoryId"] = $_GET['category'];
            }
            
            // Checks if user typed something for priceFrom
            if (!empty($_GET['priceFrom'])) {
                $sql .= " AND price >= :priceFrom";
                $namedParams[":priceFrom"] = $_GET['priceFrom'];
            }
            
            // Checks if user typed something for priceTo
            if (!empty($_GET['priceTo'])) {
                $sql .= " AND price <= :priceTo";
                $namedParams[":priceTo"] = $_GET['priceTo'];
            }
            
            if (isset($_GET['orderBy'])) {
                if ($_GET['orderBy'] == "price"){
                    $sql .= " ORDER BY price";
                } else {
                    $sql .= " ORDER BY productName";
                }
            }
            
            
            $stmt = $conn->prepare($sql);
            $stmt->execute($namedParams);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($records as $record) {
                echo "<a href=\"purchaseHistory.php?productId=".$record["productId"]."\"> History </a>";
                echo $record["productName"] . " " . $record["productDescription"] . " $" . $record["price"] . "<br/><br/>";
            }
        }
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>OtterMart Product Search</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div>
            <h1>OtterMart Product Search</h1>
            
            <form>
                Product: <input type="text" name="product"/>
                
                <br/>
                Category:
                    <select name="category">
                        <option value="">Select One</option>
                        <?=displayCategories();?>
                    </select>
                <br/>
                Price: From <input type="text" name="priceFrom" size="7"/>
                       To   <input type="text" name="priceTo" size="7"/>
                <br/>
                Order result by:
                <br/>
                
                <input type="radio" name="orderBy" value="price"/>Price<br>
                <input type="radio" name="orderBy" value="name"/>Name
                
                <br><br>
                <input type="submit" value="Search" name="searchForm"/>
            </form>
            
            <br/>
            
        </div>
        <hr>
        
        <?= displaySearchResults(); ?>
    </body>
</html>