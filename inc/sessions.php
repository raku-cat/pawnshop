<?php

class Sessions {
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    function validate($username) {
        $getuser = $this->mysqli->prepare("SELECT username FROM accounts WHERE username = ?");
        $getuser->bind_param('s', $username);
        $getuser->execute();
        $getuser->bind_result($user);
        $getuser->fetch();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}

?>