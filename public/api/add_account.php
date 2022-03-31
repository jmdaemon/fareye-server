<?php
// Connect to our database
$db = new MySQLDatabase;

$request=$_POST['request'];
$pdo = $db->getPDO();

// Adds an account to the database
function add_account($pdo) {
    $pass   = $_POST['password'];
    $fname  = $_POST['firstName'];
    $mname  = $_POST['middleName'];
    $lname  = $_POST['lastName'];
    $pin    = $_POST['pin'];
    $query = "INSERT INTO
            USERS  (fname, mname, lname, balance, pin, history, password)
            VALUES ('$fname', '$mname', '$lname', 0.0, $pin, '', '$pass');";
    $results = mysqli_query($pdo, $query);
    return checkResult("Account Creation Successful.", "Account Creation Failed.",
        $results === TRUE, $query, $pdo);

}
add_account($pdo);
?>
