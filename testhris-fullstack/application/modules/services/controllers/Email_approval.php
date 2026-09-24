<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_approval extends Admin_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
		$this->load->library('curl');
		$this->load->library('enc');
		// $this->enc->check_session();

		$this->load->helper('general');
		$this->load->model('inbox/inbox_model');
		$this->load->model('home/home_model');
		$this->load->model('m_global');
		$this->load->model('form/form_model');
		$this->load->model('m_services');

		$this->status_apps = $_ENV['CI_ENVIRONMENT'];
		
	}

    public function detail_approval($formType, $id, $nik_approver){

		// $request_id = decode_url($id);
		$ambil 		= str_split($id,7);
		$ambil 		= str_split($ambil[1],4);
		$request_id = $ambil[0];
		$nik_approver = decrypt($nik_approver);
		$this->db->where('request_id',$request_id);
		$this->db->where('approval_employee_id',$nik_approver);
		$this->db->where('approval_status','In Progress');
		$query = $this->db->get('form_approval')->row_array();
		
		$data['email_approver'] = $query['approval_email'];
		$data['nik_approver'] = $nik_approver;

		if (!empty($query)){
				$data['request_id'] = $request_id;
				$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
				$header = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
				$detail = $this->m_global->getRow('detail_table', 'form_type', array('code' => $formType));
				$data['header'] = $this->m_global->find($header, 'request_id', $request_id)->row_array();
				$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
				$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
				$data['count_approval'] = count($this->inbox_model->getApprovalList());
				$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
				$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
				$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
				$data['count_review'] = count($this->inbox_model->getReviewList());
				$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
				$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();

				switch ($formType) {

					case 'MDCR':
						
						$additional = $this->m_global->getRow('additional_table', 'form_type', array('code' => $formType));
						$data['detail'] = $this->m_global->find($detail, 'request_id', $request_id)->result_array();
						$employee_id = $data['header']['employee_id'];
						//dumper($data['detail']);
						$id_eg_prj = $data['header']['id_eg_prj'];
						$id_eg_pri = $data['header']['id_eg_pri'];
						$id_eg_pk  = $data['header']['id_eg_pk'];
						$request_created_at = $data['form_request']['created_at'];
						
						$data['approval_priority'] = $this->form_model->get_approval_priority($request_id, 'hendry.tjoa@ibstower.com');
						// dumper($data['approval_priority']);
						$data['sum_penggantian_jalan'] = $this->form_model->get_sum_penggantian_jalan($request_id);
						$data['sum_penggantian_inap'] = $this->form_model->get_sum_penggantian_inap($request_id);
						$data['sum_penggantian_kacamata'] = $this->form_model->get_sum_penggantian_kacamata($request_id);
						$data['reimaning_pagu'] = $this->form_model->get_reimaning_pagu($request_created_at, $employee_id, $id_eg_prj, $id_eg_pri, $id_eg_pk);
						$data['additional'] = $this->m_global->find($additional, 'request_id', $request_id)->result_array();
						
						// $this->load->view('services/email/request_approve_mdcr', $data);
						$this->load->view('services/email_approve/email_approval_MDCR', $data);

						break;
				}

		}else{
			// $this->load->view('templates/404');
			$this->load->view('templates/success');
		}
	}


	public function cekNote(){
		$request_id		= $_POST['id'];
		$email_approver = $_POST['email_approver'];
		$data 			= $this->m_services->cekNote($request_id, $email_approver);
		echo json_encode($data);
	}

	public function responseRequest(){

		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		$request_id = $this->input->post('id');
		
		$sql = "select id from form_request where id='$request_id' and is_status_admin_hr='1'";
		$query = $this->db->query($sql);
		$res = $query->result();
		$request_id_form 	= (!empty(($res[0]->id))) ? ($res[0]->id) : 0;
		//dumper($request_id_form);
		if($request_id_form == 0){
			//dumper('Test1');
			// TIME MANAGEMENT
			$form_type = $this->m_global->find('form_request', 'id', $request_id)->row_array()['form_type'];
			$status = $this->m_global->find('form_request', 'id', $request_id)->row_array()['is_status'];
			if ($form_type == 'TM' AND $status == 3){
				$sql = "select id from form_approval where request_id='$request_id' and approval_status='Approved'";
			} elseif ($form_type == 'MDCR' AND $status == 2){
				$sql = "select id from form_approval where request_id='$request_id' and approval_status='Revised'";
			} else {
				$sql = "select id from form_approval where request_id='$request_id' and approval_status='In Progress'";
			}
			// ///////////////
			
			$query = $this->db->query($sql);
			$res = $query->result();
			$approval_id = $res[0]->id;
		}else{
			//dumper('Test2');
			$sql = "select id from form_approval where request_id='$request_id' and approval_email='hr.support@ibstower.com' and (approval_status='Approved' or approval_status='In Progress')";
			$query = $this->db->query($sql);
			$res = $query->result();
			$approval_id = $res[0]->id;
		}
		$response = $this->input->post('resp');

		// previous layer
		$priority = $this->m_global->find('form_approval', 'id', $approval_id)->row_array()['approval_priority'];
		$prev_priority = $priority-1;
		$prev_id = $this->m_services->find_select("id",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

		$prev_email = $this->m_services->find_select("approval_email",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

		$data_prev_layer = array(
			'approval_status' => 'In Progress', 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		//GET FORM TYPE
		$sqlForm = "SELECT form_type FROM form_request WHERE id = '$request_id'";
		$queryForm = $this->db->query($sqlForm);
		$resForm = $queryForm->result();
		$tipe_form = $resForm[0]->form_type;

		switch ($response) {

			case 'Revised':

				if ($priority != 1) {

					if($request_id_form == 0){
						
						$current_layer = array(
							'approval_status' => 'Revised', 
							'updated_at' => $this->date, 
							'updated_by' => $this->email
						);

						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $current_layer)) {
							$this->db->where('id', $request_id);
							if($this->db->update('form_request', array('is_status' => 2, 'is_status_admin_hr' => 0, 'updated_by' => $this->email, 'updated_at' => $this->date))){
								$this->db->where('request_id', $request_id);
								$this->db->update('hris_medical_reimbursment', array('is_status' => 2));

								$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
								$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
								$this->sendEmail('revised_mdcr', $request_id, decrypt($data['data_employee']->email));

								$this->logs('revised', 'MDCR', $request_id, 'Response revised', 'Success');
								$output = array('status' => 1);
							}
						}

					}else{
						$current_layer = array(
							'approval_status' => 'Revised', 
							'updated_at' => $this->date, 
							'updated_by' => $this->email
						);

						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $current_layer)) {
							
							$data_revise_layer = array(
								'is_status_admin_hr' => 0, 
								'is_status' => 2, 
								'updated_at' => $this->date, 
								'updated_by' => $this->email
							);
							$this->db->where('id', $request_id);
							if ($this->db->update('form_request', $data_revise_layer)) {
								$this->db->where('request_id', $request_id);
								$this->db->update('hris_medical_reimbursment', array('is_status' => 2));

								$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
								$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
								$this->sendEmail('revised_mdcr', $request_id, decrypt($data['data_employee']->email));

								$this->logs('revised', 'MDCR', $request_id, 'Response revised', 'Success');
								$output = array('status' => 1);
							}
							
						}
					}

				} else {

						if($request_id_form != 0){

							$data_revise_layer = array(
								'is_status_admin_hr' => 0, 
								'is_status' => 2, 
								'updated_at' => $this->date, 
								'updated_by' => $this->email
							);
							$this->db->where('id', $request_id);
							$this->db->update('form_request', $data_revise_layer);
						}

						$revise_layer = array(
							'approval_status' => 'Revised', 
							'updated_at' => $this->date, 
							'updated_by' => $this->email
						);

						$this->db->where('id', $request_id);
						if ($this->db->update('form_request', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

							$this->db->where('request_id', $request_id);
							$this->db->update('hris_medical_reimbursment', array('is_status' => 2));

							$data['form_request'] = $this->m_global->find('id', $request_id, 'form_request')->row_array();
							$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
							$this->sendEmail('revised_mdcr', $request_id, decrypt($data['data_employee']->email));

							$this->db->where('id', $approval_id);
							if ($this->db->update('form_approval', $revise_layer)) {
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

						
						////// TIME MANAGEMENT - TIME OFF//////////////////

						if($tipe_form == 'TM'){
							$sqlUpdate = "UPDATE hris_request_time_off SET status=2 where request_id = '$request_id'";
							$queryUpdate = $this->db->query($sqlUpdate);

							$sqlGetDate = "SELECT a.nik, a.start_date, a.end_date FROM hris_request_time_off a
											LEFT JOIN hris_master_time_off b ON a.jenis = b.nama WHERE request_id = '$request_id'";
							$queryGetDate = $this->db->query($sqlGetDate);
							$resultGetDate = $queryGetDate->result_array();
							if(!empty($resultGetDate)){
								$nik = $resultGetDate[0]['nik'];
								$start_date = $resultGetDate[0]['start_date'];
								$end_date = $resultGetDate[0]['end_date'];

								$this->db->select('*');
								$this->db->from('hris_master_time_management');
								$this->db->where('employee_id', $nik);
								$this->db->where('date', $start_date);
								$get_attendance = $this->db->get()->result_array();
								$check_in = $get_attendance[0]['check_in'];
								$check_out = $get_attendance[0]['check_out'];

								if (!empty($check_in)){
									$attendance_code = 'H';
									$flag = 1;
								} else {
									if (empty($check_out)){
										$attendance_code = 'CTAB';
									} else {
										$attendance_code = '';
									}
									$flag = 0;
								}

								$sqlUpdateMTM = "UPDATE hris_master_time_management SET attendence_code='$attendance_code', time_off_code=NULL, flag=$flag
												WHERE employee_id='$nik' AND (date BETWEEN '$start_date' AND '$end_date')";
								$queryUpdateMTM = $this->db->query($sqlUpdateMTM);
							}

							$sqlReqNo = "SELECT request_number FROM hris_request_time_off where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
							$queryReqNo = $this->db->query($sqlReqNo);
							$resultReqNo = $queryReqNo->result_array();
							$req_no = $resultReqNo[0]['request_number'];

							$sqlChangeLog = "SELECT * FROM hris_time_management_employee where request_number = '$req_no' ORDER BY id DESC LIMIT 1";
							$queryChangeLog = $this->db->query($sqlChangeLog);
							$resultChangeLog = $queryChangeLog->result_array();

							$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
							$queryTotal = $this->db->query($sqlTotal);
							$resultTotal = $queryTotal->result_array();

							$nik = $resultChangeLog[0]['nik'];
							$start_date = $resultChangeLog[0]['start_date'];
							if ($resultChangeLog[0]['status'] == 5 && $resultChangeLog[0]['tipe_perubahan'] == 'Request Attendance'){
								$sqlApprovedData = "SELECT * FROM hris_time_management_employee where nik='$nik' AND tipe_perubahan LIKE 'Approved%' 
													AND start_date= '$start_date' ORDER BY id DESC LIMIT 1";
								$queryApprovedData = $this->db->query($sqlApprovedData);
								$resultApprovedData = $queryApprovedData->result_array();

								$newTotal = $resultTotal[0]['total_cuti'] - $resultApprovedData[0]['change_log'];
								$today = date("Y-m-d");
								$change = abs($resultApprovedData[0]['change_log']);
							} else {
								$newTotal = $resultTotal[0]['total_cuti'] - $resultChangeLog[0]['change_log'];
								$today = date("Y-m-d");
								$change = abs($resultChangeLog[0]['change_log']);
							}
							if($newTotal < -6){
								$flagTME = 1;
							} else {
								$flagTME = 0;
							}
							if($newTotal >= 0){
								$flagMinus = 0;
							} else {
								$flagMinus = 1;
							}
							
							$formDataEmployee = array(
								'nik' => $resultChangeLog[0]['nik'],
								'date' => $today,
								'tipe_perubahan' => "Reject - " . $resultChangeLog[0]['tipe_perubahan'],
								'start_date' => $resultChangeLog[0]['start_date'],
								'end_date' => $resultChangeLog[0]['end_date'],
								'total_cuti' => $newTotal,
								'change_log' => $change,
								'request_number' => "-",
								'status' => 3,
								'flag' => $flagTME,
								'minus' => $flagMinus
							);
							$this->db->insert("hris_time_management_employee", $formDataEmployee);
							$queryEmployee = $this->db->insert_id();

							$lastId = $resultChangeLog[0]['id'];
							$sqldel = "UPDATE hris_time_management_employee SET status=5, update_date='$today', flag=0 where id = '$lastId'";
							$querydel = $this->db->query($sqldel);

							$this->sendEmail('rejected_time_off', $request_id, '');

							$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1);
							/////////////END TIME MANAGEMENT////////////////////
						}elseif($tipe_form == 'MDCR'){

							$this->db->where('request_id', $request_id);
							$this->db->update('hris_medical_reimbursment', array('is_status' => 4));
							
							$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
							$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
							$this->sendEmail('rejected_mdcr', $request_id, decrypt($data['data_employee']->email));
							
							//$this->sendEmail('revise', $request_id, $prev_email['approval_email']);
							$this->logs('reject', 'MDCR', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1);
						}
					}
				break;

			case 'Approved':
				
					#check current approver list
					$sql = "SELECT * FROM form_approval WHERE id = '$approval_id' AND request_id = '$request_id'";
					$checkleftcurrent = $this->db->query($sql);

					if($tipe_form!='TM' && ($checkleftcurrent->row_array()['approval_email'] != 'hr.support@ibstower.com') and ($checkleftcurrent->row_array()['approval_priority'] != 3)){
						$this->sendEmail('approved_spv_mdcr', $request_id, $checkleftcurrent->row_array()['approval_email'], $checkleftcurrent->row_array()['approval_employee_id']);
					}

					#check approver list
					$sql = "SELECT * FROM form_approval WHERE id >= '$approval_id' AND request_id = '$request_id' ORDER BY approval_priority ASC OFFSET 1 ROWS FETCH NEXT 1 ROWS ONLY";
					$checkleft = $this->db->query($sql);

					////////TIME MANAGEMENT//////
					$resultAppr = $checkleft->result_array();
					if (!empty($resultAppr)){
						$resultCurrent = $checkleftcurrent->result_array();
						$priority_tm = $resultCurrent[0]['approval_priority'];

						if ($tipe_form == 'TM' && $priority_tm == 2){
							$skip = 1;
						} else {
							$skip = 0;
						}
					} else {
						$skip = 0;
					}
					///////TM///////

					//////Menambahkan $skip != 1 untuk form type TM
					if ($checkleft->num_rows() > 0 && $skip != 1) {
						
						$current_approval = array(
							'approval_status' => 'Approved', 
							'updated_at' => $this->date, 
							'updated_by' => $this->email
						);

						#update response approval
						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $current_approval)) {

							// TIME MANAGEMENT
							if($tipe_form == 'TM'){
								$sqlReqNo = "SELECT request_number FROM hris_request_time_off where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
								$queryReqNo = $this->db->query($sqlReqNo);
								$resultReqNo = $queryReqNo->result_array();
								$req_no = $resultReqNo[0]['request_number'];

								$config['cacheable']    = true;
								$config['cachedir']     = './assets/';
								$config['errorlog']     = './assets/';
								$config['imagedir']     = './assets/images/qrcode_tm/';
								$config['quality']      = true;
								$config['size']         = '1024';
								$config['black']        = array(224,255,255);
								$config['white']        = array(70,130,180);
								$this->ciqrcode->initialize($config);
								$image_name= 'appr-'.$req_no.'-'.$this->emp_id.'.png';
								$params['data'] = $req_no.'-'.$this->emp_id;
								$params['level'] = 'H'; //H=High
								$params['size'] = 10;
								$params['savename'] = FCPATH.$config['imagedir'].$image_name;
								$this->ciqrcode->generate($params);

								if($priority_tm == 1){
									$this->db->where('request_id', $request_id);
									$this->db->where('approval_priority', 2);
									$this->db->update('form_approval', array('approval_status' => 'In Progress'));
								}

								$this->sendEmail('approved_time_off', $request_id, $this->email);
								$this->sendEmail('req_to_hr', $request_id, '');
							}

							#set in progress for next approver
							$this->db->where('id', $checkleft->row_array()['id']);
							
							if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {

								$this->logs('approved', $request_id, 'Approved successfully');
								$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating the next approver.');
								$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.');
							}

						} else {
							$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval.');
							$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating response approval. ');
						}

					} else {	

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

								// TIME MANAGEMENT - TIME OFF///
								if($tipe_form == 'TM'){
									if($priority_tm == 2){
										$this->db->where('request_id', $request_id);
										$this->db->where('approval_priority', 2);
										$this->db->update('form_approval', $approval);
									}

									$sqlUpdate = "UPDATE hris_request_time_off SET status=1 where request_id = '$request_id'";
									$queryUpdate = $this->db->query($sqlUpdate);

									$sqlGetDate = "SELECT b.kode, a.nik, a.jenis, a.start_date, a.end_date, a.request_number FROM hris_request_time_off a
												   LEFT JOIN hris_master_time_off b ON a.jenis = b.nama WHERE request_id = '$request_id'";
									$queryGetDate = $this->db->query($sqlGetDate);
									$resultGetDate = $queryGetDate->result_array();
									$nik = $resultGetDate[0]['nik'];
									if ($resultGetDate[0]['jenis'] == 'Cuti Tahunan Setengah Hari'){
										$kode = 'CT';
									} else {
										$kode = $resultGetDate[0]['kode'];
									}
									$start_date = $resultGetDate[0]['start_date'];
									$end_date = $resultGetDate[0]['end_date'];
									$req_no = $resultGetDate[0]['request_number'];

									if ($kode == 'PPD' || $kode == 'DDK'){
										$flag = 0;
										$attendance = '';
									} else {
										$flag = 1;
										$attendance = ", attendence_code=''";
									}

									$sqlUpdateMTM = "UPDATE hris_master_time_management SET time_off_code='$kode', flag=$flag
													". $attendance ."WHERE employee_id='$nik' AND (date BETWEEN '$start_date' AND '$end_date')";
									$queryUpdateMTM = $this->db->query($sqlUpdateMTM);
									
									$today = date('Y-m-d');
									$sqlUpdateTME = "UPDATE hris_time_management_employee SET status=6, update_date='$today' WHERE request_number = '$req_no'";
									$queryUpdateTME = $this->db->query($sqlUpdateTME);

									$sqlTopTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
									$queryTopTotal = $this->db->query($sqlTopTotal);
									$resultTopTotal = $queryTopTotal->result_array();
									$topTotal = $resultTopTotal[0]['total_cuti'];

									$sqlCTAB = "SELECT nama FROM hris_master_time_off WHERE kode = 'CTAB'";
									$queryCTAB = $this->db->query($sqlCTAB);
									$resultCTAB = $queryCTAB->result_array();
									$ctab = $resultCTAB[0]['nama'];

									$totalAbsent = 0;
									$sqlChangeLog = "SELECT status, change_log FROM hris_time_management_employee WHERE tipe_perubahan = '$ctab'
														AND nik='$nik' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC";
									$queryChangeLog = $this->db->query($sqlChangeLog);
									$resultChangeLog = $queryChangeLog->result_array();
									if(!empty($resultChangeLog)){
										if ($resultChangeLog[0]['status'] == 1){
											if ($kode != 'PPD' && $kode != 'DDK' && $kode != 'IDT'){
												foreach($resultChangeLog as $value){
													$totalAbsent += $value['change_log'];
												}
												$change = abs($totalAbsent);

												$sqlUpdateTME2 = "UPDATE hris_time_management_employee SET status=0, update_date='$today', flag=0 
														WHERE nik='$nik' AND tipe_perubahan = '$ctab' AND date BETWEEN '$start_date' AND '$end_date'";
												$queryUpdateTME2 = $this->db->query($sqlUpdateTME2);
											} else {
												$change = 0;
											}
											
										} else {
											$change = 0;
										}
									} else {
										$change = 0;
									}

									if ($resultGetDate[0]['jenis'] == 'Request Attendance'){
										
										$this->db->select('waktu_masuk, waktu_keluar');
										$this->db->from('hris_request_time_off');
										$this->db->where('nik', $nik);
										$this->db->where('request_id', $request_id);
										$resGetTime = $this->db->get()->result_array();
										$clocked_in = $resGetTime[0]['waktu_masuk'];
										$clocked_out = $resGetTime[0]['waktu_keluar'];
										if (!empty($clocked_in)){
											$sentence = ", check_in='$clocked_in'";
										} else {
											$sentence = "";
										}

										$sqlUpdMTM = "UPDATE hris_master_time_management SET attendence_code='HCTAB', flag=1, check_out='$clocked_out'"
													  . $sentence ." WHERE employee_id='$nik' AND (date BETWEEN '$start_date' AND '$end_date')";
										$queryUpdMTM = $this->db->query($sqlUpdMTM);
									}

									$totalChange = $topTotal + $change;
									if($totalChange < -6){
										$flagTME = 1;
									} else {
										$flagTME = 0;
									}
									if($totalChange >= 0){
										$flagMinus = 0;
									} else {
										$flagMinus = 1;
									}

									$formDataEmployee = array(
										'nik' => $nik,
										'date' => $today,
										'tipe_perubahan' => 'Approved - ' . $resultGetDate[0]['jenis'],
										'start_date' => $start_date,
										'end_date' => $end_date,
										'total_cuti' => $totalChange,
										'change_log' => $change,
										'request_number' => '-',
										'status' => 3,
										'flag' => $flagTME,
										'minus' => $flagMinus
									);
									$this->db->insert("hris_time_management_employee", $formDataEmployee);

									// $sqlUpdateTME2 = "UPDATE hris_time_management_employee SET status=0, update_date='$today', flag=0 
									// 			  WHERE nik='$nik' AND tipe_perubahan = '$ctab' AND date BETWEEN '$start_date' AND '$end_date'";
									// $queryUpdateTME2 = $this->db->query($sqlUpdateTME2);

									$this->sendEmail('approved_time_off', $request_id, '');
									if($resultGetDate[0]['jenis'] != 'Request Attendance'){
										$this->sendEmail('info_time_off', $request_id, '');
									}
									
								}
								//END TIME MANAGEMENT - TIME OFF///

								//$this->sendEmail('approved_eapp', $request_id, $requestor);
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
	
					break;
			
			default:
				break;
		}
		//dumper($output);
		echo json_encode($output);
	}

	public function responseRequestFromAdminHR(){
		$request_id = $this->input->post('id');
		$response = $this->input->post('resp');

		$respone = $this->form_model->responseRequestFromAdminHR($request_id, $response);
		if($respone == true){
			$this->sendEmail('checked_mdcr_hr', $request_id, '');
			echo json_encode($respone);
		}else{
			echo json_encode($respone);
		}
		
	}

	public function read($table,$id)
	{
		$request_id = $id;
		switch ($table) {

			case 'ToR':

				$listToR = $this->form_model->getTypeOfRembursement($request_id);
				//dumper($listToR);
		        if (!empty($listToR)) {
		            foreach ($listToR as $key) {
						if ($key->is_status == 1 || $key->is_status == 3 || $key->is_status == 4) {
							$show = 'none';
						} else {
							$show = '';
						}
						if ( ($key->additional == 'Diri Sendiri') ){
							$additional = $key->additional;
						}else{
							$additional = decrypt($key->additional);
						}
						if (($key->harga_kamar == 'NaN') || (empty($key->harga_kamar)) || ($key->harga_kamar == '') || ($key->harga_kamar == ' ') || ($key->harga_kamar == NULL)){
							$harga_kamar = 0;
						}else{
							$harga_kamar = $key->harga_kamar;
						}
		                $row   = array();
						$row[] =  '<a class="btn btn-icon btn-trigger delete_tor" style="display: '.$show.'" id="'.$key->id.'" data="'.$key->request_id.'" onClick="delete_tor('.$key->id.')"><em class="icon ni ni-cross-circle-fill"></em></a>';
		                $row[] =  $key->tor_grandparent.' - '.$key->tor_parent.' - '.$key->tor_child;
		                $row[] =  $key->jumlah_kuitansi;
						$row[] =  number_format($key->total_kuitansi);
						$row[] =  $key->tanggal_kuitansi;
						$row[] =  number_format($key->penggantian);
						$row[] =  $key->keterangan.' - '.ucwords(strtolower($additional));
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

	public function save($type = ""){
		
        switch ($type) {

            case 'notes':

                $id = $this->input->post('request_id');
                $modul_type = $this->input->post('modul_type');
                $field['request_id'] = $id;
                $field['notes'] = $this->input->post('notes');
                $field['created_by'] = $this->input->post('email_approver');
                $field['created_at'] = $this->date;
                if ($this->db->insert('request_notes', $field)) {
                    $this->logs('save_notes', $modul_type, $id, 'Add notes', $this->input->post('notes'));
                    $response = array('status' => 1, 'id' => encode_url($id), 'messages' => 'Notes has been saved.');
                } else {
                    $this->logs('system', $id, 'Failed while saving invoices notes.');
                    $response = array('status' => 0, 'messages' => 'There\s something wrong. Please try again.');
                }

                echo json_encode($response);
                break;
        }
    }

	public function logs($type, $formType, $id, $activity = '', $description = '')
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

			case 'save_notes':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			case 'submit_to_hr':
				$log['activity'] = $activity;
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'revised_by_hr':
				$log['activity'] = $activity;
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'confirm_by_hr':
				$log['activity'] = $activity;
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'update_final_score':
				$log['activity'] = $activity;
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'revised':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;
			
			case 'reject':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

	public function sendEmail($type, $requestId, $email_to, $employee_id=""){

		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		$data['get_data_claim'] = $this->form_model->get_data_claim_per_request($requestId);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['request_to'] = $this->m_global->find('hris_request_time_off', 'request_id', $requestId)->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		$data['get_data_claim'] = $this->form_model->get_data_claim_per_request($requestId);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		
		$link_host = "$_SERVER[HTTP_HOST]";
		if($link_host == "dev-hris.ibstower.com" || $link_host == "dev-hris2.ibstower.com"){
			if ($type == 'approved_spv_mdcr') {
				$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id);
				$data['email'] = decrypt($data['data_employee']->email);
				$email_to 	   = 'luffi.utomo@ibsmulti.com';
				$html = $this->load->view('services/email/approved_spv_mdcr', $data, TRUE);
				$email_subject = 'IBST-Medical Claim Approved';
	
			} elseif ($type == 'approved_mdcr') {
				$data['email'] = $email_to;
				$html = $this->load->view('services/email/approvedMDCR', $data, TRUE);
				$email_to 	   = 'luffi.utomo@ibsmulti.com';
				$email_subject = 'IBST-Medical Claim Approved';
			}  elseif ($type == 'rejected_mdcr') {
				$data['email'] = $email_to;
				$html = $this->load->view('services/email/reject_mdcr', $data, TRUE);
				$email_to 	   = 'luffi.utomo@ibsmulti.com';
				$email_subject = 'IBST-Medical Claim Rejected';
			}  elseif ($type == 'revised_mdcr') {
				$data['email'] = $email_to;
				$html = $this->load->view('services/email/revised_mdcr', $data, TRUE);
				$email_to 	   = 'luffi.utomo@ibsmulti.com';
				$email_subject = 'IBST-Medical Claim Revised';
			} elseif ($type == 'rejected_time_off'){
				// $data['email'] = $email_to;
				$data['approval'] = 'rejected';
				$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/approval_time_off', $data, TRUE);
				$email_to 	   = $data['form_request']['created_by'];
				$email_to 	   = 'ditha.damayanti@ibsmulti.com'; // COMMENT: CAN BE REMOVED
				$email_subject = 'HRIS-Time Off Rejected';
			} elseif ($type == 'approved_time_off'){
				// $data['email'] = $email_to;
				$data['approval'] = 'approved';
				$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/approval_time_off', $data, TRUE);
				$email_to 	   = $data['form_request']['created_by'];
				$email_to 	   = 'ditha.damayanti@ibsmulti.com'; // COMMENT: CAN BE REMOVED
				if ($data['request_to']['jenis'] == 'Request Attendance'){
					$email_subject = 'HRIS-Request Attendance Approved';
				} else {
					$email_subject = 'HRIS-Time Off Approved';
				}
			} elseif ($type == 'info_time_off'){
				if(!empty($data['data_employee']->divhead_name)){
					$email_to  = strtolower(decrypt($data['data_employee']->usrid_long3));
					$name	   = ucwords(strtolower(decrypt($data['data_employee']->divhead_name)));
				} else {
					$email_to  = strtolower(decrypt($data['data_employee']->usrid_long4));
					$name	   = ucwords(strtolower(decrypt($data['data_employee']->director_name)));
				}
				// $data['email'] = $email_to;
				$data['full_name'] = $name;
				$data['emp_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/infoTODivhead', $data, TRUE);
				$email_to 	   = 'ditha.damayanti@ibsmulti.com'; // COMMENT: CAN BE REMOVED
				$email_subject = 'HRIS-Employee Time Off Approved';
			} else if ($type == 'req_to_hr'){
				// $email_to	   = 'hr.support@ibstower.com'; // COMMENT: OPEN THIS
				$email_to 	   = 'ditha.damayanti@ibsmulti.com'; // COMMENT: CAN BE REMOVED
				$data['full_name'] = 'HR Support';
				$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/requestToDeptheadRPM', $data, TRUE);
				$email_subject = 'HRIS-Request Time Off';
			}
		}else{
			if ($type == 'approved_spv_mdcr') {
				$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id);
				$html = $this->load->view('services/email/approved_spv_mdcr', $data, TRUE);
				$email_subject = 'IBST-Medical Claim Approved';
				$data['email'] = decrypt($data['data_employee']->email);
	
			} elseif ($type == 'approved_mdcr') {
				$data['email'] = $email_to;
				$html = $this->load->view('services/email/approvedMDCR', $data, TRUE);
				$email_subject = 'IBST-Medical Claim Approved';
			}  elseif ($type == 'rejected_mdcr') {
				$data['email'] = $email_to;
				$html = $this->load->view('services/email/reject_mdcr', $data, TRUE);
				$email_subject = 'IBST-Medical Claim Rejected';
			}  elseif ($type == 'revised_mdcr') {
				$data['email'] = $email_to;
				$html = $this->load->view('services/email/revised_mdcr', $data, TRUE);
				$email_subject = 'IBST-Medical Claim Revised';
			} elseif ($type == 'rejected_time_off'){
				$data['email'] = $email_to; // COMMENT: OPEN THIS
				$data['approval'] = 'rejected';
				$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/approval_time_off', $data, TRUE);
				$email_to = $data['form_request']['created_by'];
				$email_subject = 'HRIS-Time Off Rejected';
			} elseif ($type == 'approved_time_off'){
				if (!empty($email_to)){
					$data['email'] = $email_to;
				} else {
					$data['email'] = $data['form_request']['updated_by'];
				}
				$data['approval'] = 'approved';
				$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/approval_time_off', $data, TRUE);
				$email_to = $data['form_request']['created_by'];
				if ($data['request_to']['jenis'] == 'Request Attendance'){
					$email_subject = 'HRIS-Request Attendance Approved';
				} else {
					$email_subject = 'HRIS-Time Off Approved';
				}
			} elseif ($type == 'info_time_off'){
				if(!empty($data['data_employee']->divhead_name)){
					$email_to  = strtolower(decrypt($data['data_employee']->usrid_long3));
					$name	   = ucwords(strtolower(decrypt($data['data_employee']->divhead_name)));
				} else {
					$email_to  = strtolower(decrypt($data['data_employee']->usrid_long4));
					$name	   = ucwords(strtolower(decrypt($data['data_employee']->director_name)));
				}
				$data['email'] = $email_to; // COMMENT: OPEN THIS
				$data['full_name'] = $name;
				$html = $this->load->view('services/email/infoTODivhead', $data, TRUE);
				$email_subject = 'HRIS-Employee Time Off Approved';
			} else if ($type == 'req_to_hr'){
				$email_to	   = 'hr.support@ibstower.com'; // COMMENT: OPEN THIS
				$data['full_name'] = 'HR Support';
				$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/requestToDeptheadRPM', $data, TRUE);
				$email_subject = 'HRIS-Request Time Off';
			}
		}

		$url = 'https://api.ibstower.com/email_service';
		$params = array(
			'app_name'      => 'IBST-HRIS',
			'ip_address'    => $_SERVER['SERVER_ADDR'],
			'email_to'      => $email_to,
			'email_subject' => $email_subject,
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
