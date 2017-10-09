<?php
include ("session.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Furmazon - My Account</title>
        <link rel="stylesheet" type="text/css" href="layout.css">
    </head>
    <body>
        <div id="profile">
            <b id="welcome">Welcome : <i><?php echo $login_session . " Your rank is " . $rank; ?></i></b><br>
            <b id="logout"><a href="logout.php">Log Out</a></b>
            <?php
            if($rank == 'admin'){
                echo
                "<h2>You're special so you get a cat</h2><br>
                 <img src='cat.jpg'>";
            }
            ?>
        </div>
    </body>
</html>