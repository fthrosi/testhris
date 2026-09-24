<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->email = $this->session->userdata('user_email');
		$this->nik = $this->session->userdata('nik');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function getMyRequest()
	{
		$this->db->where("created_by", $this->email);
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('form_request')->result_array();
	}

	public function getMySubmissionList(){
		$this->db->where('employee_id', $this->nik);
		$this->db->where('is_status', '1');
		$approval = $this->db->get('form_request')->result_array();
		$data = array();

		if ($approval) {
			return $approval;
		} else {
			return $data;
		}
	}

	///////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////

	public function getMyRequestMDCR()
	{
		// $this->db->where("created_by", $this->email);
		$this->db->where("employee_id", $this->nik);
		$this->db->where("form_type", 'MDCR');
		$this->db->where('request_number !=', 'EAPP_MDCR_IBS_0001');
		$this->db->where('request_number !=', 'EAPP_MDCR_IBS_0002');
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('form_request')->result_array();
	}

	public function getMyRequestPAList()
	{
		$type = array('KPI', 'PLAN');
		// $this->db->where("created_by", $this->email);
		$this->db->where("employee_id", $this->nik);
		$this->db->where_in("form_type", $type);
		// $this->db->where("form_type", 'PLAN');
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('form_request')->result_array();
	}

	public function getMyRequestPA($id, $period = "")
	{

		if($period != ""){
			$where = " and b.evaluation_period_start = '".$period."-01-01'";
		}else{
			$where = "";
		}

		$query = "select * from form_request as a left join performance_appraisal as b on a.request_number = b.request_number where a.id = '$id' $where";
		// echo $query."<br>"; die;
		return $this->db->query($query)->result_array();
	}

	///////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////

	///////////////////////////////////////START TIME MANAGEMENT 2024 /////////////////////////////
	public function getMyRequestTM()
	{
		// $this->db->where("created_by", $this->email);
		$this->db->where("employee_id", $this->nik);
		$this->db->where("form_type", 'TM');
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('form_request')->result_array();
	}
	///////////////////////////////////////END TIME MANAGEMENT 2024 /////////////////////////////

	// public function getMyRequestEC()
	// {
	// 	// $this->db->where("created_by", $this->email);
	// 	$this->db->where("employee_id", $this->nik);
	// 	$this->db->where("form_type", 'EC');
	// 	$this->db->order_by('created_at', 'DESC');
	// 	return $this->db->get('form_request')->result_array();
	// }
	public function getMyRequestEC()
	{
		$this->db->select('
			form_request.*,
			rl.status AS rl_status,
			ec.status AS ec_status
		');

		$this->db->from('form_request');

		$this->db->join(
			'exit_clearance_resignation_letters rl',
			'rl.id_form_request = form_request.id',
			'left'
		);

		$this->db->join(
			'exit_clearance ec',
			'ec.id_form_request = form_request.id',
			'left'
		);

		$this->db->where('form_request.employee_id', $this->nik);
		$this->db->where('form_request.form_type', 'EC');
		$this->db->order_by('form_request.created_at', 'DESC');

		return $this->db->get()->result_array();
	}
}