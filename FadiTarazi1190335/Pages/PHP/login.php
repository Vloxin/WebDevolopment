<?php
// Start or resume the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Include your database connection file
        include('db_connection.php');

        // Get user input
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Retrieve user data from the database using prepared statements
        $query = "SELECT * FROM `users` WHERE `username` = :username AND `password` = :password;";
        $statement = $pdo->prepare($query);

        // Bind parameters
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        // Execute the query
        $statement->execute();

        // Check if a matching user is found
        if ($statement->rowCount() == 1) {
            // Fetch the user data
            $userData = $statement->fetch(PDO::FETCH_ASSOC);

            // Store user information in the session
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $userData['type'];
      

            // Check if there's a redirect URL in the session
            $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';

            // Redirect to the specified page
            header("Location: $redirectUrl");
            exit();
        } else {
            // Display login error
            $loginError = "Invalid username or password";
        }
    }
}

// Check if there's a redirect URL in the session
$redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Harja Login</title>
    <link rel="stylesheet" href="../CSS/login.CSS">
    <link rel="icon" type="image/x-icon" href="../../Assets/icons/logo.jpg">
</head>

<body>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <legend>Login</legend>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <?php
        if (isset($loginError)) {
            echo "<p class='error'>$loginError</p>";
        }
        ?>

        <p><a href="registration.php">New Customer? Sign up here</a></p>
        <p><a href="reset_password.php">Forgot Account?</a></p>

        <input type="submit" value="Login">
    </form>

</body>

</html>
