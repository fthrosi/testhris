<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_presensi_hris extends RestController
{

  public function __construct(){
    parent::__construct();
    $this->load->model('Mpresensi_hris', 'mph');
    $this->load->model('Mhris_functions', 'mhfd');
  }

  public function get_data_get(){
    $nik = $this->get('NIK');
    
    if($nik === null){
      $presensi = $this->mph->get_presensi();
    }else{
      $presensi = $this->mph->get_presensi($nik);
      
      // $generate       = generating_token_absen($nik);
      // $response       = $this->mhfd->check_token_absen($generate);
      $generate       = generate_token($nik);
      $this->mhfd->create_token_absen($generate, $nik);
    }
      
    if($presensi){
      $this->response([
        'status' => TRUE,
        'data' => $presensi
      ], RestController::HTTP_OK);
    }else{
      $this->response([
        'status' => FALSE,
        'message' => 'NIK Not Found'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
}
