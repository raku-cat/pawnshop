<?php

class Listings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->model(array('users_model', 'listings_model'));
    }
    public function index() {
        $data['title'] = 'Listings';
        $this->load->view('layouts/header', $data);

        $data['listings_array'] = $this->listings_model->get();
        $this->load->view('listings/index', $data);

        $this->load->view('layouts/footer');
    }
    public function view($id) {
        $listing_array = $this->listings_model->get($id);
        $data['title'] = $listing_data['title'];
        $data['listing_data'] = $listing_data;
    }
    public function create() {
        $data['title'] = 'New listing';
        $this->load->view('layouts/header', $data);

        $this->form_validation->set_rules('form_listing_title', 'Title', 'trim|required|alpha_numeric_spaces|max_length[128]');
        $this->form_validation->set_rules('form_listing_description', 'Description', 'trim|alpha_numeric_spaces');
        $this->form_validation->set_rules('form_listing_price', 'Price', 'trim|required|decimal');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('listings/create', $data);
        } else {
            if ($_FILES['form_listing_image']['error'] == 0) {
                $upload_config['upload_path'] = './userdata/' . $_SESSION['user_id'] . '/images';
                $upload_config['allowed_types'] = 'jpg|png|gif';
                $upload_config['max_size'] = '25000';
                $upload_config['encrypt_name'] = TRUE;
                $this->load->library('upload', $upload_config);
                if ( ! $this->upload->do_upload('listing_image')) {
                    $data['error'] = $this->upload->display_errors('<span>', '</span>');
                    $this->load->view('listings/create', $data);
                } else {
                    $this->load->library('image_lib');
                    $image_path = $this->upload->data('full_path');
                    $image_file_path = $this->upload->data('file_path');
                    $image_raw_name = $this->upload->data('raw_name');
                    $image_ext = $this->upload->data('file_ext');
                    $wm_config['source_image'] = $image_path;
                    $wm_config['wm_text'] = 'Copyright ' . $_SESSION['username'] . ' – ' . date('Y');
                    $wm_config['wm_type'] = 'text';
                    if ($this->upload->data('image_width') > 720 || $this->upload->data('image_height') > 480) {
                        $resize_config['source_image'] = $image_path;
                        $resize_config['width'] = 720;
                        $resize_config['height'] = 480;
                    }
                    $thumb_config['source_image'] = $image_path;
                    $thumb_config['width'] = 160;
                    $thumb_config['height'] = 120;
                    $thumb_config['create_thumb'] = TRUE;
                    $this->image_lib->intialize($wm_config);
                    if ( ! $this->image_lib->watermark() ) {
                        $data['error'] = $this->image_lib->display_errors('<span>', '</span>');
                        $this->load->view('listings/create', $data);
                    }
                    if (isset($resize_config)) {
                        $this->image_lib->initialize($resize_config);
                        if ( ! $this->image_lib->resize() ) {
                            $data['error'] = $this->image_lib->display_errors('<span>', '</span>');
                            $this->load->view('listings/create', $data);
                        }
                    }
                    $this->image_lib->initialize($thumb_config);
                    if ( ! $this->image_lib->resize() ) {
                        $data['error'] = $this->image_lib->display_errors('<span>', '</span>');
                        $this->load->view('listings/create', $data);
                    }
                }
            }
            $title = $this->input->post('form_listing_title', true);
            if ($this->input->post('form_listing_description') !== NULL) {
                $description = $this->input->post('form_listing_description', true);
            } else {
                $description = '';
            }
            $price = $this->input->post('form_listing_price');
            if ($this->input->post('form_listing_nsfw') !== NULL) {
                $nsfw = 1;
            } else {
                $nsfw = 0;
            }
            $slug = url_title($title);
            if (strlen($slug) > 40) {
                $slug = rtrim(substr($slug, 0, 40), '-');
            }
            $listing_array = array(
                            'slug' => $slug,
                            'user_id' => $_SESSION['user_id'],
                            'title' => $title,
                            'description' => $description,
                            'nsfw' => $nsfw,
                            'price' => $price
                        );
            if (isset($image_path)) {
                $listing_array['image'] = $image_path;
                $listing_array['image_thumb'] = $image_file_path.$image_raw_name.'_thumb'.$image_ext;
            }
            if ($this->listings_model->create($listing_array)) {
                $data['success'] = 'Your listing has been created!';
                $this->load->view('listings/index', $data);
            } else {
                $data['error'] = 'Something went wrong submitting your post, sorry!';
                $this->load->view('listings/create', $data);
            }
        }
    }
}
