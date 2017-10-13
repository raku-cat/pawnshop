<?php

class Codes_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function generate($count = 1, $email) {
            $this->db->select('id');
            $this->db->from('accounts');
            $this->db->where('email', $email);
            $id = $this->db->get();
            $id = $id->row()->id;
            $codes = array();
            foreach(range(1 ,$count) as $index) {
                $code = sha1(uniqid($email, true));
                $codes[] = array(
                            'code' => $code,
                            'id' => $id,
                            );
            }
            return $this->db->insert_batch('access_codes', $codes);
    }
    public function check($code) {
        $this->db->from('access_codes');
        $this->db->where('code', $code);
        $code_exists = $this->db->get();
        if ($code_exists->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function consume($code) {
        $this->db->from('access_codes');
        $this->db->where('code', $code);
        return $this->db->delete();
    }
}