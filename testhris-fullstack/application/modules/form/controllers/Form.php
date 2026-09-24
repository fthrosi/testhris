<?php

defined('BASEPATH') or exit('No direct script access allowed');
	require '/var/www/html/application/vendor/phpmailer/phpmailer/src/Exception.php';
	require '/var/www/html/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require '/var/www/html/application/vendor/phpmailer/phpmailer/src/SMTP.php';

	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/Exception.php';
	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/SMTP.php';	

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception ;

class Form extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
		$this->load->library('curl');
		$this->load->library('email');
		$this->load->library('enc');
		// $this->enc->check_session();

		$this->email = $this->session->userdata('user_email');
		//dumper($this->email);
		$this->emp_id = $this->session->userdata('employee_id');
		$this->emp_nik = $this->session->userdata('nik');
		$this->emp_name = $this->session->userdata('employee_name');
		$this->emp_grade = $this->session->userdata('employee_group');
		$this->roles = $this->session->userdata('exit_clearance_roles');

		$this->load->helper('general');
		$this->load->model('form_model');
		$this->load->model('inbox/inbox_model');
		$this->load->model('home/home_model');
		$this->load->model('m_global');
		$this->load->model('services/m_services');

		$this->status_apps = $_ENV['CI_ENVIRONMENT'];

		redirect_url();

		if (empty($this->session->userdata('nik'))) {
			$this->session->set_flashdata('failure', 'Login failed');
			redirect('login');
		}
	}

	public function index()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'form/index';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function seo_friendly_url($string){
		$string = str_replace('’', ' ', $string);
		$string = str_replace('•', ' ', $string);
		$string = str_replace('“', ' ', $string);
		$string = str_replace('”', ' ', $string);
		$string = str_replace('²', ' ', $string);
		$string = str_replace('…', ' ', $string);
		$string = str_replace('–', ' ', $string);
		$string = str_replace('°', ' ', $string);
		return trim($string, ' ');
	}

	public function initial_create($formType)
	{

		$year = $this->year-1;

		//=========Start Check schedule Performance Appraisal====================//

		if($formType == "KPI" or $formType == "PLAN"){
			$is_ready = $this->inbox_model->check_ready($year);
			if($is_ready == 0){
				$response = array('status' => 9, 'message' => 'The PA input schedule for '.$year.' has not yet been opened.');
				header('Content-type: application/json');
				echo json_encode($response);
				die;

			}
		}

		//=================End Check schedule Performance Appraisal============================//

		//=========Start Check eligible or not Performance Appraisal================//
		$join_date = date("Y-m-d",strtotime(decrypt($this->session->userdata('join_date'))));
		if($join_date <= $year.'-09-30'){
			// echo "ELIGIBLE<br>";
		}else{
			//not eligible
			// echo "NOT ELIGIBLE<br>";
			if($formType == "KPI"){
				$formType = "PLAN";
			}
		}
		//=========End Check eligible or not Performance Appraisal================//

		$table = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
		$requestNumber = $this->createRequestNumber(strtoupper($formType), $table['header_table']);
		switch ($formType) {
			case 'EC':
				$dataEmployee = $this->m_global->get(array(
					'complete_name',
					'nik'
				), 'hris_employee',  array('nik' => $this->emp_id));

				$requestId = $this->form_model->initial_create($formType, $dataEmployee, $requestNumber, $table['header_table']);
				
				break;

			/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////

			case 'KPI':

				$dataEmployee = $this->db->query("
				SELECT *, a.id_employee,
				case 
					when c.department != '' then c.department
				else
					a.department
				end as department, 
				case 
					when c.id_employee != '' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee and c.evaluation_year = '$year'
				WHERE lower(a.email) LIKE '".encrypt($this->email)."'
				ORDER BY a.id_employee DESC
				")->result_array();
				$dataEmployee[0]['employee_subgroup'] = $this->session->userdata('employee_subgroup');
					
				$chekRecord = $this->form_model->check_KPIPLAN(encrypt($this->email));
				if($chekRecord != ""){
					$this->logs('system', $formType, 0, 'Initial Create', 'Cannot make KPI twice in same period.');
					$response = array('status' => 2, 'message' => 'You have made KPI / Plan form in this period before '.$chekRecord);
					header('Content-type: application/json');
					echo json_encode($response);
					die;
				}
				

				$requestId = $this->form_model->initial_create($formType, $dataEmployee,$requestNumber, $table['header_table']);

				//======================auto generate approval===========================//
				

				break;

			case 'PLAN':

				$dataEmployee = $this->db->query("
					SELECT *, a.id_employee,
					case 
						when c.department != '' then c.department
					else
						a.department
					end as department, 
					case 
						when c.division != '' then c.division
					else
						a.division
					end as division,
					case 
						when c.usrid_long2 != '' then c.usrid_long2
					else
						a.usrid_long2
					end as usrid_long2,
					case 
						when c.usrid_long3 != '' then c.usrid_long3
					else
						a.usrid_long3
					end as usrid_long3,
					case 
						when c.usrid_long4 != '' then c.usrid_long4
					else
						a.usrid_long4
					end as usrid_long4
					FROM
					v_hris_employee_updated a
					LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee and c.evaluation_year = '$year'
					WHERE lower(a.email) = '".encrypt($this->email)."'
					ORDER BY a.id_employee DESC
					")->result_array();

				$dataEmployee[0]['employee_subgroup'] = $this->session->userdata('employee_subgroup');

				$chekRecord = $this->form_model->check_KPIPLAN(encrypt($this->email));

				if($chekRecord != ""){
					$this->logs('system', $formType, 0, 'Initial Create', 'Cannot make PA / Plan twice in same period.');
					$response = array('status' => 2, 'message' => 'You have made PA / Plan form in this period before '.$chekRecord);
					header('Content-type: application/json');
					echo json_encode($response);
					die;
				}

				$requestId = $this->form_model->initial_create($formType, $dataEmployee,$requestNumber, $table['header_table']);
			break;

			/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////

			case 'MDCR':

				$dataEmployee = $this->m_global->get(array(
					'complete_name',
					'nik'
				), 'hris_employee',  array('nik' => $this->emp_id));

				$requestId = $this->form_model->initial_create($formType, $dataEmployee, $requestNumber, $table['header_table']);

				$form_log_request = array(
					'request_id' => $requestId,
					'activity' => 'Create',
					'desc' => $requestNumber . ' created',
					'create_at' => $this->date,
					'create_by' => $this->email,
					'type' => 'MDCR',
					'activity_desc' => 'Created_by_User'
				);

				$this->db->insert('form_logs', $form_log_request);
				
				break;

			case 'PPD':

				$dataEmployee = $this->m_global->get(array(
					'complete_name',
					'nik'
				), 'hris_employee',  array('nik' => $this->emp_id));

				$requestId = $this->form_model->initial_create($formType, $dataEmployee, $requestNumber, $table['header_table']);
				break;

			case 'LPD':

				$dataEmployee = $this->m_global->get(array(
					'complete_name',
					'nik'
				), 'hris_employee',  array('nik' => $this->emp_id));

				$requestId = $this->form_model->initial_create($formType, $dataEmployee, $requestNumber, $table['header_table']);
				break;

			default:
				break;
		}

		if ($requestId) {
			$this->logs('create', $formType, $requestId);
			$response = array('status' => 1, 'message' => 'Redirecting..', 'form' => $formType, 'id' => encode_url($requestId));
		} else {
			$this->logs('system', $formType, $requestId, 'Initial Create', 'Something went wrong with request id.');
			$response = array('status' => 0, 'message' => 'Something went wrong with request id.');
		}

		header('Content-type: application/json');
		echo json_encode($response);
	}
	
	public function generate_resignation_letter(){
		
		$req_id = $this->input->post('request_id');
		$resign_date = $this->input->post('resignation_date');
		$last_working_date = $this->input->post('last_working_date');
		$notes = $this->input->post('notes');
		if(empty($req_id) || empty($resign_date) || empty($last_working_date)){
			$message = "Request ID, Resignation Date, and Last Working Date are required.";
			return $this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode(['error' => $message]));
		}
		
		$employee_id = $this->m_global->find('form_request', 'id', $req_id)->row()->employee_id;
		$employee = $this->form_model->get_data_employee($employee_id);
		$golongan = decrypt($employee[0]->employee_group);
		$words = preg_split('/\s+/', trim($golongan));
		$gol = strtoupper(
			substr($words[count($words) - 1], 0, 1)
		);
		
		$notice_period = $this->m_global->find('exit_clearance_notice_periods', 'grade', $gol)->row()->month;
		
		$last_date = calculate_last_day($resign_date, $notice_period);
		$join_date = decrypt($employee[0]->join_date);
		$working_year = (new DateTime($join_date))->diff(new DateTime($last_date))->y;
		if($working_year < 0){
			$working_year = 0;
		}
		$working_mounth = (new DateTime($join_date))->diff(new DateTime($last_date))->m;
		$complete_name = decrypt($employee[0]->complete_name);
		$months = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember',
		];

		$date = strtotime($resign_date);
		$now = strtotime(date('Y-m-d'));
		$resignation_date = date('d', $date)
			. ' ' . $months[(int)date('n', $date)]
			. ' ' . date('Y', $date);
		$date_now = date('d', $now)
			. ' ' . $months[(int)date('n', $now)]
			. ' ' . date('Y', $now);
		$data = [
			'date' => $date_now,
			'resignation_date' => $resignation_date,
			'notice_period' => (int) $notice_period,
			'complete_name' => $complete_name,
			'position' => decrypt($employee[0]->position),
			'nik' => $employee[0]->nik,
			'division' => decrypt($employee[0]->division),
			'working_year' => (int) $working_year,
			'working_month' => (int) $working_mounth,
			'division_head' => decrypt($employee[0]->divhead_name),
		];
		$html = $this->load->view(
			'form/print_out/print_req_resignation_letters',
			$data,
			true
		);
		// Generate PDF with the project's autoloaded TCPDF wrapper.
		$pdf = new Pdf(
			PDF_PAGE_ORIENTATION,
			PDF_UNIT,
			PDF_PAGE_FORMAT,
			true,
			'UTF-8',
			false
		);

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// Margin PDF
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		$pdf->SetTopMargin(0);
		$pdf->SetLeftMargin(0);
		$pdf->SetRightMargin(0);

		$pdf->SetCellPadding(0);
		$pdf->SetCellMargins(0, 0, 0, 0);

		$pdf->SetAutoPageBreak(false, 0);

		$pdf->SetFont('times', '', 12);

		$pdf->AddPage('P', 'A4');
		/*
		|--------------------------------------------------------------------------
		| HEADER
		|--------------------------------------------------------------------------
		*/

		// Ukuran A4 portrait = 210 x 297 mm
		$headerHeight = 22;

		// Warna background #245487
		$pdf->SetFillColor(255, 255, 255);

		// Background header full halaman
		$pdf->Rect(
			0,
			0,
			210,
			$headerHeight,
			'F'
		);
		/*
		|--------------------------------------------------------------------------
		| TITLE
		|--------------------------------------------------------------------------
		*/

		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetFont(
			'helvetica',
			'B',
			18
		);

		$pdf->SetXY(45, 15);

		$pdf->Cell(
			120,
			16,
			'SURAT PENGUNDURAN DIRI',
			0,
			0,
			'C'
		);
		/*
		|--------------------------------------------------------------------------
		| BODY
		|--------------------------------------------------------------------------
		*/

		// Reset warna text
		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetFont(
			'times',
			'',
			12
		);

		// Mulai body di bawah header
		$pdf->writeHTMLCell(
			160,                  // width
			0,                    // height otomatis
			25,                   // X = 25mm
			$headerHeight + 8,    // Y
			$html,
			0,                    // border
			1,                    // ln
			false,                // fill
			true,                 // reseth
			'L'                   // align
		);
		$filename = 'Surat_Pengunduran_Diri_' . $employee[0]->nik . '.pdf';
		$file_path = FCPATH . 'assets/documents/document_resignation/'.$employee[0]->nik.'/resignation_letter/';
		if (!is_dir($file_path)) {
			mkdir($file_path, 0777, true);
		}
		// Nama file
		$filename = 'Surat_Pengunduran_Diri' . '.pdf';
		$path = $file_path . $filename;
		if(file_exists($path)){
			unlink($path);
		}
		// Simpan PDF ke file, menggantikan file lama jika ada.
		$pdf->Output($path, 'F');
		$dataUpdate = [
			'resignation_date' => date('Y-m-d', strtotime($resign_date)),
			'last_date' => $last_date,
			'file_path' => $filename,
			'notes' => $notes,
		];
		$this->m_global->update('id_form_request',$req_id,'exit_clearance_resignation_letters', $dataUpdate);
		$response = [
			'status' => true,
			'message' => 'Resignation letter generated successfully.',
			'filename' => $filename,
		];
		$this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($response));
		
	}
	public function view_resignation_letter($employee_id, $filename)
	{
		$file_path = FCPATH . 'assets/documents/document_resignation/' . $employee_id . '/resignation_letter/' . $filename;

		if (!file_exists($file_path)) {
			show_404();
			return;
		}

		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename="' . basename($filename) . '"');
		header('Content-Length: ' . filesize($file_path));

		readfile($file_path);
		exit;
	}
	public function updateStatus()
	{
		$req_id = $this->input->post('request_id');
		$status = (int) $this->input->post('status');
		$status_form = $status === 4 ? 8 : 0;
		if ($this->m_global->update('id_form_request', $req_id, 'exit_clearance_resignation_letters', ['status' => $status])) {
			$this->m_global->update('id', $req_id, 'form_request', ['is_status' => $status_form]);
			$this->form_model->deleteApproval($req_id);
			$response = [
				'status' => true,
				'message' => 'Resignation letter updated successfully.',
			];
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode($response));
		} else {
			$response = [
				'status' => false,
				'message' => 'Failed to update resignation letter.',
			];
			return $this->output
				->set_content_type('application/json')
				->set_status_header(500)
				->set_output(json_encode($response));
		}

	}
	public function update_resignation_letter()
	{
		$req_id = $this->input->post('request_id');
		$resign_date = $this->input->post('resignation_date');
		$last_working_date = $this->input->post('last_working_date');	
		$notes = $this->input->post('notes');
		$resignation_letter = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $req_id)->row_array();
		$encrypted_resign_id = encryptURL($resignation_letter['id']);
		if (empty($resignation_letter)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(404)
				->set_output(json_encode([
					'status' => false,
					'message' => 'Resignation letter data was not found.',
				]));
		}
		
		if ((int) $resignation_letter['status'] === 1) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(409)
				->set_output(json_encode([
					'status' => false,
					'message' => 'Resignation letter has already been submitted and cannot be edited.',
				]));
		}
		
		$employee_id = $this->m_global->find('form_request', 'id', $req_id)->row()->employee_id;
		$employee = $this->form_model->get_data_employee($employee_id);
		$golongan = decrypt($employee[0]->employee_group);
		$words = preg_split('/\s+/', trim($golongan));
		$gol = strtoupper(
			substr($words[count($words) - 1], 0, 1)
		);
		$notice_period = $this->m_global->find('exit_clearance_notice_periods', 'grade', $gol)->row()->month;
		$last_date = calculate_last_day($resign_date, $notice_period);
		$update_data = [
			'resignation_date' => date('Y-m-d', strtotime($resign_date)),
			'last_date' => $last_date,
			'status' => 1,
			'notes' => $notes,
			'submitted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];

		if ($this->m_global->update('id_form_request', $req_id, 'exit_clearance_resignation_letters', $update_data)) {
			$this->m_global->update('id', $req_id, 'form_request', ['is_status' => 1]);
			// type RESIGNATION_LETTER, EXIT_CLEARANCE
			$approval = array(
				'id_form_request' => $req_id,
				'approval_type' => "RESIGNATION_LETTER",
				'status' => 0,
				'created_at' => date('Y-m-d H:i:s'),
			);
			$approval_req = $this->m_global->find('exit_clearance_approval_request', 'id_form_request', $req_id)->row_array();
			if(empty($approval_req)){
				$approver_id = !empty($employee[0]->division_head) ? $employee[0]->division_head : $employe[0]->director;

				$step = [[
					'id_approver' => decrypt($approver_id),
					'sequence' => 1,
					'status' => 0,
					'created_at' => date('Y-m-d H:i:s'),
				]];
				$this->form_model->createApproval($approval, $step);
				$role = $this->m_global->find('exit_clearance_roles', 'code', 'DVH')->row_array();
				$this->form_model->assignRoles(decrypt($approver_id), $role['id']);
			}else{
				$this->form_model->updateStatusApproval($req_id);
			}
			$path = FCPATH . 'assets/documents/document_resignation/'.$employee_id.'/resignation_letter/qrcode.png';
			if(file_exists($path)){
				unlink($path);
			}
			$config['cacheable']    = true;
			$config['cachedir']     = './assets/';
			$config['errorlog']     = './assets/';
			$config['imagedir']     = './assets/documents/document_resignation/'.$employee_id.'/resignation_letter/';
			$config['imagelogo']    = './assets/images/IBS.png';
			$config['quality']      = true;
			$config['size']         = '1024';
			$config['black']        = array(224, 255, 255);
			$config['white']        = array(70, 130, 180);
			$this->ciqrcode->initialize($config);
			$image_name 			= 'qrcode.png';
			$params['data'] 		= base_url() . 'form/Qrrl/info/' . $encrypted_resign_id;
			$params['size'] 		= 10;
			$params['savename'] 	= FCPATH . $config['imagedir'] . $image_name;
			$params['logo'] 		= FCPATH . $config['imagelogo'];
			$params['imagetmp'] 	= $config['imagedir'];
			$this->ciqrcode->generate($params);
			$this->generate_resignation_letter_pdf($resignation_letter['id_form_request']);
			unlink($path);
			$response = [
				'status' => true,
				'message' => 'Resignation letter updated successfully.',
			];
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode($response));
		} else {
			$response = [
				'status' => false,
				'message' => 'Failed to update resignation letter.',
			];
			return $this->output
				->set_content_type('application/json')
				->set_status_header(500)
				->set_output(json_encode($response));
		}
	}
	public function getQuestion($code_type)
	{
		$form_type = $this->m_global->find('exit_clearance_form_types', 'code', $code_type)->row_array();
		if (empty($form_type)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(404)
				->set_output(json_encode([
					'status' => false,
					'message' => 'Form type not found.',
				]));
		}
		switch ($form_type['code']) {
			case 'EC':
				$section = $this->m_global->find('exit_clearance_section_forms', 'id_form_type', $form_type['id'])->result_array();
				
				break;
			
			default:
				# code...
				break;
		}
	}
	public function detail($formType, $id)
	{
		$request_id = decode_url($id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
		$header = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
		
		$detail = $this->m_global->getRow('detail_table', 'form_type', array('code' => $formType));
		$additional = $this->m_global->getRow('additional_table', 'form_type', array('code' => $formType));

		if($formType == "EC"){
			$data['header'] = $this->m_global->find($header['header_table'], 'id_form_request', $request_id)->row_array();
		}else{
			$data['header'] = $this->m_global->find($header, 'request_id', $request_id)->row_array();
		}
		

		switch ($formType) {

			
			case 'MDCR':

				$data['detail'] = $this->m_global->find($detail, 'request_id', $request_id)->result_array();
				$employee_id = $data['header']['employee_id'];

				$id_eg_prj = $data['header']['id_eg_prj'];
				$id_eg_pri = $data['header']['id_eg_pri'];
				$id_eg_pk  = $data['header']['id_eg_pk'];
				$data['couple'] = $this->form_model->get_data_couple_employee($employee_id);
				$data['spouse'] = $this->form_model->getFamilyActSpouse($employee_id);
				// dumper($data['detail']);

				//penambahan zulvan 24/01/2024
				if ($data['detail'] != null) {
					$request_created_at = $data['detail'][0]['tanggal_kuitansi'];
				} else {
					$request_created_at = $data['form_request']['created_at'];
				}
				
				$data['sum_penggantian_jalan'] = $this->form_model->get_sum_penggantian_jalan($request_id);
				$data['sum_penggantian_inap'] = $this->form_model->get_sum_penggantian_inap($request_id);
				$data['sum_penggantian_kacamata'] = $this->form_model->get_sum_penggantian_kacamata($request_id);
				$data['reimaning_pagu'] = $this->form_model->get_reimaning_pagu($request_created_at, $employee_id, $id_eg_prj, $id_eg_pri, $id_eg_pk);
				// dumper($data['reimaning_pagu']);
				$data['additional'] = $this->m_global->find($additional, 'request_id', $request_id)->result_array();
				//dumper($data['reimaning_pagu']);
				$config['cacheable']    = true;
				$config['cachedir']     = './assets/';
				$config['errorlog']     = './assets/';
				$config['imagedir']     = './assets/images/qrcode_mdcr/';
				$config['imagelogo']    = './assets/images/IBS.png';
				$config['quality']      = true;
				$config['size']         = '1024';
				$config['black']        = array(224, 255, 255);
				$config['white']        = array(70, 130, 180);
				$this->ciqrcode->initialize($config);
				$image_name 			= $data['form_request']['request_number'] . '-' . $data['form_request']['employee_id'] . '.png';
				$params['data'] 		= $data['form_request']['request_number'] . '-' . $data['form_request']['employee_id'];
				$params['level'] 		= 'H'; //H=High
				$params['size'] 		= 10;
				$params['savename'] 	= FCPATH . $config['imagedir'] . $image_name;
				$params['logo'] 		= FCPATH . $config['imagelogo'];
				$params['imagetmp'] 	= $config['imagedir'];
				$this->ciqrcode->generate($params);

				break;

			case 'PPD':

				$dir =  './uploaded_files/' . $data['form_request']['request_number'] . '/supporting_files';
				$data['uploaded_document'] = $this->doScan($dir);
				$data['list_city'] = $this->form_model->getCity();
				$data['detail'] = $this->m_global->find($detail, 'header_id', $data['header']['id'])->result_array();

				if (!empty($data['detail'][0]['kota_berangkat'])) {
					$data['kota_berangkat'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_berangkat']))->row_array()['NAMA_KABUPATEN_KOTA'];
					$data['kota_tujuan'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_tujuan']))->row_array()['NAMA_KABUPATEN_KOTA'];
					$data['category_city'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_tujuan']))->row_array()['CATEGORY'];
				} else {
				}

				$data['approval_progress'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
				$count = count($data['approval_progress']);
				$data['requestor_layer'] = '';
				$data['layer_1'] = '';
				$data['layer_2'] = '';
				$data['layer_3'] = '';

				break;

			case 'LPD':

				$dir =  './uploaded_files/' . $data['form_request']['request_number'] . '/supporting_files';
				$data['uploaded_document'] = $this->doScan($dir);
				$data['list_city'] = $this->form_model->getCity();
				$data['detail'] = $this->m_global->find($detail, 'header_id', $data['header']['id'])->row_array();
				$data['additional'] = $this->m_global->find($additional, 'header_id', $data['header']['id'])->result_array();

				$data['approval_progress'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
				$count = count($data['approval_progress']);
				$data['requestor_layer'] = '';
				$data['layer_1'] = '';
				$data['layer_2'] = '';
				$data['layer_3'] = '';

				break;
			case 'EC':
				$employee_id = $this->m_global->find('form_request', 'id', $request_id)->row()->employee_id;
				$employee = $this->form_model->get_data_employee($employee_id);
				$golongan = decrypt($employee[0]->employee_group);
				$words = preg_split('/\s+/', trim($golongan));
				$gol = strtoupper(
					substr($words[count($words) - 1], 0, 1)
				);
				$notice_period = $this->m_global->find('exit_clearance_notice_periods', 'grade', $gol)->row()->month;
				
				$data['employee'] = array(
					'notice_period' => (int) $notice_period,
					'complete_name' => decrypt($employee[0]->complete_name),
					'position' => decrypt($employee[0]->position),
					'nik' => $employee[0]->nik,
					'email' => decrypt($employee[0]->email)
				);
				
			break;
			default:
			break;
		}
		if( $formType == "EC"){
			$data['content'] = 'form/exit_clearance/layout_ec';
			$data['resignation_letter'] = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $request_id)->row_array();
			$status_resign = $data['resignation_letter']['status'];
			$status_exit = $data['header']['status'];
			if($status_exit == 0){
				$data['current_step'] = (int) $status_resign === 0 ? 1 : ((int) $status_resign === 1 ? 2 : ((int) $status_resign === 2 ? 1 : ((int) $status_resign === 3 ? 3 : 1)));
			}else{
				$data['current_step'] = (int) $status_exit === 1 ? 4 : ((int) $status_exit === 2 ? 5 : 3);
			}
			$data['reason'] = $this->form_model->getReason($data['resignation_letter']['id'], "Resignation Letter");
			$data['main'] = 'form/exit_clearance/submit_rl';
		}else{
			$data['content'] = 'form/' . $formType;
		}
		$data['roles'] = $this->roles;
		$data['nik'] = $this->emp_nik;
		$data['userList'] = $this->form_model->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['employee_list'] = $this->form_model->getUserList("complete_name", "hris_employee", "is_active = 1 AND access_employee != 1 AND complete_name != '$this->emp_name'");
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['request_notes'] = $this->form_model->getRequestNotes($request_id);
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['formType'] = $this->form_model->getFormType();
		// dumper($data);
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}
	public function home_exit_clearance($id)
	{
		$id = decode_url($id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $id)->row_array();
		if(empty($data['form_request'])){
			print_r('Request not found');die;
		}
		$data['header'] = $this->m_global->find('exit_clearance', 'id_form_request', $id)->row_array();
		if(empty($data['header'])){
			print_r('Exit clearance not found');die;
		}
		$employee = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		$data['employee'] = array(
			'complete_name' => decrypt($employee[0]->complete_name),
			'position' => decrypt($employee[0]->position),
			'nik' => $employee[0]->nik,
			'email' => decrypt($employee[0]->email)
		);
		$data['roles'] = $this->roles;
		$data['resignation_letter'] = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $id)->row_array();
			$status_resign = $data['resignation_letter']['status'];
			$status_exit = $data['header']['status'];
			if($status_exit == 0){
				$data['current_step'] = (int) $status_resign === 0 ? 1 : ((int) $status_resign === 1 ? 2 : ((int) $status_resign === 2 ? 1 : ((int)$status_resign === 3 ? 3 : 1)));
			}else{
				$data['current_step'] = (int) $status_exit === 1 ? 4 : ((int) $status_exit === 2 ? 5 : 3);
			}
		$data['reason'] = $this->form_model->getReason($data['resignation_letter']['id'], "Resignation Letter");
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['content'] = 'form/exit_clearance/layout_ec';
		$data['main'] = 'form/exit_clearance/exit_clearance_home';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);

	}
	public function detail_full_approve($formType, $id)
	{
		$request_id = decode_url($id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
		$header = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
		$detail = $this->m_global->getRow('detail_table', 'form_type', array('code' => $formType));
		$data['header'] = $this->m_global->find($header, 'request_id', $request_id)->row_array();
		switch ($formType) {

			case 'MDCR':
				$employee_id = $data['header']['employee_id'];
				$data['couple'] = $this->form_model->get_data_couple_employee($employee_id);
				$additional = $this->m_global->getRow('additional_table', 'form_type', array('code' => $formType));
				$data['detail'] = $this->m_global->find($detail, 'request_id', $request_id)->result_array();
				$employee_id = $data['header']['employee_id'];
				$request_created_at = $data['form_request']['created_at'];
				//dumper($data['form_request']);
				$id_eg_prj = $data['header']['id_eg_prj'];
				$id_eg_pri = $data['header']['id_eg_pri'];
				$id_eg_pk  = $data['header']['id_eg_pk'];
				$data['sum_penggantian_jalan'] = $this->form_model->get_sum_penggantian_jalan($request_id);
				$data['sum_penggantian_inap'] = $this->form_model->get_sum_penggantian_inap($request_id);
				$data['sum_penggantian_kacamata'] = $this->form_model->get_sum_penggantian_kacamata($request_id);
				$data['reimaning_pagu'] = $this->form_model->get_reimaning_pagu($request_created_at, $employee_id, $id_eg_prj, $id_eg_pri, $id_eg_pk);
				$data['additional'] = $this->m_global->find($additional, 'request_id', $request_id)->result_array();
				// dumper($data['reimaning_pagu']);
				break;

			case 'PPD':

				$dir =  './uploaded_files/' . $data['form_request']['request_number'] . '/supporting_files';
				$data['uploaded_document'] = $this->doScan($dir);
				$data['list_city'] = $this->form_model->getCity();
				$data['detail'] = $this->m_global->find($detail, 'header_id', $data['header']['id'])->result_array();
				if (!empty($data['detail'][0]['kota_berangkat'])) {
					$data['kota_berangkat'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_berangkat']))->row_array()['NAMA_KABUPATEN_KOTA'];
					$data['kota_tujuan'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_tujuan']))->row_array()['NAMA_KABUPATEN_KOTA'];
					$data['category_city'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_tujuan']))->row_array()['CATEGORY'];
				} else {
				}

				$data['approval_progress'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
				$count = count($data['approval_progress']);
				$data['requestor_layer'] = '';
				$data['layer_1'] = '';
				$data['layer_2'] = '';
				$data['layer_3'] = '';

				// print_r($data['approval_progress']);die;
				if (!empty($data['approval_progress'])) {

					if ($count === 4) {
						$data['requestor_layer'] = $data['approval_progress'][0]['approval_email'];
						$data['layer_1'] = $data['approval_progress'][1]['approval_email'];
						$data['layer_2'] = $data['approval_progress'][2]['approval_email'];
						$data['layer_3'] = $data['approval_progress'][3]['approval_email'];
					} else {
						$data['requestor_layer'] = '';
						$data['layer_1'] = $data['approval_progress'][0]['approval_email'];
						$data['layer_2'] = $data['approval_progress'][1]['approval_email'];
						$data['layer_3'] = $data['approval_progress'][2]['approval_email'];
					}
				}

				break;

			case 'LPD':

				$dir =  './uploaded_files/' . $data['form_request']['request_number'] . '/supporting_files';
				$data['uploaded_document'] = $this->doScan($dir);
				$data['list_city'] = $this->form_model->getCity();
				$data['detail'] = $this->m_global->find($detail, 'header_id', $data['header']['id'])->row_array();
				$data['additional'] = $this->m_global->find($additional, 'header_id', $data['header']['id'])->result_array();

				$data['approval_progress'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
				$count = count($data['approval_progress']);
				$data['requestor_layer'] = '';
				$data['layer_1'] = '';
				$data['layer_2'] = '';
				$data['layer_3'] = '';

				break;

			default:
				break;
		}

		$data['userList'] = $this->form_model->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['employee_list'] = $this->form_model->getUserList("complete_name", "hris_employee", "is_active = 1 AND access_employee != 1 AND complete_name != '$this->emp_name'");
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'form/full_approval/' . $formType;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}
	
	public function read($table, $id)
	{
		//dumper($id);
		$request_id = $id;
		switch ($table) {

			case 'ToR':

				$listToR = $this->form_model->getTypeOfRembursement($request_id);
				$checkRecord = $this->form_model->cek_record($id);

				// dumper($listToR);
				// dumper($checkRecord[0]);
				if (!empty($listToR)) {
					foreach ($listToR as $key) {
						if ($key->is_status == 1 || $key->is_status == 3 || $key->is_status == 4) {
							if($this->session->userdata('access_employee') == '12' && ($checkRecord[0]->is_status_admin_hr == null || $checkRecord[0]->is_status_admin_hr == 0)) {
								$edit = '<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditPrice" data-offset="-4,0" id="'.$key->id.'" onClick="edit_price('.$key->id.')"><em class="icon ni ni-edit"></em></a>';
								$show = '';	
							} else {
								$show = 'none';
								$edit = '';
							}
						} else {
							$edit = '<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditToR" data-offset="-4,0" id="'.$key->id.'" onClick="edit_tor('.$key->id.')"><em class="icon ni ni-edit"></em></a>';
							$show = '';
						}

						if (($key->additional == 'Diri Sendiri')) {
							$additional = $key->additional;
						} else {
							$additional = decrypt($key->additional);
						}
						if (($key->harga_kamar == 'NaN') || (empty($key->harga_kamar)) || ($key->harga_kamar == '') || ($key->harga_kamar == ' ') || ($key->harga_kamar == NULL)) {
							$harga_kamar = 0;
						} else {
							$harga_kamar = $key->harga_kamar;
						}
						$row   = array();
						// $row[] =  '<a class="btn btn-icon btn-trigger delete_tor" style="display: ' . $show . '" id="' . $key->id . '" data="' . $key->request_id . '" onClick="delete_tor(' . $key->id . ')"><em class="icon ni ni-cross-circle-fill"></em></a>';
						// if ($key->is_status == ) {
						// 	# code...
						// } else {
						// 	# code...
						// }
					
						$row[] = '<div class="btn-group btn-group-sm">
												<a class="btn btn-icon btn-trigger delete_tor" style="display: ' . $show . '" id="' . $key->id . '" data="' . $key->request_id . '" onClick="delete_tor(' . $key->id . ')"><em class="icon ni ni-cross-circle-fill"></em></a>
												'.$edit.'	
		                  </div>'
								;
						$row[] =  $key->tor_grandparent . ' - ' . $key->tor_parent . ' - ' . $key->tor_child;
						$row[] =  $key->jumlah_kuitansi;
						$row[] =  number_format($key->total_kuitansi);
						$row[] =  $key->tanggal_kuitansi;
						$row[] =  number_format($key->penggantian);
						$row[] =  $key->keterangan . ' - ' . ucwords(strtolower($additional));
						$row[] =  number_format($harga_kamar);
						$row[] =  $key->docter;
						$row[] =  $key->diagnosa;

						$data[] = $row;
					}
					$output = array('data' => $data);
				} else {
					$output = array('data' => new ArrayObject());
				}
				echo json_encode($output);
				break;


			default:
				break;
		}
	}

	public function save($method, $formType = "")
	{
		switch ($method) {

			case 'request_notes':

				$id = $this->input->post('request_id');
				$field['request_id'] = $id;
				$field['notes'] = $this->input->post('notes', FALSE);
				$field['created_by'] = $this->email;
				$field['created_at'] = $this->date;

				if ($this->db->insert('request_notes', $field)) {
					$this->logs('save_request_notes', $id, 'Request Notes');
					$response = array('status' => 1, 'request_id' => encode_url($id), 'messages' => 'Notes has been saved.');
				} else {
					$this->logs('system', $id, 'Failed while saving Request notes.');
					$response = array('status' => 0, 'messages' => 'There\s something wrong. Please try again.');
				}

				echo json_encode($response);
				 break;

			case 'delete_request_notes':

				$id_request = $this->input->post('id_request');
				$id_notes = $this->input->post('id_notes');

				if ($this->db->where(array('id' => $id_notes, 'request_id' => $id_request))->delete('request_notes')) {
					$this->logs('delete_request_notes', $id, 'Request Notes');
					$response = array('status' => 1, 'messages' => 'Notes has been deleted.');
				} else {
					$response = array('status' => 0, 'messages' => 'There\s something wrong. Please refresh the page and try again.');
				}

				echo json_encode($response);
				break;
			
			/////////////////////////////////////////START Update Source Code Performance Appraisal 2024////////////////////////////////////////////

			case 'add_kpi':

				$request_id = $this->input->post('request_id');
				$kpi_row = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['count_row_kpi'];
				$total_row_kpi = ($kpi_row + 1);

				$detail = array(
					'request_id' => $request_id,
					'objective' => encrypt($this->input->post('kpi_objective', FALSE)),
					'measurement' => encrypt($this->input->post('kpi_measurement', FALSE)),
					'target_per_year' => encrypt($this->input->post('kpi_target', FALSE)),
					'achievement' => encrypt($this->input->post('kpi_achievement', FALSE)),
					'unit' => encrypt($this->input->post('unit', FALSE)),
					'target_vs_achievement' => encrypt($this->input->post('kpi_target_vs_achievement', FALSE)),
					'score' => encrypt($this->input->post('kpi_score', FALSE)),
					'time' => encrypt($this->input->post('kpi_time', FALSE)),
					'total' => encrypt($this->input->post('kpi_total_row', FALSE)),
					'created_by' => encrypt($this->email),
					'created_at' => $this->date
				);

				$header = array(
					'sub_total_weight' => encrypt($this->input->post('total_weight', FALSE)),
					'sub_total_kpi' => encrypt($this->input->post('total_kpi', FALSE)),
					'grand_total_kpi' => encrypt($this->input->post('grand_total_kpi', FALSE)),
					'pre_final_score' => encrypt($this->input->post('pre_final_score', FALSE)),
					'final_score' => encrypt($this->input->post('pre_final_score', FALSE)),
					'count_row_kpi' => $total_row_kpi,
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				$this->db->insert('performance_appraisal_measurement', $detail);
				$kpi_id = $this->db->insert_id();

				$score_isi 	= $this->db->query("select count(*) as jumlah_isi from performance_appraisal_measurement where request_id = '$request_id' AND score is not null")->row_array()['jumlah_isi'];
				
				if ($kpi_id != '') {
					$this->logs('add_kpi_row', 'KPI', $request_id);

					$this->db->where('id', $request_id);
					$updateHeader = $this->db->update('performance_appraisal', $header);
					
					if ($updateHeader) {
						$response 	= array('status' => 1, 'id' => $kpi_id, 'update_score_isi' => $score_isi, 'count_row_kpi' =>$total_row_kpi);

					} else {
						$this->db->delete('performance_appraisal_measurement', array('id' => $kpi_id));
						$response = array('status' => 0, 'update_score_isi' => $score_isi, 'count_row_kpi' =>$total_row_kpi);
					}

				} else {
					$response = array('status' => 0, 'update_score_isi' => $score_isi, 'count_row_kpi' =>$total_row_kpi);
				}

				echo json_encode($response);
				break;

			case 'update_kpi':

				$request_id = $this->input->post('request_id');
				$id_detail = $this->input->post('id_detail');

				$detail = array(
					'objective' => encrypt($this->input->post('kpi_objective', FALSE)),
					'measurement' => encrypt($this->seo_friendly_url($this->input->post('kpi_measurement', FALSE))),
					'target_per_year' => encrypt($this->input->post('kpi_target', FALSE)),
					'achievement' => encrypt($this->input->post('kpi_achievement', FALSE)),
					'target_vs_achievement' => encrypt($this->input->post('kpi_target_vs_achievement', FALSE)),
					'score' => encrypt($this->input->post('kpi_score', FALSE)),
					'time' => encrypt($this->input->post('kpi_time', FALSE)),
					'total' => encrypt($this->input->post('kpi_total_row', FALSE)),
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date,
					'unit' => encrypt($this->input->post('unit', FALSE)),
				);

				$header = array(
					'sub_total_weight' => encrypt($this->input->post('total_weight', FALSE)),
					'sub_total_kpi' => encrypt($this->input->post('total_kpi', FALSE)),
					'grand_total_kpi' => encrypt($this->input->post('grand_total_kpi', FALSE)),
					'pre_final_score' => encrypt($this->input->post('pre_final_score', FALSE)),
					'final_score' => encrypt($this->input->post('pre_final_score', FALSE)),
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				// dumper($header);
				

				$this->db->where('id', $id_detail);
				$updateDetail = $this->db->update('performance_appraisal_measurement', $detail);

				$score_isi 	= $this->db->query("select count(*) as jumlah_isi from performance_appraisal_measurement where request_id = '$request_id' AND score is not null")->row_array()['jumlah_isi'];

				if ($updateDetail) {
					$this->logs('update_kpi_row', 'KPI', $request_id, 'Update KPI item', 'Success update detail');

					$this->db->where('id', $request_id);
					$updateHeader = $this->db->update('performance_appraisal', $header);
					
					if ($updateHeader) {
						$this->logs('update_kpi_row', 'KPI', $request_id, 'Update KPI item', 'Success update header');
						$response = array('status' => 1, 'update_score_isi' => $score_isi);

					} else {
						$this->logs('update_kpi_row', 'KPI', $request_id, 'Update KPI item', 'Failed update header');
						$response = array('status' => 0, 'update_score_isi' => $score_isi);
					}

				} else {
					$this->logs('update_kpi_row', 'KPI', $request_id, 'Update KPI item', 'Failed update detail');
					$response = array('status' => 0, 'update_score_isi' => $score_isi);
				}

				echo json_encode($response);
				break;

			case 'add_plan':

				$request_id = $this->input->post('request_id');
				$perspective = $this->input->post('plan_perspective');

				switch ($perspective) {
					case 'financial_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['count_plan_financial'];
						$field = 'financial';
						break;
					case 'intern_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['count_plan_internal'];
						$field = 'internal';
						break;
					case 'cust_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['count_plan_customer'];
						$field = 'customer';
						break;
					case 'learn_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['count_plan_learning'];
						$field = 'learning';
						break;
					default:
						break;
				}

				$total_row_plan = ($count_plan + 1);

				$detail = array(
					'request_id' => $request_id,
					'objective' => encrypt($this->input->post('objective', FALSE)),
					'measurement' => encrypt($this->input->post('measurement', FALSE)),
					'time' => encrypt($this->input->post('time', FALSE)),
					'unit' => encrypt($this->input->post('unit', FALSE)),
					'target' => encrypt($this->input->post('target', FALSE)),
					'semester_1' => encrypt($this->input->post('semester_1', FALSE)),
					'semester_2' => encrypt($this->input->post('semester_2', FALSE)),
					'total' => encrypt($this->input->post('total', FALSE)),
					'plan_perspective' => encrypt($this->input->post('plan_perspective', FALSE)),
					'created_by' => encrypt($this->email),
					'created_at' => $this->date
				);

				$header = array(
					'plan_total_weight' => encrypt($this->input->post('plan_total_weight', FALSE)),
					'count_plan_'.$field => $total_row_plan,
					'created_by' => encrypt($this->email),
					'created_at' => $this->date
				);

				$this->db->insert('performance_appraisal_plan', $detail);
				$plan_id = $this->db->insert_id();

				if ($plan_id != '') {

					$this->db->where('id', $request_id);
					$updateHeader = $this->db->update('performance_appraisal', $header);

					if ($updateHeader) {
						$this->logs('add_plan_row', 'PLAN', $request_id);
						$response = array('status' => 1, 'id' => $plan_id);

					} else {
						$this->db->delete('performance_appraisal_plan', array('id' => $plan_id));
						$response = array('status' => 0);
					}

				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'add_training':

				$request_id = $this->input->post('request_id');
				$training_name = $this->input->post('training_name', FALSE);
				$training_desc = $this->input->post('training_desc', FALSE);
				$training_cat = $this->input->post('training_category', FALSE);

				$detail_training = array(
					'request_id' => $request_id,
					'training_name' => encrypt($this->input->post('training_name', FALSE)),
					'training_desc' => encrypt($this->input->post('training_desc', FALSE)),
					'category' => encrypt($training_cat),
					'created_by' => encrypt($this->email),
					'created_at' => $this->date
				);


				//==========check double===============//
				$query = "select * from performance_appraisal_training where request_id = '$request_id' and training_name = '".encrypt($this->input->post('training_name', FALSE))."'";
				$check= $this->db->query($query);
				$num = $check->num_rows();
				// echo $num. " XXXX ";
				// die;
				if($num == 1){
					$response = array('status' => 2);
					echo json_encode($response);
					die;
				}
				
				
				$this->db->insert('performance_appraisal_training', $detail_training);
				$training_id = $this->db->insert_id();

				if ($training_id != '') {

					$query = "select * from performance_appraisal_training where request_id = '$request_id'";
					$check= $this->db->query($query);
					$num = $check->num_rows();

					if($num == ""){
						$num = 0;
					}

					$this->db->query("update performance_appraisal set count_training = '$num' where id = '$request_id'");


					$this->logs('add_training', 'KPI', $request_id);
					$response = array('status' => 1, 'id' => $training_id, 'count_training' => $num);

				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'delete_training':

				$id_training = $this->input->post('id_training');
				$id_request = $this->input->post('id_request');

				if ($this->db->where('id', $id_training)->delete('performance_appraisal_training')) {
					$this->db->query("update performance_appraisal set count_training = count_training-1 where id = '$id_request'");
					$this->logs('delete_training', 'KPI', $id_request);
					
					$query = "select * from performance_appraisal_training where request_id = '$id_request'";
					$check= $this->db->query($query);
					$num = $check->num_rows();

					if($num == ""){
						$num = 0;
					}

					$response = array('status' => 1,'count_training' => $num);
					

				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'update_plan':

				$request_id = $this->input->post('request_id');
				$id_detail = $this->input->post('id_detail');

				$detail = array(
					'objective' => encrypt($this->input->post('plan_objective', FALSE)),
					'measurement' => encrypt($this->input->post('plan_measurement', FALSE)),
					'time' => encrypt($this->input->post('plan_new_time', FALSE)),
					'unit' => encrypt($this->input->post('plan_unit', FALSE)),
					'target' => encrypt($this->input->post('plan_target', FALSE)),
					'semester_1' => encrypt($this->input->post('plan_semester_1', FALSE)),
					'semester_2' => encrypt($this->input->post('plan_semester_2', FALSE)),
					'total' => encrypt($this->input->post('plan_total', FALSE)),
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				$header = array(
					'plan_total_weight' => encrypt($this->input->post('new_total_weight', FALSE)),
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				$this->db->where('id', $id_detail);
				$updateDetail = $this->db->update('performance_appraisal_plan', $detail);

				if ($updateDetail) {
					$this->logs('update_plan_row', 'PLAN', $request_id, 'Update Plan item', 'Success update detail');

					$this->db->where('id', $request_id);
					$updateHeader = $this->db->update('performance_appraisal', $header);
					
					if ($updateHeader) {
						$this->logs('update_plan_row', 'PLAN', $request_id, 'Update Plan item', 'Success update header');
						$response = array('status' => 1);

					} else {
						$this->logs('update_plan_row', 'PLAN', $request_id, 'Update Plan item', 'Failed update header');
						$response = array('status' => 0);
					}

				} else {
					$this->logs('update_plan_row', 'PLAN', $request_id, 'Update Plan item', 'Failed update detail');
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'submit':

				$request_id = $this->input->post('id');
				$id_form_request = $this->input->post('id_form_request');
				$is_status = $this->input->post('is_status');

				$save = $this->form_model->save_form($formType, $this->input->post());

				if ($save) {

					//==update form_request is_status = 1==/
					$this->db->where('id',$id_form_request);
					$this->db->update('form_request',array("is_status" => 1));
					//=====================================/

					if ($this->saveApprovalPa($id_form_request)) {

						// $email = $this->input->post('approval_layer');
						// $first_layer = $email[0];
						$this->m_services->sendEmailPA($request_id,'need_response');
						// $this->sendEmailPa('need_response', $request_id, $first_layer);

						$this->logs('submit_request', $formType, $id_form_request);
						$response = array('status' => 1);

						$this->db->where('request_id', $id_form_request);
						$this->db->update('request_notes', array('is_status' => 0));

					} else {
						$this->logs('system', $formType, $id_form_request, 'Failed when saving approval layer');
						$response = array('status' => 0);
					}

				} else {
					$this->logs('system', $formType, $requestId, 'Failed when saving data request');
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

				case 'submit_new_employee':

					$request_id = $this->input->post('id');
					$id_form_request = $this->input->post('id_form_request');
					$is_status = $this->input->post('is_status');

					$save = $this->form_model->save_form($formType, $this->input->post());

					if ($save) {

						//==update form_request is_status = 1==/
						$this->db->where('id',$id_form_request);
						$this->db->update('form_request',array("is_status" => 1));
						//=====================================/

						if ($this->saveApprovalPa($id_form_request)) {

							$email = $this->input->post('approval_layer');
							$first_layer = $email[0];
							$this->m_services->sendEmailPA($request_id,'need_response');
							// $this->sendEmailPa('need_response', $request_id, $first_layer);

							$this->logs('submit_request', $formType, $id_form_request);
							$response = array('status' => 1);

							$this->db->where('request_id', $id_form_request);
							$this->db->update('request_notes', array('is_status' => 0));

						} else {
							$this->logs('system', $formType, $id_form_request, 'Failed when saving approval layer');
							$response = array('status' => 0);
						}

					} else {
						$this->logs('system', $formType, $id_form_request, 'Failed when saving data request');
						$response = array('status' => 0);
					}

					echo json_encode($response);
					break;

				case 'pre_final_score':

					$request_id = $this->input->post('request_id');

					$formData = array(
						'pre_final_score' => $this->input->post('pre_final_score', FALSE),
						'grand_total_kpi' => $this->input->post('grand_total_kpi', FALSE),
						'grand_total_qualitative' => $this->input->post('grand_total_qualitative', FALSE),
						'updated_by' => $this->email,
						'updated_at' => $this->date
					);

					$this->db->where('id', $request_id);
					$updateHeader = $this->db->update('performance_appraisal', $formData);

					if ($updateHeader) {
						$response = array('status' => 1);
					} else {
						$response = array('status' => 0);
					}

					echo json_encode($response);
					break;
			/////////////////////////////////////////END Update Source code Performance Appraisal 2024////////////////////////////////////////////
				default:
					break;
		}
	}

	function saveApprovalMDCR($tor, $request_id, $is_status)
	{
		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();

		switch ($tor) {
			case 'rawat_inap':
				$this->db->order_by('id_employee', 'DESC');
				$data_layer = $this->db->get_where('hris_employee', array('nik' => $this->emp_id))->row_array();
				// dumper(decrypt($data_layer['department_head']));
				// dumper(encrypt('00000000'));
				$list_email = array();
				// if ($data_layer['usrid_long1'] != '') { array_push($list_email, strtolower(decrypt($data_layer['usrid_long1']))); } // superior
				// if ($data_layer['usrid_long2'] != '') { array_push($list_email, strtolower(decrypt($data_layer['usrid_long2']))); } // dept head
				// if ($data_layer['usrid_long3'] != '') { array_push($list_email, strtolower(decrypt($data_layer['usrid_long3']))); } // div head
				// if ($data_layer['usrid_long4'] != '') { array_push($list_email, strtolower(decrypt($data_layer['usrid_long4']))); } // director


				$list_nik = array();
				if (($data_layer['superior'] != '') && ($data_layer['superior'] != ' ') && ($data_layer['superior'] != '88888888') && ($data_layer['superior'] != '00000000') && ($data_layer['superior'] != '8') && ($data_layer['superior'] != '0')) {
					array_push($list_nik, strtolower(decrypt($data_layer['superior'])));
					array_push($list_email, strtolower(decrypt($data_layer['usrid_long1'])));
				} // superior
				if (($data_layer['department_head'] != '') && ($data_layer['department_head'] != '88888888') && ($data_layer['department_head'] != '00000000') && ($data_layer['department_head'] != '8') && ($data_layer['department_head'] != '0')) {
					array_push($list_nik, strtolower(decrypt($data_layer['department_head'])));
					array_push($list_email, strtolower(decrypt($data_layer['usrid_long2'])));
				} // dept head
				// dumper($list_nik);
				if (($data_layer['division_head'] != '') && ($data_layer['division_head'] != '88888888') && ($data_layer['division_head'] != '00000000') && ($data_layer['division_head'] != '8') && ($data_layer['division_head'] != '0')) {
					array_push($list_nik, strtolower(decrypt($data_layer['division_head'])));
					array_push($list_email, strtolower(decrypt($data_layer['usrid_long3'])));
				} // div head
				if (($data_layer['director'] != '') && ($data_layer['director'] != '88888888') && ($data_layer['director'] != '00000000') && ($data_layer['director'] != '8') && ($data_layer['director'] != '0')) {
					array_push($list_nik, strtolower(decrypt($data_layer['director'])));
					array_push($list_email, strtolower(decrypt($data_layer['usrid_long4'])));
				} // director

				//dumper($data_layer);
				if (count($list_email) > 0 && count($list_nik) > 0) {
					$layer = array($list_email[0],'hr.support@ibsmulti.com', 'ANANDHA.HOKKY@IBSMULTI.COM', 'ap.ibsw@ibsmulti.com', 'treasury.ibsw@ibsmulti.com');
					$layer_nik = array($list_nik[0],'00000000', '20260004', '00000001', '00000008');

					$this->sendEmail('request_approve_mdcr', $request_id, $list_email[0], $list_nik[0]);
					// $this->sendEmail('request_approve_mdcr', $request_id, 'muhammad.zulvan@ibsmulti.com', '');

					$config['cacheable']    = true;
					$config['cachedir']     = './assets/';
					$config['errorlog']     = './assets/';
					$config['imagedir']     = './assets/images/qrcode_mdcr/';
					$config['imagelogo']    = './assets/images/IBS.png';
					$config['quality']      = true;
					$config['size']         = '1024';
					$config['black']        = array(224, 255, 255);
					$config['white']        = array(70, 130, 180);
					$this->ciqrcode->initialize($config);

					$image_name_SPR 		= $data['form_request']['request_number'] . '-ApprovedBySPR.png';
					$paramsSPR['data'] 		= $data['form_request']['request_number'] . '-ApprovedBySPR-' . $list_email[0];
					$paramsSPR['level'] 	= 'H'; //H=High
					$paramsSPR['size'] 		= 10;
					$paramsSPR['savename'] 	= FCPATH . $config['imagedir'] . $image_name_SPR;
					$paramsSPR['logo'] 		= FCPATH . $config['imagelogo'];
					$paramsSPR['imagetmp'] 	= $config['imagedir'];
					$this->ciqrcode->generate($paramsSPR);

					$image_name_HR 			= $data['form_request']['request_number'] . '-ApprovedByHR.png';
					$paramsHR['data'] 		= $data['form_request']['request_number'] . '-ApprovedByHR-hr.support@ibsmulti.com';
					$paramsHR['level'] 		= 'H'; //H=High
					$paramsHR['size'] 		= 10;
					$paramsHR['savename'] 	= FCPATH . $config['imagedir'] . $image_name_HR;
					$paramsHR['logo'] 		= FCPATH . $config['imagelogo'];
					$paramsHR['imagetmp'] 	= $config['imagedir'];
					$this->ciqrcode->generate($paramsHR);
				}

				break;
			case 'non_rawat_inap':
				$layer = array('hr.support@ibsmulti.com', 'ANANDHA.HOKKY@IBSMULTI.COM', 'ap.ibsw@ibsmulti.com', 'treasury.ibsw@ibsmulti.com');
				$layer_nik = array('00000000', '20260004', '00000001', '00000008');
				$this->sendEmail('request_approve_mdcr_hr', $request_id, 'hr.support@ibsmulti.com', '00000000');

				$config['cacheable']    = true;
				$config['cachedir']     = './assets/';
				$config['errorlog']     = './assets/';
				$config['imagedir']     = './assets/images/qrcode_mdcr/';
				$config['imagelogo']    = './assets/images/IBS.png';				
				$config['quality']      = true;
				$config['size']         = '1024';
				$config['black']        = array(224, 255, 255);
				$config['white']        = array(70, 130, 180);
				$this->ciqrcode->initialize($config);

				$image_name_HR 			= $data['form_request']['request_number'] . '-ApprovedByHR.png';
				$paramsHR['data'] 		= $data['form_request']['request_number'] . '-ApprovedByHR-hr.support@ibsmulti.com';
				$paramsHR['level'] 		= 'H'; //H=High
				$paramsHR['size'] 		= 10;
				$paramsHR['savename'] 	= FCPATH . $config['imagedir'] . $image_name_HR;
				$paramsHR['logo'] 		= FCPATH . $config['imagelogo'];
				$paramsHR['imagetmp'] 	= $config['imagedir'];
				$this->ciqrcode->generate($paramsHR);

				break;
		}
		// dumper($layer);
		if (!empty($layer)) {
			return $this->form_model->saveApproval($layer, $request_id, $layer_nik);
		} else {
			return false;
		}
	}

	public function delete($type)
	{
		switch ($type) {

			case 'kpi_item':

				$header_id = $this->input->post('request_id');
				$detail_id = $this->input->post('measurement_id');
				$kpi_row = $this->m_global->find('performance_appraisal', 'id', $header_id)->row_array()['count_row_kpi'];
				$total_row_kpi = ($kpi_row - 1);

				$updateHeader = array(
					'sub_total_weight' => encrypt($this->input->post('total_weight', FALSE)),
					'sub_total_kpi' => encrypt($this->input->post('total_kpi', FALSE)),
					'grand_total_kpi' => encrypt($this->input->post('grand_total_kpi', FALSE)),
					'pre_final_score' => encrypt($this->input->post('pre_final_score', FALSE)),
					'final_score' => encrypt($this->input->post('pre_final_score', FALSE)),
					'count_row_kpi' => $total_row_kpi,
				);

				if ($this->db->where('id', $detail_id)->delete('performance_appraisal_measurement')) {
					// update Header
					$this->db->where('id', $header_id);
					if ($this->db->update('performance_appraisal', $updateHeader)) {

						$this->logs('delete_kpi_row', 'KPI', $header_id);
						$response = array('status' => 1, 'messages' => 'Delete item succesfully.');
					} else {
						$this->logs('system', 'KPI', $header_id, 'Delete KPI item', 'Failed');
						$response = array('status' => 0, 'messages' => 'Delete KPI item failed.');
					}
				} else {
					$this->logs('system', 'KPI', $header_id, 'Delete KPI item', 'Failed');
					$response = array('status' => 0, 'messages' => 'Delete KPI item failed.');
				}

				echo json_encode($response);
				break;

			case 'plan_item':

				$header_id = $this->input->post('request_id');
				$detail_id = $this->input->post('plan_id');
				$plan_perspective = $this->m_global->find('performance_appraisal_plan', 'id', $detail_id)->row_array()['plan_perspective'];

				switch (decrypt($plan_perspective)) {
					case 'financial_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $header_id)->row_array()['count_plan_financial'];
						$field = 'financial';
						break;
					case 'intern_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $header_id)->row_array()['count_plan_internal'];
						$field = 'internal';
						break;
					case 'cust_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $header_id)->row_array()['count_plan_customer'];
						$field = 'customer';
						break;
					case 'learn_perspective':
						$count_plan = $this->m_global->find('performance_appraisal', 'id', $header_id)->row_array()['count_plan_learning'];
						$field = 'learning';
						break;
					default:
						break;
				}
				
				$total_plan_row = ($count_plan - 1);

				$updateHeader = array(
					'plan_total_weight' => encrypt($this->input->post('plan_total_weight', FALSE)),
					'count_plan_' . $field => $total_plan_row
				);

				if ($this->db->where('id', $detail_id)->delete('performance_appraisal_plan')) {

					$this->db->where('id', $header_id);
					if ($this->db->update('performance_appraisal', $updateHeader)) {

						$this->logs('delete_plan_row', 'KPI', $header_id);
						$response = array('status' => 1, 'perspective' => $field, 'messages' => 'Delete Plan item succesfully.');
					} else {
						$this->logs('system', 'KPI', $header_id, 'Delete KPI item', 'Failed');
						$response = array('status' => 0, 'messages' => 'Delete Plan item failed.');
					}
				} else {
					$this->logs('system', 'KPI', $header_id, 'Delete Plan item', 'Failed');
					$response = array('status' => 0, 'messages' => 'Delete Plan item failed.');
				}

				echo json_encode($response);
				break;

			default:
				break;
		}
	}

	public function getUserList()
	{
		$userList = $this->form_model->getAll("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		echo json_encode($userList);
	}

	private function createRequestNumber($formType, $table)
	{
		$year = date('Y');
		$this->db->trans_begin();
		$this->db->where('year', $year);
		$this->db->where('form_type', $formType);
		$query = $this->db->get('request_sequence');

		if ($query->num_rows() === 0) {
			$reqnum = 1;
			$this->db->insert('request_sequence', [
				'year'        => $year,
				'form_type'   => $formType,
				'last_number' => $reqnum
			]);
		} else {
			$row = $query->row();
			$reqnum = $row->last_number + 1;

			$this->db->where('id', $row->id);
			$this->db->update('request_sequence', [
				'last_number' => $reqnum
			]);
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			throw new Exception('Gagal generate request number');
		}
		$this->db->trans_commit();
		$requestNumber = sprintf(
			'HRIS_%s_%s%06d',
			$formType,
			$year,
			$reqnum
		);

		return $requestNumber;
	}

	private function getEmailSuperior($nik)
	{
		// print_r($nik);die;
		// $superior_nik = decrypt($this->db->get_where('hris_employee', array('nik' => $nik))->row_array()['superior']);
		//$superior_nik = '20131111';
		$superior_email = decrypt($this->db->get_where('hris_employee', array('nik' => $nik))->row_array()['email']);
		return $superior_email;
	}

	public function getDetailEmployee()
	{
		$nik = $this->input->post('employee_nik');
		$data = $this->db->get_where('hris_employee', array('nik' => $nik))->row_array();
		$grade = decrypt($data['employee_group']);

		$pagu = $this->m_global->find('hris_trip_pagu', 'grade', $grade)->row_array();
		$diem = $pagu['diem'];
		$hotel_primary_cities = $pagu['hotel_primary_cities'];
		$hotel_secondary_cities = $pagu['hotel_secondary_cities'];
		$tipe_penerbangan = $pagu['tipe_penerbangan'];
		$laundry = $pagu['laundry'];
		$bagasi = $pagu['bagasi'];

		$data_layer = $this->db->get_where('hris_employee', array('nik' => $nik))->row_array();
		$list_email = array();

		if ($data_layer['usrid_long5'] != '') {
			array_push($list_email, strtolower(decrypt($data_layer['usrid_long5'])));
		} // rpm
		if ($data_layer['usrid_long1'] != '') {
			array_push($list_email, strtolower(decrypt($data_layer['usrid_long1'])));
		} // superior
		if ($data_layer['usrid_long2'] != '') {
			array_push($list_email, strtolower(decrypt($data_layer['usrid_long2'])));
		} // dept head
		if ($data_layer['usrid_long3'] != '') {
			array_push($list_email, strtolower(decrypt($data_layer['usrid_long3'])));
		} // div head
		if ($data_layer['usrid_long4'] != '') {
			array_push($list_email, strtolower(decrypt($data_layer['usrid_long4'])));
		} // director
		$data['approval_layer'] = $list_email;

		// print_r($data['approval_layer']);die;
		if ($nik != $this->emp_id) {
		}

		$data['layer_1'] = !empty($data['approval_layer'][0]) ? $data['approval_layer'][0] : '';
		$data['layer_2'] = !empty($data['approval_layer'][1]) ? $data['approval_layer'][1] : '';
		$data['hr_layer_1'] = 'hr.support@ibsmulti.com';
		$data['hr_layer_2'] = 'hr.support@ibsmulti.com';

		if (!empty($data)) {

			$response = array(
				'status' => true,
				'name' => decrypt($data['complete_name']),
				'email' => strtolower(decrypt($data['email'])),
				'division' => decrypt($data['division']),
				'position' => decrypt($data['position']),
				'cost_center' => decrypt($data['cost_center']),
				'lokasi_kantor' => decrypt($data['personnel_area']),
				'range_grade' => range_grade($grade),
				'nom_diem' => $diem,
				'nom_hotel' => $hotel_primary_cities,
				'tipe_penerbangan' => $tipe_penerbangan,
				'laundry' => $laundry,
				'bagasi' => $bagasi,
				'layer_1' => $data['layer_1'],
				'layer_2' => $data['layer_2'],
				'hr_layer_1' => $data['hr_layer_1'],
				'hr_layer_2' => $data['hr_layer_2'],
			);
		} else {
			$response = array('status' => false, 'message' => 'NIK Not Found');
		}
		echo json_encode($response);
	}

	public function update($flag = '')
	{
		switch ($flag) {
			case 'show-form':

				$id = $this->input->post('id');
				$detail_request = $this->m_approval->find_select("id, formPurpose, formNotes", array('id' => $id), 'form_request')->row_array();

				header('Content-type: application/json');
				echo json_encode(array(
					"request" => $detail_request,
				));

				break;

			case 'save':

				$response = array('status' => 0, 'message' => 'Failed while updating your request. Please try again.');

				if (isset($_POST['modalrequest_id'])) {

					$id = $_POST['modalrequest_id'];
					$requestNumber = $_POST['modalrequest_number'];
					$uploadDir = './upload/' . $requestNumber . '/';

					if (isset($_POST['modalformPurpose']) || isset($_POST['modalformNotes']) || isset($_FILES['afsUpload']['name']) || isset($_FILES['multiSupportingFiles']['name'])) {

						$formPurpose = $_POST['modalformPurpose'];
						$formNotes = $_POST['modalformNotes'];

						if (!empty($formPurpose) && !empty($formNotes)) {

							$uploadStatus = 1;

							$data = array('formPurpose' => $formPurpose, 'formNotes' => $formNotes);
							$this->db->where('id', $id);

							if ($this->db->update('form_request', $data)) {
								$uploadStatus = 1;
								$response['message'] = 'Request updated successfully.';
							} else {
								$uploadStatus = 0;
								$response['message'] = 'Sorry, there was an error while updating request data.';
							}

							// Upload file 
							$uploadedFile = '';
							if (!empty($_FILES['afsUpload']['name'])) {

								$type  = explode('.', $_FILES['afsUpload']['name']);
								$types = strtolower($type[count($type) - 1]);
								$uploadname = $requestNumber . '_' . uniqid() . '.' . $types;

								// File path config 
								$fileName = basename($uploadname);
								$targetFilePath = $uploadDir . $fileName;
								$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

								$allowTypes = array('pdf');
								if (in_array($fileType, $allowTypes)) {

									if (move_uploaded_file($_FILES["afsUpload"]["tmp_name"], $targetFilePath)) {

										$pdfVersion = "1.4";
										$newFile = './upload/' . $requestNumber . '/convert/' . $fileName;
										$currentFile = './upload/' . $requestNumber . '/' . $fileName;

										$gsCmd = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=$pdfVersion -dNOPAUSE -dBATCH -sOutputFile=$newFile $currentFile";

										$this->db->where('id', $id)->update('form_request', array('approvalFormScanned' => $fileName));

										// if (exec($gsCmd)) {

										// 	$uploadedFile = $fileName;
										// 	$this->db->where('id', $id)->update('form_request', array('approvalFormScanned' => $fileName));
										// } else {

										// 	$uploadStatus = 0;
										// 	$response['message'] = 'File uploaded successfully but failed to convert.';
										// }
									} else {
										$uploadStatus = 0;
										$response['message'] = 'Sorry, there was an error uploading Approval FIle Scanned file.';
									}
								} else {
									$uploadStatus = 0;
									$response['message'] = 'Sorry, only PDF & Excel files are allowed to upload.';
								}
							}

							if (!empty($_FILES['multiSupportingFiles']['name'])) {

								if (!is_dir('upload/' . $requestNumber . '/supporting_files/')) {
									mkdir('./upload/' . $requestNumber . '/supporting_files/', 0777, TRUE);
								}

								$count = count($_FILES['multiSupportingFiles']['name']);

								for ($i = 0; $i < $count; $i++) {

									if (!empty($_FILES['multiSupportingFiles']['name'][$i])) {

										$allowTypes = array('xlsx', 'xls', 'jpg', 'jpeg', 'png', 'pptx', 'doc', 'docx', 'pdf');
										$path =  getcwd() . '/upload/' . $requestNumber . '/supporting_files/';
										$names  = $_FILES['multiSupportingFiles']['name'][$i];
										$uploadname = str_replace(' ', '_', $names);

										// File path config 
										$fileName = basename($uploadname);
										$targetFilePath = $path . $fileName;
										$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

										if (in_array($fileType, $allowTypes)) {

											if (move_uploaded_file($_FILES["multiSupportingFiles"]["tmp_name"][$i], $targetFilePath)) {
												$uploadedFile = $fileName;
											} else {
												$uploadStatus = 0;
												$response['message'] = 'There was an error uploading supporting files. Please refresh the page and try again.';
											}
										} else {
											$uploadStatus = 0;
											$response['message'] = 'Sorry, please check your file format again.';
										}
									}
								}
							}

							if ($uploadStatus == 1) {
								$response['status'] = 1;
								$response['message'] = 'Request form updated successfully!';
							}
						} else {
							$response['message'] = 'Please fill all the mandatory fields (Purpose and Notes).';
						}
					}
				}

				echo json_encode($response);
				break;

			case 'add-layer':

				$id = $this->input->post('id');
				header('Content-type: application/json');
				echo json_encode(array("id" => $id));
				break;

			case 'save-add-layer':

				$response = array('status' => 0, 'message' => 'Failed while saving new layer.');
				$request_id = $_POST['req_id_add_layer'];
				$layer = $this->input->post('emailuser');

				## Get last layer
				$sql = "SELECT TOP 1 id, approval_priority, approval_status FROM form_approval WHERE request_id = $request_id ORDER BY approval_priority DESC ";
				$last_layer = $this->db->query($sql)->row_array();
				$approval_priority = $last_layer['approval_priority'];
				$approval_status = $last_layer['approval_status'];

				if (empty($approval_status)) {
					$approval_status = 'empty';
				}

				if ($this->m_approval->addLayer($approval_priority, $approval_status, $layer, $request_id)) {
					$transok = true;
				} else {
					$this->logs('system', $request_id, 'Failed while saving new layer.');
					$transok = false;
				}

				if ($transok) {
					$request_status = $this->m_approval->find('id', $request_id, 'form_request')->row_array()['is_status'];
					$response = array('status' => 1, 'message' => 'New layer has been added.', 'request_status' => $request_status);
				}

				header('Content-type: application/json');
				echo json_encode($response);
				break;

			case 'save-change-layer':

				$response = array('status' => 0, 'message' => 'Failed while changing layer.');
				$id = $this->input->post('req_id_change_layer');
				$approval_id = $this->input->post('app_id_change_layer');
				$email = $this->input->post('email_user');

				if ($email === 'makmur@ibsmulti.com' || $email === 'farida@ibsmulti.com') {
					$alias = 'Commitee';
				} else {
					$alias = str_replace('@ibsmulti.com', '', $email);
				}

				if ($this->db->where('id', $approval_id)->update('form_approval', array('approval_email' => $email, 'approval_alias' => $alias))) {
					$transok = true;
				} else {
					$this->logs('system', $id, 'Failed while changing layer.');
					$transok = false;
				}

				if ($transok) {
					$response = array('status' => 1, 'message' => 'Layer changed successfully.');
				}

				header('Content-type: application/json');
				echo json_encode($response);
				break;

			case 'remove-layer':

				$response = array('status' => 0, 'message' => 'Failed while removing layer.');
				$request_id = $this->input->post('id');
				$approval_id = $this->input->post('approval_id');

				$sql = "SELECT approval_email, approval_priority, approval_status FROM form_approval WHERE id = $approval_id";
				$current_layer = $this->db->query($sql)->row_array();

				$approval_priority = $current_layer['approval_priority'];
				$approval_status = $current_layer['approval_status'];
				$approval_email = $current_layer['approval_email'];

				if ($this->m_approval->removeLayer($request_id, $approval_id, $approval_email, $approval_priority, $approval_status)) {
					$transok = true;
				} else {
					$this->logs('system', $request_id, 'Failed while removing layer.');
					$transok = false;
				}

				if ($transok) {
					$request_status = $this->m_approval->find('id', $request_id, 'form_request')->row_array()['is_status'];
					$response = array('status' => 1, 'message' => 'Selected layer has been removed.', 'request_status' => $request_status);
				}

				header('Content-type: application/json');
				echo json_encode($response);
				break;

			default:
				break;
		}
	}

	public function add_notes()
	{
		$transok = 0;
		$notes = array(
			'request_id' => $this->input->post('request_id'),
			'created_by' => $this->email,
			'created_at' => $this->date,
			'approval_response' => 'Add Notes',
			'approval_notes' => $this->input->post('requestor_notes', FALSE),
		);

		if ($this->db->insert('logs', $notes)) {
			$transok = 1;
		}

		echo json_encode($transok);
	}

	// public function sendMail()
	// {
	// 	// $to                 = $this->request->getPost('to');
	// 	//   $subject            = $this->request->getPost('subject');
	// 	//   $message            = $this->request->getPost('message');


	// 	// try {
	// 	$mail = new PHPMailer();
	// 	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
	// 	$mail->isSMTP();
	// 	$mail->Host       = 'mail.ibsmulti.com';
	// 	$mail->SMTPAuth   = true;
	// 	$mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
	// 	$mail->Password   = '12345@2022No.Reply'; // ubah dengan password email Anda
	// 	$mail->SMTPSecure = 'tls';
	// 	$mail->Port       = 587;

	// 	$mail->setFrom('no.reply@ibsmulti.com', 'Notification System'); // ubah dengan alamat email Anda
	// 	$mail->addAddress('muhammad.zulvan@ibsmulti.com');

	// 	// Isi Email
	// 	$mail->isHTML(true);
	// 	$mail->Subject = 'test';
	// 	$mail->Body    = 'email test';

	// 	$mail->send();

	// 	// Pesan Berhasil Kirim Email/Pesan Error

	// 	//     session()->setFlashdata('success', 'Selamat, email berhasil terkirim!');
	// 	//     return redirect()->to('/email');
	// 	// } catch (Exception $e) {
	// 	//     session()->setFlashdata('error', "Gagal mengirim email. Error: " . $mail->ErrorInfo);
	// 	//     return redirect()->to('/email');

	// }

	public function sendEmail($type, $requestId, $email_to, $employee_id = "")
	{
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		$data['get_data_claim'] = $this->form_model->get_data_claim_per_request($requestId);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();

		if ($type == 'checked_mdcr_hr') {
			$data['email'] = decrypt($data['data_employee'][0]->email);
			$email_to 	   = decrypt($data['data_employee'][0]->email);
			
			$data['complete_name'] = decrypt($data['data_employee'][0]->complete_name);
			
			$html = $this->load->view('services/email/checked_mdcr_hr', $data, TRUE);
			$email_subject = '[HRIS-MDCR] Medical Form Ready for Printing';
		} elseif ($type == 'request_approve_mdcr') {
			$data['email'] = $email_to;
			$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee'][0]->complete_name)));
			$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id);
			$html = $this->load->view('services/email/request_approve_mdcr_spv', $data, TRUE);
			$email_subject = '[HRIS-MDCR] Approval Request';
		} elseif ($type == 'request_approve_mdcr_hr') {
			$data['email'] = $email_to;
			$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee'][0]->complete_name)));
			$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id);
			$html = $this->load->view('services/email/request_approve_mdcr_hr', $data, TRUE);
			// dumper($data); // untuk nomer 3 (note dari sheva)
			$email_subject = '[HRIS-MDCR] HR Verification Request';
		} elseif ($type == 'approved_spv_mdcr') {
			$data['email'] = decrypt($data['data_employee'][0]->email);
			$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee'][0]->complete_name)));
			$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id);
			$html = $this->load->view('services/email/request_approve_mdcr', $data, TRUE);
			$email_subject = '[HRIS-MDCR] Request Approved';
		} elseif ($type == 'approve_to_ap') {
			$data['email'] = decrypt($data['data_employee'][0]->email);
			$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id);
			$html = $this->load->view('services/email/approve_to_ap', $data, TRUE);
			$email_subject = '[HRIS-MDCR] Full Approved HR & Waiting for Accounting Process';
		}

		$mail = new PHPMailer();
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->isSMTP();
		$mail->Host       = 'mail.ibsmulti.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
		$mail->Password   = '1214#$C1k1n1.2026'; // ubah dengan password email Anda
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;

		$mail->setFrom('no.reply@ibsmulti.com', 'Notification System'); // ubah dengan alamat email Anda

		// $link_host = "$_SERVER[HTTP_HOST]";
		// if($link_host != "172.19.8.84" && $link_host == "medclaim.ibsmulti.com"){
		// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
		// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
		// }else{
		// 	$mail->addAddress($email_to);
		// 	$mail->addBCC('luffi.utomo@ibsmulti.com');
		// 	$mail->addBCC('ditha.damayanti@ibsmulti.com');
		// }

		if($this->status_apps == "development") {
			$prefix = 'DEV TEST - ';
			$email_subject = $prefix . $email_subject;

			$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('luffi.utomo@ibsmulti.com');
			$mail->addCC('ditha.damayanti@ibsmulti.com');

		} else if ($this->status_apps == "staging") {
			$prefix = 'STAGING TEST - ';
			$email_subject = $prefix . $email_subject;
			
			$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('luffi.utomo@ibsmulti.com');
			$mail->addCC('ditha.damayanti@ibsmulti.com');
		} else if ($this->status_apps == "production") {
			$mail->addAddress($email_to);
			$mail->addBCC('luffi.utomo@ibsmulti.com');
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
		}
		

		// Isi Email
		$mail->isHTML(true);
		$mail->Subject = $email_subject;
		$mail->Body    = $html;

		$mail->send();
	}

	public function getRF($region_code)
	{
		if ($region_code == 'CJ') {
			$office_location = 'IBST - SEMARANG';
		} elseif ($region_code == 'EJ') {
			$office_location = 'IBST - SURABAYA';
		} elseif ($region_code == 'WJ') {
			$office_location = 'IBST - BANDUNG';
		} elseif ($region_code == 'NS') {
			$office_location = 'IBST - MEDAN';
		} elseif ($region_code == 'SS') {
			$office_location = 'IBST - PALEMBANG';
		} elseif ($region_code == 'SUL') {
			$office_location = 'IBST - MAKASAR';
		} elseif ($region_code == 'JABO') {
			$office_location = 'IBST - JAKARTA';
		}

		$regional_finance = $this->form_model->getRow("employee_name, user_email", "employee", "is_active = 1 AND position_level = 'RF' AND office_location = '$office_location'");
		echo json_encode(array('region_finance' => $regional_finance, 'status' => 1));
	}

	// SCAN DOCUMENTS UPLOAD
	public function read_documents($request_number)
	{
		$dir = './uploaded_files/' . $request_number . '/supporting_files/';
		$response = $this->doScan($dir);

		if (!empty($response)) {
			foreach ($response as $key => $value) {
				$row   = array();
				$row[] = $value['name'];
				$row[] = $value['size'];
				$row[] = '<div class="btn-group btn-group-sm">
                                <a class="btn btn-sm btn-danger" style="cursor:pointer;" href="' . site_url('home/archive/details/' . encode_url($value['name'])) . '">
                                    X
                                </a>
                        </div>';
				$data[] = $row;
			}
			$output = array('data' => $data);
		} else {
			$output = array('data' => new ArrayObject());
		}

		header('Content-type: application/json');
		echo json_encode($output);
	}

	public function scan()
	{
		$id = $this->input->post('id');
		$requestNumber = $this->form_model->find('id', $id, 'form_request')->row_array()['requestNumber'];
		$status = $this->form_model->find('id', $id, 'form_request')->row_array()['is_status'];

		$dir =  './uploaded_files/' . $requestNumber . '/supporting_files/';
		$path =  '/uploaded_files/' . $requestNumber . '/supporting_files/';
		$response = $this->doScan($dir);

		header('Content-type: application/json');
		echo json_encode(array(
			// "name" => "files",
			"id" => $id,
			"flag" => $status,
			"items" => $response
		));
	}

	public function doScan($dir)
	{

		$files = array();

		// Is there actually such a folder/file?

		if (file_exists($dir)) {

			foreach (scandir($dir) as $f) {

				if (!$f || $f[0] == '.') {
					continue; // Ignore hidden files
				}

				if (is_dir($dir . '/' . $f)) {

					// The path is a folder

					$files[] = array(
						"name" => $f,
						"type" => "folder",
						"path" => $dir . '/' . $f,
						"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
					);
				} else {

					// It is a file

					$files[] = array(
						"name" => $f,
						"type" => "file",
						"path" => $dir . '/' . $f,
						"size" => $this->formatSizeUnits(filesize($dir . '/' . $f)) // Gets the size of this file
					);
				}
			}
		}

		return $files;
	}

	// UPLOAD SUPPORTING FILES
	public function upload_documents($apps, $requestNumber)
	{
		$transok = true;
		if (!is_dir('uploaded_files/' . $requestNumber . '/supporting_files/')) {
			mkdir('./uploaded_files/' . $requestNumber . '/supporting_files/', 0777, TRUE);
		}

		if (isset($_FILES['file'])) {
			$path =  getcwd() . '/uploaded_files/' . $requestNumber . '/supporting_files/';
			$fileName = $_FILES['file']['name'];
			$new_filename = str_replace(' ', '_', $fileName);
			$tempFile = $_FILES['file']['tmp_name'];
			$targetFile = $path . $new_filename;

			if (!move_uploaded_file($tempFile, $targetFile)) {
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error', $error['error']);
				$transok = false;
			}
		}

		return $transok;
	}

	public function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes . ' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' byte';
		} else {
			$bytes = '0 bytes';
		}

		return $bytes;
	}



	////////////////////////////////////////////Tambah TOR Medical//////////////////////////////////////
	public function get_medical_item_year(){
		$request_id 			= $_POST['request_id'];
		$data = $this->form_model->get_medical_item_year($request_id);
		echo json_encode($data);
	}

	public function tambah_tor()
	{
		$request_id 			= $_POST['request_id'];
		$tor_grandparent 		= $_POST['tor_grandparent'];
		$tor_parent 			= $_POST['tor_parent'];
		$tor_child 				= $_POST['tor_child'];
		$jumlah_kuitansi		= $_POST['jumlah_kuitansi'];
		$total_kuitansi			= $_POST['total_kuitansi'];
		$tanggal_kuitansi		= $_POST['tanggal_kuitansi'];
		$penggantian			= $_POST['penggantian'];
		$request_family			= $_POST['request_family'];
		$additional 			= $_POST['additional'];
		$docter		 			= $_POST['docter'];
		$harga_kamar			= $_POST['harga_kamar'];
		$diagnosa	 			= $_POST['diagnosa'];

		//dumper($request_id." - ".$tor_grandparent." - ".$tor_parent." - ".$tor_child." - ".$jumlah_kuitansi." - ".$total_kuitansi." - ".$penggantian." - ".$request_family." - ".$additional);

		$data = $this->form_model->tambah_tor($request_id, $tor_grandparent, $tor_parent, $tor_child, $jumlah_kuitansi, $total_kuitansi, $penggantian, $request_family, $additional, $diagnosa, $tanggal_kuitansi, $docter, $harga_kamar);
		echo json_encode($data);
	}

	public function delete_tor()
	{
		$id				= $_POST['id'];
		$data = $this->form_model->delete_tor($id);
		echo json_encode($data);
	}

	public function edit_tor()
	{
		$id = $_POST['id'];
		$data = $this->form_model->edit_tor($id);
		// dumper($data);
		echo json_encode($data);
	}

	public function get_sum_penggantian_jalan()
	{
		$request_id				= $_POST['request_id'];
		
		$data = $this->form_model->get_sum_penggantian_jalan($request_id);
		
		echo json_encode($data);
	}

	public function get_sum_penggantian_inap()
	{
		$request_id				= $_POST['request_id'];
		$data = $this->form_model->get_sum_penggantian_inap($request_id);
		echo json_encode($data);
	}

	public function get_sum_penggantian_kacamata()
	{
		$request_id				= $_POST['request_id'];
		$data = $this->form_model->get_sum_penggantian_kacamata($request_id);
		echo json_encode($data);
	}

	public function request_submited_mdcr()
	{
		// dumper('Please Reupload');
		$request_id				= $_POST['request_id'];
		$is_status				= $_POST['is_status'];
		$data = $this->form_model->request_submited_mdcr($request_id);
		$detail = $this->form_model->cekTypeOfRembursement($request_id);
		$tor = 'non_rawat_inap';
		foreach ($detail as $key => $value) {
			if ($value['tor_grandparent'] == '2') {
				$tor = 'rawat_inap';
			}
		}
		if ($data) {
			$this->saveApprovalMDCR($tor, $request_id, $is_status);

			$form_number = $this->m_global->find('form_request', 'id', $request_id)->row_array()['request_number'];

			$form_log_request = array(
				'request_id' => $request_id,
				'activity' => 'Submit',
				'desc' =>  $form_number . ' submited',
				'create_at' => $this->date,
				'create_by' => $this->email,
				'type' => 'MDCR',
				'activity_desc' => 'Submitted_by_User'
			);

			$this->db->insert('form_logs', $form_log_request);
		}
		echo json_encode($data);
	}

	public function getFamilyChild()
	{
		$tanggal_kuitansi				= $_POST['tanggal_kuitansi'];
		$data = $this->form_model->getFamilyChild($tanggal_kuitansi);
		echo json_encode($data);
	}

	public function getFamilySpouse()
	{
		$tanggal_kuitansi				= $_POST['tanggal_kuitansi'];
		$data = $this->form_model->getFamilySpouse($tanggal_kuitansi);
		echo json_encode($data);
	}

	public function getDetailFamilySpouse() {
		$id = $_POST['id'];
		$employee_id = $_POST['employee_id'];
		// $id = decrypt($_POST['id']);
		// dumper($id);
		// $record = $this->form_model->edit_tor($id);
		$data = $this->form_model->getDetailFamilySpouse($id, $employee_id);
		echo json_encode($data);
	}

	public function getDetailFamilyChild()
	{
		$id = $_POST['id'];
		$tanggal_kuitansi = $_POST['tanggal_kuitansi'];
		$employee_id = $_POST['employee_id'];
		// $id = decrypt($_POST['id']);
		// dumper($id);
		// $record = $this->form_model->edit_tor($id);
		// dumper($record);
		$data = $this->form_model->getDetailFamilyChild($id, $tanggal_kuitansi, $employee_id);
		// dumper($data);
		echo json_encode($data);
	}

	public function cek_tanggal_pengambilan_kacamata()
	{
		$request_id				= $_POST['request_id'];
		$kind				= $_POST['kind'];
		if ($kind == 'tambah') {
			$request_grandparent 	= $_POST['request_grandparent_tambah'];
			$request_parent			= $_POST['request_parent_tambah'];
			$request_child 			= $_POST['request_child_tambah'];
		} else {
			$request_grandparent 	= $_POST['request_grandparent_edit'];
			$request_parent			= $_POST['request_parent_edit'];
			$request_child 			= $_POST['request_child_edit'];
		}
		
		$data = $this->form_model->cek_tanggal_pengambilan_kacamata($request_id, $request_grandparent, $request_parent, $request_child);
		echo json_encode($data);
	}

	public function get_Grandparent()
	{
		$data = $this->form_model->get_Grandparent();
		echo json_encode($data);
	}

	public function edit_Grandparent(){
		$id = $_POST['id'];
		$data = $this->form_model->edit_get_Grandparent($id);
		echo json_encode($data);
	}

	public function get_Parent()
	{
		if ($this->input->post('grandparent')) {
			// echo $this->form_model->get_Parent($this->input->post('grandparent'));
			$data = $this->form_model->get_Parent($this->input->post('grandparent'), $this->input->post('employee_group'));
			echo json_encode($data);
		}
	}

	public function edit_Parent(){
		$id = $_POST['id'];
		$record = $this->form_model->edit_tor($id);
		
		$data = $this->form_model->edit_get_Parent($record, $this->session->userdata('employee_group'));
		echo json_encode($data);
	}

	public function get_Child()
	{
		if ($this->input->post('parent')) {
			echo $this->form_model->get_Child($this->input->post('parent'));
			// $data = $this->form_model->get_Child($this->input->post('parent'));
			// echo json_encode($data);
		}
	}

	public function edit_Child(){
		$id = $_POST['id'];
		$record = $this->form_model->edit_tor($id);
		$data = $this->form_model->edit_get_Child($record);
		echo json_encode($data);
	}

	public function update_tor()
	{
		$request_id 			= $_POST['request_id'];
		$tor_grandparent 		= $_POST['tor_grandparent'];
		
		$tor_child 				= $_POST['tor_child'];
		$jumlah_kuitansi		= $_POST['jumlah_kuitansi'];
		$total_kuitansi			= $_POST['total_kuitansi'];
		$tanggal_kuitansi		= $_POST['tanggal_kuitansi'];
		$penggantian			= $_POST['penggantian'];
		$request_family			= $_POST['request_family'];
		$additional 			= $_POST['additional'];
		$docter		 			= $_POST['docter'];
		$harga_kamar			= $_POST['harga_kamar'];
		$diagnosa	 			= $_POST['diagnosa'];
		$tor_parent 			= $_POST['tor_parent'];
		//dumper($request_id." - ".$tor_grandparent." - ".$tor_parent." - ".$tor_child." - ".$jumlah_kuitansi." - ".$total_kuitansi." - ".$penggantian." - ".$request_family." - ".$additional);

		$data = $this->form_model->update_tor($request_id, $tor_grandparent, $tor_parent, $tor_child, $jumlah_kuitansi, $total_kuitansi, $penggantian, $request_family, $additional, $diagnosa, $tanggal_kuitansi, $docter, $harga_kamar);
		echo json_encode($data);
	}

	public function update_price()
	{
		// dumper($_POST['harga_kamar']);
		$record_id 			= $_POST['record_id'];
		$penggantian_old 		= $_POST['old_penggantian'];
		$penggantian_revisi 			= $_POST['penggantian_revisi'];
		$note_penggantian 			= $_POST['note_penggantian'];
		$harga_kamar 			= $_POST['harga_kamar'];
		
		//dumper($request_id." - ".$tor_grandparent." - ".$tor_parent." - ".$tor_child." - ".$jumlah_kuitansi." - ".$total_kuitansi." - ".$penggantian." - ".$request_family." - ".$additional);

		$data = $this->form_model->update_price($record_id, $penggantian_old, $penggantian_revisi, $note_penggantian, $harga_kamar);
		echo json_encode($data);
	}

	//////////////////////////////////////////Additional Form MDCR/////////////////////////////////////

	public function cek_addtional_mdcr()
	{
		$request_id		= $_POST['request_id'];
		$data 			= $this->form_model->cek_additional_table($request_id);
		echo json_encode($data);
	}

	public function cek_limit_harga_kamar()
	{
		$data 			= $this->form_model->cek_limit_harga_kamar();
		echo json_encode($data);
	}

	public function cek_limit_maternity()
	{
		$status			= $_POST['status'];
		$data 			= $this->form_model->cek_limit_maternity($status);
		echo json_encode($data);
	}

	public function save_additional_mdcr()
	{

		$request_id = $_POST['request_id_additional'];
		$kuitansi 	= $_POST['kuitansi'];
		$resep 		= $_POST['resep'];


		if ($resep == "on") {
			$resep = 1;
		} else {
			$resep = 0;
		};

		$cek = $this->form_model->cek_additional_table($request_id);

		if (empty($cek)) {

			$config = [
				'upload_path' => './assets/documents/documents_hris/',
				'allowed_types' => '*',
				'max_size' => 10000000000, 'max_width' => 10000000000,
				'max_height' => 10000000000
			];

			if (($_FILES['FileDocumentsClaim']['error'] == 4)) {
				// echo "<script>
				// 		alert('No file was uploaded');
				// 		javascript:history.back();
				// 	</script>";
				$result = 0;
				echo json_encode($result);
			} else if (($_FILES['FileDocumentsClaim']['error'] == 7)) {
				// echo "<script>
				// 		alert('Failed to write file to disk');
				// 		javascript:history.back();
				// 	</script>";
				$result = 0;
				echo json_encode($result);
			} else if (($_FILES['FileDocumentsClaim']['error'] == 1) || ($_FILES['FileDocumentsClaim']['error'] == 2)) {
				// echo "<script>
				// 		alert('Upload Max File Size 10Mb or Format Not Support');
				// 		javascript:history.back();
				// 	</script>";
				$result = 0;
				echo json_encode($result);
			}

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('FileDocumentsClaim')) //jika gagal upload
			{
				// dumper($this->upload->display_errors());
				$error = array('error' => $this->upload->display_errors()); //tampilkan error

			} else {

				$file = $this->upload->data();
				$data = [
					'documents' => $file['file_name'],
					'request_id' => $request_id,
					'kuitansi' => $kuitansi,
					'resep' => $resep
				];
				$result = $this->form_model->save_additional_mdcr($data);
				//dumper($result);
				if ($result == '1') {
					// echo "<script>
					// alert('Success submitting form');
					// javascript:history.back();
					// </script>";
					echo json_encode($result);
				} else {
					// echo "<script>
					// alert('Error submitting form');
					// javascript:history.back();
					// </script>";
					echo json_encode($result);
				}
			}
		} else {


			if ($_FILES['FileDocumentsClaim']['name'] == '') {

				$file_update = $cek[0]->documents;
			} else {

				$config = [
					'upload_path' => './assets/documents/documents_hris/',
					'allowed_types' => '*',
					'max_size' => 10000000000, 'max_width' => 10000000000,
					'max_height' => 10000000000
				];
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('FileDocumentsClaim');
				$file = $this->upload->data();
				//dumper($file);
				$file_update = $file['file_name'];
			}

			//dumper($cek[0]);

			$data = [
				'documents' => $file_update,
				'request_id' => $request_id,
				'kuitansi' => $kuitansi,
				'resep' => $resep
			];
			//dumper($data);
			$result = $this->form_model->update_additional_mdcr($data);
			//dumper($result);
			if ($result == '1') {
				// echo "<script>
				// alert('Success submitting form');
				// javascript:history.back();
				// </script>";
				echo json_encode($result);
			} else {
				// echo "<script>
				// alert('Error submitting form');
				// javascript:history.back();
				// </script>";
				echo json_encode($result);
			}
		}
		//dumper($_FILES['FileDocumentsClaim']);

		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();

		$form_log_request = array(
			'request_id' => $request_id,
			'activity' => 'Save',
			'desc' =>  $data['form_request']['request_number'] . ' Saved',
			'create_at' => $this->date,
			'create_by' => $this->email,
			'type' => 'MDCR',
			'activity_desc' => 'Doc_Saved_by_User'
		);

		$this->db->insert('form_logs', $form_log_request);

	}

	public function print_out_req_mdcr()
	{

		$data['request_id'] = $this->uri->segment(3);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $data['request_id'])->row_array();
		$data['header'] = $this->form_model->get_header_mdcr($data['request_id']);
		// dumper($data['header']);

		$data['detail'] = $this->form_model->getTypeOfRembursement($data['request_id']);
		// dumper($data['header']);
		$header_req = $this->m_global->getRow('header_table', 'form_type', array('code' => 'MDCR'));
		$additional = $this->m_global->getRow('additional_table', 'form_type', array('code' => 'MDCR'));
		$data['header_req'] = $this->m_global->find($header_req, 'request_id', $data['request_id'])->row_array();

		$employee_id 	= $data['header_req']['employee_id'];
		$id_eg_prj 		= $data['header_req']['id_eg_prj'];
		$id_eg_pri 		= $data['header_req']['id_eg_pri'];
		$id_eg_pk  		= $data['header_req']['id_eg_pk'];
		$detail 		= $this->form_model->cekTypeOfRembursement($data['request_id']);
		$tor = 'non_rawat_inap';
		foreach ($detail as $key => $value) {
			if ($value['tor_grandparent'] == '2') {
				$tor = 'rawat_inap';
			}
		}
		// dumper($tor);

		$data['no_req_mdcr'] = $data['form_request']['request_number'];
		$data['approver'] = $this->form_model->get_approval_mdcr($data['request_id']);
		// dumper(decrypt($data['approver'][3]->complete_name));
		// dumper($data['approver']);
		$data['tor'] = $tor;
		$request_created_at = $data['form_request']['created_at'];
		$data['sum_penggantian_jalan'] = $this->form_model->get_sum_penggantian_jalan($data['request_id']);
		$data['sum_penggantian_inap'] = $this->form_model->get_sum_penggantian_inap($data['request_id']);
		$data['sum_penggantian_kacamata'] = $this->form_model->get_sum_penggantian_kacamata($data['request_id']);
		$data['reimaning_pagu'] = $this->form_model->get_reimaning_pagu($request_created_at, $employee_id, $id_eg_prj, $id_eg_pri, $id_eg_pk, $data['request_id']);

		// dumper($data['reimaning_pagu']);
		$data['additional'] = $this->m_global->find($additional, 'request_id', $data['request_id'])->result_array();
		$data['listToR'] = $this->form_model->getTypeOfRembursement($data['request_id']);

		// dumper($data['approver']);
		$is_status = $data['form_request']['is_status_progress'];
		if ($is_status >= 3) {
			$data['data_total_claim']		= $this->form_model->get_data_total_claim_for_print_iso($data['request_id']);
			// dumper($data['data_total_claim']);
			$this->load->view('form/print_out/print_req_mdcr_full_approved', $data);
		} else {
			$this->load->view('form/print_out/print_req_mdcr', $data);
		}
	}

	public function print_out_req_mdcr_all_per_day()
	{

		$data['request_number']	= $this->uri->segment(3);
		$data['data_claim']		= $this->form_model->get_data_claim($data['request_number']);
		// dumper($data['data_claim']);
		$data['total_data_claim']		= $this->form_model->get_total_data_claim($data['request_number']);
		$data['date_form']		= $this->form_model->get_date_no_req_mdcr($data['request_number']);
		// dumper($data['date_form']);
		$this->load->view('form/print_out/print_req_mdcr_all_per_day', $data);
	}

	public function print_out_req_mdcr_all_per_employee()
	{

		$data['request_id']	= $this->uri->segment(3);
		$data['data_employee_current']  = $this->form_model->get_data_employee_current($data['request_id']);
		$data['data_claim']	= $this->form_model->get_data_claim_per_employee($data['request_id']);
		$data['data_total_claim']	= $this->form_model->get_data_total_claim_per_employee($data['request_id']);
		$this->load->view('form/print_out/print_req_mdcr_all_per_employee', $data);
	}


	public function detail_approval($formType, $id)
	{
		$request_id = decode_url($id);
		// dumper($request_id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
		$header = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
		$detail = $this->m_global->getRow('detail_table', 'form_type', array('code' => $formType));
		$data['header'] = $this->m_global->find($header, 'request_id', $request_id)->row_array();
		// dumper($data['header']);
		switch ($formType) {
			case 'MDCR':

				$additional = $this->m_global->getRow('additional_table', 'form_type', array('code' => $formType));
				$data['detail'] = $this->m_global->find($detail, 'request_id', $request_id)->result_array();
				$employee_id = $data['header']['employee_id'];
				$data['couple'] = $this->form_model->get_data_couple_employee($employee_id);
				
				$id_eg_prj = $data['header']['id_eg_prj'];
				$id_eg_pri = $data['header']['id_eg_pri'];
				$id_eg_pk  = $data['header']['id_eg_pk'];
				$request_created_at = $data['form_request']['created_at'];
				$data['approval_priority'] = $this->form_model->get_approval_priority($request_id, $this->email);
				$data['get_medical_item_year'] = $this->form_model->get_medical_item_year($request_id);
				$year_medical_item = $data['get_medical_item_year'] != null ? $data['get_medical_item_year'] : $request_created_at;
				$data['sum_penggantian_jalan'] = $this->form_model->get_sum_penggantian_jalan($request_id);
				$data['sum_penggantian_inap'] = $this->form_model->get_sum_penggantian_inap($request_id);
				$data['sum_penggantian_kacamata'] = $this->form_model->get_sum_penggantian_kacamata($request_id);
				$data['reimaning_pagu'] = $this->form_model->get_reimaning_pagu($year_medical_item, $employee_id, $id_eg_prj, $id_eg_pri, $id_eg_pk);
				// dumper($data['reimaning_pagu']);
				$data['additional'] = $this->m_global->find($additional, 'request_id', $request_id)->result_array();
				//dumper($data['approval_priority']);
				break;

			case 'PPD':

				$dir =  './uploaded_files/' . $data['form_request']['request_number'] . '/supporting_files';
				$data['uploaded_document'] = $this->doScan($dir);
				$data['list_city'] = $this->form_model->getCity();
				$data['detail'] = $this->m_global->find($detail, 'header_id', $data['header']['id'])->result_array();
				$data['kota_berangkat'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_berangkat']))->row_array()['NAMA_KABUPATEN_KOTA'];
				$data['kota_tujuan'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_tujuan']))->row_array()['NAMA_KABUPATEN_KOTA'];
				$data['category_city'] = $this->db->get_where('master_city', array('IDPROVINSI' => $data['detail'][0]['kota_tujuan']))->row_array()['CATEGORY'];

				$data['approval_progress'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
				$count = count($data['approval_progress']);
				$data['requestor_layer'] = '';
				$data['layer_1'] = '';
				$data['layer_2'] = '';
				$data['layer_3'] = '';

				//print_r($data['approval_progress']);die;
				if (!empty($data['approval_progress'])) {

					if ($count === 4) {
						$data['requestor_layer'] = $data['approval_progress'][0]['approval_email'];
						$data['layer_1'] = $data['approval_progress'][1]['approval_email'];
						$data['layer_2'] = $data['approval_progress'][2]['approval_email'];
						$data['layer_3'] = $data['approval_progress'][3]['approval_email'];
					} else {
						$data['requestor_layer'] = '';
						$data['layer_1'] = $data['approval_progress'][0]['approval_email'];
						$data['layer_2'] = $data['approval_progress'][1]['approval_email'];
						$data['layer_3'] = $data['approval_progress'][2]['approval_email'];
					}
				}

				break;

			case 'LPD':

				$dir =  './uploaded_files/' . $data['form_request']['request_number'] . '/supporting_files';
				$data['uploaded_document'] = $this->doScan($dir);
				$data['list_city'] = $this->form_model->getCity();
				$data['detail'] = $this->m_global->find($detail, 'header_id', $data['header']['id'])->row_array();
				$data['additional'] = $this->m_global->find($additional, 'header_id', $data['header']['id'])->result_array();

				$data['approval_progress'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
				$count = count($data['approval_progress']);
				$data['requestor_layer'] = '';
				$data['layer_1'] = '';
				$data['layer_2'] = '';
				$data['layer_3'] = '';

				break;

			// TIME MANAGEMENT 2024 - TIME OFF ////
			case 'TM':
				$employee_id = $data['header']['nik'];
				$data['personal_detail'] = $this->form_model->getPersonalDetail_ztm($employee_id);

				break;
			///////////////////////////////////////

			default:
				break;
		}

		$data['userList'] = $this->form_model->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['employee_list'] = $this->form_model->getUserList("complete_name", "hris_employee", "is_active = 1 AND access_employee != 1 AND complete_name != '$this->emp_name'");
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		// dumper($data['approval']);
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'form/approval/' . $formType;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function cek_hak_pengajuan()
	{
		$hak_pengajuan		= $_POST['hak_pengajuan'];
		$id_request			= $_POST['id_request'];
		$this->form_model->del_draft_request_mdcr($id_request);
		$data 				= $this->form_model->cek_employee($hak_pengajuan);
		echo json_encode($data);
	}

	public function cek_detail_tor_for_apotik()
	{
		$request_id			= $_POST['request_id'];
		$detail = $this->form_model->cekTypeOfRembursement($request_id);
		$tor = 'non_apotik';
		foreach ($detail as $key => $value) {
			if (($value['tor_child'] == '2') || ($value['tor_child'] == '8') || ($value['tor_child'] == '20')) {
				$tor = 'apotik';
			} else if (($value['tor_grandparent'] == '2') && (($value['tor_child'] != '5') && ($value['tor_child'] != '6') && ($value['tor_child'] != '7') && ($value['tor_child'] != '10'))) {
				$tor = 'apotik';
			}
		}

		echo json_encode($tor);
	}

	public function cek_detail_add_info_for_doc()
	{
		$request_id			= $_POST['request_id'];
		$detail = $this->form_model->cek_additional_table($request_id);
		//dumper($detail[0]->documents);
		$doc = 'no_doc';

		if (!empty($detail[0]->documents)) {
			$doc = 'doc';
		}

		echo json_encode($doc);
	}

	public function cek_tor()
	{
		$request_id			= $_POST['request_id'];
		$listToR = $this->form_model->getTypeOfRembursement($request_id);
		$cek = 0;
		if (!empty($listToR)) {
			$cek = 1;
		}
		echo json_encode($cek);
	}

	public function cek_efektifitas_kuitansi()
	{
		$tanggal_kuitansi = $_POST['tanggal_kuitansi'];
		$data 				= $this->form_model->cek_efektifitas_kuitansi($tanggal_kuitansi);
		echo json_encode($data);
	}

	public function cek_limit_pagu()
	{
		// $tahun = date("Y", strtotime($_POST['tanggal_kuitansi']));
		$tanggal_kuitansi = $_POST['tanggal_kuitansi'];
		$employee_nik = $_POST['employee_nik'];
		$employee_group = $_POST['employee_group'];
		// $grandparent = $_POST['grandparent'];
		// $parent = $_POST['parent'];
		// $child = $_POST['child'];

		$data = $this->form_model->get_reimaning_pagu($tanggal_kuitansi, $employee_nik, $employee_group, $employee_group, $employee_group);
		// $data 				= $this->form_model->cek_pagu($tahun_request, $employee_id, $eg_prj, $eg_pri, $eg_pk, $request_id = null);

		echo json_encode($data);
	}

	public function responseRequestFromAdminHR()
	{
		$request_id = $this->input->post('id');
		$response = $this->input->post('resp');

		$respone = $this->form_model->responseRequestFromAdminHR($request_id, $response);
		if ($respone == true) {
			$this->sendEmail('checked_mdcr_hr', $request_id, '');
			///////////Menambahkan logs 2025//////////////////
			$this->logs('checked_mdcr_hr', 'MDCR', $request_id, 'Checked Form', 'Success');

			$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
			$form_log_request = array(
				'request_id' => $request_id,
				'activity' => 'Check',
				'desc' =>  $data['form_request']['request_number'] . ' Checked',
				'create_at' => $this->date,
				'create_by' => $this->email,
				'type' => 'MDCR',
				'activity_desc' => 'Checked_by_HR' 
			);

			$this->db->insert('form_logs', $form_log_request);

			echo json_encode($respone);
		} else {
			echo json_encode($respone);
		}
	}

	public function responseRequestMDCRtoFI()
	{
		$no_req = $this->input->post('no_req');
		$sql = "select * from form_request where no_req_mdcr='$no_req' and is_status='1' and is_status_admin_hr='1'";
		$query = $this->db->query($sql);
		$res = $query->result();

		$count = count($res);

		for ($i = 0; $i < $count; $i++) {

			$data = array(
				'is_status_divhead_hr' => 1,
				'is_status_progress' => 2
			);
			$this->db->where('id', $res[$i]->id);
			$this->db->update('form_request', $data);
			$this->responseRequestMDCRFI($res[$i]->id, 'Approved');

			$data['form_request'] = $this->m_global->find('form_request', 'id', $res[$i]->id)->row_array();

			$form_log_request = array(
				'request_id' => $res[$i]->id,
				'activity' => 'Approve',
				'desc' =>  $data['form_request']['request_number'] . ' Approved',
				'create_at' => $this->date,
				'create_by' => $this->email,
				'type' => 'MDCR',
				'activity_desc' => 'Approved_by_HRGA_Divhead' 
			);

			$this->db->insert('form_logs', $form_log_request);
		}

		$data = array(
			'is_status' => 1,
			'is_status_progress' => 2
		);
		$this->db->where('no_req_mdcr', $no_req);
		$result = $this->db->update('hris_no_req_mdcr', $data);

		echo json_encode($result);
	}

	public function responseRequestMDCRFI($request_id, $response)
	{
		//dumper('tes');
		//$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		$request_id = $request_id;

		$sql = "select id from form_approval where request_id='$request_id' and approval_status='In Progress'";
		$query = $this->db->query($sql);
		$res = $query->result();

		$approval_id = $res[0]->id;
		//print_r($approval_id);die;
		$response = $response;
		//dumper($response);
		// previous layer
		$priority = $this->m_global->find('form_approval', 'id', $approval_id)->row_array()['approval_priority'];
		$prev_priority = $priority - 1;
		$prev_id = $this->inbox_model->find_select("id", 'form_approval', array('approval_priority' => $prev_priority, 'request_id' => $request_id))->row_array();

		$prev_email = $this->inbox_model->find_select("approval_email", 'form_approval', array('approval_priority' => $prev_priority, 'request_id' => $request_id))->row_array();

		$data_prev_layer = array(
			'approval_status' => 'In Progress',
			'updated_at' => $this->date,
			'updated_by' => $this->email
		);

		switch ($response) {

			case 'Revised':

				if ($priority != 1) {

					$current_layer = array(
						'approval_status' => 'Revised to previous layer',
						'updated_at' => $this->date,
						'updated_by' => $this->email
					);

					$this->db->where('id', $approval_id);
					if ($this->db->update('form_approval', $current_layer)) {

						$this->db->where('id', $prev_id['id']);
						if ($this->db->update('form_approval', $data_prev_layer)) {
							$this->db->where('request_id', $request_id);
							$this->db->update('hris_medical_reimbursment', array('is_status' => 2));
							//$this->sendEmail('revise', $request_id, $prev_email['approval_email']);
							$this->logs('revised', 'MDCR', $request_id, 'Response revised', 'Success');
							$output = array('status' => 1);
						}
					}
				} else {

					$revise_layer = array(
						'approval_status' => 'Revised',
						'updated_at' => $this->date,
						'updated_by' => $this->email
					);

					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
						//$this->sendEmail('revise', $request_id, $requestor);
						$this->db->where('request_id', $request_id);
						$this->db->update('hris_medical_reimbursment', array('is_status' => 2));

						$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
						$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
						//$this->sendEmail('revised_mdcr', $request_id, decrypt($data['data_employee']->email));

						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $revise_layer)) {
							//$this->sendEmail('revise', $request_id, $prev_email['approval_email']);
							$this->logs('revised', 'MDCR', $request_id, 'Response revised', 'Success');
							$output = array('status' => 1);
						}
					}
				}

				break;

			case 'Reject':

				$this->db->where('request_id', $request_id);
				$this->db->delete('form_approval');
				$this->db->where('id', $request_id);
				if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
					$this->db->where('request_id', $request_id);
					$this->db->update('hris_medical_reimbursment', array('is_status' => 4));

					$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
					$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
					//$this->sendEmail('rejected_mdcr', $request_id, decrypt($data['data_employee']->email));

					//$this->sendEmail('revise', $request_id, $prev_email['approval_email']);
					$this->logs('reject', 'MDCR', $request_id, 'Response Rejected', 'Rejected');
					$output = array('status' => 1);
				}
				break;

			case 'Approved':

				#check current approver list
				$sql = "SELECT * FROM form_approval WHERE id = '$approval_id' AND request_id = '$request_id'";
				$checkleftcurrent = $this->db->query($sql);

				//fungsi script di bawah ini masih ambigu secara penggunaan
			
					// if (($checkleftcurrent->row_array()['approval_email'] != 'hr.support@ibsmulti.com') and ($checkleftcurrent->row_array()['approval_priority'] != 3)) {
				// 	$this->sendEmail('approved_spv_mdcr', $request_id, $checkleftcurrent->row_array()['approval_email'], $checkleftcurrent->row_array()['approval_employee_id']);
				// }

				#check approver list
				// $sql = "SELECT * FROM form_approval WHERE id >= '$approval_id' AND request_id = '$request_id' ORDER BY approval_priority ASC OFFSET 1 ROWS FETCH NEXT 1 ROWS ONLY";
				// $sql = "SELECT * FROM form_approval WHERE id >= '$approval_id' AND request_id = '$request_id' and approval_status = 'In Progress' ORDER BY approval_priority ASC";
				$sql = "SELECT * FROM form_approval WHERE id >= '$approval_id' AND request_id = '$request_id' ORDER BY approval_priority ASC LIMIT 1,1";
				// dumper($sql);
				$checkleft = $this->db->query($sql);
				if ($checkleft->num_rows() > 0) {
					$current_approval = array(
						'approval_status' => 'Approved',
						'updated_at' => $this->date,
						'updated_by' => $this->email
					);

					#update response approval
					$this->db->where('id', $approval_id);

					if ($this->db->update('form_approval', $current_approval)) {
						// dumper('iki lho');

						#set in progress for next approver
						$this->db->where('id', $checkleft->row_array()['id']);

						if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {
							// dumper('aaa');
							$this->logs('approved', 'MDCR', $request_id, 'Approved successfully', 'Approved successfully');
							$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));
						} else {
							// dumper('bbb');
							$this->logs('system', 'MDCR', $request_id, 'Authentication success, but failed while updating the next approver.', 'Authentication success, but failed while updating the next approver.');
							$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.');
						}
					} else {
						$this->logs('system', 'MDCR', $request_id, 'Authentication success, but failed while updating response approval.', 'Authentication success, but failed while updating response approval.');
						$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating response approval. ');
					}
				} else {
					// dumper('hoho');

					#update header request
					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
						$approval = array(
							'approval_status' => 'Approved',
							'updated_at' => $this->date,
							'updated_by' => $this->email
						);

						#update response approval
						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $approval)) {

							//$this->sendEmail('approved_eapp', $request_id, $requestor);
							$this->logs('approved', 'MDCR', $request_id, 'Approved successfully', 'Approved successfully');

							$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));
						} else {
							$this->logs('system', 'MDCR', $request_id, 'Authentication success, but failed while updating response approval [Full Approved].', 'Authentication success, but failed while updating response approval [Full Approved].');
							$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.');
						}
					} else {
						$this->logs('system', 'MDCR', $request_id, 'Authentication success, but failed while updating response approval [Full Approved].', 'Authentication success, but failed while updating response approval [Full Approved].');
						$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.');
					}
				}

				break;

			default:
				break;
		}
		//dumper($output);
		//echo json_encode($output);
	}


	/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////

	public function detailpa($formType, $id)
	{
		$year = $this->year - 1;
		$request_id = decode_url($id);
		$formType = $formType;

		$header = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
		$detaila = $this->m_global->getRow('detail_table', 'form_type', array('code' => $formType));
		$additionala = $this->m_global->getRow('additional_table', 'form_type', array('code' => $formType));
		foreach($detaila as $key => $val){
			$detail[$key] = $val;
		}
		foreach($additionala as $key => $val){
			$additional[$key] = $val;
		}
		$data['header'] = $this->m_global->find($header, 'id', $request_id)->row_array();
		$data['score_isi'] = $this->db->query("select count(*) as jumlah_isi from performance_appraisal_measurement where request_id = '$request_id' AND score is not null")->row_array()['jumlah_isi'];
		$data['id_form_request'] = $this->db->query("select b.id as id from performance_appraisal as a left join form_request as b on a.request_number = b.request_number where a.id = '$request_id'")->row_array()['id'];

		/////////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////////

		$data['request_number'] = $this->db->query("select b.request_number as id from performance_appraisal as a left join form_request as b on a.request_number = b.request_number where a.id = '$request_id'")->row_array()['id'];
		$data['documentary_evidence'] = $this->m_global->find('performance_appraisal_documentary_evidence', 'request_number', $data['request_number'])->result_array();
		//============Check RPM==================//

		$cek_data = $this->db->query("select * from v_hris_employee_updated where nik = '".$this->emp_nik."'")->result_array();

		if($cek_data[0]['usrid_long5'] != ""){
			$this->session->set_userdata(['depthead' => $cek_data[0]['usrid_long5']]);
		}

		if(decrypt(($cek_data[0]['directorate'])) == 'CFO'){

			if($cek_data[0]['usrid_long2'] != "" and $cek_data[0]['usrid_long3'] == ""){
				$layer = array($cek_data[0]['usrid_long2'],$cek_data[0]['usrid_long4']);
				foreach($layer as $key => $val){
					if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
						unset($layer[$key]);
					}
				}
			}elseif($cek_data[0]['usrid_long2'] == "" and $cek_data[0]['usrid_long3'] != ""){
				$layer = array($cek_data[0]['usrid_long3'],$cek_data[0]['usrid_long4']);
				foreach($layer as $key => $val){
					if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
						unset($layer[$key]);
					}
				}
			}elseif($cek_data[0]['usrid_long2'] != "" and $cek_data[0]['usrid_long3'] != ""){
				$layer = array($cek_data[0]['usrid_long3'],$cek_data[0]['usrid_long4']);
				foreach($layer as $key => $val){
					if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
						unset($layer[$key]);
					}
				}
			}elseif($cek_data[0]['usrid_long2'] == "" and $cek_data[0]['usrid_long3'] == ""){
				$layer = array($cek_data[0]['usrid_long4']);
			}

			$layer_update = $this->db->query("select a.usrid_long2 as layer1, a.usrid_long3 as layer2, a.usrid_long4 as layer3 from employee_update_division_pa as a left join v_hris_employee_updated as b on a.id_employee = b.id_employee where b.nik = '".$this->emp_nik."' and a.evaluation_year = '".$year."'")->result_array();
		
			if(!empty($layer_update)){
				if(($layer_update[0]['layer1'] != "") || $layer_update[0]['layer1'] != null){
					$layer = array($layer_update[0]['layer1'],$layer_update[0]['layer3']);
					foreach($layer as $key => $val){
						if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
							unset($layer[$key]);
						}
					}
				}else{
					$layer = array($layer_update[0]['layer2'],$layer_update[0]['layer3']);
					foreach($layer as $key => $val){
						if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
							unset($layer[$key]);
						}
					}
				}
			}

		}else{
			/////////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////////

			if($this->session->userdata('depthead') != "" and $this->session->userdata('divhead') != ""){
				$layer = array($this->session->userdata('depthead'),$this->session->userdata('divhead'));
			}elseif($this->session->userdata('depthead') == "" and $this->session->userdata('divhead') != ""){
				$layer = array($this->session->userdata('divhead'),$this->session->userdata('director'));
				foreach($layer as $key => $val){
					if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
						unset($layer[$key]);
					}
				}
			}elseif($this->session->userdata('depthead') != "" and $this->session->userdata('divhead') == ""){
				$layer = array($this->session->userdata('depthead'),$this->session->userdata('director'));
				foreach($layer as $key => $val){
					if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
						unset($layer[$key]);
					}
				}
			}elseif($this->session->userdata('depthead') == "" and $this->session->userdata('divhead') == ""){
				$layer = array($this->session->userdata('director'));
			}

			$layer_update = $this->db->query("select a.usrid_long2 as layer1, a.usrid_long3 as layer2, a.usrid_long4 as layer3 from employee_update_division_pa as a left join v_hris_employee_updated as b on a.id_employee = b.id_employee where b.nik = '".$this->emp_nik."' and a.evaluation_year = '".$year."'")->result_array();
		
			if(!empty($layer_update)){
				if(($layer_update[0]['layer1'] != "") || $layer_update[0]['layer1'] != null){
					$layer = array($layer_update[0]['layer1'],$layer_update[0]['layer2']);
					/////////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////////
					foreach($layer as $key => $val){
						if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
							unset($layer[$key]);
						}
					}
					/////////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////////
				}else{
					$layer = array($layer_update[0]['layer2'],$layer_update[0]['layer3']);
					/////////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////////
					foreach($layer as $key => $val){
						if(($val == strtoupper(encrypt("makmur@ibsmulti.com")) || $val == strtoupper(encrypt("MAKMUR@IBSMULTI.COM"))) and $key == 1 and $layer[0] != ""){
							unset($layer[$key]);
						}
					}
					/////////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////////
				}
			}

		}


		$data['layer'] = $layer;
		$data['detail'] = $this->m_global->find($detail, 'request_id', $request_id)->result_array();
		$data['training'] = $this->m_global->find('performance_appraisal_training', 'request_id', $request_id)->result_array();
		$data['additional'] = $this->m_global->find($additional, 'request_id', $request_id)->result_array();
		$data['userList'] = $this->form_model->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['employee_list'] = $this->form_model->getUserList("full_name", "users", "is_active = 1 AND user_role != 1 AND user_email != '$this->email'");
		$data['hard_skill'] = $this->form_model->getUserListPa("judul_training", "master_training", "category = 'Hard'",1);
		$data['soft_skill'] = $this->form_model->getUserListPa("judul_training", "master_training", "category = 'Soft'",1);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		//
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $data['id_form_request'])->result_array();
		$data['formType'] = $this->form_model->getFormType();
		$data['uom'] = $this->inbox_model->getUOM();
		$data['content'] = 'form/'. $formType;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function formula_score($achievment){
		$achievment = $achievment+0;
		$achievment = ceil($achievment);
		$achievment = str_replace(".",",",$achievment);
		// echo $achievment;
		// echo "<br>";
		
		$query = "select * from score_formula where percentage = '{$achievment}'";
		// echo $query;
		$score = $this->db->query($query)->result_array();
		if(!empty($score)){
			$score[0]['score'] = str_replace(",",".",$score[0]['score']);
			echo $score[0]['score'];
		}else{
			echo 10;
		}
		
		// die;
	}

	public function saveApprovalPa($request_id)
	{
		$transok = false;
		$layer = $this->input->post('approval_layer');
		if (!empty($layer)) {
			return $this->form_model->saveApprovalPa($layer, $request_id);
		} else {
			return false;
		}
	}

	function loadNotePa($id){
		// $request_id = decode_url($id);
		$notes   = $this->m_global->find('request_notes', 'request_id', $id)->result_array();
		$note_list = array();
		foreach($notes as $key => $val){
			if($this->session->userdata('user_email') == ($val['created_by'])){
				$delete = 1;
			}else{
				$delete = 0;
			}
			$note_list[] = [
				'id' => $val['id'],
				'request_id' => $val['request_id'],
				'notes' => $val['notes'],
				'created_by' => $val['created_by'],
				'created_at' => $val['created_at'],
			];
		}
		echo json_encode($note_list);
	}

	public function pullback()
	{
		$responses = array('status' => 0, 'message' => 'Failed pulling back your request. Please try again.');
		$id = $this->input->post('id');
		$request_number = $this->m_global->find('performance_appraisal', 'id', $id)->row_array()['request_number'];
		$id_form_request = $this->m_global->find('form_request', 'request_number', $request_number)->row_array()['id'];
		$approval_id = $this->form_model->getOneById('id', 'form_approval', array('request_id' => $id_form_request, 'approval_status' => 'In Progress'));

		$this->db->where('id', $id);
		if ($this->db->update('performance_appraisal', array('is_status' => 7))) {
			//////////////////////////////////////////Update 2025//////////////////////////////////////////////////////
			$this->m_services->sendEmailPA($id,'cancel');
			//////////////////////////////////////////Update 2025//////////////////////////////////////////////////////
			//============update form request to 7==========//
			$this->db->where('id', $id_form_request);
			$this->db->update('form_request', array('is_status' => 7));
			//=====================================================================//
			if ($this->db->delete('form_approval', array('request_id' => $id_form_request))) {
				$this->logs('pullback', 'KPI', $id_form_request);
				$responses = array('status' => 1, 'id' => encode_url($id));
			}
		}

		echo json_encode($responses);
	}
	
	public function approve_pa($resp)
	{
		$output = array('status' => 0, 'message' => 'Approve failed.');
		$request_id = $this->input->post('id');
		$id_form_request = $this->input->post('id_form_request');
		$request_number = $this->input->post('request_number');
		$approval_id = $this->input->post('approval_id');
		$final_score = $this->input->post('final_score');
		$comment_head = $this->input->post('comment_head_approve', FALSE);

		$requestor = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['created_by'];

		#data response approval
		$approval = array('approval_status' => $resp, 'updated_at' => $this->date, 'updated_by' => encrypt($this->email));

		switch ($resp) {

			case 'Approved':
				#check approver list
				$sql = "SELECT * FROM form_approval WHERE id > '$approval_id' AND request_id = '$id_form_request' ORDER BY approval_priority ASC LIMIT 1";
				$checkleft = $this->db->query($sql);

				$id_form_request = $this->m_global->find('form_request', 'request_number', decrypt($request_number))->row_array()['id'];
				
				if ($checkleft->num_rows() > 0) {

					#update response approval
					$this->db->where('id', $approval_id);
					if ($this->db->update('form_approval', $approval)) {

						#set in progress for next approver
						$this->db->where('id', $checkleft->row_array()['id']);
						if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {

							#update final score
							$this->db->where('id', $request_id);
							$this->db->update('performance_appraisal', array('final_score' => encrypt($final_score), 'updated_by' => $this->email, 'updated_at' => $this->date, 'comment_head_1' => encrypt($comment_head)));
							
							//Email next approver
							$this->m_services->sendEmailPA($request_id,'need_response');

							//Email next approver
							$this->m_services->sendEmailPA($request_id,'approved');

							$this->logs('approved', 'KPI', $id_form_request, 'Approved', 'Approved successfully');
							$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

							$this->db->where('request_id', $id_form_request);
							$this->db->update('request_notes', array('is_status' => 0));

						} else {
							$this->logs('system', 'KPI',$id_form_request, 'Approved', 'Approved, but failed while updating the next approver.');
							$output = array('status' => 1, 'message' => 'Approved, but failed while updating the next approver.');
						}

					} else {
						$this->logs('system', 'KPI', $request_id, 'Approved', 'Approved failed while updating response approval.');
						$output = array('status' => 1, 'message' => 'Approved failed while updating response approval. ');
					}

				} else {	

					#update header request
					$this->db->where('id', $request_id);
					if ($this->db->update('performance_appraisal', array('is_status' => 3, 'final_score' => encrypt($final_score), 'full_approved_date' => $this->date, 'updated_by' => encrypt($this->email), 'updated_at' => $this->date, 'comment_head_2' => encrypt($comment_head)))) {


						#update response approval
						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $approval)) {

							$this->db->where('id',$id_form_request);
							if($this->db->update('form_request',array("is_status" => 3))){
								// $this->sendEmail('approved_eapp', $request_id, decrypt($requestor));
								
								//Email next approver
								$this->m_services->sendEmailPA($request_id,'approved');

								$this->logs('approved', 'KPI', $id_form_request, 'Approved', 'Approved successfully.');
								$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));
							}

							$this->db->where('request_id', $id_form_request);
							$this->db->update('request_notes', array('is_status' => 0));

						} else {
							$this->logs('system', 'KPI', $id_form_request, 'Approved', 'Approved success, but failed while updating response approval [Full Approved].');
							$output = array('status' => 1, 'message' => 'Approved success, but failed updating response approval.');
						}

					} else {
						$this->logs('system', 'KPI', $id_form_request, 'Approved', 'Approved failed while updating header request [Full Approved].');
						$output = array('status' => 1, 'message' => 'Approved success, but failed updating response approval.');
					}

				}
				break;

			default:
				break;
		}

		echo json_encode($output);
	}

	public function get_plan()
	{
		$id = $this->input->post('plan_id');
		$plan_perspective = $this->form_model->getOneByIdPa("plan_perspective", "performance_appraisal_plan", "id = '$id'");
		echo json_encode($plan_perspective);
	}

	public function cekGradeEmployee($grade){
		
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		// echo $this->session->userdata('division');
		// die;
		$listForm = $this->inbox_model->getDivHeadListByDivision($this->session->userdata('division'), $eval_year);
		$total = 0;
		// dumper($listForm);
		// die;
        if (!empty($listForm)) {
            foreach ($listForm as $key) {

				if($grade == "A"){
					if (decrypt($key->final_score) >= "9.1" || decrypt($key->final_score) == "10.0") {
						$total++;
					}
				}
				
				if($grade == "D"){
					if (decrypt($key->final_score) >= "5.6" && decrypt($key->final_score) < "6.9") {
						$total++;
					}
				}
				

            }
		}
		return $total;
		// die;
	}

	/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////

	//////////////////////////////////////////////////// TIME MANAGEMENT 2024////////////////////////////////////////////////////

	public function overview($formType)
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['header'] = $this->inbox_model->getApprovalList();
		$data['formType'] = $this->form_model->getFormType();
		$data['check_ctab'] = $this->form_model->getCTAB_ztm($this->session->userdata('nik'));
		$data['content'] = 'form/TM';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}
	
	public function getTimeOffType(){
		$company_code = $this->session->userdata('company_code');
		$gender = decrypt($this->session->userdata('gender'));
		
		$start_date = decrypt($this->session->userdata('join_date'));
		$start_date = DateTime::createFromFormat('Ymd', $start_date)->format('d.m.Y');

		$data = $this->form_model->getTimeOffType($company_code, $gender);

		echo json_encode($data);
	}

	public function request_time_off(){
		$nik			= $this->session->userdata('nik');
		$emp_name 		= $this->form_model->get_data_employee($nik);
		
		$topId = $this->form_model->getRequestTopId();
		$topTotalCuti = $this->form_model->getRequestTopTotalCuti($nik);

		$start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date 		= date("Y-m-d", strtotime($_POST['end_date']));

		$schedule = $this->form_model->getSchedule($nik, $start_date);
		
		$jenis			= $_POST['jenis'];
		$kode			= $_POST['kode'];

		$waktu_masuk 	= $_POST['waktu_masuk'];
		$waktu_keluar	= $_POST['waktu_keluar'];
		$schedule_in 	= $schedule[0]['schedule_in'];
		$schedule_out 	= $schedule[0]['schedule_out'];
		$status_file	= $_POST['status_file'];
		$note			= $_POST['note'];
		if ($topId != 0){
			$no 		= $topId[0]['id'];
		} else {
			$no 		= $topId;
		}
		if ($topTotalCuti != 0){
			$prevTotal	= $topTotalCuti[0]['total_cuti'];
		} else {
			$prevTotal	= $topTotalCuti;
		}
		list($data, $request_id, $email_to, $head_name, $newTotal) = $this->form_model->requestTimeOff($jenis, $kode, $start_date, $end_date, $note, $nik, $no, $prevTotal, $waktu_masuk, $waktu_keluar, $schedule_in, $schedule_out, $status_file);
		// TIME MANAGEMENT 2.0^
		if ($request_id != ''){
			// dumper($newTotal);
			$this->sendEmailTM('request_to_depthead_rpm', $request_id, $email_to, $head_name);
			///////////Menambahkan logs 2025//////////////////
			$this->logs('request_to_depthead_rpm', 'TM', $request_id, 'Request Time Off', $jenis.' - ('.$start_date.' to '.$end_date.') - '.$note);
		}

		// TIME MANAGEMENT 2.0
		if ($newTotal <= -1){
			// dumper($newTotal);
				$this->sendEmailTM('email_cuti_minus', $request_id, $email_to, $newTotal);
		}
		//////////////////////
		
		echo json_encode($data);
	}

	// public function save_file($uploaded_file){
	// 	$config = [
	// 		'upload_path' => './assets/documents/documents_tm/',
	// 		'allowed_types' => '*'
	// 	];
	// 	$this->load->library('upload', $config);
	// 	$this->upload->initialize($config);
	// 	$this->upload->do_upload($uploaded_file);
	// 	$file = $this->upload->data();
	// 	// dumper($file);
	// 	$file_update = $file['file_name'];
	// 	$file_type = strtolower(pathinfo($file_update,PATHINFO_EXTENSION));

	// 	if(($file_type != 'PDF') && ($file_type != 'pdf') && ($file_type != 'JPG') && ($file_type != 'jpg') && ($file_type != 'JPEG') && ($file_type != 'jpeg') && ($file_type != 'png') && ($file_type != 'zip') && ($file_type != 'rar') && ($file_type != '7z')){
	// 		$data = $this->form_model->del_file(4);
		
	// 	} else if(($_FILES[$uploaded_file]['error'] == 0)){
	// 		$data = $this->form_model->save_file($file_update);

	// 	} else if(($_FILES[$uploaded_file]['error'] == 1) || ($_FILES[$uploaded_file]['error'] == 2)){

	// 		$data = $this->form_model->del_file(0);
	// 	} else if (($_FILES[$uploaded_file]['error'] == 3)){
			
	// 		$data = $this->form_model->del_file(1);
	// 	} else if (($_FILES[$uploaded_file]['error'] == 6)){
			
	// 		$data = $this->form_model->del_file(2);
	// 	} else if (($_FILES[$uploaded_file]['error'] == 7)){
			
	// 		$data = $this->form_model->del_file(3);
	// 	} else {

	// 		$data = $this->form_model->del_file(5);
	// 	}

	// 	echo json_encode($data);
	// }

	public function save_file($uploaded_file){

		$config = [
			'upload_path'   => './assets/documents/documents_tm/',
			'allowed_types' => 'pdf|jpg|jpeg|png|zip|rar|7z'
		];

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		// 🔴 cek hasil upload dulu
		if (!$this->upload->do_upload($uploaded_file)) {

			// ambil error upload
			$error = $this->upload->display_errors();
			$err_no = $_FILES[$uploaded_file]['error'];

			// mapping error tetap pakai del_file(type)
			if (strpos($error, 'type') !== false || strpos($error, 'filetype') !== false) {
        		$data = $this->form_model->del_file(4); // tipe tidak valid
    		} else if ($err_no == 1 || $err_no == 2) {
				$data = $this->form_model->del_file(0); // size terlalu besar
			} else if ($err_no == 3) {
				$data = $this->form_model->del_file(1); // partial upload
			} else if ($err_no == 6) {
				$data = $this->form_model->del_file(2); // no temp dir
			} else if ($err_no == 7) {
				$data = $this->form_model->del_file(3); // gagal write
			} else {
				$data = $this->form_model->del_file(5); // error lainnya
			}

		} else {

			// ✅ upload berhasil
			$file = $this->upload->data();
			$file_update = $file['file_name'];
			$file_type = strtolower(pathinfo($file_update, PATHINFO_EXTENSION));

			// 🔒 validasi tambahan (optional, sebenarnya sudah di allowed_types)
			if (!in_array($file_type, ['pdf','jpg','jpeg','png','zip','rar','7z'])) {

				// hapus file yang sudah terlanjur upload
				unlink($file['full_path']);
				$data = $this->form_model->del_file(4); // tipe tidak valid

			} else {

				$data = $this->form_model->save_file($file_update);
			}
		}

		echo json_encode($data);
	}

	public function request_table(){
		$listReq = $this->form_model->getRequestTimeOff($this->session->userdata('nik'));
		// dumper($listReq);
		if (!empty($listReq)) {
			$no = count($listReq);
			foreach ($listReq as $key) {

				$row   = array();
				$row[] = $no;
				$row[] = $key->request_number;
				$row[] = strtoupper($key->jenis);

				$start_date = $key->start_date;
				$start_date = DateTime::createFromFormat('Y-m-d', $start_date)->format('d.m.Y');
				$end_date = $key->end_date;
				$end_date = DateTime::createFromFormat('Y-m-d', $end_date)->format('d.m.Y');

				$row[] = $start_date;
				$row[] = $end_date;
				if ($key->status == 0){
					$row[] = 'Waiting for Approval';
				} else if ($key->status == 1){
					$row[] = 'Approved';
				} else if ($key->status == 2){
					$row[] = 'Rejected';
				} else if ($key->status == 3){
					$row[] = 'Cancelled';
				}
				$row[] = $key->note;

				$encoded_url = encode_url($key->request_id);
				if ($key->status == 0){
					$cek	= $this->form_model->CekApprovalLayer($key->request_number)[0]->result;
					if($cek){
						$trash = '';	
					}else{
						$trash = '<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteRequestTimeOff" data-offset="-4,0" id="'.$key->id.'" onClick="delete_request_time_off('.$key->id.')">
							<em class="icon ni ni-trash"></em>
							</a>';	
					}
					
				} else {
					$trash = '';
				}
				$row[] = '<div class="btn-group btn-group-sm">
								<a class="text-primary btn btn-icon btn-trigger" data-offset="-4,0" id="'.$key->id.'" onClick="detail_approval_time_off('."'$encoded_url'".')">
								<em class="icon ni ni-info"></em>
								</a>
								'. $trash .'
							</div>
							';
							
				$data[] = $row;
				$no--;
			}
			$outputReq = array('data' => $data);
		} else {
			$outputReq = array('data' => new ArrayObject());
		}
		echo json_encode($outputReq);
		
	}

	public function getDeleteRequestTimeOff(){
		$id = $_POST['id'];

		$list_req = $this->form_model->getRequestNumber($id);
		$req_no = $list_req[0]['request_number'];

		list($data, $request_id, $email_to, $head_name, $tipe_perubahan) = $this->form_model->getDeleteRequestTimeOff($id, $req_no);
		if ($data == true){
			$this->sendEmailTM('cancel_to_depthead_rpm', $request_id, $email_to, ucwords(strtolower($head_name)));
			///////////Menambahkan logs 2025//////////////////
			$this->logs('cancel_to_depthead_rpm', 'TM', $request_id, 'Cancel Request Time Off', $tipe_perubahan);
		}

		echo json_encode($data);
	}

	// public function getCancelRequestTimeOff(){
	// 	$id = $_POST['id'];

	// 	$list_req = $this->form_model->getRequestNumber($id);
	// 	$req_no = $list_req[0]['request_number'];

	// 	list($data, $request_id, $email_to, $head_name) = $this->form_model->getDeleteRequestTimeOff($id, $req_no);

	// 	echo json_encode($data);
	// }

	public function getTotalCuti(){
		$nik	= $this->session->userdata('nik');

		$data 	= $this->form_model->getTotalCuti($nik);

		echo json_encode($data);
	}

	public function getJoinDate(){
		$join_date = decrypt($this->session->userdata('join_date'));
		$join_date = DateTime::createFromFormat('Ymd', $join_date)->format('Y/m/d');

		echo json_encode($join_date);
	}

	public function getAlreadyRequested(){
		$nik	= $this->session->userdata('nik');

		$data 	= $this->form_model->getAlreadyRequested($nik);

		echo json_encode($data);
	}

	public function getAlreadyRequestedDay($end_date=''){
		$nik		= $this->session->userdata('nik');
		$start_date	= $_POST['start_date'];
		// $start_date = str_replace('/', '-', $start_date);
		$start_date 	= date("Y-m-d", strtotime($start_date));
		$tipe_time_off 	= $_POST['tipe_time_off'];
		if (empty($end_date)){
			$data 	= $this->form_model->getAlreadyRequestedDay($nik, $tipe_time_off, $start_date);
		} else {
			$end_date	= $_POST['start_date'];
			// $end_date 	= str_replace('/', '-', $end_date);
			$end_date 	= date("Y-m-d", strtotime($end_date));
			// $end_date 		= date("Y-m-d", strtotime($_POST['end_date']));
			$data 	= $this->form_model->getAlreadyRequestedDay($nik, $tipe_time_off, $start_date, $end_date);
		}
		// dumper($data);

		echo json_encode($data);
	}

	public function balance_log_table($nik=''){
		if (empty($nik)){
			$nik = $this->session->userdata('nik');
		}
		$listBalance = $this->form_model->getBalanceLog($nik);
		// dumper($listBalance);
		if (!empty($listBalance)) {
			$no = 1;
			foreach ($listBalance as $key) {

				$row   = array();
				$date = $key->date;
				$date = DateTime::createFromFormat('Y-m-d', $date)->format('Y.m.d');
				$row[] = $no;
				$row[] = $date;
				$row[] = $key->tipe_perubahan;
				$row[] = $key->start_date;
				$row[] = $key->end_date;
				$row[] = $key->total_cuti;
				if ($key->change_log > 0){
					$row[] = "+" . $key->change_log;
				} else {
					$row[] = $key->change_log;
				}
				$req_id = $this->form_model->getReqID_ztm($key->request_number);

				if($key->status == 1){
					if ($key->request_number != '-'){
						$approval_name = $this->form_model->getApprovalName_ztm($req_id[0]['id'], 'In Progress');
						$row[] = 'Waiting Approval: ' . $approval_name;
					} else {
						$row[] = 'Active';
					}
				} else if ($key->status == 2){
					$row[] = 'Cancelled by USER';
				} else if ($key->status == 3){
					$row[] = '-';
				} else if ($key->status == 4){
					$row[] = 'Potong Gaji';
				} else if ($key->status == 5){
					if (!empty($req_id)){
						$approval_name = $this->form_model->getApprovalName2_ztm($req_id[0]['id']);
						$row[] = 'Rejected by ' . $approval_name;
					} else {
						$row[] = 'Rejected by HR SUPPORT';
					}
				} else if ($key->status == 6){
					if (!empty($req_id)){
						$approval_name = $this->form_model->getApprovalName2_ztm($req_id[0]['id']);
						$row[] = 'Approved by ' . $approval_name;
					} else {
						$row[] = 'Approved by HR SUPPORT';
					}
				} else if ($key->status == 7){
						$row[] = 'Rejected by HR SUPPORT';
				} else if ($key->status == 0){
					$req_type = $this->form_model->getReqType_ztm($key->update_date, $nik);
					if (!empty($req_type)){
						$row[] = 'Inactive: ' . $req_type[0]['tipe_perubahan'];
					} else {
						$row[] = 'Inactive';
					}
				}
				if ($key->files != null || $key->files != ''){
					$row[] = '<a target="_blank" href="assets/documents/documents_tm/'.$key->files.'">'.$key->files.'</a>';
				} else {
					$row[] = '-';
				}
				if ($key->update_date != null){
					$row[] = $key->update_date;
				} else {
					$row[] = '-';
				}
				$data[] = $row;
				$no++;
			}
			$outputBalance = array('data' => $data);
			// dumper($outputBalance);
		} else {
			$outputBalance = array('data' => new ArrayObject());
		}
		echo json_encode($outputBalance);
	}

	public function getMaritalStatus(){
		$gender = decrypt($this->session->userdata('gender'));
		$marital_status = decrypt($this->session->userdata('marital_status'));

		$data = $this->form_model->getMaritalStatus($gender, $marital_status);

		echo json_encode($data);
	}

	public function getHROnly(){
		$data = $this->form_model->getHROnly();

		echo json_encode($data);
	}

	public function getCutiTidakAbsen($nik=''){
		if (empty($nik)){
			$nik			= $this->session->userdata('nik');
			$company_code 	= $this->session->userdata('company_code');
		} else {
			$company = $this->form_model->getCompany_ztm($nik);
			// $company_code = $company[0]['company_code'];
			$company_code = (!empty(($company))) ? $company[0]['company_code'] : '';
		}
		
		$data 	= $this->form_model->getCutiTidakAbsen($nik, $company_code);
		
		echo json_encode($data);
	}

	public function getCutiTidakAbsenHR($nik=''){
		if (empty($nik)){
			$nik			= $this->session->userdata('nik');
			$company_code 	= $this->session->userdata('company_code');
		} else {
			$company = $this->form_model->getCompany_ztm($nik);
			// $company_code = $company[0]['company_code'];
			$company_code = (!empty(($company))) ? $company[0]['company_code'] : '';
		}
		
		$data 	= $this->form_model->getCutiTidakAbsenHR($nik, $company_code);
		// dumper($data);
		echo json_encode($data);
	}

	public function getEmployee(){
		$nik	= $this->session->userdata('nik');

		$data = $this->form_model->getEmployee($nik);
		$x = 0;
		while($x < count($data)) {
			$data[$x]->complete_name = ucwords(strtolower(decrypt($data[$x]->complete_name)));
			$data[$x]->email = decrypt($data[$x]->email);
			$x++;
		}

		echo json_encode($data);
	}

	public function adjustEmployeeTO(){ 
		$nik_hr			= $this->session->userdata('nik');
		$email_hr		= $this->session->userdata('user_email');
		$module			= $_POST['module'];
		$code			= $_POST['code'];
		$name			= $_POST['name'];
		$sign			= $_POST['sign'];
		$amount			= $_POST['amount'];
		$emp_nik		= $_POST['emp_name'];
		$date			= $_POST['date'];
		$month 			= $_POST['month'];
		$year 			= $_POST['year'];

		$data = $this->form_model->adjustEmployeeTO($nik_hr, $email_hr, $module, $code, $name, $sign, $amount, $emp_nik, $date, $month, $year);

		echo json_encode($data);
	}

	public function getPreviousTO(){
		$data = $this->form_model->getPreviousTO_ztm();

		echo json_encode($data);
	}

	public function getDateSchedule($val){
		$nik	= $this->session->userdata('nik');

		$data = $this->form_model->getDateSchedule($nik, $val);

		echo json_encode($data);
	}

	public function request_attendance(){ 
		$nik			= $this->session->userdata('nik');
		
		$topId = $this->form_model->getRequestTopId();

		$date			= $_POST['date'];
		// if(!empty($_POST['is_status'])){
		// 	$clock_in 	= null;
		// } else {
		// 	$clock_in	= $_POST['clock_in'];
		// }
		if (!empty($_POST['is_status'])) {
			$note = "Missing CO" . (($_POST['note'] ?? '') !== '' ? ' | ' . $_POST['note'] : '');
		} else {
			$note = "Missing CI & CO" . (($_POST['note'] ?? '') !== '' ? ' | ' . $_POST['note'] : '');
		}
		$clock_in		= $_POST['clock_in'];
		$clock_out 		= $_POST['clock_out'];
		
		if ($topId != 0){
			$no 		= $topId[0]['id'];
		} else {
			$no 		= $topId;
		}

		
		list($data, $request_id, $email_to, $head_name) = $this->form_model->request_attendance_ztm($nik, $date, $clock_in, $clock_out, $note, $no);
		if ($data == true){
			$this->sendEmailTM('request_to_depthead_rpm', $request_id, $email_to, $head_name);
			///////////Menambahkan logs 2025//////////////////
			$this->logs('request_to_depthead_rpm', 'TM', $request_id, 'Request Attendance '.$date.' - '.$clock_in.' - '.$clock_out.' - '.$note, 'Success');
		}

		echo json_encode($data);
	}

	public function print_out_absen(){
		$data['request_id']= $this->uri->segment(3);
		$data['req_to'] = $this->form_model->getRequestTO_ztm($data['request_id']);

		$emp_name = $this->form_model->get_data_employee($data['req_to'][0]['nik'])[0];
		$data['full_name'] = ucwords(strtolower(decrypt($emp_name->complete_name)));
		$data['divhead_nik'] = decrypt($emp_name->division_head);
		$data['director_nik'] = decrypt($emp_name->director);
		$data['divhead_name'] = ucwords(strtolower(decrypt($emp_name->divhead_name)));
		$data['director_name'] = ucwords(strtolower(decrypt($emp_name->director_name)));
		$data['company'] = decrypt($emp_name->company_code);
		$data['company_name'] = decrypt($emp_name->company_name);

		$data['date'] = DateTime::createFromFormat('Y-m-d', $data['req_to'][0]['start_date'])->format('j F Y');

		$data['tm_emp'] = $this->form_model->getRequestDate_ztm($data['req_to'][0]['request_number']);
		$data['create_date'] = DateTime::createFromFormat('Y-m-d', $data['tm_emp'][0]['date'])->format('j F Y');
		// $data['create_date'] = DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->format('j F Y');

		$this->load->view('form/print_out/print_req_absen', $data);
	}	

	/////////// TIME MANAGEMENT 2.0 ///////////
	public function detail_approval_hr_adjust($formType, $req_no)
	{
		$data['form_request'] = $this->m_global->find('form_request', 'request_number', $req_no)->row_array();
		$data['header'] = $this->m_global->find('hris_time_management_adjustment', 'request_number', $req_no)->result_array();
		// dumper($data['header']);
		$nik_hr = $data['header'][0]['nik_hr'];
		$data['personal_detail'] = $this->form_model->getPersonalDetail_ztm($nik_hr);
		
		$request_id = $data['form_request']['id'];
		$data['emp_detail'] = $this->form_model->getEmpDetail_ztm($data['header']);
		
		$data['userList'] = $this->form_model->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		// $data['employee_list'] = $this->form_model->getUserList("employee_name", "employee", "is_active = 1 AND access_employee != 1 AND employee_name != '$this->emp_name'");
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'form/approval/'. $formType .'_HR';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
		
	}

	public function submit_schedule_shift()
	{
		$type 		= $_GET['type'];
		$start_date = $_GET['start_date'];
		$end_date 	= $_GET['end_date'];
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['header'] = $this->inbox_model->getApprovalList();
		$data['formType'] = $this->form_model->getFormType();
		$data['personal_detail'] = $this->form_model->getPersonalDetail_ztm($this->emp_id);
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['content'] = 'form/tm_schedule/' . $type;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function submit_schedule_holiday($type, $date)
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['header'] = $this->inbox_model->getApprovalList();
		$data['formType'] = $this->form_model->getFormType();
		$data['personal_detail'] = $this->form_model->getPersonalDetail_ztm($this->emp_id);
		$data['date'] = $date;
		$data['content'] = 'form/tm_schedule/' . $type;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function shift_schedule_table($start_date, $end_date, $nik=''){//TIME MANAGEMENT 2.2
		if (empty($nik)){
			$nik = $this->emp_id;
		}
		$listShift = $this->form_model->getShiftSchedule($nik, $start_date, $end_date);
		if (!empty($listShift)) {
			foreach ($listShift as $key) {

				$row   = array();
				$date = $key->date;
				$date = DateTime::createFromFormat('Y-m-d', $date)->format('Y.m.d');
				$row[] = $date;
				$row[] = $key->dws;
				$row[] = $key->schedule_in;
				$row[] = $key->schedule_out;
				$row[] = $key->check_in;
				$row[] = $key->check_out;

				//TIME MANAGEMENT 2.2
				$actualShift = $this->form_model->getDetailedShift_ztm($nik, $date); 
				if (!empty($actualShift)){
					$check_in = $actualShift->actual_in;
					$check_out = $actualShift->actual_out;
					$shift_type = $actualShift->shift_type;
				} else {
					$check_in = $key->check_in;
					$check_out = $key->check_out;
					$shift_type = $key->shift_type;
				}

				if (empty($check_in)){
					$free_text = 'Null';
					$shift = '';
				} else {
					$free_text = $check_in;
					$shift = $shift_type;
				}

				if (empty($check_out)){
					$free_text2 = 'Null';
				} else {
					$free_text2 = $check_out;
				}

				if (!empty($key->note)){
					$row[] = $check_in;
					$row[] = $check_out;
				} else {
					$row[] = '<a class="text-primary" data-toggle="modal" data-target="#modalEditCheckTime" data-offset="-4,0" id="'.$key->id.'" onClick="edit_shift_check_time('."'$check_in'".', '.$key->id.', 0, '."'$shift_type'".')">
							'.$free_text.'
							</a>'; 
					$row[] = '<a class="text-primary" data-toggle="modal" data-target="#modalEditCheckTime" data-offset="-4,0" id="'.$key->id.'" onClick="edit_shift_check_time('."'$check_out'".', '.$key->id.', 1, '."'$shift_type'".')">
							'.$free_text2.'
							</a>'; 
				}

				if ($this->session->userdata('access_employee') == '12'){
					$row[] = '<a class="text-primary" data-toggle="modal" data-target="#modalEditShiftType" data-offset="-4,0" id="'.$key->id.'" onClick="edit_shift_type('."'$shift_type'".', '.$key->id.')">
							'.$shift.'
							</a>';
				} else {
					$row[] = $shift;
				}
				
				if ($key->attendence_code == 'CTAB'){
					$row[] = $key->attendence_code;
				} else {
					$row[] = $key->time_off_code;
				}
				/////////////////////

				if ($this->session->userdata('access_employee') != '12'){
					if (empty($key->note)){
						$row[] = 'Not Yet Checked By HR';
					} else {
						$row[] = 'Checked By HR';
					}
				} else {
					if (!empty($key->note)){
						$checked_r = 'checked';
					} else {
						$checked_r = '';
					}
					$row[] = "<input type='checkbox' class='checkShift checked_id_shift' name='id_request_shift[]' value='".$key->id."' ".$checked_r.">";
				}
				
				$data[] = $row;
			}
			$outputSchedule = array('data' => $data);
		} else {
			$outputSchedule = array('data' => new ArrayObject());
		}
		echo json_encode($outputSchedule);
	}

	public function submitRequestTM(){
		$nik = $this->input->post('nik');
		$type = $this->input->post('tipe');

		if ($type == 'shift'){
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$desc = $this->input->post('desc', FALSE);
		} else {
			$date = $this->input->post('date');
			$purpose = $this->input->post('purpose', FALSE);
			$location = $this->input->post('location', FALSE);
		}

		$topId = $this->form_model->getRequestTopId();

		if ($topId != 0){
			$no = $topId[0]['id'];
		} else {
			$no = $topId;
		}
		
		if ($type == 'shift'){
			list($data, $request_id, $email_to, $head_name) = $this->form_model->submitRequestTM_ztm($type, $nik, $start_date, $end_date, $desc, $no);
		} else {
			list($data, $request_id, $email_to, $head_name) = $this->form_model->submitRequestTMHoliday_ztm($type, $nik, json_decode(rawurldecode($date)), $purpose, $location, $no);
		}

		$output = array('status' => $data, 'request_id' => encode_url($request_id));

		echo json_encode($output);
	}

	public function hr_request_table(){
		$listReq = $this->form_model->getRequestAdjustment_ztm($this->session->userdata('nik'));
		if (!empty($listReq)) {
			$no = count($listReq);
			foreach ($listReq as $key) {

				$row   = array();
				$row[] = $no;
				$row[] = $key->request_number;
				$row[] = $key->nama_modul;

				$form_req = $this->m_global->find('form_request', 'request_number', $key->request_number)->row_array();
				$row[] = date('d.m.Y', strtotime($form_req['created_at']));
				
				if ($key->status == 0){
					$row[] = 'Waiting for Approval';
				} else if ($key->status == 1){
					$row[] = 'Approved';
				} else if ($key->status == 2){
					$row[] = 'Rejected';
				} else if ($key->status == 3){
					$row[] = 'Cancelled';
				}

				if ($key->status == 0){
					$trash = '<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteAdjustment" data-offset="-4,0" id="'.$key->id.'" onClick="delete_request_adjustment('.$key->id.')">
							<em class="icon ni ni-trash"></em>
							</a>';	
				} else {
					$trash = '';
				}
				$row[] = '<div class="btn-group btn-group-sm">
								<a class="text-primary btn btn-icon btn-trigger" data-offset="-4,0" id="'.$key->id.'" onClick="detail_approval_req_adj('."'$key->request_number'".')">
								<em class="icon ni ni-info"></em>
								</a>
								'. $trash .'
							</div>
							';
							
				$data[] = $row;
				$no--;
			}
			$outputReq = array('data' => $data);
		} else {
			$outputReq = array('data' => new ArrayObject());
		}
		echo json_encode($outputReq);
		
	}

	public function getDeleteRequestAdjustment($opt){
		$id = $_POST['id'];

		list($data, $request_id, $email_to, $head_name) = $this->form_model->getDeleteRequestSchedule_ztm($id, $opt);
		///////////Menambahkan logs 2025//////////////////
		$this->logs('delete_request_adjustment', 'TM', $request_id, 'Delete Request Adjustment', 'Deleted');
		echo json_encode($data);
	}

	public function detail_approval_tm_schedule($formType, $req_id)
	{
		$request_id = decode_url($req_id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
		$data['header'] = $this->m_global->find('hris_schedule_request', 'request_id', $request_id)->row_array();

		$employee_id = $data['header']['nik'];
		$data['personal_detail'] = $this->form_model->getTruePersonal_ztm($employee_id);

		$data['userList'] = $this->form_model->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		// $data['employee_list'] = $this->form_model->getUserList("employee_name", "employee", "is_active = 1 AND access_employee != 1 AND employee_name != '$this->emp_name'");
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'form/approval/'. $formType .'_schedule_'. $data['header']['schedule_type'];
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function schedule_request_table(){
		$listReq = $this->form_model->getScheduleRequest_ztm($this->session->userdata('nik'));
		if (!empty($listReq)) {
			$no = count($listReq);
			foreach ($listReq as $key) {

				$row   = array();
				$row[] = $no;
				$row[] = $key->request_number;
				$row[] = strtoupper($key->schedule_type);
				$row[] = $key->start_date;
				$row[] = $key->end_date;
				if ($key->status == 0){
					$row[] = 'Waiting for Approval';
				} else if ($key->status == 1){
					$row[] = 'Approved';
				} else if ($key->status == 2){
					$row[] = 'Rejected';
				} else if ($key->status == 3){
					$row[] = 'Cancelled';
				} else if ($key->status == 4){
					$row[] = 'Need to be Revised';
				}

				$encoded_url = encode_url($key->request_id);
				// if ($key->status == 0){
				// 	$trash = '<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteScheduleReq" data-offset="-4,0" id="'.$key->id.'" onClick="delete_request_schedule('.$key->id.')">
				// 			<em class="icon ni ni-trash"></em>
				// 			</a>';	
				// } else {
				// 	$trash = '';
				// }
				if ($key->status == 0){
					$cek	= $this->form_model->CekApprovalLayer($key->request_number)[0]->result;
					if($cek){
						$trash = '';	
					}else{
						$trash = '<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteScheduleReq" data-offset="-4,0" id="'.$key->id.'" onClick="delete_request_schedule('.$key->id.')">
							<em class="icon ni ni-trash"></em>
							</a>';
					}
				} else {
					$trash = '';
				}
				
				$row[] = '<div class="btn-group btn-group-sm">
								<a class="text-primary btn btn-icon btn-trigger" data-offset="-4,0" id="'.$key->id.'" onClick="detail_approval_sch_req('."'$encoded_url'".')">
								<em class="icon ni ni-info"></em>
								</a>
								'. $trash .'
							</div>
							';
							
				$data[] = $row;
				$no--;
			}
			$outputReq = array('data' => $data);
		} else {
			$outputReq = array('data' => new ArrayObject());
		}
		echo json_encode($outputReq);
		
	}

	public function print_out_schedule(){
		$data['request_id']= $this->uri->segment(3);
		$data['req_schedule'] = $this->form_model->getRequestSchedule_ztm($data['request_id']);

		$emp_name = $this->form_model->get_data_employee($data['req_schedule'][0]['nik'])[0];
		if (decrypt($emp_name->action) == "Leaving"){
			$emp_name = $this->form_model->getTrueEmpData_ztm($data['req_schedule'][0]['nik'], $emp_name->action)[0];
		}
		$data['full_name'] = strtoupper(decrypt($emp_name->complete_name));
		$data['jabatan'] = decrypt($emp_name->position);
		$data['divisi'] = decrypt($emp_name->division);

		if(!empty($emp_name->rpm_name)){
			$data['manager_nik'] = decrypt($emp_name->rpm);
			$data['manager_name'] = strtoupper(decrypt($emp_name->rpm_name));
		} else if (!empty($emp_name->depthead_name)){
			$data['manager_nik'] = decrypt($emp_name->department_head);
			$data['manager_name'] = strtoupper(decrypt($emp_name->depthead_name));
		} else if (!empty($emp_name->divhead_name)){
			$data['manager_nik'] = decrypt($emp_name->division_head);
			$data['manager_name'] = strtoupper(decrypt($emp_name->divhead_name));
		} else if (!empty($emp_name->director_name)){
			$data['manager_nik'] = decrypt($emp_name->director);
			$data['manager_name'] = strtoupper(decrypt($emp_name->director_name));
		}
		
		$manager_full_info = $this->form_model->get_data_employee($data['manager_nik'])[0];
		$data['manager_position'] = decrypt($manager_full_info->position);

		$data['divhead_nik'] = decrypt($emp_name->division_head);
		$data['divhead_name'] = strtoupper(decrypt($emp_name->divhead_name));
		$divhead_full_info = $this->form_model->get_data_employee($data['divhead_nik'])[0];
		$data['divhead_position'] = decrypt($divhead_full_info->position);

		$data['schedule'] = $this->form_model->getShiftScheduleActual_ztm($data['req_schedule'][0]['nik'], $data['req_schedule'][0]['start_date'], $data['req_schedule'][0]['end_date']);

		$data['req_form'] = $this->form_model->getReqFormDate_ztm($data['request_id']);
		$data['apprv1'] = $this->form_model->getAppFormDate_ztm($data['request_id'],1); 
		$data['apprv2'] = $this->form_model->getAppFormDate_ztm($data['request_id'],2); 
		$data['apprv3'] = $this->form_model->getAppFormDate_ztm($data['request_id'],3); 
		
		$hr_email = $data['req_form'][0]['updated_by'];
		if (!empty($hr_email)){
			$hr_detail = $this->form_model->getUserDetail_ztm($hr_email);
			$data['hr_nik'] = $hr_detail->employee_id;
			$data['hr_name'] = strtoupper($hr_detail->full_name);

			$hr_full_info = $this->form_model->get_data_employee($data['hr_nik'])[0];
			$data['hr_position'] = decrypt($hr_full_info->position);
		} else {
			$data['hr_nik'] = '';
			$data['hr_name'] = '';
			$data['hr_position'] = '';
		}
		
		$data['company'] = decrypt($emp_name->company_code);
		$this->load->view('form/print_out/print_req_schedule', $data);
	}

	public function getDayOff(){
		$data = $this->form_model->getDayOff_ztm();

		echo json_encode($data);
	}

	public function holiday_schedule_table($date, $nik=''){ 
		if (empty($nik)){
			$nik = $this->emp_id;
		}
		$date = json_decode(rawurldecode($date));
		
		$listHol = $this->form_model->getHolidaySchedule_ztm($nik, $date);
		if (!empty($listHol)) {
			foreach ($listHol as $key) {

				$row   = array();
				$cur_date = $key->date;
				$cur_date = DateTime::createFromFormat('Y-m-d', $cur_date)->format('Y.m.d');
				$row[] = $cur_date;
				$row[] = $key->full_name;
				$row[] = $key->employee_id;

				$actualShift = $this->form_model->getDetailedShift_ztm($nik, $cur_date); 
				if (!empty($actualShift)){
					$check_in = $actualShift->actual_in;
					$check_out = $actualShift->actual_out;
					$shift_type = $actualShift->shift_type;
				} else {
					$check_in = $key->check_in;
					$check_out = $key->check_out;
					$shift_type = $key->shift_type;
				}

				if (empty($check_in)){
					$free_text_time = 'Null';
				} else {
					$free_text_time = $check_in;
				}

				if (empty($key->check_in_date)){
					$free_text_date = 'Null';
				} else {
					$free_text_date = $key->check_in_date;
				}

				if (empty($check_out)){
					$free_text_time2 = 'Null';
				} else {
					$free_text_time2 = $check_out;
				}

				if (empty($key->check_out_date) || $key->check_out_date == '1900-01-01'){
					$free_text_date2 = 'Null';
				} else {
					$free_text_date2 = $key->check_out_date;
				}

				if (!empty($key->note) && (!empty($key->flag) && $key->flag !=0) ){
					$row[] = $key->check_in_date;
					$row[] = $key->check_in;
					$row[] = $check_in;
					$row[] = $key->check_out_date;
					$row[] = $key->check_out;
					$row[] = $check_out;
				} else {
					$row[] = '<a class="text-primary" data-toggle="modal" data-target="#modalEditCheckDate" data-offset="-4,0" id="'.$key->id.'" onClick="edit_shift_check_date('."'$key->check_in_date'".', '.$key->id.', 0)">
							'.$free_text_date.'
							</a>';
					$row[] = $key->check_in;
					$row[] = '<a class="text-primary" data-toggle="modal" data-target="#modalEditCheckTime" data-offset="-4,0" id="'.$key->id.'" onClick="edit_shift_check_time('."'$key->check_in'".', '.$key->id.', 0, '."''".')">
							'.$free_text_time.'
							</a>';
					$row[] = '<a class="text-primary" data-toggle="modal" data-target="#modalEditCheckDate" data-offset="-4,0" id="'.$key->id.'" onClick="edit_shift_check_date('."'$key->check_out_date'".', '.$key->id.', 1)">
							'.$free_text_date2.'
							</a>';
					$row[] = $key->check_out;
					$row[] = '<a class="text-primary" data-toggle="modal" data-target="#modalEditCheckTime" data-offset="-4,0" id="'.$key->id.'" onClick="edit_shift_check_time('."'$key->check_out'".', '.$key->id.', 1, '."''".')">
							'.$free_text_time2.'
							</a>';
				}

				if ($key->attendence_code == 'CTAB'){
					$row[] = $key->attendence_code;
				} else {
					$row[] = $key->time_off_code;
				}

				if ($this->session->userdata('access_employee') != '12'){
					if (empty($key->note)){
						$row[] = 'Not Yet Checked By HR';
					} else {
						$row[] = 'Checked By HR';
					}
				} else {
					if (!empty($key->note)){
						$checked_r = 'checked';
					} else {
						$checked_r = '';
					}
					$row[] = "<input type='checkbox' class='checkShift checked_id_shift' name='id_request_shift[]' value='".$key->id."' ".$checked_r.">";
				}
				
				$data[] = $row;
			}
			$outputSchedule = array('data' => $data);
		} else {
			$outputSchedule = array('data' => new ArrayObject());
		}
		echo json_encode($outputSchedule);
	}

	public function getYears(){
		$data = $this->form_model->getYears_ztm();
		$x = 0;
		while($x < count($data)) {
			$data[$x]->date = DateTime::createFromFormat('Y-m-d', $data[$x]->date)->format('Y');
			$x++;
		}

		echo json_encode($data);
	}

	public function editShiftAttendance(){
		$id = $_POST['id'];
		$time = $_POST['time'];
		$type = $_POST['type'];
		$shift_type = $_POST['shift_type'];

		$data = $this->form_model->updateShiftAttendance_ztm($id, $time, $type, $shift_type);
		echo json_encode($data);
	}

	public function checkSchedule(){
		$nik = $this->emp_id;
		$start 		= json_decode(rawurldecode($this->input->post('start_date')));
		$end 		= json_decode(rawurldecode($this->input->post('end_date')));
		$start 		= date("Y-m-d", strtotime($start));
		$end 		= date("Y-m-d", strtotime($end));

		$data = $this->form_model->checkSchedule_ztm($nik, $start, $end);
		echo json_encode($data);
	}

	public function check_shift_by_hr(){
		$list_shift	= $_POST['list_shift'];
		$list_shift_un	= $_POST['list_shift_un'];
		$type		= $_POST['type'];
		$id = $_POST['id'];
		if ($list_shift[0] == ''){
			$list_shift = array();
		}
		if ($list_shift_un[0] == ''){
			$list_shift_un = array();
		}
		
		$data = $this->form_model->updateShiftSchedule_ztm($id, $type, $list_shift, $list_shift_un);
		echo json_encode($data);
	}

	public function editShiftAttendanceDate(){
		$id = $_POST['id'];
		$date = $_POST['date'];
		$date = date("Y-m-d", strtotime($date));
		$type = $_POST['type'];

		$data = $this->form_model->updateShiftAttendanceDate_ztm($id, $date, $type);
		echo json_encode($data);
	}

	public function print_out_schedule_hol(){

		$data['request_id']= $this->uri->segment(3);
		$data['req_schedule'] = $this->form_model->getRequestSchedule_ztm($data['request_id']);

		$emp_name = $this->form_model->get_data_employee($data['req_schedule'][0]['nik'])[0];
		
		$data['full_name'] = ucwords(strtoupper(decrypt($emp_name->complete_name)));
		$data['jabatan'] = decrypt($emp_name->position);
		$data['divisi'] = decrypt($emp_name->division);
		$data['cost_center'] = decrypt($emp_name->cost_center);

		if(!empty($emp_name->rpm_name)){
			$data['manager_nik'] = decrypt($emp_name->rpm);
			$data['manager_name'] = ucwords(strtoupper(decrypt($emp_name->rpm_name)));

			$data['divhead_nik'] = decrypt($emp_name->division_head);
			$data['divhead_name'] = strtoupper(decrypt($emp_name->divhead_name));
			$divhead_full_info = $this->form_model->get_data_employee($data['divhead_nik'])[0];
			$data['divhead_position'] = decrypt($divhead_full_info->position);

		} else if (!empty($emp_name->depthead_name)){
			$data['manager_nik'] = decrypt($emp_name->department_head);
			$data['manager_name'] = ucwords(strtoupper(decrypt($emp_name->depthead_name)));

			$data['divhead_nik'] = decrypt($emp_name->division_head);
			$data['divhead_name'] = strtoupper(decrypt($emp_name->divhead_name));
			$divhead_full_info = $this->form_model->get_data_employee($data['divhead_nik'])[0];
			$data['divhead_position'] = decrypt($divhead_full_info->position);

		} else if (!empty($emp_name->divhead_name)){
			$data['manager_nik'] = decrypt($emp_name->division_head);
			$data['manager_name'] = ucwords(strtoupper(decrypt($emp_name->divhead_name)));

			$data['divhead_nik'] = decrypt($emp_name->director);
			$data['divhead_name'] = strtoupper(decrypt($emp_name->director_name));
			$divhead_full_info = $this->form_model->get_data_employee($data['divhead_nik'])[0];
			$data['divhead_position'] = decrypt($divhead_full_info->position);

		} else if (!empty($emp_name->director)){
			$data['manager_nik'] = decrypt($emp_name->director);
			$data['manager_name'] = ucwords(strtoupper(decrypt($emp_name->director_name)));

			$data['divhead_nik'] = decrypt($emp_name->director);
			$data['divhead_name'] = strtoupper(decrypt($emp_name->director_name));
			$divhead_full_info = $this->form_model->get_data_employee($data['divhead_nik'])[0];
			$data['divhead_position'] = decrypt($divhead_full_info->position);
		}
		$manager_full_info = $this->form_model->get_data_employee($data['manager_nik'])[0];
		$data['manager_position'] = decrypt($manager_full_info->position);

		// $data['divhead_nik'] = decrypt($emp_name->division_head);
		// $data['divhead_name'] = strtoupper(decrypt($emp_name->divhead_name));
		// $divhead_full_info = $this->form_model->get_data_employee($data['divhead_nik']);
		// $data['divhead_position'] = decrypt($divhead_full_info->position);

		$data['schedule'] = $this->form_model->getHolidayScheduleActual_ztm($data['req_schedule'][0]['nik'], unserialize($data['req_schedule'][0]['date']));

		$data['req_form'] = $this->form_model->getReqFormDate_ztm($data['request_id']);
		$data['apprv1'] = $this->form_model->getAppFormDate_ztm($data['request_id'],1); 
		$data['apprv2'] = $this->form_model->getAppFormDate_ztm($data['request_id'],2); 
		$data['apprv3'] = $this->form_model->getAppFormDate_ztm($data['request_id'],3); 

		$hr_email = $data['req_form'][0]['updated_by'];
		if (!empty($hr_email)){
			$hr_detail = $this->form_model->getUserDetail_ztm($hr_email);
			$data['hr_nik'] = $hr_detail->employee_id;
			$data['hr_name'] = strtoupper($hr_detail->full_name);

			$hr_full_info = $this->form_model->get_data_employee($data['hr_nik']);
			$data['hr_position'] = decrypt($hr_full_info->position);
		} else {
			$data['hr_nik'] = '';
			$data['hr_name'] = '';
			$data['hr_position'] = '';
		}
		
		$data['company'] = decrypt($emp_name->company_code);

		$this->load->view('form/print_out/print_req_schedule_hol', $data);
	}
	
	public function update_info_holiday(){
		$id = $_POST['id'];
		$purpose = $_POST['pur'];
		$location = $_POST['loc'];

		$data = $this->form_model->updateInfoHoliday_ztm($id, $purpose, $location);
		///////////Menambahkan logs 2025//////////////////
		$this->logs('update_info_holiday', 'TM', '0', 'Update info holiday '.$purpose, 'Success');
		echo json_encode($data);
	}

	public function getLastDay(){
		$data = $this->form_model->getLastDay_ztm();
		echo json_encode($data);
	}

	public function update_info_shift(){
		$id = $_POST['id'];
		$purpose = $_POST['pur'];

		$data = $this->form_model->updateInfoShift_ztm($id, $purpose);
		echo json_encode($data);
	}

	public function editShiftType(){
		$id = $_POST['id'];
		$shift_type = $_POST['shift_type'];

		$data = $this->form_model->updateShiftType_ztm($id, $shift_type);
		echo json_encode($data);
	}
	
	public function save_file_location($loc_in, $loc_out){
		$count = $loc_in + $loc_out;
		$i = 0;
		while($i < $count){
			if ($loc_in == 1){
				$uploaded_file = 'req_loc_in_upload_file';
			} else if ($loc_out == 1) {
				$uploaded_file = 'req_loc_out_upload_file';
			}
			
			$config = [
				'upload_path' => './assets/documents/documents_tm/request_location',
				'allowed_types' => '*'
			];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload($uploaded_file);
			$file = $this->upload->data();
			$file_update = $file['file_name'];
			$file_type = strtolower(pathinfo($file_update,PATHINFO_EXTENSION));
	
			if(($_FILES[$uploaded_file]['error'] == 0)){
				if ($loc_in == 1){
					$data[0] = $file_update;
					$data[1] = '';
				} else if ($loc_in == 0 && $loc_out == 1) {
					$data[0] = '';
					$data[1] = $file_update;
				} else if ($loc_in != 1 && $loc_out == 1) {
					$data[1] = $file_update;
				}
	
			} else if(($_FILES[$uploaded_file]['error'] == 1) || ($_FILES[$uploaded_file]['error'] == 2)){
	
				$data = 0;
			} else if (($_FILES[$uploaded_file]['error'] == 3)){
				
				$data = 1;
			} else if (($_FILES[$uploaded_file]['error'] == 6)){
				
				$data = 2;
			} else if (($_FILES[$uploaded_file]['error'] == 7)){
				
				$data = 3;
			} else {
	
				$data = 5;
			}

			$i++;
			$loc_in++;
		}

		echo json_encode($data);
	}

	public function request_location(){
		$date = $_POST['date'];
		$date = date("Y-m-d", strtotime($date));
		$file_in = $_POST['file_in'];
		$file_out = $_POST['file_out'];

		$topId = $this->form_model->getRequestTopId();
		if ($topId != 0){
			$no = $topId[0]['id'];
		} else {
			$no = $topId;
		}

		list($data, $request_id, $approval_email, $approval_name) = $this->form_model->requestLocation_ztm($date, $file_in, $file_out, $no);

		if ($request_id != ''){
			$this->sendEmailTM('request_to_head_loc', $request_id, $approval_email, $approval_name);
			$this->sendEmailTM('info_to_hr', $request_id, 'hr_support@ibsmulti.com');
			///////////Menambahkan logs 2025//////////////////
			$this->logs('request_location', 'TM', $request_id, 'Request Location '.$date, 'Success');
		}
		echo json_encode(encode_url($request_id));
	}

	public function sendEmailTM($type, $requestId, $email_to, $extdata = "")
	{
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id'])[0];
		$data['request_to'] = $this->m_global->find('hris_request_time_off', 'request_id', $requestId)->row_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		$data['notes'] = $this->m_global->find('request_notes', 'request_id', $requestId)->result_array();
		
		if($type == 'request_to_depthead_rpm'){
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$data['email'] = 'ANANDHA.HOKKY@IBSMULTI.COM';
			}else{
				$data['email'] = $email_to;
			}
			$data['full_name'] = ucwords($extdata);
			$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/requestToDeptheadRPM', $data, TRUE);
			$email_subject = '[HRIS-TM] Approval Request';
		}
		else if($type == 'request_to_head_loc'){
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$data['email'] = 'ANANDHA.HOKKY@IBSMULTI.COM';
			}else{
				$data['email'] = $email_to;
			}
			$data['full_name'] = ucwords($extdata);
			$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/requestToDeptheadRPM', $data, TRUE);
			$email_subject = '[HRIS-TM] Approval Request';
		}
		else if($type == 'cancel_to_depthead_rpm'){
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$data['email'] = 'ANANDHA.HOKKY@IBSMULTI.COM';
			}else{
				$data['email'] = $email_to;
			}
			$data['full_name'] = ucwords($extdata);
			$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/cancelToDeptheadRPM', $data, TRUE);
			$email_subject = '[HRIS-TM] Request Cancel';
		}
		// TIME MANAGEMENT 2.0
		elseif($type == 'email_cuti_minus'){
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$data['email'] = 'ANANDHA.HOKKY@IBSMULTI.COM';
			}else{
				$data['email'] = $email_to;
			}
			$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$data['gender'] = decrypt($data['data_employee']->gender);
			$data['personnel_subarea'] = decrypt($data['data_employee']->personnel_subarea);
			$data['company_name'] = decrypt($data['data_employee']->company_name);
			$data['total_cuti'] = $extdata;
			$html = $this->load->view('services/email/email_cuti_minus', $data, TRUE);
			$email_subject = 'HRIS-Informasi Cuti Minus';
		} else if ($type == 'info_to_hr'){ //CR 3 TM
			$email_to	   = 'hr.support@ibsmulti.com'; // COMMENT: OPEN THIS
			$data['emp_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/infoToHRLoc', $data, TRUE);
			$email_subject = 'HRIS-Request Revised Location';
		}
		///////////////////////

		$mail = new PHPMailer();
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->isSMTP();
		$mail->Host       = 'mail.ibsmulti.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
		$mail->Password   = '1214#$C1k1n1.2026'; // ubah dengan password email Anda
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;

		$mail->setFrom('no.reply@ibsmulti.com', 'Notification System HRIS - IBS'); // ubah dengan alamat email Anda

		// $link_host = "$_SERVER[HTTP_HOST]";
		// if($link_host != "172.19.8.84" && $link_host != "medclaim.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com")){
		// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
		// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
		// }else{
		// 	if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
		// 		$mail->addAddress('ANANDHA.HOKKY@IBSMULTI.COM');
		// 	}else{
		// 		$mail->addAddress($email_to);
		// 	}
		// 	$mail->addBCC('luffi.utomo@ibsmulti.com');
		// 	$mail->addBCC('ditha.damayanti@ibsmulti.com');
		// 	$mail->addBCC('hr.support@ibsmulti.com');
		// 	// $mail->addBCC('abimas.dewangga@ibsmulti.com');
		// }

		if($this->status_apps == "development") {

			$prefix = 'DEV TEST - ';
			$email_subject = $prefix . $email_subject;

			$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('luffi.utomo@ibsmulti.com');
			$mail->addCC('ditha.damayanti@ibsmulti.com');
		} else if ($this->status_apps == "staging") {

			$prefix = 'STAGING TEST - ';
			$email_subject = $prefix . $email_subject;

			$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('luffi.utomo@ibsmulti.com');
			$mail->addCC('ditha.damayanti@ibsmulti.com');
			
		} else if ($this->status_apps == "production") {
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$mail->addAddress('ANANDHA.HOKKY@IBSMULTI.COM');
			}else{
				$mail->addAddress($email_to);
			}
			$mail->addBCC('luffi.utomo@ibsmulti.com');
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
			$mail->addBCC('hr.support@ibsmulti.com');
		}
		

		// Isi Email
		$mail->isHTML(true);
		$mail->Subject = $email_subject;
		$mail->Body    = $html;

		$mail->send();
	}

	public function getCalendarEmployee(){

		// $start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date 		= date("Y-m-d", strtotime($_POST['end_date']));
		$data = $this->form_model->getCalendarEmployee($end_date);
		echo json_encode($data);

	}
	//////////////////////////////////////////////////// END TIME MANAGEMENT 2024////////////////////////////////////////////////////

	//////////////////////////////////////////Update Logs 2025//////////////////////////////////////////////////////
	public function logs($type='', $formType='', $id='', $activity = '', $description = '')
	{
		$log['request_id'] = $id;
		$log['form_type'] = $formType;
		$log['created_by'] = ($type == 'system') ? 'system' : $this->email;
		$log['created_at'] = $this->date;

		switch ($type) {

			case 'system':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			case 'create':
				$log['activity'] = 'Create new';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'approved':
				$log['activity'] = 'Approved';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'revised':
				$log['activity'] = 'Revised';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'submit_request':
				$log['activity'] = 'Submit request';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'pullback':
				$log['activity'] = 'Pullback request';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'delete_kpi_row':
				$log['activity'] = 'Delete KPI item';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'add_kpi_row':
				$log['activity'] = 'Add KPI item';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'add_plan_row':
				$log['activity'] = 'Add Plan item';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'update_kpi_row':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			case 'update_plan_row':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			case 'submit_ppd':
				$log['activity'] = 'Submit PPD';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'save_draft_ppd':
				$log['activity'] = 'Save Draft PPD';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;
				
			case 'checked_mdcr_hr':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;
			
			case 'request_to_depthead_rpm':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			case 'cancel_to_depthead_rpm':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;
		
			case 'request_to_depthead_rpm':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;
		
			case 'delete_request_adjustment':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;
		
			case 'update_info_holiday':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			case 'request_location':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;
			
			case 'request_adjuct_cuti':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

	public function get_qrcode(){
		$config['cacheable']    = true;
		$config['cachedir']     = 'assets/';
		$config['errorlog']     = 'assets/';
		$config['imagedir']     = 'assets/images/testQR/';
		$config['imagelogo']    = 'assets/images/IBS.png';
		$config['quality']      = true;
		$config['size']         = '1024';
		$config['black']        = array(224, 255, 255);
		$config['white']        = array(70, 130, 180);
		$this->ciqrcode->initialize($config);
		$image_name 			= 'TESTQRCODE.png';
		$params['data'] 		= 'TestGambar';
		$params['level'] 		= 'H'; //H=High
		$params['size'] 		= 10;
		$params['savename'] 	= FCPATH . $config['imagedir'] . $image_name;
		$params['logo'] 		= FCPATH . $config['imagelogo'];
		$params['imagetmp'] 	= $config['imagedir'];
		$this->ciqrcode->generate($params);
	}

	/////////////////////////////Start couple 2025//////////////////////////
	public function cek_data_couple()
	{
		$employee_nik				= $_POST['employee_nik'];
		$kuitansi_date				= date("Y-m-d", strtotime($_POST['tanggal_kuitansi']));
		$data = $this->form_model->get_data_couple_employee($employee_nik, $kuitansi_date);
		// dumper($data);
		echo json_encode($data);
	}

	//////////////////////////////Start Penambahan action sent to AP Luffi 2025//////////////////////////////
	
	public function SentDocumentsToAP()
	{
		$no_req_mdcr = $this->input->post('id');
		$respone = $this->form_model->SentDocumentsToAP($no_req_mdcr);
		if ($respone == true) {
			///////////Menambahkan logs 2025//////////////////
			$this->logs('sent_doc_mdcr_ap', 'MDCR', $no_req_mdcr, 'Sent No Doc MDCR', 'Success');

			// $this->sendEmail('request_approve_mdcr', $request_id, 'email', );
			$data_forms = $this->form_model->getAllFormGroup($no_req_mdcr);
				
			foreach ($data_forms as $key => $value) {
				$this->sendEmail('approve_to_ap', $value->id, $value->created_by, $value->employee_id);

				$data['form_request'] = $this->m_global->find('form_request', 'id', $value->id)->row_array();

				$form_log_request = array(
					'request_id' => $value->id,
					'activity' => 'Send AP',
					'desc' =>  $data['form_request']['request_number'] . ' Sent',
					'create_at' => $this->date,
					'create_by' => $this->email,
					'type' => 'MDCR',
					'activity_desc' => 'Sent_to_AP' 
				);

				$this->db->insert('form_logs', $form_log_request);
			}

			echo json_encode($respone);
		} else {
			echo json_encode($respone);
		}
	}


	public function get_doc_mdcr_div_hr_fi()
	{
		// Ambil parameter dari DataTables
		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];

		// Ambil total data tanpa filter
		$totalData = $this->inbox_model->countAllMDCRFI();

		// Ambil data sesuai paging dan search
		$dataList = $this->inbox_model->getApprovalListMDCRAfterGroupingServer($start, $length, $search);

		$data = [];
		foreach ($dataList as $value) {
			$no_req    = $value['no_req_mdcr'];
			$no_req_id = str_replace("HRIS_MDCR", "", $no_req);

			$row = [];
			$row[] = $no_req;
			$row[] = status_mdcr_color($value['is_status_progress']);

			if ($value['is_status_progress'] == 1) {
				$row[] = '
					<a class="btn btn-outline-warning" data-toggle="modal" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="viewResumeNoReqToFI(this)" ><em class="icon ni ni-list"></em></a>
					<a data-toggle="modal" data-offset="-4,0" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="print_out_req_mdcr_all_per_day(this)" class="btn btn-outline-primary" title="Recap Medical Reimbursement"><em class="icon ni ni-printer"></em></a>
        			<a data-toggle="modal" data-offset="-4,0" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="action_approve_devhead_hr(this)" class="btn btn-outline-danger"><em class="icon ni ni-sign-dash"></em></a></td>';
			} else {
				$row[] = '
					<a class="btn btn-outline-warning" data-toggle="modal" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="viewResumeNoReqToFI(this)" ><em class="icon ni ni-list"></em></a>
					<a data-toggle="modal" data-offset="-4,0" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="print_out_req_mdcr_all_per_day(this)" class="btn btn-outline-primary" title="Recap Medical Reimbursement"><em class="icon ni ni-printer"></em></a>
				';

			}	

			$row['DT_RowClass'] = 'SearchMDCR';

			$data[] = $row;
		}

		// Hitung total setelah filter
		$filtered = $this->inbox_model->countFilteredMDCRFI($search);

		$output = [
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $filtered,
			"data" => $data
		];

		echo json_encode($output);
	}

	public function get_doc_mdcr_fi()
	{
		// Ambil parameter dari DataTables
		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];

		// Ambil total data tanpa filter
		$totalData = $this->inbox_model->countAllMDCRFI();

		// Ambil data sesuai paging dan search
		$dataList = $this->inbox_model->getApprovalListMDCRAfterGroupingServer($start, $length, $search);

		$data = [];
		foreach ($dataList as $value) {
			$no_req    = $value['no_req_mdcr'];
			$no_req_id = str_replace("HRIS_MDCR", "", $no_req);

			$row = [];
			$row[] = $no_req;
			$row[] = status_mdcr_color($value['is_status_progress']);

			if ($value['is_status_progress'] != 2) {
				$row[] = '
					<a class="btn btn-outline-danger disabled" title="Sent documents to AP"><em class="icon ni ni-send"></em></a>
					<a class="btn btn-outline-warning" title="View Request" data-no_req="'.$no_req.'" onClick="viewResumeNoReqToFI(this)"><em class="icon ni ni-list"></em></a>
					<a class="btn btn-outline-primary" title="Recap Medical Reimbursement" data-no_req="'.$no_req.'" onClick="print_out_req_mdcr_all_per_day(this)"><em class="icon ni ni-printer"></em></a>';
			} else {
				$row[] = '
				
					<a class="btn btn-outline-danger" title="Sent documents to AP" data-no_req="'.$no_req.'" onClick="SentMDCRToAP(this)" ><em class="icon ni ni-send"></em></a>
					<a class="btn btn-outline-warning" title="View Request" data-no_req="'.$no_req.'" onClick="viewResumeNoReqToFI(this)"><em class="icon ni ni-list"></em></a>
					<a class="btn btn-outline-primary" title="Recap Medical Reimbursement" data-no_req="'.$no_req.'" onClick="print_out_req_mdcr_all_per_day(this)"><em class="icon ni ni-printer"></em></a>';

			}

			$row['DT_RowClass'] = 'SearchMDCR';

			$data[] = $row;
		}

		// Hitung total setelah filter
		$filtered = $this->inbox_model->countFilteredMDCRFI($search);

		$output = [
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $filtered,
			"data" => $data
		];

		echo json_encode($output);
	}
	
	
	public function get_approved_mdcr()
	{

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];

		$result = $this->inbox_model->getMDCRApprovedServerSide($start, $length, $search);

		$data = [];
		foreach ($result['data'] as $value) {
			$url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"]));
			$row = [];
			$row[] = $value['employee_id'];
			$row[] = decrypt($value['complete_name']);
			$row[] = "<a href='".$url."'>".$value['request_number']."</a>";
			$row[] = $value['no_req_mdcr'];
			$row['DT_RowClass'] = 'SearchMDCR';
			$data[] = $row;
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);

	}
	
	public function get_reject_mdcr()
	{

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order  = $this->input->post('order');
		$column = $this->input->post('columns');

		$result = $this->inbox_model->getMDCRRejectServerSide($start, $length, $search, $order, $column);

		$data = [];
		foreach ($result['data'] as $value) {
			$url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"]));
			$row = [];
			$row[] = $value['employee_id'];
			$row[] = decrypt($value['complete_name']);
			$row[] = "<a href='".$url."'>".$value['request_number']."</a>";
			$row['DT_RowClass'] = 'SearchMDCR';
			$data[] = $row;
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);

	}
	
	public function get_revise_mdcr()
	{

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order  = $this->input->post('order');
		$column = $this->input->post('columns');

		$result = $this->inbox_model->getMDCRReviseServerSide($start, $length, $search);

		$data = [];
		foreach ($result['data'] as $value) {
			$url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"]));
			$row = [];
			$row[] = $value['employee_id'];
			$row[] = decrypt($value['complete_name']);
			$row[] = "<a href='".$url."'>".$value['request_number']."</a>";
			$row['DT_RowClass'] = 'SearchMDCR';
			$data[] = $row;
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);

	}
	
	public function get_waitinglist_mdcr()
	{

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order  = $this->input->post('order');
		$column = $this->input->post('columns');

		$result = $this->inbox_model->getMDCRWaitingListServerSide($start, $length, $search);

		$data = [];
		foreach ($result['data'] as $value) {
			$url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"]));
			$row = [];
			$row[] = "<input type='checkbox' class='check22 checked_id_mdcr kind".$value['kind']."' name='id_request_mdcr[]' value='".$value['id']."' kind='".$value['kind']."'>";
			$row[] = $value['employee_id'];
			$row[] = decrypt($value['complete_name']);
			$row[] = decrypt($value['cost_center']);
			$row[] = "<a href='".$url."'>".$value['request_number']."</a>";
			$row['DT_RowClass'] = 'SearchMDCR';
			$data[] = $row;
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);

	}

	public function get_request_to_hr_mdcr()
	{

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order_column_index = $this->input->post('order')[0]['column'];
    	$order_column = $this->input->post('columns')[$order_column_index]['data'];
    	$order_dir = $this->input->post('order')[0]['dir'];

		$result = $this->inbox_model->getRequestMDCRServerSide($start, $length, $search, $order_column, $order_dir);

		$data = [];
		foreach ($result['data'] as $value) {
			$url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"]));
			$row = [];
			$row[] = $value['employee_id'];
			$row[] = decrypt($value['complete_name']);
			$row[] = "<a href='".$url."'>".$value['request_number']."</a>";
			$row['DT_RowClass'] = 'SearchMDCR';
			$data[] = $row;
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);

	}	


	//////////////////////////////End Penambahan action sent to AP Luffi 2025//////////////////////////////

	public function view_detail_trans($formType, $id)
	{
		$request_id = decode_url($id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
		$header = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
		$detail = $this->m_global->getRow('detail_table', 'form_type', array('code' => $formType));
		$data['header'] = $this->m_global->find($header, 'request_id', $request_id)->row_array();

		switch ($formType) {
			case 'MDCR':

				$additional = $this->m_global->getRow('additional_table', 'form_type', array('code' => $formType));
				$data['detail'] = $this->m_global->find($detail, 'request_id', $request_id)->result_array();
				$employee_id = $data['header']['employee_id'];
				$data['couple'] = $this->form_model->get_data_couple_employee($employee_id);
				
				$id_eg_prj = $data['header']['id_eg_prj'];
				$id_eg_pri = $data['header']['id_eg_pri'];
				$id_eg_pk  = $data['header']['id_eg_pk'];
				$request_created_at = $data['form_request']['created_at'];
				$data['approval_priority'] = $this->form_model->get_approval_priority($request_id, $this->email);
				$data['get_medical_item_year'] = $this->form_model->get_medical_item_year($request_id);
				$year_medical_item = $data['get_medical_item_year'] != null ? $data['get_medical_item_year'] : $request_created_at;
				$data['sum_penggantian_jalan'] = $this->form_model->get_sum_penggantian_jalan($request_id);
				$data['sum_penggantian_inap'] = $this->form_model->get_sum_penggantian_inap($request_id);
				$data['sum_penggantian_kacamata'] = $this->form_model->get_sum_penggantian_kacamata($request_id);
				$data['reimaning_pagu'] = $this->form_model->get_reimaning_pagu($year_medical_item, $employee_id, $id_eg_prj, $id_eg_pri, $id_eg_pk);
				$data['additional'] = $this->m_global->find($additional, 'request_id', $request_id)->result_array();
				break;

			default:
				break;
		}

		$data['userList'] = $this->form_model->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['employee_list'] = $this->form_model->getUserList("complete_name", "hris_employee", "is_active = 1 AND access_employee != 1 AND complete_name != '$this->emp_name'");
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'form/view_trans/' . $formType;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read_trans($table, $id)
	{
		$request_id = $id;
		switch ($table) {

			case 'ToR':

				$listToR = $this->form_model->getTypeOfRembursement($request_id);
				$checkRecord = $this->form_model->cek_record($id);

				if (!empty($listToR)) {
					$no = 1;
					foreach ($listToR as $key) {

						if (($key->additional == 'Diri Sendiri')) {
							$additional = $key->additional;
						} else {
							$additional = decrypt($key->additional);
						}
						if (($key->harga_kamar == 'NaN') || (empty($key->harga_kamar)) || ($key->harga_kamar == '') || ($key->harga_kamar == ' ') || ($key->harga_kamar == NULL)) {
							$harga_kamar = 0;
						} else {
							$harga_kamar = $key->harga_kamar;
						}
						$row   = array();
					
						$row[] =  $no;
						$row[] =  $key->tor_grandparent . ' - ' . $key->tor_parent . ' - ' . $key->tor_child;
						$row[] =  $key->jumlah_kuitansi;
						$row[] =  number_format($key->total_kuitansi);
						$row[] =  $key->tanggal_kuitansi;
						$row[] =  number_format($key->penggantian);
						$row[] =  $key->keterangan . ' - ' . ucwords(strtolower($additional));
						$row[] =  number_format($harga_kamar);
						$row[] =  $key->docter;
						$row[] =  $key->diagnosa;
						$no++;
						$data[] = $row;
					}
					$output = array('data' => $data);
				} else {
					$output = array('data' => new ArrayObject());
				}
				echo json_encode($output);
				break;


			default:
				break;
		}
	}

	private function generate_resignation_letter_pdf($request_id)
	{
		$resignation = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $request_id)->row_array();
		$form = $this->m_global->find('form_request', 'id', $request_id)->row_array();
		$employee = $this->form_model->get_data_employee($form['employee_id']);
		$golongan = decrypt($employee[0]->employee_group);
		$words = preg_split('/\s+/', trim($golongan));
		$gol = strtoupper(substr($words[count($words) - 1], 0, 1));
		$notice_period = $this->m_global->find('exit_clearance_notice_periods', 'grade', $gol)->row()->month;
		$working_period = (new DateTime(decrypt($employee[0]->join_date)))->diff(new DateTime($resignation['last_date']));
		$months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
		$resignation_timestamp = strtotime($resignation['resignation_date']);
		$today_timestamp = strtotime(date('Y-m-d'));
		$data = [
			'date' => date('d', $today_timestamp) . ' ' . $months[(int) date('n', $today_timestamp)] . ' ' . date('Y', $today_timestamp),
			'resignation_date' => date('d', $resignation_timestamp) . ' ' . $months[(int) date('n', $resignation_timestamp)] . ' ' . date('Y', $resignation_timestamp),
			'notice_period' => (int) $notice_period,
			'complete_name' => decrypt($employee[0]->complete_name),
			'position' => decrypt($employee[0]->position),
			'nik' => $employee[0]->nik,
			'division' => decrypt($employee[0]->division),
			'working_year' => (int) $working_period->y,
			'working_month' => (int) $working_period->m,
			'division_head' => decrypt($employee[0]->divhead_name),
		];
		$html = $this->load->view('form/print_out/print_req_resignation_letters', $data, true);
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->SetFont('times', '', 12);
		$pdf->AddPage('P', 'A4');
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Rect(0, 0, 210, 22, 'F');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', 'B', 18);
		$pdf->SetXY(45, 15);
		$pdf->Cell(120, 16, 'SURAT PENGUNDURAN DIRI', 0, 0, 'C');
		$pdf->SetFont('times', '', 12);
		$pdf->writeHTMLCell(160, 0, 25, 30, $html, 0, 1, false, true, 'L');
		$file_path = FCPATH . 'assets/documents/document_resignation/' . $employee[0]->nik . '/resignation_letter/';
		if (!is_dir($file_path)) {
			mkdir($file_path, 0777, true);
		}
		$pdf->Output($file_path . 'Surat_Pengunduran_Diri.pdf', 'F');
	}

}
