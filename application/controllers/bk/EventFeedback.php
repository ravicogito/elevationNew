<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventFeedback extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		
		
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration', 'model_submission','model_login','model_home'));
		$this->data['home_banner']					= $this->model_home->getBanner();		
		//$this->data['themePath'] 			= $this->config->item('theme');
		$this->layout->setLayout('qr_layout');
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
		
		private function generateUniqueID($uID) {
		$uniqueID            ="";
		$uniqueID			.= "UIDA";
		for($i = 0; $i < (4-strlen($uID)); $i++) {
			$uniqueID			.= "0";
		}
		$uniqueID				.= $uID;
		
		return $uniqueID;
	}
	//*****************************************************************
	//******************************************************************
	
	// Feedback link direct to user Begin *******************
	
	public function putEventFeedbackDirect($event_id){
		
		$this->data['event_id']						= $event_id;
		$user_id 									= $this->session->userdata('user_id'); 
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
			
		$eventInfo = $this->model_submission->pastEventlist($tableName, $condition);	
		
		if(!empty($user_id)){			
			
			$ucond								= "UM.user_id = '$user_id'";
			$userDetails						= $this->model_registration->getUserDetailsDB($ucond);
			
			$this->data['latest_event_lists']			= $this->model_submission->latestEvents($user_id);
			
			$condition = "event_id = '$event_id'";
			$tableName = 'anad_events';
				
			$eventInfo = $this->model_submission->pastEventlist($tableName, $condition);		
			$booking_id =  $this->model_submission->GetBookingId($user_id, $event_id);
			if(!empty($booking_id)){
				$booking_id	=  $booking_id['id'];
				$this->data['booking_id'] = $booking_id;
				//$this->data['event_id']						= $event_id;
					
				//$this->data	= array();
				
				$feedbackcondition 	= "event_id = '$event_id' AND booking_id = '$booking_id' AND user_id = '$user_id'";
						$feedbackInfo		= $this->model_submission->eventFeedbacklist('anad_event_feedback', $feedbackcondition);
				if(empty($feedbackInfo)){
				$user_id 									= $this->session->userdata('user_id'); 
				//echo $user_id; exit;
				$this->data['event_lists']					= $this->model_submission->listEvents();		
				
				$this->data['eventInfo']			= $eventInfo;
				//print_r($this->data['couponInfo']);exit;
				
				
				$this->data['userDetails']			= $userDetails;
				
				$submitButn							= $this->input->post('submitButn');
				
				if($submitButn =="insert"){
					
					//print_r($_POST);EXIT;
					$insertArr						= array(
														"feedback_id" 				=> '',
														"event_id" 					=> $event_id,
														"booking_id" 				=> $booking_id,
														"user_id" 					=> $user_id,
														"overall_event_rate" 		=> $this->input->post('overall_event_rate'),
														"timing_rate"  				=> $this->input->post('timing_rate'),
														"entertainment_rate"  		=> $this->input->post('entertainment_rate'),
														"food_rate"  				=> $this->input->post('food_rate'),
														"parking_rate"  			=> $this->input->post('parking_rate'),
														"guestlist_rate"  			=> $this->input->post('guestlist_rate'),
														"facility_venue_rate"  		=> $this->input->post('facility_venue_rate'),
														"pricing_rate"  			=> $this->input->post('pricing_rate'),
														"vendor_mng_rate" 			=> $this->input->post('vendor_mng_rate'),
														"attend_ftur_events" 		=> $this->input->post('attend_ftur_events'),
														"food_quality_rate" 		=> $this->input->post('food_quality_rate'),
														"overall_services_quality" 	=> $this->input->post('overall_services_quality'),
														"cleanliness_rate" 			=> $this->input->post('cleanliness_rate'),
														"order_accuracy_rate" 		=> $this->input->post('order_accuracy_rate'),
														"speed_srvc_rate" 			=> $this->input->post('speed_srvc_rate'),
														"value_rate" 				=> $this->input->post('value_rate'),
														"overall_experience" 		=> $this->input->post('overall_experience'),
														"overall_experience_guest" 	=> $this->input->post('overall_experience_guest'),
														"fav_part_event" 			=> preg_replace( "/\r|\n/", "", $this->input->post('fav_part_event')),
														"improve_suggestions" 		=> preg_replace( "/\r|\n/", "", $this->input->post('improve_suggestions')),
														"feedback_date" 			=> date('Y-m-d')
														
														
												);
												
						
						$insertFeedbackDetails						= $this->model_submission->feedbackInsert($insertArr);
						
						$feedbackcondition 	= "event_id = '$event_id' AND booking_id = '$booking_id' AND user_id = '$user_id'";
						$feedbackInfo		= $this->model_submission->eventFeedbacklist('anad_event_feedback', $feedbackcondition);
						//print_r($feedbackInfo);exit;
						//echo $feedbackInfo[0]['timing_rate'];exit;
						$event_dt	=date('jS F Y', strtotime(str_replace("/", "-",$eventInfo[0]['event_dt'])));
						$event_time	=date('g:i A', strtotime(str_replace("/", "-",$eventInfo[0]['event_dt'])));
					##########################################
					###################Email Send to support#######################	
					$mail_body	='';

					$mail_body	= '<div style=" font-family:Arial, Helvetica, sans-serif; color:#20242F;font-size: 18px;font-weight: normal;">
					<div class="post_evnt_hd">
								<h2 style="background-color: #410035;color: #fff;text-align: center;padding: 10px 0;text-transform: uppercase;font-size: 35px;"><span style="font-weight: normal;">Post Event</span> <br>Feedback FORM</h2>
								<p style="text-align: center;">Thank you for attending our recent event. We would like to hear your impression of the various aspects of the event,
									  so that we can continually improve the experience for all attendees.</p>
								<h4 style="text-align: center;">'.$eventInfo[0]['event_title'].' <br><span>Event date was - <strong>'.$event_dt.'</strong>   |   Time - <strong>'.$event_time.'</strong></span></h4>
							  </div>
							  
							  <div class="usr_hd_dtl" style="text-align: center;padding: 18px 0;margin: 10px 0;border-top: 1px solid #410035;border-bottom: 1px solid #410035;">
								<span class="usr_dlte mmb_nme">MEMBER NAME - <strong>'.$userDetails['user_title'].'&nbsp;'.$userDetails['user_firstname'].'&nbsp;'.$userDetails['user_lastname'].'</strong></span> &nbsp; &nbsp; &nbsp;
								<span class="usr_dlte mmb_id">MEMBERSHIP ID - <strong>'.$userDetails['user_unique_id'].'</strong></span> &nbsp; &nbsp; &nbsp;
								
							  </div>
							  
							  <div class="overvewd"> <p>Overall how would you rate the event? <span class="rqd_spn">(Mandatory)</span> :-- <i>'.$feedbackInfo[0]['overall_event_rate'].'</i></p> </div>';

					if(!empty($feedbackInfo[0]['timing_rate'])||!empty($feedbackInfo[0]['entertainment_rate'])||!empty($feedbackInfo[0]['food_rate'])||!empty($feedbackInfo[0]['parking_rate'])||!empty($feedbackInfo[0]['guestlist_rate'])||!empty($feedbackInfo[0]['facility_venue_rate'])||!empty($feedbackInfo[0]['pricing_rate'])||!empty($feedbackInfo[0]['vendor_mng_rate'])){
					$mail_body.= '<div class="evn_tab_dve">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									  <tbody><tr>
									<th width="20%" align="left" valign="middle">Please rate the following aspects of the event</th>
									<th width="51%" align="center" valign="middle">'.'</th>
									</tr>';
						if(!empty($feedbackInfo[0]['timing_rate'])){

					$mail_body.= '<tr>
									<td>Scheduling and timing :--</td>
									<td>'.$feedbackInfo[0]['timing_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['entertainment_rate'])){
					$mail_body.= '<tr>
									<td>Entertainment :--</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['entertainment_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['food_rate'])){
					$mail_body.= '<tr>
									<td>Food and beverage :--</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['food_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['parking_rate'])){
					$mail_body.= '<tr>
									<td>Parking and directions :--</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['parking_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['guestlist_rate'])){
					$mail_body.= '<tr>
									<td>Invitations and guest list :--</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['guestlist_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['facility_venue_rate'])){
					$mail_body.= '<tr>
									<td>Choice of facility/venue :--</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['facility_venue_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['pricing_rate'])){
					$mail_body.= '<tr>
									<td>Cost and pricing :--</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['pricing_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['vendor_mng_rate'])){
					$mail_body.= '<tr>
									<td>Vendor management :--</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['vendor_mng_rate'].'</td>
									</tr>';
						}
					$mail_body.= '</tbody></table>
									
					</div>';

					}
					if(!empty($feedbackInfo[0]['attend_ftur_events'])){
						
					$mail_body.= '<div class="overvewd"> <p>Based on your experience at this event, how likely are you to attend future events? :-- <i>'.$feedbackInfo[0]['attend_ftur_events'].'</i></p></div>';

					}
					if(!empty($feedbackInfo[0]['food_quality_rate'])||!empty($feedbackInfo[0]['overall_services_quality'])||!empty($feedbackInfo[0]['cleanliness_rate'])||!empty($feedbackInfo[0]['order_accuracy_rate'])||!empty($feedbackInfo[0]['speed_srvc_rate'])||!empty($feedbackInfo[0]['value_rate'])){
					$mail_body.= '<div class="evn_tab_dve">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									  <tbody><tr>
									<th width="23%" align="left" valign="middle">Please rate the following aspects of the Food</th>
									<th width="51%" align="center" valign="middle">&nbsp;</th>
									</tr>';
						if(!empty($feedbackInfo[0]['food_quality_rate'])){
									
						$mail_body.= '<tr>
									<td>Food Quality</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['food_quality_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['overall_services_quality'])){
									
						$mail_body.= '<tr>
									<td>Overall Services Quality</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['overall_services_quality'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['cleanliness_rate'])){
									
						$mail_body.= '<tr>
									<td>Cleanliness</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['cleanliness_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['order_accuracy_rate'])){
									
						$mail_body.= '<tr>
									<td>Order Accuracy</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['order_accuracy_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['speed_srvc_rate'])){
									
						$mail_body.= '<tr>
									<td>Speed of Services</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['speed_srvc_rate'].'</td>
									</tr>';
						}
						if(!empty($feedbackInfo[0]['value_rate'])){
									
						$mail_body.= '<tr>
									<td>Value</td>
									<td valign="middle" align="left">'.$feedbackInfo[0]['value_rate'].'</td>
									</tr>';
						}
						$mail_body.= '</tbody></table>
					</div>';
					}
					if(!empty($feedbackInfo[0]['overall_experience'])){
						
					$mail_body.= '<div class="overvewd"> <p>Your Overall Experience :-- <i>'.$feedbackInfo[0]['overall_experience'].'</i></p> </div>';
					}
					if(!empty($feedbackInfo[0]['overall_experience_guest'])){
					$mail_body.= ' <div class="overvewd"> <p>Overall Experience of your guest :-- <i>'.$feedbackInfo[0]['overall_experience_guest'].'</i></p> </div>';
					}
					if(!empty($feedbackInfo[0]['fav_part_event'])){
					$mail_body.= ' <div class="overvewd"> <p>What was your favorite part of the event?</p> 
					<p style="font-size: 14px;">'.$feedbackInfo[0]['fav_part_event'].'</p>
					</div>';
					}
					if(!empty($feedbackInfo[0]['improve_suggestions'])){
						$mail_body.= '<div class="overvewd"> <p>Any other suggestions or comments to help us improve future event?</p> 
						<p style="font-size: 14px;">'.$feedbackInfo[0]['improve_suggestions'].'</p>
						</div>';
					}
				$mail_body.= '<tr>
			
					<td  colspan=\"2\">



						<br />

						<p><strong>Regards,</strong>

						<br /><br />



						Anand Club<br/>

						Support Team<br/>

						www.anandclub.org<br/>

						email: support@anandclub.org</p></td>

							 

							</tr></div>';
				
					$mailData['from_email']				 	= $userDetails['user_email'];
					$mailData['from_name']					= $userDetails['user_title'].''.$userDetails['user_firstname'];	
					//$mailData['to_email']					= 'support@anandclub.org';
					$mailData['to_email']					= $userDetails['user_email'];	
					//$mailData['to_email']					= 'sreela.cogito@gmail.com';				
					//$mailData['cc_mail']					= 'support@anandclub.org';			
					$mailData['replyto_email']				= 'support@anandclub.org';
					$mailData['bcc_mail']					= 'anandclub2017@gmail.com';	
					$mailData['subject']					= 'Thank you for submitting your feedback for '. $eventInfo[0]['event_title'].' on '.$event_dt.' at Anand Club';
					$mailData['message']					= $mail_body;

					
						
						
					$this->sendMail($mailData);	
						
					redirect(base_url()."submission/dashboard");
						
				}
					$this->data['frmaction']					= "";
					$this->data['forgotpassword']				= "";
					$this->data['display_login']				= "display:none";
					$this->data['display_sqStatus']				= "display:block";
					$this->data['errmsg']						= "";
					$this->data['succmsg']						= "";
					$this->data['booking_id']					= $booking_id;
					$this->data['event_id']						= $event_id;
					//print_r($this->data);
					$this->layout->view('templates/dashboard/feedback_form',$this->data);		
				}
				else{
					$this->data['eventInfo']			= $eventInfo;
					$this->data['userDetails']			= $userDetails; 
					$this->data['feedbackInfo']			= $feedbackInfo;
					
					$this->layout->view('templates/dashboard/feedback_view',$this->data); 			
					
				}
			}
			else{
				echo "<script> alert('Sorry !No booking for this event is done by you');</script>";
				redirect(base_url()."submission/dashboard");
			}
		}		
		else{
			
				
				$this->data['errmsg']						= $this->session->userdata('errmsg');
				$this->data['succmsg']						= $this->session->userdata('succmsg');
				
				$this->data['display_login']				=	"display:block";
				$this->data['display_sqStatus']				=  	"display:none";
				$this->data['userDetails']					=	"";
				$this->data['eventInfo']					= 	$eventInfo;
				$this->data['event_lists']					=	"";
				$this->data['event_lists']					=	"";
				$this->data['latest_event_lists']			=	"";
				$this->data['frmaction']					= base_url()."eventFeedback/adminchklogin/".$event_id;
				$this->data['forgotpassword']				= base_url()."user/forgotpassword/";
				
				//print_r($this->data);
				
			$this->layout->view('templates/dashboard/feedback_form',$this->data);	
		}
		
	}
	
	
	
	
	// END of code ********************************************
	
	
	
	public function adminchklogin($event_id) {
		
		$logInData									= $this->input->post('userId');
		$password									= $this->input->post('password');
		
		$cond										= "UM.user_email = '$logInData' AND BINARY password = '$password'";
		$userDetails								= $this->model_login->getUserDetailsDB($cond);
		//print_r($userDetails);exit;
		if($userDetails) {
			$this->session->set_userdata('user_id', $userDetails['user_id']);
			$this->session->set_userdata('membership_id', $userDetails['user_unique_id']);
			$this->session->set_userdata('user_mobile', $userDetails['user_mobile']);
			$this->session->set_userdata('user_email', $userDetails['user_email']);
			
			redirect(base_url()."eventFeedback/putEventFeedbackDirect/".$event_id);
		} else {
			$error = 'Membership Id or password incorrect';			
			$this->session->set_userdata('errmsg', $error);
			redirect(base_url()."eventFeedback/putEventFeedbackDirect/".$event_id);
		}
	}
	public function adminlogout($event_id) {

		$this->session->unset_userdata('user_id');

		$this->session->unset_userdata('user_unique_id');

		$this->session->unset_userdata('user_email');

		$this->session->unset_userdata('user_mobile');

				

    	$this->session->sess_destroy(); # Change

    	    

		redirect(base_url()."eventFeedback/putEventFeedbackDirect/".$event_id);

	}
	
	
	
	private function templateView(){		
		$this->templatelayout->seo();
		$this->templatelayout->header_inner();
		$this->templatelayout->footer();
		$this->templatelayout->multiple_view($this->elements,$this->elements_data);
	}	
	

}

