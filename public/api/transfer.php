<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

// Import our code
include("withdraw");

// Returns true if the user was found in the database and false otherwise
function user_exists($pdo, $pin) {
    $query = "SELECT * FROM USERS WHERE pin LIKE $pin";
    $results = mysqli_query($pdo, $query);
    if ($results > 0)
        return TRUE;
    else
        return FALSE;
}

// Returns the user(s) found in the database
// Assume that only one user is ever found in the database
function get_user($pdo, $pin) {
    $query = "SELECT * FROM USERS WHERE pin LIKE $pin";
    $results = mysqli_query($pdo, $query);
    return $results;
}


$amount = $_POST['amount'];
$request = $_POST['request'];

$targetPin  = $_POST['targetPin'];
$targetpass = $_POST['targetPass'];

switch ($request) {
    // Transfer funds from x account to our account
    case "TransferFrom":
        // Assert the pin number exists in our database
        if (!user_exists($pdo, $targetPin)) {
            // Log Error
            return FALSE;
        }

        // Query database for the user's balance
        $user = get_user($pdo, $targetPin);
        $targetBalance = mysqli_fetch_field($result, "balance");

        // Execute withdrawal
        withdraw($pdo, $targetPin, $amount, $targetpass, $targetBalance);
        // Deposit into our account

        break;
    // Transfer funds from our account to x account
    case "TransferTo":
}
?>
