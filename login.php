<?php

include ('../../furmazon_db_cfg.php');

session_start();
$error='';
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error='Invalid Username or Password';
} else {

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
unset ($db_user, $db_pass);

$get_user = $mysqli->query("SELECT * FROM accounts where username='$username' AND password='$password'");
$get_row = $mysqli->affected_rows;
$get_user->close();

if($get_row == 1){
$_SESSION['login_user']=$username;
header ("location: profile.php");
} else {
$error='Invalid Username or Password.';
}
$mysqli->close();
}
}

?>