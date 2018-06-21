<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Eventmodel');			
			$this->load->model('Photographermodel');
			$this->load->model('CustomerImageModel');
			$this->load->model('Customermodel');
			$this->load->model('resortmodel');
	}


	public function index(){
			$data['event_data']= $this->Eventmodel->listEvents();			
			$data['front_url'] = $this->config->item('front_url');
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/event_list", $data);
			$this->load->view("common/footer-inner");
		
	}

	public function addEvent(){
		$photographerlist	= $this->CustomerImageModel->listPhotographer();
		if(!empty($photographerlist)){	
			$data['photographerlist']		= $photographerlist;	
		}
		
		$location_list		= $this->Customermodel->locationList();	
		if(!empty($location_list)){	
			$data['location_list']		= $location_list;	
		}
		
		$resort_list		= $this->resortmodel->index();
		if(!empty($resort_list)){	
			$data['resort_list']		= $resort_list;	
		}
		
		if(!empty($_POST)){		
			$data =  array(	'event_id'				=>'',
							'event_name'			=>$this->input->post('event_name'),					'event_description'		=>$this->input->post('event_description'),
							'location_id'			=>$this->input->post('location_id'),
							'resort_id'				=>$this->input->post('resort_name'),
							'event_date'			=>date('Y-m-d',strtotime($this->input->post('event_date'))),
							'photographer_id'		=>$this->input->post('photographer_name'),
							'event_status'			=>'1'										
						);		
			$mess = $this->Eventmodel->addEvents($data);		
			if($mess){			
				$this->session->set_flashdata("sucessPageMessage","New Event Added Successfully!");			redirect(base_url()."Event");		
			}	
		}	
		else{			
				$this->load->view("common/header");			
				$this->load->view("common/sidebar");			
				$this->load->view('theme-v1/add_event',$data);			
				$this->load->view("common/footer-inner");		
			}	
	}
	
	public function editEvent($id=''){
			
		$location_list		= $this->Customermodel->locationList();	
		if(!empty($location_list)){	
			$data['location_list']		= $location_list;	
		}
		$data['event_data'] 		= $this->Eventmodel->Eventedit($id);
		if(!empty($data['event_data'])){
		$resort_id	= $data['event_data']['resort_id'];
		$photographer_id	=	$data['event_data']['photographer_id'];
		}
		$resort_list		= $this->resortmodel->Resortedit($resort_id);
		if(!empty($resort_list)){	
			$data['resort_list']		= $resort_list;	
		}
		//print_r($data['resort_list']);
		$photographerlist	= $this->Photographermodel->photographerEdit($photographer_id);
		if(!empty($photographerlist)){	
			$data['photographerlist']		= $photographerlist;	
		}
		//print_r($data['event_data']);
		if(!empty($data['event_data'])){
			$this->load->view("common/header");			
			$this->load->view("common/sidebar");			
			$this->load->view('theme-v1/edit_event',$data);			
			$this->load->view("common/footer-inner");		
		}		
		else{						
			redirect(base_url()."Event/");		
		}		

	}
	public function populateAjaxResortByLocation(){
	$fetchedId			= $this->input->post('location');
	
	if(!empty($fetchedId)){	
		
	$comboVal = $this->Customermodel->populateDropdown("resort_id", "resort_name", "el_resort", "location_id = '".$fetchedId."'" , "resort_name", "ASC");
	
			$fetchedOptions = array();
			
			if($comboVal)
			{	
				for ($c=0; $c<count($comboVal); $c++)
				{
					$fetchedOptions[$comboVal[$c]['resort_id']] =   $comboVal[$c]['resort_id'] . "|" . stripslashes($comboVal[$c]['resort_name']);
				}
				
				echo implode("??",$fetchedOptions);
			}
			else{
				echo "";
			}
	}
	}
	
	public function populateAjaxPhotographerByLocation(){
	$fetchedId			= $this->input->post('resort');
	
	if(!empty($fetchedId)){	
		
	$comboVal = $this->Eventmodel->populateDropdown($fetchedId);
	
			$fetchedOptions = array();
			
			if($comboVal)
			{	
				for ($c=0; $c<count($comboVal); $c++)
				{
					$fetchedOptions[$comboVal[$c]['photographer_id']] =   $comboVal[$c]['photographer_id'] . "|" . stripslashes($comboVal[$c]['photographer_name']);
				}
				
				echo implode("??",$fetchedOptions);
			}
			else{
				echo "";
			}
	}
	}
	public function updateEvent($event_id){		
	if(!empty($_POST)){			
		$data =  array(	
						'event_name'			=>$this->input->post('event_name'),					'event_description'		=>$this->input->post('event_description'),
						'location_id'			=>$this->input->post('location_id'),
						'resort_id'				=>$this->input->post('resort_name'),
						'event_date'			=>date('Y-m-d',strtotime($this->input->post('event_date'))),
						'event_price'			=>$this->input->post('event_price'),
						'photographer_id'		=>$this->input->post('photographer_name'),
						'event_status'			=>'1'										
					);
		$mess = $this->Eventmodel->updateEventbyId($event_id, $data);
		if($mess==1){

			$this->session->set_flashdata("sucessPageMessage","Event data updated Successfully!");
			redirect(base_url()."Event");
		} 
	} else{
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view('theme-v1/edit_event'.$event_id.'/');
			$this->load->view("common/footer-inner");
	}

	}

	//Delete Page

	public function deleteEvent($id){
		$this->Eventmodel->deleteEventbyId($id);
		redirect(base_url()."Event/");
	}

}
