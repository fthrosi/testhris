<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Response extends Admin_Controller
{
	function __construct()
	{
        parent::__construct();
		$this->load->library('curl');
        // $this->load->helper('general');
		$this->load->model('m_global');
		$this->date = date('Y-m-d H:i:s');
    }

    public function index(){
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
		$priority = $this->m_global->find('id', $approval_id, 'form_approval')->row_array()['approval_priority'];
		$prev_priority = $priority-1;
		$prev_id = $this->find_select("id",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

		$prev_email = $this->find_select("approval_email",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

        $this->db->select('*');
        $this->db->from('form_approval');
        $this->db->where('id', $approval_id);
        $appr_email = $this->db->get()->result();
        $this->email = strtoupper($appr_email[0]->approval_email);
        $this->emp_id = $appr_email[0]->approval_employee_id;

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
								$sqlReqNo = "SELECT TOP 1 request_number FROM hris_request_time_off where request_id = '$request_id' ORDER BY id DESC";
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

									$this->db->select('id, time_off_code, note');
									$this->db->from('hris_master_time_management');
									$this->db->where('employee_id', $nik);
									$this->db->where('date >=', $start_date);
									$this->db->where('date <=', $end_date);
									$to_code = $this->db->get()->result();
									foreach($to_code as $val){
										$id = $val->id;
										if (!empty($val->time_off_code) && empty($val->note)){
											$sentence = "note = '$kode'";
										} else if (!empty($val->time_off_code) && !empty($val->note)) {
											$sentence = "note = '" . $val->note . ", " . $kode . "'";
										} else if (empty($val->time_off_code)){
											$sentence = "time_off_code = '$kode'";
										}
										$sqlUpdateMTM = "UPDATE hris_master_time_management SET ". $sentence .", flag=$flag WHERE id=$id";
										$queryUpdateMTM = $this->db->query($sqlUpdateMTM);
									}
									
									$today = date('Y-m-d');
									$sqlUpdateTME = "UPDATE hris_time_management_employee SET status=6, update_date='$today' WHERE request_number = '$req_no'";
									$queryUpdateTME = $this->db->query($sqlUpdateTME);

									$sqlTopTotal = "SELECT TOP 1 total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC";
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

										$this->db->where('nik', $employee_nik);
										$this->db->update('hris_time_management_employee', array('minus' => 0));
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

	public function find_select($select, $where = '', $table)
	{
		$this->db->select($select);
		if ($where != '') { $this->db->where($where);}
		return $this->db->get($table);
	}

	public function sendEmail($type, $requestId, $email_to, $employee_id="")
	{
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['data_employee'] = $this->get_data_employee($data['form_request']['employee_id']);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['request_to'] = $this->m_global->find('hris_request_time_off', 'request_id', $requestId)->row_array();
		$data['data_employee'] = $this->get_data_employee($data['form_request']['employee_id']);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		
		$link_host = "$_SERVER[HTTP_HOST]";
		if($link_host == "dev-hris.ibstower.com" || $link_host == "dev-hris2.ibstower.com"){
			if ($type == 'approved_spv_mdcr') {
				$data['data_employee_approver'] = $this->get_data_employee($employee_id);
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
				$data['email'] = $email_to;
				$data['approval'] = 'rejected';
				$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/approval_time_off', $data, TRUE);
				// $email_to 	   = $data['form_request']['created_by'];
				$email_to 	   = 'ditha.damayanti@ibsmulti.com'; // COMMENT: CAN BE REMOVED
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
				// $email_to 	   = $data['form_request']['created_by'];
				$email_to 	   = 'ronald.prawira@ibstower.com'; // COMMENT: CAN BE REMOVED
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
				$email_to 	   = 'ronald.prawira@ibstower.com'; // COMMENT: CAN BE REMOVED
				$email_subject = 'HRIS-Employee Time Off Approved';
			} else if ($type == 'req_to_hr'){
				// $email_to	   = 'hr.support@ibstower.com'; // COMMENT: OPEN THIS
				$email_to 	   = 'ronald.prawira@ibstower.com'; // COMMENT: CAN BE REMOVED
				$data['full_name'] = 'HR Support';
				$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/requestToDeptheadRPM', $data, TRUE);
				$email_subject = 'HRIS-Request Time Off';
			} else if ($type == 'info_to_hr'){ //CR 3 TM
				// $email_to	   = 'hr.support@ibstower.com'; // COMMENT: OPEN THIS
				// $email_to 	   = 'ditha.damayanti@ibsmulti.com'; // COMMENT: CAN BE REMOVED
				$email_to 	   = 'ronald.prawira@ibstower.com';
				$data['emp_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				// $data['head_name'] = ucwords(strtolower($employee_id));
				$html = $this->load->view('services/email/infoToHR', $data, TRUE);
				$email_subject = 'HRIS-Request Location';
			}
		}else{
			if ($type == 'approved_spv_mdcr') {
				$data['data_employee_approver'] = $this->get_data_employee($employee_id);
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
			} else if ($type == 'info_to_hr'){ //CR 3 TM
				$email_to	   = 'hr.support@ibstower.com'; // COMMENT: OPEN THIS
				$data['emp_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
				$html = $this->load->view('services/email/infoToHR', $data, TRUE);
				$email_subject = 'HRIS-Request Location';
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
			'created_by' 	=> 'EMAIL APPROVAL'
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

	public function logs($type, $formType, $id, $activity = '', $description = '')
	{
		$log['request_id'] = $id;
		$log['form_type'] = $formType;
		$log['created_by'] = ($type == 'system') ? 'system' : 'EMAIL APPROVAL';
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

	public function get_data_employee($nik){
		$sql = "SELECT TOP 1 * FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res[0];
	}
}
?>