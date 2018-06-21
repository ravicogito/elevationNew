<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	 function __construct(){
		
		parent::__construct();
		if($this->session->userdata('customer_id') =='') {
				redirect(base_url());
			}
		
		$this->elements 							= array();
		$this->elements_data 						= array();
		$this->data 								= array();	
        $this->load->model(array('Model_profile','model_home'));  
		$this->load->helper('download');	

		$this->data['themePath'] 					= $this->config->item('theme');					
		$this->layout->setLayout('inner_layout');
	}
	
	public function myaccount() {
	$this->data['contentTitle']		= 'Elevation | My account';
	$this->data['contentKeywords']	= '';
	$customer_id               		=  $this->session->userdata('customer_id');
	$userDetails			   		=  $this->Model_profile->getUserDetails($customer_id);
	//$locationId			   			=  $this->Model_profile->getLocationId($customer_id);
	$this->data['customer_id']		= $customer_id;
	$member_name                    = $userDetails['customer_firstname'].'&nbsp;'.$userDetails['customer_middlename'].'&nbsp;'.$userDetails['customer_lastname'];
	$this->data['member_name']		= $member_name;
	$this->data['member_email']		= $userDetails['customer_email'];
	$this->data['member_phone']		= $userDetails['customer_mobile'];
	$this->data['created_date']		= $userDetails['created_on'];
	$this->data['userDetails']		= $userDetails;
	$total_photo			   		= $this->Model_profile->getImagesByEventID($customer_id);
	if(!empty($total_photo)){
		$this->data['total_photo']		= $total_photo;
	}
	else{
		$this->data['total_photo']		= '0';
	}
	$this->layout->view('templates/Profile/myaccount',$this->data);	
	}

    function photographer(){
	
	$this->data['contentTitle']		= 'Elevation';
	$this->data['contentKeywords']	= '';			
	$customer_id               		=  $this->session->userdata('customer_id');	
	$photographer_info				=  $this->Model_profile->photographerListByCustomerid($customer_id);
	
	
	if(!empty($photographer_info)){
		$this->data['photographer_info']	=   $photographer_info;
		
		//pr($this->data['photographer_info']);
		$result								=	array();
		$result_totalphoto					=	array();
		$phID								= "";
		$cnt 								= 0;
		foreach($photographer_info as $key => $val) {
			
			$pList[$val['photographer_id']]["info"]	= array(
													"name" 				=> $val['photographer_name'],
													"member_on"			=> date("d.m.Y", strtotime($val['member_on'])),
													"description"		=> $val['photographer_description'],
													"email"				=> $val['photographer_email'],
													"phone"				=> $val['photographer_mobile'],
													//"event"				=> array($cnt => $val['event_id'])
												);
							
			//$pList[$val['photographer_id']]['event'][$cnt] = $val['event_id'];
			$total_event								= $this->model_home->eventAttenedByPhotographer($val['photographer_id']);
			if(!empty($total_event)){
				foreach($total_event as $val){
					$result[$val['photographer_id']]	=	$val['event_attnd'];				
				}
			}
			
			$total_photo			= $this->model_home->totalphotoByPhotographer($val['photographer_id']);
			if(!empty($total_photo) ){
				foreach($total_photo as $photoval){
				if($photoval['photographer_id'] != null){			
			
					$result_totalphoto[$photoval['photographer_id']]	=	$photoval['total_photo'];
				}
			
				}	
			}
			
		}
		$this->data['event_attened']					= $result;			
		$this->data['total_photo']						= $result_totalphoto;
		
		$this->layout->view('templates/Profile/photographer',$this->data);	
	}
	else{
		$this->data['photographer_info']	= '';	
		$this->layout->view('templates/Profile/photographer',$this->data);
		
	}
}
	public function getLatLong($address){
		//echo $address;
		//exit;
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyCJMZhj1LOlXpPsapzj3recS4C1x4aKK6U'); 
        $output = json_decode($geocodeFromAddr);
		//print_r($output);
		//exit;
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
			if(!empty($data)){
				return $data;
			}else{
				return false;
			}
		}else{
			return false;   
		}
	}
	function location(){
	$this->layout->setLayout('front_layout');
	$customer_id               		=  $this->session->userdata('customer_id');	
	$location			   			=  $this->Model_profile->getLocation($customer_id);
	//pr($location);
	//$locationDetils        			=  $this->Model_profile->getLocationdetails($locationId);
	if(!empty($location)){	
		$this->data['location']    		= $location; 	
	}
	
	if(!empty($location)){
		foreach($location as $loc_list){
				
			$api_2 = 'http://api.openweathermap.org/data/2.5/weather?q='.$loc_list['location_name'].'&APPID=7eb4e09cd60880833d7ea97a686db4f6';
			error_reporting(E_ERROR | E_PARSE);
			$json = file_get_contents($api_2);
			if($json === FALSE){
				
			$weather[$loc_list['location_id']]	='NA';
				
			}
			else{
			 $data 									= json_decode($json,true);
			 $tmp_weather							= $data['main']['temp'];
			 $weather[$loc_list['location_id']]	= $tmp_weather - 273.15;
			 		
			}
			
			//get Lat & long
			$latlongtiude[] = $this->getLatLong($loc_list['location_name']);
			
		}
		$this->data['weather_info']	=	$weather;
		$this->data['latlong'] = $latlongtiude;
		
			
		
		}
	//pr($this->data);	
	$this->layout->view('templates/Profile/location',$this->data);		
	}
	
	public function download($customer_id,$fileName) {   
	   if ($fileName) {
		$file = "uploads/customerImg_".$customer_id."/org/". $fileName;
		// check file exists 
		
		if (file_exists ( $file )) {
			$imgArr 		= explode(".",$fileName);
			$extension 		= end($imgArr);
			$dwnFile		= "download.".$extension;	
		 // get file content
		 $data = file_get_contents ( $file );
		 //echo $data; exit;
		 //force download
		 force_download ( $dwnFile, $data );
		} else {
		 // Redirect to base url
		 redirect ( base_url () );
		}
	}
	}
	
	
	public function sample_download($customer_id,$fileName) {   
	   if ($fileName) {
		$file = "uploads/customerImg_".$customer_id."/thumb/". $fileName;
		// check file exists 
		
		if (file_exists ( $file )) {
			$imgArr 		= explode(".",$fileName);
			$extension 		= end($imgArr);
			$dwnFile		= "download.".$extension;	
		 // get file content
		 $data = file_get_contents ( $file );
		 //echo $data; exit;
		 //force download
		 force_download ( $dwnFile, $data );
		} else {
		 // Redirect to base url
		 redirect ( base_url () );
		}
	}
	}
	
	
	
}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */	
	