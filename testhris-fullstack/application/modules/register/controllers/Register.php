<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('user_email') == '') {
			redirect('https://ibsapps.ibstower.com');
		} 

		$this->load->model('m_register');
		$this->email = $this->session->userdata('user_email');
		$this->emp_id = $this->session->userdata('employee_id');
		$this->date = date('Y-m-d H:i:s');
	}

	public function index()
	{
		print_r('Please return to ibsapps.');
		die;
	}

	public function v2($app)
	{
		$data['app'] = $app;
		$data['emp'] = $this->db->get_where('users', array('user_email' => $this->email));
		$this->load->view('register/verification', $data);
	}

	public function updatePhone()
	{
		$this->load->view('register/updatePhone');
	}
	
	public function ChangePassword()
	{
		$this->load->view('register/ChangePassword');
	}

	public function validate($type)
	{
		switch ($type) {

			case 'emp_nik':

				$emp_nik = $this->input->post('emp_nik');
				$check = $this->m_register->checkID($emp_nik);

				if ($check->num_rows() == 0) {
					$response = array('status' => 0);
				} else {
					$data = $check->row_array();
					$response = array('status' => 1, 'employee' => $data);
				}

				echo json_encode($response);
				break;
			
			default:
				break;
		}
	}

	public function sendCode()
	{
		$phoneNumber = $this->input->post('phoneNumber');
		$transok = false;
		$otp_code = mt_rand(100000, 999999);
		$check = $this->m_register->checkRegistration($this->email, $phoneNumber);
		$count = $check->num_rows();

		if ($count == 0) {

			if ($phoneNumber != '') {

				$username = "ibstower_api";
				$password = "cZU4Hs7";
				$message  = "IBS eApproval registration. Your verification code is: $otp_code ";

				// Send SMS (Nusa)
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'SMSText' => $message,
						'GSM' => $phoneNumber,
						'otp' => 'Y',
						'output' => 'json'
					)
				));

				$resp = curl_exec($curl);
				$res = (array) json_decode($resp, true);
				$sms_status = $res['results'][0]['status'];
				curl_close($curl);

				if ($sms_status == '0') {

					$nusa_sms = array(
						'user_email' 		=> $this->email,
						'phone_number' 		=> $phoneNumber,
						'otp_code' 			=> $otp_code,
						'authentication' 	=> 0,
						'activity_name'		=> 'eApproval Registration',
						'last_sent'			=> date('Y-m-d H:i:s'),
						'trans_id'			=> '000',
						'trans_code'		=> '000',
						'messages'			=> $message
					);

					if ($this->db->insert('service_auth', $nusa_sms)) {
						$transok = true;
					}
					
				} else {

					// Send OTP via WA
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendwa/plain',
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => array(
							'username' => $username,
							'password' => $password,
							'text' => $message,
							'GSM' => $phoneNumber,
							'output' => 'json'
						)
					));

					$respWA = curl_exec($curl);
					$ress = (array) json_decode($respWA, true);
					$wa_status = $ress['results'][0]['status'];
					curl_close($curl);

					if ($wa_status == '0') {

						$nusa_wa = array(
							'user_email' 		=> $this->email,
							'phone_number' 		=> $phoneNumber,
							'otp_code' 			=> $otp_code,
							'authentication' 	=> 0,
							'activity_name'		=> 'eApproval Registration',
							'last_sent'			=> date('Y-m-d H:i:s'),
							'trans_id'			=> '000',
							'trans_code'		=> '000',
							'messages'			=> $message
						);

						if ($this->db->insert('service_auth', $nusa_wa)) {
							$transok = true;
						}

					} else {

						// Send GO SMS
						$go_username = "ibstower";
						$go_password = "dUmximPS";
						$mobileno = $phoneNumber;
						$go_message  = "IBS eApproval registration. Your verification code is: $otp_code ";
						$sms_final = str_replace(" ", "%20", $go_message);
						# Run OTP Service
						$url = "https://secure.gosmsgateway.com/masking/api/Send.php?username=$go_username&mobile=$mobileno&message=$sms_final&password=$go_password";

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_USERAGENT, 'Verifikasi');
						$curlsend = curl_exec($ch);

						if ($curlsend == '1701') {

							$go_sms = array(
								'user_email' 		=> $this->email,
								'phone_number' 		=> $phoneNumber,
								'otp_code' 			=> $otp_code,
								'authentication' 	=> 0,
								'activity_name'		=> 'eApproval Registration',
								'last_sent'			=> date('Y-m-d H:i:s'),
								'trans_id'			=> '000',
								'trans_code'		=> '000',
								'messages'			=> $go_message
							);

							if ($this->db->insert('service_auth', $go_sms)) {
								$transok = true;
							}
						} else {
							echo 'OTP Service Failed.';
							die;
						}
					}
				}
			} else {
				$transok = false;
			}
		} else {

			if ($this->resendCode($phoneNumber)) {
				$transok = true;
			} else {
				$transok = false;
			}
		}

		if ($transok) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function sendCodeChangeNumber()
	{
		$phoneNumber = $this->input->post('phoneNumber');
		$transok = false;
		$otp_code = mt_rand(100000, 999999);
		$check = $this->m_register->checkChangeNumber($this->email, $phoneNumber);
		$count = $check->num_rows();

		if ($count == 0) {

			if ($phoneNumber != '') {

				$username = "ibstower_api";
				$password = "cZU4Hs7";
				$message  = "Your verification code for change number is: $otp_code ";

				// Send SMS (Nusa)
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'SMSText' => $message,
						'GSM' => $phoneNumber,
						'otp' => 'Y',
						'output' => 'json'
					)
				));

				$resp = curl_exec($curl);
				$res = (array) json_decode($resp, true);
				$sms_status = $res['results'][0]['status'];
				curl_close($curl);

				if ($sms_status == '0') {

					$nusa_sms = array(
						'user_email' 		=> $this->email,
						'phone_number' 		=> $phoneNumber,
						'otp_code' 			=> $otp_code,
						'authentication' 	=> 0,
						'activity_name'		=> 'Change Number',
						'last_sent'			=> date('Y-m-d H:i:s'),
						'trans_id'			=> '000',
						'trans_code'		=> '000',
						'messages'			=> $message
					);

					if ($this->db->insert('service_auth', $nusa_sms)) {
						$transok = true;
					}
					
				} 
			} 

		} else {

			if ($this->resendCodeChangeNumber($phoneNumber)) {
				$transok = true;
			} else {
				$transok = false;
			}
		}

		if ($transok) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function sendCodeToMe()
	{
		$phoneNumber = '081211089804';
		$username = "ibstower_api";
		$password = "cZU4Hs7";
		$message  = "No OK!";

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => array(
				'username' => $username,
				'password' => $password,
				'SMSText' => $message,
				'GSM' => $phoneNumber,
				'otp' => 'Y',
				'output' => 'json'
			)
		));

		$resp = curl_exec($curl);
		$res = (array) json_decode($resp, true);
		$sms_status = $res['results'][0]['status'];
		curl_close($curl);

		$this->db->where('id', '131');
		if ($this->db->update('users', array('verification_status' => 1 ))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function sendCodeToMe2()
	{
		$phoneNumber = '081211089804';
		$username = "ibstower_api";
		$password = "cZU4Hs7";
		$message  = "OK";

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => array(
				'username' => $username,
				'password' => $password,
				'SMSText' => $message,
				'GSM' => $phoneNumber,
				'otp' => 'Y',
				'output' => 'json'
			)
		));

		$resp = curl_exec($curl);
		$res = (array) json_decode($resp, true);
		$sms_status = $res['results'][0]['status'];
		curl_close($curl);

		$this->db->where('id', '131');
		if ($this->db->update('users', array('verification_status' => 1 ))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function resendCode($phoneNumber)
	{
		$transok = false;

		if (!empty($phoneNumber)) {

			$otp_code = mt_rand(100000, 999999);

			$username = "ibstower_api";
			$password = "cZU4Hs7";
			$nusa_message  = "IBS eApproval registration. Your verification code is: $otp_code ";

			// Send SMS (Nusa)
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => array(
					'username' => $username,
					'password' => $password,
					'SMSText' => $nusa_message,
					'GSM' => $phoneNumber,
					'otp' => 'Y',
					'output' => 'json'
				)
			));

			$resp = curl_exec($curl);
			$res = (array) json_decode($resp, true);
			$sms_status = $res['results'][0]['status'];
			curl_close($curl);

			if ($sms_status == '0') {

				$this->db->where(array(
					'activity_name' => 'eApproval Registration',
					'user_email' => $this->email,
					'phone_number' => $phoneNumber,
					'trans_code' => '000',
					'trans_id' => '000',
					'authentication' => 0
				));

				$sms_update = array(
					'otp_code' => $otp_code,
					'last_sent' => date('Y-m-d H:i:s')
				);

				if ($this->db->update('service_auth', $sms_update)) {
					$transok = true;
				}

			} else {

				// Send WA (Nusa)
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendwa/plain',
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $password,
						'text' => $nusa_message,
						'GSM' => $phoneNumber,
						'output' => 'json'
					)
				));

				$respWA = curl_exec($curl);
				$ress = (array) json_decode($respWA, true);
				$wa_status = $ress['results'][0]['status'];
				curl_close($curl);

				if ($wa_status == '0') {

					$this->db->where(array(
						'activity_name' => 'eApproval Registration',
						'user_email' => $this->email,
						'phone_number' => $phoneNumber,
						'trans_code' => '000',
						'trans_id' => '000',
						'authentication' => 0
					));

					$nusa_wa_update = array(
						'otp_code' => $otp_code,
						'last_sent' => date('Y-m-d H:i:s')
					);

					if ($this->db->update('service_auth', $nusa_wa_update)) {
						$transok = true;
					}

				} else {

					// Send GO SMS
					$go_username = "ibstower";
					$go_password = "dUmximPS";
					$mobileno = $phoneNumber;
					$go_message  = "IBS eApproval registration. Your verification code is: $otp_code ";
					$sms_final = str_replace(" ", "%20", $go_message);
					# Run OTP Service
					$url = "https://secure.gosmsgateway.com/masking/api/Send.php?username=$go_username&mobile=$mobileno&message=$sms_final&password=$go_password";

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_USERAGENT, 'Verifikasi');
					$curlsend = curl_exec($ch);

					if ($curlsend == '1701') {

						$this->db->where(array(
							'activity_name' => 'eApproval Registration',
							'user_email' => $this->email,
							'phone_number' => $phoneNumber,
							'trans_code' => '000',
							'trans_id' => '000',
							'authentication' => 0
						));

						$gosms_update = array(
							'otp_code' => $otp_code,
							'last_sent' => date('Y-m-d H:i:s')
						);

						if ($this->db->update('service_auth', $gosms_update)) {
							$transok = true;
						}
					} else {
						echo 'Resend OTP Service Failed.';
						die;
					}
				}
			}

		} else {
			$transok = false;
		}

		if ($transok) {
			return true;
		} else {
			return false;
		}
	}

	public function resendCodeChangeNumber($phoneNumber)
	{
		$transok = false;

		if (!empty($phoneNumber)) {

			$otp_code = mt_rand(100000, 999999);

			$username = "ibstower_api";
			$password = "cZU4Hs7";
			$nusa_message  = "Your verification code for change number is: $otp_code ";

			// Send SMS (Nusa)
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => array(
					'username' => $username,
					'password' => $password,
					'SMSText' => $nusa_message,
					'GSM' => $phoneNumber,
					'otp' => 'Y',
					'output' => 'json'
				)
			));

			$resp = curl_exec($curl);
			$res = (array) json_decode($resp, true);
			$sms_status = $res['results'][0]['status'];
			curl_close($curl);

			if ($sms_status == '0') {

				$this->db->where(array(
					'activity_name'	=> 'Change Number',
					'user_email' => $this->email,
					'phone_number' => $phoneNumber,
					'trans_code' => '000',
					'trans_id' => '000',
					'authentication' => 0
				));

				$sms_update = array(
					'otp_code' => $otp_code,
					'last_sent' => date('Y-m-d H:i:s')
				);

				if ($this->db->update('service_auth', $sms_update)) {
					$transok = true;
				}
			} 

		} else {
			$transok = false;
		}

		if ($transok) {
			return true;
		} else {
			return false;
		}
	}

	public function verify()
	{
		$phoneNumber = $this->input->post('phoneNumber');
		$emp_id = $this->input->post('emp_id');
		$otp_code = $this->input->post('otp');
		$getOTP = $this->m_register->getDataOTP($this->email, $phoneNumber);
		$ibsapps = 'http://ibsapps.ibstower.com';
		$url = ($this->input->post('app') == 'e') ? $ibsapps : 'list/ebast';

		# Update users
		$data_user = array(
			'phone_number' => $phoneNumber, 
			'employee_id' => $emp_id, 
			'verification_status' => 1,
			'updated_by' => $this->email,
			'updated_at' => $this->date,
		);

		# Update employee
		$data_employee = array(
			'phone_number' => $phoneNumber, 
			'user_email' => $this->email, 
			'updated_by' => $this->email,
			'updated_at' => $this->date,
		);

		if ($getOTP == $otp_code) {

			# Update service_auth
			if ($this->db->where(array('phone_number' => $phoneNumber, 'otp_code' => $otp_code, 'trans_id' => '000', 'trans_code' => '000'))->update('service_auth', array('authentication' => 1))) {
			
				if ($this->db->where('user_email', $this->email)->update('users', $data_user)) {
					$this->db->where('id', $emp_id)->update('employee', $data_employee);
					$this->session->set_userdata(['verification_status'=>'1']);
					$response = array('status' => 1, 'url' => $url);
				}
			} 

		} else {
			$response = array('status' => 0);
		}

		echo json_encode($response);
	}

	public function verifyChangeNumber()
	{
		$phoneNumber = $this->input->post('phoneNumber');
		$emp_id = $this->emp_id;
		$otp_code = $this->input->post('otp');
		$getOTP = $this->m_register->getDataOTP($this->email, $phoneNumber, 'changenumber');

		# Update users
		$data_user = array(
			'phone_number' => $phoneNumber, 
			'updated_by' => $this->email,
			'updated_at' => $this->date,
		);

		# Update employee
		$data_employee = array(
			'phone_number' => $phoneNumber, 
			'updated_by' => $this->email,
			'updated_at' => $this->date,
		);

		if ($getOTP == $otp_code) {


			# Update service_auth
			if ($this->db->where(array('phone_number' => $phoneNumber, 'otp_code' => $otp_code, 'trans_id' => '000', 'trans_code' => '000'))->update('service_auth', array('authentication' => 1))) {
			
				if ($this->db->where('user_email', $this->email)->update('users', $data_user)) {
					$this->db->where('id', $emp_id)->update('employee', $data_employee);
					$response = array('status' => 1, 'url' => 'form');
				}
			} 

		} else {
			$response = array('status' => 0);
		}

		echo json_encode($response);
	}

	public function saveChangePassword(){

		$new_passcode = $_POST['newpasscode'];
		$data = $this->m_register->saveChangePassword($new_passcode);
		echo json_encode($data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */