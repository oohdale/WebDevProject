<?php

require 'connect.php';

$query = "SELECT * FROM product ORDER BY productName";
$statement = $db->prepare($query);
$statement->execute();

if(isset($_POST['submit']))
{
    header('Location: search.php');
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Panda Tea House</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Mali|Shojumaru|Source+Sans+Pro" rel="stylesheet">
</head>
<body>
<div id="wrapper">

    <form class="searchbar" action="search.php" method="get">
        <input type="text" name="search" />
        <input type="submit" value="Search" />
    </form>

    <div id="header">
        <h1><a href="index.php">Panda Bubble Tea</a></h1>
        <img src="images/banner.png" alt="panda" class="aboutuspic">
    </div> <!-- END div id="header" -->


    <ul id="navbar">
        <li><a href="index.php" class='active'>Home</a></li>
        <li><a href="#aboutus" >About Us</a></li>
        <li><a href="#menu" >Menu</a></li>
        <li><a href="reviews.php">Reviews</a></li>
        <li><a href="login.php" >Log In</a></li>
        <li><a href="register.php" >Register</a></li>
    </ul> <!-- END div id="menu" -->



    <div id="welcome">
        <div id="aboutus"><a href="aboutus"></a><h1>About Us</h1></div>
        <img src="images/drinks.jpg" alt="panda" class="aboutuspic">
        <p>Here at Panda Bubble Tea, we are dedicated to serving you consistent and quality food and beverages. Our drink flavors include matcha, taro, and red bean with toppings such as boba, grass jelly and lychee jelly. Takeout and delivery is available online ordering. We are located at1041 McPhillips Street</p>
            <div id="menu"><a href="aboutus"></a><h1>Menu</h1>
                <form name="sort" action="index.php#menu" method="post">
                    <select name="order">
                        <option value="choose">Sort by</option>
                        <option value="1">Milk Tea</option>
                        <option value="2">Slush</option>
                        <input type="submit" name="search" value="Sort"/>
                    </select>
                </form>
            </div>

        <div id="menulist">
            <?php while ($product = $statement->fetch()): ?>
            <h2><a href="show.php?productId=<?= $product['productId']?>"><?= $product['productName'] ?></a></h2>
        <?php endwhile ?>
    </div>
    </div> <!-- END div id="welcome" -->



    <div id="footer">
       1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
    </div> <!-- END div id="footer" -->
</div> <!-- END div id="wrapper" -->
</body>
</html>
