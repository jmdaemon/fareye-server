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
}
$db->__destruct;
?>
