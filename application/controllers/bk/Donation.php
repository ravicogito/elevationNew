<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donation extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('user_id') =='') {
			redirect(base_url());
		}
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration', 'model_submission', 'model_coupon', 'model_home'));	
		$this->data['home_banner']					= $this->model_home->getBanner();		
		$this->data['themePath'] 			= $this->config->item('theme');
	}
	
	public function index() {
	// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK	
		
		$this->data['event_lists']			= $this->model_submission->listEvents();
		$this->data['latest_event_lists']			= $this->model_submission->latestEvents();
	
       
          $user_id = $this->session->userdata('user_id'); 
		//$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsByID($user_id);
		

		$this->data['userDetails']    = $userDetails;
		//echo "<pre>";
		//print_r($this->data['userDetails']); 
		//echo "</pre>";
		$proposer_id = $userDetails['proposer_id'];

		$ucond							  = "user_unique_id = '$proposer_id'";
		$proposerDetails				  = $this->model_submission->getProposerDetails($ucond);
		$this->data['proposerDetails']    = $proposerDetails;
		#################### NEXT RENEWAL DATE CALCULATION ###########
          $user_package_id = $userDetails['user_package_id']; 
		  $userPackage							= $this->model_submission->getPackageDetails($user_package_id);
		  $this->data['package_details']		= $userPackage;
          $allow_array = array(1,3); 
          if(in_array($user_package_id, $allow_array)){
            $getNextRenewalDetailsArray = $this->model_submission->getNextRenewalDetails($user_id);
            
            $this->data['getNextRenewalDetailsArray']    = $getNextRenewalDetailsArray;
        }
        else{
        	$this->data['getNextRenewalDetailsArray']    = array();
        }
		#################### END OF REVEWAL DATE CALCULATION ########
		
		$this->elements['contentHtml']           	= $this->data['themePath'].'donation/add';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
	}	
		

	


	private function templateView(){		
		$this->templatelayout->seo();
		$this->templatelayout->header_inner();
		$this->templatelayout->footer();
		$this->templatelayout->multiple_view($this->elements,$this->elements_data);
	}	
	


	function ccavRequestHandler(){
       
        ######################
		$data = $this->input->post();
		//echo "<pre>";
		//print_r($data);
       // echo "</pre>";
        //exit;
		$merchant_data='';
		//$working_key='';//Shared by CCAVENUES
		//$access_code='';//Shared by CCAVENUES

		$working_key= 'B308AEA75B4CC1353F0F9E7047037FD7';//Shared by CCAVENUES
		$access_code='AVKX64DD86BA05XKAB';//Shared by CCAVENUES
	
		foreach ($data as $key => $value){
			$disallow_array = array('name','child_dob');
			if(!in_array($key, $disallow_array)){
				$merchant_data.=$key.'='.$value.'&';
			}
			
		}
        //echo $merchant_data; exit;

		$encrypted_data=$this->encrypt($merchant_data,$working_key); // Method for encrypting the data.

		$ccAvenuUrl = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;
		
		redirect($ccAvenuUrl);
		exit;
	}

function encrypt($plainText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
		$plainPad = $this->pkcs5_pad($plainText, $blockSize);
	  	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
		{
		      $encryptedText = mcrypt_generic($openMode, $plainPad);
	      	      mcrypt_generic_deinit($openMode);
		      			
		} 
		return bin2hex($encryptedText);
	}
// CCAvenuSecureCheckout

	//*********** Padding Function *********************

	 function pkcs5_pad ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}

	//********** Hexadecimal to Binary function for php 4.0 version ********

	function hextobin($hexString) 
   	 { 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
    	  } 

    	  //************************************************************
	function decrypt($encryptedText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText=$this->hextobin($encryptedText);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
		mcrypt_generic_init($openMode, $secretKey, $initVector);
		$decryptedText = mdecrypt_generic($openMode, $encryptedText);
		$decryptedText = rtrim($decryptedText, "\0");
	 	mcrypt_generic_deinit($openMode);
		return $decryptedText;
		
	}
private function chk_login() {
		$userID								= $this->session->userdata('user_id');
		
		if(empty($userID) || $userID == 0) {
			redirect(base_url().'registration/');
		}
	}
public function paymentCouponSuccess() {
		$this->chk_login();
		$userID										= $this->session->userdata('user_id');
		$redirect									= $this->chk_user_status($userID); 
		$urlMethod									= explode("/", rtrim($redirect, '/'));
		$urlMethod									= $urlMethod[count($urlMethod)-1];
		
		if($urlMethod !== $this->router->fetch_method()) {
			//redirect($redirect);
		}
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '1B9B036C5C1F2829F47954D58B2AE507';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK		
		
		$userDetails								= $this->model_registration->getUserDetailsByID($userID);
		
		$this->data['name']							= $userDetails['user_firstname']." ".$userDetails['user_lastname'];
		$this->data['unique_id']					= $userDetails['user_unique_id'];
		$this->data['next_step']					= base_url()."submission/";
		
		//Response data from CCAvenue
		
		$this->data['workingKey']					= 'B308AEA75B4CC1353F0F9E7047037FD7';		//Working Key should be provided here.
	    $encResponse								= $this->input->post('encResp');
		//This is the response sent by the CCAvenue Server
		$rcvdString									= $this->decrypt($encResponse,$this->data['workingKey']);
		
        //Crypto Decryption used as per the specified working key.
		$this->data['order_status']					= "";
		$decryptValues								= explode('&', $rcvdString);
		foreach($decryptValues as $decValue) {
			$recValueArr[]							= explode('=', $decValue);
		}
		
		
		if($recValueArr) {
			foreach($recValueArr as $key => $val) {
				$ccData[$val[0]]					= $val[1];
			}
		} else {
			$ccData									= array();
		}
		//$this->data['dataSize']						= sizeof($this->data['decryptValues']);
		/*pr($rcvdString,0);
		pr($decryptValues,0);
		pr($recValueArr,0);
		pr($ccData);
		exit;*/
		$transDate									= date("Y-m-d", strtotime(str_replace("/", "-", $ccData['trans_date'])));
		$insPaymentArr								= array(
														"user_id"			=> $userID,
														"transaction_id"	=> $ccData['tracking_id'],
														"payment_amount"	=> $ccData['amount'],
														"payment_date"		=> $transDate,
														"payment_response"	=> serialize($ccData),
														"payment_type"		=> "donation",
														"payment_status"	=> $ccData['order_status']
														);
		$this->model_registration->insdata($insPaymentArr, "chben_payment");
		


		
		//End
	    //$this->data['booking_id']			    = $booking_id;
		$this->data['payment_amount']			= $ccData['amount'];
		$this->data['package']					= $ccData['merchant_param1'];
		
		$this->data['pay_date']					= $transDate;
		$this->data['ccData']					= $ccData;
		
        $this->session->set_flashdata('donation', 'You have successfully donate the amount.'); 
		$redirectUrl           	= 'submission/dashboard';	
        redirect($redirectUrl);
        exit;
	}
	
	public function chk_user_status($userID = '') {
		$userDetails				= $this->model_registration->getUserDetailsByID($userID);
		if($userDetails) {
			if($userDetails['overall_process'] == '1') {
				$redirect			= base_url()."login";
			} else {
				if($userDetails['guest_registration'] == '1') {
					
					if($userDetails['proposer_verification'] == '1') {
				
						if($userDetails['package_payment'] == '1') {
				
							if($userDetails['final_submission'] == '1') {
							
								if($userDetails['management_approval'] == '1') {
									$redirect 	= base_url()."login";
								} else {
									// Do nothing
								}
							} else {
								$redirect 		= base_url()."submission/";
							}
						} else {
							$redirect 			= base_url()."registration/package";
						}
					} else {
						$redirect 				= base_url()."registration/proposerverification/";
					}
				} else {
					if($userDetails['user_mobile_otp_verified'] == '1') {
						
						if(!empty($userDetails['user_email'])) {
							
							if($userDetails['user_email_otp_verified'] == '1') {
								$redirect 		= base_url()."registration/personalinfo/";
							} else {
								$redirect 		= base_url()."registration/verifyemail/";
							}
						} else {
							$redirect 			= base_url()."registration/verification/email/";
						}
						
					} else {
						$redirect				= base_url()."registration/verifymobile/";
					}
				}				
			}	
		}
		return $redirect;
	}
	

}

/* End of file Registration.php */
/* Location: ./application/controllers/registration.php */