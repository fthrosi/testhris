<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_register extends CI_Model {

	public function checkID($employee_id)
    {
        $this->db->select('id, division, employee_name');
        $this->db->where('employee_nik', $employee_id);
        return $this->db->get('employee');
    }

    public function checkRegistration($email,$phone)
    {
        return $this->db->get_where('service_auth', array(
            'user_email' => $email,  
            'phone_number' => $phone, 
            'activity_name' => 'eApproval Registration', 
            'trans_id' => '000', 
            'trans_code' => '000', 
            'authentication' => 0));
    }

    public function checkChangeNumber($email,$phone)
    {
        return $this->db->get_where('service_auth', array(
            'user_email' => $email,  
            'phone_number' => $phone, 
            'activity_name' => 'Change Number',
            'trans_id' => '000', 
            'trans_code' => '000', 
            'authentication' => 0));
    }

	public function getDataOTP($user_email, $phoneNumber, $activity = '')
    {
        if ($activity != '') {
            $act = 'Change Number';
        } else {
            $act = 'eApproval Registration';
        }

        $check = $this->db
            ->where('user_email', $user_email)
            ->where('phone_number', $phoneNumber)	
            ->where('authentication', 0) 
            ->where('activity_name', $act)
            ->where('trans_id', '000')
            ->where('trans_code', '000')
            ->get('service_auth');

        if ($check->num_rows() > 0) {
            return $check->row_array()['otp_code'];
        } else {
            return 0;
        }
    }

    public function saveChangePassword($newpasscode){

        $newpasscode = encrypt($newpasscode);
        $employee_id = $this->session->userdata('employee_id');

        $sql = "UPDATE users SET password='$newpasscode' WHERE employee_id='$employee_id'";
		$query = $this->db->query($sql);
		
		if($query){
			return $query;
		}else{
			return false;
		}
    }

}
