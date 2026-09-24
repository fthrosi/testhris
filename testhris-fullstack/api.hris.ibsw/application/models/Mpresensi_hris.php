<?php

class Mpresensi_hris extends CI_Model
{
    public function get_presensi($nik = null){
      if($nik === null){
          $presensi = $this->db->get('presensi')->result_array();
            
          foreach ($presensi as $key => $value) {
              $data = array(
                    'id' => $value['id'],
                    'nik_employee' => $value['nik_employee'],
                    'in_tanggal' => $value['in_tanggal'],
                    'in_jam' => $value['in_jam'],
                    'in_latitude' => $value['in_latitude'],
                    'in_longitude' => $value['in_longitude'],
                    'in_address' => $value['in_address'],
                    'in_datetime' => $value['in_datetime'],
                    'out_latitude' => $value['out_latitude'],
                    'out_longitude' => $value['out_longitude'],
                    'out_address' => $value['out_address'],
                    'out_datetime' => $value['out_datetime'],
                    'out_date' => $value['out_date'],
                    'out_jam' => $value['out_jam']
                  );
                  $data_presensi[] = $data;
              };
          return $data_presensi;
        }else{
          $presensi = $this->db->get_where('presensi', ['nik_employee' => $nik])->result_array();

          foreach ($presensi as $key => $value) {
            $data = array(
                  'id' => $value['id'],
                  'nik_employee' => $value['nik_employee'],
                  'in_tanggal' => $value['in_tanggal'],
                  'in_jam' => $value['in_jam'],
                  'in_latitude' => $value['in_latitude'],
                  'in_longitude' => $value['in_longitude'],
                  'in_address' => $value['in_address'],
                  'in_datetime' => $value['in_datetime'],
                  'out_latitude' => $value['out_latitude'],
                  'out_longitude' => $value['out_longitude'],
                  'out_address' => $value['out_address'],
                  'out_datetime' => $value['out_datetime'],
                  'out_date' => $value['out_date'],
                  'out_jam' => $value['out_jam']
                );
                $data_presensi[] = $data;
            };
            return $data_presensi;
        }
    }
}

?>