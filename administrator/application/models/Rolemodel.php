<?php
class Rolemodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
	
	 function allroleList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT role.* FROM `el_role` role WHERE role.`role_status` ='1' ");
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    } 
	
	function roleAdd($data) {
		$relData	= array();
		if(!empty($data)){              
			
			$this->db->insert('el_role', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
		
		else{

			return 0;
		}
    }

    function RoleDataEdit($id){

		if(isset($id) && !empty($id) && $id!=0){

			$this->db->select('role.*');

			$this->db->from('el_role role');
			
			$this->db->where('role.role_id',$id);

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

    function updateRolebyId($role_id, $data) {
		
		if($data!=''){
						
			$this->db->where('role_id', $role_id);
			$this->db->update('el_role', $data);
			
			return 1;
		}
		else{
			return 0;
		}
    }	
}