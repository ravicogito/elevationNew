<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CartAdd_s extends CI_Controller {
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
			
		
		if(!empty($_SESSION['cartVal']))
		{
			$event_id 							= $_SESSION['cartVal']['eventID'];
			$event_details				 	    = $this->model_cart->getImgEventDetails($event_id);
			//pr($event_details,0);
			foreach($event_details as $events){
				//echo $events['event_type'];
				if($events['event_type'] == 'rafting') {
				$this->data['image_path']      = base_url().'uploads/import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'];
				$_SESSION['cartVal']['image_path']	= $this->data['image_path'];
				
				$this->data['fullPath'] 	   = 'import/'.$events['event_date'].'/'.$events['raftingcompany_name'].'/'.$events['event_time'].'/'.$events['event_name'].'/';
				
				$_SESSION['cartVal']['fullPath']	= $this->data['fullPath'];
				
				}
				else{
				$mainCatName			       = $events['cat_name'];
				$photographer				   = $events['photographer_name'];				
				$this->data['image_path']      = base_url().'uploads/'.$mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'];
				
				$_SESSION['cartVal']['image_path']	= $this->data['image_path'];
				
				
				$this->data['fullPath']		   = $mainCatName.'/'.$events['event_date'].'/'.$photographer.'/'.$events['event_name'].'/';

				$_SESSION['cartVal']['fullPath']	= $this->data['fullPath'];				
					
				}
			}
			 
			
			
		} else {

		}
		$userID									= $this->data['userID'];
		$productDetails 						= $_SESSION['cartVal'];
		
		
		$this->layout->view('templates/cart/cart-checkout_s', $this->data);
		
		
		
		/*if(empty($_SESSION['Usercart']))
		{
			$_SESSION['Usercart'] 				= array();
		} else {

		}
		$userID									= $this->data['userID'];
		$productDetails 						= $_SESSION['Usercart'];
		
		
		$this->layout->view('templates/cart/cart-checkout', $this->data);*/
		
		
	}
	
	public function billingCheckout()
	{
		$this->data['contentTitle']				= 'Customer Cart';
		
		$cid 				= $this->session->userdata('customer_id');
		$this->data['billAddressArr'] 	= $this->model_cart->getBillInfo($cid);
		
		$this->data['countrylists'] 	= $this->model_cart->getCountrylist();
		
		//echo"<pre>";print_r($this->data['countrylists']);die;
		
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
			
			 if(!empty($_SESSION['Usercart'])) {
				 $cartArray = $_SESSION['Usercart']; 
				 foreach ($cartArray as $key => $cartval)
				 {
					 
					$option_name = $cartArray[$key]['option']['name'];					 
					if($option_name =='Framing' && !empty($cartArray[$key]['option']['meta'])){
						$frame_name = $cartArray[$key]['option']['meta']['frame_name'];
					}
					else{
						$frame_name = 'No Meta';						
					}
					if(!empty($cartArray[$key]['option']['meta']['top']['mat_name'])){
						$topmat_name = $cartArray[$key]['option']['meta']['top']['mat_name'];
					}
					else{
						$topmat_name = '';
					}
					
					if(!empty($cartArray[$key]['option']['meta']['middle']['mat_name'])){
						$middlemat_name = $cartArray[$key]['option']['meta']['middle']['mat_name'];
					}
					else{
						$middlemat_name = '';
					}
					if(!empty($cartArray[$key]['option']['meta']['bottom']['mat_name'])){
						$bottommat_name = $cartArray[$key]['option']['meta']['bottom']['mat_name'];
					}
					else{
						$bottommat_name = '';
					}
					$imgArr			= explode(".",$cartArray[$key]['img_name']);
					
					if($option_name == 'collage')
					{
						$prod_image_arrays	 	= explode(',',$cartArray[$key]['img_name']);
						$prod_image = array();
						foreach($prod_image_arrays as $prod_image_array)
						{
							$explode_imgArr			= explode(".",$prod_image_array);
							
							$str_prod_image[]			= str_replace("-200_200", "", $explode_imgArr[0]).".".$explode_imgArr[1];
							$prod_image 				= implode(',',$str_prod_image);
						}
					}
					else{
						$prod_image	 	= str_replace("-200_200", "", $imgArr[0]).".".$imgArr[1];
					}
					
					$canvas_img	 	= $cartArray[$key]['cur_img'];	
					$option_size 	= $cartArray[$key]['size'];					
					$quantity 	 	= $cartArray[$key]['quantity'];
					$price 			= ($cartArray[$key]['price']);
					$totalprice  	= $quantity * $price;
					
					$eventID		= $cartArray[$key]['event'];
					$mediaID		= $cartArray[$key]['media'];

					 $orderdtlsarray = array(	'order_id'       		=> $ordinsrtid,
												'event_id'				=> $eventID,
												'media_id'				=> $mediaID,
												'order_img'				=> $prod_image,
												'canvas_img'			=> $canvas_img,
												'img_path'				=> $cartArray[$key]['img_path'],
												'option_name'     		=> $option_name,
												'option_meta_frame'     => $frame_name,
												'option_top_mat'     	=> $topmat_name,
												'option_bottom_mat'     => $bottommat_name,
												'option_middle_mat'     => $middlemat_name,
												'option_size'    		=> $option_size,
												'price'          		=> $price,
												'quantity'       		=> $quantity,
												'total_price'    		=> $totalprice,
												'order_date' 			=> $cdate
						);
					//pr($orderdtlsarray);
					$orddtlsinsrtid = $this->model_cart->insertData($orderdtlsarray,'el_customer_order_details'); 
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
	
	public function removeProduct()
	{
		$recArr = array();
		$userID							= $this->data['userID'];
		
		$key = $this->input->post('product_key');
		$cartVal = explode('-',$_SESSION['cartVal']['images']);
		if(array_key_exists($key, $cartVal))
		{
			unset($cartVal[$key]);
			$cartValArr = implode('-',$cartVal);
			$_SESSION['cartVal']['images']  = $cartValArr;
			$this->data['cartVal']	= $_SESSION['cartVal']['images'];				
			$recArr['process']		= "success";
		}
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
				$this->data['prodArr']		= $_SESSION['Usercart'];
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
		$this->data['contentTitle']			= 'Customer Cart';
		
		$this->data['get_all_events'] = $this->model_cart->getAllEvent();
		
		$paypalInfo    						= $_REQUEST;
		//pr($paypalInfo);
		if(!empty($paypalInfo))
		{
			$payment_response    			= json_encode($paypalInfo);
			//pr($payment_response);
		   
			$transDate  					= date("Y-m-d", strtotime(str_replace("/", "-", $paypalInfo['payment_date'])));
			
			if(empty($_SESSION['Usercart']))
			{
				$_SESSION['Usercart'] 				= array();
			}
			
			$this->data['prodArr']		= $_SESSION['Usercart'];
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
				$order_details	= $this->model_cart->getOrderdetailsByOrder($customer_id, $paypalInfo["item_name"]);			
			}
			
			if(!empty($order_details)){
				$this->data['order_details']		= $order_details;
				$orderNO							= $order_details[0]['order_no'];
				$this->data['orderNO']				= $orderNO;
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
					
					unset($_SESSION['Usercart']); 
					unset($_SESSION['subtotal']);
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
   //pr($order_details);
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
  
    $this->data['prodArr']  = $_SESSION['Usercart'];
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
				$order_details	= $this->model_cart->getOrderdetailsByOrder($customer_id, $orderID);			
			    }
			
				if(!empty($order_details)){
					$this->data['order_details']		= $order_details;
					$orderNO							= $order_details[0]['order_no'];
					$this->data['orderNO']				= $orderNO;
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
					$mailBody				= $this->load->view('templates/cart/order-mailtocustomer', $this->data, true);
					$this->email->message($mailBody);
					$this->email->send();
					
					unset($_SESSION['Usercart']); 
					unset($_SESSION['subtotal']);
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
	
}

?>