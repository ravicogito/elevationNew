<?php
class Usermodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
	
	 function alluserList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT user.* FROM `el_admin` user WHERE user.`user_status` ='1'");
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    } 
	
	 public function roleList(){
		$this->db->select('*');

		$this->db->from('el_role');

		$this->db->where('role_status','1');

		$query = $this->db->get();

		$num = $query->num_rows();

		

		if($num>0){


			$result = $query->result();

			return $result;

		}else{

			return 0;

		}
	}	
	
	function userAdd($data) {
		$relData	= array();
		if(!empty($data)){              
			
			$this->db->insert('el_admin', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
		
		else{

			return 0;
		}
    }

    function UserDataEdit($id){

		if(isset($id) && !empty($id) && $id!=0){

			$this->db->select('user.*');

			$this->db->from('el_admin user');
			
			$this->db->where('user.user_id',$id);

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

    function updateUserbyId($user_id, $data) {
		
		if($data!=''){
						
			$this->db->where('user_id', $user_id);
			$this->db->update('el_admin', $data);
			
			return 1;
		}
		else{
			return 0;
		}
    }	
}