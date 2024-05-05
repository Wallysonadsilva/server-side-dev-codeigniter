<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {

        $this->load->database();
    }

    public function register($data)
    {
        // Hash the password before saving it into the database
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('Users', $data);
    }

    public function login($email, $password)
    {
        $query = $this->db->get_where('Users', array('email' => $email));
        $user = $query->row();

        // Verify password
        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }

    public function get_user_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $result = $this->db->get('Users');
        return $result->row();
    }
}
