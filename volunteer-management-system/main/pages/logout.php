<?php
session_start(); // Start or resume the session

// Destroy the session
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session itself

// Redirect to the login page
header("Location: login_in.php");
exit();
?>