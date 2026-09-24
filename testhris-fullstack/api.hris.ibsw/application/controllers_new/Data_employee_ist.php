<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_apps_ist extends RestController
{

  public function __construct(){
    parent::__construct();
    $this->load->model('Mhris_mist', 'mist');
  }

  public function data_employee_post(){

    $nik = $this->post('nik');

    if(!empty($nik)){

      $employee     = $this->mist->get_data_employee($nik);

      if($employee){
        $this->response([
          'status'  => TRUE,
          'data'    => $employee,
          'message' => 'Data has been found'
        ], RestController::HTTP_OK);
      }else{
        $this->response([
          'status'  => FALSE,
          'data'    => '',
          'message' => 'Data not found'
        ], RestController::HTTP_NOT_FOUND);
      }           

    }else{
            $this->response([
                'status'  => FALSE,
                'data'    => '',
                'message' => 'NIK must be filled in'
                ], RestController::HTTP_BAD_REQUEST);
    }
    
  }

}
