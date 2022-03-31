<?php

/**
 * Defines commonly used functions used across all requests
 */

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

/**
 * Stores information about our user
 */
class User {
    private $fname;
    private $mname;
    private $lname;
    private $pin;
    private $pass;

    // Getters
    public function getFirstName()  { return $this->fname; }
    public function getMiddleName() { return $this->mname; }
    public function getLastName()   { return $this->lname; }
    public function getPin()        { return $this->pin; }
    public function getPassword()   { return $this->pass; }

    // Setters
    public function setFirstName($fname)  { $this->fname = $fname; }
    public function setMiddleName($mname) { $this->mname = $mname; }
    public function setLastName($lname)   { $this->lname = $lname; }
    public function setPin($pin)          { $this->pin = $pin; }
    public function setPassword($pass)    { $this->pass = $pass; }
}

// Parse a post request into a user
function parse_user($post) {
    $pin    = $post['pin'];
    $pass   = $post['password'];
    $fname  = $post['firstName'];
    $mname  = $post['middleName'];
    $lname  = $post['lastName'];

    $user = new User;
    $user->setFirstName($fname);
    $user->setMiddleName($mname);
    $user->setMiddleName($lname);
    $user->setPin($pin);
    $user->setPassword($pass);
    return $user;
}

// Adds an account to the database
function add_account($pdo, $user) {
    $query = "INSERT INTO
            USERS  (fname, mname, lname, balance, pin, history, password)
            VALUES ('$user->fname', '$user->mname', '$user->lname', 0.0, $user->pin, '', '$user->pass');";
    $results = mysqli_query($pdo, $query);
    return checkResult("Account Creation Successful.", "Account Creation Failed.",
        $results === TRUE, $query, $pdo);

}

class Message {
    private $value;

    public function getMessage() { return $this->value; }
    public function setMessage($msg) { $this->value = $msg; }
}

// Parse a post into a Message
function parse_message($post) {
    $msg = new Message;
    $history = $post['history'];
    $msg->setMessage($history);
    return $msg;
}

// Appends the message to the user's transaction log
function logMessage($pdo, $user, $msg) {
        $query = "UPDATE USERS SET history=CONCAT(history, '$msg->getMessage()') WHERE pin=$user->getPin()";
        $results = mysqli_query($pdo, $query);
        checkResult("Account history updated.", "History failed to update.",
            $results === TRUE, $query, $pdo);
}

// Checks if the account pin is unique
function check_pin($pdo, $user) {
    $query      = "SELECT * FROM USERS WHERE pin LIKE $user->getPin()";
    $results    = mysqli_query($pdo, $query);
    return checkResult("Account number is unique.", "Account already associated with a user.",
        $results === FALSE, $query, $pdo);
}

// Returns the user from the database if their pin and password match
function fetch_user($pdo, $user) {
        $query = "SELECT * FROM USERS WHERE pin=$user->getPin() AND password='$user->getPassword()'";

        $results = mysqli_query($pdo, $query);
        if ($results > 0) {
            $row = mysqli_fetch_assoc($results);
            print(json_encode($row));
            mysqli_free_result($results);
        }
}

?>
