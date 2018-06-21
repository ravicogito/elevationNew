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
		$this->load->model(array('model_cart','model_basic'));
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
		//pr($_SESSION);
		$this->data['contentTitle']				= 'Customer Cart';
		
		if(empty($_SESSION['Usercart']))
		{
			$_SESSION['Usercart'] 				= array();
			//$_SESSION['Usercart']['option'] 				= array();
		}
		$userID									= $this->data['userID'];
		$productDetails 						= $_SESSION['Usercart'];
		
		//echo"<pre>";print_r($his->data['productDetails']);die;	
		
		$this->layout->view('templates/cart/cart-checkout', $this->data);
		
		
	}
	
	public function billingCheckout()
	{
		$this->data['contentTitle']				= 'Customer Cart';
		
		$cid 				= $this->session->userdata('customer_id');
		$this->data['billAddressArr'] 	= $this->model_cart->getBillInfo($cid);
		
		$this->layout->view('templates/cart/billing-checkout', $this->data);
	}
	
	public function entryOrder()
	{
		$this->data['contentTitle']				= 'Customer Cart';
		
		$cid 				= $this->session->userdata('customer_id');
		$curBillAdd			= trim($this->input->post('newbilladdr'));
		$curBillName		= trim($this->input->post('billing_name'));
		$curBillEmail		= trim($this->input->post('billing_email'));
		$curBillMobile		= trim($this->input->post('billing_mobile'));
		
		$curshippingAdd		= trim($this->input->post('newshipaddr'));
		$curshippingName	= trim($this->input->post('shipping_name'));
		$curshippingEmail	= trim($this->input->post('shipping_email'));
		$curshippingMobile	= trim($this->input->post('shipping_mobile'));
		
		$billingArr = array($curBillName,$curBillAdd,$curBillEmail,$curBillMobile);
		
		$shippingingArr = array($curshippingName,$curshippingAdd,$curshippingEmail,$curshippingMobile);
		
		
		
		$billingAddress = implode('|',$billingArr);
		
		$curshippingAddress = implode('|',$shippingingArr);
		
		
		//echo"<pre>";print_r($implode);die;
		//echo $curBillAdd;die;
		if(!empty($curBillAdd) && !empty($curshippingAdd))
		{
			$newAddBillarray = array('customer_id'   => $cid,
									 'address'       => $billingAddress,
									 'address_type'  => 'billing'
								);
			$newAddShiparray = array('customer_id'   => $cid,
									 'address'       => $curshippingAddress,
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
								 'payment_status'   => 'NO',
								 'transDate'		=> '0000-00-00',
								 'order_status'     => '1'
								);
			$ordinsrtid = $this->model_cart->insertData($orderarray,'el_customer_order');
			
			 if(!empty($_SESSION['Usercart'])) {
				 $cartArray = $_SESSION['Usercart']; 
				 foreach ($cartArray as $key => $cartval)
				 {
					 
					$option_name = $cartArray[$key]['option']['name'];					 
					if($option_name =='Framing'){
						$frame_name = $cartArray[$key]['option']['meta']['frame_name'];
					}
					else{
						$frame_name = '';						
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

					$canvas_img	 	= $cartArray[$key]['cur_img'];	
					$prod_image	 	= str_replace("-200_200", "", $imgArr[0]).".".$imgArr[1];	
					$option_size 	= $cartArray[$key]['size'];					
					$quantity 	 	= $cartArray[$key]['quantity'];
					$price 			= ($cartArray[$key]['price']/$quantity);
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
		}
		$this->layout->view('templates/cart/checkout-confirm', $this->data);
	}
	
	
	public function removeProduct()
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
	    $_SESSION['Usercart'][$key]['price'] 		= $textVal*$hiddenprice;
		
		
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
							"payment_status" 	=> $paypalInfo["payment_status"],
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
					$this->email->subject('Payment Confirmation mail for your Elevation order no'. $orderNO);
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
}

?>