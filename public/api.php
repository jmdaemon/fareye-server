<?php

// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];
$pdo = $db->getPDO();

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
        if ($results === TRUE) {
            echo "Account Creation Successful.";
        } else {
            echo "Account Creation Failed.";
            echo "Error: " . $query . "<br>" . $pdo->error;
        }
        break;
    case "CheckNumber":
        $pin        = $_POST['pin'];
        $query      = "SELECT * FROM USERS WHERE pin LIKE $pin";
        $results    = mysqli_query($pdo, $query);
        if ($results === FALSE) {
            // User with pin does not exist in our database
            echo "Account number is unique.";
            return TRUE;
        } else {
            // User with pin exists in our database
            print("Account already associated with a user.");
            echo "Error: " . $query . "<br>" . $pdo->error;
            return FALSE;
        }
    case "FetchUser":
        $pin  = $_POST['pin'];
        $pass = $_POST['password'];

        $query = "SELECT * FROM USERS WHERE pin=$pin AND password='$password'";

        $results = mysqli_query($db->getPDO(), $query);
        if ($results > 0) {
            $row = mysqli_fetch_assoc($results);
            print(json_encode($row));
            mysqli_free_result($results);
        }
        break;
}
$db->__destruct;
?>
