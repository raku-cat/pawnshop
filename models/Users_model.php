<?php

class Users_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function create_user($email, $username, $password) {
        $userinfo = array(
                    'email' => $email,
                    'username' => $username,
                    'password' => $this->hash_password($password),
                    );
        return $this->db->insert('accounts', $userinfo);
    }
    private function hash_password($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    private function verify_password($password, $hash) {
        return password_verify($password, $hash);
    }
}