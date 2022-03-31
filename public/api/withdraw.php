<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

// Process Post Request
$pin     = $_POST['pin'];
$amount  = $_POST['amount'];
$pass    = $_POST['amount'];
$balance = $_POST['balance'];

function withdraw($pdo, $pin, $amount, $pass, $balance) {
    // If we have money
    if ($amount <= $balance) {
        // Take some of it out
        $newbalance = $balance - $amount;
        $query = "UPDATE USERS SET balance=$newbalance WHERE pin=$pin";
        $results = mysqli_query($pdo, $query);

        $success = ("Withdrawal of Amount $" . $amount . " made.\n");
        if (checkResult ($success, "", $results, $query, $pdo)) {
            // Update Log
        } else {
            // Log Error
        }
    } else if ($amount > $balance) {
        // Process the transaction with an overdraft
        $newbalance = $balance - $amount;
        $query = "UPDATE USERS SET balance=$newbalance WHERE pin=$pin";
        $results = mysqli_query($pdo, $query);

        // Process overdraft
        $newbalance = $newbalance - 25.0;
        $query = "UPDATE USERS SET balance=$newbalance WHERE pin=$pin AND password='$pass'";
        
        $success = "A bank overdraft fee of $25 will be charged to your account. We thank you for your business.\n";
        // Log overdraft message
    }
}
withdraw($pdo, $pin, $amount, $pass, $balance)
?>
