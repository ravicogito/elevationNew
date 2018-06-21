<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Member extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('eventmodel');
			$this->load->model('Usermodel');

			$this->load->model('model_registration');
	}


	public function addMember(){

		$data['categories']     = $this->eventmodel->selecteventsCategory();
		$data['events_lists']   = $this->eventmodel->listEvents();
		$stateDropdown			= $this->model_registration->populateDropdown("`state_id`", "`state_name`", "chben_states", "state_status='1'", "state_id", "ASC");
		
		$stateOptions                               = array();
		
		for ($c = 0; $c < count($stateDropdown); $c++){
			$stateOptions[$stateDropdown[$c]['state_id']]     =  $stateDropdown[$c]['state_name'];
		}
		$data['state_dropdown']                             = $stateOptions;
		$data['packages']						= $this->model_registration->packages_list();
		$data['front_url'] = $this->config->item('front_url');
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/add_member", $data);
			$this->load->view("common/footer-inner");
		
	}
	public function sendmob_otp() {
		$recArr								= array();
		$mobNo								= $this->input->post('mobno');
		$digits 							= 4;
		$otp								= $this->generatePIN($digits);
		
		$txtMessage							= "OTP for the Verification of member's mobile. $otp";
		
		$ucond								= "UM.user_mobile = '$mobNo'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
//print_r($userDetails);exit;
		if($userDetails) {
			$this->session->set_userdata("user_id", $userDetails['user_id']);
			$this->session->set_userdata("user_mobile", $userDetails['user_mobile']);
			$this->session->set_userdata("user_email", $userDetails['user_email']);
			
			$userID									= $this->session->userdata("user_id");
			
		} else {
			$insUserArr				= array(
										"user_mobile"	=> $mobNo
										);
									
			$userID					= $this->model_registration->insdata($insUserArr, 'chben_users');
			if($userID) {
				$this->session->set_userdata("user_id", $userID);
				$this->session->set_userdata("user_mobile", $mobNo);
				
				$insUserVerArr		= array(
										"user_id"					=> $userID,										
										"user_mobile_otp"			=> $otp,
										"user_mobile_otp_verified"	=> "0"
										);
				$this->model_registration->insdata($insUserVerArr, 'chben_users_verification');
				
				$insRegProcessArr		= array(
											"user_id"			=> $userID
											);
				$this->model_registration->insdata($insRegProcessArr, 'chben_reg_process');
			}
			
			$this->sendSMS( $mobNo, $txtMessage );
			echo "send";		
		}		
		
	}
	public function chkmob_otp() {
		
		$recArr					= array();
		$userID					= $this->session->userdata('user_id');
		$mobNo					= $this->session->userdata('user_mobile');
		$mobOtp					= $this->input->post('otp_no');
		
		$cond					= "user_id = $userID AND user_mobile_otp = $mobOtp AND user_mobile_otp_verified = '0'";
		$cnt					= $this->model_registration->isRecordExist('chben_users_verification', $cond);
		if($cnt > 0) {
			$editArr			= array(
									"user_mobile_otp_verified"		=> '1'
									);
									
			$condArr			= array("user_id" => $userID);
			
			$this->model_registration->editdata($editArr, 'chben_users_verification', $condArr);
			
			$process			= "success";
		} else {
			$process			= "fail";
		}
		//echo json_encode($recArr);
		$this->mobileverified($process);
				
		echo $process;
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
	public function mobileverified($process = "success") {
		
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK		
		
		$this->data['mobNo']						= $this->session->userdata('user_mobile');		
		$this->data['mobile_verify_status']			= $process;
		
	}
	public function sendmail_otp() {
		
		$recArr					= array();
		$userID					= $this->session->userdata('user_id');
		$emailID				= $this->input->post('emailID');
		$mob			    	= $this->input->post('mobNO');
		$digits 				= 6;
		$otp					= $this->generatePIN($digits);
		$txtMessage				= "OTP for the Verification of member's mobile. $otp";		
		$cond					= "user_email = '$emailID'";
		$cnt					= $this->model_registration->isRecordExist('chben_users', $cond);
		if($cnt > 0) {
			$recArr['process']	= "fail";
			$this->session->set_userdata("user_email", $emailID);
			
			
		} else {
			$insUserArr				= array(
									"user_email"	=> $emailID
									);
			$condArr				= array("user_id" => $userID);
			$userData				= $this->model_registration->editdata($insUserArr, 'chben_users', $condArr);
			if($userData) {
				$this->session->set_userdata("user_email", $emailID);
				$insUserVerArr		= array(
										"user_email_otp"			=> $otp,
										"user_email_otp_verified"	=> "0"
										);
				
				$this->model_registration->editdata($insUserVerArr, 'chben_users_verification', $condArr);
			}
									
			$this->sendSMS($mob, $txtMessage );
			
			echo "send";
			
		}
		
	}
	public function chkemail_otp() {
		
		$recArr					= array();
		$userID					= $this->session->userdata('user_id');	
		$emailID				= $this->input->post('txtemail');
		$emailOtp				= $this->input->post('emailOTP');
		
		$cond					= "user_id = '$userID' AND user_email_otp = '$emailOtp' AND user_email_otp_verified = '0'";
		$cnt					= $this->model_registration->isRecordExist('chben_users_verification', $cond);
		if($cnt > 0) {
			$editArr			= array(
									"user_email_otp_verified"		=> '1'
									);
									
			$condArr			= array("user_id" => $userID);
			
			$this->model_registration->editdata($editArr, 'chben_users_verification', $condArr);
			
			$process			= "success";
		} else {
			$process			= "fail";
		}
		$this->emailverified($process);
		echo $process;
	}
	public function emailverified($process = "success") {

		$userID										= $this->session->userdata('user_id');
		
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK		
		$this->data['emailID']						= $this->session->userdata('user_email');
		$this->data['email_verify_status']			= $process;
		
	}
	public function resend() {
		$type	= $this->input->post('typeID');
		$recArr								= array();
		$userID 							= $this->session->userdata('user_id');
		$condArr							= array("user_id" => $userID);		
		$mobNo								= $this->session->userdata('user_mobile');
			if($type == 'mobile') {
				$digits 						= 4;
				$otp							= $this->generatePIN($digits);
				$textMessage					= "OTP for the Verification of member's mobile. $otp";
				$editUserVerArr					= array(																
												"user_mobile_otp" => $otp
												);
			}
			else if($type == 'email') {
				$digits 						= 6;
				$otp							= $this->generatePIN($digits);
				$textMessage					= "OTP for the Verification of member's email. $otp";
				$editUserVerArr					= array(																
												"user_email_otp" => $otp
												);
			}
			
			$this->model_registration->editdata($editUserVerArr, 'chben_users_verification', $condArr);
			
			$this->sendSMS( $mobNo, $textMessage );
			
			echo "send";
 
		
	}
	
	public function save_info() {

		$userID									= $this->session->userdata('user_id');
		$userMobile								= $this->session->userdata('user_mobile');
		$userEmail								= $this->session->userdata('user_email');
		
		$user_title								= $this->input->post('user_title');
		$user_firstname							= $this->input->post('user_firstname');
		$user_middlename						= $this->input->post('user_middlename');
		$user_lastname							= $this->input->post('user_lastname');
		$user_gender							= $this->input->post('user_gender');
		$marital_status							= $this->input->post('marital_status');
		$user_profession						= $this->input->post('user_profession');
		$user_dob								= $this->input->post('user_dob');
		$user_dob								= date("Y-m-d", strtotime(str_replace("/","-", $user_dob)));
		$user_address							= $this->input->post('user_address');
		$user_address_line2						= $this->input->post('txtaddress2');
		$user_area								= $this->input->post('txtarea');
		$state_id								= $this->input->post('state_id');
		$city_id								= $this->input->post('city_id');
		$pin									= $this->input->post('pin');
		$pachageid 								= $this->input->post('packages');
		$paymentType 							= $this->input->post('cod_post');
        $pos_val 								= $this->input->post('pos_val');
		if($paymentType=="POS"){
         $scode 								= $pos_val;
        }
        else{
         $scode 								= date("Y-m-d");
        }
        $transaction_id 						= $paymentType.$userID.'_'.$scode;
		
		$tamp_amount							= $this->model_registration->getpackageAmount($pachageid);
		
		$amount = $tamp_amount->plan_cost + $tamp_amount->plan_join_fee;
		$planname = $tamp_amount->plan_name;
		// Generate Uniqued ID for the applicant.
		$user_unique_id							= $this->generateUniqueID();
		// Generate random password for the applicant.
		$password								= $this->generatePassword();
		
		$memberDetails							= $this->model_registration->getUserDetailsByID($userID);
		$editArr								= array(
													"user_title"			=> $user_title,
													"user_firstname"		=> $user_firstname,
													"user_middlename"		=> $user_middlename,
													"user_lastname"			=> $user_lastname,
													"user_gender"			=> $user_gender,
													"marital_status"		=> $marital_status,
													"user_profession"		=> $user_profession,
													"user_dob"				=> $user_dob,
													"user_address"			=> $user_address,
													"user_address_line2"	=> $user_address_line2,
													"user_country"			=> '1',
													"state_id"				=> $state_id,
													"city_id"				=> $city_id,
													"pin"					=> $pin,
													"user_area"				=> $user_area,
													"user_unique_id"		=> $user_unique_id,
													"password"				=> $password,
													"user_type"				=> '4',
													"user_package_id"		=> $pachageid,
													"user_approved_guest_date"	=> date("Y-m-d")
													);
		$condArr							= array("user_id" => $userID);
		/*echo "<pre>";
		print_r($_SESSION);
		print_r($_POST);
		print_r($editArr);
		print_r($condArr);
		
		echo "</pre>";
				exit;	*/								
		$condArr								= array("user_id" => $userID);
		$editData								= $this->model_registration->editdata($editArr, 'chben_users', $condArr);
		
		$insPaymentArr        = array(
              "user_id"   => $userID,
              "transaction_id" => $transaction_id,
              "payment_amount" => $amount,
              "payment_date"  => date('Y-m-d'),
              "payment_response" => serialize('NA'),
              "payment_type"  => "newpackage",
              "payment_status" => 'success'
              );
		
		$this->model_registration->insdata($insPaymentArr, "chben_payment");
		if($editData) {
			//Update Registration process.
			$processEditData					= array("guest_registration" => "1");
			$condArr							= array("user_id" => $userID);
			$this->model_registration->editdata($processEditData, 'chben_reg_process', $condArr);
			
			
			/*----------- Send password to mail and mobile -------*/
			$mailData['from_email']					= 'no-reply@chennaibengalassociation.com';
			$mailData['from_name']					= 'Chennai Bengal Association';		
			$mailData['to_email']					= $userEmail;
			$mailData['cc_mail']					= "cogito.sunav@gmail.com";
			$mailData['bcc_mail']					= '';	
			$mailData['subject']					= 'Registration password .';
			$mailData['message']					= "<div style='padding:20px 10px; font-size:15px;'>Registration password is $password</div>";
			
			//$this->sendMail($mailData);
			$mobNo								= $userMobile;
			$textMessage						= "	Registration password : $password, Package Name:  $planname, Package Amout: $amount";
			$this->sendSMS( $mobNo, $textMessage );
			/*----------------------- END -----------------------*/
			$this->session->set_flashdata('success', 'Registration done Successfully.');
			redirect(base_url()."user/listuser/");
		}
													
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
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
			return true;
	}
	private function generateUniqueID($type = 'guest', $packageName = '') {
		$uID					= $this->session->userdata('user_id');
		if($type == 'guest') {
			$uniqueID			= "MAN";
		} else if($type == 'member') {
			/*if(!empty($packageName)) {
				$uniqueID		= $packageName;
			}*/
			$uniqueID			= "MEM";
		}
		for($i = 0; $i < (4-strlen($uID)); $i++) {
			$uniqueID			.= "0";
		}
		$uniqueID				.= $uID;
		if($type == 'member') {
			if(!empty($packageName)) {
				$uniqueID		.= "-".$packageName;
			}
		}	
		return $uniqueID;
	}
	private function generatePassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyz~#$!@ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
	public function populateAjaxCity(){
		$fetchedId			= $this->input->post('state');
				
		$comboVal = $this->model_registration->populateDropdown("city_id", "city_name", "chben_cities", "state_id = '".$fetchedId."'", "city_name", "ASC");
		$fetchedOptions = array();
		
		if($comboVal)
		{	
			for ($c=0; $c<count($comboVal); $c++)
			{
				$fetchedOptions[$comboVal[$c]['city_id']] =   $comboVal[$c]['city_id'] . "|" . stripslashes($comboVal[$c]['city_name']);
			}
			
			echo implode("??",$fetchedOptions);
		}
		else{
			echo "";
		}
	}
	public function downloadMemberList(){
		
		$allmemberlist = $this->Usermodel->allMemberList();
		//print_r($allmemberlist);
		
		$data	 = '';	
		$header	 = "Name"."\t";
		$header .= "Username"."\t";
		$header .= "User Unique Id"."\t";
		$header .= "User Type"."\t";
		$header .= "User Email"."\t";
		$header .= "User Mobile"."\t";
		$header .= "Location"."\t";
		$header .= "Date of Birth"."\t";		
		$header .= "Gender"."\t";
		$header .= "Marital Status"."\t";
		$header .= "Child Have"."\t";		
		$header .= "User Profession"."\t";
		$header .= "User Comments"."\t";		
		$header .= "User Status"."\t";
		$header .= "Created On"."\t";
		$header .= "Modified On"."\t";
		$header .= "Rejected Status"."\t";
		$header .= "\n";
	
		if(!empty($allmemberlist))
		{
			
			foreach($allmemberlist as $val)
			{  
                            
				$line = '';
                $user_name = '';                
				if(!empty($val['user_title']) || !empty($val['user_firstname']) || !empty($val['user_middlename'])|| !empty($val['user_lastname'])){
					$user_name = $val['user_title'].' '.$val['user_firstname'].' '.$val['user_middlename'].' '.$val['user_lastname'];

					$line .= $user_name."\t";

					
				}
				else{
					$line .= $user_name."\t";

				}
				if(!empty($val['username'])){
					
					$line .= $val['username']."\t";
				}
				else
				{
					$line .= ""."\t";
				}
				if(!empty($val['user_unique_id'])){
					
					$line .= $val['user_unique_id']."\t";
				}
				else
				{
					$line .= ""."\t";
				}
				if(!empty($val['user_type'])){
					
					$line .= $val['user_type']."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['user_email'])){
					
					$line .= $val['user_email']."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['user_mobile'])){
					
					$line .= $val['user_mobile']."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['state_id'])){
					
					$state_name	= $this->Usermodel->getStateName($val['state_id']);
					if(!empty($state_name['state_name'])){
						$location	= $state_name['state_name'];
					}
					$line .= $location."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['user_dob'])){
					$dob ='';				
					if($val['user_dob'] != '0000-00-00'){
						$dob = date('d/m/Y',strtotime($val['user_dob']));
						
					}
					$line .= $dob."\t";
				}
				else
				{
					$line .= $dob."\t";
				}
				if(!empty($val['user_gender'])){
					$gen ='';
					if($val['user_gender'] == 'm')
					{
						$gen ='Male';
						
					}
					else if($val['user_gender'] == 'f')
					{
						$gen ='Female';
						
					}
					else{
						
						$gen = '';
					}
					$line .= $gen."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['marital_status'])){
					$marital_status ='';
					if($val['marital_status'] == 'single')
					{
						$marital_status ='Single';
						
					}
					else
					{
						$marital_status ='Married';
						
					}
					
					$line .= $marital_status."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['ischild'])){
					$child ='';
					if($val['ischild'] == 'Y')
					{
						$child ='Yes';
						
					}
					else
					{
						$child ='No';
						
					}
					
					$line .= $child."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['user_profession'])){
					
					$line .= $val['user_profession']."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}				
				if(!empty($val['user_comments'])){
					
					$line .= $val['user_comments']."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!isset($val['user_status'])){
					$user_status ='';
					if($val['user_status'] == '0')
					{
						$user_status ='Process';
						
					}
					elseif($val['user_status'] == '1')
					{
						$user_status ='Approved';
						
					}
					elseif($val['user_status'] == '2')
					{
						$user_status ='Rejected';
						
					}
					$line .= $user_status."\t";
				}
				else
				{
					$line .= ""."\t";
					
				}
				if(!empty($val['createdOn'])){
					$createdOn ='';				
					if($val['createdOn'] != '0000-00-00'){
						$createdOn = date('d/m/Y',strtotime($val['createdOn']));
						
					}
					$line .= $createdOn."\t";
				}
				else
				{
					$line .= $createdOn."\t";
				}
				if(!empty($val['modified_on'])){
					$mod_on ='';				
					if($val['modified_on'] != '0000-00-00'){
						$mod_on = date('d/m/Y',strtotime($val['modified_on']));
						
					}
					$line .= $mod_on."\t";
				}
				else
				{
					$line .= $mod_on."\t";
				}
				
				if(!isset($val['is_rejected'])){
					
					$reject_status ='';
					if($val['is_rejected'] == '0')
					{
						$reject_status ='No';
						
					}
					elseif($val['is_rejected'] == '1')
					{
						$reject_status ='Yes';
						
					}
					
					$line .= $reject_status."\t";
				}
				else
				{
					$line .= "No"."\t";
					
				}
				$data .= trim($line)."\n";
			}
		}
		$data = str_replace("\r", "", $data);
		if ($data == "")
		{
			$data = "\n(0) Records Found!\n";						
		}

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=SICL_new".'_'.date('m-d-Y_H:i').".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$data";
	}
	public function downloadFeedbackList(){
		
		$allFeedbackList = $this->Usermodel->allFeedbackList();
		//print_r($allmemberlist);
		
		$data	 = '';	
		$header_exl  = "Event Name"."\t";
		$header_exl .= "User Name"."\t";
		$header_exl .= "Overall Event Rate"."\t";
		$header_exl .= "Timing Rate"."\t";
		$header_exl .= "Entertainment Rate"."\t";
		$header_exl .= "Food Rate"."\t";
		$header_exl .= "Parking Rate"."\t";
		$header_exl .= "Gestlist Rate"."\t";		
		$header_exl .= "Facility Venue Rate"."\t";
		$header_exl .= "Pricing Rate"."\t";
		$header_exl .= "Vendor Mng Rate"."\t";		
		$header_exl .= "Attend Future Events"."\t";
		$header_exl .= "Food Quality Rate"."\t";		
		$header_exl .= "Overall Services Quality"."\t";
		$header_exl .= "Cleanliness Rate"."\t";
		$header_exl .= "Order Accuracy Rate"."\t";
		$header_exl .= "Speed Srvc Rate"."\t";
		$header_exl .= "Value Rate"."\t";		
		$header_exl .= "Overall Experience"."\t";
		$header_exl .= "Overall Experience Guest"."\t";
		$header_exl .= "Order Accuracy Rate"."\t";
		$header_exl .= "Improve Suggestions"."\t";
		$header_exl .= "Feedback Date"."\t";
		$header_exl .= "\n";
	
		if(!empty($allFeedbackList))
		{
			
			foreach($allFeedbackList as $feedback_list)
			{  
                            
				$line = '';
                $user_name = '';   
				if(!empty($feedback_list['event_name'])){
					
					$line .= $feedback_list['event_name']."\t";
				}
				else
				{
					$line .= ""."\t";
				}	
				if(!empty($feedback_list['user_title']) || !empty($feedback_list['user_firstname']) || !empty($feedback_list['user_middlename'])|| !empty($feedback_list['user_lastname'])){
					$user_name = $feedback_list['user_title'].' '.$feedback_list['user_firstname'].' '.$feedback_list['user_middlename'].' '.$feedback_list['user_lastname'];

					$line .= $user_name."\t";

					
				}
				else{
					$line .= $user_name."\t";

				}
				if(!empty($feedback_list['overall_event_rate'])){
					
					$line .= $feedback_list['overall_event_rate']."\t";
				}
				else
				{
					$line .= ""."\t";
				}
				if(!empty($feedback_list['timing_rate']) && $feedback_list['timing_rate'] != 'NoOpinion'){
					
					$line .= $feedback_list['timing_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
				}
				if(!empty($feedback_list['entertainment_rate']) && $feedback_list['entertainment_rate'] != 'NoOpinion'){
					
					$line .= $feedback_list['entertainment_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['food_rate']) && $feedback_list['food_rate'] != 'NoOpinion'){
					
					$line .= $feedback_list['food_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['parking_rate']) && $feedback_list['parking_rate'] != 'NoOpinion'){
					
					$line .= $feedback_list['parking_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['guestlist_rate']) && $feedback_list['guestlist_rate'] != 'NoOpinion'){
					
					$line .= $feedback_list['guestlist_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['facility_venue_rate']) && $feedback_list['facility_venue_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['facility_venue_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['pricing_rate']) && $feedback_list['pricing_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['pricing_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['vendor_mng_rate']) && $feedback_list['vendor_mng_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['vendor_mng_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['attend_ftur_events']) && $feedback_list['attend_ftur_events'] != 'No Opinion'){
					
					$line .= $feedback_list['attend_ftur_events']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['food_quality_rate']) && $feedback_list['food_quality_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['food_quality_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				
				if(!empty($feedback_list['overall_services_quality']) && $feedback_list['overall_services_quality'] != 'No Opinion'){
					
					$line .= $feedback_list['overall_services_quality']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}				
				if(!empty($feedback_list['cleanliness_rate']) && $feedback_list['cleanliness_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['cleanliness_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['order_accuracy_rate']) && $feedback_list['order_accuracy_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['order_accuracy_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				
				if(!empty($feedback_list['speed_srvc_rate']) && $feedback_list['speed_srvc_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['speed_srvc_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['value_rate']) && $feedback_list['value_rate'] != 'No Opinion'){
					
					$line .= $feedback_list['value_rate']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['overall_experience']) && $feedback_list['overall_experience'] != 'No Opinion'){
					
					$line .= $feedback_list['overall_experience']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['overall_experience_guest']) && $feedback_list['overall_experience_guest'] != 'No Opinion'){
					
					$line .= $feedback_list['overall_experience_guest']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['fav_part_event'])){
					
					$line .= $feedback_list['fav_part_event']."\t";
				}
				else
				{
					$line .= "No Opinion"."\t";
					
				}
				if(!empty($feedback_list['improve_suggestions'])){
						
					$line .= preg_replace( "/\r|\n/", "", $feedback_list['improve_suggestions'] )."\t";
				}
				else
				{
					$line .= "No suggession"."\t";
					
				}
				if(!empty($feedback_list['feedback_date'])){
					$feedback_date ='';				
					if($feedback_list['feedback_date'] != '0000-00-00'){
						$feedback_date = date('d/m/Y',strtotime($feedback_list['feedback_date']));
						
					}
					$line .= $feedback_date."\t";
				}
				else
				{
					$line .= $feedback_date."\t";
				}
				$data .= trim($line)."\n";
			}
		}
		$data = str_replace("\r", "", $data);
		if ($data == "")
		{
			$data = "\n(0) Records Found!\n";						
		}

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Event-feedbacklist".'_'.date('m-d-Y_H:i').".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header_exl\n$data";
	}
	
}