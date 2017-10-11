<?php

include ('/var/www/root/pawnshop/inc/codes.php');

class Account {
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    function register($username, $password) {
        $exists = $this->mysqli->prepare("SELECT username FROM accounts WHERE username = ?");
        $exists->bind_param('s', $username);
        $exists->execute();
        $exists->store_result();
        if ($exists->num_rows == 1) {
            return 'User exists, did you mean to <a href="index.php">log in</a>?';
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $submit = $this->mysqli->prepare('INSERT INTO `accounts` (`username`,`password`) VALUES (?,?)');
            $submit->bind_param('ss', $username, $password);
            $submit->execute();
            $accode = new Codes($this->mysqli);
            $accode->generate($username, 3);
            return 'Registration Succesful';
        }
    }
    function getrank($username) {
        $getrank = $this->mysqli->prepare('SELECT `rank` FROM `accounts` WHERE `username` = ?');
        $getrank->bind_param('s', $username);
        $getrank->execute();
        $getrank->bind_result($rank);
        $getrank->fetch();
        return $rank;
    }
}

?>