<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_model');
        $this->load->library('session');
    }

    public function submit_question()
    {
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => 'error', 'message' => 'You must be logged in to submit a question.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['title']) || !isset($data['description']) || empty($data['title']) || empty($data['description'])) {
            echo json_encode(['status' => 'error', 'message' => 'Title and description are required.']);
            return;
        }

        $question_data = [
            'title' => $data['title'],
            'description' => $data['description'],
            'tags' => isset($data['tags']) ? $data['tags'] : '',
            'user_id' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Question_model->save_question($question_data)) {
            echo json_encode(['status' => 'success', 'message' => 'Question submitted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error submitting question. Please try again.']);
        }
    }

    public function view_question($id)
    {
        $question = $this->Question_model->get_question_by_id($id);
        if (!$question) {
            show_404();
            return;
        }

        $answers = $this->Question_model->get_answers_by_question_id($id);
        $reactions = $this->Question_model->count_like_dislike($id);

        $user_reaction = null;

        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $user_reaction = $this->Question_model->get_user_like_dislike($user_id, $id);
        }

        $data = [
            'question' => $question,
            'answers' => $answers,
            'reactions' => $reactions,
            'user_reaction' => $user_reaction
        ];

        $this->load->view('question_detail', $data);
    }


    public function get_question($id)
    {
        header('Content-Type: application/json');
        $question = $this->Question_model->get_question_by_id($id);
        if ($question) {
            echo json_encode(['status' => 'success', 'question' => $question]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Question not found.']);
        }
    }

    public function get_questions()
    {
        header('Content-Type: application/json');
        $questions = $this->Question_model->get_questions();
        echo json_encode(['status' => 'success', 'questions' => $questions]);
    }

    public function add_answer($question_id)
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);

            $user_id = $this->session->userdata('user_id');
            if (!$user_id) {
                echo json_encode(['status' => 'error', 'message' => 'You need to be logged in to post an answer.']);
                return;
            }

            if (empty($data['content'])) {
                echo json_encode(['status' => 'error', 'message' => 'Answer content is required.']);
                return;
            }

            $answer_data = [
                'question_id' => $question_id,
                'user_id' => $user_id,
                'content' => $data['content'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->Question_model->add_answer($answer_data)) {

                $this->load->model('User_model');
                $user = $this->User_model->get_user_by_id($user_id);

                echo json_encode([
                    'status' => 'success',
                    'answer_content' => nl2br(htmlspecialchars($answer_data['content'])),
                    'username' => htmlspecialchars($user->username),
                    'created_at' => date('F j, Y, g:i a', strtotime($answer_data['created_at']))
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to submit answer.']);
            }
        }
    }

    public function like_question($question_id)
    {
        header('Content-Type: application/json');
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        if ($this->Question_model->add_like_dislike($user_id, $question_id, 'like')) {
            $reactions = $this->Question_model->count_like_dislike($question_id);
            $user_reaction = $this->Question_model->get_user_like_dislike($user_id, $question_id);
            echo json_encode([
                'status' => 'success',
                'likes' => $reactions['likes_count'],
                'dislikes' => $reactions['dislikes_count'],
                'user_reaction' => $user_reaction['type']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to react.']);
        }
    }


    public function dislike_question($question_id)
    {
        header('Content-Type: application/json');
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        if ($this->Question_model->add_like_dislike($user_id, $question_id, 'dislike')) {
            $reactions = $this->Question_model->count_like_dislike($question_id);
            $user_reaction = $this->Question_model->get_user_like_dislike($user_id, $question_id);
            echo json_encode([
                'status' => 'success',
                'likes' => $reactions['likes_count'],
                'dislikes' => $reactions['dislikes_count'],
                'user_reaction' => $user_reaction['type']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to react.']);
        }
    }
}
