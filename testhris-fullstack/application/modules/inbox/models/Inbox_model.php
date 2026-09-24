<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->email = $this->session->userdata('user_email');
		$this->nik = $this->session->userdata('nik');
		$this->employee_id = $this->session->userdata('employee_id');
		$this->division = $this->session->userdata('division');
		$this->second_division = $this->session->userdata('second_division');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');

		$this->status_apps = $_ENV['CI_ENVIRONMENT'];
	}
	public function get_my_ec_approver()
	{
		$approval_ec = $this->db
			->select('f.request_number,f.form_type, e.complete_name, e.nik as employee_id, r.status as status_request, s.status as status_step, r.id_form_request as id, r.approval_type')
			->from('exit_clearance_approval_request r')
			->join(
				'exit_clearance_approval_steps s',
				'r.id = s.id_approval_req'
			)
			->join('form_request f', 'r.id_form_request = f.id')
			->join('hris_employee e', 'f.employee_id = e.nik AND e.id_employee = (SELECT MAX(e2.id_employee) FROM hris_employee e2 WHERE e2.nik = f.employee_id)', 'inner', false)
			->where('s.id_approver', $this->nik)
			->where('s.status', 0)
			->get()
			->result_array();
		if (!empty($approval_ec)) {
			return $approval_ec;
		} else {
			return [];
		}
	}
	public function get_list_ec_approval()
	{
		$approval_ec = $this->db
			->select('f.request_number,f.form_type, e.complete_name, e.nik as employee_id, r.status as status_request, s.status as status_step, r.id_form_request as id, r.approval_type, rl.status as status_rl')
			->from('exit_clearance_approval_request r')
			->join(
				'exit_clearance_approval_steps s',
				'r.id = s.id_approval_req'
			)
			->join('form_request f', 'r.id_form_request = f.id')
			->join('exit_clearance_resignation_letters rl', 'f.id = rl.id_form_request', 'left')
			->join('hris_employee e', 'f.employee_id = e.nik AND e.id_employee = (SELECT MAX(e2.id_employee) FROM hris_employee e2 WHERE e2.nik = f.employee_id)', 'inner', false)
			->where('s.id_approver', $this->nik)
			->where('(rl.status != 0 OR rl.status != 4)', null, false)
			->order_by('f.id', 'DESC')
			->get()
			->result_array();
		if (!empty($approval_ec)) {
			return $approval_ec;
		} else {
			return [];
		}
	}
	public function approved($id,$type,$status, $notes = '')
	{
		if($status === 'Revised'){
			$status_new = 2;
			$status_approval = 2;
		}else{
			$status_new = 3;
			$status_approval = 1;
		}
		if($type === 'RESIGNATION_LETTER'){
			$table = 'exit_clearance_resignation_letters';
			$kolom = 'id_resignation_letter';
		}else{
			$table = 'exit_clearance';
			$kolom = 'id_exit_clearance';
		}
		$this->db->trans_begin();
		$appr = $this->db->get_where('exit_clearance_approval_request',['id_form_request' => $id, 'approval_type' => $type])->row_array();
		if(empty($appr)){
			$this->db->trans_rollback();
			return false;
		}
		$this->db->update('exit_clearance_approval_request',['status' => $status_approval,'completed_at' => $this->date], ['id_form_request' => $id, 'approval_type' => $type]);
		$this->db->update('exit_clearance_approval_steps',['status' => $status_approval, 'acted_at' => $this->date], ['id_approval_req' => $appr['id'], 'id_approver' => $this->nik]);
		$this->db->update($table, ['status' => $status_new], ['id_form_request' => $id]);
		if($status === 'Revised'){
			$input = $this->db->get_where($table, ['id_form_request' => $id])->row_array();
			if(empty($input)){
				$this->db->trans_rollback();
				return false;
			}
			$this->db->insert('exit_clearance_notes',[
				$kolom => $input['id'],
				'note' => $notes,
				'created_by' => $this->email,
				'created_at' => $this->date
			]);
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}
	public function getApprovalList()
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('In Progress', 'Hold', 'Review')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			
			$listApproval = implode(",", $list);
			$listForm = $this->getListForm($listApproval);
			$ec = $this->get_my_ec_approver();
			$listForm = array_merge($listForm, $ec);
			return $listForm;
		} else {
			return $data;
		}
	}
	
	public function getApprovalListMDCRCek()
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('In Progress')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		// dumper($approval);
		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			
			$listApproval = implode(",", $list);
			// dumper($listApproval);
			$listForm = $this->getListFormMDCRCek($listApproval);

			return $listForm;

		} else {
			return $data;
		}
	}

	public function getApprovalListMDCRRevised()
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('Revised', 'Revised to previous layer')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		// dumper($approval);
		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			
			$listApproval = implode(",", $list);
			$listForm = $this->getListFormMDCRRevised($listApproval);
			return $listForm;

		} else {
			return $data;
		}
	}

	public function getApprovalListMDCRApproved()
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('Approved')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		//dumper($approval);
		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			
			$listApproval = implode(",", $list);
			$listForm = $this->getListFormMDCRApproved($listApproval);
			// dumper($listApproval);
			return $listForm;
		} else {
			return $data;
		}
	}
	
	public function getApprovalListMDCRAfterCek()
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('In Progress')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		// dumper($approval);
		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			
			$listApproval = implode(",", $list);
			$listForm = $this->getListFormMDCRAfterCek($listApproval);
			return $listForm;

		} else {
			return $data;
		}
	}

	public function getApprovalListMDCRAfterGrouping()
	{
		// $sqll = "SELECT no_req_mdcr, form_type FROM form_request WHERE no_req_mdcr IS NOT NULL AND no_req_mdcr <> '' AND no_req_mdcr <> ' '  GROUP BY no_req_mdcr, form_type ORDER BY no_req_mdcr DESC";
		// $queryy = $this->db->query($sqll);
		// $group = $queryy->result_array();
		$sqll = "SELECT * FROM hris_no_req_mdcr ORDER BY id DESC";
		$queryy = $this->db->query($sqll);
		$group = $queryy->result_array();
		$data = array();

		if ($group) {
			return $group;
		} else {
			return $data;
		}
	}

	public function getReqMDCRAfterGroupingNeedApproved()
	{
		$sqll = "SELECT * FROM hris_no_req_mdcr WHERE is_status = '1'";
		$queryy = $this->db->query($sqll);
		$group = $queryy->result_array();
		$data = array();
		//dumper($group);
		if ($group) {
			return $group;
		} else {
			return $data;
		}
	}
	
	public function getApprovalListMDCRAGroupingItem($no_req)
	{
		$sqll = "SELECT * FROM form_request WHERE no_req_mdcr = '$no_req' AND (is_status = '3' OR is_status = '1')";
		$queryy = $this->db->query($sqll);
		$group = $queryy->result_array();
		$data = array();

		if ($group) {
			return $group;
		} else {
			return $data;
		}
	}

	public function getReviewList()
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('Approved')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();

		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}

			$listApproval = implode(",", $list);
			$listForm = $this->getListForm($listApproval, 'pa_list');
			return $listForm;

		} else {
			return $data;
		}
	}

	public function getDivHeadList($user = '')
	{
		if (!empty($user)) {
			$email = $user;
		} else {
			$email = $this->email;
		}

		$this->db->select('id as approval_id, request_id');
		$this->db->where("approval_email", $email);
		$this->db->where("request_id !=", '');
		$ListApproval = $this->db->get('form_approval')->result_array();

		if (!empty($ListApproval)) {

			foreach ($ListApproval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}

			$approval = implode(",", $list);
			$this->db->select("*");
			$this->db->where("id IN ($approval)");
			$this->db->where("is_status", "3");
			$result = $this->db->get('performance_appraisal')->result();
		} else {
			$result = '';
		}

		return $result;
	}

	public function getHRConfirmed($year)
	{
		// $year = $this->year - 2;
		$year = $year;
		$eval_year = $year.'-01-01';

		$this->db->select('division_name');
		$this->db->where("is_status", '3');
		$this->db->where("evaluation_period", $eval_year);
		$division_name = $this->db->get('performance_division_status')->result_array();

		if (!empty($division_name)) {

			foreach ($division_name as $key => $value) {
				$list_div = $value['division_name'];
				$list[] = $list_div;
			}

			$div_name = implode("','", $list);
			$this->db->select("*");
			$this->db->where("division IN ('$div_name')");
			$this->db->where("is_status", "3");
			$this->db->where("evaluation_period_start", $eval_year);
			$result = $this->db->get('performance_appraisal')->result();
		} else {
			$result = '';
		}

		return $result;
	}

	public function getHRReview($division_name, $eval_year)
	{
		
		$this->db->where("division", $division_name);

		$this->db->where("is_status", "3");
		$this->db->where("evaluation_period_start", $eval_year);
		$result = $this->db->get('performance_appraisal')->result();

		if (!empty($result)) {
			$output = $result;
		} else {
			$output = '';
		}

		return $output;
	}

	public function getListForm($listId = '', $flag = '')
	{
		
		// if (!empty($listId)) {
		// 	// $this->db->where("a.id IN ($listId) ");
		// 	$sql = "SELECT *
		// 				FROM form_request
		// 				WHERE id IN ($listId) AND is_status = '1'
		// 				ORDER BY id ASC";
		// 	// var_dump($sql);
		// } else {
		// 	// $this->db->where("a.created_by", $this->email);
		// 	$sql = "SELECT *
		// 				FROM form_request
		// 				WHERE employee_id LIKE '$this->employee_id' AND is_status = '1'
		// 				ORDER BY id ASC";
		// }

		// $query = $this->db->query($sql);
		// $res = $query->result_array();
		
		
		// $data = array();
		// foreach ($res as $key) {
		// 	$nik = $key['employee_id'];
		// 	// var_dump($key['employee_id']);
		// 	$request_number = $key['request_number'];
		// 	// $sqll = "SELECT TOP 1 id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
		// 	$sqll = "SELECT id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
		// 	$queryy = $this->db->query($sqll);
		// 	$complete_name = $queryy->result();
		// 	$row   = array();
		// 	// var_dump($sqll);

		// 	$row['id'] =  $key['id'];
		// 	$row['request_number'] =  $key['request_number'];
		// 	$row['form_type'] =  $key['form_type'];
		// 	$row['form_purpose'] =  $key['form_purpose'];
		// 	$row['form_notes'] =  $key['form_notes'];
		// 	$row['approval_form_scanned'] =  $key['approval_form_scanned'];
		// 	$row['approved_date'] =  $key['approved_date'];
		// 	$row['result_document'] =  $key['result_document'];
		// 	$row['is_status'] =  $key['is_status'];
		// 	$row['created_by'] =  $key['created_by'];
		// 	$row['created_at'] =  $key['created_at'];
		// 	$row['updated_by'] =  $key['updated_by'];
		// 	$row['updated_at'] =  $key['updated_at'];
		// 	$row['deleted_by'] =  $key['deleted_by'];
		// 	$row['deleted_at'] =  $key['deleted_at'];
		// 	$row['employee_id'] =  $key['employee_id'];
		// 	$row['complete_name'] =  $complete_name[0]->complete_name;
			
		// 	$data[] = $row;
		// }
		// //$output = array('data' => $data);
		// //dumper($data);
		// return $data;
		
		// // $this->db->where("is_status", '1');
		// // $this->db->order_by('created_at', 'DESC');
		// // return $this->db->get('form_request')->result_array();

		///////////////////////////////////////////Start Update Source Code Performance Appraisal 2024////////////////////////////
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		
		if (!empty($listId)) {
			$sql = "SELECT *,a.employee_id as employee_id, a.request_number as request_number,a.is_status as is_status_pa, b.id as idpa, a.id as id, a.is_status as is_status
						FROM form_request as a left join performance_appraisal as b on a.request_number = b.request_number
						WHERE a.id IN ($listId) AND a.is_status = '1'
						ORDER BY a.id ASC";
		} else {
			$sql = "SELECT *,a.employee_id as employee_id, a.request_number as request_number,a.is_status as is_status_pa, b.id as idpa, a.id as id, a.is_status as is_status
						FROM form_request as a left join performance_appraisal as b on a.request_number = b.request_number
						WHERE a.employee_id LIKE '$this->nik' AND a.is_status = '1'
						ORDER BY a.id ASC";
		}
		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		$data = array();
		$row   = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			if($nik == 0){
				$nik = '00000000';
				$key['employee_id'] = '00000000';
			}
			$request_number = $key['request_number'];
			
			if(substr($key['request_number'],5,3) != "KPI" and substr($key['request_number'],5,4) != "PLAN"){ 
				$sqll = "SELECT id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik'";
				$queryy = $this->db->query($sqll);
				$complete_name = $queryy->result();
				

				$row['id'] =  $key['id'];
				$row['request_number'] =  $key['request_number'];
				$row['form_type'] =  $key['form_type'];
				$row['form_purpose'] =  $key['form_purpose'];
				$row['form_notes'] =  $key['form_notes'];
				$row['approval_form_scanned'] =  $key['approval_form_scanned'];
				$row['approved_date'] =  $key['approved_date'];
				$row['result_document'] =  $key['result_document'];
				$row['is_status'] =  $key['is_status'];
				$row['created_by'] =  $key['created_by'];
				$row['created_at'] =  $key['created_at'];
				$row['updated_by'] =  $key['updated_by'];
				$row['updated_at'] =  $key['updated_at'];
				$row['deleted_by'] =  $key['deleted_by'];
				$row['deleted_at'] =  $key['deleted_at'];
				$row['employee_id'] =  $key['employee_id'];
				$row['is_status_admin_hr'] = $key['is_status_admin_hr']; 
				$row['is_status_divhead_hr'] = $key['is_status_divhead_hr'];
				$row['complete_name'] =  $complete_name[0]->complete_name;
				
				
			}else{				

				if($key['evaluation_period_start'] == $eval_year){

					if($flag == "review"){
						if($key['is_status_pa'] == '6'){
							foreach($key as $k => $v){
								$row[$k] = $v;
								
							}
						}
					}elseif($flag == "pa_list"){
						if($key['is_status_pa'] == '3'){
							foreach($key as $k => $v){
								$row[$k] = $v;
								
							}
						}
					}else{
						if($key['is_status_pa'] != '2' and $key['is_status_pa'] != '3' and $key['is_status_pa'] != '4' and $key['is_status_pa'] != '7' and $key['is_status_pa'] != '0'){
							foreach($key as $k => $v){
								$row[$k] = $v;
								
							}
						}
					}

				}

			}
			
			$data[] = $row;
			
		}

		return $data;
		///////////////////////////////////////////End Update Source Code Performance Appraisal 2024////////////////////////////
	}

	public function getListFormMDCRCek($listId = '', $flag = '')
	{
		
		if (!empty($listId)) {
			$sql = "SELECT *
						FROM form_request
						WHERE id IN ($listId) AND is_status = '1' AND form_type = 'MDCR' AND (is_status_admin_hr = '0' or is_status_admin_hr is null)
						ORDER BY id ASC";
		} else {
			$sql = "SELECT *
						FROM form_request
						WHERE employee_id LIKE '$this->employee_id' AND is_status = '1' AND form_type = 'MDCR' AND (is_status_admin_hr = '0' or is_status_admin_hr is null)
						ORDER BY id ASC";
		}

		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			// $sqll = "SELECT TOP 1 id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
			$sqll = "SELECT id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		}
		// dumper($data);
		return $data;

	}
	
	
	public function getListFormMDCRRevised($listId = '', $flag = '')
	{
		
		if (!empty($listId)) {
			$sql = "SELECT *
						FROM form_request
						WHERE id IN ($listId) AND ( is_status = '2' OR is_status = '1' ) AND form_type = 'MDCR'
						ORDER BY id ASC";
		} else {
			$sql = "SELECT *
						FROM form_request
						WHERE employee_id LIKE '$this->employee_id' AND is_status = '2' AND form_type = 'MDCR'
						ORDER BY id ASC";
		}

		$query = $this->db->query($sql);
		$res = $query->result_array();
		//dumper($listId);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			// $sqll = "SELECT TOP 1 id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
			$sqll = "SELECT id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		}
		return $data;
	}
	
	public function getListFormMDCRApproved($listId = '', $flag = '')
	{
		
		if (!empty($listId)) {
			$sql = "SELECT *
						FROM form_request
						WHERE id IN ($listId) AND ( is_status = '1' OR is_status = '3') AND form_type = 'MDCR'
						ORDER BY id DESC";
		} else {
			$sql = "SELECT *
						FROM form_request
						WHERE employee_id LIKE '$this->employee_id' AND ( is_status = '1' OR is_status = '3') AND form_type = 'MDCR'
						ORDER BY id DESC";
		}

		$query = $this->db->query($sql);
		$res = $query->result_array();
		//dumper($listId);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			// $sqll = "SELECT TOP 1 id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
			$sqll = "SELECT id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		}
		return $data;
	}
	
	public function getApprovalListMDCRRejected()
	{
		$sql = "SELECT *
						FROM form_request
						WHERE is_status = '4' AND form_type = 'MDCR'
						ORDER BY id ASC";

		$query = $this->db->query($sql);
		$res = $query->result_array();
		//dumper($listId);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			// $sqll = "SELECT TOP 1 id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
			$sqll = "SELECT id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		}
		return $data;
	}
	
	
	public function getListFormMDCRAfterCek($listId = '', $flag = '')
	{
		
		if (!empty($listId)) {
			$sql = "SELECT *
						FROM form_request
						WHERE id IN ($listId) AND is_status = '1' AND form_type = 'MDCR' AND ( no_req_mdcr IS NULL OR no_req_mdcr = '' ) AND is_status_admin_hr = '1'
						ORDER BY id ASC";
		} else {
			$sql = "SELECT *
						FROM form_request
						WHERE employee_id LIKE '$this->employee_id' AND is_status = '1' AND form_type = 'MDCR' AND ( no_req_mdcr IS NULL OR no_req_mdcr = '') AND is_status_admin_hr = '1'
						ORDER BY id ASC";
		}

		$query = $this->db->query($sql);
		$res = $query->result_array();
		// dumper($res);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			$sqll = "SELECT id_employee, complete_name,cost_center FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			$row['cost_center'] =  $complete_name[0]->cost_center;
			if (decrypt($complete_name[0]->cost_center) == 'IBSW-BPOH' || decrypt($complete_name[0]->cost_center) == 'IBSW-BOMOH') {
				$row['kind'] =  1;
			} else {
				$row['kind'] =  2;
			}
			
			$data[] = $row;
		}
		return $data;
	}

	// public function getLastActivity()
	// {
	// 	$this->db->select("id, approval_
	// 		, request_id, approval_notes, created_at, created_by");
	// 	$this->db->limit(5);
	// 	return $this->db->get('logs')->result_array();
	// }

	public function getLastActivity()
	{
		$this->db->select("id, approval_response, request_id, approval_notes, created_at, created_by");
		$this->db->limit(5);
		return $this->db->get('logs')->result_array();
	}

	// public function countTeam($division)
	// {
	// 	$total = $this->db->get_where('employee', array('division' => $division))->result_array();
	// 	return count($total);
	// }

	public function find_select($select, $table , $where = '')
	{
		$this->db->select($select);
		if ($where != '') { $this->db->where($where);}
		return $this->db->get($table);
	}

	public function checkApproval($id, $email)
	{
		return $this->db->get_where('form_approval', array('request_id' => $id, 'approval_email' => $email))->row_array();
	}
	
	public function cekNote($request_id)
	{
		$sql = "SELECT 	
					*
				FROM		
					request_notes
				WHERE request_id = '$request_id' AND is_status LIKE '1' AND created_by LIKE '".$this->email."' ORDER BY id DESC LIMIT 1";

		$query = $this->db->query($sql);
		$res = $query->result();
		
		if($res){
			return true;
		}else{
			return false;
		}
	}

	public function save_grouping_req_mdcr($no_ref="", $request_id=""){

		$sql2 	= "UPDATE form_request SET no_req_mdcr='$no_ref' WHERE id = '".$request_id."' and form_type = 'MDCR'";
		$query 	= $this->db->query($sql2);
		
		if($query){
			return $query;
		}else{
			return false;
		}
	}

	public function save_no_grouping_req_mdcr($no_ref=""){
		$formRequest = array(
			'no_req_mdcr' => $no_ref,
			'created_at' => date("Y-m-d H:i:s"),
			'is_status' => '1',
			'is_status_progress' => '1'
		);
		$query = $this->db->insert('hris_no_req_mdcr', $formRequest);
		
		if($query){
			return $query;
		}else{
			return false;
		}
	}

	
	/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////
	public function getApprovalListPA()
	{
		$this->db->where('a.approval_email', $this->email);
		$this->db->where("a.approval_status IN ('In Progress', 'Hold', 'Review')");
		$this->db->group_start();
		$this->db->where('b.form_type', "KPI");
		$this->db->or_where('b.form_type', "PLAN");
		$this->db->group_end();
		$this->db->join('form_request b', 'a.request_id= b.id', 'left');
		$this->db->order_by('a.id', 'ASC');
		$approval = $this->db->get('form_approval a')->result_array();
		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			
			$listApproval = implode(",", $list);
			$listForm = $this->getListFormPA($listApproval);
			
			return $listForm;

		} else {
			return $data;
		}
	}

	public function getPAList($year="")
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('Approved')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		$data = array();
		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}

			$listApproval = implode(",", $list);
			$listForm = $this->getListFormPa($listApproval, 'pa_list', $year);
			
			return $listForm;

		} else {
			return $data;
		}
	}

	public function getListFormPA($listId = '', $flag = '', $year="")
	{
		if ($year == "") {
			$year = $this->year - 1;
		}
		
		$eval_year = $year.'-01-01';
		if (!empty($listId)) {
			if($flag == "pa_list"){
				$sql = "SELECT *,a.employee_id as employee_id, a.request_number as request_number,a.is_status as is_status_pa, b.id as idpa, a.id as id, a.is_status as is_status
						FROM form_request as a left join performance_appraisal as b on a.request_number = b.request_number
						WHERE a.id IN ($listId) AND b.is_status > '1' and (left(a.request_number,8) = 'HRIS_KPI' or left(a.request_number,9) = 'HRIS_PLAN')
						ORDER BY a.id ASC";
			}else{
				$sql = "SELECT *,a.employee_id as employee_id, a.request_number as request_number,a.is_status as is_status_pa, b.id as idpa, a.id as id, a.is_status as is_status
						FROM form_request as a left join performance_appraisal as b on a.request_number = b.request_number
						WHERE a.id IN ($listId) AND b.is_status >= '1' and (left(a.request_number,8) = 'HRIS_KPI' or left(a.request_number,9) = 'HRIS_PLAN')
						ORDER BY a.id ASC";
			}
		} else {
			$sql = "SELECT *,a.employee_id as employee_id, a.request_number as request_number,a.is_status as is_status_pa, b.id as idpa, a.id as id, a.is_status as is_status
						FROM form_request as a left join performance_appraisal as b on a.request_number = b.request_number
						WHERE a.employee_id LIKE '$this->nik' AND b.is_status >= '1'  and (left(request_number,8) = 'HRIS_KPI' or left(request_number,9) = 'HRIS_PLAN')
						ORDER BY a.id ASC";
		}

		
		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		
		$data = array();
		$row   = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			
			if(substr($key['request_number'],5,3) != "KPI" and substr($key['request_number'],5,4) != "PLAN"){ 
				$sqll = "SELECT id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC";

				$queryy = $this->db->query($sqll);
				$complete_name = $queryy->result();
				

				$row['id'] =  $key['id'];
				$row['request_number'] =  $key['request_number'];
				$row['form_type'] =  $key['form_type'];
				$row['form_purpose'] =  $key['form_purpose'];
				$row['form_notes'] =  $key['form_notes'];
				$row['approval_form_scanned'] =  $key['approval_form_scanned'];
				$row['approved_date'] =  $key['approved_date'];
				$row['result_document'] =  $key['result_document'];
				$row['is_status'] =  $key['is_status'];
				$row['created_by'] =  $key['created_by'];
				$row['created_at'] =  $key['created_at'];
				$row['updated_by'] =  $key['updated_by'];
				$row['updated_at'] =  $key['updated_at'];
				$row['deleted_by'] =  $key['deleted_by'];
				$row['deleted_at'] =  $key['deleted_at'];
				$row['employee_id'] =  $key['employee_id'];
				$row['complete_name'] =  $complete_name[0]->complete_name;
				
				
			}else{
				
				if($key['evaluation_period_start'] == $eval_year){

					if($flag == "review"){
						if($key['is_status_pa'] == '6'){
							foreach($key as $k => $v){
								$row[$k] = $v;
								
							}
						}
					}elseif($flag == "pa_list"){
						if($key['is_status_pa'] == '3'){
							foreach($key as $k => $v){
								$row[$k] = $v;
								
							}
						}
					}else{
						if($key['is_status_pa'] != '2' and $key['is_status_pa'] != '3' and $key['is_status_pa'] != '4' and $key['is_status_pa'] != '7' and $key['is_status_pa'] != '0'){
							foreach($key as $k => $v){
								// echo $k. " ==> ".$v."<br>";
								$row[$k] = $v;
								
							}
						}
					}

				///////////////////////////////////////////Start Update Source Code Performance Appraisal 2025////////////////////////////
				}else{
					continue;
				}
				///////////////////////////////////////////End Update Source Code Performance Appraisal 2025////////////////////////////

			}
			// dumper($row);
			$data[] = $row;
			
		}
		
		return $data;
		
	}

	public function getUOM(){
		$list_uom = $this->db->query("select DISTINCT uom,formula from master_uom order by uom asc")->result();
		return $list_uom;
	}

	public function getAllDataPA($eval_year)
	{
		$this->db->select("*");
		$this->db->where("is_status !=", "0");
		$this->db->where("evaluation_period_start", $eval_year);
		return $this->db->get('performance_appraisal')->result();
	}

	public function getTotalGrade($division, $grade, $eval_year)
	{
		
		$query = "select employee_nik, final_score, final_score_dummy from performance_appraisal where is_status = '3' and division = '$division' and evaluation_period_start = '$eval_year' and left(request_number,8) = 'HRIS_KPI'";
		
		$q = $this->db->query($query)->result_array();
		// if($division == 'X IIIQMQWVVJQB-#BV #MUVSWM #ZIKB'){
		// 	dumper($q);
		// }
		
		$total = 0;
		foreach($q as $key => $val){

			// if($val['final_score_dummy'] != ""){
			// 	$val['final_score'] = $val['final_score_dummy'];
			// }
			$final_score = decrypt($val['final_score']);
			if($grade == 'a'){
				if($final_score >= '9.1'){
					$total++;
				}
			}elseif($grade == 'b'){
				if($final_score >= '8.1' and $final_score < '9.1'){
					$total++;
				}
			}elseif($grade == 'c'){
				if($final_score >= '6.9' and $final_score < '8.1'){
					$total++;
				}
			}elseif($grade == 'd'){
				if($final_score >= '5.6' and $final_score < '6.9'){
					$total++;
				}
			}elseif($grade == 'e'){
				if($final_score >= '0.0' and $final_score < '5.6'){
					$total++;
				}
			}
			
		}

		return $total;
	}

	public function countRequest($division, $status, $eval_year = "", $not_include = "")
	{	
		$where = array('division' => $division, 'is_status' => $status, 'evaluation_period_start' => $eval_year, 'left(request_number,8)' => 'HRIS_KPI');
		
		$total = $this->db->get_where('performance_appraisal', $where)->result_array();
		return count($total);
	}

	public function countTalentTeam($division){

		$year = date("Y")-1;

		if($this->session->userdata('second_division') != '') {
		$query = "select * from performance_appraisal
			where division = '".$this->session->userdata('second_division')."'
			and
			evaluation_period_start = '".date($year."-01-01")."'
			and
			substring(request_number,6,3) = 'KPI'
			";
		}else{
		$query = "select * from performance_appraisal
			where division = '".$this->session->userdata('division')."'
			and
			evaluation_period_start = '".date($year."-01-01")."'
			and
			substring(request_number,6,3) = 'KPI'
			";
		}
		
		$total = $this->db->query($query)->result();
		$talenTeam = 0;
		foreach($total as $item){
			if($item->nine_box_performance > 0 and $item->nine_box_potential > 0){
				$talenTeam++;
			}

		}

		return $talenTeam;
	}

	public function countTeam($division)
	{
		if (($division != '' || $division != null || !empty($division))) {
			$query = "
				SELECT *
				FROM
				v_hris_employee_updated a
				LEFT JOIN employee_update_division_pa as b on a.id_employee = b.id_employee
				where 
				case 
					when b.id_employee != '' then b.division
				else
					a.division
				end  = '".$division."'
			";	
		
			$total = $this->db->query($query)->result_array();
			$total_team = 0;
			//=======for checking=========
			foreach($total as $key => $val){
				$personnel_area		= decrypt($val['personnel_area']);
				$pers 				= substr($personnel_area,0,3);
				if($pers != "TIS"){
					$total_team++;
				}

			}
		}else{
			$total_team = 0;
		}
		
		// die;
		//============================

		return $total_team;
	}

	public function countTeamEligible($division, $year="")
	{
		if (($division != '' || $division != null || !empty($division))) {
			if($year == ""){
				$year = date("Y")-1;
			}
			
			$status_emp = encrypt('Leaving');
			$query = "
			SELECT *
			FROM
			v_hris_employee_updated a
			LEFT JOIN employee_update_division_pa as b on a.id_employee = b.id_employee and b.evaluation_year = '$year' 
			where (a.action != '$status_emp' or b.is_leaving = '1') AND a.employee_subgroup != '".encrypt('Outsource')."' AND a.nik != '20130331' AND  a.nik != '20130065' AND a.nik != '20130240' AND
			case 
				when b.division != '' then b.division
			else
				a.division
			end  = '$division'
			";
			
			$eligible = 0;
			$total = $this->db->query($query)->result();
		
			foreach($total as $item){
				$personnel_area		= decrypt($item->personnel_area);
				$pers 				= substr($personnel_area,0,3);
				if($pers != "TIS"){
					if($item->prev_joindate != ""){
						$join_date = date("Y-m-d",strtotime(decrypt($item->prev_joindate)));
					}else{
						$join_date = date("Y-m-d",strtotime(decrypt($item->join_date)));
					}
					
					if($join_date <= $year.'-09-30'){
						$eligible++;
					}
				}
			}
		}else{
			$eligible = 0;
		}
		
		return $eligible;
	}

	public function getDivHeadListByDivisionCeo($eval_year)
	{
		// dumper($eval_year);
		$this->db->select("*");
		$this->db->where("is_status", "3");
		$this->db->where("division_root", 1);
		$this->db->where("evaluation_period_start", $eval_year);
		$result = $this->db->get('performance_appraisal')->result();

		return $result;
	}

	public function getDivHeadListByDivision($division, $eval_year)
	{

		$query = "select a.id as approval_id,c.id as request_id
		from form_approval as a left join form_request as b on a.request_id = b.id left join performance_appraisal as c on b.request_number = c.request_number where (substring(b.request_number,6,3) = 'KPI') and c.division = '".$division."'";
		
		
		$ListApproval = $this->db->query($query)->result_array();
		
		if (!empty($ListApproval)) {
			foreach ($ListApproval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}

			$approval = implode(",", $list);
			$this->db->select("*");
			$this->db->where("id IN ($approval)");
			$this->db->where("is_status", "3");
			$this->db->where("division", $division);
			$this->db->where("evaluation_period_start", $eval_year);
			$result = $this->db->get('performance_appraisal')->result();
			

		} else {
			$result = '';
		}
		return $result;
	}

	public function getAllDataPAOk($eval_year)
	{
		$query = "SELECT a.*,
		(SELECT approval_email FROM form_approval WHERE request_id = b.id AND approval_priority = 1 ORDER BY id LIMIT 1) as ApprovalLayer1,
		(SELECT updated_at FROM form_approval WHERE request_id = b.id AND approval_priority = 1 ORDER BY id LIMIT 1) as ApprovalLayer1Date,
		(SELECT approval_email FROM form_approval WHERE request_id = b.id AND approval_priority = 2 ORDER BY id LIMIT 1) as ApprovalLayer2,
		(SELECT updated_at FROM form_approval WHERE request_id = b.id AND approval_priority = 2 ORDER BY id LIMIT 1) as ApprovalLayer2Date,
		b.form_type
		FROM performance_appraisal a left join form_request as b on a.request_number = b.request_number
		WHERE a.evaluation_period_start = '$eval_year' AND a.is_status NOT IN (0,7)";
		return $this->db->query($query)->result();
		
	}

	public function getPAListAllStatus()
	{
		$this->db->where('approval_email', $this->email);
		$status = array('In Progress');
		$this->db->where_in('approval_status', $status);
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		$data = array();
		// print_r($approval);
		// die;
		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			$listApproval = implode(",", $list);
			// dumper($listApproval);
			$listForm = $this->getListFormPaAll($listApproval);
			return $listForm;
		} else {
			return $data;
		}
	}

	public function getListFormPaAll($listId = '')
	{		
		if (!empty($listId)) {
			$sql = "SELECT *,a.employee_id as employee_id, a.request_number as request_number,a.is_status as is_status_pa, b.id as idpa, a.id as id, a.is_status as is_status
						FROM form_request as a left join performance_appraisal as b on a.request_number = b.request_number
						WHERE a.id IN ($listId) AND b.is_status >= '1' and (left(a.request_number,8) = 'HRIS_KPI' or left(a.request_number,9) = 'HRIS_PLAN')
						ORDER BY a.is_status, a.id ASC";
		} else {
			$sql = "SELECT *,a.employee_id as employee_id, a.request_number as request_number,a.is_status as is_status_pa, b.id as idpa, a.id as id, a.is_status as is_status
						FROM form_request as a left join performance_appraisal as b on a.request_number = b.request_number
						WHERE a.employee_id LIKE '$this->nik' AND b.is_status >= '1'  and (left(request_number,8) = 'HRIS_KPI' or left(request_number,9) = 'HRIS_PLAN')
						ORDER BY a.is_status, a.id ASC";
		}
		$query = $this->db->query($sql);
		$res = $query->result_array();

		$data = array();
		$row   = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			if(substr($key['request_number'],5,3) != "KPI" and substr($key['request_number'],5,4) != "PLAN"){ 
				$sqll = "SELECT TOP 1 id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC";

				$queryy = $this->db->query($sqll);
				$complete_name = $queryy->result();
				

				$row['id'] =  $key['id'];
				$row['request_number'] =  $key['request_number'];
				$row['form_type'] =  $key['form_type'];
				$row['form_purpose'] =  $key['form_purpose'];
				$row['form_notes'] =  $key['form_notes'];
				$row['approval_form_scanned'] =  $key['approval_form_scanned'];
				$row['approved_date'] =  $key['approved_date'];
				$row['result_document'] =  $key['result_document'];
				$row['is_status'] =  $key['is_status'];
				$row['created_by'] =  $key['created_by'];
				$row['created_at'] =  $key['created_at'];
				$row['updated_by'] =  $key['updated_by'];
				$row['updated_at'] =  $key['updated_at'];
				$row['deleted_by'] =  $key['deleted_by'];
				$row['deleted_at'] =  $key['deleted_at'];
				$row['employee_id'] =  $key['employee_id'];
				$row['complete_name'] =  $complete_name[0]->complete_name;
				
				
			}else{
				foreach($key as $k => $v){
					// echo $k. " ==> ".$v."<br>";
					$row[$k] = $v;
					
				}
			}
			$data[] = $row;
			
		}
		return $data;
		
	}

	public function get_nine_box($division,$eval_year,$note){
		$query = "select employee_name from performance_appraisal where division = '$division' and evaluation_period_start = '$eval_year' and nine_box_note = '{$note}' group by employee_name";
		
		$q = $this->db->query($query)->result_array();
		// print_r($q);
		// die;
		return $q;
	}

	public function checkDevisiasi($division, $year)
	{
		$this->db->where('division',$division);
		$this->db->where('year',$year);
		$result = $this->db->get('kurva_devisiasi')->num_rows();

		return $result;
	}

	public function devisiasi($division, $year)
	{
		$eval_year = $year.'-01-01';
		$this->db->select('iom_file');
		$this->db->where('division_name',$division);
		$this->db->where('evaluation_period',$eval_year);
		$result = $this->db->get('performance_division_status')->result();

		return $result;
	}

	public function getTeamMemberKaDiv($division){
		$year = date("Y")-1;
		$division = $this->session->userdata('division');

		$query = "
			SELECT *
			FROM
			v_hris_employee_updated a
			LEFT JOIN employee_update_division_pa as b on a.id_employee = b.id_employee and b.evaluation_year = '".$year."'
			where 
			case 
				when b.id_employee != '' then b.division
			else
				a.division
			end  = '".$division."'
			";

		$data = $this->db->query($query)->result_array();
		return $data;
	}

	public function countTeamSecondDivision($division)
		{
			
			$query = "SELECT
			email 
			FROM
				v_hris_employee_updated as a
			where a.division = '{$division}' and action != '".encrypt('Leaving')."'
			group by email";
			$total = $this->db->query($query)->result_array();
			// dumper(decrypt($total[2]['email']));
			$total_team = 0;
			//=======for checking=========
			foreach($total as $key => $val){
				$personnel_area		= decrypt($val['personnel_area']);
				$pers 				= substr($personnel_area,0,3);
				if($pers != "TIS"){
					$total_team++;
				}

			}
			

			return $total_team;
	}

	public function countTeamAdjustmentPA($division)
	{
		$query = "
		SELECT *
		FROM
		v_hris_employee_updated a
		LEFT JOIN employee_update_division_pa as b on a.id_employee = b.id_employee
		where 
		case 
			when b.id_employee != '' then b.division
		else
			a.division
		end  = '{$division}'
		and a.email != ''
		";
		$total = $this->db->query($query)->result_array();
		$total_team = 0;
		//=======for checking=========
		foreach($total as $key => $val){
			$personnel_area		= decrypt($val['personnel_area']);
			$pers 				= substr($personnel_area,0,3);
			if($pers != "TIS"){
				$total_team++;
			}

		}

		return $total_team;
	}

	public function get_all_employee_except_leaving(){
		$query = "
		select *, 
			case 
				when b.id_employee != '' then b.department
			else
				a.department
			end as department, 
			case 
				when b.id_employee != '' then b.division
			else
				a.division
			end as division
			from v_hris_employee_updated as a left join employee_update_division_pa as b on a.id_employee = b.id_employee where 
			b.id_employee is null
			and a.action != '".encrypt("Leaving")."'
		";
		// echo $query;
		$q = $this->db->query($query)->result_array();
		// print_r($q);
		// die;
		return $q;
	}

	public function get_all_division(){
		$query = "select division from v_hris_employee_updated where division != '' and action != '".encrypt('Leaving')."' group by division";
		$q = $this->db->query($query)->result_array();
		// print_r($q);
		// die;
		return $q;
	}
	
	public function cancel_for_pa($year){
	
		$cek = $this->db->select('*')->from('performance_appraisal_schedule')->where(['year' => $year, 'is_active' => 1])->get()->result_array();
		
		if(!empty($cek)){
			$data = array(
				'is_active' => '0',
				'updated_at' => date("Y-m-d H:i:s"),
				'updated_by' => encrypt($this->session->userdata('user_email'))
			);
			$this->db->set($data);
			$this->db->where('year',$year);
			$query = $this->db->update('performance_appraisal_schedule');

			return $query;

			return 1;
		}else{
			return 0;
		}
		
		die;

	}

	public function get_employee($nik){
		$query = "select division,depthead_name,divhead_name,director_name from v_hris_employee_updated where nik = '{$nik}' and action != '".encrypt('Leaving')."'";
		$q = $this->db->query($query)->result_array();
		// print_r($q);
		// die;
		return $q;
	}

	public function get_bos_division($division){
		$query = "select depthead_name, divhead_name, director_name from v_hris_employee_updated where division = '$division' and action != '".encrypt('Leaving')."' group by depthead_name, divhead_name, director_name";
		$q = $this->db->query($query)->result_array();
		return $q;
	}

	public function ready_for_pa($year){
	
		$cek = $this->db->select('*')->from('performance_appraisal_schedule')->where(['year' => $year, 'is_active' => 1])->get()->result_array();
		
		if(!empty($cek)){
			return 0;
		}else{
			
		$data = array(
				'year' => $year,
				'is_active' => '1',
				'created_at' => date("Y-m-d H:i:s"),
				'created_by' => encrypt($this->session->userdata('user_email'))
			);
			$query = $this->db->insert('performance_appraisal_schedule', $data);
			return $query;
		}
		
		die;

	}

	public function check_ready($year){
	
		$cek = $this->db->select('*')->from('performance_appraisal_schedule')->where(['year' => $year, 'is_active' => 1])->get()->result_array();
		if(!empty($cek)){
			return $cek[0]['created_at'];
		}else{
			return 0;
		}
		die;

	}
	
	public function hr_preparation_pa_delete($id){
		return $this->db->delete('employee_update_division_pa', array('id' => $id));
	}

	public function get_all_employee_leaving(){
		$query = "
		select *, 
			case 
				when b.department != '' then b.department
			else
				a.department
			end as department, 
			case 
				when b.division != '' then b.division
			else
				a.division
			end as division
			from v_hris_employee_updated as a left join employee_update_division_pa as b on a.id_employee = b.id_employee where 
			b.id_employee is null
			and a.action = '".encrypt('Leaving')."'
		";
		
		$q = $this->db->query($query)->result_array();
		return $q;
	}

	public function save_access_divhead_pa_leaving($id,$data){
		$data['division'] = $data['division'];
		if($id == ""){

			$data['created_at'] = date("Y-m-d H:i:s");
			$data['created_by'] = $this->email;
			$this->db->where("evaluation_year", $data['evaluation_year']);
			$this->db->where("division", $data['division']);
			$result = $this->db->get('access_divhead_leaving_employee')->result();
			if(empty($result)){
				$this->db->insert('access_divhead_leaving_employee', $data);
			}
			
		}else{
			$data['updated_at'] = date("Y-m-d H:i:s");
			$data['updated_by'] = $this->email;
			$this->db->set($data);
			$this->db->where('id',$id);
			$this->db->update('access_divhead_leaving_employee');
		}

		return true;
	}

	public function get_access_divhead_pa_leaving($id){
		$data = $this->db->query("select * from access_divhead_leaving_employee where id = '{$id}'")->result_array();
		return $data;
	}

	public function getAllDataOnlyPAOk($eval_year)
	{
		$query = "SELECT a.*
		FROM performance_appraisal a left join form_request as b on a.request_number = b.request_number
		WHERE a.evaluation_period_start = '$eval_year' AND LEFT(a.request_number,8) = 'HRIS_KPI' AND a.is_status NOT IN (0,7)";
		return $this->db->query($query)->result();
	}
	
	public function getAllDataTraining($eval_year)
	{
		$query = "select b.employee_name,
		b.employee_nik,
		b.division,
		a.training_name,
		a.category,
		b.employee_grade,
		b.position
		from performance_appraisal_training as a 
		left join performance_appraisal as b on a.request_id = b.id
		where b.evaluation_period_start = '{$eval_year}';";
		return $this->db->query($query)->result();
		
	}

	public function get_uom($id){
		$data = $this->db->query("select * from master_uom where id = '{$id}'")->result_array();
		return $data;
	}

	public function countTeamHR($division,$email)
	{
		if (($division != '' || $division != null || !empty($division))) {
			$query = "select * from v_hris_employee_updated
			where division = '{$division}'
			and action != '".encrypt('Leaving')."'
			and email != ''";
			$total = $this->db->query($query)->result_array();
			$total_team = 0;
			//=======for checking=========
			foreach($total as $key => $val){
				$personnel_area		= decrypt($val['personnel_area']);
				$pers 				= substr($personnel_area,0,3);
				if($pers != "TIS"){
					$total_team++;
				}
			}
		}else{
			$total_team = 0;
		}

		return $total_team;
	}

	public function getTeamMemberKaDivMul($division){
		$year = date("Y")-1;

		$query = "
			SELECT *
			FROM
			v_hris_employee_updated a
			LEFT JOIN employee_update_division_pa as b on a.id_employee = b.id_employee and b.evaluation_year = '".$year."'
			where 
			case 
				when b.id_employee != '' then b.division
			else
				a.division
			end  = '".$division."'
			";

		$data = $this->db->query($query)->result_array();
		return $data;
	}

	public function getDevisiasi($division, $grade, $year)
		{
			
			$query = "select basic_line from kurva_devisiasi where division = '$division' and year = '$year' and grade = '$grade'";
			// dumper($query);
			// echo $query."<br>";
			// die;
			$q = $this->db->query($query)->result();
	
			// echo $q[0]->basic_line."<br>";
			if(empty($q[0]->basic_line)){
				$line = "0";
			}else{
				$line = $q[0]->basic_line;
			}
			
			return $line;
		}
		
	/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////

	///////////////////////////////////////////// START TIME MANAGEMENT 2024/////////////////////////////////////////////

	public function getRequestTimeOffList()
	{
		$statuses = array('In Progress', 'Hold', 'Review');

		$this->db->select('request_id');
		$this->db->from('form_approval');
		$this->db->where('approval_email', $this->email);
		$this->db->where_in('approval_status', $statuses);
		$this->db->order_by('id', 'ASC');
		
		$approval = $this->db->get()->result_array();

		if (!empty($approval)) {
			// Ambil array ID langsung tanpa foreach manual
			$listIds = array_column($approval, 'request_id');
			
			// Panggil method pendukung dengan passing Array ID (Bukan String CSV)
			return $this->getListForm($listIds);
		}

		return array();
	}

	public function getApprovalListTMCek_ztm()
	{
		$this->db->select('request_id');
		$this->db->from('form_approval');
		$this->db->where('approval_email', $this->email);
		$this->db->where('approval_status', 'In Progress');
		$this->db->order_by('id', 'ASC');
		
		$approval = $this->db->get()->result_array();

		if (!empty($approval)) {
			// Ambil array ID langsung
			$listIds = array_column($approval, 'request_id');
			
			// Panggil method pendukung dengan passing Array ID
			return $this->getListFormTMCek($listIds); // TIME MANAGEMENT 2.0
		}

		return array();
	}

	public function getListFormTMCek($listId = '')
	{ 
		$this->db->select("
			fr.*,
			hto.jenis AS jenis_cuti,
			COALESCE(emp.complete_name, '-') AS complete_name
		", FALSE);
		$this->db->from('form_request fr');
		$this->db->join('hris_request_time_off hto', 'fr.request_number = hto.request_number', 'left');
		
		// Gabungkan query pegawai langsung ke JOIN utama
		$this->db->join('(
			SELECT e1.nik, e1.complete_name 
			FROM v_hris_employee_updated e1
			INNER JOIN (
				SELECT nik, MAX(id_employee) AS max_id 
				FROM v_hris_employee_updated 
				GROUP BY nik
			) e2 ON e1.nik = e2.nik AND e1.id_employee = e2.max_id
		) emp', "emp.nik = IF(fr.employee_id = 0, '00000000', fr.employee_id)", 'left', FALSE);

		// Filter berdasarkan $listId atau NIK
		if (!empty($listId)) {
			// Amankan $listId jika berupa string CSV (misal: "1,2,3")
			$raw_ids = is_array($listId) ? $listId : explode(',', $listId);
			$clean_ids = array_map('intval', array_filter($raw_ids));
			
			if (!empty($clean_ids)) {
				$this->db->where_in('fr.id', $clean_ids);
			} else {
				return array(); // Kembalikan array kosong jika ID tidak valid
			}
		} else {
			$this->db->where('fr.employee_id', $this->nik);
		}

		// Filter Umum
		$this->db->where('fr.is_status', '1');
		$this->db->where('fr.form_type', 'TM');
		$this->db->where('fr.is_status_admin_hr !=', 7);
		$this->db->order_by('fr.id', 'DESC');

		$res = $this->db->get()->result_array();

		// Formatting NIK 00000000 jika diperlukan
		foreach ($res as &$row) {
			if ($row['employee_id'] == 0) {
				$row['employee_id'] = '00000000';
			}
		}

		return $res;
	}

	public function getApprovalListTMRejected_ztm($flagTM) 
	{
		$approval_email = $this->email;

		$sql = "SELECT a.* FROM form_request as a
				LEFT JOIN form_approval as b ON a.id = b.request_id
				WHERE (b.approval_email='$approval_email' OR a.updated_by = '$approval_email')
				AND (a.is_status = '4' OR a.is_status = '8')
				AND a.form_type = 'TM' AND is_status_admin_hr != 7
				ORDER BY a.id DESC"; // TIME MANAGEMENT 2.0^

		$query = $this->db->query($sql);
		$res = $query->result_array();
		//dumper($listId);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			if($nik == 0){
				$nik = '00000000';
				$key['employee_id'] = '00000000';
			}
			$request_number = $key['request_number'];
			$sqll = "SELECT id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['is_status_admin_hr'] = $key['is_status_admin_hr']; // TIME MANAGEMENT 2.0
			$row['is_status_divhead_hr'] = $key['is_status_divhead_hr']; // TIME MANAGEMENT 2.0
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		}
		return $data;
	}

	public function getApprovalListTMApproved_ztm()
	{
		$this->db->where('approval_email', $this->email);
		$this->db->where("approval_status IN ('Approved')");
		$this->db->order_by('id', 'ASC');
		$approval = $this->db->get('form_approval')->result_array();
		//dumper($approval);
		$data = array();

		if (!empty($approval)) {

			foreach ($approval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			
			$listApproval = implode(",", $list);
			$listForm = $this->getListFormTMApproved($listApproval); // TIME MANAGEMENT 2.0
			return $listForm;

		} else {
			return $data;
		}
	}

	public function getListFormTMApproved($listId = '') 
	{
		
		if (!empty($listId)) {
			$sql = "SELECT *
						FROM form_request
						WHERE id IN ($listId) AND ( is_status = '1' OR is_status = '3') AND form_type = 'TM' AND is_status_admin_hr != 7
						ORDER BY id DESC"; // TIME MANAGEMENT 2.0^
		} else {
			$sql = "SELECT *
						FROM form_request
						WHERE employee_id LIKE '$this->nik' AND ( is_status = '1' OR is_status = '3') AND form_type = 'TM' AND is_status_admin_hr = 7
						ORDER BY id DESC"; // TIME MANAGEMENT 2.0^
		}

		$query = $this->db->query($sql);
		$res = $query->result_array();
		// dumper($res);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			if($nik == 0){
				$nik = '00000000';
				$key['employee_id'] = '00000000';
			}
			$request_number = $key['request_number'];
			$sqll = "SELECT id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			// dumper($complete_name);
			$row   = array();
			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['is_status_admin_hr'] = $key['is_status_admin_hr']; // TIME MANAGEMENT 2.0
			$row['is_status_divhead_hr'] = $key['is_status_divhead_hr']; // TIME MANAGEMENT 2.0
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		}
		return $data;
	}

	public function getApprovalListTMHR_ztm($flagTM)
	{
		$approval_email = $this->email;

		$sql = "SELECT a.* FROM form_request as a
				LEFT JOIN (SELECT * FROM form_approval WHERE id in (SELECT MAX(id) from form_approval WHERE approval_email='$approval_email' GROUP BY request_id))  
				as b ON a.id = b.request_id
				WHERE (b.approval_email='$approval_email' OR a.updated_by = '$approval_email')
				AND a.form_type = 'TM' AND a.is_status_admin_hr = '$flagTM'
				ORDER BY a.id DESC";

		$query = $this->db->query($sql);
		$res = $query->result_array();
		//dumper($listId);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			if($nik == 0){
				$nik = '00000000';
				$key['employee_id'] = '00000000';
			}
			$request_number = $key['request_number'];
			$sqll = "SELECT id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $nik;
			$row['is_status_admin_hr'] = $key['is_status_admin_hr']; // TIME MANAGEMENT 2.0
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		}
		return $data;
	}

	public function getApprovalListTMShift_ztm()
	{ //CR 2 TM
		$approval_email = $this->email;

		$sql = "SELECT * FROM form_request WHERE form_type='TM' AND is_status_divhead_hr=7 OR is_status_divhead_hr=8 ORDER BY id DESC";
		$query = $this->db->query($sql);
		$res = $query->result_array();

		//dumper($listId);
		
		$data = array();
		foreach ($res as $key) {
			$req_id = $key['id'];
			$sqlAppr = "SELECT * FROM form_approval WHERE request_id=$req_id";
			$queryAppr = $this->db->query($sqlAppr);
			$resAppr = $queryAppr->result_array();
			if (!empty($resAppr)){
				if (!($resAppr[1]['approval_status'] == 'Approved') && $key['is_status_divhead_hr'] == 7){
					continue;
				} else if (!($resAppr[0]['approval_status'] == 'Approved') && $key['is_status_divhead_hr'] == 8){
					continue;
				}
			}

			$nik = $key['employee_id'];
			if($nik == 0){
				$nik = '00000000';
				$key['employee_id'] = '00000000';
			}
			$request_number = $key['request_number'];
			$sqll = "SELECT id_employee, complete_name FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $nik;
			$row['is_status_admin_hr'] = $key['is_status_admin_hr']; // TIME MANAGEMENT 2.0
			$row['is_status_divhead_hr'] = $key['is_status_divhead_hr']; // TIME MANAGEMENT 2.0
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
		} 
		return $data;
	}
	

	public function cekNoteTM($request_id)
	{
		$email_login = $this->email;

		$sql = "SELECT 	
					 *
				FROM		
					request_notes
				WHERE request_id = '$request_id' AND created_by = '$email_login'
				ORDER BY id DESC LIMIT 1";

		$query = $this->db->query($sql);
		$res = $query->result();
		$email_created = (!empty(($res[0]->created_by)) && $res[0]->is_status != 0) ? $res[0]->created_by : '';
		
		if($email_created == $email_login){
			$cek = true;
		}else{
			$cek = false;
		}
		
		if($cek){
			return $cek;
		}else{
			return false;
		}
	}
	///////////////////////////////////////////// END TIME MANAGEMENT 2024/////////////////////////////////////////////

	public function countAllMDCRFI()
	{
		return $this->db->count_all('hris_no_req_mdcr');
	}

	public function countFilteredMDCRFI($search = '')
	{
		$this->db->select('COUNT(DISTINCT no_req_mdcr) AS count');
		$this->db->from('hris_no_req_mdcr');

		if (!empty($search)) {
			$this->db->like('no_req_mdcr', $search);
		}

		$query = $this->db->get();
		return $query->row()->count;
	}

	public function getApprovalListMDCRAfterGroupingServer($start = 0, $length = 10, $search = '')
	{
		$this->db->select('id, no_req_mdcr, is_status, is_status_progress');
		// $this->db->order_by('is_status_progress', 'ASC');
		$this->db->order_by('id', 'DESC');
		$this->db->from('hris_no_req_mdcr');

		if (!empty($search)) {
			$this->db->like('no_req_mdcr', $search);
		}

		$this->db->group_by('no_req_mdcr');
		$this->db->order_by('no_req_mdcr', 'DESC');
		$this->db->limit($length, $start);

		$query = $this->db->get();
		return $query->result_array();
	}
	

	public function getMDCRApprovedServerSide($start = 0, $length = 10, $search = '')
	{
		// Build query utama
		$this->db->distinct();
		$this->db->select('fr.*, he.complete_name');
		$this->db->from('form_request fr');
		$this->db->join('form_approval fa', 'fa.request_id = fr.id');
		$this->db->join('v_hris_employee_updated he', 'he.nik = fr.employee_id');
		$this->db->where('fa.approval_email', $this->email);
		$this->db->where('fa.approval_status', 'Approved');
		$this->db->where_in('fr.is_status', ['1','3']);
		$this->db->where('fr.form_type', 'MDCR');

		// Filter search
		if(!empty($search)) {
			$this->db->group_start();
			$this->db->like('fr.request_number', $search);
			$this->db->or_like('fr.employee_id', $search);
			$this->db->or_like('he.complete_name', encrypt($search));
			$this->db->or_like('fr.no_req_mdcr', $search);
			$this->db->group_end();
		}

		$this->db->group_by('fr.id');
    	$this->db->order_by('fr.id', 'DESC');

		// Hitung filtered count
		$filtered_count = $this->db->count_all_results('', false); // false agar query tidak reset

		// Paging
		if($length != -1) {
			$this->db->limit($length, $start);
		}

		// Eksekusi query
		$query = $this->db->get();
		$data = $query->result_array();

		// Hitung total data (tanpa filter)
		$this->db->from('form_request fr');
		$this->db->join('form_approval fa', 'fa.request_id = fr.id');
		$this->db->where('fa.approval_email', $this->email);
		$this->db->where('fa.approval_status', 'Approved');
		$this->db->where_in('fr.is_status', ['1','3']);
		$this->db->where('fr.form_type', 'MDCR');
		
		$total_count = $this->db->count_all_results();
		
		return [
			'data' => $data,
			'recordsTotal' => $total_count,
			'recordsFiltered' => $filtered_count
		];
	}

	public function getMDCRRejectServerSide($start = 0, $length = 10, $search = '', $order = '', $column = '')
	{

		// Kolom default untuk sorting
		$orderColumn = 'id';
		$orderDir = 'ASC';

		if (!empty($order)) {
			$orderColumn = $column[$order[0]['column']]['data'];
			$orderDir = $order[0]['dir'];
		}

		// Query utama
		$this->db->select('f.*, e.complete_name');
		$this->db->from('form_request f');
		$this->db->join('v_hris_employee_updated e', 'f.employee_id = e.nik', 'left');
		$this->db->where('f.is_status', '4');
		$this->db->where('f.form_type', 'MDCR');

		// Jika ada pencarian
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('f.request_number', $search);
			$this->db->or_like('f.employee_id', $search);
			$this->db->or_like('e.complete_name', encrypt($search));
			$this->db->group_end();
		}

		$this->db->group_by('f.id');
    	$this->db->order_by('f.id', 'DESC');

		// Hitung total data sebelum limit
		$totalFiltered = $this->db->count_all_results('', false);

		// Tambahkan limit & order
		$this->db->order_by($orderColumn, $orderDir);
		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		// Eksekusi query
		$query = $this->db->get();
		$data = $query->result_array();

		// Hitung total semua data (tanpa filter)
		$this->db->from('form_request');
		$this->db->where('is_status', '4');
		$this->db->where('form_type', 'MDCR');
		$totalData = $this->db->count_all_results();

		// Format output untuk DataTables
		$result = array(
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $data
		);

		return $result;
	}

	public function getMDCRReviseServerSide($start = 0, $length = 10, $search = '')
	{
		// ===== QUERY UTAMA =====
		$this->db->distinct();
		$this->db->select('fr.*, he.complete_name');
		$this->db->from('form_request fr');
		$this->db->join('form_approval fa', 'fa.request_id = fr.id');
		$this->db->join('v_hris_employee_updated he', 'he.nik = fr.employee_id', 'left');
		
		// Kondisi approval yang direvisi
		$this->db->where('fa.approval_email', $this->email);
		$this->db->where_in('fa.approval_status', ['Revised', 'Revised to previous layer']);
		$this->db->where_in('fr.is_status', ['1', '2']);
		$this->db->where('fr.form_type', 'MDCR');

		// ==== SEARCH FILTER ====
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('fr.request_number', $search);
			$this->db->or_like('fr.employee_id', $search);
			$this->db->or_like('he.complete_name', encrypt($search));
			$this->db->group_end();
		}

		$this->db->group_by('fr.id');
    	$this->db->order_by('fr.id', 'DESC');

		// Hitung total setelah filter (recordsFiltered)
		$filtered_count = $this->db->count_all_results('', false); // false agar query builder tidak reset

		// Limit (pagination)
		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		// Eksekusi query utama
		$query = $this->db->get();
		$data = $query->result_array();

		// ==== HITUNG TOTAL TANPA FILTER ====
		$this->db->from('form_request fr');
		$this->db->join('form_approval fa', 'fa.request_id = fr.id');
		$this->db->where('fa.approval_email', $this->email);
		$this->db->where_in('fa.approval_status', ['Revised', 'Revised to previous layer']);
		$this->db->where_in('fr.is_status', ['1', '2']);
		$this->db->where('fr.form_type', 'MDCR');
		$total_count = $this->db->count_all_results();

		// ==== RETURN DATA DALAM FORMAT DATATABLES ====
		return [
			'data' => $data,
			'recordsTotal' => $total_count,
			'recordsFiltered' => $filtered_count
		];
	}

	public function getMDCRWaitingListServerSide($start = 0, $length = 10, $search = '')
	{

		// ====Inisialisasi Cost Center=====
		$cs1	= encrypt('IBSW-BPOH');
		$cs2	= encrypt('IBSW-BOMOH');
		// ===== QUERY UTAMA =====
		$this->db->distinct();
		$this->db->select('
			fr.id,
			fr.request_number,
			fr.form_type,
			fr.form_purpose,
			fr.form_notes,
			fr.approval_form_scanned,
			fr.approved_date,
			fr.result_document,
			fr.is_status,
			fr.created_by,
			fr.created_at,
			fr.updated_by,
			fr.updated_at,
			fr.deleted_by,
			fr.deleted_at,
			fr.employee_id,
			he.complete_name,
			he.cost_center,
			CASE 
				WHEN (he.cost_center = "'.$cs1.'" OR he.cost_center = "'.$cs2.'") THEN 1
				ELSE 2
			END AS kind
		');
		$this->db->from('form_request fr');
		$this->db->join('form_approval fa', 'fa.request_id = fr.id');
		$this->db->join('v_hris_employee_updated he', 'he.nik = fr.employee_id', 'left');

		// Kondisi utama (setara fungsi sebelumnya)
		$this->db->where('fa.approval_email', $this->email);
		$this->db->where('fa.approval_status', 'In Progress');
		$this->db->where('fr.is_status', '1');
		$this->db->where('fr.form_type', 'MDCR');
		$this->db->where('(fr.no_req_mdcr IS NULL OR fr.no_req_mdcr = "")');
		$this->db->where('fr.is_status_admin_hr', '1');

		// ==== SEARCH FILTER ====
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('fr.request_number', $search);
			$this->db->or_like('fr.employee_id', $search);
			$this->db->or_like('he.complete_name', encrypt($search));
			$this->db->or_like('he.cost_center', $search);
			$this->db->group_end();
		}
		
		$this->db->group_by('fr.id');
		$this->db->order_by('fr.id', 'ASC');

		// ===== HITUNG FILTERED COUNT =====
		$filtered_count = $this->db->count_all_results('', false); // tidak reset builder

		// ===== PAGINATION =====
		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		// ===== EKSEKUSI QUERY =====
		$query = $this->db->get();
		$data = $query->result_array();

		// ===== HITUNG TOTAL TANPA FILTER =====
		$this->db->from('form_request fr');
		$this->db->join('form_approval fa', 'fa.request_id = fr.id');
		$this->db->where('fa.approval_email', $this->email);
		$this->db->where('fa.approval_status', 'In Progress');
		$this->db->where('fr.is_status', '1');
		$this->db->where('fr.form_type', 'MDCR');
		$this->db->where('(fr.no_req_mdcr IS NULL OR fr.no_req_mdcr = "")');
		$this->db->where('fr.is_status_admin_hr', '1');
		$total_count = $this->db->count_all_results();

		// ===== FORMAT DATA UNTUK DATATABLES =====
		return [
			'data' => $data,
			'recordsTotal' => $total_count,
			'recordsFiltered' => $filtered_count
		];
	}

	public function getRequestMDCRServerSide($start = 0, $length = 10, $search = '')
	{
		$email = $this->email;

		// === Base Query ===
		$this->db->select('
			fr.id,
			fr.request_number,
			fr.form_type,
			fr.form_purpose,
			fr.form_notes,
			fr.approval_form_scanned,
			fr.approved_date,
			fr.result_document,
			fr.is_status,
			fr.created_by,
			fr.created_at,
			fr.updated_by,
			fr.updated_at,
			fr.deleted_by,
			fr.deleted_at,
			fr.employee_id,
			he.complete_name
		');
		$this->db->from('form_approval fa');
		$this->db->join('form_request fr', 'fa.request_id = fr.id', 'inner');
		$this->db->join('v_hris_employee_updated he', 'fr.employee_id = he.nik', 'left');

		// === Filter utama ===
		$this->db->where('fa.approval_email', $email);
		$this->db->where('fa.approval_status', 'In Progress');
		$this->db->where('fr.is_status', '1');
		$this->db->where('fr.form_type', 'MDCR');
		$this->db->group_start()
			->where('fr.is_status_admin_hr', '0')
			->or_where('fr.is_status_admin_hr IS NULL', null, false)
		->group_end();

		// === Filter pencarian (search) ===
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('fr.request_number', $search);
			$this->db->or_like('fr.employee_id', $search);
			$this->db->or_like('he.complete_name', encrypt($search));
			$this->db->group_end();
		}

		$this->db->group_by('fr.id');
		$this->db->order_by('fr.id', 'ASC');

		// Limit (pagination)
		if ($length != -1) {
			$this->db->limit($length, $start);
		}


		// === Eksekusi query utama ===
		$query = $this->db->get();
		$data = $query->result_array();

		// === Hitung total data setelah filter ===
		$this->db->reset_query();
		$this->db->from('form_approval fa');
		$this->db->join('form_request fr', 'fa.request_id = fr.id', 'inner');
		$this->db->join('v_hris_employee_updated he', 'fr.employee_id = he.nik', 'left');
		$this->db->where('fa.approval_email', $email);
		$this->db->where('fa.approval_status', 'In Progress');
		$this->db->where('fr.is_status', '1');
		$this->db->where('fr.form_type', 'MDCR');
		$this->db->group_start()
			->where('fr.is_status_admin_hr', '0')
			->or_where('fr.is_status_admin_hr IS NULL', null, false)
		->group_end();

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('fr.request_number', $search);
			$this->db->or_like('fr.employee_id', $search);
			$this->db->or_like('he.complete_name', encrypt($search));
			$this->db->group_end();
		}

		$recordsFiltered = $this->db->count_all_results();

		// === Hitung total semua data tanpa search ===
		$this->db->reset_query();
		$this->db->from('form_approval fa');
		$this->db->join('form_request fr', 'fa.request_id = fr.id', 'inner');
		$this->db->where('fa.approval_email', $email);
		$this->db->where('fa.approval_status', 'In Progress');
		$this->db->where('fr.is_status', '1');
		$this->db->where('fr.form_type', 'MDCR');
		$this->db->group_start()
			->where('fr.is_status_admin_hr', '0')
			->or_where('fr.is_status_admin_hr IS NULL', null, false)
		->group_end();

		$recordsTotal = $this->db->count_all_results();

		// === Format untuk DataTables ===
		return [
			'recordsTotal'    => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data'            => $data
		];
	}
	public function getApproverResignation($request_id)
	{
		$this->db->select('e.id_employee,e.complete_name,e.email, s.status, s.acted_at, s.sequence');
		$this->db->from('hris_employee e');
		$this->db->join(
			'exit_clearance_approval_steps s',
			'e.nik = s.id_approver AND e.id_employee = (
				SELECT MAX(e2.id_employee)
				FROM hris_employee e2
				WHERE e2.nik = s.id_approver
			)',
			'inner',
			false
		);
		$this->db->join('exit_clearance_approval_request r', 's.id_approval_req = r.id', 'inner');
		$this->db->where('r.id_form_request', $request_id);
		$this->db->where('r.approval_type', 'RESIGNATION_LETTER');
		$this->db->order_by('s.sequence', 'ASC');
		return $this->db->get()->result_array();
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
		$data = $this->db->get()->result_array();
		if($data){
			return $data;
		}else{
			return '';
		}
	}
	public function addNote($id, $type, $note)
	{
		if($type === "Resignation Letter")
		{
			$table = 'exit_clearance_resignation_letters';
			$kolom = 'id_resignation_letter';
		}else{
			$table = 'exit_clearance';
			$kolom = 'id_exit_clearance';
		}
		$dataForm = $this->db->get_where($table, ['id_form_request' => $id])->row();
		if(!$dataForm){
			return false;
		}
		$data = [
			$kolom => $dataForm->id,
			'note' => $note,
			'created_by' => $this->email,
			'created_at' => $this->date
		];
		return $this->db->insert('exit_clearance_notes', $data);
	}
}