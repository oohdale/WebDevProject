<?php
require 'connect.php';

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 'Admin')
{
    header('Location: index.php');
}

/*if(isset($_SESSION['privilege'] == 'Admin'))
{
    header('Location: account.php');
}*/

$userId = filter_input(INPUT_POST, 'userId',FILTER_VALIDATE_INT);
$userName = filter_input(INPUT_POST, 'userName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$postType = filter_input(INPUT_POST, 'command');
$password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



$user_exists = false;

if (isset($_POST['Add'])) {
    if (strlen($password1) >= 10) {

        if ($password1 == $password2) {

            $password = password_hash($password1, PASSWORD_DEFAULT);

            $query = "SELECT * FROM user WHERE userName=:userName";
            $statement = $db->prepare($query);
            $statement->bindValue(':userName', $userName);
            $statement->execute();
            $row = $statement->fetch();

            if ($row) {
                $user_exists = true;
            } else {


                $query = "INSERT INTO user (userName, email, password) VALUES (:userName,:email,:password)";
                $statement = $db->prepare($query);
                $statement->bindValue(':userName', $userName);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':password', $password);
                $statement->execute();

                $_SESSION['userName'] = $userName;
                $_SESSION['success'] = "You are now logged in";
                header('location:account.php');
            }
        }
    }
}
if($postType == 'Delete')
{
    $query = "DELETE FROM user WHERE userId = :userId";
    $statement = $db->prepare($query);
    $bind_value = ['userId' => $userId];
    $statement->execute($bind_value);

    header('Location: menu.php?id='.$productId);
    //$test = $productId;

}
$query = "SELECT * FROM user WHERE userName <> 'admin'";
$userQuery = $db->prepare($query);
//$statement->bindValue(':userName', $userName);
$userQuery->execute();



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
<script>//alert('refresh');</script>
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
        <li><a href="account.php">Account</a></li>
        <li><a href="moderate.php">Comments</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul> <!-- END div id="menu" -->
    <div id="newcategory">
        <h1>Welcome <?=$_SESSION['login_user']?>!</h1>

        <?php if ($_SESSION['errormessage'] != 'None') :?>
            <?=$_SESSION['errormessage']?>
        <?php endif ?>

        <form method="post" id="Delete" action="account.php">
        <h2>All Registered Users</h2>
            <?php while ($row = $userQuery->fetch()): ?>
                <h3>Username: <?= $row['userName']?></h3>
                <p>Email Address: <?= $row['email'] ?></p>
            <p>
                <input type="hidden" name="userId" value="<?= $row['userId']?>" />
                <input type="submit" name="command" value="Delete">
            </p>
        <?php endwhile ?>
        </form>

        <form method="post" id="Add" action="account.php">

            <h2>Add New User</h2>
            <?php if ($password1 != $password2) :?>
                <p>Password does not match.</p>
            <?php elseif (strlen($password1) < 10) :?>
                <p>Password must be 10 characters or more.</p>
            <?php elseif ($user_exists) :?>
                <p>Username is already taken.</p>
            <?php endif ?>

            <label for="username">Username</label>
            <input type="text" name="userName" class="form-control" placeholder="User Name" value="<?=$userName?>" required autofocus>

            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?=$email?>" required autofocus>

            <label for="password1">Password</label>
            <input type="password" name="password1" class="form-control" placeholder="Password" required autofocus>

            <label for="password2">Confirm password</label>
            <input type="password" name="password2" class="form-control" placeholder="Password" required autofocus>

            <p> <input type="submit" name="Add" value="Add New User">
                <input type="reset" name="reset" value="Reset">
            </p>
        </form>


    </div>
</div>
<div id="footer">
    1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
</div> <!-- END div id="footer" -->
</body>
</html>
