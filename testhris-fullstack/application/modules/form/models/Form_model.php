<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->user = $this->session->userdata('user_name');
		$this->email = $this->session->userdata('user_email');
		$this->emp_nik = $this->session->userdata('nik');
		$this->date = date('Y-m-d H:i:s');
		$this->today = date('Y-m-d');
		$this->year = date('Y');
	}

	public function getFormType()
	{
		$output = '';
		$output .= '<option value=""></option>';

		$formType = $this->db->select('code, description')
							// ->where('code', '1')
							->where('is_active', '1')
							->order_by('description', 'ASC')
							->get('form_type')->result_array();
		$employee_id 				= $this->session->userdata('employee_id');
		$sql 				= "SELECT personnel_area, employee_subgroup, action, division FROM v_hris_employee_updated WHERE nik = '$employee_id' ORDER BY id_employee DESC";
		$query 				= $this->db->query($sql);
		$res 				= $query->result();
		$action 			= decrypt($res[0]->action);
		$personnel_area		= decrypt($res[0]->personnel_area);
		$division			= decrypt($res[0]->division);
		$pers 				= substr($personnel_area,0,3);
		$employee_subgroup  = decrypt($res[0]->employee_subgroup);

		foreach ($formType as $key) {
			$code		= $key['code'];
			if($action != "Leaving" && $pers == 'XXX'){
				/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////
					if($code == "KPI" || $code == "PLAN"){
						
					}elseif($code == 'MDCR'){
						$output .= '<option value=""></option>';
					}else{
						$output .= '<option value="' . $key['code'] . '" >' . $key['description'] . '</option>';
					}
				/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////
			}elseif($action != "Leaving" && $employee_subgroup == 'Outsource'){
				if($code == "KPI" || $code == "PLAN"){
					$output .= '<option value=""></option>';	
				}elseif($code == 'MDCR'){
					$output .= '<option value=""></option>';
				}else{
					$output .= '<option value="' . $key['code'] . '" >' . $key['description'] . '</option>';
				}
			}elseif($action != "Leaving" && $code == 'TM'){

				// $nik = $this->session->userdata('employee_id');
				// if($nik == '20228888' || $nik == '20189999' || $nik == '20140039' || $nik == '20150073' || $nik == '20180026' || $nik == '20160163' || $nik == '20160170' || $nik == '20170045' || $nik == '20180076' || $nik == '20180138' || $nik == '20190023' || $nik == '20210021' || $nik == '20210064' || $nik == '20210086' || $nik == '20210143' || $nik == '20210164' || $nik == '20210165' || $nik == '20210170' || $nik == '20220054' || $nik == '20220058' || $nik == '20220059' || $nik == '20220060' || $nik == '20220063' || $nik == '20220066' || $nik == '20220077' || $nik == '20220085' || $nik == '20220086' || $nik == '20220088' || $nik == '20220091' || $nik == '20230008' || $nik == '20230026' || $nik == '20240031' || $nik == '20240076' || $nik == '20240077'){
				// 	$output .= '<option value="' . $key['code'] . '" >' . $key['description'] . '</option>';
				// }else{
				// 	$output .= '<option value=""></option>';
				// }
				$output .= '<option value="' . $key['code'] . '" >' . $key['description'] . '</option>';
				
			}elseif($action != "Leaving"){

				/////////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////////
				if(($code == "KPI" || $code == "PLAN") && ($division == "PROJECT - BAKTI" || $division == "PROJECT MANAGEMENT - BAKTI")){
					$output .= '<option value=""></option>';
				}
				// elseif(($code == "KPI" || $code == "PLAN") && ($division != "HRGA DIVISION")){
				// 	$output .= '<option value=""></option>';
				// }
				else{
					$output .= '<option value="' . $key['code'] . '" >' . $key['description'] . '</option>';
				}
				/////////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////////

				// $output .= '<option value="' . $key['code'] . '" >' . $key['description'] . '</option>';
				
			}


		}
		return $output;
	}

	public function getAll($field, $table, $where = null)
	{
		return $this->db->select($field)->where($where)->get($table)->result_array();
	}

	public function getOneById($field, $table, $where = null)
	{
		return $this->db->select($field)->where($where)->get($table)->row_array()[$field];
	}

	public function get_data_employee($employee_id){

		$sql = "SELECT * FROM hris_employee WHERE nik = '$employee_id' ORDER BY id_employee DESC LIMIT 1";
		$query = $this->db->query($sql);
		$res = $query->result();
		// var_dump($res);
		return $res;
	}

	public function cek_employee($hak_pengajuan=""){
		$sql = "SELECT 	
					complete_name
				FROM		
					hris_employee
				WHERE nik = '$hak_pengajuan'
				ORDER BY id_employee DESC LIMIT 1";

		$query = $this->db->query($sql);
		$res = $query->result();
		$res = decrypt($res[0]->complete_name);
		return $res;
	}

	public function initial_create($formType, $formData = '',$requestNumber = '', $table = '')
	{

		switch ($formType) {
			/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////
			case 'KPI':

				$eval_year = $this->year - 1;
				$formRequest = array(
					'request_number' => $requestNumber,
					'is_status' => 0,
					'form_type' => 'KPI',
					'employee_id' => $this->session->userdata('employee_id'),
					'created_by' => $this->email,
					'created_at' => $this->date
				);

				if($formData[0]['divhead_name'] == ""){
					$formData[0]['divhead_name'] = $formData[0]['director_name'];
				}

				$this->db->insert('form_request', $formRequest);
				if($formData[0]['prev_joindate'] != ""){
					$join_date = substr(decrypt($formData[0]['prev_joindate']),0,4)."-".substr(decrypt($formData[0]['prev_joindate']),4,2)."-".substr(decrypt($formData[0]['prev_joindate']),6,2);
				}else{
					$join_date = substr(decrypt($formData[0]['join_date']),0,4)."-".substr(decrypt($formData[0]['join_date']),4,2)."-".substr(decrypt($formData[0]['join_date']),6,2);
				}
				$formData = array(
					'request_number' => $requestNumber,
					'is_status' => 0,
					'employee_name' => $formData[0]['complete_name'],
					'employee_nik' => $formData[0]['nik'],
					'position' => $formData[0]['position'],
					'division' => $formData[0]['division'],
					'departement' => $formData[0]['department'],
					'direct_manager' => $formData[0]['divhead_name'],
					'join_date'	=> $join_date,
					'employment_status' => $formData[0]['employee_subgroup'],
					'office_location'	=> $formData[0]['personnel_area'],
					'sub_total_kpi' => encrypt('0'),
					'sub_total_weight' => encrypt('0'),
					'sub_total_qualitative' => encrypt('0'),
					'pre_final_score' => encrypt('0'),
					'final_score' => encrypt('0'),
					'evaluation_period_start' => $eval_year.'-01-01',
					'evaluation_period_end' => $eval_year.'-12-31',
					'employee_id' => $this->session->userdata('employee_id'),
					'division_root' => $this->session->userdata('division_root'),
					'new_employee_flag' => 0,
					'created_by' => encrypt($this->email),
					'created_at' => $this->date,
					'employee_grade' => $this->session->userdata('employee_grade'),
					);
					$this->db->insert('performance_appraisal', $formData);
					$requestId = $this->db->insert_id();

					////////////////////////////////////////////Start Update PA 2025//////////////////////////////////////////////////

					$dataQA = array(
						'req_id_pa' => $requestId,
						'request_number' => $requestNumber,
						'created_by' => $this->email
						);
					$this->db->insert('performance_appraisal_qualitative_assesment', $dataQA);
					$requestIdQA = $this->db->insert_id();

					////////////////////////////////////////////End Update PA 2025//////////////////////////////////////////////////
					
					if($requestId > 0){
						$yyy = ($eval_year-1).'-01-01';
						$queryx = "select * from performance_appraisal where evaluation_period_start LIKE '$yyy' and full_approved_date IS NOT NULL and created_by = '".encrypt($this->email)."'";
						$cek = $this->db->query($queryx)->result_array();
						
						if(!empty($cek)){
							$queryy = "select * from performance_appraisal_plan where request_id = '".$cek[0]['id']."'";
							$plan = $this->db->query($queryy)->result_array();
							$nosa = 1;
							$totalweight = 0;
							$count_row_kpi = 0;
							if(!empty($plan)){
								foreach($plan as $keyx => $valx){
									$target_per_year = 0;
									if(($eval_year-1) < 2022){
										if(is_numeric(decrypt($valx['semester_1']))){
											if(is_numeric(decrypt($valx['semester_2']))){
												$target_per_year = decrypt($valx['semester_1'])+decrypt($valx['semester_2']);
												$nosa++;
											}
										}
										$unit = null;
									}else{
										if(is_numeric(decrypt($valx['semester_1']))){
											$target_per_year = decrypt($valx['semester_1']);
											$nosa++;
										}
										$unit = ($valx['unit']);
									}
									$target_per_year = decrypt($valx['total']);
									$totalweight = $totalweight+decrypt($valx['time']);
									$target = (string) $target_per_year;
									$targetok = encrypt($target);

									$formDataRequest = array(
										'request_id' => $requestId,
										'objective' => $valx['objective'],
										'measurement' => $valx['measurement'],
										'target_per_year' => $targetok,
										'time' => $valx['time'],
										'created_by' => encrypt($this->email),
										'created_at' => date("Y-m-d H:i:s"),
										'unit' => $unit
									);
									$this->db->insert("performance_appraisal_measurement", $formDataRequest);
									
									$count_row_kpi++;
								}
								if($totalweight > 0){
									$totalweight = (string) $totalweight;
									$up = "
										update performance_appraisal set sub_total_weight = '".encrypt($totalweight)."', count_row_kpi = '$count_row_kpi' where id = '$requestId'
									";
									$this->db->query($up);
								}
							}
						}
						
					}
				break;

			case 'PLAN':

				$eval_year = $this->year - 1;

				$formRequest = array(
					'request_number' => $requestNumber,
					'is_status' => 0,
					'form_type' => 'PLAN',
					'employee_id' => $this->session->userdata('employee_id'),
					'created_by' => $this->email,
					'created_at' => $this->date
				);

				$this->db->insert('form_request', $formRequest);
				
				if($formData[0]['divhead_name'] == ""){
					$formData[0]['divhead_name'] = $formData[0]['director_name'];
				}
				
				$formData = array(
					'request_number' => $requestNumber,
					'is_status' => 0,
					'employee_name' => $formData[0]['complete_name'],
					'employee_nik' => $formData[0]['nik'],
					'position' => $formData[0]['position'],
					'division' => $formData[0]['division'],
					'join_date'	=> substr(decrypt($formData[0]['join_date']),0,4)."-".substr(decrypt($formData[0]['join_date']),4,2)."-".substr(decrypt($formData[0]['join_date']),6,2),
					'employment_status' => $formData[0]['employee_subgroup'],
					'office_location'	=> $formData[0]['personnel_area'],
					'departement' => $formData[0]['department'],
					'direct_manager' => $formData[0]['divhead_name'],
					'sub_total_kpi' => 0,
					'sub_total_weight' => 0,
					'sub_total_qualitative' => 0,
					'pre_final_score' => 0,
					'final_score' => 0,
					'evaluation_period_start' => $eval_year.'-01-01',
					'evaluation_period_end' => $eval_year.'-12-31',
					'employee_id' => $this->session->userdata('employee_id'),
					'division_root' => $this->session->userdata('division_root'),
					'new_employee_flag' => 1,
					'created_by' => encrypt($this->email),
					'created_at' => $this->date,
					'employee_grade' => $this->session->userdata('employee_grade'),
				);

					$this->db->insert('performance_appraisal', $formData);
					$requestId = $this->db->insert_id();

				break;

				/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////

			case 'MDCR':
				$id_employee = $this->session->userdata('id_hr_emp');
				$id_hr_emp 		= encrypt("$id_employee");

				$today = $this->today;
				$formRequest = array(
					'request_number' => $requestNumber,
					'is_status' => 0,
					'form_type' => 'MDCR',
					'employee_id' => $this->session->userdata('employee_id'),
					'created_by' => $this->email,
					'created_at' => $this->date
				);

				$this->db->insert('form_request', $formRequest);
				$requestId = $this->db->insert_id();

				$employee_id = $this->session->userdata('employee_id');
				// --old
				$sql = "SELECT * FROM hris_employee WHERE nik = '$employee_id' ORDER BY id_employee DESC LIMIT 1";
				$query = $this->db->query($sql);
				$res = $query->result();
				$complete_name 			= $res[0]->complete_name;
				$employee_group 		= $res[0]->employee_group;
				$phone_number	 		= $res[0]->phone_number;
				$department		 		= $res[0]->department;
				$personnel_area	 		= $res[0]->personnel_area;
				$marital_status	 		= $res[0]->marital_status;
				$eg 					= decrypt($employee_group);

				// old
				// $sql2 = "SELECT TOP 1 id FROM hris_medical_pagu_rawat_jalan WHERE grade LIKE '$eg' AND start_date <= '$today' AND end_date > '$today' ORDER BY id DESC";

				$sql2 = "SELECT id FROM hris_medical_pagu_rawat_jalan WHERE grade LIKE '$eg' AND start_date <= '$today' AND end_date > '$today' ORDER BY id DESC LIMIT 1";

				$query2 = $this->db->query($sql2);
				$res2 = $query2->result();
				$id_eg_prj	 		= encrypt((string)$res2[0]->id);

				// $sql3 = "SELECT TOP 1 id FROM hris_medical_pagu_rawat_inap WHERE grade LIKE '$eg' AND start_date <= '$today' AND end_date > '$today' ORDER BY id DESC";

				$sql3 = "SELECT id FROM hris_medical_pagu_rawat_inap WHERE grade LIKE '$eg' AND start_date <= '$today' AND end_date > '$today' ORDER BY id DESC LIMIT 1";
				$query3 = $this->db->query($sql3);
				$res3 = $query3->result();
				$id_eg_pri	 		= encrypt((string)$res3[0]->id);
				
				// $sql4 = "SELECT TOP 1 id FROM hris_medical_pagu_kacamata WHERE grade LIKE '$eg' AND start_date <= '$today' AND end_date > '$today' ORDER BY id DESC";

				$sql4 = "SELECT id FROM hris_medical_pagu_kacamata WHERE grade LIKE '$eg' AND start_date <= '$today' AND end_date > '$today' ORDER BY id DESC LIMIT 1";

				$query4 = $this->db->query($sql4);
				$res4 = $query4->result();
				$id_eg_pk	 		= encrypt((string)$res4[0]->id);

				$formData = array(
					'complete_name' => $complete_name,
					'employee_group'=> $employee_group,
					'phone_number'	=> $phone_number,
					'department'	=> $department,
					'personnel_area'=> $personnel_area,
					'employee_id'	=> $employee_id,
					'request_id' 	=> $requestId,
					'created_by' 	=> $this->email,
					'created_at' 	=> $this->date,
					'id_eg_prj'		=> $id_eg_prj,
					'id_eg_pri'		=> $id_eg_pri,
					'id_eg_pk'		=> $id_eg_pk,
					'marital_status'=> $marital_status,
					'id_hr_emp'		=> $id_hr_emp
				);

				if ($requestId  != '') {
					$this->db->insert($table, $formData);
				}

				break;

			case 'PPD':

				$formRequest = array(
		            'request_number' => $requestNumber,
		            'form_type' => $formType,
		            'employee_id' => $formData[0]['nik'],
		            'is_status' => 0,
		            'created_by' => $this->email,
		            'created_at' => $this->date);

				$this->db->insert('form_request', $formRequest);
				$requestId = $this->db->insert_id();

				$formData = array(
                    'request_id'  			=> $requestId,
                    'ca_type'  				=> 'Travel',
                    'matrix_approval_id'  	=> '0',
                    'is_status'  			=> '0',
                    'matrix_type'  			=> 'ppd',
                    'created_by' 			=> $this->email,
                    'created_at'			=> $this->date);

				$this->db->insert('bussiness_trip', $formData);

				break;

			case 'LPD':

				$formRequest = array(
		            'request_number' => $requestNumber,
		            'form_type' => $formType,
		            'employee_id' => $formData[0]['nik'],
		            'is_status' => 0,
		            'created_by' => $this->email,
		            'created_at' => $this->date);

				$this->db->insert('form_request', $formRequest);
				$requestId = $this->db->insert_id();

				$formData = array(
                    'request_id'  			=> $requestId,
                    'ca_type'  				=> 'Travel',
                    'matrix_approval_id'  	=> '0',
                    'matrix_type'  			=> 'lpd',
                    'is_status'  			=> '0',
                    'created_by' 			=> $this->email,
                    'created_at'			=> $this->date);

				$this->db->insert('bussiness_trip_settlement', $formData);

				break;

			case 'EC':

				$formRequest = array(
		            'request_number' => $requestNumber,
		            'form_type' => $formType,
		            'employee_id' => $formData[0]['nik'],
		            'is_status' => 0,
		            'created_by' => $this->email,
		            'created_at' => $this->date);

				$this->db->insert('form_request', $formRequest);
				$requestId = $this->db->insert_id();

				$formData = array(
					'id_form_request' => $requestId,
					'status' => 0,
					'created_at' => $this->date,
				);
				if ($requestId  != '') {
					$this->db->insert('exit_clearance_resignation_letters', $formData);
					$this->db->insert('exit_clearance', $formData);
				}
			break;

			default:
				break;

		}
		
		return $requestId;
	}

	public function save_form($formType, $formData = '', $table = '')
	{

		switch ($formType) {

			case 'KPI':

				$formData = array(
					'is_status' => 1,
					'sub_total_kpi' => encrypt($this->input->post('sub_total_kpi')),
					'sub_total_weight' => encrypt($this->input->post('sub_total_weight')),
					'sub_total_qualitative' => encrypt($this->input->post('sub_total_qualitative')),
					'departement' => encrypt($this->input->post('kpi_departemen')),
					'direct_manager' => encrypt($this->input->post('atasan_langsung')),
					'work_efficiency' =>encrypt( $this->input->post('work_efficiency')),
					'work_quality' => encrypt($this->input->post('work_quality')),
					'communication' => encrypt($this->input->post('communication')),
					'planing' => encrypt($this->input->post('planing')),
					'problem_solving' => encrypt($this->input->post('problem_solving')),
					'team_work' => encrypt($this->input->post('team_work')),
					'potential' => encrypt($this->input->post('potential')),
					'initiative' => encrypt($this->input->post('initiative')),
					'leadership' => encrypt($this->input->post('leadership')),
					'work_efficiency_result' => encrypt($this->input->post('result_work_efficiency')),
					'work_quality_result' => encrypt($this->input->post('result_work_quality')),
					'communication_result' => encrypt($this->input->post('result_communication')),
					'planing_result' => encrypt($this->input->post('result_planing')),
					'problem_solving_result' => encrypt($this->input->post('result_problem_solving')),
					'team_work_result' => encrypt($this->input->post('result_team_work')),
					'potential_result' => encrypt($this->input->post('result_potential')),
					'initiative_result' => encrypt($this->input->post('result_initiative')),
					'leadership_result' => encrypt($this->input->post('result_leadership')),
					'grand_total_kpi' => encrypt($this->input->post('grand_total_kpi')),
					'grand_total_qualitative' => encrypt($this->input->post('grand_total_qualitative')),
					'pre_final_score' => encrypt($this->input->post('pre_final_score')),
					'final_score' => encrypt($this->input->post('pre_final_score')),
					'comment_employee' => encrypt($this->input->post('comment_employee')),
					'comment_head_1' => encrypt($this->input->post('comment_head_1')),
					'comment_head_2' => encrypt($this->input->post('comment_head_2')),
					'plan_total_weight' => encrypt($this->input->post('plan_total_weight')),
					'area_improvement' => encrypt($this->input->post('area_improvement')),
					'development_plan' => encrypt($this->input->post('development_plan')),
					'performance_plan_flag' => ($this->input->post('plan_total_weight') != 0) ? 1 : 0,
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				$this->db->where('id', $this->input->post('id'));
				if ($this->db->update('performance_appraisal', $formData)) {
					return true;
				} else {
					return false;
				}
					
				break;

			case 'PLAN':

				$formData = array(
					'is_status' => 1,
					'sub_total_kpi' => 0,
					'sub_total_weight' => 0,
					'sub_total_qualitative' => 0,
					'departement' => encrypt($this->input->post('kpi_departemen')),
					'direct_manager' => encrypt($this->input->post('atasan_langsung')),
					'work_efficiency' => 0,
					'work_quality' => 0,
					'communication' => 0,
					'planing' => 0,
					'problem_solving' => 0,
					'team_work' => 0,
					'potential' => 0,
					'initiative' => 0,
					'leadership' => 0,
					'work_efficiency_result' => 0,
					'work_quality_result' => 0,
					'communication_result' => 0,
					'planing_result' => 0,
					'problem_solving_result' => 0,
					'team_work_result' => 0,
					'potential_result' => 0,
					'initiative_result' => 0,
					'leadership_result' => 0,
					'grand_total_kpi' => 0,
					'grand_total_qualitative' => 0,
					'pre_final_score' => 0,
					'final_score' => 0,
					'comment_employee' => '',
					'comment_head_1' => '',
					'comment_head_2' => '',
					'plan_total_weight' => encrypt($this->input->post('plan_total_weight')),
					'area_improvement' => '',
					'development_plan' => '',
					'performance_plan_flag' => ($this->input->post('plan_total_weight') != 0) ? 1 : 0,
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				$this->db->where('id', $this->input->post('id'));
				if ($this->db->update('performance_appraisal', $formData)) {
					return true;
				} else {
					return false;
				}
					
				break;
			
			default:
				break;

		}
		
	}

	public function getCity()
	{
		$output = '';
		$output .= '<option value=""></option>';

		$list_city = $this->db->select('IDPROVINSI, PROVINSI, NAMA_KABUPATEN_KOTA')
							->where('NAMA_KABUPATEN_KOTA !=', null)
							->order_by('IDPROVINSI', 'ASC')
							->get('master_city')->result_array();

		foreach ($list_city as $key) {
			$output .= '<option value="' . $key['IDPROVINSI'] . '" >' . $key['NAMA_KABUPATEN_KOTA'] . '</option>';
		}
		return $output;
	}

	public function getRequestNotes($request_id)
	{
		$this->db->select('id, notes, created_at, created_by');
     	$this->db->from('request_notes');
      	$this->db->where('request_id', $request_id);
      	$this->db->order_by('created_at', 'ASC');
      	return $this->db->get()->result_array();
	}

	public function getUserList($field, $table, $where)
	{
		// var_dump($this->session);
		$output = '';
		$output .= '<option value=""></option>';

		$userList = $this->db->select($field)->where($where)->get($table)->result_array();
		foreach ($userList as $key) {
			$output .= '<option value="' . $key[$field] . '" >' . $key[$field] . '</option>';
		}
		return $output;
	}

	public function saveApproval($email, $requestId, $layer_nik)
	{
		$i = 0;
		$priority = 1;
		$count = count($email);
		$cek = $this->db->get_where('form_approval', array('request_id' => $requestId));
		$sql = "select id, request_number, form_type, is_status, no_req_mdcr, is_status_admin_hr, is_status_divhead_hr, revise_after_f1 from form_request where id='$requestId' ";
		$query = $this->db->query($sql);
		$res = $query->result();
		if ($res[0]->revise_after_f1 == 1) {
			for ($i = 0; $i < $count; $i++) {

				$sql_alias 			= "SELECT complete_name FROM v_hris_employee_updated WHERE email = '".encrypt($email[$i])."' ORDER BY id_employee DESC";
				$query_alias		= $this->db->query($sql_alias);
				$alias 				= $query_alias->result();
				$alias 				= decrypt($alias[0]->complete_name);
				// $alias = str_replace('@ibsmulti.com', '', $email[$i]);

				if ($priority == 1 && $layer_nik[$i] !='00000000' ) {
					$approval = array(
						'request_id' => $requestId,
						'approval_priority' => $priority,
						'approval_employee_id' => $layer_nik[$i],
						'approval_email' => $email[$i],
						'approval_alias' => $alias,
						'approval_status' => 'Approved',
						'approval_note' => '',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->email
					);
				} elseif ($priority == 1 && $layer_nik[$i] == '00000000' ) {
					$approval = array(
						'request_id' => $requestId,
						'approval_priority' => $priority,
						'approval_employee_id' => $layer_nik[$i],
						'approval_email' => $email[$i],
						'approval_alias' => $alias,
						'approval_status' => 'In Progress',
						'approval_note' => '',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->email
					);
				} elseif ($priority == 2 && $layer_nik[$i] == '00000000' ) {
					$approval = array(
						'request_id' => $requestId,
						'approval_priority' => $priority,
						'approval_employee_id' => $layer_nik[$i],
						'approval_email' => $email[$i],
						'approval_alias' => $alias,
						'approval_status' => 'In Progress',
						'approval_note' => '',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->email
					);
				}	else {
					$approval = array(
						'request_id' => $requestId,
						'approval_priority' => $priority,
						'approval_employee_id' => $layer_nik[$i],
						'approval_email' => $email[$i],
						'approval_alias' => $alias,
						'approval_status' => '',
						'approval_note' => '',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->email
					);
				}

				$this->db->where('request_id', $requestId);
				$this->db->where('approval_priority', $priority);
				$this->db->update('form_approval', $approval);
				// $layer[] = $approval;
				$priority++;
			}

			return true;
			// $this->db->where('request_id', $requestId);
			// if ($this->db->update('form_approval', $layer)) {
			// 	return true;
			// } else {
			// 	return false;
			// }
		} else {

			if($cek->num_rows() > 0){
				$this->db->delete('form_approval',array('request_id' => $requestId));
			}

			//print_r($cek->num_rows());die;
			for ($i = 0; $i < $count; $i++) {

				// if ($email[$i] === 'farida@ibstower.com') {
				// 	$alias = 'Commitee';
				// } else {
				// 	$alias = str_replace('@ibstower.com', '', $email[$i]);
				// }

				$sql_alias 			= "SELECT complete_name FROM v_hris_employee_updated WHERE email = '".encrypt($email[$i])."' ORDER BY id_employee DESC";
				$query_alias		= $this->db->query($sql_alias);
				$alias 				= $query_alias->result();
				$alias 				= decrypt($alias[0]->complete_name);

				if ($priority == 1) {
					$approval = array(
						'request_id' => $requestId,
						'approval_priority' => $priority,
						'approval_employee_id' => $layer_nik[$i],
						'approval_email' => $email[$i],
						'approval_alias' => $alias,
						'approval_status' => 'In Progress',
						'approval_note' => '',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->email
					);
				} else {
					$approval = array(
						'request_id' => $requestId,
						'approval_priority' => $priority,
						'approval_employee_id' => $layer_nik[$i],
						'approval_email' => $email[$i],
						'approval_alias' => $alias,
						'approval_status' => '',
						'approval_note' => '',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->email
					);
				}

				$layer[] = $approval;
				$priority++;
			}

			if ($this->db->insert_batch('form_approval', $layer)) {
				return true;
			} else {
				return false;
			}
		}

	}

	public function updateApproval($approval_id, $approval_priority, $approval_status, $email, $requestId)
    {
        $transok = false;
        $count = count($email);

        # check approval layer
        // $sql = "SELECT TOP 1 approval_priority, approval_status FROM form_approval WHERE approval_priority < '$approval_priority' AND request_id = '$requestId'";

        $sql = "SELECT approval_priority, approval_status FROM form_approval WHERE approval_priority < '$approval_priority' AND request_id = '$requestId' LIMIT 1";
        $checkbefore = $this->db->query($sql);

        switch ($approval_status) {

            case 'Revise':

                if ($count == 0) {

                    if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {
                        $transok = true;
                    }
                } else {

                    if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {

                        for ($i = 0; $i < $count; $i++) {

                            $approval_priority++;

                            // if ($email[$i] === 'farida@ibstower.com') {
                            //     $alias = 'Commitee';
                            // } else {
                            //     $alias = $email[$i];
                            // }

							$sql_alias 			= "SELECT complete_name FROM v_hris_employee_updated WHERE email = '".encrypt($email[$i])."' ORDER BY id_employee DESC";
							$query_alias		= $this->db->query($sql_alias);
							$alias 				= $query_alias->result();
							$alias 				= decrypt($alias[0]->complete_name);

                            $approval = array(
                                'request_id' => $requestId,
                                'approval_priority' => $approval_priority,
                                'approval_status' => '',
                                'approval_email' => $email[$i],
                                'approval_alias' => $alias,
                                'approval_note' => '',
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $this->email
                            );

                            $layer[] = $approval;
                        }

                        if ($this->db->insert_batch('form_approval', $layer)) {
                            $transok = true;
                        }
                    }
                }

                break;

            case 'Canceled':

                if ($count == 0) {

                    if ($checkbefore->num_rows() > 0 && $checkbefore->row_array()['approval_status'] == 'Approved') {

                        if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >=' => $approval_priority))) {
                            $transok = true;
                        }
                    } 

                } else {

                    if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {

                        for ($i = 0; $i < $count; $i++) {

                            // if ($email[$i] === 'farida@ibstower.com') {
                            //     $alias = 'Commitee';
                            // } else {
                            //     $alias = $email[$i];
                            // }
							$sql_alias 			= "SELECT complete_name FROM v_hris_employee_updated WHERE email = '".encrypt($email[$i])."' ORDER BY id_employee DESC";
							$query_alias		= $this->db->query($sql_alias);
							$alias 				= $query_alias->result();
							$alias 				= decrypt($alias[0]->complete_name);

                            $app_status = ($i == 0) ? 'Canceled' : '';

                            $approval = array(
                                'request_id' => $requestId,
                                'approval_priority' => $approval_priority,
                                'approval_status' => $app_status,
                                'approval_email' => $email[$i],
                                'approval_alias' => $alias,
                                'approval_note' => '',
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $this->email
                            );

                            $layer[] = $approval;
                            $approval_priority++;

                        }

                        if ($this->db->insert_batch('form_approval', $layer)) {
                            $transok = true;
                        }
                    }
                }

                break;
            
            default:
                break;
        }

        if ($transok) {
            return true;
        } else {
            return false;
        }
    }

	public function getTypeOfRembursement($request_id){

		$sql = "SELECT 	
					a.id as id,
					a.request_id as request_id,
					e.is_status as is_status,
					b.grandparent as tor_grandparent,
					c.parent as tor_parent,
					d.child as tor_child,
					a.jumlah_kuitansi as jumlah_kuitansi,
					a.total_nominal_kuitansi as total_kuitansi,
					a.penggantian as penggantian,
					a.keterangan as keterangan,
					a.harga_kamar as harga_kamar,
					a.additional as additional,
					a.docter as docter,
					a.diagnosa as diagnosa,
					a.tanggal_kuitansi as tanggal_kuitansi
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
				LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
				LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
				LEFT JOIN form_request e ON a.request_id = e.id
				WHERE a.request_id = '$request_id'";

		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;

	}

	public function cekTypeOfRembursement($request_id){

		$sql = "SELECT 	
					a.id as id,
					a.tor_grandparent,
					a.tor_parent,
					a.tor_child
				FROM		
					hris_medical_reimbursment_item a
				WHERE a.request_id = '$request_id'";

		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;

	}

	

	public function tambah_tor($request_id, $tor_grandparent, $tor_parent, $tor_child, $jumlah_kuitansi, $total_kuitansi, $penggantian, $request_family, $additional, $diagnosa, $tanggal_kuitansi, $docter="", $harga_kamar=""){
		$employee_id 				= $this->session->userdata('nik');
		$date = strtotime($tanggal_kuitansi);
		$receiptDate = date('Y-m-d',$date);
		$formData = array(
			'request_id' => $request_id,
			'tor_grandparent' => $tor_grandparent,
			'tor_parent' => $tor_parent,
			'tor_child' => $tor_child,
			'jumlah_kuitansi' => $jumlah_kuitansi,
			'total_nominal_kuitansi' => $total_kuitansi,
			'penggantian' => $penggantian,
			'keterangan' => $request_family,
			'additional' => $additional,
			'docter' => $docter,
			'diagnosa' => $diagnosa,
			'tanggal_kuitansi' => $receiptDate,
			'harga_kamar' => $harga_kamar,
			'employee_id' => $employee_id,
			'create_date' => date('Y-m-d H:i:s')
		);

		$this->db->insert("hris_medical_reimbursment_item", $formData);
		$query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function update_tor($request_id, $tor_grandparent, $tor_parent, $tor_child, $jumlah_kuitansi, $total_kuitansi, $penggantian, $request_family, $additional, $diagnosa, $tanggal_kuitansi, $docter="", $harga_kamar=""){
		$employee_id 				= $this->session->userdata('nik');
		$date = strtotime($tanggal_kuitansi);
		$receiptDate = date('Y-m-d',$date);
		$formData = array(
			'tor_grandparent' => $tor_grandparent,
			'tor_parent' => $tor_parent,
			'tor_child' => $tor_child,
			'jumlah_kuitansi' => $jumlah_kuitansi,
			'total_nominal_kuitansi' => $total_kuitansi,
			'penggantian' => $penggantian,
			'keterangan' => $request_family,
			'additional' => $additional,
			'docter' => $docter,
			'diagnosa' => $diagnosa,
			'tanggal_kuitansi' => $receiptDate,
			'harga_kamar' => $harga_kamar,
		);
		// =================================================================
		// $sql = "UPDATE hris_medical_reimbursment_item SET 
		// 			tor_grandparent='$tor_grandparent', tor_parent='$tor_parent', tor_child='$tor_child', 
		// 			jumlah_kuitansi='$jumlah_kuitansi', total_nominal_kuitansi = '$total_kuitansi',
		// 			penggantian = '$penggantian', keterangan = '$request_family', additional = '$additional', 
		// 			docter = '$docter', diagnosa = '$diagnosa', tanggal_kuitansi = '$receiptDate',
		// 			harga_kamar = '$harga_kamar' 
		// 			WHERE id='$request_id'";
		// $query = $this->db->query($sql);

		// if($query){
		// 	return true;
		// }else{
		// 	return false;
		// }
		// =================================================================

		$this->db->where('id', $request_id);
		if ($this->db->update('hris_medical_reimbursment_item', $formData)) {
			return true;
		} else {
			return false;
		}
	}

	public function update_price($record_id, $penggantian_old, $penggantian_revisi, $note_penggantian, $harga_kamar){
		$employee_id 				= $this->session->userdata('nik');
		// $date = strtotime($tanggal_kuitansi);
		// $receiptDate = date('Y-m-d',$date);

		if ($penggantian_revisi == null || $penggantian_revisi == '' || $penggantian_revisi == 0) {
			$formData = array(
				'penggantian_sebelum' => null,
				'harga_kamar' => $harga_kamar,
				'penggantian' => $penggantian_old,
				'note_penggantian' => null
			);
		} else {
			$formData = array(
				'penggantian_sebelum' => $penggantian_old,
				'harga_kamar' => $harga_kamar,
				'penggantian' => $penggantian_revisi,
				'note_penggantian' => $note_penggantian
			);
		}
		
		// =================================================================
		// $sql = "UPDATE hris_medical_reimbursment_item SET 
		// 			tor_grandparent='$tor_grandparent', tor_parent='$tor_parent', tor_child='$tor_child', 
		// 			jumlah_kuitansi='$jumlah_kuitansi', total_nominal_kuitansi = '$total_kuitansi',
		// 			penggantian = '$penggantian', keterangan = '$request_family', additional = '$additional', 
		// 			docter = '$docter', diagnosa = '$diagnosa', tanggal_kuitansi = '$receiptDate',
		// 			harga_kamar = '$harga_kamar' 
		// 			WHERE id='$request_id'";
		// $query = $this->db->query($sql);

		// if($query){
		// 	return true;
		// }else{
		// 	return false;
		// }
		// =================================================================

		$this->db->where('id', $record_id);
		if ($this->db->update('hris_medical_reimbursment_item', $formData)) {
			return true;
		} else {
			return false;
		}
	}

	public function cek_record($id)
	{
		$sql = "SELECT * FROM form_request WHERE id='$id' LIMIT 1";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;	
	}
	

	public function delete_tor($id){
		$sql = "DELETE FROM hris_medical_reimbursment_item where id = '".$id."'";
		$query = $this->db->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function edit_tor($id)
	{
		$sql = "SELECT * FROM hris_medical_reimbursment_item WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		// dumper($res);
		return $res;
	}

	public function get_medical_item_year($request_id){

		$sql = "SELECT tanggal_kuitansi
				FROM		
					hris_medical_reimbursment_item
				WHERE request_id = '$request_id' 
				Order by tanggal_kuitansi asc";
				// LIMIT 1";
				// WHERE request_id = '$request_id' and tor_grandparent = '1' and YEAR(tanggal_kuitansi) = '$this->year'";
		$query = $this->db->query($sql);
		$res = $query->result();
		$c = 0;
		$data = [];
		if ($res != null) {
			foreach ($res as $key => $value) {
				if ($c == 0) {
					$data[$c] = $value;
				}
				$c++;
			}
			$data[0]->totalId = $c;
		}
		return $data;
	}

	public function get_sum_penggantian_jalan($request_id){
		// $sql = "SELECT 	
		// 			sum( CONVERT(INT,penggantian) ) as sum_penggantian
		// 		FROM		
		// 			hris_medical_reimbursment_item
		// 		WHERE request_id = '$request_id' and tor_grandparent = '1'";

		$sql = "SELECT 	
					sum(penggantian) as sum_penggantian
				FROM		
					hris_medical_reimbursment_item
				WHERE request_id = '$request_id' and tor_grandparent = '1'";
				// WHERE request_id = '$request_id' and tor_grandparent = '1' and YEAR(tanggal_kuitansi) = '$this->year'";

		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function get_sum_penggantian_inap($request_id){
		// $sql = "SELECT 	
		// 			sum( CONVERT(INT,penggantian) ) as sum_penggantian
		// 		FROM		
		// 			hris_medical_reimbursment_item
		// 		WHERE request_id = '$request_id' and tor_grandparent = '2'";

		$sql = "SELECT 	
					sum(penggantian) as sum_penggantian
				FROM		
					hris_medical_reimbursment_item
				WHERE request_id = '$request_id' and tor_grandparent = '2'";

		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function get_sum_penggantian_kacamata($request_id){
		$sql = "SELECT 	
					SUM(CASE
						WHEN tor_child = '12'
							THEN penggantian
						ELSE 0
					END)  as sum_frame,
					SUM(CASE
						WHEN tor_child = '13'
							THEN penggantian
						ELSE 0
					END)  as sum_one_focus,
					SUM(CASE
						WHEN tor_child = '14'
							THEN penggantian
						ELSE 0
					END)  as sum_two_focus
				FROM		
					hris_medical_reimbursment_item
				WHERE request_id = '$request_id' and tor_grandparent = '3'";

		$query = $this->db->query($sql);
		$res = $query->result();

		$sql2 = "SELECT * FROM hris_medical_reimbursment_item
						WHERE request_id = '$request_id' and tor_grandparent ='3'";
		$query = $this->db->query($sql2);
		$res2 = $query->result();

		return $res;
	}

	public function cek_pagu_berjalan($tahun, $employee_nik, $employee_group, $grandparent, $parent, $child){
		// $group = encrypt($employee_group);
		switch ($grandparent) {
			case '1':
				$sql = "SELECT 	
					SUM(a.penggantian) as penggantian_rawat_jalan
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_nik' and a.tor_grandparent = '$grandparent' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and year(a.tanggal_kuitansi) LIKE '%$tahun%'";
				$query = $this->db->query($sql);
				$result = $query->result();	
				// dumper($sql);
				$result = $result[0]->penggantian_rawat_jalan;
				break;
			case '2':
				$sql = "SELECT 	
					SUM(a.penggantian) as penggantian_rawat_inap
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_nik' and a.tor_grandparent = '$grandparent' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and year(a.tanggal_kuitansi) LIKE '%$tahun%'
				";
				$query = $this->db->query($sql);
				$result = $query->result();	
				$result = $result[0]->penggantian_rawat_inap;
				break;
			default:
				$sql = "SELECT 	
					SUM(CASE
						WHEN a.tor_child = '12'
							THEN a.penggantian
						ELSE 0
					END)  as frame,
					SUM(CASE
						WHEN a.tor_child = '13'
							THEN a.penggantian
						ELSE 0
					END)  as one_focus,
					SUM(CASE
						WHEN a.tor_child = '14'
							THEN a.penggantian
						ELSE 0
					END)  as two_focus
					FROM		
						hris_medical_reimbursment_item a
					LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
					LEFT JOIN form_request c ON b.request_id = c.id
					WHERE b.employee_id = '$employee_nik' and a.tor_grandparent = '%grandparent' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and (a.tor_child = '12' or a.tor_child = '13' or a.tor_child = '14	') and year(a.tanggal_kuitansi) LIKE '%$year%'";
				$query = $this->db->query($sql);
				$result = $query->result();

				switch ($child) {
					case '12': #frame_kacamata
						$result = $result[0]->frame;
						break;
					case '13': #one_focus
						$result = $result[0]->one_focus;
						break;					
					default: #two_focus
						$result = $result[0]->two_focus;
						break;
				}
				break;
		}

		// dumper($result);
		return $result;
	}

	public function get_reimaning_pagu($request_created_at, $employee_id, $eg_prj, $eg_pri, $eg_pk, $request_id = null){
		
		if ($request_id != null) {
			$sql = "SELECT 	
						tanggal_kuitansi
					FROM		
						hris_medical_reimbursment_item
					WHERE request_id = '$request_id' GROUP BY tanggal_kuitansi ORDER BY tanggal_kuitansi ASC LIMIT 1";		
			$query = $this->db->query($sql);
			$result = $query->result();
			$tanggal_kuitansi = date('Y', strtotime($result[0]->tanggal_kuitansi));			
		}

		if (is_array($request_created_at)) {
			$year_request	=	date("Y", strtotime($request_created_at[0]->tanggal_kuitansi));
		} else {
			$year_request	=	date("Y", strtotime($request_created_at));
		}
		$year 				= $year_request;

		$today = $this->today;

		$sql_eg = "SELECT 	
						employee_group as employee_group,
						start_date as start_date,
						reason_of_action as reason_of_action,
						join_date as join_date
					FROM		
						hris_employee
					WHERE nik = '$employee_id' ORDER BY id_employee DESC";
					
		$query_eg 				= $this->db->query($sql_eg);
		$res_eg					= $query_eg->result();
		$res_eg 				= $this->my_array_unique($res_eg);

		$no = 1;
		$result = [];

		foreach ($res_eg as $rown) {
			$rowArray = (array) $rown;
			$rowArray['no'] = $no++;
			$result[] = $rowArray;
		}

		$res_eg = $result;
		

		$data_eg = [];
		foreach($res_eg as $idx){
			$year_eg_sd = str_replace('-', '', (string) decrypt($idx['start_date']));
			$year_eg_sd = (int) substr($year_eg_sd, 0, 4);
			
			if(($year == $year_eg_sd) && (decrypt($idx['reason_of_action']) == 'Promosi')){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];

				$get_before = $idx['no'] + 1;
				foreach ($res_eg as $rowb) {
					if ($rowb->no == $get_before) {
						$data_before = $rowb;
						break;
					}
				}

				if (!empty($data_before)) {
					$data_eg[] = [
						'employee_group'     => $data_before['employee_group'],
						'start_date'         => $data_before['start_date'],
						'reason_of_action'   => $data_before['reason_of_action'],
						'join_date'   		 => $data_before['join_date']
					];
				}
			}elseif(($year == $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year < $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year > $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}
		}

		
		$res_eg_new 			= decrypt($data_eg[0]['employee_group']);
		$res_sd_new 			= decrypt($data_eg[0]['start_date']);
		$res_jd_new    			= decrypt($data_eg[0]['join_date']);
		$reason_of_action		= decrypt($data_eg[0]['reason_of_action']);
		$res_eg_old 			= (!empty(($data_eg[1]['employee_group']))) ? decrypt(($data_eg[1]['employee_group'])) : '';

		$sql2new = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query2new 	= $this->db->query($sql2new);
		$res2new 	= $query2new->result();
		$pagu_jalan_tahun_new 	= (!empty(($res2new[0]->pagu_tahun))) ? ($res2new[0]->pagu_tahun) : 0;

		$sql3new = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query3new 	= $this->db->query($sql3new);
		$res3new 	= $query3new->result();
		$pagu_inap_tahun_new 	= (!empty(($res3new[0]->pagu_tahun))) ? ($res3new[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_new 	= (!empty(($res3new[0]->pagu_kamar_hari))) ? ($res3new[0]->pagu_kamar_hari) : 0;
		
		
		$sql2old = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query2old 	= $this->db->query($sql2old);
		$res2old 	= $query2old->result();
		$pagu_jalan_tahun_old 	= (!empty(($res2old[0]->pagu_tahun))) ? ($res2old[0]->pagu_tahun) : 0;

		$sql3old = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query3old 	= $this->db->query($sql3old);
		$res3old 	= $query3old->result();
		$pagu_inap_tahun_old 	= (!empty(($res3old[0]->pagu_tahun))) ? ($res3old[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_old 	= (!empty(($res3old[0]->pagu_kamar_hari))) ? ($res3old[0]->pagu_kamar_hari) : 0;

    	$join_date         		= DateTime::createFromFormat('Ymd', $res_jd_new);
		$start_date 			= DateTime::createFromFormat('Ymd', $res_sd_new);
		$start_date 			= $start_date->format('Y');
		// $year 					= date("Y");

		if( ($start_date == $year) AND (!empty($res_eg_old)) AND ($reason_of_action == 'Promosi') ){
			$yearOld = $year-1;
			$yearNew = $year+1;
			$tgl1 = $yearOld."-12-31";
			$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
			$tgl2 = $tgl2->format('Y-m-d');
			$tgl22 = date('Y-m-d', strtotime('-1 days', strtotime($tgl2)));
    		$tgl3 = $yearNew."-01-01";

			$diff_old                = abs(strtotime($tgl22) - strtotime($tgl1));
			$join_years_old          = floor($diff_old / (365*60*60*24));
			$join_months_old         = floor(($diff_old - $join_years_old * 365*60*60*24) / (30*60*60*24));
			$join_days_old         	 = round($diff_old / (60 * 60 * 24));

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));
			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun_old = ((!empty(($pagu_inap_tahun_old))) ? ($pagu_inap_tahun_old) : 0);
			$pagu_pro_inap_tahun_old = ($join_days_old/365)* $pagu_inap_tahun_old;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new + $pagu_pro_inap_tahun_old;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun_old = ((!empty($pagu_jalan_tahun_old)) ? ($pagu_jalan_tahun_old) : 0);
			$pagu_pro_jalan_tahun_old = ($join_days_old/365) * $pagu_jalan_tahun_old;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new + $pagu_pro_jalan_tahun_old;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;
			
		}else if( ($join_date->format('Ymd') > $year.'0101') && $employee_id != '20240059' && $employee_id != '20240063' && $employee_id != '20240067'){
			$yearNew = $year+1;
			$tgl2 = DateTime::createFromFormat('Ymd', $res_jd_new);
			$tgl2 = $tgl2->format('Y-m-d');
    		$tgl3 = $yearNew."-01-01";

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));

			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;
			
		}else{

			if(($year == $start_date) || ($year < $start_date)){
				$pagu_jalan_tahun	= $pagu_jalan_tahun_old;
				$pagu_inap_tahun	= $pagu_inap_tahun_old;
				$pagu_inap_kamar 	= $pagu_inap_kamar_old;

			}else{
				$pagu_jalan_tahun	= $pagu_jalan_tahun_new;
				$pagu_inap_tahun	= $pagu_inap_tahun_new;
				$pagu_inap_kamar 	= $pagu_inap_kamar_new;

			}
		
		}

		$sql4 = "SELECT 	
					pagu_one_focus_tahun as pagu_one_focus_tahun,
					pagu_two_focus_tahun as pagu_two_focus_tahun,
					pagu_frame_dua_tahun as pagu_frame_dua_tahun
				FROM		
					hris_medical_pagu_kacamata
				WHERE grade = '$res_eg_new' AND start_date <= '$today' AND end_date > '$today'";
		$query4 = $this->db->query($sql4);
		$res4 	= $query4->result();
		$pagu_one_focus_tahun 	= $res4[0]->pagu_one_focus_tahun;
		$pagu_two_focus_tahun 	= $res4[0]->pagu_two_focus_tahun;
		$pagu_frame_dua_tahun 	= $res4[0]->pagu_frame_dua_tahun;
		

		$sql5 = "SELECT 	
					SUM(a.penggantian) as penggantian_rawat_jalan
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and b.id_eg_prj = '$eg_prj' and a.tor_grandparent = '1' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' )";
		// dumper($sql5);
		$query5 = $this->db->query($sql5);
		$res5 	= $query5->result();
		$res5 	= $res5[0]->penggantian_rawat_jalan;


		$sql6 = "SELECT 	
					SUM(a.penggantian ) as penggantian_rawat_inap
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and b.id_eg_pri = '$eg_pri' and a.tor_grandparent = '2' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' )";

		$query6 = $this->db->query($sql6);
		$res6 	= $query6->result();
		$res6 	= $res6[0]->penggantian_rawat_inap;

		if ($request_id != null) {
			$sql7 = "SELECT 	
				SUM(CASE
					WHEN a.tor_child = '12'
						THEN a.penggantian
					ELSE 0
				END)  as frame,
				SUM(CASE
					WHEN a.tor_child = '13'
						THEN a.penggantian
					ELSE 0
				END)  as one_focus,
				SUM(CASE
					WHEN a.tor_child = '14'
						THEN a.penggantian
					ELSE 0
				END)  as two_focus
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and b.id_eg_pk = '$eg_pri' and a.tor_grandparent = '3' and a.request_id <= '$request_id' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and (a.tor_child = '12' or a.tor_child = '13' or a.tor_child = '14	') and year(a.tanggal_kuitansi) LIKE '%$tanggal_kuitansi%'
				";

		} else {
			$sql7 = "SELECT 	
				SUM(CASE
					WHEN a.tor_child = '12'
						THEN a.penggantian
					ELSE 0
				END)  as frame,
				SUM(CASE
					WHEN a.tor_child = '13'
						THEN a.penggantian
					ELSE 0
				END)  as one_focus,
				SUM(CASE
					WHEN a.tor_child = '14'
						THEN a.penggantian
					ELSE 0
				END)  as two_focus
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and b.id_eg_pk = '$eg_pri' and a.tor_grandparent = '3' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and (a.tor_child = '12' or a.tor_child = '13' or a.tor_child = '14	') and year(a.tanggal_kuitansi) LIKE '%$year_request%'
				";
		}


		$query7 = $this->db->query($sql7);
		$res7 	= $query7->result();
		$frame 		= $res7[0]->frame;
		$one_focus 	= $res7[0]->one_focus;
		$two_focus 	= $res7[0]->two_focus;

		$sqlhmr = "SELECT 	
					id_eg_prj as id_eg_prj,
					id_eg_pri as id_eg_pri,
					id_eg_pk as id_eg_pk
				FROM		
					hris_medical_reimbursment
				WHERE employee_id = '$employee_id' ORDER BY id DESC LIMIT 2";
		$queryhmr = $this->db->query($sqlhmr);
		$reshmr 		= $queryhmr->result();
		$id_eg_prj_old 		= (!empty(($reshmr[1]->id_eg_prj))) ? (($reshmr[1]->id_eg_prj)) : '';
		$id_eg_pri_old 		= (!empty(($reshmr[1]->id_eg_pri))) ? (($reshmr[1]->id_eg_pri)) : '';
		$id_eg_pk_old 		= (!empty(($reshmr[1]->id_eg_pk))) ? (($reshmr[1]->id_eg_pk)) : '';

		//============= new ====================
		if ($request_id != null) {
			$sql8 = "SELECT 	
					SUM(a.penggantian) as penggantian_rawat_jalan
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and a.tor_grandparent = '1' and a.request_id <= '$request_id' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and year(a.tanggal_kuitansi) LIKE '%$tanggal_kuitansi%'
				";
		} else {
			$sql8 = "SELECT 	
					SUM(a.penggantian) as penggantian_rawat_jalan
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and a.tor_grandparent = '1' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and year(a.tanggal_kuitansi) LIKE '%$year_request%'
				";
		}
		
		$query8 = $this->db->query($sql8);
		$res8 	= $query8->result();
		$res8 	= (!empty(($res8[0]->penggantian_rawat_jalan))) ? (($res8[0]->penggantian_rawat_jalan)) : 0;

		//=================== new ==========================
		if ($request_id != null) {
			$sql9 = "SELECT 	
					SUM(a.penggantian) as penggantian_rawat_inap
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and a.tor_grandparent = '2' and a.request_id <= '$request_id' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and year(a.tanggal_kuitansi) LIKE '%$tanggal_kuitansi%'
				";
		} else {
			$sql9 = "SELECT 	
					SUM(a.penggantian) as penggantian_rawat_inap
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
				LEFT JOIN form_request c ON b.request_id = c.id
				WHERE b.employee_id = '$employee_id' and a.tor_grandparent = '2' and ( c.is_status not like '0' and c.is_status not like '2' and c.is_status not like '4' ) and year(a.tanggal_kuitansi) LIKE '%$year_request%'
				";

		}		

		$query9 = $this->db->query($sql9);
		$res9 	= $query9->result();
		$res9 	= (!empty(($res9[0]->penggantian_rawat_inap))) ? (($res9[0]->penggantian_rawat_inap)) : 0;

		if($id_eg_prj_old == $eg_prj){
			$penggunaan_jalan = $res8;
		}else{
			$penggunaan_jalan = $res8;
		}

		if($id_eg_pri_old == $eg_pri){
			$penggunaan_inap = $res9;
		}else{
			$penggunaan_inap = ($res9);
		}
		
		$data = array(
			'pagu_jalan_tahun' => ( $pagu_jalan_tahun - $penggunaan_jalan),
			'pagu_inap_tahun' => ( $pagu_inap_tahun - $penggunaan_inap),
			'pagu_inap_kamar' => $pagu_inap_kamar,
			'pagu_one_focus_tahun' => ($pagu_one_focus_tahun - $one_focus),
			'pagu_two_focus_tahun' => ($pagu_two_focus_tahun - $two_focus),
			'pagu_frame_dua_tahun' => ($pagu_frame_dua_tahun - $frame)
		);

		return $data;
	}

	//
		public function my_array_unique($array, $keep_key_assoc = false){
			$duplicate_keys = array();
			$tmp = array();       
		
			foreach ($array as $key => $val){
				if (is_object($val))
					$val = (array)$val;
		
				if (!in_array($val, $tmp))
					$tmp[] = $val;
				else
					$duplicate_keys[] = $key;
			}
		
			foreach ($duplicate_keys as $key)
				unset($array[$key]);
		
			return $keep_key_assoc ? $array : array_values($array);
		}


		public function request_submited_mdcr($id){
			$sql = "UPDATE form_request SET is_status='1' WHERE id = '".$id."'";
			$query = $this->db->query($sql);

			// $nik 				= $this->session->userdata('employee_id');
			// $sql 				= "SELECT TOP 1 id_employee FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
			// $query 				= $this->db->query($sql);
			// $res 				= $query->result();
			// $id_employee			= encrypt($res[0]->id_employee);
			$date = $this->date;
			$sql2 = "UPDATE hris_medical_reimbursment SET is_status='1', created_at = '$date' WHERE request_id = '".$id."'";
			$this->db->query($sql2);

			$sql3 = "UPDATE request_notes SET is_status= null WHERE request_id = '".$id."'";
			$this->db->query($sql3);
			
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getFamilyChild($tanggal_kuitansi){
			$employee_id 	= $this->session->userdata('nik');
			$f_members		= encrypt('Child');
			$sql 			= "SELECT * FROM hris_family_employee WHERE nik='$employee_id' AND family_members = '$f_members' AND status_act = 'Y' ORDER BY id_family ASC LIMIT 3";
			$query  		= $this->db->query($sql);
			$output 		= '<option value="">Pilih Anak</option>';
			foreach($query->result() as $row)
			{
				$ulang_tahun 	=	decrypt($row->member_birthdate);
				$umur 			= $this->hitung_umur_dari_kuitansi($ulang_tahun, $tanggal_kuitansi);
				if($umur <= 21 && $employee_id != '20180115'){
				$member_names 	= str_replace("||","'", decrypt($row->member_names));
				$output .= '<option value="'.$row->member_names.'">'.$member_names.' - Th '.$umur.'</option>';
				}
				if($employee_id == '20180115' ){
				$member_names 	= str_replace("||","'", decrypt($row->member_names));
				$output .= '<option value="'.$row->member_names.'">'.$member_names.' - Th '.$umur.'</option>';
				}
			}
			return $output;
		}

		public function getDetailFamilyChild($id, $tanggal_kuitansi, $employee_id){
			$f_members		= encrypt('Child');
			$sql 			= "SELECT * FROM hris_family_employee WHERE nik='$employee_id' AND family_members = '$f_members' AND status_act = 'Y' ORDER BY id_family ASC LIMIT 3";
			$query  		= $this->db->query($sql);
			$output 		= '';
			foreach($query->result() as $row)
			{
				$ulang_tahun 	=	decrypt($row->member_birthdate);
				$umur 			= $this->hitung_umur_dari_kuitansi($ulang_tahun, $tanggal_kuitansi);
				if($umur <= 21){
					$member_names 	= str_replace("||","'", decrypt($row->member_names));
					if ($row->member_names == $id){
						$output .= '<option value="'.$row->member_names.'" selected>'.$member_names.' - Th '.$umur.'</option>';
					} else {
						$output .= '<option value="'.$row->member_names.'">'.$member_names.' - Th '.$umur.'</option>';
					}
				}
			}

			return $output;
		}
		
		public function getFamilySpouse($tanggal_kuitansi){
			$employee_id 	= $this->session->userdata('employee_id');
			$f_members		= encrypt('Spouse');
			$sql 			= "SELECT * FROM hris_family_employee WHERE nik='$employee_id' AND family_members = '$f_members' ORDER BY id_family ASC LIMIT 1";
			$query  		= $this->db->query($sql);
			$output 		= '<option value="">Pilih Pasangan</option>';
			foreach($query->result() as $row)
			{
				$member_names 	= str_replace("||","'", decrypt($row->member_names));
				$output .= '<option value="'.$row->member_names.'">'.$member_names.'</option>';
			}

			return $output;
		}

		public function getDetailFamilySpouse($id, $employee_id){
			$f_members		= encrypt('Spouse');
			$sql 			= "SELECT * FROM hris_family_employee WHERE nik='$employee_id' AND family_members = '$f_members' ORDER BY id_family ASC LIMIT 1";
			$query  		= $this->db->query($sql);
			$output = '';
			foreach($query->result() as $row)
			{
				$member_names 	= str_replace("||","'", decrypt($row->member_names));
				if ($row->member_names == $id){
					$output .= '<option value="'.$row->member_names.'" selected>' .$member_names. '</option>';
				}else{
					$output .= '<option value="'.$row->member_names.'">'.$member_names.'</option>';
				}
			}
			return $output;
		}

		public function save_additional_mdcr($data){
			
			try{
			  $this->db->insert('hris_medical_reimbursment_additional', $data);
			  return true;
			}catch(Exception $e){
			}
		}

		public function update_additional_mdcr($data){
			$this->db->where('request_id', $data['request_id']);
			if ($this->db->update('hris_medical_reimbursment_additional', $data)) {
				return true;
			} else {
				return false;
			}
		}

		public function cek_additional_table($id_request){
			$sql 		= "SELECT * FROM hris_medical_reimbursment_additional WHERE request_id ='$id_request'";
			$query 		= $this->db->query($sql);
			$res 		= $query->result();

			return $res;
		}

		public function cek_limit_harga_kamar(){
			$today				= $this->today;
			$employee_id 				= $this->session->userdata('employee_id');
			$sql 				= "SELECT employee_group FROM hris_employee WHERE nik = $employee_id ORDER BY id_employee DESC LIMIT 1";
			$query 				= $this->db->query($sql);
			$res 				= $query->result();
			$employee_group 	= $res[0]->employee_group;
			$eg 				= decrypt($employee_group);

			$sql2 				= "SELECT pagu_kamar_hari as pagu_kamar_hari FROM hris_medical_pagu_rawat_inap WHERE grade LIKE '$eg' AND start_date <= '$today' AND end_date > '$today'";
			$query2 			= $this->db->query($sql2);
			$res2 				= $query2->result();
			$pagu_inap_kamar 	= $res2[0]->pagu_kamar_hari;

			return $pagu_inap_kamar;
		}

		public function cek_limit_maternity($status){
			$today				= $this->today;
			$employee_id 				= $this->session->userdata('employee_id');
			$sql 				= "SELECT employee_group FROM hris_employee WHERE nik = $employee_id ORDER BY id_employee DESC LIMIT 1";
			$query 				= $this->db->query($sql);
			$res 				= $query->result();
			$employee_group 	= $res[0]->employee_group;
			$eg 				= decrypt($employee_group);

			$sql2 				= "SELECT pagu_tahun as pagu_tahun_maternity FROM hris_medical_pagu_maternity WHERE grade LIKE '$eg' AND melahirkan LIKE '$status' AND start_date <= '$today' AND end_date > '$today'";
			$query2 			= $this->db->query($sql2);
			$res2 				= $query2->result();
			$pagu_tahun_maternity 	= $res2[0]->pagu_tahun_maternity;

			return $pagu_tahun_maternity;
		}

		public function cek_tanggal_pengambilan_kacamata($request_id, $request_grandparent, $request_parent, $request_child){

			$employee_id 				= $this->session->userdata('employee_id');
			$sql 				= "SELECT a.id, a.tanggal_kuitansi as tanggal_req, a.penggantian FROM hris_medical_reimbursment_item a LEFT JOIN form_request b ON a.request_id = b.id	WHERE a.employee_id LIKE '$employee_id' AND a.tor_grandparent LIKE '$request_grandparent' AND a.tor_parent LIKE '$request_parent' AND b.is_status NOT LIKE '4' ORDER BY a.id DESC LIMIT 1";
			$query 				= $this->db->query($sql);
			$res 				= $query->result();
			$data = [];
			if($res){
				$data['item_id'] = $res[0]->id;
				$data['tanggal_req'] = $res[0]->tanggal_req;
				$data['penggantian'] = $res[0]->penggantian;
			}else{
				$data['item_id'] = 'Kosong'; 
				$data['tanggal_req'] = 'Kosong';
				$data['penggantian'] = 0;
			}
			
			return $data;

			// if(!empty($tanggal_req)){
			// 	return $tanggal_req;	
			// }else{
			// 	$tanggal_req = 'Kosong';
			// 	return $tanggal_req;
			// }
			
			//return $tanggal_req;
		}

		function hitung_umur_dari_kuitansi($tanggal_lahir, $tanggal_kuitansi){
			$birthDate = new DateTime($tanggal_lahir);
			$tanggal_kuitansi = new DateTime($tanggal_kuitansi);
			if ($birthDate > $tanggal_kuitansi) { 
				exit("0");
			}
			$y = $tanggal_kuitansi->diff($birthDate)->y;
			return $y;
		}

		public function get_Grandparent(){
			$sql = "SELECT * FROM hris_medical_type_of_reimbursment_grandparent";
			$query  = $this->db->query($sql);
			$output = '<option value="">Jenis Penggantian</option>';
			foreach($query->result() as $row)
			{
				$output .= '<option value="'.$row->id.'">'.$row->grandparent.'</option>';
			}
			return $output;
		}

		public function edit_get_Grandparent($id){
			$sql = "SELECT * FROM hris_medical_type_of_reimbursment_grandparent";
			$query  = $this->db->query($sql);

			$output = '';
			foreach($query->result() as $row)
			{
				if ($row->id == $id){
					$output .= '<option value="'.$row->id.'" selected>' .$row->grandparent. '</option>';
				}else{
					$output .= '<option value="'.$row->id.'">'.$row->grandparent.'</option>';
				}
				
			}
			return $output;
		}

		public function get_Parent($id_grandparent, $emp_group = null){
			$user_nik = $this->session->userdata('nik');
			if ($user_nik == '00000000') {
				$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1";
			} else {
				switch ($emp_group) {
				case 'GOL A':
				case 'GOL B':
				case 'GOL C':
				case 'GOL D':
				case 'GOL E':
					$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1";
					break;			
				default:
					$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1 and parent != 'Medical Check Up'";
					break;
				}
			}

			$query  = $this->db->query($sql);
			$output = '<option value="">Sub Penggantian</option>';
			foreach($query->result() as $row)
			{
				$output .= '<option value="'.$row->id.'">'.$row->parent.'</option>';
			}
			return $output;
		}

		public function edit_get_Parent($record, $emp_group = null){
			$id = $record[0]->tor_parent;
			$id_grandparent = $record[0]->tor_grandparent;
			$user_nik = $this->session->userdata('nik');
			if ($user_nik == '00000000') {
				$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1";
			} else {
				switch ($emp_group) {
				case 'GOL A':
				case 'GOL B':
				case 'GOL C':
				case 'GOL D':
				case 'GOL E':
					$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1";
					break;			
				default:
					$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1 and parent != 'Medical Check Up'";
					break;
				}
			}
			
			$query  = $this->db->query($sql);

			$output = '';
			foreach($query->result() as $row)
			{
				if ($row->id == $id){
					$output .= '<option value="'.$row->id.'" selected>' .$row->parent. '</option>';
				}else{
					$output .= '<option value="'.$row->id.'">'.$row->parent.'</option>';
				}
				
			}
			return $output;
		}

		public function get_Child($id_parent){
			$sql = "SELECT * FROM hris_medical_type_of_reimbursment_child WHERE parent='$id_parent' and is_active = 1";
			$query  = $this->db->query($sql);
			$output = '<option value="">Penggantian</option>';
			foreach($query->result() as $row)
			{
			$output .= '<option value="'.$row->id.'">'.$row->child.'</option>';
			}
			return $output;
		}

		public function edit_get_Child($record){
			$id = $record[0]->tor_child;
			$id_parent = $record[0]->tor_parent;
			$sql = "SELECT * FROM hris_medical_type_of_reimbursment_child WHERE parent = '$id_parent' and is_active = 1 ";
			$query  = $this->db->query($sql);

			$output = '';
			foreach($query->result() as $row)
			{
				if ($row->id == $id){
					$output .= '<option value="'.$row->id.'" selected>' .$row->child. '</option>';
				}else{
					$output .= '<option value="'.$row->id.'">'.$row->child.'</option>';
				}
				
			}
			return $output;
		}

		public function get_header_mdcr($request_id){

			$sql = "SELECT 	
						a.id as id_fr,
						b.id as id_hmr,
						a.request_number as request_number,
						a.form_type as form_type,
						a.is_status as is_status,
						a.is_status_progress as is_status_progress,
						a.created_by as created_by,
						a.created_at as created_at,
	          			a.updated_by as updated_by,
	          			a.updated_at as updated_at,
	          			a.submitted_at as submitted_at,
	          			a.revised_at as revised_at,
						a.employee_id as employee_id,
						c.position as position,
						b.complete_name as complete_name,
						b.request_id as request_id,
						b.employee_group as employee_group,
						b.phone_number as phone_number,
						b.department as department,
						b.personnel_area as personnel_area,
						b.id_eg_prj as id_eg_prj,
						b.id_eg_pri as id_eg_pri,
						b.id_eg_pk as id_eg_pk,
						b.marital_status as marital_status,
						b.gender as gender,
						a.is_status_admin_hr as is_status_admin_hr,
						a.revise as revise,
						a.is_status_divhead_hr as is_status_divhead_hr
					FROM		
						form_request a
					LEFT JOIN hris_medical_reimbursment b ON b.request_id = a.id
					LEFT JOIN v_hris_employee_updated c ON c.nik = a.employee_id
					WHERE a.id = '$request_id'";

			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;

			
		}

		public function get_data_couple_employee($employee_id="", $date=""){
			if($date == "" || $date == NULL){
				$dateformat 		= $this->today;
			}else{
				$dateformat			= $date;
			}
			
			$sql 				= "SELECT * FROM hris_couple_employee WHERE (male_nik LIKE '$employee_id' OR female_nik LIKE '$employee_id') AND start_date <= '$dateformat' and end_date >= '$dateformat' ORDER BY id DESC LIMIT 1";
			$query 				= $this->db->query($sql);
			$res 				= $query->result();
			// dumper($res);
			
			$male_nik 			= (!empty(($res[0]->male_nik))) ? $res[0]->male_nik : '';
			$male_employee		= (!empty(($res[0]->male_employee))) ? decrypt($res[0]->male_employee) : '';
			$female_nik			= (!empty(($res[0]->female_nik))) ? $res[0]->female_nik : '';
			$female_employee		= (!empty(($res[0]->female_employee))) ? decrypt($res[0]->female_employee) : '';

			$sql_male			= "SELECT * FROM hris_employee WHERE nik = '$male_nik' ORDER BY id_employee DESC LIMIT 1";
			$query_male			= $this->db->query($sql_male);
			$res_male			= $query_male->result();
			$male_employee_group = (!empty(($res_male[0]->employee_group))) ? decrypt($res_male[0]->employee_group) : '';
			
			$sql_female			= "SELECT * FROM hris_employee WHERE nik = '$female_nik' ORDER BY id_employee DESC LIMIT 1";
			$query_female		= $this->db->query($sql_female);
			$res_female			= $query_female->result();
			$female_employee_group = (!empty(($res_female[0]->employee_group))) ? decrypt($res_female[0]->employee_group) : '';

			$sql_male_gol		= "SELECT * FROM hris_employee_group WHERE employee_group = '$male_employee_group'";
			$query_male_gol		= $this->db->query($sql_male_gol);
			$res_male_gol		= $query_male_gol->result();
			$res_male_gol		= (!empty(($res_male_gol[0]->id))) ? $res_male_gol[0]->id : '';
			
			$sql_female_gol		= "SELECT * FROM hris_employee_group WHERE employee_group = '$female_employee_group'";
			$query_female_gol	= $this->db->query($sql_female_gol);
			$res_female_gol		= $query_female_gol->result();
			$res_female_gol		= (!empty(($res_female_gol[0]->id))) ? $res_female_gol[0]->id : '';
			
			if($res_male_gol > $res_female_gol){
				$hak_pengajuan = $female_nik;
			}else if($res_female_gol > $res_male_gol){
				$hak_pengajuan = $male_nik;
			}else if($res_male_gol = $res_female_gol){
				$hak_pengajuan = $male_nik;
			}else{
				$hak_pengajuan = $employee_id;
			}

			$DataCouple = array(
				'male_nik'  			=> $male_nik,
				'male_employee'			=> $male_employee,
				'male_gol'				=> $male_employee_group,
				'female_nik'  			=> $female_nik,
				'female_employee'		=> $female_employee,
				'female_gol'			=> $female_employee_group,
				'hak_pengajuan'			=> $hak_pengajuan);
			
			if($DataCouple){
				return $DataCouple;
			}

		}

		public function getFamilyActSpouse($employee_id){
			$spouse			= encrypt('Spouse');
			$sql 			= "SELECT * FROM hris_family_employee WHERE nik='$employee_id' and family_members = '$spouse' ORDER BY id_family DESC LIMIT 1";
			$query  		= $this->db->query($sql);
			$res 			= $query->result();
			$member_names	= (!empty(($res[0]->member_names))) ? $res[0]->member_names : '';
			return $member_names;
		}
		
		// public function get_detail_mdcr($request_id){

		// 	$sql = "SELECT 	
		// 				*
		// 			FROM		
		// 				hris_medical_reimbursment_item
		// 			WHERE request_id = '$request_id'
		// 			LEFT JOIN ";

		// 	$query = $this->db->query($sql);
		// 	$res = $query->result();
		// 	return $res;

			
		// }

		public function del_draft_request_mdcr($id_request){
			$sql_hmr = "DELETE FROM hris_medical_reimbursment where request_id = '".$id_request."'";
			$this->db->query($sql_hmr);

			$sql = "DELETE FROM form_request where id = '".$id_request."'";
			$query = $this->db->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function cek_efektifitas_kuitansi($tanggal_kuitansi){
			$date = strtotime($tanggal_kuitansi);
			$dateformat = date('Y-m-d',$date);
			$sql = "SELECT 	
						efektif_kuitansi
					FROM		
						hris_efektifitas_kuitansi
					WHERE start_date <= '$dateformat' and end_date >= '$dateformat'
					ORDER BY id DESC";

			$query = $this->db->query($sql);
			$res = $query->result();
			if($res){
				$res = $res[0]->efektif_kuitansi;
				return $res;
			}else{
				return false;
			}
		}


		public function responseRequestFromAdminHR($request_id, $response)
		{
			$update_form_request = [
				'checked_at'        => $this->date,
				'is_status_admin_hr'=> 1
			];

			$this->db->where('id', $request_id);
			$query = $this->db->update('form_request', $update_form_request);

			if (!$query) {
				return false;
			}

			$this->db->select('id');
			$this->db->from('form_request');
			$this->db->where('id', $request_id);
			$this->db->where('is_status_divhead_hr', 1);
			$res = $this->db->get()->result();

			$request_id_form = !empty($res[0]->id) ? $res[0]->id : 0;

			if ($request_id_form != 0) {

				$update_layer = [
					'approval_status' => 'Approved',
					'updated_at'      => $this->date,
					'updated_by'      => $this->email
				];

				$this->db->where('request_id', $request_id);
				if ($this->db->update('form_approval', $update_layer)) {

					$this->db->where('request_id', $request_id);
					$this->db->update('hris_medical_reimbursment', ['is_status' => 3]);
					
					$this->db->where('id', $request_id);
					$this->db->update('form_request', ['is_status' => 3]);
				}
			}

			return true;
		}

		public function get_approval_mdcr($requestId){

			$sql = "SELECT 
						b.id_employee as employee_id,
						b.complete_name as complete_name,
						b.position as position,
						a.created_at as created_at,
						a.updated_at as approval_date
					FROM form_approval a
					LEFT JOIN v_hris_employee_updated b ON a.approval_employee_id = b.nik
					WHERE a.request_id = '$requestId' and b.is_active = 1 ORDER BY a.approval_priority ASC";
			$query= $this->db->query($sql);
			$res = $query->result();
			
			if($res){
				return $res;
			}else{
				return false;
			}
		}
		
		public function get_data_claim($no_req_mdcr){

			$sql = "SELECT
						*
					FROM hris_no_req_mdcr
					WHERE no_req_mdcr = '$no_req_mdcr'";
	        $query= $this->db->query($sql);
			// dumper($sql);
			$res = $query->result();
			$no_req_mdcr = (!empty(($res[0]->no_req_mdcr))) ? ($res[0]->no_req_mdcr) : '';
			// $sqlForm = "SELECT 
			// 			*
			// 		FROM form_request
			// 		WHERE no_req_mdcr = '$no_req_mdcr' AND is_status_admin_hr = 1 AND is_status_divhead_hr = 1 ORDER BY created_at ASC";
			//===================== new =========================
			// $sqlForm = "SELECT 
			// 			*
			// 		FROM form_request
			// 		WHERE no_req_mdcr = '$no_req_mdcr' AND is_status_admin_hr = 1 ORDER BY created_at ASC";


			$sqlForm = "SELECT 
						*
				FROM form_request 
				WHERE no_req_mdcr = '$no_req_mdcr' AND is_status_admin_hr = 1 ORDER BY employee_id ASC";
       
      $queryForm= $this->db->query($sqlForm);
			
			$res_form = $queryForm->result();	
			// dumper($res_form);

			if (!empty($res_form)) {

				foreach ($res_form as $key) {
					$row   = array();

					$sql 		= "SELECT * FROM hris_medical_reimbursment WHERE request_id ='$key->id'";
					$query 		= $this->db->query($sql);
					$res 		= $query->result();
					$id_hr_emp	= (!empty(($res[0]->id_hr_emp))) ? (decrypt($res[0]->id_hr_emp)) : '';
					$employee_id	= (!empty(($res[0]->employee_id))) ? ($res[0]->employee_id) : '';
					// dumper($employee_id);
					// == diubah zulvan dari mencari id_employee ke nik
					// $sql 		= "SELECT * FROM hris_employee WHERE id_employee ='$id_hr_emp' order by id_employee DESC";
					// == hasil revisi zulvan
					$sql 		= "SELECT * FROM hris_employee WHERE nik ='$employee_id' order by id_employee DESC";
					$query 		= $this->db->query($sql);
					$res 		= $query->result();
					$complete_name 		= (!empty(($res[0]->complete_name))) ? (decrypt($res[0]->complete_name)) : '';
					$cost_center 		= (!empty(($res[0]->cost_center))) ? (decrypt($res[0]->cost_center)) : '';
					$bankn 				= (!empty(($res[0]->bankn))) ? (decrypt($res[0]->bankn)) : '';
					// dumper($res);

					// $sql7 = "SELECT 	
					// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_kacamata,
					// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_kacamata
					// FROM		
					// 	hris_medical_reimbursment_item 
					// WHERE tor_grandparent = '3' AND request_id = '$key->id'";

					$sql7 = "SELECT 	
						SUM(penggantian) as total_pembayaran_kacamata,
						SUM(total_nominal_kuitansi) as total_claim_kacamata
					FROM		
						hris_medical_reimbursment_item 
					WHERE tor_grandparent = '3' AND request_id = '$key->id'";

					$query7 = $this->db->query($sql7);
					$res7 	= $query7->result();
					$res7PembayaranKacamata 	= (!empty(($res7[0]->total_pembayaran_kacamata))) ? (($res7[0]->total_pembayaran_kacamata)) : 0;
					$res7ClaimKacamata 		= (!empty(($res7[0]->total_claim_kacamata))) ? (($res7[0]->total_claim_kacamata)) : 0;
					
					// $sql8 = "SELECT 	
					// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_rawat_jalan,
					// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_rawat_jalan
					// FROM		
					// 	hris_medical_reimbursment_item 
					// WHERE tor_grandparent = '1' AND request_id = '$key->id'";

					$sql8 = "SELECT 	
						SUM(penggantian) as total_pembayaran_rawat_jalan,
						SUM(total_nominal_kuitansi) as total_claim_rawat_jalan
					FROM		
						hris_medical_reimbursment_item 
					WHERE tor_grandparent = '1' AND request_id = '$key->id'";

					$query8 = $this->db->query($sql8);
					$res8 	= $query8->result();
					$res8PembayaranJalan 	= (!empty(($res8[0]->total_pembayaran_rawat_jalan))) ? (($res8[0]->total_pembayaran_rawat_jalan)) : 0;
					$res8ClaimJalan 		= (!empty(($res8[0]->total_claim_rawat_jalan))) ? (($res8[0]->total_claim_rawat_jalan)) : 0;
					
					// $sql9 = "SELECT 	
					// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_rawat_inap,
					// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_rawat_inap
					// FROM		
					// 	hris_medical_reimbursment_item 
					// WHERE tor_grandparent = '2' AND request_id = '$key->id'";

					$sql9 = "SELECT 	
						SUM(penggantian) as total_pembayaran_rawat_inap,
						SUM(total_nominal_kuitansi) as total_claim_rawat_inap
					FROM		
						hris_medical_reimbursment_item 
					WHERE tor_grandparent = '2' AND request_id = '$key->id'";

					$query9 = $this->db->query($sql9);
					$res9 	= $query9->result();
					$res9PembayaranInap 	= (!empty(($res9[0]->total_pembayaran_rawat_inap))) ? (($res9[0]->total_pembayaran_rawat_inap)) : 0;
					$res9ClaimInap 		= (!empty(($res9[0]->total_claim_rawat_inap))) ? (($res9[0]->total_claim_rawat_inap)) : 0;

					$grand_total = $res8PembayaranJalan + $res9PembayaranInap + $res7PembayaranKacamata;

					$row['request_id'] = $key->id;
					$row['employee_id'] = $key->employee_id;
					$row['complete_name'] = $complete_name;
					$row['cost_center'] = $cost_center;
					$row['bankn'] = $bankn;
					$row['request_number'] = $key->request_number;
					$row['no_mdcr'] = $key->no_req_mdcr;
					$row['claim_jalan'] = $res8ClaimJalan;
					$row['pembayaran_jalan'] = $res8PembayaranJalan;
					$row['claim_inap'] = $res9ClaimInap;
					$row['pembayaran_inap'] = $res9PembayaranInap;
					$row['claim_kacamata'] = $res7ClaimKacamata;
					$row['pembayaran_kacamata'] = $res7PembayaranKacamata;
					$row['total'] = $grand_total;
					$data[] = (object)$row;
					
				}
				$outputF = $data;
				
			} else {
				$outputF = new ArrayObject();
			}
			
			if($outputF){
				return $outputF;
			}else{
				return false;
			}
		}
		
		public function get_total_data_claim($no_req_mdcr){

			$sql = "SELECT 
						*
					FROM hris_no_req_mdcr
					WHERE no_req_mdcr = '$no_req_mdcr'";
	        $query= $this->db->query($sql);
			$res = $query->result();
			$no_req_mdcr = (!empty(($res[0]->no_req_mdcr))) ? ($res[0]->no_req_mdcr) : '';

			$sqlForm = "SELECT 
						*
					FROM form_request
					WHERE no_req_mdcr = '$no_req_mdcr' AND is_status_admin_hr LIKE '1'";
	        $queryForm= $this->db->query($sqlForm);
			$res_form = $queryForm->result();

			if (!empty($res_form)) {

				foreach ($res_form as $key) {
					$row   = array();

					$sql 		= "SELECT * FROM hris_medical_reimbursment WHERE request_id ='$key->id'";
					$query 		= $this->db->query($sql);
					$res 		= $query->result();
					$id_hr_emp	= (!empty(($res[0]->id_hr_emp))) ? (decrypt($res[0]->id_hr_emp)) : '';
					
					$sql 		= "SELECT * FROM hris_employee WHERE id_employee ='$id_hr_emp'";
					$query 		= $this->db->query($sql);
					$res 		= $query->result();
					$complete_name 		= (!empty(($res[0]->complete_name))) ? (decrypt($res[0]->complete_name)) : '';
					$cost_center 		= (!empty(($res[0]->cost_center))) ? (decrypt($res[0]->cost_center)) : '';


					// $sql7 = "SELECT 	
					// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_kacamata,
					// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_kacamata
					// FROM		
					// 	hris_medical_reimbursment_item 
					// WHERE tor_grandparent = '3' AND request_id = '$key->id'";

					$sql7 = "SELECT 	
						SUM(penggantian) as total_pembayaran_kacamata,
						SUM(total_nominal_kuitansi) as total_claim_kacamata
					FROM		
						hris_medical_reimbursment_item 
					WHERE tor_grandparent = '3' AND request_id = '$key->id'";

					$query7 = $this->db->query($sql7);
					$res7 	= $query7->result();
					$res7PembayaranKacamata 	= (!empty(($res7[0]->total_pembayaran_kacamata))) ? (($res7[0]->total_pembayaran_kacamata)) : 0;
					$res7ClaimKacamata 		= (!empty(($res7[0]->total_claim_kacamata))) ? (($res7[0]->total_claim_kacamata)) : 0;
					
					// $sql8 = "SELECT 	
					// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_rawat_jalan,
					// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_rawat_jalan
					// FROM		
					// 	hris_medical_reimbursment_item 
					// WHERE tor_grandparent = '1' AND request_id = '$key->id'";

					$sql8 = "SELECT 	
						SUM(penggantian) as total_pembayaran_rawat_jalan,
						SUM(total_nominal_kuitansi) as total_claim_rawat_jalan
					FROM		
						hris_medical_reimbursment_item 
					WHERE tor_grandparent = '1' AND request_id = '$key->id'";

					$query8 = $this->db->query($sql8);
					$res8 	= $query8->result();
					$res8PembayaranJalan 	= (!empty(($res8[0]->total_pembayaran_rawat_jalan))) ? (($res8[0]->total_pembayaran_rawat_jalan)) : 0;
					$res8ClaimJalan 		= (!empty(($res8[0]->total_claim_rawat_jalan))) ? (($res8[0]->total_claim_rawat_jalan)) : 0;
					
					// $sql9 = "SELECT 	
					// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_rawat_inap,
					// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_rawat_inap
					// FROM		
					// 	hris_medical_reimbursment_item 
					// WHERE tor_grandparent = '2' AND request_id = '$key->id'";

					$sql9 = "SELECT 	
						SUM(penggantian) as total_pembayaran_rawat_inap,
						SUM(total_nominal_kuitansi) as total_claim_rawat_inap
					FROM		
						hris_medical_reimbursment_item 
					WHERE tor_grandparent = '2' AND request_id = '$key->id'";

					$query9 = $this->db->query($sql9);
					$res9 	= $query9->result();
					$res9PembayaranInap 	= (!empty(($res9[0]->total_pembayaran_rawat_inap))) ? (($res9[0]->total_pembayaran_rawat_inap)) : 0;
					$res9ClaimInap 		= (!empty(($res9[0]->total_claim_rawat_inap))) ? (($res9[0]->total_claim_rawat_inap)) : 0;

					$grand_total = $res8PembayaranJalan + $res9PembayaranInap + $res7PembayaranKacamata;
					$row['total'] = $grand_total;
					$data[] = (object)$row;
					
				}
				$total = 0;
				$count = count($data);
				
				for ($i = 0; $i < $count; $i++) {
					$total = $total + $data[$i]->total;
				}
				$outputF = $total;
				
			} else {
				$total = 0;
				$outputF = $total;
			}

			if($outputF){
				return $outputF;
			}else{
				return false;
			}
		}

		public function get_date_no_req_mdcr($no_req_mdcr){
			// $sql = "SELECT 
			// 			*
			// 		FROM hris_no_req_mdcr
			// 		WHERE no_req_mdcr = '$no_req_mdcr'";
			//================== old =====================
			// $sql = "SELECT DATE(created_at) dateonly FROM form_request WHERE no_req_mdcr = '$no_req_mdcr' AND is_status_admin_hr = 1 AND is_status_divhead_hr = 1
			// GROUP BY dateonly";
			//================== new =====================
			$sql = "SELECT DATE(created_at) dateonly FROM form_request WHERE no_req_mdcr = '$no_req_mdcr' AND is_status_admin_hr = 1 
			GROUP BY dateonly";
	    	$query= $this->db->query($sql);
			$res = $query->result();
			// if (count($res) > 1) {
			// 	$dt1 = $res[array_key_first($res)];
			// 	$dt2 = $res[array_key_last($res)];
			// 	$tgl = ''.$dt1.'...'.$dt2.'';
			// } else if (count($res) == 1) {
			// 	$tgl = $res[0];
			// } else {
			// 	$tgl = '';
			// }

			if (count($res) >= 1) {
				$dt = $res;
			} else {
				$dt = '';
			}
			
			
			if($dt){
				return $dt;
			}else{
				return false;
			}
		}

		public function get_data_claim_per_request($request_id){

			// $sql8 = "SELECT 	
			// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_rawat_jalan,
			// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_rawat_jalan
			// FROM		
			// 	hris_medical_reimbursment_item 
			// WHERE tor_grandparent = '1' AND request_id = '$request_id'";

			$sql8 = "SELECT 	
				SUM(penggantian) as total_pembayaran_rawat_jalan,
				SUM(total_nominal_kuitansi) as total_claim_rawat_jalan
			FROM		
				hris_medical_reimbursment_item 
			WHERE tor_grandparent = '1' AND request_id = '$request_id'";

			$query8 = $this->db->query($sql8);
			$res8 	= $query8->result();
			$res8PembayaranJalan 	= (!empty(($res8[0]->total_pembayaran_rawat_jalan))) ? (($res8[0]->total_pembayaran_rawat_jalan)) : 0;
			$res8ClaimJalan 		= (!empty(($res8[0]->total_claim_rawat_jalan))) ? (($res8[0]->total_claim_rawat_jalan)) : 0;
			
			// $sql9 = "SELECT 	
			// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_rawat_inap,
			// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_rawat_inap
			// FROM		
			// 	hris_medical_reimbursment_item 
			// WHERE tor_grandparent = '2' AND request_id = '$request_id'";

			$sql9 = "SELECT 	
				SUM(penggantian) as total_pembayaran_rawat_inap,
				SUM(total_nominal_kuitansi) as total_claim_rawat_inap
			FROM		
				hris_medical_reimbursment_item 
			WHERE tor_grandparent = '2' AND request_id = '$request_id'";

			$query9 = $this->db->query($sql9);
			$res9 	= $query9->result();
			$res9PembayaranInap 	= (!empty(($res9[0]->total_pembayaran_rawat_inap))) ? (($res9[0]->total_pembayaran_rawat_inap)) : 0;
			$res9ClaimInap 		= (!empty(($res9[0]->total_claim_rawat_inap))) ? (($res9[0]->total_claim_rawat_inap)) : 0;
			
			// $sql10 = "SELECT 	
			// 	SUM(cast(penggantian AS INTEGER)) as total_pembayaran_kacamata,
			// 	SUM(cast(total_nominal_kuitansi AS INTEGER)) as total_claim_kacamata
			// FROM		
			// 	hris_medical_reimbursment_item 
			// WHERE tor_grandparent = '3' AND request_id = '$request_id'";

			$sql10 = "SELECT 	
				SUM(penggantian) as total_pembayaran_kacamata,
				SUM(total_nominal_kuitansi) as total_claim_kacamata
			FROM		
				hris_medical_reimbursment_item 
			WHERE tor_grandparent = '3' AND request_id = '$request_id'";

			$query10 = $this->db->query($sql10);
			$res10 	= $query10->result();
			$res10PembayaranKacamata 	= (!empty(($res10[0]->total_pembayaran_kacamata))) ? (($res10[0]->total_pembayaran_kacamata)) : 0;
			$res10ClaimKacamata 		= (!empty(($res10[0]->total_claim_kacamata))) ? (($res10[0]->total_claim_kacamata)) : 0;

			$grand_total = $res8PembayaranJalan + $res9PembayaranInap + $res10PembayaranKacamata;

			if($grand_total){
				return $grand_total;
			}else{
				return false;
			}
		}

		public function get_data_claim_per_employee($request_id){

			$sql = "SELECT *
			FROM		
				form_request 
			WHERE id LIKE '$request_id' AND is_status_progress >= '2'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$form_request_id = (!empty(($res[0]->id))) ? (($res[0]->id)) : '';
			$employee_id = (!empty(($res[0]->employee_id))) ? (($res[0]->employee_id)) : '';

			$sql = "SELECT *
			FROM		
				hris_medical_reimbursment
			WHERE request_id LIKE '$form_request_id'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$created_at = (!empty(($res[0]->created_at))) ? (($res[0]->created_at)) : '';
			$year = date("Y",strtotime($res[0]->created_at));
	    	$start_date 	= $year."-01-01";

			$sql = "SELECT 	
					a.id as id,
					a.request_id as request_id,
					e.is_status as is_status,
					b.grandparent as tor_grandparent,
					c.parent as tor_parent,
					d.child as tor_child,
					a.jumlah_kuitansi as jumlah_kuitansi,
					a.total_nominal_kuitansi as total_kuitansi,
					a.penggantian as penggantian,
					a.keterangan as keterangan,
					a.additional as additional,
					a.docter as docter,
					a.diagnosa as diagnosa,
					a.tanggal_kuitansi as tanggal_kuitansi,
					a.create_date as create_date
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
				LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
				LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
				LEFT JOIN form_request e ON a.request_id = e.id
				WHERE a.request_id LIKE '$form_request_id'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		public function get_data_total_claim_per_employee($request_id){

			$sql = "SELECT *
			FROM		
				form_request 
			WHERE id LIKE '$request_id' AND is_status_progress >= '2'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$form_request_id = (!empty(($res[0]->id))) ? (($res[0]->id)) : '';
			$employee_id = (!empty(($res[0]->employee_id))) ? (($res[0]->employee_id)) : '';


			
			$sql = "SELECT request_id, MIN(create_at) AS create_at
					FROM form_logs
					WHERE activity_desc = 'Submitted_by_User' AND type = 'MDCR' AND request_id = '$form_request_id'
					GROUP BY request_id";
			$query 				= $this->db->query($sql);
			$res 				= $query->result();
			$created_at 		= (!empty(($res[0]->create_at))) ? (($res[0]->create_at)) : '';

			$sql = "SELECT MAX(tanggal_kuitansi) as tanggal_kuitansi
			FROM		
				hris_medical_reimbursment_item
			WHERE request_id LIKE '$form_request_id'";
			$query 				= $this->db->query($sql);
			$res 				= $query->result();
			$tanggal_kuitansi 	= (!empty(($res[0]->tanggal_kuitansi))) ? (($res[0]->tanggal_kuitansi)) : '';
			$year_created_at 	= date("Y",strtotime($tanggal_kuitansi));
			$year 				= date("Y",strtotime($tanggal_kuitansi));
	    	$start_date_created_form 	= $year."-01-01";		


			$year_request	=	strtotime($created_at);
			$year_request	=	date("Y",$year_request);
			$year 			= 	$year_request;

			$today = $this->today;			

			
			$sql_eg = "SELECT 	
						employee_group as employee_group,
						start_date as start_date,
						reason_of_action as reason_of_action,
						join_date as join_date
					FROM		
						hris_employee
					WHERE nik = '$employee_id' ORDER BY id_employee DESC";
					
			$query_eg 				= $this->db->query($sql_eg);
			$res_eg					= $query_eg->result();
			$res_eg 				= $this->my_array_unique($res_eg);

			$no = 1;
			$result = [];

			foreach ($res_eg as $rown) {
				$rowArray = (array) $rown;
				$rowArray['no'] = $no++;
				$result[] = $rowArray;
			}

			$res_eg = $result;
			

			$data_eg = [];
			foreach($res_eg as $idx){
				$year_eg_sd = str_replace('-', '', (string) decrypt($idx['start_date']));
				$year_eg_sd = (int) substr($year_eg_sd, 0, 4);
				
				if(($year == $year_eg_sd) && (decrypt($idx['reason_of_action']) == 'Promosi')){
					$data_eg[] = [
						'employee_group'           	=> $idx['employee_group'],
						'start_date' 				=> $idx['start_date'],
						'reason_of_action'   		=> $idx['reason_of_action'],
						'join_date'   				=> $idx['join_date']
					];

					$get_before = $idx['no'] + 1;
					foreach ($res_eg as $rowb) {
						if ($rowb->no == $get_before) {
							$data_before = $rowb;
							break;
						}
					}

					if (!empty($data_before)) {
						$data_eg[] = [
							'employee_group'     => $data_before['employee_group'],
							'start_date'         => $data_before['start_date'],
							'reason_of_action'   => $data_before['reason_of_action'],
							'join_date'   		 => $data_before['join_date']
						];
					}
				}elseif(($year == $year_eg_sd)){
					$data_eg[] = [
						'employee_group'           	=> $idx['employee_group'],
						'start_date' 				=> $idx['start_date'],
						'reason_of_action'   		=> $idx['reason_of_action'],
						'join_date'   				=> $idx['join_date']
					];
				}elseif(($year < $year_eg_sd)){
					$data_eg[] = [
						'employee_group'           	=> $idx['employee_group'],
						'start_date' 				=> $idx['start_date'],
						'reason_of_action'   		=> $idx['reason_of_action'],
						'join_date'   				=> $idx['join_date']
					];
				}elseif(($year > $year_eg_sd)){
					$data_eg[] = [
						'employee_group'           	=> $idx['employee_group'],
						'start_date' 				=> $idx['start_date'],
						'reason_of_action'   		=> $idx['reason_of_action'],
						'join_date'   				=> $idx['join_date']
					];
				}
			}

			
			$res_eg_new 			= decrypt($data_eg[0]['employee_group']);
			$res_sd_new 			= decrypt($data_eg[0]['start_date']);
			$res_jd_new    			= decrypt($data_eg[0]['join_date']);
			$reason_of_action		= decrypt($data_eg[0]['reason_of_action']);
			$res_eg_old 			= (!empty(($data_eg[1]['employee_group']))) ? decrypt(($data_eg[1]['employee_group'])) : '';
			



			$sql2new = "SELECT 	
						pagu_tahun as pagu_tahun
					FROM		
						hris_medical_pagu_rawat_jalan
					WHERE grade = '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
			$query2new 	= $this->db->query($sql2new);
			$res2new 	= $query2new->result();
			$pagu_jalan_tahun_new 	= (!empty(($res2new[0]->pagu_tahun))) ? ($res2new[0]->pagu_tahun) : 0;

			$sql3new = "SELECT 	
						pagu_kamar_hari as pagu_kamar_hari,
						pagu_tahun as pagu_tahun
					FROM		
						hris_medical_pagu_rawat_inap
					WHERE grade LIKE '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
			$query3new 	= $this->db->query($sql3new);
			$res3new 	= $query3new->result();
			$pagu_inap_tahun_new 	= (!empty(($res3new[0]->pagu_tahun))) ? ($res3new[0]->pagu_tahun) : 0;
			$pagu_inap_kamar_new 	= (!empty(($res3new[0]->pagu_kamar_hari))) ? ($res3new[0]->pagu_kamar_hari) : 0;
			
			
			$sql2old = "SELECT 	
						pagu_tahun as pagu_tahun
					FROM		
						hris_medical_pagu_rawat_jalan
					WHERE grade = '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
			$query2old 	= $this->db->query($sql2old);
			$res2old 	= $query2old->result();
			$pagu_jalan_tahun_old 	= (!empty(($res2old[0]->pagu_tahun))) ? ($res2old[0]->pagu_tahun) : 0;

			$sql3old = "SELECT 	
						pagu_kamar_hari as pagu_kamar_hari,
						pagu_tahun as pagu_tahun
					FROM		
						hris_medical_pagu_rawat_inap
					WHERE grade LIKE '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
			$query3old 	= $this->db->query($sql3old);
			$res3old 	= $query3old->result();
			$pagu_inap_tahun_old 	= (!empty(($res3old[0]->pagu_tahun))) ? ($res3old[0]->pagu_tahun) : 0;
			$pagu_inap_kamar_old 	= (!empty(($res3old[0]->pagu_kamar_hari))) ? ($res3old[0]->pagu_kamar_hari) : 0;

			$start_date = DateTime::createFromFormat('Ymd', $res_sd_new);
			$start_date = $start_date->format('Y');


			if( ($start_date == $year) && (!empty($res_eg_old)) && ($reason_of_action == 'Promosi') ){

				$yearOld = $year-1;
				$yearNew = $year+1;
				$tgl1 = $yearOld."-12-31";
				$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
				$tgl2 = $tgl2->format('Y-m-d');
				$tgl22 = date('Y-m-d', strtotime('-1 days', strtotime($tgl2)));
	    		$tgl3 = $yearNew."-01-01";

				$diff_old                = abs(strtotime($tgl22) - strtotime($tgl1));
				$join_years_old          = floor($diff_old / (365*60*60*24));
				$join_months_old         = floor(($diff_old - $join_years_old * 365*60*60*24) / (30*60*60*24));
				$join_days_old         	 = round($diff_old / (60 * 60 * 24));

				
				$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
				$join_years_new          = floor($diff_new / (365*60*60*24));
				$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
				$join_days_new         	 = round($diff_new / (60 * 60 * 24));
				
				$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
				$pagu_inap_tahun_old = ((!empty(($pagu_inap_tahun_old))) ? ($pagu_inap_tahun_old) : 0);
				$pagu_pro_inap_tahun_old = ($join_days_old/365)* $pagu_inap_tahun_old;
				$pagu_inap_tahun = $pagu_pro_inap_tahun_new + $pagu_pro_inap_tahun_old;
				
				$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
				$pagu_jalan_tahun_old = ((!empty($pagu_jalan_tahun_old)) ? ($pagu_jalan_tahun_old) : 0);
				$pagu_pro_jalan_tahun_old = ($join_days_old/365) * $pagu_jalan_tahun_old;
				$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new + $pagu_pro_jalan_tahun_old;

				$pagu_inap_kamar 	= $pagu_inap_kamar_new;
				

			}else if( ($start_date == $year) AND ($reason_of_action == 'Hiring') ){

				$yearNew = $year+1;
				$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
				$tgl2 = $tgl2->format('Y-m-d');
	    		$tgl3 = $yearNew."-01-01";

				
				$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
				$join_years_new          = floor($diff_new / (365*60*60*24));
				$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
				$join_days_new         	 = round($diff_new / (60 * 60 * 24));
				
				$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
				$pagu_inap_tahun = $pagu_pro_inap_tahun_new;
				
				$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
				$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new;

				$pagu_inap_kamar 	= $pagu_inap_kamar_new;
				

			}else{

				if(($year == $start_date) || ($year < $start_date)){
					$pagu_jalan_tahun	= $pagu_jalan_tahun_old;
					$pagu_inap_tahun	= $pagu_inap_tahun_old;
					$pagu_inap_kamar 	= $pagu_inap_kamar_old;

				}else{
					$pagu_jalan_tahun	= $pagu_jalan_tahun_new;
					$pagu_inap_tahun	= $pagu_inap_tahun_new;
					$pagu_inap_kamar 	= $pagu_inap_kamar_new;

				}

			}

			$sql4 = "SELECT 	
						pagu_one_focus_tahun as pagu_one_focus_tahun,
						pagu_two_focus_tahun as pagu_two_focus_tahun,
						pagu_frame_dua_tahun as pagu_frame_dua_tahun
					FROM		
						hris_medical_pagu_kacamata
					WHERE grade = '$res_eg_new' AND start_date <= '$today' AND end_date > '$today'";
			$query4 = $this->db->query($sql4);
			$res4 	= $query4->result();
			$pagu_one_focus_tahun 	= $res4[0]->pagu_one_focus_tahun;
			$pagu_two_focus_tahun 	= $res4[0]->pagu_two_focus_tahun;
			$pagu_frame_dua_tahun 	= $res4[0]->pagu_frame_dua_tahun;

			$sql = "SELECT 
				SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_jalan,
				SUM(a.penggantian) as total_penggantian_rawat_jalan
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN form_request b ON a.request_id = b.id
			WHERE b.is_status_progress >= '2' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '1' AND a.create_date BETWEEN '$start_date_created_form' AND '$created_at'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$total_nominal_kuitansi_rawat_jalan = (!empty(($res[0]->total_nominal_kuitansi_rawat_jalan))) ? (($res[0]->total_nominal_kuitansi_rawat_jalan)) : 0;
			$total_penggantian_rawat_jalan = (!empty(($res[0]->total_penggantian_rawat_jalan))) ? (($res[0]->total_penggantian_rawat_jalan)) : 0;
			

			$sql = "SELECT 
				SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_inap,
				SUM(a.penggantian) as total_penggantian_rawat_inap
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN form_request b ON a.request_id = b.id
			WHERE b.is_status_progress >= '2' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '2' AND a.create_date BETWEEN '$start_date_created_form' AND '$created_at'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$total_nominal_kuitansi_rawat_inap = (!empty(($res[0]->total_nominal_kuitansi_rawat_inap))) ? (($res[0]->total_nominal_kuitansi_rawat_inap)) : 0;
			$total_penggantian_rawat_inap = (!empty(($res[0]->total_penggantian_rawat_inap))) ? (($res[0]->total_penggantian_rawat_inap)) : 0;
			

			$sql = "SELECT 
				SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_kacamata,
				SUM(a.penggantian) as total_penggantian_kacamata
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN form_request b ON a.request_id = b.id
			WHERE b.is_status_progress >= '2' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '3' AND a.create_date BETWEEN '$start_date_created_form' AND '$created_at'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$total_nominal_kuitansi_kacamata = (!empty(($res[0]->total_nominal_kuitansi_kacamata))) ? (($res[0]->total_nominal_kuitansi_kacamata)) : 0;
			$total_penggantian_kacamata = (!empty(($res[0]->total_penggantian_kacamata))) ? (($res[0]->total_penggantian_kacamata)) : 0;

			$pagu_optic_tahun = ($pagu_one_focus_tahun + $pagu_two_focus_tahun + $pagu_frame_dua_tahun);


			$sql = "SELECT 
				SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_jalan_per_request,
				SUM(a.penggantian) as total_penggantian_rawat_jalan_per_request
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN form_request b ON a.request_id = b.id
			WHERE b.is_status_progress >= '2' AND a.request_id LIKE '$form_request_id' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '1' AND a.create_date BETWEEN '$start_date_created_form' AND '$created_at'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$total_nominal_kuitansi_rawat_jalan_per_request = (!empty(($res[0]->total_nominal_kuitansi_rawat_jalan_per_request))) ? (($res[0]->total_nominal_kuitansi_rawat_jalan_per_request)) : 0;
			$total_penggantian_rawat_jalan_per_request = (!empty(($res[0]->total_penggantian_rawat_jalan_per_request))) ? (($res[0]->total_penggantian_rawat_jalan_per_request)) : 0;
			
			$sql = "SELECT 
				SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_inap_per_request,
				SUM(a.penggantian) as total_penggantian_rawat_inap_per_request
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN form_request b ON a.request_id = b.id
			WHERE b.is_status_progress >= '2' AND a.request_id LIKE '$form_request_id' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '2' AND a.create_date BETWEEN '$start_date_created_form' AND '$created_at'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$total_nominal_kuitansi_rawat_inap_per_request = (!empty(($res[0]->total_nominal_kuitansi_rawat_inap_per_request))) ? (($res[0]->total_nominal_kuitansi_rawat_inap_per_request)) : 0;
			$total_penggantian_rawat_inap_per_request = (!empty(($res[0]->total_penggantian_rawat_inap_per_request))) ? (($res[0]->total_penggantian_rawat_inap_per_request)) : 0;
			

			$sql = "SELECT 
				SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_kacamata_per_request,
				SUM(a.penggantian)as total_penggantian_kacamata_per_request
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN form_request b ON a.request_id = b.id
			WHERE b.is_status_progress >= '2' AND a.request_id LIKE '$form_request_id' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '3' AND a.create_date BETWEEN '$start_date_created_form' AND '$created_at'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$total_nominal_kuitansi_kacamata_per_request = (!empty(($res[0]->total_nominal_kuitansi_kacamata_per_request))) ? (($res[0]->total_nominal_kuitansi_kacamata_per_request)) : 0;
			$total_penggantian_kacamata_per_request = (!empty(($res[0]->total_penggantian_kacamata_per_request))) ? (($res[0]->total_penggantian_kacamata_per_request)) : 0;


			$data = array(
				'pagu_jalan_tahun' => ( $pagu_jalan_tahun ),
				'total_nominal_kuitansi_rawat_jalan' => ( $total_nominal_kuitansi_rawat_jalan),
				'total_nominal_kuitansi_rawat_jalan_per_request' => ( $total_nominal_kuitansi_rawat_jalan_per_request),
				'total_penggantian_rawat_jalan' => ( $total_penggantian_rawat_jalan),
				'total_penggantian_rawat_jalan_per_request' => ( $total_penggantian_rawat_jalan_per_request),
				'balancing_jalan_tahun' => ( $pagu_jalan_tahun - $total_penggantian_rawat_jalan),
				'pagu_inap_tahun' => ( $pagu_inap_tahun ),
				'total_nominal_kuitansi_rawat_inap' => ( $total_nominal_kuitansi_rawat_inap),
				'total_nominal_kuitansi_rawat_inap_per_request' => ( $total_nominal_kuitansi_rawat_inap_per_request),
				'total_penggantian_rawat_inap' => ( $total_penggantian_rawat_inap),
				'total_penggantian_rawat_inap_per_request' => ( $total_penggantian_rawat_inap_per_request),
				'balancing_inap_tahun' => ( $pagu_inap_tahun - $total_penggantian_rawat_inap),
				'pagu_optic_tahun' => ( $pagu_optic_tahun ),
				'total_nominal_kuitansi_kacamata' => ( $total_nominal_kuitansi_kacamata),
				'total_nominal_kuitansi_kacamata_per_request' => ( $total_nominal_kuitansi_kacamata_per_request),
				'total_penggantian_kacamata' => ( $total_penggantian_kacamata),
				'total_penggantian_kacamata_per_request' => ( $total_penggantian_kacamata_per_request),
				'balancing_optic_tahun' => ( $pagu_optic_tahun - $total_penggantian_kacamata),
				'year_created_at' => $year_created_at
			);
			
			return $data;

		}

		public function get_data_employee_current($request_id){

			$sql = "SELECT *
			FROM		
				form_request 
			WHERE id LIKE '$request_id' AND is_status_progress >= '2'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$form_request_id = (!empty(($res[0]->id))) ? (($res[0]->id)) : '';

			$sql = "SELECT *
			FROM		
				hris_medical_reimbursment
			WHERE request_id LIKE '$form_request_id'";
			$query = $this->db->query($sql);
			$res 	= $query->result();
			$id_hr_emp = (!empty(($res[0]->id_hr_emp))) ? (decrypt($res[0]->id_hr_emp)) : '';

			$sql = "SELECT * FROM hris_employee WHERE id_employee = '$id_hr_emp'";
			$query = $this->db->query($sql);
			$res = $query->result();
			
			return $res[0];
		}

		public function get_approval_priority($request_id, $email){

			$sql = "SELECT approval_priority, approval_status FROM form_approval WHERE request_id LIKE '$request_id' AND approval_email LIKE '$email'";
	    	$query = $this->db->query($sql);
			$res = $query->result();
			if ($res == null || $res == '') {
				return $res;
			} else {
				return $res[0];
			}
		}
	//

	public function get_data_total_claim_for_print_iso($request_id){

		$today = $this->today;

		$sql = "SELECT *
		FROM		
			form_request 
		WHERE id LIKE '$request_id' AND is_status_progress >= '2'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$form_request_id = (!empty(($res[0]->id))) ? (($res[0]->id)) : '';
		$employee_id = (!empty(($res[0]->employee_id))) ? (($res[0]->employee_id)) : '';
		
		$sql = "SELECT 	
					tanggal_kuitansi
				FROM		
					hris_medical_reimbursment_item
				WHERE request_id = '$request_id' GROUP BY tanggal_kuitansi ORDER BY tanggal_kuitansi ASC LIMIT 1";		
		$query = $this->db->query($sql);
		$result = $query->result();
		$tanggal_kuitansi = date('Y', strtotime($result[0]->tanggal_kuitansi));					

		$year 		= $tanggal_kuitansi;


		$sql_eg = "SELECT 	
						employee_group as employee_group,
						start_date as start_date,
						reason_of_action as reason_of_action,
						join_date as join_date
					FROM		
						hris_employee
					WHERE nik = '$employee_id' ORDER BY id_employee DESC";
					
		$query_eg 				= $this->db->query($sql_eg);
		$res_eg					= $query_eg->result();
		$res_eg 				= $this->my_array_unique($res_eg);

		$no = 1;
		$result = [];

		foreach ($res_eg as $rown) {
			$rowArray = (array) $rown;
			$rowArray['no'] = $no++;
			$result[] = $rowArray;
		}

		$res_eg = $result;
		

		$data_eg = [];
		foreach($res_eg as $idx){
			$year_eg_sd = str_replace('-', '', (string) decrypt($idx['start_date']));
			$year_eg_sd = (int) substr($year_eg_sd, 0, 4);
			
			if(($year == $year_eg_sd) && (decrypt($idx['reason_of_action']) == 'Promosi')){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];

				$get_before = $idx['no'] + 1;
				foreach ($res_eg as $rowb) {
					if ($rowb->no == $get_before) {
						$data_before = $rowb;
						break;
					}
				}

				if (!empty($data_before)) {
					$data_eg[] = [
						'employee_group'     => $data_before['employee_group'],
						'start_date'         => $data_before['start_date'],
						'reason_of_action'   => $data_before['reason_of_action'],
						'join_date'   		 => $data_before['join_date']
					];
				}
			}elseif(($year == $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year < $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year > $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}
		}

		
		$res_eg_new 			= decrypt($data_eg[0]['employee_group']);
		$res_sd_new 			= decrypt($data_eg[0]['start_date']);
		$res_jd_new    			= decrypt($data_eg[0]['join_date']);
		$reason_of_action		= decrypt($data_eg[0]['reason_of_action']);
		$res_eg_old 			= (!empty(($data_eg[1]['employee_group']))) ? decrypt(($data_eg[1]['employee_group'])) : '';

		$sql2new = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query2new 	= $this->db->query($sql2new);
		$res2new 	= $query2new->result();
		$pagu_jalan_tahun_new 	= (!empty(($res2new[0]->pagu_tahun))) ? ($res2new[0]->pagu_tahun) : 0;

		$sql3new = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query3new 	= $this->db->query($sql3new);
		$res3new 	= $query3new->result();
		$pagu_inap_tahun_new 	= (!empty(($res3new[0]->pagu_tahun))) ? ($res3new[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_new 	= (!empty(($res3new[0]->pagu_kamar_hari))) ? ($res3new[0]->pagu_kamar_hari) : 0;
		
		
		$sql2old = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query2old 	= $this->db->query($sql2old);
		$res2old 	= $query2old->result();
		$pagu_jalan_tahun_old 	= (!empty(($res2old[0]->pagu_tahun))) ? ($res2old[0]->pagu_tahun) : 0;

		$sql3old = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query3old 	= $this->db->query($sql3old);
		$res3old 	= $query3old->result();
		$pagu_inap_tahun_old 	= (!empty(($res3old[0]->pagu_tahun))) ? ($res3old[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_old 	= (!empty(($res3old[0]->pagu_kamar_hari))) ? ($res3old[0]->pagu_kamar_hari) : 0;

		$start_date = DateTime::createFromFormat('Ymd', $res_sd_new);
		$start_date = $start_date->format('Y');


		if( ($start_date == $year) && (!empty($res_eg_old)) && ($reason_of_action == 'Promosi') ){

			$yearOld = $year-1;
			$yearNew = $year+1;
			$tgl1 = $yearOld."-12-31";
			$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
			$tgl2 = $tgl2->format('Y-m-d');
			$tgl22 = date('Y-m-d', strtotime('-1 days', strtotime($tgl2)));
    		$tgl3 = $yearNew."-01-01";

			$diff_old                = abs(strtotime($tgl22) - strtotime($tgl1));
			$join_years_old          = floor($diff_old / (365*60*60*24));
			$join_months_old         = floor(($diff_old - $join_years_old * 365*60*60*24) / (30*60*60*24));
			$join_days_old         	 = round($diff_old / (60 * 60 * 24));

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));
			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun_old = ((!empty(($pagu_inap_tahun_old))) ? ($pagu_inap_tahun_old) : 0);
			$pagu_pro_inap_tahun_old = ($join_days_old/365)* $pagu_inap_tahun_old;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new + $pagu_pro_inap_tahun_old;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun_old = ((!empty($pagu_jalan_tahun_old)) ? ($pagu_jalan_tahun_old) : 0);
			$pagu_pro_jalan_tahun_old = ($join_days_old/365) * $pagu_jalan_tahun_old;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new + $pagu_pro_jalan_tahun_old;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;

		}else if( ($start_date == $year) AND ($reason_of_action == 'Hiring') ){

			$yearNew = $year+1;
			$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
			$tgl2 = $tgl2->format('Y-m-d');
    		$tgl3 = $yearNew."-01-01";

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));
			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;
			

		}else{

			if(($year == $start_date) || ($year < $start_date)){
				$pagu_jalan_tahun	= $pagu_jalan_tahun_old;
				$pagu_inap_tahun	= $pagu_inap_tahun_old;
				$pagu_inap_kamar 	= $pagu_inap_kamar_old;

			}else{
				$pagu_jalan_tahun	= $pagu_jalan_tahun_new;
				$pagu_inap_tahun	= $pagu_inap_tahun_new;
				$pagu_inap_kamar 	= $pagu_inap_kamar_new;

			}

		}

		$sql4 = "SELECT 	
					pagu_one_focus_tahun as pagu_one_focus_tahun,
					pagu_two_focus_tahun as pagu_two_focus_tahun,
					pagu_frame_dua_tahun as pagu_frame_dua_tahun
				FROM		
					hris_medical_pagu_kacamata
				WHERE grade = '$res_eg_new' AND start_date <= '$today' AND end_date > '$today'";
		$query4 = $this->db->query($sql4);
		$res4 	= $query4->result();
		$pagu_one_focus_tahun 	= $res4[0]->pagu_one_focus_tahun;
		$pagu_two_focus_tahun 	= $res4[0]->pagu_two_focus_tahun;
		$pagu_frame_dua_tahun 	= $res4[0]->pagu_frame_dua_tahun;

		$sql = "SELECT 	
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_jalan,
			SUM(a.penggantian) as total_penggantian_rawat_jalan
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
		LEFT JOIN form_request c ON b.request_id = c.id
		WHERE b.employee_id = '$employee_id' and a.tor_grandparent = '1' and c.is_status = '3' and year(a.tanggal_kuitansi) LIKE '%$tanggal_kuitansi%' and a.request_id <= '$request_id'";

		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_rawat_jalan = (!empty(($res[0]->total_nominal_kuitansi_rawat_jalan))) ? (($res[0]->total_nominal_kuitansi_rawat_jalan)) : 0;
		$total_penggantian_rawat_jalan = (!empty(($res[0]->total_penggantian_rawat_jalan))) ? (($res[0]->total_penggantian_rawat_jalan)) : 0;
		

			$sql = "SELECT 	
						SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_inap,
						SUM(a.penggantian) as total_penggantian_rawat_inap
					FROM		
						hris_medical_reimbursment_item a
					LEFT JOIN hris_medical_reimbursment b ON a.request_id = b.request_id
					LEFT JOIN form_request c ON b.request_id = c.id
					WHERE b.employee_id = '$employee_id' and a.tor_grandparent = '2' and c.is_status = '3' and year(a.tanggal_kuitansi) LIKE '%$tanggal_kuitansi%' and a.request_id <= '$request_id'";

			$query = $this->db->query($sql);
			$res 	= $query->result();
			$total_nominal_kuitansi_rawat_inap = (!empty(($res[0]->total_nominal_kuitansi_rawat_inap))) ? (($res[0]->total_nominal_kuitansi_rawat_inap)) : 0;
			$total_penggantian_rawat_inap = (!empty(($res[0]->total_penggantian_rawat_inap))) ? (($res[0]->total_penggantian_rawat_inap)) : 0;
		//

		$sql = "SELECT 
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_kacamata,
			SUM(a.penggantian) as total_penggantian_kacamata
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN form_request b ON a.request_id = b.id
		WHERE b.is_status = '3' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '3' and year(a.tanggal_kuitansi) LIKE '%$tanggal_kuitansi%' and a.request_id <= '$request_id'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_kacamata = (!empty(($res[0]->total_nominal_kuitansi_kacamata))) ? (($res[0]->total_nominal_kuitansi_kacamata)) : 0;
		$total_penggantian_kacamata = (!empty(($res[0]->total_penggantian_kacamata))) ? (($res[0]->total_penggantian_kacamata)) : 0;

		$pagu_optic_tahun = ($pagu_one_focus_tahun + $pagu_two_focus_tahun + $pagu_frame_dua_tahun);

		$data = array(
			'pagu_jalan_tahun' => ( $pagu_jalan_tahun ),
			'total_nominal_kuitansi_rawat_jalan' => ( $total_nominal_kuitansi_rawat_jalan),
			'total_penggantian_rawat_jalan' => ( $total_penggantian_rawat_jalan),
			'balancing_jalan_tahun' => ( $pagu_jalan_tahun - $total_penggantian_rawat_jalan),
			'pagu_inap_tahun' => ( $pagu_inap_tahun ),
			'total_nominal_kuitansi_rawat_inap' => ( $total_nominal_kuitansi_rawat_inap),
			'total_penggantian_rawat_inap' => ( $total_penggantian_rawat_inap),
			'balancing_inap_tahun' => ( $pagu_inap_tahun - $total_penggantian_rawat_inap),
			'pagu_optic_tahun' => ( $pagu_optic_tahun ),
			'total_nominal_kuitansi_kacamata' => ( $total_nominal_kuitansi_kacamata),
			'total_penggantian_kacamata' => ( $total_penggantian_kacamata),
			'balancing_optic_tahun' => ( $pagu_optic_tahun - $total_penggantian_kacamata),
			'year_created_at' => $year
		);
		
		return $data;

	}

	/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////
	public function check_KPIPLAN($email){
		$eval_year = $this->year - 1;
		$evaluation_period_start = $eval_year.'-01-01';
		
		$query = "select request_number from performance_appraisal where evaluation_period_start = '$evaluation_period_start' and created_by = '$email'";
		if(!empty($this->db->query($query)->row()->request_number)){
			return $this->db->query($query)->row()->request_number;
		}else{
			return "";
		}
	}

	public function getUserListPa($field, $table, $where)
	{
		$output = '';
		$output .= '<option value=""></option>';
		$userList = $this->db->select($field)->where($where)->get($table)->result_array();
		// dumper($userList);
		foreach ($userList as $key) {
			$output .= '<option value="' . $key[$field] . '" >' . $key[$field] . '</option>';
		}
		return $output;
	}

	public function saveApprovalPa($email, $requestId)
	{
		$i = 0;
		$priority = 1;
		$count = count($email);

		for ($i = 0; $i < $count; $i++) {

			// if ($email[$i] === 'farida@ibstower.com') {
			// 	$alias = 'Commitee';
			// } else {
			// 	$alias = str_replace('@ibstower.com', '', $email[$i]);
			// }

			$sql_alias 			= "SELECT complete_name FROM v_hris_employee_updated WHERE email = '".encrypt($email[$i])."' ORDER BY id_employee DESC";
			$query_alias		= $this->db->query($sql_alias);
			$alias 				= $query_alias->result();
			$alias 				= decrypt($alias[0]->complete_name);

			if ($priority == 1) {
				$approval = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_email' => $email[$i],
					'approval_alias' => $alias,
					'approval_status' => 'In Progress',
					'approval_note' => '',
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->email
				);
			} else {
				$approval = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_email' => $email[$i],
					'approval_alias' => $alias,
					'approval_status' => '',
					'approval_note' => '',
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->email
				);
			}

			$layer[] = $approval;
			$priority++;
		}

		if ($this->db->insert_batch('form_approval', $layer)) {
			return true;
		} else {
			return false;
		}

	}

	public function getOneByIdPa($field, $table, $where = null)
	{
		return decrypt($this->db->select($field)->where($where)->get($table)->row_array()[$field]);
	}

	public function initial_create_pa_leaving($formType, $formData = '',$requestNumber = '', $table = '')
	{
		switch ($formType) {

			case 'KPI':

				$eval_year = $this->year - 1;
				
				$formRequest = array(
					'request_number' => $requestNumber,
					'is_status' => 0,
					'form_type' => 'KPI',
					'employee_id' => $formData[0]['nik'],
					'created_by' => decrypt($formData[0]['email']),
					'created_at' => $this->date
				);
				
				$this->db->insert('form_request', $formRequest);
				$id_form_request = $this->db->insert_id();
				
				$formData = array(
					'request_number' => $requestNumber,
					'is_status' => 3,
					'full_approved_date' => date("Y-m-d H:i:s",strtotime("now")),
					'employee_name' => $formData[0]['complete_name'],
					'employee_nik' => $formData[0]['nik'],
					'position' => $formData[0]['position'],
					'division' => $formData[0]['division'],
					'departement' => $formData[0]['department'],
					'direct_manager' => $formData[0]['divhead_name'],
					'join_date'	=> substr(decrypt($formData[0]['join_date']),0,4)."-".substr(decrypt($formData[0]['join_date']),4,2)."-".substr(decrypt($formData[0]['join_date']),6,2),
					'employment_status' => $formData[0]['employee_subgroup'],
					'office_location'	=> $formData[0]['personnel_area'],
					'sub_total_kpi' => 0,
					'sub_total_weight' => 0,
					'sub_total_qualitative' => 0,
					'pre_final_score' => $formData[0]['final_score'],
					'final_score' => $formData[0]['final_score'],
					'evaluation_period_start' => $eval_year.'-01-01',
					'evaluation_period_end' => $eval_year.'-12-31',
					'employee_id' => $formData[0]['id_employee'],
					'new_employee_flag' => 0,
					'created_by' =>  $formData[0]['email'],
					'created_at' => $this->date,
					'is_leaving' => 1);
					
					$this->db->insert('performance_appraisal', $formData);
					$requestId = $this->db->insert_id();
					
					if($requestId > 0){
						$yyy = ($eval_year-1).'-01-01';
						$queryx = "select * from performance_appraisal where evaluation_period_start = '$yyy' and created_by = '".encrypt($this->email)."'";
						// die;
						$cek = $this->db->query($queryx)->result_array();

						if(!empty($cek)){
							$queryy = "select * from performance_appraisal_plan where request_id = '".$cek[0]['id']."'";
							$plan = $this->db->query($queryy)->result_array();
							$nosa = 1;
							$totalweight = 0;
							$count_row_kpi = 0;
							if(!empty($plan)){
								foreach($plan as $keyx => $valx){
									$target_per_year = 0;
									if(($eval_year-1) < 2022){
										if(is_numeric(decrypt($valx['semester_1']))){
											if(is_numeric(decrypt($valx['semester_2']))){
												$target_per_year = decrypt($valx['semester_1'])+decrypt($valx['semester_2']);
												$nosa++;
											}
										}
										$unit = null;
									}else{
										if(is_numeric(decrypt($valx['semester_1']))){
											$target_per_year = decrypt($valx['semester_1']);
											$nosa++;
										}
										$unit = decrypt($valx['unit']);
									}
		
									
									$totalweight = $totalweight+decrypt($valx['time']);
									$target = (string) $target_per_year;
									$targetok = encrypt($target);
									
		
									$in = "
										insert into performance_appraisal_measurement (request_id,objective,measurement,target_per_year,time, created_by, created_at, unit) values (
											'$requestId', '".$valx['objective']."', '".$valx['measurement']."', '$targetok', '".$valx['time']."', '".encrypt($this->email)."', '".date("Y-m-d H:i:s")."', '$unit'
										)
									";
									$inserts = $this->db->query($in);
									$count_row_kpi++;
								}
								if($totalweight > 0){
									$totalweight = (string) $totalweight;
									$up = "
										update performance_appraisal set sub_total_weight = '".encrypt($totalweight)."', count_row_kpi = '$count_row_kpi' where id = '$requestId'
									";
									$this->db->query($up);
								}
							}
						}
					}
				break;

			default:
				break;

		}

		$request_id = $requestId;
		$id_form_request = $id_form_request;
		$is_status = 3;

		//==update form_request is_status = 1==/
		$this->db->where('id',$id_form_request);
		$this->db->update('form_request',array("is_status" => 3));
		//=====================================/
		$sql_alias 			= "SELECT complete_name FROM v_hris_employee_updated WHERE email = '".encrypt($this->email)."' ORDER BY id_employee DESC";
		$query_alias		= $this->db->query($sql_alias);
		$alias 				= $query_alias->result();
		$alias 				= decrypt($alias[0]->complete_name);
		$approval = array(
			'request_id' => $id_form_request,
			'approval_priority' => 1,
			'approval_email' => $this->email,
			'approval_alias' => $alias,
			'approval_status' => 'Approved',
			'approval_note' => 'Generate by pa leaving employee',
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->email
		);
		$this->db->insert('form_approval', $approval);
		
		return $requestId;
	}

	/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////

	//////////////////////////////////////////////////// TIME MANAGEMENT 2024////////////////////////////////////////////////////

	public function getTimeOffType($company_code, $gender){
		$today = $this->today;
		$sql = "SELECT nama, kode FROM hris_master_time_off WHERE company_code = '$company_code' AND kode NOT LIKE 'PG' AND kode NOT LIKE 'CA' AND kode NOT LIKE 'CTAB' AND start_date <= '$today' AND end_date > '$today' AND status = 1 ORDER BY kode ASC";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getTotalCuti($nik){
		$sql = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$res = $query->result();
		
		return $res;
	}

	public function requestTimeOff($jenis, $kode, $start_date, $end_date, $note, $nik, $no, $prevTotal, $waktu_masuk, $waktu_keluar, $schedule_in, $schedule_out, $status_file){
		
		if ($kode == 'CT'){
			if($prevTotal <= -6){
				return array('minus_six', '', '', '', ''); // TIME MANAGEMENT 2.0
			}
		} else if ($kode == 'IPC'){
			$time_diff = strtotime($schedule_out) - strtotime($waktu_keluar);
			$time = $time_diff / 60 /60;
			
			if($time > 2 && $prevTotal <= -6){
				return array('minus_six', '', '', '', ''); // TIME MANAGEMENT 2.0
			}
		} else if ($kode == 'IDT'){
			$time_diff = strtotime($waktu_masuk) - strtotime($schedule_in);
			$time = $time_diff / 60 /60;

			if($time > 2 && $prevTotal <= -6){
				return array('minus_six', '', '', '', ''); // TIME MANAGEMENT 2.0
			}
		}

		// if ((date('m-Y', strtotime($start_date)) < date('m-Y')) && $nik != '23010009'){
		// 	return array(false, '', '', '');
		// } 

		$tgl1 = strtotime($start_date);
		$tgl2 = strtotime($end_date); 

		$jarak = $tgl2 - $tgl1;
		$jarak_hari = $jarak / 60 / 60 / 24;

		$sqlDateDO = "SELECT * FROM hris_master_time_management WHERE (date BETWEEN '$start_date' AND '$end_date') AND schedule_code LIKE 'DO%' 
					  AND employee_id='$nik'";
		$queryDateDO = $this->db->query($sqlDateDO);
		$resultDateDO = $queryDateDO->result_array(); 

		if (!empty($resultDateDO) && $kode=='CT'){
			$jarak_hari -= count($resultDateDO);
		} 

		$no++;
		// $req_no = 'EAPP_TM_V2' . str_pad($no,6,"0", STR_PAD_LEFT);

		$req_no = $this->createRequestNumber('TM');
		// $req_no= 'HRIS_TM_'.$this->year.str_pad($no, 6, 0, STR_PAD_LEFT);

		$sqlPrev = "SELECT a.start_date, a.end_date, a.files 
					FROM hris_request_time_off a 
					LEFT JOIN hris_master_time_off b ON a.jenis = b.nama
					WHERE a.nik = '$nik' AND b.kode = 'S' AND (a.status=0 OR a.status=1)
					ORDER BY a.id DESC LIMIT 1";
		$queryPrev = $this->db->query($sqlPrev);
		$resultPrev = $queryPrev->result_array();

		if (!empty($resultPrev) && $kode == 'S'){
			$lastReqDate = date_create($resultPrev[0]['start_date']);
			$nowReqDate = date_create($start_date);
			$dateDiff = date_diff($nowReqDate, $lastReqDate);
			$diff = $dateDiff->format("%a");

			$period = new DatePeriod($lastReqDate, new DateInterval('P1D'), $nowReqDate);
			$lastReqDate = date_format($lastReqDate,"Y-m-d");
			$nowReqDate = date_format($nowReqDate,"Y-m-d");
			$sqlCheckDO = "SELECT * FROM hris_master_calendar WHERE dws_code='DO' AND (date BETWEEN '$lastReqDate' AND '$nowReqDate')";
			$queryCheckDO = $this->db->query($sqlCheckDO);
			$holidays = $queryCheckDO->result_array();

			foreach($period as $dt) {
				$curr = $dt->format('D');

				if ($curr == 'Sat' || $curr == 'Sun') {
					$diff--;
				}elseif (in_array($dt->format('Y-m-d'), $holidays)) {
					$diff--;
				}
			}

			if (($diff == 1 || $diff == 0) && $status_file == 0 && $start_date == $end_date){
				return array('prev_sakit', '', '', '', ''); // TIME MANAGEMENT 2.0
			}

		}

		$sqlNext = "SELECT a.start_date, a.end_date, a.files 
		FROM hris_request_time_off a 
		LEFT JOIN hris_master_time_off b ON a.jenis = b.nama
		WHERE a.nik = '$nik' AND b.kode = 'S' AND (a.status=0 OR a.status=1) AND a.start_date > '$start_date'
		ORDER BY a.id DESC LIMIT 1";
		$queryNext = $this->db->query($sqlNext);
		$resultNext = $queryNext->result_array();

		if (!empty($resultNext) && $kode == 'S'){
		$lastReqDate = date_create($resultNext[0]['start_date']);
		$nowReqDate = date_create($start_date);
		$dateDiff = date_diff($nowReqDate, $lastReqDate);
		$diff = $dateDiff->format("%a");

		$period = new DatePeriod($lastReqDate, new DateInterval('P1D'), $nowReqDate);

		$lastReqDate = date_format($lastReqDate,"Y-m-d");
		$nowReqDate = date_format($nowReqDate,"Y-m-d");
		$sqlCheckDO = "SELECT * FROM hris_master_calendar WHERE dws_code='DO' AND (date BETWEEN '$lastReqDate' AND '$nowReqDate')";
		$queryCheckDO = $this->db->query($sqlCheckDO);
		$holidays = $queryCheckDO->result_array();

		foreach($period as $dt) {
			$curr = $dt->format('D');

			if ($curr == 'Sat' || $curr == 'Sun') {
				$diff--;
			}elseif (in_array($dt->format('Y-m-d'), $holidays)) {
				$diff--;
			}
		}

		if (($diff == 1 || $diff == 0) && $status_file == 0 && $start_date == $end_date){
			return array('next_sakit', '', '', '', ''); // TIME MANAGEMENT 2.0
		}

		}

		if ($jarak_hari >= 0){
			$formData = array(
				'jenis' => $jenis,
				'request_number' => $req_no,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'note' => $note,
				'status' => 0,
				'nik' => $nik
			);

			$this->db->insert("hris_request_time_off", $formData);
			$query = $this->db->insert_id();

			$today = date("Y-m-d");
			
			$this->db->select('nama');
			$this->db->from('hris_master_time_off');
			$this->db->where('kode', 'CTAB');
			$resultCTAB = $this->db->get()->result_array();
			$namaCTAB = $resultCTAB[0]['nama'];

			$sqlCheckCTAB = "SELECT * FROM hris_time_management_employee WHERE nik='$nik' AND tipe_perubahan='$namaCTAB' AND (date BETWEEN '$start_date' AND '$end_date')";
			$queryCheckCTAB = $this->db->query($sqlCheckCTAB);
			$resultCheckCTAB = $queryCheckCTAB->result_array();

			if (empty($resultCheckCTAB)){
				if (($waktu_masuk == 0) && ($waktu_keluar != 0)){ //Ijin Pulang Cepat
					$sqlKeluar = "UPDATE hris_request_time_off SET waktu_keluar = '$waktu_keluar' WHERE request_number='$req_no'";
					$queryKeluar = $this->db->query($sqlKeluar);
	
					$time_diff = strtotime($schedule_out) - strtotime($waktu_keluar);
					$time = $time_diff / 60 /60;
					
					if($time > 2){
						$change = -1 * abs(0.5);
					} else {
						$change = 0;
					}
				} else if (($waktu_keluar == 0) && ($waktu_masuk != 0)) { //Ijin Datang Terlambat
					$sqlMasuk = "UPDATE hris_request_time_off SET waktu_masuk = '$waktu_masuk' WHERE request_number='$req_no'";
					$queryMasuk = $this->db->query($sqlMasuk);
	
					$time_diff = strtotime($waktu_masuk) - strtotime($schedule_in);
					$time = $time_diff / 60 /60;
					
					if($time > 2){
						$change = -1 * abs(0.5);
					} else {
						$change = 0;
					}
				} else if ($kode == 'CT'){
					if ($jenis === "Cuti Tahunan Setengah Hari"){
						$change = -1 * abs(0.5);
					} else {
						$change = -1 * abs($jarak_hari + 1);
					}
				} else {
					$change = 0;
				}
			} else {
				// if ($kode != 'PPD' && $kode != 'DDK'){
				if ($kode != 'S' && $kode != 'DDK' && $kode != 'DLK'){
					$sqlUpdCTAB = "UPDATE hris_time_management_employee SET status=0, update_date='$today' WHERE nik='$nik' AND tipe_perubahan='$namaCTAB' AND (date BETWEEN '$start_date' AND '$end_date')";
					$queryUpdCTAB = $this->db->query($sqlUpdCTAB);
	
					// $sqlUpdMTM = "UPDATE hris_master_time_management SET attendence_code='', time_off_code='$kode', flag=1 
					// 				WHERE employee_id='$nik' AND (date BETWEEN '$start_date' AND '$end_date')";
					// $queryUpdMTM = $this->db->query($sqlUpdMTM);
	
					$temp_change = 0;
					foreach($resultCheckCTAB as $res){
						$temp_change += $res['change_log'];
					}
	
					if ($kode != 'CT'){
						$change = abs($temp_change);
					} else {
						if ($jenis === "Cuti Tahunan Setengah Hari"){
							$change = 0;
						} else {
							$change = -1 * abs(($jarak_hari + 1) - count($resultCheckCTAB));
						}
					}
				} else {
					$change = 0;
				}
			}

			$totalChange = $prevTotal + $change;
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
				'tipe_perubahan' => $jenis,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'total_cuti' => $totalChange,
				'change_log' => $change,
				'request_number' => $req_no,
				'status' => 1,
				'flag' => $flagTME,
				'minus' => $flagMinus
			);
			$this->db->insert("hris_time_management_employee", $formDataEmployee);
			$queryEmployee = $this->db->insert_id();

			$formDataRequest = array(
				'request_number' => $req_no,
				'form_type' => 'TM',
				'is_status' => 1,
				'created_by' => $this->email,
				'created_at' => $this->date,
				'employee_id' => $this->session->userdata('employee_id'),
				'is_status_admin_hr' => 0,
				'is_status_divhead_hr' => 0
			);

			$this->db->insert("form_request", $formDataRequest);
			$queryRequest = $this->db->insert_id();

			$sqlRequestID = "UPDATE hris_request_time_off SET request_id = '$queryRequest' WHERE request_number='$req_no'";
			$queryRequestID  = $this->db->query($sqlRequestID );

			$sqlTop = "SELECT directorate ,rpm, rpm_name, usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4 
					   FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryTop = $this->db->query($sqlTop);
			$resultTop = $queryTop->result_array();
			if(decrypt(($resultTop[0]['directorate'])) == 'CFO'){

				$approval_email = $resultTop[0]['usrid_long4'];
				$approval_em = decrypt($approval_email);

				if($approval_em == 'makmur@ibsmulti.com' || $approval_em == 'MAKMUR@IBSMULTI.COM'){
					$approval_email = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
					$approval_id = '88088024';
					$approval_name = 'VVSLS#IIW  #IW#ILSPP#VWG';
				}else{
					$approval_email = $resultTop[0]['usrid_long4'];
					$approval_id = $resultTop[0]['director'];
					$approval_name = $resultTop[0]['director_name'];
					// $approval_email = 'JEJKIOC#IMQ..IB#AOT#QIAWL@Q#UVUU';
					// $approval_id = '88048010';
					// $approval_name = 'JLBOINM#IQVO QI#AZE#QG IEIV#U L#';
				}

			}else{

				if(!empty($resultTop[0]['usrid_long5'])){
					$approval_email = $resultTop[0]['usrid_long5'];
					$approval_id = $resultTop[0]['rpm'];
					$approval_name = $resultTop[0]['rpm_name'];
				} else if (!empty($resultTop[0]['usrid_long2'])){
					$approval_email = $resultTop[0]['usrid_long2'];
					$approval_id = $resultTop[0]['department_head'];
					$approval_name = $resultTop[0]['depthead_name'];
				} else if (!empty($resultTop[0]['usrid_long3'])){
					$approval_email = $resultTop[0]['usrid_long3'];
					$approval_id = $resultTop[0]['division_head'];
					$approval_name = $resultTop[0]['divhead_name'];
				} else if (!empty($resultTop[0]['usrid_long4'])){
					
					$approval_email = $resultTop[0]['usrid_long4'];
					$approval_em = decrypt($approval_email);
	
					if($approval_em == 'makmur@ibsmulti.com' || $approval_em == 'MAKMUR@IBSMULTI.COM'){
						$approval_email = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
						$approval_id = '88088024';
						$approval_name = 'VVSLS#IIW  #IW#ILSPP#VWG';
					}else{
						$approval_email = $resultTop[0]['usrid_long4'];
						$approval_id = $resultTop[0]['director'];
						$approval_name = $resultTop[0]['director_name'];
					}
					
				}
				
			}
			
			$alias = str_replace('@IBSMULTI.COM', '', decrypt($approval_email));

			$formApprovalTO = array(
				'request_id' => $queryRequest,
				'approval_priority' => 1,
				'approval_email' => strtolower(decrypt($approval_email)),
				'approval_status' => 'In Progress',
				'created_at' => $this->date,
				'created_by' => $this->email,
				'approval_alias' => strtolower($alias),
				'is_read' => 0,
				'approval_employee_id' => decrypt($approval_id)
			);
			$this->db->insert("form_approval", $formApprovalTO);

			if($query){
				$query = 'jarak_plus';
			}else{
				$query = false;
			}

		}else{
			$sqlHol = "SELECT * FROM hris_master_calendar WHERE (date BETWEEN '$start_date' AND '$end_date') AND holiday_calendar != ''";
			$queryHol = $this->db->query($sqlHol);
			$resultHol = $queryHol->result_array();

			if (!empty($resultHol)){
				$query = 'holiday';
			} else {
				$query = 'start_end';
			}
		}

		if($query == 'start_end' || $query == 'holiday'){
			return array($query, '', '', '', ''); // TIME MANAGEMENT 2.0
		}else if($query == 'jarak_plus'){
			return array(true, $queryRequest, strtolower(decrypt($approval_email)), strtolower(decrypt($approval_name)), $totalChange); // TIME MANAGEMENT 2.0
		}else {
			return array(false, '', '', '', ''); // TIME MANAGEMENT 2.0
		}
	}

	public function save_file($files){
		$sqlTopId = "SELECT id FROM hris_request_time_off ORDER BY id DESC LIMIT 1";
		$queryTopId = $this->db->query($sqlTopId);
		$resultTopId = $queryTopId->result_array();
		$topId = $resultTopId[0]['id'];

		$sqlUpdate = "UPDATE hris_request_time_off SET files = '$files' WHERE id='$topId'";
		$queryUpdate = $this->db->query($sqlUpdate);
		return true;
	}

	public function del_file($type){
		$sqlSelect1 = "SELECT request_id, id FROM hris_request_time_off ORDER BY id DESC LIMIT 1";
		$querySelect1 = $this->db->query($sqlSelect1);
		$resultSelect1 = $querySelect1->result_array();
		$topIdRequest = $resultSelect1[0]['id'];

		$sqlSelect2 = "SELECT id FROM hris_time_management_employee ORDER BY id DESC LIMIT 1";
		$querySelect2 = $this->db->query($sqlSelect2);
		$resultSelect2 = $querySelect2->result_array();
		$topIdLog = $resultSelect2[0]['id'];

		$sql1 = "DELETE FROM hris_request_time_off where id = '$topIdRequest'";
		$query1 = $this->db->query($sql1);

		$sql2 = "DELETE FROM hris_time_management_employee where id = '$topIdLog'";
		$query2 = $this->db->query($sql2);

		$topReqFormId = $resultSelect1[0]['request_id'];
		$sql3 = "DELETE FROM form_request where id = '$topReqFormId'";
		$query3 = $this->db->query($sql3);

		$sql4 = "DELETE FROM form_approval where request_id = '$topReqFormId'";
		$query4 = $this->db->query($sql4);

		return $type;
	}

	public function getRequestTimeOff($nik){
		$sql = "SELECT * FROM hris_request_time_off WHERE nik = '$nik' AND jenis NOT LIKE 'Schedule%' ORDER BY id ASC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function getRequestTopId(){
		$sql = "SELECT id FROM hris_request_time_off ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(!empty($result)){
			return $result;
		} else {
			return 0;
		}
	}

	public function getDeleteRequestTimeOff($id, $req_no)
	{
		$sqlChangeLog = "SELECT * FROM hris_time_management_employee where request_number = '$req_no' ORDER BY id DESC LIMIT 1";
		$queryChangeLog = $this->db->query($sqlChangeLog);
		$resultChangeLog = $queryChangeLog->result_array();

		$nik = $this->session->userdata('employee_id');
		$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
		$queryTotal = $this->db->query($sqlTotal);
		$resultTotal = $queryTotal->result_array();
		$today = date("Y-m-d");
		if(!empty($resultChangeLog)){
			$newTotal = $resultTotal[0]['total_cuti'] - $resultChangeLog[0]['change_log'];
			$today = date("Y-m-d");
			if ($resultChangeLog[0]['change_log'] < 0){
				$change = abs($resultChangeLog[0]['change_log']);
			} else {
				$change = -1 * $resultChangeLog[0]['change_log'];
			}
			if ($newTotal < 0){
				$flag_minus = 1;
			} else {
				$flag_minus = 0;
			}
			
			$formDataEmployee = array(
				'nik' => $resultChangeLog[0]['nik'],
				'date' => $today,
				'tipe_perubahan' => "Cancel - " . $resultChangeLog[0]['tipe_perubahan'],
				'start_date' => $resultChangeLog[0]['start_date'],
				'end_date' => $resultChangeLog[0]['end_date'],
				'total_cuti' => $newTotal,
				'change_log' => $change,
				'request_number' => "-",
				'status' => 3,
				'flag' => 0,
				'minus' => $flag_minus
			);
			$this->db->insert("hris_time_management_employee", $formDataEmployee);
			$queryEmployee = $this->db->insert_id();

			$lastId = $resultChangeLog[0]['id'];
			$sqldel = "UPDATE hris_time_management_employee SET status=2, update_date='$today', flag=0 where id = '$lastId'";
			$querydel = $this->db->query($sqldel);

		}

		$sqlFindFile = "SELECT files, start_date, end_date FROM hris_request_time_off WHERE id = '$id' ORDER BY id DESC LIMIT 1";
		$queryFindFile = $this->db->query($sqlFindFile);
		$resultFindFile = $queryFindFile->result_array();

		if(!empty($resultFindFile[0]['files'])){
			$path = './assets/documents/documents_tm/' . $resultFindFile[0]['files'];
			unlink($path);
		}

		$this->db->select('nama');
		$this->db->from('hris_master_time_off');
		$this->db->where('kode', 'CTAB');
		$resultCTAB = $this->db->get()->result_array();
		$namaCTAB = $resultCTAB[0]['nama'];

		$ctab_start_date = $resultFindFile[0]['start_date'];
		$ctab_end_date = $resultFindFile[0]['end_date'];

		$sqlUpdCTAB = "UPDATE hris_time_management_employee SET status=1, update_date='$today' WHERE nik='$nik' AND tipe_perubahan='$namaCTAB' AND (date BETWEEN '$ctab_start_date' AND '$ctab_end_date')";
		$queryUpdCTAB = $this->db->query($sqlUpdCTAB);

		$sqlApprID = "SELECT id FROM form_request where request_number = '$req_no' ORDER BY id DESC LIMIT 1";
		$queryApprID = $this->db->query($sqlApprID);
		$resultApprID = $queryApprID->result_array();
		$reqID = $resultApprID[0]['id'];

		$update_datetime = $this->date;
		$update_email = $this->email;

		$sqlDelAppr = "UPDATE form_approval SET approval_status='Canceled by User', updated_at='$update_datetime', updated_by='$update_email' 
					   WHERE request_id = '$reqID'";
		$queryDelAppr = $this->db->query($sqlDelAppr);

		$sqlDelReq = "UPDATE form_request SET is_status=8, deleted_by='$update_email', deleted_at='$update_datetime' WHERE request_number = '$req_no'";
		$queryDelReq = $this->db->query($sqlDelReq);

		$sql = "UPDATE hris_request_time_off SET status=3 WHERE id = '$id'";
		$query = $this->db->query($sql);

		$this->db->select('approval_email');
		$this->db->from('form_approval');
		$this->db->where('request_id', $reqID);
		$this->db->where('approval_status', 'Canceled by User');
		$resultEmail = $this->db->get()->result_array();
		$approval_email = $resultEmail[0]['approval_email'];

		$this->db->select('complete_name');
		$this->db->from('v_hris_employee_updated');
		$this->db->where('email', strtoupper(encrypt($approval_email)));
		$complete_name = $this->db->get()->result_array();
		$nama_approver = decrypt($complete_name[0]['complete_name']);
		
		if ($queryDelAppr){
			/////////////////////Menambahkan data tipe perubahan 2025/////////////////////////
			return array(true, $reqID, $approval_email, $nama_approver, $resultChangeLog[0]['tipe_perubahan']);
		} else {
			return array(false, '', '', '');
		}
	}

	public function getRequestTopTotalCuti($nik){
		$sql = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(!empty($result)){
			return $result;
		} else {
			return 0;
		}
	}

	public function getRequestNumber($id){
		$sql = "SELECT request_number FROM hris_request_time_off WHERE id='$id' ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getSchedule($nik, $start_date){
		$sql = "SELECT schedule_in, schedule_out FROM hris_master_time_management WHERE employee_id='$nik' AND date='$start_date' ORDER BY id DESC LIMIT 1";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getAlreadyRequested($nik){
		$sql = "SELECT * FROM hris_request_time_off WHERE nik='$nik' AND jenis='CUTI IBADAH HAJI' AND status != '3' ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getAlreadyRequestedDay($nik, $tipe_time_off, $start_date, $end_date=''){
		if (empty($end_date)){
			$sql = "SELECT * FROM hris_master_time_management WHERE employee_id='$nik' AND date ='$start_date' AND (schedule_code LIKE 'DO%' OR schedule_code = 'CTB')";
			$query = $this->db->query($sql);
			$result = $query->result_array();
			if (!empty($result)){
				return array(true, 'day_off');
			}
			$oneMonthAgo = new \DateTime('1 month ago');
			$oneMonthAgo = $oneMonthAgo->format('Y-m-d');

			$addquery = "AND start_date >= '$oneMonthAgo'";
		}else{
			$addquery = "AND start_date >= '$start_date' AND start_date <= '$end_date'";
		}
	
		$sqlGetTO = "SELECT * FROM hris_request_time_off WHERE nik='$nik' $addquery AND (status=0 OR status=1)"; // TIME MANAGEMENT 2.0
		$queryGetTO = $this->db->query($sqlGetTO);
		$check_request = $queryGetTO->result_array();
		$no_idt = 0;
		$no_ipc = 0;
		foreach($check_request as $value){
			$request_start_date = $value['start_date'];
			$request_end_date	= $value['end_date'];
			$jenis = $value['jenis'];

			if($jenis != 'IJIN DATANG TERLAMBAT' && $jenis != 'IJIN PULANG CEPAT'){
				if (strtotime($start_date) >= strtotime($request_start_date) && strtotime($start_date) <= strtotime($request_end_date)){
					return array(true, $jenis, $request_start_date, $request_end_date);
				}
				if (!empty($end_date)){
					if (strtotime($end_date) >= strtotime($request_start_date) && strtotime($end_date) <= strtotime($request_end_date)){
						return array(true, $jenis, $request_start_date, $request_end_date);
					}elseif ($request_start_date == $request_end_date) {
						return array(true, $jenis, $request_start_date, $request_end_date);
					} else {
						continue;
					}
				}
			}else{
				if($jenis == 'IJIN DATANG TERLAMBAT' && $start_date == $request_start_date){
					$no_idt++;
					if($no_idt > 0 && $jenis == $tipe_time_off){
						return array(true, $jenis, $request_start_date, $request_end_date);
					}
				}elseif ($jenis == 'IJIN PULANG CEPAT' && $start_date == $request_start_date) {
					$no_ipc++;
					if($no_ipc > 0 && $jenis == $tipe_time_off){
						return array(true, $jenis, $request_start_date, $request_end_date);
					}
				}else{
					continue;
				}
			}
		}
		return array(false, '');

	} 

	public function getBalanceLog($nik){
		// $sql = "SELECT * FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC";
		$sql = "SELECT a.*, b.files FROM hris_time_management_employee a
				LEFT JOIN hris_request_time_off b ON a.request_number = b.request_number
				WHERE a.nik = '$nik' ORDER BY a.id DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function getMaritalStatus($gender, $marital_status){
		if ($gender != 'Female' && $marital_status == 'Single'){
			return 'not_married_male';
		} else if ($gender == 'Female' && $marital_status == 'Single'){
			return 'not_married_female';
		} else if ($gender != 'Female' && $marital_status != 'Single'){
			return 'married_male';
		} else if ($gender == 'Female' && $marital_status != 'Single'){
			return 'married_female';
		}
	}

	public function getHROnly(){
		if ($this->session->userdata('access_level') == 7){
			$sentence = "OR kode LIKE 'PG'";
		} else {
			$sentence = "";
		}
		$sql = "SELECT DISTINCT nama, kode FROM hris_master_time_off WHERE kode LIKE 'CTAB'" . $sentence;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function getCutiTidakAbsen($nik, $company_code){
		if (date('d') <= 10){
			$this_month = date('Y-m', strtotime('-1 month'));
			$this_month_last = date('Y-m-d');
		} else {
			$this_month = date('Y-m');
			$this_month_last = date('Y-m-t');
		}

		$sql = "SELECT a.date FROM hris_time_management_employee a 
				LEFT JOIN hris_master_time_off b ON a.tipe_perubahan = b.nama
				LEFT JOIN v_hris_employee_updated c ON a.nik = c.nik
				WHERE a.nik = '$nik' AND b.kode = 'CTAB' AND b.company_code = '$company_code' 
				AND (a.date BETWEEN '$this_month-01' AND '$this_month_last') ORDER BY a.date ASC";
		
		$query = $this->db->query($sql);
		$result = $query->result();

		if (empty($result)){
			return NULL;
		}
		
		$this->db->select('nama');
		$this->db->from('hris_master_time_off');
		$this->db->where('kode', 'CTAB');
		$resultCTAB = $this->db->get()->result_array();
		$ctab = $resultCTAB[0]['nama'];

		$listCTAB = array();
		$no = 0;
		$flag = false;
		foreach($result as $value){ 
			$date = $value->date;
			
			if (date('m', strtotime('-1 month')) == date('m', strtotime($date)) && $no >= 3){
				continue;
			} else if (date('m') == date('m', strtotime($date))){
				if ($flag == false && $no > 0){
					$no = 0;
					$flag = true;
				} else if ($flag == false && $no == 0) {
					$flag = true;
				} else if ($flag == true && $no == 3){
					break;
				}
			}
			
			$sqlCheckReq = "SELECT id FROM hris_request_time_off WHERE nik='$nik' AND jenis = 'Request Attendance' AND (status=1 OR status=0) AND start_date = '$date'";
			$queryCheckReq = $this->db->query($sqlCheckReq);
			
			$sqlCheckHR = "SELECT id FROM hris_time_management_adjustment WHERE nik_karyawan='$nik' AND nama_modul = 'Adjustment CUTI TIDAK ABSEN' AND (status=1 OR status=0) AND start_date = '$date'";
			$queryCheckHR = $this->db->query($sqlCheckHR);

			$sqlCheckAppr = "SELECT id FROM hris_time_management_employee WHERE nik='$nik' AND tipe_perubahan='$ctab' AND status=0 AND start_date = '$date'";
			$queryCheckAppr = $this->db->query($sqlCheckAppr);
			
			if (empty($queryCheckReq->result())){
				if (!empty($queryCheckHR->result())){
					$no++;
					continue;
				}
				if (!empty($queryCheckAppr->result())){
					continue;
				} else {
					$no++;
					$listCTAB[] = $date;
				}
			} else {
				$no++;
				continue;
			}
		}
		
		if (!empty($result) && empty($listCTAB)){
			return NULL;
		} else if (!empty($result) && !empty($listCTAB)) {
			return $listCTAB;
		}
	}
	
	public function getCutiTidakAbsenHR($nik, $company_code){
		if (date('d') <= 10){
			$this_month = date('Y-m', strtotime('-3 month'));
			$this_month_last = date('Y-m-d');
		} else {
			// $this_month = date('Y-m');
			$this_month = date('Y-m', strtotime('-3 month'));
			$this_month_last = date('Y-m-t');
		}

		$sql = "SELECT a.date, a.start_date, a.end_date FROM hris_time_management_employee a 
				LEFT JOIN hris_master_time_off b ON a.tipe_perubahan = b.nama
				LEFT JOIN v_hris_employee_updated c ON a.nik = c.nik
				WHERE a.nik = '$nik' AND b.kode = 'CTAB' AND b.company_code = '$company_code' 
				AND (a.date BETWEEN '$this_month-01' AND '$this_month_last') ORDER BY a.date ASC";
		//dumper($sql);
		$query = $this->db->query($sql);
		$result = $query->result();

		if (empty($result)){
			return NULL;
		}
		
		$this->db->select('nama');
		$this->db->from('hris_master_time_off');
		$this->db->where('kode', 'CTAB');
		$resultCTAB = $this->db->get()->result_array();
		$ctab = $resultCTAB[0]['nama'];

		$listCTAB = array();
		$no = 0;
		$flag = false;
		foreach($result as $value){ 
			$date = $value->date;
			
			if (date('m', strtotime('-3 month')) == date('m', strtotime($date)) && $no >= 31){
				continue;
			} else if (date('m') == date('m', strtotime($date))){
				if ($flag == false && $no > 0){
					$no = 0;
					$flag = true;
				} else if ($flag == false && $no == 0) {
					$flag = true;
				} else if ($flag == true && $no == 31){
					break;
				}
			}
			
			$sqlCheckReq = "SELECT id FROM hris_request_time_off WHERE nik='$nik' AND jenis = 'Request Attendance' AND (status=1 OR status=0) AND start_date = '$date'";
			$queryCheckReq = $this->db->query($sqlCheckReq);
			
			$sqlCheckHR = "SELECT id FROM hris_time_management_adjustment WHERE nik_karyawan='$nik' AND nama_modul = 'Adjustment CUTI TIDAK ABSEN' AND (status=1 OR status=0) AND start_date = '$date'";
			$queryCheckHR = $this->db->query($sqlCheckHR);

			$sqlCheckAppr = "SELECT id FROM hris_time_management_employee WHERE nik='$nik' AND tipe_perubahan='$ctab' AND status=0 AND start_date = '$date'";
			$queryCheckAppr = $this->db->query($sqlCheckAppr);
			
			if (empty($queryCheckReq->result())){
				if (!empty($queryCheckHR->result())){
					$no++;
					continue;
				}
				if (!empty($queryCheckAppr->result())){
					continue;
				} else {
					$no++;
					$listCTAB[] = $date;
				}
			} else {
				$no++;
				continue;
			}
		}
		
		if (!empty($result) && empty($listCTAB)){
			return NULL;
		} else if (!empty($result) && !empty($listCTAB)) {
			return $listCTAB;
		}
	}

	public function getEmployee($nik){
		$condition = encrypt("Leaving");
		$sql = "SELECT id_employee, email, complete_name, nik FROM v_hris_employee_updated WHERE nik != '$nik' AND action!='$condition' AND nik NOT LIKE '0000%' ORDER BY nik ASC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function adjustEmployeeTO($nik_hr, $email_hr, $module, $code, $name, $sign, $amount, $emp_nik, $date, $month, $year){ //TIME MANAGEMENT 2.1
		$today = $this->today;

		if ($code == 'ACT'){
			$x = 0;
			$req_no = '';

			while($x < count($name)) {
				$employee_email = encrypt($name[$x]);
				$sqlNIK = "SELECT nik FROM v_hris_employee_updated WHERE email = '$employee_email' ORDER BY id_employee DESC LIMIT 1";
				$queryNIK = $this->db->query($sqlNIK);
				$resultNIK = $queryNIK->result_array();
				$employee_nik = $resultNIK[0]['nik'];
	
				if ($sign == 'minus'){
					$amount = -1 * abs($amount);
				}
	
				$formData = array(
					'nama_modul' => $module,
					'kode_modul' => $code,
					'nik_karyawan' => $employee_nik,
					'email_karyawan' => $name[$x],
					'nik_hr' => $nik_hr,
					'email_hr' => $email_hr,
					'jumlah_perubahan' => $amount,
					'status' => 0
				);
	
				$this->db->insert("hris_time_management_adjustment", $formData);
				$queryId = $this->db->insert_id();

				if (empty($req_no)){
					// $req_no = 'EAPP_TMHR_V2' . str_pad($queryId,6,"0", STR_PAD_LEFT);
					$req_no = 'HRIS_TMHR_'.$this->year.str_pad($queryId, 6, 0, STR_PAD_LEFT);
				}
				$sqlUpdateReqNo = "UPDATE hris_time_management_adjustment SET request_number='$req_no' WHERE id='$queryId'";
				$queryUpdateReqNo = $this->db->query($sqlUpdateReqNo);
	
				$x++;
			}
		} else {
			$this->db->select('nama');
			$this->db->from('hris_master_time_off');
			$this->db->where('kode', 'CTAB');
			$resultCTAB = $this->db->get()->result_array();
			$ctab = $resultCTAB[0]['nama'];

			if ($code == 'PG'){	
				$change = $amount;
				$date = $year . '-' . $month . '-10';
				
			} else {
				$sqlChangeLog = "SELECT change_log FROM hris_time_management_employee WHERE tipe_perubahan = '$ctab'
								  AND nik='$emp_nik' AND date = '$date' ORDER BY id DESC";
				$queryChangeLog = $this->db->query($sqlChangeLog);
				$resultChangeLog = $queryChangeLog->result_array();
				if(!empty($resultChangeLog)){
					$change = abs($resultChangeLog[0]['change_log']);
				} else {
					$change = 0;
				}
			}

			$sqlEmail = "SELECT email, complete_name FROM v_hris_employee_updated WHERE nik = '$emp_nik' ORDER BY id_employee DESC LIMIT 1";
			$queryEmail = $this->db->query($sqlEmail);
			$resultEmail = $queryEmail->result_array();

			$formData = array(
				'nama_modul' => 'Adjustment ' . $module,
				'kode_modul' => $code,
				'start_date' => $date,
				'nik_karyawan' => $emp_nik,
				'email_karyawan' => decrypt($resultEmail[0]['email']),
				'nik_hr' => $nik_hr,
				'email_hr' => $email_hr,
				'jumlah_perubahan' => $change,
				'status' => 0
			);
			$this->db->insert("hris_time_management_adjustment", $formData);
			$queryId = $this->db->insert_id();

			// $req_no = 'EAPP_TMHR_V2' . str_pad($queryId,6,"0", STR_PAD_LEFT);
			$req_no = 'HRIS_TMHR_'.$this->year.str_pad($queryId, 6, 0, STR_PAD_LEFT);

			$sqlUpdate = "UPDATE hris_time_management_adjustment SET request_number='$req_no' WHERE id='$queryId'";
			$queryUpdate = $this->db->query($sqlUpdate);
		}

		$formDataRequest = array(
			'request_number' => $req_no,
			'form_type' => 'TM',
			'is_status' => 1,
			'created_by' => $this->email,
			'created_at' => $this->date,
			'employee_id' => $this->session->userdata('employee_id'),
			'is_status_admin_hr' => 7,
			'is_status_divhead_hr' => 0
		);

		$this->db->insert("form_request", $formDataRequest);
		$queryRequest = $this->db->insert_id();

		//////////////////////////////////////////Start Update Logs 2025//////////////////////////////////////////////////////
		if ($code == 'ACT'){
			$name = implode(', ', $name);
			$this->logs('request_adjuct_cuti', 'TM', $queryRequest, $module, $module.' - '.$code.' - ( '.$name.' ) - ( '.$amount.' ) - ( '.$today.' )');
		}else{
			$this->logs('request_adjuct_cuti', 'TM', $queryRequest, $module, $module.' - '.$code.' - '.decrypt($resultEmail[0]['complete_name']).' - '.$change.' - ( '.$date.' )');
		}
		//////////////////////////////////////////End Update Logs 2025//////////////////////////////////////////////////////

		$this->db->select('user_email, employee_id');
		$this->db->from('users');
		$this->db->where('access_level', 7);
		if ($this->session->userdata('access_level') == 7){
			$this->db->where('employee_id !=', $this->session->userdata('employee_id'));
		}
		$this->db->order_by('id_user', 'ASC');
		$hr_user = $this->db->get()->result_array();
		foreach ($hr_user as $key) {
			$approval = array(
				'request_id' => $queryRequest,
				'approval_priority' => 1,
				'approval_employee_id' => $key['employee_id'],
				'approval_email' => $key['user_email'],
				'approval_alias' => 'HR Super Admin',
				'approval_status' => 'In Progress',
				'approval_note' => '',
				'is_read' => 0,
				'created_at' => $this->date,
				'created_by' => $this->email,
			);
			$this->db->insert('form_approval', $approval);
		}

		return true;
	}

	public function getPersonalDetail_ztm($employee_id){
		$this->db->select('*');
		 $this->db->from('v_hris_employee_updated');
		  $this->db->where('nik', $employee_id);
		  $this->db->order_by('id_employee', 'ASC');
		  return $this->db->get()->result_array();
	}

	public function getPreviousTO_ztm(){
		$sqlPrev = "SELECT a.files, b.kode 
					FROM hris_request_time_off a 
					LEFT JOIN hris_master_time_off b ON a.jenis = b.nama
					ORDER BY a.id DESC LIMIT 1";
		$queryPrev = $this->db->query($sqlPrev);
		$resultPrev = $queryPrev->result_array();

		if (!empty($resultPrev)){
			if ($resultPrev[0]['kode'] == 'S' && empty($resultPrev[0]['files'])){
				$query = 'prev_sakit';
			}
		}

		if (!empty($query)){
			return $query;
		} else {
			return true;
		}
	}

	public function getDateSchedule($nik, $date){
		$this->db->select('schedule_in, schedule_out, check_in');
		 $this->db->from('hris_master_time_management');
		  $this->db->where('employee_id', $nik);
		$this->db->where('date', $date);
		  return $this->db->get()->result_array();
	}

	public function request_attendance_ztm($nik, $date, $clock_in, $clock_out, $note, $no){
		$no++;
		// $req_no = 'EAPP_TM_V2' . str_pad($no,6,"0", STR_PAD_LEFT);
		$req_no = $this->createRequestNumber('TMRA');
		// $req_no = 'HRIS_TMRA_'.$this->year.str_pad($no, 6, 0, STR_PAD_LEFT);

		// dumper($clock_in." - ".$clock_out);

		$formData = array(
			'jenis' => 'Request Attendance',
			'request_number' => $req_no,
			'start_date' => $date,
			'end_date' => $date,
			'note' => $note,
			'status' => 0,
			'nik' => $nik,
			'waktu_masuk' => $clock_in,
			'waktu_keluar' => $clock_out
		);
		// dumper($formData);
		$this->db->insert("hris_request_time_off", $formData);
		$query = $this->db->insert_id();

		$this->db->select('nama');
		$this->db->from('hris_master_time_off');
		$this->db->where('kode', 'CTAB');
		$resultCTAB = $this->db->get()->result_array();
		$namaCTAB = $resultCTAB[0]['nama'];

		$formDataRequest = array(
			'request_number' => $req_no,
			'form_type' => 'TM',
			'is_status' => 1,
			'created_by' => $this->email,
			'created_at' => $this->date,
			'employee_id' => $this->session->userdata('employee_id'),
			'is_status_admin_hr' => 0,
			'is_status_divhead_hr' => 0
		);

		$this->db->insert("form_request", $formDataRequest);
		$queryRequest = $this->db->insert_id();

		$sqlRequestID = "UPDATE hris_request_time_off SET request_id = '$queryRequest' WHERE request_number='$req_no'";
		$queryRequestID  = $this->db->query($sqlRequestID );


		$sqlGetTop = "SELECT total_cuti FROM hris_time_management_employee WHERE nik='$nik' ORDER BY id DESC LIMIT 1";
		$queryGetTop = $this->db->query($sqlGetTop);
		$resultGetTop = $queryGetTop->result_array();
		$totalChange = $resultGetTop[0]['total_cuti'];

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
			'date' => $this->today,
			'tipe_perubahan' => 'Request Attendance',
			'start_date' => $date,
			'end_date' => $date,
			'total_cuti' => $totalChange,
			'change_log' => 0,
			'request_number' => $req_no,
			'status' => 1,
			'flag' => $flagTME,
			'minus' => $flagMinus
		);
		$this->db->insert("hris_time_management_employee", $formDataEmployee);
		$queryEmployee = $this->db->insert_id();

		$sqlTop = "SELECT directorate, superior, superior_name, usrid_long1, rpm, rpm_name, usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4
				   FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
		$queryTop = $this->db->query($sqlTop);
		$resultTop = $queryTop->result_array();

		if(decrypt(($resultTop[0]['directorate'])) == 'CFO'){

			$approval_email = $resultTop[0]['usrid_long4'];
			$approval_em = decrypt($approval_email);

			if($approval_em == 'makmur@ibsmulti.com' || $approval_em == 'MAKMUR@IBSMULTI.COM'){
				$approval_email = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id = '88088024';
				$approval_name = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email = $resultTop[0]['usrid_long4'];
				$approval_id = $resultTop[0]['director'];
				$approval_name = $resultTop[0]['director_name'];
			}

		}else{
		
			if (!empty($resultTop[0]['usrid_long1'])) {
				$approval_email = $resultTop[0]['usrid_long1'];
				$approval_id = $resultTop[0]['superior'];
				$approval_name = $resultTop[0]['superior_name'];
			}else if(!empty($resultTop[0]['usrid_long5'])){
				$approval_email = $resultTop[0]['usrid_long5'];
				$approval_id = $resultTop[0]['rpm'];
				$approval_name = $resultTop[0]['rpm_name'];
			} else if (!empty($resultTop[0]['usrid_long2'])){
				$approval_email = $resultTop[0]['usrid_long2'];
				$approval_id = $resultTop[0]['department_head'];
				$approval_name = $resultTop[0]['depthead_name'];
			} else if (!empty($resultTop[0]['usrid_long3'])){
				$approval_email = $resultTop[0]['usrid_long3'];
				$approval_id = $resultTop[0]['division_head'];
				$approval_name = $resultTop[0]['divhead_name'];
			} else if (!empty($resultTop[0]['usrid_long4'])){

				$approval_email = $resultTop[0]['usrid_long4'];
				$approval_em = decrypt($approval_email);

				if($approval_em == 'makmur@ibsmulti.com' || $approval_em == 'MAKMUR@IBSMULTI.COM'){
					$approval_email = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
					$approval_id = '88088024';
					$approval_name = 'VVSLS#IIW  #IW#ILSPP#VWG';
				}else{
					$approval_email = $resultTop[0]['usrid_long4'];
					$approval_id = $resultTop[0]['director'];
					$approval_name = $resultTop[0]['director_name'];
				}
				// $approval_email = $resultTop[0]['usrid_long4'];
				// $approval_id = $resultTop[0]['director'];
				// $approval_name = $resultTop[0]['director_name'];
			}

		}
		
		$alias = str_replace('@IBSMULTI.COM', '', decrypt($approval_email));

		$approval = array(
			'request_id' => $queryRequest,
			'approval_priority' => 1,
			'approval_email' => strtolower(decrypt($approval_email)),
			'approval_status' => 'In Progress',
			'created_at' => $this->date,
			'created_by' => $this->email,
			'approval_alias' => strtolower($alias),
			'is_read' => 0,
			'approval_employee_id' => decrypt($approval_id)
		);
		$approve = $this->db->insert('form_approval', $approval);
		$aliasHR = 'HR Support'; 

		$hr_user = $this->db->select('user_email, employee_id')
							 ->where('access_level', '7')
							 ->where('employee_id !=', $nik)
							 ->order_by('id_user', 'ASC')
							 ->get('users')->result_array();

		foreach ($hr_user as $key) {
			$approval = array(
				'request_id' => $queryRequest,
				'approval_priority' => 2,
				'approval_employee_id' => $key['employee_id'],
				'approval_email' => $key['user_email'],
				'approval_alias' => $aliasHR,
				'approval_status' => '',
				'approval_note' => '',
				'is_read' => 0,
				'created_at' => $this->date,
				'created_by' => $this->email
			);
			$this->db->insert('form_approval', $approval);
		}

		if ($approve){
			$config['cacheable']    = true;
			$config['cachedir']     = './assets/';
			$config['errorlog']     = './assets/';
			$config['imagedir']     = './assets/images/qrcode_tm/';
			$config['quality']      = true;
			$config['size']         = '1024';
			$config['black']        = array(224,255,255);
			$config['white']        = array(70,130,180);
			$this->ciqrcode->initialize($config);
			$image_name= $req_no.'-'.$nik.'.png';
			$params['data'] = $req_no.'-'.$nik;
			$params['level'] = 'H'; //H=High
			$params['size'] = 10;
			$params['savename'] = FCPATH.$config['imagedir'].$image_name;
			$this->ciqrcode->generate($params);

			return array(true, $queryRequest, strtolower(decrypt($approval_email)), strtolower(decrypt($approval_name)));
		} else {
			return array(false, '', '', '');
		}
	}

	public function getRequestTO_ztm($request_id){
		$this->db->select('*');
		$this->db->from('hris_request_time_off');
		$this->db->where('request_id', $request_id);
		 
		return $this->db->get()->result_array();
	}

	public function getCompany_ztm($nik=''){
		
		$this->db->select('company_code, company_name');
		$this->db->from('v_hris_nik_company');
		if(empty($nik)){
			$this->db->group_by('company_code, company_name');
			$this->db->order_by('company_code', 'asc');
		} else {
			$this->db->where('nik', $nik);
		}
		$result = $this->db->get()->result_array();

		if($result){
			return $result;
		}else{
			return false;
		}
	}

	public function getRequestDate_ztm($req_no){
		$this->db->select('date');
		$this->db->from('hris_time_management_employee');
		$this->db->where('request_number', $req_no);
		return $this->db->get()->result_array();
	}

	public function getReqID_ztm($req_no){
		$this->db->select('id');
		$this->db->from('form_request');
		$this->db->where('request_number', $req_no);
		return $this->db->get()->result_array();
	}

	public function getApprovalName_ztm($req_id, $approval_status){
		$sql = "SELECT approval_email, approval_alias FROM form_approval
				WHERE request_id = '$req_id' AND approval_status='$approval_status' ORDER BY id ASC LIMIT 1";
				// if($req_id == '16302'){
				// 	dumper($sql);
				// }
		$query = $this->db->query($sql);
		$res = $query->result_array();
		if (empty($res[0]['approval_email'])){
			$plz = "PLEASE CONTACT YOUR HRZ";
			return $plz;
		}
		if ($res[0]['approval_alias'] == 'HR Support'){
			$approval_name = $res[0]['approval_alias'];
			return $approval_name;
		} else {
			$this->db->select('complete_name');
			$this->db->from('v_hris_employee_updated');
			$this->db->like('email', encrypt($res[0]['approval_email']));
			$result = $this->db->get()->result_array();
			if (empty($result)){
				$plz = "PLEASE CONTACT YOUR HRX";
				return $plz;
			}else{
				$approval_name = decrypt($result[0]['complete_name']);
				return $approval_name;
			}
		}
	}

	public function getApprovalName2_ztm($req_id){
		$this->db->select('updated_by');
		$this->db->from('form_request');
		$this->db->where('id', $req_id);
		$res = $this->db->get()->result_array();

		$this->db->select('complete_name');
		$this->db->from('v_hris_employee_updated');
		$this->db->where('email', encrypt($res[0]['updated_by']));
		$result = $this->db->get()->result_array();
		return decrypt($result[0]['complete_name']);
	}

	public function getReqType_ztm($update_date, $nik){
		$sql = "SELECT tipe_perubahan FROM hris_time_management_employee WHERE nik='$nik'
				AND date='$update_date' AND (status=1 OR status=6)
				ORDER BY id ASC LIMIT 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	///////////////////// TIME MANAGEMENT 2.0 /////////////////////
	public function getHRAdjustment_ztm($req_no){
		$this->db->select('*');
		$this->db->from('hris_time_management_adjustment');
		$this->db->where('request_number', $req_no);
		return $this->db->get()->result_array();
	}

	public function getShiftSchedule($emp_id, $start_date, $end_date){
		$sql = "SELECT a.*, b.shift_type FROM hris_master_time_management a
				LEFT JOIN hris_master_schedule b ON a.schedule_code = b.kode
				LEFT JOIN v_hris_nik_company c ON a.employee_id = c.nik
				WHERE a.employee_id = '$emp_id' AND a.date >= '$start_date' AND a.date <= '$end_date' 
				AND (b.company_code = c.company_code OR a.schedule_code LIKE 'DO%') order by date asc";
		$query = $this->db->query($sql);
		return $result = $query->result();
	}

	public function getRequestAdjustment_ztm($nik){
		$sql = "SELECT * FROM hris_time_management_adjustment WHERE id in (SELECT MAX(id) from hris_time_management_adjustment GROUP BY request_number)
				AND nik_hr='$nik' AND request_number != '' ORDER BY id ASC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function submitRequestTM_ztm($type, $nik, $start_date, $end_date, $desc, $no){ 
		$no++;
		// $req_no = 'EAPP_TM_V2' . str_pad($no,6,"0", STR_PAD_LEFT);
		if($type = 'shift'){
			$req_no = 'HRIS_TMSH'.$this->year.str_pad($no, 6, 0, STR_PAD_LEFT);
		}else{
			$req_no = 'HRIS_TM_'.$this->year.str_pad($no, 6, 0, STR_PAD_LEFT);
		}
		

		$formDataRequest = array(
			'request_number' => $req_no,
			'form_type' => 'TM',
			'is_status' => 1,
			'created_by' => $this->email,
			'created_at' => $this->date,
			'revised_at' => $this->date,
			'employee_id' => $this->session->userdata('employee_id'),
			'is_status_admin_hr' => 0,
			'is_status_divhead_hr' => 7
		);
		$this->db->insert("form_request", $formDataRequest);
		$queryRequest = $this->db->insert_id();

		$formDataSchedule = array(
			'request_id' => $queryRequest,
			'request_number' => $req_no,
			'schedule_type' => $type,
			'nik' => $nik,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'status' => 0,
			'ket' => $desc
		);
		$this->db->insert("hris_schedule_request", $formDataSchedule);

		$formData = array(
			'jenis' => 'Schedule Shift',
			'request_number' => $req_no,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'status' => 7,
			'nik' => $nik
		);
		$this->db->insert("hris_request_time_off", $formData);

		$sqlTop = "SELECT rpm, rpm_name, usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4
				FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
		$queryTop = $this->db->query($sqlTop);
		$resultTop = $queryTop->result_array();

		if(!empty($resultTop[0]['usrid_long5'])){
			$approval_email1 = $resultTop[0]['usrid_long5'];
			$approval_id1 = $resultTop[0]['rpm'];
			$approval_name1 = $resultTop[0]['rpm_name'];

			$approval_email2 = $resultTop[0]['usrid_long3'];
			$approval_id2 = $resultTop[0]['division_head'];
			$approval_name2 = $resultTop[0]['divhead_name'];
		} else if (!empty($resultTop[0]['usrid_long2'])){
			$approval_email1 = $resultTop[0]['usrid_long2'];
			$approval_id1 = $resultTop[0]['department_head'];
			$approval_name1 = $resultTop[0]['depthead_name'];

			$approval_email2 = $resultTop[0]['usrid_long3'];
			$approval_id2 = $resultTop[0]['division_head'];
			$approval_name2 = $resultTop[0]['divhead_name'];
		} else if (!empty($resultTop[0]['usrid_long3'])){
			$approval_email1 = $resultTop[0]['usrid_long3'];
			$approval_id1 = $resultTop[0]['division_head'];
			$approval_name1 = $resultTop[0]['divhead_name'];

			$approval_email2 = $resultTop[0]['usrid_long4'];
			$approval_em2 = decrypt($approval_email2);

			if($approval_em2 == 'makmur@ibsmulti.com' || $approval_em2 == 'MAKMUR@IBSMULTI.COM'){
				$approval_email2 = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id2 = '88088024';
				$approval_name2 = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email2 = $resultTop[0]['usrid_long4'];
				$approval_id2 = $resultTop[0]['director'];
				$approval_name2 = $resultTop[0]['director_name'];
			}
			// $approval_email2 = $resultTop[0]['usrid_long4'];
			// $approval_id2 = $resultTop[0]['director'];
			// $approval_name2 = $resultTop[0]['director_name'];			
		} else if (!empty($resultTop[0]['usrid_long4'])){
			$approval_email1 = $resultTop[0]['usrid_long4'];
			$approval_em1 = decrypt($approval_email1);

			if($approval_em1 == 'makmur@ibsmulti.com' || $approval_em1 == 'MAKMUR@IBSMULTI.COM'){
				$approval_email1 = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id1 = '88088024';
				$approval_name1 = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email1 = $resultTop[0]['usrid_long4'];
				$approval_id1 = $resultTop[0]['director'];
				$approval_name1 = $resultTop[0]['director_name'];
			}
			
			$approval_email2 = $resultTop[0]['usrid_long4'];
			$approval_em2 = decrypt($approval_email2);

			if($approval_em2 == 'makmur@ibsmulti.com' || $approval_em2 == 'MAKMUR@IBSMULTI.COM'){
				$approval_email2 = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id2 = '88088024';
				$approval_name2 = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email2 = $resultTop[0]['usrid_long4'];
				$approval_id2 = $resultTop[0]['director'];
				$approval_name2 = $resultTop[0]['director_name'];
			}

			// $approval_email1 = $resultTop[0]['usrid_long4'];
			// $approval_id1 = $resultTop[0]['director'];
			// $approval_name1 = $resultTop[0]['director_name'];

			// $approval_email2 = $resultTop[0]['usrid_long4'];
			// $approval_id2 = $resultTop[0]['director'];
			// $approval_name2 = $resultTop[0]['director_name'];
		}

		$x = 1;
		while ($x <= 2){
			$alias = str_replace('@IBSMULTI.COM', '', decrypt(${"approval_email" . $x}));
			if ($x == 2){
				$appr_status = ''; 
			} else {
				$appr_status = 'In Progress';
			}

			$approval = array(
				'request_id' => $queryRequest,
				'approval_priority' => $x,
				'approval_email' => strtolower(decrypt(${"approval_email" . $x})),
				'approval_status' => $appr_status,
				'created_at' => $this->date,
				'created_by' => $this->email,
				'approval_alias' => strtolower($alias),
				'is_read' => 0,
				'approval_employee_id' => decrypt(${"approval_id" . $x})
			);
			$approve = $this->db->insert('form_approval', $approval);

			$x++;
		}
		
		$hr_user = $this->db->select('user_email, employee_id')
							->where('access_level', '7')
							->where('employee_id !=', $nik)
							->order_by('id_user', 'ASC')
							->get('users')->result_array();

		$aliasHR = 'HR';

		foreach ($hr_user as $key) {
			$approval = array(
				'request_id' => $queryRequest,
				'approval_priority' => 3,
				'approval_employee_id' => $key['employee_id'],
				'approval_email' => $key['user_email'],
				'approval_alias' => $aliasHR,
				'approval_status' => '',
				'approval_note' => '',
				'is_read' => 0,
				'created_at' => $this->date,
				'created_by' => $this->email
			);
			$this->db->insert('form_approval', $approval);
		}

		if ($approve){
			$config['cacheable']    = true;
			$config['cachedir']     = './assets/';
			$config['errorlog']     = './assets/';
			$config['imagedir']     = './assets/images/qrcode_tm_schedule/';
			$config['quality']      = true;
			$config['size']         = '1024';
			$config['black']        = array(224,255,255);
			$config['white']        = array(70,130,180);
			$this->ciqrcode->initialize($config);
			$image_name= $req_no.'-'.$nik.'.png';
			$params['data'] = $req_no.'-'.$nik;
			$params['level'] = 'H'; //H=High
			$params['size'] = 10;
			$params['savename'] = FCPATH.$config['imagedir'].$image_name;
			$this->ciqrcode->generate($params);

			return array(true, $queryRequest, strtolower(decrypt($approval_email1)), strtolower(decrypt($approval_name1)));
		} else {
			return array(false, '', '', '');
		}
	}

	public function getDeleteRequestSchedule_ztm($id, $opt) // TIME MANAGEMENT 2.1
	{
		$this->db->select('*');
		if ($opt == 'hr_adj'){
			$this->db->from('hris_time_management_adjustment');
		} else {
			$this->db->from('hris_schedule_request');
		}
		$this->db->where('id', $id);
		$schedule_req = $this->db->get()->result_array();
		
		if ($opt == 'hr_adj'){
			$request_no = $schedule_req[0]['request_number'];

			$this->db->select('id');
			$this->db->from('form_request');
			$this->db->where('request_number', $request_no);
			$form_req_id = $this->db->get()->result_array();

			$request_id = $form_req_id[0]['id'];

			$sql = "UPDATE hris_time_management_adjustment SET status=3 WHERE id = '$id'";
			$query = $this->db->query($sql);
		} else {
			$request_id = $schedule_req[0]['request_id'];

			$sql = "UPDATE hris_schedule_request SET status=3 WHERE id = '$id'";
			$query = $this->db->query($sql);
		}

		$update_datetime = $this->date;
		$update_email = $this->email;

		$sqlDelAppr = "UPDATE form_approval SET approval_status='Canceled by User', updated_at='$update_datetime', updated_by='$update_email' 
					WHERE request_id = '$request_id'";
		$queryDelAppr = $this->db->query($sqlDelAppr);

		$sqlDelReq = "UPDATE form_request SET is_status=8, deleted_by='$update_email', deleted_at='$update_datetime' WHERE id = '$request_id'";
		$queryDelReq = $this->db->query($sqlDelReq);

		$this->db->select('approval_email');
		$this->db->from('form_approval');
		$this->db->where('request_id', $request_id);
		$this->db->where('approval_status', 'Canceled by User');
		$resultEmail = $this->db->get()->result_array();
		$approval_email = $resultEmail[0]['approval_email'];

		$this->db->select('complete_name');
		$this->db->from('v_hris_employee_updated');
		$this->db->where('email', strtoupper(encrypt($approval_email)));
		$complete_name = $this->db->get()->result_array();
		$nama_approver = decrypt($complete_name[0]['complete_name']);
		
		if ($queryDelAppr){
			return array(true, $request_id, $approval_email, $nama_approver);
		} else {
			return array(false, '', '', '');
		}
	}

	public function getScheduleRequest_ztm($nik){
		$sql = "SELECT * FROM hris_schedule_request WHERE nik='$nik' ORDER BY id ASC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function getRequestSchedule_ztm($request_id){
		$this->db->select('*');
		$this->db->from('hris_schedule_request');
		$this->db->where('request_id', $request_id);
		
		return $this->db->get()->result_array();
	}

	public function getReqFormDate_ztm($id){
		$this->db->select('*');
		$this->db->from('form_request');
		$this->db->where('id', $id);
		
		return $this->db->get()->result_array();
	}

	public function getUserDetail_ztm($email){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_email', $email);
		$res = $this->db->get()->result();

		return $res[0];
	}

	public function getDayOff_ztm(){
		$today = date('Y-m-d');
		$two_months = date('Y-m', strtotime("-2 months"));

		$sql = "SELECT * FROM hris_master_calendar WHERE (dws_code LIKE 'DO%' OR dws_code LIKE 'CTB') AND (holiday_calendar IS NOT NULL AND holiday_calendar !='') AND date between '$two_months-01' and '$today'";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function getHolidaySchedule_ztm($emp_id, $date){ 
		$this_date = $date[0];
		$sentence = "AND a.date = '$this_date'";
		if (count($date) > 1){
			$new = "AND (a.date = '$this_date' ";
			for ($i=1; $i<count($date); $i++){
				$add_date = $date[$i];
				$new .= "OR a.date = '$add_date' ";
			}
			$sentence = $new . ')';
		}

		$sql = "SELECT a.*, b.shift_type FROM hris_master_time_management a
				LEFT JOIN hris_master_schedule b ON a.schedule_code = b.kode
				LEFT JOIN v_hris_nik_company c ON a.employee_id = c.nik
				WHERE a.employee_id = '$emp_id'". $sentence ."  
				AND (b.company_code = c.company_code OR a.schedule_code LIKE 'DO%')";
		$query = $this->db->query($sql);
		// dumper($sql);
		return $result = $query->result();
	}

	public function submitRequestTMHoliday_ztm($type, $nik, $date, $purpose, $location, $no){ 
		$no++;
		// $req_no = 'EAPP_TM_V2' . str_pad($no,6,"0", STR_PAD_LEFT);
		$req_no = 'HRIS_TM_'.$this->year.str_pad($no, 6, 0, STR_PAD_LEFT);

		$formDataRequest = array(
			'request_number' => $req_no,
			'form_type' => 'TM',
			'is_status' => 1,
			'created_by' => $this->email,
			'created_at' => $this->date,
			'revised_at' => $this->date,
			'employee_id' => $this->session->userdata('employee_id'),
			'is_status_admin_hr' => 0,
			'is_status_divhead_hr' => 7
		);
		$this->db->insert("form_request", $formDataRequest);
		$queryRequest = $this->db->insert_id();

		$formDataSchedule = array(
			'request_id' => $queryRequest,
			'request_number' => $req_no,
			'schedule_type' => $type,
			'nik' => $nik,
			'start_date' => $this->today,
			'end_date' => $this->today,
			'ket' => $purpose,
			'date' => serialize($date),
			'lokasi' => $location,
			'status' => 0
		);
		$this->db->insert("hris_schedule_request", $formDataSchedule);

		$formData = array(
			'jenis' => 'Schedule Holiday',
			'request_number' => $req_no,
			'start_date' => $this->today,
			'end_date' => $this->today,
			'status' => 7,
			'nik' => $nik
		);
		$this->db->insert("hris_request_time_off", $formData);

		$sqlTop = "SELECT rpm, rpm_name, usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4 
		FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
		// dumper($sqlTop);
		$queryTop = $this->db->query($sqlTop);
		$resultTop = $queryTop->result_array();

		if(!empty($resultTop[0]['usrid_long5'])){
			$approval_email1 = $resultTop[0]['usrid_long5'];
			$approval_id1 = $resultTop[0]['rpm'];
			$approval_name1 = $resultTop[0]['rpm_name'];

			$approval_email2 = $resultTop[0]['usrid_long3'];
			$approval_id2 = $resultTop[0]['division_head'];
			$approval_name2 = $resultTop[0]['divhead_name'];
		} else if (!empty($resultTop[0]['usrid_long2'])){
			$approval_email1 = $resultTop[0]['usrid_long2'];
			$approval_id1 = $resultTop[0]['department_head'];
			$approval_name1 = $resultTop[0]['depthead_name'];

			$approval_email2 = $resultTop[0]['usrid_long3'];
			$approval_id2 = $resultTop[0]['division_head'];
			$approval_name2 = $resultTop[0]['divhead_name'];
		} else if (!empty($resultTop[0]['usrid_long3'])){
			$approval_email1 = $resultTop[0]['usrid_long3'];
			$approval_id1 = $resultTop[0]['division_head'];
			$approval_name1 = $resultTop[0]['divhead_name'];

			$approval_email2 = $resultTop[0]['usrid_long4'];
			$approval_em2 = decrypt($approval_email2);
			if($approval_em2 == 'makmur@ibsmulti.com' || $approval_em2 == 'MAKMUR@IBSMULTI.COM'){
				$approval_email2 = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id2 = '88088024';
				$approval_name2 = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email2 = $resultTop[0]['usrid_long4'];
				$approval_id2 = $resultTop[0]['director'];
				$approval_name2 = $resultTop[0]['director_name'];
			}
			// $approval_email2 = $resultTop[0]['usrid_long4'];
			// $approval_id2 = $resultTop[0]['director'];
			// $approval_name2 = $resultTop[0]['director_name'];			
		} else if (!empty($resultTop[0]['usrid_long4'])){
			$approval_email1 = $resultTop[0]['usrid_long4'];
			$approval_em1 = decrypt($approval_email1);
			if($approval_em1 == 'makmur@ibsmulti.com' || $approval_em1 == 'MAKMUR@IBSMULTI.COM'){
				$approval_email1 = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id1 = '88088024';
				$approval_name1 = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email1 = $resultTop[0]['usrid_long4'];
				$approval_id1 = $resultTop[0]['director'];
				$approval_name1 = $resultTop[0]['director_name'];
			}
			// $approval_email1 = $resultTop[0]['usrid_long4'];
			// $approval_id1 = $resultTop[0]['director'];
			// $approval_name1 = $resultTop[0]['director_name'];

			$approval_email2 = $resultTop[0]['usrid_long4'];
			$approval_em2 = decrypt($approval_email2);
			if($approval_em2 == 'makmur@ibsmulti.com' || $approval_em2 == 'MAKMUR@IBSMULTI.COM'){
				$approval_email2 = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id2 = '88088024';
				$approval_name2 = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email2 = $resultTop[0]['usrid_long4'];
				$approval_id2 = $resultTop[0]['director'];
				$approval_name2 = $resultTop[0]['director_name'];
			}
			// $approval_email2 = $resultTop[0]['usrid_long4'];
			// $approval_id2 = $resultTop[0]['director'];
			// $approval_name2 = $resultTop[0]['director_name'];
		}

		

		$x = 1;
		while ($x <= 2){
			$alias = str_replace('@IBSMULTI.COM', '', decrypt(${"approval_email" . $x}));
			if ($x == 2){
				$appr_status = ''; 
			} else {
				$appr_status = 'In Progress';
			}

			$approval = array(
				'request_id' => $queryRequest,
				'approval_priority' => $x,
				'approval_email' => strtolower(decrypt(${"approval_email" . $x})),
				'approval_status' => $appr_status,
				'created_at' => $this->date,
				'created_by' => $this->email,
				'approval_alias' => strtolower($alias),
				'is_read' => 0,
				'approval_employee_id' => decrypt(${"approval_id" . $x})
			);
			$approve = $this->db->insert('form_approval', $approval);

			$x++;
		}

		$hr_user = $this->db->select('user_email, employee_id')
							->where('access_level', '7')
							->where('employee_id !=', $nik)
							->order_by('id_user', 'ASC')
							->get('users')->result_array();

		$aliasHR = 'HR';

		foreach ($hr_user as $key) {
			$approval = array(
				'request_id' => $queryRequest,
				'approval_priority' => 3,
				'approval_employee_id' => $key['employee_id'],
				'approval_email' => $key['user_email'],
				'approval_alias' => $aliasHR,
				'approval_status' => '',
				'approval_note' => '',
				'is_read' => 0,
				'created_at' => $this->date,
				'created_by' => $this->email
			);
			$this->db->insert('form_approval', $approval);
		}

		if ($approve){
			$config['cacheable']    = true;
			$config['cachedir']     = '/assets/';
			$config['errorlog']     = '/assets/';
			$config['imagedir']     = '/assets/images/qrcode_tm_schedule/';
			$config['quality']      = true;
			$config['size']         = '1024';
			$config['black']        = array(224,255,255);
			$config['white']        = array(70,130,180);
			$this->ciqrcode->initialize($config);
			$image_name= $req_no.'-'.$nik.'.png';
			$params['data'] = $req_no.'-'.$nik;
			$params['level'] = 'H'; //H=High
			$params['size'] = 10;
			$params['savename'] = FCPATH.$config['imagedir'].$image_name;
			$this->ciqrcode->generate($params);

			return array(true, $queryRequest, strtolower(decrypt($approval_email1)), strtolower(decrypt($approval_name1)));
		} else {
			return array(false, '', '', '');
		}
	}

	public function getYears_ztm(){
		$sql = "SELECT date FROM hris_master_calendar WHERE date LIKE '%-12-31' ORDER BY date DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function updateShiftAttendance_ztm($id, $time, $type, $shift_type){
		$sql1 = "SELECT employee_id, date, check_in, check_out FROM hris_master_time_management WHERE id=$id";
		$query1 = $this->db->query($sql1);
		$result1 = $query1->result();
		$nik = $result1[0]->employee_id;
		$date = $result1[0]->date;
		$check_in = $result1[0]->check_in;
		$check_out = $result1[0]->check_out;

		$this->db->select('*');
		$this->db->from('hris_master_shift_management');
		$this->db->where('employee_id', $nik);
		$this->db->where('date', $date);
		$exist = $this->db->get()->result();

		if (empty($exist)){
			if ($type == 0){
				$data = array(
					'employee_id' => $nik,
					'date' => $date,
					'actual_in' => $time,
					'actual_out' => $check_out,
					'shift_type' => $shift_type
				);
			} else {
				$data = array(
					'employee_id' => $nik,
					'date' => $date,
					'actual_in' => $check_in,
					'actual_out' => $time,
					'shift_type' => $shift_type
				);
			}
			$query = $this->db->insert('hris_master_shift_management', $data);
		} else {
			if ($type == 0){
				$sql = "UPDATE hris_master_shift_management SET actual_in='$time' WHERE employee_id='$nik' AND date='$date'";
			} else {
				$sql = "UPDATE hris_master_shift_management SET actual_out='$time' WHERE employee_id='$nik' AND date='$date'";
			}
			$query = $this->db->query($sql);
		}
		
		if($query){
			return true;
		}
	}

	public function getAppFormDate_ztm($id, $layer){
		$this->db->select('*');
		$this->db->from('form_approval');
		$this->db->where('request_id', $id);
		$this->db->where('approval_priority', $layer);
		$data = $this->db->get()->result_array();
		
		return $data[0];
	}

	public function checkSchedule_ztm($nik, $start, $end){
		$sql = "SELECT * FROM hris_master_time_management WHERE employee_id='$nik' AND date BETWEEN '$start' and '$end' AND schedule_code LIKE 'SHF%'";
		
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if (!empty($result)){
			return true;
		} else {
			return false;
		}
	}

	public function updateShiftSchedule_ztm($id, $type="", $list_shift='', $list_shift_un=''){
		$this->db->select('*');
		$this->db->from('hris_schedule_request');
		$this->db->where('request_id', $id);
		$data 		= $this->db->get()->result_array();
		$start_date = $data[0]['start_date'];
		$end_date 	= $data[0]['end_date'];

		if($data[0]['schedule_type'] = 'holiday'){
			$add1 = ', flag = 1';
			$add2 = ', flag = NULL';
		} else {
			$add1 = '';
			$add2 = '';
		}
		if (!empty($list_shift)){
			foreach ($list_shift as $value){
				$sql = "UPDATE hris_master_time_management SET note='checked' ".$add1." WHERE id=$value";
				$query = $this->db->query($sql);
			}
		}
		if (!empty($list_shift_un)){
			foreach ($list_shift_un as $value2){
				$sql = "UPDATE hris_master_time_management SET note=NULL ".$add2." WHERE id=$value2";
				$query = $this->db->query($sql);
			}
		}
		if($type == 'Reject'){
				$sql = "UPDATE hris_master_time_management SET note = NULL, flag = NULL WHERE date BETWEEN '$start_date' AND '$end_date'";
				$query = $this->db->query($sql);
		}else{
			if ($this->session->userdata('access_employee') != '12'){
				$query = true;
			}
		}
		
		if($query){
			return true;
		}
	}

	public function getEmpDetail_ztm($emp){
		$detail = array();

		foreach ($emp as $value) { 
			$email = encrypt($value['email_karyawan']);

			$this->db->select('*');
			$this->db->from('v_hris_employee_updated');
			$this->db->where('email', $email);
			$data = $this->db->get()->result_array();

			$detail['name'] = ucwords(strtolower(decrypt($data[0]['complete_name'])));
			$detail['nik'] = $data[0]['nik'];
			$result[] = $detail;
		}

		return $result;
	}

	public function updateShiftAttendanceDate_ztm($id, $date, $type){
		if ($type == 0){
			$sql = "UPDATE hris_master_time_management SET check_in_date='$date' WHERE id='$id'";
		} else {
			$sql = "UPDATE hris_master_time_management SET check_out_date='$date' WHERE id='$id'";
		}
		$query = $this->db->query($sql);
		
		if($query){
			return true;
		}
	}

	public function updateInfoHoliday_ztm($id, $purpose, $location){
		$formData = array(
			'ket' => $purpose,
			'lokasi' => $location
		);

		$this->db->where('request_id', $id);
		if ($this->db->update('hris_schedule_request', $formData)) {
			return true;
		} else {
			return false;
		}
	}

	public function getLastDay_ztm(){
		$sql = "SELECT * FROM hris_master_calendar ORDER BY date DESC LIMIT 1";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res[0]['date'];
	}

	public function getCTAB_ztm($nik){
		if (date('d') <= 10){
			$this_month = date('Y-m', strtotime('-1 month'));
			$this_month_last = date('Y-m-d');
		} else {
			$this_month = date('Y-m');
			$this_month_last = date('Y-m-t');
		}

		$sql = "SELECT * FROM hris_time_management_employee a 
				LEFT JOIN hris_master_time_off b ON a.tipe_perubahan = b.nama
				LEFT JOIN v_hris_nik_company c ON a.nik = c.nik
				WHERE a.nik = '$nik' AND b.kode = 'CTAB' AND b.company_code = c.company_code 
				AND (a.date BETWEEN '$this_month-01' AND '$this_month_last') AND a.status=0";
		
		$query = $this->db->query($sql);
		$result = $query->num_rows();

		if (!empty($result)){
			return $result;
		} else {
			return 0;
		}
	}

	public function getTrueEmpData_ztm($nik, $action){
		$sql = "SELECT * FROM hris_employee WHERE nik = '$nik' AND action != '$action' ORDER BY id_employee DESC";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res[0];
	}

	public function getTruePersonal_ztm($nik, $action = 'Tqiomvd#'){
		$sql = "SELECT * FROM hris_employee WHERE nik = '$nik' AND action != '$action' ORDER BY id_employee DESC LIMIT 1";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
	}

	public function updateInfoShift_ztm($id, $purpose){
		$sql = "UPDATE hris_schedule_request SET ket='$purpose' WHERE request_id='$id'";
		$query = $this->db->query($sql);
		
		if($query){
			return true;
		}
	}

	public function getDetailedShift_ztm($nik, $date){
		$sql = "SELECT * FROM hris_master_shift_management WHERE employee_id='$nik' AND date='$date'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if($res){
			return $res[0];
		}else{
			return false;
		}
		
	}

	public function getShiftScheduleActual_ztm($emp_id, $start_date, $end_date){
		$sql = "SELECT e.nama AS time_off, d.date AS actual_date, d.actual_in, d.actual_out, d.shift_type AS actual_type, a.*, b.shift_type 
				FROM hris_master_time_management a
				LEFT JOIN hris_master_schedule b ON a.schedule_code = b.kode
				LEFT JOIN v_hris_nik_company c ON a.employee_id = c.nik
				LEFT JOIN hris_master_shift_management d ON a.employee_id = d.employee_id AND a.date = d.date
				LEFT JOIN hris_master_time_off e ON a.time_off_code = e.kode AND e.company_code = c.company_code AND e.end_date = '9999-12-31'
				WHERE a.employee_id = '$emp_id' AND a.date >= '$start_date' AND a.date <= '$end_date' 
				AND (b.company_code = c.company_code OR a.schedule_code LIKE 'DO%')
				ORDER BY a.date ASC";
		$query = $this->db->query($sql);
		return $result = $query->result();
	}

	public function updateShiftType_ztm($id, $shift_type){
		$sql1 = "SELECT employee_id, date, check_in, check_out FROM hris_master_time_management WHERE id=$id";
		$query1 = $this->db->query($sql1);
		$result1 = $query1->result();
		$nik = $result1[0]->employee_id;
		$date = $result1[0]->date;
		$check_in = $result1[0]->check_in;
		$check_out = $result1[0]->check_out;

		$this->db->select('*');
		$this->db->from('hris_master_shift_management');
		$this->db->where('employee_id', $nik);
		$this->db->where('date', $date);
		$exist = $this->db->get()->result();

		if (empty($exist)){
			$data = array(
				'employee_id' => $nik,
				'date' => $date,
				'actual_in' => $check_in,
				'actual_out' => $check_out,
				'shift_type' => $shift_type
			);
			$query = $this->db->insert('hris_master_shift_management', $data);
		} else {
			$sql = "UPDATE hris_master_shift_management SET shift_type='$shift_type' WHERE employee_id='$nik' AND date='$date'";
			$query = $this->db->query($sql);
		}
		
		if($query){
			return true;
		}
	}

	public function getHolidayScheduleActual_ztm($emp_id, $date){ 
		$this_date = $date[0];
		$sentence = "AND a.date = '$this_date'";
		if (count($date) > 1){
			$new = "AND (a.date = '$this_date' ";
			for ($i=1; $i<count($date); $i++){
				$add_date = $date[$i];
				$new .= "OR a.date = '$add_date' ";
			}
			$sentence = $new . ')';
		}

		$sql = "SELECT e.nama AS time_off, d.date AS actual_date, d.actual_in, d.actual_out, a.* 
				FROM hris_master_time_management a
				LEFT JOIN hris_master_schedule b ON a.schedule_code = b.kode
				LEFT JOIN v_hris_nik_company c ON a.employee_id = c.nik
				LEFT JOIN hris_master_shift_management d ON a.employee_id = d.employee_id AND a.date = d.date
				LEFT JOIN hris_master_time_off e ON a.time_off_code = e.kode AND e.company_code = c.company_code AND e.end_date = '9999-12-31'
				WHERE a.employee_id = '$emp_id'". $sentence ."
				AND (b.company_code = c.company_code OR a.schedule_code LIKE 'DO%')
				ORDER BY a.date ASC";
		$query = $this->db->query($sql);
		// dumper($sql);
		return $result = $query->result();
	}

	public function requestLocation_ztm($date, $file_in, $file_out, $no){
		$no++;
		// $req_no = 'EAPP_TM_V2' . str_pad($no,6,"0", STR_PAD_LEFT);
		$req_no = 'HRIS_TMRL'.$this->year.str_pad($no, 6, 0, STR_PAD_LEFT);

		$formDataRequest = array(
			'request_number' => $req_no,
			'form_type' => 'TM',
			'is_status' => 1,
			'created_by' => $this->email,
			'created_at' => $this->date,
			'revised_at' => $this->date,
			'employee_id' => $this->session->userdata('employee_id'),
			'is_status_admin_hr' => 8,
			'is_status_divhead_hr' => 0
		);
		$this->db->insert("form_request", $formDataRequest);
		$queryRequest = $this->db->insert_id();

		$formData = array(
			'request_id' => $queryRequest,
			'request_number' => $req_no,
			'jenis' => 'Request Revised Location',
			'start_date' => $date,
			'end_date' => $date,
			'status' => 0,
			'nik' => $this->session->userdata('employee_id'),
			'waktu_masuk' => $file_in,
			'waktu_keluar' => $file_out
		);
		$query = $this->db->insert("hris_request_time_off", $formData);

		$nik = $this->session->userdata('employee_id');
		$sqlTop = "SELECT superior, superior_name, usrid_long1, rpm, rpm_name, usrid_long5, department_head, depthead_name, usrid_long2, 
				division_head, divhead_name, usrid_long3, director, director_name, usrid_long4 
				FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
		$queryTop = $this->db->query($sqlTop);
		$resultTop = $queryTop->result_array();

		if (!empty($resultTop[0]['usrid_long1'])) {
			$approval_email = $resultTop[0]['usrid_long1'];
			$approval_id = $resultTop[0]['superior'];
			$approval_name = $resultTop[0]['superior_name'];
		}else if(!empty($resultTop[0]['usrid_long5'])){
			$approval_email = $resultTop[0]['usrid_long5'];
			$approval_id = $resultTop[0]['rpm'];
			$approval_name = $resultTop[0]['rpm_name'];
		} else if (!empty($resultTop[0]['usrid_long2'])){
			$approval_email = $resultTop[0]['usrid_long2'];
			$approval_id = $resultTop[0]['department_head'];
			$approval_name = $resultTop[0]['depthead_name'];
		} else if (!empty($resultTop[0]['usrid_long3'])){
			$approval_email = $resultTop[0]['usrid_long3'];
			$approval_id = $resultTop[0]['division_head'];
			$approval_name = $resultTop[0]['divhead_name'];
		} else if (!empty($resultTop[0]['usrid_long4'])){

			$approval_email = $resultTop[0]['usrid_long4'];
			$approval_em = decrypt($approval_email);

			if($approval_em == 'makmur@ibsmulti.com' || $approval_em == 'MAKMUR@IBSMULTI.COM'){
				$approval_email = encrypt('ANANDHA.HOKKY@IBSMULTI.COM');
				$approval_id = '88088024';
				$approval_name = 'VVSLS#IIW  #IW#ILSPP#VWG';
			}else{
				$approval_email = $resultTop[0]['usrid_long4'];
				$approval_id = $resultTop[0]['director'];
				$approval_name = $resultTop[0]['director_name'];
			}
			// $approval_email = $resultTop[0]['usrid_long4'];
			// $approval_id = $resultTop[0]['director'];
			// $approval_name = $resultTop[0]['director_name'];
		}

		$alias = str_replace('@IBSMULTI.COM', '', decrypt($approval_email));

		$formApproval = array(
			'request_id' => $queryRequest,
			'approval_priority' => 1,
			'approval_email' => strtolower(decrypt($approval_email)),
			'approval_status' => 'In Progress',
			'created_at' => $this->date,
			'created_by' => $this->email,
			'approval_alias' => strtolower($alias),
			'is_read' => 0,
			'approval_employee_id' => decrypt($approval_id)
		);
		$this->db->insert("form_approval", $formApproval);

		if ($query){
			return array(true, $queryRequest, decrypt($approval_email), decrypt($approval_name));
		} else {
			return array(false, '');
		}
	}

	public function CekApprovalLayer($request_number){
		$sql = "SELECT
						(CASE 
						WHEN COUNT(a.id) > 0 THEN TRUE
						ELSE FALSE
						END) AS result
				FROM form_approval a
				RIGHT JOIN form_request AS b ON a.request_id = b.id
				WHERE b.request_number LIKE '$request_number' AND a.approval_status LIKE 'Approved'";
		$query = $this->db->query($sql);
		// dumper($sql);
		$result = $query->result();
		return $result;
	}

	public function getCalendarEmployee($end_date){
		$employee_id 				= $this->session->userdata('employee_id');
		$sql = "SELECT date FROM hris_master_time_management WHERE date LIKE '$end_date' AND employee_id LIKE '$employee_id'";
		$query = $this->db->query($sql);
		$result = $query->result();
		if($result){
			return true;
		}else{
			return false;
		}

	}

	// END
	//////////////////////////////////////////////////// TIME MANAGEMENT 2024////////////////////////////////////////////////////
	
	//////////////////////////////////////////Update Logs 2025//////////////////////////////////////////////////////
	public function logs($type, $formType, $id, $activity = '', $description = '')
	{

		$log['request_id'] = $id;
		$log['form_type'] = $formType;
		$log['created_by'] = ($type == 'system') ? 'system' : $this->email;
		$log['created_at'] = $this->date;

		switch ($type) {
			
			case 'request_adjuct_cuti':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

	////////////////////////////////////////////Start Update PA 2025//////////////////////////////////////////////////
	public function get_qa($id){
		
        $sqlInfo    = "SELECT * FROM performance_appraisal_qualitative_assesment WHERE req_id_pa LIKE '$id'";
        $result     = $this->db->query($sqlInfo);
        $info       = $result->result_array();
		
        if($info){
            return $info;
        }else{
			$data = array(
			'id'					=>	'',
			'req_id_pa'				=>	'',
			'request_number'		=>	'',
			'work_efficiency'		=>	'',
			'work_quality'			=>	'',
			'communication'			=>	'',
			'planning_organizing'	=>	'',
			'problem_solving'		=>	'',
			'team_work'				=>	'',
			'potential'				=>	'',
			'initiative'			=>	'',
			'leadership'			=>	'',
			'create_at'				=>	'',
			'create_bt'				=>	''
			);
			$info[] = $data;
			return $info;
        }
	}
	
	public function post_qa($id, $plan_score, $id_req){
		
		if($id == 1){
			$attr = 'work_efficiency';
		}elseif($id == 2){
			$attr = 'work_quality';
		}elseif($id == 3){
			$attr = 'communication';
		}elseif($id == 4){
			$attr = 'planning_organizing';
		}elseif($id == 5){
			$attr = 'problem_solving';
		}elseif($id == 6){
			$attr = 'team_work';
		}elseif($id == 7){
			$attr = 'potential';
		}elseif($id == 8){
			$attr = 'initiative';
		}elseif($id == 9){
			$attr = 'leadership';
		}
        $sql = "UPDATE performance_appraisal_qualitative_assesment SET ".$attr." = '$plan_score' WHERE req_id_pa='$id_req'";
		$query = $this->db->query($sql);
        if($query){
            return true;
        }else{
			return false;
        }
	}
	
	public function post_content_pa($content, $type, $id_req){
		
        $sql = "UPDATE performance_appraisal_qualitative_assesment SET ".$type." = '$content' WHERE req_id_pa='$id_req'";
		$query = $this->db->query($sql);
        if($query){
            return true;
        }else{
			return false;
        }
	}

	public function save_documents_evidence($data, $s){
		
		if($s == 'n'){
			try{
				$this->db->insert('performance_appraisal_documentary_evidence', $data);
				return true;
			  }catch(Exception $e){
			}
		}else{
			
			$documents 		= $this->m_global->find('performance_appraisal_documentary_evidence', 'request_number', $data['request_number'])->row_array()['documents'];
			$file_pointer   = "./assets/documents/documents_pa/$documents";
			unlink($file_pointer);

			$this->db->where('request_number', $data['request_number']);
			if ($this->db->update('performance_appraisal_documentary_evidence', $data)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function cek_documents_evidence_table($request_number){
		$sql 		= "SELECT * FROM performance_appraisal_documentary_evidence WHERE request_number ='$request_number'";
		$query 		= $this->db->query($sql);
		$res 		= $query->num_rows();
		return $res;
	}

	////////////////////////////////////////////End Update PA 2025//////////////////////////////////////////////////

	private function createRequestNumber($formType)
	{
		$year = date('Y');
		$this->db->trans_begin();
		$this->db->where('year', $year);
		$this->db->where('form_type', $formType);
		$query = $this->db->get('request_sequence');

		if ($query->num_rows() === 0) {
			$reqnum = 1;
			$this->db->insert('request_sequence', [
				'year'        => $year,
				'form_type'   => $formType,
				'last_number' => $reqnum
			]);
		} else {
			$row = $query->row();
			$reqnum = $row->last_number + 1;

			$this->db->where('id', $row->id);
			$this->db->update('request_sequence', [
				'last_number' => $reqnum
			]);
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			throw new Exception('Gagal generate request number');
		}
		$this->db->trans_commit();
		$requestNumber = sprintf(
			'HRIS_%s_%s%06d',
			$formType,
			$year,
			$reqnum
		);

		return $requestNumber;
	}

	//////////////////////////////Start Penambahan action sent to AP Luffi 2025//////////////////////////////
	public function SentDocumentsToAP($no_req_mdcr)
	{

		$this->db->where('no_req_mdcr', $no_req_mdcr);
		$this->db->where('is_status_admin_hr', '1');
		$this->db->where('is_status_divhead_hr', '1');
		$result = $this->db->update('form_request', ['is_status_progress' => 3]);

		$this->db->where('no_req_mdcr', $no_req_mdcr);
		$this->db->update('hris_no_req_mdcr', ['is_status_progress' => 3]);

		return $result;
	}
	//////////////////////////////End Penambahan action sent to AP Luffi 2025//////////////////////////////

	public function getAllFormGroup($no_req_mdcr)
	{

		$sql = "SELECT * FROM form_request WHERE no_req_mdcr = '$no_req_mdcr'";
		$query = $this->db->query($sql);
		$res = $query->result();

		return $res;
	}

	public function createApproval($data, $step = [])
	{
		// type RESIGNATION_LETTER, EXIT_CLEARANCE
		$this->db->trans_begin();
		$this->db->insert('exit_clearance_approval_request', $data);
		$id = $this->db->insert_id();
		if(!empty($step)){
			foreach ($step as $key => &$value) {
				$value['id_approval_req'] = $id;
			}
			$this->db->insert_batch('exit_clearance_approval_steps', $step);
		}
		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			throw new Exception('Gagal membuat approval');
		}
		$this->db->trans_commit();
		return $id;
	}
	public function deleteApproval($id)
	{
		$this->db->trans_begin();
		$this->db->where('id_form_request', $id);
		$data = $this->db->get('exit_clearance_approval_request')->row();
		if (!$data) {
			$this->db->trans_rollback();
			throw new Exception('Approval tidak ditemukan');
		}

		$this->db->where('id_approval_req', $data->id);
		$this->db->update('exit_clearance_approval_steps', ['status' => 3]);
		$this->db->where('id_form_request', $id);
		$this->db->update('exit_clearance_approval_request', ['status' => 3]);
		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			throw new Exception('Gagal menghapus approval');
		}
		$this->db->trans_commit();
		return true;
	}
	public function assignRoles($id, $roles)
	{
		$this->db->trans_begin();
		$this->db->where('id_employee', $id);
		$this->db->where('id_role', $roles);
		$exist = $this->db->get('exit_clearance_user_roles')->row();
		if(!$exist){
			$this->db->insert('exit_clearance_user_roles', [
				'id_employee' => $id,
				'id_role' => $roles
			]);
		}
		$this->db->trans_commit();
		return true;
	}
	public function getReason($id, $type)
	{
		if($type === "Resignation Letter")
		{
			$kolom = 'id_resignation_letter';
		}else{
			$kolom = 'id_exit_clearance';
		}
		$this->db->select('*');
		$this->db->from('exit_clearance_notes');
		$this->db->where($kolom, $id);
		$this->db->order_by('created_at', 'DESC');
		$data = $this->db->get()->result_array();
		if($data){
			return $data;
		}else{
			return '';
		}
	}
	public function updateStatusApproval($id)
	{
		$this->db->trans_begin();
		$this->db->where('id_form_request', $id);
		$data = $this->db->get('exit_clearance_approval_request')->row();
		if (!$data) {
			$this->db->trans_rollback();
			throw new Exception('Approval tidak ditemukan');
		}
		$this->db->where('id_form_request', $id);
		$this->db->update('exit_clearance_approval_request', ['status' => 0]);
		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			throw new Exception('Gagal mengupdate status approval');
		}
		$this->db->where('id_approval_req', $data->id);
		$this->db->update('exit_clearance_approval_steps', ['status' => 0]);
		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			throw new Exception('Gagal mengupdate status approval steps');
		}
		$this->db->trans_commit();
		return true;
	}
	public function addNote($id, $type, $note)
	{
		if($type === "Resignation Letter")
		{
			$kolom = 'id_resignation_letter';
		}else{
			$kolom = 'id_exit_clearance';
		}
		$data = [
			$kolom => $id,
			'note' => $note,
			'created_by' => $this->email,
			'created_at' => $this->date
		];
		return $this->db->insert('exit_clearance_notes', $data);
	}
	public function getAllEmployee($nik = null)
	{
		$outsource = encrypt('Outsource');
		$intership = encrypt('Internship');
		$this->db->select('complete_name, nik, email');
		$this->db->from('v_hris_employee_updated');
		$this->db->where('action !=', 'mqTovi#d');
		$this->db->where('employee_subgroup !=', $outsource);
		$this->db->where('employee_subgroup !=', $intership);
		$this->db->where('nik !=', $nik);
		$this->db->not_like('nik', '0000', 'after');
		$this->db->order_by('nik', 'ASC');
		return $this->db->get()->result_array();
	}
	public function saveDataSection($data, $answers = [],$pic = [] , $handover = [], $note = [],$id_exit_form = null)
	{
		$this->db->trans_begin();
		$exists = $this->db->get_where('exit_clearance_note_sections', ['id_section' => $note['id_section'], 'id_employee' => $note['id_employee']])->row_array();
		
		if($exists){
			if(!empty($note)){
				$this->db->where(['id_section' => $note['id_section'], 'id_employee' => $note['id_employee']]);
				$this->db->update('exit_clearance_note_sections', $note);
				if($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					return false;
				}
			}else{
				$this->db->delete('exit_clearance_note_sections', ['id_section' => $data['id_section'], 'id_employee' => $this->emp_nik]);
			}
		}else{
			if(!empty($note)){
				$this->db->insert('exit_clearance_note_sections', $note);
				if($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					return false;
				}
			}
		}
		$save_section = $this->db->get_where('exit_clearance_form_sections', ['id_exit_form' => $data['id_exit_form'], 'id_section' => $data['id_section']])->row_array();
		if(empty($save_section)){
			if(!empty($answers)){
				$this->db->insert_batch('exit_clearance_answers', $answers);
				if($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					return false;
				}
			}
			if(!empty($handover)){
				$this->db->insert('exit_clearance_handovers', $handover);
				if($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					return false;
				}
				$id_handover = $this->db->insert_id();
			}
			if(!empty($pic)){
				foreach ($pic as $key => &$value) {
					$value['id_handover'] = $id_handover;
				}
				$this->db->insert_batch('exit_clearance_pic_handovers', $pic);
				if($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					return false;
				}
			}
			$this->db->insert('exit_clearance_form_sections', $data);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}else{
			$section = $this->db->get_where('exit_clearance_section_forms', ['id' => $data['id_section']])->row_array();
			$question_in_section = $this->db
				->select('id')
				->get_where('exit_clearance_questions', [
					'id_form_section' => $data['id_section']
				])
				->result_array();
			$id_question_in_section = array_column($question_in_section, 'id');
			$this->db->where('id_form', $data['id_exit_form']);
			$this->db->where_in('id_question', $id_question_in_section);
			$this->db->delete('exit_clearance_answers');
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
			if(!empty($answers)){
				if((intval($section['id']) === 2) ){
					$is_parent = array_filter($answers, function($answer){
						return $answer['id_question'] === 3;
					});
					if($is_parent){
						$this->db->insert_batch('exit_clearance_answers', $answers);
						if($this->db->trans_status() === FALSE) {
							$this->db->trans_rollback();
							return false;
						}
					}
				}else{
					$this->db->insert_batch('exit_clearance_answers', $answers);
					if($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						return false;
					}
				}
			}
			if(intval($section['id']) === 1){
				$hand = $this->db->get_where('exit_clearance_handovers', ['id_form' => $data['id_exit_form']])->row_array();
				if(!empty($hand)){
					$this->db->delete('exit_clearance_pic_handovers', ['id_handover' => $hand['id']]);
					$this->db->delete('exit_clearance_handovers', ['id_form' => $data['id_exit_form']]);
					if($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						return false;
					}
				}
				if(!empty($handover)){
					$answers_parent = $this->db->get_where('exit_clearance_answers', ['id_form' => $data['id_exit_form'], 'id_question' => 1])->row_array();
					$this->db->insert('exit_clearance_handovers', $handover);
					if(!empty($answers_parent)){
						$id_handover = $this->db->insert_id();
						foreach ($pic as $key => &$value) {
							$value['id_handover'] = $id_handover;
						}
						$this->db->insert_batch('exit_clearance_pic_handovers', $pic);
					}
					if($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						return false;
					}
				}
			}
		}
		if($id_exit_form !== null){
			$this->db->where('id', $id_exit_form);
			$this->db->update('form_exit_clearance', ['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}
		$this->db->trans_commit();
		return true;
	}
	public function saveExitForm($id, $data = [])
	{
		$this->db->trans_begin();
		$this->db->where('id', $id);
		$exit_form = $this->db->get('form_exit_clearance')->row_array();
		if(!$exit_form){
			$this->db->trans_rollback();
			return false;
		}
		$this->db->update('form_exit_clearance', ['status' => 1 , 'submitted_at' => date('Y-m-d H:i:s')], ['id' => $exit_form['id']]);
		if($data){
			$this->db->insert('form_exit_clearance', $data);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}
		$this->db->trans_commit();
		return true;
	}
	public function saveHandoverForm($id,$status, $data = [])
	{
		$this->db->trans_begin();
		$this->db->where('id', $id);
		$handover_form = $this->db->get('form_exit_clearance')->row_array();
		if(!$handover_form){
			$this->db->trans_rollback();
			return false;
		}
		$this->db->update('form_exit_clearance', ['status' => $status , 'submitted_at' => date('Y-m-d H:i:s')], ['id' => $handover_form['id']]);
		if($data){
			$this->db->insert('form_exit_clearance', $data);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}
		$this->db->trans_commit();
		return true;
	}
	public function getQuestions($id_type,$id_Section = [])
	{
		$this->db->select('*');
		$this->db->from('exit_clearance_questions');
		$this->db->where('id_form_type', $id_type);
		if(!empty($id_Section)){
			$this->db->where_in('id_form_section', $id_Section);
		}
		$this->db->where('start_date <=', date('Y-m-d'));
		$this->db->where('end_date >=', date('Y-m-d'));
		return $this->db->get()->result_array();
	}
	public function getEmployeeAssign($id,$status){
		$this->db->select('*');
		$this->db->from('exit_clearance_pic_handovers');
		$this->db->where('id_handover', $id);
		if ((int)$status === 0) {
			$this->db->where('status', 0);
		} else {
			$this->db->where('status !=', 0);
		}
		return $this->db->get()->result_array();
	}
	public function savePicHandover($type, $data)
	{
		$this->db->trans_begin();
		if($type === 'employee'){
			$this->db->where('id', $data['id']);
			$this->db->update('exit_clearance_pic_handovers', [
				'notes' => $data['description'],
				'nama_alat' => $data['tool_name'],
				'jumlah_alat' => $data['quantity'],
				'status' => $data['status'],
				'updated_at' => date('Y-m-d H:i:s')
				]);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}else{
			$this->db->insert('exit_clearance_pic_handovers', $data);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}
		$this->db->trans_commit();
		return true;
	}
	public function deletePicHandover($id)
	{
		$this->db->trans_begin();
		$this->db->select('*');
		$this->db->from('exit_clearance_pic_handovers');
		$this->db->where('id', $id);
		$pic = $this->db->get()->row_array();
		if(!$pic){
			return false;
		}
		if($pic['nik'] && $pic['id_employee']){
			$this->db->where('id', $id);
			$this->db->update('exit_clearance_pic_handovers', ['status' => 0]);
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}else{
			$this->db->where('id', $id);
			$this->db->delete('exit_clearance_pic_handovers');
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			}
		}
		$this->db->trans_commit();
		return true;
	}
	public function getOptions($id_question)
	{
		$this->db->select('*');
		$this->db->from('exit_clearance_question_options');
		$this->db->where_in('id_question', $id_question);
		return $this->db->get()->result_array();
	}

}