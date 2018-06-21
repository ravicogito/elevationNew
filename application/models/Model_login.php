<?php 
class model_login extends CI_Model {

	function __construct(){
		parent::__construct();
		
	}
	function chkUserAuth($username,$pass){
		if( $username !="" && $pass !="" ){

			$this->db->select('*');

			$this->db->from('el_customer');

			$this->db->where('customer_email',$username);

			$this->db->where('customer_password',$pass);
			
			$this->db->where('customer_status','1');

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
  
	
	function getUserDetailsDB($condition = '') {
    	$recArr					= array();
        if(!empty($condition)) {
        	$sql				= "SELECT
								  UM.*
								FROM el_customer UM								  
								WHERE $condition
								    AND UM.customer_status = '1'";
			//echo $sql;exit;					    
        	$rs 				= $this->db->query($sql);
        	if($rs->num_rows() > 0) {
				$recArr 		= $rs->row_array();
			} else {
				$recArr			= array();
			}
			
        }		
		//echo $this->db->last_query();exit;
        return $recArr;
    }
	
	function getUserCredentials($email){
		
		$sql = "SELECT customer_email, customer_password FROM el_customer WHERE customer_email='".$email."' AND customer_status = '1'";
		//echo $sql;
		//exit;
		$res = $this->db->query($sql);
		if($res->num_rows() > 0) {
				$recArr 		= $res->row();
			} else {
				$recArr			= array();
			}
			
			return $recArr;
	
		
	}

}
?>