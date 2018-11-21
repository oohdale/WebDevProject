<!--
This php contains all the validation to process data
before it display on the blog.
-->

<?php
    require 'connect.php';

    $productId = filter_input(INPUT_POST, 'categoryId', FILTER_VALIDATE_INT);
    $postType = filter_input(INPUT_POST, 'command');
    $productName = filter_input(INPUT_POST, 'productName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $productDesc = filter_input(INPUT_POST, 'productDesc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



    if(isset($_POST['Add'])) {

        if  ((empty($productName)) || (empty($productDesc)))
        {
            $error = "You must fill out everything.";
        }

        else {
            $query = "INSERT INTO product (productName,productDesc, category) VALUES (:productName,:productDesc, :category)";
            $statement = $db->prepare($query);
            $bind_value = [':productName' => $productName, ':productDesc' => $productDesc , ':category' => $category];
            $statement->execute($bind_value);

            header('Location: index.php');
            exit();
        }

    }

    if($postType == 'Update')
    {
        //change the post in the database
        $query = "UPDATE product SET productName = :productName, productDesc = :productDesc, category = :category, date = :date WHERE productId = :productId";
        $statement = $db->prepare($query);
        $statement->execute(array(
            ':productName' => $productName,
            ':productDesc' => $productDesc,
            ':category' => $category,
            ':date' => $date,
            ':productId' => $productId
        ));


        header('Location: index.php?id='.$productId);
        exit();
    }
    if($postType == 'Delete')
    {
        $query = "DELETE FROM product WHERE productId = :productId";
        $statement = $db->prepare($query);
        $bind_value = ['productId' => $productId];
        $statement->execute($bind_value);
        header('Location: index.php');
        exit();
    }


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
    <div id="header">
        <h1><a href="index.php">Panda Bubble Tea</a></h1>
        <img src="images/banner.png" alt="panda" class="center">
    </div> <!-- END div id="header" -->

    <ul id="navbar">
        <li><a href="create.php" class='active'>Product</a></li>
        <li><a href="category.php">Category</a></li>
        <li><a href="menu.php" >Menu</a></li>
        <li><a href="reviews.php">Reviews</a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->

<div id="postproducts">
      <form action="post.php" method="post">
        <fieldset>
       <?php if ((empty( $productName)) || (empty($productDesc) || (empty($category)))):?>
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