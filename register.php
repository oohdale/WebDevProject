<?php

require 'connect.php';

$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$query = "SELECT * FROM user";
$statement = $db->prepare($query);
$statement->execute();

$user_exists=false;

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['register'])) {
            if (strlen($password1) >= 10) {
                if ($password1 == $password2) {
                    $password = password_hash($password1, PASSWORD_DEFAULT);

                    $query = "SELECT * FROM user WHERE username=:username";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':username', $username);
                    $statement->execute();
                    $row = $statement->fetch();


                    if ($row)
                    {
                        $user_exists=true;
                    }
                    else {


                        $query = "INSERT INTO user (username, email, password) VALUES (:username,:email,:password)";
                        $statement = $db->prepare($query);
                        $statement->bindValue(':username', $username);
                        $statement->bindValue(':email', $email);
                        $statement->bindValue(':password', $password);
                        $statement->execute();
                        $row = $statement->fetch();

                        $_SESSION['username'] = $username;
                        $_SESSION['success'] = "You are now logged in";
                        header('location:index.php');
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Mali|Shojumaru|Source+Sans+Pro" rel="stylesheet">
</head>
<body>
<a href="index.php">Home</a>
<form method="post" id="register" action="register.php">
    <h2>Register</h2>
    <?php if ($password1 != $password2) :?>
        <p>Password does not match.</p>
    <?php elseif (strlen($password1) < 10) :?>
        <p>Password must be 10 characters or more.</p>
    <?php elseif ($user_exists) :?>
    <p>Username is already taken.</p>
    <?php endif ?>

        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="User Name" value="<?=$username?>" required autofocus>

        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?=$email?>">

        <label>Password</label>
        <input type="password" name="password1" class="form-control" placeholder="Password">

        <label>Confirm password</label>
        <input type="password" name="password2" class="form-control" placeholder="Password">

    <p> <input type="submit" name="register" value="Register">
        <input type="reset" name="reset" value="Reset">
    </p>
    <p> Already have an account? <a href="login.php">Sign in</a>  </p>




</form>
</body>
</html>