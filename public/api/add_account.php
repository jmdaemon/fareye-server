<?php
// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

include('../api.php');
$user = parse_user($_POST);
add_account($pdo, $user);
?>
