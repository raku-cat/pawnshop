<?php
include ('/var/www/furmazon_db_cfg.php');

session_start();
$user_check = $_SESSION['login_user'];

$get_user = $mysqli->prepare('SELECT username,rank FROM accounts WHERE username=?');
$get_user->bind_param('s', $user_check);
$get_user->execute();
$get_user->bind_result($user, $rank);
$get_user->fetch();
if ($user && $rank) {
    $login_session = $user;
}
if (!isset($login_session)){
    header ('location: /furmazon/');
}

?>


