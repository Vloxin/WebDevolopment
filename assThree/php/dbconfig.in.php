<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2024-01-10

    Description:   This is the db config file.
 -->


<?php
$host = 'localhost'; 
$dbname = 'students'; 
$username = 'root'; 
$password = ''; 

try {
    // Establish a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



 
    //echo "Connected successfully";

} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
?>
