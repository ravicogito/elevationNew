<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {
	public function __construct(){
			parent::__construct();
			if($this->session->userdata('admin_user_id') =='') {
				redirect(base_url());
			}
			$this->load->model('Ordermodel');			
	}


	public function listorder(){
		
			$data['order_list']= $this->Ordermodel->listOrders();
			$data['front_url'] = $this->config->item('front_url');
		
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/order_list", $data);
			$this->load->view("common/footer-inner");
		
	}
	
	//Delete Page

	public function deleteOrder($id){
		
		$this->Ordermodel->deleteOrderbyId($id);
		
		$this->session->set_flashdata("sucessPageMessage","Order Deleted Successfully!");
		
		redirect(base_url()."Order/listorder/");
	}
	
	public function Orderdetails($id)
	{
		    $data['order_details']= $this->Ordermodel->listOrderdetails($id);
			
			if(!empty($data['order_details'])){
				foreach($data['order_details'] as $key => $order)
				{
				 $orderImgDetails			   		=  $this->Ordermodel->getOrderImgDetails($id);
				 $orderImg[$id]	   	=  $orderImgDetails;		 
				}
				$data['orderImgDetails']		=  $orderImg;
				//pr($this->data['orderImgDetails']);

			}
			$data['front_url'] = $this->config->item('front_url');
		
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/order_details", $data);
			$this->load->view("common/footer-inner");
		
	}
}
	
	