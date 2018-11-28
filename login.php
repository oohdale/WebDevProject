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


<div id="header">
    <h1><a href="index.php">Panda Bubble Tea</a></h1>
    <img src="images/banner.png" alt="panda" class="aboutuspic">
</div> <!-- END div id="header" -->


    <ul id="navbar">
        <li><a href="create.php" class='active'>Product</a></li>
        <li><a href="category.php">Category</a></li>
        <li><a href="menu.php" >Menu</a></li>
        <li><a href="contactus.php">Contact Us</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->

</div>

<?php if (isset($_SESSION['login_user'])) :?>
    <h2>You're still signed in <?=$_SESSION['login_user']?>!</h2>
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

