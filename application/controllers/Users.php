<?php

class Users extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model('m_users');
        $this->data = array('users' => $this->m_users->get_users());
    }

    function index() {
        //Is user logged in?
        if($this->session->userdata("userID")) {
            $loggedIn = true;
            //Get the user model
            $user = $this->m_users->get_user_details($this->session->userdata("userID"));
            $admin = $user['admin'];
            $userID = $user['id'];
            $myEmail = $user['email'];
            
            //Is this user authorised to view the page?
            if($admin == 0) {
                redirect(base_url());
            }
        }

        //User is not logged in
        else {
            redirect(base_url());
        }

        $this->load->view('header');
        $this->load->view('users_view', $this->data);
        $this->load->view('footer');
    }

}

?>