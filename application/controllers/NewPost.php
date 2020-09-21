<?php

class NewPost extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->data = array('title' => 'This is a test', 'error' => 0, 'error_msg' => '');
        $this->load->model('m_blogs');
    }

    function index(){
        //First check whether the user has logged in - redirect if not
        if(!$this->session->userdata("userID"))
        {
            redirect(base_url());
        }

        //Has the user posted data?
        if ($this->input->post())
        {
            $this->addPost();
        }

        else $this->display();
      }

    private function addPost()
    {
        $data['error'] = 0; //Track whether an error was encountered in trying to log in

        //Analyse the post data
        if( $this->input->post())
        {
            //Set the rules for validation
            $rules = array(
                array(
                    'field' => 'title',
                    'label' => 'Title',
                    'rules' => 'trim|required|min_length[1]|max_length[50]',
                ),
                array(
                    'field' => 'content',
                    'label' => 'content',
                    'rules' => 'trim|required|min_length[5]|max_length[2000]'
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
                $title = $this->input->post('title', TRUE);
                $content = $this->input->post('content', TRUE);
                $userID = $this->m_blogs->insert_entry($title, $content, $this->session->userdata("userID"));

                //Send the user to the home page
                redirect(base_url());
            }
        }

        //Display the page
        $this->display();
    }

    public function display()
    {
        $this->load->view('header');
        $this->load->view('post_form', $this->data);
        $this->load->view('footer');
    }
}
?>