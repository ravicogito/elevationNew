<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct(){
			parent::__construct();
			$this->load->model('loginmodel');
	}


	public function index(){
		$this->load->view("theme-v1/login");		
	}


	public function auth() {
		$data 			= array();
			if($_POST){
				$id = $this->input->post('username');
				$password = $this->input->post('password');
				if(!empty($id) && !empty($password)){
					$authenticate = $this->loginmodel->authentication($id,$password);
					//print_r($this->session->all_userdata());
					$sess_data = $this->session->userdata('admin_user_id');		
					//echo $sess_data;exit;	
					if($authenticate==true && $sess_data!=''){
						redirect(base_url()."Customer/listcustomer");						

					}else{
						$this->session->set_flashdata("errMsg","Login credentials mismatch.Please re-enter login id and password.");
						redirect(base_url());
					}
				}else{
					$this->session->set_flashdata("errMsg","Please input login id and password.");
					redirect(base_url());

				}
			}

	}
	public function change_password() {
		
		$admin_id	= $this->session->userdata('admin_user_id');
		
        if ($admin_id != '') {
            $render_data = array();

            if (isset($_POST['submit_new_pass'])) {
                
                $change_pass = $this->loginmodel->change_pass($admin_id);
                if ($change_pass == 3){
                    $this->session->set_flashdata('pass_inc', 'Old Password is Incorrect.');
					redirect('Login/change_password');
				}
                if ($change_pass == 1){
                    $this->session->set_flashdata('pass_update', 'Password Updated Successfully.');
                redirect('Login');
				}
            }
            else{
				$this->load->view("common/header");

				$this->load->view("common/sidebar");

				$this->load->view('theme-v1/change_password');

				$this->load->view("common/footer-inner");
				
				
			}
               
        }
        else
            redirect(base_url() . 'Login/change_password');
    }
	
	public function logout(){
		$this->session->set_userdata('userName','');
		$this->session->set_userdata('admin_user_id','');
		$this->session->set_flashdata("errMsg","You have successfully logged out.");
		redirect(base_url());
	}
	


}
