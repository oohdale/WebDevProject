<?php

require 'connect.php';

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 'Admin')
{
    header('Location: contactus.php');
}

$commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, 'name',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
$comment = filter_input(INPUT_POST, 'comment',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$postType = filter_input(INPUT_POST, 'command');

//$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$commentQuery = "SELECT * FROM comments ORDER BY date DESC";
$commentStatement = $db->prepare($commentQuery);
$commentStatement -> execute();

if($postType == 'Delete')
{
    $deleteQuery = "DELETE FROM comments WHERE commentId = :commentId";
    $deleteStatement = $db->prepare($deleteQuery);
    $bind_value = ['commentId' => $commentId];
    $deleteStatement->execute($bind_value);

    header('Location: moderate.php');
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
        <li><a href="index.php#aboutus" >About Us</a></li>
        <li><a href="index.php#menu" >Menu</a></li>
        <li><a href="contactus.php">Contact Us</a></li>
        <li><a href="login.php" >Log In</a></li>
        <li><a href="register.php" >Register</a></li>
    </ul> <!-- END div id="menu" -->



    <div id="reviews">
        <form action="moderate.php" method="post" role="form">
            <fieldset>
                <legend>Comments</legend>
                <?php while ($row = $commentStatement->fetch()): ?>
                    <p><strong>Name:</strong> <?= $row['name']?></p>
                    <p><strong>Date:</strong> <?= $row['date'] ?></p>
                    <p><strong>Email:</strong> <?= $row['email'] ?></p>
                    <p><strong>Comment:</strong> <?= $row['comment'] ?></p>
                <p>
                    <input type="hidden" name="commentId" value="<?= $row['commentId']?>" />
                    <input type="submit" name="command" value="Delete">
                </p>

                <?php endwhile ?>
            </fieldset>
        </form>
    </div>

</div> <!-- END div id="welcome" -->

<div id="footer">
    1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
</div> <!-- END div id="footer" -->
</div> <!-- END div id="wrapper" -->
</body>
</html>
