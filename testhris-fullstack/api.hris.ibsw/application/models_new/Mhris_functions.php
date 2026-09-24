<?php

class Mhris_functions extends CI_Model
{

    public function create_token_absen($generate, $nik){

        $formData = array(
            'token' => $generate,
            'nik'   => $nik,
        );

        $exists = $this->db->get_where('tokens_api_absen', [
            'token' => $generate,
            'nik'   => $nik
        ])->row();

        if (!$exists) {
            $query = $this->db->insert("tokens_api_absen", $formData);

            if ($query){
                return true;
            } else {
                return false;
            }

        } else {
            return true; 
        }		
       
    }

    public function check_token_absen($token){
        
        $this->db->where('token', $token);
        $this->db->where('status', 1);
        $query = $this->db->get('tokens_api_absen');
        
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
       
    }

    public function get_token_absen($nik){
        
        $this->db->select('token');
        $this->db->where('nik', $nik);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get('tokens_api_absen');
        $row = $query->row();
        

        if ($row) {
            return $token = $row->token;
        } else {
            return false;
        }
       
    }

}

?>