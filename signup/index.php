<?php
session_start();

if( isset($_SESSION['valid_code']) ) {
    $access_code = $_SESSION['valid_code'];
    include ('register.php');
} else {
    include ('access.php');
}
?>
