<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class dashboard extends CI_Controller{
		function __construct(){
			parent::__construct();
			if($this->session->userdata('userId') =='') {
				redirect(base_url());
			}
			$this->load->model('model_common');
			$this->layout->setLayout('common_layout');
		} 
		public function index(){
			$this->layout->view('templates/admin/dashboard');
		}
		
		public function settings(){
			
		$viewData = array();
       	$viewData['errorMsg'] = "";
		$viewData["successMsg"] = "";
		$where = array("user_id" => 1);
        $tbl = "anad_admin";
		
		if ($this->input->post('settings')) {
			
			$data['password'] = trim($this->input->post('password'));
            $data['user_email'] = trim($this->input->post('email'));
            $dd = $this->model_common->updateDataToTable($tbl, $where, $data);
			if ($dd) {
                $this->session->set_flashdata("successMsg", "You have successfully updated the settings.");
                redirect(base_url() . "admin/dashboard/settings");
            } else {
                $this->session->set_flashdata("errorMsg", "Please try again.");
               	redirect(base_url() . "admin/dashboard/settings");
            }
		
		}
		
			$selectedData = "";
			$list = $this->model_common->fetchDataFromTable($tbl, $where, $selectedData);
			$viewData['password'] = $list[0]->password;
			$viewData['email'] = $list[0]->user_email;
			//print_r($viewData);
			
			$this->layout->view('templates/admin/settings', $viewData);
		}
		
	}
?>