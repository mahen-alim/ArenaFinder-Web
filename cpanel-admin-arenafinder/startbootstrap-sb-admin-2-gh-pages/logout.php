<?php
// Start the session (if not already started)
session_start();

// Destroy the session data
session_destroy();

// Redirect to the login page or any other desired location after logout
header("Location: login.php");
exit;
?>
