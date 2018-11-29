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

//$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$commentQuery = "SELECT * FROM comments";
$statement = $db->prepare($commentQuery);
$statement -> execute();

if(isset($_POST['Add'])) {

    if((empty($name)) || (empty($email)) || (empty($comment)))
    {
        $error = "You must fill out everything.";
    }

    else {
        $query = "INSERT INTO comments (name, email, comment) VALUES (:name,:email, :comment)";
        $statement = $db->prepare($query);
        $bind_value = [':name' => $name, ':email' => $email, ':comment' => $comment];
        $statement->execute($bind_value);

        header('Location: contactus.php');
    }
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
        <form action="contactus.php" method="post" role="form">
            <fieldset>
                <legend>Contact Us</legend>
                <p>
                    <label for="name">Name</label>
                    <input name="name" id="name">
                    <label for="email">Email</label>
                    <input name="email" id="email">
                </p>
                <p>
                    <label for="comment">Comments</label>
                    <textarea name ="comment" rows="4" cols="50"></textarea>
                </p>
                <p>
                    <input type="submit" name="Add" value="Send">
                </p>
            </fieldset>
            <fieldset>
                <legend>Comments</legend>
                <?php while ($row = $statement->fetch()): ?>
                    <p><strong>Name:</strong> <?= $row['name']?></p>
                    <p><strong>Email:</strong> <?= $row['email'] ?></p>
                    <p><strong>Comment:</strong> <?= $row['comment'] ?></p>
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
