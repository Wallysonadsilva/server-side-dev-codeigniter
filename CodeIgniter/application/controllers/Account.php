<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); // Load the User model
        $this->load->library('session');  // Load session library
        $this->load->library('form_validation'); // Load the form validation library
        $this->load->helper('url'); // Load helper for URL and redirect

        // Prevent back button from showing sensitive data after logout
        $this->output->set_header('Cache-Control: no store, no cache, must-revalidate');
        $this->output->set_header('Pragma: no cache');
    }

    public function login_register()
    {
        $this->load->view('login_register');
    }

    public function register()
    {
        // Set form validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[Users.email]');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Form validation has errors
            $this->load->view('register', ['errors' => validation_errors()]); // Load your registration view with errors
        } else {
            // Form validation was successful
            $data = array(
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'bio' => $this->input->post('bio')
            );

            if ($this->User_model->register($data)) {
                // Registration success
                $this->session->set_userdata('user_id', $this->db->insert_id());
                redirect('/'); // Redirect to homepage or dashboard
            } else {
                // Registration failed
                $this->load->view('register', ['errors' => 'Unable to register. Please try again.']);
            }
        }
    }

    public function login()
    {
        $this->load->library('form_validation');

        // Set form rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            // If validation fails or it's a fresh visit to the login form
            $data['errors'] = validation_errors();
        } else {
            // Form is valid, proceed to check credentials
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->User_model->login($email, $password);

            if ($user) {
                // Credentials are correct, set user session
                $this->session->set_userdata('user_id', $user->id);
                redirect('home');  // Redirect to a dashboard or home page
            } else {
                // Credentials are incorrect, set error message
                $data['errors'] = 'Invalid email or password.';
                // Load the login view with any errors
                $this->load->view('login_register', $data);
            }
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy(); // This destroys the session completely
        redirect('account/login_register'); // Redirect to the login page or wherever you see fit
    }

    public function get_user_info()
    {
        try {
            $user_id = $this->session->userdata('user_id');
            if (!$user_id) {
                echo json_encode(['error' => 'User not logged in']);
                return;
            }

            $user_info = $this->User_model->get_user_by_id($user_id);
            if ($user_info) {
                echo json_encode(['username' => $user_info->username]);
            } else {
                echo json_encode(['error' => 'User not found']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error in get_user_info: ' . $e->getMessage());
            echo json_encode(['error' => 'Server error occurred']);
        }
    }
}
