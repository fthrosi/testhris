<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception ;

class M_services extends CI_Model
{

    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
        $this->load->model('m_global');
        $this->load->model('form_model');
		$this->user = $this->session->userdata('user_name');
		$this->email = $this->session->userdata('user_email');
		$this->date = date('Y-m-d H:i:s');
		$this->today = date('Y-m-d');
		$this->year = date('Y');

        $this->status_apps = $_ENV['CI_ENVIRONMENT'];

	}
    
    public function check_otp($email, $id, $phone, $requestNumber)
    {
        return $this->db->get_where('service_auth', array(
            'user_email' => $email, 
            'phone_number' => $phone, 
            'trans_id' => $id, 
            'trans_code' => $requestNumber, 
            'authentication' => 0
        ));
    }

    public function get_otp($user_email, $phones, $requestId, $requestNumber)
    {
        $check = $this->db
            ->where('user_email', $user_email)
            ->where('phone_number', $phones)
            ->where('trans_id', $requestId)
            ->where('trans_code', $requestNumber)
            ->where('authentication', 0)
            ->get('service_auth');

        if ($check->num_rows() > 0) {
            return $check->row_array()['otp_code'];
        } else {
            return 0;
        }
    }

    public function sendEmailPA($requestId, $type)
	{
        $employee_name = $this->m_global->find('performance_appraisal', 'id', $requestId)->row_array()['employee_name'];
		$data['detail'] = $this->m_global->find('performance_appraisal', 'id', $requestId)->row_array();
        $id_form_request = $this->m_global->find('form_request', 'request_number', $data['detail']['request_number'])->row_array();
        $data['form_request'] = $this->m_global->find('form_request', 'id', $id_form_request['id'])->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $id_form_request['id'])->result_array();
		
		if ($type == 'need_response') {
            
            foreach ($data['approval'] as $key => $value) {
                if ($value['approval_status'] == 'In Progress') {
                    $email_to   = $data['approval'][$key]['approval_email'];
                    $data['approval_alias'] = $data['approval'][$key]['approval_alias'];
                    break;
                }
            }
            $data['is_status'] = status_color($data['form_request']['is_status']);
			$html = $this->load->view('services/email/need_response_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Approval Request';
		} elseif ($type == 'cancel') {
            $email_to               = $data['approval'][0]['approval_email'];
            $data['approval_alias'] = $data['approval'][0]['approval_alias'];
            $data['is_status']      = status_color($data['form_request']['is_status']);
			$html = $this->load->view('services/email/cancel_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Request Cancel';
		} elseif ($type == 'approved') {
            $email_to               = decrypt($data['detail']['created_by']);
            $data['requestor']      = decrypt($employee_name);

            $count_approved = 0;
            foreach ($data['approval'] as $key => $value) {
                if ($value['approval_status'] == 'Approved') {
                    $count_approved ++;
                }
            }
            $itung = $count_approved - 1;
            
            $data['approval_alias'] = $data['approval'][$itung]['approval_alias'];
            $data['is_status']      = status_color($data['form_request']['is_status']);
			$html = $this->load->view('services/email/approved_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Request Approved';
		} elseif ($type == 'revise_1') {
            $email_to               = decrypt($data['detail']['created_by']);
            $data['requestor']      = decrypt($employee_name);
            $data['approval_alias'] = $data['approval'][0]['approval_alias'];
            $data['is_status']      = status_color($data['detail']['is_status']);
			$html = $this->load->view('services/email/revise_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Request Revised';
		} elseif ($type == 'revise_2') {
            $email_to               = decrypt($data['detail']['created_by']);
            $data['requestor']      = decrypt($employee_name);
            $data['approval_alias'] = $data['approval'][1]['approval_alias'];
            $data['is_status']      = status_color($data['detail']['is_status']);
			$html = $this->load->view('services/email/revise_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Request Revised';
		} elseif ($type == 'revise_info') {
            $email_to               = $data['approval'][0]['approval_email'];
            $data['requestor']      = decrypt($employee_name);
            $data['approval_alias_1'] = $data['approval'][0]['approval_alias'];
            $data['approval_alias_2'] = $data['approval'][1]['approval_alias'];
            $data['is_status']      = status_color($data['detail']['is_status']);
			$html = $this->load->view('services/email/revise_info_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Information Request Revised';
		} elseif ($type == 'hr_confirmed') {
            $email_to               = decrypt($data['detail']['created_by']);
            $data['requestor']      = decrypt($employee_name);
            $data['is_status']      = status_color($data['detail']['is_status']);
			$html = $this->load->view('services/email/hr_confirmed_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] HR Confirmed';
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
		// 	$mail->addAddress($email_to);
        //     $mail->addBCC('luffi.utomo@ibsmulti.com');
		// }elseif($link_host == 'rnd.ibsmulti.com'){
		// 	$mail->addAddress('ditha.damayanti@ibsmulti.com');
        //     $mail->addCC('luffi.utomo@ibsmulti.com','gilang.cahyo@ibsmulti.com');
		// }else{
        //     $mail->addAddress($email_to);
        //     $mail->addBCC('luffi.utomo@ibsmulti.com');
		// }

        if($this->status_apps == "development") {
            $prefix = 'DEV TEST - ';
			$email_subject = $prefix . $email_subject;
            $mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('ditha.damayanti@ibsmulti.com');
            $mail->addCC('luffi.utomo@ibsmulti.com','gilang.cahyo@ibsmulti.com');
		} else if ($this->status_apps == "staging") {
            $prefix = 'STAGING TEST - ';
			$email_subject = $prefix . $email_subject;
            $mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('ditha.damayanti@ibsmulti.com');
            $mail->addCC('luffi.utomo@ibsmulti.com','gilang.cahyo@ibsmulti.com');
		} else if ($this->status_apps == "production") {
			$mail->addAddress($email_to);
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
			$mail->addBCC('luffi.utomo@ibsmulti.com');
		}
		

		// Isi Email
		$mail->isHTML(true);
        $mail->Body    = $html;
		$mail->Subject = $email_subject;

		// $mail->send();	
        if(!$mail->Send())
        {
            // $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$emailpenerima;
            return false;
        }else{
            // $message = "sent-MEDCLAIM";
            return true;
        }
		
	}
    
    public function sendEmailHRPA($division, $eval_year, $type)
	{
        $sql = "SELECT a.*, b.complete_name FROM performance_division_status a LEFT JOIN v_hris_employee_updated AS b ON a.updated_by = b.email WHERE a.division_name = '$division' AND a.evaluation_period = '$eval_year'";
		$division_status = $this->db->query($sql)->result_array();
		
		if ($type == 'submit_to_hr') {
            $email_to               = 'gilang.cahyo@ibsmulti.com';
            $data['division'] = decrypt($division);
            $data['requestor'] = decrypt($division_status[0]['complete_name']);
            $data['is_status'] = status_color($division_status[0]['is_status']);
			$html = $this->load->view('services/email/submit_to_hr_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Approval Request';
		}elseif ($type == 'revised') {
            $email_to               = decrypt($division_status[0]['updated_by']);
            $data['division'] = decrypt($division);
            $data['requestor'] = decrypt($division_status[0]['complete_name']);
            $data['is_status'] = status_color($division_status[0]['is_status']);
			$html = $this->load->view('services/email/revised_to_div_pa', $data, TRUE);
            $email_subject = '[HRIS-PA] Request Revised';
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
		// 	$mail->addAddress($email_to);
        //     $mail->addBCC('luffi.utomo@ibsmulti.com');
		// }elseif($link_host == 'rnd.ibsmulti.com'){
		// 	$mail->addAddress('ditha.damayanti@ibsmulti.com');
        //     $mail->addCC('luffi.utomo@ibsmulti.com','gilang.cahyo@ibsmulti.com');
		// }else{
        //     $mail->addAddress($email_to);
        //     $mail->addBCC('luffi.utomo@ibsmulti.com');
		// }

        if($this->status_apps == "development") {
            $prefix = 'DEV TEST - ';
			$email_subject = $prefix . $email_subject;
            $mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('ditha.damayanti@ibsmulti.com');
            $mail->addCC('luffi.utomo@ibsmulti.com','gilang.cahyo@ibsmulti.com');
		} else if ($this->status_apps == "staging") {
            $prefix = 'STAGING TEST - ';
			$email_subject = $prefix . $email_subject;
            $mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
			$mail->addAddress('ditha.damayanti@ibsmulti.com');
            $mail->addCC('luffi.utomo@ibsmulti.com','gilang.cahyo@ibsmulti.com');
		} else if ($this->status_apps == "production") {
			$mail->addAddress($email_to);
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
			$mail->addBCC('luffi.utomo@ibsmulti.com');
		}
		
		

		// Isi Email
		$mail->isHTML(true);
        $mail->Body    = $html;
		$mail->Subject = $email_subject;

		// $mail->send();	
        if(!$mail->Send())
        {
            // $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$emailpenerima;
            return false;
        }else{
            // $message = "sent-MEDCLAIM";
            return true;
        }
		
	}

}
