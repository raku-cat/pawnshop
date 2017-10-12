<?php

class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'html'));
    }
    public function index() {
        $data['title'] = 'Home';

        $this->load->view('templates/header', $data);
        $this->load->view('home');
        $this->load->view('templates/footer');

    }
    public function login() {
        $data['title'] = 'Login';

        $this->load->view('templates/header');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (form_validation->run() === FALSE) {
            $this->load->view('login');
        }
    }
}