<?php

class Logout extends CI_Controller
{
    private $data;

    public function __construct() {
        parent::__construct();
    }

    function index()
    {
        $this->logout();
    }

    //User has pressed logout - destroy the session and redirect
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
?>