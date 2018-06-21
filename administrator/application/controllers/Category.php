<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Categorymodel');			
	}

	public function addCategory($id = '')
	{
		$data['all_category'] = $this->Categorymodel->editCategory($id);
		/* echo"<pre>";
		print_r($data['all_categories']);
		die; */
		
		$get_cat_name = $this->input->post('category_name');
		$get_hid_id = $this->input->post('hid');
		
		if(!empty($get_hid_id))
		{
			$data = array('cat_name' => $get_cat_name,'updated_on' => date('Y-m-d'));
			$table = 'el_category';
			
			$update_category = $this->Categorymodel->updatecategory($table,$data,$id);
			
			if($update_category == 1)
			{
				$this->session->set_flashdata('ins_success','Category Update Successfully');
				redirect(base_url()."Category/allCategory");	
			}
			else{
				$this->session->set_flashdata('ins_failed','Category Update Failed');
			}
		}
		
		else{
			if(!empty($_POST))
			{
				$data = array('cat_name' => $get_cat_name,'created_on' => date('Y-m-d'),'cat_status' => '1');
				$table = 'el_category';
				
				$ins_category = $this->Categorymodel->addCategory($table,$data);
				
				if($ins_category !=0)
				{
					$this->session->set_flashdata('ins_success','Category Insert Successfully');
					redirect(base_url()."Category/allCategory");
				}
				else{
					$this->session->set_flashdata('ins_failed','Category Insert Failed');
				}
			}
		}
		
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/add_category",$data);
		$this->load->view("common/footer-inner");
	}
	
	public function allCategory()
	{
		$data['all_categories'] = $this->Categorymodel->allCategory();
		
		/* echo"<pre>";
		print_r($data['all_categories']);
		die; */
		$this->load->view("common/header");
		$this->load->view("common/sidebar");
		$this->load->view("theme-v1/all_category",$data);
		$this->load->view("common/footer-inner");
	}
	public function index()
	{
		$this->allCategory();
	}
	
	public function deleteCategory($id = '')
	{
		$check_category_status = $this->Categorymodel->isExistRecord($id);
		
		if(!empty($check_category_status)){
			$data = array('cat_status' => '0');
			$table = 'el_category';
			
			$delete_category = $this->Categorymodel->updatecategory($table,$data,$id);
				
				if($delete_category == 1)
				{
					$this->session->set_flashdata('ins_success','Category Deleted Successfully');
					redirect(base_url()."Category/allCategory");	
				}
				else{
					$this->session->set_flashdata('ins_failed','Category Delete Failed');
				}
		}
		else{
			$this->session->set_flashdata('ins_failed','Record not exist');
		}
	}
}
	
	