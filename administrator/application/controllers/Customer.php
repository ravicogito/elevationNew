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
			$this->load->model('Eventmodel');
			
			$this->load->model('mailchimpmodel');
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
		$resortId			= $this->input->post('rstID');		
		$locationId			= $this->input->post('lnID');
		//echo $fetchedId."fsajdhg".$locationId;exit;
		$customer_id 		= $this->Customermodel->fetchResortrdtls($fetchedId,$locationId,$resortId);
		//echo $customer_id;exit;
		if(!empty($customer_id))
		{
			$comboVal		= $this->Customermodel->fetchCustomerdtls($customer_id);
			
			if(!empty($comboVal)){
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
			}
			else{
				$recArr['process'] 	=  'fail';	
				
				$comboVal2 = $this->Customermodel->populatecustomer($locationId,$resortId);
				
				$fetchedOptions = array();
				
				if($comboVal2)
				{	
					for ($c=0; $c<count($comboVal2); $c++)
					{
						$fetchedOptions[$comboVal2[$c]['customer_id']] =   $comboVal2[$c]['customer_id'] . "|" . stripslashes($comboVal2[$c]['customer_firstname']);
					}
					
					$recArr['customer_data']		= implode("??",$fetchedOptions);
					//echo $result['customer_data'];
				}
				else{
					$recArr['customer_data']		= "";
				}
			} 
		}
		else{
			$recArr['process'] 	=  'fail';	
			$comboVal2 = $this->Customermodel->populatecustomer($locationId,$resortId);

				$fetchedOptions = array();
				
				if($comboVal2)
				{	
					for ($c=0; $c<count($comboVal2); $c++)
					{
						$fetchedOptions[$comboVal2[$c]['customer_id']] =   $comboVal2[$c]['customer_id'] . "|" . stripslashes($comboVal2[$c]['customer_firstname']);
					}
					
					$recArr['customer_data']		= implode("??",$fetchedOptions);
				}
				else{
					$recArr['customer_data']		= "";
				}
		}
		  echo json_encode($recArr);
		}
		
		
	public function Ajaxlocationwiserf(){
		$fetchedId			= $this->input->post('location');
		$result				= array();			
		//$result['comboVal'] = $this->Customermodel->fetchLocationdtls($fetchedId);
		$comboVal = $this->Customermodel->populateDropdown("resort_id", "resort_name", "el_resort", "location_id = '".$fetchedId."' AND resort_status = '1'" , "resort_name", "ASC");
	
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
	public function populateAjaxRfidByResort(){
	$fetchedId			= $this->input->post('resort');
	$location			= $this->input->post('locationId');
	if(!empty($fetchedId)){	
		
	$comboVal	= $this->Customermodel->fetchLocationdtls($fetchedId);
		if($comboVal)
		{	
			$result['comboVal']	= $comboVal;

			$comboVal2 = $this->Customermodel->populatecustomer();

			$fetchedOptions = array();
			
			if($comboVal2)
			{	
				for ($c=0; $c<count($comboVal2); $c++)
				{
					$fetchedOptions[$comboVal2[$c]['customer_id']] =   $comboVal2[$c]['customer_id'] . "|" . stripslashes($comboVal2[$c]['customer_firstname']);
				}
				
				$result['customer_data']		= implode("??",$fetchedOptions);
			}
			else{
				$result['customer_data']		= "";
			}
			//echo $result['customer_data'];
		}
		else{
			$result['comboVal']	= "";
			
		}
	}
		echo json_encode($result); 
	}	
	
	public function populateAjaxPhotographerByLocation(){
	$fetchedId			= $this->input->post('resort');
	
	if(!empty($fetchedId)){	
		
	$comboVal = $this->Eventmodel->populateDropdown($fetchedId);
	
			$fetchedOptions = array();
			
			if($comboVal)
			{	
				for ($c=0; $c<count($comboVal); $c++)
				{
					$fetchedOptions[$comboVal[$c]['photographer_id']] =   $comboVal[$c]['photographer_id'] . "|" . stripslashes($comboVal[$c]['photographer_name']);
				}
				
				echo implode("??",$fetchedOptions);
			}
			else{
				echo "";
			}
	}
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
		
	
	$country_list		= $this->Customermodel->countryList();
	$city_list			= $this->Customermodel->cityList();
	$state_list			= $this->Customermodel->stateList();

	if(!empty($country_list)){	
		$data['country_list']	= $country_list;	
	}
	if(!empty($city_list)){	
		$data['city_list']		= $city_list;	
	}
	if(!empty($state_list)){	
		$data['state_list']		= $state_list;	
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
		
				$state_id=$this->input->post('state_id');
				$city_id=$this->input->post('city_id');

			
			
			$data =  array(
													
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
								
								'customer_status'			=>'1',
								
								'created_on'				=>date('Y-m-d')
								
														

						);
						
			$mess = $this->Customermodel->customerAdd($data);
			
			
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
	
	public function populateAjaxbyStateCity()
	{
		$get_country_id = $this->input->post('country_id');
		
		$get_country_id_for_city = $this->input->post('country_id_for_city');
		
		$get_state_id_for_city = $this->input->post('state_id_for_city');
		
		if(!empty($get_country_id))
		{
			$get_state_lists = $this->Customermodel->StatelistByCountry($get_country_id);
			if(!empty($get_state_lists))
			{
				$return_new_array = array();

					foreach($get_state_lists as $get_state_list)

					{

						$returnArr = array();

						$returnArr['state_id'] = $get_state_list['state_id'];

						$returnArr['state_name'] = $get_state_list['state_name'];

						

						$return_new_array[] = $returnArr;

					}

					//print_r($return_new_array);

					

					header('Content-Type: application/json');

					 echo json_encode( $return_new_array );
			}
			else{
				$return_new_array = 0;
				echo json_encode( $return_new_array );
			}
			/* echo"<pre>";
			print_r($get_event_lists);
			die; */
		}
		
		else if(!empty($get_state_id_for_city))
		{
			$get_city_lists = $this->Customermodel->CitylistByCountryState($get_state_id_for_city,$get_country_id_for_city);
			if(!empty($get_city_lists))
			{
				$return_new_array = array();

					foreach($get_city_lists as $get_city_list)

					{

						$returnArr = array();

						$returnArr['city_id'] = $get_city_list['city_id'];

						$returnArr['city_name'] = $get_city_list['city_name'];

						

						$return_new_array[] = $returnArr;

					}

					//print_r($return_new_array);

					

					header('Content-Type: application/json');

					 echo json_encode( $return_new_array );
			}
			else{
				$return_new_array = 0;
				echo json_encode( $return_new_array );
			}
		}
	}
	/*public function addCustomer(){ 
		
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
		
			$location_id	= $this->input->post('location_name');
			$resort_id		= $this->input->post('resort_name');
			if($this->input->post('resort_ref_id')=="")
			{
				$rf_id='0';
				$state_id=$this->input->post('state_id');
				$city_id=$this->input->post('city_id');

			}
			else{
				$rf_id=$this->input->post('resort_ref_id');
				$state_id=$this->input->post('state_id');
				$city_id=$this->input->post('city_id');

			} 
			
			$data =  array(
													
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
								
								'customer_status'			=>'1',
								
								'created_on'				=>date('Y-m-d')
								
														

						);
						
			$mess = $this->Customermodel->customerAdd($data,$location_id,$resort_id,$rf_id);
			
			
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
	}*/
	public function editCustomer($id){
		//echo $id;
		
		$country_list		= $this->Customermodel->countryList();
		$state_list			= $this->Customermodel->stateList();
		$city_list			= $this->Customermodel->cityList();
		
		
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
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_customer", $data);

		$this->load->view("common/footer-inner");

	}	
	
	public function RefidToCustomerList(){
		$data['customer_location_rfid_rels']		= $this->Customermodel->listCustomerLocationRfid();
		/* echo"<pre>";
		print_r($data['customer_location_event_relations']);
		die; */
		
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view('theme-v1/assign_refidto_customer',$data);
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
							
							'customer_firstname'		=>$this->input->post('customer_firstname'),
							
							'customer_middlename'		=>$this->input->post('customer_middlename'),
							
							'customer_lastname'			=>$this->input->post('customer_lastname'),
							
							'customer_email'			=>$this->input->post('customer_email'),
							
							'customer_mobile'			=>$this->input->post('customer_mobile'),
							
							'customer_password'			=>substr($this->input->post('customer_mobile'),-4),
							
							'customer_address'			=>$this->input->post('customer_address'),
							
							'customer_country_id'		=>$this->input->post('country_id'),
							
							'customer_state_id'			=>$this->input->post('state_id'),
							
							'customer_city_id'			=>$this->input->post('city_id'),
							
							'customer_zipcode'			=>$this->input->post('customer_zipcode'),
							
							'customer_status'			=>'1'							

						);


					$mess = $this->Customermodel->updateCustomerbyId($c_id, $data);
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
		
		$condition_customer_location_event_relation = "customer_id = '$id'";
		$checkon_location_event_relations = $this->Customermodel->isRecordExist('el_customer_location_event_relation',$condition_customer_location_event_relation);
		
		if(!empty($checkon_location_event_relations)){
			
			foreach($checkon_location_event_relations as $checkon_location_event_relation)
			{
				$data 		=  array('rel_status'=>'0');
				$condArr    =  array("customer_location_event_id" => $checkon_location_event_relation['customer_location_event_id']);
				$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_customer_location_event_relation',$condArr);
			}
			
		}
		
		$condition_customer_location_resort_relation = "customer_id = '$id'";
		$checkon_location_resort_relations = $this->Customermodel->isRecordExist('el_customer_location_resort_relation',$condition_customer_location_resort_relation);
		
		if(!empty($checkon_location_resort_relations)){
			
			foreach($checkon_location_resort_relations as $checkon_location_resort_relation)
			{
				$data 		=  array('status'=>'0');
				$condArr    =  array("resort_cust_location_relation_id" => $checkon_location_resort_relation['resort_cust_location_relation_id']);
				$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_customer_location_resort_relation',$condArr);
			}
			
		}
		
		
		$condition_customer_location_rfid_rel = "customer_id = '$id'";
		$checkon_location_rfid_rels = $this->Customermodel->isRecordExist('el_customer_location_rfid_rel',$condition_customer_location_rfid_rel);
		
		if(!empty($checkon_location_rfid_rels)){
			
			foreach($checkon_location_rfid_rels as $checkon_location_rfid_rel)
			{
				$data 		=  array('status'=>'0');
				$condArr    =  array("rel_id" => $checkon_location_rfid_rel['rel_id']);
				$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_customer_location_rfid_rel',$condArr);
			}
			
		}
		
		$condition_customer_photographer_relation = "customer_id = '$id'";
		$checkon_photographer_relations = $this->Customermodel->isRecordExist('el_media_customer_photographer_relation',$condition_customer_photographer_relation);
		
		if(!empty($checkon_photographer_relations)){
			
			foreach($checkon_photographer_relations as $checkon_photographer_relation)
			{
				$data 		=  array('rel_status'=>'0');
				$condArr    =  array("media_rel_id" => $checkon_photographer_relation['media_rel_id']);
				$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_media_customer_photographer_relation',$condArr);
			}
			
		}
		
		//$checkon_location_event_relations = $this->Customermodel->deleteLocationEventRelationbyId($id);
		
		/* echo"<pre>";
		print_r($checkon_location_event_relation);
		die; */
		
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
			
		$get_mailchimpList = $this->mailchimpmodel->activemailchimp();
					
		$get_mailchimpList_title = $get_mailchimpList[0]['title'];
		$get_mailchimpList_content = $get_mailchimpList[0]['content'];	
		
		$data = array(
"name"=>$get_mailchimpList_title,"html"=>"<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

$get_mailchimpList_content

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
				
				

				foreach($customer_lists as $user_list){
					$email = $user_list['customer_email'];
					
					$url = base_url().'/'.urlencode($email);
					$merge_fields = array('FNAME' => $user_list['customer_firstname'],'LNAME' => $user_list['customer_firstname'],'MMERGE4'=> 'http://192.168.2.160/elevation_new/CustomerPhotosMail/photodetailsTemp/'.urlencode($email));
		 
				$this->mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields );

					}
					
					
			/* echo"<pre>";
			print_r($get_mailchimpList);
			die; */

					// Create Template
					$this->mailchimp_template_status($api_key);
					//END
				redirect(base_url()."Customer/getMailchimpSubscribers");

	}
	public function RfidToCustomer(){
		
		$location_list		= $this->Customermodel->locationList();		
		
		if(!empty($location_list)){	
		$data['location_list']	= $location_list;
		}
		else{
			$data['location_list']	= '';
		}
		
		
		if(!empty($_POST)){
			
			$location_id	= $this->input->post('location_id');
			$resort_id		= $this->input->post('resort_id');
			if($this->input->post('resort_ref_id')=="")
			{
				$rf_id='0';
			}
			else{
					$rf_id=$this->input->post('resort_ref_id');
					
			}
			
				
				$customer_id	= $this->input->post('customer_list_id');
				$mess = $this->Customermodel->addCustomerwithRfId($location_id,$resort_id,$customer_id,$rf_id);
				if($mess==1){

					$this->session->set_flashdata("sucessPageMessage","Customer Assign Resort with RFID Successfully!");

					redirect(base_url()."Customer/RefidToCustomerList");

				}

		}
		else{

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_rfidwithcustomer',$data);

			$this->load->view("common/footer-inner");

		}

	}
	
	public function deleteRefidToCustomer($rel_id){
		$data 		=  array('rel_status'=>'0');
		$condArr    =  array("rel_id" => $rel_id);
		$update_rel_status = $this->Customermodel->deleteAssigneventCustomerId($data,'el_customer_location_rfid_rel',$condArr);
				
		if($update_rel_status == 1){
			$this->session->set_flashdata("sucessPageMessage","Assign Event To Customer Deleted Successfully!");
			redirect(base_url()."Customer/RefidToCustomerList");
		}
	}
	
}
