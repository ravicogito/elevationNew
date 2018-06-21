<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends CI_Controller {
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
		$this->load->model(array('model_registration', 'model_submission', 'model_coupon','model_home'));		
		//$this->data['themePath'] 			= $this->config->item('theme');
		$this->data['home_banner']					= $this->model_home->getBanner();
		$this->load->library('paypal_lib');	
		$this->layout->setLayout('front_layout');
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
	
	
	public function details($event_id) {		    
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	

		 //Counter

		/*$filePath =  getcwd().'/assets/counter.txt';
            $handle = fopen($filePath, "r");
           if(!$handle){
            	$this->data['counterData'] = 0;
           } 
            else { 
            	
            	$counter = (int) fread ($handle,20) ;
             	fclose ($handle) ;
             	
             	$counter++ ;
             	//echo " <span> ". $counter . " < /span > " ;
             	             	$this->data['counterData'] = $counter;
             	$handle = fopen($filePath, "w" ) ; 
             	fwrite($handle,$counter) ; 
             	fclose ($handle) ; 
           }*/

		$user_id = $this->session->userdata('user_id'); 
        ###################################################
		
         if(count($_POST)>0){
         	
						$totalPrice       	= $this->input->post('totalPrice');						$totalAmount     	=	array_sum($totalPrice);
         	           $couponBookingArr		= array(
												"user_id"		=> $user_id,
												"event_id"		=> $this->input->post('event_id'),
												"total_group"   => $this->input->post('totalcoupondiv'),																								"total"   		=> $totalAmount,
												"usedDateTime"   =>date('Y-m-d h:m:s')
												);
			           $booking_id = $this->model_registration->insdata($couponBookingArr, 'anad_coupon_booking');
					   
					   $editArr				= array(
												"ticket_id" => $this->generateTicketID($booking_id)
											);
		$condArr								= array("user_id" => $user_id, 'id' => $booking_id);	
		$editData								= $this->model_registration->updateData($editArr, 'anad_coupon_booking', $condArr);

						$member_type		= $this->input->post('member_type');
						$member_qty 		= $this->input->post('member_qty');
						$guest_qty 		 	= $this->input->post('guest_qty');
						$unitPrice       	= $this->input->post('unitPrice');						
						$boxId            	= $this->input->post('boxId');
						
                       foreach ($member_type as $key => $value) {

                       	for ($i=0; $i<$member_qty[$key]; $i++) {
                       		$no = $key+1; 
                       			$couponBookingDetailsArr	= array(
													"booking_id"		=> $booking_id,
													"box_id"			=> $boxId[$key],
													"member_type"		=> substr($value, 0,1),
													"member_qty"		=> $member_qty[$key],			
													"unit_price"		=> $unitPrice[$key],
													"total_price"		=> $totalPrice[$key]
													);
								if(($i+1) > $guest_qty[$key]) {
									$gQty					= '0';
								} else {
									$gQty					= $guest_qty[$key];
								}
								$couponBookingDetailsArr	= array_merge($couponBookingDetailsArr, array("guest_qty" => $gQty));
								
								//print_r($couponBookingDetailsArr); 							
			                     $this->model_registration->insdata($couponBookingDetailsArr, 'anad_coupon_booking_details');

                       	}
                       
                       }//exit;
                       $redirectUrl           	= 'coupon/viewCouponBookingInfo/'.$booking_id;	
                       redirect($redirectUrl);
                       exit;

         }
        ###################################################
        
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsDB($ucond);
		

		$this->data['userDetails']    = $userDetails;
		
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		$this->data['event_lists']			= $this->model_submission->customlist($tableName, $condition);
		###############  part 1: HERE I AM CREATING THE availibility LIST ########################## 
           $coupondata_avl_response_arr		= $this->model_coupon->getcouponAvalibility($event_id);
           $this->data['dynamic_coupon_cat_list']		= $coupondata_avl_response_arr;
		#########################   END LIST #########################
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
		#################### END OF REVEWAL DATE CALCULATION ########
		
		
		//$this->elements['contentHtml']           	= $this->data['themePath'].'coupon/create';	
		//$this->elements_data['contentHtml']      	= $this->data;		
		
        //$this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        //$this->templateView();
		$this->layout->view('templates/event/create',$this->data);
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
		//$condition2 = "booking_id = '$booking_id' and guest_qty!='0' ORDER BY id ASC";
		$condition2 = "booking_id = '$booking_id'  ORDER BY id ASC";
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
	
	   public function ajaxupdatebookinghinfo() {
		   //$rec=Array();
		//print_r($_POST);//exit; 
		//echo "<pre>";
  		//print_r($recArr);
        //echo json_encode($_POST); exit;
		if(!empty($_POST['guestName']))
		{
			foreach($_POST['guestName'] as $gname){
				//echo json_encode($gname);
				$guest_name 		= $gname;
			}
		}
		else{
			$guest_name 		= '';
			
		}
		if(!empty($_POST['bookingdetailsID']))
		{
			foreach($_POST['bookingdetailsID'] as $bookingdetailsID){
				//echo json_encode($bookingdetailsID);
				$booking_details_id = $bookingdetailsID;
			}
		}
		else{
			$booking_details_id = '';
			
		}
		
		
		$booking_id 		= $this->input->post('booking_id');
		$event_id 			= $this->input->post('ev_id');
		//$guest_name 		= $this->input->post('guest_name');
		//$booking_details_id = $this->input->post('bookingdetailsid');
		$total_amount 		= $this->input->post('total_amount');
		// SEO WORK
		$this->data['booking_id']					= $booking_id;	
		
		// END SEO WORK	
		 
        $user_id = $this->session->userdata('user_id'); 
		//$ucond								= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsByID($user_id);
		

		$this->data['userDetails']    = $userDetails;
		
		##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
		#############################################


		$this->data['event_id'] = $bookingInfo['event_id'];
        $event_id = $bookingInfo['event_id'];
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		$this->data['event_lists']			= $this->model_submission->customlist($tableName, $condition);
		
		$this->data['total_amount'] = $total_amount;
		if(!empty($_POST['guestName'])){
			for($i=0;$i<count($_POST['guestName']);$i++){
			
				$BookingDetailsArr	= array("guest_name" =>  $_POST['guestName'][$i]);
					
				//print_r($BookingDetailsArr);								
				$cpDetails_id = $_POST['bookingdetailsID'][$i];
				$condArrdetails								= array("id" => $cpDetails_id);	
				
			
				//print_r($condArrdetails);	
				$editData								= $this->model_submission->updateData($BookingDetailsArr, 'anad_coupon_booking_details', $condArrdetails);										
				

			}
		}
		else{
			for($i=0;$i<count($_POST['bookingdetailsID']);$i++){
				$BookingDetailsArr	= array("guest_name" =>  '');
				$cpDetails_id = $_POST['bookingdetailsID'][$i];
				$condArrdetails								= array("id" => $cpDetails_id);	
				
			
				//print_r($condArrdetails);	
				$editData								= $this->model_submission->updateData($BookingDetailsArr, 'anad_coupon_booking_details', $condArrdetails);
			 }	
			}
		###########
		##############################################

		$condition = "booking_id = '$booking_id' group by box_id ORDER BY id ASC";
		//$condition2 = "booking_id = '$booking_id' and guest_qty!='0' ORDER BY id ASC";
		$condition2 = "booking_id = '$booking_id' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails				= $this->model_submission->customListArr($tableName, $condition);
		$bookingDetailsID			= $this->model_submission->customListArr($tableName, $condition2);
        $this->data['bookingDetails']			= $bookingDetails;
		$this->data['bookingDetailsID']			= $bookingDetailsID;
		//print_r($this->data['bookingDetailsID']);exit;
		###########
		//if($this->data)
		//{
			$rec['process'] ='success';
		//}
		//else{
			//$rec['process'] ='fail';
		//}
		
		//echo($this->data['total_amount']);exit;
		echo json_encode($rec['process']);
		
		}
	
	
    public function ajaxAddCoupon() {
		$totalcoupondiv= isset($_POST['totalcoupondiv'])&&$_POST['totalcoupondiv']!=""?$_POST['totalcoupondiv']:"";
		$event_id = $_POST['event_id'];
		$data['totalcoupondiv']				= $totalcoupondiv;
        $member_type     = 'member'; // member | guest | children
		//$coupon_category     = 'thali';
		//$coupon_sub_category =  'veg';
		$data['couponPrice']			= $this->model_coupon->getCouponPrice($event_id, $member_type);
		###############  part 1: HERE I AM CREATING THE availibility LIST ########################## 
           $coupondata_avl_response_arr		= $this->model_coupon->getcouponAvalibility($event_id);
           $data['dynamic_coupon_cat_list']		= $coupondata_avl_response_arr;
		#########################   END LIST #########################

            //Counter

		/*$filePath =  getcwd().'/assets/counter.txt';
            $handle = fopen($filePath, "r");
            if(!$handle){
            	$this->data['counterData'] = 0;
            } 
            else { 
            	
            	$counter = (int) fread ($handle,20) ;
             	fclose ($handle) ;
             	
             	$counter++ ;
             	//echo " <span> ". $counter . " < /span > " ;
             	             	$this->data['counterData'] = $counter;
             	$handle = fopen($filePath, "w" ) ; 
             	fwrite($handle,$counter) ; 
             	fclose ($handle) ; 
           }*/

		$this->load->view('theme_v_1/coupon/ajaxAddRowCoupon',$data);
	}
	
	public function getGuestList() {

		$guest_qty= isset($_POST['guest_qty'])&&$_POST['guest_qty']!=""?$_POST['guest_qty']:"";
        $data['boxId']	= $_POST['boxId'];
		$data['guest_qty']	= $guest_qty;
		$event_id				= $_POST['event_id'];
		$member_type			= $_POST['member_type'];
		
		
		
		$arr = array();
		//$getCouponPriceByCategory="";
		/*if($coupon_category_name=="thali"){
		$total_avl_veg = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'veg');
		$total_avl_nonveg = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'nonveg');
		if($total_avl_veg>0)
		$arr['veg'] = 'veg('.$total_avl_veg.')';
	    if($total_avl_nonveg>0)
		$arr['nonveg'] = 'Non veg('.$total_avl_nonveg.')';
		
		}
		if($coupon_category_name=="combo"){
		
		$total_avl_combo1 = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'combo1');
		$total_avl_combo2 = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'combo2');
		
		if($total_avl_combo1>0)
		$arr['combo1'] = 'combo1('.$total_avl_combo1.')';
	    if($total_avl_combo2>0)
		$arr['combo2'] = 'combo2('.$total_avl_combo2.')';
		}
		if($coupon_category_name=="special"){
		
		$total_avl_catalog = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'catalog');
		$total_avl_others = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'others');
	
		if($total_avl_catalog>0)
		$arr['catalog'] = 'catalog('.$total_avl_catalog.')';
	    if($total_avl_others>0)
		$arr['others'] = 'others('.$total_avl_others.')';
		}
		if($coupon_category_name=="bhog"){
		//$arr=array('parcel'=>'parcel','others'=>'others');
		$total_avl_parcel = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'parcel');
		$total_avl_others = $this->model_coupon->chkAvailableCoupon($event_id, $coupon_category_name, 'others');
		
		if($total_avl_parcel>0)
		$arr['parcel'] = 'parcel('.$total_avl_parcel.')';
	    if($total_avl_others>0)
		$arr['others'] = 'others('.$total_avl_others.')';
		}*/

		$data['arr']				            = $arr;
        $getCouponPriceByCategoryArray = $this->model_coupon->getEventPrice($event_id);
        //print_r($getCouponPriceByCategoryArray);
        if($member_type=="A"){
        	$getCouponPriceByCategory = $getCouponPriceByCategoryArray[0]['adult_price'];
        }
        if($member_type=="T"){
        	$getCouponPriceByCategory = $getCouponPriceByCategoryArray[0]['teens_price'];
        }
        if($member_type=="C"){
        	$getCouponPriceByCategory = $getCouponPriceByCategoryArray[0]['child_price'];
        }
        
		

		        $recArr	= array();	
                $recArr['getCouponPriceByCategory']= $getCouponPriceByCategory;	
                $recArr['HTML']		= $this->load->view('theme_v_1/coupon/ajaxGuestyList',$data, true);
                //echo "<pre>";
  			    //print_r($recArr);
                echo json_encode($recArr);



	}
	
	public function getMemberType() {

	
        $data['boxId']			= $_POST['boxId'];
		$event_id				= $_POST['event_id'];
		$member_type			= $_POST['member_type'];
		
		
		
		$arr = array();
		$data['arr']				   = $arr;
        $getCouponPriceByCategoryArray = $this->model_coupon->getEventPrice($event_id);
        //print_r($getCouponPriceByCategoryArray);
        if($member_type=="A"){
        	$getCouponPriceByCategory = $getCouponPriceByCategoryArray[0]['adult_price'];
        }
        if($member_type=="T"){
        	$getCouponPriceByCategory = $getCouponPriceByCategoryArray[0]['teens_price'];
        }
        if($member_type=="C"){
        	$getCouponPriceByCategory = $getCouponPriceByCategoryArray[0]['child_price'];
        }
        
		

		        $recArr	= array();	
                $recArr['getCouponPriceByCategory']= $getCouponPriceByCategory;	
                //echo "<pre>";
  			    //print_r($recArr);
                echo json_encode($recArr);
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
		//for($i=0;$i<count($booking_details_id);$i++){
			if(!empty($guest_name)){
			for($i=0;$i<count($guest_name);$i++){
			$BookingDetailsArr	= array("guest_name" =>  $guest_name[$i]);
	       //print_r($BookingDetailsArr);								
			$cpDetails_id = $booking_details_id[$i];
			$condArrdetails								= array("id" => $cpDetails_id);	
			
		
			//print_r($condArrdetails);	
			$editData								= $this->model_submission->updateData($BookingDetailsArr, 'anad_coupon_booking_details', $condArrdetails);										
			

		}
	}
		else{
			for($i=0;$i<count($booking_details_id);$i++){
				$BookingDetailsArr	= array("guest_name" =>  '');
				$cpDetails_id = $booking_details_id[$i];
				$condArrdetails								= array("id" => $cpDetails_id);	
				
			
				//print_r($condArrdetails);	
				$editData								= $this->model_submission->updateData($BookingDetailsArr, 'anad_coupon_booking_details', $condArrdetails);
			 }	
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
		$event_lists                            = $this->data['event_lists'];				
		$this->data['user_id'] 					= $bookingInfo['user_id'];
		$u_id                                   = $this->data['user_id'];
		$uDetails							    = $this->model_registration->getUserDetailsByID($u_id);
		$this->data['uDetails']    				= $uDetails;
		//print_r($this->data['uDetails']);exit;
		$event_title  = $event_lists['event_title'];
		$event_date   = $event_lists['event_dt'];
		$s = strtotime($event_date);
		$date = date('Y/m/d', $s);
		$time = date('H:i:s', $s);
		$eventDate  = date("jS F Y", strtotime(str_replace("/", "-", $date)));
		$user_email= $uDetails['user_email']; 
		
		##########################################
		###################Email Send to support#######################
		    $mailData['from_email']					= 'noreply@anandclub.org';
			$mailData['from_name']					= 'Anand Club';		
			//$mailData['to_email']					= 'support@anandclub.org';
			$mailData['to_email']					=  $user_email;
			$mailData['cc_mail']					= "support@anandclub.org";
			$mailData['bcc_mail']					= '';	
			$mailData['replyto_email']				= "support@anandclub.org";
			$mailData['subject']					= 'Details of your tickets booking at '.$event_title.' 2017 on '.$eventDate;
			$mailBody = $this->getMailBody($booking_id,$bookingDetailsID, $bookingInfo, $bookingDetails, $event_lists,$uDetails); 
			$mailData['message']					= "<div style='padding:20px 10px; font-size:15px;'>$mailBody</div>";
			
			$this->sendMail($mailData);
		##########################################
		$this->layout->view('templates/event/ticket.php',$this->data);
	}
	
public function getMailBody($booking_id, $bookingDetailsID, $bookingInfo, $bookingDetails, $event_lists,$uDetails){
		$k = 0;
		$total=0;
		$total_guest=0;

	$s = strtotime($event_lists["event_dt"]);
	$date = date('Y/m/d', $s);
	$time = date('H:i:s', $s);
	$eventDate  = date("d.m.Y", strtotime(str_replace("/", "-", $date)));	
	
	$s1 = strtotime($bookingInfo["usedDateTime"]);
	$date1 = date('Y/m/d', $s1);
	$time1 = date('H:i:s', $s1);
	$bookingDate1  = date("jS F Y", strtotime(str_replace("/", "-", $date1)));
	
	
	$body_content='';
	$body_content.='<div>
	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;">
  <tr>
    <td colspan="2"><strong>Dear Member,</strong></td>    
  </tr>
  <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td colspan="2">Thank you for booking tickets online via your online portal. I hope you enjoyed the experience.</td>    
  </tr>
   <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
  <tr>
   <td width="29%" style="font-weight: bold;">Member name:</td>
    <td>'.strtoupper($uDetails["user_title"]).'&nbsp;'.strtoupper($uDetails["user_firstname"]).'&nbsp;'.strtoupper($uDetails["user_lastname"]).'</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Member ID:</td>
    <td>'.$uDetails["user_unique_id"].' &nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Event ID:</td>
    <td>'.$event_lists["event_unique_id"].'&nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Event name:</td>
    <td>'.$event_lists["event_title"].'&nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Event date:</td>
    <td>'.$eventDate.'&nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Booking Date:</td>
    <td>'.$bookingDate1.'&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" style="font-weight: bold;">You have booked ticket for </td>
	  <td><strong>'.$event_lists["event_title"].' </strong><br/> event to be held at <strong>'.$event_lists["event_location"].'</strong> <br/>at <strong>6.00PM</strong> onwards.</td>
      
    </tr>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong style="">Your booking details:</strong></td>      
    </tr>'
	;
if(!empty($bookingInfo['total_group'])){
	
	$count = $bookingInfo['total_group'];
	
	   for($i =0;$i<$count;$i++)
	   {
		if(!empty($bookingDetails)){
		$url = base_url().'coupon/qr_validation/'.$booking_id;

		$qr_secret = urlencode($url);
		$memberType		='';
		$member_qty	=array();
		$guest_qty	=array();
		$bookingDetails_id =array();
		
		foreach($bookingDetails as $val){
			$member_type[]		= $val['member_type'];
			$member_qty[]		= $val['member_qty'];
			$member_price[]		= $val['total_price'];
			$guest_qty[]		= $val['guest_qty'];
			$total_price[]		= $val['total_price'];
			
		}
		
		if($member_type[$i] == 'A')
		{
			
			$memberType = 'ADULT';
		}
		if($member_type[$i] == 'T')
		{
			
			$memberType = 'TEENS';
		}
		if($member_type[$i] == 'C')
		{
			
			$memberType = 'CHILDREN';
		}
		
		foreach($bookingDetailsID as $value){
			$bookingDetails_id[] 	= $value['id'];
			$guest_name[]			= $value['guest_name'];
		}
		//print_r($guest_qty);
	}


$body_content.="<tr><td></td>
      <td>Number of <strong>".$memberType." :  " .$member_qty[$i]. "</strong>  <strong style='float:right;'> &pound;".number_format($member_price[$i],2)." </strong></td>      
    </tr>";
    $total=$total+$member_price[$i]; 
	 }
	 
	
 }
 
    
	$body_content.='<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="right" style="font-size:18px; background-color:#ccc; padding:8px" >You paid in total:         <strong>&pound;'.number_format($total,2).' only.</strong></td>
      
    </tr>
	<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-weight: bold;">Out of which Guest Details as follows: </td>            
    </tr>';
	
	if(!empty($bookingInfo['total_group'])){
	
	$count = $bookingInfo['total_group'];
	
	   for($i =0;$i<$count;$i++)
	   {
		if(!empty($bookingDetails)){
		$url = base_url().'coupon/qr_validation/'.$booking_id;

		$qr_secret = urlencode($url);
		$memberType		='';
		$member_qty	=array();
		$guest_qty	=array();
		$bookingDetails_id =array();
		
		foreach($bookingDetails as $val){
			$member_type[]		= $val['member_type'];
			$member_qty[]		= $val['member_qty'];
			$member_price[]		= $val['total_price'];
			$guest_qty[]		= $val['guest_qty'];
			$total_price[]		= $val['total_price'];
			
		}
		
		if($member_type[$i] == 'A')
		{
			
			$memberType = 'ADULT';
		}
		if($member_type[$i] == 'T')
		{
			
			$memberType = 'TEENS';
		}
		if($member_type[$i] == 'C')
		{
			
			$memberType = 'CHILDREN';
		}
		
		foreach($bookingDetailsID as $value){
			$bookingDetails_id[] 	= $value['id'];
			$guest_name[]			= $value['guest_name'];
		}
		//print_r($guest_qty);
	}

	
	$body_content.="<tr>
      <td></td>
    <td> Number of<strong> ".$memberType."</strong> Guests:  <strong>".$guest_qty[$i]."</strong></td>
    </tr>";
	$total_guest=$total_guest+$guest_qty[$i];
	}
 }
    $body_content.="<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style='font-weight: bold;'>Total number of Guest(s):</td>
      <td> <strong>".$total_guest."</strong></td>
    </tr>
	<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style='font-weight: bold;' >The names of the Guest(s) as follows:</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td></td>
      <td>
	";
	if(!empty($bookingInfo['total_group'])){
	
	$count = $bookingInfo['total_group'];
	
	   for($i =0;$i<$count;$i++)
	   {
		if(!empty($bookingDetails)){
		$url = base_url().'coupon/qr_validation/'.$booking_id;

		$qr_secret = urlencode($url);
		$memberType		='';
		$member_qty	=array();
		$guest_qty	=array();
		$bookingDetails_id =array();
		
		foreach($bookingDetails as $val){
			$member_type[]		= $val['member_type'];
			$member_qty[]		= $val['member_qty'];
			$member_price[]		= $val['total_price'];
			$guest_qty[]		= $val['guest_qty'];
			$total_price[]		= $val['total_price'];
			
		}
		
		if($member_type[$i] == 'A')
		{
			
			$memberType = 'ADULT';
		}
		if($member_type[$i] == 'T')
		{
			
			$memberType = 'TEENS';
		}
		if($member_type[$i] == 'C')
		{
			
			$memberType = 'CHILDREN';
		}
		
		foreach($bookingDetailsID as $value){
			$bookingDetails_id[] 	= $value['id'];
			$guest_name[]			= $value['guest_name'];
		}
		//print_r($guest_qty);
	}
	if($guest_qty[$i] > 0){ 
	$body_content.="<p>";
	for($j=0;$j< $guest_qty[$i];$j++){
	$body_content.=$k+1 .": ".strtoupper($guest_name[$k])."</p>";
     $k++;}
	 } else {
$body_content.="<p>
<h2><strong>No Guest</strong></h2>
</p>";
 } 
 
    }
 }

	$body_content.='</td></tr><tr>
      <td></td>
      <td>&nbsp;</td>
    </tr><tr>
      <td></td>
      <td>&nbsp;</td>
    </tr><tr>
      <td colspan="2">YOU DECIDED TO PAY AT BANK/EVENT. 
</td>
    </tr>
	<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
<tr>
      <td  colspan="2">You can download or print your event tickets from your left-hand panel in your login.If you need any help please refer to the FAQ section for further assistance.

<br />
<p><strong>Thanking you,<br /><br />
Warm Regards,</strong>
<br /><br />

<i>Anand Club<br />
Support Team</i><br /><br />
www.anandclub.org<br />
email: support@anandclub.org</p></td>
     
    </tr>
</div>';	 
	     return $body_content;
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
						
			$user_type	=	$userDetails['user_type'];
			
			if(!empty($user_type)){
				
				$cond									= "user_id = '$u_id'";
				$spouseDetails							= $this->model_submission->getUserSpouseInfo($cond);
				$getMemberwiseExpertizeListArr		    = $this->model_submission->getMemberwiseExpertizeList($cond);
				
				
				$this->data['user_id']			= $u_id;
					
				$this->data['userDetails']    	= $userDetails;
				//print_r($this->data['userDetails']);exit;
				$this->data['spouseDetails']    = $spouseDetails;
				$this->data['getMemberwiseExpertizeListArr']    = $getMemberwiseExpertizeListArr;
			
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
					
				}
				
				$cond					= "id = '$bk_usr_id'";
				$eventdetails			= $this->model_submission->get_eventdetails($cond);
				
				if(!empty($eventdetails)){
					foreach($eventdetails as $value){
						$event_title = $value['event_title'];					
					}
				}
				$coupon_bookingdetails	    = $this->model_submission->getTransactionId($bk_usr_id);
				$ucond						= "booking_id = '$bk_usr_id' AND guest_qty!=0";
				$tableName 					= 'anad_coupon_booking_details';
				$total_payAmount			= $this->model_submission->qrValidation($tableName, $ucond);
					foreach($total_payAmount as $qrpay){
						
						$total_price = $total_price + $qrpay['total_price'];
					}
						$this->data['userData']						= $this->model_submission->getUserDetails($bk_usr_id);		
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
						$this->data['total_payAmount']				= $total_price;	
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
				$this->data['frmaction']					= base_url()."coupon/adminchklogin/".$bk_usr_id;
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
				
		$bk_usr_id 								=	$this->input->post('bk_usr_id');
		$total_amount							= 	$this->input->post('total_amount');
		$submit_value							= 	$this->input->post('submit_sq');
		$this->data['userDetails']				= 	$this->model_submission->getUserDetails($bk_usr_id);
		$user_id								= 	$this->data['userDetails']['user_id'];
		$bookingDetails							= 	$this->model_coupon->getBookingDetailsByID($bk_usr_id);
		
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
		if($submit_value == "Pay & Confirm"){
			$editArr			= array(		"coupon_unique_id" => $bk_usr_id,
												"total" => $total_amount,
												"ticket_id" => $this->generateTicketID($bk_usr_id),
												"isUsed" => 'Y',
												"usedDateTime" => date('Y-m-d h:s:i')
										);	
										
			$condArr								= array('id' => $bk_usr_id);	
			$editData								= $this->model_registration->updateData($editArr, 'anad_coupon_booking', $condArr);
		
			$this->data['total_amount']            	= $total_amount;
			$this->layout->view('templates/event/confermation_cashpayment.php',$this->data);
		}
		else if($submit_value == "Confirm"){
			
			$editArr			= array(		
												"isUsed" => 'Y',
												"usedDateTime" => date('Y-m-d h:s:i')
										);
			$condArr			= array('id' => $bk_usr_id);	
			$editData			= $this->model_registration->updateData($editArr, 'anad_coupon_booking', $condArr);							
			redirect(base_url()."coupon/success/".$user_id."/".$bk_usr_id);
		}
		
	}
	
	
	public function adminchklogin() {
		$logInData									= $this->input->post('userId');
		$password									= $this->input->post('password');
		
		$cond										= "UM.user_email = '$logInData' AND BINARY password = '$password'";
		$userDetails								= $this->model_login->getUserDetailsDB($cond);
		//pr($userDetails);
		if($userDetails) {
			$this->session->set_userdata('user_id', $userDetails['user_id']);
			$this->session->set_userdata('membership_id', $userDetails['user_unique_id']);
			$this->session->set_userdata('user_mobile', $userDetails['user_mobile']);
			$this->session->set_userdata('user_email', $userDetails['user_email']);
			
			redirect(base_url()."coupon/qr_validation");
		} else {
			$error = 'Membership Id or password incorrect';			
			$this->session->set_userdata('errmsg', $error);
			redirect(base_url());
		}
	}

	private function templateView(){		
		$this->templatelayout->seo();
		$this->templatelayout->header_inner();
		$this->templatelayout->footer();
		$this->templatelayout->multiple_view($this->elements,$this->elements_data);
	}	
	
	public function couponlists($booking_id)
	{
		//$booking_id = 16;
		
		// SEO WORK
			
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	

        $user_id = $this->session->userdata('user_id'); 
		//$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsByID($user_id);
		

		$this->data['userDetails']    = $userDetails;
		##############################################

		$condition = "id = '$booking_id' AND trans_id!=''";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
       
        if(empty($bookingInfo)){
				$redirectUrl           	= 'coupon/viewCouponBookingInfo/'.$booking_id;	
				redirect($redirectUrl);
				exit;
        }
       
		###########
		##############################################

		$condition = "booking_id = '$booking_id' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails			= $this->model_submission->customListArr($tableName, $condition);
		$condition_trans = "id = '$booking_id'";
		$transDetails			= $this->model_submission->customlist('anad_coupon_booking', $condition_trans);
		
		$this->data['transDetails']				= $transDetails;
        $this->data['bookingDetails']			= $bookingDetails;
		//print_r($this->data['bookingDetails']);exit;
		###########

		$this->data['booking_id']					= $booking_id;
		$this->data['event_id'] = $bookingInfo['event_id'];
		$event_id = $bookingInfo['event_id'];
		$condition = "event_id = '$event_id'";
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

        $this->elements['contentHtml']           	= $this->data['themePath'].'coupon/couponlists';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
	}

	public function couponPdfdownload($booking_id){
		
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	

        $user_id = $this->session->userdata('user_id'); 
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsDB($ucond);
		

		$outPutData['userDetails']    = $userDetails;
		
		$this->data['booking_id']    = $booking_id;
		##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
		$condition_trans 		= "id = '$booking_id'";
		$transDetails			= $this->model_submission->customlist('anad_coupon_booking', $condition_trans);
		
		$outPutData['transDetails']				= $transDetails;
        $outPutData['bookingInfo']			= $bookingInfo;
		###########
		##############################################

		$condition = "booking_id = '$booking_id' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$outPutData['coupon_pdfs']			= $this->model_submission->customListArr($tableName, $condition);
		//print_r($outPutData['coupon_pdfs']);exit;
		$outPutData['booking_id']					= $booking_id;
		$outPutData['event_id'] 					= $bookingInfo['event_id'];
		$outPutData['user_id'] 						= $bookingInfo['user_id'];
		$outPutData['booking_id']    = $booking_id;		
		$event_id = $bookingInfo['event_id'];
		
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		$outPutData['event_lists']				= $this->model_submission->customlist($tableName, $condition);
		
		
		
		$u_id = $bookingInfo['user_id'];
		$tableName1 = 'anad_users';
		$outPutData['user_lists']			= $this->model_registration->getUserDetailsByID($u_id);
		
		##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo = $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
		//print_r($bookingInfo);exit;
		$ticket_id = $bookingInfo['ticket_id'];
		###########
        		
		$condition = "booking_id = '$booking_id' group by box_id ORDER BY id ASC";
		$condition2 = "booking_id = '$booking_id' and guest_qty!='0' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails				= $this->model_submission->customListArr($tableName, $condition);
		$bookingDetailsID			= $this->model_submission->customListArr($tableName, $condition2);
        //echo "<pre>";
		//print_r($bookingDetails); 
		$outPutData['bookingDetails']			= $bookingDetails;
		$outPutData['bookingDetailsID']			= $bookingDetailsID;
		//exit;
		$html = '<style>@page{}</style>';
		//$html .= $outPutData;
		$html .= $this->load->view('theme_v_1/coupon/coupongenerate.php',$outPutData,true);
		//$this->load->view('theme_v_1/coupon/coupongenerate.php',$outPutData);
		//require_once('../chennai_cms/application/third_party/mpdf/mpdf.php');	
		
		require_once(getcwd().'/application/third_party/mpdf/mpdf.php');	
		$mpdf = new mPDF('win-1252', 'A4','', '','0', 0, '0', 0, 0, 1, 'L');
		$mpdf->useOnlyCoreFonts = false;    // false is default
		$mpdf->SetHTMLHeader('');
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);

		//$filename = 'coupon-pdfs.pdf';	
        $filename = 'Diwali-2017-Event-Ticket-'.$ticket_id.'.pdf';		
		$mpdf->Output($filename, 'D');
	}
	
	public function couponPdfdownloadhtml($booking_id){
		
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK	

        $user_id = $this->session->userdata('user_id'); 
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsDB($ucond);
		

		$outPutData['userDetails']    = $userDetails;
		
		$this->data['booking_id']    = $booking_id;
		##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
		$condition_trans = "id = '$booking_id'";
		$transDetails			= $this->model_submission->customlist('anad_coupon_booking', $condition_trans);
		
		$outPutData['transDetails']				= $transDetails;
        $outPutData['bookingInfo']			= $bookingInfo;
		###########
		##############################################

		$condition = "booking_id = '$booking_id' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$outPutData['coupon_pdfs']			= $this->model_submission->customListArr($tableName, $condition);
		//print_r($outPutData['coupon_pdfs']);exit;
		$outPutData['booking_id']					= $booking_id;
		$outPutData['event_id'] 					= $bookingInfo['event_id'];
		$event_id = $bookingInfo['event_id'];
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		$outPutData['event_lists']			= $this->model_submission->customlist($tableName, $condition);
		//print_r($outPutData['event_lists']);
		
		$html = '<style>@page{}</style>';
		//$html .= $outPutData;
		$this->load->view('theme_v_1/coupon/coupongenerate.php',$outPutData);
		
	}
	
public function couponPrint($booking_id) {
	
		// SEO WORK
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	

        $user_id = $this->session->userdata('user_id'); 
		$ucond									= "UM.user_id = '$user_id'";
		$userDetails							= $this->model_registration->getUserDetailsDB($ucond);
		

		$this->data['userDetails']    = $userDetails;
		
		$this->data['booking_id']    = $booking_id;
		##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
		###########
		##############################################

		$condition = "booking_id = '$booking_id' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$this->data['coupon_pdfs']			= $this->model_submission->customListArr($tableName, $condition);
		
		$event_id = $bookingInfo['event_id'];
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		$this->data['event_lists']			= $this->model_submission->customlist($tableName, $condition);
		
		$this->elements['contentHtml']           	= $this->data['themePath'].'coupon/couponprint';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
		
		//redirect(base_url()."coupon/couponlists/".$booking_id);
	}

	function ccavRequestHandler(){
		$userID										= $this->session->userdata('user_id');
        #################
        $eventID		= $this->input->post('ev_id');
		$bookingID		= $this->input->post('booking_id');				
		$guest_name 	= $this->input->post('name');
		$child_dob 		= $this->input->post('child_dob');
		$coupon_id 		= $this->input->post('coupon_id');
		
		/*echo "<pre>";
		print_r($guest_name);
		print_r($child_dob);
		print_r($couponBookingDetailsArr);
		echo "</pre>";*/
		foreach ($guest_name as $key => $value) {
			if(!empty($child_dob[$key]))
			{
				$cd_dob =	date("Y-m-d", strtotime(str_replace("/","-", $child_dob[$key])));
			}
			else{
				
				$cd_dob = 'NULL';
			}
			
			$couponBookingDetailsArr	= array(
														
														"guest_name"		=>  $guest_name[$key],
														"child_dob"			=>	$cd_dob
														
														);
			$cp_id = $coupon_id[$key];
			$condArr								= array("id" => $cp_id);	
			
		
			
			$editData								= $this->model_submission->updateData($couponBookingDetailsArr, 'anad_coupon_booking_details', $condArr);	
		}

        ######################
		$data = $this->input->post();
		$userType = $this->session->userdata('userType'); 
		if($userType=="admin"){
		/*echo "<pre>";
		print_r($couponBookingDetailsArr);
		print_r($data);
        echo "</pre>";*/
        $paymentType = $this->input->post('cod_post');
        $pos_val = $this->input->post('pos_val');
        if($paymentType=="POS"){
        	$scode = $pos_val;
        }
        else{
        	$scode = date("Y-m-d");
        }
        $transaction_id = $paymentType.$userID.'_'.$scode;
        $amount 		= $this->input->post('amount');
        $this->paymentCouponOffline($bookingID,$amount,$transaction_id);
        exit;
		}
		else{


		
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
	public function paymentCouponOffline($booking_id,$amount,$transaction_id) {
		$this->chk_login();
		$userID										= $this->session->userdata('user_id');
		
		
		
		
		$userDetails								= $this->model_registration->getUserDetailsByID($userID);
		
		$this->data['name']							= $userDetails['user_firstname']." ".$userDetails['user_lastname'];
		$this->data['unique_id']					= $userDetails['user_unique_id'];
		$this->data['next_step']					= base_url()."submission/";
		
		
		$transDate									= date("Y-m-d");
		
		$insPaymentArr								= array(
														"user_id"			=> $userID,
														"transaction_id"	=> $transaction_id,
														"payment_amount"	=> $amount,
														"payment_date"		=> $transDate,
														"payment_response"	=> serialize('na'),
														"payment_type"		=> "coupon",
														"payment_status"	=> 'success'
														);
		$this->model_registration->insdata($insPaymentArr, "anad_payment");
		
		

		

				##############################################

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
		###########
		##############################################

		$condition = "booking_id = '$booking_id' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails			= $this->model_submission->customListArr($tableName, $condition);
        $this->data['bookingDetails']			= $bookingDetails;
		//print_r($this->data['bookingDetails']);exit;
		###########
		$eventID = $bookingInfo['event_id'];
		$condition = "event_id = '$eventID'";
		$tableName = 'anad_events';
		$event_listsArr			= $this->model_submission->customlist($tableName, $condition);
          foreach($bookingDetails as $key=>$val){

          	$coupon_booking_details_id = $val['id'];

        $coupondata_avl_response_arr		= $this->model_submission->getcouponDetails($eventID,$booking_id,$coupon_booking_details_id);

          if(count($coupondata_avl_response_arr)>0){

          
        ####################### LIST OF OPERATION ####
			
			$coupon_unique_id	=	$coupondata_avl_response_arr['coupon_unique_id'];			


			$couponBookingDetailsArr	= array(
			"coupon_unique_id"	=>	$coupon_unique_id
			);
			$condArr		    = array("id" => $coupon_booking_details_id);	


			$editData		    = $this->model_submission->updateData($couponBookingDetailsArr, 'anad_coupon_booking_details', $condArr);	
            
            $sold_out	=	'yes';
			$coupondetails	= array( "sold_out"	=>  $sold_out );
			$condArr2								= array("coupon_unique_id" => $coupon_unique_id);
			$editData								= $this->model_submission->updateData($coupondetails, 'anad_coupon_details', $condArr2);
            $mobNo = $userDetails['user_mobile'];
            $user_unique_id = $userDetails['user_unique_id'];
            $guest_name = $val['guest_name'];
            $food_category=$val['food_category'];
            $food_sub_category=$val['food_sub_category'];
            $unit_price=$val['unit_price'];
            $event_title = $event_listsArr['event_title'];
            
            $msg   = "EVENT- $event_title COUPON CODE - $coupon_unique_id FOR $guest_name $user_unique_id $food_category($food_sub_category) $unit_price CONFIRMED.";
			$this->sendSMS($mobNo, $msg);
			
        ######################  END ######################
  	       }// end sold out based on availibility checking
          } // end foreach
			
			$coupon_booking_arr						= array( "trans_id" =>  $transaction_id);
			$condArr2								= array("id" => $booking_id);
			$editData								= $this->model_submission->updateData($coupon_booking_arr, 'anad_coupon_booking', $condArr2);


		

		
		//End
	    $this->data['booking_id']			    = $booking_id;
		$this->data['payment_amount']			= $amount;
		
		
		$this->data['pay_date']					= $transDate;
		$this->data['ccData']					= $ccData;
		
		
	
		$redirectUrl           	= 'coupon/couponlists/'.$booking_id;	
                       redirect($redirectUrl);
                       exit;
	}
	/*public function paymentCouponSuccess() {
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
		$this->data['contentKeywords']				= 'B308AEA75B4CC1353F0F9E7047037FD7';
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
		
		$transDate									= date("Y-m-d", strtotime(str_replace("/", "-", $ccData['trans_date'])));
		$insPaymentArr								= array(
														"user_id"			=> $userID,
														"transaction_id"	=> $ccData['tracking_id'],
														"payment_amount"	=> $ccData['amount'],
														"payment_date"		=> $transDate,
														"payment_response"	=> serialize($ccData),
														"payment_type"		=> "coupon",
														"payment_status"	=> $ccData['order_status']
														);
		$this->model_registration->insdata($insPaymentArr, "anad_payment");
		
	

			if($ccData['order_status']=="Success"){
				$booking_id = $ccData['order_id'];

		

		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
	
	

		$condition = "booking_id = '$booking_id' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails			= $this->model_submission->customListArr($tableName, $condition);
        $this->data['bookingDetails']			= $bookingDetails;
		
		$eventID = $bookingInfo['event_id'];
		$condition = "event_id = '$eventID'";
		$tableName = 'anad_events';
		$event_listsArr			= $this->model_submission->customlist($tableName, $condition);
          foreach($bookingDetails as $key=>$val){

          	$coupon_booking_details_id = $val['id'];

        $coupondata_avl_response_arr		= $this->model_submission->getcouponDetails($eventID,$booking_id,$coupon_booking_details_id);

          if(count($coupondata_avl_response_arr)>0){

          
       
			
			$coupon_unique_id	=	$coupondata_avl_response_arr['coupon_unique_id'];			


			$couponBookingDetailsArr	= array(
			"coupon_unique_id"	=>	$coupon_unique_id
			);
			$condArr		    = array("id" => $coupon_booking_details_id);	


			$editData		    = $this->model_submission->updateData($couponBookingDetailsArr, 'anad_coupon_booking_details', $condArr);	
            
            $sold_out	=	'yes';
			$coupondetails	= array( "sold_out"	=>  $sold_out );
			$condArr2								= array("coupon_unique_id" => $coupon_unique_id);
			$editData								= $this->model_submission->updateData($coupondetails, 'anad_coupon_details', $condArr2);
            $mobNo = $userDetails['user_mobile'];
            $user_unique_id = $userDetails['user_unique_id'];
            $guest_name = $val['guest_name'];
            $food_category=$val['food_category'];
            $food_sub_category=$val['food_sub_category'];
            $unit_price=$val['unit_price'];
            $event_title = $event_listsArr['event_title'];
            
            $msg   = "EVENT- $event_title FOR $guest_name $user_unique_id $food_category($food_sub_category) $unit_price CONFIRMED.";
			$this->sendSMS($mobNo, $msg);
			
       
  	       }
          } 
			$trans_id = $ccData['tracking_id'];
			$coupon_booking_arr						= array( "trans_id" =>  $trans_id);
			$condArr2								= array("id" => $booking_id);
			$editData								= $this->model_submission->updateData($coupon_booking_arr, 'anad_coupon_booking', $condArr2);


		
			} 
	    $this->data['booking_id']			    = $booking_id;
		$this->data['payment_amount']			= $ccData['amount'];
		$this->data['package']					= $ccData['merchant_param1'];
		
		$this->data['pay_date']					= $transDate;
		$this->data['ccData']					= $ccData;
		
		
      $this->templateView();
		$redirectUrl           	= 'coupon/couponlists/'.$booking_id;	
                       redirect($redirectUrl);
                       exit;
	}*/
	public function sendSMS($mobNo = 0, $msg = '') {
		$url = 'http://bhashsms.com/api/sendmsg.php';
			$fields = array(
				'user' => urlencode('thebengalassociation'),
				'pass' => urlencode('TBA@321'),
				'sender' => urlencode('BENGAL'),
				'phone' => urlencode($mobNo),
				'text' => urlencode($msg),
				'priority' => urlencode('ndnd'),
				'stype' => urlencode('normal')
			);
			//pr($fields,0);
			$fields_string = '';
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');
			//echo $fields_string;
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
			return true;
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
	
	
	
	
	 public function paymentCouponSuccess() {		    
		
        $paypalInfo = $_REQUEST;
		//echo "<pre>";
		//print_r($paypalInfo);
		//echo "<pre>"; exit;
		//**************************//
	   $payment_response    = json_encode($paypalInfo);
	   $transDate  = date('Y-m-d');
		$this->data['user_id'] 					= $paypalInfo["cm"];
        $this->data['transaction_id']    		= $paypalInfo["tx"];
        $this->data['payment_amount'] 			= $paypalInfo["amt"];
		$this->data['payment_date'] 			= $transDate;
		$this->data['payment_response'] 		= $payment_response;
        $this->data['payment_type'] 			= 'coupon';
        $this->data['payment_status']   		= $paypalInfo["st"];
             
        $paypalURL 								= $this->paypal_lib->paypal_url;        
        $result    								= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
 
        $this->model_registration->insertTransaction($this->data);
      
			
		//****************************//
		
        $this->data['user_id'] 					= $paypalInfo["cm"];
        $this->data['transaction_id']    		= $paypalInfo["tx"];
        $this->data['payment_amount'] 			= $paypalInfo["amt"];
        $this->data['payment_type'] 			= 'coupon';
		$this->data['booking_id']   			= $paypalInfo["item_name"];		
		$txn_id                 		        = $this->data['transaction_id'];
		//$password						        = $this->generatePassword();
		$user_id                     	        = $this->data['user_id'];
		$booking_id                             = $this->data['booking_id'];
		$editArr						        = array(
												"trans_id" => $txn_id,
												"coupon_unique_id" => $booking_id,
												"total" => $this->data['payment_amount'],
												"usedDateTime" => date('Y-m-d h:m:s'),
												"ticket_id" => $this->generateTicketID($booking_id)
										);
		$condArr								= array("user_id" => $user_id, 'id' => $booking_id);	
		$editData								= $this->model_registration->updateData($editArr, 'anad_coupon_booking', $condArr);
		//exit;
		$userDetails							= $this->model_registration->getUserDetailsByID($user_id);
		$user_email          				    = $userDetails['user_email'];
		###########
		##############################################
		
		$condition = "id = '$booking_id'";
		$tableName = 'anad_coupon_booking';
		$bookingInfo			= $this->model_submission->customlist($tableName, $condition);
        $this->data['bookingInfo']			= $bookingInfo;
		
		
        $event_id = $bookingInfo['event_id'];
		$condition = "event_id = '$event_id'";
		$tableName = 'anad_events';
		$this->data['event_lists']			= $this->model_submission->customlist($tableName, $condition);
		$this->data['total_amount'] = $total_amount;
		
		
		$condition = "booking_id = '$booking_id' group by box_id ORDER BY id ASC";
		$condition2 = "booking_id = '$booking_id' and guest_qty!='0' ORDER BY id ASC";
		$tableName = 'anad_coupon_booking_details';
		$bookingDetails				= $this->model_submission->customListArr($tableName, $condition);
		$bookingDetailsID			= $this->model_submission->customListArr($tableName, $condition2);
        $this->data['bookingDetails']			= $bookingDetails;
		$this->data['bookingDetailsID']			= $bookingDetailsID;
		$event_lists                            = $this->data['event_lists'];				
		$this->data['user_id'] 					= $bookingInfo['user_id'];
		$u_id                                   = $this->data['user_id'];
		$uDetails							    = $this->model_registration->getUserDetailsByID($u_id);
		$this->data['uDetails']    				= $uDetails;
		//print_r($this->data['uDetails']);exit;
		$event_title  = $event_lists['event_title'];
		$event_date   = $event_lists['event_dt'];
		$s = strtotime($event_date);
		$date = date('Y/m/d', $s);
		$time = date('H:i:s', $s);
		$eventDate  = date("jS F Y", strtotime(str_replace("/", "-", $date)));
		$user_email= $uDetails['user_email']; 
		
		
		if($editData) {
			/*----------- Send password to mail and mobile -------*/
			$mailData['from_email']					= 'noreply@anandclub.org';
			$mailData['from_name']					= 'Anand Club';		
			$mailData['to_email']					= $user_email;
			//$mailData['to_email']					= "khan.ruma@gmail.com";
			$mailData['cc_mail']					= "support@anandclub.org";
			$mailData['replyto_email']				= "support@anandclub.org";
			$mailData['bcc_mail']					= '';	
			//$mailData['subject']					= 'Event Coupon Booking';
			$mailData['subject']					= 'Details of your tickets booking at '.$event_title.' 2017 on '.$eventDate;
			$mailBody = $this->getMailBodypaypal($booking_id,$bookingDetailsID, $bookingInfo, $bookingDetails, $event_lists,$uDetails); 
			$mailData['message']					= "<div style='padding:20px 10px; font-size:15px;'>$mailBody</div>";
			//$mailData['message']					= "<div style='padding:20px 10px; font-size:15px;'>Your Event Booking Id is $booking_id</div>";
			
			$this->sendMail($mailData);

			/*----------------------- END -----------------------*/    
        redirect(base_url()."coupon/success/".$user_id."/".$booking_id); 
		//$this->load->view('templates/payment/paymentsuccess', $this->data);
		} 
	}
	
	
	public function getMailBodypaypal($booking_id, $bookingDetailsID, $bookingInfo, $bookingDetails, $event_lists,$uDetails){
		$k = 0;
		$total=0;
		$total_guest=0;

	$s = strtotime($event_lists["event_dt"]);
	$date = date('Y/m/d', $s);
	$time = date('H:i:s', $s);
	$eventDate  = date("d.m.Y", strtotime(str_replace("/", "-", $date)));	
	
	$s1 = strtotime($bookingInfo["usedDateTime"]);
	$date1 = date('Y/m/d', $s1);
	$time1 = date('H:i:s', $s1);
	$bookingDate1  = date("jS F Y", strtotime(str_replace("/", "-", $date1)));
	
	
	$body_content='';
	$body_content.='<div>
	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;">
  <tr>
    <td colspan="2"><strong>Dear Member,</strong></td>    
  </tr>
  <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td colspan="2">Thank you for booking tickets online via your online portal. I hope you enjoyed the experience.</td>    
  </tr>
   <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
  <tr>
   <td width="29%" style="font-weight: bold;">Member name:</td>
    <td>'.strtoupper($uDetails["user_title"]).'&nbsp;'.strtoupper($uDetails["user_firstname"]).'&nbsp;'.strtoupper($uDetails["user_lastname"]).'</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Member ID:</td>
    <td>'.$uDetails["user_unique_id"].' &nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Event ID:</td>
    <td>'.$event_lists["event_unique_id"].'&nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Event name:</td>
    <td>'.$event_lists["event_title"].'&nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Event date:</td>
    <td>'.$eventDate.'&nbsp;</td>
    </tr>
  <tr>
    <td style="font-weight: bold;">Booking Date:</td>
    <td>'.$bookingDate1.'&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" style="font-weight: bold;">You have booked ticket for </td>
	  <td><strong>'.$event_lists["event_title"].' </strong><br/> event to be held at <strong>'.$event_lists["event_location"].'</strong> <br/>at <strong>6.00PM</strong> onwards.</td>
      
    </tr>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong style="">Your booking details:</strong></td>      
    </tr>'
	;
if(!empty($bookingInfo['total_group'])){
	
	$count = $bookingInfo['total_group'];
	
	   for($i =0;$i<$count;$i++)
	   {
		if(!empty($bookingDetails)){
		$url = base_url().'coupon/qr_validation/'.$booking_id;

		$qr_secret = urlencode($url);
		$memberType		='';
		$member_qty	=array();
		$guest_qty	=array();
		$bookingDetails_id =array();
		
		foreach($bookingDetails as $val){
			$member_type[]		= $val['member_type'];
			$member_qty[]		= $val['member_qty'];
			$member_price[]		= $val['total_price'];
			$guest_qty[]		= $val['guest_qty'];
			$total_price[]		= $val['total_price'];
			
		}
		
		if($member_type[$i] == 'A')
		{
			
			$memberType = 'ADULT';
		}
		if($member_type[$i] == 'T')
		{
			
			$memberType = 'TEENS';
		}
		if($member_type[$i] == 'C')
		{
			
			$memberType = 'CHILDREN';
		}
		
		foreach($bookingDetailsID as $value){
			$bookingDetails_id[] 	= $value['id'];
			$guest_name[]			= $value['guest_name'];
		}
		//print_r($guest_qty);
	}


$body_content.="<tr><td></td>
      <td>Number of <strong>".$memberType." :  " .$member_qty[$i]. "</strong>  <strong style='float:right;'> &pound;".number_format($member_price[$i],2)." </strong></td>      
    </tr>";
    $total=$total+$member_price[$i]; 
	 }
	 
	
 }
 
    
	$body_content.='<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="right" style="font-size:18px; background-color:#ccc; padding:8px" >You paid in total:         <strong>&pound;'.number_format($total,2).' only.</strong></td>
      
    </tr>
	<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="font-weight: bold;">Out of which Guest Details as follows: </td>            
    </tr>';
	
	if(!empty($bookingInfo['total_group'])){
	
	$count = $bookingInfo['total_group'];
	
	   for($i =0;$i<$count;$i++)
	   {
		if(!empty($bookingDetails)){
		$url = base_url().'coupon/qr_validation/'.$booking_id;

		$qr_secret = urlencode($url);
		$memberType		='';
		$member_qty	=array();
		$guest_qty	=array();
		$bookingDetails_id =array();
		
		foreach($bookingDetails as $val){
			$member_type[]		= $val['member_type'];
			$member_qty[]		= $val['member_qty'];
			$member_price[]		= $val['total_price'];
			$guest_qty[]		= $val['guest_qty'];
			$total_price[]		= $val['total_price'];
			
		}
		
		if($member_type[$i] == 'A')
		{
			
			$memberType = 'ADULT';
		}
		if($member_type[$i] == 'T')
		{
			
			$memberType = 'TEENS';
		}
		if($member_type[$i] == 'C')
		{
			
			$memberType = 'CHILDREN';
		}
		
		foreach($bookingDetailsID as $value){
			$bookingDetails_id[] 	= $value['id'];
			$guest_name[]			= $value['guest_name'];
		}
		//print_r($guest_qty);
	}

	
	$body_content.="<tr>
      <td></td>
    <td> Number of<strong> ".$memberType."</strong> Guests:  <strong>".$guest_qty[$i]."</strong></td>
    </tr>";
	$total_guest=$total_guest+$guest_qty[$i];
	}
 }
    $body_content.="<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style='font-weight: bold;'>Total number of Guest(s):</td>
      <td> <strong>".$total_guest."</strong></td>
    </tr>
	<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style='font-weight: bold;' >The names of the Guest(s) as follows:</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td></td>
      <td>
	";
	if(!empty($bookingInfo['total_group'])){
	
	$count = $bookingInfo['total_group'];
	
	   for($i =0;$i<$count;$i++)
	   {
		if(!empty($bookingDetails)){
		$url = base_url().'coupon/qr_validation/'.$booking_id;

		$qr_secret = urlencode($url);
		$memberType		='';
		$member_qty	=array();
		$guest_qty	=array();
		$bookingDetails_id =array();
		
		foreach($bookingDetails as $val){
			$member_type[]		= $val['member_type'];
			$member_qty[]		= $val['member_qty'];
			$member_price[]		= $val['total_price'];
			$guest_qty[]		= $val['guest_qty'];
			$total_price[]		= $val['total_price'];
			
		}
		
		if($member_type[$i] == 'A')
		{
			
			$memberType = 'ADULT';
		}
		if($member_type[$i] == 'T')
		{
			
			$memberType = 'TEENS';
		}
		if($member_type[$i] == 'C')
		{
			
			$memberType = 'CHILDREN';
		}
		
		foreach($bookingDetailsID as $value){
			$bookingDetails_id[] 	= $value['id'];
			$guest_name[]			= $value['guest_name'];
		}
		//print_r($guest_qty);
	}
	if(!empty($guest_qty)){ 
	$body_content.="<p>";
	for($j=0;$j< $guest_qty[$i];$j++){
	$body_content.=$k+1 .": ".strtoupper($guest_name[$k])."</p>";
     $k++;}
	 } else {
$body_content.="<p>
<h2><strong>No Guest</strong></h2>
</p>";
 } 
 
    }
 }

	$body_content.='</td></tr><tr>
      <td></td>
      <td>&nbsp;</td>
    </tr><tr>
      <td></td>
      <td>&nbsp;</td>
    </tr><tr>
      <td colspan="2">YOU DECIDED TO PAY VIA PAYPAL. 
</td>
    </tr>
	<tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
<tr>
      <td  colspan="2">You can download or print your event tickets from your left-hand panel in your login.If you need any help please refer to the FAQ section for further assistance.

<br />
<p><strong>Thanking you,<br /><br />
Warm Regards,</strong>
<br /><br />

<i>Anand Club<br />
Support Team</i><br /><br />
www.anandclub.org<br />
email: support@anandclub.org</p></td>
     
    </tr>
</div>';	 
	     return $body_content;
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
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_unique_id');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_mobile');
				
    	$this->session->sess_destroy();
		
		$this->layout->view('templates/payment/paymentsuccess',$this->data);
     }
	 
	 function paymentCouponcancel(){
		// SEO WORK
		
		$this->data['contentTitle']					= 'ANAND CLUB';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'puja.';
		// END SEO WORK	
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_unique_id');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_mobile');
				
    	$this->session->sess_destroy();
	
		$this->layout->view('templates/payment/paymentcancel',$this->data);
     }
	
	function ipn(){
        //paypal return transaction details array
       // $paypalInfo    = $this->input->post();
	   $paypalInfo 			= $_REQUEST;
	   $payment_response    = json_encode($paypalInfo);
	  
	   $transDate  = date("Y-m-d", strtotime(str_replace("/", "-", $paypalInfo['payment_date'])));

        $this->data['user_id'] 					= $paypalInfo["cm"];
        $this->data['transaction_id']    		= $paypalInfo["tx"];
        $this->data['payment_amount'] 			= $paypalInfo["amt"];
		$this->data['payment_date'] 			= $transDate;
		$this->data['payment_response'] 		= $payment_response;
        $this->data['payment_type'] 			= 'coupon';
        $this->data['payment_status']   		= $paypalInfo["payment_status"];
             
        $paypalURL 								= $this->paypal_lib->paypal_url;        
        $result    								= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);

        
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
	public function ticketDetails($booking_id,$event_id) {
		$total_amount = 0;
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
		$total_group = $bookingInfo['total_group'];
		$total_amount = $bookingInfo['total'];
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
		$this->data['total_amount'] = $total_amount;
		$this->layout->view('templates/event/ticket.php',$this->data);
	}
	
	
}

/* End of file Registration.php */
/* Location: ./application/controllers/registration.php */