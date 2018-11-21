<?php

    require 'connect.php';
    if (!isset($_SESSION['errormessage'])){
        $_SESSION['errormessage'] = 'None';
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
<a href="index.php">Panda Bubble Tea</a>
<?php if (isset($_SESSION['login_user'])) :?>
    <h2>You're still signed in!</h2>
    <a href="create.php">Home</a>
    <h2><a href="logout.php">Click here to log out.</a></h2>
<?php endif ?>
<?php if (!isset($_SESSION['login_user'])) :?>
    <form action="loggedin.php" id="login" method="post">
        <h2>Please sign in</h2>
        <?php if ($_SESSION['errormessage'] != 'None') :?>
            <h3><?=$_SESSION['errormessage']?></h3>
        <?php endif ?>
        <label for="username" >User Name</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="User Name" required autofocus>
        <label for="password" >Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

        <div id="remember">
                <input type="checkbox" name ="rememberme" value="remember-me"> Remember me
        </div>
        <input type="submit" value="Sign-In">
        <input type="reset" value="Reset">
    </form>
<?php endif ?>


</body>
</html>

