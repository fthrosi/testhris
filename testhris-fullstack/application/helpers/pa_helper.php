<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('check_pa_leaving')) {
    function check_pa_leaving($division)
    {
        $year = date("Y");
        $year = $year-1;
        $query = "select id from access_divhead_leaving_employee where division = '$division' and evaluation_year = '$year' and is_active = '1'";
        $CI =& get_instance();
        $check = $CI->db->query($query)->result();

        return $check;

        // echo $check;
    }
}

