<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authen extends Admin_Controller
{
	// private $method = 'wa';
	private $method = 'sms';
	// private $method = 'wa-sms';
	// private $method = 'sms-wa';

	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->helper('general');
		$this->load->helper('ebast');
		$this->load->model('m_services');
		$this->load->model('list/m_approval');
		$this->load->model('list/m_ebast');
		$this->load->model('m_global');
		$this->email = $this->session->userdata('user_email');
		$this->phone = $this->session->userdata('phone_number');
		$this->date = date('Y-m-d H:i:s');
		$this->ilink = $this->load->database('db_ilink', TRUE);
	}

	## eApproval
	public function verify()
	{
		$phone = $this->phone;
		$id = $this->input->post('id');
		$request_number = $this->input->post('request_number');

		if ($id == 'undefined') {
			echo 0;
		}

		$check = $this->m_services->check_otp($this->email, $id, $phone, $request_number)->num_rows();
		if ($check === 0) {
			$this->otp('send', $id, $request_number, $this->method);
			exit;
		} else {
			$this->otp('resend', $id, $request_number, $this->method);
		}
	}

	## E-BAST
	public function verify_ebast()
	{
		$phone = $this->phone;
		$id = $this->input->post('id');
		$request_number = $this->input->post('request_number');
		$check = $this->m_services->check_otp($this->email, $id, $phone, $request_number)->num_rows();

		if ($id != '') {

			if ($check == 0) {
				$this->otp('send', $id, $request_number, 'ebast');
			} else {
				$this->otp('resend', $id, $request_number, 'ebast');
			}

		} else {
			echo 0;
		}
	}

	## Send and Resend OTP
	public function otp($type, $id, $request_number, $method)
	{
		$transok = 0;
		$username = "";
		$password = "";
		// $password = "testing-switch";

		$phone = $this->phone;
		$otp_code = mt_rand(100000, 999999);
		$message = "$otp_code is your authentication code for request number: [ $request_number ].";
		$message_ebast = "$otp_code is your E-BAST code for request number: [ $request_number ].";

		switch ($method) {

			case 'wa':

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendwa/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'text' => $message,
						'GSM' => $phone,
						'output' => 'json'
					)
				));

				$resp = curl_exec($curl);
				$res = (array) json_decode($resp, true);
				$wa_status = $res['results'][0]['status'];

				if ($wa_status == '0') {

					if ($type == 'send') {

						$send = array(
							'user_email' 		=> $this->email,
							'phone_number' 		=> $phone,
							'otp_code' 			=> $otp_code,
							'authentication' 	=> 0,
							'activity_name'		=> 'Send OTP via WA',
							'last_sent'			=> $this->date,
							'trans_id'			=> $id,
							'trans_code'		=> $request_number,
							'messages'			=> $message
						);

						if ($this->db->insert('service_auth', $send)) {
							$logs_msg = 'Resend OTP via WA successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}
						
					} else {

						$this->db->where(array(
							'user_email' => $this->email,
							'phone_number' => $phone,
							'trans_code' => $request_number,
							'authentication' => 0,
							'trans_id' => $id
						));

						$resend = array(
							'otp_code' => $otp_code,
							'messages' => $message,
							'activity_name' => 'Resend OTP via WA',
							'last_sent' => $this->date
						);

						if ($this->db->update('service_auth', $resend)) {
							$logs_msg = 'Resend OTP via WA successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}
					}
					
				}

				curl_close($curl);
				echo json_encode($transok);
				break;

			case 'sms':

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'SMSText' => $message,
						'GSM' => $phone,
						'otp' => 'Y',
						'output' => 'json'
					)
				));

				$resp = curl_exec($curl);
				$res = (array) json_decode($resp, true);
				$status = $res['results'][0]['status'];

				if ($status == '0') {

					if ($type == 'send') {

						$send = array(
							'user_email' 		=> $this->email,
							'phone_number' 		=> $phone,
							'otp_code' 			=> $otp_code,
							'authentication' 	=> 0,
							'activity_name'		=> 'OTP via SMS',
							'last_sent'			=> $this->date,
							'trans_id'			=> $id,
							'trans_code'		=> $request_number,
							'messages'			=> $message
						);

						if ($this->db->insert('service_auth', $send)) {
							$logs_msg = 'Send OTP via SMS successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}

					} else {

						$this->db->where(array(
							'user_email' => $this->email,
							'phone_number' => $phone,
							'trans_code' => $request_number,
							'authentication' => 0,
							'trans_id' => $id
						));

						$resend = array(
							'otp_code' => $otp_code,
							'messages' => $message,
							'activity_name' => 'Resend OTP via SMS',
							'last_sent' => $this->date
						);

						if ($this->db->update('service_auth', $resend)) {
							$logs_msg = 'Resend OTP via SMS successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}
					}
					
				}

				curl_close($curl);
				echo json_encode($transok);
				break;

			case 'wa-sms':

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendwa/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'text' => $message,
						'GSM' => $phone,
						'output' => 'json'
					)
				));

				$resp = curl_exec($curl);
				$res = (array) json_decode($resp, true);
				$wa_status = $res['results'][0]['status'];
				curl_close($curl);

				if ($wa_status == '0') {
					
					if ($type == 'send') {

						$send = array(
							'user_email' 		=> $this->email,
							'phone_number' 		=> $phone,
							'otp_code' 			=> $otp_code,
							'authentication' 	=> 0,
							'activity_name'		=> 'Send OTP via WA',
							'last_sent'			=> $this->date,
							'trans_id'			=> $id,
							'trans_code'		=> $request_number,
							'messages'			=> $message
						);

						if ($this->db->insert('service_auth', $send)) {
							$logs_msg = 'Send OTP via WA successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}

					} else {

						$resend = array(
							'otp_code' => $otp_code, 
							'messages' => $message, 
							'activity_name' => 'Resend OTP via WA', 
							'last_sent' => $this->date);

						$this->db->where(array('user_email' => $this->email, 'phone_number' => $phone, 'trans_code' => $request_number, 'authentication' => 0, 'trans_id' => $id));
						if ($this->db->update('service_auth', $resend)) {
							$logs_msg = 'Resend OTP via WA successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}
					}
					
				} else {

					$this->logs('system', $id, 'Auto Switch to SMS. Reason: ' . $wa_status . ', Method: [' . $method . ']');

					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => array(
							'username' => $username,
							'password' => $password,
							'SMSText' => $message,
							'GSM' => $phone,
							'otp' => 'Y',
							'output' => 'json'
						)
					));

					$resp_sms = curl_exec($curl);
					$result = (array) json_decode($resp_sms, true);
					$sms_status = $result['results'][0]['status'];
					curl_close($curl);

					if ($sms_status == '0') {
						
						if ($type == 'send') {

							$send = array(
								'user_email' 		=> $this->email,
								'phone_number' 		=> $phone,
								'otp_code' 			=> $otp_code,
								'authentication' 	=> 0,
								'activity_name'		=> '[Auto Switch] Send OTP via SMS',
								'last_sent'			=> $this->date,
								'trans_id'			=> $id,
								'trans_code'		=> $request_number,
								'messages'			=> $message
							);

							if ($this->db->insert('service_auth', $send)) {
								$logs_msg = 'Send OTP via SMS successfully';
								$this->logs('system', $id, $logs_msg);
								$transok = 1;
							}

						} else {
							
							$resend = array(
								'otp_code' => $otp_code, 
								'messages' => $message, 
								'activity_name' => '[Auto Switch] Resend OTP via SMS', 
								'last_sent' => $this->date);

							$this->db->where(array('user_email' => $this->email, 'phone_number' => $phone, 'trans_code' => $request_number, 'authentication' => 0, 'trans_id' => $id));
							if ($this->db->update('service_auth', $resend)) {
								$logs_msg = 'Resend OTP via SMS successfully';
								$this->logs('system', $id, $logs_msg);
								$transok = 1;
							}
						}

					} else {
						$this->logs('system', $id, 'SMS Failed. Reason: ' . $sms_status . ', Method: [' . $method . ']');
					}

				}
				
				echo json_encode($transok);
				break;

			case 'sms-wa':

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'SMSText' => $message,
						'GSM' => $phone,
						'otp' => 'Y',
						'output' => 'json'
					)
				));

				$resp_sms = curl_exec($curl);
				$result = (array) json_decode($resp_sms, true);
				$sms_status = $result['results'][0]['status'];
				curl_close($curl);

				if ($sms_status == '0') {

					if ($type == 'send') {

						$send = array(
							'user_email' 		=> $this->email,
							'phone_number' 		=> $phone,
							'otp_code' 			=> $otp_code,
							'authentication' 	=> 0,
							'activity_name'		=> 'Send OTP via SMS',
							'last_sent'			=> $this->date,
							'trans_id'			=> $id,
							'trans_code'		=> $request_number,
							'messages'			=> $message);

						if ($this->db->insert('service_auth', $send)) {
							$logs_msg = 'Send OTP via SMS successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}

					} else {
						
						$resend = array(
							'otp_code' => $otp_code, 
							'messages' => $message, 
							'activity_name' => 'Resend OTP via SMS', 
							'last_sent' => $this->date);
						
						$this->db->where(array('user_email' => $this->email, 'phone_number' => $phone, 'trans_code' => $request_number, 'authentication' => 0, 'trans_id' => $id));
						if ($this->db->update('service_auth', $resend)) {
							$logs_msg = 'Resend OTP via SMS successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}

					}

				} else {

					$this->logs('system', $id, 'Auto Switch to WA. Reason: ' . $sms_status . ', Method: [' . $method . ']');

					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendwa/plain',
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => array(
							'username' => $username,
							'password' => $password,
							'text' => $message,
							'GSM' => $phone,
							'output' => 'json'
						)
					));

					$resp = curl_exec($curl);
					$res = (array) json_decode($resp, true);
					$wa_status = $res['results'][0]['status'];
					curl_close($curl);

					if ($wa_status == '0') {

						if ($type == 'send') {

							$send = array(
								'user_email' 		=> $this->email,
								'phone_number' 		=> $phone,
								'otp_code' 			=> $otp_code,
								'authentication' 	=> 0,
								'activity_name'		=> '[Auto Switch] Send OTP via WA',
								'last_sent'			=> $this->date,
								'trans_id'			=> $id,
								'trans_code'		=> $request_number,
								'messages'			=> $message
							);

							if ($this->db->insert('service_auth', $send)) {
								$logs_msg = 'Send OTP via WA successfully';
								$this->logs('system', $id, $logs_msg);
								$transok = 1;
							}

						} else {

							$resend = array(
								'otp_code' => $otp_code, 
								'messages' => $message, 
								'activity_name' => '[Auto Switch] Resend OTP via WA', 
								'last_sent' => $this->date);

							$this->db->where(array('user_email' => $this->email, 'phone_number' => $phone, 'trans_code' => $request_number, 'authentication' => 0, 'trans_id' => $id));
							if ($this->db->update('service_auth', $resend)) {
								$logs_msg = 'Resend OTP via WA successfully';
								$this->logs('system', $id, $logs_msg);
								$transok = 1;
							}

						}

					} else {
						$this->logs('system', $id, 'WA Failed. Reason: ' . $wa_status . ', Method: [' . $method . ']');
					}
					
				}

				echo json_encode($transok);
				break;

			case 'ebast':

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'SMSText' => $message_ebast,
						'GSM' => $phone,
						'otp' => 'Y',
						'output' => 'json'
					)
				));

				$resp_sms = curl_exec($curl);
				$result = (array) json_decode($resp_sms, true);
				$sms_status = $result['results'][0]['status'];
				curl_close($curl);

				if ($sms_status == '0') {

					if ($type == 'send') {

						$send = array(
							'user_email' 		=> $this->email,
							'phone_number' 		=> $phone,
							'otp_code' 			=> $otp_code,
							'authentication' 	=> 0,
							'activity_name'		=> 'Send OTP via SMS',
							'last_sent'			=> $this->date,
							'trans_id'			=> $id,
							'trans_code'		=> $request_number,
							'messages'			=> $message_ebast
						);

						if ($this->db->insert('service_auth', $send)) {
							$logs_msg = 'Send OTP via SMS successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}

					} else {

						$resend = array(
							'otp_code' => $otp_code,
							'messages' => $message_ebast,
							'activity_name' => 'Resend OTP via SMS',
							'last_sent' => $this->date
						);

						$this->db->where(array('user_email' => $this->email, 'phone_number' => $phone, 'trans_code' => $request_number, 'authentication' => 0, 'trans_id' => $id));
						if ($this->db->update('service_auth', $resend)) {
							$logs_msg = 'Resend OTP via SMS successfully';
							$this->logs('system', $id, $logs_msg);
							$transok = 1;
						}
					}

				} else {

					$this->logs('system', $id, 'Auto Switch to WA. Reason: ' . $sms_status . ', Method: [' . $method . ']');

					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendwa/plain',
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => array(
							'username' => $username,
							'password' => $password,
							'text' => $message_ebast,
							'GSM' => $phone,
							'output' => 'json'
						)
					));

					$resp = curl_exec($curl);
					$res = (array) json_decode($resp, true);
					$wa_status = $res['results'][0]['status'];
					curl_close($curl);

					if ($wa_status == '0') {

						if ($type == 'send') {

							$send = array(
								'user_email' 		=> $this->email,
								'phone_number' 		=> $phone,
								'otp_code' 			=> $otp_code,
								'authentication' 	=> 0,
								'activity_name'		=> '[Auto Switch] Send OTP via WA',
								'last_sent'			=> $this->date,
								'trans_id'			=> $id,
								'trans_code'		=> $request_number,
								'messages'			=> $message_ebast
							);

							if ($this->db->insert('service_auth', $send)) {
								$logs_msg = 'Send OTP via WA successfully';
								$this->logs('system', $id, $logs_msg);
								$transok = 1;
							}

						} else {

							$resend = array(
								'otp_code' => $otp_code,
								'messages' => $message_ebast,
								'activity_name' => '[Auto Switch] Resend OTP via WA',
								'last_sent' => $this->date
							);

							$this->db->where(array('user_email' => $this->email, 'phone_number' => $phone, 'trans_code' => $request_number, 'authentication' => 0, 'trans_id' => $id));
							if ($this->db->update('service_auth', $resend)) {
								$logs_msg = 'Resend OTP via WA successfully';
								$this->logs('system', $id, $logs_msg);
								$transok = 1;
							}
						}

					} else {
						$this->logs('system', $id, 'WA Failed. Reason: ' . $wa_status . ', Method: [' . $method . ']');
					}
				}

				echo json_encode($transok);
				break;
			
			default:
				break;
		}

	}

	## Validate OTP
	public function validate($resp)
	{
		$output = array('status' => 0, 'message' => 'Authentication failed.');
		$phone = $this->phone;
		$otp = $this->input->post('otp');
		$request_id = $this->input->post('id');
		$request_number = $this->input->post('request_number');
		$approval_id = $this->input->post('approval_id');
		$final_score = $this->input->post('final_score');

		$requestor = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['created_by'];

		#data response approval
		$approval = array('approval_status' => $resp, 'updated_at' => $this->date, 'updated_by' => $this->email);

		$getOTP = $this->m_services->get_otp($this->email, $phone, $request_id, $request_number);

		switch ($resp) {

			case 'Approved':
				
				if ($getOTP == $otp) {

					#update service auth
					$this->db->where(array('user_email' => $this->email, 'otp_code' => $otp, 'phone_number' => $phone, 'trans_id' => $request_id, 'trans_code' => $request_number));
					if ($this->db->update('service_auth', array('authentication' => 1))) {

						#check approver list
						$sql = "SELECT * FROM form_approval WHERE id >= '$approval_id' AND request_id = '$request_id' ORDER BY approval_priority ASC OFFSET 1 ROWS FETCH NEXT 1 ROWS ONLY";
						$checkleft = $this->db->query($sql);


						if ($checkleft->num_rows() > 0) {

							#update response approval
							$this->db->where('id', $approval_id);
							if ($this->db->update('form_approval', $approval)) {

								#set in progress for next approver
								$this->db->where('id', $checkleft->row_array()['id']);
								if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {

									#update final score
									$this->db->where('id', $request_id);
									$this->db->update('performance_appraisal', array('final_score' => $final_score, 'updated_by' => $this->email, 'updated_at' => $this->date));
									$this->sendEmail('need_response_eapp', $request_id, $checkleft->row_array()['approval_email']);
									$this->logs('approved', $request_id);
									$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

								} else {
									$this->logs('system', $request_id, 'Authentication success, but failed while updating the next approver.');
									$output = array('status' => 1, 'message' => 'Authentication success, but failed while updating the next approver.');
								}

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval.');
								$output = array('status' => 1, 'message' => 'Authentication success, but failed while updating response approval. ');
							}

						} else {	

							#update header request
							$this->db->where('id', $request_id);
							if ($this->db->update('performance_appraisal', array('is_status' => 3, 'final_score' => $final_score, 'full_approved_date' => $this->date, 'updated_by' => $this->email, 'updated_at' => $this->date))) {


								#update response approval
								$this->db->where('id', $approval_id);
								if ($this->db->update('form_approval', $approval)) {

									$this->sendEmail('approved_eapp', $request_id, $requestor);
									$this->logs('approved', $request_id, 'Approved successfully.');
									
									$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

								} else {
									$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval [Full Approved].');
									$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.');
								}

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating header request [Full Approved].');
								$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.');
							}

						}

					} else {
						$this->logs('system', $request_id, 'Failed while updating service auth.');
						$output = array('status' => 0, 'message' => 'Please try again.');
					}

				} else {
					$this->logs('system', $request_id, 'Authentication Failed. Code didn\'t match.');
				}

				break;

			default:
				break;
		}

		echo json_encode($output);
	}

	public function validate_ebast($resp)
	{
		$output = array('status' => 0, 'message' => 'Authentication failed.');
		$phone = $this->phone;
		$otp = $this->input->post('otp');
		$request_id = $this->input->post('id');
		$request_number = $this->input->post('request_number');
		$requestor = $this->input->post('requestor');
		$approval_id = $this->input->post('approval_id');
		$approval_note = $this->input->post('approval_note');

		$approval_priority = $this->m_ebast->find_select("approval_priority", array('id' => $approval_id), 'ebast_approval')->row_array()['approval_priority'];

		// print_r($approval_priority);die;

		$worktype = $this->m_ebast->find_select("worktype_id", array('id' => $request_id), 'ebast')->row_array()['worktype_id'];
		$milestone = $this->m_ebast->find_select("milestone_id", array('id' => $request_id), 'ebast')->row_array()['milestone_id'];


		// Notif admin when ebast full approved
		$region = $this->m_ebast->find_select("region", array('id' => $request_id), 'ebast')->row_array()['region'];
		$admin_internal = $this->m_ebast->find_select("user_email", array('regional' => $region, 'user_group_id' => '1012'), 'users')->result();

		#data response approval
		$approval = array('approval_status' => $resp, 'approval_note' => $approval_note, 'updated_at' => $this->date, 'updated_by' => $this->email);
		$getOTP = $this->m_services->get_otp($this->email, $phone, $request_id, $request_number);

		switch ($resp) {

			case 'Approved':

				if ($getOTP == $otp) {

					#update service auth
					$this->db->where(array('user_email' => $this->email, 'otp_code' => $otp, 'phone_number' => $phone, 'trans_id' => $request_id, 'trans_code' => $request_number));
					if ($this->db->update('service_auth', array('authentication' => 1))) {

						#check approver list
						$sql = "SELECT * FROM ebast_approval WHERE id >= '$approval_id' AND ebast_id = '$request_id' ORDER BY approval_priority ASC OFFSET 1 ROWS FETCH NEXT 1 ROWS ONLY";
						$checkleft = $this->ilink->query($sql);

						if ($checkleft->num_rows() > 0) {

							#update response approval
							$this->ilink->where('id', $approval_id);
							if ($this->ilink->update('ebast_approval', $approval)) {


								// IF BAMT, INSERT TO IMM
								if ($worktype == "8" && $milestone == "22" && $approval_priority == "2") {
									$this->save_bamt_report($request_id);
								}

								#set in progress for next approver
								$this->ilink->where('id', $checkleft->row_array()['id']);
								if ($this->ilink->update('ebast_approval', array('approval_status' => 'In Progress'))) {

									$this->logs('approved', $request_id, $approval_note, 'E-BAST');
									$progress = $this->m_ebast->find_select("approval_email, approval_name, approval_priority, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();
									$output = array('status' => 1, 'message' => 'Response updated successfully.', 'progress' => $progress, 'response' => ebast_status_color(2));

								} else {
									$this->logs('system', $request_id, 'Authentication success, but failed while updating the next approver.');
									$output = array('status' => 1, 'message' => 'Authentication success, but failed while updating the next approver. Please call the Software Engineer. ');
								}

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval.');
								$output = array('status' => 1, 'message' => 'Authentication success, but failed while updating response approval. Please call the Software Engineer. ');
							}

						} else {

							#update header request
							$this->ilink->where('id', $request_id);
							if ($this->ilink->update('ebast', array('is_status' => 3, 'full_approved_date' => $this->date, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

								#update response approval
								$this->ilink->where('id', $approval_id);
								if ($this->ilink->update('ebast_approval', $approval )) {


									// IF BAMT, INSERT TO IMM
									if ($worktype == "8" && $milestone == "22" && $approval_priority == "2") {
										$this->save_bamt_report($request_id);
									}

									$this->logs('approved', $request_id, $approval_note, 'E-BAST');

									$this->sendNotifEbast('approved', $request_id, $admin_internal);

									$progress = $this->m_ebast->find_select("approval_email,approval_priority, approval_name, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();
									$output = array('status' => 1, 'message' => 'Approved successfully.', 'progress' => $progress, 'response' => ebast_status_color(3));

								} else {
									$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval [Full Approved].');
									$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval. Please call the Software Engineer. ');
								}

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating header request [Full Approved].');
								$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval. Please call the Software Engineer. ');
							}
						}

					} else {
						$this->logs('system', $request_id, 'Failed while updating service auth.');
						$output = array('status' => 0, 'message' => 'Please try again.');
					}

				} else {
					$this->logs('system', $request_id, 'Authentication Failed. Code didn\'t match.');
				}

				break;

			case 'Rejected':

				if ($getOTP == $otp) {

					#update service auth
					$this->db->where(array('user_email' => $this->email, 'otp_code' => $otp, 'phone_number' => $phone, 'trans_id' => $request_id, 'trans_code' => $request_number));
					if ($this->db->update('service_auth', array('authentication' => 1))) {

						#update header request
						if ($this->ilink->where('id', $request_id)->update('ebast', array('is_status' => 5, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

							#update response approval
							if ($this->ilink->where('id', $approval_id)->update('ebast_approval', $approval)) {

								$this->logs('rejected',$request_id,$approval_note, 'E-BAST');
								$progress = $this->m_ebast->find_select("approval_email, approval_priority, approval_name, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();
								$output = array('status' => 1, 'message' => 'Request has been rejected.', 'progress' => $progress, 'response' => ebast_status_color(5));

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval.');
								$output = array('status' => 1, 'message' => 'Authentication success, but failed while updating response approval.');
							}
						} else {
							$this->logs('system', $request_id, 'Authentication success, but failed while updating header request.');
							$output = array('status' => 1, 'message' => 'Authentication success, but failed while updating header request.');
						}
					} else {
						$this->logs('system', $request_id, 'Failed while updating service auth.');
						$output = array('status' => 0, 'message' => 'Please try again.');
					}
				} else {
					$this->logs('system', $request_id, 'Authentication Failed. Code didn\'t match.');
				}

				break;

			default:
				break;
		}

		echo json_encode($output);
	}

	public function logs($type, $id, $message = '', $form_type = '')
	{
		$log['request_id'] = $id;
		$log['created_by'] = ($type == 'system') ? 'system' : $this->email;
		$log['created_at'] = $this->date;
		$log['form_type'] = $form_type;

		switch ($type) {

			case 'system':
				$log['activity'] = 'system';
				$log['description'] = $message;
				$this->db->insert('logs', $log);
				break;
			
			case 'approved':
				$log['activity'] = 'Approved';
				$log['description'] = $message;
				$this->db->insert('logs', $log);
				break;

			case 'rejected':
				$log['activity'] = 'Rejected';
				$log['description'] = $message;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

	public function sendEmail($type, $requestId, $email_to)
	{
		$employee_name = $this->m_global->find('performance_appraisal', 'id', $requestId)->row_array()['employee_name'];
		$data['detail'] = $this->m_global->find('performance_appraisal', 'id', $requestId)->row_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		$data['email'] = $email_to;

		if ($type == 'need_response_eapp') {
			$html = $this->load->view('services/email/need_response', $data, TRUE);
		} elseif ($type == 'revise') {
			$html = $this->load->view('services/email/revise', $data, TRUE);
		} elseif ($type == 'approved_eapp') {
			$html = $this->load->view('services/email/approved', $data, TRUE);
		} elseif ($type == 'approved_mdcr') {
			$html = $this->load->view('services/email/approvedMDCR', $data, TRUE);
		} 

		$url = 'https://api.ibstower.com/email_service';
		$params = array(
			'app_name'      => 'eApproval',
			'ip_address'    => $_SERVER['SERVER_ADDR'],
			'email_to'      => $email_to,
			'email_subject' => 'Performance Appraisal - ['. $employee_name .' ]',
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

    public function sendNotifEbast($type, $requestId, $email_to)
    {
        $request_number = $this->m_ebast->find('id', $requestId, 'ebast')->row_array()['request_number'];
        $data['detail'] = $this->m_ebast->find('id', $requestId, 'ebast')->row_array();
        $data['approval'] = $this->m_ebast->find('ebast_id', $requestId, 'ebast_approval')->result_array();
        $data['worktype'] = $this->m_ebast->getOneById("category_name", 'master_worktype', array('id' => $data['detail']['worktype_id']));
        $data['milestone'] = $this->m_ebast->getOneById("name", 'master_milestone', array('id' => $data['detail']['milestone_id']));
        $data['email'] = $email_to;

        $html = $this->load->view('services/email/notif_ebast_approved', $data, TRUE);

		foreach ($email_to as $key) {

			$url = 'https://api.ibstower.com/email_service';
	        $params = array(
	            'app_name'      => 'E-BAST',
	            'ip_address'    => $_SERVER['SERVER_ADDR'],
	            'email_to'      => $key->user_email,
	            'email_subject' => $request_number,
	            'email_content' => $html,
	            'is_status'     => 0,
	            'created_at'     => $this->date,
	            'created_by'     => $this->email
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

    // INSERT BAMT TO IMM
    function save_bamt_report($request_id)
    {
    	if ($this->m_ebast->save_bamt_report($request_id)) {
    		return true;
    	} else {
    		return false;
    	}
    }

	// Check
	function check_wa()
	{
		$username = "";
		$password = "";
		$message  = "testing wa.";

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendwa/plain',
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => array(
				'username' => $username,
				'password' => $password,
				'text' => $message,
				'GSM' => '', //Nomor
				'output' => 'json'
			)
		));

		$resp = curl_exec($curl);
		curl_close($curl);
		echo $resp;
	}

	function check_sms()
	{
		$username = "";
		$password = "";
		$message  = "testing sms.";

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => array(
				'username' => $username,
				'password' => $password,
				'SMSText' => $message,
				'GSM' => '', //Nomor
				'otp' => 'Y',
				'output' => 'json'
			)
		));

		$resp = curl_exec($curl);
		curl_close($curl);
		echo $resp;
	}

}
