<?php
include_once ('/var/www/common.php');
include_once ( ROOT_PATH . 'inc/codes.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paw'n'Shop - My Account</title>
        <?php include_once ( ROOT_PATH . 'inc/style_includes.php'); ?>
    </head>
    <body>
    <?php if(isset($login_session)) :?>
        <div id="profile">
            <b id="welcome">Welcome : <i><?php  echo $login_session . "</i> Your rank is " . $rank; ?></b><br>
            <b id="logout"><a href="/pawnshop/logout.php">Log Out</a></b><br>
            <?php $listcodes = new Codes($mysqli); $codearray = $listcodes->get($login_session); if (!empty($codearray)) : ?>
            <table class="codes">
            <?php
            foreach ($codearray as $key=>$code) {
                echo "<tr><td>" . $code . "</td></tr>";
            }
            ?>
            </table>
            <?php endif; ?>
            <?php if ($rank == 'admin') : ?>
            <h2>You're special so you get a cat</h2><br>
            <img src='/pawnshop/cat.jpg'>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <h1>You need to be logged in</h1>
    <?php endif; ?>
    </body>
</html>
