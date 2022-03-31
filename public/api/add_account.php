<?php
// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];
$pdo = $db->getPDO();

include('../api.php');

add_account($pdo);
?>
