<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Enc extends Admin_Controller
{
	function __construct()
	{
        parent::__construct();
        
    }

    public function index(){
		$this->load->view('master/check_encryption');
    }
	// ENCRYPTION DECRYPTION //

	public function dec(){
		$type	= $_POST['con_type'];
		$input	= $_POST['input'];

		if ($type == 'DEC'){
			echo json_encode(decrypt($input));
		} else {
			echo json_encode(encrypt($input));
		}
	}
	/////////// END ///////////
}