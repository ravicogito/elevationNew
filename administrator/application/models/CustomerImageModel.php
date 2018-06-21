<?php

class CustomerImageModel extends CI_Model {

    function __construct() {

       parent::__construct();

    }



    function listCustomerImage(){

        $query	= $this->db->query("SELECT elmi.*,elmcpr.*,elc.customer_firstname,elp.photographer_name FROM `el_media_image` as elmi left join el_media_customer_photographer_relation as elmcpr on elmi.`media_id` = elmcpr.`media_id` left join el_customer as elc on elmcpr.customer_id = elc.customer_id left join el_photographer as elp on elmcpr.photographer_id = elp.photographer_id where elmi.`media_status` ='1' GROUP BY elmcpr.customer_id order by elmi.media_id desc");

        $num = $query->num_rows();

        if($num>0){

            //print_r($query->row_array()); exit;

            //echo "<pre>";

            $result = $query->result();

			//print_r($result);exit;

            return $result;

        }else{

            return 0;

        }



    }
	function listCustomer(){
        $this->db->select('*');

        $this->db->from('el_customer');
		
		$this->db->where('customer_status', '1');

        $query = $this->db->get();

        $num = $query->num_rows();

        if($num>0){

            //print_r($query->row_array()); exit;

            //echo "<pre>";

            $result = $query->result();

			//print_r($result);exit;

            return $result;

        }else{

            return 0;

        }
    }
	function listPhotographer(){



        $this->db->select('*');

        $this->db->from('el_photographer');
		
		$this->db->where('photographer_status', '1');

        $query = $this->db->get();

        $num = $query->num_rows();

        if($num>0){

            //print_r($query->row_array()); exit;

            //echo "<pre>";

            $result = $query->result();

			//print_r($result);exit;

            return $result;

        }else{

            return 0;

        }



    }
	
	
	function listraftingCompany(){


        $this->db->select('*');

        $this->db->from('el_raftingcompany');
		
		$this->db->where('raftingcompany_status', '1');

        $query = $this->db->get();

        $num = $query->num_rows();

        if($num>0){

            $result = $query->result();

            return $result;

        }else{

            return 0;

        }



    }

    function addImages($data,$cutomer_id,$photographer_id,$event_id) {
		$cust_rel	=	array();
		
		if(!empty($data)){
			$this->db->insert('el_media_image', $data);
			
			$insert_id = $this->db->insert_id();
			
			if(!empty($insert_id )){
				$cust_rel	= array(
										'media_rel_id'						=>'',
										'customer_id'						=> $cutomer_id,
										'photographer_id'					=> $photographer_id,							
										'event_id'							=> $event_id,							
										'media_id'							=> $insert_id,
										'rel_status'						=> '1',
									);
									
				$this->db->insert('el_media_customer_photographer_relation', $cust_rel);					
			}

			return $insert_id;

		}
		
		else{

			return 0;
		}      

    }
	
	public function getPhotographerByMediaID($mid = 0) {
	  $recArr    = array();
	  if(!empty($mid)) {
	   $sql    = "SELECT el_photographer.* FROM el_photographer WHERE photographer_id =( SELECT `photographer_id` from el_media_customer_photographer_relation WHERE `media_id` = '".$mid."')";
		$rs           = $this->db->query($sql);
			 if($rs->num_rows() > 0) {
				 $recArr      = $rs->row_array();
			 } else {
				 //Do nothing
			 }   
	  }
	  
	  return $recArr;
	}

	

	function Imageview($id = 0){

        if(isset($id) && !empty($id) && $id!=0){

        $query	= $this->db->query("SELECT elmcpr.`media_id`,elmi.*,(select customer_firstname from el_customer where customer_id ='".$id."') as customer_firstname,(select customer_middlename from el_customer where customer_id ='".$id."') as customer_middlename, (select customer_lastname from el_customer where customer_id ='".$id."') as customer_lastname FROM `el_media_customer_photographer_relation` elmcpr left join el_media_image elmi on elmcpr.`media_id` = elmi.`media_id` WHERE elmcpr.`customer_id` ='".$id."' And elmi.media_status ='1'" );        

        $num = $query->num_rows();

        if($num>0){



            $result = $query->result_array();



            return $result;

        }else{

            return 0;

        }



        }



    }
	
	function imageEditById($id = 0){

        if(isset($id) && !empty($id) && $id!=0){

        $query	= $this->db->query("SELECT * from el_media_image elmi where elmi.media_id ='".$id."' And elmi.media_status ='1'" );        

        $num = $query->num_rows();

        if($num>0){



            $result = $query->row_array();



            return $result;

        }else{

            return 0;

        }



        }



    }

    function updateEventbyId($mid, $data) {		
		if($data!=''){	
			
			$this->db->where('media_id', $mid);
			$this->db->update('el_media_image', $data);
			return 1;		
		}		
		else{			
			return 0;		
		}
    }
	function changeImgPublishStatus($mid,$data){
		if(isset($mid) && !empty($mid)){
           
            $this->db->where('media_id', $mid);
            $this->db->update('el_media_image', $data);
            return 1;
        } else{
                return 0;
        }       

    }


    function deleteImagesById($mid){
		if(isset($mid) && !empty($mid)){
            $data =  array('media_status'=>'0');
			$data2 =  array('rel_status'=>'0');
            $this->db->where('media_id', $mid);
            $this->db->update('el_media_image', $data);
			
			$this->db->where('media_id', $mid);
            $this->db->update('el_media_customer_photographer_relation', $data2);
            return 1;
        } else{
                return 0;
        }       

    }
	
	public function fetchCustomerdtls($cID)
	{
		    $sql = "SELECT * FROM el_customer WHERE customer_id=$cID";
			//echo  $sql; exit;
            $rs = $this->db->query($sql);
			
            if($rs->num_rows()) {
                $rec = $rs->result_array();
                return $rec;
            }
            return false;
	}
	
	public function get_events($locationID)
	{
		    $sql = "SELECT * FROM el_event WHERE location_id=$locationID";
			//echo  $sql; exit;
            $rs = $this->db->query($sql);
			
            if($rs->num_rows()) {
                $rec = $rs->result_array();
                return $rec;
            }
            return false;
	}

	function getCustomerEventlist($customer_id){
		
        $this->db->select('EVT.event_id,EVT.event_name');

        $this->db->from('el_customer_location_event_relation ECLER');
		
		$this->db->join('el_event EVT','ECLER.event_id = EVT.event_id');
		
		$this->db->where('EVT.event_status', '1');
		
		$this->db->where('ECLER.customer_id', $customer_id);

        $query = $this->db->get();

        $num = $query->num_rows();

        if($num>0){

            //print_r($query->row_array()); exit;

            //echo "<pre>";

            $result = $query->result();

			//print_r($result);exit;

            return $result;

        }else{

            return 0;

        }
    }
	
	function getCustomerPhotographlist($event_id){
		
        $this->db->select('EPG.photographer_id,EPG.photographer_name');

        $this->db->from('el_customer_location_event_relation ECLER');
		
		$this->db->join('el_photographer EPG','ECLER.photographer_id = EPG.photographer_id');
		
		$this->db->where('EPG.photographer_status', '1');
		
		$this->db->where('ECLER.event_id', $event_id);

        $query = $this->db->get();

        $num = $query->num_rows();

        if($num>0){

            //print_r($query->row_array()); exit;

            //echo "<pre>";

            $result = $query->result();

			//print_r($result);exit;

            return $result;

        }else{

            return 0;

        }
    }



}