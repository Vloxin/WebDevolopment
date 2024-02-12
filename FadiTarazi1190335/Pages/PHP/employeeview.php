<?php

// Check if user is not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_type'])) {
    // Redirect to login page or handle as appropriate
    header("Location: login.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee View</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
</head>
<body>
    <div class="center-container">
        <form  method="post">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            
            <br>

            <a href="index.php?action=add_product" class="add-button">
                <button type="button" class="add">
                    <span class="icon">➕</span> Add Product
                </button>
            </a>
            
            <a href="index.php?action=edit_product" class="edit-button">
                <button type="button" class="edit">
                    <span class="icon">✎</span> Edit Product
                </button>
            </a>
         
        </form>
    </div>
</body>
</html>
