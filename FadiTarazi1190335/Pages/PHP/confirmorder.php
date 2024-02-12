<?php

// Include your database connection file
include('db_connection.php');



if (isset($_SESSION['userid'], $_SESSION['totalPrice'], $_SESSION['products'], $_SESSION['itemDictionary'])) {
    $userId = $_SESSION['userid'];
    $totalPrice = $_SESSION['totalPrice'];
    
    $products = $_SESSION['products'];
    $itemDictionary = $_SESSION['itemDictionary'];

    try {
        // Insert order details into the "orders" table
        $queryOrder = "INSERT INTO orders (id, date, total, status, productlist) VALUES (:id, :date, :total, :status, :productlist)";
        $statementOrder = $pdo->prepare($queryOrder);

        $date = date("Y-m-d H:i:s");
        $status = "pending"; // You can set the status as needed

        // Create an associative array for the product list
        $productListArray = array();
        foreach ($itemDictionary as $productId => $quantity) {
            $productListArray[$productId] = $quantity;
        }
        $productListJson = json_encode($productListArray);

        $statementOrder->bindParam(':id', $userId);
        $statementOrder->bindParam(':date', $date);
        $statementOrder->bindParam(':total', $totalPrice);
        $statementOrder->bindParam(':status', $status);
        $statementOrder->bindParam(':productlist', $productListJson);

        $statementOrder->execute();

        // Retrieve the order ID
        $orderId = $pdo->lastInsertId();

      


        echo '<h2>CONFIRMATION</h2>';
        echo '<p>Thank you for purchasing from us. You can view all your order details by clicking on the link below:</p>';
        echo '<br>';
        echo "<a href='?action=store&task=orderdetails'>Order Details</a>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Incomplete session data. Please ensure you have selected products and are logged in.";
}
?>
