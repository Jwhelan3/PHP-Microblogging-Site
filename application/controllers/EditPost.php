<?php

class EditPost extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
        $this->data = array('title' => 'This is a test', 'error' => 0, 'error_msg' => '');
        $this->load->model('m_blogs');
        $this->load->model('m_users');
    }

    function index(){
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

        //Has the user posted data?
        if ($this->input->post())
        {
            $this->editPost();
        }

        else $this->display();
      }

    private function editPost()
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
                $this->m_blogs->edit_entry($this->uri->segment(3), $title, $content);

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
        $this->load->view('edit_form', $this->data);
        $this->load->view('footer');
    }
}
?>