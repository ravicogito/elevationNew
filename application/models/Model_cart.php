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
	
	
	function getImgEventDetails($event_id = '') {
	
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_event_public event');
			
			$this->db->join('el_raftingcompany rafting', 'rafting.raftingcompany_id = event.rafting_company_id', 'LEFT');
			
			$this->db->join('el_category', 'event.category_id = el_category.id', 'LEFT');
			
			$this->db->join('el_photographer', 'event.photographer_id = el_photographer.photographer_id', 'LEFT');
			
			$this->db->where('event.event_id',$event_id);
			
			$this->db->where('event.event_status','1');
			
			//$this->db->where('media.event_type','rafting');
            
			$query = $this->db->get();

			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				
				return $temp; 				
			}			else{				
				return false;
			}
		}
		
		
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
	
	function allOrderDetails($customer_id,$orderID){
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_customer_order order');
			
			$this->db->join('el_customer_order_details ecod', 'ecod.order_id = order.order_id', 'LEFT');
			
			$this->db->where('order.customer_id',$customer_id);
			
			$this->db->where('order.order_id',$orderID);
			
			$query = $this->db->get();
			
			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				
				return $temp; 				
			}			else{				
				return false;
			}

			
		}

	}
	
	
	
	function getAllOrderDetails($customer_id){
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_customer_order order');
			
			$this->db->where('order.customer_id',$customer_id);

			return $this->db->count_all_results();
		}

	}

	function getOrderDetails($customer_id,$limit, $start){
		if($customer_id !=""){

			$this->db->select('*');	
			
        	$this->db->from('el_customer_order eor');
        	
			$this->db->where('eor.customer_id',$customer_id);
			
			//$this->db->where('eor.payment_status', 'Yes');
			
			//$this->db->where('eor.order_status', '2');
			
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
	function getOrderImgDetails($order_id,$customer_id){
		/*if($order_id !=""){

			$this->db->select('*');

			$this->db->from('el_customer_order_details orderdetails');
			
			$this->db->join('el_media_image image', 'image.media_id = orderdetails.media_id', 'left');

			$this->db->where('orderdetails.order_id',$order_id);

			$query = $this->db->get();

			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 

				return $temp; 				
			}			else{				
				return false;
			}
		}*/
		$this->db->select('ECO.order_id,ECO.order_no,ECO.transaction_id,ECO.order_datetime,ECO.total,ECO.bill_address,ECO.ship_address,ECOD.*');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left'); 
		$this->db->where('ECO.customer_id',$customer_id);
		$this->db->where('ECO.order_id',$order_id);

		//$this->db->where('ECO.payment_response', 'null');
        $query = $this->db->get();
        //echo  $this->db->last_query();

        $num = $query->num_rows();
        if($num>0){
            $result = $query->result_array();
            return $result;
        }else{
            return array();
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
	
   function getAllEvent(){

        $this->db->select('*');
        $this->db->from('el_event_public');
		$this->db->where('event_status','1');
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
	
	public function listOrderdetails($orderID = 0) {
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
	
	function getOrderdetailsById($customer_id,$order_id){
		
        $this->db->select('ECO.order_id,ECO.order_no,ECO.transaction_id,ECO.order_datetime,ECO.total,ECO.bill_address,ECO.ship_address,ECO.customer_note,ECOD.*');
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
	    //echo $customer_id; echo "<br/>"; echo $order_id;
        $this->db->select('ECO.order_id,ECO.order_no,ECO.transaction_id,ECO.order_datetime,ECO.total,ECO.bill_address,ECO.ship_address,ECO.customer_note,ECOD.*');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left'); 
		$this->db->where('ECO.customer_id',$customer_id);
		$this->db->where('ECOD.order_id',$order_id);
		
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
	function getOrderdetailsSection($customer_id,$order_id){
		$this->db->select('ECOD.section');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left'); 
		$this->db->where('ECO.customer_id',$customer_id);
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
	function getOrderdetailsBySection($customer_id,$order_id,$section){
	    //echo $customer_id; echo "<br/>"; echo $order_id;
        $this->db->select('ECO.order_id,ECO.order_no,ECO.transaction_id,ECO.order_datetime,ECO.total,ECO.bill_address,ECO.ship_address,ECO.customer_note,ECOD.*');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left'); 
		$this->db->where('ECO.customer_id',$customer_id);
		$this->db->where('ECOD.order_id',$order_id);
		$this->db->where('ECOD.section',$section);
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
	function getOrderdetailsByOrderid($order_id){
	    //echo $customer_id; echo "<br/>"; echo $order_id;
        $this->db->select('ECO.order_id,ECO.order_no,ECO.transaction_id,ECO.order_datetime,ECO.total,ECO.bill_address,ECO.ship_address,ECO.customer_note,ECOD.*');
        $this->db->from('el_customer_order ECO');
		$this->db->join('el_customer_order_details ECOD', 'ECOD.order_id = ECO.order_id', 'left');
		$this->db->where('ECOD.order_id',$order_id);
		
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
	
	function getCountrylist()
	{
		$this->db->select('*');
		$this->db->from('el_country');
		$this->db->where('country_status','1');
		$query = $this->db->get();
		
		$num_row = $query->num_rows();
		if($num_row > 0)
		{
			$result = $query->result_array();
			
			return $result;
		}
		else{
			return 0;
		}
	}
	
	function getCountryByid($where='')
	{
		$this->db->select('*');
		$this->db->from('el_country');
		$this->db->where($where);
		$query = $this->db->get();
		
		$num_row = $query->num_rows();
		if($num_row > 0)
		{
			$result = $query->row_array();
			
			return $result;
		}
		else{
			return 0;
		}
	}
	
	function getStateByid($where='')
	{
		$this->db->select('*');
		$this->db->from('el_states');
		$this->db->where($where);
		$query = $this->db->get();
		
		$num_row = $query->num_rows();
		if($num_row > 0)
		{
			$result = $query->row_array();
			
			return $result;
		}
		else{
			return 0;
		}
	}
	
	function allCountrylist($country_id)
	{
		$this->db->select('*');
		$this->db->from('el_states');
		$this->db->where('country_id',$country_id);
		$this->db->where('state_status','1');
		
		$query = $this->db->get();
		$get_num_rows = $query->num_rows();
		if($get_num_rows > 0 )
		{
			$result = $query->result_array();
			return $result;
		}
		else{
			return 0;
		}
	}
	
}
?>