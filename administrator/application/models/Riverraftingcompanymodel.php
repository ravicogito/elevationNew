<?php
class Riverraftingcompanymodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
	function index(){

			$this->db->select('*');
			$this->db->from('el_raftingcompany');
			$this->db->where('raftingcompany_status','1');			
			$this->db->order_by("el_raftingcompany.raftingcompany_id", "desc");
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

			$this->db->select('elp.*');

			$this->db->from('el_raftingcompany elp');			

			$this->db->where('elp.raftingcompany_email',$email);
			
			$this->db->where('elp.raftingcompany_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function checkUniquemobile($mobile){
		if(isset($mobile) && !empty($mobile)){

			$this->db->select('elp.*');

			$this->db->from('el_raftingcompany elp');			

			$this->db->where('elp.raftingcompany_mobile',$mobile);
			
			$this->db->where('elp.raftingcompany_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	
	function checkUniqueUsername($username){
		if(isset($username) && !empty($username)){

			$this->db->select('ead.*');

			$this->db->from('el_admin ead');			

			$this->db->where('ead.username',$username);
			
			$this->db->where('ead.user_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	
   
	
	public function insertData($dataArr = array(), $tableName = '') {
        $this->db->insert($tableName, $dataArr);
		//echo "hi - ".$this->db->last_query();
        if($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }
	
	function RiverraftingcompanyEdit($id){
			if(isset($id) && !empty($id) && $id!=0){
			$this->db->select('elp.*');
			$this->db->from('el_raftingcompany elp');
			$this->db->where('elp.raftingcompany_id',$id);
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
	
	
	
	function checkCurrentPassword($id = "",$current_password = ""){
		if(isset($id) && !empty($id) && $id!=0){
			$this->db->select('ead.*');
			$this->db->from('el_admin ead');
			$this->db->where('ead.user_id',$id);
			$this->db->where('ead.password',$current_password);
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
	
	
	
	function updateRiverraftingbyId($pid, $data) {				
	if($data!=''){			
												
			$this->db->where('raftingcompany_id', $pid);			
			$this->db->update('el_raftingcompany', $data);						
					
			return 1;		
		}		
		else{			
		return 0;		
		}
    }
	
	
	
	function deleteRaftingCompanybyId($pid){

        if(isset($pid) && !empty($pid)){

            $data =  array('raftingcompany_status'=>'0');			  			
			$this->db->where('raftingcompany_id', $pid);
            $this->db->update('el_raftingcompany', $data);
            return 1;

        } else{

                return 0;
        }
    }	
	
	

}