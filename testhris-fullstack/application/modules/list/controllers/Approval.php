<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('enc');
		// $this->enc->check_session();

		// if (!$this->enc->access_user()) {
		// 	$x = base_url();
		// 	redirect($x);
		// 	exit();

		// } else {
		// 	$this->email = $this->session->userdata('user_email');
		// 	$this->phone = $this->session->userdata('phone_number');
		// }
		
		$this->load->helper('general');
		$this->load->model('m_approval');
		$this->load->model('m_global');
		$this->email = $this->session->userdata('user_email');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function index()
	{
		// if (!$this->enc->access_user()) {
		// 	$x = base_url();
		// 	redirect($x);
		// 	exit();
		// }

		$data['approval'] = $this->m_approval->getApprovalList($this->email);
		$data['userList'] = $this->m_approval->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['content']  = 'list/approval_list';
		$this->templates->show('index', 'templates/index', $data);
	}

	public function viewRequest()
	{
		$requestId = $this->input->post('id');
		$detail_request = $this->m_approval->find_select("id, requestNumber, formType, formPurpose, formNotes, approvalFormScanned, created_by, created_at, is_status", array('id' => $requestId), 'form_request')->row_array();
		$detail_approval = $this->m_approval->find_select("id, approval_email, approval_priority, approval_status, is_read, updated_at, updated_by", array('request_id' => $requestId, 'approval_email' => $this->email), 'form_approval')->row_array();
		$progress = $this->m_approval->find_select("id, approval_alias, approval_email, approval_priority, approval_note, approval_status, updated_at, updated_by", array('request_id' => $requestId), 'form_approval')->result_array();
		$review = $this->m_approval->find_select("id, reviewer, reviewer_notes, review_done, created_by", array('request_id' => $requestId, 'created_by' => $this->email), 'form_reviewer')->result_array();
		$review_id = $this->db->get_where('form_reviewer', array('request_id' => $requestId, 'is_status' => '1'))->row_array()['id'];
		$notes = $this->m_approval->getApprovalNotes($requestId)->result_array();
		$approval_status = $detail_approval['approval_status'];

		$status = status_color($detail_request['is_status']);
		$is_read = $this->m_approval->find('id', $detail_approval['id'], 'form_approval')->row_array()['is_read'];

		if ($approval_status == 'In Progress' || $approval_status == 'Hold') {
			$approval_id = $detail_approval['id'];
		} else {
			$approval_id = '0';
		}

		if ($is_read == 0) {
			$this->db->where('id', $approval_id);
			$this->db->update('form_approval', array('is_read' => 1));
			$this->logs('is_read', $requestId);
		}

		$dir =  './upload/' . $detail_request['requestNumber'] . '/supporting_files/';
		$file = $this->doScan($dir);

		header('Content-type: application/json');
		echo json_encode(array(
			"request" => $detail_request,
			"approval_id" => $approval_id,
			"review_id" => $review_id,
			"review" => $review,
			"notes" => $notes,
			"progress" => $progress,
			"read" => $is_read,
			"status" => $status,
			"items" => $file
		));
	}

	public function responseRequest()
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		$request_id = $this->input->post('id');
		$approval_id = $this->input->post('approval_id');
		$requestor = $this->input->post('requestor');
		$response = $this->input->post('resp');
		$notes = $this->input->post('note');

		$data_response = array(
			'approval_status' => $response, 
			'approval_note' => $notes, 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		switch ($response) {
			case 'Revised':

				$this->db->where('id', $approval_id);
				if ($this->db->update('form_approval', $data_response)) {

					$progress = $this->m_approval->find_select("approval_alias, approval_priority, approval_status", array('request_id' => $request_id), 'form_approval')->result_array();

					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

						// $this->sendEmail('revise', $request_id, $requestor);
						$this->logs('revise', $request_id, $notes);
						$request_status = $this->m_approval->find('id', $request_id, 'form_request')->row_array()['is_status'];
						$output = array('status' => 1, 'message' => status_color(2), 'request_status' => $request_status, 'progress' => $progress);
					}
				}

				break;

			case 'Hold':

				$this->db->where('id', $approval_id);
				if ($this->db->update('form_approval', $data_response)) {

					$progress = $this->m_approval->find_select("approval_alias, approval_priority, approval_status", array('request_id' => $request_id), 'form_approval')->result_array();

					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 5, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

						// $this->sendEmail('hold', $request_id, $requestor);
						$this->logs('hold', $request_id, $notes);
						$request_status = $this->m_approval->find('id', $request_id, 'form_request')->row_array()['is_status'];
						$output = array('status' => 1, 'message' => status_color(5), 'request_status' =>
						$request_status, 'progress' => $progress);
					}
				}

				break;

			case 'SendToReviewer':

				$reviewer = $this->input->post('emailuser');
				$need_review = array(
					'approval_status' => 'Review',
					'approval_note' => 'On review by ' . $reviewer,
					'updated_at' => $this->date,
					'updated_by' => $this->email
				);

				if (!empty($request_id) && !empty($approval_id) && !empty($reviewer)) {
					$check = $this->db->get_where('form_reviewer', array('approval_id' => $approval_id, 'is_status' => 1, 'request_id' => $request_id));

					if ($check->num_rows() == 0) {

						if ($this->db->insert('form_reviewer', array('approval_id' => $approval_id, 'is_status' => 1, 'reviewer' => $reviewer, 'review_date' => $this->date, 'request_id' => $request_id, 'created_by' => $this->email, 'created_at' => $this->date))) {

							$this->db->where('id', $request_id);
							if ($this->db->update('form_request', array('is_status' => 6, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

								$this->db->where('id', $approval_id);
								if ($this->db->update('form_approval', $need_review)) {

									// $this->sendEmail('send_to_reviewer', $request_id, $reviewer);
									$msg = 'On review by ' . $reviewer;
									$this->logs('send_to_reviewer', $request_id, $msg);
									$output = array('status' => 1, 'message' => status_color(6));
								}

							}

						}

					}

				}

				break;
			
			default:
				break;
		}

		echo json_encode($output);
	}

	public function logs($type, $id, $message = '')
	{
		$log['request_id'] = $id;
		$log['created_by'] = ($type == 'system') ? 'system' : $this->email;
		$log['created_at'] = $this->date;

		switch ($type) {
			case 'system':
				$log['approval_response'] = '-';
				$log['approval_notes'] = $message;
				$this->db->insert('logs', $log);
				break;

			case 'is_read':
				$log['approval_response'] = 'View request';
				$this->db->insert('logs', $log);
				break;
			case 'revise':
				$log['approval_response'] = 'Revised';
				$log['approval_notes'] = $message;
				$this->db->insert('logs', $log);
				break;

			case 'hold':
				$log['approval_response'] = 'Hold';
				$log['approval_notes'] = $message;
				$this->db->insert('logs', $log);
				break;

			case 'send_to_reviewer':
				$log['approval_response'] = 'Review';
				$log['approval_notes'] = $message;
				$this->db->insert('logs', $log);
				break;
			
			default:
				break;
		}
	}

	public function sendEmail($type, $requestId, $email_to)
	{
		$purpose = $this->m_global->find('form_request', 'id', $requestId)->row_array()['formPurpose'];
		$data['detail'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		$data['email'] = $email_to;

		if ($type == 'need_response') {
			$html = $this->load->view('services/email/need_response', $data, TRUE);
		} elseif ($type == 'need_review') {
			$html = $this->load->view('services/email/need_review', $data, TRUE);
		} elseif ($type == 'review_done') {
			$html = $this->load->view('services/email/review_done', $data, TRUE);
		} elseif ($type == 'revise') {
			$html = $this->load->view('services/email/revise', $data, TRUE);
		} elseif ($type == 'hold') {
			$html = $this->load->view('services/email/hold', $data, TRUE);
		} elseif ($type == 'approved') {
			$html = $this->load->view('services/email/approved', $data, TRUE);
		} elseif ($type == 'reject') {
			$html = $this->load->view('services/email/reject', $data, TRUE);
		} elseif ($type == 'reactive') {
			$html = $this->load->view('services/email/reactive', $data, TRUE);
		}

		$url = 'https://api.ibstower.com/email_service';
		$params = array(
			'app_name'      => 'eApproval',
			'ip_address'    => $_SERVER['SERVER_ADDR'],
			'email_to'      => $email_to,
			'email_subject' => $purpose,
			'email_content' => $html,
			'is_status' 	=> 0,
			'created_at' 	=> $this->date,
			'created_by' 	=> $this->email
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$result = curl_exec($ch);
		if (curl_errno($ch) !== 0) {
			print_r('Oops! cURL error when connecting to ' . $url . ': ' . curl_error($ch));
		}

		curl_close($ch);
	}

	public function scan()
	{
		$id = $this->input->post('id');
		$requestNumber = $this->m_approval->find('id', $id, 'form_request')->row_array()['requestNumber'];
		$status = $this->m_approval->find('id', $id, 'form_request')->row_array()['is_status'];

		$dir =  './upload/' . $requestNumber . '/supporting_files/';
		$path =  '/upload/' . $requestNumber . '/supporting_files/';
		$response = $this->doScan($dir);

		header('Content-type: application/json');
		echo json_encode(array(
			"id" => $id,
			"flag" => $status,
			"items" => $response
		));
	}

	private function doScan($dir)
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
						"size" => filesize($dir . '/' . $f) // Gets the size of this file
					);
				}
			}
		}

		return $files;
	}

}
