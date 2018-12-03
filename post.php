<!--
This php contains all the validation to process data
before it display on the blog.
-->

<?php
    require 'connect.php';

    include 'ImageResize.php';
    use \Gumlet\ImageResize;

    //print_r($_POST);
    $productId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
    $productImage = filter_input(INPUT_POST, 'productImage');
    $postType = filter_input(INPUT_POST, 'command');
    $productName = filter_input(INPUT_POST, 'productName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $productDesc = filter_input(INPUT_POST, 'productDesc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $error="You must fill out the Product Name, Product Description and Select a Category to add a new product on the menu.";

    function file_is_an_image($temporary_path, $new_path)
    {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];

        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];

        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

        return $file_extension_is_valid && $mime_type_is_valid;
    }

    function file_upload_path($original_filename, $upload_subfolder = 'uploads')
    {
        $current_Folder = dirname(__FILE__);
        $path_segments = [$current_Folder, $upload_subfolder, basename($original_filename)];
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }
    if (isset($_FILES['image'])) {

        $image_filename = $_FILES['image']['name'];
        $productImage = $image_filename;
        $temporary_image_path = $_FILES['image']['tmp_name'];

        $new_image_path = file_upload_path($image_filename);
        $file_check = file_is_an_image($temporary_image_path, $new_image_path);

        if ($file_check) {

            move_uploaded_file($temporary_image_path, "uploads/$image_filename");

            $image = new ImageResize("uploads/$image_filename");
            $image->scale(20);
            $image->save("uploads/$image_filename");
        }

    }

    //echo "uploads/".$image_filename;

    if(isset($_POST['Add'])) {

        if((empty($productName)) || (empty($productDesc)) || (empty($category)))
        {
            $error;
        }

        else {
            $query = "INSERT INTO product (productName,productDesc, category, productImage) VALUES (:productName,:productDesc, :category, :productImage)";
            $statement = $db->prepare($query);
            $bind_value = [':productName' => $productName, ':productDesc' => $productDesc, ':category' => $category, ':productImage' => $productImage];
            $statement->execute($bind_value);

            header('Location: menu.php');
        }
    }
    if($postType == 'Update')
    {

        $deleteImageQuery="SELECT productImage FROM product WHERE productId = :productId";
        $deleteImageStatement = $db->prepare($deleteImageQuery);
        $bindDeleteImage = ['productId' => $productId];
        $deleteImageStatement->execute($bindDeleteImage);
        $imageDeleteRow = $deleteImageStatement -> fetch();
        $imageName = $imageDeleteRow['productImage'];
        unlink("uploads/$imageName");

        //change the post in the database
        $query = "UPDATE product SET productName = :productName, productDesc = :productDesc, category = :category, productImage = :productImage WHERE productId = :productId";
        $statement = $db->prepare($query);
        $statement->execute(array(
            ':productName' => $productName,
            ':productDesc' => $productDesc,
            ':category' => $category,
            ':productImage' => $productImage,
            ':productId' => $productId
        ));

       //$test = $productId;


        //header('Location: index.php?id='.$productId);
        header('Location: menu.php');

    }
    if($postType == 'Delete')
    {
        $deleteImageQuery="SELECT productImage FROM product WHERE productId = :productId";
        $deleteImageStatement = $db->prepare($deleteImageQuery);
        $bindDeleteImage = ['productId' => $productId];
        $deleteImageStatement->execute($bindDeleteImage);
        $imageDeleteRow = $deleteImageStatement -> fetch();
        $imageName = $imageDeleteRow['productImage'];
        unlink("uploads/$imageName");

        $query = "DELETE FROM product WHERE productId = :productId";
        $statement = $db->prepare($query);
        $bind_value = ['productId' => $productId];
        $statement->execute($bind_value);

       header('Location: menu.php?id='.$productId);
       //$test = $productId;

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
        <li><a href="moderate.php">Comments</a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->

<div id="postproducts">
      <form action="post.php" method="post">
        <fieldset>
          <p><?= $error ?></p>
        </fieldset>
      </form>
    </div> <!-- END div id="allproducts" -->

        <div id="footer">
       <img src="images/footerimage.png" alt="panda" class="center">
       1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
    </div> <!-- END div id="footer" -->

</body>
</html>