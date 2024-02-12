<?php
include 'db_connection.php';

    try {
        // Fetch user's id from the users table
        $stmt = $pdo->prepare("SELECT idnum, type FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch orders based on the user's id
        if ($user) {
            $userId = $user['idnum'];
            $usr_type = $user['type'];

            if ($usr_type == '1') {
                $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :userId ORDER BY date ASC");
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display the orders in a table
                echo "<table class = 'viewordertable'>";
                echo "<tr class ='trblack'>";
                echo "<th>Order Number</th>";
                echo "<th>Order Date</th>";
                echo "<th>Order Status</th>";
                echo "</tr>";

                foreach ($orders as $order) {
                    
                    
                    $orderNumber = $order['number'];
                    $productList = json_decode($order['productlist'], true);
                    $date = $order['date'];
           
                    $status = $order['status'];
      
               

                    // Apply different styles based on order status
                    if ($status == 'pending') {
                        $styleClass = 'waiting-status';
                    } else if ($status == 'done') {
                        $styleClass = 'done-status';
                    }else if ($status == 'processing') {
                        $styleClass = 'processing-status';
                    }

                    echo "<tr class='$styleClass'>";
                    echo "<td><a href='vieworder.php?order_id=$orderNumber' target='_blank'>$orderNumber</a></td>";
                    echo "<td>$date</td>";
           
                    echo "<td>$status</td>";
                    echo "</tr>";
                    
                }

                echo "</table>";
            } else {
                $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY date ASC");
                $stmt->execute();
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

             

                // Display the orders in a table
                echo "<table>";
                echo "<tr>";
                echo "<th>Order Number</th>";
                echo "<th>Order Date</th>";
      
                echo "<th>Order Status</th>";
                echo "</tr>";

                foreach ($orders as $order) {
                    $orderNumber = $order['number'];
                    $productList = json_decode($order['productlist'], true);
                    $date = $order['date'];
            
                    $status = $order['status'];

                    // Apply different styles based on order status
                    if ($status == 'pending') {
                        $styleClass = 'waiting-status';
                    } else if ($status == 'done') {
                        $styleClass = 'done-status';
                    }else if ($status == 'processing') {
                        $styleClass = 'processing-status';
                    }
                  
                 
                    echo "<tr class='$styleClass'>";
                    echo "<td><a href='vieworder.php?order_id=$orderNumber' target='_blank'>$orderNumber</a></td>";
                    echo "<td>$date</td>";
          
                    echo "<td>$status</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        } else {
            // Handle the case where the user is not found in the users table
            echo "User not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>
