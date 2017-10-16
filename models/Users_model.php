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
        $hash_query = $this->db->get();
        if ($hash_query->num_rows() == 1) {
            $hash = $hash_query->row()->password;
            return $this->verify_password($password, $hash);
        } else {
            return FALSE;
        }
    }
    public function get_user_id($email) {
        $this->db->select('id');
        $this->db->from('accounts');
        $this->db->where('email', $email);
        $id_query = $this->db->get();
        if ($id_query->num_rows() == 1) {
            return $id_query->row()->id;
        } else {
            return FALSE;
        }
    }
    public function get_user($user_id) {
        $this->db->from('accounts');
        $this->db->where('id', $user_id);
        $user = $this->db->get();
        if ($user->num_rows() == 1) {
            return $user;
        } else {
            return FALSE;
        }
    }
    private function hash_password($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    private function verify_password($password, $hash) {
        return password_verify($password, $hash);
    }
}