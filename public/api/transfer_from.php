<?php

// Connect to our database
$db = new MySQLDatabase;
$request = $_POST['request'];
$pdo = $db->getPDO();

// Import our code
include("../api.php");

$amount = $_POST['amount'];

$pin = $_POST['pin'];
$user = New User;
$user->setPin($pin);

// Initialize Target User
$targetPin  = $_POST['targetPin'];
$targetPass = $_POST['targetPass'];

$target = New User;
$target->setPin($targetPin);
$target->setPassword($targetPass);

// Transfer funds from target to user
transfer_from($pdo, $amount, $target, $user);

// Transfer funds from our account to x account
?>
