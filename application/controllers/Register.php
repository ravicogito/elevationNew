<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
		private $data;
		private $theme;
		public $elements;
		public $elements_data;
		
		function __construct(){
			
			parent::__construct();
			$this->elements 					= array();
			$this->elements_data 				= array();
			$this->data 						= array();	
			$this->load->model(array('model_login','model_home','Customermodel'));
		   // $this->load->library( 'nativesession' );	
		    $this->data['userID']		= $this->session->userdata('customer_id');
			$userID						= $this->data['userID'];
			if(!empty($userID)) {
				redirect(base_url());
			}  
			$this->layout->setLayout('inner_layout');
		}
		
		public function index()
		{
			//print_r($_SESSION['href']);die;
			$this->data['contentTitle']				= "Registration";
				
			if(!empty($_POST)){
		
				$email 			= $this->input->post('customer_email');
				$mobile 		= $this->input->post('customer_mobile');
				
				$customer_firstname 		= $this->input->post('customer_firstname');
				$customer_newpass 			= $this->input->post('customer_newpass');
				$customer_lastname 			= $this->input->post('customer_lastname');
				
				
				$unique_email	= $this->Customermodel->checkUniqueEmail($email);
				$unique_mobile	= $this->Customermodel->checkUniquemobile($mobile);
				//echo $unique_email;exit;
				
				$this->session->set_flashdata("customer_firstname",$customer_firstname);
				$this->session->set_flashdata("customer_lastname",$customer_lastname);
				$this->session->set_flashdata("customer_email",$email);
				$this->session->set_flashdata("customer_mobile",$mobile);
				
				if($unique_email !='0'){
					$this->session->set_flashdata("pass_inc","This email is already added");

					$this->layout->view('templates/Home/registration',$this->data);
				}
				else if($unique_mobile !='0'){
					$this->session->set_flashdata("pass_inc","This mobile is already added");

					$this->layout->view('templates/Home/registration',$this->data);
					
				}
				else{
				
					
					$data =  array(
													
								'customer_firstname'		=>$this->input->post('customer_firstname'),
								
								'customer_middlename'		=>'',
								
								'customer_lastname'			=>$this->input->post('customer_lastname'),
								
								'customer_email'			=>$this->input->post('customer_email'),
								
								'customer_mobile'			=>$this->input->post('customer_mobile'),
								
								'customer_password'			=>$customer_newpass,
								
								'customer_address'			=>'',
								
								'customer_country_id'		=>'0',
								
								'customer_state_id'			=>'0',
								
								'customer_city_id'			=>'0',
								
								'customer_zipcode'			=>'',
								
								'customer_status'			=>'1',
								
								'created_on'				=>date('Y-m-d')
								
														

						);
								
					$mess = $this->Customermodel->customerAdd($data);
					
					
					if($mess){
						//$this->session->set_flashdata("sucessPageMessage","New Customer Added Successfully!");
						
						$this->data['customer_name'] = $customer_firstname;
						$this->data['password'] = $customer_newpass;
						$this->data['emailData'] = $email;
						$this->data['mobile'] = $mobile;
						
						$this->load->library('email');
						$config['charset'] 		= 'iso-8859-1';
						$config['mailtype'] 	= 'html';
						$this->email->initialize($config);
						$this->email->from('no-reply@elevation.com', 'Elevation Photography');
						$this->email->to($email);
						$this->email->subject('Account Creation');
						//$this->layout->view('templates/cart/order-mailtocustomer',$this->data);
						$mailBody				= $this->load->view('templates/Home/registration_mail', $this->data, true);
						$this->email->message($mailBody);
						$this->email->send();

						$this->session->set_userdata('customer_id', $mess);
						$this->session->set_userdata('customer_email', $email);
						$this->session->set_userdata('customer_fname', $customer_firstname);			
						$this->session->set_userdata('customer_mobile', $mobile);
						
						$event_id = explode('/',$_SESSION['href']);
						
						$check_users = $this->Customermodel->isExist($event_id[6],$mess);
						if($check_users =='0')
						{
							$data = array('event_id' => $event_id[6],'customer_id' => $mess,'assign_date' => date('Y-m-d'));
							$this->Customermodel->insCustomerEventRel($data);
						}
						
						redirect($_SESSION['href']);
						unset($_SESSION['href']);

					}
				}
					
			}
			$this->layout->view('templates/Home/registration',$this->data);	
		}
		
		public function checkUser()
		{
			$recArr = array();
			
			$user_email				    = $this->input->post('customer_email');
			
			$get_user_existByemail = $this->Customermodel->getUserExistByemail($user_email);
			//echo"<pre>";
			//print_r($get_user_existByemail['customer_firstname']);die;
			
			if(!empty($get_user_existByemail))
			{
				$recArr['customer_data'] 	= 'true';
			}
			else{
				$recArr['customer_data'] = 'false';
			}
			
			echo json_encode($recArr);
			
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
}