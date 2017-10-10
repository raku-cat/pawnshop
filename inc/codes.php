<?php

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
    }
    function get($username) {
        $getcode = $this->mysqli->prepare('SELECT `code` FROM `access_codes` WHERE user = ?');
        $getcode->bind_param('s', $username);
        $getcode->execute();
        $codes = array();
        $getcode->bind_result($code);
        while ( $getcode->fetch() ) {
            $codes[] = $code;
        }
        return $codes;
    }
    function check($code) {
        $getcode = $this->mysqli->prepare('SELECT `code` FROM `access_codes` WHERE `code` = ?');
        $getcode->bind_param('s', $code);
        $getcode->execute();
        $getcode->bind_result($exists);
        $getcode->fetch();
        if ($exists) {
            return true;
        } else {
            return false;
        }
    }
}

?>