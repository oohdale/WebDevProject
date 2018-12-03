<?php
require 'connect.php';

$search = $_GET['search'];
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$search_results = "SELECT * FROM product WHERE productName LIKE :search";
$statement=$db->prepare($search_results);
$statement->bindValue(':search', '%'.$search.'%');
$statement->execute();
$row=$statement->fetch();


?>


<!DOCTYPE html>
<html lang="en">
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
    </ul> <!-- END div id="menu" -->


    <div id="searchpage">
        <?php if($row): ?>
            <?php while ($row): ?>
                <p><a href="show.php?productId=<?=$row['productId']?>"><?=$row['productName']?></a></p>
            <?php
                $row = $statement->fetch();
                endwhile;
                ?>
        <?php else: ?>
            <h2>No Results...</h2>
        <?php endif?>

    </div>
</div> <!-- END div id="searchpage" -->

<div id="footer">
    1041 McPhillips Street, (204)-123-1212, pandabubbletea@gmail.com
</div> <!-- END div id="footer" -->

</body>
</html>
