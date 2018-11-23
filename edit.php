<!--
This php enables the logon user to edit or delete
a blog from the database.
-->

<?php

    require 'connect.php';

    $productName = filter_input(INPUT_POST, 'productName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $productDesc = filter_input(INPUT_POST, 'productDesc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $productImage = filter_input(INPUT_POST,'productImage',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $queryCategory ="SELECT * FROM category ";
    $result = $db->prepare($queryCategory);
    $result -> execute();

    //$queryImage = "SELECT * FROM productImage ";
    //$image_result = $db->prepare($queryImage);
    //$image_result -> execute();

    if(isset($_GET['productId'])) {

        $productId = filter_input(INPUT_GET, 'productId', FILTER_VALIDATE_INT);

        $query = "SELECT * FROM product WHERE productId = :productId;";
        $statement = $db->prepare($query);
        $bind_values = ['productId' => $productId];
        $statement->execute($bind_values);
        $product = $statement->fetch();

        //print_r($product);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Mali|Shojumaru|Source+Sans+Pro" rel="stylesheet">


</head>
<body>
<div id="wrapper">
        <div id="header">
        <h1><a href="index.php">Panda Bubble Tea</a></h1>
        <img src="images/banner.png" alt="panda" class="center">
    </div> <!-- END div id="header" -->


<ul id="navbar">
            <li><a href="create.php">Product</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="menu.php" class='active'>Menu</a></li>
            <li><a href="reviews.php">Contact Us</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul> <!-- END div id="menu" -->

<div id="editproducts">
      <form id="editproducts" action="post.php" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Edit Product</legend>
          <p>
            <label for="productName">Product Name</label>
            <input name="productName" id="productName" value="<?= $product['productName'] ?>">
          </p>
            <p>
                <label for="productDesc">Product Description</label>
                <input name="productDesc" id="productDesc" value="<?= $product['productDesc'] ?>">
            </p>

            <p>
                <label for="productImage">Product Image</label>
                <?php if($product['productImage']):?>
            <p>Uncheck if you want the image to be deleted and click update.</p>
                    <img src="uploads\<?=$product['productImage']?> "alt="image">
                    <input type="checkbox" name="productImage" id="productImage" <?php if($product['productImage']) echo 'checked="checked"' ?> value="<?= $product['productImage'] ?>">
                <?php else:?>
                <input type="file" name="image" id="image">
                <?php endif?>
            </p>

            <p>
                <label for="category">Category</label>
                <select name="category" id="category">
                    <option value="">Select Category</option>
                    <?php while ($categoriesResult = $result->fetch()): ?>
                        <option value="<?=$categoriesResult['categoryId']?>">
                            <?=$categoriesResult['categoryName']?>
                        </option>
                    <?php endwhile ?>
                </select>
            </p>
          <p>

<!--            <input type="submit" name="command" value="Create">-->
            <input type="hidden" name="productId" value='<?= $product["productId"] ?>'>
            <input type="submit" name="command" value="Update">
            <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you want to delete this from the menu?')">
          </p>
        </fieldset>
      </form>
    </div> <!-- END div id="allproducts" -->
        <div id="footer">
        <img src="images/footerimage.png" alt="panda" class="center">
       1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
    </div> <!-- END div id="footer" -->
</div>
</body>
</html>
