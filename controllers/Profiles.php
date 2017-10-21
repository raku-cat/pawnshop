<?php

class Profiles extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model(array('users_model', 'listings_model', 'profiles_model'));
    }
    public function index() {
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
}