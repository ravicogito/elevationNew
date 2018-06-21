<?php
/**
 *
 * @ CustomerPhotos model
 *
 *
 */

class Model_customerPhotos extends CI_Model {
	
	private $limit;
    private $pageNumber;
    private $offset;
	
    function __construct() {
       parent::__construct();
	   
    }
	
	function getcustomerLocationDetails($customer_id,$location_id){
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_customer customer');
			
			$this->db->join('el_customer_location_resort_relation customer_location_resort', 'customer_location_resort.customer_id = customer.customer_id', 'left');
			
			$this->db->join('el_customer_location_rfid_rel customer_location_rfid', 'customer_location_resort.resort_id = customer_location_rfid.resort_id', 'left');
			$this->db->where('customer_location_rfid.customer_id',$customer_id);
			
			$this->db->where('customer_location_resort.location_id',$location_id);

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
	function countEventByLocationID($location_id,$customer_id){
		$this->db->select('location_rel.*,event.*');

		$this->db->from('el_event event');
		
		$this->db->join('el_customer_location_event_relation location_rel', 'location_rel.event_id = event.event_id', 'left');

		$this->db->where('location_rel.location_id',$location_id);
		
		$this->db->where('location_rel.customer_id',$customer_id);
		
		$this->db->where('location_rel.rel_status','1');
		
		$query = $this->db->get();	

		//echo $this->db->last_query();exit;
		if( $query->num_rows()> 0 ){
			
			$count = $query->num_rows(); 
			
			return $count; 				
		}			
		else{				
			return false;
		}


	}
	/*function getEventByLocationID($location_id, $lmt){
		//echo $lmt;exit;
			$this->db->select('*');

			$this->db->from('el_event event');
			
			$this->db->join('el_location location', 'location.location_id = event.location_id', 'left');

			$this->db->where('event.location_id',$location_id);
			
			$this->db->limit(5,$lmt);
			
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				//print_r($query->result_array());exit;
				return $temp; 				
			}			else{				
				return false;
			}
	}*/
	function getEventByLocationID($location_id,$customer_id,$start ='0'){
		if($start != 0 ){
			$condition	= 'Limit 5,'.$start;
		}
		else{
			$condition	= 'Limit 5';
		}
		$query = $this->db->query("Select location_rel.*,event.*,location.* from el_event event left join el_customer_location_event_relation location_rel on location_rel.event_id = event.event_id left join el_location location on location.location_id = location_rel.location_id where location_rel.location_id = '".$location_id."' And location_rel.customer_id = '".$customer_id."' and location_rel.rel_status ='1' $condition");
		//echo $this->db->last_query();exit;
		if( $query->num_rows()> 0 ){
			
			$temp = $query->result_array(); 
			//print_r($query->result_array());exit;
			return $temp; 				
		}			else{				
			return false;
		}
	}
	function getImagesByEventID($event_id,$customer_id){
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_media_image images');
			
			$this->db->join('el_media_customer_photographer_relation cp', 'cp.media_id = images.media_id', 'left');
			
			$this->db->where('images.publish_status','1');
			
			$this->db->where('images.media_status','1');
			
			$this->db->where('images.event_id',$event_id);
			
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
	
	function getAllImages($event_id,$customer_id){
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_media_image images');
			
			$this->db->join('el_media_customer_photographer_relation cp', 'cp.media_id = images.media_id', 'left');
			
			$this->db->where('images.publish_status','1');
			
			$this->db->where('images.media_status','1');
			
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
	
		function getLocation($location_id){
		
		if($location_id !=""){

			$this->db->select('*');

			$this->db->from('el_location location');
			
			$this->db->where('location.location_status','1');
			
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
	
	function getResort($customer_id,$location_id,$event_id){
		
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_resort resort');
			
			$this->db->join('el_customer_location_event_relation cl', 'cl.resort_id = resort.resort_id', 'left');
			
			$this->db->where('resort.resort_status','1');
			
			$this->db->where('cl.rel_status','1');	
			
			$this->db->where('cl.customer_id',$customer_id);
			
			$this->db->where('cl.event_id',$event_id);
			
			$this->db->where('cl.location_id',$location_id);

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
	
	
	function getEvents($location_id,$resort_id,$event_id){
		
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_event event');
			
			$this->db->join('el_customer_location_event_relation cl', 'cl.event_id = event.event_id', 'left');
			
			$this->db->where('event.event_status','1');
			
			$this->db->where('event.event_id',$event_id);
			
			$this->db->where('cl.resort_id',$resort_id);
			
			$this->db->where('cl.location_id',$location_id);
			
			$this->db->where('cl.rel_status','1');

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
	
		public function setLimit($limit) {
            $this->_limit = $limit;
        }
 
        public function setPageNumber($pageNumber) {
            $this->_pageNumber = $pageNumber;
        }
 
        public function setOffset($offset) {
            $this->_offset = $offset;
        }
        // Count all record of table "employee" in database.
         public function getAllCustomerImages($event_id,$customer_id) {
            $this->db->from('el_media_image images');
						
			$this->db->join('el_media_customer_photographer_relation cp', 'cp.media_id = images.media_id', 'left');
			
			$this->db->where('images.publish_status','1');
			
			$this->db->where('cp.event_id',$event_id);
			
			$this->db->where('cp.customer_id',$customer_id);
			
			$this->db->where('cp.rel_status','1');

            return $this->db->count_all_results();
        }
		
		public function get_data($where, $fields,$limit, $start,$event_id,$customer_id)
		{
			return $this->getAllDetailsImages($where,$fields , $limit, $start);
		}
		
		
	
	function getAllDetailsImages($event_id,$customer_id,$limit, $start){
		if($event_id !=""){

			$this->db->select('*');

			$this->db->from('el_media_image images');
			
			$this->db->join('el_media_customer_photographer_relation cp', 'cp.media_id = images.media_id', 'left');
			
			$this->db->where('images.publish_status','1');
			
			$this->db->where('images.event_id',$event_id);
			
			$this->db->where('cp.customer_id',$customer_id);
			
			$this->db->where('cp.rel_status','1');
			
			$this->db->limit($limit, $start);		

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
	
	function getPhotographerdtls($photographer_id){
		if($photographer_id !=""){

			$this->db->select('*');

			$this->db->from('el_photographer photographer');
			
			$this->db->where('photographer.photographer_status','1');
			
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
	function getLocationDetails($cid){
		if($cid !=""){
			
			$this->db->select('elclr.*,location.*');

			$this->db->from('el_customer_location_resort_relation elclr');
			
			$this->db->join('el_location location', 'elclr.location_id = location.location_id', 'left');
			
			$this->db->where('elclr.customer_id',$cid);
			
			$this->db->where('location.location_status','1');
			
			$this->db->where('elclr.status','1');
			
			$this->db->group_by('elclr.location_id');
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if( $query->num_rows()> 0 ){				
				$temp = $query->result_array(); 
				return $temp; 				
			}		
			else{				
				return false;
			}
		}
		else{
			return false;
		}
		
		
		
	}
}
?>