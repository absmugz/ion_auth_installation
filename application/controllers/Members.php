<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends Members_Controller {
	
function __construct()
    {
        parent::__construct();
		$this->load->library('ion_auth');
	}

    public function index()
    {
        $this->load->view('welcome_message');
    }


    
}
