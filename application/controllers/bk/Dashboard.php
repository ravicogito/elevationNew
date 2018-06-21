<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
    function __construct(){
		
		parent::__construct();
		if($this->session->userdata('user_id') =='') {
			redirect(base_url());
		}
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration','model_submission','model_home'));
		$this->data['home_banner']					= $this->model_home->getBanner();		
		$this->layout->setLayout('front_layout');
	}	
	
	public function index()
	{
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB | LOGIN';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	
		$this->data['event_lists']					= $this->model_submission->listEvents();
		$this->data['latest_event_lists']			= $this->model_submission->latestEvents();		
        
        $user_id = $this->session->userdata('user_id'); 
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsDB($ucond);
		$this->data['userDetails']    = $userDetails;
		$this->layout->view('templates/dashboard/dashboard',$this->data);
	}
	public function editProfile()
	{
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK		
		$stateDropdown								= $this->model_registration->populateDropdown("`state_id`", "`state_name`", "anad_states", "state_status='1'", "state_id", "ASC");
		
		$stateOptions                               = array();
		$stateOptions['']                           = "--Select State--";
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
		
		$ucond									= "UM.user_id = '$user_id'";
		$this->data['userDetails']									= $this->model_registration->getUserDetailsDB($ucond);
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
		$this->layout->view('templates/dashboard/editprofile_form',$this->data);
	
	
	}
	public function updateProfile(){
		if(!empty($_POST)){
			
			
		}
		
	}
	public function changeProfilepic()
	{
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK		
		$user_id = $this->session->userdata('user_id'); 
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_submission->getUserDetailsDB($ucond);
		$this->data['userDetails']    = $userDetails;
		
		$this->layout->view('templates/dashboard/changeprofile_pic',$this->data);
	
	
	}

}
