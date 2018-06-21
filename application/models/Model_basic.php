<?php
/**
 *
 * @ Basic model
 *
 *
 */

class Model_basic extends CI_Model {

    function __construct() {
       parent::__construct();
    }
 
 /**
 * @function : isRecordExist
 * @description : this function is use to check the record uniqueness in a table based on the condition
 * @parameter : $tableName, $condition, $idField, $idValue
 * @return number of record
 */


	public function isRecordExist($tableName = '', $condition = '', $idField = '', $idValue = '') {
		if($condition == '') $condition = 1;
		 $sql = "SELECT COUNT(*) as CNT FROM ".$tableName." WHERE ".$condition."";
		if($idValue > 0 && $idValue <> '') {
			$sql .=" AND ".$idField." <> '".$idValue."'";
		}
        //echo $sql;exit;
		$rs = $this->db->query($sql);
		$rec = $rs->row();
		$cnt = $rec->CNT;
		return $cnt;
	}     

/**
 * @function : insdata
 * @description : this function is use to insert data
 * @parameter : data array and table name
 * @return boolean
 */
   
    public function insdata($dataArr = array(), $tableName = '') {
        $insRec = $this->insertData($dataArr, $tableName);
        return $insRec;
    }

/**
 * @function : insbatchdata
 * @description : this function is use to insert batchdata
 * @parameter : data array and table name
 * @return boolean
 */

    public function insbatchdata($dataArr = array(), $tableName = '', $course_id = 0) {
        /*if($course_id > 0) {
            $this->delData($tableName, array("course_id" => $course_id));
        }*/
        $insRec = $this->db->insert_batch($tableName, $dataArr);
        return TRUE;
    }

/**
 * @function : insertData
 * @description : This is a private function and used only to insert data in the database.
 * @param : insert data array and table name
 * @return : last inserted id for success and false for fail. 
 */    
 
    private function insertData($dataArr = array(), $tableName = '') {
        $this->db->insert($tableName, $dataArr);
//        echo "hi - ".$this->db->last_query();
        if($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }    

/**
 * @function : editdata
 * @description : this function is use to edit data
 * @parameter : data array, table name and condition array
 * @return boolean
 */
   
    public function editdata($dataArr = array(), $tableName = '', $conditionArr = array()) {
        $editRec = $this->updateData($dataArr, $tableName, $conditionArr);
        return $editRec;
    }
    
/**
 * @function : updateData
 * @description : This is a private function and used only to update data in the database based on the condition.
 * @param : update data array and table name, condition array
 * @return : boolean. 
 */
 
    private function updateData($dataArr = array(), $tableName = '', $conditionArr = array()) {
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

/**
 * @function : deletedata
 * @description : this function is use to delete data
 * @parameter : data array, table name and condition array
 * @return boolean
 */
    public function deletedata($tableName = '', $conditionArr = array()) {
        $delRec = $this->delData($tableName, $conditionArr);
        return $delRec;
    }

/**
 * @function : deleteData
 * @description : This is a private function and used only to delete data in the database based on the condition.
 * @param : delete data array and table name, condition array
 * @return : boolean. 
 */
    private function delData($tableName = '', $conditionArr = array()) {
        if(count($conditionArr) > 0) {
            $this->db->delete($tableName, $conditionArr);
            if($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function getSingle($idField = '', $idValue = '', $tableName = '') {
		$recArr						= array();
		if(!empty($image_id)) {
			$this->db->select('*');
        	$this->db->from($tableName);        	
        	$this->db->where($idField, $idValue);
        	$query 	= $this->db->get();
        	$num 	= $query->num_rows();
	        if($num>0){	         
	            $recArr = $query->row_array();
			}
		}
		return $recArr;
	}
    public function validWishlistAdd($userID,$imgID){
		
			$this->db->select('*');
			$this->db->from('el_wishlist');
			$this->db->where('user_id',$userID);
			$this->db->where('image_id',$imgID);
			$query = $this->db->get();
			$num = $query->num_rows();
			if($num>0){
				
				return $num;
				
			}else{
				return 0;
			}

		
	}
}