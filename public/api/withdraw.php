<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

include('../api.php');
// Process Post Request
$pin     = $_POST['pin'];
$amount  = $_POST['amount'];
$pass    = $_POST['amount'];
$balance = $_POST['balance'];

$user = new User;
$user->setPin($pin);
$user->setPassword($pass);
$user->setBalance($balance);

withdraw($pdo, $amount, $user)
?>
