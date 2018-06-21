<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RaftingCompany extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Eventmodel');			
			
	}
	
	public function addCompany()
	{
		$this->load->view('theme-v1/add_rafting',$data);
	}
}