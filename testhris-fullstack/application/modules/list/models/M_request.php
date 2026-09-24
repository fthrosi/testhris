<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_request extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->user = $this->session->userdata('user_name');
		$this->email = $this->session->userdata('user_email');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function find($field = '', $value = '', $table, $order_by = '', $order_type = '')
	{
		if ($field != '' && $value != '') {
			$this->db->where($field, $value);
		}

		if ($order_by != '') {
			if ($order_type != '') {
				$this->db->order_by($order_by, $order_type);
			} else {
				$this->db->order_by($order_by, 'ASC');
			}
		}

		return $this->db->get($table);
	}

	public function find_select($select, $where = '', $table)
	{
		$this->db->select($select);
		if ($where != '') { $this->db->where($where);}
		return $this->db->get($table);
	}

	public function getAll($field, $table, $where = null)
	{
		return $this->db->select($field)->where($where)->get($table)->result_array();
	}

	public function getFormType()
	{
		$output = '';
		$output .= '<option value=""></option>';

		$formType = $this->db->select('code, description')
							->where('is_active = 1')
							->order_by('description', 'ASC')
							->get('form_type')->result_array();

		foreach ($formType as $key) {
			$output .= '<option value="' . $key['code'] . '" >' . $key['description'] . '</option>';
		}
		return $output;
	}

	public function getUserList($field, $table, $where)
	{
		$output = '';
		$output .= '<option value=""></option>';
		$userList = $this->db->select($field)->where($where)->get($table)->result_array();
		foreach ($userList as $key) {
			$output .= '<option value="' . $key[$field] . '" >' . $key[$field] . '</option>';
		}
		return $output;
	}

	public function saveApproval($email, $requestId)
	{
		$i = 0;
		$priority = 1;
		$count = count($email);

		for ($i = 0; $i < $count; $i++) {

			if ($email[$i] === 'handra@ibstower.com' || $email[$i] === 'farida@ibstower.com') {
				$alias = 'Commitee';
			} else {
				$alias = str_replace('@ibstower.com', '', $email[$i]);
			}

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

	public function saveForm($requestNumber)
	{
		$formData = array(
			'requestNumber' => $requestNumber,
			'formType'      => $this->input->post('formType'),
			'formPurpose'   => $this->input->post('formPurpose'),
			'formNotes'     => $this->input->post('formNotes'),
			'is_status'     => 1,
			'created_by'    => $this->email,
			'created_at'    => $this->date,
		);
		$this->db->insert('form_request', $formData);
		$requestId = $this->db->insert_id();
		return $requestId;
	}

}