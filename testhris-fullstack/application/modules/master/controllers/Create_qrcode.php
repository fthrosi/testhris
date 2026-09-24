<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Create_qrcode extends Admin_Controller
{
	function __construct()
	{
        parent::__construct();
        
    }

    public function index(){
		$data1 = "ELLY PRASETIO";
    	$data2 = "CHIEF HUMAN RESOURCES OFFICER ";
    	$data3 = "PT. TEKNO INFRASTRUKTUR SUKSES";
		$config['cacheable']    = true;
		$config['cachedir']     = './assets/';
		$config['errorlog']     = './assets/';
		$config['imagedir']     = './assets/images/qrcode_hris/';
		$config['quality']      = true;
		$config['size']         = '1024';
		$config['black']        = array(224,255,255);
		$config['white']        = array(70,130,180);
		$this->ciqrcode->initialize($config);

		$image_name= $data1.'.png';
		$params['data'] = $data1.' - '.$data2.' - '.$data3;
		
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH.$config['imagedir'].$image_name;
		$cek = $this->ciqrcode->generate($params);
		echo "https://hris.ibsmulti.com/assets/images/qrcode_hris/".$image_name;
    }
	
}