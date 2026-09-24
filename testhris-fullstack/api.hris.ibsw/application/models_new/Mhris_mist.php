<?php

class Mhris_mist extends CI_Model
{
    public function get_data_employee($nik){

        $employee = $this->db->get_where('v_hris_employee_updated', ['nik' => $nik])->result_array();

        $data_employee = [];

        foreach ($employee as $key => $value) {
            $data = array(
                'nik' => $value['nik'],
                'complete_name' => decrypt($value['complete_name']),
                'email' => decrypt($value['email']),
                'company_code' => decrypt($value['company_code']),
                'company_name' => decrypt($value['company_name']),
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
        }

        return $data_employee;
    }
}

?>