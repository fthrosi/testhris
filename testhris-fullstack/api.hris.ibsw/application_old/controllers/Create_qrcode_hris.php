<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Create_qrcode_hris extends RestController
{

  public function __construct(){
    parent::__construct();
    $this->load->model('Mhris_ibsw', 'mhid');
  }

  public function create_qrcode_post(){
    $data1 = $this->post('data1');
    $data2 = $this->post('data2');
    $data3 = $this->post('data3');
    $data4 = $this->post('data4');
    $data5 = $this->post('data5');
    
    $config['cacheable']    = true;
    $config['cachedir']     = 'https://hris.ibsmulti.com/assets/';
    $config['errorlog']     = 'https://hris.ibsmulti.com/assets/';
    $config['imagedir']     = 'https://hris.ibsmulti.com/assets/images/qrcode_hris/';
    $config['quality']      = true;
    $config['size']         = '1024';
    $config['black']        = array(224,255,255);
    $config['white']        = array(70,130,180);
    $this->ciqrcode->initialize($config);

    $image_name= $data1.'.png';
    if(!empty($data5)){
      $params['data'] = $data1.' - '.$data2.' - '.$data3.' - '.$data4.' - '.$data5;
    }else{
      $params['data'] = $data1.' - '.$data2.' - '.$data3.' - '.$data4;
    }
    
    $params['level'] = 'H'; //H=High
    $params['size'] = 10;
    $params['savename'] = FCPATH.$config['imagedir'].$image_name;
    $cek = $this->ciqrcode->generate($params);
      
    if($cek){
      $this->response([
        'status' => TRUE,
        'data' => 'https://hris.ibsmulti.com/assets/images/qrcode_hris/'.$image_name
      ], RestController::HTTP_OK);
    }else{
      $this->response([
        'status' => FALSE,
        'message' => 'Cant create QR Code'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
}
