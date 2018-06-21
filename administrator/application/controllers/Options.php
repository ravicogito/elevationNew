<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Options extends CI_Controller {
	public function __construct(){
			parent::__construct();


			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Optionmodel');
	}

	public function listoption($id = ''){
		$front_url = $this->config->item('front_url');
		$data['option_lists']= $this->Optionmodel->alloptionList();
		//print'<pre>';print_r($data['option_lists']);exit;
		$data['front_url'] = $front_url;
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/list_options", $data);
			$this->load->view("common/footer-inner");
		
	}

	public function listoptionhead($id = ''){
		$front_url = $this->config->item('front_url');
		$data['optionhead_lists']= $this->Optionmodel->alloptionheadList();
		//print'<pre>';print_r($data['optionhead_lists']);exit;
		$data['front_url'] = $front_url;
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/list_optionhead", $data);
			$this->load->view("common/footer-inner");
		
	}

	public function listoptionmeta($id = ''){
		$front_url = $this->config->item('front_url');
		$data['optionmeta_lists']= $this->Optionmodel->alloptionmetaList();
		//print'<pre>';print_r($data['optionmeta_lists']);exit;
		$data['front_url'] = $front_url;
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/list_optionmeta", $data);
			$this->load->view("common/footer-inner");
		
	}

 public function addOption(){ 
    //print'<pre>';print_r($_POST);exit;
	$data = array();
	if(!empty($_POST)){
		$option_name 		= $this->input->post('option_name');
		$option_desc 		= $this->input->post('option_desc');
		$option_size_type 	= $this->input->post('option_size_type');
		$option_feeting_fee = $this->input->post('option_feeting_fee');
		$print_area_status  = $this->input->post('print_area_status');
		$oid = '';
		//echo $unique_email;exit;
		$chk_option_name = $this->Optionmodel->checkDuplicateOption($option_name,$oid);
		if($chk_option_name !='0'){
			$this->session->set_flashdata("pass_inc","This option name is already added");

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_option',$data);

			$this->load->view("common/footer-inner");
		}
		else{
			
			if(!empty($_FILES['metaImage']['name']))
			{
				$filename = rand(000000000, 999999999) . time() . $_FILES['metaImage']['name'];
				$config['upload_path'] = '../uploads/optionImg';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 20000;
				$config['file_name'] = $filename;

				$this->load->library('upload', $config);

				if (!file_exists('../uploads')) {
					mkdir('../uploads', 0777,true);
				}

				if (!file_exists('../uploads/optionImg')) {
					mkdir('../uploads/optionImg', 0777,true);
				}

				if (!$this->upload->do_upload('metaImage')) {
							$error = array('error' => $this->upload->display_errors());					
							$this->session->set_flashdata("failMessage",$error);
				}
				else {
				$fileData = $this->upload->data();
				
					$data =  array(
									'option_name'	        =>$option_name,
									
									'option_image'			=>$fileData['file_name'],
										
									'option_description'	=>$option_desc,
										
									'option_size_type'		=>$option_size_type,
										
									'option_fitting_fee'	=>$option_feeting_fee,
										
									'is_change_print_area'	=>$print_area_status,
									
									'created_on'			=>date('Y-m-d')
										
						);
								
					$mess = $this->Optionmodel->optionAdd($data);
					
					
					if($mess){
						$this->session->set_flashdata("sucessPageMessage","New Option Added Successfully!");

						redirect(base_url()."Options/listoption");

					}
				}
			}
		}
	}
	else{
            $this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_option',$data);

			$this->load->view("common/footer-inner");

		}
	}


	public function editOption($oid){
		
		$data['front_url'] = $this->config->item('front_url');
		
		$option_data = $this->Optionmodel->optionDataResult($oid);
        //print'<pre>';print_r($option_data);exit;
		if(!empty($option_data)){
			$data['option_data']	= $option_data;
		}
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_option", $data);

		$this->load->view("common/footer-inner");

	}	
	
	public function updateOption($o_id){

		if(!empty($_POST)){
		$option_name 		= $this->input->post('option_name');
		$option_desc 		= $this->input->post('option_desc');
		$option_size_type 	= $this->input->post('option_size_type');
		$option_feeting_fee = $this->input->post('option_feeting_fee');
		$print_area_status  = $this->input->post('print_area_status');
		$oldmetaImage  = $this->input->post('oldmetaImage');
		//echo $unique_email;exit;
		$chk_option_name = $this->Optionmodel->checkDuplicateOption($option_name,$o_id);
		if($chk_option_name !='0'){
			$this->session->set_flashdata("pass_inc","This option name is already added");
            redirect(base_url()."Options/editOption/".$o_id);
		}
	
		else{
			
			if(!empty($_FILES['metaImage']['name'])){
				
				$filename = rand(000000000, 999999999) . time() . $_FILES['metaImage']['name'];
				$config['upload_path'] = '../uploads/optionImg';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 20000;
				$config['file_name'] = $filename;

				$this->load->library('upload', $config);

				if (!file_exists('../uploads')) {
					mkdir('../uploads', 0777,true);
				}

				if (!file_exists('../uploads/optionImg')) {
					mkdir('../uploads/optionImg', 0777,true);
				}
				if (file_exists('../uploads/optionImg/'.$oldmetaImage)) {
					unlink('../uploads/optionImg/'.$oldmetaImage);
				}
				if (!$this->upload->do_upload('metaImage')) {
					$error = array('error' => $this->upload->display_errors());					
					$this->session->set_flashdata("failMessage",$error['error']);
					redirect(base_url()."Options/editOption/".$omid);
				} 
				else {
					$fileData = $this->upload->data();
					//echo "FILE NAME--".$fileData['file_name'],exit;
					$image	= $fileData['file_name'];
				}               
			}
			else{
				
				$image	=	$oldmetaImage;
			}
			
			$data =  array(
							
							'option_name'	        =>$option_name,
							
							'option_image'			=>$image,
								
							'option_description'	=>$option_desc,
								
							'option_size_type'		=>$option_size_type,
								
							'option_fitting_fee'	=>$option_feeting_fee,
								
							'is_change_print_area'	=>$print_area_status,
							
							'created_on'			=>date('Y-m-d')						

						);


					$mess = $this->Optionmodel->updateOptionbyId($o_id, $data);

					if($mess==1){

							$this->session->set_flashdata("sucessPageMessage","Option's details updated Successfully!");

							redirect(base_url()."Options/listoption");

						} 
			}
		} else{

				redirect(base_url()."Options/editOption/".$o_id);

			}

	}
	
	public function deleteOption($o_id){
		$data 		=  array('option_status'=>'0');
		$condArr    =  array("option_id" => $o_id);
		$update_rel_status = $this->Optionmodel->deleteOptionById($data,'el_frame_options',$condArr);
		
		if($update_rel_status == 1){
			$this->session->set_flashdata("sucessPageMessage","Option Deleted Successfully!");
			redirect(base_url()."Options/listoption");
		}
	}


	public function addOptionHead(){ 
    //print'<pre>';print_r($_POST);exit;
	$data = array();	
	$data['option_list'] = $this->Optionmodel->alloptionList();
	if(!empty($_POST)){
		$option_name 		= $this->input->post('option_name');
		$option_head 		= $this->input->post('option_head');
		$ohid = '';
		//echo $unique_email;exit;
		$chk_option_head = $this->Optionmodel->checkDuplicateOptionHead($option_name,$option_head,$ohid);
		if($chk_option_head !='0'){
			$this->session->set_flashdata("pass_inc","This option head name is already added");

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_optionhead',$data);

			$this->load->view("common/footer-inner");
		}
		else{
		  $data =  array(
							'option_id'	            =>$option_name,
								
							'option_meta_head_name'	=>$option_head,
							
							'created_on'			=>date('Y-m-d')
								
				);
						
			$mess = $this->Optionmodel->optionHeadAdd($data);
			
			
			if($mess){
				$this->session->set_flashdata("sucessPageMessage","New Option Head Added Successfully!");

				redirect(base_url()."Options/listoptionhead");

			}
		}
	}
	else{
            $this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_optionhead',$data);

			$this->load->view("common/footer-inner");

		}
	}

	public function editOptionHead($ohid){
		$data['option_list'] = $this->Optionmodel->alloptionList();
		//print'<pre>';print_r($data['option_list']);exit;
		$optionhead_data = $this->Optionmodel->optionHeadDataResult($ohid);
        //print'<pre>';print_r($option_data);exit;
		if(!empty($optionhead_data)){
			$data['optionhead_data']	= $optionhead_data;
		}
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_optionhead", $data);

		$this->load->view("common/footer-inner");

	}	

	public function updateOptionHead($oh_id){

		if(!empty($_POST)){
		$option_name 		= $this->input->post('option_name');
		$option_head 		= $this->input->post('option_head');
		//echo $unique_email;exit;
		$chk_option_head = $this->Optionmodel->checkDuplicateOptionHead($option_name,$option_head,$oh_id);
		if($chk_option_head !='0'){
			$this->session->set_flashdata("pass_inc","This option head name is already added");
            redirect(base_url()."Options/editOptionHead/".$oh_id);
		}
	
		else{
			    $data =  array(
							'option_id'	            =>$option_name,
								
							'option_meta_head_name'	=>$option_head,
							
							'modified_on'			=>date('Y-m-d')
								
				);					

				$mess = $this->Optionmodel->updateOptionHeadbyId($oh_id, $data);

				if($mess==1){

							$this->session->set_flashdata("sucessPageMessage","Option head details updated Successfully!");

							redirect(base_url()."Options/listoptionhead");

						} 
			}
		} else{

				redirect(base_url()."Options/editOptionHead/".$oh_id);

			}

	}
	
	// Prepare List for Mailchimp
    public function deleteOptionHead($oh_id){
		$data 		=  array('option_meta_head_status'=>'0');
		$condArr    =  array("option_meta_head_id" => $oh_id);
		$update_rel_status = $this->Optionmodel->deleteOptionHeadById($data,'el_frame_option_meta_head',$condArr);
		
		if($update_rel_status == 1){
			$this->session->set_flashdata("sucessPageMessage","Option Head Deleted Successfully!");
			redirect(base_url()."Options/listoptionhead");
		}
	}

	public function addOptionMeta(){ 
    //print'<pre>';print_r($_POST);exit;
	$data = array();
	$data['option_list'] = $this->Optionmodel->alloptionList();
	if(!empty($_POST)){
		$option_name 		= $this->input->post('option_name');
		$option_head 		= $this->input->post('option_head');
		$meta_value 	    = $this->input->post('meta_value');
		$meta_material      = $this->input->post('meta_material');
		$meta_style         = $this->input->post('meta_style');
		$meta_color         = $this->input->post('meta_color');
		$meta_finish        = $this->input->post('meta_finish');
		$meta_height        = $this->input->post('meta_height');
		$meta_width         = $this->input->post('meta_width');
		$meta_price         = $this->input->post('meta_price');
		$omid = '';
		//echo $unique_email;exit;
		$chk_option_meta = $this->Optionmodel->checkDuplicateOptionMeta($option_name,$option_head,$meta_value,$omid);
		if($chk_option_meta !='0'){
			$this->session->set_flashdata("pass_inc","This option meta name is already added");

			$this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_optionmeta',$data);

			$this->load->view("common/footer-inner");
		}
		else{
		  if(!empty($_FILES['metaImage']['name'])){	
		  	$filename = rand(000000000, 999999999) . time() . $_FILES['metaImage']['name'];
			$config['upload_path'] = '../uploads/metaImg';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 20000;
			$config['file_name'] = $filename;

			$this->load->library('upload', $config);

			if (!file_exists('../uploads')) {
				mkdir('../uploads', 0777,true);
			}

			if (!file_exists('../uploads/metaImg')) {
				mkdir('../uploads/metaImg', 0777,true);
			}

			if (!$this->upload->do_upload('metaImage')) {
						$error = array('error' => $this->upload->display_errors());					
						$this->session->set_flashdata("failMessage",$error);
			} else {
				$fileData = $this->upload->data();
		        $data =  array(
							'option_id'	            =>$option_name,
								
							'option_meta_head_id'	=>$option_head,
								
							'option_meta_value'		=>$meta_value,

							'option_meta_image'		=>$fileData['file_name'],
								
							'option_meta_material'	=>$meta_material,
								
							'option_meta_style'	    =>$meta_style,

							'option_meta_color'	    =>$meta_color,

							'option_meta_finish'    =>$meta_finish,

							'option_meta_height'    =>$meta_height,
                            
                            'option_meta_width'     =>$meta_width, 

                            'option_meta_price'     =>$meta_price, 
                            
                            'created_on'			=>date('Y-m-d')
								
				);
						
			$mess = $this->Optionmodel->optionMetaAdd($data);
			unset($config);
			
			if($mess){
				$this->session->set_flashdata("sucessPageMessage","New Option Meta Added Successfully!");

				redirect(base_url()."Options/listoptionmeta");

			}
		  }
	   }
	}
  }
	else{
            $this->load->view("common/header");

			$this->load->view("common/sidebar");

			$this->load->view('theme-v1/add_optionmeta',$data);

			$this->load->view("common/footer-inner");

		}
	}

	public function ajax_optionheadDetails(){
		$optionId = isset($_POST['optionId'])?$_POST['optionId']:'';
	    $data['optionheadlist'] = $this->Optionmodel->findOptionHeadlists($optionId);
	    //print'<pre>';print_r( $data['optionheadlist']);exit;
	    $this->load->view('theme-v1/ajaxOptionHeadDetails',$data);
	    return true;
    }

    public function editOptionMeta($omid){
    	$data['front_url'] = $this->config->item('front_url');
		$data['option_list'] = $this->Optionmodel->alloptionList();
		$data['optionhead_list'] = $this->Optionmodel->optionHeadMetaList($omid);
		//print'<pre>';print_r($data['optionhead_list']);exit;
		$optionmeta_data = $this->Optionmodel->optionMetaDataResult($omid);
        //print'<pre>';print_r($optionmeta_data);exit;
		if(!empty($optionmeta_data)){
			$data['optionmeta_data']	= $optionmeta_data;
		}
		
		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_optionmeta", $data);

		$this->load->view("common/footer-inner");

	}	

	public function updateOptionMeta($omid){
        if(!empty($_POST)){
		$option_name 		= $this->input->post('option_name');
		$option_head 		= $this->input->post('option_head');
		$meta_value 	    = $this->input->post('meta_value');
		$oldmetaImage		= $this->input->post('oldmetaImage');
		$meta_material      = $this->input->post('meta_material');
		$meta_style         = $this->input->post('meta_style');
		$meta_color         = $this->input->post('meta_color');
		$meta_finish        = $this->input->post('meta_finish');
		$meta_height        = $this->input->post('meta_height');
		$meta_width         = $this->input->post('meta_width');
		$meta_price         = $this->input->post('meta_price');
		//echo $unique_email;exit;
		$chk_option_meta = $this->Optionmodel->checkDuplicateOptionMeta($option_name,$option_head,$meta_value,$omid);
		if($chk_option_meta !='0'){
			$this->session->set_flashdata("pass_inc","This option meta name is already added");
            redirect(base_url()."Options/editOptionMeta/".$omid);
		}
	
		else{

			if(!empty($_FILES['metaImage']['name'])){
				
				$filename = rand(000000000, 999999999) . time() . $_FILES['metaImage']['name'];
				$config['upload_path'] = '../uploads/metaImg';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 20000;
				$config['file_name'] = $filename;

				$this->load->library('upload', $config);

				if (!file_exists('../uploads')) {
					mkdir('../uploads', 0777,true);
				}

				if (!file_exists('../uploads/metaImg')) {
					mkdir('../uploads/metaImg', 0777,true);
				}
				if (file_exists('../uploads/metaImg/'.$oldimg)) {
					unlink('../uploads/metaImg/'.$oldimg);
				}
				if (!$this->upload->do_upload('metaImage')) {
					$error = array('error' => $this->upload->display_errors());					
					$this->session->set_flashdata("failMessage",$error['error']);
					redirect(base_url()."Options/editOptionMeta/".$omid);
				} 
				else {
					$fileData = $this->upload->data();
					//echo "FILE NAME--".$fileData['file_name'],exit;
					$image	= $fileData['file_name'];
				}               
			}
			else{
				
				$image	=	$oldmetaImage;
			}

            $data =  array(
							'option_id'	            =>$option_name,
								
							'option_meta_head_id'	=>$option_head,
								
							'option_meta_value'		=>$meta_value,

							'option_meta_image'		=>$image,
								
							'option_meta_material'	=>$meta_material,
								
							'option_meta_style'	    =>$meta_style,

							'option_meta_color'	    =>$meta_color,

							'option_meta_finish'    =>$meta_finish,

							'option_meta_height'    =>$meta_height,
                            
                            'option_meta_width'     =>$meta_width, 

                            'option_meta_price'     =>$meta_price, 
                            
                            'modified_on'			=>date('Y-m-d')
								
				);				

				$mess = $this->Optionmodel->updateOptionMetabyId($omid, $data);

				if($mess==1){

					$this->session->set_flashdata("sucessPageMessage","Option meta details updated Successfully!");

					redirect(base_url()."Options/listoptionmeta");

					} 
			}
		} else{

				redirect(base_url()."Options/editOptionMeta/".$omid);

			}

	}
	
    public function deleteOptionMeta($omid){
		$data 		=  array('option_meta_status'=>'0');
		$condArr    =  array("option_meta_id" => $omid);
		$update_rel_status = $this->Optionmodel->deleteOptionMetaById($data,'el_frame_options_meta',$condArr);
		
		if($update_rel_status == 1){
			$this->session->set_flashdata("sucessPageMessage","Option Meta Deleted Successfully!");
			redirect(base_url()."Options/listoptionmeta");
		}
	}
	
}
