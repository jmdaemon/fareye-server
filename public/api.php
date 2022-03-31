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
    private $balance;

    // Getters
    public function getFirstName()  { return $this->fname; }
    public function getMiddleName() { return $this->mname; }
    public function getLastName()   { return $this->lname; }
    public function getPin()        { return $this->pin; }
    public function getPassword()   { return $this->pass; }
    public function getBalance()    { return $this->balance; }

    // Setters
    public function setFirstName($fname)  { $this->fname = $fname; }
    public function setMiddleName($mname) { $this->mname = $mname; }
    public function setLastName($lname)   { $this->lname = $lname; }
    public function setPin($pin)          { $this->pin = $pin; }
    public function setPassword($pass)    { $this->pass = $pass; }
    public function setBalance($bal)      { $this->balance = $bal; }
}

// Parse a post request into a user
function parse_user($post) {
    $pin    = $post['pin'];
    $pass   = $post['password'];
    $fname  = $post['firstName'];
    $mname  = $post['middleName'];
    $lname  = $post['lastName'];
    $bal    = $post['balance'];

    $user = new User;
    $user->setFirstName($fname);
    $user->setMiddleName($mname);
    $user->setMiddleName($lname);
    $user->setPin($pin);
    $user->setPassword($pass);
    $user->setBalance($bal);
    return $user;
}

// Parse a post request into a target user
function parse_target($post) {
    $targetPin  = $_POST['targetPin'];
    $targetPass = $_POST['targetPass'];

    // Initialize Target User
    $target = New User;
    $target->setPin($targetPin);
    $target->setPassword($targetPass);
    return $target;
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

// Withdraws money from a user's balance in our database
function withdraw($pdo, $amount, $user) {
    // If we have money
    if ($amount <= $user->getBalance()) {
        // Take some of it out
        $newbalance = $user->getBalance() - $amount;
        $query = "UPDATE USERS SET balance=$newbalance WHERE pin=$user->pin";
        $results = mysqli_query($pdo, $query);

        $success = ("Withdrawal of Amount $" . $amount . " made.\n");
        if (checkResult ($success, "", $results, $query, $pdo)) {
            // Update Log
        } else {
            // Log Error
        }
    } else if ($amount > $user->getBalance()) {
        // Process the transaction with an overdraft
        $newbalance = $user->getBalance()- $amount;
        $query = "UPDATE USERS SET balance=$newbalance WHERE pin=$user->getPin()";
        $results = mysqli_query($pdo, $query);

        // Process overdraft
        $newbalance = $newbalance - 25.0;
        $query = "UPDATE USERS SET balance=$newbalance WHERE pin=$user->getPin() AND password='$user->getPassword()'";
        
        $success = "A bank overdraft fee of $25 will be charged to your account. We thank you for your business.\n";
        // Log overdraft message
    }
}

// Deposits some amount of money into a user's balance
function deposit($pdo, $amount, $user) {
    if ($amount > 0) {
        // Add the amount to our user's balance
        $newbalance = $user->getBalance() + $amount;
        $query = "UPDATE USERS SET balance=$newbalance WHERE pin=$user->getPin()"; 
        $results = mysqli_query($pdo, $query);

        $success = "Deposit of Amount $" . $amount . " made.\n";
        if (checkResult ($success, "", $results, $query, $pdo)) {
            // Update Log
        } else {
            // Log Error
        }
    } else if ($amount < 0) {
        $message = ("Deposit unsuccessful: invalid amount.\n");
        // Log error
    }
}

// Returns true if the user was found in the database and false otherwise
function user_exists($pdo, $pin) {
    $query = "SELECT * FROM USERS WHERE pin LIKE $pin";
    $results = mysqli_query($pdo, $query);
    if ($results > 0)
        return TRUE;
    else
        return FALSE;
}

// Returns the user(s) found in the database
// Assume that only one user is ever found in the database
function get_user($pdo, $pin) {
    $query = "SELECT * FROM USERS WHERE pin LIKE $pin";
    $results = mysqli_query($pdo, $query);
    return $results;
}

// Transfer funds from the target account to our account
function transfer_from($pdo, $amount, $target, $user) {
    // Assert the pin number exists in our database
    if (!user_exists($pdo, $target->getPin())) {
        // Log Error
        return FALSE;
    }

    // Query database for the user's balance
    $targetUser = get_user($pdo, $target->getPin());
    $targetBalance = mysqli_fetch_field($targetUser, "balance");

    // Set our target's balance
    $target->setBalance($targetBalance);

    // Execute withdrawal
    withdraw($pdo, $amount, $target);

    // Deposit into our account
    deposit($pdo, $amount, $user);
}

// Reset a user's password
function reset_password($pdo, $newpass, $user) {
    $query = "UPDATE USERS SET password='$newpass' WHERE pin=$user->getPin()";
    $results = mysqli_query($pdo, $query);

    $success = "Password successfully updated.\n";
    $fail = "Password Reset Unsuccessful . Please Try Again.\n";
    if (checkResult ($success, "", $results, $query, $pdo)) {
        // Update Log
    } else {
        // Log Error
    }
}

function reset_account($pdo, $user) {
    $query = "UPDATE USERS SET balance=0.0 WHERE pin=$user->pin"; 
    $results = mysqli_query($pdo, $query);

    $success = "Account successfully emptied.";
    $fail = "Account failed to empty.";
    $message = "So much for \"Leaving something for a rainy day!\"\n";
    if (checkResult ($success, $fail, $results, $query, $pdo)) {
        // Update Log
    } else {
        // Log Error
    }
}

?>
