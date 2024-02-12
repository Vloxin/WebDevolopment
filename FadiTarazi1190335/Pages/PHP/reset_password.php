<?php
// Include your database connection file
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the users table
    $query = "SELECT * FROM `users` WHERE `email` = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Display the user's password (for debugging only)
        echo "<form>";
        echo "<p>Useer's UserName: {$user['username']}</p>";
        echo "<p>User's Password: {$user['password']}</p>";
        echo "</form>";

    } else {
        echo "<p>Email not found. Please try again.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Recovery</title>
    <link rel="stylesheet" href="../CSS/login.CSS">
    <link rel="icon" type="image/x-icon" href="../../Assets/icons/logo.jpg">
</head>

<body>
    <form action="reset_password.php" method="POST">
        <h1>Account Recovery</h1>
        <p>Please enter your email address. We will send you an email to reset your password.</p>
        <label for="email">Email:</label>
        <br>
        <input type="email" id="email" name="email" required>
        <br>
        <br>
        <p><a href="login.php">Remembered account? Back to login</a></p>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
