<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mailchimp extends CI_Controller {
	public function __construct(){
			parent::__construct();


			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('mailchimpmodel');
	}

	public function addmailchimp($id = ""){
		
		$check_mailchimp_existid = $this->mailchimpmodel->Mailchimpedit($id);
		/* echo"<pre>";
		print_r($check_mailchimp_existid);
		die; */
		$mail_title = $this->input->post('ptitle');
		$mail_content = $this->input->post('editor1');
		$hidds_id = $this->input->post('hidds');
		if(!empty($check_mailchimp_existid))
		{
			$data['mailchimp_row_data'] = $check_mailchimp_existid;
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/add_mailchimp_template",$data);
			$this->load->view("common/footer-inner");
			
			if($_POST){
					if(!empty($mail_title) && !empty($mail_content))
					{
						$data =  array(
										'title'			=> $mail_title,
										'content'		=> $mail_content
									);
									
						$mess = $this->mailchimpmodel->editMailchimpdata($data,$hidds_id);
						
						if($mess){

							$this->session->set_flashdata("sucessPageMessage","New Mailchimp Added Successfully!");
							redirect(base_url()."Mailchimp/mailchimplist/");
						}
						
					}
					
					else{
						$this->session->set_flashdata("failedPageMessage","New Mailchimp Added Failed!");
						redirect(base_url()."Mailchimp/mailchimplist/");
					}
			}
		}
		
		else{
			if($_POST){
				if(empty($hidds_id)){
					if(!empty($mail_title) && !empty($mail_content))
					{
						$data =  array(
										'title'			=> $mail_title,
										'content'		=> $mail_content,
										'creation_date' => date('Y-m-d H:i:s')
									);
						$mess = $this->mailchimpmodel->addMailchimp($data);
						
						if($mess){

							$this->session->set_flashdata("sucessPageMessage","New Mailchimp Edit Successfully!");
							redirect(base_url()."Mailchimp/mailchimplist/");
						}
						
					}
					
					else{
						$this->session->set_flashdata("failedPageMessage","New Mailchimp Edit Failed!");
						redirect(base_url()."Mailchimp/mailchimplist/");
					}
				}
				
			}
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/add_mailchimp_template");
			$this->load->view("common/footer-inner");
		}
		
	}
	
	public function updatePage(){

		$page_id  = $this->input->post('page_id');

		$data = array(
			'ptitle'=>$this->input->post('ptitle'),
			'content'=>$this->input->post('editor1'),
			);
		if($data['ptitle']!="" && $data['content']!=""){
				$mess = $this->pagemodel->updatePagebyId($page_id, $data);


					if($mess==1){

						$this->session->set_flashdata("sucessPageMessage","Page updated Successfully!");
						redirect(base_url()."Page/editPage/".$page_id."/");
					} 
		} else{
				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/editPage'.$page_id.'/');
				$this->load->view("common/footer-inner");
			}

	}
	
	public function deletemailchimp($id = ""){

		$this->mailchimpmodel->deleteMailchimpdata($id);
		redirect(base_url()."Mailchimp/mailchimplist/");

	}
	
	public function publishmailchimp($id = ""){

		$data =  array(
						'status'			=> 1
					);
					
		$check_publish_data = $this->mailchimpmodel->checkpublishMailchimpdata();
		//print_r($check_publish_data);
		
		if(!empty($check_publish_data)){
			$data1 =  array(
						'status'			=> 0
					);
					
			$this->mailchimpmodel->publishMailchimpdata($data1,$check_publish_data['id']);
			
		}
		
		$this->mailchimpmodel->publishMailchimpdata($data,$id);
		
		
		//$unpublish_mailchimp = $this->mailchimpmodel->unpublishMailchimpdata();
					
		
		redirect(base_url()."Mailchimp/mailchimplist/");

	}
	
	public function unpublishmailchimp($id = ""){

		$data =  array(
						'status'			=> 0
					);
					
	/* 	$check_publish_data = $this->mailchimpmodel->checkpublishMailchimpdata();
		//print_r($check_publish_data);
		
		if(!empty($check_publish_data)){
			$data1 =  array(
						'status'			=> 0
					);
					
			$this->mailchimpmodel->publishMailchimpdata($data1,$check_publish_data['id']);
			
		} */
		
		$this->mailchimpmodel->publishMailchimpdata($data,$id);
		
		
		//$unpublish_mailchimp = $this->mailchimpmodel->unpublishMailchimpdata();
					
		
		redirect(base_url()."Mailchimp/mailchimplist/");

	}
	
	public function mailchimplist(){
		
		$data['mailchimp_lists']= $this->mailchimpmodel->allmailchimpList();
		
		/* echo"<pre>";
		print_r($data['mailchimp_lists']);
		die; */
		
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/list_all_mailchimp",$data);
		$this->load->view("common/footer-inner");
	}
}
