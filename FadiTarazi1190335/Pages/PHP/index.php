
<?php
session_start();

include('header.php');

// Check if the user is logged in
echo "<main class= 'index_main'>";
if (isset($_SESSION['username'])) {
    if ($_SESSION['user_type'] == 1) {
        $action = isset($_GET['action']) ? $_GET['action'] : 'store';

        // User type 1 (Regular User)
        switch ($action) {
            case 'store':
                include('store.php');
                break;
            case 'aboutus':
                include('aboutus.php');
                break;
            default:
                include('store.php');
                break;
        }
    } elseif ($_SESSION['user_type'] == 2) {
        // User type 2 (Employee)
        $action = isset($_GET['action']) ? $_GET['action'] : 'employeeview';

        switch ($action) {
            case 'orderdetails':
                include('orderdetails.php');
                break;
            case 'add_product':
                include('add_product.php');
                break;
            case 'edit_product':
                include('edit_product.php');
                break;
            case 'back':
                include('employeeview.php');
                break;
            case 'aboutus':
                include('aboutus.php');
                break;
            case 'employeeview':
                include('employeeview.php');
                break;
            case 'store':
                include('store.php');
                break;
            default:
                include('employeeview.php');
                break;
        }
    }
} else {
    // User is not logged in - Include aboutus.php and search functionality
    if (isset($_GET['action']) && $_GET['action'] == 'store') {
        include('store.php'); // Include search functionality
    } else {
        include('aboutus.php');
    }
}
echo "</main >";

include('footer.php');
?>

<link rel="stylesheet" href="../CSS/style.css">