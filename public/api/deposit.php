<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

// Imports
include('../api.php');

$amount = $_POST['amount'];

$pin     = $_POST['pin'];
$amount  = $_POST['amount'];
$pass    = $_POST['password'];
$balance = $_POST['balance'];

$user = new User;
$user->setPin($pin);
$user->setPassword($pass);
$user->setBalance($balance);

deposit($pdo, $amount, $user);
?>
