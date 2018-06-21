<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

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
		$this->layout->setLayout('inner_layout');
	}
	
	public function index() {		
		$this->data['contentTitle']				= "Category";
		$this->data['contentKeywords']			= "Action|Portrait|Kid";
		$categories								= $this->Model_event->categoryList();
		$this->data['all_category']				= $categories;

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
		
		
		//$this->data['all_times']				    = $times;
		
		//$this->data['time_slot']  				= $array_of_time;
		/*------------------------ END -----------------------*/
		
		$guide									= $this->Model_event->guideList();
		$this->data['all_guide']				= $guide;
		

		$this->data['frmaction']				= base_url()."Category/search/";
		$this->data['action']					= "";
		$this->data['cat_id']					= "";
		$this->data['guide_id']					= "";
		$this->data['event_time']				= "0";
		$this->data['event_date']				= "";

		//pr($this->data);
		$this->layout->view('templates/event/search',$this->data);
	}
	
	public function search() {
		if(!empty($this->input->post('cat_id'))){
			$time 									= 0;
			$categoryIDArr							= explode("|",$this->input->post('cat_id'));
			$categoryID 							= $categoryIDArr[0];
			$categoryName 							= $categoryIDArr[1];
			$date 									= $this->input->post('event_date');
			
			if($categoryID == 17) {
				$time 								= $this->input->post('event_time');
				$company_id 						= $this->input->post('rafting_company');
			}
			else{
				$time                               = 0;
				$company_id 						= '';
			}
			$eventDate								= date("Y-m-d", strtotime(str_replace("/", "-", $date)));
			$this->data['contentTitle']				= "Category";
			$this->data['contentKeywords']			= "Action|Portrait|Kid";
			$categories								= $this->Model_event->categoryList();
			$this->data['all_category']				= $categories;
			
		
			$this->data['frmaction']				= base_url()."Category/search/";
			$this->data['cat_id']					= $categoryID;
			$this->data['company_id']				= $company_id;
			$this->data['event_time']				= $time;
			$times									= $this->Model_event->populatetimes($company_id, $eventDate);
			$this->data['times']					= $times;
			
			$companys								= $this->Model_event->populatecompany($categoryID, $eventDate);
			$this->data['companys']					= $companys;

			
			$this->data['event_date']				= $date;
			
			$guides									= $this->Model_event->populateguide($time,$eventDate);
			$this->data['guides']					= $guides;
			
			
			$this->data['action']					= "search";		
			$this->data['event_list']				= $this->Model_event->getEventList($categoryID, $eventDate, $time,$company_id);
			
			if($this->data['event_list']) {
				foreach($this->data['event_list'] as $key => $val) {
					$path 							= './uploads/';
					$mainCatName					= $val['cat_name'];
					$eventDate						= $val['event_date'];
					$eventTime						= $val['event_time'];
					$photographer					= $val['photographer_name'];
					$company						= $val['raftingcompany_name'];
					$event_name						= $val['event_name'];
				
					if($categoryID == 17) {
						$fullPath					= $path.'/import/'.$eventDate.'/'.$company.'/'.$eventTime."/".$event_name;
						$this->data['event_list'][$key]['img_path']	= 'import/'.$eventDate.'/'.$company.'/'.$eventTime.'/'.$event_name.'/';
						$this->data['event_list'][$key]['path']	= $fullPath.'/';
					} else {
						$fullPath					= $path.$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
						$this->data['event_list'][$key]['img_path']	= $mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name.'/';
						$this->data['event_list'][$key]['path']	= $fullPath.'/';
					}
					
					
				}
				
			}
			
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
			$this->data['time_slot']  				= $array_of_time;
			$this->data['categoryID']  				= $categoryID;
			/*------------------------ END -----------------------*/

			//pr($this->data);
			$this->layout->view('templates/event/search',$this->data);
		} else {
			redirect(base_url()."Category/");
		} 
		
	}
	
	public function allimages($eventID = 0) {
		if(!empty($eventID)) {
			$data['event_data']							= $this->Model_event->getSingleEvent($eventID);
			//pr($data['event_data']);
			
			$customer_id = $this->session->userdata('customer_id');
			$data['customer_id'] = $customer_id;
			$favArr = array();
			$customer_favourites = $this->Model_event->getCustomerFavourite($customer_id);
			foreach($customer_favourites as $media_image)
			{
				$favArr[] = $media_image['media_id'];
			}
			$data['customer_favourites'] = $favArr;
			if($data['event_data']) {
				$path 										= './uploads/';
				$mainCatName								= $data['event_data']['cat_name'];
				$eventDate									= $data['event_data']['event_date'];
				$eventTime									= $data['event_data']['event_time'];
				$photographer								= $data['event_data']['photographer_name'];
				$company									= $data['event_data']['raftingcompany_name'];
				$event_name									= $data['event_data']['event_name'];

				if($data['event_data']['event_type'] == 'rafting') {
					$fullPath								= $path.'/import/'.$eventDate.'/'.$company.'/'.$eventTime."/".$event_name;
					$data['img_path']						= 'import/'.$eventDate.'/'.$company.'/'.$eventTime.'/'.$event_name.'/';
					
				} else {
					$fullPath 								= $path.$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
					$data['img_path']						= $mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name.'/';
				}
				
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
				$data['time_slot']  				    = $array_of_time;
				
				
				
				
			
				/*------------------------ END -----------------------*/

				$limit										= '20';
				$start										= '0';
				
				$data['contentTitle']						= "Category";
				$data['event_name']							= $event_name;
				$data['contentKeywords']					= "Action|Portrait|Kid";
				$data['all_img_list']						= $this->Model_event->getAllImages($eventID, $limit, $start);
				
				$categories									= $this->Model_event->categoryList();
				$data['all_category']						= $categories;
				
				$data['company_id']							= $data['event_data']['rafting_company_id'];
				
				$times									    = $this->Model_event->populatetimes($data['event_data']['rafting_company_id'], $data['event_data']['event_date']);
			    $data['times']								= $times;
				
				
				
				
				$data['frmaction']							= base_url()."Category/search/";
				$data['cat_id']								= $data['event_data']['category_id'];
				
				$data['guide_id']							= $data['event_data']['guide_id'];
				$data['event_time']							= $data['event_data']['event_time'];
				$data['event_date']							= date("d/m/Y", strtotime($data['event_data']['event_date']));
				$data['event_id']							= $eventID;
				
				$guides									    = $this->Model_event->populateguide($data['event_data']['event_time'],$data['event_data']['event_date']);
			    $data['guides']							    = $guides;
				
				$companys									= $this->Model_event->populatecompany($data['event_data']['category_id'],$data['event_data']['event_date']);
			    $data['companys']							= $companys;

				$pageArr['event_id']						= $eventID;	
				$pageArr['per_page']						= $limit;	
				$data['pagination']							= $this->_pagination($pageArr);
				//pr($data);
				$this->layout->view('templates/event/img-list', $data);
			} else {
				redirect(base_url()."Category");
			}
			
		}
	}
	
	
	public function populatecompany()
	{
		$recArr = array();
		
		$cat_id 				 = $this->input->post('cat_id');
		$date 					 = $this->input->post('date');
		$date1                   = explode('/',$date);
		$newdate1                = $date1[0];
		$newdate2                = $date1[1];
		$newdate3                = $date1[2];
		$newdate                 = $newdate3.'-'.$newdate2.'-'.$newdate1;

		$populatecompany   		 = $this->Model_event->populatecompany($cat_id,$newdate);
		
		if(!empty($populatecompany))
		{
			$recArr['process'] 		= 'success';
			$recArr['companys']      = $populatecompany;
			
			
		}
		else{
			$recArr['process']      = 'fail';
		}
		
		//pr($recArr);
		
		echo json_encode($recArr);
		
	}
	
	
	public function populatetime()
	{
		$recArr = array();
		
		$company_id 			 = $this->input->post('company_id');
		$date 					 = $this->input->post('event_date');

		$date1                   = explode('/',$date);
		$newdate1                = $date1[0];
		$newdate2                = $date1[1];
		$newdate3                = $date1[2];
		$newdate                 = $newdate3.'-'.$newdate2.'-'.$newdate1;

		$populatetimes   		 = $this->Model_event->populatetimes($company_id,$newdate);
		if(!empty($populatetimes))
		{
			$recArr['process'] 		= 'success';
			$recArr['timeslots']    = $populatetimes;
			
			
		}
		else{
			$recArr['process']      = 'fail';
		}
		echo json_encode($recArr);
		
	}
	
	
	public function populateguide()
	{
		$recArr = array();
		
		$event_time 			 = $this->input->post('event_time');
		$event_date 			 = $this->input->post('event_date');
		$event_date1 			 = str_replace('/', '-', $event_date);
		$event_date2             = date('Y-m-d', strtotime($event_date1));
		

		$populateguide   		 = $this->Model_event->populateguide($event_time,$event_date2);
		if(!empty($populateguide))
		{
			$recArr['process'] 		= 'success';
			$recArr['guides']       = $populateguide;
			
			
		}
		else{
			$recArr['process']      = 'fail';
		}
		
		echo json_encode($recArr);
		
	}
	
	public function checkFavourite()
	{
		//pr($_POST);
		$recArr = array();
		
		$get_media_id 	 = $this->input->post('media_id');
		$get_customer_id = $this->input->post('customer_id');
		$get_event_id 	 = $this->input->post('event_id');
		
		$check_existance_data = $this->Model_event->checkisExist($get_event_id,$get_customer_id,$get_media_id);
		/* echo"<pre>";
		print_r($check_existance_data);
		die; */
		
		if(!empty($check_existance_data))
		{
			$recArr['get_favourite'] = 'get_img';
		}
		else{
			$recArr['get_favourite'] = 'not_get_img';
		}
		
		echo json_encode($recArr);
	}
	
	public function addFavourite()
	{
		$recArr = array();
		
		$media_id 	 = $this->input->post('media_id');
		//$customer_id = $this->input->post('get_customer_id');
		$customer_id = $this->session->userdata('customer_id');
		$event_id 	 = $this->input->post('get_event_id');
		
		$check_existance_data = $this->Model_event->checkisExistimage($event_id,$customer_id,$media_id);
		
		/* echo"<pre>";
		print_r($check_existance_data);
		die; */
		
		if((!empty($check_existance_data)) && $check_existance_data['is_favourite'] == 0)
		{
			$table = 'el_customer_favourite';
			
			$where = array('event_id' => $event_id,'customer_id' => $customer_id,'media_id' => $media_id);
			$data = array('is_favourite' => '1');
			
			$update_customer_favourite = $this->Model_event->updateMedia($data,$table,$where);
			if($update_customer_favourite)
			{
				$recArr['get_favourite'] = 'add_favourite_true';
			}
			else
			{
				$recArr['get_favourite'] = 'add_favourite_false';
			}
		}
		
		else if((!empty($check_existance_data)) && $check_existance_data['is_favourite'] == 1)
		{
			$table = 'el_customer_favourite';
			
			$where = array('event_id' => $event_id,'customer_id' => $customer_id,'media_id' => $media_id);
			$data = array('is_favourite' => '0');
			
			$update_customer_favourite = $this->Model_event->updateMedia($data,$table,$where);
			if($update_customer_favourite)
			{
				$recArr['get_favourite'] = 'remove_favourite_true';
			}
			else
			{
				$recArr['get_favourite'] = 'remove_favourite_false';
			}
		}
		
		else{
			$table = 'el_customer_favourite';
			$data = array('event_id' => $event_id,'customer_id' => $customer_id,'media_id' => $media_id,'is_favourite' => '1');
			$ins_customer_favourite = $this->Model_event->insertData($data,$table);
			if($ins_customer_favourite)
			{
				$recArr['get_favourite'] = 'add_favourite_true';
			}
			else
			{
				$recArr['get_favourite'] = 'add_favourite_false';
			}
		}
		echo json_encode($recArr);
	}
	
	public function removeFavourite()
	{
		$recArr = array();
		
		$media_id 	 = $this->input->post('media_id');
		$customer_id = $this->input->post('get_customer_id');
		$event_id 	 = $this->input->post('get_event_id');
		
		$check_existance_data = $this->Model_event->checkisExist($event_id,$customer_id,$media_id);
		
		/* echo"<pre>";
		print_r($check_existance_data);
		die; */
		
		if(!empty($check_existance_data))
		{
			$table = 'el_customer_favourite';
			
			$where = array('event_id' => $event_id,'customer_id' => $customer_id,'media_id' => $media_id);
			$data = array('is_favourite' => '0');
			
			$ins_customer_favourite = $this->Model_event->updateMedia($data,$table,$where);
			if($ins_customer_favourite)
			{
				$recArr['get_favourite'] = 'true';
			}
			else
			{
				$recArr['get_favourite'] = 'false';
			}
			
		}
		else{
			$recArr['get_favourite'] = 'exist_data';
		}
		echo json_encode($recArr);
	}
	
	public function imgHref()
	{
		$recArr = array();
			
			$img_href = $this->input->post('category_img_href');
			if(!empty($img_href))
			{
				$_SESSION['href'] = $img_href;
				$recArr['img_href'] = 'true';
				echo json_encode($recArr);
			}
			else{
				$_SESSION['href'] = '';
			}
	}

	public function pagination() {	
		$recArr										= array();
		$customer_id = $this->session->userdata('customer_id');
		$data['customer_id'] = $customer_id;
		$favArr = array();
		$customer_favourites = $this->Model_event->getCustomerFavourite($customer_id);
		foreach($customer_favourites as $media_image)
		{
			$favArr[] = $media_image['media_id'];
		}
		$data['customer_favourites'] = $favArr;
		$eventID  									= $this->uri->segment(3);
		$page 										= $this->uri->segment(4);
		$data['event_data']							= $this->Model_event->getSingleEvent($eventID);
		$path 										= './uploads/';
		$mainCatName								= $data['event_data']['cat_name'];
		$eventDate									= $data['event_data']['event_date'];
		$photographer								= $data['event_data']['photographer_name'];
		$event_name									= $data['event_data']['event_name'];
		$fullPath 									= $path.$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
		$data['img_path']							= $mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name.'/';
		$limit										= '4';
		$start										= '0';		
		
		
		$start 										= ($page - 1) * $limit;
		
		$data['all_img_list']						= $this->Model_event->getAllImages($eventID, $limit, $start);
		$categories									= $this->Model_event->categoryList();
		$data['all_category']						= $categories;
		$data['frmaction']							= base_url()."Category/search/";
		$data['cat_id']								= $data['event_data']['category_id'];
		$data['event_date']							= date("d/m/Y", strtotime($data['event_data']['event_date']));
		$data['event_name']							= $event_name;
		$data['event_id']							= $eventID;	

		$pageArr['event_id']						= $eventID;	
		$pageArr['per_page']						= $limit;	
		$data['pagination']							= $this->_pagination($pageArr);
		//pr($data);
		$recArr['HTML']								= $this->load->view('templates/event/ajax-img-list', $data, true);
		$recArr['pagination_link']  				= $this->pagination->create_links();		
		echo json_encode($recArr);
	}

	public function details($mediaID = 0) {
		$data['img_details']						= $this->Model_event->getImgDetailsByID($mediaID);
		$data['event_data']							= $this->Model_event->getSingleEvent($data['img_details']['event_id']);
		$path 										= './uploads/';
		$mainCatName								= $data['event_data']['cat_name'];
		$eventDate									= $data['event_data']['event_date'];
		$photographer								= $data['event_data']['photographer_name'];
		$event_name									= $data['event_data']['event_name'];
		$fullPath 									= $path.$mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name;
		$data['img_path']							= $mainCatName.'/'.$eventDate.'/'.$photographer.'/'.$event_name.'/';

		$callBackHtml								= $this->load->view('templates/event/ajax-image-details', $data, true);
		echo $callBackHtml;
	}


	public function create_collage() {
		$data=array();
		$this->layout->view('templates/event/create-collage', $data);
	}

	private function _pagination($data = array()) {
		$this->load->library('pagination');
		$config['base_url'] 				= "#";
		$config['total_rows'] 				= $this->Model_event->countAllImages($data['event_id']);
		$config['per_page'] 				= $data['per_page'];
		$config['uri_segment'] 				= 4;
		$config['num_links'] 				= 2;
		$config["use_page_numbers"] 		= TRUE;
		$config["full_tag_open"] 			= '<ul class="pagination">';
		$config["full_tag_close"] 			= '</ul>';
		$config["first_tag_open"] 			= '<li>';
		$config["first_tag_close"] 			= '</li>';
		$config["last_tag_open"] 			= '<li>';
		$config["last_tag_close"] 			= '</li>';
		$config['next_link'] 				= '&gt;';
		$config["next_tag_open"] 			= '<li>';
		$config["next_tag_close"] 			= '</li>';
		$config["prev_link"] 				= "&lt;";
		$config["prev_tag_open"] 			= "<li>";
		$config["prev_tag_close"] 			= "</li>";
		$config["cur_tag_open"] 			= "<li class='active'><a href='#'>";
		$config["cur_tag_close"] 			= "</a></li>";
		$config["num_tag_open"] 			= "<li>";
		$config["num_tag_close"] 			= "</li>";		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

}
?>	