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
        $this->load->library('session');
        log_message('debug', 'API Controller Initialized');
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
            $this->response($questions, 200); // HTTP status 200: OK
        } catch (Exception $e) {
            log_message('error', 'Error fetching questions: ' . $e->getMessage());
            $this->response(['status' => 'error', 'message' => 'Failed to fetch questions'], 500); // HTTP status 500: Internal Server Error
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
            $this->response(['status' => 'error', 'message' => 'No question ID provided'], 400); // HTTP status 400: Bad Request
            return;
        }

        log_message('debug', 'Fetching question with ID: ' . $id);
        try {
            $question = $this->Question_model->get_question_by_id($id);

            if ($question) {
                $this->response($question, 200); // HTTP status 200: OK
            } else {
                $this->response(['status' => 'error', 'message' => 'Question not found'], 404); // HTTP status 404: Not Found
            }
        } catch (Exception $e) {
            log_message('error', 'Error fetching question: ' . $e->getMessage());
            $this->response(['status' => 'error', 'message' => 'Failed to fetch question'], 500); // HTTP status 500: Internal Server Error
        }
    }

    public function user_questions_get()
    {
        $user_id = $this->session->userdata('user_id');

        if ($user_id) {
            $questions = $this->Question_model->get_questions_by_user($user_id);
            $this->response($questions, 200); // HTTP 200: OK
        } else {
            $this->response(['status' => 'error', 'message' => 'User not logged in'], 401); // HTTP 401: Unauthorized
        }
    }

    // POST a new question
    public function add_question_post()
    {
        $data = json_decode($this->input->raw_input_stream, true);

        // Check for missing required fields
        if (!isset($data['title']) || !isset($data['description'])) {
            $this->response(['status' => 'error', 'message' => 'Missing required fields: title or description'], 400); // HTTP status 400: Bad Request
            return;
        }

        // Add user_id and tags
        $data['user_id'] = $this->session->userdata('user_id');
        if (empty($data['user_id'])) {
            $this->response(['status' => 'error', 'message' => 'User not authenticated'], 401); // HTTP status 401: Unauthorized
            return;
        }
        $data['tags'] = isset($data['tags']) ? $data['tags'] : '';

        // Save question
        if ($this->Question_model->save_question($data)) {
            $this->response(['status' => 'success', 'message' => 'Question added successfully'], 201); // HTTP status 201: Created
        } else {
            $this->response(['status' => 'error', 'message' => 'Failed to add question'], 500); // HTTP status 500: Internal Server Error
        }
    }

    // PUT to update a question
    public function update_question_put($id = NULL)
    {
        if ($id === NULL) {
            $this->response(['status' => 'error', 'message' => 'No question ID provided'], 400); // HTTP status 400: Bad Request
            return;
        }

        $data = [
            'title' => $this->put('title'),
            'description' => $this->put('description'),
            'tags' => $this->put('tags')
        ];

        log_message('debug', 'Updating question with ID ' . $id . ': ' . json_encode($data));
        try {
            if ($this->Question_model->update_question($id, $data)) {
                $this->response(['status' => 'success', 'message' => 'Question updated successfully'], 200); // HTTP status 200: OK
            } else {
                $this->response(['status' => 'error', 'message' => 'Failed to update question'], 500); // HTTP status 500: Internal Server Error
            }
        } catch (Exception $e) {
            log_message('error', 'Error updating question: ' . $e->getMessage());
            $this->response(['status' => 'error', 'message' => 'Failed to update question'], 500); // HTTP status 500: Internal Server Error
        }
    }

    // DELETE a question
    public function delete_question_delete($id = NULL)
    {
        if ($id === NULL) {
            $this->response(['status' => 'error', 'message' => 'No question ID provided'], 400); // HTTP 400: Bad Request
            return;
        }

        if ($this->Question_model->delete_question_and_answers($id)) {
            $this->response(['status' => 'success', 'message' => 'Question and associated answers deleted successfully'], 200); // HTTP 200: OK
        } else {
            $this->response(['status' => 'error', 'message' => 'Failed to delete question'], 500); // HTTP 500: Internal Server Error
        }
    }

    // POST to add a like/dislike
    public function add_like_dislike_post()
    {
        $user_id = $this->session->userdata('user_id');
        $question_id = $this->post('question_id');
        $type = $this->post('type');

        if (empty($user_id) || empty($question_id) || empty($type)) {
            $this->response(['status' => 'error', 'message' => 'Missing required parameters'], 400); // HTTP status 400: Bad Request
            return;
        }

        log_message('debug', 'Adding ' . $type . ' to question ID ' . $question_id . ' by user ID ' . $user_id);
        try {
            if ($this->Question_model->add_like_dislike($user_id, $question_id, $type)) {
                $this->response(['status' => 'success', 'message' => ucfirst($type) . ' added successfully'], 201); // HTTP status 201: Created
            } else {
                $this->response(['status' => 'error', 'message' => 'Failed to add ' . $type], 500); // HTTP status 500: Internal Server Error
            }
        } catch (Exception $e) {
            log_message('error', 'Error adding ' . $type . ': ' . $e->getMessage());
            $this->response(['status' => 'error', 'message' => 'Failed to add ' . $type], 500); // HTTP status 500: Internal Server Error
        }
    }
}
