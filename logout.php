<?php
// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect to the login page (or any other page)
header("Location: login.php");
exit;
?>