<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller
{
    public $data = array();
    function __construct ()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE); //debug 
        $this->load->helper('dump'); //ham dump khi code
        //check login
        $login = $this->session->userdata('ad_logged_in');
        !$login ? redirect(base_url('admin/login'), 'refresh'):'';
        //Create breadcrumbs
        $this->load->library('breadcrumbs');
        $this->breadcrumbs->push('Admin', '/admin');
        //Get user list
        $this->load->model('Ad_auth');
        $this->data['user_list']=$this->Ad_auth->user_list();
    }
}