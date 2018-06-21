<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		
		$this->load->model(array('model_registration','model_home'));
		$this->data['home_banner']					= $this->model_home->getBanner();
        $this->load->library('paypal_lib');		
		$this->layout->setLayout('front_layout');
	}	
	
	private function generatePassword() {
     $alphabet = 'abcdefghijklmnopqrstuvwxyz~#$!@ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
     $pass = array(); //remember to declare $pass as an array
     $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
     for ($i = 0; $i < 8; $i++) {
         $n = rand(0, $alphaLength);
         $pass[] = $alphabet[$n];
     }
     return implode($pass); //turn the array into a string
	}
	
	function success(){
        //get the transaction data
		
        $paypalInfo = $_REQUEST;
		echo "<pre>";
		print_r($paypalInfo);
		echo "</pre>";		
        
        
	
	    $payment_response    = json_encode($paypalInfo);
	    $transDate  = date('Y-m-d');
		$this->data['user_id'] 					= $paypalInfo["item_number"];
        $this->data['transaction_id']    		= $paypalInfo["tx"];
        $this->data['payment_amount'] 			= $paypalInfo["amt"];
		$this->data['payment_date'] 			= $transDate;
		$this->data['payment_response'] 		= $payment_response;
        $this->data['payment_type'] 			= 'newpackage';
        $this->data['payment_status']   		= $paypalInfo["st"];
             
        $paypalURL 								= $this->paypal_lib->paypal_url;        
        $result    								= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
 
        $this->model_registration->insertTransaction($this->data);
		
		$this->data['transaction_id'] 	= $paypalInfo["tx"];
        $this->data['payment_amount'] 	= $paypalInfo["amt"];
        $this->data['currency_code']	= $paypalInfo["cc"];
        $this->data['status'] 			= $paypalInfo["st"];
		$this->data['custom'] 			= $paypalInfo["cm"];
		$this->data['item_number']      = $paypalInfo['item_number'];
		$this->data['item_name']        = $paypalInfo['item_name'];    
		$user_unique_id                 = $this->data['item_name'];
		$password						= $this->generatePassword();
		$user_email                     = $this->data['custom'];
		$user_id                        = $this->data['item_number'];
		$txn_id                         = $this->data['transaction_id']; 
		
		
		$editArr						= array(
												"user_unique_id"		=> $user_unique_id,
												"password"				=> $password,
												"createdOn"				=> date('Y-m-d'),
												"user_status"				=> '1'
										);
		$condArr								= array("user_id" => $user_id);	
		$editData								= $this->model_registration->updateData($editArr, 'anad_users', $condArr);
		
		if($editData) {
			/*----------- Send password to mail and mobile -------*/
			$mailData['from_email']					= 'noreply@anandclub.org';
			$mailData['from_name']					= 'Anand Club';		
			$mailData['to_email']					= $user_email;
			$mailData['cc_mail']					= "support@anandclub.org";
			$mailData['replyto_email']				= "support@anandclub.org";
			$mailData['bcc_mail']					= '';	
			$mailData['subject']					= 'New member Registration Details';
			$mailData['message']					= "<div>
	<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;\">
  <tr>
    <td colspan=\"2\"><strong>Dear Member,</strong></td>    
  </tr>
  <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td colspan=\"2\">Thank you for Registration at Anand Club.<br/><br/> Your payment is success. Your transaction ID is: $txn_id.<br/><br/>You can now login with the details below:</td>    
  </tr>
  <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td>Email Id:- $user_email</td>
	</tr>
    <tr> 	
      <td>Password:- $password</td>
    </tr>	
	
	<tr>
      <td  colspan=\"2\">

<br />
<p><strong>Thanking you,<br /><br />
Warm Regards,</strong>
<br /><br />

<i>Anand Club<br />
Support Team</i><br />
www.anandclub.org<br />
email: support@anandclub.org</p></td>
     
    </tr>
</div>";
			
			$this->sendMail($mailData);

			/*----------------------- END -----------------------*/
		}	
		redirect(base_url()."registration/thankyou");
        
        //pass the transaction data to view
        //$this->load->view('templates/user/reg_success', $this->data);
     }
	 
	 function cancel(){
        $this->load->view('templates/user/payment_cancel');
     }
	 
	 function ipn(){
        //paypal return transaction details array
       // $paypalInfo    = $this->input->post();
	   $paypalInfo 			= $_REQUEST;
	   $payment_response    = json_encode($paypalInfo);
	  
	   $transDate  = date("Y-m-d", strtotime(str_replace("/", "-", $paypalInfo['payment_date'])));

        //$this->data['user_email'] 			= $paypalInfo['custom'];
        $this->data['user_id']   				= $paypalInfo["item_number"];
        $this->data['transaction_id']    		= $paypalInfo["tx"];
        $this->data['payment_amount'] 			= $paypalInfo["amt"];
		$this->data['payment_date'] 			= $transDate;
		$this->data['payment_response'] 		= $payment_response;
        $this->data['payment_type'] 			= 'newpackage';
        $this->data['payment_status']   		= $paypalInfo["st"];

        $paypalURL 								= $this->paypal_lib->paypal_url;        
        $result    								= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
		$user_id                                = $this->data['user_id'];
        
        //check whether the payment is verified
        if(preg_match("/VERIFIED/i",$result)){
            //insert the transaction data into the database
            $this->model_registration->insertTransaction($this->data);

        }
    }
	 
	 public function sendMail($mailData = array()) {
		$this->load->library('email');
		$config['charset'] = 'iso-8859-1';
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->clear();
		$this->email->from($mailData['from_email'], $mailData['from_name']);
		$this->email->to($mailData['to_email']);
		$this->email->reply_to($mailData['replyto_email']); //User email submited in for
		if(array_key_exists('cc_mail', $mailData)) {
			$this->email->cc($mailData['cc_mail']);
		}
		if(array_key_exists('bcc_mail', $mailData)) {
			$this->email->bcc($mailData['bcc_mail']);
		}
		if(array_key_exists('attach_path', $mailData)) {
			$this->email->attach($mailData['attach_path']);
		}
		$this->email->subject($mailData['subject']);
		$this->email->message($mailData['message']);
		if($this->email->send()) {
			return TRUE;
		} else {
			echo $this->email->print_debugger();	
			exit;
		}
	}
	
	
	
}

/* End of file Registration.php */
/* Location: ./application/controllers/registration.php */