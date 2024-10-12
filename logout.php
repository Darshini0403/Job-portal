<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Also clear the session cookie if set
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to the login page
header("Location: login.php");
exit;
?>