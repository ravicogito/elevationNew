<?php
/**
 *
 * @ Cart model
 *
 *
 */

class Model_wishlist extends CI_Model {
	
    function __construct() {
       parent::__construct();
    }
	
	function getImgDetails($image_id = '') {
		$recArr						= array();
		if(!empty($image_id)) {
			$this->db->select('MI.media_title, MI.media_path, MI.file_name, MI.media_type, MI.event_id, MI.media_price, E.event_name, E.location_id, E.resort_id, E.photographer_id, P.photographer_name');
        	$this->db->from('el_media_image MI');
        	$this->db->join('el_event E', 'MI.event_id = E.event_id', 'LEFT');
        	$this->db->join('el_photographer P', 'E.photographer_id = P.photographer_id', 'LEFT');
        	$this->db->where('MI.media_id', $image_id);
        	$query 					= $this->db->get();
        	$num 					= $query->num_rows();
	        if($num>0){	         
	            $recArr 			= $query->row_array();
			}
		}
		return $recArr;
	}

    function getwishlistDetails($customer_id){
		$temp   = array();
		if($customer_id !=""){

			$this->db->select('*');

			$this->db->from('el_wishlist wishlist');
			
			$this->db->join('el_media_image image', 'image.media_id = wishlist.image_id', 'left');
			
			
			$this->db->join('el_photographer photographer', 'photographer.photographer_id = wishlist.photographer_id', 'left');
			
			$this->db->where('wishlist.user_id',$customer_id);
			
			
			
			$this->db->order_by("wishlist_id", "desc");
			

			$query = $this->db->get();

			if( $query->num_rows()> 0 ){
				
				$temp = $query->result_array(); 
				
				 				
			}return $temp;
		}

	}	
	
}
?>