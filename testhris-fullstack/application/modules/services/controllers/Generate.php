<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require_once(APPPATH.'libraries/FPDF-master/fpdf.php');
// require_once(APPPATH.'libraries/FPDI-master/src/autoload.php');
// use setasign\Fpdi\Fpdi;

class Generate extends Admin_Controller
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
		print_r('hello');die;
	}

	##### Generate Result Document
	function result_document($form_url, $request_id, $request_number)
	{
		if ($form_url == 'kpi') {
			$form_name = 'PA';
			$form_path = 'kpi';
		} 

		$id = decode_url($request_id);

		$data['header'] = $this->m_global->find('performance_appraisal', 'id', $id)->row_array();
		$eval_year = $data['header']['evaluation_period_start'];
		$eval_year = date('Y', strtotime($eval_year));
		$data['eval_year'] = $eval_year;
		$id_form_request = $this->m_global->find('form_request', 'request_number', $data['header']['request_number'])->row_array()['id'];
		$data['detail_kpi'] = $this->m_global->find('performance_appraisal_measurement', 'request_id', $id)->result_array();
		$data['training'] = $this->m_global->find('performance_appraisal_training', 'request_id', $id)->result_array();
		$data['additional'] = $this->m_global->find('performance_appraisal_plan', 'request_id', $id)->result_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $id_form_request)->result_array();
		$data['count_approval'] = count($data['approval']);
		$data['employee'] = $this->db->query("select a.email ,
		(SELECT complete_name FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as complete_name,
		(SELECT nik FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as nik,
		(SELECT position FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as position,
		(SELECT join_date FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as join_date,
		(SELECT employee_subgroup FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as employee_subgroup,
		(SELECT division FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as division,
		(SELECT personnel_area FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as personnel_area
		from v_hris_employee_updated as a where a.email = '".$data['header']['created_by']."' group by a.email")->row_array();
		// $this->load->view('form/result_document/kpi_approved', $data);
		$this->templates->show('detail', 'form/result_document/kpi_approved', $data);
		
	}

	// ##### Generate Result Document
	// function result_document($form_url, $request_id, $request_number)
	// {
	// 	if ($form_url == 'kpi') {
	// 		$form_name = 'PA';
	// 		$form_path = 'kpi';
	// 	} 

	// 	$id = decode_url($request_id);
	// 	$api_endpoint  = "https://selectpdf.com/api2/convert/";
	// 	$key = '25d1d749-bda3-446e-af89-dcb00bb34a5d'; 
	// 	$test_url 	   = base_url().'/services/generate/print/' . $form_url . '/' . $id;//stop dulu
	// 	// $test_url 	   = 'https://e-approval.ibstower.com/services/generate/print/' . $form_url . '/' . $id;
	// 	$filename      = 'IBSW-' . $form_name . '-' . $request_number . '.pdf';
	// 	$local_file    = './papp_documents/'. $request_number .'/'. $filename;
	// 	$rpath   	   = './papp_documents/'. $request_number .'/';

	// 	if (!is_dir($rpath)) {
	// 		mkdir($rpath, 0777, TRUE);
	// 		chmod($rpath, 0777);
	// 	}
		 
	// 	$parameters = array(
	// 		"ssl"=>array(
	// 		"verify_peer"=>false,
	// 		"verify_peer_name"=>false,
	// 		"viewer_center_window"=>true,
	// 		"page_breaks_enhanced_algorithm"=>true,
	// 		"single_page_pdf"=>true,
	// 		"viewer_page_layout"=>'1'
	// 		// "viewer_fit_window"=>true
	// 	),
	// 	'key' => $key, 'url' => $test_url);
	// 	$options = array(
	// 		'http' => array(
	// 			'header'  => "Content-type: application/json",
	// 			'method'  => 'POST',
	// 			'content' => json_encode($parameters),
	// 		),
	// 	);

	// 	$context  = stream_context_create($options);
	// 	$result = @file_get_contents($api_endpoint, false, $context);

		
	// 	if (!$result) {
	// 		echo "HTTP Response: " . $http_response_header[0] . "<br/>";
	// 		$error = error_get_last();
	// 		echo "Error Message: " . $error['message'];
	// 	} else {

	// 		file_put_contents($local_file, $result);

	// 		if ($this->db->where('id', $id)->update('performance_appraisal', array('result_document' => $local_file, 'count_print' => '1'))) {
	// 			redirect(base_url($local_file));
	// 		}
	// 	}



		
		
	// }

	// function print($type, $id)
	// {
	// 	switch ($type) {

	// 		case 'kpi':
	// 			$data['header'] = $this->m_global->find('performance_appraisal', 'id', $id)->row_array();
	// 			$eval_year = $data['header']['evaluation_period_start'];
	// 			$eval_year = date('Y', strtotime($eval_year));
	// 			$data['eval_year'] = $eval_year;
	// 			$id_form_request = $this->m_global->find('form_request', 'request_number', $data['header']['request_number'])->row_array()['id'];
	// 			$data['detail_kpi'] = $this->m_global->find('performance_appraisal_measurement', 'request_id', $id)->result_array();
	// 			$data['training'] = $this->m_global->find('performance_appraisal_training', 'request_id', $id)->result_array();
	// 			$data['additional'] = $this->m_global->find('performance_appraisal_plan', 'request_id', $id)->result_array();
	// 			$data['approval'] = $this->m_global->find('form_approval', 'request_id', $id_form_request)->result_array();
	// 			$data['count_approval'] = count($data['approval']);
	// 			// $data['employee'] = $this->m_global->find('employee', 'id', $data['header']['employee_id'])->row_array();
	// 			$data['employee'] = $this->db->query("select a.email ,
	// 			(SELECT complete_name FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as complete_name,
	// 			(SELECT nik FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as nik,
	// 			(SELECT position FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as position,
	// 			(SELECT join_date FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as join_date,
	// 			(SELECT employee_subgroup FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as employee_subgroup,
	// 			(SELECT division FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as division,
	// 			(SELECT personnel_area FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as personnel_area
	// 			from v_hris_employee_updated as a where a.email = '".$data['header']['created_by']."' group by a.email")->row_array();
	// 			$this->templates->show('detail', 'form/result_document/kpi_approved', $data);
	// 			break;
			
	// 		default:
	// 			break;
	// 	}

	// }


}
