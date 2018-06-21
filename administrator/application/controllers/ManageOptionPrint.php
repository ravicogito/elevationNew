<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ManageOptionPrint extends CI_Controller {
	public function __construct(){
			parent::__construct();


			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('OptionPrintmodel');
	}

	public function addOptionPrint()
	{
		$data['get_frame_options'] = $this->OptionPrintmodel->listOptionPrint();
		
		if(!empty($_POST)){
			$option_name       = $this->input->post('option_name');
			
			$print_size_value  = $this->input->post('option_size');
			
			$print_size_type   = $this->input->post('print_size_type');

			$acrylic_price     = $this->input->post('acrylic_price');
			
			$check_frame_option_prints = $this->OptionPrintmodel->checkFrameOption($print_size_value,$print_size_type);
			//echo'<pre>';print_r($check_frame_option_prints);exit;
			
			if(!empty($check_frame_option_prints))
			{
				$check_value_exist = $this->OptionPrintmodel->checkValueExist($check_frame_option_prints['print_size_id'],$option_name);
				
				if(!empty($check_value_exist))
				{
					$this->session->set_flashdata("pass_inc","The Print Option Name,Option Size and Print Size Type is already added");

					$this->load->view("common/header");

					$this->load->view("common/sidebar");

					$this->load->view('theme-v1/add_optionprint',$data);

					$this->load->view("common/footer-inner");
				}
				else{
					$data =  array(
									'option_id'						=>$option_name,
										
									'option_print_size_id'			=>$check_frame_option_prints['print_size_id'],
										
									'acrylic_price'					=>$acrylic_price,
										
									'option_printsize_rel_status'	=>'1'
								);

					$table = 'el_frame_option_printsize_rel';			
					$option_printsize_rel  = $this->OptionPrintmodel->optionPrintAdd($table,$data);
					if($option_printsize_rel){
						$this->session->set_flashdata("sucessPageMessage","Manage Option Print Added Successfully!");

						redirect(base_url()."ManageOptionPrint/listOptionPrint");

					}
				}
			}
			else{
				$data =  array(
									'print_option_size_value'	=>$this->input->post('option_size'),
										
									'print_min_dpi'				=>$this->input->post('print_min_dpi'),
										
									'print_min'					=>$this->input->post('print_min'),
										
									'print_optimal_dpi'			=>$this->input->post('print_optimal_dpi'),
										
									'print_optimal'				=>$this->input->post('print_optimal'),
									
									'print_size_type'			=>$this->input->post('print_size_type'),
									
									'print_size_price'			=>$this->input->post('print_size_dp'),
							
					);

					$table = 'el_frame_option_print_size';			
					$printId  = $this->OptionPrintmodel->optionPrintAdd($table,$data);
					
					if($printId){
						 $data =  array(
									'option_id'						=>$option_name,
										
									'option_print_size_id'			=>$printId,
										
									'acrylic_price'					=>$acrylic_price,
										
									'option_printsize_rel_status'	=>'1'
								);

					$table = 'el_frame_option_printsize_rel';			
					$mess1  = $this->OptionPrintmodel->optionPrintAdd($table,$data);
					if($mess1){
							$this->session->set_flashdata("sucessPageMessage","Manage Option Print Added Successfully!");

							redirect(base_url()."ManageOptionPrint/listOptionPrint");

						}
					}
				
			}
			
		}
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view('theme-v1/add_optionprint',$data);

		$this->load->view("common/footer-inner");
	}
	
	public function listOptionPrint()
	{
		$data['list_manage_option_prints'] = $this->OptionPrintmodel->alllistOptionPrint();
		//print'<pre>';print_r($data['list_manage_option_prints']);exit;
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view('theme-v1/list_optionprint',$data);

		$this->load->view("common/footer-inner");
	}
	
	public function editOptionPrint($option_printsize_rel_id)
	{
		$data['get_frame_options'] = $this->OptionPrintmodel->listOptionPrint();

		$data['edit_manage_option_print'] = $this->OptionPrintmodel->editOptionPrint($option_printsize_rel_id);

		//print'<pre>';print_r($data['edit_manage_option_print']);exit;
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view('theme-v1/edit_optionprint',$data);

		$this->load->view("common/footer-inner");
	}
	
	
	public function updateOptionPrint(){
		
		$data['get_frame_options'] = $this->OptionPrintmodel->listOptionPrint();
		
		if(!empty($_POST)){
			
			$print_size_id = $this->input->post('print_size_id');
			
			$option_printsize_rel_id = $this->input->post('option_printsize_rel_id');
			
			$data['edit_manage_option_print'] = $this->OptionPrintmodel->editOptionPrint($option_printsize_rel_id);
			
			
			$option_name       = $this->input->post('option_name');
			
			$print_size_value  = $this->input->post('option_size');
			
			$print_size_type   = $this->input->post('print_size_type');

			$acrylic_price     = $this->input->post('acrylic_price');
			//echo $acrylic_price ;die;
			
			$el_frame_option_printsize_relChecking = $this->OptionPrintmodel->optionPrintsizeRelChecking($option_name,$print_size_id );
			/* echo"<pre>";
			print_r($el_frame_option_printsize_relChecking);die; */
			
			if($el_frame_option_printsize_relChecking)
			{
			
				$data =  array(
							'option_id'	    => $option_name,
							'acrylic_price'	=>$acrylic_price
						);		

				$mess  = $this->OptionPrintmodel->updateOptionbyId($option_printsize_rel_id,$data);
				if($mess){
						
						$check_frame_option_prints = $this->OptionPrintmodel->getOptionPrintsize($option_printsize_rel_id);
						
						$data2 =  array(
								'print_option_size_value'	=>$this->input->post('option_size'),
									
								'print_min_dpi'				=>$this->input->post('print_min_dpi'),
									
								'print_min'					=>$this->input->post('print_min'),
									
								'print_optimal_dpi'			=>$this->input->post('print_optimal_dpi'),
									
								'print_optimal'				=>$this->input->post('print_optimal'),
								
								'print_size_type'			=>$this->input->post('print_size_type'),
								
								'print_size_price'				=>$this->input->post('print_size_dp')
						);
						
					$mess1  = $this->OptionPrintmodel->updateOptionbyPrintsizeId($check_frame_option_prints['option_print_size_id'],$data2);
					if($mess1){
						$this->session->set_flashdata("sucessPageMessage","Manage Option Print Size Updated Successfully!");

						redirect(base_url()."ManageOptionPrint/listOptionPrint");

					}

				}
			}
			else{
					$this->session->set_flashdata("pass_inc","The Print Option Name is already added");

					/* $this->load->view("common/header");

					$this->load->view("common/sidebar");

					$this->load->view('theme-v1/edit_optionprint',$data);

					$this->load->view("common/footer-inner"); */
					redirect(base_url()."ManageOptionPrint/editOptionPrint/".$option_printsize_rel_id);
			}
				
				
			
		}
	}
	
	public function deleteOption($id){
		$data 		=  array('option_printsize_rel_status'=>'0');
		$condArr    =  array("option_printsize_rel_id" => $id);
		$update_rel_status = $this->OptionPrintmodel->deleteOptionById($data,'el_frame_option_printsize_rel',$condArr);
		
		if($update_rel_status == 1){
			$this->session->set_flashdata("sucessPageMessage","Manage Option Print Deleted Successfully!");
			redirect(base_url()."ManageOptionPrint/listOptionPrint");
		}
	}
	
}
