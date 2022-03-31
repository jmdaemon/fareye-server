<?php

// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];

switch ($request) {
    case "AddAccount":
        $pass   = $_POST['password'];
        $fname  = $_POST['firstName'];
        $mname  = $_POST['middleName'];
        $lname  = $_POST['lastName'];
        $pin    = $_POST['pin'];
        $query = "INSERT INTO
                USERS  (fname, mname, lname, balance, pin, history, password)
                VALUES ($fname, $mname, $lname, 0.0, $pin, '', $password);";
        $results = mysqli_query($db->getPDO(),$query);
        if ($results === TRUE) {
            echo "Account Creation Successful.";
        } else {
            echo "Account Creation Failed.";
            echo "Error: " . $query . "<br>" . $db->getPDO()->error;
        }
        break;
    case "CheckNumber":
        $pin        = $_POST['pin'];
        $query      = "SELECT * FROM USERS WHERE pin LIKE $pin";
        $results    = mysqli_query($db->getPDO(),$query);
        if ($results === FALSE) {
            // User with pin does not exist in our database
            echo "Account number is unique.";
            return TRUE;
        } else {
            // User with pin exists in our database
            print("Account already associated with a user.");
            echo "Error: " . $query . "<br>" . $db->getPDO()->error;
            return FALSE;
        }
}
$db->__destruct;
?>
