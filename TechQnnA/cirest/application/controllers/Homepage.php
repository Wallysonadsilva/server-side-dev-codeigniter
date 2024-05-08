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

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($user_id);


        $query = $this->input->get('query');
        if ($query) {
            $questions = $this->Question_model->search_questions($query);
        } else {
            $questions = $this->Question_model->get_questions_with_answer_count(9);
        }

        $trending_questions = $this->Question_model->get_trending_questions_by_likes();

        $data = [
            'questions' => $questions,
            'trending_questions' => $trending_questions,
            'username' => $user ? $user->username : 'Guest',
            'query' => $query
        ];

        $this->load->view('homepage', $data);
    }


    public function about()
    {
        $trending_questions = $this->Question_model->get_trending_questions_by_likes();

        $data = [
            'trending_questions' => $trending_questions
        ];
        $this->load->view('about', $data);
    }

    public function askquestion()
    {
        $this->load->view('askquestion');
    }

    public function search()
    {
        $query = $this->input->get('query');

        if ($query) {
            $search_results = $this->Question_model->search_questions($query);

            echo json_encode($search_results);
        } else {
            echo json_encode([]);
        }
    }
}
