<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Post_absen_hris extends RestController
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Mabsen_ibsw', 'mai');
    }

    public function absen_post(){
      $data = [
          'nik' => $this->post('nik'),
          'nama' => $this->post('nama'),
          'clock_in' => $this->post('clock_in'),
          'long_in' => $this->post('long_in'),
          'lat_in' => $this->post('lat_in'),
          'address_in' => $this->post('address_in'),
          'clock_out' => $this->post('clock_out'),
          'long_out' => $this->post('long_out'),
          'lat_out' => $this->post('lat_out'),
          'address_out' => $this->post('address_out'),
      ];

      if($this->mai->absen($data) > 0){
          $this->response([
                  'status' => TRUE,
                  'data' => $data,
                  'message' => 'Presensi Sudah Tercatat'
              ], RestController::HTTP_CREATED);
      }else{
          $this->response([
              'status' => FALSE,
              'message' => 'Gagal melakukan presensi'
          ], RestController::HTTP_BAD_REQUEST);   
      }
  }
}
