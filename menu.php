<!--
This 
-->

<?php
  require 'connect.php';

    if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 'Admin')
    {
        header('Location: index.php');
    }

$productQuery = "SELECT * FROM Product ORDER BY productName";
$productStatement = $db->prepare($productQuery);
$productStatement->execute();


$categoryId = filter_input(INPUT_POST, 'categoryId',FILTER_VALIDATE_INT);
$categoryName = filter_input(INPUT_POST, 'categoryName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$categoryDesc = filter_input(INPUT_POST, 'categoryDesc',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$query = "SELECT * FROM product";
if($categoryId) :

    $query .= " WHERE category = :categoryId";
endif;

$statement = $db->prepare($query);

if($categoryId) {
    $statement->bindParam(':categoryId', $categoryId);
}

$statement->execute();


$queryCategory ="SELECT * FROM category ";
$result = $db->prepare($queryCategory);
$result -> execute();

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

    <form name="sort" action="menu.php" method="post">
        <select name="categoryId" id="categoryId">
            <option value="">All Categories</option>
            <?php while ($categoriesResult = $result->fetch()): ?>
                <option value="<?= $categoriesResult['categoryId']?>">
                    <?= $categoriesResult['categoryName']?>
                </option>
            <?php endwhile ?>
        </select>
            <input type="submit" name="categories" value="Submit">

    </form>


    <fieldset>
    <legend>Menu List</legend>
        <?php while ($product = $statement->fetch()): ?>
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
