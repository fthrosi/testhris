<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_approval extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->email = $this->session->userdata('user_email');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');

		$this->ilink = $this->load->database('db_ilink', TRUE);
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

	public function getMyRequest()
	{
		$this->db->select("id, requestNumber, formType, formPurpose, formNotes, created_by, created_at, is_status");
		$this->db->where("created_by", $this->email);

		// $this->db->where("is_status !=", '3');
		// $this->db->where("is_status !=", '4');

		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('form_request')->result();
	}

	public function getLastApproved($user_email = '')
	{
		$this->db->select("id, requestNumber, formType, formPurpose, formNotes, approvedDate, created_by, created_at, is_status");

		if ($user_email != '') {
			$this->db->where("created_by", $user_email);
		}

		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(5);
		return $this->db->get('form_request')->result_array();
	}

	public function getLastActivity()
	{
		$this->db->select("id, approval_response, request_id, approval_notes, created_at, created_by");
		$this->db->limit(5);
		return $this->db->get('logs')->result_array();
	}

	public function getApprovalList($email)
	{
		$this->db->where('approval_email', $email);
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

	public function getReviewList()
	{
		$review = $this->find_select('id, reviewer, reviewer_notes, review_done, created_by, request_id', array('reviewer' => $this->email, 'is_status' => 1), 'form_reviewer')->result_array();
		$data = array();
		if (!empty($review)) {
			foreach ($review as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}
			$reviewList = implode(",", $list);
			$listForm = $this->getListForm($reviewList, 'review');
			return $listForm;
		} else {
			return $data;
		}
	}

	public function getListForm($listId = '', $flag = '')
	{
		$this->db->select("id, requestNumber, formType, formPurpose, formNotes, created_by, created_at, is_status");
		if (!empty($listId)) {
			$this->db->where("id IN ($listId) ");
		} else {
			$this->db->where("created_by", $this->email);
		}

		$this->db->where("is_status !=", '3');
		// $this->db->where("is_status !=", '4');

		if (!empty($flag)) {
			if ($flag == 'review') {
				$this->db->where("is_status !=", '1');
				$this->db->where("is_status !=", '2');
				$this->db->where("is_status !=", '5');
			}
		}

		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('form_request')->result();
	}

	public function getApprovalNotes($id)
	{
		$this->db->select('approval_notes, approval_response, created_at, created_by');
		$this->db->where('request_id', $id);
		$this->db->where('created_by !=', "system");
		$this->db->where('approval_response !=', 'Add new layer');
		$this->db->where('approval_response !=', 'Delete layer');
		$this->db->where('approval_notes !=', null);
		return $this->db->get('logs');
	}

	public function getArchive()
	{
		// form_approval
		$this->db->select('request_id');
		$this->db->where("approval_email", $this->email);
		$ListApproval = $this->db->get('form_approval')->result_array();

		if (!empty($ListApproval)) {

			foreach ($ListApproval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}

			$approval = implode(",", $list);
			$this->db->select("id, requestNumber, formType, formPurpose, formNotes, created_by, created_at, is_status, deleted_by");
			$this->db->where("id IN ($approval) ");
			$this->db->where('deleted_by', null);
			$result1 = $this->db->get('form_request')->result();
		} else {
			$approval = '';
		}

		// form_request
		$this->db->select("id, requestNumber, formType, formPurpose, formNotes, created_by, created_at, is_status");
		$this->db->where("created_by", $this->email);
		$this->db->where('deleted_by', null);
		$result2 = $this->db->get('form_request')->result();

		if (!empty($result1)) {
			$result = array_merge($result1, $result2);
		} else {
			$result = $result2;
		}

		return $result;
	}

	public function getArchiveEbast()
	{
		$this->ilink->select('ebast_id');
		$this->ilink->where("approval_email", $this->email);
		$this->ilink->where("ebast_id !=", '');
		$ListApproval = $this->ilink->get('ebast_approval')->result_array();

		if (!empty($ListApproval)) {

			foreach ($ListApproval as $key => $value) {
				$reqId = $value['ebast_id'];
				$list[] = $reqId;
			}

			$approval = implode(",", $list);
			$this->ilink->select("a.id, a.request_number, a.milestone_id, a.worktype_id, a.po_number, a.created_by, a.created_at, a.is_status, a.region, a.wbs_id, a.vendor_id, b.name, c.category_name");
			$this->ilink->where("a.id IN ($approval)");
			// $this->ilink->where("a.is_status", "3");
			$this->ilink->where('a.deleted_by', null);
			$this->ilink->join('master_milestone b', 'a.milestone_id = b.id');
			$this->ilink->join('master_worktype c', 'a.worktype_id = c.id');
			$result = $this->ilink->get('ebast a')->result();
		} else {
			$approval = '';
		}

		return $result;
	}

	public function getAllEbast()
	{
		$this->ilink->select("a.id, a.request_number, a.milestone_id, a.worktype_id, a.po_number, a.created_by, a.created_at, a.is_status, a.region, a.wbs_id, a.vendor_id, b.name, c.category_name");
		$this->ilink->where("a.is_status !=", "1");
		$this->ilink->where('a.deleted_by', null);
		$this->ilink->join('master_milestone b', 'a.milestone_id = b.id');
		$this->ilink->join('master_worktype c', 'a.worktype_id = c.id');
		$result = $this->ilink->get('ebast a')->result();

		return $result;
	}

	public function getOneById($field, $table, $where = null)
	{
		return $this->db->select($field)->where($where)->get($table)->row_array()[$field];
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

	public function checkApproval($id, $email)
	{
		return $this->db->get_where('form_approval', array('request_id' => $id, 'approval_email' => $email))->row_array();
	}

	public function updateApproval($approval_id, $approval_priority, $approval_status, $email, $requestId)
	{
		$transok = false;
		$count = count($email);
		$log = array('request_id' => $requestId, 'created_at' => $this->date, 'created_by' => $this->email, 'approval_response' => 'Change Approval List');

		# check approval layer
		$sql = "SELECT TOP 1 approval_priority, approval_status FROM form_approval WHERE approval_priority < '$approval_priority' AND request_id = '$requestId'";
		$checkbefore = $this->db->query($sql);

		switch ($approval_status) {

			case 'In Progress':

				if ($count == 0) {

					if ($checkbefore->num_rows() > 0 && $checkbefore->row_array()['approval_status'] == 'Approved') {

						if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >=' => $approval_priority))) {
							if ($this->db->where('id', $requestId)->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
								$this->db->insert('logs', $log);
								$transok = true;
							}
						}
					}

				} else {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >=' => $approval_priority))) {

						for ($i = 0; $i < $count; $i++) {

							if ($email[$i] === 'handra@ibstower.com' || $email[$i] === 'farida@ibstower.com') {
								$alias = 'Commitee';
							} else {
								$alias = $email[$i];
							}

							$app_status = ($i == 0) ? 'In Progress' : '';

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

						if ($this->db->insert_batch($this->tableApproval, $layer)) {
							if ($this->db->where('id', $requestId)->update('form_request', array('is_status' => 1, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
								$this->db->insert('logs', $log);
								$transok = true;
							}
						}
					}

				}

				break;

			case 'Approved':

				if ($count == 0) {

					$transok = true;
					
				} else {

					for ($i = 0; $i < $count; $i++) {

						$approval_priority++;

						if ($email[$i] === 'handra@ibstower.com' || $email[$i] === 'farida@ibstower.com') {
							$alias = 'Commitee';
						} else {
							$alias = $email[$i];
						}

						$app_status = ($i == 0) ? 'In Progress' : '';

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
					}

					if ($this->db->insert_batch($this->tableApproval, $layer)) {
						if ($this->db->where('id', $requestId)->update('form_request', array('is_status' => 1, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
							$this->db->insert('logs', $log);
							$transok = true;
						}
					}
				}

				break;

			case 'Revise':

				if ($count == 0) {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {

						for ($i = 0; $i < $count; $i++) {

							$approval_priority++;

							if ($email[$i] === 'handra@ibstower.com' || $email[$i] === 'farida@ibstower.com') {
								$alias = 'Commitee';
							} else {
								$alias = $email[$i];
							}

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

						if ($this->db->insert_batch($this->tableApproval, $layer)) {
							$this->db->insert('logs', $log);
							$transok = true;
						}
					}
				}

				break;

			case 'Hold':

				if ($count == 0) {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {

						for ($i = 0; $i < $count; $i++) {

							$approval_priority++;

							if ($email[$i] === 'handra@ibstower.com' || $email[$i] === 'farida@ibstower.com') {
								$alias = 'Commitee';
							} else {
								$alias = $email[$i];
							}

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

						if ($this->db->insert_batch($this->tableApproval, $layer)) {
							$this->db->insert('logs', $log);
							$transok = true;
						}
					}
				}

				break;

			case 'Review':

				if ($count == 0) {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >' => $approval_priority))) {

						for ($i = 0; $i < $count; $i++) {

							$approval_priority++;

							if ($email[$i] === 'handra@ibstower.com' || $email[$i] === 'farida@ibstower.com') {
								$alias = 'Commitee';
							} else {
								$alias = $email[$i];
							}

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

						if ($this->db->insert_batch($this->tableApproval, $layer)) {
							$this->db->insert('logs', $log);
							$transok = true;
						}
					}
				}

				break;

			case 'Canceled':

				if ($count == 0) {

					if ($checkbefore->num_rows() > 0 && $checkbefore->row_array()['approval_status'] == 'Approved') {

						if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >=' => $approval_priority))) {
							if ($this->db->where('id', $requestId)->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
								$this->db->insert('logs', $log);
								$transok = true;
							}
						}
					}
				} else {

					if ($this->db->delete('form_approval', array('request_id' => $requestId, 'approval_priority >=' => $approval_priority))) {

						for ($i = 0; $i < $count; $i++) {

							if ($email[$i] === 'handra@ibstower.com' || $email[$i] === 'farida@ibstower.com') {
								$alias = 'Commitee';
							} else {
								$alias = $email[$i];
							}

							$app_status = ($i == 0) ? 'Canceled by requestor' : '';

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

						if ($this->db->insert_batch($this->tableApproval, $layer)) {
							$this->db->insert('logs', $log);
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

	public function addLayer($approval_priority, $approval_status, $email, $requestId)
	{
		$transok = false;
		$priority = $approval_priority + 1;
		$log = array('request_id' => $requestId, 'created_at' => $this->date, 'created_by' => $this->email, 'approval_notes' => 'Add '.$email.' as new layer successsfully', 'approval_response' => 'Add new layer');

		if ($email === 'handra@ibstower.com' || $email === 'farida@ibstower.com') {
			$alias = 'Commitee';
		} else {
			$alias = str_replace('@ibstower.com', '', $email);
		}

		switch ($approval_status) {

			case 'empty':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => '',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {
					$this->db->insert('logs', $log);
					return true;
				} else {
					return false;
				}

				break;

			case 'In Progress':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => '',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {
					$this->db->insert('logs', $log);
					return true;
				} else {
					return false;
				}

				break;

			case 'Hold':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => '',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {
					$this->db->insert('logs', $log);
					return true;
				} else {
					return false;
				}

				break;

			case 'Revised':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => '',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {
					$this->db->insert('logs', $log);
					return true;
				} else {
					return false;
				}

				break;

			case 'Rejected':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => '',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {
					$this->db->insert('logs', $log);
					return true;
				} else {
					return false;
				}

				break;

			case 'Canceled':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => '',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {
					$this->db->insert('logs', $log);
					return true;
				} else {
					return false;
				}

				break;

			case 'Review':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => '',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {
					$this->db->insert('logs', $log);
					return true;
				} else {
					return false;
				}

				break;

			case 'Approved':

				$new_layer = array(
					'request_id' => $requestId,
					'approval_priority' => $priority,
					'approval_status' => 'In Progress',
					'approval_email' => $email,
					'approval_alias' => $alias,
					'approval_note' => '',
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				if ($this->db->insert('form_approval', $new_layer)) {

					if ($this->db->where('id', $requestId)->update('form_request', array('is_status' => 1, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
					
				} else {
					return false;
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

	public function removeLayer($request_id, $selected_approval_id, $selected_approval_email, $selected_approval_priority, $selected_approval_status)
	{
		$transok = false;
		$log = array('request_id' => $request_id, 'created_at' => $this->date, 'created_by' => $this->email, 'approval_notes' => 'Delete ' . $selected_approval_email . ' as layer successsfully', 'approval_response' => 'Delete layer');
		
		# check previous approval status 
		$sql = "SELECT TOP 1 approval_status FROM form_approval WHERE approval_priority < '$selected_approval_priority' AND request_id = '$request_id' ORDER BY approval_priority DESC";
		$prev_layer = $this->db->query($sql)->row_array();
		$prev_status = $prev_layer['approval_status'];

		if (empty($prev_status)) {
			$prev_status = 'empty';
		} 

		# count next layer 
		$sql = "SELECT id, approval_priority FROM form_approval WHERE approval_priority > '$selected_approval_priority' AND request_id = '$request_id'";
		$next_layer = $this->db->query($sql)->result_array();
		$count = count($next_layer);

		switch ($prev_status) {

			case 'empty':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {
							
							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1; 
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}

				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						$this->db->insert('logs', $log);
						$transok = true;
					} 
				}

				break;

			case 'Revised':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {

							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1;
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				}

				break;

			case 'Rejected':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {

							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1;
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				}

				break;

			case 'Hold':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {

							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1;
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				}

				break;

			case 'Review':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {

							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1;
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				}

				break;

			case 'Canceled':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {

							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1;
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				}

				break;

			case 'In Progress':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {

							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1;
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						$this->db->insert('logs', $log);
						$transok = true;
					}
				}

				break;

			case 'Approved':

				if ($count > 0) {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						for ($i = 0; $i < $count; $i++) {

							$next_priority = $next_layer[$i]['approval_priority'];
							$new_priority = $next_priority - 1;
							$this->db->where('id', $next_layer[$i]['id'])->update('form_approval', array('approval_priority' => $new_priority));
						}
						$this->db->insert('logs', $log);
						$transok = true;
					}
				} else {

					if ($this->db->delete('form_approval', array('id' => $selected_approval_id))) {
						if ($this->db->where('id', $request_id)->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
							$this->db->insert('logs', $log);
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

}