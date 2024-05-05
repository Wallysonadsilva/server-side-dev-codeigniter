<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Correctly load database library, if that's what was intended
        $this->load->database();
    }

    public function save_question($data)
    {
        // Assume $data already includes title, description, tags
        // Now, add the user_id from the session to the data array
        $data['user_id'] = $this->session->userdata('user_id');

        // Insert the question data into the 'questions' table
        return $this->db->insert('Questions', $data);
    }

    // Fetch all questions
    public function get_questions()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('Questions');
        return $query->result();
    }

    public function get_question_by_id($id)
    {
        $this->db->select('Questions.*, Users.username as question_username');
        $this->db->from('Questions');
        $this->db->join('Users', 'Users.id = Questions.user_id');
        $this->db->where('Questions.id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    public function get_answers_by_question_id($question_id)
    {
        $this->db->select('Answers.*, Users.username');
        $this->db->from('Answers');
        $this->db->join('Users', 'Users.id = Answers.user_id');
        $this->db->where('Answers.question_id', $question_id);
        $this->db->order_by('Answers.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }


    public function add_answer($data)
    {
        return $this->db->insert('Answers', $data);
    }

    // New Method: Get all questions with their answer counts
    public function get_questions_with_answer_count()
    {
        $this->db->select('Questions.*, COUNT(Answers.id) as answer_count');
        $this->db->from('Questions');
        $this->db->join('Answers', 'Answers.question_id = Questions.id', 'left');
        $this->db->group_by('Questions.id');
        $this->db->order_by('Questions.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_trending_questions_by_likes()
    {
        $this->db->select('Questions.*, COUNT(Question_likes.id) as like_count');
        $this->db->from('Questions');
        $this->db->join('Question_likes', 'Question_likes.question_id = Questions.id AND Question_likes.type = "like"', 'left');
        $this->db->group_by('Questions.id');
        $this->db->order_by('like_count', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }

    public function add_like_dislike($user_id, $question_id, $type)
    {
        // Check if the user already reacted to this question
        $existing_reaction = $this->get_user_like_dislike($user_id, $question_id);

        if ($existing_reaction) {
            // User has already reacted, return false if it's the same reaction type
            if ($existing_reaction['type'] == $type) {
                return false;
            }
        }

        // Add or update the user's reaction
        $data = array(
            'user_id' => $user_id,
            'question_id' => $question_id,
            'type' => $type
        );
        $this->db->replace('Question_likes', $data);

        return true;
    }


    public function get_user_like_dislike($user_id, $question_id)
    {
        $this->db->select('type');
        $this->db->from('Question_likes');
        $this->db->where('user_id', $user_id);
        $this->db->where('question_id', $question_id);
        $query = $this->db->get();
        return $query->row_array();  // Returns NULL if no reaction, or the type of reaction ('like' or 'dislike')
    }

    public function count_like_dislike($question_id)
    {
        $this->db->select('type, COUNT(*) as count');
        $this->db->group_by('type');
        $this->db->where('question_id', $question_id);
        $query = $this->db->get('Question_likes');
        $reactions = array('like' => 0, 'dislike' => 0);
        foreach ($query->result() as $row) {
            $reactions[$row->type] = (int) $row->count;
        }
        return $reactions;
    }
}
