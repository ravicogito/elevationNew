<?php
class Eventmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function listEvents(){

        $query	= $this->db->query("SELECT ele.*,(select location_name from el_location where location_id = ele.`location_id`)as location_name FROM `el_event` ele where ele.event_status ='1'");		
        $num = $query->num_rows();
        if($num>0){
            $result = $query->result();
            return $result;
        }else{
            return 0;
        }

    }		
	
	function addEvents($data) {      		
		if(!empty($data)){              				                
			$this->db->insert('el_event', $data);								
			$insert_id = $this->db->insert_id();								
			return  $insert_id;              		
		}				
		else{			
		return 0;		
		}    
	}	
	
	
    function Eventedit($id = 0){

        if(isset($id) && !empty($id) && $id!=0){
			$this->db->select('*');
			$this->db->from('el_event');
			$this->db->where('event_id',$id);
			$this->db->where('event_status','1');
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
    function updateEventbyId($eid, $data) {
            if($data!=''){
                $this->db->where('event_id', $eid);
                $this->db->update('el_event', $data);
                return 1;
            } else{
                return 0;
            }
    }	
    public function populateDropdown($rid) {
		
            $sql = "SELECT elr.*, elpr.*,elp.* FROM el_resort elr left join `el_photographer_resort_relation` elpr on elr.`resort_id` = elpr.`resort_id` left join el_photographer elp on elpr.photographer_id = elp.photographer_id WHERE elr.resort_id ='".$rid."'";
            $rs = $this->db->query($sql);
			
			//echo $this->db->last_query();exit;
            if($rs->num_rows()) {
                $rec = $rs->result_array();
                return $rec;
            }
            return false;
	}
	function deleteEventbyId($eid)
	{
		if(isset($eid) && !empty($eid)){
            $data =  array('event_status'=>'0');
            $this->db->where('event_id', $eid);
            $this->db->update('el_event', $data);
            return 1;
        } else{
                return 0;
        }
	}
	
}