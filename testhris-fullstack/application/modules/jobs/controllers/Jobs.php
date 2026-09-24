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

class Jobs extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('general');
		$this->load->model('form/form_model');
		$this->load->model('inbox/inbox_model');
		$this->load->model('home/home_model');
		$this->load->model('m_global');
		$this->load->model('services/m_services');

		$this->status_apps = $_ENV['CI_ENVIRONMENT'];

		$this->date = date('Y-m-d H:i:s');
	}

    public function index(){
		$this->load->view('templates/404p');
    }

	public function get_data_fi_transaction()
    {
			$today = date('Ymd');
			$file = "/home/ftpuser/HRIS_MEDPAY_$today.csv";

			// Cek file
			if (!file_exists($file)) {
				log_message('error', 'FI Transaction Import - File tidak ditemukan: ' . $file);
				echo "\u{274C} File tidak ditemukan.<br>";
				return;
			}
			echo "File CSV ditemukan<br><br>";

			log_message('info', 'FI Transaction Import - File ditemukan: ' . $file);

			$csv = fopen($file, "r");

			if (!$csv) {
				log_message('error', 'FI Transaction Import - Gagal membuka file CSV');
				echo "\u{274C} Gagal membuka file.<br>";
				return;
			}

			// Mulai transaksi database
			$this->db->trans_begin();

			$flag = true;

			$row_count = 0;

			while (($data = fgetcsv($csv, 0, ';')) !== FALSE) {
				if ($flag) { 
					$flag = false; 
					continue; 
				}

				$row_count++;

				// Mapping data
				$period              = $data[0];
				$year                = $data[1];
				$company_code        = $data[2];
				$accounting_doc      = $data[3];
				$document_date       = $data[4];
				$header_text         = $data[5];
				$vendor_code         = $data[6];
				$personnel_number    = $data[7];
				$vendor_name         = str_replace("'", "||", $data[8]);
				$posting_date        = $data[9];
				$assignment          = $data[10];
				$text                = $data[11];
				$amount_claimed      = $data[12];
				$payment_doc         = $data[13];
				$payment_date        = $data[14];
				$amount_paid         = $data[15];

				// Cek data existing
				$sql_check = "
					SELECT * 
					FROM data_fi_transaction 
					WHERE vendor_code = ? 
					AND personnel_number = ?
					AND assignment = ?
				";
				$res = $this->db->query($sql_check, [
					$vendor_code, $personnel_number, $assignment
				])->row();

				if ($res) {

					// UPDATE
					$sql_update = "
						UPDATE data_fi_transaction SET 
							period = ?, 
							year = ?, 
							company_code = ?, 
							accounting_doc = ?, 
							document_date = ?, 
							header_text = ?, 
							vendor_code = ?, 
							personnel_number = ?, 
							vendor_name = ?, 
							posting_date = ?, 
							assignment = ?, 
							text = ?, 
							amount_claimed = ?, 
							payment_doc = ?, 
							payment_date = ?, 
							amount_paid = ?
						WHERE vendor_code = ? 
						AND personnel_number = ?
						AND assignment = ?
					";

					$this->db->query($sql_update, [
						$period, $year, $company_code, $accounting_doc, $document_date,
						$header_text, $vendor_code, $personnel_number, $vendor_name,
						$posting_date, $assignment, $text, $amount_claimed,
						$payment_doc, $payment_date, $amount_paid,
						$vendor_code, $personnel_number, $assignment
					]);

				} else {

					// INSERT
					$sql_insert = "
						INSERT INTO data_fi_transaction (
							period, year, company_code, accounting_doc, document_date, 
							header_text, vendor_code, personnel_number, vendor_name,
							posting_date, assignment, text, amount_claimed,
							payment_doc, payment_date, amount_paid
						) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
					";

					$this->db->query($sql_insert, [
						$period, $year, $company_code, $accounting_doc, $document_date,
						$header_text, $vendor_code, $personnel_number, $vendor_name,
						$posting_date, $assignment, $text, $amount_claimed,
						$payment_doc, $payment_date, $amount_paid
					]);
				}

				// Jika ada error query langsung break
				if ($this->db->error()['code'] != 0) {
					log_message('error', 'FI Transaction Import - DB Error: ' . json_encode($this->db->error()));
					break;
				}

			}

			fclose($csv);

			// Commit / rollback
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('error', 'FI Transaction Import - Gagal. Rollback dilakukan. Total row diproses: ' . $row_count);
				echo "\u{274C} Import gagal. Semua perubahan dibatalkan.<br>";
			} else {
				$this->db->trans_commit();
				echo "\u{2705} Import selesai dan data berhasil disimpan.<br>";
				log_message('info', 'FI Transaction Import - Berhasil commit. Total row diproses: ' . $row_count);
				// Hapus file setelah sukses
				if (file_exists($file)) {
					if (unlink($file)) {
						log_message('info', 'FI Transaction Import - File berhasil dihapus: ' . $file);
						echo "\u{2705} Import selesai dan file CSV berhasil dihapus.<br>";
					} else {
						log_message('error', 'FI Transaction Import - Gagal menghapus file: ' . $file);
						echo "\u{26A0} Import berhasil, tetapi file CSV gagal dihapus.<br>";
					}
				}
			}

        
    }

	public function sendEmail($type, $requestId, $email_to, $employee_id = "") {
		
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		$data['get_data_claim'] = $this->form_model->get_data_claim_per_request($requestId);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();

		$data['email'] = decrypt($data['data_employee'][0]->email);
		$email_to 	   = decrypt($data['data_employee'][0]->email);
		$data['complete_name'] = decrypt($data['data_employee'][0]->complete_name);
		$html = $this->load->view('services/email/re_request_full_paid', $data, TRUE);
		$email_subject = '[HRIS-MDCR] Medical Claim Fully PAID';

		// dumper($data);

		$mail = new PHPMailer();
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->isSMTP();
		$mail->Host       = 'mail.ibsmulti.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
		// $mail->Password   = '2025@54321No.Reply'; // ubah dengan password email Anda
		$mail->Password   = '1214#$C1k1n1.2026';
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;

		$mail->setFrom('no.reply@ibsmulti.com', 'Notification System'); // ubah dengan alamat email Anda

		// dumper($data);

		// $link_host = "$_SERVER[HTTP_HOST]";
		// if($link_host != "172.19.8.84" && $link_host != "hris.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com" || $link_host == "172.19.8.81")){
		// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
		// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
		// 	// $mail->addCC('gilang.cahyo@ibsmulti.com');
		// 	// $mail->addCC('palupi.utamo@ibsmulti.com');
		// 	// $mail->addCC('abimas.dewangga@ibsmulti.com');
		// }else{
		// 	// $mail->addAddress('luffi.utomo@ibsmulti.com');
		// 	// $mail->addCC('ditha.damayanti@ibsmulti.com');
		// 	$mail->addAddress($email_to);
		// 	if($email_to == "MAKMUR@IBSMULTI.COM" || $email_to == "makmur@ibsmulti.com" || $email_to == "FARIDA@IBSMULTI.COM" || $email_to == "farida@ibsmulti.com"){
		// 		$mail->addCC('STEFANI.UJONG@IBSMULTI.COM');
		// 	}
		// 	$mail->addCC('IKA.AMBARSARI@IBSMULTI.COM');
		// 	$mail->addCC('HARIS.KURNIAWAN@IBSMULTI.COM');
		// 	$mail->addCC('ap.ibsw@ibsmulti.com');
		// 	$mail->addBCC('hr.support@ibsmulti.com');
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
			if($email_to == "MAKMUR@IBSMULTI.COM" || $email_to == "makmur@ibsmulti.com" || $email_to == "FARIDA@IBSMULTI.COM" || $email_to == "farida@ibsmulti.com"){
				$mail->addCC('STEFANI.UJONG@IBSMULTI.COM');
			}
			$mail->addCC('IKA.AMBARSARI@IBSMULTI.COM');
			$mail->addCC('HARIS.KURNIAWAN@IBSMULTI.COM');
			$mail->addCC('ap.ibsw@ibsmulti.com');
			$mail->addBCC('hr.support@ibsmulti.com');
			$mail->addBCC('luffi.utomo@ibsmulti.com');
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
		}
		

		// Isi Email
		$mail->isHTML(true);
		$mail->Subject = $email_subject;
		$mail->Body    = $html;

		$mail->send();
	}

	public function matching_fi_transaction()
	{
		$this->db->trans_begin();

		$total_proc = 0;
		$total_paid = 0;

		$sql = "SELECT * FROM hris_no_req_mdcr WHERE is_status_progress != 6";
		$query = $this->db->query($sql);

		foreach ($query->result() as $row) {

			$no_req_mdcr = $row->no_req_mdcr;
			$data_no_fi = $no_req_mdcr;

			$sql_fr = "
				SELECT *
				FROM form_request
				WHERE no_req_mdcr = ? AND is_status_progress >= 3
			";
			$query_fr = $this->db->query($sql_fr, [$no_req_mdcr]);

			foreach ($query_fr->result() as $row_fr) {

				$request_id          = $row_fr->id;
				$personnel_number_fr = $row_fr->employee_id;
				$let_personnel_number_fr = $personnel_number_fr;
				$cek_data_no_fi 	 = $row_fr->no_req_mdcr;
				$let_data_no_fi 	 = $cek_data_no_fi;

				$sql_dft = "
					SELECT *
					FROM data_fi_transaction
					WHERE TRIM(assignment) = TRIM(?) 
					AND TRIM(personnel_number) = TRIM(?)";
				$query_dft = $this->db->query($sql_dft, [
					$cek_data_no_fi,
					$personnel_number_fr
				]);

				// ======================================================
				// === PERUBAHAN 1: HANDLE JIKA FI TIDAK ADA
				// ======================================================
				if ($query_dft->num_rows() == 0) {

					$sql_cek_fr = "
						SELECT is_status_progress
						FROM form_request
						WHERE no_req_mdcr = TRIM(?)
						AND form_type = 'MDCR'
						AND is_status_progress <= 3
						LIMIT 1
					";

					$query_cek_fr = $this->db->query($sql_cek_fr, [$cek_data_no_fi]);
					$cek_row = $query_cek_fr->row(); // ambil satu row saja

					$get_is_status_progress = $cek_row ? $cek_row->is_status_progress : $cek_row->is_status_progress;

					$this->db->where('no_req_mdcr', $cek_data_no_fi)
						->update('hris_no_req_mdcr', [
							'is_status' => 1,
							'is_status_progress' => $get_is_status_progress
						]);

					continue;
				}

				foreach ($query_dft->result() as $row_dft) {

					$payment_doc_dft = $row_dft->payment_doc;

					// ======================================================
					// CASE 1 — payment_doc kosong
					// ======================================================
					if ($payment_doc_dft === NULL || trim($payment_doc_dft) === '') {


						// === PERUBAHAN 2: Tidak lagi pakai variabel lama
						$this->db->query("
							UPDATE form_request 
							SET is_status_progress = 4
							WHERE id = ?
							AND is_status_progress != 4
						", [$request_id]);

						if ($this->db->affected_rows() > 0) {

							$this->db->query("
								UPDATE form_approval 
								SET approval_status = 'Approved', 
									updated_at = NOW(), 
									updated_by = 'ap.ibsw@ibsmulti.com'
								WHERE request_id = ? 
								AND approval_email LIKE 'ap.ibsw@ibsmulti.com'
							", [$request_id]);

							$this->db->where('request_id', $request_id);
							$this->db->like('approval_email', 'treasury.ibsw@ibsmulti.com');
							$this->db->update('form_approval', [
								'approval_status' => 'In Progress'
							]);

							$total_proc++;
						}

						continue;
					}

					// ======================================================
					// CASE 2 — payment_doc ada
					// ======================================================

					// === PERUBAHAN 3: Update langsung via kondisi DB
					$this->db->query("
						UPDATE form_request 
						SET is_status = 3,
							is_status_progress = 6,
							updated_by = 'treasury.ibsw@ibsmulti.com',
							updated_at = NOW()
						WHERE id = ?
						AND is_status_progress = 4
					", [$request_id]);

					if ($this->db->affected_rows() > 0) {

						$res_number = $this->db
								->where('id', $request_id)
								->limit(1)
								->get('form_request')
								->row();

						$email  = $res_number->created_by;
						$id 	= $res_number->id;
						$nik 	= $res_number->employee_id;

						$this->sendEmail('request_approve_mdcr',$id, $email, $nik);

						$this->db->query("
							UPDATE form_approval 
							SET approval_status = 'Approved', 
								updated_at = NOW(), 
								updated_by = 'treasury.ibsw@ibsmulti.com'
							WHERE request_id = ? 
							AND approval_email LIKE 'treasury.ibsw@ibsmulti.com'
						", [$request_id]);

						$total_paid++;

						continue;
					}
				}



						// ====================================================
						// HEADER UPDATE
						// ====================================================

						// Hitung total semua form_request
						$this->db->from('form_request');
						$this->db->where('no_req_mdcr', $let_data_no_fi);
						$total_all = $this->db->count_all_results();

						// Hitung jumlah detail per progress
						$this->db->from('form_request');
						$this->db->where('no_req_mdcr', $let_data_no_fi);
						$this->db->where('is_status_progress', 0);
						$status0 = $this->db->count_all_results();

						$this->db->from('form_request');
						$this->db->where('no_req_mdcr', $let_data_no_fi);
						$this->db->where('is_status_progress', 1);
						$status1 = $this->db->count_all_results();

						$this->db->from('form_request');
						$this->db->where('no_req_mdcr', $let_data_no_fi);
						$this->db->where('is_status_progress', 2);
						$status2 = $this->db->count_all_results();

						$this->db->from('form_request');
						$this->db->where('no_req_mdcr', $let_data_no_fi);
						$this->db->where('is_status_progress', 3);
						$status3 = $this->db->count_all_results();

						$this->db->from('form_request');
						$this->db->where('no_req_mdcr', $let_data_no_fi);
						$this->db->where('is_status_progress', 4);
						$status4 = $this->db->count_all_results();

						$this->db->from('form_request');
						$this->db->where('no_req_mdcr', $let_data_no_fi);
						$this->db->where('is_status_progress', 6);
						$status6 = $this->db->count_all_results();

						if ($total_all > 0 && $total_all == $status0) {
							// Semua 0 → header 4/0
							$this->db->where('no_req_mdcr', $let_data_no_fi)
									->update('hris_no_req_mdcr', [
										'is_status' => 4,
										'is_status_progress' => 0
									]);
						}
						else if ($total_all > 0 && $total_all == $status1) {
							// Semua 1 → header 1/1
							$this->db->where('no_req_mdcr', $let_data_no_fi)
									->update('hris_no_req_mdcr', [
										'is_status' => 1,
										'is_status_progress' => 1
									]);
						}
						else if ($total_all > 0 && $total_all == $status2) {
							// Semua 2 → header 1/2
							$this->db->where('no_req_mdcr', $let_data_no_fi)
									->update('hris_no_req_mdcr', [
										'is_status' => 1,
										'is_status_progress' => 2
									]);
						}
						else if ($total_all > 0 && $total_all == $status3) {
							// Semua 3 → header 1/3
							$this->db->where('no_req_mdcr', $let_data_no_fi)
									->update('hris_no_req_mdcr', [
										'is_status' => 1,
										'is_status_progress' => 3
									]);
						}
						else if ($total_all > 0 && $total_all == $status4) {
							// Semua 4 → header 1/4
							$this->db->where('no_req_mdcr', $let_data_no_fi)
									->update('hris_no_req_mdcr', [
										'is_status' => 1,
										'is_status_progress' => 4
									]);
						}
						else if ($total_all > 0 && $total_all == $status6) {
							// Semua DONE → header 3/6
							$this->db->where('no_req_mdcr', $let_data_no_fi)
									->update('hris_no_req_mdcr', [
										'is_status' => 3,
										'is_status_progress' => 6
									]);
						}
						else {
							// Partial / campuran → header 1/5
							$this->db->where('no_req_mdcr', $let_data_no_fi)
									->update('hris_no_req_mdcr', [
										'is_status' => 1,
										'is_status_progress' => 5
									]);
						}



			}

		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo "\u{274C} Matching FI Transaction FAILED";
		} else {
			$this->db->trans_commit();
			echo "\u{2705} Matching FI Transaction COMPLETED";
		}
	}


	public function sendEmailTMSummary()
	{
		$prevMonth = strtotime('-1 month');
		$year  = date('Y', $prevMonth);
		$month = date('m', $prevMonth);
		$action = encrypt('Leaving');

		try {

			$grouped = [];
			$data_all = [];

			/**
			 * ==========================================
			 * GET ALL EMPLOYEE
			 * ==========================================
			 */
			$this->db->select('nik');
			$this->db->from('v_hris_employee_updated');
			$this->db->where("action !=", $action);
			$this->db->where("division !=", encrypt('HR SUPPORT'));
			$this->db->where("division !=", encrypt('IT APPLICATION DIVISION'));
			// $this->db->where("division =", encrypt('INFORMATION TECHNOLOGY & SAP DIVISION'));
			// $this->db->where_not_in('nik', ['20130065','20050001','20189999','20228888']);
			$this->db->where_not_in('nik', ['20130065','20050001']);
			$this->db->order_by('directorate', 'ASC');
			$this->db->order_by('division', 'ASC');
			$this->db->order_by('department', 'ASC');
			$this->db->order_by('CAST(nik AS UNSIGNED)', 'ASC', FALSE);

			$result2 = $this->db->get()->result_array();

			/**
			 * ==========================================
			 * LOOP EMPLOYEE
			 * ==========================================
			 */
			foreach ($result2 as $res2) {

				$nik = $res2['nik'];

				/**
				 * ==========================================
				 * QUERY SUMMARY
				 * ==========================================
				 */
				$sql = "SELECT 
						SUM(CASE 
							WHEN a.attendance_status = 'on_time' 
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS telat_aman,

						SUM(CASE 
							WHEN a.attendance_status = 'late_in' 
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS telat,

						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code like 'C%'  THEN 1 ELSE 0 END) AS ijin,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code = 'S' THEN 1 ELSE 0 END) AS sakit,

						SUM(CASE 
							WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
							THEN 1 ELSE 0 
						END) AS hari_kerja_sch,

						SUM(
							CASE 
								-- full cuti tahunan
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'CUTI TAHUNAN'
									AND b.status IN (0,1)
								)
								THEN 1

								-- setengah hari
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'Cuti Tahunan Setengah Hari'
									AND b.status IN (0,1)
								)
								THEN 0.5

								-- normal hadir
								WHEN a.check_in IS NOT NULL 
								THEN 1

								ELSE 0 
							END
						) AS hari_kerja_act,
						SEC_TO_TIME(
							SUM(
								CASE 
									WHEN (a.schedule_code) LIKE 'N%' 
									OR (a.schedule_code) LIKE 'SHF%' 
									THEN GREATEST(
										TIMESTAMPDIFF(
											SECOND,
											a.schedule_in,
											a.schedule_out
										),
										0
									)
									ELSE 0
								END
							)
						) AS jam_kerja_sch,

						SEC_TO_TIME(
							SUM(
								TIME_TO_SEC(
									a.working_hours_t
								)
							)
						) AS jam_kerja_act,

						CAST(
						SUM(TIME_TO_SEC(a.working_hours_t)) * 100 /
						NULLIF(
							SUM(
								CASE
									WHEN a.schedule_code LIKE 'N%'
									OR a.schedule_code LIKE 'SHF%'
									THEN
										CASE
											WHEN a.schedule_out < a.schedule_in
											THEN TIMESTAMPDIFF(
													SECOND,
													a.schedule_in,
													DATE_ADD(a.schedule_out, INTERVAL 1 DAY)
												)
											ELSE TIMESTAMPDIFF(
													SECOND,
													a.schedule_in,
													a.schedule_out
												)
										END
									ELSE 0
								END
							),
							0
						)
					AS DECIMAL(5,2)) AS attendance_percentage,

						SUM(
							CASE 
								WHEN (
									a.attendence_code = 'H'
									AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
									AND a.check_out IS NOT NULL
									AND a.check_out < a.schedule_out
								)
								THEN 1
								ELSE 0
							END
						) AS pulang_cepat,

						c.nik,
						c.position,
						c.complete_name,

						c.usrid_long2,
						c.department,
						c.depthead_name,

						c.usrid_long3,
						c.division,
						c.divhead_name,

						c.usrid_long4,
						c.directorate,
						c.director_name

					FROM hris_master_time_management a

					INNER JOIN v_hris_employee_updated c
						ON a.employee_id = c.nik

					WHERE a.employee_id = ?
					AND c.action != ?
					AND a.date BETWEEN CONCAT(?, '-', ?, '-01')
					AND LAST_DAY(CONCAT(?, '-', ?, '-01'))";
				
				$query3 = $this->db->query(
					$sql,[$nik, $action, $year, $month, $year, $month]
				);

				// if ($nik == "20220094") {
				// 	dumper($this->db->last_query());
				// }

				$result3 = $query3->row_array();

				if (!$result3) {
					continue;
				}

				/**
				 * ==========================================
				 * CALCULATE
				 * ==========================================
				 */
				$actual   = $result3['jam_kerja_act'];
				$schedule = $result3['jam_kerja_sch'];

				$diff = $actual - $schedule;

				/**
				 * ==========================================
				 * EMPLOYEE ROW
				 * ==========================================
				 */
				$row = [

					'nik'                   => $result3['nik'],
					'complete_name'         => decrypt($result3['complete_name']),
					'directorate'            => decrypt($result3['directorate']),
					'division'              => decrypt($result3['division']),
					'department'            => decrypt($result3['department']),
					'position'              => decrypt($result3['position']),
					'late_in'               => $result3['telat'],
					'early_check_out'       => $result3['pulang_cepat'],
					'schedule_working_hour' => $result3['jam_kerja_sch'],
					'actual_working_hour'   => $result3['jam_kerja_act'],
					'diff'                  => $diff,
					'time_off'              => ($result3['ijin'] + $result3['sakit']),
					'attendance_percentage' => $result3['attendance_percentage'],
					'schedule_working_day'  => $result3['hari_kerja_sch'],
					'actual_working_day'    => $result3['hari_kerja_act']

				];

				$data_all[] = $row;

				/**
				 * ==========================================
				 * GROUP DEPARTMENT
				 * ==========================================
				 */
				if (!empty($result3['usrid_long2']) && ($result3['usrid_long2'] != '##8#####') && ($result3['usrid_long2'] != '0') && ($result3['usrid_long2'] != '')) {

					$head_email = decrypt($result3['usrid_long2']);
					$head_name  = decrypt($result3['depthead_name']);

					$group_key = 'DEPTHEAD|' . $head_email;

					if (!isset($grouped[$group_key])) {
						$grouped[$group_key] = [
							'scope'      => 'DEPT',
							'head_name'  => $head_name,
							'head_email' => $head_email,
							'departments'=> [],
							'employees'  => []
						];
					}

					$dept_name = decrypt($result3['department']);
					$grouped[$group_key]['departments'][$dept_name] = true;

					$grouped[$group_key]['employees'][] = $row;
				}

				/**
				 * ==========================================
				 * GROUP DIVISION
				 * ==========================================
				 */
				if (!empty($result3['usrid_long3']) && ($result3['usrid_long3'] != '##8#####') && ($result3['usrid_long3'] != '0') && ($result3['usrid_long3'] != '')) {

					$head_email = decrypt($result3['usrid_long3']);
					$head_name  = decrypt($result3['divhead_name']);

					$group_key = 'DIVHEAD|' . $head_email;

					if (!isset($grouped[$group_key])) {
						$grouped[$group_key] = [
							'scope'      => 'DIVISION',
							'head_name'  => $head_name,
							'head_email' => $head_email,
							'divisions'  => [],
							'employees'  => []
						];
					}

					$division_name = decrypt($result3['division']);
					$grouped[$group_key]['divisions'][$division_name] = true;

					$grouped[$group_key]['employees'][] = $row;
				}

				/**
				 * ==========================================
				 * GROUP DIRECTORAT
				 * ==========================================
				 */
				if (!empty($result3['usrid_long4']) && ($result3['usrid_long4'] != '##8#####') && ($result3['usrid_long4'] != '0') && ($result3['usrid_long4'] != '')) {

					$head_email = decrypt($result3['usrid_long4']);
					$head_name  = decrypt($result3['director_name']);

					$group_key = 'DIRHEAD|' . $head_email;

					if (!isset($grouped[$group_key])) {
						$grouped[$group_key] = [
							'scope'        => 'DIRECTORAT',
							'head_name'    => $head_name,
							'head_email'   => $head_email,
							'directorates' => [],
							'employees'    => []
						];
					}

					$directorate_name = decrypt($result3['directorate']);
					$grouped[$group_key]['directorates'][$directorate_name] = true;

					$grouped[$group_key]['employees'][] = $row;
				}
			}
			// dumper($grouped);
			// ================== SEND EMAIL ==================
			foreach ($grouped as $group) {

				$scope      = $group['scope'];
				$head_email = $group['head_email'];
				$head_name  = $group['head_name'];
				if($head_email == 'makmur@ibsmulti.com' || $head_email == 'MAKMUR@IBSMULTI.COM'){
					$head_email = 'ANANDHA.HOKKY@IBSMULTI.COM';
					$head_name 	= 'ANANDA HANDOKO HOKKY';
				}else{
					$head_email = $group['head_email'];
					$head_name  = $group['head_name'];
				}

				$rows 		= $group['employees'];

				$schedule_working_day  = $rows[0]['schedule_working_day'];
				$schedule_working_hour = $rows[0]['schedule_working_hour'];

				// build subject
				$subject = "IBSW - Summary Time Management ". get_bulan($month) ." $year";

				// optional list
				$org_list = implode(', ', array_keys(
					$group['departments'] 
					?? $group['divisions'] 
					?? $group['directorates'] 
					?? []
				));

				$data = [
					'org_list' 					=> $org_list,
					'head_name'    				=> $head_name,
					'data_summary' 				=> $rows,
					'year'						=> $year,
					'month'						=> $month,
					'subject'					=> "Summary Time Management ". get_bulan($month) ." $year",
					'schedule_working_day'		=> $schedule_working_day,
					'schedule_working_hour'		=> $schedule_working_hour
				];

				$html = $this->load->view(
					'services/email/summery_time_off',
					$data,
					TRUE
				);

				// dumper($data);

				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->Host       = 'mail.ibsmulti.com';
				$mail->SMTPAuth   = true;
				$mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
				$mail->Password   = '1214#$C1k1n1.2026';
				$mail->SMTPSecure = 'tls';
				$mail->Port       = 587;

				$mail->setFrom('no.reply@ibsmulti.com', 'Notification System'); // ubah dengan alamat email Anda

				// $link_host = "$_SERVER[HTTP_HOST]";
				// if($link_host != "172.19.8.84" && $link_host != "hris.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com")){
				// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
				// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
				// 	$mail->addBCC('palupi.utamo@ibsmulti.com');
				// 	$mail->addCC('gilang.cahyo@ibsmulti.com');
				// }else{
				// 	$mail->addAddress($head_email);
				// 	// $mail->addAddress('luffi.utomo@ibsmulti.com');
				// 	$mail->addBCC('ditha.damayanti@ibsmulti.com');
				// 	$mail->addBCC('luffi.utomo@ibsmulti.com');
				// 	$mail->addBCC('palupi.utamo@ibsmulti.com');
				// 	$mail->addBCC('gilang.cahyo@ibsmulti.com');
				// }

				if($this->status_apps == "development") {
					$prefix = 'DEV TEST - ';
					$subject = $prefix . $subject;
					$mail->addAddress('luffi.utomo@ibsmulti.com');
					$mail->addCC('ditha.damayanti@ibsmulti.com');
					$mail->addBCC('palupi.utamo@ibsmulti.com');
					$mail->addCC('gilang.cahyo@ibsmulti.com');
				} else if ($this->status_apps == "staging") {
					$prefix = 'STAGING TEST - ';
					$subject = $prefix . $subject;
					$mail->addAddress('luffi.utomo@ibsmulti.com');
					$mail->addCC('ditha.damayanti@ibsmulti.com');
					$mail->addBCC('palupi.utamo@ibsmulti.com');
					$mail->addCC('gilang.cahyo@ibsmulti.com');
				} else if ($this->status_apps == "production") {
					$mail->addAddress($head_email);
					$mail->addBCC('ditha.damayanti@ibsmulti.com');
					$mail->addBCC('luffi.utomo@ibsmulti.com');
					$mail->addBCC('palupi.utamo@ibsmulti.com');
					$mail->addBCC('gilang.cahyo@ibsmulti.com');
				}
				
				// Isi Email
				$mail->isHTML(true);
				// $mail->AddEmbeddedImage("./assets/images/logo_ibsw.png", "gmbr");
				$mail->Subject = $subject;
				$mail->Body    = $html;

				if (!$mail->send()) {
					log_message('error', $mail->ErrorInfo);
				}
			}

			// Update status
			// $date = date("Y-m-d");

			// $this->db->where('task_name LIKE', 'absen_minus_blast');
			// $this->db->where('date', $date);
			// $this->db->update('background_job_status', ['status' => 0]);

		} catch (Exception $e) {
			$this->db->trans_rollback();
			return ['error' => $e->getMessage()];
		}

		$this->db->trans_complete(); // COMMIT

		if ($this->db->trans_status() === FALSE) {
			return ['error' => 'Transaction failed'];
		}

		

	}

	function timeToSeconds($time)
	{
		$parts = explode(':', $time);

		$h = isset($parts[0]) ? (int)$parts[0] : 0;
		$m = isset($parts[1]) ? (int)$parts[1] : 0;
		$s = isset($parts[2]) ? (int)$parts[2] : 0;

		return ($h * 3600) + ($m * 60) + $s;
	}

	##### Generate Result Document
	function generate_result_document_PA($year = null)
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);

		if ($year == null) {
			$evaluation_period_start = date('Y') . '-01-01';
		} else {
			$evaluation_period_start = $year . '-01-01';
		}

		$performance_appraisal = $this->db
			->where('evaluation_period_start', $evaluation_period_start)
			->get('performance_appraisal')
			->result_array();


		foreach ($performance_appraisal as $pa) {

			$id = $pa['id'];

			$data = [];

			$data['logo'] = 'logo_ibsw.png';

			$data['header'] = $pa;

			$eval_year = date('Y', strtotime($pa['evaluation_period_start']));
			$data['eval_year'] = $eval_year;

			$form_request = $this->m_global
				->find('form_request', 'request_number', $pa['request_number'])
				->row_array();

			$id_form_request = $form_request['id'] ?? 0;

			$data['detail_kpi'] = $this->m_global
				->find('performance_appraisal_measurement', 'request_id', $id)
				->result_array();

			$data['training'] = $this->m_global
				->find('performance_appraisal_training', 'request_id', $id)
				->result_array();

			$data['additional'] = $this->m_global
				->find('performance_appraisal_plan', 'request_id', $id)
				->result_array();

			$data['approval'] = $this->m_global
				->find('form_approval', 'request_id', $id_form_request)
				->result_array();

			$data['count_approval'] = count($data['approval']);

			$data['employee'] = $this->db->query("
				SELECT 
					a.email,
					(
						SELECT complete_name 
						FROM v_hris_employee_updated 
						WHERE email = a.email 
						ORDER BY id_employee DESC 
						LIMIT 1
					) as complete_name,
					(
						SELECT nik 
						FROM v_hris_employee_updated 
						WHERE email = a.email 
						ORDER BY id_employee DESC 
						LIMIT 1
					) as nik,
					(
						SELECT position 
						FROM v_hris_employee_updated 
						WHERE email = a.email 
						ORDER BY id_employee DESC 
						LIMIT 1
					) as position,
					(
						SELECT join_date 
						FROM v_hris_employee_updated 
						WHERE email = a.email 
						ORDER BY id_employee DESC 
						LIMIT 1
					) as join_date,
					(
						SELECT employee_subgroup 
						FROM v_hris_employee_updated 
						WHERE email = a.email 
						ORDER BY id_employee DESC 
						LIMIT 1
					) as employee_subgroup,
					(
						SELECT division 
						FROM v_hris_employee_updated 
						WHERE email = a.email 
						ORDER BY id_employee DESC 
						LIMIT 1
					) as division,
					(
						SELECT personnel_area 
						FROM v_hris_employee_updated 
						WHERE email = a.email 
						ORDER BY id_employee DESC 
						LIMIT 1
					) as personnel_area
				FROM v_hris_employee_updated as a
				WHERE a.email = '".$pa['created_by']."'
				GROUP BY a.email
			")->row_array();

			// =========================
			// LOAD HTML VIEW
			// =========================
			// dumper($data);
			$html = $this->load->view('jobs/kpi_approved',$data,true);

			// =========================
			// TCPDF
			// =========================

			ob_start();

			// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf = new MyPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			// $ns = str_replace("/","","");
			$ns = str_replace(
				['/', ' '],
				['', '_'],
				decrypt($data['employee']['complete_name']) . '_' . $eval_year . '_' . $data['header']['request_number']
			);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('PT. Infrastruktur Bisnis Sejahtera');
			$pdf->SetTitle("HRIS PA AND PLAN-".$data['header']['request_number']);
			$pdf->SetSubject("HRIS PA AND PLAN".$data['header']['request_number']);
			$pdf->SetKeywords('HRIS PA AND PLAN,IBS');

			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(true);

			$pdf->SetMargins(10, 10, 10);
			$pdf->SetAutoPageBreak(TRUE, 10);

			$pdf->SetFont('times', '', 8);

			$pdf->AddPage('P', 'A4');

			$pdf->writeHTML($html, true, false, true, false, '');

			// =========================
			// SAVE PDF
			// =========================

			$folder = FCPATH . 'papp_documents/' . $pa['request_number'] . '/';

			if (!is_dir($folder)) {
				mkdir($folder, 0777, true);
			}

			$ns = str_replace(
				['/', ' '],
				['', '_'],
				decrypt($data['employee']['complete_name']) . '_' . $eval_year . '_' . $data['header']['request_number']
			);

			$filename = $ns . '.pdf';

			$path = $folder . $filename;

			$pdf->Output($path, 'F');

			// cleanup memory
			$pdf->Close();
			unset($pdf);
		}

		echo "Generate PDF selesai";
	}

}

class MyPDF extends TCPDF {

    public function Footer() {

        // posisi footer
        $this->SetY(-15);

        // font
        $this->SetFont('times', '', 8);

        // garis atas footer (optional)
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        // footer kiri
        $this->Cell(
            0,
            10,
            'Human Resources Information System - PT. Infrastruktur Bisnis Sejahtera',
            0,
            0,
            'L'
        );

        // footer kanan - nomor halaman
        $this->Cell(
            0,
            10,
            'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(),
            0,
            0,
            'R'
        );
    }
}



////////////////////////////////////////////////////////////////////////////////////
////////////////Konsep jika status 3 langsung menjadi status 6 /////////////////////
////////////////////////////////////////////////////////////////////////////////////

// public function matching_fi_transaction()
//     {
//         $this->db->trans_begin();

//         $total_proc = 0;
//         $total_paid = 0;

//         $sql = "SELECT * FROM hris_no_req_mdcr WHERE is_status_progress != 6";
//         $query = $this->db->query($sql);

//         foreach ($query->result() as $row) {

//             $no_req_mdcr = $row->no_req_mdcr;
//             $data_no_fi = $no_req_mdcr;

//             $sql_fr = "
//                 SELECT *
//                 FROM form_request
//                 WHERE no_req_mdcr = ? AND is_status_progress >= 3
//             ";
//             $query_fr = $this->db->query($sql_fr, [$no_req_mdcr]);

//             foreach ($query_fr->result() as $row_fr) {

//                 $request_id              = $row_fr->id;
//                 $personnel_number_fr     = $row_fr->employee_id;
//                 $let_personnel_number_fr = $personnel_number_fr;
//                 $cek_data_no_fi          = $row_fr->no_req_mdcr;
//                 $let_data_no_fi          = $cek_data_no_fi;

//                 $sql_dft = "
//                     SELECT *
//                     FROM data_fi_transaction
//                     WHERE TRIM(assignment) = TRIM(?) 
//                     AND TRIM(personnel_number) = TRIM(?)";
//                 $query_dft = $this->db->query($sql_dft, [
//                     $cek_data_no_fi,
//                     $personnel_number_fr
//                 ]);

//                 // ======================================================
//                 // === PERUBAHAN 1: HANDLE JIKA FI TIDAK ADA
//                 // ======================================================
//                 if ($query_dft->num_rows() == 0) {

//                     $sql_cek_fr = "
//                         SELECT is_status_progress
//                         FROM form_request
//                         WHERE no_req_mdcr = TRIM(?)
//                         AND form_type = 'MDCR'
//                         AND is_status_progress <= 3
//                         LIMIT 1
//                     ";

//                     $query_cek_fr = $this->db->query($sql_cek_fr, [$cek_data_no_fi]);
//                     $cek_row = $query_cek_fr->row(); // ambil satu row saja

//                     $get_is_status_progress = $cek_row ? $cek_row->is_status_progress : $cek_row->is_status_progress;

//                     $this->db->where('no_req_mdcr', $cek_data_no_fi)
//                         ->update('hris_no_req_mdcr', [
//                             'is_status' => 1,
//                             'is_status_progress' => $get_is_status_progress
//                         ]);

//                     continue;
//                 }

//                 foreach ($query_dft->result() as $row_dft) {

//                     $payment_doc_dft = $row_dft->payment_doc;

//                     // ======================================================
//                     // CASE 1 — payment_doc kosong
//                     // ======================================================
//                     if ($payment_doc_dft === NULL || trim($payment_doc_dft) === '') {

//                         $this->db->query("
//                             UPDATE form_request 
//                             SET is_status_progress = 4
//                             WHERE id = ?
//                             AND is_status_progress != 4
//                         ", [$request_id]);

//                         if ($this->db->affected_rows() > 0) {

//                             $this->db->query("
//                                 UPDATE form_approval 
//                                 SET approval_status = 'Approved', 
//                                     updated_at = NOW(), 
//                                     updated_by = 'ap.ibsw@ibsmulti.com'
//                                 WHERE request_id = ? 
//                                 AND approval_email LIKE 'ap.ibsw@ibsmulti.com'
//                             ", [$request_id]);

//                             $this->db->where('request_id', $request_id);
//                             $this->db->like('approval_email', 'treasury.ibsw@ibsmulti.com');
//                             $this->db->update('form_approval', [
//                                 'approval_status' => 'In Progress'
//                             ]);

//                             $total_proc++;
//                         }

//                         continue;
//                     }

//                     // ======================================================
//                     // CASE 2 — payment_doc SUDAH ADA (Bypass Hirarki AP)
//                     // ======================================================
                    
//                     // PERUBAHAN: Hilangkan 'AND is_status_progress = 4' agar record status >= 3 bisa langsung diproses ke 6
//                     $this->db->query("
//                         UPDATE form_request 
//                         SET is_status = 3,
//                             is_status_progress = 6,
//                             updated_by = 'treasury.ibsw@ibsmulti.com',
//                             updated_at = NOW()
//                         WHERE id = ?
//                         AND is_status_progress IN (3, 4)
//                     ", [$request_id]);

//                     if ($this->db->affected_rows() > 0) {

//                         $res_number = $this->db
//                                 ->where('id', $request_id)
//                                 ->limit(1)
//                                 ->get('form_request')
//                                 ->row();

//                         $email  = $res_number->created_by;
//                         $id     = $res_number->id;
//                         $nik    = $res_number->employee_id;

//                         // Kirim email notifikasi sukses bayar
//                         $this->sendEmail('request_approve_mdcr',$id, $email, $nik);

//                         // PERUBAHAN: Set status AP langsung menjadi 'Approved' tanpa peduli kondisi sebelumnya
//                         $this->db->query("
//                             UPDATE form_approval 
//                             SET approval_status = 'Approved', 
//                                 updated_at = NOW(), 
//                                 updated_by = 'ap.ibsw@ibsmulti.com'
//                             WHERE request_id = ? 
//                             AND approval_email LIKE 'ap.ibsw@ibsmulti.com'
//                             AND approval_status != 'Approved'
//                         ", [$request_id]);

//                         // PERUBAHAN: Set status Treasury langsung menjadi 'Approved'
//                         $this->db->query("
//                             UPDATE form_approval 
//                             SET approval_status = 'Approved', 
//                                 updated_at = NOW(), 
//                                 updated_by = 'treasury.ibsw@ibsmulti.com'
//                             WHERE request_id = ? 
//                             AND approval_email LIKE 'treasury.ibsw@ibsmulti.com'
//                         ", [$request_id]);

//                         $total_paid++;

//                         continue;
//                     }
//                 }

//                 // ====================================================
//                 // HEADER UPDATE
//                 // ====================================================

//                 // Hitung total semua form_request
//                 $this->db->from('form_request');
//                 $this->db->where('no_req_mdcr', $let_data_no_fi);
//                 $total_all = $this->db->count_all_results();

//                 // Hitung jumlah detail per progress
//                 $this->db->from('form_request');
//                 $this->db->where('no_req_mdcr', $let_data_no_fi);
//                 $this->db->where('is_status_progress', 0);
//                 $status0 = $this->db->count_all_results();

//                 $this->db->from('form_request');
//                 $this->db->where('no_req_mdcr', $let_data_no_fi);
//                 $this->db->where('is_status_progress', 1);
//                 $status1 = $this->db->count_all_results();

//                 $this->db->from('form_request');
//                 $this->db->where('no_req_mdcr', $let_data_no_fi);
//                 $this->db->where('is_status_progress', 2);
//                 $status2 = $this->db->count_all_results();

//                 $this->db->from('form_request');
//                 $this->db->where('no_req_mdcr', $let_data_no_fi);
//                 $this->db->where('is_status_progress', 3);
//                 $status3 = $this->db->count_all_results();

//                 $this->db->from('form_request');
//                 $this->db->where('no_req_mdcr', $let_data_no_fi);
//                 $this->db->where('is_status_progress', 4);
//                 $status4 = $this->db->count_all_results();

//                 $this->db->from('form_request');
//                 $this->db->where('no_req_mdcr', $let_data_no_fi);
//                 $this->db->where('is_status_progress', 6);
//                 $status6 = $this->db->count_all_results();

//                 if ($total_all > 0 && $total_all == $status0) {
//                     $this->db->where('no_req_mdcr', $let_data_no_fi)
//                             ->update('hris_no_req_mdcr', [
//                                 'is_status' => 4,
//                                 'is_status_progress' => 0
//                             ]);
//                 }
//                 else if ($total_all > 0 && $total_all == $status1) {
//                     $this->db->where('no_req_mdcr', $let_data_no_fi)
//                             ->update('hris_no_req_mdcr', [
//                                 'is_status' => 1,
//                                 'is_status_progress' => 1
//                             ]);
//                 }
//                 else if ($total_all > 0 && $total_all == $status2) {
//                     $this->db->where('no_req_mdcr', $let_data_no_fi)
//                             ->update('hris_no_req_mdcr', [
//                                 'is_status' => 1,
//                                 'is_status_progress' => 2
//                             ]);
//                 }
//                 else if ($total_all > 0 && $total_all == $status3) {
//                     $this->db->where('no_req_mdcr', $let_data_no_fi)
//                             ->update('hris_no_req_mdcr', [
//                                 'is_status' => 1,
//                                 'is_status_progress' => 3
//                             ]);
//                 }
//                 else if ($total_all > 0 && $total_all == $status4) {
//                     $this->db->where('no_req_mdcr', $let_data_no_fi)
//                             ->update('hris_no_req_mdcr', [
//                                 'is_status' => 1,
//                                 'is_status_progress' => 4
//                             ]);
//                 }
//                 else if ($total_all > 0 && $total_all == $status6) {
//                     $this->db->where('no_req_mdcr', $let_data_no_fi)
//                             ->update('hris_no_req_mdcr', [
//                                 'is_status' => 3,
//                                 'is_status_progress' => 6
//                             ]);
//                 }
//                 else {
//                     $this->db->where('no_req_mdcr', $let_data_no_fi)
//                             ->update('hris_no_req_mdcr', [
//                                 'is_status' => 1,
//                                 'is_status_progress' => 5
//                             ]);
//                 }
//             }
//         }

//         if ($this->db->trans_status() === FALSE) {
//             $this->db->trans_rollback();
//             echo "❌ Matching FI Transaction FAILED";
//         } else {
//             $this->db->trans_commit();
//             echo "✅ Matching FI Transaction COMPLETED";
//         }
//     }