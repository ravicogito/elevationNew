<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer extends CI_Controller {
	public function __construct(){
			parent::__construct();


			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Customermodel');
			$this->load->model('Resortmodel');
			
	}

	public function listcustomer($id = ''){
		
		$front_url = $this->config->item('front_url');
		
		$data['customer_lists']= $this->Customermodel->allcustomerList();
		
		
		$data['front_url'] = $front_url;
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/list_customer", $data);
			$this->load->view("common/footer-inner");
		
	}
	
	public function AjaxCustomerList(){
		$recArr				= array();
		$fetchedId			= $this->input->post('rfID');
		$locationId			= $this->input->post('lnID');
		$comboVal = $this->Customermodel->fetchCustomerdtls($fetchedId);
		if(!empty($comboVal))
		{
			foreach($comboVal as $val)
				{
					$recArr['process'] 			    =  'success';
					$recArr['customer_firstname']   =  $val['customer_firstname'];
					$recArr['customer_middlename']  =  $val['customer_middlename'];
					$recArr['customer_lastname']   	=  $val['customer_lastname'];
					$recArr['customer_email']  	    =  $val['customer_email'];
					$recArr['customer_mobile']  	=  $val['customer_mobile'];
					$recArr['customer_address']  	=  $val['customer_address'];
					$recArr['customer_country_id']  =  $val['customer_country_id'];
					$recArr['customer_state_id']    =  $val['customer_state_id'];
					$recArr['customer_state_id']    =  $val['customer_state_id'];
					$recArr['customer_city_id']     =  $val['customer_city_id'];
					$recArr['customer_zipcode']     =  $val['customer_zipcode'];
				}
			$redioVal = $this->Customermodel->populateDropdown("resort_id", "resort_name", "el_resort", "location_id = '".$locationId."'" , "resort_name", "ASC");
	
			$fetchedOptions = array();
			
			if($redioVal)
			{	
				for ($c=0; $c<count($redioVal); $c++)
				{
					$fetchedOptions[$redioVal[$c]['resort_id']] =   $redioVal[$c]['resort_id'] . "|" . stripslashes($redioVal[$c]['resort_name']);
				}
				
				$recArr['resort_data']		= implode("??",$fetchedOptions);
			}
			else{
				$recArr['resort_data']		= "";
			}
		}
        else{
					$recArr['process'] 	=  'fail';	
					$redioVal = $this->Customermodel->populateDropdown("resort_id", "resort_name", "el_resort", "location_id = '".$locationId."'" , "resort_name", "ASC");
	
			$fetchedOptions = array();
			
			if($redioVal)
			{	
				for ($c=0; $c<count($redioVal); $c++)
				{
					$fetchedOptions[$redioVal[$c]['resort_id']] =   $redioVal[$c]['resort_id'] . "|" . stripslashes($redioVal[$c]['resort_name']);
				}
				
				$recArr['resort_data']		= implode("??",$fetchedOptions);
			}
			else{
				$recArr['resort_data']		= "";
			}
        }
		
		   echo json_encode($recArr);    
		}
		
		
	public function Ajaxlocationwiserf(){
		$fetchedId			= $this->input->post('location');
		$result				= array();			
		$result['comboVal'] = $this->Customermodel->fetchLocationdtls($fetchedId);
		$comboVal = $this->Customermodel->populateDropdown("resort_id", "resort_name", "el_resort", "location_id = '".$fetchedId."'" , "resort_name", "ASC");
	
			$fetchedOptions = array();
			
			if($comboVal)
			{	
				for ($c=0; $c<count($comboVal); $c++)
				{
					$fetchedOptions[$comboVal[$c]['resort_id']] =   $comboVal[$c]['resort_id'] . "|" . stripslashes($comboVal[$c]['resort_name']);
				}
				
				$result['resort_data']		= implode("??",$fetchedOptions);
			}
			else{
				$result['resort_data']		= "";
			}
 
			echo json_encode($result); 
		}	
	
	public function populateAjaxstate(){
		$fetchedId			= $this->input->post('country');
				
		$comboVal = $this->Customermodel->populateDropdown("state_id", "state_name", "el_states", "country_id = '".$fetchedId."'", "state_name", "ASC");
		
		$fetchedOptions = array();
		
		if($comboVal)
		{	
			for ($c=0; $c<count($comboVal); $c++)
			{
				$fetchedOptions[$comboVal[$c]['state_id']] =   $comboVal[$c]['state_id'] . "|" . stripslashes($comboVal[$c]['state_name']);
			}
			
			echo implode("??",$fetchedOptions);
		}
		else{
			echo "";
		}
	}
	public function populateAjaxCity(){
		$fetchedId			= $this->input->post('state');
				
		$comboVal = $this->Customermodel->populateDropdown("city_id", "city_name", "el_city", "state_id = '".$fetchedId."'", "city_name", "ASC");
		
		$fetchedOptions = array();
		
		if($comboVal)
		{	
			for ($c=0; $c<count($comboVal); $c++)
			{
				$fetchedOptions[$comboVal[$c]['city_id']] =   $comboVal[$c]['city_id'] . "|" . stripslashes($comboVal[$c]['city_name']);
			}
			
			echo implode("??",$fetchedOptions);
		}
		else{
			echo "";
		}
	}
	
	public function addCustomer(){ 
		
	$location_list		= $this->Customermodel->locationList();	
	$country_list		= $this->Customermodel->countryList();
	$city_list			= $this->Customermodel->cityList();
	$state_list			= $this->Customermodel->stateList();
	
	if(!empty($location_list)){	
		$data['location_list']	= $location_list;	
	}
	
	if(!empty($country_list)){	
		$data['country_list']	= $country_list;	
	}
	if(!empty($city_list)){	
		$data['city_list']		= $city_list;	
	}
	if(!empty($state_list)){	
		$data['state_list']		= $state_list;	
	}
	$resort_list		= $this->Resortmodel->index();
	if(!empty($resort_list)){	
		$data['resort_list']		= $resort_list;	
	}

	if(!empty($_POST)){
		
		$email 			= $this->input->post('customer_email');
		$mobile 		= $this->input->post('customer_mobile');
		$unique_email	= $this->Customermodel->checkUniqueEmail($email);
		$unique_mobile	= $this->Customermodel->checkUniquemobile($mobile);
		//echo $unique_email;exit;
		if($unique_email !='0'){
			$this->session->set_flashdata("pass_inc","This email is already added");

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_customer',$data);

			$this->load->view("common/footer-inner");
		}
		else if($unique_mobile !='0'){
			$this->session->set_flashdata("pass_inc","This mobile is already added");

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_customer',$data);

			$this->load->view("common/footer-inner");
			
		}
		else{
		
			$resort_id		= $this->input->post('resort_name');
			if($this->input->post('customer_ref_id')=="")
			{
				$rf_id='0';
				$state_id=$this->input->post('state_id');
				$city_id=$this->input->post('city_id');

			}
			else{
				$rf_id=$this->input->post('customer_ref_id');
				$state_id=$this->input->post('state_id');
				$city_id=$this->input->post('city_id');

			} 
			
			$data =  array(
								'customer_ref_id'			=>$rf_id,
								'location_id'				=>$this->input->post('location_id'),
								'customer_firstname'		=>$this->input->post('customer_firstname'),
								
								'customer_middlename'		=>$this->input->post('customer_middlename'),
								
								'customer_lastname'			=>$this->input->post('customer_lastname'),
								
								'customer_email'			=>$this->input->post('customer_email'),
								
								'customer_mobile'			=>$this->input->post('customer_mobile'),
								
								'customer_password'			=>substr($this->input->post('customer_mobile'),-4),
								
								'customer_address'			=>$this->input->post('customer_address'),
								
								'customer_country_id'		=>$this->input->post('country_id'),
								
								'customer_state_id'			=>$state_id,
								
								'customer_city_id'			=>$city_id,
								
								'customer_zipcode'			=>$this->input->post('customer_zipcode'),
								
								'customer_status'			=>'1'						

						);
						
			$mess = $this->Customermodel->customerAdd($data,$resort_id);
			
			
			if($mess){
				$this->session->set_flashdata("sucessPageMessage","New Customer Added Successfully!");

				redirect(base_url()."Customer/listcustomer");

			}
		}
	}
	else{

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_customer',$data);

			$this->load->view("common/footer-inner");

		}
	}
	public function editCustomer($id){
		//echo $id;
		$location_list		= $this->Customermodel->locationList();	
		$country_list		= $this->Customermodel->countryList();
		$state_list			= $this->Customermodel->stateList();
		$city_list			= $this->Customermodel->cityList();
		
		if(!empty($location_list)){	
		$data['location_list']	= $location_list;	
		
		}
	
		if(!empty($country_list)){	
			$data['country_list']	= $country_list;	
		}
		if(!empty($state_list)){	
			$data['state_list']		= $state_list;	
		}
		if(!empty($city_list)){	
			$data['city_list']		= $city_list;	
		}		
		
		$customer_data = $this->Customermodel->CustomerDataEdit($id);
		if(!empty($customer_data))
		{
			$data['customer_data']	= $customer_data;
			
		}
		$resort_list		= $this->Customermodel->Resortlist($data['customer_data']['location_id']);
		if(!empty($resort_list)){	
			$data['resort_list']		= $resort_list;	
		}
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_customer", $data);

		$this->load->view("common/footer-inner");



	}	
	
	public function updateCustomer($c_id){

		if(!empty($_POST)){
		$email 			= $this->input->post('customer_email');
		$mobile 		= $this->input->post('customer_mobile');	
		$unique_email	= $this->Customermodel->checkUniqueEmailInEdit($email,$c_id);
		$unique_mobile	= $this->Customermodel->checkUniquemobileInEdit($mobile,$c_id);
		//echo $unique_email;exit;
		if($unique_email !='0'){
			$this->session->set_flashdata("pass_inc","This email is already added");

			redirect(base_url()."Customer/editCustomer/".$c_id);
		}
		else if($unique_mobile !='0'){
			$this->session->set_flashdata("pass_inc","This mobile is already added");

			redirect(base_url()."Customer/editCustomer/".$c_id);
			
		}
		else{
			$resort_id		= $this->input->post('resort_name');
			if($this->input->post('customer_ref_id')=="")
			{
				$rf_id='0';
			}
			else{
				$rf_id=$this->input->post('customer_ref_id');
			}
			
			$data =  array(

							'customer_ref_id'			=>$rf_id,
							
							'customer_firstname'		=>$this->input->post('customer_firstname'),
							
							'customer_middlename'		=>$this->input->post('customer_middlename'),
							
							'customer_lastname'			=>$this->input->post('customer_lastname'),
							
							'customer_email'			=>$this->input->post('customer_email'),
							
							'customer_mobile'			=>$this->input->post('customer_mobile'),
							
							'customer_address'			=>$this->input->post('customer_address'),
							
							'customer_country_id'		=>$this->input->post('country_id'),
							
							'customer_state_id'			=>$this->input->post('state_id'),
							
							'customer_city_id'			=>$this->input->post('city_id'),
							
							'customer_zipcode'			=>$this->input->post('customer_zipcode'),
							
							'customer_status'			=>'1'							

						);


					$mess = $this->Customermodel->updateCustomerbyId($c_id, $data , $resort_id);
						if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","Customer's details updated Successfully!");

							redirect(base_url()."Customer/listcustomer");

						} 
			}
		} else{

				redirect(base_url()."Customer/editCustomer/".$c_id);

			}



	}
	
	
	public function deleteCustomer($id){

		$this->Customermodel->deleteCustomerbyId($id);
		
		$this->session->set_flashdata("sucessPageMessage","Customer's details Deleted Successfully!");

		redirect(base_url()."Customer/listcustomer");
	}
	
	
	// Prepare List for Mailchimp

	public function mailchimp_curl_connect( $url, $request_type, $api_key, $data = array() ) {
	if( $request_type == 'GET' )
		$url .= '?' . http_build_query($data);
 
	$mch = curl_init();
	$headers = array(
		'Content-Type: application/json',
		'Authorization: Basic '.base64_encode( 'user:'. $api_key )
	);
	curl_setopt($mch, CURLOPT_URL, $url );
	curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
	//curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
	curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
	curl_setopt($mch, CURLOPT_TIMEOUT, 10);
	curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection
 
	if( $request_type != 'GET' ) {
		curl_setopt($mch, CURLOPT_POST, true);
		curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
	}
 
	return curl_exec($mch);
	}


		//Update Mail subscriber

		public function mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME' => '','LNAME' => '') ){
		$data = array(
			'apikey'        => $api_key,
	    		'email_address' => $email,
			'status'        => $status,
			'merge_fields'  => $merge_fields
		);
		$mch_api = curl_init(); // initialize cURL connection
	 
		curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
		curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
		curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
		curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
		curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
		curl_setopt($mch_api, CURLOPT_POST, true);
		curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
	 
		$result = curl_exec($mch_api);
		return $result;
		}
		
	// POST Mailchimp templated

		public function mailchimp_template_status( $api_key ){
		$data = array(
"name"=>"CogitoPhotographTEMPLATE","html"=>"<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<h1>This is a Heading</h1>
<p>*|MERGE4|*</p>

</body>
</html>"
		);

//print_r($data);
//exit;
		$mch_api = curl_init(); // initialize cURL connection
	 
		curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/templates/');
		curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
		curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
		curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'POST'); // method PUT
		curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
		curl_setopt($mch_api, CURLOPT_POST, true);
		curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
	 
		$result = curl_exec($mch_api);
		//print_r($result);
		//exit;
		//return $result;
		}



	public function getMailchimpSubscribers( $id = '' ){
		
		$data['customer_lists']= $this->Customermodel->allcustomerList();

			$api_key = '35ca3fa9408b47b8bfebef7fba694691-us17';
			$list_id= '6ee04f9958';
			
			$subscribers_details = array();
			 
			$dc = substr($api_key,strpos($api_key,'-')+1); // us5, us8 etc
 
			// URL to connect
			$url = 'https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$list_id;
			 
			// connect and get results
			$body = json_decode( $this->mailchimp_curl_connect( $url, 'GET', $api_key ) );
						//print_r( $result);

							// number of members in this list
				$member_count = $body->stats->member_count;
				$emails = array();
				 
				for( $offset = 0; $offset < $member_count; $offset += 50 ) :
				 
					$data = array(
						'offset' => $offset,
						'count'  => 50
					);
				 
					// URL to connect
					$url = 'https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$list_id.'/members';
				 
					// connect and get results
					$body = json_decode( $this->mailchimp_curl_connect( $url, 'GET', $api_key, $data ) );
				 
				 	foreach ( $body->members as $member ) {

				 		$subscribers_details[] = array('subs_email'=>$member->email_address, 'subs_details'=> $member->merge_fields);
					}
				 
				endfor;
				 
			
			$data['mailchimplist'] = $subscribers_details;

			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/create_mailchimp_lists", $data);
			$this->load->view("common/footer-inner");

	}


	public function postMailchimpSubscription( $id = '' ){

				$customer_lists = $this->Customermodel->allcustomerList();

				//$email = 'rumakhan88@gmail.com';
				$status = 'subscribed'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
				$list_id = '6ee04f9958'; // where to get it read above
				$api_key = '35ca3fa9408b47b8bfebef7fba694691-us17'; // where to get it read above
				
				$bulkEmailURL = 'http://senabidemoportal.com/elevation/CustomerPhotosMail/photodetailsTemp/';

				foreach($customer_lists as $user_list){
					$email = $user_list['customer_email'];
					
					$url = base_url().'/'.urlencode($email);
					$merge_fields = array('FNAME' => $user_list['customer_firstname'],'LNAME' => $user_list['customer_firstname'],'MMERGE4'=> 'http://senabidemoportal.com/elevation/CustomerPhotosMail/photodetailsTemp/'.urlencode($email));
		 
				$this->mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields );

					}

					// Create Template
					$this->mailchimp_template_status($api_key);
					//END
				redirect(base_url()."Customer/getMailchimpSubscribers");

	}
}
