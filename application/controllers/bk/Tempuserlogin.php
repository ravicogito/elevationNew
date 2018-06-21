<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tempuserlogin extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		//if($this->session->userdata('user_id') =='') {
			//redirect(base_url()."tempuserlogin");
		//}
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration','model_submissiontemp'));		
		$this->data['themePath'] 			= $this->config->item('theme');
	}
	
	public function index() {		    
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK	
        //$this->data['frmaction']					= base_url()."tempuserlogin/chk_tempuser/";
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		$this->load->view($this->data['themePath'].'temp/login',$this->data);
	}
	
	public function thankyou() {
	
        // SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK	
        //$this->data['frmaction']					= base_url()."tempuserlogin/chk_tempuser/";
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_mobile');
		$this->session->unset_userdata('user_unique_id');
		$this->session->unset_userdata('password');	
		$this->session->unset_userdata('user_package_id');		
    	$this->session->sess_destroy();
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		$this->load->view($this->data['themePath'].'temp/thankyou',$this->data);	
		
	}
	
		public function chk_tempuser() {
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK		
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');	
		$username									= $this->input->post('username');
		//$password									= $this->input->post('password');
		//if (trim($username) != "" && trim($password) != "") {
		if (trim($username) != "") {	
		 //$usertempDetails = $this->model_submissiontemp->chkUserAuth(trim($username), trim($password));
		 $usertempDetails = $this->model_submissiontemp->chkUserAuth(trim($username));
		}
		//print_r($usertempDetails);
		//echo $usertempDetails["user_process_status"]; die;
		if($usertempDetails["user_process_status"]=='1')
		{
		  $this->data['errmsg'] = "You have already verified your information. Please login to your members login from the chennaibengalassociation.com website only. Thank you!";
		 
		}
		else {
		if (!empty($usertempDetails)) {
			
		  $this->session->set_userdata('userid', $usertempDetails["user_id"]);
		  $this->session->set_userdata('username', $usertempDetails["username"]);
		  $this->session->set_userdata('password', $usertempDetails["password"]);
		  $this->session->set_userdata('user_mobile', $usertempDetails["user_mobile"]);
          $this->session->set_userdata('user_email', $usertempDetails["user_email"]); 
		  $this->session->set_userdata('user_unique_id', $usertempDetails["user_unique_id"]); 
		  $this->session->set_userdata('user_package_id', $usertempDetails["user_package_id"]); 
		  //print_r($this->session->userdata()); //die;
		  ########################## END ########################
		 redirect(base_url()."tempuserlogin/mobile_verification");
					
		}
		
		else{
			$this->data['errmsg'] = "We cannot find your membership record. Please contact <a href='mailto:support@chennaibengalassociation.com'>support@chennaibengalassociation</a>";
			}
		}
	
		$this->load->view($this->data['themePath'].'temp/login',$this->data);
		
	}
	
	private function chk_login() {
		$userID								= $this->session->userdata('userid');
		
		if(empty($userID) || $userID == 0) {
			redirect(base_url().'tempuserlogin/');
		}
	}
	
	
	public function mobile_verification() {
	$this->chk_login();	
	// SEO WORK
	$this->data['contentTitle']					= 'The Bengal Association, Chennai';
	$this->data['contentKeywords']				= '';
	$this->data['contentDescription']			= 'Durgapuja.';
	// END SEO WORK		
	$this->data['errmsg']						= $this->session->userdata('errmsg');
	$this->data['succmsg']						= $this->session->userdata('succmsg');	
	$this->data['mobile_no']					= $this->session->userdata('user_mobile');		
	$this->load->view($this->data['themePath'].'temp/mobile_verification',$this->data);	
	}

    public function send_otp() {
		//print_r($this->session->userdata());
		$recArr								= array();
		$digits 							= 4;
		$otp								= $this->generatePIN($digits);
		$txtMessage							= "Your OTP is $otp";
		$mobNo								= $this->input->post('user_mobile');
		$ucond								= "UM.user_mobile = '$mobNo'";
		$usertempDetails					= $this->model_submissiontemp->getOldUserDetails($ucond);
		//pr($usertempDetails);
		/*if($usertempDetails) {
		  $this->session->set_userdata('userid', $usertempDetails["user_id"]);
		  $this->session->set_userdata('username', $usertempDetails["username"]);
		  $this->session->set_userdata('password', $usertempDetails["password"]);
		  $this->session->set_userdata('user_mobile', $usertempDetails["user_mobile"]);
          $this->session->set_userdata('user_email', $usertempDetails["user_email"]); 
		  $this->session->set_userdata('user_unique_id', $usertempDetails["user_unique_id"]); 
		  $this->session->set_userdata('user_package_id', $usertempDetails["user_package_id"]);
		  $userID					= $this->session->userdata("userid");
	
		 } */
			$userID					= $this->session->userdata("userid");
			if($userID) {
				$this->session->set_userdata("user_id", $userID);
				$this->session->set_userdata("user_mobile", $mobNo);
				
				$updateUserVerArr	= array(
										"user_id"					=> $userID,										
										"user_mobile_otp"			=> $otp,
										"user_mobile_otp_verified"	=> "0"
										);
										
				$condArr			= array("user_id" => $userID);	
				$this->model_submissiontemp->updateData($updateUserVerArr, 'chben_exist_old_users', $condArr);
				
			$this->sendSMS($mobNo, $txtMessage);
			redirect(base_url()."tempuserlogin/verifymobile/");
			}
		
	}
	public function resend($type = 'mobile') {
		$this->chk_login();
		$recArr								= array();
		$userID 							= $this->session->userdata('userid');
		$condArr							= array("user_id" => $userID);
		if($type == 'mobile') {
			$mobNo							= $this->session->userdata('user_mobile');
			$digits 						= 4;
			$otp							= $this->generatePIN($digits);
			$textMessage					= "Your OTP is $otp";
			
			$editUserVerArr					= array(																
												"user_mobile_otp" => $otp
												);
														
			$this->model_registration->editdata($editUserVerArr, 'chben_exist_old_users', $condArr);
			
			$this->sendSMS( $mobNo, $textMessage );
			
			redirect(base_url()."tempuserlogin/verifymobile/");
		} 
	}
	
	
		public function verifymobile() {
		$this->chk_login();		
		$mobNo										= $this->session->userdata("user_mobile");
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK		
		$this->data['mobNo']						= $mobNo;
		$this->data['regenerate']					= base_url()."tempuserlogin/resend/mobile/";
		$this->load->view($this->data['themePath'].'temp/mobile-otp-verification',$this->data);
	}
	
	public function mobileverified($process = "success") {
		$this->chk_login();
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		$this->data['regenerate']					= base_url()."tempuserlogin/resend/mobile/";
		// END SEO WORK		
		
		$this->data['mobNo']						= $this->session->userdata('user_mobile');		
		$this->data['errmsg']						= $process;
		$this->load->view($this->data['themePath'].'temp/mobile-otp-verification',$this->data);
	}
	
	public function chkmob_otp() {
		$this->chk_login();
		$recArr					= array();
		$userID					= $this->session->userdata('userid');
		$mobNo					= $this->session->userdata('user_mobile');
		$mobOtp					= $this->input->post('otp_no');
		$cond					= "user_id = '$userID' AND user_mobile_otp = '$mobOtp' AND user_mobile_otp_verified = '0'";
		$cnt					= $this->model_registration->isRecordExist('chben_exist_old_users', $cond);
		if($cnt > 0) {
			$editArr			= array(
									"user_mobile_otp_verified"		=> '1'
									);
									
			$condArr			= array("user_id" => $userID);
			
			$this->model_registration->editdata($editArr, 'chben_exist_old_users', $condArr);
			
			$process			= "success";
			redirect(base_url().'submissiontemp/');
		} else {
			$process			= "You OTP is wrong.";
		}
		//echo json_encode($recArr);
		$this->mobileverified($process);
	}

    	private function generatePIN($digits = 4){
	    $i = 0; //counter
	    $pin = ""; //our default pin is blank.
	    while($i < $digits){
	        //generate a random number between 0 and 9.
	        $pin .= mt_rand(0, 9);
	        $i++;
	    }
	    return $pin;
	}

    	
	
	public function logout() {
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_mobile');
		$this->session->unset_userdata('user_unique_id');
		$this->session->unset_userdata('password');	
		$this->session->unset_userdata('user_package_id');		
    	$this->session->sess_destroy(); # Change
    	    
		redirect(base_url()."tempuserlogin/");
	}
	
	public function sendSMS($mobNo = 0, $msg = '') {
		$url = 'http://bhashsms.com/api/sendmsg.php';
			$fields = array(
				'user' => urlencode('thebengalassociation'),
				'pass' => urlencode('TBA@321'),
				'sender' => urlencode('BENGAL'),
				'phone' => urlencode($mobNo),
				'text' => urlencode($msg),
				'priority' => urlencode('ndnd'),
				'stype' => urlencode('normal')
			);
			//pr($fields,0);
			$fields_string = '';
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');
			//echo $fields_string;
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
			return true;
	}
	
	public function send_email() {
		$emailID						= 'ruma.khan@cogitosoftware.in';	
		$digits 						= 6;
		$otp							= $this->generatePIN($digits);
		$viewdata['otp']                = $otp;	
		$mesg = $this->load->view($this->data['themePath'].'email/registration',$viewdata);
		$mailData['from_email']			= 'no-reply@chennaibengalassociation.com';
		$mailData['from_name']			= 'Chennaibengal association';		
		$mailData['to_email']			= $emailID;
		$mailData['cc_mail']			= "cogito.sunav@gmail.com";
		$mailData['bcc_mail']			= '';	
		$mailData['subject']			= 'Email verification OTP .';
		//$mailData['message']			= "<div style='padding:20px 10px; font-size:15px;'>Registration OTP is $otp</div>";
		$mailData['message']			= $mesg;
		$mail 							= $this->sendMail($mailData);
		if($mail){
			echo "true";
		}
		
	}	
	
	
}

/* End of file Tempuserlogin.php */
/* Location: ./application/controllers/tempuserlogin.php */