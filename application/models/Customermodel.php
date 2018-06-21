<?php
class Customermodel extends CI_Model {
    function __construct() {
       parent::__construct();
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
	
	function isExist($event_id,$cust_id){
		if(!empty($event_id) && !empty($cust_id)){

			$this->db->select('*');

			$this->db->from('el_event_customer_rel');			

			$this->db->where('el_event_customer_rel.event_id',$event_id);
			
			$this->db->where('el_event_customer_rel.customer_id',$cust_id);

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

			$this->db->where('elc.customer_mobile',$mobile);
			
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
	
	function insCustomerEventRel($data) {
		$relData	= array();
		if(!empty($data)){              
			
			$this->db->insert('el_event_customer_rel', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();

				
			return  $insert_id;
		}
		
		else{

			return 0;
		}
    }
	
	function getUserExistByemail($email){
		if(isset($email) && !empty($email)){
		$this->db->select('*');
		$this->db->from('el_customer ECL');
		$this->db->where('ECL.customer_email',$email);
		$this->db->where('ECL.customer_status','1');
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$result = $query->row_array();
			return $result;
		}else{
			return 0;
		}
		}
    }
	
	function updatedUser($tbl,$data,$customer_id) {	

		if(!empty($data)){

			$this->db->where('customer_id', $customer_id);

            $this->db->update($tbl, $data);

			return 1;

		}else{

			return 0;

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
	
}