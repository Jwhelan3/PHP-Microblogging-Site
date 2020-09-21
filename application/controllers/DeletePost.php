<?php

class DeletePost extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->data = array('title' => 'This is a test', 'error' => 0, 'error_msg' => '');
        $this->load->model('m_blogs');
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

        //Get the post details
        $post = $this->m_blogs->get_post_details($this->uri->segment(3));
        $this->data['title'] = $post['name'];
        $this->data['body'] = $post['body'];
        $this->data['author'] = $post['author'];

        //Permissions?
        if($this->session->userdata("admin") == 0) {
            if($this->session->userdata("userID") != $this->data['author']) {
                redirect(base_url());
            }
        }

        //If the user has reached this point they're authorised to delete
        if ($this->input->post())
        {
            $this->editPost();
        }

        $this->m_blogs->delete_entry($this->uri->segment(3));
        redirect(base_url());
      }
}
?>