<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Answer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Add a new answer to a question
    public function add_answer($data)
    {
        $data['user_id'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('Answers', $data);
    }

    // Fetch all answers by question
    public function get_answers_by_question_id($question_id)
    {
        $this->db->select('Answers.*, Users.username');
        $this->db->from('Answers');
        $this->db->join('Users', 'Users.id = Answers.user_id');
        $this->db->where('Answers.question_id', $question_id);
        $this->db->order_by('Answers.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // Fetch answer by ID
    public function get_answer_by_id($answer_id)
    {
        $this->db->select('Answers.*, Users.username')
            ->from('Answers')
            ->join('Users', 'Users.id = Answers.user_id')
            ->where('Answers.id', $answer_id);
        return $this->db->get()->row();
    }
}
