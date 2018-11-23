
<!--This php enables the logon user to show the full blog entry.-->



<?php

require 'connect.php';

$query = "SELECT * FROM Product ORDER BY productId";

$statement = $db->prepare($query);

$statement->execute();

$product = $statement-> fetchAll();

if(isset($_GET['productId'])) {

    $productId = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM Product WHERE productId = :productId;";
    // Returns a PDOStatement object.
    $statement = $db->prepare($query);
    //Bind the values to id.
    $bind_values = ['productId' => $productId];
    //Execute the query.
    $statement->execute($bind_values);

    if($statement->rowCount() <= 0) {
        // No results found.
        header("Location: show.php");

    }
    //Retrieves an array of all the rows
    $product = $statement->fetch();
}
else {
    //Requires a valid id
    header("Location: show.php");
    }
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title><?=  $product['productName'] ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Mali|Shojumaru|Source+Sans+Pro" rel="stylesheet">
</head>
<body>
<div id="wrapper">
    <div id="header">
        <h1><a href="index.php">Panda Bubble Tea</a></h1>
        <img src="images/banner.png" alt="panda" class="aboutuspic">
    </div> <!-- END div id="header" -->

      <ul id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#aboutus" >About Us</a></li>
        <li><a href="index.php#menu"  class='active'>Menu</a></li>
          <li><a href="reviews.php">Contact Us</a></li>
        <li><a href="create.php" >Log In</a></li>
    </ul> <!-- END div id="menu" -->

    <div id="allproducts">
      <div class="productpost">
        <h2><?=  $product['productName'] ?></h2>
        <div class="productdesc">
          <?=  $product['productDesc'] ?>
        </div>
          <?php if($product['productImage']):?>
              <img src="uploads\<?=$product['productImage']?> "alt="image">
          <?php endif?>
      </div>
    </div>
      <div id="footer">
          1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
      </div> <!-- END div id="footer" -->
</div>
</body>
</html>