<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
    function __construct(){
		
		parent::__construct();
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_login','model_home'));
       // $this->load->library( 'nativesession' );	
		$this->data['home_banner']					= $this->model_home->getBanner();	   
		$this->layout->setLayout('front_layout');
	}	
	
	public function index()
	{
		//pr($_SESSION);		    
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB | LOGIN';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK		
		
		$this->data['frmaction']					= base_url()."login/chklogin/";
		$this->data['forgotpassword']				= base_url()."login/forgotpassword/";
		$mobno										= $this->session->userdata('user_mobile');
		$userEmail									= $this->session->userdata('user_email');
		if(!empty($mobno)) {
			$this->data['logindata']				= $mobno;
		} else if(!empty($userEmail)) {
			$this->data['logindata']				= $userEmail;
		} else {
			$this->data['logindata']				= "";
		}
		
		
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		$this->session->set_userdata('errmsg', '');
		$this->session->set_userdata('succmsg', '');
	
		$this->layout->view('templates/user/login',$this->data);

	}
	
	public function site_login() {
		$userID									= $this->session->userdata('user_id');
		if(isset($userID) && !empty($userID)) {
			redirect(base_url()."submission/dashboard/");
		}
		else{redirect(base_url()."login");}
	}	
	
	
	public function chklogin() {
		$logInData									= $this->input->post('userId');
		$password									= $this->input->post('password');
		
		$cond										= "UM.user_email = '$logInData' AND BINARY password = '$password'";
		$userDetails								= $this->model_login->getUserDetailsDB($cond);
		//pr($userDetails);
		if($userDetails) {
			$this->session->set_userdata('user_id', $userDetails['user_id']);
			//$this->nativesession->set( 'user_id', $userDetails['user_id'] );
			$this->session->set_userdata('membership_id', $userDetails['user_unique_id']);
			$this->session->set_userdata('user_mobile', $userDetails['user_mobile']);
			$this->session->set_userdata('user_email', $userDetails['user_email']);
			
			redirect(base_url()."submission/dashboard");
		} else {
			$error = 'Membership Id or password incorrect';			
			$this->session->set_userdata('errmsg', $error);
			redirect(base_url()."login");
		}
	}
	
	public function forgotpassword() {
		$userID									= $this->session->userdata('user_id');
		if(isset($userID) && !empty($userID)) {
			redirect(base_url()."submission/dashboard/");
		}
	    
	// SEO WORK
	$this->data['contentTitle']					= 'ANAND CLUB';
	$this->data['contentKeywords']				= '';
	$this->data['contentDescription']			= 'puja.';
	// END SEO WORK	

	$this->data['errmsg']						= $this->session->userdata('errmsg');
	$this->data['succmsg']						= $this->session->userdata('succmsg');
	$this->session->set_userdata('errmsg', '');
	$this->session->set_userdata('succmsg', '');
	
	//$this->data['frmaction']					= base_url()."login/chkforgotpassword/";
	//print_r($this->data); exit;
	$this->layout->view('templates/user/forgotpassword',$this->data);	
    }	
	
	
	public function chkforgotpassword() {
		$userID									= $this->session->userdata('user_id');
		if(isset($userID) && !empty($userID)) {
			redirect(base_url()."submission/dashboard/");
		}
	$emailid = 	 $this->input->post('userId');
    $cond										= "UM.user_email = '$emailid'";
	$userDetails								= $this->model_login->getUserDetailsDB($cond);
	$emailData 									= $userDetails['user_email'];
	$password 									= $userDetails['password'];

	if($emailid == $emailData)
	{
		
		/*----------- Send password to mail and mobile -------*/
			$mailData['from_email']					= 'no-reply@anandclub.com';
			$mailData['from_name']					= 'Anand Club';		
			$mailData['to_email']					= $emailData;
			$mailData['cc_mail']					= "khan.ruma@gmail.com";
			$mailData['bcc_mail']					= '';	
			$mailData['subject']					= 'Forgot password';
			$mailData['message']					= "<div style='padding:20px 10px; font-size:15px;'>Your Account Password is $password</div>";
			
			$this->sendMail($mailData);
		
		$this->session->set_flashdata('succmsg', 'Your password successfully send to email id.'); 
	}
	else
	{
		$this->session->set_flashdata('errmsg', 'This enail id is not registered.'); 
	}
	redirect(base_url()."login/");
    }	
	
	
	public function sendMail($mailData = array()) {
		$this->load->library('email');
		$config['charset'] = 'iso-8859-1';
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->clear();
		$this->email->from($mailData['from_email'], $mailData['from_name']);
		$this->email->to($mailData['to_email']);
		if(array_key_exists('cc_mail', $mailData)) {
			$this->email->cc($mailData['cc_mail']);
		}
		if(array_key_exists('bcc_mail', $mailData)) {
			$this->email->bcc($mailData['bcc_mail']);
		}
		if(array_key_exists('attach_path', $mailData)) {
			$this->email->attach($mailData['attach_path']);
		}
		$this->email->subject($mailData['subject']);
		$this->email->message($mailData['message']);
		if($this->email->send()) {
			return TRUE;
		} else {
			echo $this->email->print_debugger();	
			exit;
		}
	}
	
	public function logout() {
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_unique_id');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_mobile');
				
    	$this->session->sess_destroy(); # Change
    	    
		redirect(base_url()."login/");
	}
	

}
