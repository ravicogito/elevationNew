<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Guide extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Guidemodel');	
			$this->load->model('Eventmodel');			
			$this->load->model('Photographermodel');
			$this->load->model('CustomerImageModel');
			$this->load->model('Customermodel');
			$this->load->model('resortmodel');
	}


	public function index(){
			$data['guide_data']= $this->Guidemodel->listGuide();			
			$data['front_url'] = $this->config->item('front_url');
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/guide/guide_list", $data);
			$this->load->view("common/footer-inner");
		
	}
	
	public function creatTimeDropdown(){
        $hours = $minutes = $ampm = $optString='';
        $i=0;
        for( $i = 540; $i <= 1260; $i += 30){

                    $hours = floor($i / 60);
                    $minutes = $i % 60;
                    if ($minutes < 10){
                        $minutes = '0' . $minutes; // adding leading zero
                    }
                    $ampm = $hours % 24 < 12 ? 'AM' : 'PM';
                    $hours = $hours % 12;
                    if ($hours === 0){
                        $hours = 12;
                    }
                    $text =$hours.':'.$minutes.' '.$ampm;
                    $optString .='<option value="'.$i.'">'.$text.'</option>';



        }
        return $optString;
    }

	public function addGuide(){
		$raftingCompanylist	= $this->CustomerImageModel->listraftingCompany();
		if(!empty($raftingCompanylist)){	
			$data['raftingCompanylist']		= $raftingCompanylist;	
		}
		
		$guidelist	= $this->Guidemodel->listallGuide();
		if(!empty($guidelist)){	
			$data['guidelist']		= $guidelist;	
		}
		
		/*$location_list		= $this->Customermodel->locationList();	
		if(!empty($location_list)){	
			$data['location_list']		= $location_list;	
		}
		
		$all_photographers		= $this->Eventmodel->photographerList();	
		if(!empty($all_photographers)){	
			$data['all_photographers']		= $all_photographers;	
		}*/
		
		$category_lists		= $this->Guidemodel->guide_category();
		if(!empty($category_lists)){	
			$data['all_category']		= $category_lists;	
		}

		$starttime = '9:00';  // your start time
		$endtime = '21:00';  // End time
		$duration = '30';  // split by 30 mins
		 
		$array_of_time = array ();
		$start_time    = strtotime ($starttime); //change to strtotime
		$end_time      = strtotime ($endtime); //change to strtotime
		 
		$add_mins  = $duration * 60;
		 
		while ($start_time <= $end_time) // loop between time
		{
		   $array_of_time[] = date ("h:i A", $start_time);
		   $start_time += $add_mins; // to check endtie=me
		}
		
		$data['time_slot']		= $array_of_time;
		
		$this->load->view("common/header");			
		$this->load->view("common/sidebar");			
		$this->load->view('theme-v1/guide/add_guide',$data);			
		$this->load->view("common/footer-inner");		
				
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
		
		$mainguideArr								= explode("||", $this->input->post('guide_name'));
		$mainGuideId								= $mainguideArr[0];
		$guide_name									= $mainguideArr[1];
		
		
		//$guide_name									= $mainGuideId;
		$guide_description							= trim($this->input->post('guide_description'));
		$guide_date									= date('Y-m-d',strtotime($this->input->post('guide_date')));
		$guide_time									= $this->input->post('guide_time');
		$companyArr									= explode("||", $this->input->post('river_rafting_company_name'));
		$company_id 								= $companyArr[0];
		$companyName 								= $companyArr[1]; 
		$guide_price								= $this->input->post('guide_price');

		$condition 									= "category_id = $mainCatId AND guide_id = '".$mainGuideId."' AND event_name = '".$guide_name."' AND event_date = '".$guide_date."' AND rafting_company_id = $company_id";
		$cnt 										= $this->Common_model->isRecordExist('el_event_public', $condition);
		if($cnt > 0) {
			$recArr['process']						= "exists";	
		} else {
			$data 									=  array(
														'category_id'			=> $mainCatId,
														'guide_id'				=> $mainGuideId,
														'event_name'			=> $guide_name,					
														'event_description'		=> $guide_description,
														'event_date'			=> $guide_date,
														'event_time'			=> $guide_time,
														'rafting_company_id'	=> $company_id,
														'event_status'			=> '1',
														'event_type'			=> 'rafting',
														'event_price'			=> $guide_price
														);
			$insData 								= $this->Common_model->insdata($data, 'el_event_public');
			if ($insData) {
				$path 								= '../uploads/';
				if( ! is_dir($path.$mainCatName)) {
		            mkdir($path.$mainCatName, DIR_READ_MODE);
		        }
		        if( ! is_dir($path.$mainCatName.'/'.$guide_date)) {
		            mkdir($path.$mainCatName.'/'.$guide_date, DIR_READ_MODE);
		        }
		        if( ! is_dir($path.$mainCatName.'/'.$guide_date.'/'.$companyName)) {
		            mkdir($path.$mainCatName.'/'.$guide_date.'/'.$companyName, DIR_READ_MODE);
		    	   }
				if( ! is_dir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'. $guide_time)) {
		            mkdir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time, DIR_READ_MODE);
		        }
				if( ! is_dir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_name)) {
		            mkdir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$guide_name, DIR_READ_MODE);
		        }

				$recArr['process']					= "success";
				$recArr['event_id']					= $insData;
				$recArr['final_path']				= $path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$guide_name;
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
		$eventID 									= $this->input->post('guide_id');
		$imgPath 									= $this->input->post('upload_path');

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			
			$this->load->library('upload');
			$filesCount = count($_FILES['img_file']['name']);
			//pr($_FILES);
            for($i = 0; $i < $filesCount; $i++) {
                $_FILES['gallery_pic']['name'] 		= $_FILES['img_file']['name'][$i];
				$_FILES['gallery_pic']['type'] 		= $_FILES['img_file']['type'][$i];
                $_FILES['gallery_pic']['tmp_name'] 	= $_FILES['img_file']['tmp_name'][$i];
                $_FILES['gallery_pic']['error'] 	= $_FILES['img_file']['error'][$i];
                $_FILES['gallery_pic']['size'] 		= $_FILES['img_file']['size'][$i];
                
				$config['upload_path'] 				= $imgPath.'/';
                $config['allowed_types'] 			= 'gif|jpg|jpeg|png|GIF|JPG|PNG|JPEG';
                $config['encrypt_name']				= false;
                $config['max_size'] 				= 0;
                $config['max_width'] 				= 0;
                
				//$config['input_name']        = "gallery_pic";
				$this->upload->initialize($config);
				//$this->upload->do_upload($config['input_name']);
				//pr($config, 0);					
				 if(!$this->upload->do_upload('gallery_pic')) {
				 	$this->session->set_userdata('errmsg', $this->upload->display_errors());
				 } else {
				 	$data 							= $this->upload->data();
				 	$file_name						= $data['file_name'];
				 	//$file_name						= $_FILES['gallery_pic']['name'];
				 	$insArr							= array(
															'media_id'      	=> '',
															'media_title'		=> '',
															'media_description' => '',
															'file_name'			=> $file_name,
															'media_path'		=> '',
															'media_type'		=> 'Image',
															'event_id'			=> $eventID,
															'media_status'		=> '1',
															'publish_status'	=> '0',
															'pub_unpub_date'	=> '',
															'upload_date'		=> date('Y-m-d')
															);
					$this->Common_model->insdata($insArr, 'el_media_image');
				 }
			}
		}	
			$error = '';
			$img = '';
			/*$dir = $imgPath."/";
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
			
				
		}*/
		echo (json_encode(array('error' => $error, 'img' => $img)));
	}

	public function listAll() {
		$data['guide_data']							= $this->Guidemodel->guideList();			
		$data['front_url'] 							= $this->config->item('front_url');
		//pr($data);	
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/guide/guide_list", $data);
		$this->load->view("common/footer-inner");
	}

	public function view($eventID = 0) {
		if(!empty($eventID)) {
			$data['guide_data']							= $this->Guidemodel->getSingleEvent($eventID);
			$data['back_link']							= base_url()."Guide/listAll/";
			$data['img_list']							= base_url()."Guide/listImage/".$eventID;
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/guide/view_guide", $data);
			$this->load->view("common/footer-inner");
		} else {
			$this->session->set_userdata('errmsg', "Event ID is not lcorrect.");
			redirect(base_url()."Event/listAll/");
		}
		
	}

	public function listImage($eventID = 0) {
		if(!empty($eventID)) {
			$currentUrl									= $this->uri->uri_string();
			$data['event_data']							= $this->Guidemodel->getSingleEvent($eventID);
			$data['back_link']							= base_url()."Guide/view/".$eventID;
			$path 										= '../uploads/';
			$mainCatName								= $data['event_data']['cat_name'];
			$guideDate									= $data['event_data']['event_date'];
			$guideTime									= $data['event_data']['event_time'];
			$rafting_company							= $data['event_data']['raftingcompany_name'];
			$guide_name									= $data['event_data']['event_name'];
			$fullPath 									= $path.'import/'.$guideDate.'/'.$rafting_company.'/'.$guideTime.'/'.$guide_name;
			//$data['img_path']							= $mainCatName.'/'.$guideDate.'/'.$rafting_company.'/'.$guideTime.'/'.$guide_name.'/';
			$data['img_path']							= 'import/'.$guideDate.'/'.$rafting_company.'/'.$guideTime.'/'.$guide_name.'/';
			$data['front_url'] 							= $this->config->item('front_url');
			
			$data['img_list']							= $this->Eventmodel->getImageByguide($eventID);
			
			$data['event_id']							= $eventID;
			//pr($data['img_list']);
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/guide/image-list", $data);
			$this->load->view("common/footer-inner");
		} else {
			$this->session->set_userdata('errmsg', "Event ID is not lcorrect.");
			redirect(base_url()."Guide/listAll/");
		}
		
	}
	
	public function deleteImages($media__event_id)
	{
		$explode_media_event = explode('_',$media__event_id);
		//echo"<pre>";
		//print_r($explode_media_event);
		//die;
		$data = array('media_status' => '0');
		$this->Guidemodel->deleteImagebyId($explode_media_event[0],$data);
		
		redirect(base_url()."Guide/listImage/".$explode_media_event[1]);
	}
	
	
	public function imageDetails()
	{
		$recArr						= array();
		$image_id 					= $this->input->post('id');
        if(!empty($image_id)){		
		$recArr['imagedata']		= $this->Guidemodel->getImageByID($image_id);
		$recArr['process']			= "success";
		}
		else{
		$recArr['process']			= "fail";	
		}

		echo json_encode($recArr);
		
		
	}	
	


	public function delGuide($eventID = 0) {
		if(!empty($eventID)) {
			$guide_data									= $this->Guidemodel->getSingleEvent($eventID);

			$path 										= '../uploads/';
			$mainCatName								= $guide_data['cat_name'];
			$guideDate									= $guide_data['event_date'];
			$company									= $guide_data['raftingcompany_name'];
			$time										= $guide_data['event_time'];
			$guide_name									= $guide_data['event_name'];
			$fullPath 									= $path.$mainCatName.'/'.$guideDate.'/'.$company.'/'.$time.'/'.$guide_name;

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
		

			$this->session->set_userdata('errmsg', "Guide is deleted.");
			redirect(base_url()."Guide/listAll/");
		} else {
			$this->session->set_userdata('errmsg', "Guide not deleted.");
			redirect(base_url()."Guide/listAll/");
		}
	}
	
	public function assign($eventID = 0) {
		if(!empty($eventID)) {
			$data['event_data']							= $this->Guidemodel->getSingleEvent($eventID);
			$data['event_id']							= $eventID;
			$data['back_link']							= base_url()."Guide/listAll/";	
			$data['actionAssign']						= base_url()."Guide/do_assign/";
			$data['actionUpload']						= base_url()."Guide/do_upload/";
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
			$this->load->view("theme-v1/guide/assign-user", $data);
			$this->load->view("common/footer-inner");
		} else {
			$this->session->set_userdata('errmsg', "Event ID is not lcorrect.");
			redirect(base_url()."Guide/listAll/");
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
	   	redirect(base_url()."Guide/listAll/");
	}

	public function do_upload() {
		//pr($_FILES);//application/vnd.ms-excel......
		$userID 									= array();
		$eventID 									= $this->input->post('guide_id');
		if($_FILES['excel']['name'] != '') {
            $ext = end(explode('.', $_FILES['excel']['name']));
		    if($ext=='xls' || $ext=='xlsx')
		    {
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
		} else {
			$this->session->set_userdata('errmsg', 'Choose Excel file to upload.');
		}	
		redirect(base_url()."Guide/listAll/");
	}




############## 30-03-2018 ##############################################
  public function edit($eid) {
	    $data['guide_details']			   = $this->Guidemodel->eventListDetails($eid);
		$categories						   = $this->Guidemodel->categoryList();
		$data['all_category']				= $categories;
		
		$raftingCompanylist				    = $this->CustomerImageModel->listraftingCompany();
		if(!empty($raftingCompanylist)){	
			$data['raftingCompanylist']		= $raftingCompanylist;	
		}
		else {
			$data['raftingCompanylist']		= array();
		}
		
		$guidelist	= $this->Guidemodel->listallGuide();
		if(!empty($guidelist)){	
			$data['guidelist']				= $guidelist;	
		}
		else {
			$data['guidelist']				= array();
		}
		
		
		$starttime = '9:00';  // your start time
		$endtime = '21:00';  // End time
		$duration = '30';  // split by 30 mins
		 
		$array_of_time = array ();
		$start_time    = strtotime ($starttime); //change to strtotime
		$end_time      = strtotime ($endtime); //change to strtotime
		 
		$add_mins  = $duration * 60;
		 
		while ($start_time <= $end_time) // loop between time
		{
		   $array_of_time[] = date ("h:i A", $start_time);
		   $start_time += $add_mins; // to check endtie=me
		}
		
		$data['time_slot']		= $array_of_time;
		
		
        $this->load->view("common/header");			
		$this->load->view("common/sidebar");			
		$this->load->view('theme-v1/guide/edit_guide',$data);			
		$this->load->view("common/footer-inner");		
			
}

public function do_edit_event() {
	   
		$guideId 									= trim($this->input->post('guideid'));
		$old_guide_name			  		    		= $this->Guidemodel->eventName($guideId);
		$mainCatArr									= explode("||", $this->input->post('cat_id'));
		$mainCatId									= $mainCatArr[0];
		$mainCatName								= $mainCatArr[1];
		
		$mainGuideArr								= explode("||", $this->input->post('guide_name'));

		$mainGuideId								= $mainGuideArr[0];
		$mainGuideName								= $mainGuideArr[1];
		$guide_name                                 = $mainGuideName;
		
		//$guide_name									= trim($this->input->post('guide_name'));
		$guide_description							= trim($this->input->post('guide_description'));
		$guide_date									= date('Y-m-d',strtotime($this->input->post('guide_date')));
		$guide_time									= $this->input->post('guide_time');
		$companyArr									= explode("||", $this->input->post('rafting_company_name'));
		$company_id 								= $companyArr[0];
		$companyName 								= $companyArr[1];
		$guide_price								= $this->input->post('guide_price');

	    $condition 									= "category_id = $mainCatId AND guide_id = $mainGuideId  AND event_name = '".$guide_name."' AND event_date = '".$guide_date."' AND 	rafting_company_id	 = $company_id AND event_id != '".$guideId."'";
		$cnt 										= $this->Common_model->isRecordExist('el_event_public', $condition);
		if($cnt > 0) {
			$recArr['process']						= "exists";	
		} else {
			$data 									=  array(
														'category_id'			=> $mainCatId,
														'guide_id'				=> $mainGuideId,
														'event_name'			=> $mainGuideName,					
														'event_description'		=> $guide_description,
														'event_price'			=> $guide_price
														);
													

			$condArr    =  array("event_id" => $guideId);

			$editData = $this->Common_model->editdata($data,'el_event_public',$condArr);
			//if ($editData) {
				$path 								= '../uploads/';
				if( ! is_dir($path.$mainCatName)) {
		            mkdir($path.$mainCatName, DIR_READ_MODE);
		        }
		        if( ! is_dir($path.$mainCatName.'/'.$guide_date)) {
		            mkdir($path.$mainCatName.'/'.$guide_date, DIR_READ_MODE);
		        }
		        if( ! is_dir($path.$mainCatName.'/'.$guide_date.'/'.$companyName)) {
		            mkdir($path.$mainCatName.'/'.$guide_date.'/'.$companyName, DIR_READ_MODE);
		    	   }
				if( ! is_dir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'. $guide_time)) {
		            mkdir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time, DIR_READ_MODE);
		        }
				if( ! is_dir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$guide_name)) {
					
					mkdir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$guide_name, DIR_READ_MODE);
					
					$files = scandir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$old_guide_name.'/');
					$source = $path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$old_guide_name.'/';
					$destination = $path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$guide_name.'/';
					// Cycle through all source files
					foreach ($files as $file) {
					  if (in_array($file, array(".",".."))) continue;
					  // If we copied this successfully, mark it for deletion
					  if (copy($source.$file, $destination.$file)) {
						$delete[] = $source.$file;
					  }
					}
					// Delete all successfully-copied files
					foreach ($delete as $file) {
					  unlink($file);
					} 
					rmdir($path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$old_guide_name.'/');
		            
		        }

				$recArr['process']					= "success";
				$recArr['guide_id']					= $editData;
				$recArr['final_path']				= $path.$mainCatName.'/'.$guide_date.'/'.$companyName.'/'.$guide_time.'/'.$guide_name;
			//} else {
				//$recArr['process']					= "fail";
			//}
		}
		
		echo json_encode($recArr);
	}
	
	
	public function guideManagementadd($id = ''){
		$data['all_guide'] = $this->Guidemodel->editGuide($id);
		$get_guide_name = $this->input->post('guide_name');
		$get_hid_id = $this->input->post('hid');
		
		
		if(!empty($get_hid_id))
		{
			$data = array('guide_name' => $get_guide_name,'updated_on' => date('Y-m-d'));
			$table = 'el_guidename';
			
			$update_guide = $this->Guidemodel->updateGuide($table,$data,$get_hid_id);
			
			if($update_guide == 1)
			{
				$this->session->set_flashdata('ins_success','Guide Update Successfully');
				redirect(base_url()."Guide/guideManagement");	
			}
			else{
				$this->session->set_flashdata('ins_failed','Guide Update Failed');
			}
		}
		
		else{
			if(!empty($_POST))
			{
				$data = array('guide_name' => $get_guide_name,'created_on' => date('Y-m-d'),'guide_status' => '1');
				$table = 'el_guidename';
				
				$ins_guide = $this->Guidemodel->addGuide($table,$data);
				
				if($ins_guide !=0)
				{
					$this->session->set_flashdata('ins_success','Guide Insert Successfully');
					redirect(base_url()."Guide/guideManagement");
				}
				else{
					$this->session->set_flashdata('ins_failed','Guide Insert Failed');
				}
			}
		}
						
		$this->load->view("common/header");			
		$this->load->view("common/sidebar");			
		$this->load->view('theme-v1/guide/guidename_add',$data);			
		$this->load->view("common/footer-inner");		
				
	}
	
	public function guideManagement($id = ''){
		$data['all_guides'] = $this->Guidemodel->allGuide();
		
		 //echo"<pre>";
		//print_r($data['all_guide']);
		///die; 
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/guide/all_guide",$data);
		$this->load->view("common/footer-inner");
	}
	public function deleteGuide($id = '')
	{
		$check_guide_status = $this->Guidemodel->isExistRecord($id);
		
		//if(!empty($check_guide_status)){
			$data = array('guide_status' => '0');
			$table = 'el_guidename';
			
			$delete_guide = $this->Guidemodel->updateGuide($table,$data,$id);
				
				if($delete_guide == 1)
				{
					$this->session->set_flashdata('ins_success','Guide Deleted Successfully');
					redirect(base_url()."Guide/guideManagement");	
				}
				else{
					$this->session->set_flashdata('ins_failed','Guide Delete Failed');
				}
		//}
		//else{
			//$this->session->set_flashdata('ins_failed','Record not exist');
		//}
	}

    

   /* public function delImage() {
		$recArr						= array();
		$imgName					= $this->input->post('image_name');
		$imgID						= $this->input->post('image_id');
		$imgPath					= $this->input->post('image_path');
		
		if(!empty($imgName)) {
			if(!empty($imgID)) {
				$condArr		= array("media_id" => $imgID);
				$this->Common_model->deletedata('el_media_image', $condArr); 
				$recArr['process']		= "success";
				if(file_exists($imgPath)) {
					unlink($imgPath);
				}				
			} else {
				$recArr['process']		= "fail";
			}
		} else {
			$recArr['process']			= "fail";
		}
		echo json_encode($recArr);exit;
	}*/
########################################################################
	public function dir_to_array($dir, $separator = DIRECTORY_SEPARATOR, $paths = 'relative') 
	{
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value, array(".", "..")))
        {
            if (is_dir($dir . $separator . $value))
            {
                $result[$value] = $this->dir_to_array($dir . $separator . $value, $separator, $paths);
            }
            else
            {
                if ($paths == 'relative')
                {
                    $result[] = $dir . '/' . $value;                    
                }
                elseif ($paths == 'absolute')
                {
                    $result[] = base_url() . $dir . '/' . $value;
                }
            }
        }
    }
    return $result;
	} 
		public function generate()
	{ 
		$originalfname =  array();
		$tempfname = array();
	 $filepath = $this->dir_to_array('../uploads/import');
	 foreach($filepath as $date => $alldata)
		{
			foreach($alldata as $company => $data)
			{
			
				foreach($data as $event_time => $restdata)
				{
					foreach($restdata as $guide_name => $imagedata)
					{
						foreach($imagedata as $images)
						{
														
							$pathArr    = explode('/', $images);
							$filename 	= end($pathArr);

														
							$array      = explode('.', $filename);
							$extension  = end($array);

							$filename2  = strpos($filename,'-400_400');
							
							$img_query   = $this->db->get_where('el_media_image', array(
							'file_name'  => trim($filename)
							));	
							$count_img   = $img_query->num_rows();
						
						if($count_img === 0) {
							
								$image_array = array(
								'file_name'  	    => trim($filename),
								'media_type'     	=> 'Image',
								'media_status' 	    => '1',
								'upload_date' 	    => date('Y-m-d'),
								'publish_status' 	=> '1',
								'public' 			=> '1'
							);
							if(!$filename2) {
								if($extension=='JPG' || $extension=='jpg'|| $extension=='png'|| $extension=='PNG'|| $extension=='gif' || $extension=='GIF'){
								$this->db->insert('el_media_image', $image_array);
								$image_id = $this->db->insert_id();
								}
							}
														
						}
						else{
						   $image_id = $this->Guidemodel->getImageID($filename);
						}						
							
					    $company_query = $this->db->get_where('el_raftingcompany', array(
							'raftingcompany_name'  => trim($company)
							));	
                        $count_company = $company_query->num_rows();
						if($count_company === 0) {
                        $company_array = array(
							'raftingcompany_name' 	=> trim($company),
							'member_on' 		    => date('Y-m-d')
							);
                          $this->db->insert('el_raftingcompany', $company_array); 
						  $company_id = $this->db->insert_id();
                         											
							$guide_query = $this->db->get_where('el_guidename', array(
								'guide_name'  => trim($guide_name)
							));
						   $count_guide = $guide_query->num_rows();
						if ($count_guide === 0) {
                          $guide_array = array(
								'guide_name' 	=> trim($guide_name),
								'created_on' 	=> date('Y-m-d'),
								'guide_status' 	=> '1'
							);
                          $this->db->insert('el_guidename', $guide_array); 
						  $guide_id = $this->db->insert_id();
				
					    $rafting_query = $this->db->get_where('el_event_public', array(
								'category_id'  	=> '17',
								'rafting_company_id'  	=> $company_id,
								'guide_id'  			=> $guide_id,
								'event_name' 			=> trim($guide_name),
								'event_date' 			=> $date,
								'event_time' 			=> $event_time,
								'event_status' 			=> '1',
								'event_type' 			=> 'rafting',
							));
						   $count = $rafting_query->num_rows();
						if ($count === 0) {
							$rafting_array = array(
								'category_id'  	=> '17',
								'rafting_company_id'  	=> $company_id,
								'guide_id'  	        => $guide_id,
								'event_name' 	        => trim($guide_name),
								'event_date' 	        => $date,
								'event_time' 	        => $event_time,
								'event_status'       	=> '1',
								'event_type' 	        => 'rafting',
							);
							$this->db->insert('el_event_public', $rafting_array);
							$event_id = $this->db->insert_id();
							$image_id = $this->Guidemodel->getImageID($filename);
							$this->db->set('event_id', $event_id);
							$this->db->where('media_id', $image_id);
							$this->db->update('el_media_image'); 					
											
						}
					else{
					  echo $event_id = $this->Guidemodel->getEventID($guide_name);
					  $image_id = $this->Guidemodel->getImageID($filename);
					  $this->db->set('event_id', $event_id);
					  $this->db->where('media_id', $image_id);
					  $this->db->update('el_media_image');	
						
					}						
							
					}
					else{
					  				  
					  $guide_id = $this->Guidemodel->getGuideID($guide_name);
					  $rafting_query = $this->db->get_where('el_event_public', array(
								'category_id'  			=> '17',
								'guide_id'  			=> $guide_id,
								'rafting_company_id'  	=> $company_id,
								'event_name' 			=> trim($guide_name),
								'event_date' 			=> $date,
								'event_time' 			=> $event_time,
								'event_status' 			=> '1',
								'event_type' 			=> 'rafting',
							));
						   $count = $rafting_query->num_rows();
						if ($count === 0) {
							$rafting_array = array(
								'category_id'  	=> '17',
								'rafting_company_id'  	=> $company_id,
								'guide_id'  			=> $guide_id,
								'event_name' 			=> trim($guide_name),
								'event_date' 			=> $date,
								'event_time' 			=> $event_time,
								'event_status' 			=> '1',
								'event_type' 			=> 'rafting',
							);
							$this->db->insert('el_event_public', $rafting_array);
							$event_id = $this->db->insert_id();
							$image_id = $this->Guidemodel->getImageID($filename);
							$this->db->set('event_id', $event_id);
							$this->db->where('media_id', $image_id);
							$this->db->update('el_media_image'); 		
											
						}
						else{
						  $event_id = $this->Guidemodel->getEventID($guide_name);
						  $image_id = $this->Guidemodel->getImageID($filename);
						  $this->db->set('event_id', $event_id);
						  $this->db->where('media_id', $image_id);
						  $this->db->update('el_media_image');	
						}
					
						
					   }					
							
				}
				else{
					
					$company_id = $this->Guidemodel->getCompanyID($company);
					
					$guide_query = $this->db->get_where('el_guidename', array(
								'guide_name'  	=> trim($guide_name)
							));
						   $count_guide = $guide_query->num_rows();
						if ($count_guide === 0) {
                          $guide_array = array(
								'guide_name' 	=> trim($guide_name),
								'created_on' 	=> date('Y-m-d'),
								'guide_status' 	=> '1'
							);
                          $this->db->insert('el_guidename', $guide_array); 
						  $guide_id = $this->db->insert_id();
				
					    $rafting_query = $this->db->get_where('el_event_public', array(
								'category_id'  	=> '17',
								'rafting_company_id'  	=> $company_id,
								'guide_id'  			=> $guide_id,
								'event_name' 			=> trim($guide_name),
								'event_date' 			=> $date,
								'event_time' 			=> $event_time,
								'event_status' 			=> '1',
								'event_type' 			=> 'rafting',
							));
						   $count = $rafting_query->num_rows();
						if ($count === 0) {
							$rafting_array = array(
								'category_id'  	=> '17',
								'rafting_company_id'  	=> $company_id,
								'guide_id'  			=> $guide_id,
								'event_name' 			=> trim($guide_name),
								'event_date' 			=> $date,
								'event_time' 			=> $event_time,
								'event_status' 			=> '1',
								'event_type' 			=> 'rafting',
							);
							$this->db->insert('el_event_public', $rafting_array);
							$event_id = $this->db->insert_id();
							$image_id = $this->Guidemodel->getImageID($filename);
							
							$this->db->set('event_id', $event_id);
							$this->db->where('media_id', $image_id);
							$this->db->update('el_media_image'); 
							
											
						}
					else{
						  $image_id = $this->Guidemodel->getImageID($filename); 
						  $event_id = $this->Guidemodel->getEventID($guide_name);
						  $this->db->set('event_id', $event_id);
						  $this->db->where('media_id', $image_id);
						  $this->db->update('el_media_image');	
					}						
							
					}
					else{
		            	  $guide_id = $this->Guidemodel->getGuideID($guide_name);
					      
					  
					    $rafting_query = $this->db->get_where('el_event_public', array(
								'category_id' 		 	=> '17',
								'guide_id'  			=> $guide_id,
								'rafting_company_id'  	=> $company_id,
								'event_name' 			=> trim($guide_name),
								'event_date' 			=> $date,
								'event_time' 			=> $event_time,
								'event_status' 			=> '1',
								'event_type' 			=> 'rafting',
							));
						   $count = $rafting_query->num_rows();
						if ($count === 0) {
							$rafting_array = array(
								'category_id'  			=> '17',
								'rafting_company_id'  	=> $company_id,
								'guide_id'  			=> $guide_id,
								'event_name' 			=> trim($guide_name),
								'event_date' 			=> $date,
								'event_time' 			=> $event_time,
								'event_status' 			=> '1',
								'event_type' 			=> 'rafting',
							);
							$this->db->insert('el_event_public', $rafting_array);
							$event_id = $this->db->insert_id();
							$image_id = $this->Guidemodel->getImageID($filename);
							$this->db->set('event_id', $event_id);
						    $this->db->where('media_id', $image_id);
						    $this->db->update('el_media_image');
							
							 		
											
						}
						else{
							
						  $event_id = $this->Guidemodel->getEventID($guide_name);
						  $image_id = $this->Guidemodel->getImageID($filename);
						  $this->db->set('event_id', $event_id);
						  $this->db->where('media_id', $image_id);
						  $this->db->update('el_media_image');						  
							
						}
					
						
					   }				
					
				      }				
					
					  
					
					}
					
				  }	
				
									
				
			}
		}
	}
	
	    redirect('/Guide/listAll/');
		
	}


}
