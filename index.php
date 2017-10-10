<?php
session_start();
if (isset($_SESSION['login_user'])) {
    include ('main.php');
} else {
    include ('login.php');
}

?>
