<?php

// Include the database connection file
include 'db_connection.php';

// Check if the task parameter is set
$task = isset($_GET['task']) ? $_GET['task'] : '';


echo"<div class='navdiv'>";
include('nav.php');
echo"</div>";
echo"<div class='storediv'>";
switch ($task) {
    case 'orderdetails':
        include('orderdetails.php');
        break;
    case 'confirmorder':
        include('confirmorder.php');
        break;
    case 'checkout':
        include('checkout.php');
        break;
    case 'search':
        include('search.php');
        break;
    
case 'productview':
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Fetch product details from the database
        $query = "SELECT * FROM product WHERE id = :product_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo '<h2>' . htmlspecialchars($product['name']) . '</h2>';
            echo '<div class="product-details">';
            
            // Use a container to hold both the image and product info
            echo '<div class="product-container">';
            
            // Image on the left
            $imagefile = "../../Assets/Images/itemsImages/item" . $product['img'];
            echo "<img src='{$imagefile}' alt='{$product['name']}' class='product-image' width='200'>";
            
            // Product info on the right
            echo '<div class="product-info">';
            echo '<p>Description: ' .'<p>'.htmlspecialchars($product['description']). '</p>';
            
            echo '<p>Price: ' . htmlspecialchars($product['price']) . '</p>';
         
            echo '</div>';
            
            // Close the container
            echo '</div>';
            
            echo '</div>';
        } else {
            // Product not found
            echo 'Product not found.';
        }
    } else {
        // Product ID not provided
        echo 'Product ID not provided.';
    }
    break;
    default:
      
        break;
}

echo "</div>";
?>
<link rel="stylesheet" href="../CSS/style.css">
