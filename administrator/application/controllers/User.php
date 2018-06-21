<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	public function __construct(){
			parent::__construct();


			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Usermodel');
			$this->load->model('Rolemodel');
			
	}
	
	
	public function listuser($id = ''){
		
		$front_url = $this->config->item('front_url');
		
		$data['user_lists']= $this->Usermodel->alluserList();
		
		//print_r($data['user_lists']);die;
		$data['front_url'] = $front_url;
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/list_user", $data);
			$this->load->view("common/footer-inner");
		
	}
	
	public function addUser(){
	$role_list		= $this->Usermodel->roleList();
    if(!empty($role_list)){	
		$data['role_list']	=$role_list;	
	}	
	
	if(!empty($_POST)){
		
		$data =  array(
		                    'name'						=>$this->input->post('name'), 
							'username'					=>$this->input->post('username'),
							'password'					=>$this->input->post('password'),
							'email'						=>$this->input->post('email'),
							'user_status'				=>'1'							

					);
		$mess = $this->Usermodel->userAdd($data);
		
		
		if($mess){
			$this->session->set_flashdata("sucessPageMessage","New User Added Successfully!");

			redirect(base_url()."User/listuser");

		}
	}
	else{

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_user',$data);

			$this->load->view("common/footer-inner");

		}
	}
	
	public function editUser($id){
		
		$role_list		= $this->Usermodel->roleList();
		if(!empty($role_list)){	
			$data['role_list']	=$role_list;	
		}
	
	
		$data['user_data'] = $this->Usermodel->UserDataEdit($id);

		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_user", $data);

		$this->load->view("common/footer-inner");



	}	
	
	public function updateUser($user_id){

		if(!empty($_POST)){
						
			$data =  array(

							'name'						=>$this->input->post('name'), 
							'username'					=>$this->input->post('username'),
							'password'					=>$this->input->post('password'),
							'email'						=>$this->input->post('email'),
							'user_status'				=>'1'								

						);


					$mess = $this->Usermodel->updateUserbyId($user_id, $data);
						if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","User details updated Successfully!");

							redirect(base_url()."User/listuser");

						} 

		} else{

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/edit_user'.$user_id.'/');

				$this->load->view("common/footer-inner");

			}



	}
	
}	
	