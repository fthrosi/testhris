<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";


use chriskacerguis\RestServer\RestController;


class Data_absensi extends RestController
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Mhris_ibsw', 'mhid');
        $this->load->model('Mhris_functions', 'mhfd');
    }

    public function get_token_post(){
        
        // $nik         = $this->post('nik');
        // $generate    = generating_token_absen($nik);
        // $response = $this->mhfd->create_token_absen($generate, $nik);
        //     if($response){
        //         $this->response([
        //             'status' => TRUE
        //             ], RestController::HTTP_OK);
        //     }else{
        //         $this->response([
        //             'status' => FALSE
        //             ], RestController::HTTP_BAD_REQUEST);
        //     }
        $nik            = $this->post('nik');
        $generate       = generate_token($nik);
        $response       = $this->mhfd->create_token_absen($generate, $nik);
        if($response){
            $this->response([
                'status' => TRUE
                ], RestController::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE
                ], RestController::HTTP_BAD_REQUEST);
        }

    }
    
    public function check_token_post(){
        
    // $nik         = $this->post('nik');
    // $generate    = generating_token_absen($nik);

    // $response = $this->mhfd->check_token_absen($generate);
    //     if($response){
    //         $this->response([
    //             'status' => TRUE
    //             ], RestController::HTTP_OK);
    //     }else{
    //         $this->response([
    //             'status' => FALSE
    //             ], 409);
    //     }
        // $nik            = $this->post('nik');
        // $token          = $this->mhfd->get_token_absen($nik);

        
        
        $response       = validate_token_check('MjAxODAwMjYuMTc2NTQ0NjMyMS5hZDQzYjhhM2U3MTAzMDQ3MjY2ZGJjZmMyM2UxNTE5MmUwYTVlYmFjMTc4OTkxOGQwYjRhNTY1Y2ZjNTMwNjcy');
        
        if($response){
            $this->response([
                'status' => TRUE,
                'data' => $response
                ], RestController::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'data' => $response
                ], 409);
        }
    }
    
    public function get_absen_get(){
    
        $nik            = $this->get('nik');
        if(!empty($nik)){

            $data = [
                'nik' => $this->get('nik')
            ];
            
            $response = $this->mhid->get_last_presensi($data);
            if($response){
                // $generate        = generating_token_absen($nik);
                // $this->mhfd->create_token_absen($generate, $nik);
                $generate       = generate_token($nik);
                $this->mhfd->create_token_absen($generate, $nik);

                $this->response([
                // 'status' => TRUE,
                'data' => $response
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                // 'status' => FALSE,
                'message' => 'Data Not Found'
                ], RestController::HTTP_NOT_FOUND);
            }

        }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'NIK must be filled in'
                    ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function get_absen2_get(){

    $data = [
        'nik' => $this->get('nik'),
        'start_date' => $this->get('start_date'),
        'end_date' => $this->get('end_date'),
        'month' => $this->get('month'),
    ];
    
    $response = $this->mhid->get_last_presensi2($data);
        if($response){
            $this->response([
            // 'status' => TRUE,
            'data' => $response
            ], RestController::HTTP_OK);
        }else{
            $this->response([
            // 'status' => FALSE,
            'message' => 'Data Not Found'
            ], RestController::HTTP_NOT_FOUND);
        }
    }
    
    public function post_absen_post(){

        $nik         = $this->post('nik');    
 
        if(!empty($nik)){

            // $generate       = generating_token_absen($nik);
            // $response       = $this->mhfd->check_token_absen($generate);

            $token          = $this->mhfd->get_token_absen($nik);
            $response       = validate_token($token);

            if($response){

                $data = [
                    'nik'       => $this->post('nik'),
                    'address'   => $this->post('address'),
                    'latitude'  => $this->post('latitude'),
                    'longitude' => $this->post('longitude')
                ];
            
                $status = $this->mhid->update_presensi($data);

                if($status){
                    $this->response([
                    'status' => TRUE,
                    'data' => $status
                    ], RestController::HTTP_OK);
                }else{
                    $this->response([
                    'status' => FALSE,
                    'data' => 'Data Not Modified'
                    // 'message' => 'Data Not Modified'
                    ], RestController::HTTP_NOT_MODIFIED);
                }


            }else{
                $this->response([
                    'status' => FALSE,
                    'data' => 'Conflict: Token not found. The provided token does not exist in our system.'
                    ], 409);
            }

        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'NIK must be filled in'
                ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function post_absen2_post(){
    $data = [
        'nik'       => $this->post('nik'),
        // 'clock'     => $this->post('clock'),
        'address'   => $this->post('address'),
        'latitude'  => $this->post('latitude'),
        'longitude' => $this->post('longitude')
    ];
    
    $response = $this->mhid->update_presensi2($data);

        if($response){
            $this->response([
            'status' => TRUE,
            'data' => $response
            ], RestController::HTTP_OK);
        }else{
            $this->response([
            'status' => FALSE,
            'message' => 'Data Not Modified'
            ], RestController::HTTP_NOT_MODIFIED);
        }
    }
    
}
