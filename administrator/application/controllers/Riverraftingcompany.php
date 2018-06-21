<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Riverraftingcompany extends CI_Controller {

	public function __construct(){

			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}	
			$this->load->model('Riverraftingcompanymodel');		
			//$this->load->model('resortmodel');
			//$this->load->model('Customermodel');
	}

	

	public function index(){
		$data['raftingcompany_list']	= $this->Riverraftingcompanymodel->index();
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/rafting_company/raftingcompany_list", $data);

		$this->load->view("common/footer-inner");
	}



	public function addRaftingcompany(){
		
	
		if(!empty($_POST)){
			$email 			= $this->input->post('raftingcompany_email');
			$mobile 		= $this->input->post('raftingcompany_mobile');
			$unique_email	= $this->Riverraftingcompanymodel->checkUniqueEmail($email);
			$unique_mobile	= $this->Riverraftingcompanymodel->checkUniquemobile($mobile);

			if($unique_email !='0'){
				$this->session->set_flashdata("pass_inc","This email is already added");

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/rafting_company/add_raftingcompany');

				$this->load->view("common/footer-inner");
			}
			else if($unique_mobile !='0'){
				$this->session->set_flashdata("pass_inc","This mobile is already added");

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/rafting_company/add_raftingcompany');

				$this->load->view("common/footer-inner");
				
			}
			
			else{
				
				$data =  array(
									'raftingcompany_name'		 => $this->input->post('raftingcompany_name'),
									
									'raftingcompany_email'		 => $this->input->post('raftingcompany_email'),
									
									'raftingcompany_mobile'		 => $mobile,

									'raftingcompany_description' => $this->input->post('raftingcompany_editor1'),
									
									'raftingcompany_status'		 => '1',
									
									'member_on'					 => date('Y-m-d')	

							);
				$mess = $this->Riverraftingcompanymodel->insertData($data,'el_raftingcompany');
				
				
				if($mess){
					
										
					$this->session->set_flashdata("sucessPageMessage","Rafting Company Added Successfully!");

					redirect(base_url()."Riverraftingcompany");

				}
			}
		}
		else{

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/rafting_company/add_raftingcompany');

				$this->load->view("common/footer-inner");

			}

	}

	

	public function editRaftingCompany($id){
		
		$data['raftingcompany_data'] = $this->Riverraftingcompanymodel->RiverraftingcompanyEdit($id);

		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/rafting_company/edit_raftingcompany", $data);

		$this->load->view("common/footer-inner");



	}
	
	
	
	

	public function updateRaftingCompany($riverraftingcompany_id){

		if(!empty($_POST)){
			$email 			= $this->input->post('raftingcompany_email');
			$mobile 		= $this->input->post('raftingcompany_mobile');
			$unique_email	= $this->Riverraftingcompanymodel->checkUniqueEmailInEdit($email,$riverraftingcompany_id);
			$unique_mobile	= $this->Riverraftingcompanymodel->checkUniquemobileInEdit($mobile,$riverraftingcompany_id);
			if($unique_email !='0'){
				$this->session->set_flashdata("pass_inc","This email is already added");

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/rafting_company/edit_raftingcompany'.$riverraftingcompany_id.'/');

				$this->load->view("common/footer-inner");
			}
			else if($unique_mobile !='0'){
				$this->session->set_flashdata("pass_inc","This mobile is already added");

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/rafting_company/edit_raftingcompany'.$riverraftingcompany_id.'/');

				$this->load->view("common/footer-inner");
				
			}
			else{
			
			$data =  array(

							'raftingcompany_name'			=>$this->input->post('raftingcompany_name'),
							
							'raftingcompany_email'			=>$this->input->post('raftingcompany_email'),
							
							'raftingcompany_mobile'			=>$this->input->post('raftingcompany_mobile'),

							'raftingcompany_description'	=>$this->input->post('raftingcompany_editor1'),
							
							'raftingcompany_status'			=>'1'					

						);


					$mess = $this->Riverraftingcompanymodel->updateRiverraftingbyId($riverraftingcompany_id, $data);
						if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","Rafting Company updated Successfully!");

							redirect(base_url()."Riverraftingcompany");

						} 
			}
		} else{

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/rafting_company/edit_raftingcompany'.$riverraftingcompany_id.'/');

				$this->load->view("common/footer-inner");

			}



	}

	

	public function deleteRaftingCompany($id){

		$this->Riverraftingcompanymodel->deleteRaftingCompanybyId($id);
					
		$update_rel_status = $this->Riverraftingcompanymodel->deleteRaftingCompanybyId($id);
			
		
		$this->session->set_flashdata("sucessPageMessage","Rafting Company Deleted Successfully!");
		
		redirect(base_url()."Riverraftingcompany/");



	}



}

