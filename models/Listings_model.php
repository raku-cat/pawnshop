<?php

class Listings_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get($id = FALSE) {
        if ($id === FALSE) {
            $this->db->select('listings.*, accounts.username');
            $this->db->from('listings');
            $this->db->join('accounts', 'accounts.id = listings.user_id');
            $listings = $this->db->get();
            return $listings->result_array();
        }
    }
    public function create($listing_array) {
        return $this->db->insert('listings', $listing_array);
    }
}
