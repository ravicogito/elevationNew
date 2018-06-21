<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CartAdd extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;	
	public $limit = array();
	private $getClass ;
	private $getMethod ;
	
	public function __construct(){
		
		parent::__construct();		
		$this->elements 			= array();
		$this->elements_data 		= array();
		$this->data 				= array();
		$this->limit['perPage'] 	= 20;
		$this->limit['offset'] 		= 0;
		$this->data['themePath'] 	= $this->config->item('theme');
		$this->data['userID']		= $this->session->userdata('customer_id');
		$this->load->library('pagination');
		$this->load->helper('download');
		$this->load->model(array('model_cart','model_basic','Model_event'));
		$this->getClass 			= $this->router->fetch_class();
		$this->getMethod 			= $this->router->fetch_method();	
		$userID						= $this->data['userID'];
		if(empty($userID)) {
			redirect(base_url());
		}
		$this->layout->setLayout('inner_layout');	
	}	
	public function index()
	{
		$this->data['contentTitle']				= 'Customer Cart';
		$this->data['frmaction']				= base_url()."Category/search/";
		$categories								= $this->Model_event->categoryList();
		$this->data['all_category']				= $categories;
		
		$guide									= $this->Model_event->guideList();
		$this->data['all_guide']				= $guide;
		

		$this->data['frmaction']				= base_url()."Category/search/";
		$this->data['action']					= "";
		$this->data['cat_id']					= "";
		$this->data['guide_id']					= "";
		$this->data['event_time']				= "0";
		$this->data['event_date']				= "";
			
		
		if(!empty($_SESSION['productArry']))
		{	
			//pr($_SESSION['productArry'],0);
			//pr($_SESSION['cartVal'],0);
			$x =count($_SESSION['productArry']);
			foreach($_SESSION['productArry'] as $cartKey => $cartValue){
				if(is_numeric($cartKey) ) {
					
					$img_id								= $cartValue['imagesID'];
					$imgId								= explode("-",$img_id);
					
					$event_id							= $cartValue['eventID'];
					$event_details				 	    = $this->model_cart->getImgEventDetails($event_id);
					//pr($event_details,0);
					foreach($event_details as $events){
						//echo $events['event_type'];
						if($events['event_type'] == 'rafting') {
						$imagePath[$event_id]      		= base_url().'uploads/import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'];
						
						$_SESSION['productArry'][$cartKey]['imagePath']= $imagePath[$event_id];

						
						$full_path[$event_id] 	   = 'import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'].'/';
						
						$_SESSION['productArry'][$cartKey]['fullPath']= $full_path[$event_id];
						
						}
						else{
						$mainCatName			       = $events['cat_name'];
						$photographer				   = $events['photographer_name'];				
						$imagePath[$event_id] 				   = base_url().'uploads/'.$mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'];
						//$tmpimagePath['imagePath'][$event_id] = $imagePath[$event_id];
						//$_SESSION['productArry'][$cartKey]['image_path']	= $tmpimagePath;
						$_SESSION['productArry'][$cartKey]['imagePath']	= $imagePath[$event_id];
						
						$full_path[$event_id]	   					= $mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'].'/';
						//$tmpfullPath['fullPath'][$event_id] = $full_path[$event_id];
						//$_SESSION['productArry'][$cartKey]['fullPath']	= $tmpfullPath;	
						$_SESSION['productArry'][$cartKey]['fullPath']	= $full_path[$event_id];							
							
						}
					}
				}	
				$this->data['image_path']		= $imagePath;
				$this->data['fullPath']			= $full_path;
				
			} 		
			
		} else {

		}
		
		$userID									= $this->data['userID'];
		$all_img_list							= $this->Model_event->getAllImagesByImgId($userID,$imgId);	
		if(!empty($all_img_list)){
			$this->data['all_img_list']			= $all_img_list;
		}
		else{
			
			$this->data['all_img_list']			= '' ;
		}
		$productDetails 						= $_SESSION['productArry'];
		$printOption 							= $this->Model_event->getOptionPrintDetails('1');
		$metaOption 							= $this->Model_event->optionMetaDetails('1');
			//pr($metaOption, 0);
			if($printOption) {
				foreach($printOption as $printKey => $printVal) {
					$this->data['option_name']						= $printVal['option_name'];
					$this->data['option_image']						= $printVal['option_image'];
					$this->data['option_description']				= $printVal['option_description'];
					$this->data['option_size_text']					= $printVal['option_size_type'];
					$this->data['option_size'][]					= array("size" => $printVal['print_option_size_value'], "price" => $printVal['print_size_price']);
				}
				$this->data['size_price']								= $printOption[0]['print_size_price'];
			} else {
				$this->data['size_price']								= '0.00';
			}
			
			
			$categories											= $this->Model_event->categoryList();
			$this->data['all_category']							= $categories;
			
			$guide												= $this->Model_event->guideList();
			//pr($guide,0);
		    $this->data['all_guide']				    		= $guide;
			$this->data['cat_id']								= "";
			$this->data['guide_id']								= "";
			$this->data['event_date']							= "";
			$this->data['event_time']							= "0";
			$this->data['frmaction']							= base_url()."Category/search/";
			
			$option_list										= $this->Model_event->getOptionList();
		if(!empty($option_list)){
			$this->data['option_list']							= $option_list;
		}
		else{
			
			$this->data['option_list']			= '';
		}
		
		
		################################# FRAME ##################################
		
		
			$printOption 											= $this->Model_event->getOptionPrintDetails(2);
			$metaOption 											= $this->Model_event->optionMetaDetails(2);
			//pr($metaOption, 0);
			if($printOption) {
				foreach($printOption as $printKey => $printVal) {
					$this->data['option_name']							= $printVal['option_name'];
					$this->data['option_image']							= $printVal['option_image'];
					$this->data['option_description']					= $printVal['option_description'];
					$this->data['option_size_text']						= $printVal['option_size_type'];
					$this->data['option_size'][]						= array("size" => $printVal['print_option_size_value'], "price" => $printVal['print_size_price']);
				}
				$this->data['size_price']								= $printOption[0]['print_size_price'];
			}
			if($metaOption) {
				$this->data['meta_data']									= array();	
				foreach($metaOption as $metaKey => $metaVal) {
					if(!empty($metaVal['option_meta_value'])) {
						$this->data['meta_data'][$metaVal['option_meta_head_name']][]			= array("meta_value" => $metaVal['option_meta_value'], "meta_image" => $metaVal['option_meta_image'], "meta_price" => $metaVal['option_meta_price']);
					}
				}
			} else {
				$this->data['meta_data']								= array();				
			}
			//pr($_SESSION['productArry'],0);
			if($events['event_type'] == 'rafting') {
				$this->data['image_src']									= $_SESSION['productArry'][0]['imagePath'].'/'.$all_img_list[0]['file_name'];
			}
			else{
				
				$this->data['image_src']									= $_SESSION['productArry'][0]['imagePath'].'/'.$all_img_list[0]['file_name'];
			}
			if($this->data['option_name'] == 'Framing') {
				$this->data['texture_class'] 							= "texture";
				$this->data['border_frame']								= "black";
			} else {
				$this->data['texture_class'] 							= "";
				$this->data['border_frame']								= "";
			}
			
			
		################################# END FRAME ##################################	
		
		if($_SESSION['productArry'][$x-1]['packagetype'] == 'printing-pkg'){
				$this->layout->view('templates/cart/choose_frame_collage.php', $this->data);
			}
			else{
				
				$this->layout->view('templates/event/fav-img-list_frame', $this->data);
			}
		
	}
    ########DEVELOPED SUDHANSU############################################ 
    public function allImagesFrame() {
		//$data = array()
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

        ###########SUDHANSU############################################
		$this->load->model('model_cart');
		//pr($_SESSION['productArry']);	
		if(!empty($_SESSION['productArry'][0])){
			$img_id								= $_SESSION['productArry'][0]['imagesID'];
			$imgId								= explode("-",$img_id);
			$event_id 							= $_SESSION['productArry'][0]['eventID'];
			$event_details				 	    = $this->model_cart->getImgEventDetails($event_id);
			//pr($event_details,0);
			foreach($event_details as $events){
				//echo $events['event_type'];
				if($events['event_type'] == 'rafting') {
				$data['image_path']      = base_url().'uploads/import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'];
				$_SESSION['productArry'][0]['image_path']	= $data['image_path'];
				
				$data['fullPath'] 	   = 'import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'].'/';
				
				$_SESSION['productArry'][0]['fullPath']	= $data['fullPath'];
				
				}
				else{
				$mainCatName			       = $events['cat_name'];
				$photographer				   = $events['photographer_name'];				
				$data['image_path']      = base_url().'uploads/'.$mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'];
				
				$_SESSION['productArry'][0]['image_path']	= $data['image_path'];
				
				
				$data['fullPath']		   = $mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'].'/';

				$_SESSION['productArry'][0]['fullPath']	= $data['fullPath'];				
					
				}
			}
		}
        //pr($data);
        ###########SUDHANSU############################################
		$userID									= $this->data['userID'];
		$all_img_list							= $this->Model_event->getAllImagesByImgId($userID,$imgId);	
		
		if(!empty($all_img_list)){
			$data['all_img_list']			= $all_img_list;
		}
		else{
			
			$data['all_img_list']			= '' ;
		}


        ################################# FRAME ##################################
		$printOption 			= $this->Model_event->getOptionPrintDetails(2);
		$metaOption 			= $this->Model_event->optionMetaDetails(2);
			//pr($metaOption, 0);
			if($printOption) {
				foreach($printOption as $printKey => $printVal) {
					$data['option_name']							= $printVal['option_name'];
					$data['option_image']							= $printVal['option_image'];
					$data['option_description']					= $printVal['option_description'];
					$data['option_size_text']						= $printVal['option_size_type'];
					$data['option_size'][]						= array("size" => $printVal['print_option_size_value'], "price" => $printVal['print_size_price']);
				}
				$data['size_price']								= $printOption[0]['print_size_price'];
			}
			if($metaOption) {
				$data['meta_data']									= array();	
				foreach($metaOption as $metaKey => $metaVal) {
					if(!empty($metaVal['option_meta_value'])) {
						$data['meta_data'][$metaVal['option_meta_head_name']][]			= array("meta_value" => $metaVal['option_meta_value'], "meta_image" => $metaVal['option_meta_image'], "meta_price" => $metaVal['option_meta_price']);
					}
				}
			} else {
				$data['meta_data']								= array();				
			}
			//pr($_SESSION['productArry'],0);
			$data['image_src']			= $_SESSION['productArry'][0]['image_path'].'/'.$all_img_list[0]['file_name'];
			if($data['option_name'] == 'Framing') {
				$data['texture_class'] 							= "texture";
				$data['border_frame']							= "black";
			} else {
				$data['texture_class'] 							= "";
				$data['border_frame']							= "";
			}
			
			
		################################# END FRAME ##################################	

        ##################################################################
        $this->layout->view('templates/event/fav-img-list_frame', $data);
		}
		else{
			redirect(base_url()."category");
		}
	}
	########DEVELOPED SUDHANSU############################################ 


	public function frmarrayMake(){
		$recarray     					= array();
		$colgimg						= array();
		
		$frm['opsType']					= $this->input->post('ops_type');		
		$frm['frameprice']				= $this->input->post('frm_price');		
		$frm['framename']				= $this->input->post('frm_name');
		$frm['img_val']					= $this->input->post('img_val');
		$frm['qnty']					= $this->input->post('qnty');
		$imgName						= $this->input->post('img_name');	
		if($frm['opsType'] ==  'collage'){
			if(is_array($imgName)){
				$frm['imageName']			= implode('~',$imgName);
			}
			else{
				$frm['imageName']			= $imgName;
			}
		}
		else{
			
			$frm['imageName']			= $imgName;
		}
		$img_id							= $this->input->post('img_id');
		//echo $img_id;exit;
		if(!empty($_SESSION['productArry'])){
			$y =count($_SESSION['productArry']);
			if(!empty($_SESSION['cartVal'])){
				$_SESSION['cartVal'][$y-1]['selected_photo']	= 	$_SESSION['productArry'][$y-1]['selected_photo'];
				$_SESSION['cartVal'][$y-1]['size']				= 	$_SESSION['productArry'][$y-1]['size'];
				$_SESSION['cartVal'][$y-1]['size_price']		= 	$_SESSION['productArry'][$y-1]['size_price'];
				$_SESSION['cartVal'][$y-1]['images']			= 	$_SESSION['productArry'][$y-1]['images'];
				$_SESSION['cartVal'][$y-1]['imagesID']			= 	$_SESSION['productArry'][$y-1]['imagesID'];
				$_SESSION['cartVal'][$y-1]['eventID']			= 	$_SESSION['productArry'][$y-1]['eventID'];
				$_SESSION['cartVal'][$y-1]['msg']				= 	$_SESSION['productArry'][$y-1]['msg'];
				$_SESSION['cartVal'][$y-1]['total_photo']		= 	$_SESSION['productArry'][$y-1]['total_photo'];
				$_SESSION['cartVal'][$y-1]['single_price']		= 	$_SESSION['productArry'][$y-1]['single_price'];
				$_SESSION['cartVal'][$y-1]['qty']				= 	$_SESSION['productArry'][$y-1]['qty'];
				$_SESSION['cartVal'][$y-1]['quantity']			= 	$_SESSION['productArry'][$y-1]['quantity'];
				$_SESSION['cartVal'][$y-1]['packagetype']		= 	$_SESSION['productArry'][$y-1]['packagetype'];
				if(isset($_SESSION['productArry'][$y-1]['download'])){
					$_SESSION['cartVal'][$y-1]['download']		= 	$_SESSION['productArry'][$y-1]['download'];
				}
				if(isset($_SESSION['productArry'][$y-1]['dgimg_price'])){
					$_SESSION['cartVal'][$y-1]['dgimg_price']	= 	$_SESSION['productArry'][$y-1]['dgimg_price'];
				}
				$_SESSION['cartVal'][$y-1]['fullPath']			= 	$_SESSION['productArry'][$y-1]['fullPath'];
				$_SESSION['cartVal'][$y-1]['imagePath']			= 	$_SESSION['productArry'][$y-1]['imagePath'];
			}
			else{
				$_SESSION['cartVal'][$y-1]	= 	$_SESSION['productArry'][$y-1];
				
			}
				$x =count($_SESSION['cartVal']);
				if($frm['opsType'] == 'frame' || $frm['opsType'] == 'print'){
					
					$frmset_count		= count($img_id);
					
				}
				else{
					
					$frmset_count		= count(explode(',',$img_id));
					
				}
				if($_SESSION['productArry'][$y-1]['total_image_cnt'] !='0'){
					$_SESSION['productArry'][$y-1]['total_image_cnt']	= $_SESSION['productArry'][$y-1]['total_image_cnt'] + $frmset_count;
					$_SESSION['cartVal'][$y-1]['total_image_cnt']		= $_SESSION['productArry'][$y-1]['total_image_cnt'];
				}
				else{
					
					$_SESSION['productArry'][$y-1]['total_image_cnt']	= $frmset_count;
					$_SESSION['cartVal'][$y-1]['total_image_cnt']		= $_SESSION['productArry'][$y-1]['total_image_cnt'];
				}
				if($frm['opsType'] == 'frame'){
					$frm['print_price']								= $_SESSION['productArry'][$y-1]['size_price'];
					$_SESSION['cartVal'][$y-1]['frmset'][$img_id]	= $frm;
				}
				else if($frm['opsType'] == 'collage'){
					$frm['print_price']								= $this->input->post('colg_price');	
					$frm['colgname']								= $this->input->post('colg_name');
					$_SESSION['cartVal'][$y-1]['collage'][] = $frm;
					
				}
				else{
					
					$frm['imageId']							= $this->input->post('img_id');	
					$frm['img_val']							= $_SESSION['productArry'][$y-1]['imagePath'].'/'.$frm['imageName'];
					$frm['print_price']						= $_SESSION['productArry'][$y-1]['size_price'];
					$_SESSION['cartVal'][$y-1]['print'][] 	= $frm;
				}
				$selected_photo			  = $_SESSION['productArry'][$y-1]['selected_photo'];
				$frmset_count			  = $_SESSION['productArry'][$y-1]['total_image_cnt'];
				$recarray['frmset_count'] = $frmset_count;
			
				if($selected_photo > $frmset_count){
					
					$recarray['msg'] = "disabled";
					
				}
				else if($selected_photo == $frmset_count){
					
					$recarray['msg'] = "";
					
				}						
		}
		else{
			
			
			
		}
		echo json_encode($recarray);
	}
	public function placeOrder()
	 {
		//pr($_SESSION['cartVal'],0); 
	    $this->data['contentTitle']    			= 'Customer Cart';
	  
	    $this->data['frmaction']				= base_url()."Category/search/";
		$categories								= $this->Model_event->categoryList();
		$this->data['all_category']				= $categories;
		
		$guide									= $this->Model_event->guideList();
		$this->data['all_guide']				= $guide;
		

		$this->data['frmaction']				= base_url()."Category/search/";
		$this->data['action']					= "";
		$this->data['cat_id']					= "";
		$this->data['guide_id']					= "";
		$this->data['event_time']				= "0";
		$this->data['event_date']				= "";
	  
	 if(!empty($_SESSION['cartVal']))
		{	
			//pr($_SESSION['cartVal'],0);
			foreach($_SESSION['cartVal'] as $cartKey => $cartValue){
				if(is_numeric($cartKey) ) {
					if(!empty($cartValue['imagesID'])){
					$img_id								= $cartValue['imagesID'];
					$imgId								= explode("-",$img_id);					
					}
					else{
					
					}
					
					
					
					$event_id							= $cartValue['eventID'];
					$event_details				 	    = $this->model_cart->getImgEventDetails($event_id);
					foreach($event_details as $events){
						//echo $events['event_type'];
						if($events['event_type'] == 'rafting') {
						$imagePath[$event_id]      		= base_url().'uploads/import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'];
						
						$_SESSION['cartVal'][$cartKey]['imagePath']= $imagePath[$event_id];

						
						$full_path[$event_id] 	   = 'import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'].'/';
						
						$_SESSION['cartVal'][$cartKey]['fullPath']= $full_path[$event_id];
						
						}
						else{
						$mainCatName			       = $events['cat_name'];
						$photographer				   = $events['photographer_name'];				
						$imagePath[$event_id] 				   = base_url().'uploads/'.$mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'];
						//$tmpimagePath['imagePath'][$event_id] = $imagePath[$event_id];
						//$_SESSION['cartVal'][$cartKey]['image_path']	= $tmpimagePath;
						$_SESSION['cartVal'][$cartKey]['imagepath']	= $imagePath[$event_id];
						
						$full_path[$event_id]	   					= $mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'].'/';
						//$tmpfullPath['fullPath'][$event_id] = $full_path[$event_id];
						//$_SESSION['cartVal'][$cartKey]['fullPath']	= $tmpfullPath;	
						$_SESSION['cartVal'][$cartKey]['fullPath']	= $full_path[$event_id];							
							
						}
					}
				}	
				$this->data['image_path']		= $imagePath;
				$this->data['fullPath']			= $full_path;
				
			} 		
			
		} else {

		}
	  
	  $this->layout->view('templates/cart/cart', $this->data);
	  
	 } 
	
	public function billingCheckout()
	{
		$this->data['contentTitle']		= 'Customer Cart';
		//pr($_SESSION,0);
		//echo $_SESSION['subtotal'];
		$cid 							= $this->session->userdata('customer_id');
		$this->data['billAddressArr'] 	= $this->model_cart->getBillInfo($cid);
		$this->data['countrylists'] 	= $this->model_cart->getCountrylist();
				
		$this->layout->view('templates/cart/billing-checkout', $this->data);
	}
	
	public function getCountrylist()
	{
		$this->data['contentTitle']				= 'Customer Cart';
		
		$get_country_id = $this->input->post('country_id');
		
		
		
		$state_lists = $this->model_cart->allCountrylist($get_country_id);
		if(!empty($state_lists))
		{
			$return_new_array = array();
			
			foreach($state_lists as $state_list)
			{
				$returnArr = array();
				$returnArr['state_id'] = $state_list['state_id'];
				$returnArr['state_name'] = $state_list['state_name'];
				
				$return_new_array[] = $returnArr;
			}
			
			header('Content-Type: application/json');

			 echo json_encode( $return_new_array );
		}
	}
	
	public function entryOrder()
	{
		$this->data['contentTitle']				= 'Customer Cart';
		
		$cid 				= $this->session->userdata('customer_id');
		$curBillAdd			= trim($this->input->post('newbilladdr'));
		$curBillName		= trim($this->input->post('billing_name'));
		$curBillEmail		= trim($this->input->post('billing_email'));
		$curBillMobile		= trim($this->input->post('billing_mobile'));
		$curBillCountry		= trim($this->input->post('billing_country'));
		$curBillState		= trim($this->input->post('billing_state'));
		$curBillPin			= trim($this->input->post('billing_pin'));
		
		$curshippingAdd		= trim($this->input->post('newshipaddr'));
		$curshippingName	= trim($this->input->post('shipping_name'));
		$curshippingEmail	= trim($this->input->post('shipping_email'));
		$curshippingMobile	= trim($this->input->post('shipping_mobile'));
		$curshippingCountry	= trim($this->input->post('shipping_country'));
		$curshippingState	= trim($this->input->post('shipping_state'));
		$curshippingPin		= trim($this->input->post('shipping_pin'));
		
		$array_billcountry = array('country_id' => $curBillCountry);
		$get_bill_country = $this->model_cart->getCountryByid($array_billcountry);
		
		$array_ship_country = array('country_id' => $curshippingCountry);
		$get_ship_country = $this->model_cart->getCountryByid($array_ship_country);
		
		$array_billstate = array('state_id' => $curBillState);
		$get_bill_state = $this->model_cart->getStateByid($array_billstate);
		
		$array_shipestate = array('state_id' => $curshippingState);
		$get_ship_state = $this->model_cart->getStateByid($array_shipestate);
		
		
		$billingArr = array($curBillName,$curBillAdd,$curBillEmail,$curBillMobile,$get_bill_country['country_name'],$get_bill_state['state_name'],$curBillPin);
		
		$shippingingArr = array($curshippingName,$curshippingAdd,$curshippingEmail,$curshippingMobile,$get_ship_country['country_name'],$get_ship_state['state_name'],$curshippingPin);
		
		$billingAddress = implode('|',$billingArr);
		
		$curshippingAddress = implode('|',$shippingingArr);
		
		
		//echo"<pre>";print_r($implode);die;
		//echo $curBillAdd;die;
		if(!empty($curBillAdd) && !empty($curshippingAdd))
		{
			$newAddBillarray = array('customer_id'   => $cid,
									 'address'       => $billingAddress,
									 'country'       => $curBillCountry,
									 'state'       	 => $curBillState,
									 'pin'      	 => $curBillPin,
									 'address_type'  => 'billing'
								);
			$newAddShiparray = array('customer_id'   => $cid,
									 'address'       => $curshippingAddress,
									 'country'       => $curshippingCountry,
									 'state'       	 => $curshippingState,
									 'pin'      	 => $curshippingPin,
									 'address_type'  => 'shipping'
								);
			$this->model_cart->insertData($newAddBillarray,'el_customer_address');
			$this->model_cart->insertData($newAddShiparray,'el_customer_address');
			
			$cdate = date('Y-m-d h:i:s');
			$order_no = 'or#'.rand();
			$transaction_id = 'txn'.rand();
			$subtotal = $_SESSION['subtotal'];
			//$subtotal = $_SESSION['subtotal'];
			
			$orderarray = array('order_no'       	=> $order_no,
								 'transaction_id'   => $transaction_id,
								 'order_datetime'   => $cdate,
								 'customer_id'      => $cid,
								 'subtotal'         => $subtotal,
								 'total'         	=> $subtotal,
								 'bill_address'		=> $billingAddress,
								 'ship_address'		=> $curshippingAddress,
								 'payment_response' => 'Null',
								 'payment_status'   => 'NOT PAID',
								 'transDate'		=> '0000-00-00',
								 'order_status'     => '1'
								);
			$ordinsrtid = $this->model_cart->insertData($orderarray,'el_customer_order');
			
			if(!empty($_SESSION['cartVal'])) {
		 
			foreach ($_SESSION['cartVal'] as $cartkey => $cartval)
			{
				$option_size 	= $_SESSION['cartVal'][$cartkey]['size'];					
					//$quantity 	 	= $_SESSION['cartVal'][$cartkey]['quantity'];
				if(!empty($_SESSION['cartVal'][$cartkey]['download'])){
				$option_meta  	= $_SESSION['cartVal'][$cartkey]['download'];	
				}
				else{
				$option_meta  	= "";	
				}
				
				$eventID		= $_SESSION['cartVal'][$cartkey]['eventID'];
				if(!empty($_SESSION['cartVal'][$cartkey]['imagesID'])){
				$mediaID		= $_SESSION['cartVal'][$cartkey]['imagesID'];
				}
				else{
				$mediaID		= 0;	
				}
				if(array_key_exists('dgimg_price',$_SESSION['cartVal'][$cartkey])){
					$digital_price1         = $_SESSION['cartVal'][$cartkey]['dgimg_price'];
				}
				else{
					$digital_price1         = '0';
				}
				$total_price=0;
				$price    	       	   	= $_SESSION['cartVal'][$cartkey]['size_price'];
				$quantity  		   		= $_SESSION['cartVal'][$cartkey]['quantity'];
				$finalp =0;
				$canvas_img='';
				
				if(array_key_exists('frmset',$_SESSION['cartVal'][$cartkey])){					
					$i=0; 
					foreach($_SESSION['cartVal'][$cartkey]['frmset'] as $key => $frame)
					{ 
						$qty  		   		= $frame['qnty'];
						$original_price 	= $_SESSION['cartVal'][$cartkey]['size_price']+$frame['frameprice'];
						$option_type   	 	= $frame['opsType'];
						$finalp        		= $frame['print_price']+$frame['frameprice'];
						$canvas_img	 		= $frame['img_val'];
						$prod_image			= $frame['imageName'];
						$totalprice  		= $finalp*$qty;
						$option_frame_name	= $frame['framename'];
						$i++;
						if(array_key_exists('dgimg_price',$_SESSION['cartVal'][$cartkey])){
							$digital_price = $_SESSION['cartVal'][$cartkey]['dgimg_price'];
						}
						else{
							$digital_price         = '0';
						}
						$orderdtlsarray = array(	'order_id'      => $ordinsrtid,
											'event_id'				=> $eventID,
											'media_id'				=> $mediaID,
											'order_img'				=> $prod_image,
											'canvas_img'			=> $canvas_img,
											'img_path'				=> $_SESSION['cartVal'][$cartkey]['fullPath'],
											'section'				=> $cartkey+1,
											'option_name'     		=> $option_type,
											'option_frame_name'     => $option_frame_name,
											'option_frame_collage'  => '',
											'option_meta_frame'     => $option_meta,
											'option_size'    		=> $option_size,
											'price'          		=> $finalp,
											'quantity'       		=> $qty,
											'total_price'    		=> $totalprice,
											'digital_price'         => $digital_price,
											'order_date' 			=> $cdate
						);
						$orddtlsinsrtid = $this->model_cart->insertData($orderdtlsarray,'el_customer_order_details'); 
					}				
					
				}
				if(array_key_exists('collage',$_SESSION['cartVal'][$cartkey])){
					$i=0; 
					
					foreach($_SESSION['cartVal'][$cartkey]['collage'] as $key => $collage){ 
						$qnty		  			= $collage['qnty'];
						$original_price 		= $collage['frameprice'];
						$finalp        			= $collage['print_price']+$collage['frameprice'];
						$prod_image				= $collage['imageName'];
						$canvas_img	 			= $collage['img_val'];
						$totalprice  			= $finalp*$qnty;
						$option_type    		= $collage['opsType'];
						if($collage['framename'] !=''){
							$option_frame_name	= $collage['framename'];
						}
						else{
							
							$option_frame_name	= '';
						}
						$option_frame_collage	= $collage['colgname'];
					$i++;
						if(array_key_exists('dgimg_price',$_SESSION['cartVal'][$cartkey])){
							$digital_price = $_SESSION['cartVal'][$cartkey]['dgimg_price'];
						}
						else{
							$digital_price         = '0';
						}				
					
					$orderdtlsarray = array('order_id'      		=> $ordinsrtid,
											'event_id'				=> $eventID,
											'media_id'				=> $mediaID,
											'order_img'				=> $prod_image,
											'canvas_img'			=> $canvas_img,
											'img_path'				=> $_SESSION['cartVal'][$cartkey]['fullPath'],
											'section'				=> $cartkey+1,
											'option_name'     		=> $option_type,
											'option_frame_name'     => $option_frame_name,
											'option_frame_collage'  => $option_frame_collage,
											'option_meta_frame'     => $option_meta,
											'option_size'    		=> $option_size,
											'price'          		=> $finalp,
											'quantity'       		=> $qnty,
											'total_price'    		=> $totalprice,
											'digital_price'         => $digital_price,
											'order_date' 			=> $cdate
						);
					$orddtlsinsrtid = $this->model_cart->insertData($orderdtlsarray,'el_customer_order_details');
					}
				}
				if(array_key_exists('print',$_SESSION['cartVal'][$cartkey])){	
					if(!empty($_SESSION['cartVal'][$cartkey]['print']) && $_SESSION['cartVal'][$cartkey]['print']=='onlyprint') {
					
						$all_images=explode('~',$_SESSION['cartVal'][$cartkey]['images']);
						if(!empty($all_images)){
							$i=0;	
							foreach($all_images as $imgkey =>  $images){
								
								$totalprice 	= $_SESSION['cartVal'][$cartkey]['dgimg_price'];
								$canvas_img     = $_SESSION['cartVal'][$cartkey]['imagePath'].'/'.$images;
								$prod_image		= $images;
								$option_type 	= 'Only Print';
								$qty			= $_SESSION['cartVal'][$cartkey]['quantity'];
								$i++;
								if(array_key_exists('dgimg_price',$_SESSION['cartVal'][$cartkey])){
									$digital_price = $_SESSION['cartVal'][$cartkey]['dgimg_price'];
								}
								else{
									$digital_price         = '0';
								}
								
							$orderdtlsarray = array('order_id'      => $ordinsrtid,
											'event_id'				=> $eventID,
											'media_id'				=> $mediaID,
											'order_img'				=> $prod_image,
											'canvas_img'			=> $canvas_img,
											'img_path'				=> $_SESSION['cartVal'][$cartkey]['fullPath'],
											'section'				=> $cartkey+1,
											'option_name'     		=> $option_type,
											'option_frame_name'     => '',
											'option_frame_collage'  => '',
											'option_meta_frame'     => $option_meta,
											'option_size'    		=> $option_size,
											'price'          		=> $finalp,
											'quantity'       		=> $qty,
											'total_price'    		=> $totalprice,
											'digital_price'         => $digital_price,
											'order_date' 			=> $cdate
							);
							$orddtlsinsrtid = $this->model_cart->insertData($orderdtlsarray,'el_customer_order_details');
							}
						}
						
					}
					else{
							
						$i      = 0;
						foreach($_SESSION['cartVal'][$cartkey]['print'] as $key => $print){
							$qty  		   	= $print['qnty'];
							$option_type    = $print['opsType'];
							$finalp			= $print['print_price'];
							$prod_image		= $print['imageName'];			
							$totalprice 	= $finalp*$qty;								
							$canvas_img	 	= $print['img_val'];
							$i++;				
							if(array_key_exists('dgimg_price',$_SESSION['cartVal'][$cartkey])){
								$digital_price = $_SESSION['cartVal'][$cartkey]['dgimg_price'];
							}
							else{
								$digital_price         = '0';
							}
						
						$orderdtlsarray = array(	'order_id'      => $ordinsrtid,
											'event_id'				=> $eventID,
											'media_id'				=> $mediaID,
											'order_img'				=> $prod_image,
											'canvas_img'			=> $canvas_img,
											'img_path'				=> $_SESSION['cartVal'][$cartkey]['fullPath'],
											'section'				=> $cartkey+1,
											'option_name'     		=> $option_type,
											'option_frame_name'     => '',
											'option_frame_collage'  => '',
											'option_meta_frame'     => $option_meta,
											'option_size'    		=> $option_size,
											'price'          		=> $finalp,
											'quantity'       		=> $qty,
											'total_price'    		=> $totalprice,
											'digital_price'         => $digital_price,
											'order_date' 			=> $cdate
							);
						$orddtlsinsrtid = $this->model_cart->insertData($orderdtlsarray,'el_customer_order_details');
						}
					}
				
				}
			}
			}
		}
		if(empty($ordinsrtid))
		{
			$ordinsrtid = '';
		}			
		$order_details = $this->model_cart->getOrderdetailsById($cid,$ordinsrtid);
		//print_r($order_details);

		if(!empty($order_details)){
			$bill_address = $order_details[0]['bill_address'];
			$shipping_address = $order_details[0]['ship_address'];
			
			$bill_address_Arr = explode('|',$bill_address);
			$ship_address_Arr = explode('|',$shipping_address);
			
			
				
				$this->data['billaddress']		= $bill_address_Arr;
				$this->data['shipaddress']		= $ship_address_Arr;
				$this->data['order_details']	= $order_details;
				
				
			
			//pr($this->data['order_details']);
			$this->data['customer_id']	= $cid;
			$this->data['order_id']		= $order_details[0]['order_id'];
		}
		else{
			$this->data['order_details']	='';
			$this->data['customer_id']	= '';
			$this->data['order_id']		= '';
		}
		$this->layout->view('templates/cart/checkout-confirm', $this->data);
	}
	
	
	/*public function removeProduct()
	{
		$recArr = array();
		$userID							= $this->data['userID'];
		
		$key = $this->input->post('product_key');
		if(array_key_exists($key, $_SESSION['Usercart']))
		{
			unset($_SESSION['Usercart'][$key]);
			$this->data['Usercart']	= $_SESSION['Usercart'];				
			//$recArr['HTML']			= $this->load->view('templates/cart/custom-ajax-cart', $this->data, true);
			$recArr['process']		= "success";
		}
		echo json_encode($recArr);
	}*/
	public function emptycart(){
	  unset($_SESSION['productArry']);  
	  unset($_SESSION['cartVal']);
	  redirect(base_url().'Favourite');  
	}
	/*public function removeProduct()
	{
	  $recArr = array();
	  $userID       = $this->data['userID'];
	  
	 $frame_key = $this->input->post('frame_key'); 
	 $cart_key = $this->input->post('cart_key');
	 $cart_type = $this->input->post('cart_type');
	  //echo $frame_key."###".$cart_key."###".$cart_type;
	  if($cart_type == 'collage' || $cart_type == 'frmset') {
		  unset($_SESSION['cartVal'][$cart_key][$cart_type][$frame_key]);
		  $count=count($_SESSION['cartVal'][$cart_key][$cart_type]);
		  if($count==0){
			 unset($_SESSION['cartVal'][$cart_key]); 
		  }
	  } else{
		 $all_images = explode('~',$_SESSION['cartVal'][$cart_key]['images']);
		 unset($all_images[$frame_key]);
		 unset($_SESSION['cartVal'][$cart_key]['print'][$frame_key]);
		 $images = implode('~',$all_images);
		 $_SESSION['cartVal'][$cart_key]['images']=$images;
		 $count=count($_SESSION['cartVal'][$cart_key]['images']);
		 if($count==0){
			 unset($_SESSION['cartVal'][$cart_key]); 
		  }
	  }
		  
	  $recArr['process']  = "success";
	  echo json_encode($recArr);
	}*/
	public function removeProduct()
	{
		$recArr = array();
		$userID       = $this->data['userID'];
	  
		$frame_key = $this->input->post('frame_key'); 
		$cart_key = $this->input->post('cart_key');
		$cart_type = $this->input->post('cart_type');
	  //echo $frame_key."###".$cart_key."###".$cart_type;
	  
		unset($_SESSION['cartVal'][$cart_key][$cart_type][$frame_key]);
		$count=count($_SESSION['cartVal'][$cart_key][$cart_type]);
		if($count==0){
		 unset($_SESSION['cartVal'][$cart_key]); 
		}	  
		  
		$recArr['process']  = "success";
		echo json_encode($recArr);
	}
	
	public function noteadd()
	{
		$recArr = array();
		$userID							= $this->data['userID'];
		$order_id                       = $this->input->post('id');
		$customer_note                  = $this->input->post('note');
		
		if(!empty($userID))
		{
			$condArr		= array("order_id" => $order_id, "customer_id" => $userID);
			$noteArr		= array(
									"customer_note" 	=> $customer_note
									);        
			
			$updateData	   = $this->model_basic->editdata($noteArr,"el_customer_order", $condArr);
			$recArr['process']		= "success";
		}
		else{
			$recArr['process']		= "fail";
		}
		echo json_encode($recArr);
	}
	
	/*public function checkout()
	{
		//pr($_SESSION);
		 foreach($_SESSION['Usercart'] as $key => $cartArray)
		{
			if($cartArray['option']['name'] = 'Canvas' && $cartArray['option']['name'] = 'Framing')
			{
				echo"<pre>";
				print_r($_SESSION['Usercart'][$key]['option']['meta']);
			}
			
		}
		die; 
		//pr($_SESSION,0);
		//unset($_SESSION['imageDecoration']);
		
		$this->data['contentTitle']				= 'Customer Cart';
		
		if(empty($_SESSION['Usercart']))
		{
			$_SESSION['Usercart'] 				= array();
		}
		$userID									= $this->data['userID'];
		$productDetails 						= $_SESSION['Usercart'];
		
		//echo"<pre>";print_r($his->data['productDetails']);die;	
		
		$this->layout->view('templates/cart/allproductcart-list', $this->data);
	}*/
	

	public function updateQuantity()
	{
		//pr($_POST);
		$recArr 									= array();
		
		$key 										= isset($_POST['key'])?$_POST['key']:'';
	    $hiddenprice 								= isset($_POST['hiddenprice'])?$_POST['hiddenprice']:'';
	    $textVal 									= isset($_POST['textVal'])?$_POST['textVal']:'';
		
	    $_SESSION['Usercart'][$key]['quantity'] 	= $textVal;
	    $_SESSION['Usercart'][$key]['price'] 		= $hiddenprice;
		
		
	    $recArr['process']  						= "success";
	   
	    echo json_encode($recArr);
		
		
		//$total = $total * $qres;
	}
	
	public function cancel() {
		$this->data['contentTitle']			= 'Customer Cart';
		$this->data['contentKeywords']		= '';
		$customer_id							= $this->session->userdata('customer_id');
		if(!empty($customer_id)){
			if(!empty($_SESSION['cart'])){
				$this->data['prodArr']		= $_SESSION['cartVal'];
			}
			else{
				
				$this->data['prodArr']		= '';
			}
			$this->layout->view('templates/cart/cancel-payment', $this->data);
		}
		else{
			redirect(base_url()."Login/");
			
		}
	}
	
	public function successPayment()
	{
		$infArr	= array();
		$this->data['contentTitle']			= 'Customer Cart';
		
		$this->data['get_all_events'] = $this->model_cart->getAllEvent();
		
		$paypalInfo    						= $_REQUEST;
		//pr($paypalInfo);
		if(!empty($paypalInfo))
		{
			$payment_response    			= json_encode($paypalInfo);
			//pr($payment_response);
		   
			$transDate  					= date("Y-m-d", strtotime(str_replace("/", "-", $paypalInfo['payment_date'])));
			
			if(empty($_SESSION['cartVal']))
			{
				$_SESSION['cartVal'] 				= array();
			}
			
			$this->data['prodArr']		= $_SESSION['cartVal'];
			//pr($this->data['prodArr']);
			$OrderArr	= array(
							"transDate"			=> $transDate,	
							"transaction_id" 	=> $paypalInfo["txn_id"],
							"payment_response" 	=> $payment_response,
							"payment_status" 	=> 'PAID',
							"total"			 	=> $paypalInfo["payment_gross"],							
							"order_status"     => '2'
							);
			$mass	= $this->model_cart->updateOrder($OrderArr, "el_customer_order", $paypalInfo["item_name"]);
			
			$customer_id					= $this->session->userdata('customer_id');
			
			$customer_details				= $this->model_cart->customerData($customer_id);
			if(!empty($customer_details)){
				
				$this->data['customer_name']		= $customer_details['customer_firstname'].''.$customer_details['customer_lastname'];
				$customer_email						= $customer_details['customer_email'];
			}
			else{
				
				$this->data['customer_details']		= '';
			}
			
			if(!empty($customer_id)){
				$ord_data	= $this->model_cart->getOrderdetailsSection($customer_id,$paypalInfo["item_name"]);
				
			}
			
			if(!empty($ord_data)){
				foreach($ord_data as $val){
					
					$order_details	= $this->model_cart->getOrderdetailsBySection($customer_id, $paypalInfo["item_name"],$sec);	
					if(!empty($order_details)){
						$infArr[$sec][]=	$order_details;
					}
					/*$this->data['order_details']		= $order_details;
					$orderNO							= $order_details[0]['order_no'];
					$this->data['orderNO']				= $orderNO;*/
				}
				
			}
			else{
				
				$this->data['order_details']		='';
			}
			
			if($mass){
					
					$this->load->library('email');
					$config['charset'] 		= 'iso-8859-1';
					$config['mailtype'] 	= 'html';
					$this->email->initialize($config);
					$this->email->from('no-reply@elevation.com', 'Elevation Photography');
					$this->email->to($customer_email);
					$this->email->subject('Payment Confirmation for your Elevation order '. $orderNO);
					//$this->layout->view('templates/cart/order-mailtocustomer',$this->data);
					$mailBody				= $this->load->view('templates/cart/order-mailtocustomer', $this->data, true);
					$this->email->message($mailBody);
					$this->email->send();
					
					//unset($_SESSION['cartVal']); 
					//unset($_SESSION['subtotal']);
					$this->layout->view('templates/cart/payment_success',$this->data); 
				}
				else{
					
					redirect(base_url()."cartAdd/billingCheckout");
					
				}
		}
		else{
			redirect(base_url()."cartAdd");
		}
	}
	
	public function downloadFile($attachment_name) {
        return force_download($attachment_name, NULL);
    }
	
	
	public function authorize_payment(){
  //pr($_REQUEST);
   $this->data['contentTitle']			= 'Customer Cart';
   $this->data['get_all_events'] = $this->model_cart->getAllEvent();
   $customer_id    	    		 = $this->session->userdata('customer_id');    
   $customer_details    		 = $this->model_cart->customerData($customer_id);
   
   if(!empty($customer_details)){
    $customer_firstname   	= $customer_details['customer_firstname'];
    $customer_lastname  	= $customer_details['customer_lastname'];
    $customer_mobile   		= $customer_details['customer_mobile'];
    $customer_email   		= $customer_details['customer_email'];
   }
    $orderID      = $_REQUEST['order_id'];

   $order_details     = $this->model_cart->allOrderDetails($customer_id,$orderID);
  
   if(!empty($order_details[0]['ship_address'])){   
   $shipaddrs     = explode('|',$order_details[0]['ship_address']);
   $shippingaddrs = $shipaddrs[0].','.$shipaddrs[1].','.$shipaddrs[2].','.$shipaddrs[3].','.$shipaddrs[4].','.$shipaddrs[5];
   
   }
   
   if(!empty($order_details[0]['bill_address'])){
    
    $billaddrs 	   = explode('|',$order_details[0]['bill_address']);
    $billingaddrs  = $billaddrs[0].','.$billaddrs[1].','.$billaddrs[2].','.$billaddrs[3].','.$billaddrs[4].','.$billaddrs[5];
    
   }
   if(!empty($order_details)){
    $bill_address     			 = $billingaddrs;
    $ship_address      			 = $shippingaddrs;    
    $orderNO          			 = $order_details[0]['order_no'];
    $this->data['orderNO']       = $orderNO;
    $product_id      			 = $order_details[0]['media_id'];
   }
   
   //pr($order_details);
   // developer accounts: https://test.authorize.net/gateway/transact.dll
   // for real accounts (even in test mode), please make sure that you are
   // posting to: https://secure.authorize.net/gateway/transact.dll
   //$post_url = "https://secure.authorize.net/gateway/transact.dll";
   $post_url = "https://test.authorize.net/gateway/transact.dll";
   $post_values = array(
    
    // the API Login ID and Transaction Key must be replaced with valid values
    //"x_login"   => "7jJ7N2e8", 
	"x_login"   => "82ymFC3a9f",
    //"x_tran_key"  => "3wF56hX4F75snE5A",
	"x_tran_key"  => "3jc4w7dFpAB437W9",
    "x_version"   => "3.1",
    "x_delim_data"  => "TRUE",
    "x_delim_char"  => "|",
    "x_relay_response" => "FALSE",
    "x_type"   => "AUTH_CAPTURE",
    "x_method"   => "CC",
    "x_card_num"  => "$_REQUEST[showcardno]", //4111111111111111
    "x_card_code"  => "$_REQUEST[txtcvv]",
    "x_exp_date"  => "$_REQUEST[expmnth]/$_REQUEST[expyear]", //0115
    "x_amount"   => "$_REQUEST[amount]",
    "x_invoice_num"  => "$_REQUEST[order_id]",
    "x_first_name"  => "$customer_firstname",
    "x_last_name"  => "$customer_lastname",
    "x_phone"   => "$customer_mobile",
    "x_email"   => "$customer_email",
    "x_address"   => "$bill_address",
    "x_ship_to_address" => "$ship_address"
   );
   //pr($post_values);
   // This section takes the input fields and converts them to the proper format
   // for an http post.  For example: "x_login=username&x_tran_key=a1B2c3D4"
   $post_string = "";
   foreach( $post_values as $key => $value )
    { $post_string .= "$key=" . urlencode( $value ) . "&"; }
   $post_string = rtrim( $post_string, "& " );

   // This sample code uses the CURL library for php to establish a connection,
   // submit the post, and record the response.
   // If you receive an error, you may want to ensure that you have the curl
   // library enabled in your php configuration
   $request = curl_init($post_url); // initiate curl object
    curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
    $post_response = curl_exec($request); // execute curl post and store results in $post_response
    // additional options may be required depending upon your server configuration
    // you can find documentation on curl options at http://www.php.net/curl_setopt
   curl_close ($request); // close curl object

   // This line takes the response and breaks it into an array using the specified delimiting character
   $response_array = explode($post_values["x_delim_char"],$post_response);
   //echo $post_response;
   //print_r($response_array);exit;
   if($response_array[0] == 1){
    $transDate      = date("Y-m-d");      
  
    $this->data['prodArr']  = $_SESSION['cartVal'];
    //pr($this->data['prodArr']);
    $OrderArr     = array(
             "transDate"   => $transDate, 
             "transaction_id"  => $response_array[6],
             "payment_response"  => $post_response,
             "total"     => $response_array[9],
             "payment_status" => 'PAID',
             "order_status"  => '2',
             ); 
    $mass      = $this->model_cart->updateOrder($OrderArr, "el_customer_order", $response_array[7]);

	
	            if(!empty($customer_details)){
				$this->data['customer_name']		= $customer_details['customer_firstname'].''.$customer_details['customer_lastname'];
				$customer_email						= $customer_details['customer_email'];
				}
				else{
					
					$this->data['customer_details']		= '';
				}
				if(!empty($customer_id)){
					$order_details = $this->model_cart->getOrderdetailsByOrder($customer_id,$response_array[7]);				
				}
				if(!empty($order_details)){
					
					$this->data['order_details']		= $order_details;
					
				}
				else{
					$this->data['order_details']		='';
				}	
				if(!empty($customer_id)){
					$ord_data = $this->model_cart->getOrderdetailsSection($customer_id,$response_array[7]);				
				}
			
				if(!empty($ord_data)){
					foreach($ord_data as $val){
						$sec = $val['section'];
						$order_details	= $this->model_cart->getOrderdetailsBySection($customer_id, $response_array[7],$sec);	
						if(!empty($order_details)){
							$infArr[$sec]=	$order_details;
						}
						/*$this->data['order_details']		= $order_details;
						$orderNO							= $order_details[0]['order_no'];
						$this->data['orderNO']				= $orderNO;*/
					}
					//pr($infArr,0);
					$this->data['orderDetails']			= $infArr;
					$orderNO							= $response_array[7];
					$this->data['orderNO']				= $orderNO;
					
					//copy order folder
					
					/*$imagePath 	= getcwd()."/uploads/1471422573_59_flowers-162v.jpg";
					$newPath 	= getcwd()."/lab/orders/".$orderNO."/".;		
					$newName  	= $newPath."SERIES"."__1471422573_59_flowers-162v.jpg";*/
				}
				else{
					
					$this->data['orderDetails']			= '';
				}
				if($mass){			
					
					$this->load->library('email');
					$config['charset'] 		= 'iso-8859-1';
					$config['mailtype'] 	= 'html';
					$this->email->initialize($config);
					$this->email->from('no-reply@elevation.com', 'Elevation Photography');
					$this->email->to($customer_email);
					$this->email->subject('Payment Confirmation for your Elevation order '. $orderNO);
					$mailBody				= $this->load->view('templates/cart/order-mailtocustomer', $this->data, true);
					$this->email->message($mailBody);
					$this->email->send();
					
					//unset($_SESSION['cartVal']); 
					//unset($_SESSION['subtotal']);
					$this->layout->view('templates/cart/payment_success',$this->data); 
				}
				else{
					
					redirect(base_url()."cartAdd/billingCheckout");
					
				}


	}
	else{
		$this->data['response_message']		=$response_array[3];
		$this->layout->view('templates/cart/cancel-payment',$this->data); 
	}
}	
	
	public function validCardNo(){
		
		$recArr	= array();
		$card_no	= $this->input->post('cardNo');
		$recArr['card_no'] = $card_no;
		global $type;

		$cardtype = array(
			"visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
			"mastercard" => "/^5[1-5][0-9]{14}$/",
			"amex"       => "/^3[47][0-9]{13}$/",
			"discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
		);

		if (preg_match($cardtype['visa'],$card_no))
		{
			$type= "visa";
			$recArr['process']  = "success";
			$recArr['cardtype']  =  'visa';
		
		}
		else if (preg_match($cardtype['mastercard'],$card_no))
		{
			$type= "mastercard";
			$recArr['process']  = "success";
			$recArr['cardtype']  =  'mastercard';
		}
		else if (preg_match($cardtype['amex'],$card_no))
		{
			$type= "amex";
			$recArr['process']  = "success";
			$recArr['cardtype'] =  'amex';
		
		}
		else if (preg_match($cardtype['discover'],$card_no))
		{
			$type= "discover";
			$recArr['process']  = "success";
			$recArr['cardtype'] =  'discover';
		}
		else
		{
			$recArr['process'] = 'failure';
		} 
		echo json_encode($recArr);
	}
	public function validCardCode(){
		
		$recArr	= array();
		$card_code				= $this->input->post('cardCode');
		$card_type				= $this->input->post('cardType');
		$recArr['card_code'] 	= $card_code;
		//echo $card_type."@@jhf@@".$card_code;
		if($card_type !='amex'){
			
			if (preg_match('/[0-9]{3}+/', $card_code) && strlen($card_code) == 3){
				
				$recArr['process']  = "success";
			
			}
			else{
				$recArr['process'] = 'failure';
				$recArr['card_type'] = $card_type;
			}
			
		}
		else{
			if (preg_match('/[0-9]{4}+/', $card_code) && strlen($card_code) == 4){
				
				$recArr['process']  = "success";
			}
			else{
				$recArr['process']  = "failure";
				$recArr['card_type'] = $card_type;
			}
			
		}
		echo json_encode($recArr);
	}
	
	public function storetoal(){
		
		$recArr	= array();
		$total				 = $this->input->post('total');
		$price				 = $this->input->post('price');
		$arraykey            = $this->input->post('arraykey');
		$key                 = $this->input->post('key');
		$cart_type           = $this->input->post('cartType');
		$qty                 = $this->input->post('qty');
		if($price !=''){

			//$_SESSION['subtotal']    = $total;
			if($cart_type	== 'frmset'){
				$allKeys 		= array_keys($_SESSION['cartVal'][$arraykey][$cart_type]);
				$key	 		= $allKeys[$key];
				$recArr['key']  = $key;
				$_SESSION['cartVal'][$arraykey][$cart_type][$key]['qnty']=$qty;
				$_SESSION['cartVal'][$arraykey][$cart_type][$key]['print_price']=$_SESSION['cartVal'][$arraykey]['size_price'];
				$_SESSION['cartVal'][$arraykey]['single_price'][$key]=$price;
			}
			else{
				$_SESSION['cartVal'][$arraykey][$cart_type][$key]['qnty']=$qty;
				$_SESSION['cartVal'][$arraykey][$cart_type][$key]['print_price']=$_SESSION['cartVal'][$arraykey]['size_price'];
				$_SESSION['cartVal'][$arraykey]['single_price'][$key]=$price;
			}
			$recArr['process']  = "success";
			//pr($_SESSION['cartVal'],0);
		
		}
		else{
			
				$recArr['process']  = "failure";
				
			}
			
	  echo json_encode($recArr);
	}
	/*public function download() { 
     
     $fileName 	 		= 'import/2017-09-29/mad/1200/Fitz/rafting-bali.jpg';	 
	 $downlode_img		= base_url().'upload/'.$fileName;
   if ($fileName) {
    //$file = realpath ( "download" ) . "\\" . $fileName;
	$file = $downlode_img;
    // check file exists    

     // get file content
	 $my_save_dir = 'images/';
	 $filename = basename($downlode_img);
	 $complete_save_loc = $my_save_dir . $filename;
     file_put_contents($complete_save_loc, file_get_contents($downlode_img));

   }
   else {
     // Redirect to base url
     redirect ( base_url () );
    }
 
  }*/
  public function download() {
	  
		$fileName		= $this->input->post('download_link');
		$file_path		= base_url().'uploads/'.$fileName;
		
		
		/*header( "Pragma: public" );
		header( "Expires: 0" );
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header( "Cache-Control: public" );
		header( "Content-Description: File Transfer" );
		header( "Content-type: application/image/jpg" );
		header( "Content-Disposition: attachment; filename=\"" . $fileName . "\"" );
		header( "Content-Transfer-Encoding: binary" );
		//header( "Content-Length: " . filesize( $file_path ) );

		readfile( $file_path );
		*/
		echo $file_path.','.$this->input->post('image_name');
  }
	
}

?>