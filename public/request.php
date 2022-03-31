<?php

/**
 * Handle all the Fareye application requests
 */


# Imports
include('../api.php');

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

$request=$_POST['request'];

// Deal with all the requests
switch ($request) {
    case "add_account":
        $user = parse_user($_POST);
        add_account($pdo, $user);

}

?>
