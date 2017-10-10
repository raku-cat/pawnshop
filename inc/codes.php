<?php

include ('/var/www/furmazon_db_cfg.php');

class Codes {
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    function generate($username, $count = 1) {
        foreach(range(1 ,$count) as $index) {
            $code = sha1(uniqid($username, true));
            $addcode = $this->mysqli->prepare('INSERT INTO `access_codes` (code, user) VALUES (?, ?)');
            $addcode->bind_param('ss', $code, $username);
            $addcode->execute();
        }
        $mysqli->close();
    }
    function get($username) {
        $getcode = $this->mysqli->prepare('SELECT `code` FROM `access_codes` WHERE `user`=?');
        $getcode->bind_param('s', $username);
        $getcode->execute();
        $getcode->bind_result($code);
        $getcode->fetch();
        return $code;
        $this->mysqli->close();
    }
}

?>