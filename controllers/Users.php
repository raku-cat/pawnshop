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

        $this->load->view('layouts/header', $data);

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('login/login');
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
                $this->load->view('login/login', $data);
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
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('password_confirm', 'Confirm password', 'trim|required|matches[password]', array('matches' => 'Passwords do not match'));
            if (isset($_SESSION['email'])) {
                $data['email'] = $_SESSION['email'];
            }

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('signup/signup', $data);
            } else {
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $code = $_SESSION['invite_code'];
                if ($this->invites_model->check($email) && $this->users_model->create_user($email, $username, $password) && $this->invites_model->consume($code)) {
                    $this->session->sess_destroy();
                    $this->load->view('signup/signupSuccess');
                } else {
                    $data['error'] = 'An error occured, your invite may have expired or you used a different email than the one you were invited with';
                    $this->load->view('signup/signup', $data);
                }
            }
        } else {
            if (isset($_GET['invite_code'])) {
                $this->form_validation->set_data($_GET);
            }
            $this->form_validation->set_rules('invite_code', 'Invite code', array('trim', 'required', 'exact_length[40]', array('invite_valid', array($this->invites_model, 'exists'))));
            $this->form_validation->set_message('invite_valid', 'Invalid invite');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('signup/access');
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
    public function profile() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $user = $this->users_model->get_user($_SESSION['user_id'])->row();
            $data['title'] = 'Profile';
            $data['username'] = $_SESSION['username'];
            $data['rank'] = $user->rank;
            $data['invites_left'] = $user->invites_left;
            $this->load->view('layouts/header', $data);
            if (isset($_POST['invite_email'])) {
                $this->form_validation->set_rules('invite_email', 'Email', 'trim|required|valid_email|is_unique[accounts.email]|is_unique[invites.email]', array('is_unique' => 'User is already registered or invited'));
                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('profile/profile', $data);
                } else {
                    $this->load->model('invites_model');
                    $invite_email = $this->input->post('invite_email');
                    $this->invites_model->generate($_SESSION['user_id'], $invite_email);
                    $code = $this->invites_model->get($invite_email);
                    if ($data['rank'] !== 'admin') {
                        $this->invites_model->decrement($_SESSION['user_id'], $data['invites_left']);
                        $data['invites_left'] = $data['invites_left'] - 1;
                    }
                    if ($this->invites_model->send($data['username'], $invite_email, $code)) {
                        $data['result'] = 'Invitation sent!';
                    } else {
                        $data['result'] = 'Something went wrong, tell an admin to get your invite back :(';
                    }
                    $this->load->view('profile/profile', $data);
                }
            } else {
                $this->load->view('profile/profile', $data);
            }
            $this->load->view('layouts/footer');
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