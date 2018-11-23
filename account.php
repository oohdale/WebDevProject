<?php
require 'connect.php';

$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$query = "SELECT * FROM user WHERE username=:username";
$statement = $db->prepare($query);
$statement->bindValue(':username', $username);
$statement->execute();
$row = $statement->fetch();


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
        <li><a href="create.php">Product</a></li>
        <li><a href="category.php">Category</a></li>
        <li><a href="menu.php" >Menu</a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->
    <div id="newcategory">
        <p>Welcome <?=$_SESSION['login_user']?>!</p>

        <?php if ($_SESSION['errormessage'] != 'None') :?>
            <?=$_SESSION['errormessage']?>
        <?php endif ?>

        <?php while ($users = $statement->fetch()): ?>
            <h2><?= $users['userName']?> <?= $users['password'] ?></h2>
        <?php endwhile ?>


    </div>
</div>
<div id="footer">
    1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
</div> <!-- END div id="footer" -->
</body>
</html>
