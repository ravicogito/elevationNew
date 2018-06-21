<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Locations extends CI_Controller {
	public function __construct(){
			parent::__construct();


			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Locationmodel');
			
	}
	
	public function listlocations($id = ''){
		
		$front_url = $this->config->item('front_url');
		
		$data['location_lists']= $this->Locationmodel->alllocationList();
		
		
		$data['front_url'] = $front_url;
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/list_location", $data);
			$this->load->view("common/footer-inner");
		
	}
	
	public function addLocation(){
		
	if(!empty($_POST)){
		$location_name  			= $this->input->post('location_name');
		$is_location_refid_exists	= $this->input->post('location_ref_id');
		$mess						= '';							
			if(!empty($_FILES['location_image']['name'])){	
                $_FILES['location_image']['name'] 		= $_FILES['location_image']['name'];
				$_FILES['location_image']['type'] 		= $_FILES['location_image']['type'];
                $_FILES['location_image']['tmp_name'] 	= $_FILES['location_image']['tmp_name'];
                $_FILES['location_image']['error']   	= $_FILES['location_image']['error'];
                $_FILES['location_image']['size'] 		= $_FILES['location_image']['size'];
                $config['allowed_types'] 				= 'gif|jpg|png|jpeg';
				$config['overwrite'] 					= FALSE;
				$config['remove_spaces'] 				= TRUE;
				$config['upload_path'] = '../uploads/locations/';
                $this->load->library('upload', $config);
				
				
				 if (!$this->upload->do_upload('location_image'))
					{
						 $error = array('error' => $this->upload->display_errors());
                         print_r($this->upload->display_errors());
					}
					else
					{
							$fileData = $this->upload->data();	
							$data =  array(
										'location_name'						=>$location_name,
										
										'location_image'					=>$fileData['file_name'],
										'location_status'					=>'1'
										);	
										print_r($data);
					
						$mess = $this->Locationmodel->addLocation($data);
							
					}               
          

		
		if($mess){


			$this->session->set_flashdata("sucessPageMessage","Location Added Successfully!");



			redirect(base_url()."Locations/listlocations");
		} 
	} }		
	else{

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_location');

			$this->load->view("common/footer-inner");

		}
	}
	
	
	public function editLocation($id){
		
		$front_url = $this->config->item('front_url');
		
		$data['front_url'] = $front_url;
		
        $data['location_data'] = $this->Locationmodel->LocationDataEdit($id);
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_location", $data);

		$this->load->view("common/footer-inner");



	}	
	
	public function updateLocation($id){

		if(!empty($_POST)){
			
			$location_name  			= $this->input->post('location_name');
			$is_location_refid_exists	= $this->input->post('location_ref_id');
			$mess						= '';							
			if(!empty($_FILES['location_image']['name'])){
				$location_data = $this->Locationmodel->LocationDataEdit($id);
                $old_file=$location_data['location_image'];
				if(!empty($old_file))
				{
					unlink('../uploads/locations/'.$old_file);
				}

			
                $_FILES['location_image']['name'] 		= $_FILES['location_image']['name'];
				$_FILES['location_image']['type'] 		= $_FILES['location_image']['type'];
                $_FILES['location_image']['tmp_name'] 	= $_FILES['location_image']['tmp_name'];
                $_FILES['location_image']['error']   	= $_FILES['location_image']['error'];
                $_FILES['location_image']['size'] 		= $_FILES['location_image']['size'];
                $config['allowed_types'] 				= 'gif|jpg|png|jpeg';
				$config['overwrite'] 					= FALSE;
				$config['remove_spaces'] 				= TRUE;
				$config['upload_path'] = '../uploads/locations/';
                $this->load->library('upload', $config);
				
				
				 if (!$this->upload->do_upload('location_image'))
					{
						   $error = array('error' => $this->upload->display_errors());
						   
					}
					else
					{
						$fileData = $this->upload->data();
						$data =  array(

							'location_name'						=>$location_name,
							
							'location_image'					=>$fileData['file_name'],
							'location_status'					=>'1'
						);


					$mess = $this->Locationmodel->updateLocationbyId($id, $data);
					}
						if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","Location details updated Successfully!");

							redirect(base_url()."Locations/listlocations");

						} 
            }
			else{
				
				$data =  array(

							'location_name'						=>$location_name,
							
							'location_status'					=>'1'
						);


					$mess = $this->Locationmodel->updateLocationbyId($id, $data);
					if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","Location details updated Successfully!");

							redirect(base_url()."Locations/listlocations");

						}
			}			
		} else{

				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/edit_location'.$id.'/');

				$this->load->view("common/footer-inner");

			}



	}
	
	
	public function deleteLocation($id){

		$this->Locationmodel->deleteLocationbyId($id);
		
		$this->session->set_flashdata("sucessPageMessage","Location details Deleted Successfully!");

		redirect(base_url()."Locations/listlocations");
	}
	
	
}
	