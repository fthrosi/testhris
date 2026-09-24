<?php

class Mabsen_ibsw extends CI_Model
{
    public function absen($data){

		$this->db->insert('presensi_ibsw', $data);
        return $this->db->affected_rows();
    }

}

?>