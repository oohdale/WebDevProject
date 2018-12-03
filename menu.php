<!--
This 
-->

<?php
require 'connect.php';

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 'Admin')
{
    header('Location: index.php');
}

$productName = filter_input(INPUT_POST, 'productName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date = filter_input(INPUT_POST, 'date');

$productQuery = "SELECT * FROM Product";

if(isset($_POST['submit']) && isset($_POST['sort'])) {
    $sort = $_POST['sort'];

    if($sort == 'sortAsc') {
        $productQuery = "SELECT * FROM Product ORDER BY productName ASC";
    }
    else if($sort == 'sortDesc') {
        $productQuery = "SELECT * FROM Product ORDER BY productName DESC";
    }
    else if($sort == 'date') {
        $productQuery = "SELECT * FROM Product ORDER BY date";
    }
}

$productStatement = $db->prepare($productQuery);
$productStatement->execute();


?>

<!DOCTYPE html>
<html lang="en">
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
        <li><a href="moderate.php">Contact Us</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->




    <fieldset>
        <legend>Menu List</legend>

        <form action="#" method="post">
            <select class="custom-select" id="sort" name="sort">
                <option selected>Sort by</option>
                <option value="sortAsc">Name(A-Z)</option>
                <option value="sortDesc">Name (Z-A)</option>
                <option value="date">Date</option>
            </select>
            <input type="submit" class="btn btn-primary" name='submit' value='Submit'>
        </form>

        <?php while ($product = $productStatement->fetch()): ?>
            <h2><a href="show.php?productId=<?= $product['productId']?>"><?= $product['productName'] ?></a> </h2>
            <?= substr($product['productDesc'], 0, 200)?>  <strong><a href="edit.php?productId=<?= $product['productId']?>">Edit</a></strong>
            <?php if($product['productImage']):?>
                <p><img src="uploads/<?=$product['productImage']?>" alt="image"></p>
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
