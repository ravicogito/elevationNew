<?php
class Feedbackmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }

    function allFeedbackList(){

        $recArr						= array();
		
		$sql	= $this->db->query("select aef.*,(select event_title from anad_events where event_id = aef.event_id) as event_name,(select user_title from anad_users where user_id = aef.user_id) as user_title,(select user_firstname from anad_users where user_id = aef.user_id) as user_firstname,(select user_middlename from anad_users where user_id = aef.user_id) as user_middlename,(select user_lastname from anad_users where user_id = aef.user_id) as user_lastname from anad_event_feedback aef");
		
        $num = $sql->num_rows();
        if($num>0){
            $recArr = $sql->result_array();
			
        }
		return $recArr;

    }
	
}
?>	