<?php
// Start or resume the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the index page or any other desired page after logout
header("Location: index.php");
exit();
?>
