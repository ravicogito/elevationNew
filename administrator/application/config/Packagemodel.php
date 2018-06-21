<?php
class Packagemodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function index(){

        $this->db->select('*');
        $this->db->from('chben_packages');
		$this->db->where('plan_status','1');
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

    function addPackage($data) {

            //Check data 

            if($data['plan_name']!='' && $data['plan_short_name']!='' && $data['plan_desc']!=''
			&& $data['plan_cost']!='' && $data['plan_join_fee']!='' && $data['plan_type_id']!=''
			 && $data['have_offer_this_plan']!='' && $data['offer_id']!=''){

                $data=array('plan_name'=>$data['plan_name'],'plan_short_name'=>$data['plan_short_name'],
				'plan_desc'=>$data['plan_desc'],'plan_cost'=>$data['plan_cost'],'plan_join_fee'=>$data['plan_join_fee']
				,'plan_type_id'=>$data['plan_type_id'],'have_offer_this_plan'=>$data['have_offer_this_plan']
				,'offer_id'=>$data['offer_id']);

                $this->db->insert('chben_packages', $data);

                return 1;

            }
			
			else{

                return 0;
            }
      
    }


    // Edit 

    function Packageedit($id = 0){

        if(isset($id) && !empty($id) && $id!=0){
        $this->db->select('*');
        $this->db->from('chben_packages');
        $this->db->where('plan_id',$id);
        $query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            //print_r($query->row_array()); exit;
            //echo "<pre>";
            $result = $query->row_array();
			//echo"<pre>";
			//print_r($result); exit;
            return $result;
        }else{
            return 0;
        }

        }

    }


    function updatePackagebyId($pid, $data) {

            if($data['plan_name']!='' && $data['plan_short_name']!='' && $data['plan_desc']!=''
				 && $data['plan_cost']!='' && $data['plan_join_fee']!='' && $data['plan_type_id']!='' 
				 && $data['offer_id']!='' && $data['plan_modified_on']!=''){

                $data=array('plan_name'=>$data['plan_name'],'plan_short_name'=>$data['plan_short_name'],'plan_desc'=>$data['plan_desc'],
				'plan_cost'=>$data['plan_cost'],'plan_join_fee'=>$data['plan_join_fee'],'plan_type_id'=>$data['plan_type_id'], 
				'have_offer_this_plan'=>$data['have_offer_this_plan'],'offer_id'=>$data['offer_id'],'plan_modified_on'=>$data['plan_modified_on']);
				
				//print_r($data);
				//die;

                $this->db->where('plan_id', $pid);
                $this->db->update('chben_packages', $data);

                return 1;

            } else{

                return 0;
            }
      
    }

    // Delete Page

    function deleteCategorybyId($pid){

        if(isset($pid) && !empty($pid)){

            //$data =  array('category_status'=>'0');
            $this->db->where('gal_img_id', $pid);
            $this->db->update('chben_gallery');

            return 1;

        } else{

                return 0;
        }
    }
	
	function selectplansType()
	{
		$this->db->select('*');
		$this->db->from('chben_plans_type');
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
	
	function selectpackageOffer()
	{
		$this->db->select('*');
		$this->db->from('chben_package_offer');
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