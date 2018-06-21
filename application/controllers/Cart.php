<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cart extends CI_Controller {

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
		$this->load->model(array('model_cart','model_basic'));
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
	
	public function eventadd($event_id = '') {		//$this->chklogin();
		$userID									= $this->data['userID'];
		if(!empty($event_id) && is_numeric($event_id)) {
			//$_SESSION['cart']['event_id']		= $event_id;
			$event_price						= $this->model_cart->getEventPrice($event_id);
			//$_SESSION['cart']['event_price']	= $event_price;
			$allimages							= $this->model_cart->getallImages($event_id);
			
			foreach($allimages as $allimage) 
			{
				$imgID						= $allimage['media_id'];
				$this->add($imgID, $event_id);
			}
			$_SESSION['cart']['event'][$event_id]['price']	= $event_price;	
		}
		
		redirect(base_url()."cart/checkout/");	
	}
	
	
	public function add($image_id = '', $event_id = '') {		//$this->chklogin();
		
		$userID							= $this->data['userID'];
		$imgID							= $image_id;
		if(!empty($imgID) && is_numeric($imgID)) {
			
			$imageDetails				= $this->model_cart->getImgDetails($imgID);			
		}
		//pr($imageDetails);
		if(!empty($event_id) && is_numeric($event_id)) {
			$_SESSION['cart']['event'][$event_id][$imgID][]	= $imageDetails;
			return true;
		} else {
			if(array_key_exists('ind', $_SESSION['cart'])) {
				$cnt			= count($_SESSION['cart']['ind']);
			} else {
				$cnt			= 0;
			}
			
			$_SESSION['cart']['ind'][$cnt][$imgID][]	= $imageDetails;
			$_SESSION['cart']['ind'][$cnt]['price']		= $imageDetails['media_price'];
			redirect(base_url()."cart/checkout/");	
		}
	}
	
	public function checkout() {
		//unset($_SESSION['cart']['ind'][1]);
		//pr($_SESSION['cart'],0);
		$userID								= $this->data['userID'];
        $this->data['customer_id']			= $userID;
		$this->data['contentTitle']			= 'Customer Cart';
		$this->data['contentKeywords']		= '';		
		if(array_key_exists('cart', $_SESSION)) {
			if(count($_SESSION['cart']) > 0) {
				$price					= 0;
				if(array_key_exists('event', $_SESSION['cart'])) {
					
					foreach($_SESSION['cart']['event'] as $key => $val) {
						$price				+= $val['price'];
					}			
				}
				
				if(array_key_exists('ind', $_SESSION['cart'])) {
					
					foreach($_SESSION['cart']['ind'] as $key => $val) {
						$price				+= $val['price'];
					}			
				}
				$this->data['price']				= $price;
				$this->data['photoArr']				= $_SESSION['cart'];
			} 
			//pr($this->data['photoArr'],0);
		} 
       $this->layout->view('templates/cart/cart-list', $this->data);		
	}
	
	public function clear(){
		unset($_SESSION['cart']);
	}
	
	public function remove() {
		$recArr							= array();
		$userID							= $this->data['userID'];
		$this->data['customer_id']		= $userID;
		$imgType						= $this->input->post('img_type');
		$eventId						= $this->input->post('event_id');
		$imgID							= $this->input->post('image_id');
		if(!empty($imgID) && is_numeric($imgID)) {
			if(array_key_exists($imgType, $_SESSION['cart'])) {				
				if($imgType == 'ind') {
					unset($_SESSION['cart'][$imgType][$eventId]);
				} else {
					//unset($_SESSION['cart'][$imgType][$eventId][$imgID]);
					unset($_SESSION['cart'][$imgType][$eventId]);
				}
				$recArr['process']		= "success";
				$price					= 0;
				if(array_key_exists('event', $_SESSION['cart'])) {
					
					foreach($_SESSION['cart']['event'] as $key => $val) {
						$price				+= $val['price'];
					}			
				}
				if(array_key_exists('ind', $_SESSION['cart'])) {
					
					foreach($_SESSION['cart']['ind'] as $key => $val) {
						$price				+= $val['price'];
					}			
				}
				$this->data['price']				= $price;
				$this->data['photoArr']	= $_SESSION['cart'];				
				$recArr['HTML']			= $this->load->view('templates/cart/ajax-cart-list', $this->data, true);
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
		echo json_encode($recArr);
	}
	
	public function saveCart() {
		$recArr									= array();
		$userID									= $this->data['userID'];		
		$imgArr									= explode("_", $this->input->post('image_id'));
		$imgID									= $imgArr[2];
		$imgType								= $imgArr[0];
		$eventId								= $imgArr[1];
		$txtCaption								= $this->input->post('txtcaption');
		$eventType								= $this->input->post('event_type');
		$locationID								= $this->session->userdata('location_id');
		if(!empty($imgID) && is_numeric($imgID)) {
			//if(array_key_exists($userID, $_SESSION['cart'])) {
				if($eventType == "blur") {					
					$_SESSION['cart'][$imgType][$eventId][$imgID][0]['caption']	= $txtCaption;
					$recArr['process']			= "success";
				} else {
					$condition					= "user_id = '$userID' AND img_type = '$imgType' AND event_id = '$eventId' AND image_id = '$imgID'";
					$cnt						= $this->model_basic->isRecordExist('cart_temp', $condition);
					if($cnt > 0) {
						$recArr['process']		= "success";
					} else {
						$cartData				= serialize($_SESSION['cart'][$imgType][$eventId][$imgID]);
						$createdOn				= date("Y-m-d");
						
						$insArr					= array(
													"user_id"		=> $userID,
													"img_type"		=> $imgType,
													"event_id"		=> $eventId,
													"image_id"		=> $imgID,
													"cart_data"		=> $cartData,
													"created_on"	=> $createdOn	
													);
						$insID					= $this->model_basic->insdata($insArr, "cart_temp");

					    				
						if($insID) {
							$recArr['process']	= "success";
						} else {
							$recArr['process']	= "not_inserted";
						}	
					}
				}		
			/*} else {
				$recArr['process']				= "fail";
			}*/
		} else {
			$recArr['process']					= "blank";
		}
		echo json_encode($recArr);
	}
	
	public function success() {	
		$paypalInfo    							= $_REQUEST;	    
	    $payment_response    					= json_encode($paypalInfo);
		pr($payment_response);
	   
		$transDate  							= date("Y-m-d", strtotime(str_replace("/", "-", $paypalInfo['payment_date'])));

        
		$userID								= $this->data['userID'];	
		//$locationID							= $this->session->userdata('location_id');
		$this->data['contentTitle']			= 'Customer Cart';
		$this->data['contentKeywords']		= '';
		if(array_key_exists('cart', $_SESSION)) {
			if(count($_SESSION['cart']) > 0) {
				$price					= 0;
				if(array_key_exists('event', $_SESSION['cart'])) {
					$purchase_status        = "Bulk";  
		
				}
				if(array_key_exists('ind', $_SESSION['cart'])) {
					$purchase_status        = "Individual";
	
				}
				
				//$this->data['price']				= $price;
				$this->data['photoArr']				= $_SESSION['cart'];
    			$orderDate					= date("Y-m-d H:i:s");
				$OrderArr					= array(
											"order_datetime"	=> $transDate,
											"customer_id"		=> $paypalInfo["custom"],
											"transaction_id" 	=> $paypalInfo["txn_id"],
											"payment_response" 	=> $payment_response,
											"payment_status" 	=> 'Yes',
											"total"			 	=> $paypalInfo["payment_gross"],
											"purchase_status"	=> $purchase_status,
											"order_status"		=> '2'
											);        
			
				$insID					= $this->model_basic->insdata($OrderArr, "el_order");
				$user_unique_id			= $this->generateUniqueID($insID);
                $condArr				= array("order_id" => $insID);
				$editArray     			= array(
											"order_no" 		=> $user_unique_id,
											);
				$this->model_basic->editdata($editArray,"el_order", $condArr);
				//pr($_SESSION['cart']);
                foreach($_SESSION['cart'] as $key => $eventArr) {
					foreach($eventArr as $j => $val) {
					  foreach($val as $i => $valimg) {
                        if(is_numeric($i)) {   						  
				       
					$condArr						= array("user_id" => $userID, "image_id" => $i);
					$this->model_basic->deletedata("cart_temp", $condArr);
					$insDetailsArr[]     = array(
											"order_id" 		=> $insID,
											"image_id"		=> $i,
											"event_id"		=> $j 
											);
						}					
					  }						
					}
				}
				
				$this->db->insert_batch('el_orderdetails', $insDetailsArr); 
                $this->data['total']				= $paypalInfo["payment_gross"];
				
				
			$this->load->library('email');
			$config['charset'] 		= 'iso-8859-1';
			$config['mailtype'] 	= 'html';
			$this->email->initialize($config);
			$this->email->from('no-reply@elevation.com', 'Elevation Photography');
			$this->email->to('ruma.khan@cogitosoftware.in');
			$this->email->subject('Order Details');
			$mailBody				= $this->load->view('templates/cart/order-mail', $this->data, true);
            $this->email->message($mailBody);
			$this->email->send(); 			
			
			}
            unset($_SESSION['cart']);
			$this->layout->view('templates/cart/success-payment', $this->data);   			
			
		} else{
			redirect(base_url()."profile/myaccount/");
		} 
		
		
		
		
		
		
		/*if(array_key_exists('cart', $_SESSION)) {
			if(count($_SESSION['cart'][$userID]) > 0) {
				//pr($_SESSION['cart'],0);
				if(array_key_exists('event_id', $_SESSION['cart'])) {
				$event_id 					= $_SESSION['cart']['event_id'];
					if(!empty($event_id)){
						$purchase_status        = "Bulk";    
					}
					else{
						$purchase_status        = "Individual";
					}
				}
				else{
					$purchase_status        = "Individual";
				}
				
                $this->data['photoArr']		= $_SESSION['cart'];	 				
				$orderDate					= date("Y-m-d H:i:s");
				$OrderArr					= array(
											"order_datetime"	=> $transDate,
											"customer_id"		=> $paypalInfo["custom"],
											"transaction_id" 	=> $paypalInfo["txn_id"],
											"payment_response" 	=> $payment_response,
											"payment_status" 	=> $paypalInfo["payment_status"],
											"total"			 	=> $paypalInfo["payment_gross"],
											"purchase_status"	=> $purchase_status,
											);        
			//pr($OrderArr);
				$insID					= $this->model_basic->insdata($OrderArr, "el_order");
				$user_unique_id			= $this->generateUniqueID($insID);
                $condArr				= array("order_id" => $insID);
				$editArray     			= array(
											"order_no" 		=> $user_unique_id,
											);
				$this->model_basic->editdata($editArray,"el_order", $condArr);				

				foreach($_SESSION['cart'][$userID] as $key => $val) {
				
					$condArr						= array("user_id" => $userID, "image_id" => $key);
					$this->model_basic->deletedata("cart_temp", $condArr);
					$insDetailsArr[]     = array(
											"order_id" 		=> $insID,
											"image_id"		=> $key,
											"event_id"		=> $val[0]['event_id']
											);
					
				}
				$this->db->insert_batch('el_orderdetails', $insDetailsArr);
				if(!empty($_SESSION['cart']['event_price'])){
					  $this->data['total'] = $_SESSION['cart']['event_price']; }
					else {
						$this->data['total'] = $_SESSION['cart']['total']; }

				unset($_SESSION['cart']);
				$this->layout->view('templates/cart/success-payment', $this->data);
			} else{
				redirect(base_url()."profile/myaccount/");
			}
		} else{
			redirect(base_url()."profile/myaccount/");
		}*/
		
	}
	
	public function cancel() {
		$this->data['contentTitle']			= 'Customer Cart';
		$this->data['contentKeywords']		= '';
		$locationID							= $this->session->userdata('location_id');
		$userID								= $this->data['userID'];	
		/*if(array_key_exists('cart', $_SESSION)) {
			if(count($_SESSION['cart'][$userID]) > 0) {
				
			} 			
		}*/ 
		$this->layout->view('templates/cart/cancel-payment', $this->data);
	}
	
		
	function ipn() {      
	    $paypalInfo    							= $_REQUEST;	    
	    $payment_response    					= json_encode($paypalInfo);
	   
	    $transDate  							= date("Y-m-d", strtotime(str_replace("/", "-", $paypalInfo['payment_date'])));

        $this->data['user_id']      			= $paypalInfo["cm"];
        $this->data['transaction_id']      		= $paypalInfo["tx"];
        $this->data['payment_amount']    		= $paypalInfo["amt"];
	  	$this->data['payment_date']    			= $transDate;
	  	$this->data['payment_response']   		= $payment_response;
        $this->data['payment_type']    			= 'coupon';
        $this->data['payment_status']     		= $paypalInfo["payment_status"];
             
        $paypalURL         						= $this->paypal_lib->paypal_url;        
        $result            						= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);

        //check whether the payment is verified
        if(preg_match("/VERIFIED/i",$result)){
            //insert the transaction data into the database
            //$this->model_registration->insertTransaction($this->data);
        }
    }
	
	function order(){
		$this->data['contentTitle']			= 'Customer Order';
		$this->data['contentKeywords']		= '';		
		$orderImg                       =  array();	
		$customer_id               		=  $this->session->userdata('customer_id');
		$this->data['customer_id']		=  $customer_id;
		$config 						= array();
		$config['total_rows'] 			= $this->model_cart->getAllOrderDetails($customer_id);
		$config['base_url'] = base_url() . 'cart/order/';	
		$config["per_page"] = 5;
	    $config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
		$orderDetails			   		=  $this->model_cart->getOrderDetails($customer_id,$config["per_page"], $page);
		$this->data['links'] = $this->pagination->create_links();
		
		$this->data['orderDetails']		=  $orderDetails;
		if(!empty($orderDetails)){
			foreach($orderDetails as $key => $order)
			{
			 $orderImage			   		=  $this->model_cart->getOrderImgDetails($order['order_id'],$customer_id);
			 $orderImgDetails[$order['order_id']]  	= $orderImage;
				 
			}
			$this->data['orderImgDetails']		    =  $orderImgDetails;
			
		}
		//$user_unique_id						= $this->generateUniqueID($order['order_id']);
		//$this->data['user_unique_id']		    =  $user_unique_id;
		/*$customerOrderDetails			   		=  $this->model_cart->customerOrderDetails($customer_id,$config["per_page"], $page);
		if(!empty($customerOrderDetails)){
			
			$this->data['customerOrderDetails']	= $customerOrderDetails;
			
		}*/
		//pr($customerOrderDetails);exit;
		$this->layout->view('templates/Profile/order',$this->data);		
	}
	
	function orderdetails($order_id = '')
	{
		$this->data['contentTitle']			= 'Customer Order';
		$this->data['contentKeywords']		= '';
		$customer_id    	    		 	= $this->session->userdata('customer_id');
		$get_all_events 					= $this->model_cart->getAllEvent();
		if(!empty($get_all_events)){
			$this->data['get_all_events'] 	= $get_all_events;
		}
		else{
			$this->data['get_all_events'] 	= '';
		}
		if(!empty($customer_id)){
			$order_details = $this->model_cart->getOrderdetailsByOrder($customer_id,$order_id);				
		}
		if(!empty($order_details)){
			
			$this->data['order_details']		= $order_details;
			
		}
		else{
			$this->data['order_details']		='';
		}	
		if(!empty($customer_id)){
			$ord_data = $this->model_cart->getOrderdetailsSection($customer_id,$order_id);				
		}
	
		if(!empty($ord_data)){
			foreach($ord_data as $val){
				$sec = $val['section'];
				$order_details	= $this->model_cart->getOrderdetailsBySection($customer_id, $order_id,$sec);	
				if(!empty($order_details)){
					$infArr[$sec]=	$order_details;
				}
				/*$this->data['order_details']		= $order_details;
				$orderNO							= $order_details[0]['order_no'];
				$this->data['orderNO']				= $orderNO;*/
			}
			//pr($infArr,0);
			$this->data['orderDetails']			= $infArr;
			//$orderNO							= $response_array[7];
			//$this->data['orderNO']				= $orderNO;
		}
		else{
			
			$this->data['orderDetails']		='';
		}
		
		//$this->data['orderDetails']   = $this->model_cart->listOrderdetails($order_id);
		
		$this->layout->view('templates/Profile/order_details',$this->data);
	}
	
	private function generateUniqueID($orderID, $uniqueID = '') {
		$uniqueID			.= "ELEV";
		for($i = 0; $i < (4-strlen($orderID)); $i++) {
			$uniqueID			.= "0";
		}
		$uniqueID				.= $orderID;
		
		return $uniqueID;
	}
    
}

/* End of file Cart.php */
/* Location: ./application/controllers/cart.php */