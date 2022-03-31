<?php

// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];

// Checks if the account pin is unique
function check_pin($pdo) {
    $pin        = $_POST['pin'];
    $query      = "SELECT * FROM USERS WHERE pin LIKE $pin";
    $results    = mysqli_query($pdo, $query);
    return checkResult("Account number is unique.", "Account already associated with a user.",
        $results === FALSE, $query, $pdo);
}
check_pin($pdo);
?>
