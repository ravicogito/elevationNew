<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminapproval extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		/*if($this->session->userdata('user_id') =='') {
			redirect(base_url());
		}*/
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration', 'model_submission','model_login','model_home'));
		$this->data['home_banner']					= $this->model_home->getBanner();		
		$this->data['themePath'] 			= $this->config->item('theme');
	}
	
	public function index() {	

		$app_id = 	$this->uri->segment('3');
		$u_id = $this->session->userdata('user_id');
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK	
        $this->data['frmaction']					= base_url()."submission/update_member_info";
		$stateDropdown								= $this->model_registration->populateDropdown("`state_id`", "`state_name`", "chben_states", "state_status='1'", "state_id", "ASC");
		
		$stateOptions                               = array();
		
		for ($c = 0; $c < count($stateDropdown); $c++){
			$stateOptions[$stateDropdown[$c]['state_id']]     =  $stateDropdown[$c]['state_name'];
		}
		$this->data['state_dropdown']                             = $stateOptions;	
		
		
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		if(!empty($app_id)){
			$applicant_id = $app_id;
		}
		$ucond									    = "UM.user_id = '$applicant_id'";
		$userDetails							    = $this->model_registration->getUserDetailsDB($ucond);
		if(!empty($userDetails)){
			
			$cond									= "user_id = '$applicant_id'";
			$spouseDetails							= $this->model_submission->getUserSpouseInfo($cond);
			$getMemberwiseExpertizeListArr		    = $this->model_submission->getMemberwiseExpertizeList($cond);
			
			
			$this->data['user_id']			= $u_id;
				
			$this->data['userDetails']    	= $userDetails;
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
			$this->elements['contentHtml']           	= $this->data['themePath'].'adminapproval/applicantDetails';	
			$this->elements_data['contentHtml']      	= $this->data;		
			
			$this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
			$this->templateView();
		}
		
	}
	
	public function applicantDetails($applicant_id){
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK		
		
		$this->data['frm2action']					= base_url()."Adminapproval/adminchklogin/".$applicant_id;
		$this->data['forgotpassword']				= base_url()."user/forgotpassword/";
		$mobno										= $this->session->userdata('user_mobile');
		$userEmail									= $this->session->userdata('user_email');
		if(!empty($mobno)) {
			$this->data['logindata']				= $mobno;
		} else if(!empty($userEmail)) {
			$this->data['logindata']				= $userEmail;
		} else {
			$this->data['logindata']				= "";
		}
		
		$this->data['user_id']			= '';
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		$this->session->set_userdata('errmsg', '');
		$this->session->set_userdata('succmsg', '');
		
		
		$this->elements['contentHtml']           	= $this->data['themePath'].'adminapproval/applicantDetails';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
	}

	public function applicantDetailsApprove(){
		
		$appID = $this->input->post('id');
		$condArr       = "user_id = '$appID'";
		
		$processEditData     = array("management_approval" => "1","overall_process" => "1");
				
		$this->model_registration->editdata($processEditData, 'chben_reg_process', $condArr);
		
		$approveData     = array("user_type" => "4");            
		$editData        = $this->model_submission->updateData($approveData, 'chben_users', $condArr);
		
		if($editData){
			$userDetails	    = $this->model_submission->getProposerDetails($condArr);
			//print_r($userDetails);exit;
			$secretaryDetails	= $this->model_submission->getSecrateryDetailsDB();
			$transactionId	    = $this->model_submission->getUserTransactionId($userDetails['user_id']);
			$proposer_name	    = $this->model_submission->getUserProposerName($userDetails['proposer_id']);
			$emailID 			= $userDetails['user_email'];
			
			$mailData['from_email']	        = 'no-reply@chennaibengalassociation.com';
			$mailData['from_name']			= 'Chennaibengal association';		
			$mailData['to_email']			= $emailID;
			//$mailData['to_email']			= "sudhansupattu.cogitosoftware@gmail.com";
			$mailData['cc_mail']			= "cogito.sunav@gmail.com";
			$mailData['bcc_mail']			= '';	
			$mailData['subject']			= "Secretary Verification";
			
			$viewData['name']				=	'';
			//$viewData['secName']			= ucfirst($userDetails['user_firstname'])." ".ucfirst($userDetails['user_firstname']);
			$viewData['applicantName']		= $userDetails['user_title']." ".ucfirst($userDetails['user_firstname'])." ".ucfirst($userDetails['user_lastname']);
			$applicantName					= $viewData['applicantName'];
			$viewData['applicantUniqueId']	= $userDetails['user_unique_id'];
			$viewData['proposer']			= $proposer_name['user_title']." ".$proposer_name['user_firstname'];
			$viewData['username']			= $userDetails['user_mobile'];
			$username						= $viewData['username'];
			$viewData['password']			= $userDetails['password'];
			$password						= $viewData['password'];
			$viewData['email_url']			= base_url()."login/";

			$mailData['message'] 			= "<div style='padding:20px 10px; font-size:15px;'>Dear $applicantName<p><strong>Congratulations!</strong></p><p>Username:- $username</p><p>Password:- $password</p></div>"; //$this->load->view($this->data['themePath'].'adminapproval/after_approve.php', $viewData, true);			
			//echo $mailData['message'];exit;
			$this->sendMail($mailData);
			echo "success";		
		}
	}
	public function applicantDetailsReject(){
		
		$appID = $this->input->post('id');
		$condArr       = array("user_id" => $appID);		
		
		$approveData     = array("is_rejected" => "1");            
		$editData        = $this->model_submission->updateData($approveData, 'chben_users', $condArr);
		echo $editData;
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
	
	public function adminchklogin() {
		$app_id = 	$this->uri->segment('3');
				
		$logInData									= $this->input->post('txtlogindata');
		$password									= $this->input->post('txtpassword');
		
		$cond										= "(UM.user_mobile = '$logInData' OR UM.user_email = '$logInData') AND BINARY password = '$password'";
		$userDetails								= $this->model_login->getUserDetailsDB($cond);
		//pr($userDetails);
		if($userDetails) {
			$this->session->set_userdata('user_id', $userDetails['user_id']);
			$this->session->set_userdata('user_mobile', $userDetails['user_mobile']);
			$this->session->set_userdata('user_email', $userDetails['user_email']);
			if(!empty($app_id) && $userDetails['user_type'] == 3){
				
				redirect(base_url()."Adminapproval/index/".$app_id);
			}
			else {
				$error = 'YOU HAVE NOT THE AUTHORITY FOR APPROVAL THE APPLICANT ';			
				$this->session->set_userdata('errmsg', $error);
				redirect(base_url()."Adminapproval/applicantDetails/".$app_id);
			}
		} else {
			$error = 'mobile number or password incorrect';			
			$this->session->set_userdata('errmsg', $error);
			redirect(base_url()."login/");
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