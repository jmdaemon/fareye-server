<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

// Appends the message to the user's transaction log
function logMessage($pdo) {
        $pin = $_POST['pin'];
        $msg = $_POST['history'];
        $query = "UPDATE USERS SET history=CONCAT(history, '$msg') WHERE pin=$pin";

        $results = mysqli_query($pdo, $query);
        checkResult("Account history updated.", "History failed to update.",
            $results === TRUE, $query, $pdo);
}

logMessage($pdo);
?>
