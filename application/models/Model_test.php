<?php
/**
 *
 * @ Registration model
 *
 *
 */

class Model_test extends CI_Model {
	
    function __construct() {
       parent::__construct();
    }
	
	function getPageContent($page_id){
		
		$this->db->select('*');

        $this->db->from('el_pages');

        $this->db->where('seo_title',$page_id);

        $query = $this->db->get();

		

        $num = $query->num_rows();

        if($num>0){

            //print_r($query->row_array()); exit;

            //echo "<pre>";

            $result = $query->row_array();

            return $result;

        }else{

            return 0;

        }
	}
	
}