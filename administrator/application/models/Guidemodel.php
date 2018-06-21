<?php
class Guidemodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function listGuide(){

        $query	= $this->db->query("SELECT ele.*,(select raftingcompany_name from el_raftingcompany where raftingcompany_id = ele.`rafting_company_id`)as raftingcompany_name FROM `el_guide` ele where ele.guide_status ='1' order by `guide_id` DESC");		
        $num = $query->num_rows();
        if($num>0){
            $result = $query->result();
            return $result;
        }else{
            return 0;
        }

    }		
	
	public function photographerList() {
		$this->db->select('*');
		$this->db->from('el_photographer');
		$this->db->where('photographer_status','1');
		$query 	= $this->db->get();
		$num = $query->num_rows();
		if($num>0) {
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
		} else {
			return 0;		
		}    
	}	
	
	public function insertData($dataArr = array(), $tableName = '') {
        $this->db->insert($tableName, $dataArr);
//        echo $this->db->last_query();
        if($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
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
	
	function listAllLocation(){
		$this->db->select('Location.location_name,Location.location_id');
		$this->db->from('el_location Location');
		$this->db->where('Location.location_status','1');
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
	
	
	
	function listAllCustomer(){
		$this->db->select('ELC.customer_firstname,ELC.customer_id');
		$this->db->from('el_customer ELC');
		$this->db->where('ELC.customer_status','1');
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

	function listLocationEventRelations(){
		$this->db->select('ECLER.customer_location_event_id,Location.location_name,Resort.resort_name,Photographer.photographer_name,Customer.customer_firstname,Customer.customer_middlename,Customer.customer_lastname,Event.event_name,ECLER.evet_start_date,ECLER.evet_end_date');
		$this->db->from('el_customer_location_event_relation ECLER');
		$this->db->join('el_location Location', 'ECLER.location_id = Location.location_id', 'LEFT');
		$this->db->join('el_resort Resort', 'ECLER.resort_id = Resort.resort_id', 'LEFT');
		$this->db->join('el_photographer Photographer', 'ECLER.photographer_id = Photographer.photographer_id', 'LEFT');
		$this->db->join('el_customer Customer', 'ECLER.customer_id = Customer.customer_id', 'LEFT');
		$this->db->join('el_event Event', 'ECLER.event_id = Event.event_id', 'LEFT');
		$this->db->where('ECLER.rel_status','1');
		$this->db->order_by("ECLER.customer_location_event_id", "desc");
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
	
	function checkEventByresort($customer_id,$resort_id,$event_id)
	{
		$this->db->select('*');
		$this->db->from('el_customer_location_event_relation ECLSR');
		$this->db->where('ECLSR.customer_id',$customer_id);
		$this->db->where('ECLSR.resort_id',$resort_id);
		$this->db->where('ECLSR.event_id',$event_id);
		$this->db->where('ECLSR.rel_status','1');
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
	
	function deleteAssigneventCustomerId($data='',$location_event_id='',$table=''){
		if(isset($location_event_id) && !empty($location_event_id)){
			$this->db->where('customer_location_event_id', $location_event_id);
            $this->db->update($table, $data);
            return 1;
        } else{
                return 0;
        }       

    }
	
	function getResortlist($location_id){
		$this->db->select('ERS.resort_name,ERS.resort_id');
		$this->db->from('el_customer_location_resort_relation ECLSR');
		$this->db->join('el_resort ERS', 'ECLSR.resort_id = ERS.resort_id', 'LEFT');
		$this->db->group_by('ECLSR.resort_id');
		$this->db->where('ECLSR.location_id',$location_id);
		$this->db->where('ERS.resort_status','1');
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
	
	function getResortEventlist($resort_id){
		$this->db->select('EVENT.event_id,EVENT.event_name');
		$this->db->from('el_event EVENT');
		$this->db->where('EVENT.resort_id',$resort_id);
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
	
	function getCustomerlistByResort($resort_id,$location_id){
		$this->db->select('Customer.customer_id,Customer.customer_firstname');
		$this->db->from('el_customer_location_resort_relation ECLR');
		$this->db->join('el_customer Customer', 'ECLR.customer_id = Customer.customer_id', 'LEFT');
		//$this->db->group_by('PHOTO.photographer_id');
		$this->db->where('ECLR.resort_id',$resort_id);
		$this->db->where('ECLR.location_id',$location_id);
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

	function getCustomerPhotographerlist($event_id){
		$this->db->select('EVENT.event_id,EVENT.event_name,PHOTO.photographer_id,PHOTO.photographer_name');
		$this->db->from('el_event EVENT');
		$this->db->join('el_photographer PHOTO', 'EVENT.photographer_id = PHOTO.photographer_id', 'LEFT');
		$this->db->group_by('EVENT.event_id','EVENT.photographer_id');
		$this->db->where('EVENT.event_id',$event_id);
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
	
    function updateEventbyId($eid, $data) {
            if($data!=''){
                $this->db->where('event_id', $eid);
                $this->db->update('el_event', $data);
                return 1;
            } else{
                return 0;
            }
    }	
	
	function deleteImagebyId($eid, $data) {
		if($data!=''){
			$this->db->where('media_id', $eid);
			$this->db->update('el_media_image', $data);
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
        } else {
            return 0;
        }
	}
	
/*-------------------------------- 25-02-2018 New logic -----------------------------------*/
	function guideList(){
		$recArr						= array();
		$this->db->select('el_event_public.*, el_raftingcompany.raftingcompany_name,el_category.cat_name');
		$this->db->from('el_event_public');
		$this->db->join('el_category', 'el_event_public.category_id = el_category.id', 'LEFT');
		$this->db->join('el_raftingcompany', 'el_event_public.rafting_company_id = el_raftingcompany.raftingcompany_id', 'LEFT');
		$this->db->where('el_category.id', '17');
		$this->db->order_by('el_event_public.event_id', 'DESC');
		$query 						= $this->db->get();	
        //echo $this->db->last_query();exit;
        $num 						= $query->num_rows();
        if($num>0){
            $recArr 				= $query->result();
        }else{
            // Do nothing
        }
        return $recArr;
    }
	
	public function eventName($guideID=''){
		$res = $this->db->get_where('el_event_public', array('event_id' => $guideID));
		if($res->num_rows() > 0)
		{
			$guide = $res->row();
			return $guide->event_name;
		}
		else
		{
			return '';
		}
		
    }
	
	
	function guide_category(){


        $this->db->select('*');

        $this->db->from('el_category');
		
		$this->db->where('id', '17');
		
		$this->db->where('cat_status', '1');

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

	

    public function getSingleEvent($eventID = 0) {
    	$recArr							= array();
    	$this->db->select('el_event_public.*, el_raftingcompany.raftingcompany_name,el_category.cat_name');
    	$this->db->from('el_event_public');
    	$this->db->join('el_raftingcompany', 'el_event_public.rafting_company_id = el_raftingcompany.raftingcompany_id', 'LEFT');
    	$this->db->join('el_category', 'el_event_public.category_id = el_category.id', 'LEFT');
    	$this->db->where('el_event_public.event_id', $eventID);
    	$query 							= $this->db->get();
		//echo $this->db->last_query();exit;
    	if($query->num_rows() > 0) {
    		$recArr						= $query->row_array();
    	}

    	return $recArr;
    }

    public function getAllCustomer($where = ''){
		$this->db->select('ELC.*');
		$this->db->from('el_customer ELC');
		$this->db->where('ELC.customer_status','1');
		if($where) {
			$this->db->like("customer_firstname", $where);
			$this->db->or_like('customer_lastname', $where);
		}
		$this->db->order_by('customer_firstname', 'ASC');
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
	
	public function updateImageByid($event_id = '',$image_id = '',$table = '',$data = ''){
		if($data!=''){
                $this->db->where('event_id', $event_id);
                $this->db->where('file_name', $image_id);
                $this->db->update($table, $data);
                return 1;
            } else{
                return 0;
            }
    }
	
	public function findAllMedia($event_id)
	{
		$this->db->select('*');
		$this->db->from('el_media_image');
		$this->db->where('event_id',$event_id);
		$query 	= $this->db->get();
		$num = $query->num_rows();
		if($num>0) {
			$result = $query->result_array();
			return $result;
		}else{
			return 0;
		}
	}
	
	public function findMediaByid($event_id ='',$file_name = '')
	{
		$this->db->select('*');
		$this->db->from('el_media_image');
		$this->db->where('event_id',$event_id);
		$this->db->where('file_name',$file_name);
		$query 	= $this->db->get();
		$num = $query->num_rows();
		if($num>0) {
			$result = $query->row_array();
			return $result;
		}else{
			return 0;
		}
	}
	
	public function getImageByevent($event_id ='',$file_name = '')
	{
		$this->db->select('*');
		$this->db->from('el_media_image');
		$this->db->where('event_id',$event_id);
		$query 	= $this->db->get();
		$num = $query->num_rows();
		if($num>0) {
			$result = $query->result_array();
			return $result;
		}else{
			return 0;
		}
	}
	
	
	public function getGuideID($guide_name ='')
	{
		$this->db->select('guide_id');
		$this->db->from('el_guidename');
		$this->db->where('guide_name',$guide_name);
		$query 	= $this->db->get();
 
		 if($query->num_rows()>0) {
		 $data = $query->row_array();
		 $value = $data['guide_id'];
		 return $value;
		}
		else{
		return false;	
		}
	}


    public function getCompanyID($company_name ='')
	{
		$this->db->select('raftingcompany_id');
		$this->db->from('el_raftingcompany');
		$this->db->where('raftingcompany_name',$company_name);
		$query 	= $this->db->get();
 
		 if($query->num_rows()>0) {
		 $data = $query->row_array();
		 $value = $data['raftingcompany_id'];
		 return $value;
		}
		else{
		return false;	
		}
	}	

    public function getEventID($event_name ='')
	{
		$this->db->select('event_id');
		$this->db->from('el_event_public');
		$this->db->where('event_name',$event_name);
		$query 	= $this->db->get();
 
		 if($query->num_rows()>0) {
		 $data = $query->row_array();
		 $value = $data['event_id'];
		 return $value;
		}
		else{
		return false;	
		}
	}		

   public function getImageID($file_name ='')
	{
		$this->db->select('media_id');
		$this->db->from('el_media_image');
		$this->db->where('file_name',$file_name);
		$query 	= $this->db->get();
 
		 if($query->num_rows()>0) {
		 $data = $query->row_array();
		 $value = $data['media_id'];
		 return $value;
		}
		else{
		return false;	
		}
	}			
	
	
	public function getImageByID($image_id ='')
	{
		$this->db->select('*');
		$this->db->from('el_media_image');
		$this->db->where('media_id',$image_id);
		$query 	= $this->db->get();
		$num = $query->num_rows();
		if($num>0) {
			$result = $query->result_array();
			return $result;
		}else{
			return 0;
		}
	}

    public function getCustByMail($condField = '', $condValue = '') {
    	$recArr							= array();
    	$this->db->select('ELC.*');
		$this->db->from('el_customer ELC');
		$this->db->where('ELC.customer_status','1');
		if(!empty($condField)) {
			$this->db->where($condField, $condValue);
		}
		$query 							= $this->db->get();
		//echo $this->db->last_query();exit;
		$num 							= $query->num_rows();
		if($num > 0) {
			$recArr						= $query->row_array();
		}
		return $recArr;
    }

    public function getAssignedCustomer($eventID = '') {
    	$recArr							= array();
    	$this->db->select('ECR.*');
		$this->db->from('el_event_customer_rel ECR');
		$this->db->where('ECR.event_id', $eventID);		
		$query 							= $this->db->get();
		//echo $this->db->last_query();exit;
		$num 							= $query->num_rows();
		if($num > 0) {
			$recArr						= $query->result_array();
		}
		return $recArr;
    }

    public function categoryList() {
		$recArr			= array();
		$this->db->select('*');
		$this->db->from('el_category');
		$this->db->where('id', '17');
		$this->db->where('cat_status', '1');
		$query 			= $this->db->get();
		$num 			= $query->num_rows();
		if($num>0) {
			$recArr 	= $query->result_array();
		}
		return $recArr;
	}

	function eventListDetails($eid){
		$recArr						= array();
		$this->db->select('*');
		$this->db->from('el_event_public');
		$this->db->where('event_id',$eid);
		$query 			= $this->db->get();	
        $num 			= $query->num_rows();
        if($num>0){
            $recArr 	= $query->result_array();
        }else{
            // Do nothing
        }
        return $recArr;
    }
	
	public function editGuide($id = '')
	{
		$this->db->select('*');
		$this->db->from('el_guidename');
		$this->db->where('guide_status','1');
		$this->db->where('guide_id',$id);
		
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		 if($num_rows > 0)
		 {
			 $get_result = $query->row_array();
			 return $get_result;
		 }
		 else{
			 return 0;
		 }
	}
	
	public function updateGuide($table,$data,$id)
	{
	if($data!=''){
                $this->db->where('guide_id', $id);
                $this->db->update($table, $data);
                return 1;
            } else{
                return 0;
            }
	}
	
	public function addGuide($table,$data)
	{
		if(!empty($data))
		{
			$this->db->insert($table,$data);
			$get_ins_id = $this->db->insert_id();
			return $get_ins_id;
		}
	}
	
	public function allGuide()
	{
		$this->db->select('*');
		$this->db->from('el_guidename');
		$this->db->where('guide_status','1');
		
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		 if($num_rows > 0)
		 {
			 $get_result = $query->result_array();
			 return $get_result;
		 }
		 else{
			 return 0;
		 }
		
	}
	
	
	 function listallGuide(){


        $this->db->select('*');

        $this->db->from('el_guidename');
		
		$this->db->where('guide_status', '1');

        $query = $this->db->get();

        $num = $query->num_rows();

        if($num>0){

            $result = $query->result();

            return $result;

        }else{

            return 0;

        }



    }
	

	public function isExistRecord($id)
	{
		$this->db->select('*');
		$this->db->from('el_event_public');
		//$this->db->where('guide_status','1');
		$this->db->where('guide_id',$id);
		
		$query = $this->db->get();
		$num_rows = $query->num_rows();
		 if($num_rows > 0)
		 {
			 $get_result = $query->row_array();
			 return $get_result;
		 }
		 else{
			 return 0;
		 }
	}	

}