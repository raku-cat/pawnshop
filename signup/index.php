<?php
include ('signup.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Furmazon - Register</title>
        <link rel="stylesheet" type="text/css" href="/furmazon/layout.css">
    </head>
    <body>
        <div>
            <span><?php echo $result; ?></span>
            <form action="" method="post">
                <input name="username" id="user" placeholder="Username" type="text">
                <input name="password" id="pass" placeholder="Password" type="password">
                <input name="passwordv" id="pass" placeholder="Repeat Password" type="password">
                <input name="submit" id="submit" type="submit" value="Register">
            </form>
       </div>
    </body>
</html>