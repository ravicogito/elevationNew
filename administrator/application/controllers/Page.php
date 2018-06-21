<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends CI_Controller {
	public function __construct(){
			parent::__construct();
			$this->load->model('Pagemodel');
			if($this->session->userdata('admin_user_id')==''){
			  redirect(base_url());
			}
			
	}


	public function listpages($id = ''){

            $front_url = $this->config->item('front_url');
			$data['front_url'] = $front_url;
			$data['contents']= $this->Pagemodel->allpageList();
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/page", $data);
			$this->load->view("common/footer-inner");
		
	}

	public function addPage(){

		if(count($_POST)>0){
			
			$ptitle  			= $this->input->post('ptitle');
			$meta_title 		= $this->input->post('meta_title');
			$meta_keywords  	= $this->input->post('meta_keywords');
			$meta_description  	= $this->input->post('meta_description');
			$page_description  	= $this->input->post('editor1');
			
			
			$page_title_explode = explode(' ',$ptitle);
			$page_title_implode = implode('-',$page_title_explode);
			$meta_title_check = $this->Pagemodel->checkMetaTitle($page_title_implode);
			//echo"<pre>";
			//print_r($meta_title_check);die;
			if($meta_title_check > 0)
			{
				$seo_title_get = $meta_title_check['seo_title'];
				$get_last_number = strrev((int)strrev($seo_title_get));
				/* if(!empty($get_last_number))
				{
					$get_last_number = 0;
				}
				else{
					$get_last_number = $get_last_number;
				} */
				$seotitle_val = $seo_title_get.($get_last_number+1);
				
				$meta_title_checkN = $this->Pagemodel->checkMetaTitle($seotitle_val);
				/* if(!empty($meta_title_checkN)){
					$seo_title_getN = $meta_title_checkN['seo_title'];
					$get_last_numberN = strrev((int)strrev($seo_title_getN));
					$seotitle_val = $seo_title_getN.($get_last_numberN+1);
				}
				else{
					$seotitle_val = $seotitle_val;
				} */
			}
			else{
				$seotitle_val = $page_title_implode;
			}
			
			
			$data =  array(
					'page_title'			=> $ptitle,
					'page_description'		=> $page_description,
					'seo_title'				=> $seotitle_val,
					'page_meta_title'		=> $meta_title,
					'page_meta_keywords'	=> $meta_keywords,
					'created_on'			=> date('Y-m-d H:i:s'),
					'page_status'			=> '1',
					'page_meta_description'	=> $meta_description
				);

			$mess = $this->Pagemodel->addPages($data);

			if($mess==1){

				$this->session->set_flashdata("sucessPageMessage","Page Added Successfully!");
				redirect(base_url()."Page/listpages/");
			} 
		} else{
				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/add_Page');
				$this->load->view("common/footer-inner");
			}
		
		
		
	}

	public function editPage(){

		$id = $this->uri->segment(3);
		//echo $id;
		$data['contents'] = $this->Pagemodel->Pageedit($id);
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/edit_Page", $data);
		$this->load->view("common/footer-inner");

	}

	public function updatePage(){

		$page_id  = $this->input->post('page_id');

		$data = array(
			'ptitle'=>$this->input->post('ptitle'),
			'content'=>$this->input->post('editor1'),
			);
		if($data['ptitle']!="" && $data['content']!=""){
				$mess = $this->Pagemodel->updatePagebyId($page_id, $data);


					if($mess==1){

						$this->session->set_flashdata("sucessPageMessage","Page updated Successfully!");
						redirect(base_url()."Page/editPage/".$page_id."/");
					} 
		} else{
				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/edit_Page'.$page_id.'/');
				$this->load->view("common/footer-inner");
			}

	}

	//Delete Page

	public function deletePage(){

		$id = $this->uri->segment(3);
		$this->Pagemodel->deletePagebyId($id);
		redirect(base_url()."Page/listpages");

	}


	
	


}
