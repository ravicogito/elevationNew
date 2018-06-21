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
		
		$all_photographers		= $this->Eventmodel->photographerList();	
		if(!empty($all_photographers)){	
			$data['all_photographers']		= $all_photographers;	
		}
		
		$resort_lists		= $this->resortmodel->index();
		if(!empty($resort_lists)){	
			$data['resort_lists']		= $resort_lists;	
		}
		
		if(!empty($_POST)){		
			$data =  array(	'event_id'				=>'',
							'event_name'			=>$this->input->post('event_name'),					
							'event_description'		=>$this->input->post('event_description'),
							'location_id'			=>$this->input->post('location_id'),
							'resort_id'				=>$this->input->post('resort_name'),
							'event_date'			=>date('Y-m-d',strtotime($this->input->post('event_date'))),
							'photographer_id'		=>$this->input->post('photographer_name'),
							'event_status'			=>'1',									
							'event_price'			=>$this->input->post('event_price')								
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
		/* echo"<pre>";
		print_r($data['event_data']);
		die; */
		if(!empty($data['event_data'])){
			
			$location_id		= $data['event_data']['location_id'];
			$resort_id			= $data['event_data']['resort_id'];
			$photographer_id	= $data['event_data']['photographer_id'];
			
		}
		$resort_lists		= $this->Eventmodel->getResortlist($location_id);
		//print_r($resort_lists);exit;
		if(!empty($resort_lists)){	
			$data['resort_lists']		= $resort_lists;	
		}
		//print_r($data['resort_list']);
		
		$all_photographers		= $this->Eventmodel->photographerList();	
		if(!empty($all_photographers)){	
			$data['all_photographers']		= $all_photographers;	
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
	
	public function EventToCustomer(){
		
		//$fetch_all_location	= $this->EventModel->listAllLocation();
		$data['fetch_all_locations']		= $this->Eventmodel->listAllLocation();
		$data['fetch_all_customers']		= $this->Eventmodel->listAllCustomer();
		/* echo"<pre>";
		print_r($fetch_all_location);
		die; */
		if(!empty($_POST)){
			
			$getCustomer_id = $this->input->post('customer_name');
			$getresort_id 	= $this->input->post('resort_name');
			$getEvent_id 	= $this->input->post('event_id');
			
			$start_date 	= $this->input->post('start_date');
			$end_date 		= $this->input->post('end_date');
			
			$check_event_Byresort = $this->Eventmodel->checkEventByresort($getCustomer_id,$getresort_id,$getEvent_id);
			
			if(!empty($check_event_Byresort)){
				$this->session->set_flashdata("failMessage","Event Name can't be same with respect to same Customer and Resort!");			
				redirect(base_url()."Event/EventToCustomer");
			}
			if( strtotime($start_date) > strtotime($end_date) )
			{
				$this->session->set_flashdata("failMessage","Start date will be greater from end date!");			
				redirect(base_url()."Event/EventToCustomer");
			}
			else{
				$data =  array(
								'location_id'			=>$this->input->post('location_id'),					
								'resort_id'				=>$this->input->post('resort_name'),
								'photographer_id'		=>$this->input->post('dflt_photographer_id'),
								'customer_id'			=>$this->input->post('customer_name'),
								'event_id'				=>$this->input->post('event_id'),
								'rel_status'			=>1,
								'evet_start_date'		=>date('Y-m-d',strtotime($this->input->post('start_date'))),								
								'evet_end_date'			=>date('Y-m-d',strtotime($this->input->post('end_date')))							
							);		
				$mess = $this->Eventmodel->insertData($data,'el_customer_location_event_relation');		
				if($mess){			
					$this->session->set_flashdata("sucessPageMessage","Assign Event To Customer Added Successfully!");			
					redirect(base_url()."Event/EventToCustomerList");		
				}	
			}
		}
		
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view('theme-v1/add_assign_event',$data);
		$this->load->view("common/footer-inner");
	}
	
	public function deleteAssigneventCustomer($location_event_id){
		
		$data =  array('rel_status'=>'0');
		$update_rel_status = $this->Eventmodel->deleteAssigneventCustomerId($data,$location_event_id,'el_customer_location_event_relation');
		if($update_rel_status == 1){
			$this->session->set_flashdata("sucessPageMessage","Image Deleted Successfully!");
			redirect(base_url()."Event/EventToCustomerList");
		}
	}
	
	public function EventToCustomerList(){
		
		$data['customer_location_event_relations']		= $this->Eventmodel->listLocationEventRelations();
		/* echo"<pre>";
		print_r($data['customer_location_event_relations']);
		die; */
		
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view('theme-v1/list_assign_event',$data);
		$this->load->view("common/footer-inner");
		
	}
	
	
	public function populateAjaxbyUserEvent()
	{
		$location_id			= $this->input->post('locationId');
		
		$resort_id				= $this->input->post('resortId');
		
		$event_id				= $this->input->post('eventId');
		
		/* $get_eventId			= $this->input->post('eventId');
		$get_customerName		= $this->input->post('customerName'); */
		
		if(!empty($location_id)){
			
			$get_resort_lists = $this->Eventmodel->getResortlist($location_id);
			/* echo"<pre>";
			print_r($get_resort_lists);
			die; */
			if(!empty($get_resort_lists)){
			
				$return_new_array = array();

					foreach($get_resort_lists as $get_resort_list)

					{

						$returnArr = array();

						$returnArr['resort_id'] = $get_resort_list['resort_id'];

						$returnArr['resort_name'] = $get_resort_list['resort_name'];

						

						$return_new_array[] = $returnArr;

					}

					header('Content-Type: application/json');

					 echo json_encode( $return_new_array );
			}
			else{
				$return_new_array = 0;
				echo json_encode( $return_new_array );
			}
			/* echo"<pre>";
			print_r($get_event_list);
			die; */
		}
		
		else if(!empty($resort_id)){
			
			$location_IdbyResort = $this->input->post('location_IdbyResort');
			
			$get_eventphotographer_lists = $this->Eventmodel->getResortEventlist($resort_id);
			
			$get_user_lists = $this->Eventmodel->getCustomerlistByResort($resort_id,$location_IdbyResort);
			/* echo"<pre>";
			print_r($get_resort_lists);
			die; */
			if(!empty($get_eventphotographer_lists)){
			
				$return_new_array = array();

					foreach($get_eventphotographer_lists as $get_eventphotographer_list)

					{

						$returnArr = array();

						$returnArr['event_id'] 			= $get_eventphotographer_list['event_id'];

						$returnArr['event_name'] 		= $get_eventphotographer_list['event_name'];

						

						$return_new_array[] = $returnArr;

					}
					
					foreach($get_user_lists as $get_user_list)

					{

						$returnArr = array();

						$returnArr['customer_id'] 			= $get_user_list['customer_id'];

						$returnArr['customer_firstname'] 	= $get_user_list['customer_firstname'];

						

						$return_new_array[] = $returnArr;

					}

					header('Content-Type: application/json');

					 echo json_encode( $return_new_array );
			}
			else{
				$return_new_array = 0;
				echo json_encode( $return_new_array );
			}
			/* echo"<pre>";
			print_r($get_event_list);
			die; */
		}
		
		else if(!empty($event_id)){
			
			$get_photograph_lists = $this->Eventmodel->getCustomerPhotographerlist($event_id);
			
			if(!empty($get_photograph_lists)){
				$return_new_array = array();

					foreach($get_photograph_lists as $get_photograph_list)

					{

						$returnArr = array();

						$returnArr['photographer_id'] = $get_photograph_list['photographer_id'];

						$returnArr['photographer_name'] = $get_photograph_list['photographer_name'];

						

						$return_new_array[] = $returnArr;

					}
					header('Content-Type: application/json');

					echo json_encode( $return_new_array );
			}
			else{
				$return_new_array = 0;
				echo json_encode( $return_new_array );
			}
		}
	}
	
	public function populateAjaxResortByLocation(){
	$fetchedId			= $this->input->post('location');
	
	if(!empty($fetchedId)){	
		
	$comboVal = $this->Customermodel->populateDropdown("resort_id", "resort_name", "el_resort", "location_id = '".$fetchedId."' AND resort_status = '1'" , "resort_name", "ASC");
	
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
						'event_name'			=>$this->input->post('event_name'),
						'event_description'		=>$this->input->post('event_description'),
						'location_id'			=>$this->input->post('location_id'),
						'resort_id'				=>$this->input->post('resort_name'),
						'event_date'			=>date('Y-m-d',strtotime($this->input->post('event_date'))),
						'photographer_id'		=>$this->input->post('photographer_name'),
						'event_status'			=>'1',
						'event_price'			=>$this->input->post('event_price')
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
		
		$condition_customer_location_event_relation = "event_id = '$id'";
		$checkon_location_event_relations = $this->Customermodel->isRecordExist('el_customer_location_event_relation',$condition_customer_location_event_relation);
		
		if(!empty($checkon_location_event_relations)){
			
			foreach($checkon_location_event_relations as $checkon_location_event_relation)
			{
				$data 		=  array('rel_status'=>'0');
				$condArr    =  array("customer_location_event_id" => $checkon_location_event_relation['customer_location_event_id']);
				$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_customer_location_event_relation',$condArr);
			}
			
		}
		
		$condition_media_image = "event_id = '$id'";
		$checkon_media_images = $this->Customermodel->isRecordExist('el_media_image',$condition_media_image);
		
		if(!empty($checkon_media_images)){
			
			foreach($checkon_media_images as $checkon_media_image)
			{
				$data 		=  array('media_status'=>'0');
				$condArr    =  array("media_id" => $checkon_media_image['media_id']);
				$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_media_image',$condArr);
			}
			
		}
		$this->session->set_flashdata("sucessPageMessage","Event Deleted Successfully!");
		
		redirect(base_url()."Event/");
	}


/*----------------------- New Logic Implementation [26-02-2018] --------------------------------*/
	public function add() {
		$categories								= $this->Eventmodel->categoryList();
		//pr($all_photographers);
		
		$data['all_category']					= $categories;

		$all_photographers						= $this->Eventmodel->photographerList();
		if(!empty($all_photographers)){	
			$data['all_photographers']			= $all_photographers;	
		} else {
			$data['all_photographers']			= array();
		}
		
		$data['succmsg']						= $this->session->userdata('succmsg');
		$data['errmsg']							= $this->session->userdata('errmsg');
		
		$this->session->set_userdata('succmsg', '');
		$this->session->set_userdata('errmsg', '');

		$this->load->view("common/header");			
		$this->load->view("common/sidebar");			
		$this->load->view('theme-v1/event/add',$data);			
		$this->load->view("common/footer-inner");		
			
	}

	public function do_add_event() {

		$recArr										= array();
		$mainCatArr									= explode("||", $this->input->post('cat_id'));
		$mainCatId									= $mainCatArr[0];
		$mainCatName								= $mainCatArr[1];
		$event_name									= trim($this->input->post('event_name'));
		$event_description							= trim($this->input->post('event_description'));
		$event_date									= date('Y-m-d',strtotime($this->input->post('event_date')));
		$photographerArr							= explode("||", $this->input->post('photographer_name'));
		$photographer_id 							= $photographerArr[0];
		$photographerName 							= $photographerArr[1];
		$event_price								= $this->input->post('event_price');

		$condition 									= "category_id = $mainCatId AND event_name = '".$event_name."' AND event_date = '".$event_date."' AND photographer_id = $photographer_id";
		$cnt 										= $this->Common_model->isRecordExist('el_event_public', $condition);
		if($cnt > 0) {
			$recArr['process']						= "exists";	
		} else {
			$data 									=  array(
														'category_id'			=> $mainCatId,
														'event_name'			=> $event_name,					
														'event_description'		=> $event_description,
														'event_date'			=> $event_date,
														'photographer_id'		=> $photographer_id,
														'event_status'			=> '1',
														'event_price'			=> $event_price
														);
			$insData 								= $this->Common_model->insdata($data, 'el_event_public');
			if ($insData) {
				$path 								= '../uploads/';
				if( ! is_dir($path.$mainCatName)) {
		            mkdir($path.$mainCatName, DIR_READ_MODE);
		        }
		        if( ! is_dir($path.$mainCatName.'/'.$event_date)) {
		            mkdir($path.$mainCatName.'/'.$event_date, DIR_READ_MODE);
		        }
		        if( ! is_dir($path.$mainCatName.'/'.$event_date.'/'.$photographerName)) {
		            mkdir($path.$mainCatName.'/'.$event_date.'/'.$photographerName, DIR_READ_MODE);
		        }
		        if( ! is_dir($path.$mainCatName.'/'.$event_date.'/'.$photographerName.'/'.$event_name)) {
		            mkdir($path.$mainCatName.'/'.$event_date.'/'.$photographerName.'/'.$event_name, DIR_READ_MODE);
		        }

				$recArr['process']					= "success";
				$recArr['event_id']					= $insData;
				$recArr['final_path']				= $path.$mainCatName.'/'.$event_date.'/'.$photographerName.'/'.$event_name;
			} else {
				$recArr['process']					= "fail";
			}
		}
		
		echo json_encode($recArr);
	}


	public function addImage() {
		/*ini_set('max_execution_time', 0);
		ini_set('memory_limit','8192M');*/
		//pr($_FILES);
		$eventID 									= $this->input->post('event_id');
		$imgPath 									= $this->input->post('upload_path');

		if(!empty($_FILES['customerImage']['name'][0])) {

			//$this->load->library('Image');
			$this->load->library('upload');
			$filesCount = count($_FILES['customerImage']['name']);
			//pr($_FILES);
            for($i = 0; $i < $filesCount; $i++) {
                $_FILES['gallery_pic']['name'] 		= $_FILES['customerImage']['name'][$i];
				$_FILES['gallery_pic']['type'] 		= $_FILES['customerImage']['type'][$i];
                $_FILES['gallery_pic']['tmp_name'] 	= $_FILES['customerImage']['tmp_name'][$i];
                $_FILES['gallery_pic']['error'] 	= $_FILES['customerImage']['error'][$i];
                $_FILES['gallery_pic']['size'] 		= $_FILES['customerImage']['size'][$i];
                
				$config['upload_path'] 				= $imgPath.'/';
                $config['allowed_types'] 			= 'gif|jpg|png|zip';
                $config['max_size'] 				= 0;
                $config['max_width'] 				= 0;
                
				//$config['input_name']        = "gallery_pic";
				$this->upload->initialize($config);
				//$this->upload->do_upload($config['input_name']);
				//pr($config, 0);					
				 if(!$this->upload->do_upload('gallery_pic')) {
				 	$this->session->set_userdata('errmsg', $this->upload->display_errors());
				 } else {
				 	if($_FILES['gallery_pic']['type'] == 'application/zip' || $_FILES['gallery_pic']['type'] == 'application/octet-stream') {
				 		$data = array('upload_data' => $this->upload->data());
						$zip = new ZipArchive;
						$file = $data['upload_data']['full_path'];
						chmod($file, 0777);
						if ($zip->open($file) === TRUE) {
						    $zip->extractTo($imgPath.'/');
						    $zip->close();
						    unlink($file);

							$filesArr = scandir($imgPath."/");
							if($filesArr) {
								foreach ($filesArr as $key => $value) {
							      	if (!in_array($value,array(".",".."))) {
							            $result[] = $value;
							      	}
							   	}

							   	foreach($result as $key => $image) {
							   		$insArr[]				= array(
																'media_id'							=> '',
																'media_title'						=> '',
																'media_description'					=> '',
																'file_name'							=> $image,
																'media_path'						=> '',
																'media_type'						=> 'Image',
																'event_id'							=> $eventID,
																'media_status'						=> '1',
																'publish_status'					=> '0',
																'pub_unpub_date'					=> '',
																'upload_date'						=> date('Y-m-d')
																);
							   	}
							   	$this->db->insert_batch('el_media_image', $insArr);
							   	$this->session->set_userdata('succmsg', "Files uploaded and extracted successfully.");
							   	redirect(base_url()."event/listAll/");
							}
						} else {
						    $this->session->set_userdata('errmsg', "Unable to extract the zip file. Please try manually.");
						    redirect(base_url()."event/listAll/");
						}
				 	}
				 	$this->session->set_userdata('succmsg', "Files uploaded successfully.");
				 	redirect(base_url()."event/listAll/");
				 }					             
            }		
		} else {
			$condArr 								= array("event_id" => $eventID);
			$delData 								= $this->Common_model->deletedata('el_event_public', $condArr);
			if($delData) {
				$this->session->set_userdata('errmsg', 'Unable to upload files. Please try again.');
				redirect(base_url()."event/add/");
			} else {
				//Do nothing
			}
		}
	}

	public function listAll() {
		$data['event_data']							= $this->Eventmodel->eventList();			
		$data['front_url'] 							= $this->config->item('front_url');
		//pr($data);	
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/event/event-list", $data);
		$this->load->view("common/footer-inner");
	}

	public function view($eventID = 0) {
		if(!empty($eventID)) {
			$data['event_data']							= $this->Eventmodel->getSingleEvent($eventID);
			$data['back_link']							= base_url()."Event/listAll/";
			$data['img_list']							= base_url()."Event/listImage/".$eventID;
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/event/view", $data);
			$this->load->view("common/footer-inner");
		} else {
			$this->session->set_userdata('errmsg', "Event ID is not lcorrect.");
			redirect(base_url()."Event/listAll/");
		}
		
	}

	public function listImage($eventID = 0) {
		if(!empty($eventID)) {
			$currentUrl									= $this->uri->uri_string();
			$data['event_data']							= $this->Eventmodel->getSingleEvent($eventID);
			$data['back_link']							= base_url()."Event/view/".$eventID;
			$path 										= '../uploads/';
			$mainCatName								= $data['event_data']['cat_name'];
			$eventDate									= $data['event_data']['event_date'];
			$photographer								= $data['event_data']['photographer_name'];
			$event_name									= $data['event_data']['event_name'];
			$fullPath 									= $path.$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
			$data['img_path']							= $mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name.'/';
			$data['front_url'] 							= $this->config->item('front_url');
			
			$data['img_list']							= $this->Eventmodel->getImageByevent($eventID);
			
			$data['event_id']							= $eventID;
			//pr($data);
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/event/image-list", $data);
			$this->load->view("common/footer-inner");
		} else {
			$this->session->set_userdata('errmsg', "Event ID is not lcorrect.");
			redirect(base_url()."Event/listAll/");
		}
		
	}
	
	public function imageDataPost()
	{
		$get_event_id = $this->input->post('event_id');
		
		$gal_image_name = $this->input->post('gal_image_id');
		$media_price = $this->input->post('media_price');
		$image_decs_post = $this->input->post('image_decs_post');
		$photo_resolution = $this->input->post('photo_resolution');
		$photo_size = $this->input->post('photo_size');
		$digital_format = $this->input->post('digital_format');
		$photo_title = $this->input->post('photo_title');
		$photo_description = $this->input->post('photo_description');
		//print_r($media_price);die;
		
		if($image_decs_post > 0 )
		{
			$table = 'el_media_image';
			$find_all_medias = $this->Eventmodel->findAllMedia($get_event_id);
			
			$count = 0;
			foreach($find_all_medias as $find_all_media){
				
				if(empty($media_price))
				{
					$photo_price = $find_all_media['media_price'];
				}
				else{
					$photo_price = $media_price;
				}
				
				if(empty($photo_resolution))
				{
					$media_resolution = $find_all_media['photo_resolution'];
				}
				else{
					$media_resolution = $photo_resolution;
				}
				
				if(empty($photo_size))
				{
					$media_size = $find_all_media['photo_size'];
				}
				else{
					$media_size = $photo_size;
				}
				
				if(empty($digital_format))
				{
					$media_digital_format = $find_all_media['digital_format'];
				}
				else{
					$media_digital_format = $digital_format;
				}
				
				if(empty($photo_title))
				{
					$media_title = $find_all_media['media_title'];
				}
				else{
					$media_title = $photo_title.$count;
				}
				
				if(empty($photo_description))
				{
					$media_description = $find_all_media['media_description'];
				}
				else{
					$media_description = $photo_description.$count;
				}
				
				
				$data = array('media_price' => $photo_price,'photo_resolution' => $media_resolution,'photo_size'=>$media_size,
				'digital_format' => $media_digital_format,'media_title' => $media_title,'media_description'=> $media_description);
				$update_all_image = $this->Eventmodel->updateImageByid($get_event_id,$find_all_media['file_name'],$table,$data);
				
				$count++;
			}
		}
		else{
			
			$find_all_media = $this->Eventmodel->findMediaByid($get_event_id,$gal_image_name);
			//echo"<pre>";print_r($find_media_Byid);die;
			
			if(empty($media_price))
				{
					$photo_price = $find_all_media['media_price'];
				}
				else{
					$photo_price = $media_price;
				}
				
				if(empty($photo_resolution))
				{
					$media_resolution = $find_all_media['photo_resolution'];
				}
				else{
					$media_resolution = $photo_resolution;
				}
				
				if(empty($photo_size))
				{
					$media_size = $find_all_media['photo_size'];
				}
				else{
					$media_size = $photo_size;
				}
				
				if(empty($digital_format))
				{
					$media_digital_format = $find_all_media['digital_format'];
				}
				else{
					$media_digital_format = $digital_format;
				}
				
				if(empty($photo_title))
				{
					$media_title = $find_all_media['media_title'];
				}
				else{
					$media_title = $photo_title.$count;
				}
				
				if(empty($photo_description))
				{
					$media_description = $find_all_media['media_description'];
				}
				else{
					$media_description = $photo_description.$count;
				}
			
			$data = array('media_price' => $photo_price,'photo_resolution' => $media_resolution,'photo_size'=>$media_size,
				'digital_format' => $media_digital_format,'media_title' => $media_title,'media_description'=> $media_description);
		
		$table = 'el_media_image';
		$update_image_Byid = $this->Eventmodel->updateImageByid($get_event_id,$gal_image_name,$table,$data);
		}
		
		
	}

	public function delEvent($eventID = 0) {
		if(!empty($eventID)) {
			$event_data									= $this->Eventmodel->getSingleEvent($eventID);
			$path 										= '../uploads/';
			$mainCatName								= $event_data['cat_name'];
			$eventDate									= $event_data['event_date'];
			$photographer								= $event_data['photographer_name'];
			$event_name									= $event_data['event_name'];
			$fullPath 									= $path.$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;

			$condArr 									= array('event_id' => $eventID);
			$delData 									= $this->Common_model->deletedata('el_media_image', $condArr);
			if($delData) {				
				$delEventData							= $this->Common_model->deletedata('el_event_public', $condArr);
				if($delEventData) {
					$filesArr 							= scandir($fullPath."/");

					if($filesArr) {
						$result 						= array();	
						foreach ($filesArr as $key => $value) {
					      	if (!in_array($value, array(".",".."))) {
					            $result[] = $value;
					      	}
					   	}
					   	//pr($result);	
					   	if($result) {
					   		foreach($result as $key => $image) {
					   			unlink($fullPath."/".$image);
					   		}
					   		rmdir($fullPath);
					   	}
					}   	
				}	
			}
		}
	}
	
	public function assign($eventID = 0) {
		if(!empty($eventID)) {
			$data['event_data']							= $this->Eventmodel->getSingleEvent($eventID);
			$data['event_id']							= $eventID;
			$data['back_link']							= base_url()."Event/listAll/";	
			$data['actionAssign']						= base_url()."Event/do_assign/";
			$data['actionUpload']						= base_url()."Event/do_upload/";
			$custList									= $this->Eventmodel->getAllCustomer();
			$assignedCustList							= $this->Eventmodel->getAssignedCustomer($eventID);
			foreach($custList as $key => $val) {
				$firstChar								= substr($val['customer_firstname'], 0, 1);
				$userList[$firstChar][]					= array("name" => $val['customer_firstname']." ". $val['customer_lastname'], "customer_id" => $val['customer_id']);
			}
			$data['custList']							= $userList;

			if($assignedCustList) {
				foreach($assignedCustList as $cust) {
					$custArr[]							= $cust['customer_id'];
				}
				$data['action']							= 'edit';
			} else {
				$custArr 								= array();
				$data['action']							= 'add';
			}
			$data['assign_list']						= $custArr;
			//pr($data);
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/event/assign-user", $data);
			$this->load->view("common/footer-inner");
		} else {
			$this->session->set_userdata('errmsg', "Event ID is not lcorrect.");
			redirect(base_url()."Event/listAll/");
		}
	}

	public function search_user() {
		$recArr											= array();
		$searchText										= $this->input->post('search_text');
		$eventID 										= $this->input->post('event_id');
		$custList										= $this->Eventmodel->getAllCustomer($searchText);
		$assignedCustList								= $this->Eventmodel->getAssignedCustomer($eventID);
		foreach($custList as $key => $val) {
			$firstChar									= substr($val['customer_firstname'], 0, 1);
			$userList[$firstChar][]						= array("name" => $val['customer_firstname']." ". $val['customer_lastname'], "customer_id" => $val['customer_id']);
		}
		$data['custList']								= $userList;

		if($assignedCustList) {
			foreach($assignedCustList as $cust) {
				$custArr[]								= $cust['customer_id'];
			}
			$data['action']								= 'edit';
		} else {
			$custArr 									= array();
			$data['action']								= 'add';
		}
		$data['assign_list']							= $custArr;

		$recArr['process']								= "success";
		$recArr['HTML']									= $this->load->view("theme-v1/event/ajax-user-list", $data, true);
		echo json_encode($recArr);
	}

	public function do_assign() {
		$eventID 										= $this->input->post('event_id');
		$custArr 										= $this->input->post('chkCustomer');
		$assignDate 									= date("Y-m-d");
		foreach($custArr as $key => $customer) {
			$insArr[]									= array(
															"event_id" 			=> $eventID,
															"customer_id"		=> $customer,
															"assign_date"		=> $assignDate
														);
		}
		$this->db->insert_batch('el_event_customer_rel', $insArr);
	   	$this->session->set_userdata('succmsg', "Customer assigned successfully.");
	   	redirect(base_url()."event/listAll/");
	}

	public function do_upload() {
		//pr($_FILES);//application/vnd.ms-excel......
		$userID 									= array();
		$eventID 									= $this->input->post('event_id');
		if($_FILES['excel']['name'] != '') {

			$userFile								= $_FILES['excel']['tmp_name'];

			$this->load->library('Excel');
            
            $objPHPExcel 							= PHPExcel_IOFactory::load($userFile);
 
			//get only the Cell Collection
			$cell_collection 						= $objPHPExcel->getActiveSheet()->getCellCollection();
			 //pr($cell_collection);
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
			    $column 							= $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			    $row 								= $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			    $data_value 						= $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			 
			    //The header will/should be in row 1 only. of course, this can be modified to suit your need.
			    if ($row == 1) {
			        $header[$row][$column] 			= $data_value;
			    } else {
			        $arr_data[$row][$column] 		= $data_value;
			    }
			}
			 
			//send the data in an array format
			$data['header'] 						= $header;
			$data['values'] 						= $arr_data;
			foreach($arr_data as $cusData) {
				$nameArr 							= explode(" ",$cusData['A']);
				$fName 								= $nameArr[0];
				$lName 								= $nameArr[1];
				$phone 								= $cusData['B'];
				$email 								= $cusData['C'];
				$address 							= $cusData['D'];
				if(array_key_exists('E', $cusData)) {
					$rfId 							= $cusData['E'];
				}
				
				$userArr 							= $this->Eventmodel->getCustByMail('customer_email', $email);
				if($userArr) {
					$userID[]						= $userArr['customer_id'];
				} else {
					$insArr							= array(
														"customer_firstname" 		=> $fName,
														"customer_lastname" 		=> $lName,
														"customer_email"			=> $email,
														"customer_mobile"			=> $phone,
														"customer_password"			=> '123456',
														"customer_address"			=> $address
													);
					$userID[]						= $this->Common_model->insdata($insArr, 'el_customer');
				}
				
			}  
			if($userID) {
				foreach($userID as $val) {
					$insCustEventArr[]				= array(
														"event_id" 					=> $eventID,
														"customer_id" 				=> $val,
														"assign_date"				=> date("Y-m-d")
													);
				}
				//pr($insCustEventArr);
				$this->db->insert_batch('el_event_customer_rel', $insCustEventArr);
				$this->session->set_userdata('succmsg', 'Customer assigned succcessfully.');
			}

			//CSV Upload........
			/*$handle = fopen($userFile, "r");
			$cnt 	= 0;
			while(($cusData = fgetcsv($handle, 1000, ",")) !== false) {
				$cnt++;
				if($cnt > 1) {
					$nameArr = explode(" ",$cusData[0]);
					$fName 	= $nameArr[0];
					$lName 	= $nameArr[1];
					$phone = $cusData[1];
					$email = $cusData[2];
					$address = $cusData[3];
					//$rfId = $cusData[4];
					$insArr[]						= array(
															"customer_firstname" 			=> $fName,
															"customer_lastname" 			=> $lName,
															"customer_email"		=> $email,
															"customer_mobile"		=> $phone,
															"customer_password"		=> '123456',
															"customer_address"		=> $address
														);
				}
				
			}
			pr($insArr);*/
		} else {
			$this->session->set_userdata('errmsg', 'Please Upload a Excel file.');
		}
		redirect(base_url()."Event/listAll/");
	}










/*------------------------------------ R & D section ----------------------------------------*/

	public function upload_img() {
		$data = array();
		$this->load->view("common/header");			
		$this->load->view("common/sidebar");			
		$this->load->view('theme-v1/event/muti-upload',$data);			
		$this->load->view("common/footer-inner");	
	}

	public function upload(){
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$error = '';
			$img = '';
			$dir = '../test_uploads/';
			$extensions = array("jpeg","jpg","png");
			foreach($_FILES['img_file']['tmp_name'] as $key => $tmp_name )
			{
				$file_name = $_FILES['img_file']['name'][$key];
				$file_size =$_FILES['img_file']['size'][$key];
				$file_tmp =$_FILES['img_file']['tmp_name'][$key];
				$file_type=$_FILES['img_file']['type'][$key];
				$file_ext = strtolower(end(explode('.',$file_name)));
				if(in_array($file_ext,$extensions ) === true)
				{
					if(move_uploaded_file($file_tmp, $dir.$file_name))
					{
						$img .= '<div class="col-sm-2"><div class="thumbnail">';
						$img .= '<img src="'.$dir.$file_name.'" />';
						$img .= '</div></div>';		
					}
					else {
						$error = 'Error in uploading few files. Some files couldn\'t be uploaded.';				
					}
				}	
				else
				{
					$error = 'Error in uploading few files. File type is not allowed.';
				}		
			}
			echo (json_encode(array('error' => $error, 'img' => $img)));	
		}
		die();
	}
}
