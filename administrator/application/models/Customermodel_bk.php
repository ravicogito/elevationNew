<?php
class Customermodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function allcustomerList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT elc.*,els.state_name,elcr.resort_id,elr.resort_name FROM `el_customer` elc left join el_states els on elc.`customer_state_id` = els.state_id left join el_customer_resort_relation elcr on elc.`customer_id` = elcr.customer_id left join el_resort elr on elcr.resort_id = elr.resort_id WHERE elc.`customer_status` ='1' ");
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    } 
	function Resortlist($lid){
			if(isset($lid) && !empty($lid) && $lid!=0){
			$this->db->select('*');
			$this->db->from('el_resort');
			$this->db->where('location_id',$lid);
			$query = $this->db->get();
			$num = $query->num_rows();
			if($num>0){
				$result = $query->result_array();
				return $result;
			}else{
				return 0;
			}
		}
    }
    public function locationList(){
		$this->db->select('*');

		$this->db->from('el_location');

		$this->db->where('location_status','1');

		$query = $this->db->get();

		$num = $query->num_rows();

		

		if($num>0){


			$result = $query->result();

			return $result;

		}else{

			return 0;

		}
	}	
	
	public function countryList(){
		$this->db->select('*');

		$this->db->from('el_country');

		$this->db->where('country_status','1');

		$query = $this->db->get();

		$num = $query->num_rows();

		

		if($num>0){

			$result = $query->result();

			return $result;

		}else{

			return 0;

		}
	}

	public function cityList(){
		$this->db->select('*');

		$this->db->from('el_city');

		$this->db->where('city_status','1');

		$query = $this->db->get();

		$num = $query->num_rows();

		

		if($num>0){

			//print_r($query->row_array()); exit;

			//echo "<pre>";

			$result = $query->result();

			return $result;

		}else{

			return 0;

		}
	}
	
	public function stateList(){
		$this->db->select('*');

		$this->db->from('el_states');

		$this->db->where('state_status','1');

		$query = $this->db->get();

		$num = $query->num_rows();

		

		if($num>0){

			//print_r($query->row_array()); exit;

			//echo "<pre>";

			$result = $query->result();

			return $result;

		}else{

			return 0;

		}
	}
	public function fetchLocationdtls($locationId)
	{
		$sql = "SELECT * FROM el_location WHERE location_id=$locationId";
            $rs = $this->db->query($sql);
			
            if($rs->num_rows()) {
                $rec = $rs->row();
                return $rec->is_location_refid_exists;
            }
            return false;
	}
	
	
	public function fetchCustomerdtls($rfID)
	{
		    $sql = "SELECT elc.*,(select event_name from el_event where event_id = elc.event_id)as event_name,(select event_price from el_event where event_id = elc.event_id)as event_price, FROM el_customer elc WHERE customer_ref_id=$rfID";
            $rs = $this->db->query($sql);
			
            if($rs->num_rows()) {
                $rec = $rs->result_array();
                return $rec;
            }
            return false;
	}
	
	
	public function populateDropdown($idField, $nameField, $tableName, $condition, $orderField, $orderBy) {
		
            $sql = "SELECT ".$idField.", ".$nameField." FROM ".$tableName." WHERE ".$condition." ORDER BY ".$orderField." ".$orderBy."";
            $rs = $this->db->query($sql);
			
			//echo $this->db->last_query();exit;
            if($rs->num_rows()) {
                $rec = $rs->result_array();
                return $rec;
            }
            return false;
	}
	function checkUniqueEmail($email){
		if(isset($email) && !empty($email)){

			$this->db->select('elc.*');

			$this->db->from('el_customer elc');			

			$this->db->where('elc.customer_email',$email);
			
			$this->db->where('elc.customer_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function checkUniquemobile($mobile){
		if(isset($mobile) && !empty($mobile)){

			$this->db->select('elc.*');

			$this->db->from('el_customer elc');			

			$this->db->where('elc.customer_email',$mobile);
			
			$this->db->where('elc.customer_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function customerAdd($data,$resortID) {
		$relData	= array();
		if(!empty($data)){              
			
			$this->db->insert('el_customer', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
			
			if(!empty($insert_id)){
				$relData = array( 	'resort_id'    		=> $resortID,
						
									'customer_id' 		=> $insert_id,
									
									'customer_ref'		=> $data['customer_ref_id'],
									
									'status'		=>'1'
					
							);
				$this->db->insert('el_customer_resort_relation', $relData);
			}
				
			return  $insert_id;
		}
		
		else{

			return 0;
		}
    }	
	function CustomerDataEdit($id){

		if(isset($id) && !empty($id) && $id!=0){

			$this->db->select('elc.*,elcr.*');

			$this->db->from('el_customer elc');
			
			$this->db->join('el_customer_resort_relation elcr', 'elc.customer_id = elcr.customer_id', 'left'); 

			$this->db->where('elc.customer_id',$id);

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
	function checkUniqueEmailInEdit($email,$c_id){
		if(isset($email) && !empty($email)){

			$this->db->select('elc.*');

			$this->db->from('el_customer elc');			

			$this->db->where('elc.customer_email',$email);
			
			$this->db->where('elc.customer_id !=',$c_id);
			
			$this->db->where('elc.customer_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function checkUniquemobileInEdit($mobile,$c_id){
		if(isset($mobile) && !empty($mobile)){

			$this->db->select('elc.*');

			$this->db->from('el_customer elc');			

			$this->db->where('elc.customer_email',$mobile);
			
			$this->db->where('elc.customer_id !=',$c_id);
			
			$this->db->where('elc.customer_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function updateCustomerbyId($cid, $data ,$resort_id) {
		
		if($data!=''){
			$relDatta = array(
								'resort_id'		=>$resort_id,
								'customer_ref'	=> $data['customer_ref_id']
						);
						
			$this->db->where('customer_id', $cid);
			$this->db->update('el_customer', $data);
			
			$this->db->where('customer_id', $cid);		
			$this->db->update('el_customer_resort_relation', $relDatta);
			
			return 1;
		}
		else{
			return 0;
		}
    }
	
	
	function deleteCustomerbyId($cid){

        if(isset($cid) && !empty($cid)){
            $data 	=  array('customer_status'=>'0');
			$data2	=  array('status'=>'0');
			  
			$this->db->where('customer_id', $cid);
            $this->db->update('el_customer', $data);
			
			$this->db->where('customer_id', $cid);
            $this->db->update('el_customer_resort_relation', $data2);
			
            return 1;



        } else{



                return 0;

        }
	}
}