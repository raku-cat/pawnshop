<?php
include_once ('login_action.php');
include_once ('/var/www/common.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paw'n'Shop - Buy and sell art the modern way</title>
        <?php include_once (ROOT_PATH . 'inc/style_includes.php'); ?>

    </head>
    <body>
        <div class="header">
            <h1><img src='logo.jpg'></h1>
        </div>
        <div class="login">
            <span><?php echo $error; ?></span>
            <form action="" method="post">
                <table>
                    <tr>
                        <td align="left"><input id="user" name="username" placeholder="username" type="text"></td>
                    </tr>
                    <tr>
                        <td align="left"><input id="pass" name="password" placeholder="password" type="password"></td>
                    </tr>
                    <tr>
                        <td><input id="login" name="login" type="submit" value="login"></td>
                    </tr>
                </table>
            </form>
            <a href="signup">Sign Up</a>
        </div>
    </body>
</html>