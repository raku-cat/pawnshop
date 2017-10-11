<?php
include_once ('/var/www/common.php');
include_once ('signup.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Paw'n'Shop - Register</title>
        <?php include_once ( ROOT_PATH . 'inc/style_includes.php'); ?>
    </head>
    <body>
    <?php if (isset($_SESSION['valid_code'])) : ?>
        <div>
            <span><?php echo $result; ?></span>
            <form action="" method="post">
                <input name="username" id="user" placeholder="Username" type="text">
                <input name="password" id="pass" placeholder="Password" type="password">
                <input name="passwordv" id="pass" placeholder="Repeat Password" type="password">
                <input name="signup" id="signup" type="submit" value="Sign Up">
            </form>
       </div>
    <?php else : ?>
        <h1>You arent authorized to view this page</h1>
    <?php endif; ?>
    </body>
</html>