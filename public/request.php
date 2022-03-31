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
    case "append_history":
        $user = parse_user($_POST);
        $msg = parse_message($_POST);
        logMessage($pdo, $user, $msg);
    case "check_pin":
        $user = parse_user($_POST);
        check_pin($pdo, $user);

}

?>
