<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	 function __construct(){
		
		parent::__construct();
		$this->elements 							= array();
		$this->elements_data 						= array();
		$this->data 								= array();	

		$this->load->model(array('model_home'));
		$this->data['themePath'] 					= $this->config->item('theme');					
		$this->layout->setLayout('front_layout');
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
	public function index() {		
		
		$this->data['contentTitle']			= 'Elevation';
		$this->data['contentKeywords']		= '';		
		$this->data['location_lists']		= $this->model_home->alllocationList();
		$this->data['countlocation']		= $this->model_home->countgetlocationList();
		if($this->input->post('eventSearch')=='Search')
		{
			$location_name			= $this->input->post('location_name'); 
			$location_id			= $this->input->post('location_id'); 
			$this->data['location']	= $this->model_home->getlocationList($location_id,$location_name);
		}
		else{
		   $this->data['location']	= $this->model_home->getlocationList();		   
		}		
				
		$weather					= array();		
		
		if(!empty($this->data['location'])){
		foreach($this->data['location'] as $loc_list) {
				
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
		$this->data['loadmorecount']	=	'5';
		$this->data['weather_info']		=	$weather;
		$this->data['latlong'] 			= $latlongtiude;
		
			
		
		}
		//pr($this->data);
		
		$this->layout->view('templates/Home/home',$this->data);
	
	}
	function photographereDetails($location_id=''){
		$this->layout->setLayout('inner_layout');
		$result								=	array();
		$result_totalphoto					=	array();
		$customer_id 						= $this->session->userdata('customer_id');
		if(empty($customer_id)){
			
			$customer_id 						=	''; 
		}
		if($location_id !=''){
		$photographer_info					= $this->model_home->photographerListByLocationid($location_id,$customer_id);
		
		//pr($photographer_info);
		if(!empty($photographer_info)) {
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
			//pr($this->data['total_photo']);
			$this->data['photographer_info']				= $pList;		
			$this->layout->view('templates/Home/profile',$this->data);
		}
		else{
			$this->data['photographer_info']				= '';		
			$this->layout->view('templates/Home/profile',$this->data);
		}
	}
	else{
		//$this->data['photographer_info']				= '';			
		//$this->layout->view('templates/Home/profile',$this->data);
		redirect(base_url());
	}
}
	
	function populateAjaxresort(){
		$lid			= $this->input->post('location');
		$resort_lists	= $this->model_home->resortListByLocationid($lid);
		$fetchedOptions = array();
		
		if($resort_lists)
		{	
			for ($c=0; $c<count($resort_lists); $c++)
			{
				$fetchedOptions[$resort_lists[$c]['resort_id']] =   $resort_lists[$c]['resort_id'] . "|" . stripslashes($resort_lists[$c]['resort_name']);
			}
			
			echo implode("??",$fetchedOptions);
		}
		else{
			echo "";
		}
	}
	function Loadmorelocation(){
		$this->data['loadmorecount']	=	'';
		$start 							= $this->input->post('start');
		$this->data['contentTitle']		= 'Elevation';
		$this->data['contentKeywords']	= '';		
		$totalcountlocation				= $this->model_home->countgetlocationList();
		$tblname						= 'el_location';
		$condition						= "location_status='1'";
		$this->data['result']			= $this->model_home->loadlocationWithLimit($start,$tblname,$condition);	
		$tmpcount					= count($this->data['result']) ;
		if(!empty($this->data['result'])){
		foreach($this->data['result'] as $loc_list){
				
			$api_2 = 'http://api.openweathermap.org/data/2.5/weather?q='.$loc_list['location_name'].'&APPID=7eb4e09cd60880833d7ea97a686db4f6';
			error_reporting(E_ERROR | E_PARSE);
			$json = file_get_contents($api_2);
			if($json === FALSE){
				
			$weather[$loc_list['location_id']]	='NA';
				
			}
			else{
			 $data 								= json_decode($json,true);
			 $tmp_weather						= $data['main']['temp'];
			 $weather[$loc_list['location_id']]	= $tmp_weather - 273.15;
			 		
			}
		}
		$this->data['weather_info']				=	$weather;
		}
		else{
			$this->data['result']				= '';
		}
		$this->data['loadmorecount']			= $totalcountlocation - (5 + $tmpcount);
		
		//print_r($this->data['location_info']);	
		$this->load->view('templates/Home/ajax_home_load_more',$this->data);
	}
	
	function locationEventSearch($limit = ''){

		$this->data['contentTitle']		= 'Elevation';
		$this->data['contentKeywords']	= '';
		
		$location		= $this->input->post('location_id');
        $location_name 	= $this->input->post('location_name');
		
		$this->data['result']	= $this->model_home->locationEventSearchWithLimit($location,$location_name,$limit);	
		//echo "dnhghj";print_r($this->data['result']) ;exit;
		if(!empty($this->data['result'])){
		foreach($this->data['result'] as $loc_list){
				
			$api_2 = 'http://api.openweathermap.org/data/2.5/weather?q='.$loc_list['location_name'].'&APPID=7eb4e09cd60880833d7ea97a686db4f6';
			error_reporting(E_ERROR | E_PARSE);
			$json = file_get_contents($api_2);
			if($json === FALSE){
				
			$weather[$loc_list['location_id']]	='NA';
				
			}
			else{
			 $data 								= json_decode($json,true);
			 $tmp_weather						= $data['main']['temp'];
			 $weather[$loc_list['location_id']]	= $tmp_weather - 273.15;
			 		
			}
		}
		$this->data['weather_info']	=	$weather;
		}
		else{
			$this->data['result']	='';
		}
		//print_r($this->data['location_info']);	
		$this->load->view('templates/Home/ajax_home_load_more',$this->data);
	}
	

	function locationName(){
		
		$locationName           = isset($_POST['keyword'])?$_POST['keyword']:"";
		$locationDetils        = $this->model_home->getLocationName($locationName);
		$locationName           = "";
		
		$this->data['result']    = $locationDetils; 
		  
		$this->load->view('templates/Home/ajax_location_name',$this->data);
		  
	}


	public function locationMap(){
		//echo $address;
		//exit;

		$address =  $this->uri->segment(3);
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
        $lat= $output->results[0]->geometry->location->lat; 
        $long = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
			if(!empty($lat) && !empty($long)){
				//return $data;
				$this->data['latitude']	= $lat;
				$this->data['longitude'] = $long;
				$this->data['location'] = $address;
				$this->layout->view('templates/Home/locationMap',$this->data);

			}else{
				return false;
			}
		}else{
			return false;   
		}
	}
	
}

/* End of file Home.php */
/* Location: ./application/controllers/home.php */