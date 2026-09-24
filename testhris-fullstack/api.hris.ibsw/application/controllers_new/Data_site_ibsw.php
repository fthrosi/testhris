<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_site_ibsw extends RestController
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Msite_ibsw', 'msite');
    }

    public function get_data_get(){
      $users = $this->msite->get_site();
      
      if($users){
        $this->response([
          'status' => TRUE,
          'data_view' => $users
        ], RestController::HTTP_OK);
      }else{
        $this->response([
          'status' => FALSE,
          'message' => 'User Not Found'
        ], RestController::HTTP_NOT_FOUND);
      }
    }

}
