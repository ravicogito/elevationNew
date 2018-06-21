<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
    function __construct(){
		
		parent::__construct();
		$this->load->model('model_login');
		$this->layout->setLayout('login_layout');
	}	
	
	public function index()
	{
		$viewData = array();
       	$viewData['errorMsg'] = "";
		$viewData["successMsg"] = "";
		
		if ($this->input->post('logIN')) {
					
			if (trim($this->input->post('userName')) != "" && trim($this->input->post('password')) != "") {
			   $userDetails = $this->model_login->chkUserAuth(trim($this->input->post('userName')), trim($this->input->post('password')));	

		}
		
		if (!empty($userDetails)) {
					 
					  $this->session->set_userdata('userId', $userDetails["user_id"]);
                  	  $this->session->set_userdata('emailId', $userDetails["user_email "]);
					  $this->session->set_userdata('userName', $userDetails["username"]);
                                         
					  redirect(base_url()."admin/dashboard");
					
                }else{
                    $viewData['errorMsg'] = "Please Enter Correct Username or Password.";
					
				}

			
		}
		$this->layout->view('templates/admin/login',$viewData);
	}
	
	public function doforget()
	{
		$viewData = array();
       	$viewData['errorMsg'] = "";
		$viewData["successMsg"] = "";
		
		$this->load->helper('url');
		$email=$this->input->post('emailid');
		$q = $this->db->query("select * from anad_admin where user_email='" . $email . "'");
        if ($q->num_rows > 0) {
            $r = $q->result();
            $user=$r[0];
			$this->resetpassword($user);
			$this->session->set_flashdata('successMsg', 'Password has been reset and has been sent to email id:'.$email);
			redirect(base_url().'admin/login/#signup');
        }
		else{
		
		$this->session->set_flashdata('errorMsg', 'The email id you entered not found on our database.');
		redirect(base_url().'admin/login/#signup');
		}
		
		
	} 
	
	private function resetpassword($user)
	{
		date_default_timezone_set('GMT');
		$this->load->helper('string');
		$password= random_string('alnum', 16);
		$this->db->where('id', $user->id);
		$this->db->update('anad_admin',array('password'=>$password));
		$this->load->library('email');
		$this->email->from('ruma.senabi@gmail.com', 'Admin');
		$this->email->to($user->email); 	
		$this->email->subject('Password reset');
		$this->email->message('You have requested the new password, Here is you new password:'. $password);	
		$this->email->send();
	} 

  	
	public function logout() {
		//$redirect = base_url()/login;
        $this->session->sess_destroy();
        redirect(base_url() . 'admin/login','refresh');
    }

}
