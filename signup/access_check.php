<?php
include ('/var/www/furmazon_db_cfg.php');
include ('../inc/codes.php');

if (isset($_POST['submit'])) {
    $access_code = $_POST['access_code'];
    $checkcode = new Codes($mysqli);
    $result = $checkcode->check($access_code);
    $_SESSION['valid_code'] = $access_code;
}

?>