<?php

// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];
$pdo = $db->getPDO();

/**
 * Checks if the result is true, and logs an error otherwise
 *
 * @param $success The success message to log
 * @param $success The fail message to log
 * @param $query The SQL query
 * @param @pdo The PHP data object
 */
function checkResult($success, $fail, $result, $query, $pdo) {
    if ($result === TRUE) {
        echo $success;
        return TRUE;
    } else {
        echo $fail;
        echo "Error: " . $query . "<br>" . $pdo->error;
        return FALSE;
    }
}

switch ($request) {
    case "AddAccount":
        $pass   = $_POST['password'];
        $fname  = $_POST['firstName'];
        $mname  = $_POST['middleName'];
        $lname  = $_POST['lastName'];
        $pin    = $_POST['pin'];
        $query = "INSERT INTO
                USERS  (fname, mname, lname, balance, pin, history, password)
                VALUES ('$fname', '$mname', '$lname', 0.0, $pin, '', '$password');";
        $results = mysqli_query($pdo, $query);
        return checkResult("Account Creation Successful.", "Account Creation Failed.",
            $results === TRUE, $query, $pdo);
    case "CheckNumber":
        $pin        = $_POST['pin'];
        $query      = "SELECT * FROM USERS WHERE pin LIKE $pin";
        $results    = mysqli_query($pdo, $query);
        return checkResult("Account number is unique.", "Account already associated with a user.",
            $results === FALSE, $query, $pdo);
    case "FetchUser":
        $pin  = $_POST['pin'];
        $pass = $_POST['password'];

        $query = "SELECT * FROM USERS WHERE pin=$pin AND password='$password'";

        $results = mysqli_query($pdo, $query);
        if ($results > 0) {
            $row = mysqli_fetch_assoc($results);
            print(json_encode($row));
            mysqli_free_result($results);
        }
        break;
    case "AppendHistory": # Append transaction history
        $pin = $_POST['pin'];
        $msg = $_POST['history'];
        $query = "UPDATE USERS SET history=CONCAT(history, '$msg') WHERE pin=$pin";

        $results = mysqli_query($pdo, $query);
        checkResult("Account history updated.", "History failed to update.",
            $results === TRUE, $query, $pdo);
    case "Withdraw":
        $pin     = $_POST['pin'];
        $amount  = $_POST['amount'];
        $pass    = $_POST['amount'];
        $balance = $_POST['balance'];

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
        } break;
}
$db->__destruct;
?>
