<?php 
class model_other extends CI_Model {

	function __construct(){
		parent::__construct();
		
	}
	
	
	function getLocation($location_id){
		
		if($location_id !=""){

			$this->db->select('*');

			$this->db->from('el_location location');
			
			$this->db->where('location.location_id',$location_id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				
				$temp = $query->row_array(); 
				return $temp; 				
			}			else{				
				return false;
			}
		}
		
	}	
	
	function getResort($customer_id,$location_id){
		
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_resort resort');
			
			$this->db->join('el_customer_resort_relation cl', 'cl.resort_id = resort.resort_id', 'left');
			
			$this->db->where('cl.customer_id',$customer_id);

			$query = $this->db->get();

			if( $query->num_rows()> 0 ){
				
				$temp = $query->row_array(); 
				return $temp; 				
			}			else{				
				return false;
			}
		}
		
	}	
	
	
	function getEvents($event_id){
		
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_event event');
			
			$this->db->where('event.event_id',$event_id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				
				$temp = $query->row_array(); 
				return $temp; 				
			}			else{				
				return false;
			}
		}
		
	}
	
	function getAllDetailsImages($event_id,$customer_id){
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_media_image images');
			
			$this->db->join('el_media_customer_photographer_relation cp', 'cp.media_id = images.media_id', 'left');
			
			$this->db->where('images.event_id',$event_id);
			
			$this->db->where('cp.customer_id',$customer_id);
			
			$this->db->where('cp.rel_status','1');
			
			$query = $this->db->get();
			//echo $this->db->last_query();
			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				//print_r($query->result_array());exit;
				return $temp; 				
			}			else{				
				return false;
			}
		}

	}
	
	function getPhotographer($photographer_id){
		if($photographer_id !=""){

			$this->db->select('*');

			$this->db->from('el_photographer photographer');
			
			$this->db->where('photographer.photographer_id',$photographer_id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				
				$temp = $query->row_array(); 
				return $temp['photographer_name']; 				
			}			else{				
				return false;
			}
		}

	}

	
	
}	