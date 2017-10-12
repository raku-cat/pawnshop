<?php

class Users extends CI_Controller {
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