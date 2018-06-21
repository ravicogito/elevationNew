<?php
class Photographermodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
	function index(){

			$this->db->select('*');
			$this->db->from('el_photographer');
			$this->db->where('photographer_status','1');			
			$this->db->order_by("el_photographer.photographer_id", "desc");
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

			$this->db->from('el_photographer elp');			

			$this->db->where('elp.photographer_email',$email);
			
			$this->db->where('elp.photographer_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function checkUniquemobile($mobile){
		if(isset($mobile) && !empty($mobile)){

			$this->db->select('elp.*');

			$this->db->from('el_photographer elp');			

			$this->db->where('elp.photographer_mobile',$mobile);
			
			$this->db->where('elp.photographer_status','1');

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
	
    function photographerAdd($data,$resortID) {
		$relData	= array();		if(!empty($data)){              							
		$this->db->insert('el_photographer', $data);						
		$insert_id = $this->db->insert_id();						
		/* if(!empty($insert_id)){				
			$relData = array( 	'resort_id'    		=> $resortID,	
								'photographer_id' 	=> $insert_id,									'rel_status'		=>'1'
									
							);				
			$this->db->insert('el_photographer_resort_relation', $relData);			
		} */							
		return  $insert_id;		
		}				
		else{			
			return 0;		
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
	
	function photographerEdit($id){
			if(isset($id) && !empty($id) && $id!=0){
			$this->db->select('elp.*');
			$this->db->from('el_photographer elp');
			$this->db->where('elp.photographer_id',$id);
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
	
	function editUserByid($id = ""){
		if(isset($id) && !empty($id) && $id!=0){
			$this->db->select('ead.*');
			$this->db->from('el_admin ead');
			$this->db->where('ead.user_id',$id);
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
				//print_r($query->row_array()); exit;
				//echo "<pre>";
				$result = $query->row_array();
				return $result;
			}else{
				return 0;
			}

				   
			}
	}
	
	function checkUniqueEmailInEdit($email,$pid){
		if(isset($email) && !empty($email)){

			$this->db->select('elp.*');

			$this->db->from('el_photographer elp');			

			$this->db->where('elp.photographer_email',$email);
			
			$this->db->where('elp.photographer_id !=',$pid);
			
			$this->db->where('elp.photographer_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function checkUniquemobileInEdit($mobile,$pid){
		if(isset($mobile) && !empty($mobile)){

			$this->db->select('elp.*');

			$this->db->from('el_photographer elp');			

			$this->db->where('elp.photographer_mobile',$mobile);
			
			$this->db->where('elp.photographer_id !=',$pid);
			
			$this->db->where('elp.photographer_status','1');

			$query = $this->db->get();
			
			//echo $this->db->last_query();exit;
			
			$num = $query->num_rows();
			
			return $num;

			
		}
	}
	function updatePhotographerbyId($pid, $data ,$resort_id) {				
	if($data!=''){								
			$this->db->where('photographer_id', $pid);			
			$this->db->update('el_photographer', $data);					
			return 1;		
		}		
		else{			
		return 0;		
		}
    }
	
	function editUserdata($table = '',$data = '',$id ='') {
		
		if(!empty($data)){
			
			 $this->db->where('user_id', $id);

             $this->db->update($table, $data);
			
			return  1;
		}
		else{

			return 0;
		}
    }	
	
	function deletePhotographerbyId($pid){

        if(isset($pid) && !empty($pid)){

            $data =  array('photographer_status'=>'0');			  			
			$this->db->where('photographer_id', $pid);
            $this->db->update('el_photographer', $data);
            return 1;

        } else{

                return 0;
        }
    }	
	
	

}