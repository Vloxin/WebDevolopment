<!DOCTYPE html>

<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../CSS/login.CSS">
    <link rel="icon" type="image/x-icon" href="../../Assets/icons/logo.jpg">   
</head>


<body>

<?php
    // Start or resume the session
    session_start();


    // Initialize the step variable
    $step = isset($_GET['step']) ? $_GET['step'] : 1;

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process Step data based on the current step
        if ($step == 1) {
            // Process Step 1 data
            $_SESSION['step1'] = $_POST; // Save Step 1 data in session
            header("Location: ?step=2");
            exit();
        } elseif ($step == 2) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirmPassword'];
        
                if ($password === $confirmPassword) {
                    // Process Step 2 data
                    $_SESSION['step2'] = $_POST; // Save Step 2 data in session
                    header("Location: ?step=3");
                    exit();
                } else {
                    $passwordMismatchError = "Passwords do not match";
                }
            }
        } 
    }

    // Function to print filled fields
    function printFields($data) {
        echo "<ul>";
        foreach ($data as $key => $value) {
            echo "<li>$key: $value</li>";
        }
        echo "</ul>";
    }
    function confirmationFunction() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
            // Include your database connection file
            include('db_connection.php');
    
            // Retrieve data from session
            $step1Data = $_SESSION['step1'];
            $step2Data = $_SESSION['step2'];
    
            // Process data and insert into the database
            // Implement your database insertion logic here using $step1Data and $step2Data
    
            $name = $step1Data['name'];
            $type = 1; // Assuming type is an integer
            $address = $step1Data['address'];
            $dateofbirth = $step1Data['dateofbirth'];
            $idnum = $step1Data['idnum'];
            $email = $step1Data['email'];
            $telephone = $step1Data['telephone'];
            $creditCardNumber = $step1Data['creditCardNumber'];
            $expirationDate = $step1Data['expirationDate'];
            $cardHolderName = $step1Data['cardHolderName'];
            $bank = $step1Data['bank'];
            $username = $step2Data['username'];
            $password = $step2Data['password'];
    
            // Use prepared statements for the insertion
            $query = "INSERT INTO `users` (`name`, `type`, `address`, `dateofbirth`, `idnum`, `email`, `telephone`, `creditCardNumber`, `expirationDate`, `cardHolderName`, `bank`, `username`, `password`) 
                      VALUES (:name, :type, :address, :dateofbirth, :idnum, :email, :telephone, :creditCardNumber, :expirationDate, :cardHolderName, :bank, :username, :password);";
            $statement = $pdo->prepare($query);
    
            // Bind parameters
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':type', $type, PDO::PARAM_INT);
            $statement->bindParam(':address', $address, PDO::PARAM_STR);
            $statement->bindParam(':dateofbirth', $dateofbirth, PDO::PARAM_STR);
            $statement->bindParam(':idnum', $idnum, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':telephone', $telephone, PDO::PARAM_STR);
            $statement->bindParam(':creditCardNumber', $creditCardNumber, PDO::PARAM_STR);
            $statement->bindParam(':expirationDate', $expirationDate, PDO::PARAM_STR);
            $statement->bindParam(':cardHolderName', $cardHolderName, PDO::PARAM_STR);
            $statement->bindParam(':bank', $bank, PDO::PARAM_STR);
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->bindParam(':password', $password, PDO::PARAM_STR);
    
            // Execute the query
            $statement->execute();
    
            // Display confirmation message
            echo "<p>Your registration has been confirmed successfully!</p>";
            echo "<a href='./login.php'>Login</a>";
            echo "<p>Redirecting you in 5 seconds to the login page</p>";
    
            // Clear session data
            session_unset();
            session_destroy();
    
            // Redirect to login page after 5 seconds
            header("Refresh: 5; URL=login.php");
            exit;
        }
    }
    

?>



<form action="?step=<?php echo $step; ?>" method="POST">

<fieldset >
    <legend>Register - Step <?php echo $step; ?></legend>

        <?php if ($step == 1) { 
            ?>
        <div class="field-container">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" pattern="[A-Za-z ]{1,}" title="Only letters and spaces are allowed" required>
            <br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <br>

            <label for="dateofbirth">Date of Birth:</label>
            <input type="date" id="dateofbirth" name="dateofbirth" required>
            <br>

            <label for="idnum">ID Number:</label>
            <input type="text" id="idnum" name="idnum" pattern="[0-9]{1,}" title="Only numbers are allowed" required>
            <br>

            <label for="email">Email Address:</label>
            <br>
            <input type="email" id="email" name="email" required>
            <br>

            <label for="telephone">Telephone:</label>
            <br>
            <input type="tel" id="telephone" name="telephone" pattern="[0-9+-]{1,}" title="Only numbers, +, and - are allowed" required>
            <br>
        </dev>
        
        <div class="field-container">
            <label for="creditCardNumber">Credit Card Number:</label>
            <input type="text" id="creditCardNumber" name="creditCardNumber" pattern="[0-9]{16}" title="Credit card number must be 16 digits" required>

            <label for="expirationDate">Expiration Date:</label>
            <input type="text" id="expirationDate" name="expirationDate" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Format: MM/YY" required>

            <label for="cardHolderName">Card Holder Name:</label>
            <input type="text" id="cardHolderName" name="cardHolderName" pattern="[A-Za-z ]{1,}" title="Only letters and spaces are allowed" required>

            <label for="bank">Bank Issued:</label>
            <input type="text" id="bank" name="bank" required>

        </dev>

            <p> 
                <a href="login.php"> Already have an account ? Login Here</a> 
            </p>
        
            <input type="submit" value="Next">
        <?php }?>


    
<?php if ($step == 2) { ?>


    <label for="username">Username:</label>
    <input type="text" id="username" name="username" minlength="6" maxlength="13"  >
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" minlength="8" maxlength="12"  >
    <br>
    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" minlength="8" maxlength="12"  >
    <br>

    <?php if (isset($passwordMismatchError)) { ?>
        <p class="error"><?php echo $passwordMismatchError; ?></p>
    <?php } ?>

    <input type="submit" value="Next">
    
<?php } ?>
            


<?php if ($step == 3) { ?>
        <form action="?step=<?php echo $step; ?>" method="POST">
        <h2>Preview:</h2>
        <?php
        // Display preview of entered data
        echo "<h2>User info</h2>";
        printFields($_SESSION['step1']);
        
        echo "<h2>E account info</h2>";
        printFields($_SESSION['step2']);
        ?>
        <input type="submit" name="confirm" value="Confirm">

         </form>
<?php   confirmationFunction(); 
   
        } ?>






</fieldset>

</form>
    
    
    


