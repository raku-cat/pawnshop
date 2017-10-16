<?php

class Invites_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function generate($user_id, $email) {
            $code = sha1(uniqid($email, true));
            $invite = array(
                        'id' => $user_id,
                        'code' => $code,
                        'email' => $email
                        );
            return $this->db->insert('invites', $invite);
    }
    public function exists($code) {
        $this->db->from('invites');
        $this->db->where('code', $code);
        $code_exists = $this->db->get();
        if ($code_exists->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function consume($code) {
        $this->db->from('invites');
        $this->db->where('code', $code);
        return $this->db->delete();
    }
    public function get($email) {
        $this->db->select('code');
        $this->db->from('invites');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row()->code;
        } else {
            return FALSE;
        }
    }
    public function check($email) {
        $this->db->from('invites');
        $this->db->where('email', $email);
        $email_exists = $this->db->get();
        if ($email_exists->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function send($username, $email, $code) {
        $this->load->library('email');
        $this->email->from('donotreply@raku.party');
        $this->email->to($email);
        $this->email->subject('You\'re invited to Paw\'n\'Shop!');
        $data['username'] = $username;
        $data['email'] = $email;
        $data['code'] = $code;
        $this->email->message($this->load->view('email/invite_email', $data, true));
        return $this->email->send();
    }
    public function decrement($user_id, $invites_left) {
        $invites_left = $invites_left - 1;
        $user_data = array(
                    'invites_left' => $invites_left
                    );
        $this->db->where('id', $user_id);
        $this->db->update('accounts', $user_data);
    }
}