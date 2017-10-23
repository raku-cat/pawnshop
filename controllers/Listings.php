<?php

class Listings extends CI_Controller {
    public function __construct() {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        parent::__construct();
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->model(array('users_model', 'listings_model'));
    }
    public function index() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
            $data['title'] = 'Listings';
            $this->load->view('layouts/header', $data);

            $data['listings_array'] = $this->listings_model->get();
            $this->load->view('listings/index', $data);

            $this->load->view('layouts/footer');
        } else {
            redirect ('/');
        }
    }    
    public function view($id = NULL, $slug = NULL) {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
            $listings_array = $this->listings_model->get($id);
            if (empty($listings_array)) {
                show_404();
            }
            if ( $slug != $listings_array['slug'] ) {
                $url = explode('/', uri_string());
                array_pop($url);
                $url = implode('/', $url);
                redirect ($url . '/' . $listings_array['slug']);
            }
            $data['title'] = $listings_array['title'];
            $this->load->view('layouts/header', $data);
            $data['listings_array'] = $listings_array;
            $this->load->view('listings/view', $data);
            $this->load->view('layouts/footer');
        } else {
            redirect ('/');
        }
    }
    public function create() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
            $data['title'] = 'New listing';
            $this->load->view('layouts/header', $data);
    
            $this->form_validation->set_rules('form_listing_title', 'Title', 'trim|required|alpha_numeric_spaces|max_length[128]');
            $this->form_validation->set_rules('form_listing_description', 'Description', 'trim|callback_alpha_dash_spaces');
            $this->form_validation->set_rules('form_listing_price', 'Price', 'trim|required|callback_currency_validate');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('listings/create/index', $data);
            } else {
                if ($_FILES['form_listing_image']['error'] == 0) {
                    $upload_config['upload_path'] = './userdata/' . $_SESSION['user_id'] . '/images/';
                    if (!file_exists($upload_config['upload_path'])) {
                        mkdir($upload_config['upload_path'], 0777, true);
                    }
                    $upload_config['allowed_types'] = 'jpg|png|gif';
                    $upload_config['max_size'] = '25000';
                    $upload_config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $upload_config);
                    if ( ! $this->upload->do_upload('form_listing_image')) {
                        $data['error'] = $this->upload->display_errors('<span>', '</span>');
                        $this->load->view('listings/create/index', $data);
                        return FALSE;
                    } else {
                        $this->load->library('image_lib');
                        $image_path = $this->upload->data('full_path');
                        $image_file_path = $this->upload->data('file_path');
                        $image_raw_name = $this->upload->data('raw_name');
                        $image_ext = $this->upload->data('file_ext');
                        $image_name = $this->upload->data('file_name');
                        $upload_path = mb_substr($upload_config['upload_path'],2);
                        $wm_config['source_image'] = $image_path;
                        $wm_config['wm_text'] = 'Copyright ' . $_SESSION['username'] . ' - ' . date('Y');
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
                        $thumb_config['new_image'] = $image_file_path.$image_raw_name.'_thumb'.$image_ext;
                        if (isset($resize_config)) {
                            $this->image_lib->initialize($resize_config);
                            if ( ! $this->image_lib->resize() ) {
                                $data['error'] = $this->image_lib->display_errors('<span>', '</span>');
                                $this->load->view('listings/create/index', $data);
                                return FALSE;
                            }
                        }
                        $this->image_lib->initialize($wm_config);
                        if ( ! $this->image_lib->watermark() ) {
                            $data['error'] = $this->image_lib->display_errors('<span>', '</span>');
                            $this->load->view('listings/create/index', $data);
                            return FALSE;
                        }
                        $this->image_lib->initialize($thumb_config);
                        if ( ! $this->image_lib->resize() ) {
                            $data['error'] = $this->image_lib->display_errors('<span>', '</span>');
                            $this->load->view('listings/create/index', $data);
                            return FALSE;
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
                                'price' => money_format('%!i', $price)
                            );
                if (isset($image_path)) {
                    $listing_array['image'] = $upload_path.$image_name;
                    $listing_array['image_thumb'] = $upload_path.$image_raw_name .'_thumb'.$image_ext;
                }
                if ($this->listings_model->create($listing_array)) {
                    $this->session->set_flashdata('success','TRUE');
                    redirect ('/listings');
                } else {
                    $data['error'] = 'Something went wrong creating your listing, sorry!';
                    $this->load->view('listings/create/index', $data);
                }
            }
        } else {
            redirect ('/');
        }
    }
    public function alpha_dash_spaces($str) {
        if ( !preg_match('/^[a-z .,\-\']*$/i',$str)) {
            $this->form_validation->set_message('alpha_dash_spaces', 'Description can only contain alphanumeric characters, spaces, dashes, periods, and commas.'); 
            return false;
        } else {
            return true;
        }
    }
    public function currency_validate($int) {
        if ( !preg_match('/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/', $int)) {
            $this->form_validation->set_message('currency_validate', 'You entered an invalid price value.');
            return false;
        } else {
            return true;
        }
    }
}
