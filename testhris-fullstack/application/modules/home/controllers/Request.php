<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('enc');
		$this->enc->check_session();
		$this->load->helper('general_helper');
		$this->email = $this->session->userdata('user_email');
		$this->emp_id = $this->session->userdata('employee_id');
		
		// if ($this->emp_id == '') {
		// 	print_r("You are not authorized to access this apps.");
		// 	exit();
		// }
		
		$this->load->helper('general');
		$this->load->model('form/form_model');
		$this->load->model('inbox/inbox_model');
		$this->load->model('home_model');
		$this->load->model('m_global');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');

		if(empty($this->session->userdata('nik'))){
            $this->session->set_flashdata('failure', 'Login failed');
            redirect('login');
        }
	}

	public function index()
	{
		$data['header'] = $this->home_model->getMyRequest();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		///////////////////////////////////////START UPDATE SOURCE CODE Performance Appraisal 2024////////////////////////////////////////
		$data['header_mdcr'] = $this->home_model->getMyRequestMDCR();
		$data['header_pa'] = $this->home_model->getMyRequestPAList();
		$data['nik'] = $this->session->userdata('nik');
		///////////////////////////////////////END UPDATE SOURCE CODE Performance Appraisal 2024////////////////////////////////////////

		/////////////////////////ADD TIME MANAGEMENT 2024////////////////////////////
		$data['header_tm'] = $this->home_model->getMyRequestTM();
		/////////////////////////END TIME MANAGEMENT 2024////////////////////////////

		$data['header_ec'] = $this->home_model->getMyRequestEC();
		
		foreach ($data['header_ec'] as &$row) {

			$rlStatus = (int) $row['rl_status'];
			$ecStatus = (int) $row['ec_status'];

			if ($ecStatus === 0) {

				switch ($rlStatus) {
					case 0:
						$row['current_step'] = 1;
						$row['status'] = 0;
						break;

					case 1:
						$row['current_step'] = 2;
						$row['status'] = 1;
						break;

					case 2:
						$row['current_step'] = 1;
						$row['status'] = 2;
						break;
					case 3:
						$row['current_step'] = 3;
						$row['status'] = 3;
						break;
					case 4:
						$row['current_step'] = 1;
						$row['status'] = 8;
						break;

					default:
						$row['current_step'] = 1;
						break;
				}

			} else {

				switch ($ecStatus) {
					case 1:
						$row['current_step'] = 4;
						break;

					case 2:
						$row['current_step'] = 5;
						break;

					default:
						$row['current_step'] = 3;
						break;
				}
			}
		}

		unset($row);

		$data['content'] = 'home/list_request';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function view($id,$formType = "")
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		if($formType == ""){

			$formType = 'MDCR';
			$request_id = decode_url($id);
			$header = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
			$detail = $this->m_global->getRow('detail_table', 'form_type', array('code' => $formType));
			$additional = $this->m_global->getRow('additional_table', 'form_type', array('code' => $formType));
			
			$data['header'] = $this->m_global->find($header, 'request_id', $request_id)->row_array();
			$employee_id = $data['header']['employee_id'];
			$data['detail'] = $this->m_global->find($detail, 'request_id', $request_id)->result_array();
			$data['sum_penggantian'] = $this->form_model->get_sum_penggantian($request_id);
			$data['reimaning_pagu'] = $this->form_model->get_reimaning_pagu($employee_id);

			// $request_id = decode_url($id);
			// $data['header'] = $this->m_global->find('id', $request_id, 'performance_appraisal')->row_array();
			// $data['detail'] = $this->m_global->find('request_id', $request_id, 'performance_appraisal_measurement')->result_array();
			// $data['additional'] = $this->m_global->find('request_id', $request_id, 'performance_appraisal_plan')->result_array();
			$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
			$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
			$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
			$data['count_review'] = count($this->inbox_model->getReviewList());
			$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
			$data['formType'] = $this->form_model->getFormType();
			$data['content'] = 'home/form/details';
			$this->templates->show('index', 'templates/eapp/eapp_main', $data);
		}else{
				///////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////
				$request_id = decode_url($id);
				$data['header'] = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array();
				// dumper($data['header']);
				$data['id_form_request'] = $this->db->query("select b.id as id from performance_appraisal as a left join form_request as b on a.request_number = b.request_number where a.id = '$request_id'")->row_array()['id'];
				$form_request_id = getIdFormRequest($data['header']['request_number']);
				// echo $form_request_id;
				// die;
	
				$data['detail'] = $this->m_global->find('performance_appraisal_measurement', 'request_id', $request_id)->result_array();
				$data['training'] = $this->m_global->find('performance_appraisal_training', 'request_id', $request_id)->result_array();
				$data['additional'] = $this->m_global->find('performance_appraisal_plan', 'request_id', $request_id)->result_array();
				$data['approval'] = $this->m_global->find('form_approval', 'request_id', $form_request_id)->result_array();
				$cekApproved = 0;
				foreach($data['approval'] as $key => $val){
					if($val['approval_status'] == "Approved"){
						$cekApproved++;
					}
				}
				if($cekApproved > 0){
					$data['cekApproved'] = 1;
				}else{
					$data['cekApproved'] = 0;
				}
				// die;
				$eval_year = ($data['header']['evaluation_period_start']);
				$division = ($data['header']['division']);
				
				$sql_div = "Select (CASE WHEN is_status is null THEN 0 ELSE is_status END) as is_status_div from performance_division_status where evaluation_period = '".$eval_year."' and division_name = '".$division."'";
				$data_div = $this->db->query($sql_div)->row();
				
				
				if(!empty($data_div)){
					$data['is_status_div'] = $data_div->is_status_div;
				}else{
					$data['is_status_div'] = 0;
				}

				$data['notes']   = $this->m_global->find('request_notes', 'request_id', $data['id_form_request'])->result_array();
				$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
				$data['count_review'] = count($this->inbox_model->getReviewList());
				$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
				$data['formType'] = $this->form_model->getFormType();

				///////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////
				$data['request_number'] = $this->db->query("select b.request_number as id from performance_appraisal as a left join form_request as b on a.request_number = b.request_number where a.id = '$request_id'")->row_array()['id'];
				$data['documentary_evidence'] = $this->m_global->find('performance_appraisal_documentary_evidence', 'request_number', $data['request_number'])->result_array();
				///////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////

				$data['content'] = 'home/form/details_pa';
				$this->templates->show('index', 'templates/eapp/eapp_main', $data);
				///////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////
		}
	}

	public function delete($request_id)
    {
    	$transok = false;
		$form_type = $this->m_global->find('form_request', 'id', $request_id)->row_array()['form_type'];
		$form_number = $this->m_global->find('form_request', 'id', $request_id)->row_array()['request_number'];

		$header_table = $this->m_global->find('form_type', 'code', $form_type)->row_array()['header_table'];
		$detail_table = $this->m_global->find('form_type', 'code', $form_type)->row_array()['detail_table'];
		$additional_table = $this->m_global->find('form_type', 'code', $form_type)->row_array()['additional_table'];
        if ($this->db->where('id', $request_id)->delete('form_request')) {

	    	$this->db->trans_begin();
			if($form_type == 'EC') {
				$this->db->where('id_form_request', $request_id)->delete($header_table);
			}else{
				$this->db->where('request_id', $request_id)->delete($header_table);
				$this->db->where('request_id', $request_id)->delete($detail_table);
				$this->db->where('request_id', $request_id)->delete($additional_table);
			}

        	if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
			    $transok = false;
			    $type = 'system';
			    $desc = 'Failed while deleting draft request.';

			} else {
			    $this->db->trans_commit();
			    $transok = true;
			    $type = 'delete_draft';
			    $desc = 'Success delete draft.';
			}
        }

	    $this->logs($type, $form_type, $request_id, 'Delete Draft', $desc);

			$form_log_request = array(
				'request_id' => $request_id,
				'activity' => 'Delete',
				'desc' => $form_number . ' Deleted',
				'create_at' => $this->date,
				'create_by' => $this->email,
				'type' => 'MDCR',
				'activity_desc' => 'Deleted_by_User'
			);

			

			$this->db->insert('form_logs', $form_log_request);

        if ($transok) {
        	echo json_encode(array('status' => 1));
        } else {
        	echo json_encode(array('status' => 0));
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

			case 'delete_draft':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}


	///////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////

	public function delete_pa($request_id)
    {
    	$transok = false;
		$id_pa = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['id'];
		$request_number = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['request_number'];
		$id_form_request = $this->m_global->find('form_request', 'request_number', $request_number)->row_array()['id'];
		$form_type = $this->m_global->find('form_request', 'request_number', $request_number)->row_array()['form_type'];
		$header_table = $this->m_global->find('form_type', 'code', $form_type)->row_array()['header_table'];
		$detail_table = $this->m_global->find('form_type', 'code', $form_type)->row_array()['detail_table'];
		$additional_table = $this->m_global->find('form_type', 'code', $form_type)->row_array()['additional_table'];
		///////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////
		$documents 	= !empty($this->m_global->find('performance_appraisal_documentary_evidence', 'request_number', $request_number)->row_array()['documents']) ? $this->m_global->find('performance_appraisal_documentary_evidence', 'request_number', $request_number)->row_array()['documents'] : 'empty';
		///////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////
        if ($this->db->where('id', $id_form_request)->delete('form_request')) {

	    	$this->db->trans_begin();
        	$this->db->where('id', $id_pa)->delete($header_table);
        	$this->db->where('request_id', $id_pa)->delete($detail_table);
			$this->db->where('request_id', $id_pa)->delete($additional_table);
			///////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////
			$this->db->where('req_id_pa', $id_pa)->delete('performance_appraisal_qualitative_assesment');
			if($documents != 'empty'){
				$this->db->where('request_number', $request_number)->delete('performance_appraisal_documentary_evidence');
				$file_pointer      = "./assets/documents/documents_pa/$documents";
				unlink($file_pointer);
			}
			///////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////
			$this->db->where('request_number', $request_number)->delete('form_request');
        	if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
			    $transok = false;
			    $type = 'system';
			    $desc = 'Failed while deleting draft request.';

			} else {
			    $this->db->trans_commit();
			    $transok = true;
			    $type = 'delete_draft';
			    $desc = 'Success delete draft.';
			}
        }

	    $this->logs($type, $form_type, $id_form_request, 'Delete Draft', $desc);

        if ($transok) {
        	echo json_encode(array('status' => 1));
        } else {
        	echo json_encode(array('status' => 0));
        }
    }

	///////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////
	public function viewQrRL($request_id)
	{
		$id = decode_url($request_id);
		$resign = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $id)->row_array();
		if (!$resign) {
			show_404();
		}
		$data['request_id'] = $resign['request_id'];
		$data['nama'] = $resign['complete_name'];
		$data['nik'] = $resign['nik'];
		$data['tanggal_submit'] = date('d F Y', strtotime($resign['submitted_at']));
		return $this->load->view('form/exit_clearance/view_qrcode', $data);
	}
}
