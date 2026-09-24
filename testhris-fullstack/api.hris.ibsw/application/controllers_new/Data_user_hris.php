<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_user_hris extends RestController
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Mhris_ibsw', 'mhid');
    }

    public function users_get(){
      $users = $this->mhid->get_users();
      
      if($users){
        $this->response([
          'status' => TRUE,
          'data' => $users
        ], RestController::HTTP_OK);
      }else{
        $this->response([
          'status' => FALSE,
          'message' => 'User Not Found'
        ], RestController::HTTP_NOT_FOUND);
      }
    }

    public function user_login_get(){
      $email = $this->get('EMAIL');
      $nik = $this->get('NIK');

      if($email === null || $nik === null){
        $employee = $this->mhid->get_user_login();
      }else{
        $employee = $this->mhid->get_user_login($email, $nik);
      }
        
      if($employee){
        $this->response([
          'status' => TRUE,
          'data' => $employee
        ], RestController::HTTP_OK);
      }else{
        $this->response([
          'status' => FALSE,
          // 'data' => $employee
          'message' => 'NIK  Not Found'
        ], RestController::HTTP_OK);
        // ], RestController::HTTP_NOT_FOUND);
      }
    }

    public function user_login_mobile_post(){
       $datauser = $this->post('datauser');
       $pass = $this->post('passcode');
       $pass = encrypt($pass);

      $data = [
        'datauser' => $this->post('datauser'),
        'pass' => encrypt($this->post('passcode'))
      ];

      // dumper($data);
      // $employee = $this->mhid->get_user_login_mobile($email, $nik, $pass);
      $employee = $this->mhid->get_user_login_mobile($data);
        
      if($employee){
        $this->response([
          'status' => TRUE,
          'data' => $employee
        ], RestController::HTTP_OK);
      }else{
        $this->response([
          'status' => FALSE,
          // 'data' => $employee
          'message' => 'Employee Not Found'
        ], RestController::HTTP_OK);
        // ], RestController::HTTP_NOT_FOUND);
      }
    }
    
    public function user_login_web_post(){
       $datauser = $this->post('datauser');
       $pass = $this->post('passcode');
       $pass = encrypt($pass);

      $data = [
        'datauser' => $this->post('datauser'),
        'pass' => encrypt($this->post('passcode'))
      ];

      // dumper($data);
      // $employee = $this->mhid->get_user_login_mobile($email, $nik, $pass);
      $employee = $this->mhid->get_user_login_web($data);
        
      if($employee){
        $this->response([
          'status' => TRUE,
          'data' => $employee
        ], RestController::HTTP_OK);
      }else{
        $this->response([
          'status' => FALSE,
          // 'data' => $employee
          'message' => 'Employee Not Found or Invalid Password'
        ], RestController::HTTP_OK);
        // ], RestController::HTTP_NOT_FOUND);
      }
    }
}
