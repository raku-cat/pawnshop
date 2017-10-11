<html>
    <head>
        <title>Paw'n'Shop</title>
    <head>
    <body>
        <h1><img src='logo.jpg'></h1>
        <?php if (isset($_SESSION['login_user'])) : ?>
        <h2>Yaaay</h2>
        <a href="profile">Profile</a>
        <a href="logout.php">Log Out</a>
        <?php else : ?>
        <h2>You are not logged in</h2>
        <?php endif; ?>
    </body>
</html>