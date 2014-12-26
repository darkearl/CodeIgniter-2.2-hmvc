<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Controller extends CI_Controller
{
    public $data = array();
    function __construct ()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE); //debug 
        $this->load->helper('dump'); //ham dump khi code
    }
}