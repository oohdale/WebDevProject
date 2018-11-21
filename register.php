<?php

require 'connect.php';

$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['register']))
        {
            $password=md5($password1);
            $query = "INSERT INTO user (username, email, password) VALUES (:username,:email,:password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password);
            $statement->execute();
            $row = $statement->fetch();


            $_SESSION['username']=$username;
            $_SESSION['success']="You are now logged in";
            header('location:index.php');
        }
    }

?>

<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Mali|Shojumaru|Source+Sans+Pro" rel="stylesheet">
</head>
<body>
<a href="index.php">Home</a>
<form method="post" id="register" action="register.php">
    <h2>Register</h2>

        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" placeholder="User Name" required autofocus>

        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>

        <label for="password1">Password</label>
        <input type="password" name="password1" class="form-control" placeholder="Password" required autofocus>

        <label for="password2">Confirm password</label>
        <input type="password" name="password2" class="form-control" placeholder="Password" required autofocus>

    <p> <input type="submit" name="register" value="Register">
        <input type="reset" name="reset" value="Reset">
    </p>
    <p> Already have an account? <a href="login.php">Sign in</a>  </p>

</form>
</body>
</html>