

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QRConfimation extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration', 'model_submission','model_login', 'model_coupon','model_home'));		
		$this->data['home_banner']					= $this->model_home->getBanner();
		$this->layout->setLayout('qr_layout');
	}
	
	private function generateTicketID($BID) {
		$uniqueID            ="";
		$uniqueID			.= "DWL";
		for($i = 0; $i < (4-strlen($BID)); $i++) {
			$uniqueID			.= "0";
		}
		$uniqueID				.= $BID;
		
		return $uniqueID;
	}
    
	
	public function viewCouponBookingInfo($booking_id) {		    
		// SEO WORK
		$this->data['booking_id']					= $booking_id;	
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK	
		 
        $user_id = $this->session->userdata('user_id'); 
		//$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsByID($user_id);
		

		$this->data['userDetails']    = $userDetails;
		
		##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
		###########
		##############################################

		$condition = "booking_id = '$booking_id' group by box_id ORDER BY id ASC";
		$condition2 = "booking_id = '$booking_id' and guest_qty!='0' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails				= $this->model_submission->customListArr($tableName, $condition);
		$bookingDetailsID			= $this->model_submission->customListArr($tableName, $condition2);
        $this->data['bookingDetails']			= $bookingDetails;
		$this->data['bookingDetailsID']			= $bookingDetailsID;
		//print_r($this->data['bookingDetailsID']);exit;
		###########

		if(!empty($bookingInfo['event_id'])){
			$this->data['event_id'] = $bookingInfo['event_id'];
			$event_id = $bookingInfo['event_id'];
			$condition = "event_id = '$event_id'";
		}
		
		$tableName = 'anad_events';
		$this->data['event_lists']			= $this->model_submission->customlist($tableName, $condition);
		//print_r($this->data['event_lists']);exit;
		$member_type     = 'member'; // member | guest | children
		$coupon_category     = 'thali';
		$coupon_sub_category =  'veg';
		$this->data['couponPrice']			= $this->model_coupon->getCouponPrice($event_id, $member_type, $coupon_category, $coupon_sub_category);
		#################### NEXT RENEWAL DATE CALCULATION ###########
          $user_package_id = $userDetails['user_package_id']; 
          $allow_array = array(1,3); 
          if(in_array($user_package_id, $allow_array)){
            $getNextRenewalDetailsArray = $this->model_submission->getNextRenewalDetails($user_id);
            
            $this->data['getNextRenewalDetailsArray']    = $getNextRenewalDetailsArray;
        }
        else{
        	$this->data['getNextRenewalDetailsArray']    = array();
        }

		$this->layout->view('templates/event/viewCouponBookingInfo',$this->data);
	}
	
	public function update_bookCouponUserdata() {
		//print_r($_POST);
		$booking_id 		= $this->input->post('booking_id');
		$event_id 			= $this->input->post('ev_id');
		$guest_name 		= $this->input->post('guest_name');
		$booking_details_id = $this->input->post('bookingdetailsid');
		$total_amount 		= $this->input->post('total_amount');
		
		// SEO WORK
		$this->data['booking_id']					= $booking_id;	
		
		// END SEO WORK	
		 
        $user_id = $this->session->userdata('user_id'); 
		//$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsByID($user_id);
		

		$this->data['userDetails']    = $userDetails;
		
		##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
		
		###########


		$this->data['event_id'] = $bookingInfo['event_id'];
        $event_id = $bookingInfo['event_id'];
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		$this->data['event_lists']			= $this->model_submission->customlist($tableName, $condition);
		
		$this->data['total_amount'] = $total_amount;
		
		//echo($this->data['total_amount']);exit;
		//echo count($booking_details_id);exit;
		for($i=0;$i<count($booking_details_id);$i++){
			
			$BookingDetailsArr	= array("guest_name" =>  $guest_name[$i]);
			//print_r($BookingDetailsArr);								
			$cpDetails_id = $booking_details_id[$i];
			$condArrdetails								= array("id" => $cpDetails_id);	
			
		
			//print_r($condArrdetails);	
			$editData								= $this->model_submission->updateData($BookingDetailsArr, 'anad_coupon_booking_details', $condArrdetails);										
			

		}
		###########
		##############################################

		$condition = "booking_id = '$booking_id' group by box_id ORDER BY id ASC";
		$condition2 = "booking_id = '$booking_id' and guest_qty!='0' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails				= $this->model_submission->customListArr($tableName, $condition);
		$bookingDetailsID			= $this->model_submission->customListArr($tableName, $condition2);
        $this->data['bookingDetails']			= $bookingDetails;
		$this->data['bookingDetailsID']			= $bookingDetailsID;
		//print_r($this->data['bookingDetailsID']);exit;
		
		##########################################
		$this->layout->view('templates/event/ticket.php',$this->data);
	}
	public function qr_validation($bk_usr_id){
		$member_type 	= array();
		$guest_name 	= array();	
		$total_price	= 0;
		$adult_counter=0;
		$teen_counter=0;
		$child_counter=0;
		$this->data['qr_msg']	= '';
		$u_id = $this->session->userdata('user_id');		
		if($u_id != ''){	
			$ucond									    = "user_id = '$u_id'";
			$userDetails							    = $this->model_submission->UserDataDB($ucond);		
			
				
				$cond									= "user_id = '$u_id'";
				$spouseDetails							= $this->model_submission->getUserSpouseInfo($cond);
				
				
				
				$this->data['user_id']			= $u_id;
					
				$this->data['userDetails']    	= $userDetails;
				//print_r($this->data['userDetails']);exit;
				$this->data['spouseDetails']    = $spouseDetails;
				//$this->data['getMemberwiseExpertizeListArr']    = $getMemberwiseExpertizeListArr;
			
				$ucond					= "booking_id = '$bk_usr_id'";
				$tableName 				= 'anad_coupon_booking_details';
				$qrCpDetails			= $this->model_submission->qrValidation($tableName, $ucond);
				
				if(!empty($qrCpDetails)){
					foreach($qrCpDetails as $qpd){
						$member_type[]			= $qpd['member_type'];						
						$guest_name[]			= $qpd['guest_name'];	
						$booking_details_id[]	= $qpd['id'];
						

						if($qpd['member_type']== "A")
						{
							$adult_counter++;
						}
						if($qpd['member_type']== "T")
						{
							$teen_counter++;
						}
						if($qpd['member_type']== "C")
						{
							$child_counter++;
						}

					
				}
				
				$cond					= "id = '$bk_usr_id'";
				$eventdetails			= $this->model_submission->get_eventdetails($cond);
				
				if(!empty($eventdetails)){
					foreach($eventdetails as $value){
						$event_title = $value['event_title'];					
					}
				}
				$coupon_bookingdetails	    = $this->model_submission->getTransactionId($bk_usr_id);
				//print_r($coupon_bookingdetails);exit;
				
					
						$this->data['userData']						= $this->model_submission->getUserDetailsForQR($bk_usr_id);
	
						$this->data['event_title']					= $event_title;						
						$this->data['member_type']					= $member_type;
						$this->data['guest_name']					= $guest_name;
						$this->data['adult_counter']				= $adult_counter;
						$this->data['teen_counter']					= $teen_counter;
						$this->data['child_counter']				= $child_counter;
						$this->data['booking_details_id']			= $booking_details_id;
						$this->data['transactionId']				= $coupon_bookingdetails['trans_id'];		
						$this->data['coupon_unique_id']				= $coupon_bookingdetails['coupon_unique_id'];
						$this->data['total_paid']					= $coupon_bookingdetails['total'];
						$this->data['isUsed']						= $coupon_bookingdetails['isUsed'];
						$this->data['ticket_id']					= $coupon_bookingdetails['ticket_id'];
						$this->data['total_payAmount']				= $coupon_bookingdetails['total'];
						$this->data['bk_usr_id']					= $bk_usr_id;
						$this->data['display_login']				= "display:none";
						$this->data['display_sqStatus']				= "display:block";
						$this->data['frmaction']					= '';
						$this->data['forgotpassword']				= '';
			}		
			
		}
		else{
				
				$this->data['errmsg']						= $this->session->userdata('errmsg');
				$this->data['succmsg']						= $this->session->userdata('succmsg');
				
				$this->data['display_login']				=	"display:block";
				$this->data['display_sqStatus']				=  	"display:none";
				$this->data['frmaction']					= base_url()."QRConfimation/adminchklogin/".$bk_usr_id;
				$this->data['forgotpassword']				= base_url()."user/forgotpassword/";
				$username									= $this->session->userdata('username');
				//echo $this->data['frmaction'];exit;
				if(!empty($mobno)) {
					$this->data['logindata']				= $mobno;
				} else {
					$this->data['logindata']				= "";
				}
		}
				
						
			$this->layout->view('templates/event/qrcoupon_validationMSG',$this->data);
		
	}
	public function qr_validation_submit(){
		
		
		$u_id = $this->session->userdata('user_id');
		$ucond									    = "user_id = '$u_id'";
		$scanbyData							    = $this->model_submission->UserDataDB($ucond);
		
		//print_r($_POST);exit;	
		$bk_usr_id 								=	$this->input->post('bk_usr_id');
		$total_amount							= 	$this->input->post('total_amount');
		$submit_value							= 	$this->input->post('submit_sq');
		$userDetails							= 	$this->model_submission->getUserDetailsForQR($bk_usr_id);		
		$this->data['userDetails']				=	$userDetails;
		$user_id								= 	$userDetails['user_id'];
		$bookingDetails							= 	$this->model_coupon->getBookingDetailsByID($bk_usr_id);
		
		$adult_counter=0;
		$teen_counter=0;
		$child_counter=0;
		$tmp_scan_date =0;
		$scan_confrim_date =0;
		foreach($bookingDetails as $key => $val) {
			if($val['member_type']== "A")
			{
				$adult_counter++;
			}
			if($val['member_type']== "T")
			{
				$teen_counter++;
			}
			if($val['member_type']== "C")
			{
				$child_counter++;
			}
			}
		$this->data['adult_counter']            = $adult_counter;
		$this->data['teen_counter']             = $teen_counter;
		$this->data['child_counter']            = $child_counter;
		
		foreach($bookingDetails as $val) {
		$this->data['bookingDetails']    		= $val;
        }

		$condition = "id = '$bk_usr_id'";
			$tableName = 'anad_coupon_booking';
			$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
			if(!empty($bookingInfo['trans_id'])){
					$payStatus ="BY PAYPAL";		  
		  
			}
			  else{
				$payStatus ="EVENT";  
			  }
			
			$condition = "booking_id = '$bk_usr_id' group by box_id ORDER BY id ASC";
			$condition2 = "booking_id = '$bk_usr_id' and guest_qty!='0' ORDER BY id ASC";
			$tableName = 'anad_coupon_booking_details';
			$bookingDetails				= $this->model_submission->customListArr($tableName, $condition);
			$bookingDetailsID			= $this->model_submission->customListArr($tableName, $condition2);
			//print_r($bookingDetailsID);exit;
			
			$tmp_scan_date  = strtotime(str_replace("/", "-", $bookingInfo['scanconfirmDateTime']));

			$scan_confrim_date  = date("d-m-Y g:i A",  $tmp_scan_date);
			
			
			
			$body_content='';
$body_content.="<div><table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;\">

  <tr>

    <td align='center' colspan=\"2\"><strong>TO WHOM IT MAY CONCERN</strong></td>    

  </tr>

  <tr>

      <td></td>

      <td>&nbsp;</td>

    </tr>

    <tr>

    <td colspan=\"2\">Ticket Number <b>".$bookingInfo['ticket_id']."</b>, for <b>". strtoupper($userDetails['user_title'])."&nbsp;".strtoupper($userDetails['user_firstname'])."&nbsp;".strtoupper($userDetails['user_lastname'])."</b>, member id <b>".$userDetails['user_unique_id'] ."</b>, is successfully scanned and the same is updated in the database at <b>". $scan_confrim_date ." . </b></td>    

	</tr>
	<tr>
	<td></td>
    <td>&nbsp;</td>

	</tr>
	<tr>

      <td>The total value of the ticket is <b>&pound;" . number_format($bookingInfo['total'],2) ."</b>. This ticket is PAID at <b>".$payStatus."</b> </td>

      <td>&nbsp;</td>

    </tr>
	<tr>
	<td></td>
    <td>&nbsp;</td>

	</tr>
	<tr>

      <td>The details of the ticket as follows:</td>

	</tr>
	<tr>
	<td></td>
    <td>&nbsp;</td>

	</tr>";
	$k=0;
	for($i=0;$i< count($bookingDetails);$i++){
		$k++;
		if($bookingDetails[$i]['member_type'] == 'A')
		{
			
			$memberType = 'Adult';
		}
		if($bookingDetails[$i]['member_type'] == 'T')
		{
			
			$memberType = 'Teens';
		}
		if($bookingDetails[$i]['member_type'] == 'C')
		{
			
			$memberType = 'Children';
		}
		foreach($bookingDetails as $val){
			$member_type[]		= $val['member_type'];
			$member_qty[]		= $val['member_qty'];
			$member_price[]		= $val['total_price'];
			$guest_qty[]		= $val['guest_qty'];
			$total_price[]		= $val['total_price'];
			
		}
		foreach($bookingDetailsID as $value){
			$bookingDetails_id[] 	= $value['id'];
			$guest_name[]			= $value['guest_name'];
		}
		
	$body_content.=	"<tr><td>".
	$k .") ". $memberType."(s): ". $bookingDetails[$i]['member_qty'].
	"<br></td></tr>";
	}
	
	$body_content.="<tr>
	<td></td>
    <td>&nbsp;</td>

	</tr><tr>

      <td><b>GUEST(s):</b></td>
	  

	</tr>";
	$n=0;
	if(!empty($guest_qty)){ 
		for($p=0;$p< count($bookingDetails);$p++){
			
			
			$body_content.="<tr><td>";
				for($j=0;$j< $guest_qty[$p];$j++){
					$body_content.=$n+1 .": ".strtoupper($guest_name[$n])."<br>";
				$n++;}
			$body_content.="</td></tr>";	
			
		}
	} else {
			$body_content.="<tr><td>
				<h2><strong>No Guest</strong></h2>
				</td></tr>";
		}
			

	$body_content.="<tr>
	<td></td>
    <td>&nbsp;</td>

	</tr><tr><td><i>This ticket was scanned by ". strtoupper($scanbyData['user_title'])."&nbsp;".strtoupper($scanbyData['user_firstname'])."&nbsp;".strtoupper($scanbyData['user_lastname'])." at ".$scan_confrim_date."</i></td>
	
	</tr>
	<tr>
	<td></td>
    <td>&nbsp;</td>

	</tr>
	<tr>

      <td  colspan=\"2\">



<br />

<p>Regards,

<br /><br />



<b>Anand Club</b><br />

<b>Support Team</b><br /><br />

www.anandclub.org<br />

email: support@anandclub.org</p></td>

     

    </tr></div>";
		if($submit_value == "Pay & Confirm"){
			$editArr			= array(		"coupon_unique_id" => $bk_usr_id,
												"ticket_id" => $this->generateTicketID($bk_usr_id),
												"isUsed" => 'Y',
												"scanconfirmDateTime" => date('Y-m-d h:s:i')
										);	
										
			$condArr								= array('id' => $bk_usr_id);	
			$editData								= $this->model_registration->updateData($editArr, 'anad_coupon_booking', $condArr);
		
			$this->data['total_amount']            	= $total_amount;
			
			
			
			
			##########################################
		###################Email Send to support#######################		
			$mailData['from_email']				 	= 'noreply@anandclub.org';
			$mailData['from_name']					= 'Anand Club';		
			//$mailData['to_email']					= 'support@anandclub.org';
			$mailData['to_email']					= $userDetails['user_email'];			
			$mailData['cc_mail']					= "support@anandclub.org";
			$mailData['replyto_email']				= "support@anandclub.org";
			$mailData['bcc_mail']					= '';	
			$mailData['subject']					= 'Confirmation mail for event.';
			$mailData['message']					= $body_content;
			
			$this->sendMail($mailData);
			
			$this->layout->view('templates/event/confermation_cashpayment.php',$this->data);
		}
		else if($submit_value == "Confirm"){
			
			$editArr			= array(		
												"isUsed" => 'Y',
												"scanconfirmDateTime" => date('Y-m-d h:s:i')
										);
			$condArr			= array('id' => $bk_usr_id);	
			$editData			= $this->model_registration->updateData($editArr, 'anad_coupon_booking', $condArr);

			##########################################
		###################Email Send to support#######################		
			$mailData['from_email']				 	= 'noreply@anandclub.org';
			$mailData['from_name']					= 'Anand Club';		
			//$mailData['to_email']					= 'support@anandclub.org';
			$mailData['to_email']					= $userDetails['user_email'];						
			$mailData['cc_mail']					= "support@anandclub.org";
			$mailData['replyto_email']				= "support@anandclub.org";
			$mailData['bcc_mail']					= '';	
			$mailData['subject']					= 'Confirmation mail for event.';
			$mailData['message']					= $body_content;

			$this->sendMail($mailData);
			
			redirect(base_url()."QRConfimation/success/".$user_id."/".$bk_usr_id);
		}
		
	}
	public function adminchklogin($bk_usr_id) {
		
		$logInData									= $this->input->post('userId');
		$password									= $this->input->post('password');
		
		$cond										= "UM.user_email = '$logInData' AND BINARY password = '$password'";
		$userDetails								= $this->model_login->chkUserAuth($logInData,$password);
//print_r($userDetails);exit;
		if($userDetails) {
			$this->session->set_userdata('user_id', $userDetails['user_id']);
			$this->session->set_userdata('membership_id', $userDetails['user_unique_id']);
			$this->session->set_userdata('user_mobile', $userDetails['user_mobile']);
			$this->session->set_userdata('user_email', $userDetails['user_email']);
			
			redirect(base_url()."QRConfimation/qr_validation/".$bk_usr_id);
		} else {
			$error = 'Membership Id or password incorrect';			
			$this->session->set_userdata('errmsg', $error);
			redirect(base_url()."QRConfimation/qr_validation/".$bk_usr_id);
		}
	}
	public function adminlogout($bk_usr_id) {

		$this->session->unset_userdata('user_id');

		$this->session->unset_userdata('user_unique_id');

		$this->session->unset_userdata('user_email');

		$this->session->unset_userdata('user_mobile');

				

    	$this->session->sess_destroy(); # Change

    	    

		redirect(base_url()."QRConfimation/qr_validation/".$bk_usr_id);

	}
	private function templateView(){		
		$this->templatelayout->seo();
		$this->templatelayout->header_inner();
		$this->templatelayout->footer();
		$this->templatelayout->multiple_view($this->elements,$this->elements_data);
	}
	function success($user_id,$booking_id){
		// SEO WORK
		
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	

		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		$userDetails							= $this->model_registration->getUserDetailsByID($user_id);
		
		$bookingDetails							= $this->model_coupon->getBookingDetailsByID($booking_id);
		
		$adult_counter=0;
		$teen_counter=0;
		$child_counter=0;
		foreach($bookingDetails as $key => $val) {
			if($val['member_type']== "A")
			{
				$adult_counter++;
			}
			if($val['member_type']== "T")
			{
				$teen_counter++;
			}
			if($val['member_type']== "C")
			{
				$child_counter++;
			}
			}
		$this->data['adult_counter']            = $adult_counter;
		$this->data['teen_counter']             = $teen_counter;
		$this->data['child_counter']            = $child_counter;
		foreach($bookingDetails as $val) {
		$this->data['bookingDetails']    		= $val;
        }		
		$this->data['userDetails']    			= $userDetails;
		
		$this->layout->view('templates/payment/paymentsuccess',$this->data);
     }

	public function sendMail($mailData = array()) {//pr($mailData);
			$this->load->library('email');
			$config['charset'] = 'iso-8859-1';
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->clear();
			$this->email->from($mailData['from_email'], $mailData['from_name']);
			$this->email->to($mailData['to_email']);
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