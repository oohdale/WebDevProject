
<?php
require 'connect.php';

$categoryId = filter_input(INPUT_POST, 'categoryId',FILTER_VALIDATE_INT);
$categoryName = filter_input(INPUT_POST, 'categoryName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$categoryDesc = filter_input(INPUT_POST, 'categoryDesc',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$query ="SELECT * FROM category ";
$statement = $db->prepare($query);
$statement -> execute();

if(isset($_POST['Add'])) {

    if  ((empty($categoryName)) || (empty($categoryDesc)))
    {
        $error = "You must fill out everything.";
    }

    else {

        $query = "INSERT INTO category (categoryName,categoryDesc) VALUES (:categoryName,:categoryDesc)";
        $statement = $db->prepare($query);
        $bind_value = [':categoryName' => $categoryName, ':categoryDesc' => $categoryDesc ];
        $statement->execute($bind_value);
        header('Location: category.php');
    }

}

if(isset($_POST['Delete']))
{
    $query = "DELETE FROM category WHERE categoryId = :categoryId";
    $statement = $db->prepare($query);
    $bind_value = [':categoryId' => $categoryId];
    $statement->execute($bind_value);
    header('Location: category.php');
}


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
<div id="header">
    <h1><a href="index.php">Panda Bubble Tea</a></h1>
    <img src="images/banner.png" alt="panda" class="center">
</div> <!-- END div id="header" -->

<ul id="navbar">
    <li><a href="create.php">Product</a></li>
    <li><a href="category.php" class='active'>Category</a></li>
    <li><a href="menu.php" >Menu</a></li>
    <li><a href="moderate.php">Comments</a></li>
    <li><a href="index.php">Home</a></li>
    <li><a href="logout.php">Log Out</a></li>
</ul> <!-- END div id="menu" -->

<div id="newcategory">
    <form action="postcategory.php" method="post">
        <fieldset>
            <?php if ((empty($categoryName)) || (empty($categoryDesc))):?>
                <p><?= $error ?></p>
            <?php endif?>

        </fieldset>
    </form>
</div> <!-- END div id="allproducts" -->

<div id="footer">
    <img src="images/footerimage.png" alt="panda" class="center">
    1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
</div> <!-- END div id="footer" -->

</body>
</html>