<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submissiontemp extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		//echo $this->session->userdata('userid'); exit;
		if($this->session->userdata('userid') =='') {
			//redirect(base_url()."tempuserlogin");
		}
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration','model_submissiontemp'));		
		$this->data['themePath'] 			= $this->config->item('theme');
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
	
	
	public function index() {
 		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK	
        $this->data['frmaction']					= base_url()."submissiontemp/update_member_info_temp";
		$stateDropdown								= $this->model_registration->populateDropdown("`state_id`", "`state_name`", "chben_states", "state_status='1'", "state_id", "ASC");
		
		$stateOptions                               = array();
		
		for ($c = 0; $c < count($stateDropdown); $c++){
			$stateOptions[$stateDropdown[$c]['state_id']]     =  $stateDropdown[$c]['state_name'];
		}
		$this->data['state_dropdown']                             = $stateOptions;	
		
		
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
        $user_id = $this->session->userdata('userid');
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_submissiontemp->getUserDetailsDB($ucond);
		$cond									= "user_id = '$user_id'";
		$spouseDetails							= $this->model_submissiontemp->getUserSpouseInfo($cond);
		$cond									= "user_id = '$user_id'";
		$getMemberwiseExpertizeListArr		    = $this->model_submissiontemp->getMemberwiseExpertizeList($cond);
		
		$this->data['userDetails']    = $userDetails;
		$this->data['spouseDetails']    = $spouseDetails;
		$this->data['getMemberwiseExpertizeListArr']    = $getMemberwiseExpertizeListArr;
		################### TO GET STATE LIST #############
        $cityDropdown = $this->model_registration->populateDropdown("city_id", "city_name", "chben_cities", "state_id = '".$userDetails['state_id']."'", "city_name", "ASC");
		$cityOptions = array();
		for ($c = 0; $c < count($cityDropdown); $c++){
			$cityOptions[$cityDropdown[$c]['city_id']]     =  $cityDropdown[$c]['city_name'];
		}
		$this->data['city_dropdown']  = $cityOptions;	
		################### END OF STATE LIST ##########
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		
		$this->elements['contentHtml']           	= $this->data['themePath'].'temp/final_submission_temp';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
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

	public function addMember() {
		$getType= isset($_POST['type'])&&$_POST['type']!=""?$_POST['type']:"";
		$data['type']				= array();

		$this->load->view($this->data['themePath'].'temp/ajaxAddRowMember',$data);
	}

	
	public function generateUniqueID( $uID = 0, $packageName = '') {
		$uniqueID='';
		$uniqueID			= "MEM";
		
		for($i = 0; $i < (4-strlen($uID)); $i++) {
			$uniqueID			.= "0";
		}
		
		$uniqueID				.= $uID;
			
		if(!empty($packageName)) {
			$uniqueID		.= '-'.$packageName;
		}
		return $uniqueID;
	}
	
	
	
		
	public function update_member_info_temp() {
		//echo "Hi"; exit;
	/*----------------------- EXISTING USER DETAILS UPDATE START -----------------------*/
		$userID								    = $this->session->userdata('userid');
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
		
		$process                                = '1';  

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
													"user_alternate_mobile"	=> $user_alternate_mobile,
													"user_designation"		=> $user_designation,
													"dependent_child"		=> $dependent_child,
													"dependent_adult"		=> $dependent_adult,													
													"user_process_status"   => $process
													
													);
		$condArr								= array("user_id" => $userID);	
		       	
		$editData								= $this->model_submissiontemp->updateData($editArr, 'chben_exist_old_users', $condArr);
		
		/*----------------------- EXISTING USER DETAILS UPDATE END -----------------------*/
		
		/*----------------------- USER DETAILS INSERT START -----------------------*/	
		if($editData) {
			
		$userID								    = $this->session->userdata('user_id');
		$user_title								= $this->input->post('user_title');
		$user_firstname							= $this->input->post('user_firstname');
		$user_middlename						= '';
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
		$country_id								= '1';		
		$user_area								= $this->input->post('user_area');
		$pin									= $this->input->post('pin');
		$user_mobile							= $this->session->userdata('user_mobile');
		$user_alternate_mobile					= $this->input->post('user_alternate_mobile');
		$user_email					    		= $this->session->userdata('user_email');
		$username					    		= $this->session->userdata('username');
		$password					    		= $this->session->userdata('password');
		//$user_unique_id							= $this->generateUniqueID();
		$proposer_id							= '';
		$user_mother_tongue                     = 'bengali'; 
		$user_package_id						= $this->session->userdata('user_package_id');
		$user_package_name                      = $this->model_submissiontemp->getPackageById($user_package_id);
		$user_designation					    = $this->input->post('user_designation');
		$dependent_child					    = $this->input->post('dependent_child');
		$dependent_adult					    = $this->input->post('dependent_adult');	
		$user_approved_guest_date				= '';
		$user_approved_proposer_date			= '';
		$user_approved_secretary_date           = '';
		$user_type	                            = '4';
		$user_status	                        = '1';
		$old_user	                            = '1';
		$is_rejected	                        = '0';
		$member_type	                        = NULL;
		
		$insArrOfUserMain = array(
									"user_title"			=> $user_title,
									"user_firstname"		=> $user_firstname,
									"user_middlename"		=> $user_middlename,
									"user_lastname"			=> $user_lastname,
									"user_gender"			=> $user_gender,
									"marital_status"		=> $marital_status,
									"user_profession"		=> $user_profession,
									"user_designation"		=> $user_designation,
									"user_dob"				=> $user_dob,
									"user_address"			=> $user_address,
									"user_address_line2"	=> $user_address_line2,
									"dependent_child"		=> $dependent_child,
									"dependent_adult"		=> $dependent_adult,
									"user_country"			=> $country_id,
									"state_id"				=> $state_id,
									"city_id"				=> $city_id,
									"user_area"				=> $user_area,
									"pin"					=> $pin,
									"user_mobile"			=> $user_mobile,
									"user_alternate_mobile"	=> $user_alternate_mobile,
									"user_email"			=> $user_email,
									"username"				=> $username,
									"password"				=> $password,
                                    "user_package_id"		=> $user_package_id,
									"user_mother_tongue"	=> $user_mother_tongue,
									"user_approved_guest_date"	=> $user_approved_guest_date,
                                    "user_approved_proposer_date"	=> $user_approved_proposer_date,
									"user_approved_secretary_date"	=> $user_approved_secretary_date,
									"user_type"						=> $user_type,
									"user_status"			        => $user_status,
									"is_rejected"			        => $is_rejected,
									"old_user"			            => $old_user,
									"member_type"			            => $member_type
									);
								
				
		$mainUserDetails = $this->model_registration->insdata($insArrOfUserMain,'chben_users');	
		/*----------------------- USER DETAILS INSERT END -----------------------*/
		$user_unique_id							= $this->generateUniqueID($mainUserDetails, $user_package_name);
		//echo '<br/>'.$user_unique_id; exit;
		$edituniqueID						= array(
												"user_unique_id"		=> $user_unique_id												
												);
		$conduArr								= array("user_id" => $mainUserDetails);
		$editData								= $this->model_submissiontemp->updateData($edituniqueID, 'chben_users', $conduArr);
		/*----------------------- USER SPOUSE DETAILS INSERT START -----------------------*/	
				$user_id 		    = $mainUserDetails;
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
				
			$insArrOfMemSpose = array(
						'user_id' 	                    => $user_id,
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
			$this->model_registration->insdata($insArrOfMemSpose,'chben_user_spouse_info');	
        /*----------------------- USER SPOUSE DETAILS INSERT END -----------------------*/
		/*----------------------- USER VERIFICATION DETAILSINSERT START -----------------------*/
				$user_id 		    = $mainUserDetails;
                
				
			$insArrOfUserVerification = array(
						'user_id' 	                    => $user_id,
						'user_mobile_otp_verified'      => '1',
						'user_email_otp_verified'       => '1',
						'proposer_otp_verified'         => '1'
						
                );	
			$this->model_registration->insdata($insArrOfUserVerification,'chben_users_verification');
		    /*----------------------- USER VERIFICATION DETAILS END -----------------------*/
			/*----------------------- USER REGISTRATION PROCESS START -----------------------*/
				$user_id 		    = $mainUserDetails;
                
				
			$insArrOfRegProcess = array(
						'user_id' 	                    => $user_id,
						'guest_registration'      		=> '1',
						'proposer_verification'       	=> '1',
						'package_payment'         		=> '1',
						'management_approval'        	=> '1',
						'final_submission'        		=> '1',
						'overall_process'        		=> '1'
						
                );	
			$this->model_registration->insdata($insArrOfRegProcess,'chben_reg_process');
		   
         
        /*----------------------- USER REGISTRATION PROCESS END -----------------------*/		
        /*----------------------- USER HOBBIES DETAILS INSERT START -----------------------*/	
			foreach ($_POST['hobbies_title'] as $key => $val) {
     
                $user_id 		= $mainUserDetails;
                $hobbies_title 	= $_POST['hobbies_title'][$key];
				$hobbies_firstname   = $_POST['hobbies_firstname'][$key];
                $hobbies_lastname   = $_POST['hobbies_lastname'][$key];
                $hobbies_area_of_expertise 	= $_POST['hobbies_area_of_expertise'][$key];
				$relationship_with_applicant   = $_POST['relationship_with_applicant'][$key];
                
            //SET ARRAY VARIABLES FOR INSERT INTO chben_user_member_hobbies table
    		$insArrOfMemHobbies = array(
						'user_id' 	                   => $user_id,
						'hobbies_title'                => $hobbies_title,
						'hobbies_firstname'            => $hobbies_firstname,
						'hobbies_lastname'             => $hobbies_lastname,
						'hobbies_area_of_expertise'    => $hobbies_area_of_expertise,
						'relationship_with_applicant'  => $relationship_with_applicant
						
                );
    		//Insert into chben_user_member_hobbies table
			$this->model_registration->insdata($insArrOfMemHobbies,'chben_user_member_hobbies');
        	  
			}
			/*----------------------- USER HOBBIES END -----------------------*/
			
     	}
	
	$this->session->set_flashdata('succmsg', 'You have successfully added as a member.');
    redirect(base_url()."tempuserlogin/thankyou");
	
	}
	
	private function templateView(){		
		$this->templatelayout->seo();
		$this->templatelayout->header_inner();
		$this->templatelayout->footer();
		$this->templatelayout->multiple_view($this->elements,$this->elements_data);
	}	
}

/* End of file Submissiontemp.php */
/* Location: ./application/controllers/submissiontemp.php */