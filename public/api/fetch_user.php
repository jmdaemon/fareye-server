<?php

// Connect to our database
$db = new MySQLDatabase;
$pdo = $db->getPDO();

// Returns the user from the database if their pin and password match
function fetch_user($pdo) {
        $pin  = $_POST['pin'];
        $pass = $_POST['password'];

        $query = "SELECT * FROM USERS WHERE pin=$pin AND password='$pass'";

        $results = mysqli_query($pdo, $query);
        if ($results > 0) {
            $row = mysqli_fetch_assoc($results);
            print(json_encode($row));
            mysqli_free_result($results);
        }
}
fetch_user($pdo);
?>
