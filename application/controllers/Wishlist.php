<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wishlist extends CI_Controller {

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
		$this->load->model(array('model_wishlist','model_cart'));
		$this->getClass 			= $this->router->fetch_class();
		$this->getMethod 			= $this->router->fetch_method();	
		$userID						= $this->data['userID'];
		if(empty($userID)) {
			redirect(base_url());
		}
		$this->layout->setLayout('inner_layout');	
	}
	
	public function chklogin(){
		$userID						= $this->data['userID'];
		
	}
	
	public function add($image_id = '') {		//$this->chklogin();
		
		$userID							= $this->data['userID'];
		$imgID							= $image_id;
		if(!empty($imgID) && is_numeric($imgID)) {
			
			$imageDetails				= $this->model_wishlist->getImgDetails($imgID);
			$_SESSION['wishlist'][$userID][$imgID][]	= $imageDetails;
		    $photographer_id=$imageDetails['photographer_id'];
			
			
			$insArr					= array(
													"user_id"		=> $userID,
													"image_id"		=> $imgID,
													"photographer_id"	=> $photographer_id	
													);
			$valid_user				= $this->model_basic->validWishlistAdd($userID,$imgID);
			
			if($valid_user == 0){
				$insID					= $this->model_basic->insdata($insArr, "el_wishlist");
			}
			
		}
		redirect(base_url()."wishlist/photolist/");	
	}
	
	public function photolist() {
		$userID								= $this->data['userID'];
		$this->data['contentTitle']			= 'Customer Wishlist';
		$this->data['contentKeywords']		= '';	
		$wishlistDetails			   		=  $this->model_wishlist->getwishlistDetails($userID);
		$this->data['wishlistDetails']	    =  $wishlistDetails;	
		$customer_id               			=  $this->session->userdata('customer_id');
	    $this->data['customer_id']			=  $customer_id;
		if(array_key_exists('wishlist', $_SESSION)) {
			if(count($_SESSION['wishlist'][$userID]) > 0) {
			$this->data['photoArr']				= $_SESSION['wishlist'];				
			} 
		} 
        $this->layout->view('templates/Wishlist/wishlist-list', $this->data);		
	}
	
	public function remove() {
		$recArr							= array();
		$userID							= $this->data['userID'];
		$imgID							= $this->input->post('image_id');
		if(!empty($imgID) && is_numeric($imgID)) {
			$wishlistDetails			   		=  $this->model_wishlist->getwishlistDetails($userID);
			$this->data['wishlistDetails']	    =  $wishlistDetails;	
			
			$customer_id               			=  $this->session->userdata('customer_id');
			$this->data['customer_id']			=  $customer_id;
			if(!empty($wishlistDetails)) {
				//unset($_SESSION['wishlist'][$userID][$imgID]);
				$condArr				= array("user_id" => $userID, "image_id" => $imgID); 
				$this->model_basic->deletedata("el_wishlist", $condArr);
				$recArr['process']		= "success";
				//$this->data['photoArr']	= $_SESSION['wishlist'];
				$wishlistDetails			   		=  $this->model_wishlist->getwishlistDetails($userID);
				$this->data['wishlistDetails']	    =  $wishlistDetails;					
				$recArr['HTML']			= $this->load->view('templates/Wishlist/ajax-wishlist-list', $this->data, true);
				//echo $recArr['process'];
				//$recArr['itemCnt']		= count($_SESSION['cart'][$userID]);
				$cntCart   = 0;
				 if(array_key_exists('cart', $_SESSION)) {
					   if(array_key_exists('event', $_SESSION['cart'])) {
						foreach($_SESSION['cart']['event'] as $key => $eventArr) {
						 foreach($eventArr as $j => $val) {
						  if(is_numeric($j)) {
						   $cntCart++;
						  }
						 }
						}
					   }
					   
					   if(array_key_exists('ind', $_SESSION['cart'])) {
						foreach($_SESSION['cart']['ind'] as $keyInd => $indArr) {
						 foreach($indArr as $k => $indval) {
						  if(is_numeric($k)) {
						   $cntCart++;
						  }
						 }
						}
					   }
				
				}
				$recArr['itemCnt']		=  $cntCart;
			} else {
				$recArr['process']		= "fail";
			}
		} else {
			$recArr['process']			= "blank";
		}
		//pr($recArr);
		
		echo json_encode($recArr);
	}
	
	
	public function cart() {
		$recArr							= array();
		$userID							= $this->data['userID'];
		$imgID							= $this->input->post('image_id');
		if(!empty($imgID) && is_numeric($imgID)) {
			$imageDetails				= $this->model_cart->getImgDetails($imgID);
			
			$cnt			= 0;
			$_SESSION['cart']['ind'][$cnt][$imgID][]	= $imageDetails;
			$_SESSION['cart']['ind'][$cnt]['price']		= $imageDetails['media_price'];
			$cntCart   = 0;
				 if(array_key_exists('cart', $_SESSION)) {
					   if(array_key_exists('event', $_SESSION['cart'])) {
						foreach($_SESSION['cart']['event'] as $key => $eventArr) {
						 foreach($eventArr as $j => $val) {
						  if(is_numeric($j)) {
						   $cntCart++;
						  }
						 }
						}
					   }
					   
					   if(array_key_exists('ind', $_SESSION['cart'])) {
						foreach($_SESSION['cart']['ind'] as $keyInd => $indArr) {
						 foreach($indArr as $k => $indval) {
						  if(is_numeric($k)) {
						   $cntCart++;
						  }
						 }
						}
					   }
				
				}
				$recArr['itemCnt']		=  $cntCart;
			//$recArr['itemCnt']		= count($_SESSION['cart'][$userID]);
			$recArr['msg']			= "Added to Cart";
			$recArr['process']			= "success";
		} else {
			$recArr['itemCnt']		= 0;
			$recArr['msg']			= "";
			$recArr['process']			= "fail";
		}
		//pr($_SESSION['cart']);
		echo json_encode($recArr);
	}
}

/* End of file Wishlist.php */
/* Location: ./application/controllers/Wishlist.php */	