<?php
session_start();

// destroy all session variables
$_SESSION = array();

// destroy the session
session_destroy();

// redirect to the home page
header("Location: index.php");
exit();
?> 