<?php
class Pagemodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
	
	 function allpageList(){

        $recArr						= array();
		
		$sql	= $this->db->query("SELECT page.* FROM `el_pages` page WHERE page.`page_status` ='1' ");
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    } 
	
	function addPages($data) {

		if(!empty($data)){

			$this->db->insert('el_pages', $data);

			return 1;

		} else{

			return 0;
		}
      
    }

	function checkMetaTitle($seo_title_match){
		$recArr						= array();
		$this->db->select('*');
		$this->db->from('el_pages');
		$this->db->where('seo_title' , $seo_title_match);
		
        $query = $this->db->get();
		//echo $this->db->last_query();
        $num = $query->num_rows();
        if($num>0){
            //$recArr = $query->result_array();
			//return $num;
			$result = $query->row_array();
            return $result;
        }else{
            return 0;
        }
	}
	
	function Pageedit($id){

        if(isset($id) && !empty($id) && $id!=0){
        $this->db->select('*');
        $this->db->from('el_pages');
        $this->db->where('page_id',$id);
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
	
	function updatePagebyId($pid, $data) {

            if($data['ptitle']!='' && $data['content']!='' && $pid!='' && $pid!=0){

                $data=array( 'page_title'=>$data['ptitle'], 'page_description'=>$data['content'] );

                $this->db->where('page_id', $pid);
                $this->db->update('el_pages', $data);

                return 1;

            } else{

                return 0;
            }
      
    }
	
	function deletePagebyId($pid){

        if(isset($pid) && !empty($pid)){

            $data =  array('page_status'=>'0');
            $this->db->where('page_id', $pid);
            $this->db->update('el_pages', $data);

            return 1;

        } else{

                return 0;
        }
    }
}	