<?php
include ('/var/www/furmazon_db_cfg.php');
include ('../inc/accounts.php');
$result = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passwordv'])) {
        $result = 'Please fill out the fields.';
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordv = $_POST['passwordv'];
        if ($password == $passwordv) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $result = 'Passwords do not match.';
            return false;
        }
        $account = new Account($mysqli);
        $result = $account->register($username, $password);
    }
}

?>