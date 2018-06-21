<?php
class Customermodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function allcustomerList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT elc.*,els.state_name FROM `el_customer` elc left join el_states els on elc.`customer_state_id` = els.state_id WHERE elc.`customer_status` ='1' order by `customer_id` DESC");
		
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
	
	function StatelistByCountry($country_id){
			if(isset($country_id) && !empty($country_id) && $country_id!=0){
			$this->db->select('States.state_id,States.state_name');
			$this->db->from('el_states States');
			$this->db->where('States.country_id',$country_id);
			$this->db->where('States.state_status','1');
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
	
	function CitylistByCountryState($state_id,$country_id){
			if(isset($country_id) && !empty($country_id) && $country_id!=0){
			$this->db->select('City.city_id,City.city_name');
			$this->db->from('el_city City');
			$this->db->where('City.state_id',$state_id);
			$this->db->where('City.country_id',$country_id);
			$this->db->where('City.city_status','1');
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
	
	public function listCustomerLocationRfid(){
			$this->db->select('ECLR.rel_id,ECLR.cust_rf_id,Location.location_name,Resort.resort_name,Customer.customer_firstname,Customer.customer_middlename,Customer.customer_lastname');
			$this->db->from('el_customer_location_rfid_rel ECLR');
			$this->db->join('el_location Location', 'ECLR.location_id = Location.location_id', 'LEFT');
			$this->db->join('el_resort Resort', 'ECLR.resort_id = Resort.resort_id', 'LEFT');
			$this->db->join('el_customer Customer', 'ECLR.customer_id = Customer.customer_id', 'LEFT');
			$this->db->where('ECLR.rel_status','1');
			$this->db->order_by("ECLR.rel_id", "desc");
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$num = $query->num_rows();
			if($num>0){
				$result = $query->result_array();
				return $result;
			}else{
				return 0;
			}
	}
	
/* 	function deleteLocationEventRelationbyId($customer_id){
			if(isset($customer_id) && !empty($customer_id) && $customer_id!=0){
			$this->db->select('*');
			$this->db->from('el_customer_location_event_relation');
			$this->db->where('customer_id',$customer_id);
			$query = $this->db->get();
			$num = $query->num_rows();
			if($num>0){
				$result = $query->result_array();
				return $result;
			}else{
				return 0;
			}
		}
    } */
	
/* 	function deleteAssigneventCustomerId($data='',$location_event_id='',$table=''){
		if(isset($location_event_id) && !empty($location_event_id)){
			$this->db->where('customer_location_event_id', $location_event_id);
            $this->db->update($table, $data);
            return 1;
        } else{
                return 0;
        }       

    } */
	
	public function isRecordExist($tableName = '', $condition = '') {
		if($condition == '') $condition = 1;
		$sql = "SELECT * FROM ".$tableName." WHERE ".$condition."";
		
        //echo $sql;exit;
		$rs 				= $this->db->query($sql);
		if($rs->num_rows() > 0) {
			$result 		= $rs->result_array();
			return $result;
		} else {
			return 0;
		}
	}	
	
	function deleteAssigneventCustomerId($dataArr = array(), $tableName = '', $conditionArr = array()) {
        if(count($conditionArr) > 0) {
            $this->db->update($tableName, $dataArr, $conditionArr);
            //echo "hi - ".$this->db->last_query();// exit;
            if($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
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
	/*public function fetchLocationdtls($locationId)
	{
		$sql = "SELECT * FROM el_location WHERE location_id=$locationId";
            $rs = $this->db->query($sql);
			
            if($rs->num_rows()) {
                $rec = $rs->row();
                return $rec->is_location_refid_exists;
            }
            return false;
	}*/
	
	public function fetchLocationdtls($resortID)
	{
		//echo $resortID;exit;
		$sql = "SELECT * FROM el_resort WHERE resort_id=$resortID";
            $rs = $this->db->query($sql);
			
            if($rs->num_rows()) {
                $rec = $rs->row();
                return $rec->is_location_resort_refid_exists;
            }
            return false;
	}
	
	public function fetchResortrdtls($rfID,$locationId,$resortId)
	{
		    $sql = "SELECT * FROM el_customer_location_rfid_rel WHERE cust_rf_id='".$rfID."' and location_id = '".$locationId."' and resort_id ='".$resortId."'";
            $rs = $this->db->query($sql);
			
            if($rs->num_rows()) {
                $rec = $rs->row_array();
				//print_r($rec);
                return $rec['customer_id'];
            }
            return false;
	}
	
	public function fetchCustomerdtls($cID)
	{
		    $sql = "SELECT * FROM el_customer WHERE customer_id=$cID";
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
	
	public function populatecustomer() {

		$this->db->select('*');

		$this->db->from('el_customer');

		$this->db->where('customer_status','1');

		$query = $this->db->get();

		$num = $query->num_rows();	

			
		//echo $this->db->last_query();exit;
		if($num >0) {
			$rec = $query->result_array();
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
	function customerAdd($data) {
		$relData	= array();
		if(!empty($data)){              
			
			$this->db->insert('el_customer', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();

				
			return  $insert_id;
		}
		
		else{

			return 0;
		}
    }	
	/*function CustomerDataEdit($id){

		if(isset($id) && !empty($id) && $id!=0){

			$this->db->select('elc.*,elrr.*,elr.*');

			$this->db->from('el_customer elc');
			
			$this->db->join('el_customer_location_rfid_rel elrr', 'elc.customer_id = elrr.customer_id', 'left');

			$this->db->join('el_resort elr', 'elrr.resort_id = elr.resort_id', 'left'); 		

			$this->db->where('elc.customer_id',$id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
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
    }*/
	function CustomerDataEdit($id){

		if(isset($id) && !empty($id) && $id!=0){

			$this->db->select('elc.*');

			$this->db->from('el_customer elc');
			
			$this->db->where('elc.customer_id',$id);

			$query = $this->db->get();
			//echo $this->db->last_query();exit;
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
	function updateCustomerbyId($cid, $data) {
		
		if($data!=''){			
						
			$this->db->where('customer_id', $cid);
			$this->db->update('el_customer', $data);
			return 1;
		}
		else{
			return 0;
		}
    }
	
	
	function deleteCustomerbyId($cid){

        if(isset($cid) && !empty($cid)){
            $data 	=  array('customer_status'=>'0');
			//$data2	=  array('status'=>'0');
			  
			$this->db->where('customer_id', $cid);
            $this->db->update('el_customer', $data);
			
			/* $this->db->where('customer_id', $cid);
            $this->db->update('el_customer_resort_relation', $data2); */
			
            return 1;



        } else{



                return 0;

        }
	}
	function verifyRfidWithCustomer($resort_id,$rf_id){
		if(!empty($resort_id) && !empty($rf_id)){
			$recArr	= array();
			
			$sql	= $this->db->query("SELECT * from el_customer_location_rfid_rel where resort_id ='".$resort_id."' And cust_rf_id = '". $rf_id ."'");
			
			echo $this->db->last_query();exit;
			$num = $sql->num_rows();
			if($num>0){
				$recArr = $sql->result_array();
				
			}
			return $recArr;
		}
		else{
			$recArr ='';
			return $recArr;
		}
	}
	function addCustomerwithRfId($location_id,$resort_id,$customer_id,$rf_id){
		if(!empty($location_id) && !empty($resort_id) && !empty($customer_id)){
		$relData = array( 					
							'customer_id' 		=> $customer_id,
							
							'location_id'		=> $location_id,
							
							'resort_id'    		=> $resort_id,
							
							'status'			=>'1'
					
							);
							
		$Datarel = array( 	
							'location_id'		=> $location_id,
							
							'resort_id'    		=> $resort_id,
						
							'customer_id' 		=> $customer_id,
							
							'cust_rf_id'		=> $rf_id,
							
							'rel_status'			=>'1'
					
							);
		$insert_id = $this->db->insert('el_customer_location_resort_relation', $relData);
		
		$insert_id2 = $this->db->insert('el_customer_location_rfid_rel', $Datarel);
		
		
			return  $insert_id;
		}
		else{
			
			return  0;
			
		}
	}
}