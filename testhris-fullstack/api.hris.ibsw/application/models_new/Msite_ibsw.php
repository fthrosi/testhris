<?php

class Msite_ibsw extends CI_Model
{
    public function get_site($siteID = null){
      if($siteID === null){
          $site = $this->db->get('site')->result_array();

          foreach ($site as $key => $value) {
              $data = array(
                  'id' => $value['id'],
                  'wbs_id' => $value['site_id'],
                  'site_name' => $value['site_name'],
                  'address' => $value['alamat'],
                  'region' =>$value['region'],
                
                  );
                  $data_master[] = $data;
              };
              
          return $data_master;
      }
    }

    public function get_users(){
        $this->db->select('id_user');
        $this->db->select('employee_id');
        $this->db->select('full_name');
        $this->db->select('user_email');
        $this->db->select('user_role');
        $this->db->select('access_level');
        $this->db->select('verification_status');
        $q = $this->db->get('users');
        $data = $q->result_array();
        return $data;
    }

    public function get_user_login($email = null, $nik = null){
      if($email === null || $nik === null){
          $employee = $this->db->get('v_hris_employee_updated')->result_array();

          foreach ($employee as $key => $value) {
              $data = array(
                  'id_employee' => $value['id_employee'],
                  'nik' => $value['nik'],
                  'complete_name' => decrypt($value['complete_name']),
                  'start_date' => decrypt($value['start_date']),
                  'action' => decrypt($value['action']),
                  'reason_of_action' => decrypt($value['reason_of_action']),
                  'gender' => decrypt($value['gender']),
                  'birthplace' => decrypt($value['birthplace']),
                  'date_of_birth' => decrypt($value['date_of_birth']),
                  'religion' => decrypt($value['religion']),
                  'marital_status' => decrypt($value['marital_status']),
                  'join_date' => decrypt($value['join_date']),
                  'permanent_address' => decrypt($value['permanent_address']),
                  'temporary_address' => decrypt($value['temporary_address']),
                  'phone_number' => decrypt($value['phone_number']),
                  'sf_phone_number' => decrypt($value['sf_phone_number']),
                  'personal_email' => decrypt($value['personal_email']),
                  'email' => decrypt($value['email']),
                  'no_ktp' => decrypt($value['no_ktp']),
                  'npwp_id' => decrypt($value['npwp_id']),
                  'bpjs_ketenagakerjaan' => decrypt($value['bpjs_ketenagakerjaan']),
                  'bpjs_kesehatan' => decrypt($value['bpjs_kesehatan']),
                  'status_ptkp' => decrypt($value['status_ptkp']),
                  'company_code' => decrypt($value['company_code']),
                  'company_name' => decrypt($value['company_name']),
                  'personnel_area' => decrypt($value['personnel_area']),
                  'personnel_subarea' => decrypt($value['personnel_subarea']),
                  'employee_group' => decrypt($value['employee_group']),
                  'employee_subgroup' => decrypt($value['employee_subgroup']),
                  'cost_center' => decrypt($value['cost_center']),
                  'cost_center_desc' => decrypt($value['cost_center_desc']),
                  'bankn' => decrypt($value['bankn']),
                  'emftx' => decrypt($value['emftx']),
                  'bankn1' => decrypt($value['bankn1']),
                  'emftx1' => decrypt($value['emftx1']),
                  'position' => decrypt($value['position']),
                  'department' => decrypt($value['department']),
                  'division' => decrypt($value['division']),
                  'directorate' => decrypt($value['directorate']),
                  'superior' => decrypt($value['superior']),
                  'superior_name' => decrypt($value['superior_name']),
                  'usrid_long1' => decrypt($value['usrid_long1']),
                  'rpm' => decrypt($value['rpm']),
                  'rpm_name' => decrypt($value['rpm_name']),
                  'usrid_long5' => decrypt($value['usrid_long5']),
                  'department_head' => decrypt($value['department_head']),
                  'depthead_name' => decrypt($value['depthead_name']),
                  'usrid_long2' => decrypt($value['usrid_long2']),
                  'division_head' => decrypt($value['division_head']),
                  'divhead_name' => decrypt($value['divhead_name']),
                  'usrid_long3' => decrypt($value['usrid_long3']),
                  'director' => decrypt($value['director']),
                  'director_name' => decrypt($value['director_name']),
                  'usrid_long4' => decrypt($value['usrid_long4'])
                  );
                  $data_employee[] = $data;
              };
              
          return $data_employee;
      }else{
        $email = encrypt($email);
        $condition = array(
         'email'=>$email,
         'nik'=>$nik
        );

        $employee = $this->db->get_where('v_hris_employee_updated', $condition)->result_array();

        foreach ($employee as $key => $value) {
            $data = array(
                'id_employee' => $value['id_employee'],
                'nik' => $value['nik'],
                'complete_name' => decrypt($value['complete_name']),
                'start_date' => decrypt($value['start_date']),
                'action' => decrypt($value['action']),
                'reason_of_action' => decrypt($value['reason_of_action']),
                'gender' => decrypt($value['gender']),
                'birthplace' => decrypt($value['birthplace']),
                'date_of_birth' => decrypt($value['date_of_birth']),
                'religion' => decrypt($value['religion']),
                'marital_status' => decrypt($value['marital_status']),
                'join_date' => decrypt($value['join_date']),
                'permanent_address' => decrypt($value['permanent_address']),
                'temporary_address' => decrypt($value['temporary_address']),
                'phone_number' => decrypt($value['phone_number']),
                'sf_phone_number' => decrypt($value['sf_phone_number']),
                'personal_email' => decrypt($value['personal_email']),
                'email' => decrypt($value['email']),
                'no_ktp' => decrypt($value['no_ktp']),
                'npwp_id' => decrypt($value['npwp_id']),
                'bpjs_ketenagakerjaan' => decrypt($value['bpjs_ketenagakerjaan']),
                'bpjs_kesehatan' => decrypt($value['bpjs_kesehatan']),
                'status_ptkp' => decrypt($value['status_ptkp']),
                'company_code' => decrypt($value['company_code']),
                'company_name' => decrypt($value['company_name']),
                'personnel_area' => decrypt($value['personnel_area']),
                'personnel_subarea' => decrypt($value['personnel_subarea']),
                'employee_group' => decrypt($value['employee_group']),
                'employee_subgroup' => decrypt($value['employee_subgroup']),
                'cost_center' => decrypt($value['cost_center']),
                'cost_center_desc' => decrypt($value['cost_center_desc']),
                'bankn' => decrypt($value['bankn']),
                'emftx' => decrypt($value['emftx']),
                'bankn1' => decrypt($value['bankn1']),
                'emftx1' => decrypt($value['emftx1']),
                'position' => decrypt($value['position']),
                'department' => decrypt($value['department']),
                'division' => decrypt($value['division']),
                'directorate' => decrypt($value['directorate']),
                'superior' => decrypt($value['superior']),
                'superior_name' => decrypt($value['superior_name']),
                'usrid_long1' => decrypt($value['usrid_long1']),
                'rpm' => decrypt($value['rpm']),
                'rpm_name' => decrypt($value['rpm_name']),
                'usrid_long5' => decrypt($value['usrid_long5']),
                'department_head' => decrypt($value['department_head']),
                'depthead_name' => decrypt($value['depthead_name']),
                'usrid_long2' => decrypt($value['usrid_long2']),
                'division_head' => decrypt($value['division_head']),
                'divhead_name' => decrypt($value['divhead_name']),
                'usrid_long3' => decrypt($value['usrid_long3']),
                'director' => decrypt($value['director']),
                'director_name' => decrypt($value['director_name']),
                'usrid_long4' => decrypt($value['usrid_long4'])
                );
                $data_employee[] = $data;
            };
        return $data_employee;
      }
    }
}

?>