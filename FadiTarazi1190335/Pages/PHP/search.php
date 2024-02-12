<?php
include 'db_connection.php';
$_SESSION['shortlist'] = [];
// Initialize search and filter variables
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$minPrice = isset($_POST['min_price']) ? $_POST['min_price'] : '';
$maxPrice = isset($_POST['max_price']) ? $_POST['max_price'] : '';

// Check if the search form has been submitted
$searchSubmitted = !empty($searchTerm) || !empty($minPrice) || !empty($maxPrice);

// Initialize cart array
$cart = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a product is added to the cart
    if (isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        // You might want to add additional validation for the product ID
        $cart[] = $productId;
    }

    // Check if shortlist is submitted
    if (isset($_POST['shortlist'])) {
        // Update shortlisted products array
        $shortlist = $_POST['add_to_cart'] ?? [];
        // Store the shortlist in the session
        $_SESSION['shortlist'] = $shortlist;
    }
}

if ($searchSubmitted) {
    // Fetch products from the database based on search and filter
    $query = "SELECT * FROM product WHERE name LIKE :search";
    $params = [':search' => '%' . $searchTerm . '%'];

    if (!empty($minPrice)) {
        $query .= " AND price >= :min_price";
        $params[':min_price'] = $minPrice;
    }

    if (!empty($maxPrice)) {
        $query .= " AND price <= :max_price";
        $params[':max_price'] = $maxPrice;
    }

    // Add sorting to the query
    $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'name';
    $sortOrder = isset($_COOKIE['sortOrder']) ? $_COOKIE['sortOrder'] : 'ASC';
    $query .= " ORDER BY $sortColumn $sortOrder";

    $statement = $pdo->prepare($query);
    $statement->execute($params);
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Display the search form
?>
<form method="POST" action="?action=store&task=search">
    <label for="search">Search:</label>
    <input type="text" id="search" class="search" name="search" value="<?= htmlspecialchars($searchTerm) ?>">

    <label for="min_price">Min Price:</label>
    <input type="text" id="min_price" class="minprice" name="min_price" value="<?= htmlspecialchars($minPrice) ?>">

    <label for="max_price">Max Price:</label>
    <input type="text" id="max_price" class="maxprice" name="max_price" value="<?= htmlspecialchars($maxPrice) ?>">

    <input type="submit" value="Search">
</form>

<?php
function displayTableWithCheckoutButton() {
    ;
    echo '<form method="POST" action="?action=store&task=checkout">';
    $_SESSION['cart'] = $_SESSION['shortlist'];
    echo '<input type="submit" value="Proceed to Checkout">';
    echo '</form>';
}
// Display the products in a table
if ($searchSubmitted && !empty($products)) {
    echo '<form method="POST" action="?action=store&task=search">';
    echo '<table class ="stable">';
    echo '<tr>
            <th><button type="submit" name="shortlist">Shortlist</button></th>
            <th>Image</th>
            <th>Reference Number</th>
            <th>Price</th>
            <th>Category</th>
            <th>Product Quantity</th>
          </tr>';

    foreach ($products as $product) {
        $imagefile = "../../Assets/Images/itemsImages/item" . $product['img'];
        echo '<tr>';
        echo '<td><input type="checkbox" name="add_to_cart[]" value="' . $product['id'] . '"';
        
        // Check if the current product is in the shortlist
        if (!empty($_SESSION['shortlist']) && in_array($product['id'], $_SESSION['shortlist'])) {
            echo ' checked';
        }
        
        echo '></td>';
        echo "<td><img src='{$imagefile}' alt='{$product['name']}' width='200'></td>";
        echo '<td><a href="?action=store&task=productview&product_id=' . $product['id'] . '">' . $product['id'] . '</a></td>';
        echo '<td>' . htmlspecialchars($product['price']) . '</td>';
        echo '<td>' . htmlspecialchars($product['category']) . '</td>';
        echo '<td>' . htmlspecialchars($product['quantity']) . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</form>';
   
} elseif ($searchSubmitted) {
    echo 'No products found.';
}

// Display the shortlisted products
if (!empty($_SESSION['shortlist'])) {
    
    echo '<h2>Shortlisted Products</h2>';
    echo '<table class="stable">';
    echo '<tr>
            <th>Image</th>
            <th>Reference Number</th>
            <th>Price</th>
            <th>Category</th>
            <th>Product Quantity</th>
          </tr>';

    foreach ($_SESSION['shortlist'] as $productId) {
        // Fetch product details based on the product ID
        $query = "SELECT * FROM product WHERE id = :product_id";
        $statement = $pdo->prepare($query);
        $statement->execute([':product_id' => $productId]);
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        $imagefile = "../../Assets/Images/itemsImages/item" . $product['img'];
        echo '<tr>';
        echo "<td><img src='{$imagefile}' alt='{$product['name']}' width='200'></td>";
        echo '<td><a href="?action=store&task=productview&product_id=' . $product['id'] . '">' . $product['id'] . '</a></td>';
        echo '<td>' . htmlspecialchars($product['price']) . '</td>';
        echo '<td>' . htmlspecialchars($product['category']) . '</td>';
        echo '<td>' . htmlspecialchars($product['quantity']) . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
 
}
displayTableWithCheckoutButton()
?>
