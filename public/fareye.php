<?php

// Import our crypt library
require ('crypt.php');

$aesUtility = new AesUtility;

// Parse POST Request
$key    = $_POST['key'];
$iv     = $_POST['iv'];
$pin    = $aesUtility->decrypt($_POST['pin'], $iv);
$pass   = $aesUtility->decrypt($_POST['password'], $iv);

// Create SQL request
$query = "SELECT * FROM USERS WHERE pin LIKE $pin AND $password";

// Query the database
$db = new MySQLDatabase;
$results = mysqli_query($db->getPDO(),$query);

// Handle login 
if ($results > 0) {
    // User was found
    } else {
        // Could not connect to database
    if (!$results) {
        // Log Error
        die('Error: ' . mysqli_error($db->getPDO()));
    } else {
        // User was not found in the database
        echo "Login failed.";
    }
  }
  $db->getPDO()->close();
?>
