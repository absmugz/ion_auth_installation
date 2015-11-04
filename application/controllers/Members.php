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
        
       $data['user'] = $this->ion_auth->user()->row();
       //var_dump($data);
        $this->load->view('members/members_view', $data);
    }


    
}
