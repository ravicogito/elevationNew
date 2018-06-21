<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Favourite extends CI_Controller {

	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	 function __construct(){
		
		parent::__construct();
		$this->elements 							= array();
		$this->elements_data 						= array();
		$this->data 								= array();	

		$this->load->model(array('Model_event'));
		$this->data['themePath'] 					= $this->config->item('theme');		
		$this->data['userID']						= $this->session->userdata('customer_id');		
		$this->layout->setLayout('inner_layout');
		
		if(empty($this->data['userID'])) {
			redirect(base_url()."Category/");
		}
	}
	
	public function index() {
		unset($_SESSION['imageDecoration']);
		$this->allimages();
	}
	
		
	public function allimages() {
		
		$customer_id 										= $this->session->userdata('customer_id');
		
		$get_customer_favourites 							= $this->Model_event->eventidByCustomer($customer_id);
		
		if(!empty($get_customer_favourites ))
		{
		
			if($get_customer_favourites) {
				foreach($get_customer_favourites as $get_customer_favourite) {
					$customer_eventID[] = $get_customer_favourite['event_id'];				
				}
			} else {
				$customer_eventID 								= array();
			}
			
			$customer_eventIDs									= $this->Model_event->getcustomerEventId($customer_eventID);
			//pr($customer_eventIDs);
			if($customer_eventIDs) {
				$path 											= './uploads/';
				foreach($customer_eventIDs as $event_data) {
					$mainCatID								    = $event_data['category_id'];
					$mainCatName								= $event_data['cat_name'];
					$eventDate									= $event_data['event_date'];
					$eventTime									= $event_data['event_time'];
					$photographer								= $event_data['photographer_name'];
					$company									= $event_data['raftingcompany_name'];
					$event_name									= $event_data['event_name'];
					
					if($event_data['event_type'] == 'rafting') {
						$fullPath								= $path.'/import/'.$eventDate.'/'.$company.'/'.$eventTime."/".$event_name;
						$data['fullPath'][$event_data['event_id']] = 'import/'.$eventDate.'/'.$company.'/'.$eventTime.'/'.$event_name.'/';
						
					} else {
						$fullPath 								= $path.$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
						//$data['img_path']							= $mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name.'/';
						$data['fullPath'][$event_data['event_id']]	= $mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name.'/';
					}

				
					//echo $data['img_path'];die;
				}			
				$data['all_img_list']							= $this->Model_event->getAllImagesBycustomer($customer_id);			
				//pr($data['all_img_list']);			
			} else {
				$data['all_img_list']							= array();			
			}
			
			$printOption 										= $this->Model_event->getOptionPrintDetails('1');
			$metaOption 										= $this->Model_event->optionMetaDetails('1');
			//pr($metaOption, 0);
			if($printOption) {
				foreach($printOption as $printKey => $printVal) {
					$data['option_name']						= $printVal['option_name'];
					$data['option_image']						= $printVal['option_image'];
					$data['option_description']					= $printVal['option_description'];
					$data['option_size_text']					= $printVal['option_size_type'];
					$data['option_size'][]						= array("size" => $printVal['print_option_size_value'], "price" => $printVal['print_size_price']);
				}
				$data['size_price']								= $printOption[0]['print_size_price'];
			} else {
				$data['size_price']								= '0.00';
			}
			if($data['all_img_list']) {
				$i = 0;
				foreach($data['all_img_list'] as $key => $val) {
					if($i <= 0) {
						$data['img_price']						= $val['media_price'];
						$data['event_id']       				= $val['event_id'];
						$data['media_id']       				= $val['media_id'];
					}
					$i++;
				}
			} else {
				$data['img_price']								= '0.00';
			}
			$data['total_price']								= $data['img_price']+$data['size_price'];
				
			$data['contentTitle']								= "Favourite";
			$data['contentKeywords']							= "Action|Portrait|Kid";
			
			$categories											= $this->Model_event->categoryList();
			$data['all_category']								= $categories;
			
			$guide												= $this->Model_event->guideList();
			//pr($guide,0);
		    $data['all_guide']				    				= $guide;
			$data['cat_id']										= "";
			$data['guide_id']									= "";
			$data['event_date']									= "";
			$data['event_time']									= "0";
			$data['frmaction']									= base_url()."Category/search/";
			$data['option_list']								= $this->Model_event->getOptionList();

			/*------------------- For Rafting --------------------*/
			$starttime 								= '9:00';  // your start time
			$endtime 								= '21:00';  // End time
			$duration 								= '30';  // split by 30 mins
			   
			$array_of_time 							= array ();
			$start_time    							= strtotime ($starttime); //change to strtotime
			$end_time      							= strtotime ($endtime); //change to strtotime
			   
			$add_mins  								= $duration * 60;
			   
			while ($start_time <= $end_time) {// loop between time		  
				$array_of_time[] 					= date ("h:i A", $start_time);
				$start_time 						+= $add_mins; // to check endtie=me
			}
			$data['time_slot']  					= $array_of_time;
			
			$times								    = $this->Model_event->populatetimes($event_data['category_id'], $event_data['event_date']);
			$data['times']								= $times;
				
				
			/*------------------------ END -----------------------*/

			//pr($_SESSION['imageDecoration']);
			/*------------------ Put value into the cart session ---------------------------*/ 

			$_SESSION['imageDecoration']['option']['name']			= $data['option_list'][0]['option_name'];
			$_SESSION['imageDecoration']['price']					= $data['total_price'];
			$_SESSION['imageDecoration']['size']					= $data['option_size'][0]['size'];
			$_SESSION['imageDecoration']['size_price']				= $data['size_price'];
			$_SESSION['imageDecoration']['img_price']				= $data['img_price'];
			$_SESSION['imageDecoration']['event']					= $data['event_id'];
			$_SESSION['imageDecoration']['media']					= $data['media_id'];

			$_SESSION['imageDecoration']['img_name']				= $data['all_img_list'][0]['file_name'];
			$_SESSION['imageDecoration']['img_path']				= "uploads/".$data['fullPath'][$data['all_img_list'][0]['event_id']];

			//unset($_SESSION['Usercart']);
			//pr($_SESSION);
			/*------------------------------- END -------------------------------------------*/
			//pr($data,0);
			$this->layout->view('templates/event/fav-img-list', $data);
		}
		else{
			redirect(base_url()."category");
		}
	}

	public function removeSes(){unset($_SESSION['imageDecoration']);}

	public function getOptionDetails($optionID = 0) {
		$optionID 													= $this->input->post('option_id');
		$imageSrc 													= $this->input->post('image_src');
		$imgPrice													= $this->input->post('img_price');
		$frameName													= $this->input->post('frame_name');
		
		$recArr = array(); 
		if(!empty($optionID)) {
			$printOption 											= $this->Model_event->getOptionPrintDetails($optionID);
			$metaOption 											= $this->Model_event->optionMetaDetails($optionID);
			//pr($metaOption, 0);
			if($printOption) {
				foreach($printOption as $printKey => $printVal) {
					$data['option_name']							= $printVal['option_name'];
					$data['option_image']							= $printVal['option_image'];
					$data['option_description']						= $printVal['option_description'];
					$data['option_size_text']						= $printVal['option_size_type'];
					$data['option_size'][]							= array("size" => $printVal['print_option_size_value'], "price" => $printVal['print_size_price']);
				}
				$data['size_price']									= $printOption[0]['print_size_price'];
			}
			if($metaOption) {
				$data['meta_data']									= array();	
				foreach($metaOption as $metaKey => $metaVal) {
					if(!empty($metaVal['option_meta_value'])) {
						$data['meta_data'][$metaVal['option_meta_head_name']][]			= array("meta_value" => $metaVal['option_meta_value'], "meta_image" => $metaVal['option_meta_image'], "meta_price" => $metaVal['option_meta_price']);
					}
				}
			} else {
				$data['meta_data']									= array();				
			}
			$data['image_src']										= $imageSrc;
			if($data['option_name'] == 'Framing') {
				$data['texture_class'] 								= "texture";
				$data['border_frame']								= "black";
			} else {
				$data['texture_class'] 								= "";
				$data['border_frame']								= "";
			}
			$data['img_price']										= $imgPrice;
			$data['total_price']									= $data['img_price']+$data['size_price'];
			$data['frame_name']										= strtolower(str_replace(" ", "_", $frameName));
			$imageSrcArr											= explode("/", $imageSrc);
			$fileName 												= str_replace("-400_400", "", $imageSrcArr[count($imageSrcArr)-1]);
			
			$eventID 												= $_SESSION['imageDecoration']['event'];
			$eventData 												= $this->Model_event->getSingleEvent($eventID);
			
			if($eventData['event_type'] == 'rafting') {
				$mainCatName											= $imageSrcArr[count($imageSrcArr)-6];
				$eventDate												= $imageSrcArr[count($imageSrcArr)-5];
				$company												= $imageSrcArr[count($imageSrcArr)-4];
				$eventTime												= $imageSrcArr[count($imageSrcArr)-3];
				$event_name												= $imageSrcArr[count($imageSrcArr)-2];
				$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$company.'/'.$eventTime."/".$event_name;
			} else {
				$mainCatName											= $imageSrcArr[count($imageSrcArr)-5];
				$eventDate												= $imageSrcArr[count($imageSrcArr)-4];
				$photographer											= $imageSrcArr[count($imageSrcArr)-3];
				$event_name												= $imageSrcArr[count($imageSrcArr)-2];
				$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
			}
			
		
			/*$_SESSION['cartVal']['option']['name']			= $data['option_name'];
			$_SESSION['cartVal']['price']					= $data['total_price'];
			$_SESSION['cartVal']['frame_name']				= $data['frame_name'];
			$_SESSION['cartVal']['size']					= $data['option_size'][0]['size'];
			$_SESSION['cartVal']['size_price']				= $data['size_price'];
			$_SESSION['cartVal']['img_price']				= $data['img_price'];
			$_SESSION['cartVal']['img_name']				= $fileName;
			$_SESSION['cartVal']['img_path']				= $fullPath;*/
			//pr($data);
			$recArr['HTML']     = $this->load->view('templates/event/ajax-fram-option', $data, true);
			//pr($_SESSION['imageDecoration']); 
			echo json_encode($recArr);
			//echo json_encode($data);
			//pr($data);
		}
	}

	public function cngImg() {
		$imageSrc 													= $this->input->post('img_name');		
		$imagePrice 												= $this->input->post('img_price');
		$finalPrice 												= $this->input->post('final_price');
		$eventID 													= $this->input->post('event_id');
		$mediaID 													= $this->input->post('media_id');
		$eventData 													= $this->Model_event->getSingleEvent($eventID);

		$imageSrcArr												= explode("/", $imageSrc);
		$fileName 													= str_replace("-400_400", "", $imageSrcArr[count($imageSrcArr)-1]);
		if($eventData['event_type'] == 'rafting') {
			$mainCatName											= $imageSrcArr[count($imageSrcArr)-6];
			$eventDate												= $imageSrcArr[count($imageSrcArr)-5];
			$company												= $imageSrcArr[count($imageSrcArr)-4];
			$eventTime												= $imageSrcArr[count($imageSrcArr)-3];
			$event_name												= $imageSrcArr[count($imageSrcArr)-2];
			$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$company.'/'.$eventTime."/".$event_name;
		} else {
			$mainCatName											= $imageSrcArr[count($imageSrcArr)-5];
			$eventDate												= $imageSrcArr[count($imageSrcArr)-4];
			$photographer											= $imageSrcArr[count($imageSrcArr)-3];
			$event_name												= $imageSrcArr[count($imageSrcArr)-2];
			$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
		}
		
		$_SESSION['imageDecoration']['img_path']					= $fullPath;
		$_SESSION['imageDecoration']['img_name']					= $fileName;
		$_SESSION['imageDecoration']['img_price']					= $imagePrice;
		$_SESSION['imageDecoration']['price']						= $finalPrice;
		$_SESSION['imageDecoration']['event']						= $eventID;
		$_SESSION['imageDecoration']['media']						= $mediaID;
		//pr($_SESSION['imageDecoration']);
		echo "success";
	}
	public function cngprintImg() {
		$imageSrc 													= $this->input->post('img_name');
		$imageSrcArr												= explode("/", $imageSrc);
		$fileName 													= str_replace("-400_400", "", $imageSrcArr[count($imageSrcArr)-1]);
		$eventID 													= $this->input->post('event_id');
		
		$eventData 													= $this->Model_event->getSingleEvent($eventID);
		if(!empty($eventData )){
			
			if($eventData['event_type'] == 'rafting') {
				$mainCatName											= $imageSrcArr[count($imageSrcArr)-6];
				$eventDate												= $imageSrcArr[count($imageSrcArr)-5];
				$company												= $imageSrcArr[count($imageSrcArr)-4];
				$eventTime												= $imageSrcArr[count($imageSrcArr)-3];
				$event_name												= $imageSrcArr[count($imageSrcArr)-2];
				$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$company.'/'.$eventTime."/".$event_name;
			} 
			else {
				$mainCatName											= $imageSrcArr[count($imageSrcArr)-5];
				$eventDate												= $imageSrcArr[count($imageSrcArr)-4];
				$photographer											= $imageSrcArr[count($imageSrcArr)-3];
				$event_name												= $imageSrcArr[count($imageSrcArr)-2];
				$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
			}
			echo "success";
		}
	}
	public function cngSize() {
		$frameSize 													= $this->input->post('frame_size');		
		$sizePrice 													= $this->input->post('size_price');
		$finalPrice 												= $this->input->post('final_price');

		$_SESSION['imageDecoration']['size']						= $frameSize;
		$_SESSION['imageDecoration']['size_price']					= $sizePrice;		
		$_SESSION['imageDecoration']['price']						= $finalPrice;
		//pr($_SESSION['imageDecoration']);
		echo "success";
	}

	public function cngFrame() {
		$frameName 													= ucwords(str_replace("_", " ", $this->input->post('frame_name')));		
		$framePrice 												= $this->input->post('frame_price');
		$finalPrice 												= $this->input->post('final_price');

		
		$_SESSION['imageDecoration']['option']['meta']				= array("frame_name" => $frameName, "frame_price" => $framePrice);		
		$_SESSION['imageDecoration']['price']						= $finalPrice;
		//pr($_SESSION['imageDecoration']);
		
		//**********sreela(05/04/18)*********
		$recArr['frame_name']										= $frameName;	
		
		echo json_encode($recArr);
		
		//**********END*********
	}

	public function cngMat() {
		$matPosition 												= $this->input->post('mat_position');
		$matName 													= ucwords(str_replace("_", " ", $this->input->post('mat_name')));		
		$matPrice 													= $this->input->post('mat_price');
		$finalPrice 												= $this->input->post('final_price');

		
		$_SESSION['imageDecoration']['option']['meta'][$matPosition]= array("mat_name" => $matName, "mat_price" => $matPrice);		
		$_SESSION['imageDecoration']['price']						= $finalPrice;
		//pr($_SESSION['imageDecoration']);
		
		//**********sreela(05/04/18)*********
		
		if($matPosition =='top'){
			$recArr['topmat_name']										= $matName;
		}
		else if($matPosition =='middle'){
			$recArr['middlemat_name']									= $matName;
		}
		else if($matPosition =='bottom'){
			$recArr['bottommat_name']									= $matName;
		}
		else{
			
			
		}
		echo json_encode($recArr);
		
		//**********END*********
	}
	
	public function cart() {
		//unset($_SESSION['imageDecoration']);
		//pr($_SESSION);
		$_SESSION['imageDecoration']['quantity']					= '1';
		$_SESSION['imageDecoration']['cur_img']						= $this->input->post('img_val');
		//print_r(count($_SESSION['imageDecoration']));die;
		$flag 														= 'exists';
		if(!empty($_SESSION['Usercart']))
		{
			foreach($_SESSION['Usercart'] as $key => $cartValue)
			{
				$option_name_arr[]	    = $_SESSION['Usercart'][$key]['option']['name'];
				$option_size_arr[] 		= $_SESSION['Usercart'][$key]['size'];
				$option_img_name_arr[]  = $_SESSION['Usercart'][$key]['img_name'];
			}
			
			//echo"<pre>";print_r($option_img_name_arr);die;
			
			/* if($_SESSION['Usercart'][$key]['option']['name'] != $_SESSION['imageDecoration']['option']['name'] || $_SESSION['Usercart'][$key]['size'] != $_SESSION['imageDecoration']['size'] || $_SESSION['Usercart'][$key]['img_name'] != $_SESSION['imageDecoration']['img_name']) */
				
			if(in_array($_SESSION['imageDecoration']['option']['name'],$option_name_arr) && in_array($_SESSION['imageDecoration']['size'],$option_size_arr) && in_array($_SESSION['imageDecoration']['img_name'],$option_img_name_arr))
			{
				
				$this->session->set_flashdata('failedMessage','Same Image Could Not Be Added');
				
				
			}
			else{
				//$flag 											= 1;
				
				$flag 											= 'notexists';
			}
				
		} else {
			$flag 													= 'notexists';			
		}
		if($flag == 'notexists') {
			$_SESSION['Usercart'][] = $_SESSION['imageDecoration'];
		}
		//pr($_SESSION['imageDecoration']);
		unset($_SESSION['imageDecoration']);
		redirect(base_url()."cartAdd/");
	}
	
	
	public function cartNew() {
	//unset($_SESSION['productArry']);
	//unset($_SESSION['cartVal']);
		$formdata                                                   = $this->input->post('formdata');
		
		$form_data_all                                              = explode('&',$formdata);
		
		$selected_photoVal                                        	= $form_data_all[6];
		$selected_photoArr                                          = explode('=',$selected_photoVal);
		$cartnewitem['selected_photo']                      		= $selected_photoArr[1];
		$size_priceVal                                              = $form_data_all[1];
		$size_priceArr                                              = explode('=',$size_priceVal);
		$cartnewitem['size']                               			= $size_priceArr[1];
		
		
		$sizeVal                                                    = $form_data_all[0];
		$sizeArr                                                    = explode('=',$sizeVal);
		if($selected_photoArr[1] > 1 && $size_priceArr[1] =='5x7'){
								
			$cartnewitem['size_price']		= 20;
		}
		else if($selected_photoArr[1] > 1 && $size_priceArr[1] == '8x10'){
			
			$cartnewitem['size_price']		= 25;
		}
		else{
			
			$cartnewitem['size_price']                          		= $sizeArr[1];
		}		
		
		$imagesVal                                                  = $form_data_all[2];
		$imagesArr                                                  = explode('=',$imagesVal);
		$cartnewitem['images']                              		= $imagesArr[1];
        $all_images                                                 = explode('~',$imagesArr[1]);
		
		
			
		$imagesIDVal                                                = $form_data_all[3];
		$imagesIDArr                                                = explode('=',$imagesIDVal);
		$cartnewitem['imagesID']                            		= $imagesIDArr[1];
		
		$eventIDVal                                                 = $form_data_all[4];
		$eventIDArr                                                 = explode('=',$eventIDVal);
		$cartnewitem['eventID']                            			= $eventIDArr[1];
		
		$cartnewitem['msg']                            	   			= $form_data_all[5];
		
		$msgVal                                                 	= $form_data_all[5];
		$msgDArr                                                    = explode('=',$msgVal);
		$cartnewitem['msg']                            	    		= $msgDArr[1];	
		
		$total_photoVal                                        		= $form_data_all[7];
		$total_photoValArr                                          = explode('=',$total_photoVal);
		$cartnewitem['total_photo']                      			= $total_photoValArr[1];

		########SUDHANSU############################# 
		/*$total_dgimgprcVal                       = $form_data_all[9];
		$total_dgimgprcValArr                      = explode('=',$total_dgimgprcVal);
		$_SESSION['cartVal']['dgimg_price']        = $total_dgimgprcValArr[1];*/
		########SUDHANSU############################# 
		
		$cartnewitem['quantity']							  = 1;
		$cartnewitem['packagetype']							  = 'printing-pkg';
		$cartnewitem['total_image_cnt']						  = '0';
		foreach($all_images as $key=> $images){
			if($selected_photoArr[1] > 1 && $size_priceArr[1] =='5x7'){
				$cartnewitem['single_price'][$key]               = 20;
			}
			else if($selected_photoArr[1] > 1 && $size_priceArr[1] == '8x10'){			
				$cartnewitem['single_price'][$key]               = 25;
			}
			else{
				$cartnewitem['single_price'][$key]               = $sizeArr[1];
				
			}
			$cartnewitem['qty'][$key]                        	 = 1;
		}
		if(!empty($cartnewitem['eventID'])){
			$_SESSION['productArry'][]							 = $cartnewitem;
		}
		$_SESSION['digital_price']								 = 0;
		//pr($_SESSION['productArry']);
		
		
		echo json_encode($_SESSION['productArry']);	
		
	}

 ########DEVELOPED SUDHANSU############################################ 
	public function cartNewDigital() {
	//unset($_SESSION['cartVal']);
	$recarray     					= array();
    if($this->input->post('dgtaltype') == 'processnext'){
        $image_name = $this->input->post('image_name');
        $image_id = $this->input->post('image_id');
        $event_id = $this->input->post('event_id');
        $selected_photo = $this->input->post('selected_photo');
        $total_photo = $this->input->post('total_photo');
        $dgimg_price = $this->input->post('dgimg_price');
		
       /* $formdata                          = $this->input->post('formdata');
		$form_data_all                     = explode('&',$formdata);
		$sizeVal                           = $form_data_all[0];
		$sizeArr                           = explode('=',$sizeVal);
		$cartnewitem['size_price']         = $sizeArr[1];
		$size_priceVal                     = $form_data_all[1];
		$size_priceArr                     = explode('=',$size_priceVal);
		$cartnewitem['size']               = $size_priceArr[1];*/
		$cartnewitem['size_price']			= '0';
		$cartnewitem['size']               	= '0';
		$cartnewitem['images']             	= $image_name;
		$all_images                        	= explode('~',$image_name);
		
		$cartnewitem['imagesID']           	= $image_id;
		
		
		$cartnewitem['eventID']           	= $event_id;		
	
		$cartnewitem['selected_photo']     	= $selected_photo;
		
		
		$cartnewitem['total_photo']        	= $total_photo;
        $cartnewitem['dgimg_price']        	= $dgimg_price;


		########SUDHANSU############################# 
		/*$total_dgimgprcVal                         = $form_data_all[9];
		$total_dgimgprcValArr                      = explode('=',$total_dgimgprcVal);
		$_SESSION['cartVal']['dgimg_price']        = $total_dgimgprcValArr[1];*/
		########SUDHANSU############################# 
		
		$cartnewitem['quantity']		 						= '1';
		$cartnewitem['total_image_cnt']							= '0';
		$cartnewitem['download']		 						= 'yes';
		$cartnewitem['packagetype']		 						= 'digital-pkg';
		$cartnewitem['print'] 									= 'onlyprint';
		foreach($all_images as $key=> $images){
			
			$cartnewitem['single_price'][$key]               = 0;
			
			$cartnewitem['qty'][$key]                        = 1;
		}
		if(!empty($cartnewitem['eventID'])){
			$_SESSION['productArry'][]							= $cartnewitem;
			$_SESSION['cartVal'][]								= $cartnewitem;
			
		}
		$_SESSION['digital_price']								= $dgimg_price;
		
		$recarray['download']									='yes';
    }else{
		
		$dgimg_price = $this->input->post('dgimg_price');
		
		$formdata                                                 	= $this->input->post('formdata');
		//echo $formdata;exit;
		$form_data_all                                              = explode('&',$formdata);
		$sizeVal                                                    = $form_data_all[0];
		$sizeArr                                                    = explode('=',$sizeVal);
		$cartnewitem['size_price']                          			= $sizeArr[1];
		$size_priceVal                                              = $form_data_all[1];
		$size_priceArr                                              = explode('=',$size_priceVal);
		$cartnewitem['size']                               				 = $size_priceArr[1];
		$imagesVal                                                  = $form_data_all[2];
		$imagesArr                                                  = explode('=',$imagesVal);
		$cartnewitem['images']                              			= $imagesArr[1];
		$all_images                                                 = explode('~',$imagesArr[1]);
		$imagesIDVal                                                = $form_data_all[3];
		$imagesIDArr                                                = explode('=',$imagesIDVal);
		$cartnewitem['imagesID']                            			= $imagesIDArr[1];
		
		$eventIDVal                                                 = $form_data_all[4];
		$eventIDArr                                                 = explode('=',$eventIDVal);
		$cartnewitem['eventID']                            				= $eventIDArr[1];
		
		$cartnewitem['msg']                            	   				 = $form_data_all[5];
		
		$msgVal                                                 	= $form_data_all[5];
		$msgDArr                                                    = explode('=',$msgVal);
		$cartnewitem['msg']                            	    			= $msgDArr[1];
		
		$selected_photoVal                                        	= $form_data_all[6];
		$selected_photoArr                                          = explode('=',$selected_photoVal);
		$cartnewitem['selected_photo']                      			= $selected_photoArr[1];
		
		$total_photoVal                                        		= $form_data_all[7];
		$total_photoValArr                                          = explode('=',$total_photoVal);
		$cartnewitem['total_photo']                					= $total_photoValArr[1];
        $total_dgimgprcVal                 							= $form_data_all[9];
		$total_dgimgprcValArr              							= explode('=',$total_dgimgprcVal);
		$cartnewitem['dgimg_price']        							= $total_dgimgprcValArr[1];


		########SUDHANSU############################# 
		/*$total_dgimgprcVal                         = $form_data_all[9];
		$total_dgimgprcValArr                      = explode('=',$total_dgimgprcVal);
		$_SESSION['cartVal']['dgimg_price']        = $total_dgimgprcValArr[1];*/
		########SUDHANSU############################# 
		
		$cartnewitem['quantity']		 							= '1';
		$cartnewitem['total_image_cnt']								= '0';
		$cartnewitem['download']									= 'yes';
		$cartnewitem['packagetype']		 							= 'digital-pkg';
		foreach($all_images as $key=> $images){
			$cartnewitem['single_price'][$key]               = $cartnewitem['size_price'];
			$cartnewitem['qty'][$key]                        = 1;
			
		}
		if(!empty($cartnewitem['eventID'])){
			$_SESSION['productArry'][]									= $cartnewitem;
		}
		$_SESSION['digital_price']									= $dgimg_price;
		$recarray['download']										=	'no';
       }
		$_SESSION['digital_price']									= $cartnewitem['dgimg_price'];	
		echo json_encode($recarray);
	}

/*----------------------- Collage Section ------------------------*/	
	public function getCollageDetails() {
		$recArr 						= array();
		$data 							= array();
		$data['count']					= $this->input->post('');
		$_SESSION['imageDecoration']['option']['name']			= "collage";
		$recArr['HTML']     			= $this->load->view('templates/event/ajax-fram-collage', $data, true);
		//pr($_SESSION['imageDecoration']); 
		echo json_encode($recArr);
	}
	public function getCollageDetailsRafting() {
		$recArr 						= array();
		$data 							= array();
		$data['count']					= $this->input->post('');
		$_SESSION['imageDecoration']['option']['name']			= "collage";
		$recArr['HTML']     			= $this->load->view('templates/event/ajax-fram-collage_rafting', $data, true);
		//pr($_SESSION['imageDecoration']); 
		echo json_encode($recArr);
	}
	public function cngColageFrame() {
		$frameName 													= ucwords(str_replace("_", " ", $this->input->post('frame_name')));		
		$framePrice 												= $this->input->post('frame_price');
		$finalPrice 												= $this->input->post('final_price');		
		
		$_SESSION['imageDecoration']['price']						= $finalPrice;		
		//pr($_SESSION['imageDecoration']);		
		
		$recArr['frame_name']										= $frameName;		
		echo json_encode($recArr);		
	}

	public function cngImgCollage() {
		$imageSrc 													= $this->input->post('img_name');		
		$imagePrice 												= $this->input->post('img_price');
		$finalPrice 												= $this->input->post('final_price');
		$eventID 													= $this->input->post('event_id');
		$mediaID 													= $this->input->post('media_id');
		$eventData 													= $this->Model_event->getSingleEvent($eventID);

		$imageSrcArr												= explode("/", $imageSrc);
		$fileName 													= str_replace("-400_400", "", $imageSrcArr[count($imageSrcArr)-1]);
		if($eventData['event_type'] == 'rafting') {
			$mainCatName											= $imageSrcArr[count($imageSrcArr)-6];
			$eventDate												= $imageSrcArr[count($imageSrcArr)-5];
			$company												= $imageSrcArr[count($imageSrcArr)-4];
			$eventTime												= $imageSrcArr[count($imageSrcArr)-3];
			$event_name												= $imageSrcArr[count($imageSrcArr)-2];
			$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$company.'/'.$eventTime."/".$event_name;
		} else {
			$mainCatName											= $imageSrcArr[count($imageSrcArr)-5];
			$eventDate												= $imageSrcArr[count($imageSrcArr)-4];
			$photographer											= $imageSrcArr[count($imageSrcArr)-3];
			$event_name												= $imageSrcArr[count($imageSrcArr)-2];
			$fullPath 												= "uploads/".$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
		}
		$_SESSION['imageDecoration']['file_name'][]					= $fileName;
		$_SESSION['imageDecoration']['full_path'][]					= $fullPath;
		$_SESSION['imageDecoration']['img_path']					= implode(',', $_SESSION['imageDecoration']['full_path']);
		$_SESSION['imageDecoration']['img_name']					= implode(",", $_SESSION['imageDecoration']['file_name']);
		$_SESSION['imageDecoration']['img_price']					= $imagePrice;
		$_SESSION['imageDecoration']['price']						= $finalPrice;
		$_SESSION['imageDecoration']['event']						= $eventID;
		$_SESSION['imageDecoration']['media']						= $mediaID;
		//pr($_SESSION['imageDecoration']);
		echo "success";
	}
	
	public function countfavImgByEvent() {
		$recArr 													= array();
		$event_id 													= $this->input->post('eventID');
		$customer_id 												= $this->session->userdata('customer_id');
	    $countfavImg   											    = $this->Model_event->countImage($customer_id,$event_id);

	    #### INTEGRATED BY SUDHANSU-21-05-2018###########
         $countTotEvntImg   = $this->Model_event->getAllImages($event_id);
	    #### INTEGRATED BY SUDHANSU-21-05-2018###########
		
	   if(!empty($countfavImg))
		{
			$recArr['process'] 				= 'success';
			$recArr['event_photo_no']       = $countfavImg;
			#### INTEGRATED BY SUDHANSU-21-05-2018###########
			$recArr['total_event_photo']    = count($countTotEvntImg);
			#### INTEGRATED BY SUDHANSU-21-05-2018###########
		}
		else{
			$recArr['process']      = 'fail';
		}		
		echo json_encode($recArr);		
	}
}
?>	