<?php
class Resortmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
	function index(){
			$this->db->select('*');
			$this->db->from('el_resort');
			$this->db->where('resort_status','1');
			$this->db->order_by("el_resort.resort_id", "desc");
			$query = $this->db->get();
			$num = $query->num_rows();
			if($num>0){
				$result = $query->result();
				return $result;
			}else{
				return 0;
			}
    }
	function checkUniqueEmail($email){
		if(isset($email) && !empty($email)){

			$this->db->select('elr.*');

			$this->db->from('el_resort elr');			

			$this->db->where('elr.resort_email',$email);
			
			$this->db->where('elr.resort_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function checkUniquemobile($mobile){
		if(isset($mobile) && !empty($mobile)){

			$this->db->select('elr.*');

			$this->db->from('el_resort elr');			

			$this->db->where('elr.resort_mobile',$mobile);
			
			$this->db->where('elr.resort_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
    function addResorts($data) {
		if(!empty($data)){              				               
		$this->db->insert('el_resort', $data);								
		$insert_id = $this->db->insert_id();								
		return  $insert_id;              		
		}				
		else{			
		return 0;		
		}
    }
	
	function Resortedit($id){
			if(isset($id) && !empty($id) && $id!=0){
			$this->db->select('*');
			$this->db->from('el_resort');
			$this->db->where('resort_id',$id);
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
	function checkUniqueEmailInEdit($email,$post_id){
		if(isset($email) && !empty($email)){

			$this->db->select('elr.*');

			$this->db->from('el_resort elr');			

			$this->db->where('elr.resort_email',$email);
			
			$this->db->where('elr.resort_id !=',$post_id);
			
			$this->db->where('elr.resort_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function checkUniquemobileInEdit($mobile,$post_id){
		if(isset($mobile) && !empty($mobile)){

			$this->db->select('elr.*');

			$this->db->from('el_resort elr');			

			$this->db->where('elr.resort_mobile',$mobile);
			
			$this->db->where('elr.resort_id !=',$post_id);
			
			$this->db->where('elr.resort_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function updateResortbyId($pid, $data) {		
		if($data!=''){			
			$this->db->where('resort_id', $pid);
			$this->db->update('el_resort', $data);
			return 1;		
		}		
		else{			
			return 0;		
		}
    }
	
	function deleteResortbyId($pid){
        if(isset($pid) && !empty($pid)){
            $data =  array('resort_status'=>'0');
            $this->db->where('resort_id', $pid);
            $this->db->update('el_resort', $data);
            return 1;
        } else{
                return 0;
        }
    }	
}