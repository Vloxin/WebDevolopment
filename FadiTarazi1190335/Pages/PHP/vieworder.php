<?php
session_start();
include 'db_connection.php';
if(is_null($_SESSION['username'])){
    header("Location: login.php");
}
// Get the order_id from the query parameters
$orderNumber = $_GET['order_id'];

try {
    // Fetch order details based on order number
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE number = :orderNumber");
    $stmt->bindParam(':orderNumber', $orderNumber);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        // Display order details
        echo "<h1>Order Details - Order Number: $orderNumber</h1>";
        echo "<p>Order Date: " . $order['date'] . "</p>";

        // Check if user_type is 2 (employee)
        if ($_SESSION['user_type'] == 2) {
            if ($order['status'] == 'done') {
                echo "<p>Order Status: Done</p>";
            } else {
                echo "<form action='updatestatus.php' method='post'>";
                echo "<label for='status'>Order Status:</label>";
                echo "<select name='status' id='status'>";
                echo "<option value='waiting' " . ($order['status'] == 'waiting' ? 'selected' : '') . ">Waiting</option>";
                echo "<option value='processing' " . ($order['status'] == 'processing' ? 'selected' : '') . ">Processing</option>";
                echo "<option value='done' " . ($order['status'] == 'done' ? 'selected' : '') . ">Done</option>";
                echo "</select>";
                // Add a hidden input field for order_id
                echo "<input type='hidden' name='order_id' value='$orderNumber'>";
                echo "<input type='submit' value='Update Status'>";
                echo "</form>";
            }
        } else {
            // Display order status for customers (user_type = 1)
            echo "<p>Order Status: " . $order['status'] . "</p>";
        }

        // Display product list in a table
        $productList = json_decode($order['productlist'], true);
        echo "<h2>Product List</h2>";
        echo "<table class>";
        echo "
        <tr>
        <th>Product Image</th>
        <th>Product ID</th>
        <th>Ordered Quantity</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th><th>Category</th>
        <th>Available Quantity</th>
        <th>Size</th>
        <th>Remarks</th>
        </tr>";

        foreach ($productList as $productId => $quantity) {
            echo "<tr>";

            // Retrieve product details from the database
            $stmt = $pdo->prepare("SELECT * FROM product WHERE id = :productId");
            $stmt->bindParam(':productId', $productId);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Display product details in the table
            if ($product) {
                $imagelocation   =  "../../Assets/Images/itemsImages/item" .$product['img'] ;
      
                echo "<td> <figure> <img src='$imagelocation' width='100'> </figure></td>";
                echo "<td>$productId</td>";
                echo "<td>$quantity</td>";
                echo "<td>" . $product['name'] . "</td>";
                echo "<td>" . $product['description'] . "</td>";
                echo "<td>" . $product['price'] . "</td>";
                echo "<td>" . $product['category'] . "</td>";
                echo "<td>" . $product['quantity'] . "</td>";
                echo "<td>" . $product['size'] . "</td>";
                echo "<td>" . $product['remarks'] . "</td>";

                echo "</tr>";
            } else {
                echo "<td colspan='9'>Product not found.</td></tr>";
            }
        }

        echo "</table>";
    } else {
        echo "Order not found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<link rel="stylesheet" href="../CSS/style.css">
