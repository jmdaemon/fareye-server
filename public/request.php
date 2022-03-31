<?php

/**
 * Handle all the Fareye application requests
 */

# Imports
include('../api.php');

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

// Deal with all the requests
$request=$_POST['request'];

switch ($request) {
    case "add_account":
        $user = parse_user($_POST);
        add_account($pdo, $user);
        break;
    case "append_history":
        $user = parse_user($_POST);
        $msg = parse_message($_POST);
        logMessage($pdo, $user, $msg);
        break;
    case "check_pin":
        $user = parse_user($_POST);
        check_pin($pdo, $user);
        break;
    case "deposit":
        $amount = $_POST['amount'];
        $user = parse_user($_POST);
        deposit($pdo, $amount, $user);
        break;
    case "withdraw":
        $amount  = $_POST['amount'];
        $user = parse_user($_POST);
        withdraw($pdo, $amount, $user);
        break;
    case "fetch_user":
        $user = parse_user($_POST);
        fetch_user($pdo, $user);
        break;
    case "transfer_from":
        $amount = $_POST['amount'];
        $user = parse_user($_POST);
        $target = parse_target($_POST);

        // Transfer funds from target to user
        transfer_from($pdo, $amount, $target, $user);
        break;
    case "transfer_to":
        $amount = $_POST['amount'];
        $user = parse_user($_POST);
        $target = parse_target($_POST);

        // Transfer funds from our account to target account
        transfer_from($pdo, $amount, $target, $user);
    case 'reset_pass':
        $newpass = $_POST['newPass'];
        $user = parse_user($_POST);
        reset_password($pdo, $newpass, $user);
        break;
    case 'reset_account':
        $user = parse_user($_POST);
        reset_account($pdo, $user);
        break;
}
?>
