<!--
This 
-->

<?php
  require 'connect.php';

    if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 'Admin')
    {
        header('Location: index.php');
    }

  $query = "SELECT * FROM Product ORDER BY productId";
  // Returns a PDOStatement object.
  $statement = $db->prepare($query);
  // The query is now executed.
  $statement->execute();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Panda Bubble Tea</title>
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
        <li><a href="create.php">Product</a></li>
        <li><a href="category.php" class='active'>Category</a></li>
        <li><a href="menu.php" class='active'>Menu</a></li>
        <li><a href="reviews.php">Contact Us</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->



<fieldset>
    <legend>Menu List</legend>
        <?php while ($product = $statement->fetch()): ?>
            <h2><a href="show.php?productId=<?= $product['productId']?>"><?= $product['productName'] ?></a> </h2>
            <?= substr($product['productDesc'], 0, 200)?>  <strong><a href="edit.php?productId=<?= $product['productId']?>">Edit</a></strong>
            <?php if($product['productImage']):?>
                <p><img src="uploads\<?=$product['productImage']?> "alt="image"></p>
            <?php endif?>
            <p><b>Last Edited</b> <?= date('F d, Y, h:i A',strtotime($product['date']))?> </p>
        <?php endwhile ?>
     </fieldset>


</div>

        <div id="footer">
       1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
    </div> <!-- END div id="footer" -->
</body>
</html>
