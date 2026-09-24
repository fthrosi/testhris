<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_ver_mobile_hris extends RestController
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Mhris_ibsw', 'mhid');
    }

    public function get_ver_android_post(){
       $ver_android        = $this->post('ver_android');

      if(!empty($ver_android)){
          
          $data_ver  = $this->mhid->getVersionAndroid($ver_android);
          
          if($data_ver){
            $this->response([
              'data' => $data_ver
            ], RestController::HTTP_OK);
          }else{
            $this->response([
              'message' => 'Version Not Found'
            ], RestController::HTTP_NOT_FOUND);
          }

      }else{
        $this->response([
          'message' => 'Version Number must be input'
        ], RestController::HTTP_BAD_REQUEST);
      }

    }
    
    public function get_info_mobile_post(){
          
          $data_info  = $this->mhid->getInfoMobile();
          
          if($data_info){
            $this->response([
              'data' => $data_info
            ], RestController::HTTP_OK);
          }else{
            $this->response([
              'data' => 'Information Not Found!'
            ], RestController::HTTP_NOT_FOUND);
          }

    }
    
    // public function get_user_agent_get(){

    //   $this->load->library('user_agent');

    //   if ($this->agent->is_browser())
    //   {
    //           $agent = $this->agent->browser().' '.$this->agent->version();
    //   }
    //   elseif ($this->agent->is_robot())
    //   {
    //           $agent = $this->agent->robot();
    //   }
    //   elseif ($this->agent->is_mobile())
    //   {
    //           $agent = $this->agent->mobile();
    //   }
    //   else
    //   {
    //           $agent = 'Unidentified User Agent';
    //   }

    //   echo $agent;
    //   echo '<br>';
    //   echo $this->agent->platform();
    //   $ver_android        = $this->post('ver_android');

    //   if(!empty($ver_android)){
          
    //       $data_ver  = $this->mhid->getVersionAndroid($ver_android);
          
    //       if($data_ver){
    //         $this->response([
    //           'data' => $data_ver
    //         ], RestController::HTTP_OK);
    //       }else{
    //         $this->response([
    //           'message' => 'Version Not Found'
    //         ], RestController::HTTP_NOT_FOUND);
    //       }

    //   }else{
    //     $this->response([
    //       'message' => 'Version Number must be input'
    //     ], RestController::HTTP_BAD_REQUEST);
    //   }

    // }
}
