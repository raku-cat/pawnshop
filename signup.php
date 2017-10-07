<?php
include ('../../furmazon_db_cfg.php');

$error = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passwordv'])) {
        $error = 'Please fill out the fields.';
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordv = $_POST['passwordv'];
        if ($password == $passwordv) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $error = 'Passwords do not match.';
            return false;
        }
        $mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
        unset ($db_user, $db_pass);
        $exists = $mysqli->prepare("SELECT username FROM accounts WHERE username = ?");
        $exists->bind_param('s', $username);
        $exists->execute();
        $exists->store_result();
        if ($exists->num_rows == 1) {
            $error='User exists, did you mean to <a href="index.php">log in</a>?';
        } else {
            $submit = $mysqli->prepare('INSERT INTO `accounts` (`username`,`password`) VALUES (?,?)');
            $submit->bind_param('ss', $username, $password);
            $submit->execute();
            $error = 'Registration succesful.';
        }
        $mysqli->close();
    }
}

?>