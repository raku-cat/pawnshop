<?php
session_start();

if (isset($_SESSION['valid_code'])) {
    $access_code = $_SESSION['valid_code'];
    include_once ('register.php');
} else {
    include_once ('access.php');
}
?>
