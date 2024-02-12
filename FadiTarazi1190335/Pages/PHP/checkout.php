<?php
$totalPrice = 0;
// Check if the user is logged in
if (isset($_SESSION['username'])) {


    // Include your database connection file
    include('db_connection.php');

    // Fetch user data from the "user" table
    $queryUser = "SELECT * FROM users WHERE username = :username";
    $statementUser = $pdo->prepare($queryUser);
    $statementUser->bindParam(':username', $_SESSION['username']);
    $statementUser->execute();
    $userData = $statementUser->fetch(PDO::FETCH_ASSOC);
    echo '<h2>User Information</h2>';
    // Display user information
    echo'<div class="userinfo">';
   
    echo '<p>Name: ' . htmlspecialchars($userData['name']) . '</p>';
    echo '<p>ID Number: ' . htmlspecialchars($userData['idnum']) . '</p>';
    echo '<p>Email: ' . htmlspecialchars($userData['email']) . '</p>';
    echo '<p>Telephone: ' . htmlspecialchars($userData['telephone']) . '</p>';
    echo '<p>Card Holder Name: ' . htmlspecialchars($userData['cardHolderName']) . '</p>';
    echo '<p>Credit Card Number: ' . htmlspecialchars($userData['creditCardNumber']) . '</p>';
    echo '<p>Expiration Date: ' . htmlspecialchars($userData['expirationDate']) . '</p>';
    echo '<p>Bank: ' . htmlspecialchars($userData['bank']) . '</p>';
 
    echo'</div>';
   
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];

        // Fetch items from the database based on the product IDs in the cart
        $placeholders = rtrim(str_repeat('?,', count($cart)), ',');
        $query = "SELECT * FROM product WHERE id IN ($placeholders)";
        $statement = $pdo->prepare($query);
        $statement->execute($cart);
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Display the checkout details with a table
        echo '<h2>Checkout</h2>';
        echo '<table id="checkoutTable">';
        echo '<tr><th>Product ID</th><th>Title</th><th>Price</th><th>Quantity</th><th>Remove</th></tr>';
        

        foreach ($products as $product) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($product['id']) . '</td>';
            echo '<td>' . htmlspecialchars($product['name']) . '</td>';
            echo '<td class="product-price">' . htmlspecialchars($product['price']) . '</td>';
            echo '<td><input type="number" class="quantity" value="0" min="0" data-product-id="' . $product['id'] . '"></td>';
            echo '</tr>';
        }
        

        echo '</table>';
        echo '<button id="recalculate">Recalculate</button>';
        echo '<p>Total: <span id="totalPrice">' . $totalPrice . '</span></p>';


        confirmorderbutton($products, $totalPrice, $userData);
    } else {
        echo '<p>Your cart is empty.</p>';
    }
} else {
    echo '<p>Please <a href="login.php">login</a> to continue with your purchase.</p>';
}

function confirmorderbutton($products, $totalPrice, $userData)
{
    echo '<form method="POST" action="?action=store&task=confirmorder" id="confirmOrderForm">';

    echo '<input type="submit" value="Confirm Order" onclick="updateQuantities()">';

    $_SESSION['totalPrice'] = $totalPrice;
    $_SESSION['products'] = $products;
    $_SESSION['userid'] = $userData['idnum'];

    // Create an associative array for the product list
    $itemDictionary = array();
    foreach ($products as $product) {
        $itemDictionary[$product['id']] = 1; // Default quantity set to 1
    }
    $_SESSION['itemDictionary'] = $itemDictionary;

    echo '</form>';
}

?>

<script>
    // Function to update hidden input fields with the current quantity values
    function updateQuantities() {
        var quantityInputs = document.getElementsByClassName('quantity');
        var hiddenQuantityInputs = document.getElementsByClassName('hidden-quantity');

        // Update hidden input fields with the current quantity values
        for (var i = 0; i < quantityInputs.length; i++) {
            hiddenQuantityInputs[i].value = quantityInputs[i].value;
        }
    }

    // Event listener for the "Recalculate" button
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('recalculate').addEventListener('click', function () {
            // Recalculate total when the "Recalculate" button is clicked
            var total = 0;
            var quantityInputs = document.getElementsByClassName('quantity');

            // Loop through quantity inputs to calculate the total price
            for (var i = 0; i < quantityInputs.length; i++) {
                var productId = quantityInputs[i].getAttribute('data-product-id');
                var productPrice = parseFloat(document.getElementsByClassName('product-price')[i].textContent);
                var quantity = parseInt(quantityInputs[i].value);

                // Calculate total price for each product
                total += productPrice * quantity;
            }

            // Update the total price in the HTML
            document.getElementById('totalPrice').textContent = total.toFixed(2);
  

        });
    });
</script>
