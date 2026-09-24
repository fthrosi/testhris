<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends Admin_Controller
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
		$this->load->model('m_request');
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

		$data['request'] = $this->m_approval->getMyRequest();
		$data['userList'] = $this->m_request->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['content'] = 'list/request_list';
		$this->templates->show('index', 'templates/index', $data);
	}

	public function create()
	{
		$data['formType'] = $this->m_request->getFormType();
		$data['userList'] = $this->m_request->getUserList("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		$data['content'] = 'list/request/create';
		$this->templates->show('index', 'templates/index', $data);
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
					$response = array('status' => 1, 'message' => 'New layer has been added.', 'request_status' => $request_status );
				} 

				header('Content-type: application/json');
				echo json_encode($response);
				break;

			case 'save-change-layer':

				$response = array('status' => 0, 'message' => 'Failed while changing layer.');
				$id = $this->input->post('req_id_change_layer');
				$approval_id = $this->input->post('app_id_change_layer');
				$email = $this->input->post('email_user');

				if ($email === 'handra@ibstower.com' || $email === 'farida@ibstower.com') {
					$alias = 'Commitee';
				} else {
					$alias = str_replace('@ibstower.com', '', $email);
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
					$response = array('status' => 1, 'message' => 'Selected layer has been removed.', 'request_status' => $request_status );
				}

				header('Content-type: application/json');
				echo json_encode($response);
				break;
			
			default:
				break;
		}
		
	}

	public function delete()
	{
		$responses = array('status' => 0, 'message' => 'Failed while deleting your request. Please try again.');
		$id = $this->input->post('id');

		if ($this->db->delete('form_request', array('id' => $id))) {

			if ($this->db->delete('form_approval', array('request_id' => $id))) {
				$this->logs('delete', $id);
				$responses = array('status' => 1, 'message' => 'Deleted successfully.');
			} else {
				$this->logs('system', $id, 'Failed while deleting data approval');
			}

		} else {
			$this->logs('system', $id, 'Failed while deleting data request');
		}

		echo json_encode($responses);
	}

	public function saveForm()
	{
		$response = array('status' => 0, 'message' => 'Create new request failed, please try again.');
		$requestNumber = $this->getRequestNumber($this->input->post('formType'));
		$requestId = $this->m_request->saveForm($requestNumber);

		// print_r($requestNumber);die;

		if ($requestId) {

			## Form Approval Upload 
			if ($this->docUpload($requestId, $requestNumber)) {

				## Multiple Supporting Document Upload
				if ($this->multipleDocUpload($requestNumber)) {

					## Insert Approval Progress
					if ($this->saveApproval($requestId)) {

						$email = $this->input->post('email');
						$first_layer = $email[0];
						// $this->sendEmail('need_response', $requestId, $first_layer);

						$this->logs('create', $requestId);

						$response['status'] = 1;
						$response['message'] = 'Request created successfully.';
					} else {
						$this->db->delete('form_request', array('id' => $requestId));
						$this->logs('system', $requestId, 'Failed when saving approval layer');
						$response['status'] = 0;
						$response['message'] = 'Please Add Approval Layer';
					}
				} else {
					$this->db->delete('form_request', array('id' => $requestId));
					$this->logs('system', $requestId, 'Failed when uploading supporting files');
					$response['status'] = 0;
					$response['message'] = 'Supporting Files Upload: Failed when uploading supporting files';
				}
			} else {
				$this->db->delete('form_request', array('id' => $requestId));
				$this->logs('system', $requestId, 'Failed when uploading Approval Form Scanned');
				$response['status'] = 0;
				$response['message'] = 'Approval Form Scanned: Failed when uploading Approval Form Scanned.';
			}
		} else {
			$this->logs('system', $requestId, 'Failed when saving data request form');
			$response['status'] = 0;
			$response['message'] = 'Failed when saving data request form .';
		}

		echo json_encode($response);
	}

	public function saveApproval($requestId)
	{
		$transok = false;
		$layer = $this->input->post('email');
		if (!empty($layer)) {
			return $this->m_request->saveApproval($layer, $requestId);
		} else {
			return false;
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
			'approval_notes' => $this->input->post('requestor_notes'), 
		);
		
		if ($this->db->insert('logs', $notes)) {
			$transok = 1;
		} 
		
		echo json_encode($transok);
	}

	public function docUpload($requestId, $requestNumber)
	{
		$uploaded = array();
		$transok = false;

		foreach ($_FILES as $doctype => $form) {

			if ($doctype != 'filesDropZone' && $form['name'] != '') {

				$path = './upload/' . $requestNumber . '/';
				$type  = explode('.', $form['name']);
				$types = strtolower($type[count($type) - 1]);
				$filename = $requestNumber . '_' . uniqid() . '.' . $types;

				// start Upload
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'pdf';
				$config['file_name'] = $filename;
				$config['encrypt_name'] = FALSE;
				$config['overwrite'] = FALSE;
				$config['max_size'] = 20000;
				// $this->upload->initialize($config);
				$this->load->library('upload', $config);

				if (!is_dir('upload/' . $requestNumber . '/')) {
					mkdir('./upload/' . $requestNumber . '/', 0777, TRUE);
				}

				if (!is_dir('upload/' . $requestNumber . '/marked/')) {
					mkdir('./upload/' . $requestNumber . '/marked/', 0777, TRUE);
				}

				if (!is_dir('upload/' . $requestNumber . '/convert/')) {
					mkdir('./upload/' . $requestNumber . '/convert/', 0777, TRUE);
				}

				if (!is_dir('upload/' . $requestNumber . '/supporting_files/')) {
					mkdir('./upload/' . $requestNumber . '/supporting_files/', 0777, TRUE);
				}

				if ($this->upload->do_upload($doctype)) {

					$this->db->where('id', $requestId);
					if ($this->db->update('form_request', array($doctype => $filename))) {
						$transok = true;
					}

					// $pdfVersion = "1.4";
					// $newFile = './upload/' . $requestNumber . '/convert/' . $filename;
					// $currentFile = './upload/' . $requestNumber . '/' . $filename;

					// $gsCmd = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=$pdfVersion -dNOPAUSE -dBATCH -sOutputFile=$newFile $currentFile";

					// if (exec($gsCmd)) {
					// 	$uploaded[] = $this->upload->data();
					// 	$this->db->where('id', $requestId)->update('form_request', array($doctype => $filename));
					// 	$transok = true;

					// } else {
					// 	$transok = false;
					// }

				} else {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
					$transok = false;
				}
			}
		}

		return $transok;
	}

	public function multipleDocUpload($requestNumber)
	{
		$transok = true;
		if (isset($_FILES['filesDropZone'])) {

			$count = count($_FILES['filesDropZone']['name']);

			for ($i = 0; $i < $count; $i++) {

				if (!empty($_FILES['filesDropZone']['name'][$i])) {

					$path =  getcwd() . '/upload/' . $requestNumber . '/supporting_files/';
					$fileName = $_FILES['filesDropZone']['name'][$i];
					$new_filename = preg_replace("/[^A-Z0-9._-]/i", "_", $fileName);
					$tempFile = $_FILES['filesDropZone']['tmp_name'][$i];
					$targetFile = $path . $new_filename;

					if (!move_uploaded_file($tempFile, $targetFile)) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						$transok = false;
					}
				}
			}
		}

		return $transok;
	}

	public function deleteSupportingFiles()
	{
		$transok = false;
		$id = $this->input->post('id');
		$filenames = $this->input->post('filename');

		$requestNumber = $this->m_approval->find('id', $id, 'form_request')->row_array()['requestNumber'];
		$filepath = getcwd() . '/upload/' . $requestNumber . '/supporting_files/' . $filenames;

		if (file_exists($filepath)) {
	        unlink($filepath);
	        $transok = true;
	    } else {
	        $transok = false;
	    }

		if ($transok) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function resubmit($id)
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh the page and try again.');
		$type = $this->m_approval->getOneById('is_status', 'form_request', array('id' => $id));

		$this->db->where('id', $id);
		$update_request = $this->db->update('form_request', array('is_status' => 1));

		if ($update_request) {

			switch ($type) {

				case '2':

					$approval_id = $this->db->get_where('form_approval', array('request_id' => $id, 'approval_status' => 'Revised'))->row_array()['id'];
					$layer = $this->db->get_where('form_approval', array('id' => $approval_id))->row_array()['approval_email'];

					if ($this->db->where('id', $approval_id)->update('form_approval', array('approval_status' => 'In Progress'))) {
						$this->sendEmail('need_response', $id, $layer);
						$this->logs('submit_revise', $id);
						$output = array('status' => 1, 'message' => status_color(1));
					} else {
						$this->logs('system', $id, 'Failed while updating form approval');
						$output = array('status' => 0, 'message' => 'Failed when updating approval layer. Please call the Software Engineer.');
					}
					break;

				case '0':

					$approval_id = $this->db->get_where('form_approval', array('request_id' => $id, 'approval_status' => 'Canceled'))->row_array()['id'];
					$layer = $this->db->get_where('form_approval', array('id' => $approval_id))->row_array()['approval_email'];

					if ($this->db->where('id', $approval_id)->update('form_approval', array('approval_status' => 'In Progress'))) {
						$this->sendEmail('need_response', $id, $layer);
						$this->logs('submit_pullback', $id);
						$output = array('status' => 1, 'message' => status_color(1));
					} else {
						$this->logs('system', $id, 'Failed while updating form approval');
						$output = array('status' => 0, 'message' => 'Failed when updating approval layer. Please call the Software Engineer.');
					}
					break;

				default:
					break;
			}
		}

		echo json_encode($output);
	}

	public function pullBack()
	{
		$responses = array('status' => 0, 'message' => 'Failed pulling back your request. Please try again.');
		$id = $this->input->post('id');
		$app_id = $this->m_approval->getOneById('id', 'form_approval', array('request_id' => $id, 'approval_status' => 'In Progress'));

		$this->db->where('id', $id);
		if ($this->db->update('form_request', array('is_status' => 0))) {
			if ($this->db->where('id', $app_id)->update('form_approval', array('approval_status' => 'Canceled', 'approval_note' => 'Canceled by requestor', 'updated_at' => $this->date, 'updated_by' => $this->email))) {
				$this->logs('pullback', $id);
				$responses = array('status' => 1, 'message' => status_color(0));
			}
		}

		echo json_encode($responses);
	}

	public function getTemplateForm()
	{
		$code = $this->input->post('code');
		$files = $this->db->get_where('form_type', array('code' => $code))->row_array()['files'];
		echo json_encode($files);
	}

	public function getFormCategory()
	{
		$formType = $this->input->post('formType');
		$category = $this->db->get_where('form_type', array('code' => $formType))->row_array()['category'];
		echo json_encode($category);
	}

	public function getUserList()
	{
		$userList = $this->m_request->getAll("user_email", "users", "is_active = 1 AND user_email != '$this->email'");
		echo json_encode($userList);
	}

	private function getRequestNumber($formType)
	{
		$this->db->select_max('id');
		$eid = $this->db->get('form_request')->row_array();
		$reqnum = $eid['id'] + 1;
		$requestNumber = 'EAPP_' . $formType . '_' . str_pad($reqnum, 5, 0, STR_PAD_LEFT);
		return $requestNumber;
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
			case 'pullback':
				$log['approval_response'] = 'Canceled';
				$this->db->insert('logs', $log);
				break;

			case 'create':
				$log['approval_response'] = 'Submit Request';
				$this->db->insert('logs', $log);
				break;

			case 'delete':
				$log['approval_response'] = 'Deleted';
				$log['approval_notes'] = 'Request has been deleted';
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

}
