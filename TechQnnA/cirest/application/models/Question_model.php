<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Save a new question
    public function save_question($data)
    {
        $data['user_id'] = $this->session->userdata('user_id');
        return $this->db->insert('Questions', $data);
    }

    // Fetch all questions
    public function get_questions()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('questions');
        return $query->result();
    }


    // Get answers by question ID
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

    // Get question by ID
    public function get_question_by_id($id)
    {
        $this->db->select('Questions.*, Users.username as question_username');
        $this->db->from('Questions');
        $this->db->join('Users', 'Users.id = Questions.user_id');
        $this->db->where('Questions.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Add an answer
    public function add_answer($data)
    {
        return $this->db->insert('Answers', $data);
    }

    // Get all questions and their answer counts
    public function get_questions_with_answer_count($limit)
    {
        $this->db->select('Questions.*, COUNT(Answers.id) as answer_count');
        $this->db->from('Questions');
        $this->db->join('Answers', 'Answers.question_id = Questions.id', 'left');
        $this->db->group_by('Questions.id');
        $this->db->order_by('Questions.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    // Fetch all questions by user
    public function get_questions_by_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('Questions');
        return $query->result();
    }

    // Method to delete question and its answers
    public function delete_question_and_answers($id)
    {
        $this->db->trans_start(); // Start transaction
        $this->db->where('question_id', $id);
        $this->db->delete('Answers');
        $this->db->where('id', $id);
        $this->db->delete('Questions');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }


    // Get trending questions and sort by likes
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

    // Add or update a like/dislike for a question
    public function add_like_dislike($user_id, $question_id, $type)
    {
        $existing_reaction = $this->get_user_like_dislike($user_id, $question_id);

        $this->db->trans_start();

        if ($existing_reaction) {
            if ($existing_reaction['type'] === $type) {
                $this->db->where('user_id', $user_id)
                    ->where('question_id', $question_id)
                    ->delete('Question_likes');
                $this->update_like_dislike_count($question_id, $type, -1);
            } else {
                // Update to the new reaction type
                $this->db->where('user_id', $user_id)
                    ->where('question_id', $question_id)
                    ->update('Question_likes', ['type' => $type]);

                // Adjust counts accordingly
                $this->update_like_dislike_count($question_id, $existing_reaction['type'], -1);
                $this->update_like_dislike_count($question_id, $type, 1);
            }
        } else {
            $data = [
                'user_id' => $user_id,
                'question_id' => $question_id,
                'type' => $type
            ];
            $this->db->insert('Question_likes', $data);
            $this->update_like_dislike_count($question_id, $type, 1);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Update the like/dislike count
    private function update_like_dislike_count($question_id, $type, $increment)
    {
        $field = ($type === 'like') ? 'likes_count' : 'dislikes_count';

        $this->db->set($field, "$field + $increment", false)
            ->where('id', $question_id)
            ->update('Questions');
    }

    // Get the count of likes/dislikes
    public function count_like_dislike($question_id)
    {
        $this->db->select('likes_count, dislikes_count')
            ->from('Questions')
            ->where('id', $question_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Get a user's like/dislike
    public function get_user_like_dislike($user_id, $question_id)
    {
        $this->db->select('type')
            ->from('Question_likes')
            ->where('user_id', $user_id)
            ->where('question_id', $question_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Search questions by title/tags
    public function search_questions_navbar($query)
    {
        $lower_query = strtolower($query);

        $this->db->where("LOWER(title) LIKE '%{$lower_query}%'");
        $this->db->or_where("LOWER(tags) LIKE '%{$lower_query}%'");

        $result = $this->db->get('Questions');
        return $result->result_array();
    }
}
