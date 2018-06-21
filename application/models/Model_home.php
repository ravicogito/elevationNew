<?php
/**
 *
 * @ Registration model
 *
 *
 */

class Model_home extends CI_Model {
	
    function __construct() {
       parent::__construct();
    }
	function resortListByLocationid($lid){
		if(isset($lid) && !empty($lid) && $lid!=0){
			$this->db->select('*');
			$this->db->from('el_resort');
			$this->db->where('location_id',$lid);
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
	function photographerListByLocationid($lid='',$cid=''){
	 
		$recArr						= array();
		if($cid !=''){
			
			$condition 	=	" AND ELCLER.location_id = '".$lid."' AND ELCLER.customer_id = '".$cid."'";
		}
		else{
			$condition 	=	" AND ELCLER.location_id = '".$lid."'";
			
		}
		$sql	= $this->db->query("SELECT ELP.*, ELCLER.event_id 
									FROM `el_photographer` ELP 
									LEFT JOIN el_customer_location_event_relation ELCLER 
									ON ELP.photographer_id = ELCLER.photographer_id 
									WHERE ELP.photographer_status = '1' And ELCLER.rel_status ='1'".$condition );
									
		//echo $this->db->last_query();exit;
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;
    }
	function eventAttenedByPhotographer($pid){
	 
		$recArr						= array();
		
		//$sql	= $this->db->query("SELECT count(ele.photographer_id)as event_attnd,ele.photographer_id FROM `el_resort` elr left join el_photographer_resort_relation elpr on elr.`resort_id` = elpr.`resort_id` left join el_photographer elp on elpr.photographer_id = elp.photographer_id left join el_event ele on elp.photographer_id = ele.photographer_id WHERE elr.`location_id` ='".$lid."' And elp.photographer_status = '1' group by ele.photographer_id ");
		//echo $this->db->last_query();exit;
		$this->db->select ('cr.photographer_id, count(cr.photographer_id) as event_attnd');
		$this->db->from('el_customer_location_event_relation cr');
			
		$this->db->where('cr.rel_status','1');
		
		$this->db->group_by('cr.photographer_id');
		
		$this->db->where('cr.photographer_id',$pid);
		
		
		$sql = $this->db->get();
		
		//echo $this->db->last_query();exit;
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;
    }
    
	function totalphotoByPhotographer($photographer_id){
	 
		$recArr						= array();
		
		//$sql	= $this->db->query("SELECT count(photographer_id)as total_photo FROM `el_customer_location_event_relation` WHERE `customer_id` ='$cid'");
		//echo $this->db->last_query();exit;
		$this->db->select ('cm.photographer_id, count(cm.photographer_id) as total_photo');
		$this->db->from('el_media_customer_photographer_relation cm');
			
		$this->db->where('cm.rel_status','1');
		
		$this->db->where('cm.photographer_id',$photographer_id);
		
      	$query = $this->db->get();
		
		//echo $this->db->last_query();exit;
		$temp = $query->result_array(); 
		
		return $temp; 				
			
		
    }
	function alllocationList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT lc.location_id,lc.location_name,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1 limit 5");
		//$sql	= $this->db->query("SELECT lc.location_id,lc.location_name,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1");
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    }
	function countgetlocationList($location_id=0,$location_name=''){

        $recArr						= array();
		if(!empty($location_name))
			{
			$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1 AND lc.location_name='$location_name' OR lc.location_id='$location_id'");
			}
		else{
			$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1");
		}		
		//echo $this->db->last_query();
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $num;
			
        }
		return $recArr;

    }
	function getlocationList($location_id=0,$location_name=''){

        $recArr						= array();
		if(!empty($location_name))
			{
			$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1 AND lc.location_name='$location_name' OR lc.location_id='$location_id' limit 5");
			//$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1 AND lc.location_name='$location_name' OR lc.location_id='$location_id'");
			}
		else{
			$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1 limit 5");
			//$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1");
		}		
		//echo $this->db->last_query();
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    }
	function alleventwithlocationList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT ele.*, ell.* FROM el_event ele left join `el_location` ell on ele.`location_id` = ell.`location_id` where ell.location_status= '1' AND ele.event_status= '1' order by ell.location_name ASC limit 5 ");
		
		//$sql	= $this->db->query("SELECT ele.*, ell.* FROM el_event ele left join `el_location` ell on ele.`location_id` = ell.`location_id` where ell.location_status= '1' AND ele.event_status= '1' order by ell.location_name ASC");
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    }
	function loadlocationWithLimit($start='',$tblname,$condition){
		
		$recArr						= array();
		
		$sql	= $this->db->query("SELECT * FROM $tblname where $condition LIMIT 5, $start");
		//echo $this->db->last_query();exit;
		$num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

	}
	
	function locationEventSearchWithLimit($location,$location_name,$limit =''){
		//echo $location;exit;
		$recArr				= array();
		$condition 			= "";
        $limit_condition	= "";
        if($location != "" || $location_name !=""){
            $condition .= ' AND (lc.location_id = "'.addslashes($location).'" or lc.location_name = "'.addslashes($location_name).'")';
			if(!empty($limit)){
				$limit_condition	= ' LIMIT '.$limit ;
				
			}
			
			$sql	= $this->db->query("SELECT lc.location_id,lc.location_name ,lc.location_image,lc.location_status  FROM `el_location` lc where lc.location_status=1".$condition.$limit_condition);
			//echo $this->db->last_query();exit;
			$this->db->last_query();
			$num = $sql->num_rows();
			if($num>0){
				$recArr = $sql->result_array();
				
			}
		}
			
		else{
			$recArr ='';
		}
		return $recArr;

	}
	function getLocationName($lName=''){
		$recArr						= array();
		$condition = "";
        
        if($lName != ""){
            $condition .= ' AND lc.location_name like "%'.addslashes($lName).'%"';
        }
		$sql	= $this->db->query("SELECT lc.* FROM `el_location` lc where lc.location_status=1".$condition);
	   //echo $this->db->last_query(); exit; 
	   $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;
		
	}
	function getBannerData($seo_title){
		
		if(isset($seo_title) && !empty($seo_title)){


        $this->db->select('*');


        $this->db->from('el_banner');


        $this->db->where('seo_title',$seo_title);


        $query = $this->db->get();

		//echo $this->db->last_query(); exit; 
        $num = $query->num_rows();


        if($num>0){
            $result = $query->row_array();
			//print_r( $result);exit;
            return $result;
        }else{
            return 0;

        }

        }
	}
	function getpolicyData(){
		
		$this->db->select('*');

        $this->db->from('el_privacy_policy');

        $this->db->where('policy_status','1');

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
	
	function getFaqData(){
		$this->db->select('*');

        $this->db->from('el_faq');

        $this->db->where('faq_status','1');

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
}