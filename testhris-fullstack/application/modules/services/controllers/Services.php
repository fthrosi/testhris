<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH.'libraries/FPDF-master/fpdf.php');
require_once(APPPATH.'libraries/FPDI-master/src/autoload.php');
// require '/var/www/html/application/vendor/phpmailer/phpmailer/src/Exception.php';
// require '/var/www/html/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require '/var/www/html/application/vendor/phpmailer/phpmailer/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception ;
use setasign\Fpdi\Fpdi;

class Services extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('enc');
		$this->load->model('m_global');
		$this->email = $this->session->userdata('user_email');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function index()
	{
		$this->load->view('services/email/template_email', TRUE);
		// print_r('hello');die;
	}


}
