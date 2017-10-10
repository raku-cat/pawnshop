<?php
include ("session.php");
include ('../inc/codes.php');
include ('/var/www/furmazon_db_cfg.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Furmazon - My Account</title>
        <link rel="stylesheet" type="text/css" href="/furmazon/layout.css">
    </head>
    <body>
        <div id="profile">
            <b id="welcome">Welcome : <i><?php echo $login_session . "</i> Your rank is " . $rank; ?></b><br>
            <b id="logout"><a href="/furmazon/logout.php">Log Out</a></b><br>
            <span><?php $listcodes = new Codes($mysqli); echo $listecodes->getcodes($login_session);?></span>
            <?php if ($rank == 'admin') : ?>
            <h2>You're special so you get a cat</h2><br>
            <img src='/furmazon/cat.jpg'>
            <?php endif; ?>
        </div>
    </body>
</html>