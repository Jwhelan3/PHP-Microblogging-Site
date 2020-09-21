<?php

class Register extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->data = array('error_msg' => '');
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
            $this->register();
        }

        else
        {
            $this->displayPage();
        }
      }

    //Register a new user
    function register()
    {
        if($this->input->post())
        {
            //Set the rules 
            $rules = array(
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|is_unique[users.email]|valid_email',
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required|min_length[5]|max_length[20]'
                ),
                array(
                    'field' => 'cpassword',
                    'label' => 'Password confirmation',
                    'rules' => 'trim|required|matches[password]',
                )
            );

            //Load the validation library
            $this->load->library('form_validation');
            $this->form_validation->set_rules($rules);

            //Were there errors?
            if($this->form_validation->run() == FALSE)
            {
                //Inform the user
                $this->data['error'] = validation_errors();
                $this->data['error_msg'] = validation_errors();
            }

            else 
            {
                //Send the data to the user model for creation
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $userID = $this->m_users->create_user($email, $password);

                //Log the newly registered user in
                $user = $this->m_users->get_user_details($userID);
                $this->session->set_userdata('userID', $user['id']);
                $this->session->set_userdata('admin', $user['admin']);
                $this->session->set_userdata('email',$user['email']);
                redirect(base_url());
                //Send the user to the home page
                redirect(base_url());
            }
        }

        $this->displayPage();
    }

    //Load the page elements
    function displayPage()
    {
        $this->load->view('header');
        $this->load->view('register_form', $this->data);
        $this->load->view('footer');
    }
}
?>