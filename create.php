<!--
This 
-->

<?php
  require 'connect.php';

    if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 'Admin')
    {
        header('Location: index.php');
    }

    $categoryId = filter_input(INPUT_POST, 'categoryId',FILTER_SANITIZE_NUMBER_INT);
    $categoryName = filter_input(INPUT_POST, 'categoryName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoryDesc = filter_input(INPUT_POST, 'categoryDesc',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM category";
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
        <li><a href="menu.php">Menu</a></li>
        <li><a href="category.php">Category</a></li>
        <li><a href="moderate.php">Comments</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->

<div id="createproduct">
    <h1>Welcome to Products!</h1>
      <form action="post.php" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>New Product</legend>
            <p><label for="image">Product Image File</label>
                <input type="file" name="image" id="image">
            </p>
          <p>
            <label for="productName">Product Name</label>
            <input name="productName" id="productName">
          </p>
          <p>
            <label for="productDesc">Product Description</label>
            <input name="productDesc" id="productDesc">
          </p>
          <p>
            <label for="category">Category</label>
            <select name="category" id="category">
                <option value=""></option>
                <?php while ($result = $statement->fetch()): ?>
                    <option value="<?php echo $result['categoryId']?>">
                        <?php echo $result['categoryName']?>
                    </option>
                <?php endwhile ?>
            </select>
          <p>
            <input type="submit" name="Add" value="Add Product">
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
