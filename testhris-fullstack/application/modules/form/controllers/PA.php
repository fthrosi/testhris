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

class PA extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
		$this->load->library('email');
		$this->load->library('enc');

		$this->email = $this->session->userdata('user_email');
		$this->emp_id = $this->session->userdata('employee_id');
		$this->emp_nik = $this->session->userdata('nik');
		$this->emp_name = $this->session->userdata('employee_name');
		$this->emp_grade = $this->session->userdata('employee_group');

		$this->load->helper('general');
		$this->load->model('form_model');
		$this->load->model('inbox/inbox_model');
		$this->load->model('home/home_model');
		$this->load->model('m_global');
		$this->load->model('services/m_services');

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

	public function get_qa(){
		$id 	= decode_url($_POST['id']);
		$data 	= $this->form_model->get_qa($id);

		echo json_encode($data);
	}
	
	public function post_qa(){
		$id 			= $_POST['id'];
		$plan_score 	= $_POST['plan_score'];
		$id_req 		= $_POST['id_req'];
		$data 	= $this->form_model->post_qa($id, $plan_score, $id_req);

		echo json_encode($data);
	}

	public function post_content_pa(){
		$content 		= $_POST['content'];
		$type 		= $_POST['type'];
		$id_req 		= $_POST['id_req'];
		$data 	= $this->form_model->post_content_pa($content, $type, $id_req);

		echo json_encode($data);
	}

	public function save_documents_evidence()
	{

		$request_number = $_POST['request_number'];

		$cek = $this->form_model->cek_documents_evidence_table($request_number);
		
		if (empty($cek)) {
			$config = [
				'upload_path' => './assets/documents/documents_pa/',
				'allowed_types' => 'jpg|jpeg|ppt|pptx|zip|rar|7z|pdf|doc|docx',
				'max_size' => 10000000000, 'max_width' => 10000000000,
				'max_height' => 10000000000
			];
			// dumper($_FILES['FileDocumentsEvidence']);
			if (($_FILES['FileDocumentsEvidence']['error'] == 4)) {
				$result = 'No file was uploaded'; //No file was uploaded
				echo json_encode($result);
			} else if (($_FILES['FileDocumentsEvidence']['error'] == 7)) {
				$result = 'Failed to write file to disk'; //Failed to write file to disk
				echo json_encode($result);
			} else if (($_FILES['FileDocumentsEvidence']['error'] == 1) || ($_FILES['FileDocumentsEvidence']['error'] == 2)) {
				$result = 'Upload Max File Size 10Mb or Format Not Support'; //Upload Max File Size 10Mb or Format Not Support
				echo json_encode($result);
			}

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('FileDocumentsEvidence')) //jika gagal upload
			{
				// dumper($this->upload->display_errors());
				$error = array('error' => $this->upload->display_errors()); //tampilkan error
				echo json_encode($this->upload->display_errors());

			} else {

				$file = $this->upload->data();
				$data = [
					'documents' => $file['file_name'],
					'request_number' => $request_number
				];
				$result = $this->form_model->save_documents_evidence($data,'n');
				if ($result == '1') {
					echo json_encode($result);
				} else {
					echo json_encode($result);
				}
			}
		} else {

			$config = [
				'upload_path' => './assets/documents/documents_pa/',
				'allowed_types' => 'jpg|jpeg|ppt|pptx|zip|rar|7z|pdf|doc|docx',
				'max_size' => 10000000000, 'max_width' => 10000000000,
				'max_height' => 10000000000
			];
	
			if (($_FILES['FileDocumentsEvidence']['error'] == 4)) {
				$result = 'No file was uploaded'; //No file was uploaded
				echo json_encode($result);
			} else if (($_FILES['FileDocumentsEvidence']['error'] == 7)) {
				$result = 'Failed to write file to disk'; //Failed to write file to disk
				echo json_encode($result);
			} else if (($_FILES['FileDocumentsEvidence']['error'] == 1) || ($_FILES['FileDocumentsEvidence']['error'] == 2)) {
				$result = 'Upload Max File Size 10Mb or Format Not Support'; //Upload Max File Size 10Mb or Format Not Support
				echo json_encode($result);
			}
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('FileDocumentsEvidence')) //jika gagal upload
			{
				// dumper($this->upload->display_errors());
				$error = array('error' => $this->upload->display_errors()); //tampilkan error
				echo json_encode($this->upload->display_errors());
	
			} else {
	
				$file = $this->upload->data();
				$data = [
					'documents' => $file['file_name'],
					'request_number' => $request_number,
					'updated_at' => $this->date,
				];
	
				$result = $this->form_model->save_documents_evidence($data,'u');
				if ($result == '1') {
					echo json_encode($result);
				} else {
					echo json_encode($result);
				}
			}

		}

	}
}
