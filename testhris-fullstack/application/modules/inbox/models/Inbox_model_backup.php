<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->email = $this->session->userdata('user_email');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
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
			return $listForm;

		} else {
			return $data;
		}
	}

	public function getPAList()
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

		$this->db->select('request_id');
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
			// $result = array('data' => new ArrayObject());
		}

		return $result;
	}

	public function getHRConfirmed()
	{
		$year = $this->year - 1;
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
			$result = $this->db->get('performance_appraisal')->result();
		} else {
			$result = '';
		}

		return $result;
	}

	public function getListForm($listId = '', $flag = '')
	{
		if (!empty($listId)) {
			$this->db->where("id IN ($listId) ");
		} else {
			$this->db->where("created_by", $this->email);
		}

		if (!empty($flag)) {

			if ($flag == 'review') {
				$this->db->where("is_status", '6');
			} elseif ($flag == 'pa_list') {
				$this->db->where("is_status", '3');
			}

		} else {
			$this->db->where("is_status !=", '2');
			$this->db->where("is_status !=", '3');
			$this->db->where("is_status !=", '4');
			$this->db->where("is_status !=", '7');
			$this->db->where("is_status !=", '0');
		}

		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('performance_appraisal')->result_array();
	}

	public function getLastActivity()
	{
		$this->db->select("id, approval_response, request_id, approval_notes, created_at, created_by");
		$this->db->limit(5);
		return $this->db->get('logs')->result_array();
	}

	public function countTeam($division)
	{
		$total = $this->db->get_where('employee', array('division' => $division))->result_array();
		return count($total);
	}

	public function countRequest($division, $status, $not_include = '')
	{	
		$where = array('division' => $division, 'is_status' => $status);
		$total = $this->db->get_where('performance_appraisal', $where)->result_array();
		return count($total);
	}

	public function getTotalGrade($division, $grade)
	{
		if ($grade == 'a') {
			$where = array('division' => $division, 'is_status' => 3, 'final_score >=' => '9.1');
		} elseif ($grade == 'b') {
			$where = array('division' => $division, 'is_status' => 3, 'final_score >=' => '8.1', 'final_score <' => '9.1');
		} elseif ($grade == 'c') {
			$where = array('division' => $division, 'is_status' => 3, 'final_score >=' => '6.9', 'final_score <' => '8.1');
		} elseif ($grade == 'd') {
			$where = array('division' => $division, 'is_status' => 3, 'final_score >=' => '5.6', 'final_score <' => '6.9');
		} elseif ($grade == 'e') {
			$where = array('division' => $division, 'is_status' => 3, 'final_score >=' => '0.0', 'final_score <' => '5.6');
		}


		$total = $this->db->get_where('performance_appraisal', $where)->result_array();
		return count($total);
	}

	public function find_select($select, $where = '', $table)
	{
		$this->db->select($select);
		if ($where != '') { $this->db->where($where);}
		return $this->db->get($table);
	}

	public function checkApproval($id, $email)
	{
		return $this->db->get_where('form_approval', array('request_id' => $id, 'approval_email' => $email))->row_array();
	}

}