<?php
include ('/var/www/furmazon_db_cfg.php');
include_once ('../inc/accounts.php');
include_once ('../inc/codes.php');
$result = '';

if (isset($_POST['signup'])) {
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passwordv'])) {
        $result = 'Please fill out the fields.';
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordv = $_POST['passwordv'];
        if ($password == $passwordv) {
            $account = new Account($mysqli);
            $code = new Codes($mysqli);
            $check = $code->check($access_code);
            if($check) {
                $result = $account->register($username, $password);
                $code->consume($access_code);
                session_destroy();
            } else {
                $result = 'Sorry, your code is no longer valid, you will be redirected in 5 seconds';
                session_destroy();
                sleep(5);
                header ('location: index.php');
            }
        } else {
            $result = 'Passwords do not match.';
            return false;
        }
    }
}

?>