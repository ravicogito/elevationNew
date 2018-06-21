<?php
/**
 *
 * @ Cart model
 *
 *
 */

class Model_cart extends CI_Model {
	
    function __construct() {
       parent::__construct();
    }
	
	function getImgDetails($image_id = '') {
		$recArr						= array();
		if(!empty($image_id)) {
			$this->db->select('MI.media_title,MI.photo_size,MI.digital_format,MI.photo_number, MI.media_path, MI.file_name, MI.media_type, MI.event_id, MI.media_price, E.event_name, E.location_id, E.resort_id, E.photographer_id, P.photographer_name');
        	$this->db->from('el_media_image MI');
        	$this->db->join('el_event E', 'MI.event_id = E.event_id', 'LEFT');
        	$this->db->join('el_photographer P', 'E.photographer_id = P.photographer_id', 'LEFT');
			
        	$this->db->where('MI.media_id', $image_id);
			
			$this->db->where('MI.media_status','1');
			
			$this->db->where('MI.publish_status','1');
        	$query 					= $this->db->get();
			
			//echo $this->db->last_query();exit;
        	$num 					= $query->num_rows();
	        if($num>0){	         
	            $recArr 			= $query->row_array();
			}
		}
		return $recArr;
	}
	
	function getallImages($event_id = '') {
	
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_media_image media');
			
			$this->db->where('media.event_id',$event_id);
			
			$this->db->where('media.media_status','1');
			
			$this->db->where('media.publish_status','1');
            
			$query = $this->db->get();

			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				
				return $temp; 				
			}			else{				
				return false;
			}
		}
		
		
	}		
	function getEventPrice($event_id = '') {
	
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_event event');
			
			$this->db->where('event.event_id',$event_id);
			
            $this->db->where('event.event_status','1');
			$query = $this->db->get();

			if( $query->num_rows()> 0 ){
				
				$temp = $query->row_array(); 
				return $temp['event_price']; 				
			}			else{				
				return false;
			}
		}
		
		
	}	
	
	function getAllOrderDetails($customer_id){
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_order order');
			
			$this->db->where('order.customer_id',$customer_id);

			return $this->db->count_all_results();
		}

	}

	function getOrderDetails($customer_id,$limit, $start){
		if($customer_id !=""){

			$this->db->select('*');	
			
        	$this->db->from('el_order eor');
        	
			$this->db->where('eor.customer_id',$customer_id);
			
			$this->db->where('eor.payment_status', 'Yes');
			
			$this->db->where('eor.order_status', '2');
			
			$this->db->order_by("eor.order_id", "desc");
			
			$this->db->limit($limit, $start);

			$query = $this->db->get();
			
			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				
				return $temp; 				
			}			else{				
				return false;
			}
		}

	}
	function customerOrderDetails($customer_id,$limit, $start){
		if($customer_id !=""){

			$this->db->select('*');	
			
        	$this->db->from('el_customer_order ecor');
			
			$this->db->join('el_customer_order_details ecod', 'ecor.order_id = ecod.order_id', 'LEFT');
        	
			$this->db->where('ecor.customer_id',$customer_id);	
			
			$this->db->where('ecor.payment_status', 'Yes');
			
			$this->db->where('ecor.order_status', '2');
			
			$this->db->order_by("ecor.order_id", "desc");
			
			$this->db->limit($limit, $start);

			$query = $this->db->get();
			
			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				
				return $temp; 				
			}			else{				
				return false;
			}
		}

	}
	function getOrderImgDetails($order_id){
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

	function insertData($data,$tblname) { 

        if(!empty($data)){

          $this->db->insert($tblname, $data);

          $insert_id = $this->db->insert_id();

          return $insert_id;

        }else{

          return 0;

        }

   }
   
   function getBillInfo($customer_id){

        $this->db->select('*');
        $this->db->from('el_customer');
		$this->db->where('customer_id',$customer_id);
        $query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            //print_r($query->row_array()); exit;
            //echo "<pre>";
            $result = $query->row_array();
            return $result;
        }else{
            return array();
        }

    }
	
	function getOrderdetailsById($customer_id,$order_id){
		
        $this->db->select('ECO.order_id,ECO.order_no,ECO.transaction_id,ECO.order_datetime,ECO.total,ECO.bill_address,ECO.ship_address,ECOD.*');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left'); 
		$this->db->where('ECO.customer_id',$customer_id);
		$this->db->where('ECO.order_id',$order_id);
		//$where = "ECO.payment_response is NOT NULL";
		//$this->db->where($where);
		$this->db->where('ECO.payment_response', 'null');
        $query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            //print_r($query->row_array()); exit;
            //echo "<pre>";
            $result = $query->result_array();
            return $result;
        }else{
            return array();
        }

    }
	
	function getOrderdetailsByOrder($customer_id,$order_id){
        $this->db->select('ECO.order_id,ECO.order_no,ECO.transaction_id,ECO.order_datetime,ECO.total,ECO.bill_address,ECO.ship_address,ECOD.*');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left'); 
		$this->db->where('ECO.customer_id',$customer_id);
		$this->db->where('ECOD.order_id',$order_id);
		
        $query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            //print_r($query->row_array()); exit;
            //echo "<pre>";
            $result = $query->result_array();
            return $result;
        }else{
            return array();
        }

    }
	 
	function updateOrder($data,$tbl,$order_id) {	

		if(!empty($data)){

			$this->db->where('order_id', $order_id);

            $this->db->update($tbl, $data);

			return 1;

		}else{

			return 0;

		}

	}
	
	function customerData ($customer_id){
		
		$recArr						= array();
		
		$this->db->select('*');
		$this->db->from('el_customer');	 
		
		$this->db->where('customer_id', $customer_id);
		$this->db->where('customer_status', '1');		
		
		$sql = $this->db->get();
		//echo $this->db->last_query();exit;
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->row_array();
			
        }
		return $recArr;
		
	}
	
}