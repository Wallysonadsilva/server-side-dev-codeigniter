<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    //hash the password and register user
    public function register($data)
    {

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('Users', $data);
    }

    //login method
    public function login($email, $password)
    {
        $query = $this->db->get_where('Users', array('email' => $email));
        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }

    //fetch user by id
    public function get_user_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $result = $this->db->get('Users');
        return $result->row();
    }

    //update user information
    public function update_user($user_id, $data)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('Users', $data);
    }

    // Check if a email already exists
    public function is_email_taken($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('Users');

        return $query->num_rows() > 0;
    }

    // Check if a username already exists
    public function is_username_taken($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('Users');

        return $query->num_rows() > 0;
    }
}
