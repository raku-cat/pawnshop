<?php
include ('login_action.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Furmazon - Buy and sell art the modern way</title>
        <link rel="stylesheet" type="text/css" href="/furmazon/layout.css">

    </head>
    <body>
        <div class="header">
            <h1>Furmazon</h1>
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
            <a href="/furmazon/signup">Sign Up</a>
        </div>
    </body>
</html>