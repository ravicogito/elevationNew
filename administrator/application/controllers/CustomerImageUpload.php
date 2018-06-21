<?php
ini_set('memory_limit', '800M');
ini_set('post_max_size', '800M');
ini_set('upload_max_filesize', '800M');

defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerImageUpload extends CI_Controller {
	public function __construct(){
			parent::__construct();			
			if($this->session->userdata('admin_user_id') =='') {				
			redirect(base_url());			
			}
			$this->load->model('CustomerImageModel');
			$this->load->model('Eventmodel');
			$this->load->model('Customermodel');
			
	}
	public function index(){
			$data['image_lists']		= $this->CustomerImageModel->listCustomerImage();
			
			//print_r($data['image_lists']);exit;
			$data['front_url'] = $this->config->item('front_url');
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/customer_images_list", $data);
			$this->load->view("common/footer-inner");
	}
	
	public function addImage(){

		$insertcustomerImages		= array();
		$filename					= '';
		$cutomer_id					= $this->input->post('customer_id');
		$mediatype					= $this->input->post('media_type');
		if($this->input->post('dflt_photographer_id') == ""){
			
			$photographer_id			= $this->input->post('photographer_name');
		}
		else{
			
			$photographer_id			= $this->input->post('dflt_photographer_id');
		}
		
		$photographerDetails			= 	$this->CustomerImageModel->listPhotographer($photographer_id);
		
		$data['customerlist']		= $this->CustomerImageModel->listCustomer();
		$data['photographerlist']	= $this->CustomerImageModel->listPhotographer();
		$data['event_lists']		= $this->Eventmodel->listEvents();
		$mess						='';
		//print_r($_FILES);
		//echo $_FILES['customerImage']['type'][2];exit;
		if(!empty($_FILES['customerImage']['name'][0])){
			
			$this->load->library('Image');
			
			$filesCount = count($_FILES['customerImage']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['gallery_pic']['name'] 		= $_FILES['customerImage']['name'][$i];
				$_FILES['gallery_pic']['type'] 		= $_FILES['customerImage']['type'][$i];
                $_FILES['gallery_pic']['tmp_name'] 	= $_FILES['customerImage']['tmp_name'][$i];
                $_FILES['gallery_pic']['error'] 	= $_FILES['customerImage']['error'][$i];
                $_FILES['gallery_pic']['size'] 		= $_FILES['customerImage']['size'][$i];
                
                
				if($mediatype == 'Image'){
					$config['upload_path'] 			= '../uploads/customerImg_'.$cutomer_id."/org/";
					$config['upload_path_dis']		= '../uploads/customerImg_'.$cutomer_id."/";
				}
				else if($mediatype == 'Video'){
					$config['upload_path'] = '../uploads/customervideo_'.$cutomer_id;
				}
                $config['allowed_types'] 	= 'gif|jpg|png';
                $config['max_size'] 		= 0;
                $config['max_width'] 		= 0;
                $config['photographer']		= $photographerDetails[0]->photographer_email;
				//$config['maintain_ratio'] 	= FALSE;
				
				$imgThumbnailSizeArr 		= array(
												array('width' => 826, 'height' => 511),
												array('width' => 390, 'height' => 320),
											);
				//pr($imgThumbnailSizeArr);				
				$config['input_name']        = "gallery_pic";								
				$this->image->imageUpload($config, $imgThumbnailSizeArr, 'R');
				
                /*$this->load->library('upload', $config);
				
				if (!file_exists('../uploads')) {
						mkdir('../uploads', 0777, true);
					}

				if (!file_exists('../uploads/customerImg_'.$cutomer_id)) {
					mkdir('../uploads/customerImg_'.$cutomer_id, 0777, true);
				}
				if (!file_exists('../uploads/customervideo_'.$cutomer_id)) {
					mkdir('../uploads/customervideo_'.$cutomer_id, 0777, true);
				}*/
				
										

			
									
				 //if (!$this->upload->do_upload('gallery_pic'))
				 if (!empty($config['img_err']))
					{
						  $error = array('error' => $this->upload->display_errors());
						  //echo $error['error'];exit;
						   //$this->session->set_flashdata("failMessage",$error['error']);
						   $this->session->set_flashdata("failMessage",$config['img_err']);
							
					}
					else
					{
							$fileData = $this->upload->data();
							//echo "FILE NAME--".$fileData['file_name'],exit;
							$event_id		= $this->input->post('event_name');
							$event_data 	= $this->Eventmodel->Eventedit($event_id);
							
							if(empty($event_id)){
								
								$uploadDate = date('Y-m-d');
								
							}
							else{
								
								$uploadDate	= $event_data['event_date'];
							}
							$data =  array(
										'media_id'							=>'',
										'media_title'						=>$this->input->post('media_title'),
										'media_description'					=>$this->input->post('media_description'),
										'file_name'							=>$fileData['file_name'],
										'media_path'						=>$fileData['file_path'],
										'media_type'						=>$this->input->post('media_type'),
										'event_id'							=>$event_id,
										'media_status'						=>'1',
										'publish_status'					=>'0',
										'pub_unpub_date'					=>'',
										'upload_date'						=> $uploadDate
										);	
					
						$mess = $this->CustomerImageModel->addImages($data,$cutomer_id,$photographer_id,$event_id);
						$this->load->view("common/header");
						$this->load->view("common/sidebar");
						$this->load->view('theme-v1/add_images',$data);
						$this->load->view("common/footer-inner");	
					}               
            }

		
		if($mess){


			$this->session->set_flashdata("sucessPageMessage","Images Uploaded Successfully!");
			//echo $mess;exit;
			redirect(base_url()."customerImageUpload");
		} 
	}
	else{
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view('theme-v1/add_images',$data);
		$this->load->view("common/footer-inner");
	}
}


public function populateAjaxEvent(){
	$fetchedId			= $this->input->post('location_id');
			
	$comboVal = $this->Customermodel->populateDropdown("event_id", "event_name", "el_event", "location_id = '".$fetchedId."'", "event_name", "ASC");
	
	$fetchedOptions = array();
	
	if($comboVal)
	{	
		for ($c=0; $c<count($comboVal); $c++)
		{
			$fetchedOptions[$comboVal[$c]['event_id']] =   $comboVal[$c]['event_id'] . "|" . stripslashes($comboVal[$c]['event_name']);
		}
		
		echo implode("??",$fetchedOptions);
	}
	else{
		echo "";
	}

}
public function populateAjaxPhotographer(){
	$fetchedId			= $this->input->post('event');
	
	if(!empty($fetchedId)){	
		$photographer	= $this->Eventmodel->Eventedit($fetchedId);
		if(!empty($photographer)){
			$photographer_id	= $photographer['photographer_id'];
			
			$condition			= "photographer_id = '".$photographer_id."'";
		}		
	}
	else{
		
		$condition	= '1';
	}
	$comboVal = $this->Customermodel->populateDropdown("photographer_id", "photographer_name", "el_photographer", $condition , "photographer_name", "ASC");
	
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
public function viewImage($cid=''){
	
	$data['Image_list'] 	= $this->CustomerImageModel->Imageview($cid);
	$data['customer_id'] 	= $cid;
	//print_r($data['Image_list']);

	$this->load->view("common/header");

	$this->load->view("common/sidebar");

	$this->load->view("theme-v1/view_imagesGallery", $data);

	$this->load->view("common/footer-inner");
}
	
	public function editImage($mid='',$cid=''){
		$data['Image_data'] 	= $this->CustomerImageModel->imageEditById($mid);
		$data['media_id'] 		= $mid;
		$data['customer_id'] 	= $cid;
		/* $data['succMsg']		= $this->session->userdata('sucessPageMessage');
		$this->session->set_userdata('sucessPageMessage', ''); */
		//print_r($data);
		if(!empty($cid) && !empty($mid)){
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/edit_image", $data);
			$this->load->view("common/footer-inner");
		} else {
			redirect(base_url()."customerImageUpload/");
		}
	
	}
	
	private function generateUniqueID($photoID) {
	  $uniqueID   = "EL";
	  for($i = 0; $i < (4-strlen($photoID)); $i++) {
	   $uniqueID   .= "0";
	  }
	  $uniqueID    .= $photoID;
	  
	  return $uniqueID;
	}
	
	public function updateEditImage($mid='',$cid=''){
		
		$data['media_id'] 		= $mid;
		$data['customer_id'] 	= $cid;
		$newimg					='';
		$oldimage				= $this->input->post('old_img');
		$imageprice				= $this->input->post('media_price');
		$photo_resolution		= $this->input->post('photo_resolution');
		$photo_size				= $this->input->post('photo_size');
		$digital_format			= $this->input->post('digital_format');
		
		$photo_number = $this->generateUniqueID($mid);
		
		
		$photographerDetails	= $this->CustomerImageModel->getPhotographerByMediaID($mid);
		if(isset($_FILES) && $_FILES['editcustmImage']['error'] == 0)
		{
			$this->load->library('Image');
			
			/*$oldimg = "uploads/rink_logo/" . $oldimage;
			if (file_exists($oldimg)) {
                unlink($oldimg);
            }*/
            
            
            $config['upload_path'] 			= '../uploads/customerImg_'.$cid."/org/";
			$config['upload_path_dis']		= '../uploads/customerImg_'.$cid."/";
            
            $config['allowed_types'] 		= 'gif|jpg|png';
            $config['max_size'] 			= 0;
            $config['max_width'] 			= 0;
			 $config['photographer']		= $photographerDetails['photographer_name'];
			
			$imgThumbnailSizeArr 			= array(
												array('width' => 826, 'height' => 511),
												array('width' => 390, 'height' => 320),
											);
			//pr($imgThumbnailSizeArr);				
			$config['input_name']        	= "editcustmImage";								
			$this->image->imageUpload($config, $imgThumbnailSizeArr, 'R');
            
            
			$this->load->library('upload', $config);
				
			

			/*if (!file_exists('../uploads/customerImg_'.$cid)) {
				mkdir('../uploads/customerImg_'.$cid, 777);
			}
			if (!file_exists('../uploads/customervideo_'.$cid)) {
				mkdir('../uploads/customervideo_'.$cid, 777);
			}*/
			if (!empty($config['img_err']))
			{
			   $error = array('error' => $config['img_err']);
				   
			} else {
				$fileData 		= $this->upload->data();				
				$newimg 		= $fileData['file_name'];
				
				$oldimgArr 		= explode(".",$oldimage);
				$extension 		= end($oldimgArr);
				
				if (file_exists($config['upload_path'].$oldimage)) {
	                unlink($config['upload_path'].$oldimage);
	            }
	            if (file_exists($config['upload_path']."thumb/".$oldimgArr[0]."-826X511.".$extension)) {
	                unlink($config['upload_path']."thumb/".$oldimgArr[0]."-826X511.".$extension);
	            }
	            if (file_exists($config['upload_path']."thumb/".$oldimgArr[0]."-390X320.".$extension)) {
	                unlink($config['upload_path'].$oldimg);
	            }
	            if (file_exists($config['upload_path_dis'].$oldimage)) {
	                unlink($config['upload_path_dis'].$oldimage);
	            }
				
				$this->session->set_flashdata("sucessPageMessage","Image updated Successfully!");
			}
		}
		else{
			$newimg =  $oldimage;
		}
		$data2 =  array(	'file_name'				=>$newimg, 
							'media_price'			=>$imageprice,								
							'photo_resolution'		=>$photo_resolution,								
							'photo_size'			=>$photo_size,								
							'digital_format'		=>$digital_format,								
							'photo_number'			=>$photo_number,								
					);
		$mess = $this->CustomerImageModel->updateEventbyId($mid, $data2);
		
		if($mess==1){
			$data['Image_data'] 	= $this->CustomerImageModel->imageEditById($mid);
			$this->session->set_flashdata("sucessPageMessage","Data updated Successfully!");
			redirect(base_url()."CustomerImageUpload/editImage/".$mid."/".$cid);
		} 
	} 
	
	public function publishImage($mid='',$cid=''){
		$data	=array();
		
		$data	=array("publish_status"		=>	'1',
						"pub_unpub_date"		=>	date('Y-m-d')
				);
		
		$this->CustomerImageModel->changeImgPublishStatus($mid,$data);
		$this->session->set_flashdata("sucessPageMessage","Image Published Successfully!");
		redirect(base_url()."customerImageUpload/viewImage/".$cid);
		
	}
	public function unPublishImage($mid='',$cid=''){
		$data	=array();
		
		$data	=array("publish_status"		=>	'0',
						"pub_unpub_date"		=>	date('Y-m-d')
				);
		
		$this->CustomerImageModel->changeImgPublishStatus($mid,$data);
		$this->session->set_flashdata("sucessPageMessage","Image Unpublished Successfully!");
		redirect(base_url()."customerImageUpload/viewImage/".$cid);
		
	}
	
	public function deleteImage($mid='',$cid=''){
	
		$this->CustomerImageModel->deleteImagesById($mid);
		
		$condition_customer_photographer_relation = "media_id = '$id'";
		$checkon_photographer_relations = $this->Customermodel->isRecordExist('el_media_customer_photographer_relation',$condition_customer_photographer_relation);
		
		if(!empty($checkon_photographer_relations)){
			
			foreach($checkon_photographer_relations as $checkon_photographer_relation)
			{
				$data 		=  array('rel_status'=>'0');
				$condArr    =  array("media_rel_id" => $checkon_photographer_relation['media_rel_id']);
				$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_media_customer_photographer_relation',$condArr);
			}
			
		}
		
		
		$this->session->set_flashdata("sucessPageMessage","Image Deleted Successfully!");
		redirect(base_url()."customerImageUpload/viewImage/".$cid);
	}
	
	public function AjaxCustomerwiseLoaction(){
		$recArr				= array();
		$fetchedId			= $this->input->post('customer_id');
	    //echo $fetchedId; exit;
		$comboVal = $this->CustomerImageModel->fetchCustomerdtls($fetchedId);
		if(!empty($comboVal))
		{
			foreach($comboVal as $val)
				{
					
					$recArr['process'] 			    =  'success';
					$recArr['customer_location']   	=  $val['location_id'];
					
/*$data           	= 	$this->CustomerImageModel->get_events($val['location_id']);

					for($i=0;$i<count($data);$i++){
						echo $events = '<option value="'.$data[$i]['event_id'].'">'.$data[$i]['event_name'].'</option>';

					}*/
					
					

					
				}
		}
        else{
					$recArr['process'] 	=  'fail';	
        }			
		            //print_r($recArr);
					echo json_encode($recArr);    
		}
		
	public function populateAjaxbyUserEvent()
	{
		$get_customerId			= $this->input->post('customerId');
		
		$get_eventId			= $this->input->post('eventId');
		$get_customerName		= $this->input->post('customerName');
		
		if(!empty($get_customerId)){
			
			$get_event_lists = $this->CustomerImageModel->getCustomerEventlist($get_customerId);
			
			if(!empty($get_event_lists)){
			
				$return_new_array = array();

					foreach($get_event_lists as $get_event_list)

					{

						$returnArr = array();

						$returnArr['event_id'] = $get_event_list->event_id;

						$returnArr['event_name'] = $get_event_list->event_name;

						

						$return_new_array[] = $returnArr;

					}

					//print_r($return_new_array);

					

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
		
		else if(!empty($get_eventId)){
			
			$get_photograph_lists = $this->CustomerImageModel->getCustomerPhotographlist($get_eventId);
			
			$return_new_array = array();

				foreach($get_photograph_lists as $get_photograph_list)

				{

					$returnArr = array();

					$returnArr['photographer_id'] = $get_photograph_list->photographer_id;

					$returnArr['photographer_name'] = $get_photograph_list->photographer_name;

					

					$return_new_array[] = $returnArr;

				}

				//print_r($return_new_array);

				

				header('Content-Type: application/json');

				 echo json_encode( $return_new_array );
			
		}
	/* 	else if($get_customerId == 0){
			$returnArr = array();

			$returnArr['event_id'] = '';

			$returnArr['event_name'] = 'No Event';
			$return_new_array = $returnArr;
			header('Content-Type: application/json');

			echo json_encode( $return_new_array );
		} */
		/* else{
			$returnArr = array();

			$returnArr['event_id'] = '';

			$returnArr['event_name'] = 'No Event';
			$return_new_array[] = $returnArr;
			header('Content-Type: application/json');

			echo json_encode( $return_new_array );
		} */
	}

}

