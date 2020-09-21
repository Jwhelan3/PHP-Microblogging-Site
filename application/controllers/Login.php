<?php

class Login extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->data = array('title' => 'This is a test', 'error' => 0, 'error_msg' => '');
        $this->load->model('m_users');
    }

    function index(){
        //First check whether the user has already logged in - redirect
        if($this->session->userdata("userID"))
        {
            redirect(base_url());
        }

        //Has the user posted data?
        if ($this->input->post())
        {
            $this->login();
        }

        else $this->display();
      }

    private function login()
    {
        $data['error'] = 0; //Track whether an error was encountered in trying to log in

        //Analyse the post data
        if( $this->input->post() )
        {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            $user = $this->m_users->login($email, $password);

            //The user didn't exist
            if (!$user) { 
                $this->data['error'] = 1;
                $this->data['error_msg'] = "Incorrect credentials";
            }

            //User successfully logged in
            else
            {
                $user = $this->m_users->get_user_details_email($email);
                $this->session->set_userdata('userID', $user['id']);
                $this->session->set_userdata('admin', $user['admin']);
                $this->session->set_userdata('email',$user['email']);
                redirect(base_url());
            }
        }

        $this->display();
    }

    public function display()
    {
        $this->load->view('header');
        $this->load->view('login_form', $this->data);
        $this->load->view('footer');
    }
}
?>