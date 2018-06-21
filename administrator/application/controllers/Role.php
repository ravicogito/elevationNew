<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Role extends CI_Controller {
	public function __construct(){
			parent::__construct();


			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Rolemodel');
			
	}
	
	
	public function listrole($id = ''){
		
		$front_url = $this->config->item('front_url');
		
		$data['role_lists']= $this->Rolemodel->allroleList();
		
		
		$data['front_url'] = $front_url;
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/list_role", $data);
			$this->load->view("common/footer-inner");
		
	}
	
	public function addRole(){
		
	
	if(!empty($_POST)){
		
		$data =  array(
							'role_name'					=>$this->input->post('role_name'),
							'role_status'				=>'1'					

					);
		$mess = $this->Rolemodel->roleAdd($data);
		
		
		if($mess){
			$this->session->set_flashdata("sucessPageMessage","New Role Added Successfully!");

			redirect(base_url()."Role/listrole");

		}
	}
	else{

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_role');

			$this->load->view("common/footer-inner");

		}
	}
	
	public function editRole($id){
		
		$data['role_data'] = $this->Rolemodel->RoleDataEdit($id);

		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_role", $data);

		$this->load->view("common/footer-inner");



	}	
	
	public function updateRole($role_id){

		if(!empty($_POST)){
						
			$data =  array(

							'role_name'					=>$this->input->post('role_name'),
							'role_status'				=>'1'							

						);


					$mess = $this->Rolemodel->updateRolebyId($role_id, $data);
						if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","Role details updated Successfully!");

							redirect(base_url()."Role/listrole");

						} 

		} else{

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/edit_role'.$role_id.'/');

				$this->load->view("common/footer-inner");

			}



	}
	
}	
	