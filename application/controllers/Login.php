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
		  
		$this->layout->setLayout('inner_layout');
	}	
	public function index() {
		$useremail									= $this->input->post('useremail');
		$password									= $this->input->post('password');
		
		
		$userDetails								= $this->model_login->chkUserAuth($useremail,$password);
		//print_r($userDetails);
		if($userDetails) {
			$this->session->set_userdata('customer_id', $userDetails['customer_id']);
			$this->session->set_userdata('customer_email', $userDetails['customer_email']);
			$this->session->set_userdata('customer_fname', $userDetails['customer_firstname']);			
			$this->session->set_userdata('customer_mobile', $userDetails['customer_mobile']);
			//$this->session->set_userdata('location_id', $userDetails['location_id']);
			echo $result = '1';	

		} 
		else{
			echo $result = '0';	
	
		}
	}
	
	public function site_login() {
		$userID									= $this->session->userdata('user_id');
		if(isset($userID) && !empty($userID)) {
			redirect(base_url()."submission/dashboard/");
		}
		else{redirect(base_url()."login");}
	}	
	
	
	
	
	public function forgotpassword() {	
	    
	// SEO WORK
	$this->data['contentTitle']					= 'Elevation';
	
	// END SEO WORK	

	$this->data['errmsg']						= $this->session->userdata('errmsg');
	$this->data['succmsg']						= $this->session->userdata('succmsg');
	$this->session->set_userdata('errmsg', '');
	$this->session->set_userdata('succmsg', '');
	
	$this->data['frmaction']					= base_url()."login/chkforgotpassword/";
	//print_r($this->data); exit;
	$this->layout->view('templates/Home/forgotpassword',$this->data);	
    }	
	
	
	public function chkforgotpassword() {
	$emailid = 	 $this->input->post('userId');
    $cond										= "UM.customer_email = '$emailid'";
	$userDetails								= $this->model_login->getUserDetailsDB($cond);
	$emailData 									= $userDetails['customer_email'];
	$password 									= $userDetails['customer_password'];
	$customer_name 								= $userDetails['customer_firstname'];
	
	
	$base_url = base_url().'assets/images/logo.png';

	if($emailid == $emailData)
	{
		$this->data['customer_name']	= $customer_name;
		$this->data['password']			= $password;
		$this->data['emailData']		= $emailData;
		$this->load->library('email');
		$config['charset'] 		= 'iso-8859-1';
		$config['mailtype'] 	= 'html';
		$this->email->initialize($config);
		$this->email->from('no-reply@elevation.com', 'Elevation Photography');
		$this->email->to($emailData);
		$this->email->subject('Forgot password');
		//$this->layout->view('templates/cart/order-mailtocustomer',$this->data);
		$mailBody				= $this->load->view('templates/Home/forgot_mail', $this->data, true);
		$this->email->message($mailBody);
		$this->email->send();
		
		$this->data['succmsg'] 	= $this->session->set_flashdata('succmsg', 'Your password successfully send to email id.'); 
		redirect(base_url()."Login/forgotpassword",$this->data);	
	}
	else
	{
		$this->data['errmsg']	=$this->session->set_flashdata('errmsg', 'This enail id is not registered.'); 
		redirect(base_url()."Login/forgotpassword",$this->data);	
	}
		
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
		$this->session->unset_userdata('customer_id');
		$this->session->unset_userdata('customer_ref_id');
		$this->session->unset_userdata('customer_email');
		$this->session->unset_userdata('customer_mobile');
				
    	$this->session->sess_destroy(); # Change
    	    
		redirect(base_url());
	}
}
?>