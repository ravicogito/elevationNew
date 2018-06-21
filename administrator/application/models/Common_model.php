<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Common_model extends CI_Model {


	public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

	public function getValue_condition($TableName, $FieldName, $AliasFieldName='', $Condition='') {
            if($Condition=="") {
                $Condition="";
            } else {
                $Condition=" WHERE ".$Condition;
            }
            if($AliasFieldName == '') {
                    $getField = $FieldName;
            } else {
                $getField = $AliasFieldName;
                $FieldName = $FieldName ." AS ".$AliasFieldName;
            }

            $sql = "SELECT ".$FieldName." FROM ".$TableName.$Condition;
            //echo $sql."<br />";
            $rs = $this->db->query($sql);
            if($rs->num_rows()) {
                $rec = $rs->row();
                if(is_numeric($rec->$getField)) {
                    if($rec->$getField > 0) {
                        return $rec->$getField;
                    } else {
                        return "0";
                    }
                } else {
                    return $rec->$getField;
                }
            } else {
                return false;
            }
	}

	public function isRecordExist($tableName = '', $condition = '', $idField = '', $idValue = '') {
		if($condition == '') $condition = 1;
		$sql = "SELECT COUNT(*) as CNT FROM ".$tableName." WHERE ".$condition."";

		if($idValue > 0 && $idValue <> '') {
			$sql .=" AND ".$idField." <> '".$idValue."'";
		}
        // echo $sql;exit;
		$rs = $this->db->query($sql);
		$rec = $rs->row();
		$cnt = $rec->CNT;
		return $cnt;
	}


	public function populateDropdown($idField, $nameField, $tableName, $condition, $orderField, $orderBy) {
            $sql = "SELECT ".$idField.", ".$nameField." FROM ".$tableName." WHERE ".$condition." ORDER BY ".$orderField." ".$orderBy."";
            $rs = $this->db->query($sql);
            if($rs->num_rows()) {
                $rec = $rs->result_array();
                return $rec;
            }
            return false;
	}

	public function getSingle($tableName, $whereCondition) {
        if($whereCondition <> '') {
            $where = " WHERE ".$whereCondition;
        } else {
            $where = " WHERE 1 ";
        }
        $sql = "SELECT * FROM ".$tableName." ".$where." ";
        $rs = $this->db->query($sql);
        if($rs->num_rows()) {
            $rec = $rs->result();
            return $rec;
        }
        return false;
	}

   
    public function getList($TableName, $FieldName, $Condition='') {
		if($Condition == "") {
            $Condition        = "";
        } else {
            $Condition        = " WHERE ".$Condition;
        }
		$sql                  = "SELECT ".$FieldName." FROM ".$TableName.$Condition;
		$rs                   = $this->db->query($sql);
		$rec                  = false;
		if($rs->num_rows()) {
            $rec              = $rs->result_array();
        } else {
            // do nothing
        }
		return $rec;

	}


    public function cngStatus($TableName, $FieldName, $Condition = '') {
        $data = array();
        if( !empty($Condition)) {
            $Condition=" WHERE ".$Condition;
        } else {
            // do nothing.
        }
        $sql = "UPDATE $TableName SET $FieldName = IF($FieldName='on','off','on') $Condition";
        $this->db->query($sql);
        if( $this->db->affected_rows() > 0 ) {
            $data['type']               = "succmsg";
            $data['msg']                = "Status Changed Successfully.";
            $data['success']            = TRUE;
        } else {
            $data['type']               = "errmsg";
            $data['msg']                = "Unable to change status. Please try again.";
            $data['success']            = TRUE;
        }
        return $data;
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


}