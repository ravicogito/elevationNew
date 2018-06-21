<?php
class Ordermodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function listOrders(){
        $this->db->select('order.*,customer.*');
		$this->db->from('el_customer_order order');		
		$this->db->join('el_customer customer', 'customer.customer_id = order.customer_id', 'LEFT');
		$this->db->where('customer.customer_status','1');
		//$this->db->where('order.order_status','1');
        
		
		$query = $this->db->get();
		$num = $query->num_rows();		
		if($num>0){
			$result = $query->result();
			return $result;
		}else{
			return 0;
		}
    }	
	
	
	 function allOrders($id){
		$this->db->select('order.*,customer.*');
		$this->db->from('el_customer_order order');		
		$this->db->join('el_customer customer', 'customer.customer_id = order.customer_id', 'LEFT');
		$this->db->where('customer.customer_status','1');
		if($id!='all'){
        $this->db->where('order.order_status',$id);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$num = $query->num_rows();		
		if($num>0){
			$result = $query->result();
			return $result;
		}else{
			return 0;
		}
    }	

     function listOrderdetails($id){
        $this->db->select('order.*, customer.*');
		$this->db->from('el_customer_order order');
		//$this->db->join('el_customer_order_details order_details', 'order.order_id = order_details.order_id', 'LEFT');		
		$this->db->join('el_customer customer', 'customer.customer_id = order.customer_id', 'LEFT');		
		//$this->db->where('order.order_status','1');		
		$this->db->where('customer.customer_status','1');		
		$this->db->where('order.order_id',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$num = $query->num_rows();		
		if($num>0){
			$result = $query->row_array();
			return $result;
		}else{
			return 0;
		}
    }
	
/* 	function getOrderdetailsByid($id){
        $this->db->select('order.*, customer_order_details.*');
		$this->db->from('el_customer_order order');	
		$this->db->join('el_customer_order_details customer_order_details', 'customer_order_details.order_id = order.order_id', 'LEFT');		
			
		$this->db->where('order.order_id',$id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$num = $query->num_rows();		
		if($num>0){
			$result = $query->row_array();
			return $result;
		}else{
			return 0;
		}
    } */
	
	function updateData($data,$where) {
		if($data!=''){
            $this->db->where($where);
            $this->db->update('el_customer_order', $data);
            return 1;
        } else{
            return 0;
        }
    }

    function getOrderImgDetails($order_id)
	{
		if($order_id !=""){
			$this->db->select('orderdetails.*,image.*');
			$this->db->from('el_customer_order_details orderdetails');			
			$this->db->join('el_media_image image', 'image.media_id = orderdetails.order_img', 'left');
			$this->db->where('orderdetails.order_id',$order_id);
			$query = $this->db->get();
			if( $query->num_rows()> 0 ){				
				$temp = $query->result_array();
				return $temp; 				
			} else {
				return false;
			}
		}		
	}
	function getOrderdetailsSection($order_id){
		$this->db->select('ECOD.section');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left'); 		
		$this->db->where('ECOD.order_id',$order_id);
		$this->db->group_by('section'); 
        $query = $this->db->get();
        //echo  $this->db->last_query(); exit;
        $num = $query->num_rows();
        if($num>0){
            
            $result = $query->result_array();
            return $result;
        }else{
            return array();
        }
		
	}
	function getOrderDetailsByOrderId($order_id,$section)
	{
		if($order_id !=""){
			$this->db->select('orderdetails.*,image.*');
			$this->db->from('el_customer_order_details orderdetails');			
			$this->db->join('el_media_image image', 'image.media_id = orderdetails.order_img', 'left');
			
			$this->db->where('orderdetails.order_id',$order_id);
			$this->db->where('orderdetails.section',$section);
			$query = $this->db->get();
			if( $query->num_rows()> 0 ){				
				$temp = $query->result_array();
				return $temp; 				
			} else {
				return false;
			}
		}	
	}
	function getOrderdetailsBySection($customer_id,$order_id,$section){
	    //echo $customer_id; echo "<br/>"; echo $order_id;
        

    }
	function deleteOrderbyId($id)
	{
		if(isset($id) && !empty($id)){
            $data =  array('order_status'=>'0');
            $this->db->where('order_id', $id);
            $this->db->update('el_order', $data);
			echo $this->db->last_query();exit;
            return 1;
        } else{
            return 0;
        }
	}
	
	function updateOrderstatus($data,$where)
	{
		 if($data!=''){
            $this->db->where($where);
            $this->db->update('el_customer_order', $data);
            return 1;
        } else{
            return 0;
        }
	}
	

	public function getInvoiceDetails($orderID = 0) {
		$recArr					= array();
		if(!empty($orderID)) {
			$this->db->select('ECO.*, ECOD.*, EC.*, EE.event_name');
			$this->db->from('el_customer_order ECO');
			$this->db->join('el_customer_order_details ECOD', 'ECO.`order_id` = ECOD.order_id', 'LEFT');
			$this->db->join('el_customer EC', 'ECO.`customer_id` = EC.customer_id', 'LEFT');
			$this->db->join('el_event_public EE', 'ECOD.event_id = EE.event_id', 'LEFT');
			$this->db->where('ECO.order_id', $orderID);
			$query 				= $this->db->get();
			if( $query->num_rows()> 0 ){				
				$recArr			= $query->result_array();				
			}
		}

		return $recArr;
	}
	
	public function getCustomernote($orderID = 0) {
		$recArr					= array();
		if(!empty($orderID)) {
			$this->db->select('ECO.*');
			$this->db->from('el_customer_order ECO');
			$this->db->where('ECO.order_id', $orderID);
			$query 				= $this->db->get();
			if( $query->num_rows()> 0 ){				
				$recArr			= $query->row_array();				
			}
		}

		return $recArr;
	}

}