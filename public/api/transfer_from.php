<?php

// Connect to our database
$db = new MySQLDatabase;
$request = $_POST['request'];
$pdo = $db->getPDO();

// Import our code
include("../api.php");

$amount = $_POST['amount'];

// Initialize Target User
$targetPin  = $_POST['targetPin'];
$targetPass = $_POST['targetPass'];

$target = New User;
$target->setPin($targetPin);
$target->setPassword($targetPass);

transfer_from($pdo, $amount, $target);

// Transfer funds from our account to x account
?>
