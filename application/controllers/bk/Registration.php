<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->library('paypal_lib');	
		$this->load->model(array('model_registration','model_home'));
		$this->data['home_banner']					= $this->model_home->getBanner();	
		$this->layout->setLayout('front_layout');
		$this->load->library('form_validation');
	}	
	
	public function index() {		    
				    
		// SEO WORK
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
		
		$this->layout->view('templates/user/registration',$this->data);
	}
	
	public function insert_user_info() {
		$this->form_validation->set_rules('user_email', 'Email Id', 'required|valid_email|is_unique[anad_users.user_email]');
		if ($this->form_validation->run() == FALSE)
		{
            $error = 'Email Id already exist.';			
			$this->session->set_userdata('errmsg', $error);
			redirect(base_url()."registration");
		}
		else
		{
		$birth_day = $this->input->post('birth_date');
		$birth_month = $this->input->post('birth_month');
		if(array_key_exists('checkboxG4',$_POST)){
		$user_title								= $this->input->post('user_title');
		$user_firstname							= $this->input->post('user_firstname');
		$user_lastname							= $this->input->post('user_lastname');
		$user_dob								= $birth_day.'/'.$birth_month;
		//$user_dob								= date("Y-m-d", strtotime(str_replace("/","-", $user_dob)));
		$user_profession						= $this->input->post('user_profession');
		$marital_status							= $this->input->post('marital_status');
        $user_gender							= $this->input->post('user_gender');
		$child									= $this->input->post('no_of_child');
		$mobile_no								= $this->input->post('user_mobile');
		$user_email								= $this->input->post('user_email');
		$user_address1							= $this->input->post('user_address1');
		$user_address2							= $this->input->post('user_address2');
		$user_country							= '1';			
		$user_area								= $this->input->post('user_address2');		
		$state_id								= $this->input->post('state_id');
		$city_id								= $this->input->post('city_id');
		$pin									= $this->input->post('pin');
		$user_comments							= $this->input->post('user_comment');
		
		
		
		$insertArr								= array(
													"user_title"			=> $user_title,
													"user_firstname"		=> $user_firstname,
													"user_lastname"			=> $user_lastname,
													"user_gender"			=> $user_gender,
													"ischild"				=> $child,
													"marital_status"		=> $marital_status,
													"user_profession"		=> $user_profession,
													"user_dob"				=> $user_dob,
													"user_address"			=> $user_address1,
													"user_address_line2"	=> $user_address2,
													"user_country"			=> $user_country,
													"state_id"				=> $state_id,
													"city_id"				=> $city_id,
													"user_mobile"			=> $mobile_no,
													"user_email"			=> $user_email,
													"user_area"				=> $user_area,
													"pin"					=> $pin,
													"user_comments"			=> $user_comments,
													);
										
													
										
		$insertData								= $this->model_registration->insertData($insertArr, 'anad_users');
		$this->session->set_userdata('user_id', $insertData);
		$this->session->set_userdata('user_email', $user_email);
		if($insertData) {
			
                $user_id 		    = $insertData;
                $spouse_title 	    = $_POST['spouse_title'];
				$spouse_firstname   = $_POST['spouse_firstname'];
                $spouse_lastname    = $_POST['spouse_lastname'];
                $spouse_mobile 	    = $_POST['spouse_mobile'];
                $spouse_email       = $_POST['spouse_email'];
				
                
            //SET ARRAY VARIABLES FOR INSERT INTO chben_user_member_hobbies table
    		$insArrOfMemSpouse = array(
						'user_id' 	                    => $user_id,
						'spouse_title'                  => $spouse_title,
						'spouse_firstname'              => $spouse_firstname,
						'spouse_lastname'               => $spouse_lastname,
						'spouse_mobile'                 => $spouse_mobile,
						'spouse_email'                  => $spouse_email
						
                );

		    $spouseDetails							= $this->model_registration->insertData($insArrOfMemSpouse, 'anad_user_spouse_info');
    		//echo "<pre>";
			//print_r($_POST);
			//echo "</pre>"; //exit;
			foreach ($_POST['child_fname'] as $key => $val) {
				$user_id 				= $user_id;
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
    		//Insert into chben_user_member_hobbies table
			$this->model_registration->insdata($insArrOfMemHobbies,'anad_user_member_child');	
			
			}
          }
			redirect(base_url(). "registration/payment");
		}
		else
		{
			$error = 'Please check confirmation.';			
			$this->session->set_userdata('errmsg', $error);
			redirect(base_url()."registration");
		}
		
	}		
	}
	
	private function generateUniqueID($uID) {
		$uniqueID            ="";
		$uniqueID			.= "UIDA";
		for($i = 0; $i < (4-strlen($uID)); $i++) {
			$uniqueID			.= "0";
		}
		$uniqueID				.= $uID;
		
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
	
	public function payment() {		    
				    
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK		
		$user_id 							    	=$this->session->userdata('user_id');		
		$this->data['frmaction']					= base_url()."registration/paymentprocess/$user_id";
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		
		
		$this->layout->view('templates/user/payment',$this->data);
	}
	
	public function paymentprocess($id) {
        //Set variables for paypal form
        $returnURL 									= base_url().'paypal/success'; //payment success url
        $cancelURL 									= base_url().'paypal/cancel'; //payment cancel url
        $notifyURL 									= base_url().'paypal/ipn'; //ipn url
        //get particular product data
		$cond										= "UM.user_id = '$id'";
        $userDetails 								= $this->model_registration->getUserDetails($cond);
        $userID 									= $userDetails['user_id']; //current user id
		$userName 									= $userDetails['user_firstname'].'&nbsp;'.$userDetails['user_lastname']; //current user id
        $logo 										= base_url().'assets/images/logo.png';
		
		$user_unique_id								= $this->generateUniqueID($userID);
		$user_email                                 =$this->session->userdata('user_email'); 
        
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $user_unique_id);
        $this->paypal_lib->add_field('custom',$user_email);
        $this->paypal_lib->add_field('item_number', $userID);
        $this->paypal_lib->add_field('amount',  '125');        
        $this->paypal_lib->image($logo);
        
        $this->paypal_lib->paypal_auto_form();  


		/*----------------------- END -----------------------*/
		
		//redirect(base_url()."registration/thankyou");
	
	}
	
	public function thankyou() {		    
				    
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK		
				
		//$this->data['frmaction']					= base_url()."registration/paymentprocess/";
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_unique_id');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_mobile');
				
    	$this->session->sess_destroy(); # Change
		
		$this->layout->view('templates/user/reg_success',$this->data);
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
	
}

/* End of file Registration.php */
/* Location: ./application/controllers/registration.php */