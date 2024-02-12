<?php
$host = 'localhost'; // Assuming your database server is on the same machine
$dbname = 'haraja'; // Replace with your database name
$username = 'root'; // Default username for XAMPP is 'root'
$password = ''; // Default password for XAMPP is empty or 'root'

try {
    // Establish a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    //  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



 
    //echo "Connected successfully";

} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
?>
