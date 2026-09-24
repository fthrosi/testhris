<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_schedule_hris extends RestController
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Mhris_ibsw', 'mhid');
    }

    public function schedule_employee_post(){
       $nik         = $this->post('nik');
       $start_date  = $this->post('start_date');
       $end_date    = $this->post('end_date');

      if(!empty($nik)){

          if(empty($start_date)){
              $start_date = date('Y-m-d');
              $end_date   = date('Y-m-d');
          }else if(empty($end_date)){
              $end_date   = $start_date;
          }

          $data = [
            'nik'         => $nik,
            'start_date'  => $start_date,
            'end_date'    => $end_date
          ];
    
          $data = $this->mhid->get_schedule_employee($data);
            
          if($data){
            $this->response([
              'status' => TRUE,
              'data' => $data
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
    
    public function schedule_employee_per_day_post(){
       $nik         = $this->post('nik');
       $date        = $this->post('date');

      if(!empty($nik)){

          if(empty($date)){
              $date = date('Y-m-d');
          }

          $data = [
            'nik'         => $nik,
            'date'        => $date
          ];
          list($status, $nik, $full_name, $date, $dws, $schedule_code, $attendence_code, $time_off_code, $schedule_in, $schedule_out) = $this->mhid->get_schedule_per_day_employee($data);
          if($status){
            $this->response([
              'status' => $status,
              'nik' => $nik,
              'full_name' => $full_name,
              'date' => $date,
              'dws' => $dws,
              'schedule_code' => $schedule_code,
              'attendence_code' => $attendence_code,
              'time_off_code' => $time_off_code,
              'schedule_in' => $schedule_in,
              'schedule_out' => $schedule_out,
            ], RestController::HTTP_OK);
          }else{
            $this->response([
              'status' => $status,
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
}
