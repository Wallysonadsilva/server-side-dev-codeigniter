<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Api extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Question_model');
        $this->load->model('Answer_model');
        $this->load->model('User_model');
        $this->load->library('session');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        // See the rest.php config file for the SQL to set up the limits file (limits are disabled by default)
        // $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    // GET all questions
    public function questions_get()
    {
        try {
            $questions = $this->Question_model->get_questions_with_answer_count(10);
            $this->response($questions, 200);
        } catch (Exception $e) {
            log_message('error', 'Error fetching questions: ' . $e->getMessage());
            $this->response(['status' => 'error', 'message' => 'Failed to fetch questions'], 500);
        }
    }

    // GET trending questions
    public function trending_questions_get()
    {
        $trending_questions = $this->Question_model->get_trending_questions_by_likes();
        $this->response($trending_questions, 200);
    }

    // GET a specific question by ID
    public function question_get($id = NULL)
    {
        if ($id === NULL) {
            $this->response(['status' => 'error', 'message' => 'No question ID provided'], 400);
            return;
        }

        try {
            $question = $this->Question_model->get_question_by_id($id);

            if ($question) {
                $this->response($question, 200); // HTTP status 200: OK
            } else {
                $this->response(['status' => 'error', 'message' => 'Question not found'], 404);
            }
        } catch (Exception $e) {
            log_message('error', 'Error fetching question: ' . $e->getMessage());
            $this->response(['status' => 'error', 'message' => 'Failed to fetch question'], 500);
        }
    }

    public function user_questions_get()
    {
        $user_id = $this->session->userdata('user_id');

        if ($user_id) {
            $questions = $this->Question_model->get_questions_by_user($user_id);
            $this->response($questions, 200);
        } else {
            $this->response(['status' => 'error', 'message' => 'User not logged in'], 401);
        }
    }

    // POST a new question
    public function add_question_post()
    {
        $data = json_decode($this->input->raw_input_stream, true);

        // Check for missing required fields
        if (!isset($data['title']) || !isset($data['description'])) {
            $this->response(['status' => 'error', 'message' => 'Missing required fields: title or description'], 400);
            return;
        }

        // Add user_id and tags
        $data['user_id'] = $this->session->userdata('user_id');
        if (empty($data['user_id'])) {
            $this->response(['status' => 'error', 'message' => 'User not authenticated'], 401);
            return;
        }
        $data['tags'] = isset($data['tags']) ? $data['tags'] : '';

        // Save question
        if ($this->Question_model->save_question($data)) {
            $this->response(['status' => 'success', 'message' => 'Question added successfully'], 201);
        } else {
            $this->response(['status' => 'error', 'message' => 'Failed to add question'], 500);
        }
    }

    // DELETE a question
    public function delete_question_delete($id = NULL)
    {
        if ($id === NULL) {
            $this->response(['status' => 'error', 'message' => 'No question ID provided'], 400);
            return;
        }

        if ($this->Question_model->delete_question_and_answers($id)) {
            $this->response(['status' => 'success', 'message' => 'Question and associated answers deleted successfully'], 200);
        } else {
            $this->response(['status' => 'error', 'message' => 'Failed to delete question'], 500);
        }
    }


    // POST to add a like/dislike
    public function add_like_dislike_post()
    {
        $user_id = $this->session->userdata('user_id');
        $question_id = $this->post('question_id');
        $type = $this->post('type');

        if (empty($user_id) || empty($question_id) || empty($type)) {
            $this->response(['status' => 'error', 'message' => 'Missing required parameters'], 400);
            return;
        }

        log_message('debug', 'Adding ' . $type . ' to question ID ' . $question_id . ' by user ID ' . $user_id);
        try {
            if ($this->Question_model->add_like_dislike($user_id, $question_id, $type)) {
                $this->response(['status' => 'success', 'message' => ucfirst($type) . ' added successfully'], 201);
            } else {
                $this->response(['status' => 'error', 'message' => 'Failed to add ' . $type], 500);
            }
        } catch (Exception $e) {
            log_message('error', 'Error adding ' . $type . ': ' . $e->getMessage());
            $this->response(['status' => 'error', 'message' => 'Failed to add ' . $type], 500);
        }
    }

    // Fetch user profile info
    public function user_get($id = NULL)
    {
        $user_id = $this->session->userdata('user_id') ?? $id;

        if ($user_id === NULL) {
            $this->response(['status' => 'error', 'message' => 'No user ID provided'], 400);
            return;
        }

        $user = $this->User_model->get_user_by_id($user_id);

        if ($user) {
            $this->response($user, 200); // HTTP status 200: OK
        } else {
            $this->response(['status' => 'error', 'message' => 'User not found'], 404);
        }
    }


    // Update user profile info
    public function update_profile_post()
    {
        $user_id = $this->session->userdata('user_id');

        if ($user_id === NULL) {
            $this->response(['status' => 'error', 'message' => 'User not logged in'], 401);
            return;
        }

        $data = [
            'username' => $this->post('username'),
            'email' => $this->post('email'),
            'bio' => $this->post('bio')
        ];

        $update = $this->User_model->update_user($user_id, $data);

        if ($update) {
            $this->response(['status' => 'success', 'message' => 'Profile updated successfully'], 200);
        } else {
            $this->response(['status' => 'error', 'message' => 'Failed to update profile'], 500);
        }
    }

    // Search questions by title/tags
    public function navbar_search_get()
    {
        $query = $this->get('query');
        if (!$query) {
            $this->response(['status' => 'error', 'message' => 'No search query provided'], 400);
            return;
        }

        $questions = $this->Question_model->search_questions_navbar($query);

        if ($questions) {
            $this->response($questions, 200); // HTTP status 200: OK
        } else {
            $this->response(['status' => 'error', 'message' => 'No questions found'], 404);
        }
    }
}
