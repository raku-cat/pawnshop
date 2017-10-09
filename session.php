<?php
include ('../../furmazon_db_cfg.php');

$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
unset ($db_user, $db_pass);

session_start();
$user_check = $_SESSION['login_user'];

$get_user = $mysqli->prepare("SELECT username,rank FROM accounts WHERE username='$user_check'");
$get_user->execute();
$get_user->bind_result($user, $rank);
$get_user->fetch();
if ($user && $rank) {
    $login_session = $user;
}
if (!isset($login_session)){
    $mysqli->close();
    header ('location: index.php');
}
$get_user->close();
$mysqli->close();

?>


