<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Resort extends CI_Controller {
	public function __construct(){
			parent::__construct();			if($this->session->userdata('admin_user_id') =='') {				redirect(base_url());			}	
			$this->load->model('resortmodel');	
			$this->load->model('Customermodel');			
	}
	
	public function index(){
		$data['resort_data']= $this->resortmodel->index();
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/resort_list", $data);
		$this->load->view("common/footer-inner");
	}

	public function addResort(){
		
		if(!empty($_POST)){
			$email 			= $this->input->post('resort_email');
			$mobile 		= $this->input->post('resort_mobile');
			$unique_email	= $this->resortmodel->checkUniqueEmail($email);
			$unique_mobile	= $this->resortmodel->checkUniquemobile($mobile);
			$location_list		= $this->Customermodel->locationList();	
			if(!empty($location_list)){	
			$data['location_list']	= $location_list;	
			}
			if($unique_email !='0'){
				$this->session->set_flashdata("pass_inc","This email is already added");

				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/add_resort',$data);
				$this->load->view("common/footer-inner");
			}
			else if($unique_mobile !='0'){
				$this->session->set_flashdata("pass_inc","This mobile is already added");

				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/add_resort',$data);
				$this->load->view("common/footer-inner");
				
			}
			else{
				$data =  array(	'resort_id'							=>'',
								'location_id'						=>$this->input->post('location_id'), 
								'resort_name'						=>$this->input->post('resort_name'),
								'resort_desc'						=>$this->input->post('resort_location'),
								'resort_email'						=>$this->input->post('resort_email'),
								'resort_mobile'						=>$this->input->post('resort_mobile'),	
								'resort_contact_person'				=>$this->input->post('resort_contact_person'),
								'is_location_resort_refid_exists'	=>$this->input->post('resort_ref_id'),
								'resort_insert_date'	=>date('Y-m-d'),
								'resort_status'			=>'1'					
							);
				$mess = $this->resortmodel->addResorts($data);
				if($mess){
					$this->session->set_flashdata("sucessPageMessage","Resort Added Successfully!");
					redirect(base_url()."Resort");
				}
			}
		}	
		else{
			$location_list		= $this->Customermodel->locationList();	
			if(!empty($location_list)){	
			$data['location_list']	= $location_list;	
			}
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view('theme-v1/add_resort',$data);
			$this->load->view("common/footer-inner");
		}
	}
	
	public function editResort($id){
		$data['resort_data'] = $this->resortmodel->Resortedit($id);	
		$location_list		= $this->Customermodel->locationList();	
			if(!empty($location_list)){	
			$data['location_list']	= $location_list;	
			}		
		if(!empty($data['resort_data'])){
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/edit_resort", $data);
			$this->load->view("common/footer-inner");		
		}		
		else{						
			redirect(base_url()."Resort/");		
		}		

	}
	
	public function updateResort($post_id){		
	if(!empty($_POST)){	
		$email 			= $this->input->post('resort_email');
		$mobile 		= $this->input->post('resort_mobile');
		$unique_email	= $this->resortmodel->checkUniqueEmailInEdit($email,$post_id);
		$unique_mobile	= $this->resortmodel->checkUniquemobileInEdit($mobile,$post_id);
		if($unique_email !='0'){
			$this->session->set_flashdata("pass_inc","This email is already added");

			redirect(base_url()."Resort/editResort/".$post_id);
		}
		else if($unique_mobile !='0'){
			$this->session->set_flashdata("pass_inc","This mobile is already added");

			redirect(base_url()."Resort/editResort/".$post_id);
			
		}
		else{
		$data =  array(	'resort_name'						=>$this->input->post('resort_name'),
						'resort_desc'						=>$this->input->post('resort_location'),
						'resort_email'						=>$this->input->post('resort_email'),
						'resort_mobile'						=>$this->input->post('resort_mobile'),	'resort_contact_person'				=>$this->input->post('resort_contact_person'),
						'is_location_resort_refid_exists'	=>$this->input->post('resort_ref_id'),
						'resort_insert_date'				=>date('Y-m-d'),							
						'resort_status'						=>'1'										
					);
				$mess = $this->resortmodel->updateResortbyId($post_id, $data);
				if($mess==1){

					$this->session->set_flashdata("sucessPageMessage","Resort updated Successfully!");
					redirect(base_url()."Resort");
				} 
		}
	} else{
			redirect(base_url()."Resort/editResort/".$post_id);
	}

	}
	
	public function deleteResort($id){
		$this->resortmodel->deleteResortbyId($id);
		redirect(base_url()."Resort/");
	}

}
