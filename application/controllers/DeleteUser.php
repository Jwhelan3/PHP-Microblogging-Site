<?php

class DeleteUser extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->data = array('title' => 'This is a test', 'error' => 0, 'error_msg' => '');
        $this->load->model('m_users');
    }

    function index() {
        //First check whether the user has logged in - redirect if not
        if(!$this->session->userdata("userID"))
        {
            redirect(base_url());
        }

        //Check whether this user has permission to make changes
        $user = $this->m_users->get_user_details($this->session->userdata("userID"));
        $admin = $user['admin'];
        $userID = $user['id'];

        //Permissions?
        if($this->session->userdata("admin") == 0) {
            redirect(base_url());
        }

        //If the user has reached this point they're authorised to delete

        $this->m_users->delete_user($this->uri->segment(3));
        redirect(base_url());
      }
}
?>