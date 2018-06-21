<?php
/**
 *
 * @ Event model
 *
 *
 */

class Model_event extends CI_Model {
	
    function __construct() {
       parent::__construct();
    }
	
	public function categoryList() {
        $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_category');
        $this->db->where('cat_status', '1');
		$this->db->where('id', '17');
        $query              = $this->db->get();
        $num                = $query->num_rows();
        if($num>0) {
            $recArr         = $query->result_array();
        }
        return $recArr;
    }
	
	
	public function guideList() {
        $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_guidename');
        $this->db->where('guide_status', '1');
        $query              = $this->db->get();
        $num                = $query->num_rows();
        if($num>0) {
            $recArr         = $query->result_array();
        }
        return $recArr;
    }
	
	
	public function populateguide($time,$date1) {
        $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_guidename');
		$this->db->join('el_event_public', 'el_event_public.guide_id = el_guidename.guide_id', 'LEFT');
		$this->db->where('el_event_public.event_time', $time);
		$this->db->where('el_event_public.event_date', $date1);
        $this->db->where('guide_status', '1');
        $query              = $this->db->get();
        $num                = $query->num_rows();
        if($num>0) {
            $recArr         = $query->result_array();
        }
        return $recArr;
    }
	
	
	
	public function populatecompany($cat_id,$date) {
        $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_event_public');
		$this->db->join('el_raftingcompany', 'el_event_public.rafting_company_id = el_raftingcompany.raftingcompany_id', 'LEFT');
        $this->db->where('category_id', '17');
		$this->db->where('event_date', $date);
		$this->db->group_by('event_time');
		$this->db->order_by('event_time', 'ASC');
		
        $query              = $this->db->get();

        $num                = $query->num_rows();
        if($num>0) {
            $recArr = $query->result_array();
			//pr($recArr,0);
			return $recArr;
        }
        return $recArr;
    }
	

	
	public function populatetimes($company_id,$date) {
        $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_event_public');
        $this->db->where('rafting_company_id', $company_id);
		$this->db->where('event_date', $date);
		$this->db->group_by('event_time');
		$this->db->order_by('event_time', 'ASC');
		
        $query              = $this->db->get();

        $num                = $query->num_rows();
        if($num>0) {
            $recArr = $query->result_array();
			//pr($recArr,0);
			return $recArr;
        }
        return $recArr;
    }
	
	
    public function getEventList($categoryID = '', $eventDate = '', $eventTime = 0, $company_id='') {
        $recArr                 = array();
        $this->db->select('el_event_public.*, el_media_image.file_name, el_media_image.media_id, el_photographer.photographer_name, el_raftingcompany.raftingcompany_name, el_category.cat_name');
        $this->db->from('el_event_public');
        $this->db->join('el_media_image', 'el_event_public.event_id = el_media_image.event_id', 'LEFT');
        $this->db->join('el_photographer', 'el_event_public.photographer_id = el_photographer.photographer_id', 'LEFT');
        $this->db->join('el_raftingcompany', 'el_event_public.rafting_company_id = el_raftingcompany.raftingcompany_id', 'LEFT');
		$this->db->join('el_guidename', 'el_event_public.guide_id = el_guidename.guide_id', 'LEFT');
        $this->db->join('el_category', 'el_event_public.category_id = el_category.id', 'LEFT');
        $this->db->where('el_event_public.event_status', '1');
        if(!empty($categoryID)) {
            $this->db->where('el_event_public.category_id', $categoryID);
        }
        if(!empty($eventDate)) {
            $this->db->where('el_event_public.event_date', $eventDate);
        }
        if(!empty($eventTime)) {
            $this->db->where('el_event_public.event_time', $eventTime);
        }
		if(!empty($company_id)) {
            $this->db->where('el_event_public.rafting_company_id', $company_id);
        }

        $this->db->group_by('el_event_public.event_id');
        $query                  = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() > 0) {
            $recArr             = $query->result_array();
        }
        return $recArr;
    }

	public function getSingleEvent($eventID = 0) {
        $recArr                         = array();
		$this->db->select('el_event_public.*, el_photographer.photographer_name,el_raftingcompany.raftingcompany_name, el_category.cat_name');
		$this->db->from('el_event_public');
		$this->db->join('el_photographer', 'el_event_public.photographer_id = el_photographer.photographer_id', 'LEFT');
        $this->db->join('el_raftingcompany', 'el_event_public.rafting_company_id = el_raftingcompany.raftingcompany_id', 'LEFT');
		$this->db->join('el_category', 'el_event_public.category_id = el_category.id', 'LEFT');
		$this->db->where('el_event_public.event_id', $eventID);
		$query                          = $this->db->get();
		if($query->num_rows() > 0) {
			$recArr                     = $query->row_array();
		}
		

        return $recArr;
    }
	
    public function getcustomerEventId($eventID = array()) {
        $recArr                         = array();
		if($eventID){
			$this->db->select('el_event_public.*, el_photographer.photographer_name,el_raftingcompany.raftingcompany_name,el_category.cat_name');
			$this->db->from('el_event_public');
			$this->db->join('el_photographer', 'el_event_public.photographer_id = el_photographer.photographer_id', 'LEFT');
            $this->db->join('el_raftingcompany', 'el_event_public.rafting_company_id = el_raftingcompany.raftingcompany_id', 'LEFT');
			$this->db->join('el_category', 'el_event_public.category_id = el_category.id', 'LEFT');
			$this->db->where_in('el_event_public.event_id', $eventID);
			$query                          = $this->db->get();
			if($query->num_rows() > 0) {
				$recArr                     = $query->result_array();
			}
		}

        return $recArr;
    }
	
	function eventidByCustomer($customer_id = ''){
    	$recArr = array();
        $this->db->select('event_id');
		$this->db->from('el_customer_favourite');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('is_favourite','1');
		$this->db->group_by('event_id');
		$query = $this->db->get();
		$num = $query->num_rows();
		if($num>0){
			$recArr = $query->result_array();
		}
		return $recArr;
    }

    public function getAllImagesBycustomer($customer_id = 0) {
        $recArr                             = array(); 
        if(!empty($customer_id)) {
            $this->db->select('ECF.*, EMI.*');
            $this->db->from('el_customer_favourite ECF');
			$this->db->join('el_media_image EMI', 'ECF.media_id = EMI.media_id','left');
            $this->db->where('ECF.customer_id', $customer_id);
			$this->db->where('ECF.is_favourite', '1');
            $query                          = $this->db->get();
            //echo $this->db->last_query();
            if($query->num_rows() > 0) {
                $recArr                     = $query->result_array();
            }
        }
        return $recArr;
    }
	
	public function getAllImages($eventID = 0, $limit = 0, $start = 0) {
        $recArr                             = array(); 
        if(!empty($eventID)) {
            $this->db->select('*');
            $this->db->from('el_media_image');
            //$this->db->where('event_id', $eventID);
            $this->db->where('event_id', $eventID);
            $this->db->limit($limit, $start);
            $query                          = $this->db->get();
            //echo $this->db->last_query();
            if($query->num_rows() > 0) {
                $recArr                     = $query->result_array();
            }
        }
        return $recArr;
    }

    public function countAllImages($eventID = 0) {
        $cnt                                = '0'; 
        if(!empty($eventID)) {
            $this->db->select('*');
            $this->db->from('el_media_image');
            //$this->db->where('event_id', $eventID);
            $this->db->where('event_id', $eventID);
            
            $query                          = $this->db->get();
            if($query->num_rows() > 0) {
                $cnt                        = $query->num_rows();
            }
        }
        return $cnt;
    }

    public function getImgDetailsByID($mediaID  = 0) {
        $recArr                             = array();
        if(!empty($mediaID)) {
            $this->db->select('*');
            $this->db->from('el_media_image');
            //$this->db->where('event_id', $eventID);
            $this->db->where('media_id', $mediaID);
            
            $query                          = $this->db->get();
            if($query->num_rows() > 0) {
                $recArr                     = $query->row_array();
            }
        }
        return $recArr;
    }
	
	public function insertData($dataArr = array(), $tableName = '') {
        $this->db->insert($tableName, $dataArr);
//        echo "hi - ".$this->db->last_query();
        if($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }
	
  public function checkisExist($event_id = '',$customer_id = '',$media_id = '') {
       $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_customer_favourite');
        $this->db->where('event_id', $event_id);
        $this->db->where('customer_id', $customer_id);
        $this->db->where('media_id', $media_id);
        $this->db->where('is_favourite', '1');
        $query              = $this->db->get();
        $num                = $query->num_rows();
        if($num>0) {
            $recArr         = $query->row_array();
        }
        return $recArr;
    }
	
	public function checkisExistimage($event_id = '',$customer_id = '',$media_id = '') {
       $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_customer_favourite');
        $this->db->where('event_id', $event_id);
        $this->db->where('customer_id', $customer_id);
        $this->db->where('media_id', $media_id);
        $query              = $this->db->get();
        $num                = $query->num_rows();
        if($num>0) {
            $recArr         = $query->row_array();
        }
        return $recArr;
    }
	
	function updateMedia($data,$tbl,$where) {	

		if(!empty($data)){

			$this->db->where($where);

            $this->db->update($tbl, $data);

			return 1;

		}else{

			return 0;

		}

	}
	
	public function getCustomerFavourite($customer_id = '') {
       $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_customer_favourite');
        $this->db->where('customer_id', $customer_id);
		$this->db->where('is_favourite', '1');
        $query              = $this->db->get();
        $num                = $query->num_rows();
        if($num>0) {
            $recArr         = $query->result_array();
        }
        return $recArr;
    }

    public function getOptionList() {
        $recArr                     = array();
        $this->db->select('*');
        $this->db->from('el_frame_options');
        $this->db->where('option_status', '1');
        $query                      = $this->db->get();
        if($query->num_rows() > 0) {
            $recArr                 = $query->result_array();
        }
        return $recArr;
    }

    public function getOptionPrintDetails($optionID = 0) {
        $recArr                         = array();
        $this->db->select('el_frame_options.*,el_frame_option_print_size.*');
        $this->db->from('el_frame_options');
        $this->db->join('el_frame_option_printsize_rel', 'el_frame_options.option_id = el_frame_option_printsize_rel.option_id', 'LEFT');
        $this->db->join('el_frame_option_print_size', 'el_frame_option_print_size.print_size_id = el_frame_option_printsize_rel.option_print_size_id', 'LEFT');
        $this->db->where('el_frame_options.option_id', "$optionID");

        $query                          = $this->db->get();
        if($query->num_rows() > 0) {
            $recArr                     = $query->result_array();
        }
        return $recArr;
    }

    public function optionMetaDetails($optionID = 0) {
        $recArr                         = array();
        $this->db->select('el_frame_option_meta_head.*,el_frame_options_meta.*');
        $this->db->from('el_frame_options');
        $this->db->join('el_frame_option_meta_head', 'el_frame_options.option_id = el_frame_option_meta_head.option_id', 'LEFT');
        $this->db->join('el_frame_options_meta', 'el_frame_option_meta_head.option_meta_head_id = el_frame_options_meta.option_meta_head_id', 'LEFT');
        $this->db->where('el_frame_options.option_id', "$optionID");

        $query                          = $this->db->get();
        if($query->num_rows() > 0) {
            $recArr                     = $query->result_array();
        }
        return $recArr;
    }
	
	public function countImage($customer_id = '',$event_id='') {
        $recArr             = array();
        $this->db->select('*');
        $this->db->from('el_customer_favourite');
        $this->db->where('customer_id', $customer_id);
		$this->db->where('event_id', $event_id);
		$this->db->where('is_favourite', '1');
        $query              = $this->db->get();
        $num                = $query->num_rows();
        if($num>0) {
            $recArr         = $query->result_array();
        }
        return $num;
    }
#####################sreela(23-05-18)##########################
	public function	getAllImagesByImgId($customer_id,$img_id){
		$recArr                             = array(); 
        if(!empty($customer_id)) {
			
            $this->db->select('ECF.*, EMI.*');
            $this->db->from('el_customer_favourite ECF');
			$this->db->join('el_media_image EMI', 'ECF.media_id = EMI.media_id','left');
            $this->db->where('ECF.customer_id', $customer_id);
			$this->db->where('ECF.is_favourite', '1');
			$this->db->where_in('EMI.media_id',$img_id);
            $query                          = $this->db->get();
            //echo $this->db->last_query();
            if($query->num_rows() > 0) {
                $recArr                     = $query->result_array();
            }
        }
		
        return $recArr;
		
		
		
	}
}