<?php
class Optionmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function alloptionList(){
        $recArr	= array();
		$this->db->select('*');
		$this->db->from('el_frame_options');
		$this->db->where('option_status','1');
		$query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            $recArr = $query->result_array();
		}
		return $recArr;
    } 

    function alloptionheadList(){
       $recArr	= array();
	   $this->db->select('efh.option_meta_head_id,efo.option_name,efh.option_meta_head_name');
       $this->db->from('el_frame_option_meta_head efh');
       $this->db->where('efh.option_meta_head_status','1');
       $this->db->join('el_frame_options efo', 'efo.option_id = efh.option_id','left');
        
       $query = $this->db->get();
       $num = $query->num_rows();
       if($num>0){
            $recArr = $query->result_array();
	   }
	   return $recArr;
    } 

    function checkDuplicateOption($option,$oid){
        $this->db->select('*');
		$this->db->from('el_frame_options');
		if($oid !=''){
		    $where = "option_name ='".$option."' AND option_id !='".$oid."'";
	    }else{
	    	$where = "option_name ='".$option."'";
        }
        $this->db->where($where);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			return $num;
		}else{
			return 0;
		}
    } 

    function optionAdd($data) {
		$relData	= array();
		if(!empty($data)){              
		    $this->db->insert('el_frame_options', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
            return  $insert_id;
		}else{
            return 0;
		}
    }	

    function optionDataResult($optionId){
    	$recArr = array();
        $this->db->select('*');
		$this->db->from('el_frame_options');
		$this->db->where('option_id',$optionId);
		
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->result_array();
		}
		return $recArr;
    } 

    function updateOptionbyId($oid, $data) {
		if($data!=''){			
			$this->db->where('option_id', $oid);
			$this->db->update('el_frame_options', $data);
			return 1;
		}
		else{
			return 0;
		}
    }

   function deleteOptionById($dataArr = array(), $tableName = '', $conditionArr = array()) {
        if(count($conditionArr) > 0) {
            $this->db->update($tableName, $dataArr, $conditionArr);
            //echo "hi - ".$this->db->last_query();// exit;
            if($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }   

    function checkDuplicateOptionHead($option,$optionhead,$ohid){
        $this->db->select('*');
		$this->db->from('el_frame_option_meta_head');
		if($ohid !=''){
		    $where = "option_id ='".$option."' AND option_meta_head_name ='".$optionhead."' AND option_meta_head_id !='".$ohid."'";
	    }else{
	    	$where = "option_id ='".$option."' AND option_meta_head_name ='".$optionhead."'";
        }
        $this->db->where($where);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			return $num;
		}else{
			return 0;
		}
    } 

    function optionHeadAdd($data) {
		$relData	= array();
		if(!empty($data)){              
		    $this->db->insert('el_frame_option_meta_head', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
            return  $insert_id;
		}else{
            return 0;
		}
    }	
    
     function optionHeadDataResult($optionheadId){
    	$recArr = array();
        $this->db->select('*');
		$this->db->from('el_frame_option_meta_head');
		$this->db->where('option_meta_head_id',$optionheadId);
		
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->result_array();
		}
		return $recArr;
    } 

     function updateOptionHeadbyId($ohid, $data) {
		if($data!=''){			
			$this->db->where('option_meta_head_id', $ohid);
			$this->db->update('el_frame_option_meta_head', $data);
			return 1;
		}
		else{
			return 0;
		}
    }

    function deleteOptionHeadById($dataArr = array(), $tableName = '', $conditionArr = array()) {
        if(count($conditionArr) > 0) {
            $this->db->update($tableName, $dataArr, $conditionArr);
            //echo "hi - ".$this->db->last_query();// exit;
            if($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }   

    function alloptionmetaList(){
       $recArr	= array();
	   $this->db->select('efm.option_meta_id,efo.option_name,efh.option_meta_head_name,efm.option_meta_value,efm.option_meta_price');
       $this->db->from('el_frame_option_meta_head efh');
       $this->db->where('efm.option_meta_status','1');
       $this->db->join('el_frame_options efo', 'efo.option_id = efh.option_id','left');
       $this->db->join('el_frame_options_meta efm', 'efo.option_id = efm.option_id AND efh.option_meta_head_id = efm.option_meta_head_id','left'); 
       $query = $this->db->get();
       $num = $query->num_rows();
       if($num>0){
            $recArr = $query->result_array();
	   }
	   return $recArr;
    } 

     function findOptionHeadlists($oid){
        $recArr	= array();
		$this->db->select('*');
		$this->db->from('el_frame_option_meta_head');
		$this->db->where('option_id',$oid);
		$this->db->where('option_meta_head_status','1');
		$query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            $recArr = $query->result_array();
		}
		return $recArr;
    } 

    function checkDuplicateOptionMeta($option,$optionhead,$optionmeta,$omid){
        $this->db->select('*');
		$this->db->from('el_frame_options_meta');
		if($omid !=''){
	$where = "option_id ='".$option."' AND option_meta_head_id ='".$optionhead."' AND option_meta_value ='".$optionmeta."' AND option_meta_id !='".$omid."'";
	    }else{
	    	$where = "option_id ='".$option."' AND option_meta_head_id ='".$optionhead."' AND option_meta_value ='".$optionmeta."'";
        }
        $this->db->where($where);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			return $num;
		}else{
			return 0;
		}
    } 

    function optionMetaAdd($data) {
		$relData	= array();
		if(!empty($data)){              
		    $this->db->insert('el_frame_options_meta', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
            return  $insert_id;
		}else{
            return 0;
		}
    }	

    function optionMetaDataResult($optionmetaId){
    	$recArr = array();
        $this->db->select('*');
		$this->db->from('el_frame_options_meta');
		$this->db->where('option_meta_id',$optionmetaId);
		
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->result_array();
		}
		return $recArr;
    } 

    function optionHeadMetaList($omid){
        $recArr	= array();
        $this->db->select('efh.option_meta_head_id,efh.option_meta_head_name');
		$this->db->from('el_frame_option_meta_head efh');
	$this->db->join('el_frame_options_meta efm', 'efh.option_id = efm.option_id');
		$this->db->where('efm.option_meta_id',$omid);
        $this->db->where('efh.option_meta_head_status','1');

		$query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            $recArr = $query->result_array();
		}
		return $recArr;
    } 

    function updateOptionMetabyId($omid, $data) {
		if($data!=''){			
			$this->db->where('option_meta_id', $omid);
			$this->db->update('el_frame_options_meta', $data);
			return 1;
		}
		else{
			return 0;
		}
    }
    
    function deleteOptionMetaById($dataArr = array(), $tableName = '', $conditionArr = array()) {
        if(count($conditionArr) > 0) {
            $this->db->update($tableName, $dataArr, $conditionArr);
            //echo "hi - ".$this->db->last_query();// exit;
            if($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }   
	
}