<?php
/**
 *
 * @ Profile model
 *
 *
 */

	class Model_profile extends CI_Model {
		private $limit;
		private $pageNumber;
		private $offset;
		
		function __construct() {
		   parent::__construct();
		   
		}
	function getUserDetails($customer_id){
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_customer');

			$this->db->where('customer_id',$customer_id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				
				$temp = $query->row_array(); 
				//print_r($query->result_array());exit;
				return $temp; 				
			}			else{				
				return false;
			}
		}

	}

    function getLocation($customer_id){
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_location location');
			
			$this->db->join('el_customer_location_resort_relation cr', 'cr.location_id = location.location_id', 'left');
			
			$this->db->where('cr.customer_id',$customer_id);
			
			$this->db->group_by('cr.location_id');
			
			$this->db->group_by('cr.status','1');
			
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				return $temp; 				
			}			else{				
				return false;
			}
		}

	}


    function getImagesByEventID($customer_id){
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_media_image images');
			
			$this->db->join('el_media_customer_photographer_relation cp', 'cp.media_id = images.media_id', 'left');
			
			$this->db->where('images.publish_status','1');
			
			$this->db->where('images.media_status','1');
			
			$this->db->where('cp.customer_id',$customer_id);

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				return $query->num_rows(); 				
			}			else{				
				return false;
			}
		}

	}

    function photographerListByCustomerid($customer_id=''){
	    if($customer_id !=""){
		
		//$this->db->from('el_photographer photographer');
		
		$this->db->from('el_customer_location_event_relation cp');
			
		$this->db->join('el_photographer photographer', 'photographer.photographer_id = cp.photographer_id', 'left');
		
		$this->db->where('cp.rel_status','1');
		
		$this->db->group_by('cp.photographer_id');
		
		$this->db->where('photographer.photographer_status','1');
			
		$this->db->where('cp.customer_id',$customer_id);
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				return $query->result_array(); 				
			}			else{				
				return false;
			}
		}	
    }

    function getLocationdetails($location_id){

       
		if($location_id !=""){

			$this->db->select('*');

			$this->db->from('el_location location');
			
			$this->db->where('location.location_id',$location_id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				return $temp; 				
			}			else{				
				return false;
			}
		}

    }	
}
?>
