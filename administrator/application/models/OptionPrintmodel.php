<?php
class OptionPrintmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function listOptionPrint(){
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
	
	function optionPrintAdd($table = '',$data = '') {
		$relData	= array();
		if(!empty($data)){              
		    $this->db->insert($table, $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
            return  $insert_id;
		}else{
            return 0;
		}
    }

	function checkFrameOption($option_size_value = '',$print_size_type = ''){
    	$recArr = array();
        $this->db->select('efops.print_size_id');
		$this->db->from('el_frame_option_print_size efops');
		$this->db->where('efops.print_option_size_value',$option_size_value);
		$this->db->where('efops.print_size_type',$print_size_type);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->row_array();
		}
		return $recArr;
    }
	
	function checkValueExist($print_size_id = '',$option_id = ''){
    	$recArr = array();
        $this->db->select('*');
		$this->db->from('el_frame_option_printsize_rel efopr');
		$this->db->where('efopr.option_id',$option_id);
		$this->db->where('efopr.option_print_size_id',$print_size_id);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->row_array();
		}
		return $recArr;
    }
	
	function getOptionPrintsize($option_printsize_rel_id){
    	$recArr = array();
        $this->db->select('option_print_size_id');
		$this->db->from('el_frame_option_printsize_rel');
		$this->db->where('option_printsize_rel_id',$option_printsize_rel_id);
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->row_array();
		}
		return $recArr;
    }

	function alllistOptionPrint(){
       $recArr	= array();
	   $this->db->select('efops.print_size_id,efo.option_name,efops.print_option_size_value,efops.print_size_type,efops.print_size_price,efopr.option_printsize_rel_id');
       $this->db->from('el_frame_option_print_size efops');
       $this->db->join('el_frame_option_printsize_rel efopr', 'efops.print_size_id = efopr.option_print_size_id','left');
       $this->db->join('el_frame_options efo', 'efopr.option_id = efo.option_id','left');
	   $this->db->where('efopr.option_printsize_rel_status','1');
        
       $query = $this->db->get();
       $num = $query->num_rows();
       if($num>0){
            $recArr = $query->result_array();
	   }
	   return $recArr;
    } 
	
	function editOptionPrint($option_printsize_rel_id){
    	$recArr = array();
        $this->db->select('efops.print_option_size_value,efops.print_size_type,efops.print_min_dpi,efops.print_min,efops.print_optimal_dpi,efops.print_optimal,efops.print_size_type,efops.print_size_price,efops.print_size_id,efopr.acrylic_price,efopr.option_printsize_rel_id,efo.option_id');
		$this->db->from('el_frame_option_printsize_rel efopr');
		$this->db->where('efopr.option_printsize_rel_id',$option_printsize_rel_id);
		$this->db->join('el_frame_options efo', 'efopr.option_id = efo.option_id','left');
        $this->db->join('el_frame_option_print_size efops', 'efopr.option_print_size_id = efops.print_size_id','left');
		
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->row_array();
		}
		return $recArr;
    } 
	
	function updateOptionbyId($id, $data) {
		if($data!=''){			
			$this->db->where('option_printsize_rel_id', $id);
			$this->db->update('el_frame_option_printsize_rel', $data);
			return 1;
		}
		else{
			return 0;
		}
    }
	
	function updateOptionbyPrintsizeId($id, $data) {
		if($data!=''){			
			$this->db->where('print_size_id', $id);
			$this->db->update('el_frame_option_print_size', $data);
			return 1;
		}
		else{
			return 0;
		}
    }
	
	function optionPrintsizeRelChecking($option_id,$option_printsize_rel_id ){
    	$recArr = array();
        $this->db->select('option_id,option_print_size_id');
		$this->db->from('el_frame_option_printsize_rel');
		$this->db->where('option_id',$option_id);
		$this->db->where('option_print_size_id',$option_printsize_rel_id);
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

	
}