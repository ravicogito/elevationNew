<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('faqmodel');
			
	}


	public function index(){


			$data['contents']= $this->faqmodel->index();
			//print_r($contents);
			//exit;		
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/faq_list", $data);
			$this->load->view("common/footer-inner");
		
	}

	public function addFaq(){
	if(!empty($_POST)){
		$data =  array(
						'faq_question'=>$this->input->post('ptitle'),
						'faq_answer'=>	$this->input->post('editor1'),
						'faq_status'=>	'1',
						'createon'=>date('Y-m-d')
					);

		

					$mess = $this->faqmodel->addFaqs($data);

					if($mess==1){

						$this->session->set_flashdata("sucessPageMessage","FAQ Added Successfully!");
						redirect(base_url()."Faq/");
					} 
	} else{
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view('theme-v1/add_faq');
			$this->load->view("common/footer-inner");
		}
			
	}

	public function editFaq(){

		$id = $this->uri->segment(3);
		//echo $id;
		$data['contents'] = $this->faqmodel->Faqedit($id);
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/edit_faq", $data);
		$this->load->view("common/footer-inner");

	}

	public function updateFaq(){

		$faq_id  = $this->input->post('faq_id');

		if(!empty($_POST)){
			
			$data =  array(

							'faq_question'	=>$this->input->post('ptitle'),

							'faq_answer'	=>$this->input->post('editor1'),

						);


					$mess = $this->faqmodel->updateFaqbyId($faq_id, $data);
						if($mess==1){



							$this->session->set_flashdata("sucessPageMessage","Faq updated Successfully!");

							redirect(base_url()."Faq/editFaq/".$faq_id."/");

						} 

		} else{
				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/editFaq'.$page_id.'/');
				$this->load->view("common/footer-inner");
			}

	}

	//Delete Page

	public function deleteFaq(){

		$fid = $this->uri->segment(3);
		// echo $id;
		// exit;
		$this->faqmodel->deleteFaqbyId($fid);
		redirect(base_url()."Faq/");

	}


	
	


}
