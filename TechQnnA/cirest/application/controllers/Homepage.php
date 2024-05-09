<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homepage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Question_model');
        $this->load->library('session');
        $this->load->helper(['url', 'html']);
    }

    // when user login, load all data necessary for homepage
    public function index()
    {

        $this->load->view('homepage');
    }

    //redirect to about page and load trending questions
    public function about()
    {
        $this->load->view('about');
    }

    public function profile()
    {
        $this->load->view('profile');
    }

    public function edit_profile()
    {
        $this->load->view('edit_profile');
    }

    public function askquestion()
    {
        $this->load->view('askquestion');
    }
}
