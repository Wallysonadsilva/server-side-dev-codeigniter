<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homepage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_model'); // Load the model here
    }


    public function index()
    {
        $data['questions'] = $this->Question_model->get_questions_with_answer_count();

        // Fetch the top 5 trending questions by likes
        $data['trending_questions'] = $this->Question_model->get_trending_questions_by_likes(); // Fetch questions
        $this->load->view('homepage', $data); // Pass questions to view
    }


    public function about()
    {
        $this->load->view('about');
    }

    public function contact()
    {
        $this->load->view('contact');
    }

    public function askquestion()
    {
        $this->load->view('askquestion');
    }
}
