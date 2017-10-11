<?php

include_once ('/var/www/common.php');

$error='';
if (isset($_POST['login'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error='Empty input';
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $get_user = $mysqli->prepare('SELECT password FROM accounts WHERE username = ?');
        $get_user->bind_param('s', $username);
        $get_user->execute();
        $get_user->bind_result($hash);
        $get_user->fetch();
        if ( password_verify($password, $hash) ) {
            $_SESSION['login_user'] = $username;
            header ("location: .");
        } else {
            $error='Invalid Username or Password.';
        }
    }
}

?>