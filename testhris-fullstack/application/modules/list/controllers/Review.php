<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('enc');
		$this->enc->check_session();

		if (!$this->enc->access_user()) {
			$x = base_url();
			redirect($x);
			exit();
		}
		
		$this->load->helper('general');
		$this->load->model('m_approval');
		$this->load->model('m_global');

		$this->email = $this->session->userdata('user_email');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function index()
	{
		if (!$this->enc->access_user()) {
			$x = base_url();
			redirect($x);
			exit();
		}

		$data['review']   = $this->m_approval->getReviewList();
		$data['userList'] = $this->m_approval->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['content']  = 'list/review_list';
		$this->templates->show('index', 'templates/index', $data);
	}

	public function submit()
	{
		$output = array('status' => 0, 'message' => 'Add review failed, please try again.');
		$request_id = $this->input->post('id');
		$review_id = $this->input->post('review_id');
		$review_notes = $this->input->post('review_notes');
		$approver = $this->m_approval->find_select("created_by", array('id' => $review_id), 'form_reviewer')->row_array();

		$approval_id = $this->db->get_where('form_approval', array('approval_status' => 'Review'))->row_array()['id'];

		if ( !empty($request_id) && !empty($review_notes)) {

			if ($this->db->where('id', $review_id)->update('form_reviewer', array('reviewer_notes' => $review_notes, 'review_done' => $this->date, 'is_status' => 2))) {

				if ($this->db->where('id', $request_id)->update('form_request', array('is_status' => 1))) {

					if ($this->db->where('id', $approval_id)->update('form_approval', array('approval_status' => 'In Progress', 'approval_note' => ''))) {
						// $this->sendEmail($request_id, $approver);
						$this->logs('submit_review', $request_id, $review_notes);
						$output = array('status' => 1, 'message' => status_color(1));
					} else {
						$this->logs('system', $request_id, 'Failed while updating form approval.');
						$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
					}

				} else {
					$this->logs('system', $request_id, 'Failed while updating form request.');
					$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
				}
				
			} else {
				$this->logs('system', $request_id, 'Failed while updating form reviewer.');
				$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
			}
			
		} else {
			$this->logs('system', $request_id, 'Aborted. because request id and review notes are empty.');
			$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		}

		echo json_encode($output);
	}

	public function upload($flag = '')
	{
		switch ($flag) {
			case 'show_modal_upload':

				$id = $this->input->post('id');
				$request_number = $this->input->post('req_number');

				header('Content-type: application/json');
				echo json_encode(array("request_id" => $id,"request_number" => $request_number,));
				break;

			case 'save_upload':

				$id = $this->input->post('modalrequest_id');
				$requestNumber = $this->input->post('modalrequest_number');
				$response = array('status' => 0, 'message' => 'Failed while uploading your files. Please try again.');

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
									$uploadStatus = 1;
								} else {
									$uploadStatus = 0;
								}
							} else {
								$uploadStatus = 0;
								$response = array('status' => 0, 'message' => 'Sorry, please check your file format again.');
							}
						}
					}

					if ($uploadStatus == 1) {
						$this->logs('system', $id, 'Upload review files successfully.');
						$response = array('status' => 1, 'message' => 'Upload review files successfully.');
					} else {
						$this->logs('system', $id, 'There was an error uploading supporting files.');
					}
				}

				header('Content-type: application/json');
				echo json_encode($response);
				break;
			
			default:
				break;
		}
		
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

			case 'submit_review':
				$log['approval_response'] = 'Submit Review';
				$log['approval_notes'] = $message;
				$this->db->insert('logs', $log);
				break;
			case 'upload':
				$log['approval_response'] = 'Upload Review Files';
				$log['approval_notes'] = $message;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

	public function sendEmail($requestId, $email_to)
	{
		$purpose = $this->m_global->find('form_request', 'id', $requestId)->row_array()['formPurpose'];
		$data['detail'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		$data['email'] = $email_to;

		$html = $this->load->view('services/email/review_done', $data, TRUE);

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

}
