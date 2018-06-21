<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submission extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		
		if($this->session->userdata('user_id') =='') {
			redirect(base_url());
		}
		
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration', 'model_submission','model_home'));		
		//$this->data['themePath'] 			= $this->config->item('theme');
		$this->data['home_banner']					= $this->model_home->getBanner();
		$this->layout->setLayout('front_layout');
	}
	
	public function index() {		    
		redirect(base_url()."submission/dashboard");
	}
	
	public function ajaximagecrop(){
		        
		$data = $_POST['image'];
		$userID = $this->session->userdata('user_id'); 


		list($type, $data) = explode(';', $data);

		list(, $data)      = explode(',', $data);


		$data = base64_decode($data);

		$imageName = time().'.png';
		 //echo getcwd(); exit;
		file_put_contents(getcwd().'/assets/cropprofileimage/'.$imageName, $data);


		   ###################  PROFILE UPDATION #############
		$editArr								= array(
		"user_profile_image"			=> $imageName,
		"user_profile_image_updated_on"	=> date("Y-m-d")

		);
		
		$condArr								= array("user_id" => $userID);												
		$editData								= $this->model_submission->updateData($editArr, 'anad_users', $condArr);

		
		if($editData) {
		
		}

		###################  END PROFILE UPDATION #########
				
	}

		
		public function sendMail($mailData = array()) {//pr($mailData);
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


	public function dashboard() {
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		$feedback_data	=array();
		$feedbackInfo	=array();
		// END SEO WORK	
		$user_id 									= $this->session->userdata('user_id'); 
		//echo $user_id; exit;
		$this->data['event_lists']					= $this->model_submission->listEvents();
		
		$this->data['oldevent_lists']				= $this->model_submission->listOldEvents();
			
		$this->data['eventCategory']				= $this->model_submission->eventCategoryList();
		$this->data['latest_event_lists']			= $this->model_submission->latestEventsDashboard($user_id);
		//echo "<pre>";
		//print_r($this->data['oldevent_lists']);
		
		
		$user_id 									= $this->session->userdata('user_id');
		
		$condition 									= "user_id = '$user_id'";
		$tableName 									= 'anad_coupon_booking';
		$couponInfo									= $this->model_submission->pastEventlist($tableName, $condition);
		foreach($couponInfo as $key => $val){
			
			$event_id = $val['event_id'];
			$bookingid = $val['id'];
			$condition = "event_id = '$event_id'";
			$tableName = 'anad_events';
			
			$couponInfo[$key]['event_details'] = $this->model_submission->pastEventlist($tableName, $condition);
			$feedbackcondition = "event_id = '$event_id' AND booking_id = '$bookingid' AND user_id = '$user_id'";
			$feedbackInfo[$key]['feedback_details']							= $this->model_submission->eventFeedbacklist('anad_event_feedback', $feedbackcondition);
		}
        $this->data['couponInfo']			= $couponInfo;
		if(!empty($feedbackInfo)){
		foreach($feedbackInfo as $val){
			if(!empty($val['feedback_details'])){
			foreach($val['feedback_details'] as $value){
				$feedback_data[] = $value;
			}	
			}
		}
		}
		$this->data['feedbackInfo']			= $feedback_data;
        $user_id 							= $this->session->userdata('user_id'); 
		$ucond								= "UM.user_id = '$user_id'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
		//print_r($userDetails);
		$allcategorylist					= $this->model_submission->getAllCategory();
		$this->data['allcategorylist']    	= $allcategorylist;
		
		$this->data['userDetails']    		= $userDetails;
		$ucond2								= "AMC.user_id = '$user_id'";
		$childDetails						= $this->model_registration->getChildDetailsDB($ucond2);
		
		$this->data['childDetails']    		= $childDetails;
		$this->layout->view('templates/dashboard/dashboard',$this->data);
	}
	
	public function dwnCard() {
		$user_id 							= $this->session->userdata('user_id'); 
		$ucond								= "UM.user_id = '$user_id'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
		
		$cond								= "user_id = '$user_id'";
		$spouseDetails						= $this->model_submission->getUserSpouseInfo($cond);
		
		//pr($userDetails,0);
		//pr($spouseDetails);
		$outPutData['user_details']			= $userDetails;
		if(empty($userDetails['user_profile_image'])) {
			$outPutData['user_details']['user_profile_image']	= "images/profilpic.png";
		} else {
			$outPutData['user_details']['user_profile_image']	= "cropprofileimage/".$userDetails['user_profile_image'];
		}
		/*if($spouseDetails) {
			$outPutData['user_details']['member']		= 2;
		} else {
			$outPutData['user_details']['member']		= 1;
		}*/
		$outPutData['user_details']['member']			=$userDetails['dependent_child']+$userDetails['dependent_adult'];
		//echo $outPutData['user_details']['member']; 
		//pr($outPutData);
		
		$html = '<style>@page{}</style>';
		//$html .= $outPutData;
		$html .= $this->load->view('theme_v_1/submission/card.php',$outPutData,true);
		//require_once('../chennai_cms/application/third_party/mpdf/mpdf.php');	
		
		require_once(getcwd().'/application/third_party/mpdf/mpdf.php');	
		$mpdf = new mPDF('win-1252', 'A4','', '','0', 0, '0', 0, 0, 1, 'L');
		$mpdf->useOnlyCoreFonts = false;    // false is default
		$mpdf->SetHTMLHeader('');
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);

		$filename = 'card.pdf';			
		$mpdf->Output($filename, 'D');
	}
	
	public function eventdetails($id){
		
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	
		
		$this->data['event_lists']					= $this->model_submission->listEvents();
		$this->data['latest_event_lists']			= $this->model_submission->latestEvents();
		$this->data['latestCirculars']				= $this->model_submission->latestCirclars();
		
		$this->data['event_details']			= $this->model_submission->eventDetails($id);
        
        $user_id = $this->session->userdata('user_id'); 
		
		$condition = "user_id = '$user_id'";
		$tableName = 'chben_coupon_booking';
		$couponInfo			= $this->model_submission->pastEventlist($tableName, $condition);
		foreach($couponInfo as $key => $val){
			
			$event_id = $val['event_id'];
			$condition = "event_id = '$event_id'";
			$tableName = 'chben_events';
			
			$couponInfo[$key]['event_details'] = $this->model_submission->pastEventlist($tableName, $condition);
		}
        $this->data['couponInfo']			= $couponInfo;
		
		$user_id 							= $this->session->userdata('user_id'); 
		$ucond								= "UM.user_id = '$user_id'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
		//pr($userDetails);
		$this->data['userDetails']    		= $userDetails;
		
		$proposer_id = $userDetails['proposer_id'];

		$ucond							  	= "user_unique_id = '$proposer_id'";
		$proposerDetails				  	= $this->model_submission->getProposerDetails($ucond);
		//print_r($proposerDetails);
		$this->data['proposerDetails']    	= $proposerDetails;
		#################### NEXT RENEWAL DATE CALCULATION ###########
          $user_package_id 					= $userDetails['user_package_id']; 
		  $userPackage						= $this->model_submission->getPackageDetails($user_package_id);
		  $this->data['package_details']	= $userPackage;
          $allow_array 						= array(1,3); 
          if(in_array($user_package_id, $allow_array)){
            $getNextRenewalDetailsArray = $this->model_submission->getNextRenewalDetails($user_id);
            
            $this->data['getNextRenewalDetailsArray']    = $getNextRenewalDetailsArray;
        }
        else{
        	$this->data['getNextRenewalDetailsArray']    = array();
        }
		#################### END OF REVEWAL DATE CALCULATION ########
		
		if($this->data['event_details'])
		{
			//$this->elements['contentHtml']           	= $this->data['themePath'].'submission/eventdetails';	
			//$this->elements_data['contentHtml']      	= $this->data;		
			
			//$this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
			//$this->templateView();
			$this->layout->view('templates/submission/eventdetails',$this->data);
		}
		else{
			redirect(base_url()."submission/dashboard");
		}
		
	}
	
	public function circulardetails($id){
		
	   // SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	
		
		$this->data['event_lists']					= $this->model_submission->listEvents();
		$this->data['latest_event_lists']			= $this->model_submission->latestEvents();
		$this->data['latestCirculars']				= $this->model_submission->latestCirclars();
		
		$this->data['circular_details']				= $this->model_submission->circularDetails($id);
        
        $user_id = $this->session->userdata('user_id'); 
		
		$condition = "user_id = '$user_id'";
		$tableName = 'chben_coupon_booking';
		$couponInfo			= $this->model_submission->pastEventlist($tableName, $condition);
		foreach($couponInfo as $key => $val){
			
			$event_id = $val['event_id'];
			$condition = "event_id = '$event_id'";
			$tableName = 'chben_events';
			
			$couponInfo[$key]['event_details'] = $this->model_submission->pastEventlist($tableName, $condition);
		}
        $this->data['couponInfo']			= $couponInfo;
		
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsDB($ucond);
		$this->data['userDetails']    = $userDetails;
		$proposer_id = $userDetails['proposer_id'];

		$ucond							  = "user_unique_id = '$proposer_id'";
		$proposerDetails				  = $this->model_submission->getProposerDetails($ucond);
		$this->data['proposerDetails']    = $proposerDetails;
		#################### NEXT RENEWAL DATE CALCULATION ###########
          $user_package_id 					= $userDetails['user_package_id']; 
		  $userPackage						= $this->model_submission->getPackageDetails($user_package_id);
		  $this->data['package_details']	= $userPackage;
          $allow_array 						= array(1,3);
          if(in_array($user_package_id, $allow_array)){
            $getNextRenewalDetailsArray = $this->model_submission->getNextRenewalDetails($user_id);
            
            $this->data['getNextRenewalDetailsArray']    = $getNextRenewalDetailsArray;
        }
        else{
        	$this->data['getNextRenewalDetailsArray']    = array();
        }
		#################### END OF REVEWAL DATE CALCULATION ########
		
		//if($this->data['event_details'])
		//{
			$this->elements['contentHtml']           	= $this->data['themePath'].'submission/circulardetails';	
			$this->elements_data['contentHtml']      	= $this->data;		
			
			$this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
			$this->templateView();
		//}
		//else{
			//redirect(base_url()."submission/dashboard");
		//}
		
	}

	
	public function populateAjaxCity(){
		$fetchedId			= $this->input->post('state');
				
		$comboVal = $this->model_registration->populateDropdown("city_id", "city_name", "anad_cities", "state_id = '".$fetchedId."'", "city_name", "ASC");
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

	public function addMember() {
		$getType= isset($_POST['type'])&&$_POST['type']!=""?$_POST['type']:"";
		/*$tempList 					= $this->model_incupldmo->fetchPhaseListing();
		$rankList 					= $this->model_incupldmo->fetchRankListing();
		$data["list"] 				= $tempList;
		$data["rankList"]			= $rankList;
		$data['type']				= $getType;*/
		$data['type']				= array();

		$this->load->view($this->data['themePath'].'submission/ajaxAddRowMember',$data);
	}
	public function update_member_info() {

		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit;*/
	
		//$userID									= 1;
		$userID								    = $this->session->userdata('user_id');
		$user_title								= $this->input->post('user_title');
		$user_firstname							= $this->input->post('user_firstname');
		$user_lastname							= $this->input->post('user_lastname');
		$marital_status							= $this->input->post('marital_status');
        $user_dob								= $this->input->post('user_dob');
		$user_dob								= date("Y-m-d", strtotime(str_replace("/","-", $user_dob)));
		$user_gender							= $this->input->post('user_gender');
		$user_profession						= $this->input->post('user_profession');
		$user_address							= $this->input->post('user_address');
		$user_address_line2						= $this->input->post('user_address_line2');		
		$state_id								= $this->input->post('state_id');
		$city_id								= $this->input->post('city_id');
		$user_area								= $this->input->post('user_area');
		$pin									= $this->input->post('pin');
		$user_alternate_mobile					= $this->input->post('user_alternate_mobile');
		$user_designation					    = $this->input->post('user_designation');
		$dependent_child					    = $this->input->post('dependent_child');
		$dependent_adult					    = $this->input->post('dependent_adult');
		// Generate Uniqued ID for the applicant.
		//$user_unique_id							= $this->generateUniqueID();
		// Generate random password for the applicant.
		//$password							= $this->generatePassword();
		$editArr								= array(
													"user_title"			=> $user_title,
													"user_firstname"		=> $user_firstname,
													"user_lastname"			=> $user_lastname,
													"user_gender"			=> $user_gender,
													"marital_status"		=> $marital_status,
													"user_profession"		=> $user_profession,
													"user_dob"				=> $user_dob,
													"user_address"			=> $user_address,
													"user_address_line2"	=> $user_address_line2,
													"state_id"				=> $state_id,
													"city_id"				=> $city_id,
													"user_area"				=> $user_area,
													"pin"					=> $pin,
													"user_alternate_mobile"			=> $user_alternate_mobile,
													"user_designation"				=> $user_designation,
													"dependent_child"				=> $dependent_child,
													"dependent_adult"				=> $dependent_adult
													
													);
		$condArr								= array("user_id" => $userID);												
		$editData								= $this->model_submission->updateData($editArr, 'chben_users', $condArr);
			
			
		if($editData) {
			
			//Update Registration process.
			$processEditData					= array("final_submission" => "1");
			$condArr							= array("user_id" => $userID);
			$this->model_registration->editdata($processEditData, 'chben_reg_process', $condArr);
		
			/*----------- Send password to mail and mobile -------*/
			
			/*----------------------- END -----------------------*/
			  ##########################  HERE WE INSERT DATA INTO chben_user_member_hobbies TABLE #################
			if(isset($_POST['spousebox'])){


                $user_id 		    = $userID;
                $spouse_title 	    = $_POST['spouse_title'];
				$spouse_firstname   = $_POST['spouse_firstname'];
                $spouse_lastname   = $_POST['spouse_lastname'];
                $spouse_current_address_line_1 	= $_POST['spouse_current_address_line_1'];
				$spouse_dob   = $_POST['spouse_dob'];
				$spouse_dob	  = date("Y-m-d", strtotime(str_replace("/","-", $spouse_dob)));
				$spouse_current_address_line_2 	= $_POST['spouse_current_address_line_2'];
                $spouse_mobile 	    = $_POST['spouse_mobile'];
				$spouse_profession_designation   = $_POST['spouse_profession_designation'];
                $spouse_email   = $_POST['spouse_email'];
				
                
            //SET ARRAY VARIABLES FOR INSERT INTO chben_user_member_hobbies table
    		$insArrOfMemHobbies = array(
						'user_id' 	                    => $userID,
						'spouse_title'                  => $spouse_title,
						'spouse_firstname'              => $spouse_firstname,
						'spouse_lastname'               => $spouse_lastname,
						'spouse_current_address_line_1' => $spouse_current_address_line_1,
						'spouse_dob'                    => $spouse_dob,
						'spouse_current_address_line_2' => $spouse_current_address_line_2,
						'spouse_mobile'                 => $spouse_mobile,
						'spouse_profession_designation' => $spouse_profession_designation,
						'spouse_email'                  => $spouse_email
						
                );

    		$cond									= "user_id = '$user_id'";
		    $spouseDetails							= $this->model_submission->getUserSpouseInfo($cond);
    		if(count($spouseDetails)>0){
            $condArr								= array("user_id" => $userID);												
		    $editData = $this->model_submission->updateData($insArrOfMemHobbies, 'chben_user_spouse_info', $condArr);
    		}
    		else
    		{
    		//Insert into chben_user_member_hobbies table
			$this->model_registration->insdata($insArrOfMemHobbies,'chben_user_spouse_info');
	
    		

    		####################### CREATE A ADON USER 13-09-2017 ################
    		####################### CREATE A ADON USER 13-09-2017 ################
    		####################### CREATE A ADON USER 13-09-2017 ################
    		
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsDB($ucond);
        $user_package_id = $userDetails['user_package_id']; 
        if($user_package_id==3){ // RULE ONLY FOR COUPLE MEMBER =3

            $spouse_gender = ($user_gender=="m")?'f':$user_gender;

    		$insUserArr								= array(
													"user_title"			=> $spouse_title,
													"user_firstname"		=> $spouse_firstname,
													"user_middlename"		=> $spouse_lastname,
													"user_lastname"			=> $spouse_lastname,
													"user_mobile"			=> $spouse_mobile,
													"user_email"		    => $spouse_email,
													"user_gender"			=> $spouse_gender,
													"marital_status"		=> $marital_status,
													"user_profession"		=> 'n.a',
													"user_dob"				=> $spouse_dob,
													"user_address"			=> $spouse_current_address_line_1,
													"user_address_line2"	=> $spouse_current_address_line_2,
													"user_country"			=> '1',
                                                    "state_id"				=> $state_id,
													"city_id"				=> $city_id,
													"user_area"				=> $user_area,
													"pin"					=> $pin,
													"user_designation"		=> 'N.A',
													"dependent_child"		=> $dependent_child,
													"dependent_adult"		=> $dependent_adult,
													"username"		        => $spouse_email,
													"password"				=> $spouse_mobile,
													"member_type"			=> 'add-on',
													"user_type"				=> '4',
													"user_package_id"	    => '1'
													);
			              $sposeUserID = $this->model_registration->insdata($insUserArr, 'chben_users');

			              if($sposeUserID) {

			    ####### HERE I AM GENERATING THE UNIQUE ID of the spose #########          	
				$user_unique_id		= $this->generateUniqueID($sposeUserID);
                $editArr								= array(
				"user_unique_id"		=> $user_unique_id,
				"proposer_id"			=> $userDetails['user_unique_id']				
				);
				
				$condArr		= array("user_id" => $sposeUserID);												
				$editData		= $this->model_submission->updateData($editArr, 'chben_users', $condArr);
                ########### END GENERATING THE UNIQUE ID of the spose ##############

				$insUserVerArr		= array(
										"user_id"					=> $userID,			
										"user_mobile_otp"			=> '1111',
										"user_email_otp"	        => "1111",
										"user_mobile_otp_verified"	=> '1',
										"user_email_otp_verified"	=> '1',
										"proposer_otp"	            => "1111",
										"proposer_otp_verified"	    => "1"
										);
				$this->model_registration->insdata($insUserVerArr, 'chben_users_verification');
				
				$insRegProcessArr		= array(
											"user_id"			    => $userID,
											"guest_registration"    => '1',
											"proposer_verification"	=> '1',
											"package_payment"		=> '1',
											"management_approval"	=> "1",
											"final_submission"		=> '1',
											"overall_process"	    => "1"
											);
				$this->model_registration->insdata($insRegProcessArr, 'chben_reg_process');
			}
		} // end SM=3 checking
    		####################### END OF ADON USER              ################
    		####################### END OF ADON USER              ################
    		} // end spouse add first time and generation of add on user for spose
           }// end spose data insertion

             
           $condArr	= array("user_id" => $userID);		
           $this->model_registration->deletedata('chben_user_member_hobbies', $condArr);
                foreach ($_POST['hobbies_title'] as $key => $val) {
     
                $user_id 		= $userID;
                $hobbies_title 	= $_POST['hobbies_title'][$key];
				$hobbies_firstname   = $_POST['hobbies_firstname'][$key];
                $hobbies_lastname   = $_POST['hobbies_lastname'][$key];
                $hobbies_area_of_expertise 	= $_POST['hobbies_area_of_expertise'][$key];
				$relationship_with_applicant   = $_POST['relationship_with_applicant'][$key];
                
            //SET ARRAY VARIABLES FOR INSERT INTO chben_user_member_hobbies table
    		$insArrOfMemHobbies = array(
						'user_id' 	                   => $userID,
						'hobbies_title'                => $hobbies_title,
						'hobbies_firstname'            => $hobbies_firstname,
						'hobbies_lastname'             => $hobbies_lastname,
						'hobbies_area_of_expertise'    => $hobbies_area_of_expertise,
						'relationship_with_applicant'  => $relationship_with_applicant
						
                );
    		//Insert into chben_user_member_hobbies table
			$this->model_registration->insdata($insArrOfMemHobbies,'chben_user_member_hobbies');
        	  
				 }

				 ########## end chben_user_member_hobbies #######
			
				 $redirect_link 	= ($_POST['mode']=="continue")?'submission/uploadphoto':'submission';
			     redirect(base_url().$redirect_link);
		}
													
	}

	private function generateUniqueID($uID, $packageName = '') {
		$uniqueID			.= "MEM";
		for($i = 0; $i < (4-strlen($uID)); $i++) {
			$uniqueID			.= "0";
		}
		$uniqueID				.= $uID;
		
		return $uniqueID;
	}


		
	
	public function editProfile()
	{
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK		
		$stateDropdown								= $this->model_registration->populateDropdown("`state_id`", "`state_name`", "anad_states", "state_status='1'", "state_name", "ASC");
		
		$stateOptions                               = array();
		$stateOptions['']                           = "--Select County--";
		for ($c = 0; $c < count($stateDropdown); $c++){
			$stateOptions[$stateDropdown[$c]['state_id']]     =  $stateDropdown[$c]['state_name'];
		}
		
		$this->data['frmaction']					= base_url()."registration/insert_user_info/";
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		$this->data['state_dropdown']               = $stateOptions;
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		
		$user_id = $this->session->userdata('user_id');
		$ucond														= "UM.user_id = '$user_id'";
		$this->data['userDetails']									= $this->model_registration->getUserDetailsDB($ucond);
		//print_r($this->data['userDetails']);exit;
		$this->data['editprofileDetails']							= $this->model_submission->getEditProfileDetails($user_id);
		
		$this->data['childDetails']									= $this->model_submission->getChildDetails($user_id);
		
		if(!empty($this->data['editprofileDetails'])){
			foreach($this->data['editprofileDetails'] as $state_id_val)
			{
				$state_id = $state_id_val->state_id;
				
			}
		}
		
		//print_r($data['editprofileDetails']);exit;
		$cityDropdown = $this->model_registration->populateDropdown("city_id", "city_name", "anad_cities", "state_id = '".$state_id."'", "city_name", "ASC");

		$cityOptions = array();

		for ($c = 0; $c < count($cityDropdown); $c++){

			$cityOptions[$cityDropdown[$c]['city_id']]     =  $cityDropdown[$c]['city_name'];

		}

		$this->data['city_dropdown']  = $cityOptions;
		//print_r($this->data);exit;
		$this->layout->view('templates/dashboard/editprofile_form',$this->data);
	
	
	}
	public function updateProfile()
	{  /*echo "<pre>";
		print_r($_POST);
		echo "</pre>";exit;*/
		if(!empty($_POST)){
			
			$userID								    = $this->session->userdata('user_id');

			$user_title								= $this->input->post('user_title');

			$user_firstname							= $this->input->post('user_firstname');

			$user_lastname							= $this->input->post('user_lastname');

			$marital_status							= $this->input->post('marital_status');

			$birth_date								= $this->input->post('birth_date');

			$birth_month							= $this->input->post('birth_month');

			$user_dob								= $birth_date.'/'.$birth_month;		

			$user_gender							= $this->input->post('user_gender');

			$user_profession						= $this->input->post('user_profession');
			
			$user_email								= $this->input->post('user_email');
			
			$ischild								= $this->input->post('no_of_child');
			
			$user_mobile							= $this->input->post('user_mobile');
			
			$createdOn								= $this->input->post('createdOn');
			$createdOn								= date("Y-m-d", strtotime(str_replace("/","-", $createdOn)));

			$user_address							= $this->input->post('user_address');

			$user_address_line2						= $this->input->post('address_line2');		

			$state_id								= $this->input->post('state_id');

			$city_id								= $this->input->post('city_id');

			$user_area								= $this->input->post('user_area');

			$pin									= $this->input->post('pin');

			$spouse_title							= $this->input->post('spouse_title');

			$spouse_firstname					    = $this->input->post('spouse_firstname');

			$spouse_lastname					    = $this->input->post('spouse_lastname');

			$spouse_email					    	= $this->input->post('spouse_email');
			
			$spouse_mobile					    	= $this->input->post('spouse_mobile');
			
			$child_id					    		= $this->input->post('child_id');
			
			$child_age0					    		= $this->input->post('age0');
			
			$child_age1					    		= $this->input->post('age1');
			
			$child_age2					    		= $this->input->post('age2');
			
			$child_age3					    		= $this->input->post('age3');
			
			$child_fname					    	= $this->input->post('child_fname');
			
			$child_lname					    	= $this->input->post('child_lname');
			
			$child_gender					    	= $this->input->post('child_gender');
			
			$child_mobile					    	= $this->input->post('child_mobile');
			
			$child_email					    	= $this->input->post('child_email');
			
			$user_comment					    	= $this->input->post('user_comment');
			
			
			
			$childrecord							= $this->model_submission->findchildData($userID);	
			//echo $childrecord;exit;
			if($childrecord == '0'){
				
				foreach ($_POST['child_fname'] as $key => $val) {

				$user_id 				= $userID;

				$age 					= $_POST['age'.$key][0];

                $child_fname 			= $_POST['child_fname'][$key];

                $child_lname   			= $_POST['child_lname'][$key];

                $child_gender 			= $_POST['child_gender'][$key];

				$child_mobile   		= $_POST['child_mobile'][$key];

				$child_email   			= $_POST['child_email'][$key];

			//SET ARRAY VARIABLES FOR INSERT INTO chben_user_member_hobbies table

    		$insArrOfMemHobbies = array(

						'user_id' 	                   => $user_id,

						'age'                		   => $age,

						'child_fname'            	   => $child_fname,

						'child_lname'             	   => $child_lname,

						'child_gender'    			   => $child_gender,

						'child_mobile'				   => $child_mobile,

						'child_email'				   => $child_email

						

                );

				//print_r($insArrOfMemHobbies);exit;		//Insert into chben_user_member_hobbies table

						$this->model_registration->insdata($insArrOfMemHobbies,'anad_user_member_child');	

			

			}						
					//print_r($editchild);exit;							
					//$editchildData				= $this->model_submission->childDataInsertData($editchild,$userID);								
													
				// }
				

			}
			else{
				if(!empty($child_id)){
					foreach($child_id as $key => $val){
						
							$editchild				= array(
																
																"age"					=> $_POST['age'.$key][$key],"child_fname"			=> $child_fname[$key],

																"child_lname"			=> $child_lname[$key],

																"child_gender"			=> $child_gender[$key],
																
																"child_mobile"			=> $child_mobile[$key],

																"child_email"			=> $child_email[$key]

															);

							$childcondArr			= array("id"=>$key,"user_id" => $userID);	
							//print_r($editchild);exit;
							//print_r($childcondArr);exit;
							$editchildData				= $this->model_submission->childDataUpdateData($editchild,$childcondArr,$userID);		
						
					}
				}
			}
			
			$edituser								= array(

														"user_title"			=> $user_title,

														"user_firstname"		=> $user_firstname,

														"user_lastname"			=> $user_lastname,

														"user_gender"			=> $user_gender,

														"marital_status"		=> $marital_status,

														"user_profession"		=> $user_profession,

														"user_dob"				=> $user_dob,
														
														"user_email"			=> $user_email,

														"user_mobile"			=> $user_mobile,
														
														"ischild"				=> $ischild,
														
														"createdOn"				=> $createdOn,
														
														"user_address"			=> $user_address,

														"user_address_line2"	=> $user_address_line2,

														"state_id"				=> $state_id,

														"city_id"				=> $city_id,

														"user_area"				=> $user_area,

														"pin"					=> $pin,

														"user_comments"			=> $user_comment,
														"modified_on"			=> date('Y-m-d')
														);
				$editspouse								= array(
														
														"user_id"				=> $userID,
														
														"spouse_title"			=> $spouse_title,

														"spouse_firstname"		=> $spouse_firstname,

														"spouse_lastname"		=> $spouse_lastname,

														"spouse_mobile"			=> $spouse_mobile,

														"spouse_email"			=> $spouse_email

														);										
														
				
				$condArr								= array("user_id" => $userID);												

				$editData								= $this->model_submission->updateData($edituser, 'anad_users', $condArr);
				$editspouseData							= $this->model_submission->spouseDataUpdateData($editspouse,$userID);
			
			$user_id 									= $this->session->userdata('user_id'); 
			$ucond								= "UM.user_id = '$user_id'";

			$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
			
			$update_date  = date("Y-m-d", strtotime(str_replace("/", "-", $userDetails['modified_on']))); 

			$updateOn  = date("jS F Y", strtotime(str_replace("/", "-", $update_date)));


			
			##########################################
		###################Email Send to support#######################		
			$mailData['from_email']				 	= 'noreply@anandclub.org';
			$mailData['from_name']					= 'Anand Club';		
			//$mailData['to_email']					= 'support@anandclub.org';
			$mailData['to_email']					= $userDetails['user_email'];			
			$mailData['cc_mail']					= "support@anandclub.org";
			$mailData['replyto_email']				= "support@anandclub.org";
			$mailData['bcc_mail']					= '';	
			$mailData['subject']					= 'Confirmation that you have updated your profile information.';
			$mailData['message']					= "<div>

	<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;\">

  <tr>

    <td colspan=\"2\"><strong>Dear Member,</strong></td>    

  </tr>

  <tr>

      <td></td>

      <td>&nbsp;</td>

    </tr>

    <tr>

    <td colspan=\"2\">Thank you for updating your profile information. I hope you enjoyed the experience.</td>    

  </tr>

  <tr>

      <td></td>

      <td>&nbsp;</td>

    </tr>

	<tr>

      <td><b>Member Name: </b>".strtoupper($userDetails['user_title'])."&nbsp;".strtoupper($userDetails['user_firstname'])."&nbsp;".strtoupper($userDetails['user_lastname'])."</td>

	</tr>
	<tr>

      <td><b>Member Id:</b> ".$userDetails['user_unique_id']."</td>

	</tr>

    <tr> 	

      <td><b>Update On:</b> ".$updateOn."</td>

    </tr>	
	<tr>

      <td></td>

      <td>&nbsp;</td>

    </tr>
	<tr>

      <td>This email confirms you that your updates were registered in the database.</td>

	</tr>
	<tr>

      <td>&nbsp;</td>

    </tr>
	<tr>

      <td><b>Please note:</b><i> If you did not update your information in last 24 hrs and you received this email, please contact us at <b>support@anadclub.org</b> immediately. </i></td>

	</tr>
	<tr>

      <td>If you need any assistance please refer to the FAQ section for further assistance. </td>

	</tr>

	<tr>

      <td  colspan=\"2\">



<br />

<p><strong>Thanking you,<br /><br />

Warm Regards,</strong>

<br /><br />



<i>Anand Club<br />

Support Team</i><br />

www.anandclub.org<br />

email: support@anandclub.org</p></td>

     

    </tr>

</div>";
			
			
			
			
		$this->sendMail($mailData);
		##########################################################
			redirect(base_url()."submission/dashboard");
		}
	}
	public function uploadphoto()
	{
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		$feedback_data	=array();
		// END SEO WORK		
		$this->data['latest_event_lists']			= $this->model_submission->latestEvents();
		$user_id = $this->session->userdata('user_id'); 
		$ucond									= "UM.user_id = '$user_id'";
		
		$this->data['event_lists']					= $this->model_submission->listEvents();
		
			
		
		$this->data['latest_event_lists']			= $this->model_submission->latestEventsDashboard($user_id);
		//echo "<pre>";
		//print_r($this->data['latest_event_lists']);
		
		
		$user_id 									= $this->session->userdata('user_id');
		
		$condition 									= "user_id = '$user_id'";
		$tableName 									= 'anad_coupon_booking';
		$couponInfo									= $this->model_submission->pastEventlist($tableName, $condition);
		foreach($couponInfo as $key => $val){
			
			$event_id = $val['event_id'];
			$bookingid = $val['id'];
			$condition = "event_id = '$event_id'";
			$tableName = 'anad_events';
			
			$couponInfo[$key]['event_details'] = $this->model_submission->pastEventlist($tableName, $condition);
			$feedbackcondition = "event_id = '$event_id' AND booking_id = '$bookingid' AND user_id = '$user_id'";
			$feedbackInfo[$key]['feedback_details']							= $this->model_submission->eventFeedbacklist('anad_event_feedback', $feedbackcondition);
		}
        $this->data['couponInfo']			= $couponInfo;
		if(!empty($feedbackInfo)){
		foreach($feedbackInfo as $val){
			if(!empty($val['feedback_details'])){
			foreach($val['feedback_details'] as $value){
				$feedback_data[] = $value;
			}	
			}
		}
		}
		$this->data['feedbackInfo']			= $feedback_data;
        
        $user_id 							= $this->session->userdata('user_id'); 
		$ucond								= "UM.user_id = '$user_id'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
		
		$this->data['userDetails']    		= $userDetails;
		
		
		$this->data['frmaction']					= base_url()."submission/update_member_info";
		
		$ucond2								= "AMC.user_id = '$user_id'";
		$childDetails						= $this->model_registration->getChildDetailsDB($ucond2);
		
		$this->data['childDetails']    		= $childDetails;
		
		$this->layout->view('templates/dashboard/changeprofile_pic',$this->data);
	
	
	}	
	
	public function viewFeedback($event_id){
		$this->data	= array();
		$user_id 	= $this->session->userdata('user_id');
		$booking_id =  $this->model_submission->GetBookingId($user_id, $event_id);
		$booking_id	=  $booking_id['id'];
		$this->data['booking_id'] = $booking_id;
		
		$this->data['event_id']						= $event_id;
		 
		//echo $user_id; exit;
		$this->data['event_lists']					= $this->model_submission->listEvents();
		
			
		
		$this->data['latest_event_lists']			= $this->model_submission->latestEvents($user_id);
		//echo "<pre>";
		//print_r($this->data['latest_event_lists']);
	
		
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		
		$eventInfo = $this->model_submission->pastEventlist($tableName, $condition);	
		
		
        $this->data['eventInfo']			= $eventInfo;
		//print_r($this->data['couponInfo']);exit;
		
		$ucond								= "UM.user_id = '$user_id'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
		$this->data['userDetails']			= $userDetails;	
		
		$feedbackcondition 					= "event_id = '$event_id' AND booking_id = '$booking_id' AND user_id = '$user_id'";
		$feedbackInfo						= $this->model_submission->eventFeedbacklist('anad_event_feedback', $feedbackcondition);
		$this->data['feedbackInfo']			= $feedbackInfo;
		
		$this->layout->view('templates/dashboard/feedback_view',$this->data);		
		
	}
	
	public function ajaxEventgallery()
	{
		$this->data		= array();
		$event_cat_id 	= $this->input->post('cat_id');
		$tmp_cat_id		= explode("_",$event_cat_id);
		$cat_id			= $tmp_cat_id[2];
		$user_id 		= $this->session->userdata('user_id');
		$ucond								= "UM.user_id = '$user_id'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
		$allUserDetails						= $this->model_submission->getAllUserDetails();
		//print_r($allUserDetails);
		$userType							= $userDetails['user_type'];
		$cat_name	= $this->model_submission->getCatName($cat_id);
		$this->data['cat_name'] = $cat_name['event_category_name'];
		$this->data['cat_id']	= $cat_id;
		$this->data['user_id']	= $user_id;	
		//echo $this->data['cat_name'];exit;
		/*if($cat_id !='4'){
			$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$cat_id);
		}
		else{
			$event_gallery_info	= $this->model_submission->eventGalleryForMemeber($userType);
			
		}*/
		
		$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$cat_id);
		$this->data['event_gallery_info']	=	$event_gallery_info;
		
		$this->data['allUserDetails']		=	$allUserDetails;
		$this->data['user_type']			=	$userType;
		$this->data['msg_status']			=	'';
		$this->load->view('theme_v_1/dashboard/ajaxEventGalleryView',$this->data);
	}
	
	public function uploadimgGallery()
	{
		
		$this->data = array();
		$file_type							= $this->input->post('event_image');
		$event_img_cat						= $this->input->post('event_glry_cat');
		$this->data['event_gllry_cat']		= $event_img_cat;
		$user_id 							= $this->session->userdata('user_id');
		$ucond								= "UM.user_id = '$user_id'";
		$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
		
		//print_r($_FILES);exit;
		$insertEventGallery	= array();
		if($file_type == "image"){
			
			if(!empty($_FILES['event_gallery_pic_0']['name'])){	
			$filesCount = count($_FILES);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['gallery_pic']['name'] 		= $_FILES['event_gallery_pic_'.$i]['name'];
				$_FILES['gallery_pic']['type'] 		= $_FILES['event_gallery_pic_'.$i]['type'];
                $_FILES['gallery_pic']['tmp_name'] 	= $_FILES['event_gallery_pic_'.$i]['tmp_name'];
                $_FILES['gallery_pic']['error'] 	= $_FILES['event_gallery_pic_'.$i]['error'];
                $_FILES['gallery_pic']['size'] 		= $_FILES['event_gallery_pic_'.$i]['size'];
                $config['upload_path'] = 'uploads/event_gallery';
                $config['allowed_types'] = 'gif|jpg|png';
				
                $this->load->library('upload', $config);
				
				if (!file_exists('uploads')) {
						mkdir('uploads', 0777);
					}

				if (!file_exists('uploads/event_gallery')) {
					mkdir('uploads/event_gallery', 777);
				}
				 if (!$this->upload->do_upload('gallery_pic'))
					{
						   $error = array('error' => $this->upload->display_errors());
						   
					}
					else
					{
							$fileData = $this->upload->data();
							
							
							$configer = array(
								'image_library' => 'gd2',
								'source_image' => $fileData['full_path'],
								'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
								'maintain_ratio' => TRUE,
								'quality' => '72%', //tell CI to reduce the image quality and affect the image size
								'width' => 800,//new size of image
								'height' => 800,//new size of image
							);
							
							$this->load->library('image_lib');
							$this->image_lib->clear();
							$this->image_lib->initialize($configer);
							$this->image_lib->resize();
							
							
							$insertEventGallery	= array(	

										"gallery_id"			=> '',	
										
										"user_id"				=> $user_id,
										
										"user_type"				=> $userDetails['user_type'],
										
										"cat_id"				=> $event_img_cat,

										"gallery_img"			=> $fileData['file_name'],
										
										"media_type"			=> 'image',

										"gallery_status"		=> 'unpublish',

										"gallery_upload_date"	=> date('Y-m-d'),
										
										"delete_status"			=> '0',

										);	
						$lastinsertedID		= $this->model_submission->insertEventImageGallery('anad_events_gallery',$insertEventGallery);
							
					}               
            }
			}
		}
		else if($file_type == "video"){
					
		   $video_link			= $this->input->post('event_gallery_video');
		   
		   $insertEventGallery	= array(	

										"gallery_id"			=> '',	
										
										"user_id"				=> $user_id,
										
										"user_type"				=> $userDetails['user_type'],
										
										"cat_id"				=> $event_img_cat,

										"gallery_img"			=> $video_link,
										
										"media_type"			=> 'video',

										"gallery_status"		=> 'unpublish',

										"gallery_upload_date"	=> date('Y-m-d'),
										
										"delete_status"			=> '0',

										);	
			$lastinsertedID		= $this->model_submission->insertEventImageGallery('anad_events_gallery',$insertEventGallery);
		}
		if($lastinsertedID !=''){
			$allUserDetails						= $this->model_submission->getAllUserDetails();
			$userType							= $userDetails['user_type'];
			$cat_name							= $this->model_submission->getCatName($event_img_cat);
			$this->data['cat_name'] = $cat_name['event_category_name'];
			$this->data['cat_id']	= $event_img_cat;
			$this->data['user_id']	= $user_id;	
			
			$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$event_img_cat);
			$this->data['event_gallery_info']	=	$event_gallery_info;
			
			$this->data['allUserDetails']		=	$allUserDetails;
			$this->data['user_type']			=	$userType;
			$this->data['msg_status']			=	'';
			$this->load->view('theme_v_1/dashboard/ajaxEventGalleryView',$this->data);
		}
		else{
			echo "";
		}
	}
	public function gallerStatusUpdate()
	{
		$event_img_cat					= $this->input->post('grlly_cat_id');	
		$gallery_id						= $this->input->post('gallery_id');
		$status							= $this->input->post('status');
		$user_id 						= $this->session->userdata('user_id');	
		$ucond							= "UM.user_id = '$user_id'";
		$userDetails					= $this->model_registration->getUserDetailsDB($ucond);
		if($status =='publish'){
			$updatearr					= array("gallery_status"		=> 'publish');	
		}
		else if($status =='unpublish'){
			$updatearr					= array("gallery_status"		=> 'unpublish');	
		}
		$condArr						= array("user_id" => $user_id , "gallery_id" => $gallery_id);
		$affectrow						= $this->model_submission->updateGalleryStatus($updatearr,$condArr);
		if($affectrow!=0 && $status =='publish'){
			//echo "fshdgh";exit;
			$allUserDetails						= $this->model_submission->getAllUserDetails();
			$userType							= $userDetails['user_type'];
			$cat_name							= $this->model_submission->getCatName($event_img_cat);
			$this->data['cat_name'] = $cat_name['event_category_name'];
			$this->data['cat_id']	= $event_img_cat;
			$this->data['user_id']	= $user_id;	
			
			$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$event_img_cat);
			$this->data['event_gallery_info']	=	$event_gallery_info;
			
			$this->data['allUserDetails']		=	$allUserDetails;
			$this->data['user_type']			=	$userType;
			$this->data['msg_status']			=	'';
			$this->load->view('theme_v_1/dashboard/ajaxEventGalleryView',$this->data);
				
		}
		elseif($affectrow!=0 && $status =='unpublish'){
			//echo "123fshdgh";exit;
			$allUserDetails						= $this->model_submission->getAllUserDetails();
			$userType							= $userDetails['user_type'];
			$cat_name							= $this->model_submission->getCatName($event_img_cat);
			$this->data['cat_name'] = $cat_name['event_category_name'];
			$this->data['cat_id']	= $event_img_cat;
			$this->data['user_id']	= $user_id;	
			
			$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$event_img_cat);
			$this->data['event_gallery_info']	=	$event_gallery_info;
			
			$this->data['allUserDetails']		=	$allUserDetails;
			$this->data['user_type']			=	$userType;
			$this->data['msg_status']			=	'';
			$this->load->view('theme_v_1/dashboard/ajaxEventGalleryView',$this->data);
		}
		
		else{
			echo "";
		}
		
	}
	/*public function gallerStatusUpdateForManager($galleryId ='')
	{
		
		$status							=	'';
		$member_id						= $this->input->post('member_id');
		$gallery_id						= $this->input->post('gallery_id');
		$status							= $this->input->post('status');
		$user_id 						= $this->session->userdata('user_id');
		if(!empty($status)){
			$updatearr						= array("gallery_status"		=> 'publish',"publish_for_user"	=> $member_id);	
			$condArr						= array("user_id" => $user_id , "gallery_id" => $gallery_id);
			$affectrow						=	$this->model_submission->updateGalleryStatus($updatearr,$condArr);
			
			if($affectrow!=0){
				echo "Successfully Published";
				
			}
			else{
				echo "Please Try Again";
			}
		}
		else{
			$updatearr					= array("gallery_status"		=> 'unpublish',"publish_for_user"	=> NULL);
			$condArr						= array("user_id" => $user_id , "gallery_id" => $galleryId);
			$affectrow						=	$this->model_submission->updateGalleryStatus($updatearr,$condArr);	
			if($affectrow!=0){
				echo "<script>alert('Successfully Published');</script>";
				redirect(base_url()."submission/dashboard");
			}
			else{
				echo "<script>alert('Please Try Again');</script>";
				redirect(base_url()."submission/dashboard");
			}
		}
		
	}*/
	public function gallerStatusUpdateForManager()
	{
		$event_img_cat					= $this->input->post('grlly_cat_id');
		$member_id						= $this->input->post('member_id');
		$gallery_id						= $this->input->post('gallery_id');
		$status							= $this->input->post('status');
		$user_id 						= $this->session->userdata('user_id');
		$ucond							= "UM.user_id = '$user_id'";
		$userDetails					= $this->model_registration->getUserDetailsDB($ucond);
		if(!empty($member_id)){
			$updatearr						= array("gallery_status"		=> 'publish',"publish_for_user"	=> $member_id);	
			$condArr						= array("user_id" => $user_id , "gallery_id" => $gallery_id);
			$affectrow						=	$this->model_submission->updateGalleryStatus($updatearr,$condArr);
			
			if($affectrow!=0){
			$allUserDetails						= $this->model_submission->getAllUserDetails();
			$userType							= $userDetails['user_type'];
			$cat_name							= $this->model_submission->getCatName($event_img_cat);
			$this->data['cat_name'] = $cat_name['event_category_name'];
			$this->data['cat_id']	= $event_img_cat;
			$this->data['user_id']	= $user_id;	
			
			$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$event_img_cat);
			$this->data['event_gallery_info']	=	$event_gallery_info;
			
			$this->data['allUserDetails']		=	$allUserDetails;
			$this->data['user_type']			=	$userType;
			$this->data['msg_status']			=	'publish';
			$this->load->view('theme_v_1/dashboard/ajaxEventGalleryView',$this->data);
				
			}
			
			else{
				echo "";
			}
		}
		else{
			
			$updatearr					= array("gallery_status"		=> 'unpublish',"publish_for_user"	=> NULL);
			$condArr						= array("user_id" => $user_id , "gallery_id" => $gallery_id);
			$affectrow						=	$this->model_submission->updateGalleryStatus($updatearr,$condArr);	
			if($affectrow!=0){
				$allUserDetails						= $this->model_submission->getAllUserDetails();
				$userType							= $userDetails['user_type'];
				$cat_name							= $this->model_submission->getCatName($event_img_cat);
				$this->data['cat_name'] = $cat_name['event_category_name'];
				$this->data['cat_id']	= $event_img_cat;
				$this->data['user_id']	= $user_id;	
				
				$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$event_img_cat);
				$this->data['event_gallery_info']	=	$event_gallery_info;
				
				$this->data['allUserDetails']		=	$allUserDetails;
				$this->data['user_type']			=	$userType;
				$this->data['msg_status']			=	'unpublish';
				$this->load->view('theme_v_1/dashboard/ajaxEventGalleryView',$this->data);
				
			}
			else{
				echo "";
			}
		}
		
	}
	public function getSellectedMember(){
		$gallery_id = $this->input->post('gallery_id');
		$user_id 	= $this->session->userdata('user_id');
		$cat_id		= '4';
		$condArr	= "user_id = '".$user_id. "' AND gallery_id = '". $gallery_id ."' AND cat_id ='" .$cat_id."'";
		
		$memberID	= $this->model_submission->getMemberID($condArr);	
		$memberID['publish_for_user'];
		echo json_encode($memberID['publish_for_user']);
		
	}
	public function deleteGalleryImage(){
		$event_img_cat	= $this->input->post('grlly_cat_id');
		$gallery_id 	= $this->input->post('gallery_id');
		$delete_result	= $this->model_submission->getDeleteImage($gallery_id);
		$user_id 						= $this->session->userdata('user_id');
		$ucond							= "UM.user_id = '$user_id'";
		$userDetails					= $this->model_registration->getUserDetailsDB($ucond);
		if($delete_result){
			
			$allUserDetails						= $this->model_submission->getAllUserDetails();
			$userType							= $userDetails['user_type'];
			$cat_name							= $this->model_submission->getCatName($event_img_cat);
			$this->data['cat_name'] = $cat_name['event_category_name'];
			$this->data['cat_id']	= $event_img_cat;
			$this->data['user_id']	= $user_id;	
			
			$event_gallery_info	= $this->model_submission->eventGalleryDetails($user_id,$event_img_cat);
			$this->data['event_gallery_info']	=	$event_gallery_info;			
			$this->data['allUserDetails']		=	$allUserDetails;
			$this->data['user_type']			=	$userType;
			$this->data['msg_status']			=	'';
			$this->load->view('theme_v_1/dashboard/ajaxEventGalleryView',$this->data);
			
		}
		else{
			
			echo "";
		}
		
	}
	private function templateView(){		
		$this->templatelayout->seo();
		$this->templatelayout->header_inner();
		$this->templatelayout->footer();
		$this->templatelayout->multiple_view($this->elements,$this->elements_data);
	}	
	

}

/* End of file Registration.php */
/* Location: ./application/controllers/registration.php */