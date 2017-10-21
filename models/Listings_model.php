<?php

class Listings_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get($id = FALSE) {
        if ($id === FALSE) {
            $listings = $this->db->get('listings');
            return $listings->result_array();
        }
    }
    public function create($listing_array) {
        return $this->db->insert('listings', $listing_array);
    }
}
