<?php
class Loginmodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
    function authentication($id="",$password="") {

        // echo $id;
        // echo $password;
        // exit;
        $this->db->select('*');
        $this->db->from('el_admin');
        $this->db->where('username',$id);
        $this->db->where('password',$password);
        $this->db->where('user_status','1');
        $query = $this->db->get();
		//echo $this->db->last_query();exit;
		$num = $query->num_rows();
		if($num>0){
			
			$result = $query->row_array();
			$this->session->set_userdata('userName',$result['username']);
			$this->session->set_userdata('admin_user_id',$result['user_id']);
			/*$_SESSION['userName']			= $result['username'];
			$_SESSION['admin_user_id']		= $result['user_id'];*/
			return true;
		}else{
			return false;
		}
    }
	
	public function change_pass($user_id = '') {
        $oldpass = $this->input->post('old_password');
        
        $newpass = $this->input->post('password');
       
        $conpass = $this->input->post('confirm_password');
        

        $login_data = $this->db->get_where('el_admin', array('user_id' => $user_id))->result();

        $old = $login_data[0]->password;

        if ($old == $oldpass) {
            if ($newpass == $conpass) {
                $this->db->update('el_admin', array('password' => $newpass), array('user_id' => $user_id));
                return 1;
            }
            else
                return 2;
        }
        else
            return 3;
    }
}