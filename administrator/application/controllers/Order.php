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
	
	public function updatePaymentsuccess(){
		
		$recArr = array();
		$get_option_val = $this->input->post('get_option_val');
		$order_id 		= $this->input->post('order_id');
		
		$data = array('order_status' => $get_option_val);
		$where = array('order_id' => $order_id);
		$update_payment_status = $this->Ordermodel->updateOrderstatus($data,$where);

		if($update_payment_status == 1)
		{
			$recArr['get'] = 'Success';
		}
		echo json_encode(array('get' => 'Success'));
		
	}
	
	public function statuswiselisting(){
		
		$recArr = array();

		$get_option_val = $this->input->post('get_option_val');

		$data['orders'] = $this->Ordermodel->allOrders($get_option_val);
		$data['orders_status'] = $get_option_val;
		
        if(!empty($data['orders'])){
			
		  $response = $this->load->view("theme-v1/order_all_list", $data ,true);
		  $recArr['process'] 					= 'success';
		  $recArr['order_all_list']      		= $response;
		 

		}

		echo json_encode($recArr);
		
	}
	 
	//Delete Page

	public function deleteOrder($id){
		
		$this->Ordermodel->deleteOrderbyId($id);
		
		$this->session->set_flashdata("sucessPageMessage","Order Deleted Successfully!");
		
		redirect(base_url()."Order/listorder/");
	}
	
	public function Orderdetails($id)
	{
		$order_details = $this->Ordermodel->listOrderdetails($id);
		if(!empty($order_details)){
			$data['order_details'] = $order_details;		
				
			if(!empty($data['order_details'])){
				
				$get_admin_note = $this->input->post('admin_note');
				if($get_admin_note)
				{
					
					$data  = array('admin_note' => $get_admin_note);
					$where = array('order_id'   => $id);
					$update_admin_note = $this->Ordermodel->updateData($data,$where);
					
					$this->session->set_flashdata("sucessPageMessage","Admin note Updated Successfully!");
					
					redirect(base_url()."Order/Orderdetails/".$id);
				}
				$ord_data = $this->Ordermodel->getOrderdetailsSection($id);
				//pr($ord_data);
				if(!empty($ord_data)){
					foreach($ord_data as $val){
						$sec = $val['section'];
						$order_details	= $this->Ordermodel->getOrderDetailsByOrderId($id,$sec);	
						if(!empty($order_details)){
							$orderImg[$sec]=	$order_details;
						}
						
					}
					
					$data['orderImgDetails']			= $orderImg;
					
				}
				else{
					
					$data['orderImgDetails']		='';
				}
				//$data['orderImgDetails']				=  $orderImg;
				//pr($this->data['orderImgDetails']);

			}
			$data['front_url'] = $this->config->item('front_url');
			//pr($data);
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/order_details", $data);
			$this->load->view("common/footer-inner");
		}
		else{
			
			redirect(base_url()."Order/listorder/");
		}
	}

	public function invoice($orderID = 0) {
		$data 							= array();
		$data['shipping_price']			= '7.00';
		$data['orderDetails']			= $this->Ordermodel->getInvoiceDetails($orderID);
		$data['customer_admin_note']			= $this->Ordermodel->getCustomernote($orderID);
		//pr($data);
		//$this->load->view("common/header");
		//$this->load->view("common/sidebar");
		$this->load->view("theme-v1/invoice", $data);
		//$this->load->view("common/footer-inner");
	}
	
 public function invoiceDownload($orderID = 0) {
  $data        = array();
  $data['front_url'] = $this->config->item('front_url');
  $data['shipping_price']   = '7.00';
  $data['orderDetails']   = $this->Ordermodel->getInvoiceDetails($orderID);
  //pr($data);
  //echo "hi - ".FCPATH;exit;
  $html = $this->load->view('theme-v1/invoice-pdf', $data, true);
  require_once(APPPATH.'third_party/mpdf/mpdf.php');

  //$mpdf = new mPDF('win-1252','A4','','',20,15,48,25,10,10);

  $mpdf = new mPDF('win-1252', 'A4','', '',13, 13, 13, 0, 0, 0, 'L');

  $mpdf->useOnlyCoreFonts = true;    // false is default

  /*if($outPutData['res'][0]->payment_status == 'paid') {
   $mpdf->SetWatermarkText('PAID');
   $mpdf->showWatermarkText = true;
  }*/

  
  $mpdf->WriteHTML($html);

  /*if($outPutData['res'][0]->unique_id != "") {
   $filename = $outPutData['res'][0]->unique_id.".pdf";
  }else{*/
   $filename = "INVOICE".$data['orderDetails'][0]['order_no'].".pdf";
  //}

  $mpdf->Output($filename, 'D');// 'D' stands for force to download
 }

}
	
	