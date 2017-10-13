<?php

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','html','form'));
        $this->load->model('users_model');
    }

    public function login() {
        $data['title'] = 'Login';

        $this->load->view('templates/header', $data);

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->users_model->check_login($email, $password)) {
                $user_id = $this->users_model->get_user_id($email);
                $user = $this->users_model->get_user($user_id);

                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $user->username;
                $_SESSION['rank'] = $user->rank;
                $_SESSION['logged_in'] = true;
                header ('location: /pawnshop-dev');
            } else {
                $data['error'] = 'Invalid username or password';
                $this->load->view('login', $data);
            }
        }
        $this->load->view('templates/footer');
    }
    public function signup() {
        $data['title'] = 'Sign Up';

        $this->load->view('templates/header', $data);
        $this->load->model('codes_model');

        if (isset($_SESSION['access_code'])) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[accounts.email]', array('is_unique' => 'This email is already registered.'));
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('password_confirm', 'Confirm password', 'trim|required|min_length[8]|matches[password]', array('matches' => 'Passwords do not match'));

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('signup');
            } else {
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $code = $_SESSION['access_code'];
                if ($this->users_model->create_user($email, $username, $password) && $this->codes_model->check($code) && $this->codes_model->consume($code)) {
                    $this->codes_model->generate(3, $email);
                    $this->session->sess_destroy();
                    $this->load->view('signupSuccess');
                } else {
                    $data['error'] = 'An error occured, your code may have expired';
                    $this->load->view('signup', $data);
                }
            }
        } else {
            $this->form_validation->set_rules('access_code', 'Access code', 'trim|exact_length[40]', array('code_valid', array($this->codes_model, 'check')));
            $this->form_validation->set_message('code_valid', 'Invalid access code');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('access');
            } else {
                $_SESSION['access_code'] = $this->input->post('access_code');
                header ('location: ' . $this->uri->uri_string());
            }
        }
        $this->load->view('templates/footer');
    }
    public function profile() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $data['title'] = 'Profile';
            $data['username'] = $_SESSION['username'];
            $data['rank'] = $_SESSION['rank'];
            $this->load->model('codes_model');
            $codes = $this->codes_model->get($_SESSION['user_id']);
            if (!empty($codes)) {
                $data['codearray'] = $codes;
            }
            $this->load->view('templates/header', $data);
            $this->load->view('profile', $data);
            $this->load->view('templates/footer');
         } else {
            redirect('/');
         }
    }
    public function logout() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $this->session->sess_destroy();
            redirect('/');
        } else {
            redirect('/');
        }
    }
}