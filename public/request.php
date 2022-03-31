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

        $pin     = $_POST['pin'];
        $amount  = $_POST['amount'];
        $pass    = $_POST['password'];
        $balance = $_POST['balance'];

        $user = new User;
        $user->setPin($pin);
        $user->setPassword($pass);
        $user->setBalance($balance);

        deposit($pdo, $amount, $user);
        break;
}

?>
