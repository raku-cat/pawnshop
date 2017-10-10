<?php

include ('/var/www/furmazon_db_cfg.php');

session_start();
$error='';
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error='Invalid Username or Password';
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $get_user = $mysqli->prepare('SELECT password FROM accounts WHERE username=?');
        $get_user->bind_param('s', $username);
        $get_user->execute();
        $get_user->bind_result($hash);
        $get_user->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['login_user'] = $username;
            header ("location: profile.php");
        } else {
            $error='Invalid Username or Password.';
        }
        $get_user->close();
        $mysqli->close();
    }
}

?>