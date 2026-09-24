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
              'status' => true,
              'data' => $data_ver,
              'message' => 'Success'
            ], RestController::HTTP_OK);
          }else{
            
            $data = array(
                  'status' => '0',
                    );
            $version[] = $data;

            $this->response([
                'status'  => false,
                'data'  => $version,
                'message' => 'App version not eligible. Please download the latest update from hris.ibsmulti.com.'
            ], RestController::HTTP_NOT_FOUND); // Atau HTTP_UPGRADE_REQUIRED (426) jika REST API mendukung
          }

      }else{
        $this->response([
          'message' => 'Version Number not detected'
        ], RestController::HTTP_BAD_REQUEST);
      }

    }
    
    public function get_info_mobile_post(){

        $data_info = $this->mhid->getInfoMobile();

        if (!empty($data_info)) {

            foreach ($data_info as $key => $row) {
                if (isset($row['info'])) {

                    // ubah <br>, <br/>, <br /> jadi newline
                    $data_info[$key]['info'] = str_ireplace(
                        ['<br>', '<br/>', '<br />'],
                        "\n",
                        $row['info']
                    );

                    // optional: decode entity (emoji, &, dll)
                    $data_info[$key]['info'] = html_entity_decode(
                        $data_info[$key]['info'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                }
            }

            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'data' => $data_info
                ], JSON_UNESCAPED_UNICODE));

        } else {

            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'data' => 'Information Not Found!'
                ], JSON_UNESCAPED_UNICODE));
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
