<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questions extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_model'); // Load the model here
    }


    public function submit_question()
    {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('tags', 'Tags', 'trim');

        if ($this->form_validation->run() == FALSE) {
            // Handle validation errors
            $this->session->set_flashdata('error', validation_errors());
            redirect('homepage/ask_question'); // Redirect back to form
        } else {
            // Process the validated data
            $data = array(
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'tags' => $this->input->post('tags', TRUE),
                'user_id' => $this->session->userdata('user_id')
            );

            if ($this->Question_model->save_question($data)) {
                $this->session->set_flashdata('message', 'Question submitted successfully.');
                redirect('homepage');
            } else {
                $this->session->set_flashdata('error', 'There was a problem submitting your question.');
                redirect('homepage/ask_question');
            }
        }
    }

    public function view_question($id)
    {
        // Assuming $id is the ID of the question
        $data['question'] = $this->Question_model->get_question_by_id($id);
        $data['answers'] = $this->Question_model->get_answers_by_question_id($id);
        $user_id = $this->session->userdata('user_id');

        if ($user_id) {
            $data['user_reaction'] = $this->Question_model->get_user_like_dislike($user_id, $id);
            $data['reactions_count'] = $this->Question_model->count_like_dislike($id);
        } else {
            $data['user_reaction'] = null;
            $data['reactions_count'] = $this->Question_model->count_like_dislike($id);
        }

        $this->load->view('question_detail', $data);
    }


    public function add_answer($question_id)
    {
        $this->load->model('Question_model');

        // Check if the user is logged in and get the user ID from the session
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            // Handle the case where the user is not logged in
            $this->session->set_flashdata('error', 'You need to be logged in to post an answer.');
            redirect('login'); // Redirect to login page or appropriate handler
            return;
        }

        $answer_data = array(
            'question_id' => $question_id,
            'user_id' => $user_id,
            'content' => $this->input->post('content', TRUE), // TRUE for XSS cleaning
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($this->Question_model->add_answer($answer_data)) {
            $this->session->set_flashdata('message', 'Answer submitted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to submit answer.');
        }

        redirect('question/' . $question_id); // Redirect back to the question detail page
    }

    public function like_question($question_id)
    {
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        if ($this->Question_model->add_like_dislike($user_id, $question_id, 'like')) {
            $reactions = $this->Question_model->count_like_dislike($question_id);
            echo json_encode(['status' => 'success', 'message' => 'Liked the question', 'likes' => $reactions['like'], 'dislikes' => $reactions['dislike']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'You have already reacted to this question.']);
        }
    }

    public function dislike_question($question_id)
    {
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        if ($this->Question_model->add_like_dislike($user_id, $question_id, 'dislike')) {
            $reactions = $this->Question_model->count_like_dislike($question_id);
            echo json_encode(['status' => 'success', 'message' => 'Disliked the question', 'likes' => $reactions['like'], 'dislikes' => $reactions['dislike']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'You have already reacted to this question.']);
        }
    }
}
