<?php
// Initialize the session
session_start();
$_SESSION = array();
 
// Destroy the session.
session_destroy();
header("location: avlogin.php");
exit();
?>