<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();
$request=$_POST['request'];

$user = parse_user($_POST);

check_pin($pdo, $user);
?>
