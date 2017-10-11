<?php
include_once ('signup.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Paw'n'Shop - Register</title>
        <link rel="stylesheet" type="text/css" href="/pawnshop/layout.css">
    </head>
    <body>
        <div>
            <span><?php echo $result; ?></span>
            <form action="" method="post">
                <input name="username" id="user" placeholder="Username" type="text">
                <input name="password" id="pass" placeholder="Password" type="password">
                <input name="passwordv" id="pass" placeholder="Repeat Password" type="password">
                <input name="signup" id="signup" type="submit" value="Sign Up">
            </form>
       </div>
    </body>
</html>