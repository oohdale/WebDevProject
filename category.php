
<?php
require 'connect.php';

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 'Admin')
{
    header('Location: index.php');
}

 $categoryId = filter_input(INPUT_POST, 'categoryId',FILTER_VALIDATE_INT);
 $categoryName = filter_input(INPUT_POST, 'categoryName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 $categoryDesc = filter_input(INPUT_POST, 'categoryDesc',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

 $query ="SELECT * FROM category ";
 $statement = $db->prepare($query);
 $statement -> execute();

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
        <li><a href="create.php" class='active'>Product</a></li>
        <li><a href="category.php">Category</a></li>
        <li><a href="menu.php" >Menu</a></li>
        <li><a href="reviews.php">Contact Us</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->

    <div id="newcategory">
        <h1>Welcome to Categories!</h1>
        <form action="postcategory.php" method="post">
            <fieldset>
                <legend>New Category</legend>
                <p>
                    <label for="categoryName">Category Name</label>
                    <input name="categoryName" id="categoryName">
                </p>
                <p>
                    <label for="categoryDesc">Category Description</label>
                    <input name="categoryDesc" id="categoryDesc">
                </p>
                    <input type="submit" name="Add" value="Add New Category">
            </fieldset>
            <fieldset>
                <legend>Delete Category</legend>
                <label for="category">Category</label>
                <select name="categoryId" id="categoryId">

                        <?php while ($result = $statement->fetch()): ?>
                            <option value="<?= $result['categoryId']?>">
                                <?= $result['categoryName']?>
                            </option>
                        <?php endwhile ?>

                </select>
                <p>
                    <input type="submit" name="Delete" value="Delete Category">
                </p>
            </fieldset>
        </form>

    </div> <!-- END div id="createproduct" -->

    <div id="footer">
        1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
    </div> <!-- END div id="footer" -->
</div>
</body>
</html>
