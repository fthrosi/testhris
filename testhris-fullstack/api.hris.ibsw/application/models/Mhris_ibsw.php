<?php

class Mhris_ibsw extends CI_Model
{
    public function get_employee_test($nik = null){
      if($nik === null){
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
          $employee = $this->db->get_where('v_hris_employee_updated', ['nik' => $nik])->result_array();

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
    
    public function get_employee($nik = null){
      if($nik === null){
          $employee = $this->db->get('v_hris_employee_updated')->result_array();

          foreach ($employee as $key => $value) {

                $gen = strtolower(decrypt($value['gender']) ?? 'male');
                $avatar      = ($gen === 'male') ? 'avatar_man.png' : 'avatar_female.png';
                // $img_profile = base_url("assets/images/{$avatar}");
                $img_profile = "https://hris.ibsmulti.com/assets/images/{$avatar}";

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
                  'usrid_long4' => decrypt($value['usrid_long4']),
                  'img_profile' => $img_profile
                  );
                  $data_employee[] = $data;
              };
              
          return $data_employee;
      }else{
          $employee = $this->db->get_where('v_hris_employee_updated', ['nik' => $nik])->result_array();

          foreach ($employee as $key => $value) {

                $gen = strtolower(decrypt($value['gender']) ?? 'male');
                $avatar      = ($gen === 'male') ? 'avatar_man.png' : 'avatar_female.png';
                // $img_profile = base_url("assets/images/{$avatar}");
                $img_profile = "https://hris.ibsmulti.com/assets/images/{$avatar}";

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
                  'usrid_long4' => decrypt($value['usrid_long4']),
                  'img_profile' => $img_profile
                  );
                  $data_employee[] = $data;
              };
          return $data_employee;
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

    // public function get_user_login_mobile($email = null, $nik = null, $pass){
    public function get_user_login_mobile($data){
        $datauser1      = $data['datauser'];
        $datauser2      = encrypt($data['datauser']);
        $pass           = $data['pass'];
        $year           = $this->year-1;

        $sql = "SELECT *, a.id_employee,
				case 
					when c.department != '' and c.evaluation_year = '$year' then c.department
				else
					a.department
				end as department, 
				case 
					when c.division != '' and c.evaluation_year = '$year' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' and c.evaluation_year = '$year' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' and c.evaluation_year = '$year' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' and c.evaluation_year = '$year' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN users b ON a.nik = b.employee_id
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				WHERE (lower(a.email) like '$datauser2' OR a.nik = '$datauser1') AND b.password like '$pass' and b.is_active <> 0
				ORDER BY a.id_employee DESC";

		$query = $this->db->query($sql);
		$data = $query->result();
        if($data){
            $gen         = strtolower(decrypt($data[0]->gender) ?? 'male');
            $avatar      = ($gen === 'male') ? 'avatar_man.png' : 'avatar_female.png';
            // $img_profile = base_url("assets/images/{$avatar}");
            $img_profile = "https://hris.ibsmulti.com/assets/images/{$avatar}";
            $sess_array = array(     
                'user_email' => decrypt($data[0]->email),   
                'user_role' => $data[0]->user_role,    
                'access_level' => $data[0]->access_level, 
                'verification_status' => $data[0]->verification_status, 
                'employee_id' => $data[0]->employee_id,
                'join_date' => decrypt($data[0]->join_date),
                'action' => decrypt($data[0]->action),
                'employee_subgroup' => decrypt($data[0]->employee_subgroup), 
                'employee_group' => decrypt($data[0]->employee_group), 
                'name' => decrypt($data[0]->complete_name), 
                'cost_center' => decrypt($data[0]->cost_center), 
                'nik' => $data[0]->employee_id,
                'division' => decrypt($data[0]->division),
                'gender' => decrypt($data[0]->gender),
                'access_employee' => $data[0]->user_role,
                'access_level' => $data[0]->access_level,
                'id_hr_emp' => $data[0]->id_employee,
                'company_code' => decrypt($data[0]->company_code),
                'marital_status' => decrypt($data[0]->marital_status),
                'personnel_area' => decrypt($data[0]->personnel_area),
                'position' => decrypt($data[0]->position),
                'directorate' => decrypt($data[0]->directorate),
                'department' => decrypt($data[0]->department),
                'second_division' => $data[0]->second_division,
                'depthead' => decrypt($data[0]->usrid_long2),
                'divhead' => decrypt($data[0]->usrid_long3),
                'director' => decrypt($data[0]->usrid_long4),
                'division_root' => $data[0]->division_root,
                'personal_area' => $data[0]->personal_area,
                'pa_lat' => $data[0]->pa_lat,
                'pa_long' => $data[0]->pa_long,
                'img_profile' => $img_profile
              );
            
            return $sess_array;
        }else{
            return false;
        }
        
      
    }
    
    public function get_user_login_web($data){
        $datauser1      = $data['datauser'];
        $datauser2      = encrypt($data['datauser']);
        $pass           = $data['pass'];
        $year           = $this->year-1;

        $sql = "SELECT *, a.id_employee,
				case 
					when c.department != '' and c.evaluation_year = '$year' then c.department
				else
					a.department
				end as department, 
				case 
					when c.division != '' and c.evaluation_year = '$year' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' and c.evaluation_year = '$year' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' and c.evaluation_year = '$year' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' and c.evaluation_year = '$year' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN users b ON a.nik = b.employee_id
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				WHERE (lower(a.email) like '$datauser2' OR a.nik = '$datauser1') AND b.password like '$pass' and b.is_active <> 0
				ORDER BY a.id_employee DESC";

		$query = $this->db->query($sql);
		$data = $query->result();
        if($data){
            $gen         = strtolower(decrypt($data[0]->gender) ?? 'male');
            $avatar      = ($gen === 'male') ? 'avatar_man.png' : 'avatar_female.png';
            // $img_profile = base_url("assets/images/{$avatar}");
            $img_profile = "https://hris.ibsmulti.com/assets/images/{$avatar}";
            $sess_array = array(     
                'user_email' => decrypt($data[0]->email),   
                'user_role' => $data[0]->user_role,    
                'access_level' => $data[0]->access_level, 
                'verification_status' => $data[0]->verification_status, 
                'employee_id' => $data[0]->employee_id,
                'join_date' => decrypt($data[0]->join_date),
                'action' => decrypt($data[0]->action),
                'employee_subgroup' => decrypt($data[0]->employee_subgroup), 
                'employee_group' => decrypt($data[0]->employee_group), 
                'name' => decrypt($data[0]->complete_name), 
                'cost_center' => decrypt($data[0]->cost_center), 
                'nik' => $data[0]->employee_id,
                'division' => decrypt($data[0]->division),
                'gender' => decrypt($data[0]->gender),
                'access_employee' => $data[0]->user_role,
                'access_level' => $data[0]->access_level,
                'id_hr_emp' => $data[0]->id_employee,
                'company_code' => decrypt($data[0]->company_code),
                'marital_status' => decrypt($data[0]->marital_status),
                'personnel_area' => decrypt($data[0]->personnel_area),
                'position' => decrypt($data[0]->position),
                'directorate' => decrypt($data[0]->directorate),
                'department' => decrypt($data[0]->department),
                'second_division' => $data[0]->second_division,
                'depthead' => decrypt($data[0]->usrid_long2),
                'divhead' => decrypt($data[0]->usrid_long3),
                'director' => decrypt($data[0]->usrid_long4),
                'division_root' => $data[0]->division_root,
                'personal_area' => $data[0]->personal_area,
                'pa_lat' => $data[0]->pa_lat,
                'pa_long' => $data[0]->pa_long,
                'img_profile' => $img_profile
              );
            
            return $sess_array;
        }else{
            return false;
        }
        
      
    }
    
    
    public function get_schedule_employee($data){
        $nik               = $data['nik'];
        $start_date        = $data['start_date'];
        $end_date          = $data['end_date'];

        $sql = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date BETWEEN '$start_date' AND '$end_date'";

		$query = $this->db->query($sql);
		$data = $query->result();

        if($data){
            foreach ($data as $key => $value) {

                if($value->dws == 'NORM'){
                    $dws = 'NORMAL';
                }else{
                    $dws = $value->dws;
                }

                $data_array = array(     
                    'nik'               => $value->employee_id,   
                    'full_name'         => $value->full_name,    
                    'date'              => $value->date, 
                    'dws'               => $dws, 
                    'schedule_code'     => $value->schedule_code,
                    'attendence_code'   => $value->attendence_code,
                    'time_off_code'     => $value->time_off_code,
                    'schedule_in'       => $value->schedule_in,
                    'schedule_out'      => $value->schedule_out,
                    'check_in'          => $value->check_in,
                    'check_in_date'     => $value->check_in_date,
                    'check_in_location' => $value->check_in_location,
                    'lat_in'            => $value->lat_in,
                    'long_in'           => $value->long_in,
                    'check_out'         => $value->check_out,
                    'check_out_date'    => $value->check_out_date,
                    'check_out_location'=> $value->check_out_location,
                    'lat_out'           => $value->lat_out,
                    'long_out'          => $value->long_out,
                );
                $data_schedule[] = $data_array;
            }
            return $data_schedule;
        }else{
            return false;
        }
        
      
    }
    
    public function get_schedule_per_day_employee($data){
        $nik               = $data['nik'];
        $date              = $data['date'];

        $sql = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date LIKE '$date'";
		$query = $this->db->query($sql);
        // dumper($sql);
		$data = $query->result()[0];
        if ($data){
            if($data->dws == 'NORM'){
                $dws = 'NORMAL';
            }else{
                $dws = $data->dws;
            }
			return array(TRUE, $data->employee_id, $data->full_name, $data->date, $dws, $data->schedule_code, $data->attendence_code, $data->time_off_code, $data->schedule_in, $data->schedule_out);
		} else {
			return array(FALSE, '', '', '', '', '', '', '', '', '', '');
		}      
    }

    public function get_pa_employee($data){
        $nik               = $data['nik'];
        $today             = $data['date'];
        $sql = "SELECT *
				FROM
				hris_master_relokasi_sementara 
				WHERE nik LIKE '$nik' AND start_date <= '$today' AND end_date >= '$today' AND status = 1";
                $query = $this->db->query($sql);
                $result = $query->result_array();
        if(!empty($result)){
            $pa = $result['pa_akhir'];
            $sql_pa = "SELECT *
				FROM
				hris_master_personnel_area 
				WHERE start_date <= '$today' AND end_date >= '$today' AND personnel_area LIKE '$pa'";
                $query_pa = $this->db->query($sql_pa);
                $result_pa = $query_pa->result_array();
                foreach ($result_pa as $key => $value) {
                    $data = array(
                        'pa_code' => $value['pa_code'],
                        'personnel_area' => $value['personnel_area'],
                        'start_date' => $value['start_date'],
                        'end_date' => $value['end_date'],
                        'address' => $value['address'],
                        'lat' => $value['lattitude'],
                        'long' => $value['longitude'],
                        'radius' => $value['radius'],
                    );
                    $data_employee[] = $data;       
                }
                return($data_employee);
        }else{
            $sqlEmployee = "SELECT personnel_area FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
            $resultEmp = $this->db->query($sqlEmployee);
            $resPA = $resultEmp->result_array()[0];
            $pa = decrypt($resPA['personnel_area']);

            $sql_pa = "SELECT *
				FROM
				hris_master_personnel_area 
				WHERE start_date <= '$today' AND end_date >= '$today' AND personnel_area LIKE '$pa'";
                $query_pa = $this->db->query($sql_pa);
                $result_pa = $query_pa->result_array();
                foreach ($result_pa as $key => $value) {
                    $data = array(
                        'pa_code' => $value['pa_code'],
                        'personnel_area' => $value['personnel_area'],
                        'start_date' => $value['start_date'],
                        'end_date' => $value['end_date'],
                        'address' => $value['address'],
                        'lat' => $value['lattitude'],
                        'long' => $value['longitude'],
                        'radius' => $value['radius'],
                    );
                    $data_employee[] = $data;       
                }
                return($data_employee);
        }

    }

    public function getRelocation_ztm($data){
        $nik               = $data['nik'];
        $date              = $data['date'];
        $this->db->select('*');
		$this->db->from('hris_master_relokasi_sementara');
		$this->db->where('nik',$nik);
		$this->db->where('start_date <=',$date);
		$this->db->where('end_date >=',$date);
		$this->db->where('status', 1);
		$relocation = $this->db->get()->result();
		if($relocation){
			return $relocation[0];	
		}else{
			return $relocation;
		}
	}

    // public function checkOfficeRadius_ztm($data){
    //     $date              = $data['date'];
    //     $lat_in            = $data['lat'];
    //     $long_in           = $data['long'];
	// 	$this->db->select('*');
	// 	$this->db->from('hris_master_personnel_area');
	// 	$this->db->where('start_date <=', $date);
	// 	$this->db->where('end_date >=', $date);
	// 	$office_loc = $this->db->get()->result();
        

	// 	foreach ($office_loc as $area){
	// 		$latFrom = deg2rad($area->lattitude);
	// 		$lonFrom = deg2rad($area->longitude);
	// 		$address = $area->address;
	// 		$latTo = deg2rad($lat_in);
	// 		$lonTo = deg2rad($long_in);

	// 		$latDelta = $latTo - $latFrom;
	// 		$lonDelta = $lonTo - $lonFrom;

	// 		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	// 		$distance = $angle * 6371000;

	// 		if ($area->radius >= $distance){
    //             $data = array(
    //                 'location_code' => TRUE,
    //                 'address' => $address,
    //                 'desc' => "Office Area"
    //             );
	// 			return ($data);
	// 		} else {
	// 			continue;
	// 		}
	// 	}

	// 	if (empty($office_loc)){
    //         $data = array(
    //             'location_code' => FALSE,
    //             'address' => 'Unknow',
    //             'desc' => "No Office Set, Please Contact HR Support"
    //         );
    //         return ($data);
	// 	} else {
    //         $data = array(
    //             'location_code' => FALSE,
    //             'address' => 'Unknow',
    //             'desc' => "Non Office Area"
    //         );
    //         return ($data);
	// 	}

	// }

    public function checkOfficeRadius_ztm($data){
        $date   = $data['date'];
        $lat_in = (float)$data['lat'];
        $long_in = (float)$data['long'];

        $this->db->select('*');
        $this->db->from('hris_master_personnel_area');
        $this->db->where('start_date <=', $date);
        $this->db->where('end_date >=', $date);
        $office_loc = $this->db->get()->result();

        foreach ($office_loc as $area){
            if (!is_numeric($area->lattitude) || !is_numeric($area->longitude)) {
                continue;
            }

            $latFrom = deg2rad((float)$area->lattitude);
            $lonFrom = deg2rad((float)$area->longitude);
            $latTo   = deg2rad($lat_in);
            $lonTo   = deg2rad($long_in);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2)
                    + cos($latFrom) * cos($latTo)
                    * pow(sin($lonDelta / 2), 2)));
            $distance = $angle * 6371000;

            if ($area->radius >= $distance){
                return [
                    'status' => TRUE,
                    'location_code' => TRUE,
                    'address' => $area->address,
                    'desc' => "Office Area",
                    'message' => "You are within the office area."
                ];
            }
        }

        if (empty($office_loc)){
            return [
                'status' => FALSE,
                'location_code' => FALSE,
                'address' => 'Unknown',
                'desc' => "No Office Set, Please Contact HR Support",
                'message' => "Unauthorized office location. Please contact HR Support to update your assigned workplace."
            ];
        } else {
            return [
                'status' => FALSE,
                'location_code' => FALSE,
                'address' => 'Unknown',
                'desc' => "Non Office Area",
                'message' => "You are outside the designated office area."
            ];
        }
    }

    
    // public function getOfficeRadius_ztm($personnel_area, $data){
    //     $nik               = $data['nik'];
    //     $date              = $data['date'];
    //     $lat_in            = $data['lat'];
    //     $long_in           = $data['long'];
	// 	$this->db->select('*');
	// 	$this->db->from('hris_master_personnel_area');
	// 	$this->db->where('personnel_area', $personnel_area);
	// 	$this->db->where('start_date <=', $date);
	// 	$this->db->where('end_date >=', $date);
	// 	$office_loc = $this->db->get()->result();
        

	// 	foreach ($office_loc as $area){
	// 		$latFrom = deg2rad($area->lattitude);
	// 		$lonFrom = deg2rad($area->longitude);
	// 		$address = $area->address;
	// 		$latTo = deg2rad($lat_in);
	// 		$lonTo = deg2rad($long_in);

	// 		$latDelta = $latTo - $latFrom;
	// 		$lonDelta = $lonTo - $lonFrom;

	// 		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	// 		$distance = $angle * 6371000;

    //         // if($nik == '20210086'){
    //         //     $luas_area = 500;
    //         // }else{
    //             $luas_area = $area->radius;
    //         // }

	// 		if ($luas_area >= $distance){
    //             $data = array(
    //                 'location_code' => TRUE,
    //                 'address' => $address,
    //                 'desc' => "Office Area"
    //             );
	// 			return ($data);
	// 		} else {
	// 			continue;
	// 		}
	// 	}

	// 	if (empty($office_loc)){
    //         $data = array(
    //             'location_code' => FALSE,
    //             'address' => 'Unknow',
    //             'desc' => "No Office Set, Please Contact HR Support"
    //         );
    //         return ($data);
	// 	} else {
    //         $data = array(
    //             'location_code' => FALSE,
    //             'address' => 'Unknow',
    //             'desc' => "Non Office Area"
    //         );
    //         return ($data);
	// 	}

	// }

    public function getOfficeRadius_ztm($personnel_area, $data)
    {
        $nik     = $data['nik'];
        $date    = $data['date'];
        $lat_in  = (float)$data['lat'];
        $long_in = (float)$data['long'];

        $this->db->select('*');
        $this->db->from('hris_master_personnel_area');
        $this->db->where('personnel_area', $personnel_area);
        $this->db->where('start_date <=', $date);
        $this->db->where('end_date >=', $date);
        $office_loc = $this->db->get()->result();

        foreach ($office_loc as $area) {

            // pastikan latitude & longitude valid
            if (!is_numeric($area->lattitude) || !is_numeric($area->longitude)) {
                continue;
            }

            $latFrom = deg2rad((float)$area->lattitude);
            $lonFrom = deg2rad((float)$area->longitude);
            $latTo   = deg2rad($lat_in);
            $lonTo   = deg2rad($long_in);

            // hitung jarak menggunakan rumus haversine
            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(
                pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
            ));

            $distance = $angle * 6371000; // radius bumi dalam meter

            $luas_area = is_numeric($area->radius) ? (float)$area->radius : 0;

            // cek apakah posisi dalam radius
            if ($luas_area >= $distance) {
                return [
                    'status' => TRUE,
                    'location_code' => TRUE,
                    'address'       => $area->address,
                    'desc'          => "Office Area",
                    'message'       => "Office Area"
                ];
            }
        }

        // hasil jika tidak ada area atau tidak dalam radius
        if (empty($office_loc)) {
            return [
                'status' => FALSE,
                'location_code' => FALSE,
                'address'       => 'Unknown',
                'desc'          => "No Office Set, Please Contact HR Support",
                'message'       => "Unauthorized office location. Please contact HR Support to update your assigned workplace."
            ];
        } else {
            return [
                'status' => FALSE,
                'location_code' => FALSE,
                'address'       => 'Unknown',
                'desc'          => "Non Office Area",
                'message'       => "You are outside the designated office area."
            ];
        }

        // // cek apakah posisi dalam radius
        //     if ($luas_area >= $distance) {
        //         return [
        //             'location_code' => TRUE,
        //             'address'       => $area->address,
        //             'desc'          => "Office Area"
        //         ];
        //     }
        // }

        // // hasil jika tidak ada area atau tidak dalam radius
        // if (empty($office_loc)) {
        //     return [
        //         'location_code' => FALSE,
        //         'address'       => 'Unknown',
        //         'desc'          => "No Office Set, Please Contact HR Support"
        //     ];
        // } else {
        //     return [
        //         'location_code' => FALSE,
        //         'address'       => 'Unknown',
        //         'desc'          => "Non Office Area"
        //     ];
        // }
    }


    public function getPaEmployee($nik){

        $sqlEmployee = "SELECT personnel_area FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
        $resultEmp = $this->db->query($sqlEmployee);
        $resPA = $resultEmp->result_array()[0];
        $pa = decrypt($resPA['personnel_area']);

        return $pa;
    }
    
    public function get_last_presensi($data){

        $nik                = $data['nik'];
        $start_date         = date('Y-m-d');
        $end_date           = date('Y-m-d');

        $sql = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->result();
        
        if($data){
            foreach ($data as $key => $value) {
                $data_array = array(     
                    'nik'               => $value->employee_id,   
                    'full_name'         => $value->full_name,    
                    'date'              => $value->date, 
                    'dws'               => $value->dws, 
                    'schedule_code'     => $value->schedule_code,
                    'attendence_code'   => ($value->attendence_code != NULL? $value->attendence_code : " - "),
                    'time_off_code'     => ($value->time_off_code != NULL? $value->time_off_code : " - "),
                    'schedule_in'       => $value->schedule_in,
                    'schedule_out'      => $value->schedule_out,
                    'check_in'          => ($value->schedule_code == 'DO'? ' - ': ($value->check_in != NULL? $value->check_in : 'N/A')),
                    'check_in_date'     => ($value->check_in_date != NULL? $value->check_in_date : " - "),
                    'check_in_location' => ($value->check_in_location != NULL? $value->check_in_location : " - "),
                    'lat_in'            => ($value->lat_in != NULL? $value->lat_in : " - "),
                    'long_in'           => ($value->long_in != NULL? $value->long_in : " - "),
                    'check_out'         => ($value->schedule_code == 'DO'? ' - ': ($value->check_out != NULL? $value->check_out : 'N/A')),
                    'check_out_date'    => ($value->check_out_date != NULL? $value->check_out_date : " - "),
                    'check_out_location'=> ($value->check_out_location != NULL? $value->check_out_location : " - "),
                    'lat_out'           => ($value->lat_out != NULL? $value->lat_out : " - "),
                    'long_out'          => ($value->long_out != NULL? $value->long_out : " - "),
                );
                $data_schedule[] = $data_array;
            }
            return $data_schedule;
        }else{
            return false;
        }
    }
    
    public function get_list_presensi($data){

        $nik                = $data['nik'];
        $start_date         = date('Y-m-d',strtotime("-4 day"));
        $end_date           = date('Y-m-d');

        $sql = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC";
		$query = $this->db->query($sql);
		$data = $query->result();
        
        if($data){
            foreach ($data as $key => $value) {
                $data_array = array(     
                    'nik'               => $value->employee_id,   
                    'full_name'         => $value->full_name,    
                    'date'              => $value->date, 
                    'dws'               => $value->dws, 
                    'schedule_code'     => $value->schedule_code,
                    'attendence_code'   => ($value->attendence_code != NULL? $value->attendence_code : " - "),
                    'time_off_code'     => ($value->time_off_code != NULL? $value->time_off_code : " - "),
                    'schedule_in'       => $value->schedule_in,
                    'schedule_out'      => $value->schedule_out,
                    'check_in'          => ($value->schedule_code == 'DO'? ' - ': ($value->check_in != NULL? $value->check_in : 'N/A')),
                    'check_in_date'     => ($value->check_in_date != NULL? $value->check_in_date : " - "),
                    'check_in_location' => ($value->check_in_location != NULL? $value->check_in_location : " - "),
                    'lat_in'            => ($value->lat_in != NULL? $value->lat_in : " - "),
                    'long_in'           => ($value->long_in != NULL? $value->long_in : " - "),
                    'check_out'         => ($value->schedule_code == 'DO'? ' - ': ($value->check_out != NULL? $value->check_out : 'N/A')),
                    'check_out_date'    => ($value->check_out_date != NULL? $value->check_out_date : " - "),
                    'check_out_location'=> ($value->check_out_location != NULL? $value->check_out_location : " - "),
                    'lat_out'           => ($value->lat_out != NULL? $value->lat_out : " - "),
                    'long_out'          => ($value->long_out != NULL? $value->long_out : " - "),
                );
                $data_schedule[] = $data_array;
            }
            return $data_schedule;
        }else{
            return false;
        }
    }
    
    public function get_last_presensi2($data){

        $nik                = $data['nik'];
        $start_date         = $data['start_date'];
        $end_date           = $data['end_date'];
        $month              = $data['month'];

        if(empty($month)){
            if(empty($start_date) || $start_date == ''){
                $start_date         = date('Y-m-d',strtotime("-4 day"));
                $end_date           = date('Y-m-d');
            }
        }else{
            $start_date = $this->firstDay($month);
            $end_date   = $this->lastDay($month);
        }

        $sql = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC";
		$query = $this->db->query($sql);
		$data = $query->result();
        
        if($data){
            foreach ($data as $key => $value) {
                $data_array = array(     
                    'nik'               => $value->employee_id,   
                    'full_name'         => $value->full_name,    
                    'date'              => $value->date, 
                    'dws'               => $value->dws, 
                    'schedule_code'     => $value->schedule_code,
                    'attendence_code'   => ($value->attendence_code != NULL? $value->attendence_code : " - "),
                    'time_off_code'     => ($value->time_off_code != NULL? $value->time_off_code : " - "),
                    'schedule_in'       => $value->schedule_in,
                    'schedule_out'      => $value->schedule_out,
                    'check_in'          => ($value->schedule_code == 'DO'? ' - ': ($value->check_in != NULL? $value->check_in : 'N/A')),
                    'check_in_date'     => ($value->check_in_date != NULL? $value->check_in_date : " - "),
                    'check_in_location' => ($value->check_in_location != NULL? $value->check_in_location : " - "),
                    'lat_in'            => ($value->lat_in != NULL? $value->lat_in : " - "),
                    'long_in'           => ($value->long_in != NULL? $value->long_in : " - "),
                    'check_out'         => ($value->schedule_code == 'DO'? ' - ': ($value->check_out != NULL? $value->check_out : 'N/A')),
                    'check_out_date'    => ($value->check_out_date != NULL? $value->check_out_date : " - "),
                    'check_out_location'=> ($value->check_out_location != NULL? $value->check_out_location : " - "),
                    'lat_out'           => ($value->lat_out != NULL? $value->lat_out : " - "),
                    'long_out'          => ($value->long_out != NULL? $value->long_out : " - "),
                );
                $data_schedule[] = $data_array;
            }
            return $data_schedule;
        }else{
            return false;
        }
    }

    public function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
        $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                        : DateTimeZone::listIdentifiers();
    
        if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {
    
            $time_zone = '';
            $tz_distance = 0;
    
            //only one identifier?
            if (count($timezone_ids) == 1) {
                $time_zone = $timezone_ids[0];
            } else {
    
                foreach($timezone_ids as $timezone_id) {
                    $timezone = new DateTimeZone($timezone_id);
                    $location = $timezone->getLocation();
                    $tz_lat   = $location['latitude'];
                    $tz_long  = $location['longitude'];
    
                    $theta    = $cur_long - $tz_long;
                    $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) 
                    + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                    $distance = acos($distance);
                    $distance = abs(rad2deg($distance));
                    // echo '<br />'.$timezone_id.' '.$distance; 
    
                    if (!$time_zone || $tz_distance > $distance) {
                        $time_zone   = $timezone_id;
                        $tz_distance = $distance;
                    } 
    
                }
            }
            return  $time_zone;
        }
        return 'unknown';
    }
    
    public function update_presensiFIX($data){

        $nik        = $data['nik'];
        $date       = date("Y-m-d");
        $location   = str_replace("'", "", $data['address']);
        $lat        = $data['latitude'];
        $long       = $data['longitude'];
        $timezone   = $this->get_nearest_timezone($lat, $long, "ID");
        $time       = new DateTime("now", new DateTimeZone($timezone)); 
        $clock_sv   = $time->format('H:i:s');
        // $clock_sv   = date("H:i");
        $last_date  = date('Y-m-d',strtotime("-1 day"));
        
        $sql_ls        = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date LIKE '$last_date'";
		$query_ls      = $this->db->query($sql_ls);
        if(!$query_ls){
            $errMess = $this->db->error()['message'];
            return $errMess;
        }
		$data_sc_ls    = $query_ls->result()[0];

        $sql_td        = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date LIKE '$date'";
        $query_td      = $this->db->query($sql_td);
        if(!$query_td){
            $errMess = $this->db->error()['message'];
            return $errMess;
        }
        $data_sc_td    = $query_td->result()[0];

        $originalTime = new DateTime($data_sc_ls->schedule_out);
        $targetTime = new DateTime($data_sc_td->schedule_in);
        $interval = $originalTime->diff($targetTime);
        $inter = $interval->format("%H:%I:%S");
        
        list($hours, $minutes) = explode(":", $inter);
        $minutes += $hours*60;
        $seconds = $minutes*60;
        $total_menit = abs(($seconds/2)/60);
        $finalTime = date("H:i:s", strtotime('+'.$total_menit.' minutes', strtotime($data_sc_ls->schedule_out)));

        $timeoff_code = strtotime($finalTime);
        $timeoffsv_code = strtotime($clock_sv);
        $timeoff = date('H:i:s', $timeoff_code);
        

        if($data_sc_ls->schedule_code != 'DO' && $data_sc_ls->schedule_code != 'DON'){

            if(($data_sc_ls->schedule_in > $data_sc_ls->schedule_out) && (strtotime($data_sc_ls->date) < strtotime($date))){

                if($data_sc_ls->check_in == NULL && $data_sc_ls->check_in == '' && (empty($data_sc_ls->check_in)  && ($timeoff_code > $timeoffsv_code))){

                    // dumper('Update SHIFT Clock In Schedule last date');
                    $attendence_code ="";
                    $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$last_date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check in data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }elseif($data_sc_ls->check_out == NULL && $data_sc_ls->check_out == '' && (empty($data_sc_ls->check_out) && ($timeoff_code > $timeoffsv_code))){

                    // dumper('Update SHIFT Clock Out Schedule last date');
                    $attendence_code = "H";

                    // ambil check_in terlebih dahulu
                    $get = $this->db->query("SELECT check_in FROM hris_master_time_management 
                                            WHERE employee_id = '$nik' AND date ='$last_date'")->row();

                    if ($get) {

                        $check_in  = strtotime($get->check_in);
                        $check_out = strtotime($clock_sv);

                        // hitung selisih jam
                        $working_hours_d = ($check_out - $check_in) / 3600;
                        $working_hours_d = round($working_hours_d, 2);

                        $sql = "UPDATE hris_master_time_management 
                                SET check_out = '$clock_sv',
                                    check_out_date = '$date',
                                    check_out_location = '$location',
                                    lat_out = '$lat',
                                    long_out = '$long',
                                    attendence_code = '$attendence_code',
                                    working_hours_d = '$working_hours_d',
                                    flag = 1
                                WHERE employee_id = '$nik' 
                                AND date = '$last_date'";

                        $query = $this->db->query($sql);

                        if ($query) {
                            return 'You have successfully updated your check out data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }

                    } else {
                        return 'Check-in data not found';
                    }

                }elseif($data_sc_ls->check_out != NULL && $data_sc_ls->check_out != '' && (!empty($data_sc_ls->check_out) && ($timeoff_code > $timeoffsv_code))){

                    // dumper('Update SHIFT Clock Out Schedule last date');
                    $attendence_code = "H";

                    // ambil data check_in
                    $get = $this->db->query("SELECT check_in FROM hris_master_time_management 
                                            WHERE employee_id = '$nik' AND date ='$last_date'")->row();

                    if ($get) {

                        $check_in  = strtotime($last_date . ' ' . $get->check_in);
                        $check_out = strtotime($date . ' ' . $clock_sv);

                        // hitung selisih jam
                        $working_hours_d = ($check_out - $check_in) / 3600;
                        $working_hours_d = round($working_hours_d, 2);

                        $sql = "UPDATE hris_master_time_management 
                                SET check_out = '$clock_sv',
                                    check_out_date = '$date',
                                    check_out_location = '$location',
                                    lat_out = '$lat',
                                    long_out = '$long',
                                    attendence_code = '$attendence_code',
                                    working_hours_d = '$working_hours_d',
                                    flag = 1
                                WHERE employee_id = '$nik' 
                                AND date ='$last_date'";

                        $query = $this->db->query($sql);

                        if ($query) {
                            return 'You have successfully updated your check out data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }

                    } else {
                        return 'Check-in data not found';
                    }

                }else{

                    if(($data_sc_td->check_in == NULL && $data_sc_td->check_in == '' && (empty($data_sc_td->check_in)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                        // dumper('Update Clock In Schedule today1');
                        $attendence_code ="";
                        $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                        $query = $this->db->query($sql);
                        if($query){
                            return 'You have successfully updated your check in data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }
                    }elseif(($data_sc_td->check_out == NULL && $data_sc_td->check_out == '' && (empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){
    
                        // dumper('Update Clock Out Schedule today1');
                        $attendence_code = "H";

                        // ambil check_in
                        $get = $this->db->query("SELECT check_in FROM hris_master_time_management 
                                                WHERE employee_id = '$nik' AND date = '$date'")->row();

                        if ($get) {

                            $check_in  = strtotime($date . ' ' . $get->check_in);
                            $check_out = strtotime($date . ' ' . $clock_sv);

                            // hitung working hours
                            $working_hours_d = ($check_out - $check_in) / 3600;
                            $working_hours_d = round($working_hours_d, 2);

                            $sql = "UPDATE hris_master_time_management 
                                    SET check_out = '$clock_sv',
                                        check_out_date = '$date',
                                        check_out_location = '$location',
                                        lat_out = '$lat',
                                        long_out = '$long',
                                        attendence_code = '$attendence_code',
                                        working_hours_d = '$working_hours_d',
                                        flag = 1
                                    WHERE employee_id = '$nik' 
                                    AND date = '$date'";

                            $query = $this->db->query($sql);

                            if ($query) {
                                return 'You have successfully updated your check out data';
                            } else {
                                $errMess = $this->db->error()['message'];
                                return $errMess;
                            }

                        } else {
                            return 'Check-in data not found';
                        }
                    }elseif(($data_sc_td->check_in != NULL && $data_sc_td->check_in != '' && (!empty($data_sc_td->check_in)) && ($data_sc_td->check_out != NULL && $data_sc_td->check_out != '' && (!empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON')))){

                        // dumper('Update Clock Out Schedule today2');
                        $attendence_code = "H";

                        // ambil data check_in terlebih dahulu
                        $get = $this->db->query("SELECT check_in 
                                                FROM hris_master_time_management 
                                                WHERE employee_id = '$nik' 
                                                AND date = '$date'")->row();

                        if ($get) {

                            $check_in  = strtotime($date . ' ' . $get->check_in);
                            $check_out = strtotime($date . ' ' . $clock_sv);

                            // hitung working hours
                            $working_hours_d = ($check_out - $check_in) / 3600;
                            $working_hours_d = round($working_hours_d, 2);

                            $sql = "UPDATE hris_master_time_management 
                                    SET check_out = '$clock_sv',
                                        check_out_date = '$date',
                                        check_out_location = '$location',
                                        lat_out = '$lat',
                                        long_out = '$long',
                                        attendence_code = '$attendence_code',
                                        working_hours_d = '$working_hours_d',
                                        flag = 1
                                    WHERE employee_id = '$nik' 
                                    AND date = '$date'";

                            $query = $this->db->query($sql);

                            if ($query) {
                                return 'You have successfully updated your check out data';
                            } else {
                                $errMess = $this->db->error()['message'];
                                return $errMess;
                            }

                        } else {
                            return 'Check-in data not found';
                        }

                    }else{
    
                        return 'NO SCHEDULED 1';
    
                    }
                    
                }
            }else{

                if(($data_sc_td->check_in == NULL && $data_sc_td->check_in == '' && (empty($data_sc_td->check_in)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                    // dumper('Update Clock In Schedule today2');
                    $attendence_code ="";
                    $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check in data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }elseif(($data_sc_td->check_out == NULL && $data_sc_td->check_out == '' && (empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                    // dumper('Update Clock Out Schedule today2');
                    $attendence_code = "H";

                    // ambil check_in terlebih dahulu
                    $get = $this->db->query("SELECT check_in 
                                            FROM hris_master_time_management 
                                            WHERE employee_id = '$nik' 
                                            AND date = '$date'")->row();

                    if ($get) {

                        $check_in  = strtotime($date . ' ' . $get->check_in);
                        $check_out = strtotime($date . ' ' . $clock_sv);

                        // hitung working hours
                        $working_hours_d = ($check_out - $check_in) / 3600;
                        $working_hours_d = round($working_hours_d, 2);

                        $sql = "UPDATE hris_master_time_management 
                                SET check_out = '$clock_sv',
                                    check_out_date = '$date',
                                    check_out_location = '$location',
                                    lat_out = '$lat',
                                    long_out = '$long',
                                    attendence_code = '$attendence_code',
                                    working_hours_d = '$working_hours_d',
                                    flag = 1
                                WHERE employee_id = '$nik' 
                                AND date = '$date'";

                        $query = $this->db->query($sql);

                        if ($query) {
                            return 'You have successfully updated your check out data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }

                    } else {
                        return 'Check-in data not found';
                    }

                }elseif(($data_sc_td->check_in != NULL && $data_sc_td->check_in != '' && (!empty($data_sc_td->check_in)) && ($data_sc_td->check_out != NULL && $data_sc_td->check_out != '' && (!empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON')))){

                    // dumper('Update Clock Out Schedule today2');
                    $attendence_code = "H";

                    // ambil check_in dulu
                    $get = $this->db->query("SELECT check_in 
                                            FROM hris_master_time_management 
                                            WHERE employee_id = '$nik' 
                                            AND date = '$date'")->row();

                    if ($get) {

                        $check_in  = strtotime($date . ' ' . $get->check_in);
                        $check_out = strtotime($date . ' ' . $clock_sv);

                        // hitung working_hours dalam jam
                        $working_hours_d = ($check_out - $check_in) / 3600;
                        $working_hours_d = round($working_hours_d, 2);

                        $sql = "UPDATE hris_master_time_management 
                                SET check_out = '$clock_sv',
                                    check_out_date = '$date',
                                    check_out_location = '$location',
                                    lat_out = '$lat',
                                    long_out = '$long',
                                    attendence_code = '$attendence_code',
                                    working_hours_d = '$working_hours_d',
                                    flag = 1
                                WHERE employee_id = '$nik' 
                                AND date = '$date'";

                        $query = $this->db->query($sql);

                        if ($query) {
                            return 'You have successfully updated your check out data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }

                    } else {
                        return 'Check-in data not found';
                    }

                }else{

                    return 'NO SCHEDULED 2';

                }

            }


        }else{

            if(($data_sc_td->check_in == NULL && $data_sc_td->check_in == '' && (empty($data_sc_td->check_in)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                // dumper('Update Clock In Schedule today3');
                $attendence_code ="";
                $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                $query = $this->db->query($sql);
                if($query){
                    return 'You have successfully updated your check in data';
                } else {
                    $errMess = $this->db->error()['message'];
                    return $errMess;
                }
            }elseif(($data_sc_td->check_out == NULL && $data_sc_td->check_out == '' && (empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                // dumper('Update Clock Out Schedule today3');
                $attendence_code = "H";

                // ambil check_in terlebih dahulu
                $get = $this->db->query("SELECT check_in 
                                        FROM hris_master_time_management 
                                        WHERE employee_id = '$nik' 
                                        AND date = '$date'")->row();

                if ($get) {

                    $check_in  = strtotime($date . ' ' . $get->check_in);
                    $check_out = strtotime($date . ' ' . $clock_sv);

                    // hitung working_hours dalam jam
                    $working_hours_d = ($check_out - $check_in) / 3600;
                    $working_hours_d = round($working_hours_d, 2);

                    $sql = "UPDATE hris_master_time_management 
                            SET check_out = '$clock_sv',
                                check_out_date = '$date',
                                check_out_location = '$location',
                                lat_out = '$lat',
                                long_out = '$long',
                                attendence_code = '$attendence_code',
                                working_hours_d = '$working_hours_d',
                                flag = 1
                            WHERE employee_id = '$nik' 
                            AND date = '$date'";

                    $query = $this->db->query($sql);

                    if ($query) {
                        return 'You have successfully updated your check out data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }

                } else {
                    return 'Check-in data not found';
                }

            }elseif(($data_sc_td->check_in != NULL && $data_sc_td->check_in != '' && (!empty($data_sc_td->check_in)) && ($data_sc_td->check_out != NULL && $data_sc_td->check_out != '' && (!empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON')))){

                // dumper('Update Clock Out Schedule today2');
                $attendence_code = "H";

                // ambil check_in terlebih dahulu
                $get = $this->db->query("SELECT check_in 
                                        FROM hris_master_time_management 
                                        WHERE employee_id = '$nik' 
                                        AND date = '$date'")->row();

                if ($get) {

                    $check_in  = strtotime($date . ' ' . $get->check_in);
                    $check_out = strtotime($date . ' ' . $clock_sv);

                    // hitung working_hours dalam jam, 2 digit
                    $working_hours_d = ($check_out - $check_in) / 3600;
                    $working_hours_d = round($working_hours_d, 2);

                    $sql = "UPDATE hris_master_time_management 
                            SET check_out = '$clock_sv',
                                check_out_date = '$date',
                                check_out_location = '$location',
                                lat_out = '$lat',
                                long_out = '$long',
                                attendence_code = '$attendence_code',
                                working_hours_d = '$working_hours_d',
                                flag = 1
                            WHERE employee_id = '$nik' 
                            AND date = '$date'";

                    $query = $this->db->query($sql);

                    if ($query) {
                        return 'You have successfully updated your check out data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }

                } else {
                    return 'Check-in data not found';
                }
                
            }else{

                return 'NO SCHEDULED 3';

            }

        }

        // if (!empty($lat_in)){
        //     $check_in =    $time_in;
        //     $date_in =     $date_in;
        //     if (!empty($time_out) && $time_out != NULL && $time_out != "NULL" && $time_out != ""){
        //         $check_out     =    $time_out;
        //         $date_out      =    $date_out;
        //         $attendence_code ="H";
        //         $check_in_location = str_replace("'", "", $check_in_location);
        //         $check_out_location = str_replace("'", "", $check_out_location);
        //         $sql = "UPDATE hris_master_time_management SET check_in = '$check_in', check_in_date='$date_in', check_in_location = '$check_in_location', lat_in = '$lat_in', long_in='$long_in', lat_out='$lat_out', long_out='$long_out', check_out = '$check_out', check_out_date='$date_out', check_out_location = '$check_out_location', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
        //     } else {
        //         $attendence_code ="";
        //         $date_out = "";
        //         $check_out = "";
        //         $check_out_location = "";
        //         $check_in_location = str_replace("'", "", $check_in_location);
        //         $check_out_location = str_replace("'", "", $check_out_location);
        //         $sql = "UPDATE hris_master_time_management SET check_in = '$check_in', check_in_date='$date_in', check_in_location = '$check_in_location', lat_in = '$lat_in', long_in='$long_in', lat_out=NULL, long_out=NULL, check_out = NULL, check_out_date=NULL, check_out_location = '$check_out_location', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
        //     }
        //     $query = $this->db->query($sql);
		//     $data = $query->result();

        // } else {
            
        // }
    }
    
    public function update_presensi2($data){

        $nik        = $data['nik'];
        $date       = date("Y-m-d");
        $location   = str_replace("'", "", $data['address']);
        $lat        = $data['latitude'];
        $long       = $data['longitude'];
        $timezone   = $this->get_nearest_timezone($lat, $long, "ID");
        $time       = new DateTime("now", new DateTimeZone($timezone)); 
        $clock_sv   = $time->format('H:i:s');
        // $clock_sv   = date("H:i");
        $last_date  = date('Y-m-d',strtotime("-1 day"));
        
        $sql_ls        = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date LIKE '$last_date'";
		$query_ls      = $this->db->query($sql_ls);
        if(!$query_ls){
            $errMess = $this->db->error()['message'];
            return $errMess;
        }
		$data_sc_ls    = $query_ls->result()[0];

        $sql_td        = "SELECT *  FROM hris_master_time_management WHERE employee_id LIKE '$nik' AND date LIKE '$date'";
        $query_td      = $this->db->query($sql_td);
        if(!$query_td){
            $errMess = $this->db->error()['message'];
            return $errMess;
        }
        $data_sc_td    = $query_td->result()[0];

        $originalTime = new DateTime($data_sc_ls->schedule_out);
        $targetTime = new DateTime($data_sc_td->schedule_in);
        $interval = $originalTime->diff($targetTime);
        $inter = $interval->format("%H:%I:%S");
        
        list($hours, $minutes) = explode(":", $inter);
        $minutes += $hours*60;
        $seconds = $minutes*60;
        $total_menit = abs(($seconds/2)/60);
        $finalTime = date("H:i:s", strtotime('+'.$total_menit.' minutes', strtotime($data_sc_ls->schedule_out)));

        $timeoff_code = strtotime($finalTime);
        $timeoffsv_code = strtotime($clock_sv);
        $timeoff = date('H:i:s', $timeoff_code);
        // dumper($timeoff_code.' - '.$timeoffsv_code.' - '.$finalTime);

        if($data_sc_ls->schedule_code != 'DO' && $data_sc_ls->schedule_code != 'DON'){

            if(($data_sc_ls->schedule_in > $data_sc_ls->schedule_out) && (strtotime($data_sc_ls->date) < strtotime($date))){

                if($data_sc_ls->check_in == NULL && $data_sc_ls->check_in == '' && (empty($data_sc_ls->check_in)  && ($timeoff_code > $timeoffsv_code))){

                    // dumper('Update SHIFT Clock In Schedule last date');
                    $attendence_code ="";
                    $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$last_date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check in data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }elseif($data_sc_ls->check_out == NULL && $data_sc_ls->check_out == '' && (empty($data_sc_ls->check_out) && ($timeoff_code > $timeoffsv_code))){

                    dumper('Update SHIFT Clock Out Schedule last date');
                    $attendence_code ="H";
                    $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$last_date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check out data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }elseif($data_sc_ls->check_out != NULL && $data_sc_ls->check_out != '' && (!empty($data_sc_ls->check_out) && ($timeoff_code > $timeoffsv_code))){

                    dumper('Update SHIFT Clock Out Schedule last date');
                    $attendence_code ="H";
                    $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$last_date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check out data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }else{

                    if(($data_sc_td->check_in == NULL && $data_sc_td->check_in == '' && (empty($data_sc_td->check_in)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                        dumper('Update Clock In Schedule today1');
                        $attendence_code ="";
                        $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                        $query = $this->db->query($sql);
                        if($query){
                            return 'You have successfully updated your check in data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }
                    }elseif(($data_sc_td->check_out == NULL && $data_sc_td->check_out == '' && (empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){
    
                        dumper('Update Clock Out Schedule today1');
                        $attendence_code ="H";
                        $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                        $query = $this->db->query($sql);
                        if($query){
                            return 'You have successfully updated your check out data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }
                    }elseif(($data_sc_td->check_in != NULL && $data_sc_td->check_in != '' && (!empty($data_sc_td->check_in)) && ($data_sc_td->check_out != NULL && $data_sc_td->check_out != '' && (!empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON')))){

                        dumper('Update Clock Out Schedule today2');
                        $attendence_code ="H";
                        $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                        $query = $this->db->query($sql);
                        if($query){
                            return 'You have successfully updated your check out data';
                        } else {
                            $errMess = $this->db->error()['message'];
                            return $errMess;
                        }
                    }else{
    
                        return 'NO SCHEDULED 1';
    
                    }
                    
                }
            }else{

                if(($data_sc_td->check_in == NULL && $data_sc_td->check_in == '' && (empty($data_sc_td->check_in)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                    dumper('Update Clock In Schedule today2');
                    $attendence_code ="";
                    $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check in data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }elseif(($data_sc_td->check_out == NULL && $data_sc_td->check_out == '' && (empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                    dumper('Update Clock Out Schedule today2');
                    $attendence_code ="H";
                    $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check out data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }elseif(($data_sc_td->check_in != NULL && $data_sc_td->check_in != '' && (!empty($data_sc_td->check_in)) && ($data_sc_td->check_out != NULL && $data_sc_td->check_out != '' && (!empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON')))){

                    dumper('Update Clock Out Schedule today2');
                    $attendence_code ="H";
                    $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                    $query = $this->db->query($sql);
                    if($query){
                        return 'You have successfully updated your check out data';
                    } else {
                        $errMess = $this->db->error()['message'];
                        return $errMess;
                    }
                }else{

                    return 'NO SCHEDULED 2';

                }

            }


        }else{

            if(($data_sc_td->check_in == NULL && $data_sc_td->check_in == '' && (empty($data_sc_td->check_in)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                dumper('Update Clock In Schedule today3');
                $attendence_code ="";
                $sql = "UPDATE hris_master_time_management SET check_in = '$clock_sv', check_in_date='$date', check_in_location = '$location', lat_in = '$lat', long_in='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                $query = $this->db->query($sql);
                if($query){
                    return 'You have successfully updated your check in data';
                } else {
                    $errMess = $this->db->error()['message'];
                    return $errMess;
                }
            }elseif(($data_sc_td->check_out == NULL && $data_sc_td->check_out == '' && (empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON'))){

                dumper('Update Clock Out Schedule today3');
                $attendence_code ="H";
                $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                $query = $this->db->query($sql);
                if($query){
                    return 'You have successfully updated your check out data';
                } else {
                    $errMess = $this->db->error()['message'];
                    return $errMess;
                }
            }elseif(($data_sc_td->check_in != NULL && $data_sc_td->check_in != '' && (!empty($data_sc_td->check_in)) && ($data_sc_td->check_out != NULL && $data_sc_td->check_out != '' && (!empty($data_sc_td->check_out)) && ($data_sc_td->schedule_code != 'DO' && $data_sc_td->schedule_code != 'DON')))){

                dumper('Update Clock Out Schedule today2');
                $attendence_code ="H";
                $sql = "UPDATE hris_master_time_management SET check_out = '$clock_sv', check_out_date='$date', check_out_location = '$location', lat_out = '$lat', long_out='$long', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
                $query = $this->db->query($sql);
                if($query){
                    return 'You have successfully updated your check out data';
                } else {
                    $errMess = $this->db->error()['message'];
                    return $errMess;
                }
            }else{

                return 'NO SCHEDULED 3';

            }

        }

        // if (!empty($lat_in)){
        //     $check_in =    $time_in;
        //     $date_in =     $date_in;
        //     if (!empty($time_out) && $time_out != NULL && $time_out != "NULL" && $time_out != ""){
        //         $check_out     =    $time_out;
        //         $date_out      =    $date_out;
        //         $attendence_code ="H";
        //         $check_in_location = str_replace("'", "", $check_in_location);
        //         $check_out_location = str_replace("'", "", $check_out_location);
        //         $sql = "UPDATE hris_master_time_management SET check_in = '$check_in', check_in_date='$date_in', check_in_location = '$check_in_location', lat_in = '$lat_in', long_in='$long_in', lat_out='$lat_out', long_out='$long_out', check_out = '$check_out', check_out_date='$date_out', check_out_location = '$check_out_location', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
        //     } else {
        //         $attendence_code ="";
        //         $date_out = "";
        //         $check_out = "";
        //         $check_out_location = "";
        //         $check_in_location = str_replace("'", "", $check_in_location);
        //         $check_out_location = str_replace("'", "", $check_out_location);
        //         $sql = "UPDATE hris_master_time_management SET check_in = '$check_in', check_in_date='$date_in', check_in_location = '$check_in_location', lat_in = '$lat_in', long_in='$long_in', lat_out=NULL, long_out=NULL, check_out = NULL, check_out_date=NULL, check_out_location = '$check_out_location', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
        //     }
        //     $query = $this->db->query($sql);
		//     $data = $query->result();

        // } else {
            
        // }
    }

    public function getVersionAndroid($ver_android){
        
        $sqlEmployee = "SELECT * FROM hris_master_arv WHERE version_number LIKE '$ver_android' AND status = 1";
        $result = $this->db->query($sqlEmployee);
        $version = $result->result_array();
        if($version){
            return $version;
        }else {            
            return false;
        }
        
    }
    
    public function getInfoMobile(){
        $today      = date("Y-m-d");
        $sqlInfo    = "SELECT * FROM information WHERE start_date <= '$today' AND end_date >= '$today' ORDER BY id DESC LIMIT 1";
        $result     = $this->db->query($sqlInfo);
        $info       = $result->result_array();
        if($info){
            return $info;
        }else{
            $data = array(
                  'id' => 'XX',
                  'info' => '',
                  'start_date' => '0000-00-00',
                  'end_date' => '0000-00-00',
                  'status' => '0',
                  'created_at' => 'No Information',
                  'created_by' => 'No Information'
                    );
            $info[] = $data;
            return $info;
        }
        
    }

    function lastDay($month = '', $year = '') 
    {
        if (empty($month)) {
           $month = date('m');
        }
        if (empty($year)) {
           $year = date('Y');
        }
        $result = strtotime("{$year}-{$month}-01");
        $result = strtotime('-1 second', strtotime('+1 month', $result));
        return date('Y-m-d', $result);
    }

    function firstDay($month = '', $year = '')
    {
        if (empty($month)) {
            $month = date('m');
        }
        if (empty($year)) {
            $year = date('Y');
        }
        $result = strtotime("{$year}-{$month}-01");
        return date('Y-m-d', $result);
    }
    
    

    //////////////////////Start Update Absen 2026///////////////////////////////
    public function update_presensi($data)
    {
        $nik        = $data['nik'];
        if (!empty($data['date'])) {
            $date = $data['date'];
        } else {
            $date = date("Y-m-d");
        }

        $last_date = date('Y-m-d', strtotime($date . ' -1 day'));


        $location   = str_replace("'", "", $data['address']);
        $lat        = $data['latitude'];
        $long       = $data['longitude'];

        $timezone   = $this->get_nearest_timezone($lat, $long, "ID");
        $time       = new DateTime("now", new DateTimeZone($timezone));
        $clock_sv   = $time->format('H:i:s');

        // // ======================
        // // GET SCHEDULE VERSI LAMA
        // // ======================

        // $data_sc_ls = $this->getSchedule($nik,$last_date);
        // $data_sc_td = $this->getSchedule($nik,$date);

        // // ======================
        // // GET EMPLOYEE DATA
        // // ======================

        // $row = $this->db
        //     ->select('action, start_date')
        //     ->get_where('v_hris_employee_updated', ['nik' => $nik])
        //     ->row();

        // // default value
        // $action     = null;
        // $start_date = null;

        // if ($row) {
        //     $action     = decrypt($row->action);
        //     $start_date = date('Y-m-d', strtotime(decrypt($row->start_date)));
        // }
        
        // // ======================
        // // VALIDATION
        // // ======================

        // $today = date('Y-m-d');

        // // hiring today
        // $isHiringToday = (
        //     $action === 'Hiring' &&
        //     $start_date === $today
        // );

        // // Hiring today -> hanya perlu schedule today
        // if ($isHiringToday) {

        //     if (!$data_sc_td) {
        //         return "Schedule not found";
        //     }

        // }
        // // selain itu wajib last schedule & today schedule
        // else {

        //     if (!$data_sc_ls || !$data_sc_td) {
        //         return "Schedule not found";
        //     }
        // }

        // ======================
        // GET SCHEDULE VERSI BARU
        // ======================

        $data_sc_ls = $this->getSchedule($nik, $last_date);
        $data_sc_td = $this->getSchedule($nik, $date);

        // ======================
        // GET EMPLOYEE DATA
        // ======================

        $row = $this->db
            ->select('action, start_date')
            ->get_where('v_hris_employee_updated', ['nik' => $nik])
            ->row();

        // default value
        $action     = null;
        $start_date = null;

        if ($row) {
            $action     = decrypt($row->action);
            $start_date = date('Y-m-d', strtotime(decrypt($row->start_date)));
        }

        // ======================
        // VALIDATION
        // ======================

        $today = date('Y-m-d');
        $now   = time();

        // hiring today
        $isHiringToday = (
            $action === 'Hiring' &&
            $start_date === $today
        );

        // ======================
        // CHECK CONTINUE SHIFT
        // ======================

        $allowByLastShift = false;

        if ($data_sc_ls) {

            $scheduleIn  = $data_sc_ls->schedule_in;
            $scheduleOut = $data_sc_ls->schedule_out;

            // cross-day shift
            // contoh:
            // in  = 20:00
            // out = 07:00
            if ($scheduleOut < $scheduleIn) {

                // shift start datetime
                $shiftStart = strtotime(
                    $data_sc_ls->date . ' ' . $scheduleIn
                );

                // shift end = besok
                $shiftEnd = strtotime(
                    date(
                        'Y-m-d',
                        strtotime($data_sc_ls->date . ' +1 day')
                    ) . ' ' . $scheduleOut
                );

                // sekarang masih dalam shift kemarin
                if ($now >= $shiftStart && $now <= $shiftEnd) {
                    $allowByLastShift = true;
                }
            }
        }

        // ======================
        // FINAL VALIDATION
        // ======================

        // Hiring today -> hanya perlu schedule today
        if ($isHiringToday) {

            if (!$data_sc_td) {
                return [
                    'status' => FALSE,
                    'message' => "Schedule not found"
                ];
                // return "Schedule not found";
            }

        }
        // selain itu
        else {

            // valid jika:
            // - ada schedule today
            // ATAU
            // - masih continuation shift kemarin
            if (!$data_sc_td && !$allowByLastShift) {
                // return "Schedule not found";
                return [
                    'status' => FALSE,
                    'message' => "Schedule not found"
                ];
            }
        }

        // ======================
        // TIMEOFF CALCULATION
        // ======================

        $timeoff_code   = $this->calculateTimeoff($data_sc_ls,$data_sc_td);
        $timeoffsv_code = strtotime($date.' '.$clock_sv);
        // $timeoffsv_code = strtotime($clock_sv);

        // ======================
        // START LOGIC
        // ======================

        if(!$this->isDayOff($data_sc_ls->schedule_code))
        {
            // SHIFT MALAM
            if(($data_sc_ls->schedule_in > $data_sc_ls->schedule_out) && (strtotime($data_sc_ls->date) < strtotime($date))){
                
                if(empty($data_sc_ls->check_in) && ($timeoff_code > $timeoffsv_code)){
                    
                    $this->updateCheckIn($nik,$last_date,$clock_sv,$location,$lat,$long);
                    // return "You have successfully updated your check in data";
                    return [
                        'status' => TRUE,
                        'message' => "You have successfully updated your check in data"
                    ];

                }elseif($timeoff_code > $timeoffsv_code){

                    $working_hours_d = $this->workingHoursD(
                        $last_date.' '.$data_sc_ls->check_in,
                        $date.' '.$clock_sv
                    );
                    $working_hours_t = $this->workingHoursT(
                        $last_date.' '.$data_sc_ls->check_in,
                        $date.' '.$clock_sv
                    );
                    
                    $this->updateCheckOut($nik,$last_date,$clock_sv,$date,$location,$lat,$long,$working_hours_d,$working_hours_t);
                    // return "You have successfully updated your check out data";
                    return [
                        'status' => TRUE,
                        'message' => "You have successfully updated your check out data"
                    ];

                }else{
                    return $this->processToday($data_sc_td,$nik,$date,$clock_sv,$location,$lat,$long);
                }
            }else{
                return $this->processToday($data_sc_td,$nik,$date,$clock_sv,$location,$lat,$long);
            }
        }else{
            return $this->processToday($data_sc_td,$nik,$date,$clock_sv,$location,$lat,$long);
        }
    }

    private function processToday($data_sc_td,$nik,$date,$clock_sv,$location,$lat,$long)
    {
        if(!$this->isDayOff($data_sc_td->schedule_code)){

            if(empty($data_sc_td->check_in)){
                $this->updateCheckIn($nik,$date,$clock_sv,$location,$lat,$long);
                // return "You have successfully updated your check in data";
                return [
                    'status' => TRUE,
                    'message' => "You have successfully updated your check in data"
                ];
            }else{

                $working_hours_d = $this->workingHoursD(
                    $date.' '.$data_sc_td->check_in,
                    $date.' '.$clock_sv
                );

                $working_hours_t = $this->workingHoursT(
                        $date.' '.$data_sc_td->check_in,
                        $date.' '.$clock_sv
                );
                $this->updateCheckOut($nik,$date,$clock_sv,$date,$location,$lat,$long,$working_hours_d,$working_hours_t);
                // return "You have successfully updated your check out data";
                return [
                    'status' => TRUE,
                    'message' => "You have successfully updated your check out data"
                ];
            }
        }

        // return "NO SCHEDULED TODAY";
        return [
            'status' => FALSE,
            'message' => "NO SCHEDULED TODAY"
        ];
    }

    private function getSchedule($nik,$date)
    {
        return $this->db
            ->where('employee_id',$nik)
            ->where('date',$date)
            ->get('hris_master_time_management')
            ->row();
    }

    private function isDayOff($code)
    {
        return in_array($code,['DO','DON']);
    }
    
    private function workingHoursD($check_in,$check_out)
    {
        //Untuk format jam desimal
        $in  = strtotime($check_in);
        $out = strtotime($check_out);

        return round(($out-$in)/3600,2);
    }

    private function workingHoursT($check_in,$check_out)
    {

        $in  = new DateTime($check_in);
        $out = new DateTime($check_out);
        $interval = $out->diff($in);

        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

    }

    private function updateCheckIn($nik,$date,$clock,$location,$lat,$long)
    {

        // $sql = "UPDATE hris_master_time_management 
        //         SET check_in='$clock',
        //         check_in_date='$date',
        //         check_in_location='$location',
        //         lat_in='$lat',
        //         long_in='$long',
        //         attendence_code='',
        //         flag=1
        //         WHERE employee_id='$nik'
        //         AND date='$date'";
        $sql = "UPDATE hris_master_time_management
                            SET 
                                check_in = '$clock',
                                check_in_date = '$date',
                                check_in_location = '$location',
                                lat_in = '$lat',
                                long_in = '$long',
                                attendence_code = '',
                                flag = 1,
                                attendance_status = CASE
                                    -- WHEN schedule_code IN ('N', 'NP') OR schedule_code LIKE 'SHF%' THEN
                                    WHEN schedule_code LIKE 'N%' OR schedule_code LIKE 'SHF%' THEN
                                        CASE
                                            WHEN TIME('$clock') <= DATE_ADD(STR_TO_DATE(schedule_in, '%H:%i:%s'), INTERVAL 0 MINUTE)
                                                THEN 'on_time'
                                            ELSE 'late'
                                        END
                                    ELSE attendance_status
                                END
                            WHERE 
                                employee_id = '$nik'
                                AND date = '$date'";

        $this->db->query($sql);
    }

    private function updateCheckOut($nik,$date,$clock,$clock_date,$location,$lat,$long,$working_hours_d,$working_hours_t)
    {

        $sql = "UPDATE hris_master_time_management 
                SET check_out='$clock',
                check_out_date='$clock_date',
                check_out_location='$location',
                lat_out='$lat',
                long_out='$long',
                attendence_code='H',
                working_hours_d='$working_hours_d',
                working_hours_t='$working_hours_t',
                flag=1
                WHERE employee_id='$nik'
                AND date='$date'";

        $this->db->query($sql);

    }

    // private function calculateTimeoff($data_sc_ls,$data_sc_td)
    // {

    //     $originalTime = new DateTime($data_sc_ls->schedule_out);
    //     $targetTime   = new DateTime($data_sc_td->schedule_in);

    //     $interval = $originalTime->diff($targetTime);
    //     $minutes = ($interval->h * 60) + $interval->i;
    //     $total_menit = abs($minutes / 2);

    //     $finalTime = date(
    //         "H:i:s",
    //         strtotime('+'.$total_menit.' minutes', strtotime($data_sc_ls->schedule_out))
    //     );

    //     return strtotime($finalTime);

    // }

    private function calculateTimeoff($data_sc_ls,$data_sc_td = null)
    {
        // schedule out shift lama
        $scheduleOut = new DateTime(
            $data_sc_ls->date.' '.$data_sc_ls->schedule_out
        );

        // jika shift malam
        if(strtotime($data_sc_ls->schedule_in) > strtotime($data_sc_ls->schedule_out)){
            $scheduleOut->modify('+1 day');
        }

        // =========================
        // JIKA BESOK LIBUR / KOSONG
        // =========================
        if(empty($data_sc_td) || empty($data_sc_td->schedule_in)){

            // beri toleransi misalnya 5 jam setelah shift out
            $scheduleOut->modify('+5 hours');

            return $scheduleOut->getTimestamp();
        }

        // =========================
        // JIKA ADA SHIFT BERIKUTNYA
        // =========================

        $nextScheduleIn = new DateTime(
            $data_sc_td->date.' '.$data_sc_td->schedule_in
        );

        $interval = $scheduleOut->diff($nextScheduleIn);

        $minutes = ($interval->h * 60) + $interval->i;

        $total_menit = abs($minutes / 2);

        $scheduleOut->modify('+'.$total_menit.' minutes');

        return $scheduleOut->getTimestamp();
    }

    // private function calculateTimeoff($data_sc_ls, $data_sc_td)
    // {
    //     // full datetime
    //     $schedule_out = strtotime(
    //         $data_sc_ls->date . ' ' . $data_sc_ls->schedule_out
    //     );

    //     $schedule_in = strtotime(
    //         $data_sc_td->date . ' ' . $data_sc_td->schedule_in
    //     );

    //     // kalau next day
    //     if ($schedule_in < $schedule_out) {
    //         $schedule_in = strtotime('+1 day', $schedule_in);
    //     }

    //     // selisih menit
    //     $diff_minutes = ($schedule_in - $schedule_out) / 60;

    //     // ambil setengahnya
    //     $half_minutes = abs($diff_minutes / 2);

    //     // final tolerance
    //     $final_time = strtotime(
    //         '+' . $half_minutes . ' minutes',
    //         $schedule_out
    //     );

    //     return $final_time;
    // }
    //////////////////////End Update Absen 2026///////////////////////////////

}

?>