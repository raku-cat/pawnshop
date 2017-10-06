<?php
include ('../../furmazon_db_cfg.php');

$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
unset ($db_user, $db_pass);

$user_check = $_SESSION['login_user'];

if ($get_user = $mysqli->query("SELECT from accounts where username='$user_check'")) {
    $row = $get_user->fetch_assoc();
    $login_session = $row['username'];
    $get_user->free();
}
if (!isset($login_session)){
    $mysqli->close();
    header ('location: index.php');
}
?>


