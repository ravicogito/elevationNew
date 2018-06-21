<?php
class Categorymodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
	
	public function addCategory($table,$data)
	{
		if(!empty($data))
		{
			$this->db->insert($table,$data);
			$get_ins_id = $this->db->insert_id();
			return $get_ins_id;
		}
	}
	
	public function allCategory()
	{
		$this->db->select('*');
		$this->db->from('el_category');
		$this->db->where('cat_status','1');
		
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
	
	public function editCategory($id = '')
	{
		$this->db->select('*');
		$this->db->from('el_category');
		$this->db->where('cat_status','1');
		$this->db->where('id',$id);
		
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
	
	public function updatecategory($table,$data,$id)
	{
	if($data!=''){
                $this->db->where('id', $id);
                $this->db->update($table, $data);
                return 1;
            } else{
                return 0;
            }
	}
	
	public function isExistRecord($id)
	{
		$this->db->select('*');
		$this->db->from('el_category');
		$this->db->where('cat_status','1');
		$this->db->where('id',$id);
		
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