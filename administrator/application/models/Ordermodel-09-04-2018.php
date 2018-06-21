<?php
class Ordermodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function listOrders(){

        $this->db->select('*');

		$this->db->from('el_order order');
		
		$this->db->join('el_customer customer', 'customer.customer_id = order.customer_id', 'LEFT');

		$this->db->where('order.order_status','1');
		
		$this->db->where('customer.customer_status','1');
		
		$this->db->order_by('order.order_datetime','desc');

		$query = $this->db->get();

		$num = $query->num_rows();
		
		if($num>0){


			$result = $query->result();

			return $result;

		}else{

			return 0;

		}

    }	

     function listOrderdetails($id){

        $this->db->select('*');

		$this->db->from('el_order order');
		
			
		$this->db->join('el_customer customer', 'customer.customer_id = order.customer_id', 'LEFT');
		
		$this->db->where('order.order_status','1');
		
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

    function getOrderImgDetails($order_id)
	{
		if($order_id !=""){

			$this->db->select('*');

			$this->db->from('el_orderdetails orderdetails');
			
			$this->db->join('el_media_image image', 'image.media_id = orderdetails.image_id', 'left');

			$this->db->where('orderdetails.order_id',$order_id);

			$query = $this->db->get();

			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 

				return $temp; 				
			}			else{				
				return false;
			}
		}
		
	}	
	
	function deleteOrderbyId($id)
	{
		if(isset($id) && !empty($id)){
            $data =  array('order_status'=>'0');
            $this->db->where('order_id', $id);
            $this->db->update('el_order', $data);
            return 1;
        } else{
                return 0;
        }
	}
	
}