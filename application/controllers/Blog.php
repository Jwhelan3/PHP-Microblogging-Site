<?php

class Blog extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model('m_blogs');
        $this->load->model('m_users');
        //Is user logged in?
        if($this->session->userdata("userID")) {
            $loggedIn = true;
            //Get the user model
            $user = $this->m_users->get_user_details($this->session->userdata("userID"));
            $admin = $user['admin'];
            $userID = $user['id'];
            $myEmail = $user['email'];
        }

        else { 
            $loggedIn = false;
            $userID = 0;
            $admin = false;
            $myEmail = "";
        }

        $this->data = array('loggedIn' => $loggedIn, 'posts' => $this->m_blogs->get_entries(), 'admin' => $admin, 'userID' => $userID, 'myEmail' => $myEmail);
    }

    function index() {
        $this->load->view('header');
        $this->load->view('blog_view', $this->data);
        $this->load->view('footer');
    }

}

?>