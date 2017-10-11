<?php
include_once ('/var/www/common.php');
include_once ( ROOT_PATH . 'inc/sessions.php');
include_once ( ROOT_PATH . 'inc/accounts.php');
session_start();

if (isset($_SESSION['login_user'])) {
    $user = $_SESSION['login_user'];
    $session = new Sessions($mysqli);
    if ($session->validate($user)) {
        $login_session = $user;
        $account = new Account($mysqli);
        $rank = $account->getrank($user);
        include_once ('profile.php');
    } else {
        echo '<h1>You need to be logged in</h1>';
    }
} else {
    echo '<h1>You need to be logged in</h1>';
}
?>