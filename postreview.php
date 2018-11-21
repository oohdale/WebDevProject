<!--
This php contains all the validation to process data
before it display on the blog.
-->

<?php
require 'connect.php';

$fullname = filter_input(INPUT_POST, 'fullname',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
$comment = filter_input(INPUT_POST, 'comment',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$postType = filter_input(INPUT_POST, 'command');
$reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_VALIDATE_INT);


if(isset($_POST['Add'])) {

    if  ((empty($fullname)) || (empty($email)) || (empty($comment)))
    {
        $error = "You must fill out everything.";
    }

    else {
        $query = "INSERT INTO review (fullname,email,comment,date) VALUES (:fullname,:email,:comment,:date)";
        $statement = $db->prepare($query);
        $bind_value = [':fullname' => $fullname, ':email' => $email , ':comment' => $comment];
        $statement->execute($bind_value);

        header('Location: reviews.php');

    }

}

if($postType == 'Update')
{
    //change the post in the database
    $query = "UPDATE review SET fullname = :fullname, email = :email, comment = :comment, date = :date WHERE reviewId = :reviewId";
    $statement = $db->prepare($query);
    $statement->execute(array(
        ':fullname' => $fullname,
        ':email' => $email,
        ':comment' => $comment,
        ':date' => $date
    ));


    header('Location: reviews.php?id='.$productId);
    exit();
}
if($postType == 'Delete')
{
    $query = "DELETE FROM review WHERE reviewId = :reviewId";
    $statement = $db->prepare($query);
    $bind_value = ['reviewId' => $reviewId];
    $statement->execute($bind_value);
    header('Location: reviews.php');
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

<div id="postreviews">
    <form action="postreview.php" method="post">
        <fieldset>
            <?php if ((empty( $fullname)) || (empty($email) || (empty($comment)))):?>
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