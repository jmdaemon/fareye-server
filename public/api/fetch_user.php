<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

$user = parse_user($_POST);
fetch_user($pdo, $user);
?>
