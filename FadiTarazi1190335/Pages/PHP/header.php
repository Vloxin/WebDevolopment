<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <title>Your Page Title</title>
</head>

<body>

    <div class="header">
        <img src="../../Assets/icons/logo.jpg" class="logo-img">
        <ul>
            <li><a href="index.php?action=aboutus">AboutUs</a></li>
            <?php
        
            if (isset($_SESSION['username'])) {
                // Check if the user is an employee (user_type == 2)
                if ($_SESSION['user_type'] == 1) {
                    echo '<li><a href="index.php?action=store">Store</a></li>';
                } else {
                    echo '<li><a href="index.php?action=employeeview">Employee View</a></li>';
                    echo '<li><a href="index.php?action=orderdetails">orderdetails</a></li>';
                }
                echo '<li class="right"><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li class="right"><a href="registration.php">Register</a></li>';
                echo '<li class="right"><a href="login.php">Login</a></li>';
                echo '<li><a href="index.php?action=store">Store</a></li>';
            }
            ?>
        </ul>
    </div>
