<?php

include_once 'db_connection.php';


    // Get the new status and order ID from the form submission
    $newStatus = $_POST['status'];
    $orderId = $_POST['order_id'];

    try {
        // Update the status in the orders table
        $stmt = $pdo->prepare("UPDATE orders SET status = :newStatus WHERE number = :orderId");
        $stmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: vieworder.php?order_id=$orderId");

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


?>
