<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

        // Prevent back button from showing sensitive data after logout
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Pragma: no-cache');
    }

    public function startpage()
    {
        $this->load->view('startpage');
    }

    public function register()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $email = $this->input->post('email', true);
        $username = $this->input->post('username', true);

        // Check for existing email
        if ($this->User_model->is_email_taken($email)) {
            echo json_encode(['status' => 'error', 'message' => 'An account with this email already exists.']);
            return;
        }

        // Check for existing username
        if ($this->User_model->is_username_taken($username)) {
            echo json_encode(['status' => 'error', 'message' => 'Username already exists. Please choose another one.']);
            return;
        }

        if ($this->form_validation->run() === false) {
            $errors = validation_errors('<li>', '</li>');
            echo json_encode(['status' => 'error', 'message' => '<ul>' . $errors . '</ul>']);
        } else {
            $data = [
                'email' => $email,
                'username' => $username,
                'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            ];

            if ($this->User_model->register($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Registration successful! You can now log in.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Unable to register. Please try again.']);
            }
        }
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === false) {
            $errors = validation_errors('<li>', '</li>');
            echo json_encode(['status' => 'error', 'message' => '<ul>' . $errors . '</ul>']);
        } else {
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);
            $user = $this->User_model->login($email, $password);

            if ($user) {
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('username', $user->username);
                echo json_encode(['status' => 'success', 'redirect' => site_url('homepage')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
            }
        }
    }

    public function get_user_info()
    {
        $username = $this->session->userdata('username');
        if ($username) {
            echo json_encode(['status' => 'success', 'username' => $username]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'username']);
        $this->session->sess_destroy();
        redirect('auth/startpage');
    }
}
