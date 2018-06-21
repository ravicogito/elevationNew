<?php
class Faqmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function index(){

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

    function addFaqs($data) {

		if(!empty($data)){ 
			$this->db->insert('el_faq', $data);
			//echo $this->db->last_query();exit;
			$insert_id = $this->db->insert_id();
			
			return 1;

			//return 1;

		}
		else{
			
			return 0;
			
		}
    }


    // Edit 

    function Faqedit($id){

        //

        if(isset($id) && !empty($id) && $id!=0){
        $this->db->select('*');
        $this->db->from('el_faq');
        $this->db->where('faq_id',$id);
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


    // Update



    function updateFaqbyId($fid, $data) {

		 if($data!=''){

			$this->db->where('faq_id', $fid);
			$this->db->update('el_faq', $data);

			return 1;

		} else{

			return 0;
		}
      
    }


    // Delete Page

    function deleteFaqbyId($fid){

        if(isset($fid) && !empty($fid)){

            $data =  array('faq_status'=>'0');
            $this->db->where('faq_id', $fid);
            $this->db->update('el_faq', $data);

            return 1;

        } else{

                return 0;
        }
    }

    



}