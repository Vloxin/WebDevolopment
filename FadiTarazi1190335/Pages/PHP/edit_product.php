    <?php
    // Include your database connection code
    include 'db_connection.php';

    // Initialize a variable to hold the confirmation message
    $confirmationMessage = "";

    // Check if the update form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_quantity"])) {
        // Update the quantity in the database
        $productId = $_POST["product_id"];
        $newQuantity = $_POST["new_quantity"];

        try {
            $stmt = $pdo->prepare("UPDATE product SET quantity = quantity + :new_quantity WHERE id = :product_id");
            $stmt->bindParam(':new_quantity', $newQuantity, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            $confirmationMessage = "Quantity updated successfully.";
        } catch (PDOException $e) {
            $confirmationMessage = "Error updating quantity: " . $e->getMessage();
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">

        <title>Edit Product</title>
    </head>

    <body>

        <div class="center-container">
            <h2>Edit Product Quantity</h2>

            <!-- Search Form -->
            <form action="index.php?action=edit_product" method="post" class="form-container">
                <a href="index.php?action=back">&lt; Back</a>
                <label for="search" class="form-label">Search Product:</label>
                <input type="text" id="search" name="search" placeholder="Enter product name or ID" class="form-input">
                <button type="submit" class="submit-button">Search</button>
            </form>

            <!-- Display Confirmation Message -->
            <?php if (!empty($confirmationMessage)): ?>
                <p class="success-message"><?php echo $confirmationMessage; ?></p>
            <?php endif; ?>

        <?php
    // Handle the search and display results
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
        $searchTerm = $_POST["search"];

        try {
            // Check if the search term is numeric (assuming product IDs are numeric)
            if (is_numeric($searchTerm)) {
                $stmt = $pdo->prepare("SELECT id, name FROM product WHERE id = :search");
            } else {
                $stmt = $pdo->prepare("SELECT id, name FROM product WHERE name LIKE :search");
                $searchTerm = '%' . $searchTerm . '%'; // Add % for partial string matching
            }

            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display the search results
            if (!empty($products)) {
                echo "<ul>";
                foreach ($products as $product) {
                    echo "<li><a href='index.php?action=edit_product&id={$product['id']}'>{$product['name']} (ID: {$product['id']})</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No products found.</p>";
            }
        } catch (PDOException $e) {
            echo "Error searching for products: " . $e->getMessage();
        }
    }

        // Display the form for editing quantity
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $productId = $_GET["id"];

            try {
                $stmt = $pdo->prepare("SELECT id, name , img FROM product WHERE id = :product_id");
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $imagefile=  "../../Assets/Images/itemsImages/item" . $product['img'];

                    echo "<form action='index.php?action=edit_product' method='post'>";
                    echo "<label for='new_quantity'>Enter new quantity for Product: {$product['name']}</label>";
                    echo "<input type='number' id='new_quantity' name='new_quantity' required>";
                    echo "<input type='hidden' name='product_id' value='{$product['id']}'>";
                
                    echo "<button type='submit' name='update_quantity'>Update Quantity</button>";
                    
                    echo "<div class='imgcontainer'>";
                    echo "<img src='{$imagefile}' alt='{$product['name']}' width='200'>";
                    echo "</div>";
                
                    echo "</form>"; 
                    echo "<br>";
                
                    
                } else {
                    echo "<p>Product not found.</p>";
                }
            } catch (PDOException $e) {
                echo "Error retrieving product details: " . $e->getMessage();
            }
        }
        ?>

    </div>

    </body>
    </html>
