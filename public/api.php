<?php

// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];
$results=NULL;
$success_message="";
$fail_message="";
$sql="";

switch ($request) {
    case "AddAccount":
        $pass   = $_POST['password'];
        //$bal    = $_POST['balance'];
        $fname  = $_POST['firstName'];
        $mname  = $_POST['middleName'];
        $lname  = $_POST['lastName'];
        $pin    = $_POST['pin'];
        $sql = "INSERT INTO
                USERS  (fname, mname, lname, balance, pin, history, password)
                VALUES ($fname, $mname, $lname, 0.0, $pin, '', $password);";
        $results = mysqli_query($db->getPDO(),$sql);
        $success_message="Account Creation Successful.";
        $fail_message="Account Creation Failed.";
        if ($results === TRUE) {
            echo $success_message;
        } else {
            echo $fail_message;
            echo "Error: " . $sql . "<br>" . $db->getPDO()->error;
        }

        break;
    case "CheckNumber":
        $pin    = $_POST['pin'];
        //$pass   = $_POST['password'];
        //$fname  = $_POST['firstName'];
        //$mname  = $_POST['middleName'];
        //$lname  = $_POST['lastName'];
        $sql = "SELECT * FROM USERS WHERE pin LIKE $pin";
        $results = mysqli_query($db->getPDO(),$sql);
        if ($results === FALSE) {
            // User with pin does not exist in our database
            echo "Account number is unique.";
            return TRUE;
        } else {
            // User with pin exists in our database
            print("Account already associated with a user.");
            echo "Error: " . $sql . "<br>" . $db->getPDO()->error;
            return FALSE;
        }
}
$db->__destruct;
?>
