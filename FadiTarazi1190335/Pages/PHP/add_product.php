<?php

include 'db_connection.php';

// Function to generate a 10-digit product ID
function generateProductID($pdo) {
    $maxAttempts = 10; // You can adjust the maximum number of attempts

    for ($i = 0; $i < $maxAttempts; $i++) {
        $uniqueID = mt_rand(1000000000, 9999999999);

        // Check if the generated ID already exists in the database
        $stmt = $pdo->prepare("SELECT id FROM product WHERE id = :id");
        $stmt->bindParam(':id', $uniqueID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // If the ID doesn't exist, use it and break the loop
            return $uniqueID;
        }
    }

    // If we reach here, maximum attempts exceeded (optional: handle accordingly)
    throw new RuntimeException('Failed to generate a unique ID after maximum attempts.');
}



// Function to handle file upload (allowing GIFs and PNG/JPG files)
function handleFileUpload($productID) {
    $targetDir = "../../Assets/Images/itemsImages/";

    // Get file extension
    $fileExtension = strtolower(pathinfo($_FILES["productImage"]["name"], PATHINFO_EXTENSION));

    // Allow (GIF, PNG, JPG)
    $allowedExtensions = array("gif", "png", "jpg");
    if (in_array($fileExtension, $allowedExtensions)) {
        $uploadFile = $targetDir . "item" . $productID . "img." . $fileExtension;

        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $uploadFile)) {
            return   $productID . "img." . $fileExtension;
        } else {
            return false;
        }
    } else {
        return false; 
    }
}

// Display success message with item ID if 
$successMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];
    $size = $_POST["size"];
    $remarks = $_POST["remarks"];

    $productID = generateProductID($pdo);
    $imgPath = handleFileUpload($productID);

    if ($imgPath !== false) {
        $stmt = $pdo->prepare("INSERT INTO product (id, name, description, price, category, quantity, size, img, remarks)
                              VALUES (:id, :name, :description, :price, :category, :quantity, :size, :img, :remarks)");

        $stmt->bindParam(':id', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':size', $size, PDO::PARAM_STR);
        $stmt->bindParam(':img', $imgPath, PDO::PARAM_STR);
        $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);

        $stmt->execute();

        $successMessage = "Product added successfully! Item ID: " . $productID;
    } else {
        echo "Invalid file format or upload failure.";
    }
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Form</title>
    <link rel="stylesheet" type="text/css" href="../CSS/product_mangment.css">
</head>
<body>
    <div class="center-container">
    <form method="post" enctype="multipart/form-data" class="form-container">


            <input type="button" value="< Back" onclick="window.location.href='index.php?action=back'" />
            <br>
            <br>

            <label for="name" class="form-label">Product Name:</label>
            <input type="text" name="name" pattern="[a-zA-Z0-9\s]+" required class="form-input">

            <label for="description" class="form-label">Product Description:</label>
            <textarea name="description" required class="form-input"></textarea>

            <label for="price" class="form-label">Price (numeric data only):</label>
            <input type="number" name="price" min="0.01" step="0.01" required class="form-input">

            <label for="category" class="form-label">Category:</label>
            <select name="category" required class="form-input">
                <option value="new arrival">New Arrival</option>
                <option value="on sale">On Sale</option>
                <option value="featured">Featured</option>
                <option value="high demand">High Demand</option>
                <option value="normal" selected>Normal</option>
            </select>

            <label for="quantity" class="form-label">Quantity (numeric):</label>
            <input type="number" name="quantity" min="1" required class="form-input">

            <label for="size" class="form-label">Size:</label>
            <input type="text" name="size" pattern="[a-zA-Z0-9\s]+" class="form-input">

            <label for="remarks" class="form-label">Remarks:</label>
            <textarea name="remarks" class="form-input"></textarea>

            <label for="productImage" class="form-label">Product Image:</label>
            <input type="file" name="productImage" accept="image/gif, image/png, image/jpeg" required class="form-input">

            <input type="submit" value="Submit" class="submit-button" action=>

            <?php if (!empty($successMessage)) : ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <br>

        </form>
    </div>  


</body>
</html>
