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
        $results = mysqli_query($db->getPDO(),$query);
        $success_message="Account Creation Successful.";
        $fail_message="Account Creation Failed.";
}

if ($results === TRUE) {
    echo $success_message;
} else {
    echo $fail_message;
    echo "Error: " . $sql . "<br>" . $db->getPDO()->error;
}
$db->__destruct;
?>
