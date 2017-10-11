<?php
include_once ('access_check.php');
?>
<html>
    <head>
        <title>Paw'n'Shop</title>
    </head>
    <body>
        <?php if(isset($error)) { echo "<span>" . $error . "</span>"; } ?>
        <form action="" method="post">
            <input name="access_code" id="access_code" placeholder="Access code" type="text">
            <input name="submit" id="submit" value="submit" type="submit">
        </form>
    </body>
</html>