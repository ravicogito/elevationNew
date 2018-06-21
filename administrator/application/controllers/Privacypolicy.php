<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Privacypolicy extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Privacypolicymodel');
			
	}


	public function index(){


			$data['contents']= $this->Privacypolicymodel->index();
			//print_r($contents);
			//exit;		
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/privacy_policy_list", $data);
			$this->load->view("common/footer-inner");
		
	}

	public function addPrivacyPolicy(){
	if(!empty($_POST)){
		$data =  array(
						'policy_question'=>$this->input->post('ptitle'),
						'policy_answer'=>	$this->input->post('editor1'),
						'policy_status'=>	'1',
						'createon'=>date('Y-m-d')
					);

		

					$mess = $this->Privacypolicymodel->addPrivacypolicy($data);

					if($mess==1){

						$this->session->set_flashdata("sucessPageMessage","New Privacy policy Added Successfully!");
						redirect(base_url()."Privacypolicy");
					} 
	} else{
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view('theme-v1/add_privacy_policy');
			$this->load->view("common/footer-inner");
		}
			
	}

	public function editPrivacyPolicy(){

		$id = $this->uri->segment(3);
		//echo $id;
		$data['contents'] = $this->Privacypolicymodel->Privacypolicyedit($id);
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/edit_privacy_policy", $data);
		$this->load->view("common/footer-inner");

	}

	public function updatePrivacyPolicy(){

		$faq_id  = $this->input->post('faq_id');

		if(!empty($_POST)){
			
			$data =  array(

							'policy_question'	=>$this->input->post('ptitle'),

							'policy_answer'	=>$this->input->post('editor1'),

						);


					$mess = $this->Privacypolicymodel->updatePrivacypolicybyId($faq_id, $data);
						if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","Privacy policy updated Successfully!");

							redirect(base_url()."Privacypolicy/editPrivacyPolicy/".$faq_id."/");

						} 

		} else{
				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/edit_privacy_policy'.$page_id.'/');
				$this->load->view("common/footer-inner");
			}

	}

	//Delete Page

	public function deletePrivacyPolicy(){

		$fid = $this->uri->segment(3);
		// echo $id;
		// exit;
		$this->Privacypolicymodel->deletePrivacypolicybyId($fid);
		redirect(base_url()."Privacypolicy/");

	}


	
	


}
