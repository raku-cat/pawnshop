<?php

class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'html'));
    }
    public function index() {
        $data['title'] = 'Home';

        $this->load->view('layoutss/header', $data);

        $this->load->library('session');
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $data['username'] = $_SESSION['username'];
            $this->load->view('home', $data);
        } else {
            $this->load->view('logged_out');
        }

        $this->load->view('layouts/footer');

    }
}