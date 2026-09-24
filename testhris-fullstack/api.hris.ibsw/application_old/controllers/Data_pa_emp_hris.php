<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_pa_emp_hris extends RestController
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Mhris_ibsw', 'mhid');
        $this->load->model('Mhris_functions', 'mhfd');
    }

    public function pa_employee_post(){
       $nik         = $this->post('nik');
       $lat         = $this->post('lat');
       $long        = $this->post('long');
       $date        = $this->post('date');

      if(!empty($nik)){

          // $generate       = generating_token_absen($nik);
          // $response       = $this->mhfd->check_token_absen($generate);
          $generate       = generate_token($nik);
          $this->mhfd->create_token_absen($generate, $nik);

          if(empty($date)){
              $date  = date('Y-m-d');
          }

          $data = [
            'nik'         => $nik,
            'date'        => $date,
            'lat'         => $lat,
            'long'        => $long
          ];
          
          $data_pa  = $this->mhid->getRelocation_ztm($data);
          if (!empty($data_pa)){
            $personnel_area = $data_pa->pa_akhir;
          } else {
            $personnel_area = $this->mhid->getPaEmployee($nik);
          }
          $status   = $this->mhid->getOfficeRadius_ztm($personnel_area, $data);
          
          if($status){
            $this->response([
              'status' => TRUE,
              'data' => $status
            ], RestController::HTTP_OK);
          }else{
            $this->response([
              'status' => FALSE,
              'message' => 'Data Not Found'
            ], RestController::HTTP_NOT_FOUND);
          }

      }else{
        $this->response([
          'status' => FALSE,
          'message' => 'NIK must be input'
        ], RestController::HTTP_BAD_REQUEST);
      }

    }
    
    public function check_pa_post(){
       $lat         = $this->post('lat');
       $long        = $this->post('long');
       $date        = $this->post('date');

      if(empty($date)){
          $date  = date('Y-m-d');
      }

      $data = [
        'date'        => $date,
        'lat'         => $lat,
        'long'        => $long
      ];
      
      $status   = $this->mhid->checkOfficeRadius_ztm($data);
      
      if($status){
        $this->response([
          'status' => TRUE,
          'data' => $status
        ], RestController::HTTP_OK);
      }else{
        $this->response([
          'status' => FALSE,
          'message' => 'Data Not Found'
        ], RestController::HTTP_NOT_FOUND);
      }

    }
}
