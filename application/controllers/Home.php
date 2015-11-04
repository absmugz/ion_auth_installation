<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('ion_auth');
	}

    public function index()
    {
        
if ($this->ion_auth->logged_in()) {
      $loggedin = true;
    } else {
      $loggedin = false;
    }
    $data['user'] = $this->ion_auth->user()->row();
     $data['loggedin'] = $loggedin;
     $this->load->view('members/index_view', $data);
    }
    
      public function register()
    {
          
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First name','trim|required');
        $this->form_validation->set_rules('last_name', 'Last name','trim|required');
        $this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('email','Email','trim|valid_email|required');
        $this->form_validation->set_rules('password','Password','trim|min_length[8]|max_length[20]|required');
        $this->form_validation->set_rules('confirm_password','Confirm password','trim|matches[password]|required');

        if($this->form_validation->run()===FALSE)
        {
            $this->load->helper('form');
            $this->load->view('members/register_view');
        }
        else
        {
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $first_name,
                'last_name' => $last_name
            );

            $this->load->library('ion_auth');
            if($this->ion_auth->register($username,$password,$email,$additional_data))
            {
                $_SESSION['auth_message'] = 'The account has been created. You may now login.';
                $this->session->mark_as_flash('auth_message');
                redirect('home');
            }
            else
            {
                $_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                redirect('members/register_view');
            }
        }
    }
    
        public function login()
    {
       
		
	$this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->helper('form');
            $this->load->view('members/login_view');
        }
        else
        {
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember))
            {
                redirect('home');
            }
            else
            {
                $_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                redirect('memebers/login');
            }
        }
    }
    
    public function logout()
{
	$this->ion_auth->logout();
	redirect('home');
}


    
}
