<?php
// Initialize session structures
session_start();

// Unset global session arrays entirely
$_SESSION = array();

// Completely destroy backend cookies and session parameters
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Safely drop the user right back to the gateway screen
header("Location: index.php");
exit();
?>