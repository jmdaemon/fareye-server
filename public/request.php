<?php

/**
 * Handle all the Fareye application requests
 */

// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];
$pdo = $db->getPDO();

// Deal with all the requests
switch ($request) {
}

?>
