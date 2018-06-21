<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerPhotos extends CI_Controller {

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

		$this->load->model(array('Model_customerPhotos'));
		$this->load->model(array('model_login','model_home'));
		$this->load->library('pagination');
		$this->data['themePath'] 					= $this->config->item('theme');					
		$this->layout->setLayout('photo_layout');
	}
	public function customerEventPhoto($location_id,$start='') {
		
		if($location_id !=''){
		$this->data['loadmorecount']	=	'';	
		$this->data['contentTitle']		= 'Customer Event Photo List';
		$this->data['contentKeywords']	= '';
		$this->data['location_id']		= $location_id;
		$customer_id 					= $this->session->userdata('customer_id'); 
		if(!empty($customer_id)){
			$this->data['customer_id']	= $customer_id;
		}
		//if($location_id)
		$customerLocationDetails		= $this->Model_customerPhotos->getcustomerLocationDetails($customer_id,$location_id);
		
		if(!empty($customerLocationDetails)){
				
			$this->data['locationDetails']		= $customerLocationDetails;
			
			//pr($customerLocationDetails);
			//Event Location and cutomer wise
			
			$eventDetails						= $this->Model_customerPhotos->getEventByLocationID($location_id,$customer_id,$start);
			
			$counteventDetails					= $this->Model_customerPhotos->countEventByLocationID($location_id,$customer_id);
		
			$this->data['eventDetails']					= $eventDetails;
			//pr($eventDetails);
			
			if(!empty($eventDetails)){
				$tmpcount				=	count($eventDetails);
				foreach($eventDetails as $key => $events) {
					$eventImages						   	= $this->Model_customerPhotos->getImagesByEventID($events['event_id'],$customer_id);
					
					$events_result[$events['event_id']]	   	= $eventImages;			
					
					$eventphotographername					= $this->Model_customerPhotos->getPhotographer($events['photographer_id']);
					//echo $eventphotographername;
					$photographer[$events['photographer_id']]  	= $eventphotographername;
					
					
					$eventAllImages						= $this->Model_customerPhotos->getAllImages($events['event_id'],$customer_id);
					//pr($eventAllImages);
					if(!empty($eventAllImages)){
						foreach($eventAllImages as $val){
						$eventsAllImages[$events['event_id']][]= $val;
						}
						
					}	
					//pr($eventsAllImages);
					
				}
				
				$this->data['allcountlist']		    			= $counteventDetails;
				
				$this->data['total_photo']		    			= $events_result;
				
				if(!empty($eventsAllImages)){
					
					$this->data['alleventsimages']				= $eventsAllImages;
				}
				//pr($this->data['alleventsimages']);
				$this->data['photographer']						= $photographer;
				
				$this->data['erro-msg']							='';		
							
				
			}
			else{
				$this->data['erro-msg']	='No Image on this event';
						
			}
			if(!empty($start)){
				$this->data['loadmorecount']			= $counteventDetails - (5 + $tmpcount);
				$this->load->view('templates/Customer_Photos/ajax_event_customer_photos_list',$this->data);
			}
			else{
				$this->data['loadmorecount']			=	'';
				$this->layout->view('templates/Customer_Photos/event_customer_photos_list',$this->data);
			}
		}
		else{
			
				$this->data['erro-msg']	='No event on this Location';
				$this->data['locationDetails']		='';		
				$this->layout->view('templates/Customer_Photos/event_customer_photos_list',$this->data);
				
		}
			
		}
		else{
			//echo"dhfkjh";
			redirect(base_url());

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
	
	public function customerEventPhotoList() {

		$this->data['contentTitle']		= 'Customer Event Photo List';
		$this->data['contentKeywords']	= '';
		$this->data['loadmorecount']	=	'';
		$customer_id 					= $this->session->userdata('customer_id'); 
		if(!empty($customer_id)){
			$this->data['customer_id']	= $customer_id;
		}
		
		$LocationIds					= $this->Model_customerPhotos->getLocationDetails($customer_id);
		//pr($LocationIds);
		if(!empty($LocationIds)){
			$this->data['location']		=	$LocationIds;
			foreach($LocationIds as $loc_list) {
				
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
			$this->layout->view('templates/Home/home',$this->data);
		}
		else{
			$this->data['erro-msg']	='You have no location ';
			$this->data['locationDetails']		='';
			$this->layout->view('templates/Home/home',$this->data);
		}
		
		
			
			
	}
	
	public function event_details($event_id) {
		$this->layout->view('templates/Customer_Photos/event_customer_photo_details',$this->data);
	}

    
	
	public function photodetails($location_id,$event_id) {
		$this->layout->setLayout('details_layout');
		
		
		$photographer   =   array(); 
		$this->data['contentTitle']			= 'Event Photo Details';
		$this->data['contentKeywords']		= '';	
		
		$customer_id 						= $this->session->userdata('customer_id'); 
		$location						    = $this->Model_customerPhotos->getLocation($location_id);
		$this->data['locationname']			= $location['location_name'];
		$this->data['locationid']			= $location['location_id'];
		
		
		$resort								= $this->Model_customerPhotos->getResort($customer_id,$location_id,$event_id);
		$this->data['resortname']			= $resort['resort_name'];
		$resort_id                          = $resort['resort_id'];   
		
		$eventdetails						= $this->Model_customerPhotos->getEvents($location_id,$resort_id,$event_id);
		$this->data['event_date']			= $eventdetails['event_date'];
		$this->data['event_name']			= $eventdetails['event_name'];
		$this->data['event_price']			= $eventdetails['event_price'];
		$this->data['event_id']				= $eventdetails['event_id'];
		$config 							= array();
		$config['total_rows'] 				= $this->Model_customerPhotos->getAllCustomerImages($event_id,$customer_id);
        $this->data['total_count'] 			= $config['total_rows'];
		$config['base_url'] = base_url() . 'CustomerPhotos/photodetails/'.$location_id.'/'.$event_id;
		$config["per_page"] = 6;
        $config["uri_segment"] = 5;
		$this->pagination->initialize($config);

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

		$eventAllImages						= $this->Model_customerPhotos->getAllDetailsImages($event_id,$customer_id,$config["per_page"], $page);
		$this->data['eventAllImages']		= $eventAllImages;
		
		$this->data['links'] = $this->pagination->create_links();
				
           
			if(!empty($eventAllImages))
				{	
					foreach($eventAllImages as $key => $eventAllImage)
						{
							$eventphotographername			= $this->Model_customerPhotos->getPhotographerdtls($eventAllImage['photographer_id']);

						}
					$this->data['photographer']			    = $eventphotographername;	
				}
				else
				{
					
				}
		
		//$eventAllImages						= $this->Model_customerPhotos->getAllDetailsImages($event_id,$customer_id);
		//$this->data['eventAllImages']		= $eventAllImages;
		
        		
		
		$this->layout->view('templates/Customer_Photos/event_customer_photo_details',$this->data);

	}
	
	
	public function photodetailsTemp() {
		//$location_id,$event_id
		$email = $this->uri->segment(3);
		
		//echo $this->uri->segment(3);
		//exit;
		
		if(isset($email) && !empty($email)){
			
			//echo base64_decode($email);
			//exit;
			
			//echo urldecode($email);
			//exit;
		
			$result = $this->model_login->getUserCredentials(urldecode($email));
			//print_r($result);
			//exit;
			$useremail = $result->customer_email;
			$password = $result->customer_password;
			$location_id = $result->location_id;
			
			//echo $useremail;
			//echo $password;
			//echo $location_id;
			//exit;
			
			
			
			
			
			if(!empty($useremail) && !empty($password)){
		
						
				$userDetails = $this->model_login->chkUserAuth($useremail,$password);
				//print_r($userDetails);
				//exit;
				if($userDetails) {
					$this->session->set_userdata('customer_id', $userDetails['customer_id']);
					//$this->nativesession->set( 'user_id', $userDetails['user_id'] );
					$this->session->set_userdata('customer_ref_id', $userDetails['customer_ref_id']);
					$this->session->set_userdata('customer_email', $userDetails['customer_email']);
					$this->session->set_userdata('customer_mobile', $userDetails['customer_mobile']);
					$this->session->set_userdata('location_id', $userDetails['location_id']);
					//echo $result = '1';
					$userID									= $this->session->userdata('user_id');
					
					//Get Event
					
					$eventDetails								= $this->Model_customerPhotos->getEventByLocationID($location_id,5);
					
					foreach($eventDetails as $events){
						
						$event_id = $events['event_id'];
					}

					
					$this->photodetails($location_id,$event_id);
					
				}
			} else{redirect(base_url());}
		} else{
			
			redirect(base_url());
		}
	}
}

/* End of file CustomerPhotos.php */
/* Location: ./application/controllers/CustomerPhotos.php */