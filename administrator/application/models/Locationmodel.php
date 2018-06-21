<?php
class Locationmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function alllocationList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1 order by lc.location_id desc");
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    } 

    function addLocation($data) {
		$location_rel	=	array();
		
		if(!empty($data)){
			$this->db->insert('el_location', $data);
			
			$insert_id = $this->db->insert_id();
			
			return $insert_id;

		}
		
		else{

			return 0;
		}      

    }	
	
	function LocationDataEdit($id){

		if(isset($id) && !empty($id) && $id!=0){

			$this->db->select('lc.*');

			$this->db->from('el_location lc');
			
			$this->db->where('lc.location_id',$id);

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
	
	function updateLocationbyId($id, $data) {
		
		if($data!=''){
						
			$this->db->where('location_id', $id);
			$this->db->update('el_location', $data);
			
			return 1;
		}
		else{
			return 0;
		}
    }
	
	function deleteLocationbyId($id){

        if(isset($id) && !empty($id)){
            $data 	=  array('location_status'=>'0');
			  
			$this->db->where('location_id', $id);
            $this->db->update('el_location', $data);
			
            return 1;



        } else{



                return 0;

        }
	}
	
}	