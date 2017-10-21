<?php

class Accounts extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','html','form'));
        $this->load->model('users_model');
    }

    public function login() {
        $data['title'] = 'Login';

        $this->load->view('layouts/header', $data);

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('accounts/login/login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->users_model->check_login($email, $password)) {
                $user_id = $this->users_model->get_user_id($email);
                $user = $this->users_model->get_user($user_id)->row();

                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $user->username;
                $_SESSION['logged_in'] = true;
                header ('location: /pawnshop-dev');
            } else {
                $data['error'] = 'Invalid username or password';
                $this->load->view('accounts/login/login', $data);
            }
        }
        $this->load->view('layouts/footer');
    }
    public function signup() {
        $data['title'] = 'Sign Up';

        $this->load->view('layouts/header', $data);
        $this->load->model('invites_model');

        if (isset($_SESSION['invite_code'])) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[accounts.email]', array('is_unique' => 'This email is already registered.'));
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|less_than_equal_to[32]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('password_confirm', 'Confirm password', 'trim|required|matches[password]', array('matches' => 'Passwords do not match'));
            if (isset($_SESSION['email'])) {
                $data['email'] = $_SESSION['email'];
            }

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('accounts/signup/signup', $data);
            } else {
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $code = $_SESSION['invite_code'];
                if ($this->invites_model->check($email) && $this->users_model->create_user($email, $username, $password) && $this->invites_model->consume($code)) {
                    $this->session->sess_destroy();
                    $this->load->view('accounts/signup/signupSuccess');
                } else {
                    $data['error'] = 'An error occured, your invite may have expired or you used a different email than the one you were invited with';
                    $this->load->view('accounts/signup/signup', $data);
                }
            }
        } else {
            if (isset($_GET['invite_code'])) {
                $this->form_validation->set_data($_GET);
            }
            $this->form_validation->set_rules('invite_code', 'Invite code', array('trim', 'required', 'exact_length[40]', array('invite_valid', array($this->invites_model, 'exists'))));
            $this->form_validation->set_message('invite_valid', 'Invalid invite');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('accounts/signup/access');
            } else {
                $_SESSION['invite_code'] = isset($_GET['invite_code']) ? $_GET['invite_code'] : $this->input->post('invite_code');
                $this->session->mark_as_temp('invite_code', 180);
                if (isset($_GET['email'])) {
                    $_SESSION['email'] = $_GET['email'];
                    $this->session->mark_as_temp('email', 180);
                }
                header ('location: ' . $this->uri->uri_string());
            }
        }
        $this->load->view('layouts/footer');
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