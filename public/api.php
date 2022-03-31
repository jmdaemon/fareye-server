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
?>
