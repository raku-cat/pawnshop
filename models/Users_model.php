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
    public function check_login($email, $password) {
        $this->db->select('password');
        $this->db->from('accounts');
        $this->db->where('email', $email);
        $hash = $this->db->get()->row()->password;
        return $this->verify_password($password, $hash);
    }
    public function get_user_id($email) {
        $this->db->select('id');
        $this->db->from('accounts');
        $this->db->where('email', $email);
        return $this->db->get()->row()->id;
    }
    public function get_user($user_id) {
        $this->db->from('accounts');
        $this->db->where('id', $user_id);
        return $this->db->get();
    }
    private function hash_password($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    private function verify_password($password, $hash) {
        return password_verify($password, $hash);
    }
}