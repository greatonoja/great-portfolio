<?php
session_start();

// Kill all session variables
session_unset();
session_destroy();

// Redirect to login screen (HTML frontend)
header("Location: ../frontend/html/login.html");
exit();
?>
