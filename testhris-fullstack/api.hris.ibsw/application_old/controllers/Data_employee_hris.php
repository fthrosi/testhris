<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_employee_hris extends RestController
{

  public function __construct(){
    parent::__construct();
    $this->load->model('Mhris_ibsw', 'mhid');
    $this->load->model('Mhris_functions', 'mhfd');
  }

  public function get_data_get(){
    $nik = $this->get('NIK');
    $generate       = generating_token_absen($nik);
    $this->mhfd->create_token_absen($generate, $nik);
    if($nik === null){
      $employee = $this->mhid->get_employee();
    }else{
      $employee = $this->mhid->get_employee($nik);
    }
      
    if($employee){
      $this->response([
        'status' => TRUE,
        'data' => $employee
      ], RestController::HTTP_OK);
    }else{
      $this->response([
        'status' => FALSE,
        'message' => 'NIK Not Found'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
}
