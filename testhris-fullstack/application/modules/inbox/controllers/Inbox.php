<?php
defined('BASEPATH') or exit('No direct script access allowed');
	require '/var/www/html/application/vendor/phpmailer/phpmailer/src/Exception.php';
	require '/var/www/html/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require '/var/www/html/application/vendor/phpmailer/phpmailer/src/SMTP.php';
	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/Exception.php';
	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/SMTP.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

class Inbox extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('enc');
		$this->enc->check_session();

		$this->email = $this->session->userdata('user_email');
		$this->division = $this->session->userdata('division');
		$this->second_division = $this->session->userdata('second_division');
		$this->emp_id = $this->session->userdata('employee_id');
		$this->nik = $this->session->userdata('employee_id');
		$this->roles = $this->session->userdata('exit_clearance_roles');

		$this->status_apps = $_ENV['CI_ENVIRONMENT'];

		if ($this->emp_id == '') {
			print_r("You are not authorized to access this apps.");
			exit();
		}
		
		$this->load->helper('general');
		$this->load->model('inbox_model');
		$this->load->model('form/form_model');
		$this->load->model('home/home_model');
		$this->load->model('m_global');
		$this->load->model('services/m_services');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function index()
	{
		print_r('Please go back to ibsapps.');die;
	}

	public function approval()
	{
		$data['header'] = $this->inbox_model->getApprovalList();
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
		$data['content'] = 'inbox/list_approval';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function approval_resignation_letter()
	{
		$revised = [];
		$approved = [];
		$allData = $this->inbox_model->get_list_ec_approval();
		$result = [];
		$cek = [];
		foreach ($allData as $row) {
			$key = $row['request_number'];

			if (!isset($result[$key])) {
				$result[$key] = [
					'id'                   => $row['id'],
					'request_number'       => $row['request_number'],
					'complete_name'        => $row['complete_name'],
					'employee_id' 		=> $row['employee_id'],
					'status_resign'    		=> null,
					'status_exit'    		=> null
				];
			}
			$status = (int)$row['status_step'] === 0 ? 1 : ((int)$row['status_step'] === 1 ? 3 : ((int)$row['status_step'] === 2 ? 2 : 8));

			if ($row['approval_type'] == 'RESIGNATION_LETTER') {
				$result[$key]['status_resign'] = $status;
			}

			if ($row['approval_type'] == 'EXIT_CLEARANCE') {
				$result[$key]['status_exit'] = $status;
			}
		}
		foreach($result as $key) {
			if(!$key['status_exit']){
				switch ((int)$key['status_resign']){
					case 1:
						$cek[] = $key;
						break;
					case 2:
						$revised[] = $key;
						break;
					case 3:
						$approved[] = $key;
						break;
				}
			}else{
				switch ((int)$key['status_exit']){
					case 1:
						$cek[] = $key;
						break;
					case 2:
						$revised[] = $key;
						break;
					case 3:
						$approved[] = $key;
						break;
				}
			}
		}
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['header_ec_cek'] = $cek;
		$data['header_ec_rejected'] = $revised;
		$data['header_ec_approved'] = $approved;
		$data['formType'] = $this->form_model->getFormType();
		//start update 2026
		$data['nik_user'] = $this->nik;
		//end update 2026
		$data['content'] = 'inbox/list_approval_resignation_letter';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}
	public function do_approval_resignation_letter()
	{
		$id = $this->input->post('id');
		$notes = $this->input->post('notes');
		$status = $this->input->post('status');
		$resignation_letters = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $id)->row_array();
		$form = $this->m_global->find('form_request', 'id', $resignation_letters['id_form_request'])->row_array();
		if(empty($resignation_letters) || empty($form)){
			$response = [
				'status' => false,
				'message' => 'Approval Failed. Data not found.',
			];
			return $this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode($response));
		}
		$approval = $this->inbox_model->approved($form['id'],'RESIGNATION_LETTER', $status, $notes);
		if($approval === false){
			$response = [
				'status' => false,
				'message' => 'Approval Failed.',
			];
			return $this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode($response));
		}
		$response = [
			'status' => true,
			'message' => 'Approval Success.',
		];
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($response));
		
	}

	public function addNote()
	{
		$id = $this->input->post('id');
		$notes = $this->input->post('notes');
		$add = $this->inbox_model->addNote($id, "Resignation Letter", $notes);
		if($add === false){
			$response = [
				'status' => false,
				'message' => 'Add Note Failed.',
			];
			$status_code = 400;
		}else{
			$response = [
				'status' => true,
				'message' => 'Add Note Success.',
			];
			$status_code = 200;
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header($status_code)
			->set_output(json_encode($response));
	}
	public function detail_req_resignation_letter($id)
	{
		$id = decode_url($id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $id)->row_array();
		if(empty($data['form_request'])){
			print_r('Request not found');die;
		}
		$data['header'] = $this->m_global->find('exit_clearance', 'id_form_request', $id)->row_array();
		if(empty($data['header'])){
			print_r('Exit clearance not found');die;
		}
		$employee = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		$approver = $this->inbox_model->getApproverResignation($id);
		$data['employee'] = array(
			'complete_name' => decrypt($employee[0]->complete_name),
			'position' => decrypt($employee[0]->position),
			'nik' => $employee[0]->nik,
			'email' => decrypt($employee[0]->email)
		);
		$resignation_letter = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $id)->row_array();
		$status_approve = (int) $resignation_letter['status'] === 1 ? "In Progress" : ((int) $resignation_letter['status'] === 2 ? "Revised" : ((int) $resignation_letter['status'] === 3 ? "Approved" : "Cancelled by User"));
		
		$data['approval'] = [[
			'layer' => $approver[0]['sequence'],
			'complete_name' => decrypt($approver[0]['complete_name']),
			'email' => decrypt($approver[0]['email']),
			'status' => $status_approve,
			'acted_at' => $approver[0]['acted_at'],
		]];
		$data['roles'] = $this->roles;
		// dumper($data['roles']);
		$data['resignation_letter'] = $this->m_global->find('exit_clearance_resignation_letters', 'id_form_request', $id)->row_array();
			$status_resign = $data['resignation_letter']['status'];
			$status_exit = $data['header']['status'];
			if($status_exit == 0){
				$data['current_step'] = (int) $status_resign === 0 ? 1 : ((int) $status_resign === 1 ? 2 : ((int) $status_resign === 2 ? 1 : ((int)$status_resign === 3 ? 3 : 1)));
			}else{
				$data['current_step'] = (int) $status_exit === 1 ? 4 : ((int) $status_exit === 2 ? 5 : 3);
			}
		$data['reason'] = $this->form_model->getReason($data['resignation_letter']['id'], "Resignation Letter");
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['content'] = 'form/exit_clearance/layout_ec';
		$data['main'] = 'inbox/detail_approval_resignation_letter';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);

	}
	
	public function approval_mdcr()
	{
		$data['header'] = $this->inbox_model->getApprovalList();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['header_mdcr_after_cek'] = $this->inbox_model->getApprovalListMDCRAfterCek();
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();

		// $data['header_mdcr_cek'] = $this->inbox_model->getApprovalListMDCRCek();
		// dumper($data['header_mdcr_after_cek']);
		// $data['header_mdcr_after_grouping'] = $this->inbox_model->getApprovalListMDCRAfterGrouping();
		// $data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		// $data['header_mdcr_revised'] = $this->inbox_model->getApprovalListMDCRRevised();
		// $data['header_mdcr_approved'] = $this->inbox_model->getApprovalListMDCRApproved();
		// dumper($data['header_mdcr_approved']);
		// $data['header_mdcr_rejected'] = $this->inbox_model->getApprovalListMDCRRejected();

		$data['content'] = 'inbox/list_approval_mdcr';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}
	
	public function approval_mdcr_to_fi()
	{
		$data['header'] = $this->inbox_model->getApprovalList();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();

		// $data['header_mdcr_after_grouping'] = $this->inbox_model->getApprovalListMDCRAfterGrouping();
		// $data['header_mdcr_revised'] = $this->inbox_model->getApprovalListMDCRRevised();
		// $data['header_mdcr_approved'] = $this->inbox_model->getApprovalListMDCRApproved();
		// $data['header_mdcr_rejected'] = $this->inbox_model->getApprovalListMDCRRejected();
		// $data['header_mdcr_cek'] = $this->inbox_model->getApprovalListMDCRCek();
		// $data['header_mdcr_after_cek'] = $this->inbox_model->getApprovalListMDCRAfterCek();

		$data['content'] = 'inbox/list_approval_mdcr_to_fi';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function pa_management($year="")
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '2') && ($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		
		// $year = $this->input->post('periodpasearch') !== NULL ? $this->input->post('periodpasearch') != "" ? $this->input->post('periodpasearch') : "" : "";
		if($year == ""){
			$year = $this->year - 1;
		}

		$data['year'] = $year;
		$data['header'] = $this->inbox_model->getPAList($year);
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/list_pa_approved';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function review()
	{
		$data['header'] = $this->inbox_model->getReviewList();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/list_approval';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	// public function read()
    // {
    // 	$year = $this->year - 1;
	// 	$eval_year = $year.'-01-01';

	// 	$listForm = $this->inbox_model->getDivHeadListByDivision($this->session->userdata('division'),$eval_year);

	// 	$division_status = $this->db->get_where('performance_division_status', array('division_name' => $this->session->userdata('division'), 'evaluation_period' => $eval_year))->row_array()['is_status'];
       
    //     if (!empty($listForm)) {
    //         foreach ($listForm as $key) {

    //         	$count_layer = $this->db->get_where('form_approval', array('request_id' => $key->id))->num_rows();
    //         	$approval_priority = $this->db->get_where('form_approval', array('request_id' => $key->id, 'approval_email' => $this->email))->row_array()['approval_priority'];

    //         	$show = ($count_layer == $approval_priority) ? '' : 'none';

    //             $row   = array();
    //             $row[] = $key->employee_nik;
    //             $row[] = $key->employee_name;
    //             $row[] = $key->division;
    //             $row[] = $key->departement;
    //             $row[] = $key->position;
    //             $row[] = $key->direct_manager;
    //             $row[] = $key->office_location;
    //             $row[] = $key->join_date;
    //             $row[] = $key->employment_status;
    //             $row[] = $key->final_score;
    //             $row[] = grade_pa(decrypt($key->final_score));
    //             $row[] = status_text($key->is_status);
    //             $row[] = $key->full_approved_date;
    //             $row[] = $key->request_number;

    //             if ($division_status == 1 || $division_status == 3) {
    //             	$row[] = '';
    //             } else {
    //             	$row[] = '<div class="btn-group btn-group-sm" style="display:'.$show.'">
    //                         <a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickView(this.id)">
    //                             <em class="icon ni ni-edit"></em>
    //                         </a>
    //                 	</div>';
    //             }

    //             $data[] = $row;
    //         }
    //         $output = array('data' => $data);
    //     } else {
    //         $output = array('data' => new ArrayObject());
    //     }

    //     echo json_encode($output);
    // }

    public function hr_view_details($id)
	{
		$request_id = decode_url($id);
		$data['header'] = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array();
		$data['id_form_request'] = $this->db->query("select b.id as id from performance_appraisal as a left join form_request as b on a.request_number = b.request_number where a.id = '$request_id'")->row_array()['id'];
		$data['eval_year'] = $this->db->query("select YEAR(evaluation_period_start) as eval_year from performance_appraisal where id = '$request_id'")->row_array()['eval_year'];
		$data['training'] = $this->m_global->find('performance_appraisal_training', 'request_id', $request_id)->result_array();
		$id_form_request = $this->m_global->find('form_request', 'request_number', $data['header']['request_number'])->row_array()['id'];
		$data['detail'] = $this->m_global->find('performance_appraisal_measurement', 'request_id', $request_id)->result_array();
		$data['additional'] = $this->m_global->find('performance_appraisal_plan', 'request_id', $request_id)->result_array();
		// $data['employee'] = $this->m_global->find('id', $data['header']['employee_id'], 'employee')->row_array();
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $data['id_form_request'])->result_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $id_form_request)->result_array();
		$data['approval_id'] = $this->inbox_model->find_select("id", 'form_approval', array('request_id' => $id_form_request, 'approval_email' => $this->email))->row_array();
		
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/form/hr_view_details';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

    public function read_hr_confirmed($periodpa)
    {
    	// $year = $this->year - 1;
    	$year = $periodpa;
		$eval_year = $year.'-01-01';

		$listForm = $this->inbox_model->getHRConfirmed($year);
		// dumper($listForm);
        if (!empty($listForm)) {
            foreach ($listForm as $key) {
				if(substr($key->request_number,5,4) == "PLAN"){
					$type = 'PLAN';
				}elseif (substr($key->request_number,5,3) == "KPI") {
					$type = 'KPI';
				}
                $row   = array();
                $row[] = $key->employee_nik;
                $row[] = decrypt($key->employee_name);
                $row[] = decrypt($key->division);
                $row[] = decrypt($key->departement);
                $row[] = decrypt($key->position);
                $row[] = decrypt($key->direct_manager);
                $row[] = decrypt($key->office_location);
                $row[] = $key->join_date;
                $row[] = decrypt($key->employment_status);
                $row[] = decrypt($key->final_score);
                $row[] = grade_pa(decrypt($key->final_score));
                $row[] = $type;
                $row[] = status_text($key->is_status);
                $row[] = $key->full_approved_date;
                $row[] = $key->request_number;
                $row[] = decrypt($key->area_improvement);
                $row[] = decrypt($key->development_plan);
                $row[] = '<div class="btn-group btn-group-sm">
                            <a href="' . base_url('inbox/hr_view_details/' . encode_url($key->id)) . '" class="btn btn-icon btn-trigger">
                                <em class="icon ni ni-eye"></em>
                            </a>
                    	</div> <div class="btn-group btn-group-sm">
                            <a target="_blank" href="' . site_url('services/generate/result_document/kpi/'.encode_url($key->id)).'/'.$key->request_number.'" class="btn btn-icon btn-trigger"><em class="icon ni ni-printer"></em>
                            </a>
                    	</div>';

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }
		// print_r($output);
        echo json_encode($output);
    }

	public function view($id)
	{
		$request_id = decode_url($id);
		$data['header'] = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array();
		$data['detail'] = $this->m_global->find('performance_appraisal_measurement', 'request_id', $request_id)->result_array();
		$data['additional'] = $this->m_global->find('performance_appraisal_plan', 'request_id', $request_id)->result_array();
		$data['employee'] = $this->m_global->find('employee', 'id', $data['header']['employee_id'])->row_array();
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['approval_id'] = $this->inbox_model->find_select("id", 'form_approval', array('request_id' => $request_id, 'approval_email' => $this->email))->row_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/form/details';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hrd()
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['header'] = $this->inbox_model->getPAList();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/hr_summary';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}


	public function responseRequest()
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');

		
		$sql = "select id,is_status from form_request where id='$request_id' and is_status_admin_hr='1'"; //penambahan pencarian field is_status untuk cek status dokumen.
		$query = $this->db->query($sql);
		$res = $query->result();
		$request_id_form 	= (!empty(($res[0]->id))) ? ($res[0]->id) : 0;
		$request_is_status = (!empty(($res[0]->is_status))) ? ($res[0]->is_status) : 0; /// PENAMBAHAN PENGECEKAN STATUS FORM sudah approved atau masih checked.
		if($request_id_form == 0){
			//////////////////////////////////// START TIME MANAGEMENT 2024 /////////////////////////////////////////
			$form_type = $this->m_global->find('form_request', 'id', $request_id)->row_array()['form_type'];
			$status = $this->m_global->find('form_request', 'id', $request_id)->row_array()['is_status'];
			if ($form_type == 'TM' AND $status == 3){
				$sql = "select id from form_approval where request_id='$request_id' and approval_status='Approved'";
			} elseif ($form_type == 'MDCR' AND $status == 2){
				$sql = "select id from form_approval where request_id='$request_id' and approval_status='Revised'";
			} else {
				$sql = "select id from form_approval where request_id='$request_id' and approval_status='In Progress'";
			}
			//////////////////////////////////// END TIME MANAGEMENT 2024 /////////////////////////////////////////
			// $sql = "select id from form_approval where request_id='$request_id' and approval_status='In Progress'";
			$query = $this->db->query($sql);
			$res = $query->result();
			$approval_id = $res[0]->id;
		}else{

			if ($request_is_status != 0) {
				if ($request_is_status == 1) {
					$is_status = 'In Progress';
				} else {
					$is_status = 'Approved';
				}
			} else {
				$is_status = 'Approved';
			}
			
			$sql = "select id from form_approval where request_id='$request_id' and approval_status='$is_status' and approval_email='hr.support@ibsmulti.com'";
			$query = $this->db->query($sql);
			$res = $query->result();
			if ($res == null || $res == '') {
				$approval_id = '';
			} else {
				$approval_id = $res[0]->id;
			}
		}
		$response = $this->input->post('resp');

		// previous layer
		$priority = $this->m_global->find('form_approval', 'id', $approval_id)->row_array()['approval_priority'];
		// dumper($priority);
		$prev_priority = $priority-1;
		$prev_id = $this->inbox_model->find_select("id",'form_approval' ,array('approval_priority'=>$prev_priority,'request_id'=>$request_id))->row_array();

		$prev_email = $this->inbox_model->find_select("approval_email",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$request_id))->row_array();

		$data_prev_layer = array(
			'approval_status' => 'In Progress', 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);
		// dumper($prev_id);

		///////////////////// START GET FORM TYPE 2024 TIME MANAGEMENT///////////////////////////////
		$sqlForm = "SELECT form_type, request_number FROM form_request WHERE id = '$request_id'";
		$queryForm = $this->db->query($sqlForm);
		$resForm = $queryForm->result();
		$tipe_form = $resForm[0]->form_type;
		///////////////////// END GET FORM TYPE 2024 TIME MANAGEMENT///////////////////////////////
		switch ($response) {

			case 'Revised':
				$data['form_approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->row_array();

				if ($this->email == 'HR.SUPPORT@IBSMULTI.COM') {
					$form_log_request = array(
						'request_id' => $request_id,
						'activity' => 'Revise',
						'desc' =>  $resForm[0]->request_number . ' Revised',
						'create_at' => $this->date,
						'create_by' => $this->email,
						'type' => 'MDCR',
						'activity_desc' => 'Revised_by_HR'
					);

					$this->db->insert('form_logs', $form_log_request);
				} else {
					$form_log_request = array(
						'request_id' => $request_id,
						'activity' => 'Revise',
						'desc' => $resForm[0]->request_number . ' Revised',
						'create_at' => $this->date,
						'create_by' => $this->email,
						'type' => 'MDCR',
						'activity_desc' => 'Revised_by_Superior'
					);

					// dumper($form_log_request);

					$this->db->insert('form_logs', $form_log_request);
				}

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
								$data['form_approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->row_array();
								$this->sendEmail('revised_mdcr', $request_id, decrypt($data['data_employee'][0]->email));

								$this->logs('revised', 'MDCR', $request_id, 'Response revised', 'Success');
								$output = array('status' => 1);
							}
						}

					}else{
						// dumper($request_id);
						$current_layer = array(
							'approval_status' => 'Revised', 
							'updated_at' => $this->date, 
							'updated_by' => $this->email
						);

						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $current_layer)) {
							$sql2 = "select id, request_number, form_type, is_status, no_req_mdcr, is_status_admin_hr, is_status_divhead_hr, revise from form_request where id='$request_id' ";
							$query = $this->db->query($sql2);
							$res2 = $query->result();

							// $this->db->where('request_id', $request_id);
							// $this->db->update('request_notes', array('is_status' => null));
							if ($res2[0]->no_req_mdcr != null) {
								$old_no_req_mdcr = $res2[0]->no_req_mdcr;
								$data_revise_layer = array(
									'no_req_mdcr' => null,
									'is_status_admin_hr' => 0, 
									'is_status_divhead_hr' => null, 
									'revise_after_f1' => 1,
									'revise' => ($res2[0]->revise == null ? 1 : $res2[0]->revise++),
									'is_status' => 2, 
									'updated_at' => $this->date, 
									'updated_by' => $this->email
								);								
							} else {
								$data_revise_layer = array(
									'is_status_admin_hr' => 0, 
									'is_status' => 2,
									'revise' => ($res2[0]->revise == null ? 1 : $res2[0]->revise++), 
									'updated_at' => $this->date, 
									'updated_by' => $this->email
								);
							}
							
							$this->db->where('id', $request_id);
							if ($this->db->update('form_request', $data_revise_layer)) {

								$this->db->where('request_id', $request_id);
								$this->db->update('hris_medical_reimbursment', array('is_status' => 2));

								$sql3 = "select * from form_request where no_req_mdcr='$old_no_req_mdcr' ";
								$query = $this->db->query($sql3);
								$res3 = $query->result();

								if ($res3 == null) {
									$this->db->where('no_req_mdcr', $old_no_req_mdcr);
									$this->db->update('hris_no_req_mdcr', array('is_status' => 4));
								} 
								
								$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
								$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
								$data['form_approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->row_array();
								$this->sendEmail('revised_mdcr', $request_id, decrypt($data['data_employee'][0]->email));

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

							$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
							$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
							$data['form_approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->row_array();
							$this->sendEmail('revised_mdcr', $request_id, decrypt($data['data_employee'][0]->email));

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
						////////////////////////////// TIME MANAGEMENT - TIME OFF 2024//////////////////

						if($tipe_form == 'TM'){
							
							$sqlUpdate = "UPDATE hris_request_time_off SET status=2 where request_id = '$request_id'";
							$queryUpdate = $this->db->query($sqlUpdate);

							$sqlGetDate = "SELECT a.nik, a.start_date, a.end_date, a.request_number, b.kode, a.jenis FROM hris_request_time_off a
											LEFT JOIN hris_master_time_off b ON a.jenis = b.nama WHERE a.request_id = '$request_id'";
							$queryGetDate = $this->db->query($sqlGetDate);
							$resultGetDate = $queryGetDate->result_array();
							
							if(!empty($resultGetDate)){
								$this->db->select('nama');
								$this->db->from('hris_master_time_off');
								$this->db->where('kode', 'CTAB');
								$resultCTAB = $this->db->get()->result_array();
								$ctab = $resultCTAB[0]['nama'];

								$nik = $resultGetDate[0]['nik'];
								$request_number = $resultGetDate[0]['request_number'];
								$start_date = $resultGetDate[0]['start_date'];
								$end_date = $resultGetDate[0]['end_date'];
								

								$this->db->select('*');
								$this->db->from('hris_master_time_management');
								$this->db->where('employee_id', $nik);
								$this->db->where('date', $start_date);
								$get_attendance = $this->db->get()->result_array();
								$check_in = $get_attendance[0]['check_in'];
								$check_out = $get_attendance[0]['check_out'];
								$check_in_date = $get_attendance[0]['check_in_date'];
								$check_out_date = $get_attendance[0]['check_out_date'];
								$check_in_location = $get_attendance[0]['check_in_location'];

								/* menentukan kode */
								if ($resultGetDate[0]['jenis'] == 'Cuti Tahunan Setengah Hari') {
									$kode   = 'CT';
									$kode_h = 'CT_Half';
								} else {
									$kode   = $resultGetDate[0]['kode'];
									$kode_h = '';
								}
								
								if (empty($check_in_location) || $check_in_location == NULL){
									$attendance_code = 'CTAB';
									$flag = 1;
									$sentence = ", check_in = NULL, check_out = NULL, working_hours_d = '0.00', working_hours_t = '00:00:00', attendance_status = 'absent'";
								} else {
									$flag = 0;
									if (empty($check_out)){

										$attendance_code = 'CTAB';
										$flag = 0;
										$sentence = ", check_out = NULL, working_hours_d = '0.00', working_hours_t = '00:00:00', attendance_status = 'absent'";
										
									} else {

										$attendance_code 	= '';
										$flag       		= 0;
										if ($kode == 'S' && (!empty($check_in)) && (!empty($check_out))) {

											$working_hours_d = $this->workingHoursD(
												$check_in_date.' '.$check_in,
												$check_out_date.' '.$check_out
											);
											$working_hours_t = $this->workingHoursT(
												$check_in_date.' '.$check_in,
												$check_out_date.' '.$check_out
											);
											
											
											$sentence = ", working_hours_d='$working_hours_d', working_hours_t = '$working_hours_t'";
											
										}elseif($kode == 'CT' && $kode_h == 'CT_Half' && (!empty($check_in)) && (!empty($check_out))) {
												
											$working_hours_d = $this->workingHoursD(
												$check_in_date.' '.$check_in,
												$check_out_date.' '.$check_out
											);
											$working_hours_t = $this->workingHoursT(
												$check_in_date.' '.$check_in,
												$check_out_date.' '.$check_out
											);

											
											$working_hours_d = $working_hours_d;
											$working_hours_t = $working_hours_t;
											$sentence = ", working_hours_d='$working_hours_d', working_hours_t = '$working_hours_t'";

										}else{

											$sentence = ", working_hours_d = '0.00', working_hours_t = '00:00:00', attendance_status = 'absent'";

										}
									}

								}

								

								$sqlGetDateDiff = "SELECT * FROM hris_master_time_management WHERE employee_id='$nik'
								AND (date BETWEEN '$start_date' AND '$end_date')
								AND schedule_code = 'DON'
								AND (time_off_code IS NOT NULL OR time_off_code != '')";
								$queryGetDateDiff = $this->db->query($sqlGetDateDiff);
								$resultGetDateDiff = $queryGetDateDiff->result_array();
								$date_diff = count($resultGetDateDiff);

								

								$sqlUpdateMTM = "UPDATE hris_master_time_management SET attendence_code='$attendance_code', time_off_code=NULL, flag=$flag ".$sentence."
												WHERE employee_id='$nik' AND (date BETWEEN '$start_date' AND '$end_date')";
								$queryUpdateMTM = $this->db->query($sqlUpdateMTM);

								$today = date('Y-m-d');
								$sqlUpdateTME = "UPDATE hris_time_management_employee SET status=1, update_date='$today', flag=0 
												WHERE nik='$nik' AND tipe_perubahan = '$ctab' AND date = '$start_date'";
								$queryUpdateTME = $this->db->query($sqlUpdateTME);

								$this->db->where('nik', $nik);
								$this->db->where('request_number', $request_number);
								$this->db->update('hris_time_management_employee', array('status' => 5));

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

								if(!empty($resultApprovedData)){
									$newTotal = $resultTotal[0]['total_cuti'] - $resultApprovedData[0]['change_log'] - $date_diff;
									$today = date("Y-m-d");
									$change = abs($resultApprovedData[0]['change_log']) - $date_diff;
								}else{
									$newTotal = $resultTotal[0]['total_cuti'] - $resultChangeLog[0]['change_log'] - $date_diff;
									$today = date("Y-m-d");
									$change = abs($resultChangeLog[0]['change_log']);
								}

							} else {
								$newTotal = $resultTotal[0]['total_cuti'] - $resultChangeLog[0]['change_log'] - $date_diff;
								$today = date("Y-m-d");
								$change = abs($resultChangeLog[0]['change_log']) - $date_diff;
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
								'change_log' =>  -1 * abs($change),
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

							$this->sendEmailTM('rejected_time_off', $request_id, '');

							$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1, 'tipe_form' => $tipe_form);

							//////////////////////////END TIME MANAGEMENT 2024////////////////////

						}elseif($tipe_form == 'MDCR'){
							$this->db->where('request_id', $request_id);
							$this->db->update('hris_medical_reimbursment', array('is_status' => 4));
							
							$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();
							$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
							$this->sendEmail('rejected_mdcr', $request_id, decrypt($data['data_employee'][0]->email));
							$this->logs('reject', 'MDCR', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1);

							if (strtoupper($this->email) == 'HR.SUPPORT@IBSMULTI.COM') {
								$form_log_request = array(
									'request_id' => $request_id,
									'activity' => 'Reject',
									'desc' =>  $data['form_request']['request_number'] . ' Rejected',
									'create_at' => $this->date,
									'create_by' => $this->email,
									'type' => 'MDCR',
									'activity_desc' => 'Rejected_by_HR'
								);

								$this->db->insert('form_logs', $form_log_request);
							} else {
								$form_log_request = array(
									'request_id' => $request_id,
									'activity' => 'Reject',
									'desc' =>  $data['form_request']['request_number'] . ' Rejected',
									'create_at' => $this->date,
									'create_by' => $this->email,
									'type' => 'MDCR',
									'activity_desc' => 'Rejected_by_Superior'
								);

								$this->db->insert('form_logs', $form_log_request);
							}

						}
						
					}
			break;

			case 'Approved':
				
					#check current approver list
					$sql = "SELECT * FROM form_approval WHERE id = '$approval_id' AND request_id = '$request_id'";
					$checkleftcurrent = $this->db->query($sql);

					if($tipe_form!='TM' && ($checkleftcurrent->row_array()['approval_priority'] == 1)){
						$this->sendEmail('approved_spv_mdcr', $request_id, $checkleftcurrent->row_array()['approval_email'], $checkleftcurrent->row_array()['approval_employee_id']); 
						$this->sendEmail('request_approve_mdcr_hr', $request_id, 'hr.support@ibsmulti.com', '00000000');
						$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();

						$form_log_request = array(
							'request_id' => $request_id,
							'activity' => 'Approve',
							'desc' =>  $data['form_request']['request_number'] . ' Approved',
							'create_at' => $this->date,
							'create_by' => $this->email,
							'type' => $tipe_form,
							'activity_desc' => 'Approved_by_Superior'
						);

						$this->db->insert('form_logs', $form_log_request);
					}elseif($tipe_form == 'MDCR'){
						$this->sendEmail('approved_mdcr', $request_id, 'hr.support@ibsmulti.com', $checkleftcurrent->row_array()['approval_employee_id']);								
					}

					#check approver list
					$sql = "SELECT * FROM form_approval WHERE id >= '$approval_id' AND request_id = '$request_id' ORDER BY approval_priority ASC LIMIT 1,1";
					$checkleft = $this->db->query($sql);

					///////////////////////START TIME MANAGEMENT 2024//////////////////////////
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
					///////////////////////END TIME MANAGEMENT 2024//////////////////////////
					//////Menambahkan $skip != 1 untuk form type TM TIME MANAGEMENT 2024 //////////////
					if ($checkleft->num_rows() > 0 && $skip != 1) {
										
						$current_approval = array(
							'approval_status' => 'Approved', 
							'updated_at' => $this->date, 
							'updated_by' => $this->email
						);

						#update response approval
						$this->db->where('id', $approval_id);
						if ($this->db->update('form_approval', $current_approval)) {

							/////////////////////////////////////////////////START TIME MANAGEMENT 2024 ////////////////////////////////////////////
							if($tipe_form == 'TM'){
								$sqlReqNo = "SELECT request_number FROM hris_request_time_off where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
								$queryReqNo = $this->db->query($sqlReqNo);
								$resultReqNo = $queryReqNo->result_array();
								$req_no = $resultReqNo[0]['request_number'];

								$config['cacheable']    = true;
								$config['cachedir']     = './assets/';
								$config['errorlog']     = './assets/';
								$config['imagedir']     = './assets/images/qrcode_tm/';
								$config['imagelogo']    = './assets/images/IBS.png';								
								$config['quality']      = true;
								$config['size']         = '1024';
								$config['black']        = array(224,255,255);
								$config['white']        = array(70,130,180);
								$this->ciqrcode->initialize($config);
								$image_name				= 'appr-'.$req_no.'-'.$this->emp_id.'.png';
								$params['data'] 		= $req_no.'-'.$this->emp_id;
								$params['level'] 		= 'H'; //H=High
								$params['size'] 		= 10;
								$params['savename'] 	= FCPATH.$config['imagedir'].$image_name;
								$params['logo'] 		= FCPATH . $config['imagelogo'];
								$params['imagetmp'] 	= $config['imagedir'];								
								$this->ciqrcode->generate($params);

								$resultCurrent = $checkleftcurrent->result_array();
								$priority_tm = $resultCurrent[0]['approval_priority'];

								if($priority_tm == 1){
									$this->db->where('request_id', $request_id);
									$this->db->where('approval_priority', 2);
									$this->db->update('form_approval', array('approval_status' => 'In Progress'));

									$this->db->where('id', $request_id);
									$this->db->update('form_request', array('updated_by' => $this->email, 'updated_at' => $this->date));
								}

								$this->sendEmailTM('approved_time_off', $request_id, $this->email);
								// $this->sendEmailTM('req_to_hr', $request_id, '');
							}
							/////////////////////////////////////////////////END TIME MANAGEMENT 2024 ////////////////////////////////////////////

							#set in progress for next approver
							$this->db->where('id', $checkleft->row_array()['id']);
							
							if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {

								// $this->logs('approved', $request_id, 'Approved successfully');
								///////////Start Update logs 2025//////////////////
								$this->logs('approved', $tipe_form, $request_id, 'Approved', 'Approved successfully');
								///////////End Update logs 2025//////////////////
								// $output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));
								$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id), 'tipe_form' => $tipe_form);

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating the next approver.');
								$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.', 'tipe_form' => $tipe_form);
							}

						} else {
							$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval.');
							$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating response approval. ', 'tipe_form' => $tipe_form);
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

								//////////////////////START TIME MANAGEMENT 2024 - TIME OFF//////////////////////////
								$resultCurrent = $checkleftcurrent->result_array();
								$priority_tm = $resultCurrent[0]['approval_priority'];
								if($tipe_form == 'TM'){

									if($priority_tm == 2){
										$this->db->where('request_id', $request_id);
										$this->db->where('approval_priority', 2);
										$this->db->update('form_approval', $approval);
									}

									$sqlUpdate = "UPDATE hris_request_time_off SET status=1 where request_id = '$request_id'";
									$queryUpdate = $this->db->query($sqlUpdate);

									$sqlGetDate = "
												SELECT
													b.kode,
													a.nik,
													a.jenis,
													a.start_date,
													a.end_date,
													a.request_number
												FROM hris_request_time_off a
												LEFT JOIN hris_master_time_off b
													ON a.jenis = b.nama
												WHERE request_id = '$request_id'
											";

											$queryGetDate  = $this->db->query($sqlGetDate);
											$resultGetDate = $queryGetDate->result_array();

											if(empty($resultGetDate)){
												// handle request tidak ditemukan
												return;
											}

											$dataGetDate = $resultGetDate[0];

											$nik        = $dataGetDate['nik'];
											$start_date = $dataGetDate['start_date'];
											$end_date   = $dataGetDate['end_date'];
											$req_no     = $dataGetDate['request_number'];

											$sqlGetB4 = "
												SELECT id
												FROM hris_request_time_off
												WHERE request_id = '$request_id'
												AND status = 1
											";

											$queryGetB4 = $this->db->query($sqlGetB4);

											if($queryGetB4->num_rows() > 0){

												$sqlGetDateDiff = "
													SELECT *
													FROM hris_master_time_management
													WHERE employee_id = '$nik'
													AND date BETWEEN '$start_date' AND '$end_date'
													AND schedule_code = 'DON'
												";

												$queryGetDateDiff = $this->db->query($sqlGetDateDiff);
												$changeDON = $queryGetDateDiff->num_rows();

											} else {
												$changeDON = 0;
											}

									/* menentukan kode */
									if ($dataGetDate['jenis'] == 'Cuti Tahunan Setengah Hari') {
										$kode   = 'CT';
										$kode_h = 'CT_Half';
									} else {
										$kode   = $dataGetDate['kode'];
										$kode_h = '';
									}

									/* menentukan attendance */
									if (in_array($kode, ['PPD', 'DDK', 'DLK', 'PD'])) {
										$flag       = 0;
										$attendance = ", working_hours_d='9.00', working_hours_t = '09:00:00', attendance_status = 'absent'";
									} elseif ($kode == 'CT' && $kode_h == 'CT_Half') {
										$flag       = 1;
										$attendance = ", working_hours_d='4.50', working_hours_t = '04:30:00', attendance_status = 'absent'";
									} elseif ($kode == 'S') {
										$flag       = 1;
										$attendance = ", working_hours_d='0.00', working_hours_t = '00:00:00'";
									} else {
										$flag       = 1;
										$attendance = ", working_hours_d='9.00', working_hours_t = '09:00:00', attendance_status = 'absent'";
									}

									$this->db->select('id, time_off_code, note, check_in, check_in_date, check_out, check_out_date');
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

										if ($kode == 'S' && (!empty($val->check_in)) && (!empty($val->check_out))) {

											$working_hours_d = $this->workingHoursD(
												$val->check_in_date.' '.$val->check_in,
												$val->check_out_date.' '.$val->check_out
											);
											$working_hours_t = $this->workingHoursT(
												$val->check_in_date.' '.$val->check_in,
												$val->check_out_date.' '.$val->check_out
											);
											
											$flag       = 1;
											$attendance = ", working_hours_d='$working_hours_d', working_hours_t = '$working_hours_t', attendance_status = 'absent'";
										}

										if ($kode == 'CT' && $kode_h == 'CT_Half' && (!empty($val->check_in)) && (!empty($val->check_out))) {
												
											$working_hours_d = $this->workingHoursD(
												$val->check_in_date.' '.$val->check_in,
												$val->check_out_date.' '.$val->check_out
											);
											$working_hours_t = $this->workingHoursT(
												$val->check_in_date.' '.$val->check_in,
												$val->check_out_date.' '.$val->check_out
											);

											// karena setengah hari, maka working hours maksimal adalah 9 untuk daily dan 09:00:00 untuk time
											$working_hours_d = min($working_hours_d + 4.5, 9);
											$working_hours_t = min(
												$this->addTime($working_hours_t, "04:30:00"),
												"09:00:00"
											);
											
											$flag       = 1;
											$attendance = ", working_hours_d='$working_hours_d', working_hours_t = '$working_hours_t', attendance_status = 'absent'";

										}



										$sqlUpdateMTM = "UPDATE hris_master_time_management SET ". $sentence . $attendance .", flag=$flag WHERE id=$id AND schedule_code NOT IN ('DO', 'DON')";
										// dumper($sqlUpdateMTM);
										$queryUpdateMTM = $this->db->query($sqlUpdateMTM);
									}
									
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
											// if ($kode != 'PPD' && $kode != 'DDK' && $kode != 'IDT'){
											if ($kode != 'IDT'){
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

									if ($dataGetDate['jenis'] == 'Request Attendance'){

										$this->db->select('waktu_masuk, waktu_keluar, start_date, end_date');
										$this->db->from('hris_request_time_off');
										$this->db->where('nik', $nik);
										$this->db->where('request_id', $request_id);
										$resGetTime  = $this->db->get()->row_array();

										$clocked_in  = $resGetTime['waktu_masuk'] ?? null;
										$clocked_out = $resGetTime['waktu_keluar'] ?? null;
										$start_date_r= $resGetTime['start_date'] ?? null;
										$end_date_r  = $resGetTime['end_date'] ?? null;


										/* Get Check In dari time management */
										$this->db->select('check_in');
										$this->db->from('hris_master_time_management');
										$this->db->where('employee_id', $nik);
										$this->db->where('date >=', $start_date_r);
										$this->db->where('date <=', $end_date_r);
										$resGetTimeCheckIn = $this->db->get()->row_array();

										$get_check_in = $resGetTimeCheckIn['check_in'] ?? null;
										// dumper($get_check_in.);

										/* Tentukan start time */
										$clock_in = !empty($clocked_in) ? $clocked_in : $get_check_in;

										/* Hitung working hours */
										if (!empty($clocked_out)) {

											$working_hours_d = $this->workingHoursD(
												$start_date_r.' '.$clock_in,
												$end_date_r.' '.$clocked_out
											);
											$working_hours_t = $this->workingHoursT(
												$start_date_r.' '.$clock_in,
												$end_date_r.' '.$clocked_out
											);

											// karena setengah hari, maka working hours maksimal adalah 9 untuk daily dan 09:00:00 untuk time
											$working_hours_d = min($working_hours_d, 9);
											$working_hours_t = min($working_hours_t, "09:00:00");

											if (!empty($clocked_in)) {
												$sentence = ", check_in='$clocked_in', working_hours_d='$working_hours_d', working_hours_t='$working_hours_t'";
											} else {
												$sentence = ", working_hours_d='$working_hours_d', working_hours_t='$working_hours_t'";
											}

										} else {
											$sentence = "";
										}

										$sqlUpdMTM = "UPDATE hris_master_time_management SET attendence_code='HCTAB', flag=1, check_out='$clocked_out'"
													. $sentence ." WHERE employee_id='$nik' AND (date BETWEEN '$start_date' AND '$end_date')";
										$queryUpdMTM = $this->db->query($sqlUpdMTM);
									}

									if ($kode == 'CT'){
										$sqlGetDateDiff = "SELECT * FROM hris_master_time_management WHERE employee_id='$nik'
														AND date BETWEEN '$start_date' and '$end_date'
														AND schedule_code = 'DON'"; 
										$queryGetDateDiff = $this->db->query($sqlGetDateDiff);
										$resultGetDateDiff = $queryGetDateDiff->result_array();

										$change += count($resultGetDateDiff);
									}

									$totalChange = $topTotal + $change + $changeDON;
									if($totalChange < -6){
										$flagTME = 1;
									} else {
										$flagTME = 0;
									}
									if($totalChange >= 0){
										$flagMinus = 0;

										// $this->db->where('nik', $employee_nik);
										$this->db->where('nik', $nik);
										$this->db->update('hris_time_management_employee', array('minus' => 0));
									} else {
										$flagMinus = 1;
									}

									$formDataEmployee = array(
										'nik' => $nik,
										'date' => $today,
										'tipe_perubahan' => 'Approved - ' . $dataGetDate['jenis'],
										'start_date' => $start_date,
										'end_date' => $end_date,
										'total_cuti' => $totalChange,
										'change_log' => $change,
										'request_number' => '-',
										'status' => 3,
										'flag' => $flagTME,
										'minus' => $flagMinus
									);
									// dumper($formDataEmployee);
									$this->db->insert("hris_time_management_employee", $formDataEmployee);

									$this->sendEmailTM('approved_time_off', $request_id, '');
									if($dataGetDate['jenis'] != 'Request Attendance'){
										$this->sendEmailTM('info_time_off', $request_id, '');
									}
									
								}
								//////////////////////END TIME MANAGEMENT 2024 - TIME OFF//////////////////////////

								//$this->sendEmail('approved_eapp', $request_id, $requestor);
								// $this->logs('approved', $request_id, 'Approved successfully.');
								///////////Start Update logs 2025//////////////////
								$this->logs('approved', $tipe_form, $request_id, 'Approved', 'Approved successfully');
								///////////End Update logs 2025//////////////////
								
								$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id), 'tipe_form' => $tipe_form);

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval [Full Approved].');
								$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.', 'tipe_form' => $tipe_form);
							}

						} else {
							$this->logs('system', $request_id, 'Authentication success, but failed while updating header request [Full Approved].');
							$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.', 'tipe_form' => $tipe_form);
						}

					}
			break;

					//////////////////////START TIME MANAGEMENT 2024 - TIME OFF//////////////////////////
			case 'RejectLoc':
				$this->db->where('request_id', $request_id);
				$this->db->delete('form_approval');
				$this->db->where('id', $request_id);
				if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

					$sqlUpdate = "UPDATE hris_request_time_off SET status=2 where request_id = '$request_id'";
					$queryUpdate = $this->db->query($sqlUpdate);
					
					$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
					$output = array('status' => 1, 'tipe_form' => $tipe_form);
				}
			break;

			case 'ApprovedLoc':
				#update header request
				$this->db->where('id', $request_id);
				if ($this->db->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
					$approval = array(
						'approval_status' => 'Approved', 
						'updated_at' => $this->date, 
						'updated_by' => $this->email
					);

					#update response approval
					$this->db->where('request_id', $request_id);
					if ($this->db->update('form_approval', $approval)) {

						$sqlData = "SELECT * FROM hris_request_time_off where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
						$queryData = $this->db->query($sqlData);
						$resultData = $queryData->result_array();

						$date = $resultData[0]['start_date'];
						$nik = $resultData[0]['nik'];

						$sqlPA = "SELECT * FROM v_hris_employee_updated WHERE nik='$nik'";
						$queryPA = $this->db->query($sqlPA);
						$resultPA = $queryPA->result_array();

						$personelArea = decrypt($resultPA[0]['personnel_area']);

						$sqlGetLoc = "SELECT * FROM hris_master_personnel_area WHERE personnel_area='$personelArea' ORDER BY id ASC LIMIT 1";
						$queryGetLoc = $this->db->query($sqlGetLoc);
						$resultGetLoc = $queryGetLoc->result_array();

						$location_address = $resultGetLoc[0]['address'];
						$location_lat = $resultGetLoc[0]['lattitude'];
						$location_long = $resultGetLoc[0]['longitude'];

						if (!empty($resultData[0]['waktu_masuk']) && empty($resultData[0]['waktu_keluar'])){
							$sentence = "check_in_location = '$location_address', lat_in = '$location_lat', long_in = '$location_long'";
						} else if (empty($resultData[0]['waktu_masuk']) && !empty($resultData[0]['waktu_keluar'])){
							$sentence = "check_out_location = '$location_address', lat_out = '$location_lat', long_out = '$location_long'";
						} else if (!empty($resultData[0]['waktu_masuk']) && !empty($resultData[0]['waktu_keluar'])){
							$sentence = "check_in_location = '$location_address', lat_in = '$location_lat', long_in = '$location_long',
										check_out_location = '$location_address', lat_out = '$location_lat', long_out = '$location_long'";
						}

						$sqlUpdMTM = "UPDATE hris_master_time_management SET ". $sentence ." WHERE employee_id='$nik' AND date = '$date'";
						$queryUpdMTM = $this->db->query($sqlUpdMTM);
					
						$sqlUpdate = "UPDATE hris_request_time_off SET status=1 WHERE request_id='$request_id'";
						$queryUpdate = $this->db->query($sqlUpdate);

						$this->sendEmailTM('info_to_hr', $request_id, 'hr_support@ibstower.com', $this->session->userdata('name'));

						// $this->logs('approved', $request_id, 'Approved successfully.');
						///////////Start Update logs 2025//////////////////
						$this->logs('approved', 'TM', $request_id, 'Approved', 'Approved successfully');
						///////////End Update logs 2025//////////////////
						
						$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id), 'tipe_form' => $tipe_form);

					} else {
						$this->logs('system', $request_id, 'Authentication success, but failed while updating header request [Full Approved].');
						$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.', 'tipe_form' => $tipe_form);
					}
				}
			break;
			//////////////////////END TIME MANAGEMENT 2024 - TIME OFF//////////////////////////
			
			default:
			break;
		}
		echo json_encode($output);
	}

	public function save($type = "", $id_table = "", $division = "")
    {
      switch ($type) {
			/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////
			case 'final_score':

				$request_id = $this->input->post('id');
				$request_number = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['request_number'];
				$id_form_request = $this->m_global->find('form_request', 'request_number', $request_number)->row_array()['id'];
				$formData = array(
					'final_score' => encrypt($this->input->post('final_score')),
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				$this->db->where('id', $request_id);
				$updateHeader = $this->db->update('performance_appraisal', $formData);

				if ($updateHeader) {
					$this->logs('update_final_score', 'KPI', $id_form_request, 'Update Final Score');
					$response = array('status' => 1);
				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'dashboard_final_score':

				$request_id = $this->input->post('id');
				$request_number = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['request_number'];
				$id_form_request = $this->m_global->find('form_request', 'request_number', $request_number)->row_array()['id'];
				
				$formData = array(
					'final_score' => encrypt($this->input->post('final_score')),
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);

				$this->db->where('id', $request_id);
				$updateHeader = $this->db->update('performance_appraisal', $formData);
				if ($updateHeader) {
					$this->logs('update_final_score', 'KPI', $id_form_request, 'Update Final Score from dashboard');
					// //$this->sendEmailPa('update_final_score', $request_id, 'luffi.utomo@ibsmulti.com');
					$response = array('status' => 1);
				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'submit_to_hr':
				$division = (decode_url($division));
				$transok = 0;
				$year = $this->year - 1;
				$eval_year = $year.'-01-01';
				$formData = array(
					'evaluation_period' => $eval_year,
					'division_name' => encrypt($division),
					'is_status' => 1,
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);
				$check = $this->db->get_where('performance_division_status', 
				array('division_name' => encrypt($division), 'evaluation_period' => $eval_year));
				

				if ($check->num_rows() == 1) {
					$this->db->where('id', $check->row_array()['id']);
					$this->db->update('performance_division_status', $formData);
					
					$this->logs('submit_to_hr', 'KPI', $check->row_array()['id'], 'Submit to HR');

					//////////Submit to HR sendEmailPA///////////////////
					$this->m_services->sendEmailHRPA(encrypt($division),$eval_year,'submit_to_hr');

					$transok = 1;

				} else {
					$this->db->insert('performance_division_status', $formData);

					//////////Submit to HR sendEmailPA///////////////////
					$this->m_services->sendEmailHRPA(encrypt($division),$eval_year,'submit_to_hr');

					$division_status_id = $this->db->insert_id();
					$this->logs('submit_to_hr', 'KPI', $division_status_id, 'Submit to HR');
					// //$this->sendEmailPa('submit_to_hr', $division_status_id, 'luffi.utomo@ibsmulti.com');
					$transok = 1;
				}


				if ($transok) {
					$response = array('status' => 1);
				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'submit_to_hr_ops':

				$transok = 0;
				$year = $this->year - 1;
				$eval_year = $year.'-01-01';

				$formData = array(
					'evaluation_period' => $eval_year,
					'division_name' => encrypt('Regional Central'),
					'is_status' => 1,
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);
				
				$check = $this->db->get_where('performance_division_status', 
					array('division_name' => encrypt('Regional Central'), 'evaluation_period' => $eval_year));

				if ($check->num_rows() == 1) {
					$this->db->where('id', $check->row_array()['id']);
					$this->db->update('performance_division_status', $formData);
					
					$this->logs('submit_to_hr', 'KPI', $check->row_array()['id'], 'Submit to HR');

					// //$this->sendEmailPa('submit_to_hr', $check->row_array()['id'], 'luffi.utomo@ibsmulti.com');
					$transok = 1;

				} else {
					$this->db->insert('performance_division_status', $formData);
					$division_status_id = $this->db->insert_id();
					$this->logs('submit_to_hr', 'KPI', $division_status_id, 'Submit to HR');
					// //$this->sendEmailPa('submit_to_hr', $division_status_id, 'luffi.utomo@ibsmulti.com');
					$transok = 1;
				}


				if ($transok) {
					$response = array('status' => 1);
				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'submit_to_hr_second_division':

				$transok = 0;
				$year = $this->year - 1;
				$eval_year = $year.'-01-01';

				$formData = array(
					'evaluation_period' => $eval_year,
					'division_name' => $this->session->userdata('second_division'),
					'is_status' => 1,
					'updated_by' => encrypt($this->email),
					'updated_at' => $this->date
				);
				
				$check = $this->db->get_where('performance_division_status', 
					array('division_name' => $this->session->userdata('second_division'), 'evaluation_period' => $eval_year));
				if ($check->num_rows() == 1) {
					$this->db->where('id', $check->row_array()['id']);
					$this->db->update('performance_divisionz_status', $formData);
					$this->logs('submit_to_hr', 'KPI', $check->row_array()['id'], 'Submit to HR');
					////$this->sendEmailPa('submit_to_hr', $check->row_array()['id'], 'luffi.utomo@ibsmulti.com');
					$transok = 1;

				} else {
					$this->db->insert('performance_division_status', $formData);
					$division_status_id = $this->db->insert_id();
					$this->logs('submit_to_hr', 'KPI', $division_status_id, 'Submit to HR');
					//$this->sendEmailPa('submit_to_hr', $division_status_id, 'luffi.utomo@ibsmulti.com');
					$transok = 1;
				}

				if ($transok) {
					$response = array('status' => 1);
				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'Revised':
				$division = (decode_url($division));
				dumper($division);
				$formData = array(
					'is_status' => 2,
					'response_by' => encrypt($this->email),
					'response_at' => $this->date
				);
				$year = $this->year - 1;
				$eval_year = $year.'-01-01';

				$div_head_email = $this->db->get_where('performance_division_status', array('id' => $id_table))->row_array()['updated_by'];

				$this->db->where('id', $id_table);
				if ($this->db->update('performance_division_status', $formData)) {
					$this->logs('revised_by_hr', 'KPI', $id_table, 'Revised by HR');
					$response = array('status' => 1);

				} else {
					$this->logs('system', 'KPI', $id_table, 'Revised by HR');
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'Confirm':
				$year = date("Y")-1;
				
				$formData = array(
					'is_status' => 3,
					'response_by' => encrypt($this->email),
					'response_at' => $this->date
				);
				
				$div_head_email = $this->db->get_where('performance_division_status', array('id' => $id_table))->row_array()['updated_by'];
				$this->db->where('id', $id_table);
				if ($this->db->update('performance_division_status', $formData)) {

					$sql = "SELECT a.id FROM performance_appraisal a LEFT JOIN performance_division_status as b ON a.division = b.division_name
						WHERE a.evaluation_period_start = '".date($year."-01-01")."' AND b.id = '".$id_table."'";
					$query = $this->db->query($sql);
					$res = $query->result_array();
					foreach ($res as $key => $value) {
						//////////HR Confirmed sendEmailPA///////////////////
						$this->m_services->sendEmailPA($value['id'],'hr_confirmed');
					}
					$this->logs('confirm_by_hr', 'KPI', $id_table, 'Confirm by HR');
					$response = array('status' => 1);

				} else {
					$this->logs('system', 'KPI', $id_table, 'Confirm by HR');
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'notes':

				$id = $this->input->post('request_id');
				$field['request_id'] = $id;
				$field['notes'] = $this->input->post('notes');
				$field['created_by'] = $this->email;
				$field['created_at'] = $this->date;
				$field['is_status'] = 1;//TIME MANAGEMENT 2.0

				if ($this->db->insert('request_notes', $field)) {
					$this->logs('save_notes', 'HRIS', $id, 'Add notes', $this->input->post('notes'));
					$response = array('status' => 1, 'id' => encode_url($id), 'messages' => 'Notes has been saved.');
				} else {
					$this->logs('system', $id, 'Failed while saving invoices notes.');
					$response = array('status' => 0, 'messages' => 'There\s something wrong. Please try again.');
				}

				echo json_encode($response);
				break;

			case 'notespa':

				$id = $this->input->post('request_id');
				$field['request_id'] = $id;
				$field['notes'] = $this->input->post('notes');
				$field['created_by'] = $this->email;
				$field['created_at'] = $this->date;
				$field['is_status'] = 1;

				if ($this->db->insert('request_notes', $field)) {
					$this->logs('save_notes', 'KPI', $id, 'Add notes', $this->input->post('notes'));
					$response = array('status' => 1, 'id' => encode_url($id), 'messages' => 'Notes has been saved.');
				} else {
					$this->logs('system', $id, 'Failed while saving invoices notes.');
					$response = array('status' => 0, 'messages' => 'There\s something wrong. Please try again.');
				}

				echo json_encode($response);
				break;
			/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////


            default:
                break;
        }
    }

    public function delete_notes($notes_id, $request_id)
    {
        if ($this->db->where('id', $notes_id)->delete('request_notes')) {
            echo json_encode(array('status' => 1, 'id' => encode_url($request_id), 'messages' => "Notes has been deleted."));
        } else {
            echo json_encode(array('status' => 0, 'messages' => "Oops! There is something wrong. Please refresh the page and try again."));
        }
    }

	public function cekNote()
	{
		$request_id		= $_POST['id'];
		$data = $this->inbox_model->cekNote($request_id);
		echo json_encode($data);
	}

	public function grouping_req_mdcr()
	{
		$req_mdcr = $this->input->post('req_mdcr');
		$today = date("Y-m-d");
		$tanggal = date("dmy");

		if (empty($req_mdcr)) {
			echo json_encode(false);
			return;
		}

		// Batasi maksimal 15
		if (count($req_mdcr) > 15) {
			echo json_encode('15_lebih');
			return;
		}

		// ===== Ambil nomor referensi terakhir di hari ini =====
		$this->db->select('no_req_mdcr')
			->from('hris_no_req_mdcr')
			->where('DATE(created_at)', $today)
			->order_by('id', 'DESC')
			->limit(1);
		$last_ref = $this->db->get()->row();

		// ===== Generate nomor baru =====
		if (empty($last_ref)) {
			$nomer = '001';
		} else {
			$last_no = str_replace('HRIS_MDCR', '', $last_ref->no_req_mdcr);
			$tanggal2 = substr($last_no, 0, 6);
			$no_urut = substr($last_no, 6, 3);

			if ($tanggal == $tanggal2) {
				$nomer = sprintf("%03d", ((int)$no_urut) + 1);
			} else {
				$nomer = '001';
			}
		}

		$no_ref = "HRIS_MDCR{$tanggal}{$nomer}";

		// dumper($req_mdcr);
		
		// ===== Grouping dan simpan =====
		foreach ($req_mdcr as $request_id) {
			$hasil = $this->responseRequestGrouping($no_ref, $request_id);

			$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();

			$form_log_request = array(
				'request_id' => $request_id,
				'activity' => 'Group',
				'desc' =>  $data['form_request']['request_number'] . ' grouped wth ' . $no_ref,
				'create_at' => $this->date,
				'create_by' => $this->email,
				'type' => 'MDCR',
				'activity_desc' => 'Grouped_by_HR' 
			);

			$this->db->insert('form_logs', $form_log_request);
		}
		
		// Simpan nomor grouping ke tabel no_req_mdcr
		$status = $this->inbox_model->save_no_grouping_req_mdcr($no_ref);
		
		if($status){
			$this->sendEmailGrouping('request_approve_mdcr', 'MDCR', $no_ref, 'ANANDHA.HOKKY@IBSMULTI.COM', '20260004');
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
		
	}

	public function mod_resume_no_req_to_fi($no_req)
	{
			$no_req = $this->uri->segment(3);
			$data['header_mdcr_after_grouping_per_item'] = $this->inbox_model->getApprovalListMDCRAGroupingItem($no_req);
			$data['content'] = 'inbox/mod/mod_resume_no_req_to_fi';
			$this->templates->show('index', 'templates/eapp/eapp_main_pop_up', $data);
			//$this->load->view('inbox/mod/mod_resume_no_req_to_fi', $data);
	}
	
	public function responseRequestGrouping($no_ref, $request_id)
	{
		$this->db->trans_start(); // mulai transaksi

		$output = ['status' => 0, 'message' => 'Something went wrong. Please refresh and try again.'];
		$date = $this->date;
		$email = $this->email;

		// ===== Ambil data approval yang sedang In Progress =====
		$approval = $this->db->select('id, approval_priority')
			->where(['request_id' => $request_id, 'approval_status' => 'In Progress'])
			->get('form_approval')
			->row();

		if (!$approval) {
			$this->logs('system', $request_id, 'No active approval found.');
			return $output;
		}

		$approval_id = $approval->id;
		$priority = $approval->approval_priority;

		// ===== Cari next approver (yang belum approve) =====
		$next_approval = $this->db->select('id, approval_email, approval_employee_id')
			->where('request_id', $request_id)
			->where('approval_status', '')
			->where('approval_priority >', $priority)
			->order_by('approval_priority', 'ASC')
			->limit(1)
			->get('form_approval')
			->row();
		
		// ===== Update approval saat ini (set Approved) =====
		$this->db->where('id', $approval_id)
			->update('form_approval', [
				'approval_status' => 'Approved',
				'updated_at'      => $date,
				'updated_by'      => $email
			]);

		if ($this->db->affected_rows() == 0) {
			$this->logs('system', $request_id, 'Failed updating current approval.');
			return $output;
		}

		// ===== Jika masih ada approver berikutnya =====
		if ($next_approval) {
			// Update next approver jadi In Progress
			$this->db->where('id', $next_approval->id)
				->update('form_approval', ['approval_status' => 'In Progress']);

			// Update form_request (assign nomor grouping)
			$this->db->where(['id' => $request_id, 'form_type' => 'MDCR'])
				->update('form_request', [
					'no_req_mdcr'     		=> $no_ref,
					'is_status_progress'    => 1,
					'revise_after_f1' 		=> null
				]);

			// Kirim notifikasi ke next approver
			// $this->sendEmail('request_approve_mdcr', $request_id, $next_approval->approval_email, $next_approval->approval_employee_id);

			// Logging
			$this->logs('approved', 'MDCR', $request_id, 'Approved', 'Approved successfully');

			$output = [
				'status'  => 1,
				'message' => 'Approved successfully.',
				'id'      => encode_url($request_id)
			];
		}
		// ===== Jika tidak ada approver lagi (final approval) =====
		else {
			// Update form_request jadi status selesai (3)
			$this->db->where('id', $request_id)
				->update('form_request', [
					'is_status'       => 3,
					'is_status_progress'    => 6,
					'revise_after_f1' => null,
					'updated_by'      => $email,
					'updated_at'      => $date
				]);

			// Logging
			$this->logs('approved', 'MDCR', $request_id, 'Approved', 'Fully approved.');

			$output = [
				'status'  => 1,
				'message' => 'Fully approved successfully.',
				'id'      => encode_url($request_id)
			];
		}

		$this->db->trans_complete(); // commit transaction

		// Jika ada error di transaksi
		if ($this->db->trans_status() === FALSE) {
			$this->logs('system', $request_id, 'Transaction failed during grouping approval.');
			$output = ['status' => 0, 'message' => 'Transaction failed. Please retry.'];
		}

		return $output;
	}

	public function sendEmail($type, $requestId, $email_to, $employee_id = "")
	{
		// Ambil data utama hanya sekali
		$form_request = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data = [
			'form_request'   		=> $form_request,
			'data_employee'  		=> $this->form_model->get_data_employee($form_request['employee_id'])[0],
			'get_data_claim' 		=> $this->form_model->get_data_claim_per_request($requestId),
			'approval'       		=> $this->m_global->find('form_approval', 'request_id', $requestId)->result_array(),
			'employee_name' 		=> ucwords(strtolower(decrypt($this->form_model->get_data_employee($form_request['employee_id'])[0]->complete_name)))
		];

		// dumper($data);
		
		// Siapkan konfigurasi jenis email (mapping sederhana)
		$email_templates = [
			'approved_spv_mdcr' => [
				'view'    => 'services/email/approved_spv_mdcr',
				// 'subject' => 'IBSW - Medical Claim Approved',
				'subject' => '[HRIS-MDCR] Request Approved',
				'use_emp' => true
			],
			'approved_mdcr' => [
				'view'    => 'services/email/approvedMDCR',
				// 'subject' => 'IBSW - Medical Claim Approved'
				'subject' => '[HRIS-MDCR] HR Verification Request',
			],
			'request_approve_mdcr' => [
				'view'    => 'services/email/request_approve_mdcr',
				'subject' => '[HRIS-MDCR] Request Approved',
				'use_emp' => true
			],
			'rejected_mdcr' => [
				'view'    => 'services/email/reject_mdcr',
				'subject' => '[HRIS-MDCR] Request Rejected'
			],
			'revised_mdcr' => [
				'view'    => 'services/email/revised_mdcr',
				'subject' => '[HRIS-MDCR] Request Revised',
				'use_emp' => true
			],
			'request_approve_mdcr_hr' => [
				'view'    => 'services/email/request_approve_mdcr_hr',
				'subject' => '[HRIS-MDCR] HR Verification Request',
				'use_emp' => true
			]
			
		];

		// Validasi tipe email
		if (!isset($email_templates[$type])) {
			log_message('error', "sendEmail: Unknown email type '{$type}'");
			return false;
		}

		$tpl = $email_templates[$type];

		// Jika perlu data approver (use_emp)
		if (!empty($tpl['use_emp']) && $employee_id) {
			$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id)[0];
		}

		// Setup email utama
		$data['email'] = $email_to;
		$html = $this->load->view($tpl['view'], $data, TRUE);
		$subject = $tpl['subject'];

		// ========== PHPMailer Config ==========
		$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host       = 'mail.ibsmulti.com';
			$mail->SMTPAuth   = true;
			$mail->Username   = 'no.reply@ibsmulti.com';
			// $mail->Password   = '2025@54321No.Reply'; // ← isi password di ENV, bukan hardcode
			$mail->Password   = '1214#$C1k1n1.2026';
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->setFrom('no.reply@ibsmulti.com', 'Notification System');
			$mail->isHTML(true);


			if($this->status_apps == "development") {

				$prefix = 'DEV TEST - ';
				$subject = $prefix . $subject;
				$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
				$mail->addAddress('luffi.utomo@ibsmulti.com');
				$mail->addCC('ditha.damayanti@ibsmulti.com');
			} else if ($this->status_apps == "staging") {

				$prefix = 'STAGING TEST - ';
				$subject = $prefix . $subject;
				$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
				$mail->addAddress('luffi.utomo@ibsmulti.com');
				$mail->addCC('ditha.damayanti@ibsmulti.com');
			} else if ($this->status_apps == "production") {
				if (!empty($email_to)) {
					$mail->addAddress($email_to);
				}
				$mail->addBCC('luffi.utomo@ibsmulti.com');
				$mail->addBCC('ditha.damayanti@ibsmulti.com');
			}

			$mail->Subject = $subject;
			$mail->Body    = $html;

			// ========== Penentuan Recipient Berdasarkan Environment ==========
			// $host = $_SERVER['HTTP_HOST'] ?? '';
			// $is_dev = in_array($host, ['rnd.ibsmulti.com', 'devhris.ibsmulti.com', '172.19.8.81']);
			
			// if ($is_dev) {
			// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
			// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
			// } else {
			// 	if (!empty($email_to)) {
			// 		$mail->addAddress($email_to);
			// 	}
			// 	$mail->addBCC('luffi.utomo@ibsmulti.com');
			// 	$mail->addBCC('ditha.damayanti@ibsmulti.com');
			// }

			$mail->send();
			log_message('info', "Email '{$type}' sent to {$email_to}");
			return true;

		} catch (Exception $e) {
			log_message('error', "sendEmail Error: {$mail->ErrorInfo}");
			return false;
		}
	}

	public function sendEmailGrouping($type, $module, $no_ref, $email_to, $employee_id = "")
	{
		// Ambil data utama hanya sekali
		$data = [
			'no_ref'		  		=> $no_ref,
			'module'		  		=> $module
		];
		
		// Siapkan konfigurasi jenis email (mapping sederhana)
		$email_templates = [
			'request_approve_mdcr' => [
				'view'    => 'services/email/request_approve_grouping_mdcr',
				'subject' => '[HRIS-MDCR] Approval Request',
				'use_emp' => true
			]
		];

		// Validasi tipe email
		if (!isset($email_templates[$type])) {
			log_message('error', "sendEmail: Unknown email type '{$type}'");
			return false;
		}

		$tpl = $email_templates[$type];

		// Jika perlu data approver (use_emp)
		if (!empty($tpl['use_emp']) && $employee_id) {
			$data['data_employee_approver'] = $this->form_model->get_data_employee($employee_id)[0];
		}

		// Setup email utama
		$data['email'] = $email_to;
		$html = $this->load->view($tpl['view'], $data, TRUE);
		$subject = $tpl['subject'];

		// ========== PHPMailer Config ==========
		$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host       = 'mail.ibsmulti.com';
			$mail->SMTPAuth   = true;
			$mail->Username   = 'no.reply@ibsmulti.com';
			// $mail->Password   = '2025@54321No.Reply'; // ← isi password di ENV, bukan hardcode
			$mail->Password   = '1214#$C1k1n1.2026';
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->setFrom('no.reply@ibsmulti.com', 'Notification System');
			$mail->isHTML(true);

			if($this->status_apps == "development") {
				$prefix = 'DEV TEST - ';
				$subject = $prefix . $subject;
				$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
				$mail->addAddress('luffi.utomo@ibsmulti.com');
				$mail->addCC('ditha.damayanti@ibsmulti.com');
			} else if ($this->status_apps == "staging") {
				$prefix = 'STAGING TEST - ';
				$subject = $prefix . $subject;
				$mail->addAddress('PALUPI.UTAMI@IBSMULTI.COM');
				$mail->addAddress('luffi.utomo@ibsmulti.com');
				$mail->addCC('ditha.damayanti@ibsmulti.com');
			} else if ($this->status_apps == "production") {
				if (!empty($email_to)) {
					$mail->addAddress($email_to);
				}
				$mail->addBCC('luffi.utomo@ibsmulti.com');
				$mail->addBCC('ditha.damayanti@ibsmulti.com');
			}

			$mail->Subject = $subject;
			$mail->Body    = $html;

			// ========== Penentuan Recipient Berdasarkan Environment ==========
			// $host = $_SERVER['HTTP_HOST'] ?? '';
			// $is_dev = in_array($host, ['rnd.ibsmulti.com', 'devhris.ibsmulti.com', '172.19.8.81']);

			// if ($is_dev) {
			// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
			// 	$mail->addCC('ditha.damayanti@ibsmulti.com');		
			// } else {
			// 	if (!empty($email_to)) {
			// 		$mail->addAddress($email_to);
			// 	}
			// 	$mail->addBCC('luffi.utomo@ibsmulti.com');
			// 	$mail->addBCC('ditha.damayanti@ibsmulti.com');
			// }

			$mail->send();
			log_message('info', "Email '{$type}' sent to {$email_to}");
			return true;

		} catch (Exception $e) {
			log_message('error', "sendEmail Error: {$mail->ErrorInfo}");
			return false;
		}
	}

	/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////
	public function read_uom2(){
		$listForm = $this->inbox_model->getUOM();
		if (!empty($listForm)) {
            
            $output = $listForm;
        } else {
            $output = new ArrayObject();
        }
		echo json_encode($output);
	}

	public function save_uom($id = ""){

		if($this->input->post()){

			$data['formula'] = "";
			foreach($this->input->post() as $key => $val){
				$data[$key] = $val;
			}
			
			if($data['formula'] == 1){
				$data['formula'] = "Positive";
			}elseif(empty($data['formula'])){
				$data['formula'] = "Negative";
			}

			$save = $this->inbox_model->save_uom($id,$data);
			if($save){
				echo 1;
			}else{
				echo 0;
			}
		}

	}

	
	public function approvalpa()
	{
		$data['header'] = $this->inbox_model->getApprovalListPa();
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
		$data['content'] = 'inbox/list_approval';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}
	
	public function approvalpaAll()
	{
		$data['header'] = $this->inbox_model->getPAListAllStatus();
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
		$data['content'] = 'inbox/list_approval';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function viewpa($id,$year="")
	{
		if($year == "" || $year == NULL){
			$year = $this->year - 1;
		}
		$data['year'] = $year;
		$request_id = decode_url($id);
		$data['header'] = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array();
		$data['id_form_request'] = $this->db->query("select b.id as id from performance_appraisal as a left join form_request as b on a.request_number = b.request_number where a.id = '$request_id'")->row_array()['id'];
		$data['training'] = $this->m_global->find('performance_appraisal_training', 'request_id', $request_id)->result_array();
		$id_form_request = $this->m_global->find('form_request', 'request_number', $data['header']['request_number'])->row_array()['id'];
		$data['detail'] = $this->m_global->find('performance_appraisal_measurement', 'request_id', $request_id)->result_array();
		$data['additional'] = $this->m_global->find('performance_appraisal_plan', 'request_id', $request_id)->result_array();
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $data['id_form_request'])->result_array();
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $id_form_request)->result_array();
		$data['approval_id'] = $this->inbox_model->find_select("id", 'form_approval', array('request_id' => $id_form_request, 'approval_email' => $this->email))->row_array();
		
		if($data['header']['direct_manager'] == ""){
			$q = "
			SELECT *, a.id_employee,
			case 
				when c.department != '' then c.department
			else
				a.department
			end as department, 
			case 
				when c.id_employee != '' then c.division
			else
				a.division
			end as division,
			case 
				when c.usrid_long2 != '' then c.usrid_long2
			else
				a.usrid_long2
			end as usrid_long2,
			case 
				when c.usrid_long3 != '' then c.usrid_long3
			else
				a.usrid_long3
			end as usrid_long3,
			case 
				when c.usrid_long4 != '' then c.usrid_long4
			else
				a.usrid_long4
			end as usrid_long4,
			z.complete_name as divhead_name_backup
			FROM
			v_hris_employee_updated a
			LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
			LEFT JOIN v_hris_employee_updated as z on a.usrid_long3 = z.email
			WHERE lower(a.email) = '".$data['header']['created_by']."'
			ORDER BY a.id_employee DESC
			";
			// echo $q;
			// die;
			
			$dataEmployee = $this->db->query($q)->result_array();
				$data['backup'] = $dataEmployee;
		}

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

		///////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////
		$data['request_number'] = $this->db->query("select b.request_number as id from performance_appraisal as a left join form_request as b on a.request_number = b.request_number where a.id = '$request_id'")->row_array()['id'];
		$data['documentary_evidence'] = $this->m_global->find('performance_appraisal_documentary_evidence', 'request_number', $data['request_number'])->result_array();
		///////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////

		$data['content'] = 'inbox/form/details_pa';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function responseRequestPa()
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');
		$approval_id = $this->input->post('approval_id');
		$response = $this->input->post('resp');
		$comment = $this->input->post('comment_pa');
		$response = "Revised";

		$requestor = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['created_by'];
		$request_number = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['request_number'];
		$id_form_request = $this->m_global->find('form_request', 'request_number', $request_number)->row_array()['id'];

		$data_response = array(
			'approval_status' => $response, 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		// previous layer
		$priority = $this->m_global->find('form_approval','id', $approval_id)->row_array()['approval_priority'];
		$prev_priority = $priority-1;
		$prev_id = $this->inbox_model->find_select("id",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$id_form_request))->row_array();

		$prev_email = $this->inbox_model->find_select("approval_email",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$id_form_request))->row_array();

		$data_prev_layer = array(
			'approval_status' => 'In Progress', 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);
		// echo "ID FORM REQUEST = ".$id_form_request."<br>";
		// echo "PRIORITY = ".$priority."<br>";
		// echo "PREV PRIORITY = ".$prev_priority."<br>";
		// echo "PREV ID = ".$prev_id."<br>";
		// echo "PREV EMAIL = ".$prev_email."<br>";
		// die;

		switch ($response) {

			case 'Revised':

				if ($priority != 1) {

					$current_layer = array(
						'approval_status' => 'Revised to previous layer', 
						'updated_at' => $this->date, 
						'updated_by' => $this->email
					);

					$this->db->where('id', $approval_id);
					if ($this->db->update('form_approval', $current_layer)) {

						$this->db->where('id', $prev_id['id']);
						if ($this->db->update('form_approval', $data_prev_layer)) {
							$this->db->where('id', $request_id);
							$this->db->update('performance_appraisal', array('updated_by' => $this->email, 'updated_at' => $this->date, 'comment_head_2' => encrypt($comment)));
							//////////REVISE sendEmailPA///////////////////
							$this->m_services->sendEmailPA($request_id,'revise');
							$this->logs('revised', 'KPI', $id_form_request, 'Response revised', 'Success - '.$comment);
							$output = array('status' => 1);
						}
						
					}

				} else {
					// dumper('Test');
					$this->db->where('id', $request_id);
					if ($this->db->update('performance_appraisal', array('is_status' => 2, 'updated_by' => encrypt($this->email), 'updated_at' => $this->date, 'comment_head_1' => encrypt($comment)))) {
						//////////REVISE sendEmailPA///////////////////
						$this->m_services->sendEmailPA($request_id,'revise');
						if ($this->db->where('request_id', $id_form_request)->delete('form_approval')) {
							$this->logs('revised', 'KPI', $id_form_request, 'Response revised', 'Success - '.$comment);
							$output = array('status' => 1);
						}
					}

				}

				break;
			
			default:
				break;
		}
		echo json_encode($output);
	}

	public function readpa($periodYear = "")
    {
		if($periodYear == "" || $periodYear == NULL){
			$year = $this->year - 1;
		}else{
			$year = $periodYear;
		}

		$eval_year = $year.'-01-01';

		
		$listForm = $this->inbox_model->getDivHeadListByDivision($this->session->userdata('division'), $eval_year);
		
		$division_status = $this->db->get_where('performance_division_status', array('division_name' => $this->session->userdata('division'), 'evaluation_period' => $eval_year))->row_array();
		
		if(empty($division_status['is_status'])){
			$division_status = 0;
		}else{
			$division_status = $division_status['is_status'];
		}
		if(empty($division_status)){
			$division_status = 0;
		}
		
        if (!empty($listForm)) {
            foreach ($listForm as $key) {

					$req_id = $this->db->select('id')->from('form_request')->where(['request_number' => $key->request_number])->get()->result();
				
					$count_layer = $this->db->get_where('form_approval', array('request_id' => $req_id[0]->id))->num_rows();
					$approval_priority = isset($this->db->get_where('form_approval', array('request_id' => $req_id[0]->id, 'approval_email' => encrypt($this->email)))->row_array()['approval_priority']);
					
					$row   = array();
					$row[] = decrypt($key->employee_nik);
					$row[] = decrypt($key->employee_name);
					$row[] = decrypt($key->division);
					$row[] = decrypt($key->departement);
					$row[] = decrypt($key->position);
					$row[] = decrypt($key->direct_manager);
					$row[] = decrypt($key->office_location);
					$row[] = $key->join_date;
					$row[] = decrypt($key->employment_status);
					$row[] = decrypt($key->final_score);
					$row[] = grade_pa(decrypt($key->final_score));
					$row[] = status_text($key->is_status);
					$row[] = $key->full_approved_date;
					$row[] = $key->request_number;

					if ($division_status == 1) {
						$row[] = "";//$division_status;//'';
					
					} else if ($division_status == 3) {
						if($key->new_employee_flag != 1){
							$row[] = '<div class="btn-group btn-group-sm">
								<a target="_blank" href="' . site_url('services/generate/result_document/kpi/'.encode_url($key->id)).'/'.$key->request_number.'" class="btn btn-icon btn-trigger"><em class="icon ni ni-printer"></em>
								</a>
							</div>';
						}else{
							$row[] = "";//$division_status;//'';
						}
						
					} else {
						// 	$sql = "SELECT *
						// 							FROM form_request as a left join form_approval as b on a.id = b.request_id
						// 							WHERE a.request_number LIKE '".$key->request_number."' AND b.approval_status = 'Approved' AND b.approval_priority = '1' AND b.approval_email LIKE 'MAKMUR.JAURY@IBSMULTI.COM'";
						// 	$query = $this->db->query($sql);
						// 	$res = $query->row();
							$sql = "SELECT *
										FROM performance_appraisal a left join performance_division_status as b on a.division = b.division_name and a.evaluation_period_start = b.evaluation_period
										WHERE a.request_number LIKE '".$key->request_number."' AND (b.is_status = '3' or b.is_status = '1')";
							$query = $this->db->query($sql);
							$res = $query->row();
							if(!empty($res)){
								$row[] = '<div class="btn-group btn-group-sm" >
									<a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickViewReadonly(this.id)">
										<em class="icon ni ni-edit"></em>
									</a>
								</div>';//style="display:'.$show.'"
							}else{
								$row[] = '<div class="btn-group btn-group-sm" >
									<a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickView(this.id)">
										<em class="icon ni ni-edit"></em>
									</a>
								</div>';//style="display:'.$show.'"
							}	
					}

					$data[] = $row;
				
            }
			// dumper($data);
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function mgmt()
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '2') && ($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		if($this->input->post('periodYear') == "" || $this->input->post('periodYear') == NULL){
			$year = $this->year - 1;
		}else{
			$year = $this->input->post('periodYear');
		}

		$data['ev_year'] = $year;

		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $this->division, 'evaluation_period' => $eval_year))->row_array();

		if ($this->session->userdata('second_division') != '') {

			$data['second_division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $this->second_division, 'evaluation_period' => $eval_year))->row_array();
			
			$data['second_total_team'] = $this->inbox_model->countTeam($this->second_division);
			$data['second_total_inprogress'] = $this->inbox_model->countRequest($this->second_division, '1',$eval_year);
			$data['second_total_approved'] = $this->inbox_model->countRequest($this->second_division, '3',$eval_year);
			$data['second_total_revise'] = $this->inbox_model->countRequest($this->second_division, '2',$eval_year);
			$data['second_total_a'] = $this->inbox_model->getTotalGrade($this->second_division, 'a',$eval_year);
			$data['second_total_b'] = $this->inbox_model->getTotalGrade($this->second_division, 'b',$eval_year);
			$data['second_total_c'] = $this->inbox_model->getTotalGrade($this->second_division, 'c',$eval_year);
			$data['second_total_d'] = $this->inbox_model->getTotalGrade($this->second_division, 'd',$eval_year);
			$data['second_total_e'] = $this->inbox_model->getTotalGrade($this->second_division, 'e',$eval_year);
			$content = 'inbox/pa_multi_division';
			
		} else {
			$content = 'inbox/pa_management';
		}

		//========================================DIVISION============================================//
		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $this->division, 'evaluation_period' => $eval_year))->row_array();
		// print_r($data['division_status']);
		// die;
		// echo $data['division_status']['is_status']."xxxx";
		// die;
		if(empty($data['division_status'])){
			$data['division_status']['is_status'] = 0;
		}

		// $data['total_team'] = $this->inbox_model->countTeamEligible($this->division);
		$data['total_team_eligible'] = $this->inbox_model->countTeamEligible($this->division);
		$data['total_talent_map'] = $this->inbox_model->countTalentTeam($this->division);
		$data['total_inprogress'] = $this->inbox_model->countRequest($this->division, '1', $eval_year);
		$data['total_approved'] = $this->inbox_model->countRequest($this->division, '3', $eval_year);
		$data['total_revise'] = $this->inbox_model->countRequest($this->division, '2', $eval_year);
		$data['total_a'] = $this->inbox_model->getTotalGrade($this->division, 'a', $eval_year);
		$data['total_b'] = $this->inbox_model->getTotalGrade($this->division, 'b', $eval_year);
		$data['total_c'] = $this->inbox_model->getTotalGrade($this->division, 'c', $eval_year);
		$data['total_d'] = $this->inbox_model->getTotalGrade($this->division, 'd', $eval_year);
		$data['total_e'] = $this->inbox_model->getTotalGrade($this->division, 'e', $eval_year);

		// $data['low_contributor'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Low Contributor");
		// $data['average_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Average Performer");
		// $data['solid_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Solid Performer");
		// $data['inconsistent_player'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Inconsistent Player");
		// $data['core_player'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Core Player");
		// $data['high_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"High Performer");
		// $data['potential_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Potential Performer");
		// $data['high_potential'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"High Potential");
		// $data['star'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Star");


		//====================BASIC LINE DEVISIASI=======================//
		$checkRevise = $this->inbox_model->checkDevisiasi($this->division, $year);
		if($checkRevise > 0){
			$data['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi($this->division, 'a', $year);
			$data['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi($this->division, 'b', $year);
			$data['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi($this->division, 'c', $year);
			$data['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi($this->division, 'd', $year);
			$data['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi($this->division, 'e', $year);
			
		}else{
			$data['devisiasi_basic_line_a'] = "";
			$data['devisiasi_basic_line_b'] = "";
			$data['devisiasi_basic_line_c'] = "";
			$data['devisiasi_basic_line_d'] = "";
			$data['devisiasi_basic_line_e'] = "";
		}
		//===============================================================//

		$data['ga_basic_line_a'] = "";
		$data['ga_basic_line_b'] = "";
		$data['ga_basic_line_c'] = "";
		$data['ga_basic_line_d'] = "";
		$data['ga_basic_line_e'] = "";

		$data['total_team'] = $this->inbox_model->countTeam($this->division);
		$data['total_inprogress'] = $this->inbox_model->countRequest($this->division, '1',$eval_year);
		$data['total_approved'] = $this->inbox_model->countRequest($this->division, '3',$eval_year);
		$data['total_revise'] = $this->inbox_model->countRequest($this->division, '2',$eval_year);
		$data['total_a'] = $this->inbox_model->getTotalGrade($this->division, 'a',$eval_year);
		$data['total_b'] = $this->inbox_model->getTotalGrade($this->division, 'b',$eval_year);
		$data['total_c'] = $this->inbox_model->getTotalGrade($this->division, 'c',$eval_year);
		$data['total_d'] = $this->inbox_model->getTotalGrade($this->division, 'd',$eval_year);
		$data['total_e'] = $this->inbox_model->getTotalGrade($this->division, 'e',$eval_year);
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = $content;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function viewSummary($type)
	{

		$status = $this->input->post('status');
		switch ($type) {
			case 'division':
				$data = $this->db->get_where('performance_appraisal', array('division' => $this->division, 'is_status' => $status))->result_array();
				break;

			case 'second_division':
				$data = $this->db->get_where('performance_appraisal', array('division' => $this->second_division, 'is_status' => $status))->result_array();
				break;
			
			default:
				# code...
				break;
		}

		$datadc = array();
		foreach($data as $key => $val){
			$val['employee_nik'] = $val['employee_nik'];
			$val['employee_name'] = decrypt($val['employee_name']);
			
			$datadc[$key] = $val;
		}
		
		$output = array('data' => $datadc);
		echo json_encode($output);
	}

	public function viewTeamMember($division){
		
		$div = $this->session->userdata('division');

		if (($div != '' || $div != null || !empty($div))) {
			if($division == "kadiv"){
				$data = $this->inbox_model->getTeamMemberKaDiv($div);
				$datadc = array();
				foreach($data as $key => $val){
					$val['nik'] = $val['nik'];
					$val['complete_name'] = decrypt($val['complete_name']);
					$val['email'] = decrypt($val['email']);
					$val['position'] = decrypt($val['position']);
					$datadc[$key] = $val;
				}
			}elseif($division == "ceo"){
				$data = $this->inbox_model->getTeamMemberCEO($email);
				$datadc = array();
				foreach($data as $key => $val){
					$val['nik'] = $val['employee_id'];
					$val['complete_name'] = $val['full_name'];
					$val['email'] = $val['user_email'];
					$datadc[$key] = $val;
				}
			}elseif($division == "pmo"){
				$data = $this->inbox_model->getTeamMemberPMO();
				$datadc = array();
				foreach($data as $key => $val){
					$val['nik'] = $val['nik'];
					$val['complete_name'] = decrypt($val['complete_name']);
					$val['email'] = decrypt($val['email']);
					$datadc[$key] = $val;
				}
			}

			$output = array('data' => $datadc);
		}else{
			$datadc = array();
			$val['nik'] = '';
			$val['complete_name'] = '';
			$val['email'] = '';
			$output = array('data' => $datadc);
		}
		echo json_encode($output);
		// die;
	}

	public function quickView()
	{
		$id = $this->input->post('id');
		$datas = $this->m_global->find('performance_appraisal', 'id', $id)->result_array();
		// print_r($datas);
		// die;
		$decrypt = array("employee_name","position","departement","division","direct_manager","office_location","employment_status","area_improvement","development_plan","comment_employee","comment_head_1","comment_head_2","created_by","updated_by","deleted_by","sub_total_kpi","grand_total_kpi","sub_total_qualitative","grand_total_qualitative","pre_final_score","final_score");
		$data = array();
		foreach($datas as $key => $val){
			foreach($val as $k => $v){
				if(in_array($k,$decrypt)){
					// echo $k." ec<br>";
					if($v != "0"){
						$data = array_merge($data, array($k=>decrypt($v)));
					}else{
						$data = array_merge($data, array($k=>$v));
					}
					
				}else{
					// echo $k." dc<br>";
					$data = array_merge($data, array($k=>$v));
				}
			}
		}
		echo json_encode($data);
	}

	public function readceo()
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		
		$listForm = $this->inbox_model->getDivHeadListByDivisionCeo($eval_year);
		// dumper($listForm);
		$division_status = $this->db->get_where('performance_division_status', array('division_name' => $this->session->userdata('division'), 'evaluation_period' => $eval_year))->row_array();
		if(empty($division_status['is_status'])){
			$division_status = 0;
		}else{
			$division_status = $division_status['is_status'];
		}
		if(empty($division_status)){
			$division_status = 0;
		}
		
        if (!empty($listForm)) {
            foreach ($listForm as $key) {

				$id_form_request = $this->m_global->find('form_request', 'request_number', $key->request_number)->row_array()['id'];
            	$count_layer = $this->db->get_where('form_approval', array('request_id' => $id_form_request))->num_rows();
				
            	$approval_priority = $this->db->get_where('form_approval', array('request_id' => $id_form_request, 'approval_email' => $this->email))->row_array()['approval_priority'];
				// die;
				// echo "Request ID = ".$key->id." | Email = ".$this->email."<br>";

            	$show = ($count_layer == $approval_priority) ? '' : 'none';

                $row   = array();
                $row[] = $key->employee_nik;
                $row[] = decrypt($key->employee_name);
                $row[] = decrypt($key->division);
                $row[] = decrypt($key->departement);
                $row[] = decrypt($key->position);
                $row[] = decrypt($key->direct_manager);
                $row[] = decrypt($key->office_location);
                $row[] = $key->join_date;
                $row[] = decrypt($key->employment_status);
                $row[] = decrypt($key->final_score);
                $row[] = grade_pa(decrypt($key->final_score));
                $row[] = status_text($key->is_status);
                $row[] = $key->full_approved_date;
                $row[] = $key->request_number;

                if ($division_status == 1) {
                	$row[] = '';
                
                } else if ($division_status == 3) {
                	$row[] = '<div class="btn-group btn-group-sm">
                            <a target="_blank" href="' . site_url('services/generate/result_document/kpi/'.encode_url($key->id)).'/'.$key->request_number.'" class="btn btn-icon btn-trigger"><em class="icon ni ni-printer"></em>
                            </a>
                    	</div>';
                } else {
                	$row[] = '<div class="btn-group btn-group-sm" style="display:'.$show.'">
                            <a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickView(this.id)">
                                <em class="icon ni ni-edit"></em>
                            </a>
                    	</div>';
                }

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function read_by_second_division($div)
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$division = str_replace('%20', ' ', $div);
		$listForm = $this->inbox_model->getDivHeadListByDivision($division);
		
		$second_division_status = $this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array()['is_status'];


        if (!empty($listForm)) {
            foreach ($listForm as $key) {

            	$count_layer = $this->db->get_where('form_approval', array('request_id' => $key->id))->num_rows();
            	$approval_priority = $this->db->get_where('form_approval', array('request_id' => $key->id, 'approval_email' => $this->email))->row_array()['approval_priority'];

            	$show = ($count_layer == $approval_priority) ? '' : 'none';

                $row  = array();
                $row[] = $key->employee_nik;
                $row[] = $key->employee_name;
                $row[] = $key->division;
                $row[] = $key->departement;
                $row[] = $key->position;
                $row[] = $key->direct_manager;
                $row[] = $key->office_location;
                $row[] = $key->join_date;
                $row[] = $key->employment_status;
                $row[] = $key->final_score;
                $row[] = grade_pa($key->final_score);
                $row[] = status_text($key->is_status);
                $row[] = $key->full_approved_date;
                $row[] = $key->request_number;
                // $row[] = $count_layer;

                if ($second_division_status == 1 || $second_division_status == 3) {
                	$row[] = '';
                } else {
                	$row[] = '<div class="btn-group btn-group-sm" style="display:'.$show.'">
                            <a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickView(this.id)">
                                <em class="icon ni ni-edit"></em>
                            </a>
                    	</div>';
                }

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function read_by_division($div)
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$division = str_replace('%20', ' ', $div);
		$listForm = $this->inbox_model->getDivHeadListByDivision($division);
		$second_division_status = $this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array()['is_status'];
		
        if (!empty($listForm)) {
            foreach ($listForm as $key) {

            	$count_layer = $this->db->get_where('form_approval', array('request_id' => $key->id))->num_rows();
            	$approval_priority = $this->db->get_where('form_approval', array('request_id' => $key->id, 'approval_email' => $this->email))->row_array()['approval_priority'];

            	$show = ($count_layer == $approval_priority) ? '' : 'none';

                $row  = array();
                $row[] = $key->employee_nik;
                $row[] = $key->employee_name;
                $row[] = $key->division;
                $row[] = $key->departement;
                $row[] = $key->position;
                $row[] = $key->direct_manager;
                $row[] = $key->office_location;
                $row[] = $key->join_date;
                $row[] = $key->employment_status;
                $row[] = $key->final_score;
                $row[] = grade_pa($key->final_score);
                $row[] = status_text($key->is_status);
                $row[] = $key->full_approved_date;
                $row[] = $key->request_number;
                // $row[] = $count_layer;

                if ($second_division_status == 1 || $second_division_status == 3) {
                	$row[] = '';
                } else {
                	$row[] = '<div class="btn-group btn-group-sm" style="display:'.$show.'">
                            <a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickView(this.id)">
                                <em class="icon ni ni-edit"></em>
                            </a>
                    	</div>';
                }

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function hr_confirmed()
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$year = $this->year - 1;
		$data['year'] = $year;
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/hr_confirmed';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hr_division()
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$year = $this->input->post('periodpasearch') != NULL ? $this->input->post('periodpasearch') != "" ? $this->input->post('periodpasearch') : "" : "";
		if($year == "" || $year == NULL){
			$year = $this->year - 1;
		}
		$data['year'] = $year;
		$eval_year = $year.'-01-01';
		$where = "is_status = 1 OR is_status = 3";
		$this->db->where($where);
		$this->db->where("evaluation_period", $eval_year);
		$data['division'] = $this->db->get('performance_division_status')->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/list_division';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hr_division_employee(){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/hr_division_employee';

		
		$div = $this->db->query("select division from v_hris_employee_updated where division != '' AND division != '".encrypt('HR SUPPORT')."' group by division")->result();
		// dumper($div);
		foreach($div as $key){
			$query = "select count(*) as tot
			from v_hris_employee_updated as a left join employee_update_division_pa as b on a.id_employee = b.id_employee and b.evaluation_year = '$year' where (a.action != '".encrypt('Leaving')."' or b.is_leaving = '1') AND
			case 
				when b.division != '' then b.division
				else a.division
			end = '".$key->division."'";
			$countEmployee = $this->db->query($query)->result();
			if($countEmployee[0]->tot > 0){
				$division[] = trim(str_replace("&","And",decrypt($key->division)));
			}
			
		}
		sort($division);
		$data['division_list'] = $division;
		
		// die;
		if(empty($_GET['division_name'])){
			$data['count_employee'] = 0;
			$data['total_team_eligible'] = 0;
			/////////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////////
			$data['checkDeviasi'] = 0;
			$data['division_status'] = 0;
			/////////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////////
		}else{
			$query = "select *,
			case
				when a.prev_joindate != '' then a.prev_joindate
			else
				a.join_date
			end as join_date,
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
			from v_hris_employee_updated as a left join employee_update_division_pa as b on a.id_employee = b.id_employee and b.evaluation_year = '$year' 
			where (a.action != '".encrypt('Leaving')."' or b.is_leaving = '1') AND
			case 
				when b.division != '' then b.division
				else a.division
			end = '".encrypt(str_replace("And","&",$_GET['division_name']))."'";
			// dumper($query);
			$data['list_employee'] = $this->db->query($query)->result();
			

			$query = "select *
			from v_hris_employee_updated as a left join employee_update_division_pa as b on a.id_employee = b.id_employee and b.evaluation_year = '$year' where (a.action != '".encrypt('Leaving')."' or b.is_leaving = '1') AND
			case 
				when b.division != '' then b.division
				else a.division
			end = '".encrypt(str_replace("And","&",$_GET['division_name']))."'";
			
			$result = $this->db->query($query)->result_array();
			$countEmployee = 0;
			foreach($result as $key => $val){
				$personnel_area		= decrypt($val['personnel_area']);
				$pers 				= substr($personnel_area,0,3);
				if($pers != "TIS"){
					$countEmployee++;
				}
				// $countEmployee
			}

			$data['count_employee'] = $countEmployee;
			
			$data['total_team_eligible'] = $this->inbox_model->countTeamEligible(encrypt(str_replace("And","&",$_GET['division_name'])));

			/////////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////////
			$data['checkDeviasi'] 	= $this->inbox_model->checkDevisiasi(encrypt($_GET['division_name']), $year);
			if($data['checkDeviasi'] > 0){
				// dumper("masuk");
				$data['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi(encrypt($_GET['division_name']), 'a', $year);
				$data['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi(encrypt($_GET['division_name']), 'b', $year);
				$data['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi(encrypt($_GET['division_name']), 'c', $year);
				$data['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi(encrypt($_GET['division_name']), 'd', $year);
				$data['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi(encrypt($_GET['division_name']), 'e', $year);
				// $data['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi(encrypt(str_replace("And","&",$_GET['division_name'])), 'a', $year);
				// $data['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi(encrypt(str_replace("And","&",$_GET['division_name'])), 'b', $year);
				// $data['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi(encrypt(str_replace("And","&",$_GET['division_name'])), 'c', $year);
				// $data['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi(encrypt(str_replace("And","&",$_GET['division_name'])), 'd', $year);
				// $data['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi(encrypt(str_replace("And","&",$_GET['division_name'])), 'e', $year);	
			}else{
				$data['devisiasi_basic_line_a'] = "";
				$data['devisiasi_basic_line_b'] = "";
				$data['devisiasi_basic_line_c'] = "";
				$data['devisiasi_basic_line_d'] = "";
				$data['devisiasi_basic_line_e'] = "";
			}

			$enc_divname 		= encrypt(str_replace("And","&",$_GET['division_name']));
			$division_status = "select is_status from performance_division_status where division_name = '$enc_divname' and evaluation_period = '$eval_year'";
			$data['division_status'] = (empty($this->db->query($division_status)->result_array()[0]['is_status'])) ? 0 : $this->db->query($division_status)->result_array()[0]['is_status'];
			/////////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////////
		}
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hr_preparation_pa(){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$year = $this->year-1;
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/hr_preparation_pa';
		$data['employee'] = $this->inbox_model->get_all_employee_except_leaving();
		$data_division = $this->inbox_model->get_all_division();
		foreach($data_division as $key => $val){
			$datadivisionok[] = array('division' => decrypt($val['division']));
		}
		sort($datadivisionok);
		$data['alldivision'] = $datadivisionok;

		$data['data_change'] = $this->db->query("select a.id, b.nik, b.complete_name, b.division as division_old, b.usrid_long2 as depthead_old, b.usrid_long3 as divhead_old, b.usrid_long4 as director_old,
		a.division as division_new, a.usrid_long2 as depthead_new, a.usrid_long3 as divhead_new, a.usrid_long4 as director_new
		from employee_update_division_pa as a left join hris_employee as b on a.id_employee = b.id_employee where evaluation_year = '{$year}' and a.is_leaving = '0'")->result_array();

		$data['is_ready'] = $this->inbox_model->check_ready($year);

		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function cancel_for_pa(){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		// echo $this->input->post('year');
		$insert = $this->inbox_model->cancel_for_pa($this->input->post('year'));
		echo $insert;
	}
	
	public function get_info_employee($nik){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$dataok = array();
		$data_employee = $this->inbox_model->get_employee($nik);
		foreach($data_employee as $key => $val){
			$dataok[] = array('division' => decrypt($val['division']), 'depthead_name' => decrypt($val['depthead_name']), 'divhead_name' => decrypt($val['divhead_name']), 'director_name' => decrypt($val['director_name']));
		}

		// $output = array('data' => $data_employee);
        echo json_encode($dataok);
		
	}

	public function get_bos_division($division = ""){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$division = decode_url($division);
		$division = str_replace("_","&",$division);
		$division = str_replace("%20"," ",$division);
		$division = encrypt($division);
		
		$data_bos = $this->inbox_model->get_bos_division($division);
		foreach($data_bos as $key => $val){
			if($val['depthead_name'] != ""){
				$depthead_name[] = decrypt($val['depthead_name']);
				
			}
			if($val['divhead_name'] != ""){
				$divhead_name[] = decrypt($val['divhead_name']);
			}
			if($val['director_name'] != ""){
				$director_name[] = decrypt($val['director_name']);
			}
		}

		if(empty($depthead_name)){
			$depthead_name = array();
		}else{
			array_unique($depthead_name);
		}
		if(empty($divhead_name)){
			$divhead_name = array();
		}else{
			array_unique($divhead_name);
		}
		if(empty($director_name)){
			$director_name = array();
		}else{
			array_unique($director_name);
		}
		$output = array('depthead' => $depthead_name, 'divhead' => $divhead_name, 'director' => $director_name);
		
		// $output = array('data' => $data_employee);
        echo json_encode($output);
		
	}

	public function hr_preparation_pa_update($is_leaving = '0'){
		$year = $this->year-1;
		$eval_year = $year."-01-01";

		$queryKar = "select id_employee from v_hris_employee_updated where nik = '".$this->input->post('nik')."'";
		$cekId = $this->db->query($queryKar)->result_array();
		$division = encrypt($this->input->post('change_division'));		

		$queryDivhead = "select email from v_hris_employee_updated where complete_name = '".encrypt($this->input->post('divhead'))."'";
		$divhead = $this->db->query($queryDivhead)->result_array();

		if(empty($divhead)){
			$divhead_email = '';
		}else{
			$divhead_email = $divhead[0]['email'];
		}

		$queryDirector = "select email from v_hris_employee_updated where complete_name = '".encrypt($this->input->post('director'))."'";
		$director = $this->db->query($queryDirector)->result_array();

		if(!empty($this->input->post('change_depthead'))){
			$queryDepthead = "select email, department from v_hris_employee_updated where complete_name = '".encrypt($this->input->post('change_depthead'))."'";
			$depthead = $this->db->query($queryDepthead)->result_array();
			$dept = $depthead[0]['email'];
			
			$insert = $this->db->query("
				insert into employee_update_division_pa 
				(id_employee, division, usrid_long2, usrid_long3, usrid_long4, evaluation_year,department, created_at, created_by, is_leaving)
				values (
					'".$cekId[0]['id_employee']."',
					'$division',
					'$dept',
					'".$divhead_email."',
					'".$director[0]['email']."',
					'$year',
					'".$depthead[0]['department']."',
					'".date("Y-m-d H:i:s")."',
					'".$this->session->userdata('user_email')."',
					'$is_leaving'
				)
			");


		}else{
			$dept = NULL;
			
			$insert = $this->db->query("
				insert into employee_update_division_pa 
				(id_employee, division, usrid_long3, usrid_long4, evaluation_year, created_at, created_by, is_leaving)
				values (
					'".$cekId[0]['id_employee']."',
					'$division',
					'".$divhead_email."',
					'".$director[0]['email']."',
					'$year',
					'".date("Y-m-d H:i:s")."',
					'".$this->session->userdata('user_email')."',
					'$is_leaving'
				)
			");
		}

		if($is_leaving > 0){
			redirect('/inbox/change_division_leaving_employee/', 'refresh');
		}else{
			redirect('/inbox/hr_preparation_pa/', 'refresh');
		}
		
		die;
	}

	public function change_division_leaving_employee(){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$year = $this->year-1;
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/hr_preparation_pa_leaving_employee';
		$data['employee'] = $this->inbox_model->get_all_employee_leaving();
		$data_division = $this->inbox_model->get_all_division();
		foreach($data_division as $key => $val){
			$datadivisionok[] = array('division' => decrypt($val['division']));
		}
		sort($datadivisionok);
		$data['alldivision'] = $datadivisionok;
		

		$data['data_change'] = $this->db->query("select a.id, b.nik, b.complete_name, b.division as division_old, b.usrid_long2 as depthead_old, b.usrid_long3 as divhead_old, b.usrid_long4 as director_old,
		a.division as division_new, a.usrid_long2 as depthead_new, a.usrid_long3 as divhead_new, a.usrid_long4 as director_new
		from employee_update_division_pa as a left join hris_employee as b on a.id_employee = b.id_employee where evaluation_year = '{$year}' and a.is_leaving = '1'")->result_array();

		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function ready_for_pa(){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$insert = $this->inbox_model->ready_for_pa($this->input->post('year'));
		echo $insert;
	}

	public function hr_preparation_pa_delete(){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$delete = $this->inbox_model->hr_preparation_pa_delete($this->input->post('id'));
		echo $delete;
	}

	public function divhead_pa_leaving_employee(){
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$eval_year = $this->year-1;
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/divhead_pa_leaving_employee';
		$div = $this->db->query("select division from hris_employee where division != '' group by division")->result();
		
		foreach($div as $key){
			$division[] = decrypt($key->division);
		}
		sort($division);
		$data['list_division'] = $division;

		// $data['list'] = $this->db->query("select * from access_divhead_leaving_employee where evaluation_year = '$eval_year' and is_active = '1'")->result();
		$data['list'] = $this->db->query("select * from access_divhead_leaving_employee where evaluation_year = '$eval_year'")->result();
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function save_access_divhead_pa_leaving($id = ""){

		$eval_year = $this->year-1;
		if($this->input->post()){

			foreach($this->input->post() as $key => $val){
				$data[$key] = $val;
			}

			$data['evaluation_year'] = $eval_year;
			
			$save = $this->inbox_model->save_access_divhead_pa_leaving($id,$data);
			if($save){
				echo 1;
			}else{
				echo 0;
			}
		}

	}

	public function delete_access_divhead_pa_leaving($id){

		$data['updated_at'] = date("Y-m-d H:i:s");
		$data['updated_by'] = $this->email;
		$data['is_active'] = 0;
		$this->db->set($data);
		$this->db->where('id',$id);
		$update = $this->db->update('access_divhead_leaving_employee');
		if($update){
			echo 1;
		}else{
			echo 0;
		}

	}

	public function get_access_divhead_pa_leaving($id){
		$data = $this->inbox_model->get_access_divhead_pa_leaving($id);

		echo json_encode($data);
	}

	public function get_uom($id){
		$data = $this->inbox_model->get_uom($id);

		echo json_encode($data);
	}

	public function add_pa_leaving_employee(){
		$year = $this->year-1;
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/add_pa_leaving_employee';
		
		// dumper($this->session->userdata('division'));
		$query = "select b.email, a.id, b.nik, b.complete_name, b.division as division_old, b.usrid_long2 as depthead_old, b.usrid_long3 as divhead_old, b.usrid_long4 as director_old,
		a.division as division_new, a.usrid_long2 as depthead_new, a.usrid_long3 as divhead_new, a.usrid_long4 as director_new
		from employee_update_division_pa as a left join hris_employee as b on a.id_employee = b.id_employee where evaluation_year = '{$year}' and a.division = '".$this->session->userdata('division')."' 	and a.is_leaving = '1'";
		
		$data['list'] = $this->db->query($query)->result_array();
		
		foreach($data['list'] as $key => $val){
		
			$cek = $this->db->query("select * from performance_appraisal where evaluation_period_start = '".$year."-01-01' and employee_nik = '".$val['nik']."'")->result_array();
			if(empty($cek)){
				$dataemployee[] = [
					"email" => $val['email'],
					"id" => $val['id'],
					"complete_name" => $val['complete_name'],
					"division_old" => $val['division_old'],
					"depthead_old" => $val['depthead_old'],
					"divhead_old" => $val['divhead_old'],
					"director_old" => $val['director_old'],
					"division_new" => $val['division_new'],
					"depthead_new" => $val['depthead_new'],
					"divhead_new" => $val['divhead_new'],
					"director_new" => $val['director_new']
				];

				$data['list_employee'] = $dataemployee;
			}
			

		}


		$data['list_pa'] = $this->db->select('*')->from('performance_appraisal')->where([
			'division' => $this->session->userdata('division'),
			'is_leaving' => 1,
			'evaluation_period_start' => $year."-01-01"
		])->get()->result_array();
		// dumper($data['list_pa']);
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function proses_pa_leaving_employee($formType = "KPI")
	{

		$emailnya = $this->input->post('email');
		$final_score = $this->input->post('final_score');
		$year = $this->year-1;

		$is_ready = $this->inbox_model->check_ready($year);
		if($is_ready == 0){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Error</strong> NOT READY PA
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			</button>
			</div>');
			redirect('/inbox/add_pa_leaving_employee', 'refresh');
			die;

		}

		$table = $this->m_global->getRow('header_table', 'form_type', array('code' => $formType));
		
		$requestNumber = $this->getRequestNumberLeaving(strtoupper($formType), $table['header_table']);
		
		switch ($formType) {

			case 'KPI':
			

				$dataEmployee = $this->db->query("
				SELECT *, a.id_employee,
				case 
					when c.department != '' then c.department
				else
					a.department
				end as department, 
				case 
					when c.id_employee != '' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				WHERE lower(a.email) = '".encrypt($emailnya)."'
				ORDER BY a.id_employee DESC
				")->result_array();

				$dataEmployee[0]['employee_subgroup'] = $this->session->userdata('employee_subgroup');
				$dataEmployee[0]['final_score'] = encrypt($final_score);
				
				$chekRecord = $this->form_model->check_KPIPLAN(encrypt($emailnya));
				if($chekRecord != ""){
					$this->logs('system', $formType, 0, 'Initial Create', 'Cannot make KPI twice in same period.');
					$response = array('status' => 2, 'message' => 'You have made PA / Plan form in this period before '.$chekRecord);
					header('Content-type: application/json');
					echo json_encode($response);
					die;
				}
				

				$requestId = $this->form_model->initial_create_pa_leaving($formType, $dataEmployee,$requestNumber, $table['header_table']);

				//======================auto generate approval===========================//
				

				break;
			
			default:
				break;
		}

		if ($requestId) {
			$this->logs('create', $formType, $requestId,'Add pa leaving employee');
			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Success</strong> SUCCESS ADD
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			</button>
			</div>');
			redirect('/inbox/add_pa_leaving_employee', 'refresh');
			die;

		} else {
			$this->logs('system', $formType, $requestId, 'Initial Create', 'Something went wrong with request id.');
			$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Error</strong> FAILED
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			</button>
			</div>');
			redirect('/inbox/add_pa_leaving_employee', 'refresh');
			die;
		}
		
	}

	private function getRequestNumberLeaving($formType, $table)
	{
		if($formType != "KPI" and $formType != "PLAN"){
			$this->db->select_max('id');
			$eid = $this->db->get($table)->row_array();
			$reqnum = $eid['id'] + 1;
			$requestNumber = 'HRIS_' . $formType . '_V2' . str_pad($reqnum, 6, 0, STR_PAD_LEFT);
		}else{
			$this->db->select_max('id');
			$eid = $this->db->get($table)->row_array();
			$reqnum = $eid['id'] + 1;
			$requestNumber = 'HRIS_' . $formType . '_' . str_pad($reqnum, 6, 0, STR_PAD_LEFT);
			
		}
		return $requestNumber;
	}

	public function hr_view($division, $year="")
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$division = decode_url($division);
		if($year == "" || $year == NULL){
			$year = $this->year - 1;
		}
		$eval_year = $year.'-01-01';

		$data['year'] = $year;
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList($year));

		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/form/details_division';
		// dumper($division);
		$division_name = str_replace(array('%20','*'), array(' ', '&'), $division);
		// dumper($division_name." - ".$division);
		$division_name = encrypt($division_name);
		
	
		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $division_name, 'evaluation_period' => $eval_year))->row_array();
		$data['total_team'] = $this->inbox_model->countTeamHR($division_name,$data['division_status']['updated_by']);
		$data['total_approved'] = $this->inbox_model->countRequest($division_name, '3', $eval_year);
		$data['total_inprogress'] = $this->inbox_model->countRequest($division_name, '1', $eval_year);
		$data['total_revise'] = $this->inbox_model->countRequest($division_name, '2', $eval_year);
		$data['total_a'] = $this->inbox_model->getTotalGrade($division_name, 'a', $eval_year);
		$data['total_b'] = $this->inbox_model->getTotalGrade($division_name, 'b', $eval_year);
		$data['total_c'] = $this->inbox_model->getTotalGrade($division_name, 'c', $eval_year);
		$data['total_d'] = $this->inbox_model->getTotalGrade($division_name, 'd', $eval_year);
		$data['total_e'] = $this->inbox_model->getTotalGrade($division_name, 'e', $eval_year);
		$data['total_team_eligible'] = $this->inbox_model->countTeamEligible($division_name, $year);

		
		//====================BASIC LINE DEVISIASI=======================//
		$checkRevise = $this->inbox_model->checkDevisiasi(encrypt($division), $year);
		if($checkRevise > 0){
			$data['check_devisiasi'] 		= $this->inbox_model->devisiasi(encrypt($division), $year);
			$data['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi(encrypt($division), 'a', $year);
			$data['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi(encrypt($division), 'b', $year);
			$data['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi(encrypt($division), 'c', $year);
			$data['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi(encrypt($division), 'd', $year);
			$data['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi(encrypt($division), 'e', $year);
			
		}else{
			$data['devisiasi_basic_line_a'] = "";
			$data['devisiasi_basic_line_b'] = "";
			$data['devisiasi_basic_line_c'] = "";
			$data['devisiasi_basic_line_d'] = "";
			$data['devisiasi_basic_line_e'] = "";
		}

		$division = str_replace("-","&",$division);
		$division = str_replace("%20"," ",$division);
		$division_cek = str_replace("&","-",$division);
		$division_cek = str_replace(" ","_",$division_cek);
		$data['division'] = $division_cek;

		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read_hr_review($division, $year="")
    {
		$division = decode_url($division);
		if( $year == "" || $year == NULL){
			$year = $this->year - 1;
		}
		
		$eval_year = $year.'-01-01';
		$division_name = str_replace(array('%20'), array(' ', '&'), $division);
		$division_name = encrypt($division_name);
		$listForm = $this->inbox_model->getHRReview($division_name, $eval_year);
        if (!empty($listForm)) {
            foreach ($listForm as $key) {
                $row   = array();
                $row[] = $key->employee_nik;
                $row[] = decrypt($key->employee_name);
                $row[] = decrypt($key->division);
                $row[] = decrypt($key->departement);
                $row[] = decrypt($key->position);
                $row[] = decrypt($key->direct_manager);
                $row[] = decrypt($key->office_location);
                $row[] = $key->join_date;
                $row[] = decrypt($key->employment_status);
                $row[] = decrypt($key->final_score);
                $row[] = grade_pa(decrypt($key->final_score));
                $row[] = status_text($key->is_status);
                $row[] = $key->full_approved_date;
                $row[] = $key->request_number;
            	$row[] = '';

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }


	public function mgmt_mul($year="")
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '2') && ($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		
		if($year == "" || $year == NULL){
			$year = $this->year - 1;
			$eval_year = $year.'-01-01';
		}else{
			$eval_year = $year.'-01-01';
		}
		// $year = $this->year - 1;
		// $eval_year = $year.'-01-01';
		// if($this->input->post('periodYear') == "" || $this->input->post('periodYear') == NULL){
		// 	$year = $this->year - 1;
		// 	$eval_year = $year.'-01-01';
		// }else{
		// 	$year = $this->input->post('periodYear');
		// 	$eval_year = $year.'-01-01';
		// }

		$data['ev_year'] = $year;
		$data['year'] = $year;

		$sql = "SELECT division FROM multi_division WHERE nik = '".$this->nik."' AND eval_year = '".$year."'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		$no = 1;
		$data_div = array();
		if (empty($res)) {
			if(!empty($this->division)){

				$sql = "SELECT division FROM multi_division WHERE division = '".$this->division."' AND eval_year = '".$year."'";
				$query = $this->db->query($sql);
				$res = $query->num_rows();
				if($res < 1){
					$division['division'] = $this->division;
					$res = array($division);

					foreach ($res as $key) {
						$row   = array();
							$row['no'] = $no;
							$division = $key['division'];
							//========================================DIVISION============================================//
							$row['division'] = $division;
							$div_status = $this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array();
							
							if(empty($div_status)){
								$row['division_status'] = 0;
							}else{
								$row['division_status'] = $div_status['is_status'];
							}
			
							$row['total_team'] = $this->inbox_model->countTeam($division);
							$row['total_team_eligible'] = $this->inbox_model->countTeamEligible($division);
							$row['total_talent_map'] = $this->inbox_model->countTalentTeam($division);
							$row['total_inprogress'] = $this->inbox_model->countRequest($division, '1', $eval_year);
							$row['total_approved'] = $this->inbox_model->countRequest($division, '3', $eval_year);
							$row['total_revise'] = $this->inbox_model->countRequest($division, '2', $eval_year);
							$row['total_a'] = $this->inbox_model->getTotalGrade($division, 'a', $eval_year);
							$row['total_b'] = $this->inbox_model->getTotalGrade($division, 'b', $eval_year);
							$row['total_c'] = $this->inbox_model->getTotalGrade($division, 'c', $eval_year);
							$row['total_d'] = $this->inbox_model->getTotalGrade($division, 'd', $eval_year);
							$row['total_e'] = $this->inbox_model->getTotalGrade($division, 'e', $eval_year);
			
			
							//====================BASIC LINE DEVISIASI=======================//
							$checkRevise = $this->inbox_model->checkDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), $year);
							if($checkRevise > 0){
								$row['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'a', $year);
								$row['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'b', $year);
								$row['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'c', $year);
								$row['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'd', $year);
								$row['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'e', $year);
								
							}else{
								$row['devisiasi_basic_line_a'] = "";
								$row['devisiasi_basic_line_b'] = "";
								$row['devisiasi_basic_line_c'] = "";
								$row['devisiasi_basic_line_d'] = "";
								$row['devisiasi_basic_line_e'] = "";
							}
							//===============================================================//
							
							$row['total_inprogress'] = $this->inbox_model->countRequest($division, '1',$eval_year);
							$row['total_approved'] = $this->inbox_model->countRequest($division, '3',$eval_year);
							$row['total_revise'] = $this->inbox_model->countRequest($division, '2',$eval_year);
							$row['total_a'] = $this->inbox_model->getTotalGrade($division, 'a',$eval_year);
							$row['total_b'] = $this->inbox_model->getTotalGrade($division, 'b',$eval_year);
							$row['total_c'] = $this->inbox_model->getTotalGrade($division, 'c',$eval_year);
							$row['total_d'] = $this->inbox_model->getTotalGrade($division, 'd',$eval_year);
							$row['total_e'] = $this->inbox_model->getTotalGrade($division, 'e',$eval_year);
							$data_div[] = $row;
							$no ++;
					}
				}else{
					$division['division'] = 'Not Division';
					$res = array($division);
				}
				
			}else{
				$division['division'] = 'Not Division';
				$res = array($division);
			}
		}else{

			foreach ($res as $key) {
				$row   = array();
					$row['no'] = $no;
					$division = $key['division'];
					//========================================DIVISION============================================//
					$row['division'] = $division;
					
					$div_status = $this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array();
					
					if(empty($div_status)){
						$row['division_status'] = 0;
					}else{
						$row['division_status'] = $div_status['is_status'];
					}
	
					$row['total_team'] = $this->inbox_model->countTeam($division);
					$row['total_team_eligible'] = $this->inbox_model->countTeamEligible($division);
					$row['total_talent_map'] = $this->inbox_model->countTalentTeam($division);
					$row['total_inprogress'] = $this->inbox_model->countRequest($division, '1', $eval_year);
					$row['total_approved'] = $this->inbox_model->countRequest($division, '3', $eval_year);
					$row['total_revise'] = $this->inbox_model->countRequest($division, '2', $eval_year);
					$row['total_a'] = $this->inbox_model->getTotalGrade($division, 'a', $eval_year);
					$row['total_b'] = $this->inbox_model->getTotalGrade($division, 'b', $eval_year);
					$row['total_c'] = $this->inbox_model->getTotalGrade($division, 'c', $eval_year);
					$row['total_d'] = $this->inbox_model->getTotalGrade($division, 'd', $eval_year);
					$row['total_e'] = $this->inbox_model->getTotalGrade($division, 'e', $eval_year);
					// dumper($row['total_e']);
	
	
					//====================BASIC LINE DEVISIASI=======================//
					$checkRevise = $this->inbox_model->checkDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), $year);
					if($checkRevise > 0){
						$row['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'a', $year);
						$row['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'b', $year);
						$row['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'c', $year);
						$row['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'd', $year);
						$row['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi((encrypt(str_replace("&","And",decrypt($division)))), 'e', $year);
						
					}else{
						$row['devisiasi_basic_line_a'] = "";
						$row['devisiasi_basic_line_b'] = "";
						$row['devisiasi_basic_line_c'] = "";
						$row['devisiasi_basic_line_d'] = "";
						$row['devisiasi_basic_line_e'] = "";
					}
					//===============================================================//
					
					// $row['total_inprogress'] = $this->inbox_model->countRequest($division, '1',$eval_year);
					// $row['total_approved'] = $this->inbox_model->countRequest($division, '3',$eval_year);
					// $row['total_revise'] = $this->inbox_model->countRequest($division, '2',$eval_year);
					// $row['total_a'] = $this->inbox_model->getTotalGrade($division, 'a',$eval_year);
					// $row['total_b'] = $this->inbox_model->getTotalGrade($division, 'b',$eval_year);
					// $row['total_c'] = $this->inbox_model->getTotalGrade($division, 'c',$eval_year);
					// $row['total_d'] = $this->inbox_model->getTotalGrade($division, 'd',$eval_year);
					// $row['total_e'] = $this->inbox_model->getTotalGrade($division, 'e',$eval_year);
					$data_div[] = $row;
					$no ++;
			}

		}
		// dumper($data_div);
		$data['data_div'] = $data_div;

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

		$content = 'inbox/pa_management_mul';
		$data['content'] = $content;

		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function readpa_mul($division)
    {
		$division = decode_url($division);
		$year 		= $this->year - 1;
		$eval_year 	= $year.'-01-01';

		$listForm = $this->inbox_model->getDivHeadListByDivision($division, $eval_year);
		
		$division_status = $this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array();
		
		if(empty($division_status['is_status'])){
			$division_status = 0;
		}else{
			$division_status = $division_status['is_status'];
		}
		if(empty($division_status)){
			$division_status = 0;
		}
		
        if (!empty($listForm)) {
            foreach ($listForm as $key) {

					$req_id = $this->db->select('id')->from('form_request')->where(['request_number' => $key->request_number])->get()->result();
				
					$count_layer = $this->db->get_where('form_approval', array('request_id' => $req_id[0]->id))->num_rows();
					$approval_priority = isset($this->db->get_where('form_approval', array('request_id' => $req_id[0]->id, 'approval_email' => encrypt($this->email)))->row_array()['approval_priority']);
					
					$row   = array();
					$row[] = decrypt($key->employee_nik);
					$row[] = decrypt($key->employee_name);
					$row[] = decrypt($key->division);
					$row[] = decrypt($key->departement);
					$row[] = decrypt($key->position);
					$row[] = decrypt($key->direct_manager);
					$row[] = decrypt($key->office_location);
					$row[] = $key->join_date;
					$row[] = decrypt($key->employment_status);
					$row[] = decrypt($key->final_score);
					$row[] = grade_pa(decrypt($key->final_score));
					$row[] = status_text($key->is_status);
					$row[] = $key->full_approved_date;
					$row[] = $key->request_number;

					if ($division_status == 1) {
						$row[] = "";//$division_status;//'';
					
					} else if ($division_status == 3) {
						if($key->new_employee_flag != 1){
							$row[] = '<div class="btn-group btn-group-sm">
								<a target="_blank" href="' . site_url('services/generate/result_document/kpi/'.encode_url($key->id)).'/'.$key->request_number.'" class="btn btn-icon btn-trigger"><em class="icon ni ni-printer"></em>
								</a>
							</div>';
						}else{
							$row[] = "";//$division_status;//'';
						}
						
					} else {

						// $sql0 = "SELECT *
						// 	FROM form_request as a left join form_approval as b on a.id = b.request_id
						// 	WHERE a.request_number LIKE '".$key->request_number."' AND b.approval_status = 'Approved' AND b.approval_priority = '1' AND b.approval_email LIKE 'MAKMUR.JAURY@IBSMULTI.COM'";
						// $query0 = $this->db->query($sql0);
						// $res0 = $query0->row();

						// if(!empty($res)){
						// 	$row[] = '<div class="btn-group btn-group-sm" >
						// 		<a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickView(this.id)">
						// 			<em class="icon ni ni-edit"></em>
						// 		</a>
						// 	</div>';//style="display:'.$show.'"
						// }else{
							$sql = "SELECT *
										FROM performance_appraisal a left join performance_division_status as b on a.division = b.division_name and a.evaluation_period_start = b.evaluation_period
										WHERE a.request_number LIKE '".$key->request_number."' AND (b.is_status = '3' or b.is_status = '1')";
							$query = $this->db->query($sql);
							$res = $query->row();
							if(!empty($res)){
								$row[] = '<div class="btn-group btn-group-sm" >
									<a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickViewReadonly(this.id)">
										<em class="icon ni ni-edit"></em>
									</a>
								</div>';//style="display:'.$show.'"
							}else{
								$row[] = '<div class="btn-group btn-group-sm" >
									<a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickView(this.id)">
										<em class="icon ni ni-edit"></em>
									</a>
								</div>';//style="display:'.$show.'"
							}	
						// }
					}

					$data[] = $row;
				
            }
			// dumper($data);
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function viewTeamMemberMul($division){
		
		$div = $_POST['division'];

		if (($div != '' || $div != null || !empty($div))) {
			if($division == "kadiv"){
				$data = $this->inbox_model->getTeamMemberKaDivMul($div);
				// dumper($data);
				$datadc = array();
				$year = date("Y")-1;
				foreach($data as $key => $val){
					$join_date           = strtotime(decrypt($val['join_date']));
					$join_date           = date('Y-m-d', $join_date);
					if($join_date <= $year.'-09-30'){
						$status = "Eligible";
					}else{
						$status = "Not Eligible";
					}
					$val['nik'] = $val['nik'];
					$val['complete_name'] = decrypt($val['complete_name']);
					$val['email'] = decrypt($val['email']);
					$val['position'] = decrypt($val['position']);
					$val['status'] = $status;
					$datadc[$key] = $val;
				}
			}elseif($division == "ceo"){
				$data = $this->inbox_model->getTeamMemberCEO($email);
				$datadc = array();
				foreach($data as $key => $val){
					$val['nik'] = $val['employee_id'];
					$val['complete_name'] = $val['full_name'];
					$val['email'] = $val['user_email'];
					$datadc[$key] = $val;
				}
			}

			$output = array('data' => $datadc);
		}else{
			$datadc = array();
			$val['nik'] = '';
			$val['complete_name'] = '';
			$val['email'] = '';
			$output = array('data' => $datadc);
		}
		echo json_encode($output);
		// die;
	}

	public function viewSummaryMul($type)
	{
		
		$status = $this->input->post('status');
		$division = encrypt($this->input->post('division'));
		switch ($type) {
			case 'division':
				$data = $this->db->get_where('performance_appraisal', array('division' => $division, 'is_status' => $status))->result_array();
				break;

			case 'second_division':
				$data = $this->db->get_where('performance_appraisal', array('division' => $division, 'is_status' => $status))->result_array();
				break;
			
			default:
				# code...
				break;
		}

		$datadc = array();
		foreach($data as $key => $val){
			$val['employee_nik'] = $val['employee_nik'];
			$val['employee_name'] = decrypt($val['employee_name']);
			
			$datadc[$key] = $val;
		}
		
		$output = array('data' => $datadc);
		echo json_encode($output);
	}

	public function responseRequestPa2()
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');
		$approval_id = $this->input->post('approval_id');
		$response = $this->input->post('resp');

		$requestor = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['created_by'];
		$request_number = $this->m_global->find('performance_appraisal', 'id', $request_id)->row_array()['request_number'];
		$id_form_request = $this->m_global->find('form_request', 'request_number', $request_number)->row_array()['id'];

		$data_response = array(
			'approval_status' => $response, 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		// previous layer
		$priority = $this->m_global->find('form_approval', 'id', $approval_id)->row_array()['approval_priority'];
		$prev_priority = $priority-1;
		$prev_id = $this->inbox_model->find_select("id",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$id_form_request))->row_array();

		$prev_email = $this->inbox_model->find_select("approval_email",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$id_form_request))->row_array();

		$data_prev_layer = array(
			'approval_status' => 'In Progress', 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		switch ($response) {

			case 'Revised':

				if ($priority != 1) {

					$current_layer = array(
						'approval_status' => 'Revised to previous layer', 
						'updated_at' => $this->date, 
						'updated_by' => $this->email
					);

					$this->db->where('id', $approval_id);
					if ($this->db->update('form_approval', $current_layer)) {
						//////////REVISE sendEmailPA///////////////////
						$this->m_services->sendEmailPA($request_id,'revise_2');

						$this->db->where('id', $prev_id['id']);
						if ($this->db->update('form_approval', $data_prev_layer)) {
							// $this->db->where('id', $request_id);
							// $this->db->update('performance_appraisal', array('updated_by' => $this->email, 'updated_at' => $this->date, 'comment_head_2' => encrypt($comment)));
							$this->logs('revised', 'KPI', $id_form_request, 'Response revised', 'Revised');
							$output = array('status' => 1);
							
						}

						//////////REVISE sendEmailPA INFO///////////////////
						$this->m_services->sendEmailPA($request_id,'revise_info');
						
					}

				} else {

					$this->db->where('id', $request_id);
					// if ($this->db->update('performance_appraisal', array('is_status' => 2, 'updated_by' => encrypt($this->email), 'updated_at' => $this->date, 'comment_head_1' => encrypt($comment)))) {
					if ($this->db->update('performance_appraisal', array('is_status' => 2, 'updated_by' => encrypt($this->email), 'updated_at' => $this->date))) {
						//////////REVISE sendEmailPA///////////////////
						$this->m_services->sendEmailPA($request_id,'revise_1');
						if ($this->db->where('request_id', $id_form_request)->delete('form_approval')) {
							$this->logs('revised', 'KPI', $id_form_request, 'Response revised', 'Revised');
							$output = array('status' => 1);
						}
					}

				}

				break;
			
			default:
				break;
		}
		echo json_encode($output);
	}


	public function kurva_devisiasi(){
		if($this->input->post()){
			$jumlah = 0;
			foreach($this->input->post('basic_line') as $key => $val){
				$jumlah = $jumlah + (int)$val;
			}
			
			if($jumlah != $this->input->post('hr_te')){
				$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error</strong> The division PA cannot be revised, because the total basic line deviation is not equal to the total team eligible.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				</button>
				</div>');

			redirect('/inbox/hr_view/'.encode_url($this->input->post('division_name')), 'refresh');
			}

			$year = $this->year-1;
			$eval_year = $year."-01-01";
			$division_name = $this->input->post('division');
			$division = $this->input->post('division');
			$division_status = $this->db->get_where('performance_division_status', array('division_name' => $division_name, 'evaluation_period' => $eval_year))->result();

			// //===========================UPLOAD FILE IOM====================================//
			// $file_name = str_replace(" ","",decrypt($division_name))."_".$year;
			// $config['upload_path']          = FCPATH.'/upload/iom/';
			// $config['allowed_types']        = 'img|jpg|jpeg|pdf';
			// $config['file_name']            = $file_name;
			// $config['overwrite']            = true;
			// $config['max_size']             = 1024; // 1MB
			// $config['max_width']            = 1080;
			// $config['max_height']           = 1080;

			// $this->load->library('upload', $config);

			// if (!$this->upload->do_upload('iom_file')) {
			// 	$data['error'] = $this->upload->display_errors();
			// 	echo $data['error'];
			// 	die;
			// 	$this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			// 	<strong>Error</strong> '.$data['error'].'
			// 	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			// 	</button>
			// 	</div>');
			// 	redirect('/inbox/hr_view/'.$this->input->post('division_name'), 'refresh');
			// 	die;
			// } else {
			// 	$uploaded_data = $this->upload->data();

			// 	$new_data = [
			// 		'iom_file' => $uploaded_data['file_name'],
			// 	];
		
			// 	$this->db->where('id', $division_status[0]->id);
			// 	$this->db->update('performance_division_status', $new_data);
			// }


			foreach($this->input->post('basic_line') as $key => $val){

				if($val == ""){
					$val = 0;
				}

				$cek = $this->db->query("select * from kurva_devisiasi where division = '$division' and grade = '$key' and year = '$year'")->result();
				if(count($cek) == 0){
					$this->db->insert('kurva_devisiasi', ['year' => $year, 'grade' => $key, 'basic_line' => $val, 'division' => $division]);
				}else{
					$this->db->where('id', $cek[0]->id);
					$this->db->update('kurva_devisiasi', ['year' => $year, 'grade' => $key, 'basic_line' => $val, 'division' => $division]);
				}



			}
			
			$formData = array(
				'is_status' => 2,
				'response_by' => encrypt($this->email),
				'response_at' => $this->date
			);

			$div_head_email = $this->db->get_where('performance_division_status', array('id' => $this->input->post('id')))->row_array()['updated_by'];

			$this->db->where('id', $this->input->post('id'));
			if ($this->db->update('performance_division_status', $formData)) {
				//////////REVISE HR sendEmailPA///////////////////
				$this->m_services->sendEmailHRPA($division,$eval_year,'revised');
				$this->logs('revised_by_hr', 'KPI', $this->input->post('id'), 'Revised by HR');
				$response = array('status' => 1);

			}

			

			$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Success</strong> PA division has been revised.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			</button>
			</div>');

			redirect('/inbox/hr_view/'.encode_url($this->input->post('division_name')), 'refresh');

		}
		
	}
	/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////

	//////////////////// START TIME MANAGEMENT 2024////////////////////
	public function approval_TM_ztm()
	{
		$data['header'] = $this->inbox_model->getApprovalList();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['header_tm_cek'] = $this->inbox_model->getApprovalListTMCek_ztm(0);
		$data['header_tm_rejected'] = $this->inbox_model->getApprovalListTMRejected_ztm(0);
		$data['header_tm_approved'] = $this->inbox_model->getApprovalListTMApproved_ztm(0);
		$data['header_tm_hr'] = $this->inbox_model->getApprovalListTMHR_ztm(7); //TIME MANAGEMENT 2.0
		$data['header_tm_shift'] = $this->inbox_model->getApprovalListTMShift_ztm();
		$data['formType'] = $this->form_model->getFormType();
		//start update 2026
		$data['nik_user'] = $this->nik;
		//end update 2026
		$data['content'] = 'inbox/list_approval_tm';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function responseRequestTMHR()
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');

		$response = $this->input->post('resp');

		//GET FORM TYPE
		$sqlForm = "SELECT form_type, request_number FROM form_request WHERE id = '$request_id'";
		$queryForm = $this->db->query($sqlForm);
		$resForm = $queryForm->result();
		$tipe_form = $resForm[0]->form_type;
		$req_no = $resForm[0]->request_number;

		switch ($response) {

			case 'Reject':			

					$sqlForm = "SELECT is_status FROM form_request WHERE id = '$request_id'";
					$queryForm = $this->db->query($sqlForm);
					$resForm = $queryForm->result();
					$status_form = $resForm[0]->is_status;

					if($status_form != '3'){
						$this->db->where('request_id', $request_id);
						$this->db->delete('form_approval');
						$this->db->where('id', $request_id);
						if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

							$this->db->where('request_number', $req_no);
							$this->db->update('hris_time_management_adjustment', array('status' => 2));
							
							$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1);
						}
					}else{

						$this->db->where('request_id', $request_id);
						$this->db->delete('form_approval');
						$this->db->where('id', $request_id);
						if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

							///////////////////////////////////////// START UPDATE 17102024 TIME MANAGEMENT /////////////////////////////////////////////
							$this->db->select('*');
							$this->db->from('hris_time_management_adjustment');
							$this->db->where('request_number', $req_no);
							$get_adjustment = $this->db->get()->result();

							$today = date('Y-m-d');

									foreach ($get_adjustment as $value){
										$employee_nik = $value->nik_karyawan;
										$start_date = $value->start_date;

										if ($value->kode_modul == 'ACT'){

											$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$employee_nik' ORDER BY id DESC LIMIT 1";
											$queryTotal = $this->db->query($sqlTotal);
											$resultTotal = $queryTotal->result_array();
								
											if(!empty($resultTotal)){
												$total_cuti = $resultTotal[0]['total_cuti'] - $value->jumlah_perubahan;
											} else {
												$total_cuti = $value->jumlah_perubahan;
											}

											if($total_cuti < -6){
												$flagTME = 1;
											} else {
												$flagTME = 0;
											}
											if($total_cuti >= 0){
												$flagMinus = 0;

												$this->db->where('nik', $employee_nik);
												$this->db->update('hris_time_management_employee', array('minus' => 0));
											} else {
												$flagMinus = 1;
											}
											
											$formDataEmployee = array(
												'nik' => $employee_nik,
												'date' => $today,
												'tipe_perubahan' => "Reject - " . $value->nama_modul,
												'start_date' => $today,
												'end_date' => $today,
												'total_cuti' => $total_cuti,
												'change_log' => -1 * abs($value->jumlah_perubahan),
												'request_number' => '-',
												'status' => '3',
												'flag' => $flagTME,
												'minus' => $flagMinus
											);
											$this->db->insert("hris_time_management_employee", $formDataEmployee);

										} else {
											$this->db->select('nama');
											$this->db->from('hris_master_time_off');
											$this->db->where('kode', 'CTAB');
											$resultCTAB = $this->db->get()->result_array();
											$ctab = $resultCTAB[0]['nama'];

											$sqlGetTop = "SELECT total_cuti FROM hris_time_management_employee WHERE nik='$employee_nik' ORDER BY id DESC LIMIT 1";
											$queryGetTop = $this->db->query($sqlGetTop);
											$resultGetTop = $queryGetTop->result_array();
											$totalChange = $resultGetTop[0]['total_cuti'];

											if ($value->kode_modul == 'PG'){

												$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$employee_nik' ORDER BY id DESC LIMIT 1";
												$queryTotal = $this->db->query($sqlTotal);
												$resultTotal = $queryTotal->result_array();
									
												if(!empty($resultTotal)){
													$total_cuti = $resultTotal[0]['total_cuti'] - $value->jumlah_perubahan;
												} else {
													$total_cuti = $value->jumlah_perubahan;
												}

												if($total_cuti < -6){
													$flagTME = 1;
												} else {
													$flagTME = 0;
												}
												if($total_cuti >= 0){
													$flagMinus = 0;

													$this->db->where('nik', $employee_nik);
													$this->db->update('hris_time_management_employee', array('minus' => 0));
												} else {
													$flagMinus = 1;
												}
												
												$formDataEmployee = array(
													'nik' => $employee_nik,
													'date' => $today,
													'tipe_perubahan' => "Reject - " . $value->nama_modul,
													'start_date' => $start_date,
													'end_date' =>$start_date,
													'total_cuti' => $total_cuti,
													'change_log' => -1 * abs($value->jumlah_perubahan),
													'request_number' => '-',
													'status' => '3',
													'flag' => $flagTME,
													'minus' => $flagMinus
												);
												$this->db->insert("hris_time_management_employee", $formDataEmployee);

												$this->db->where('nik', $employee_nik);
												$this->db->where('request_number', $req_no);
												$this->db->update('hris_time_management_employee', array('status' => 5));

											} else {
								
												$total_cuti = $totalChange - $value->jumlah_perubahan;
								
												if($total_cuti < -6){
													$flagTME = 1;
												} else {
													$flagTME = 0;
												}
												if($total_cuti >= 0){
													$flagMinus = 0;

													$this->db->where('nik', $employee_nik);
													$this->db->update('hris_time_management_employee', array('minus' => 0));
												} else {
													$flagMinus = 1;
												}
								
												$formDataEmployee = array(
													'nik' => $employee_nik,
													'date' => $today,
													'tipe_perubahan' => "Reject - " . $value->nama_modul,
													'start_date' => $start_date,
													'end_date' => $start_date,
													'total_cuti' => $total_cuti,
													'change_log' => -1 * abs($value->jumlah_perubahan),
													'request_number' => '-',
													'status' => '3',
													'flag' => $flagTME,
													'minus' => $flagMinus
												);
												$this->db->insert("hris_time_management_employee", $formDataEmployee);
								
												$sqlUpdateTME = "UPDATE hris_time_management_employee SET status=1, update_date='$today', flag=0 
																WHERE nik='$employee_nik' AND tipe_perubahan = '$ctab' AND date = '$start_date'";
												$queryUpdateTME = $this->db->query($sqlUpdateTME);

												$this->db->where('nik', $employee_nik);
												$this->db->where('request_number', $req_no);
												$this->db->update('hris_time_management_employee', array('status' => 5));
								

												$this->db->select('*');
												$this->db->from('hris_master_time_management');
												$this->db->where('employee_id', $employee_nik);
												$this->db->where('date', $start_date);
												$get_attendance = $this->db->get()->result_array();
												$check_in = $get_attendance[0]['check_in'];
												$check_out = $get_attendance[0]['check_out'];
												$check_in_location = $get_attendance[0]['check_in_location'];
												
												if (empty($check_in_location) || $check_in_location == NULL){
													$attendance_code = 'CTAB';
													$flag = 1;
													$sentence = ", check_in = NULL, check_out = NULL";
												} else {
													if (empty($check_out)){
														$attendance_code = 'CTAB';
													} else {
														$attendance_code = '';
													}
													$flag = 0;
													$sentence = ", check_out = NULL";
												}

												$sqlUpdateMTM = "UPDATE hris_master_time_management SET attendence_code='$attendance_code', time_off_code=NULL, flag=$flag ".$sentence."
																WHERE employee_id='$employee_nik' AND date = '$start_date'";
												$queryUpdateMTM = $this->db->query($sqlUpdateMTM);

												// $this->db->select('*');
												// $this->db->from('hris_master_time_management');
												// $this->db->where('employee_id', $employee_nik);
												// $this->db->where('date', $start_date);
												// $resGetTime = $this->db->get()->result_array();
												// $clocked_in = $resGetTime[0]['check_in'];
												// $schedule_in = $resGetTime[0]['schedule_in'];
												// $schedule_out = $resGetTime[0]['schedule_out'];
												// if (empty($clocked_in)){
												// 	$sentence = ", check_in='$schedule_in'";
												// } else {
												// 	$sentence = "";
												// }
												// $sqlUpdMTM = "UPDATE hris_master_time_management SET attendence_code='CTAB', time_off_code=NULL, flag=0, check_out=NULL"
												// 			. $sentence ." WHERE employee_id='$employee_nik' AND date = '$start_date'";
												// $queryUpdMTM = $this->db->query($sqlUpdMTM);
											}
										}
									}

									$sqlUpdate = "UPDATE hris_time_management_adjustment SET status=4 WHERE request_number='$req_no'";
									$queryUpdate = $this->db->query($sqlUpdate);
									
							////////////////////////////////////// END UPDATE 17102024 TIME MANAGEMENT ///////////////////////////////////////////////

							$this->db->where('request_number', $req_no);
							$this->db->update('hris_time_management_adjustment', array('status' => 2));
							
							$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1);
						}

					}
					
				break;

			case 'Approved':

						#update header request
						$this->db->where('id', $request_id);
						if ($this->db->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
							$approval = array(
								'approval_status' => 'Approved', 
								'updated_at' => $this->date, 
								'updated_by' => $this->email
							);

							#update response approval
							$this->db->where('request_id', $request_id);
							if ($this->db->update('form_approval', $approval)) {

								$this->db->select('*');
								$this->db->from('hris_time_management_adjustment');
								$this->db->where('request_number', $req_no);
								$get_adjustment = $this->db->get()->result();

								$today = date('Y-m-d');

								foreach ($get_adjustment as $value){
									$employee_nik = $value->nik_karyawan;
									$start_date = $value->start_date;

									if ($value->kode_modul == 'ACT'){

										$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$employee_nik' ORDER BY id DESC LIMIT 1";
										$queryTotal = $this->db->query($sqlTotal);
										$resultTotal = $queryTotal->result_array();
							
										if(!empty($resultTotal)){
											$total_cuti = $resultTotal[0]['total_cuti'] + $value->jumlah_perubahan;
										} else {
											$total_cuti = $value->jumlah_perubahan;
										}

										if($total_cuti < -6){
											$flagTME = 1;
										} else {
											$flagTME = 0;
										}
										if($total_cuti >= 0){
											$flagMinus = 0;

											$this->db->where('nik', $employee_nik);
											$this->db->update('hris_time_management_employee', array('minus' => 0));
										} else {
											$flagMinus = 1;
										}
										
										$formDataEmployee = array(
											'nik' => $employee_nik,
											'date' => $today,
											'tipe_perubahan' => $value->nama_modul,
											'start_date' => $today,
											'end_date' => $today,
											'total_cuti' => $total_cuti,
											'change_log' => $value->jumlah_perubahan,
											'request_number' => $req_no,
											'status' => '3',
											'flag' => $flagTME,
											'minus' => $flagMinus
										);
										$this->db->insert("hris_time_management_employee", $formDataEmployee);

									} else {
										$this->db->select('nama');
										$this->db->from('hris_master_time_off');
										$this->db->where('kode', 'CTAB');
										$resultCTAB = $this->db->get()->result_array();
										$ctab = $resultCTAB[0]['nama'];

										$sqlGetTop = "SELECT total_cuti FROM hris_time_management_employee WHERE nik='$employee_nik' ORDER BY id DESC LIMIT 1";
										$queryGetTop = $this->db->query($sqlGetTop);
										$resultGetTop = $queryGetTop->result_array();
										$totalChange = $resultGetTop[0]['total_cuti'];

										if ($value->kode_modul == 'PG'){

											$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$employee_nik' ORDER BY id DESC LIMIT 1";
											$queryTotal = $this->db->query($sqlTotal);
											$resultTotal = $queryTotal->result_array();
								
											if(!empty($resultTotal)){
												$total_cuti = $resultTotal[0]['total_cuti'] + $value->jumlah_perubahan;
											} else {
												$total_cuti = $value->jumlah_perubahan;
											}

											if($total_cuti < -6){
												$flagTME = 1;
											} else {
												$flagTME = 0;
											}
											if($total_cuti >= 0){
												$flagMinus = 0;

												$this->db->where('nik', $employee_nik);
												$this->db->update('hris_time_management_employee', array('minus' => 0));
											} else {
												$flagMinus = 1;
											}
											
											$formDataEmployee = array(
												'nik' => $employee_nik,
												'date' => $today,
												'tipe_perubahan' => $value->nama_modul,
												'start_date' => $start_date,
												'end_date' =>$start_date,
												'total_cuti' => $total_cuti,
												'change_log' => $value->jumlah_perubahan,
												'request_number' => $req_no,
												'status' => '3',
												'flag' => $flagTME,
												'minus' => $flagMinus
											);
											$this->db->insert("hris_time_management_employee", $formDataEmployee);

											$sqlPG = "SELECT * FROM hris_time_management_employee WHERE total_cuti=$total_cuti AND nik='$employee_nik' AND minus=1";
											$queryPG = $this->db->query($sqlPG);
											$resultPG = $queryPG->result_array();
											$flag_id = $resultPG[0]['id'];

											$this->db->where('nik', $employee_nik);
											$this->db->where('id <=', $flag_id);
											$this->db->update('hris_time_management_employee', array('minus' => 0, 'flag' => 0));

										} else {
							
											$total_cuti = $totalChange + $value->jumlah_perubahan;
							
											if($total_cuti < -6){
												$flagTME = 1;
											} else {
												$flagTME = 0;
											}
											if($total_cuti >= 0){
												$flagMinus = 0;

												$this->db->where('nik', $employee_nik);
												$this->db->update('hris_time_management_employee', array('minus' => 0));
											} else {
												$flagMinus = 1;
											}
							
											$formDataEmployee = array(
												'nik' => $employee_nik,
												'date' => $today,
												'tipe_perubahan' => $value->nama_modul,
												'start_date' => $start_date,
												'end_date' => $start_date,
												'total_cuti' => $total_cuti,
												'change_log' => $value->jumlah_perubahan,
												'request_number' => $req_no,
												'status' => '3',
												'flag' => $flagTME,
												'minus' => $flagMinus
											);
											$this->db->insert("hris_time_management_employee", $formDataEmployee);
							
											$sqlUpdateTME = "UPDATE hris_time_management_employee SET status=0, update_date='$today', flag=0 
															WHERE nik='$employee_nik' AND tipe_perubahan = '$ctab' AND date = '$start_date'";
											$queryUpdateTME = $this->db->query($sqlUpdateTME);
							
											$this->db->select('*');
											$this->db->from('hris_master_time_management');
											$this->db->where('employee_id', $employee_nik);
											$this->db->where('date', $start_date);
											$resGetTime = $this->db->get()->result_array();
											$clocked_in = $resGetTime[0]['check_in'];
											// $clocked_out = $resGetTime[0]['check_out'];
											$schedule_in = $resGetTime[0]['schedule_in'];
											$schedule_out = $resGetTime[0]['schedule_out'];
											if (empty($clocked_in)){
												$sentence = ", check_in='$schedule_in'";
											} else {
												$sentence = "";
											}
							
											$sqlUpdMTM = "UPDATE hris_master_time_management SET attendence_code='HCTAB', time_off_code=NULL, flag=1, check_out='$schedule_out'"
														  . $sentence ." WHERE employee_id='$employee_nik' AND date = '$start_date'";
														  
											$queryUpdMTM = $this->db->query($sqlUpdMTM);
										}
									}
								}

								$sqlUpdate = "UPDATE hris_time_management_adjustment SET status=1 WHERE request_number='$req_no'";
								$queryUpdate = $this->db->query($sqlUpdate);
								

								//$this->sendEmail('approved_eapp', $request_id, $requestor);
								// $this->logs('approved', $request_id, 'Approved successfully.');
								///////////Start Menambahkan logs 2025//////////////////
								$this->logs('approved', 'TM', $request_id, 'Response Approve', 'Approved');
								///////////End Menambahkan logs 2025//////////////////
								
								$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating response approval [Full Approved].');
								$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.');
							}

						} else {
							$this->logs('system', $request_id, 'Authentication success, but failed while updating header request [Full Approved].');
							$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.');
						}

					
	
					break;
			
			default:
				break;
		}

		echo json_encode($output);
	}
	
	public function responseRequestSchedule() 
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');
		$response = $this->input->post('resp');
		
		$sql = "select id from form_approval where request_id='$request_id' and approval_status='In Progress'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if (!empty($res)){
			$approval_id = $res[0]->id;
		} else {
			$sql = "select id from form_approval where request_id='$request_id' and approval_priority=3";
			$query = $this->db->query($sql);
			$res = $query->result();
			$approval_id = $res[0]->id;
		}
		
		// previous layer
		$priority = $this->m_global->find('form_approval', 'id', $approval_id)->row_array()['approval_priority'];
		$prev_priority = $priority-1;
		$prev_id = $this->inbox_model->find_select("id",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$request_id))->row_array();

		$prev_email = $this->inbox_model->find_select("approval_email",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$request_id))->row_array();

		$data_prev_layer = array(
			'approval_status' => 'In Progress', 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		//GET FORM TYPE
		$sqlForm = "SELECT form_type, request_number FROM form_request WHERE id = '$request_id'";
		$queryForm = $this->db->query($sqlForm);
		$resForm = $queryForm->result();
		$tipe_form = $resForm[0]->form_type;
		$request_number = $resForm[0]->request_number;

		switch ($response) {

			case 'Reject':			

					// $this->db->where('request_id', $request_id);
					// $this->db->delete('form_approval');
					// $this->db->where('id', $request_id);
					// if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

					// 	$this->db->where('request_id', $request_id);
					// 	$this->db->update('hris_schedule_request', array('status' => 2));
						
					// 	$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
					// 	$output = array('status' => 1);
					// }



					$sqlForm = "SELECT request_number, is_status FROM form_request WHERE id = '$request_id'";
					$queryForm = $this->db->query($sqlForm);
					$resForm = $queryForm->result();
					$status_form = $resForm[0]->is_status;

					if($status_form != '3'){
						$this->db->where('request_id', $request_id);
						$this->db->delete('form_approval');
						$this->db->where('id', $request_id);
						if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

							$this->db->where('request_number', $request_number);
							$this->db->update('hris_time_management_adjustment', array('status' => 2));

							$this->db->where('request_id', $request_id);
							$this->db->update('hris_schedule_request', array('status' => 2));
							
							$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1);

							$this->db->where('request_id', $request_id);
							$this->db->update('request_notes', array('is_status' => 0));
						}
					}else{

						$this->db->where('request_id', $request_id);
						$this->db->delete('form_approval');
						$this->db->where('id', $request_id);
						if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

							$this->db->where('request_id', $request_id);
							$this->db->update('request_notes', array('is_status' => 0));

							///////////////////////////////////////// START UPDATE 17102024 TIME MANAGEMENT /////////////////////////////////////////////
							$this->db->select('*');
							$this->db->from('hris_time_management_adjustment');
							$this->db->where('request_number', $request_number);
							$get_adjustment = $this->db->get()->result();

							$today = date('Y-m-d');

									foreach ($get_adjustment as $value){
										$employee_nik = $value->nik_karyawan;
										$start_date = $value->start_date;

										if ($value->kode_modul == 'ACT'){

											$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$employee_nik' ORDER BY id DESC LIMIT 1";
											$queryTotal = $this->db->query($sqlTotal);
											$resultTotal = $queryTotal->result_array();
								
											if(!empty($resultTotal)){
												$total_cuti = $resultTotal[0]['total_cuti'] - $value->jumlah_perubahan;
											} else {
												$total_cuti = $value->jumlah_perubahan;
											}

											if($total_cuti < -6){
												$flagTME = 1;
											} else {
												$flagTME = 0;
											}
											if($total_cuti >= 0){
												$flagMinus = 0;

												$this->db->where('nik', $employee_nik);
												$this->db->update('hris_time_management_employee', array('minus' => 0));
											} else {
												$flagMinus = 1;
											}
											
											$formDataEmployee = array(
												'nik' => $employee_nik,
												'date' => $today,
												'tipe_perubahan' => "Reject - " . $value->nama_modul,
												'start_date' => $today,
												'end_date' => $today,
												'total_cuti' => $total_cuti,
												'change_log' => -1 * abs($value->jumlah_perubahan),
												'request_number' => '-',
												'status' => '3',
												'flag' => $flagTME,
												'minus' => $flagMinus
											);
											$this->db->insert("hris_time_management_employee", $formDataEmployee);

										} else {
											$this->db->select('nama');
											$this->db->from('hris_master_time_off');
											$this->db->where('kode', 'CTAB');
											$resultCTAB = $this->db->get()->result_array();
											$ctab = $resultCTAB[0]['nama'];

											$sqlGetTop = "SELECT total_cuti FROM hris_time_management_employee WHERE nik='$employee_nik' ORDER BY id DESC LIMIT 1";
											$queryGetTop = $this->db->query($sqlGetTop);
											$resultGetTop = $queryGetTop->result_array();
											$totalChange = $resultGetTop[0]['total_cuti'];

											if ($value->kode_modul == 'PG'){

												$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$employee_nik' ORDER BY id DESC LIMIT 1";
												$queryTotal = $this->db->query($sqlTotal);
												$resultTotal = $queryTotal->result_array();
									
												if(!empty($resultTotal)){
													$total_cuti = $resultTotal[0]['total_cuti'] - $value->jumlah_perubahan;
												} else {
													$total_cuti = $value->jumlah_perubahan;
												}

												if($total_cuti < -6){
													$flagTME = 1;
												} else {
													$flagTME = 0;
												}
												if($total_cuti >= 0){
													$flagMinus = 0;

													$this->db->where('nik', $employee_nik);
													$this->db->update('hris_time_management_employee', array('minus' => 0));
												} else {
													$flagMinus = 1;
												}
												
												$formDataEmployee = array(
													'nik' => $employee_nik,
													'date' => $today,
													'tipe_perubahan' => "Reject - " . $value->nama_modul,
													'start_date' => $start_date,
													'end_date' =>$start_date,
													'total_cuti' => $total_cuti,
													'change_log' => -1 * abs($value->jumlah_perubahan),
													'request_number' => '-',
													'status' => '3',
													'flag' => $flagTME,
													'minus' => $flagMinus
												);
												$this->db->insert("hris_time_management_employee", $formDataEmployee);

												$this->db->where('nik', $employee_nik);
												$this->db->where('request_number', $request_number);
												$this->db->update('hris_time_management_employee', array('status' => 5));

											} else {
								
												$total_cuti = $totalChange - $value->jumlah_perubahan;
								
												if($total_cuti < -6){
													$flagTME = 1;
												} else {
													$flagTME = 0;
												}
												if($total_cuti >= 0){
													$flagMinus = 0;

													$this->db->where('nik', $employee_nik);
													$this->db->update('hris_time_management_employee', array('minus' => 0));
												} else {
													$flagMinus = 1;
												}
								
												$formDataEmployee = array(
													'nik' => $employee_nik,
													'date' => $today,
													'tipe_perubahan' => "Reject - " . $value->nama_modul,
													'start_date' => $start_date,
													'end_date' => $start_date,
													'total_cuti' => $total_cuti,
													'change_log' => -1 * abs($value->jumlah_perubahan),
													'request_number' => '-',
													'status' => '3',
													'flag' => $flagTME,
													'minus' => $flagMinus
												);
												$this->db->insert("hris_time_management_employee", $formDataEmployee);
								
												$sqlUpdateTME = "UPDATE hris_time_management_employee SET status=1, update_date='$today', flag=0 
																WHERE nik='$employee_nik' AND tipe_perubahan = '$ctab' AND date = '$start_date'";
												$queryUpdateTME = $this->db->query($sqlUpdateTME);

												$this->db->where('nik', $employee_nik);
												$this->db->where('request_number', $request_number);
												$this->db->update('hris_time_management_employee', array('status' => 5));
								
												$this->db->select('*');
												$this->db->from('hris_master_time_management');
												$this->db->where('employee_id', $employee_nik);
												$this->db->where('date', $start_date);
												$resGetTime = $this->db->get()->result_array();
												$clocked_in = $resGetTime[0]['check_in'];
												// $clocked_out = $resGetTime[0]['check_out'];
												$schedule_in = $resGetTime[0]['schedule_in'];
												$schedule_out = $resGetTime[0]['schedule_out'];
												if (empty($clocked_in)){
													$sentence = ", check_in='$schedule_in'";
												} else {
													$sentence = "";
												}
								
												$sqlUpdMTM = "UPDATE hris_master_time_management SET attendence_code='CTAB', time_off_code=NULL, flag=0, check_out='$schedule_out'"
															. $sentence ." WHERE employee_id='$employee_nik' AND date = '$start_date'";
															
												$queryUpdMTM = $this->db->query($sqlUpdMTM);
											}
										}
									}

									$sqlUpdate = "UPDATE hris_time_management_adjustment SET status=4 WHERE request_number='$request_number'";
									$queryUpdate = $this->db->query($sqlUpdate);
									
							////////////////////////////////////// END UPDATE 17102024 TIME MANAGEMENT ///////////////////////////////////////////////

							$this->db->where('request_number', $request_number);
							$this->db->update('hris_time_management_adjustment', array('status' => 2));
							
							$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
							$output = array('status' => 1);
						}

					}

				break;

			case 'Checked': 

					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status_admin_hr' => 1, 'checked_at' => $this->date))) {
						
						$this->db->where('request_id', $request_id);
						$this->db->update('request_notes', array('is_status' => 0));

						$this->db->where('request_id', $request_id);
						$this->db->where('approval_priority', 3);
						
						if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {
							$this->logs('checked', 'TM', $request_id, 'Response Checked By HR', 'Checked');
							$output = array('status' => 1);
						} else {
							$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.');
						}
					}
				break;

			case 'Revised':

					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
						$this->db->where('request_id', $request_id);
						$this->db->update('hris_schedule_request', array('status' => 4));

						$this->db->where('request_id', $request_id);
						$this->db->update('request_notes', array('is_status' => 0));

						$this->logs('revise', 'TM', $request_id, 'Response Revised', 'Revised');
						$output = array('status' => 1);
					}
				break;

			case 'RevisedHR':
					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status_admin_hr' => 0))) {

						$this->db->where('request_id', $request_id);
						$this->db->update('request_notes', array('is_status' => 0));

						$this->db->where('request_id', $request_id);
						$this->db->where('approval_priority', 3);
						if ($this->db->update('form_approval', array('approval_status' => ''))) {
							$this->logs('revise', 'TM', $request_id, 'Response Revised', 'Revised');
							$output = array('status' => 1);
						} else {
							$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.');
						}
					}
				break;

			case 'Resubmitted' :
					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 1, 'revised_at' =>$this->date, 'updated_by' => NULL, 'updated_at' => NULL))) {
						$this->db->where('request_id', $request_id);
						$this->db->update('hris_schedule_request', array('status' => 0));

						$this->db->where('request_id', $request_id);
						$this->db->update('request_notes', array('is_status' => 0));

						$this->logs('resubmitted', 'TM', $request_id, 'Response Resubmitted', 'Resubmitted');
						$output = array('status' => 1);
					}
				break;

			case 'Approved':

				$sql = "SELECT * FROM form_approval WHERE id = '$approval_id' AND request_id = '$request_id'";
				$query = $this->db->query($sql);
				$checkleftcurrent = $query->result_array();

				if ($checkleftcurrent[0]['approval_priority'] != 3 ) {
				
					$current_approval = array(
						'approval_status' => 'Approved', 
						'updated_at' => $this->date, 
						'updated_by' => $this->email
					);

					#update response approval
					$this->db->where('id', $approval_id);
					if ($this->db->update('form_approval', $current_approval)) {

						$sqlReqNo = "SELECT request_number FROM hris_schedule_request where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
						$queryReqNo = $this->db->query($sqlReqNo);
						$resultReqNo = $queryReqNo->result_array();
						$req_no = $resultReqNo[0]['request_number'];

						$config['cacheable']    = true;
						$config['cachedir']     = './assets/';
						$config['errorlog']     = './assets/';
						$config['imagedir']     = './assets/images/qrcode_tm_schedule/';
						$config['imagelogo']    = './assets/images/IBS.png';						
						$config['quality']      = true;
						$config['size']         = '1024';
						$config['black']        = array(224,255,255);
						$config['white']        = array(70,130,180);
						$this->ciqrcode->initialize($config);
						$image_name				= 'appr-'.$req_no.'-'.$this->emp_id.'.png';
						$params['data'] 		= $req_no.'-'.$this->emp_id;
						$params['level'] 		= 'H'; //H=High
						$params['size'] 		= 10;
						$params['savename'] 	= FCPATH.$config['imagedir'].$image_name;
						$params['logo'] 		= FCPATH . $config['imagelogo'];
						$params['imagetmp'] 	= $config['imagedir'];
						$this->ciqrcode->generate($params);

						if ($checkleftcurrent[0]['approval_priority'] == 1 ) {
							#set in progress for next approver
							$this->db->where('id', ($approval_id + 1));
							
							if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {

								// $this->logs('approved', $request_id, 'Approved successfully');
								///////////Start Update logs 2025//////////////////
								$this->logs('approved', $tipe_form, $request_id, 'Approved', 'Approved successfully');
								///////////End Update logs 2025//////////////////
								$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

							} else {
								$this->logs('system', $request_id, 'Authentication success, but failed while updating the next approver.');
								$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.');
							}
						} else {
							$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));
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
						$this->db->where('request_id', $request_id);
						$this->db->where('approval_priority', 3);
						if ($this->db->update('form_approval', $approval)) {

							$sqlReqNo = "SELECT request_number FROM hris_schedule_request where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
							$queryReqNo = $this->db->query($sqlReqNo);
							$resultReqNo = $queryReqNo->result_array();
							$req_no = $resultReqNo[0]['request_number'];

							$config['cacheable']    = true;
							$config['cachedir']     = './assets/';
							$config['errorlog']     = './assets/';
							$config['imagedir']     = './assets/images/qrcode_tm_schedule/';
							$config['imagelogo']    = './assets/images/IBS.png';
							$config['quality']      = true;
							$config['size']         = '1024';
							$config['black']        = array(224,255,255);
							$config['white']        = array(70,130,180);
							$this->ciqrcode->initialize($config);
							$image_name				= 'appr-'.$req_no.'-'.$this->emp_id.'.png';
							$params['data'] 		= $req_no.'-'.$this->emp_id;
							$params['level'] 		= 'H'; //H=High
							$params['size'] 		= 10;
							$params['savename'] 	= FCPATH.$config['imagedir'].$image_name;
							$params['logo'] 		= FCPATH . $config['imagelogo'];
							$params['imagetmp'] 	= $config['imagedir'];							
							$this->ciqrcode->generate($params);

							$sqlUpdate = "UPDATE hris_schedule_request SET status=1 WHERE request_id='$request_id'";
							$queryUpdate = $this->db->query($sqlUpdate);
							

							//$this->sendEmail('approved_eapp', $request_id, $requestor);
							// $this->logs('approved', $request_id, 'Approved successfully.');
							///////////Start Update logs 2025//////////////////
							$this->logs('approved', $tipe_form, $request_id, 'Approved', 'Approved successfully');
							///////////End Update logs 2025//////////////////
							
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
		echo json_encode($output);
	}

	public function responseRequestShift() 
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');
		$response = $this->input->post('resp');
		
		$sql = "select id from form_approval where request_id='$request_id' and approval_status='In Progress'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if (!empty($res)){
			$approval_id = $res[0]->id;
		} else {
			$sql = "select id from form_approval where request_id='$request_id' and approval_priority=2";
			$query = $this->db->query($sql);
			$res = $query->result();
			$approval_id = $res[0]->id;
		}
		
		// previous layer
		$priority = $this->m_global->find('form_approval', 'id', $approval_id)->row_array()['approval_priority'];
		$prev_priority = $priority-1;
		$prev_id = $this->inbox_model->find_select("id",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$request_id))->row_array();

		$prev_email = $this->inbox_model->find_select("approval_email",'form_approval',array('approval_priority'=>$prev_priority,'request_id'=>$request_id))->row_array();

		$data_prev_layer = array(
			'approval_status' => 'In Progress', 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		switch ($response) {

			case 'Reject':			

					$this->db->where('request_id', $request_id);
					$this->db->delete('form_approval');
					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

						$this->db->where('request_id', $request_id);
						$this->db->update('hris_request_shift_schedule', array('status' => 2));
						
						$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
						$output = array('status' => 1);
					}
				break;

			case 'Checked': 

					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status_admin_hr' => 1, 'checked_at' => $this->date))) {
						
						$this->db->where('request_id', $request_id);
						$this->db->where('approval_priority', 2);
						
						if ($this->db->update('form_approval', array('approval_status' => 'In Progress'))) {
							$this->logs('checked', 'TM', $request_id, 'Response Checked By HR', 'Checked');
							$output = array('status' => 1);
						} else {
							$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.');
						}
					}
				break;

			case 'Revised':

					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
						$this->db->where('request_id', $request_id);
						$this->db->update('hris_request_shift_schedule', array('status' => 4));

						$this->logs('revise', 'TM', $request_id, 'Response Revised', 'Revised');
						$output = array('status' => 1);
					}
				break;

			case 'RevisedHR':
					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status_admin_hr' => 0))) {

						$this->db->where('request_id', $request_id);
						$this->db->where('approval_priority', 2);
						
						if ($this->db->update('form_approval', array('approval_status' => ''))) {
							$this->logs('revise', 'TM', $request_id, 'Response Revised', 'Revised');
							$output = array('status' => 1);
						} else {
							$output = array('status' => 0, 'message' => 'Authentication success, but failed while updating the next approver.');
						}
					}
				break;

			case 'Resubmitted' :
					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 1, 'revised_at' =>$this->date, 'updated_by' => NULL, 'updated_at' => NULL))) {
						$this->db->where('request_id', $request_id);
						$this->db->update('hris_request_shift_schedule', array('status' => 0));

						$this->db->where('request_id', $request_id);
						$this->db->update('request_notes', array('is_status' => 0));

						$this->logs('resubmitted', 'TM', $request_id, 'Response Resubmitted', 'Resubmitted');
						$output = array('status' => 1);
					}
				break;

			case 'Approved':

				$sql = "SELECT * FROM form_approval WHERE id = '$approval_id' AND request_id = '$request_id'";
				$query = $this->db->query($sql);
				$checkleftcurrent = $query->result_array();

				if ($checkleftcurrent[0]['approval_priority'] != 2 ) {
				
					$current_approval = array(
						'approval_status' => 'Approved', 
						'updated_at' => $this->date, 
						'updated_by' => $this->email
					);

					#update response approval
					$this->db->where('id', $approval_id);
					if ($this->db->update('form_approval', $current_approval)) {

						$sqlReqNo = "SELECT request_number FROM hris_request_shift_schedule where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
						$queryReqNo = $this->db->query($sqlReqNo);
						$resultReqNo = $queryReqNo->result_array();
						$req_no = $resultReqNo[0]['request_number'];

						$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

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
						$this->db->where('request_id', $request_id);
						$this->db->where('approval_priority', 2);
						if ($this->db->update('form_approval', $approval)) {

							$sqlReqNo = "SELECT * FROM hris_request_shift_schedule where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
							$queryReqNo = $this->db->query($sqlReqNo);
							$resultReqNo = $queryReqNo->result_array();
							$req_no = $resultReqNo[0]['request_number'];
							$file_name = $resultReqNo[0]['files'];

							$file = "./assets/documents/documents_tm/$file_name";
							if(file_exists("$file")){
								$handle= fopen("$file","r");
								$flag = true;
							
								while(($data=fgetcsv($handle,0,';'))!== FALSE){ 
									if($flag) { $flag = false; continue; }
									$nik = $data[0];
									$date = date("Y-m-d",strtotime(str_replace('/','-',$data[2])));
									$dws_code = $data[3];
									$to_code = $data[4];
					
									$this->db->select("company_code");
									$this->db->from("v_hris_nik_company");
									$this->db->where("nik", $nik);
									$company_result = $this->db->get()->result_array();
									$company_code = $company_result[0]['company_code'];

									$this->db->select("nama, schedule_in, schedule_out");
									$this->db->from("hris_master_schedule");
									$this->db->where("kode", $dws_code);
									$this->db->where("company_code", $company_code);
									$this->db->where("end_date", "9999-12-31");
									$schedule_data = $this->db->get()->result_array();
					
									if ($dws_code != "DO"){
										$dws = $schedule_data[0]['nama'];
										$schedule_in = $schedule_data[0]['schedule_in'];
										$schedule_out = $schedule_data[0]['schedule_out'];
									} else {
										$dws = "DAY OFF";
										$schedule_in = NULL;
										$schedule_out = NULL;
									}
					
									$formData = array(
										'dws' => $dws,
										'schedule_code' => $dws_code,
										'schedule_in' => $schedule_in,
										'schedule_out' => $schedule_out,
										'time_off_code' => $to_code
									);
									
									$this->db->where('employee_id', $nik);
									$this->db->where('date', $date);
									$this->db->update("hris_master_time_management", $formData);
								}
							}
							
							$sqlUpdate = "UPDATE hris_request_shift_schedule SET status=1 WHERE request_id='$request_id'";
							$queryUpdate = $this->db->query($sqlUpdate);

							//$this->sendEmail('approved_eapp', $request_id, $requestor);
							// $this->logs('approved', $request_id, 'Approved successfully.');
							///////////Start Update logs 2025//////////////////
							$this->logs('approved', 'TM', $request_id, 'Approved', 'Approved successfully');
							///////////End Update logs 2025//////////////////
							
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

		echo json_encode($output);
	}

	public function responseRequestRelokasi() 
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');
		$response = $this->input->post('resp');
		
		// $sql = "select id from form_approval where request_id='$request_id' and approval_status='In Progress'";
		// $query = $this->db->query($sql);
		// $res = $query->result();
		// $approval_id = $res[0]->id;
		
		// // previous layer
		// $priority = $this->m_global->find('id', $approval_id, 'form_approval')->row_array()['approval_priority'];
		// $prev_priority = $priority-1;
		// $prev_id = $this->inbox_model->find_select("id",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

		// $prev_email = $this->inbox_model->find_select("approval_email",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

		// $data_prev_layer = array(
		// 	'approval_status' => 'In Progress', 
		// 	'updated_at' => $this->date, 
		// 	'updated_by' => $this->email
		// );

		switch ($response) {

			case 'Reject':			

					$this->db->where('request_id', $request_id);
					$this->db->delete('form_approval');
					$this->db->where('id', $request_id);
					if ($this->db->update('form_request', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

						$this->db->where('request_id', $request_id);
						$this->db->update('hris_request_relokasi_sementara', array('status' => 2));

						$sqlGetReloc = "SELECT * from hris_request_relokasi_sementara where request_id='$request_id'";
						$queryGetReloc = $this->db->query($sqlGetReloc);
						$resGetReloc = $queryGetReloc->result();
						$reloc_nik = $resGetReloc[0]->nik;
						$reloc_start = $resGetReloc[0]->start_date;
						$reloc_end = $resGetReloc[0]->end_date;

						$this->db->where('nik', $reloc_nik);
						$this->db->where('start_date', $reloc_start);
						$this->db->where('end_date', $reloc_end);
						$this->db->update('hris_master_relokasi_sementara', array('status' => 2));
						
						$this->logs('reject', 'TM', $request_id, 'Response Rejected', 'Rejected');
						$output = array('status' => 1);
					}
				break;

			case 'Approved':

				// $sql = "SELECT * FROM form_approval WHERE id = '$approval_id' AND request_id = '$request_id'";
				// $query = $this->db->query($sql);
				// $checkleftcurrent = $query->result_array();

				#update header request
				$this->db->where('id', $request_id);
				if ($this->db->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
					$approval = array(
						'approval_status' => 'Approved', 
						'updated_at' => $this->date, 
						'updated_by' => $this->email
					);

					#update response approval
					$this->db->where('request_id', $request_id);
					if ($this->db->update('form_approval', $approval)) {

						$sqlReloc = "SELECT * FROM hris_request_relokasi_sementara where request_id = '$request_id' ORDER BY id DESC LIMIT 1";
						$queryReloc = $this->db->query($sqlReloc);
						$resultReloc = $queryReloc->result_array();

						$formData = array(
							'nik' => $resultReloc[0]['nik'],
							'full_name' => strtoupper($resultReloc[0]['full_name']),
							'start_date' => $resultReloc[0]['start_date'],
							'end_date' => $resultReloc[0]['end_date'],
							'pa_awal' => $resultReloc[0]['pa_awal'],
							'pa_akhir' => $resultReloc[0]['pa_akhir'],
							'status' => 1
						);
						$this->db->insert("hris_master_relokasi_sementara", $formData);
					
						$sqlUpdate = "UPDATE hris_request_relokasi_sementara SET status=1 WHERE request_id='$request_id'";
						$queryUpdate = $this->db->query($sqlUpdate);

						//$this->sendEmail('approved_eapp', $request_id, $requestor);
						// $this->logs('approved', $request_id, 'Approved successfully.');
						///////////Start Update logs 2025//////////////////
						$this->logs('approved', 'TM', $request_id, 'Approved', 'Approved successfully');
						///////////End Update logs 2025//////////////////
						
						$output = array('status' => 1, 'message' => 'Approved successfully.', 'id' => encode_url($request_id));

					} else {
						$this->logs('system', $request_id, 'Authentication success, but failed while updating header request [Full Approved].');
						$output = array('status' => 1, 'message' => 'Authentication success, but failed updating response approval.');
					}
				}

				break;
			
			default:
				break;
		}
		echo json_encode($output);
	}

	public function sendEmailTM($type, $requestId, $email_to, $employee_id = "")
	{	
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['request_to'] = $this->m_global->find('hris_request_time_off', 'request_id', $requestId)->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id'])[0];
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();
		$data['notes'] = $this->m_global->find('request_notes', 'request_id', $requestId)->result_array();

		if ($type == 'rejected_time_off'){
			// $data['email'] = $email_to; // COMMENT: OPEN THIS
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$data['email'] = 'ANANDHA.HOKKY@IBSMULTI.COM';
			}else{
				$data['email'] = $email_to;
			}
			$data['approval'] = 'rejected';
			if ($data['request_to']['jenis'] == 'Request Attendance'){
				$email_subject = '[HRIS-TM] Request Attendance Rejected';
				$data['title'] = '[HRIS-TM] Request Attendance Rejected';
			} else {
				$email_subject = '[HRIS-TM] Request Rejected';
				$data['title'] = '[HRIS-TM] Request Rejected';
			}
			$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/reject_time_off', $data, TRUE);
			$email_to = $data['form_request']['created_by'];
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$email_to  = 'ANANDHA.HOKKY@IBSMULTI.COM';
			}else{
				$email_to = $data['form_request']['created_by'];
			}
		} elseif ($type == 'approved_time_off'){
			if (!empty($email_to)){
				if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
					$data['email'] = 'ANANDHA.HOKKY@IBSMULTI.COM';
				}else{
					$data['email'] = $email_to;
				}
			} else {
				$data['email'] = $data['form_request']['updated_by'];
			}
			if ($data['request_to']['jenis'] == 'Request Attendance'){
				$email_subject = '[HRIS-TM] Request Attendance Approved';
				$data['title'] = '[HRIS-TM] Request Attendance Approved';
			} else {
				$email_subject = '[HRIS-TM] Request Approved';
				$data['title'] = '[HRIS-TM] Request Approved';
			}
			$data['approval'] = 'approved';
			$data['full_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/approval_time_off', $data, TRUE);
			$email_to = $data['form_request']['created_by'];
			
		} elseif ($type == 'info_time_off'){
			
			if(!empty($data['data_employee']->divhead_name)){
				$email_to  = strtolower(decrypt($data['data_employee']->usrid_long3));
				$name	   = ucwords(strtolower(decrypt($data['data_employee']->divhead_name)));
			} else {
				if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
					$email_to  = 'ANANDHA.HOKKY@IBSMULTI.COM';
					$name	   = 'ANANDHA HOKKY';
				}else{
					$email_to  = strtolower(decrypt($data['data_employee']->usrid_long4));
					$name	   = ucwords(strtolower(decrypt($data['data_employee']->director_name)));
				}
			}
			
			$data['email'] = $email_to; // COMMENT: OPEN THIS
			$data['full_name'] = $name;
			$data['emp_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/infoTODivhead', $data, TRUE);
			$email_subject = '[HRIS-TM] Information Request Approved';

			if(strtolower($this->email) == $email_to){
				return;
			}

		} else if ($type == 'req_to_hr'){
			$email_to	   = 'hr.support@ibsmulti.com'; // COMMENT: OPEN THIS
			$data['full_name'] = 'HR Support';
			$data['employee_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/requestToDeptheadRPM', $data, TRUE);
			$email_subject = 'HRIS-Request Time Off';
		} else if ($type == 'info_to_hr'){ //CR 3 TM
			$email_to	   = 'hr.support@ibsmulti.com'; // COMMENT: OPEN THIS
			$data['emp_name'] = ucwords(strtolower(decrypt($data['data_employee']->complete_name)));
			$html = $this->load->view('services/email/infoToHR', $data, TRUE);
			$email_subject = 'HRIS-Request Revised Location';
		}

		///////////////////////

		$mail = new PHPMailer();
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->isSMTP();
		$mail->Host       = 'mail.ibsmulti.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
		$mail->Password   = '1214#$C1k1n1.2026'; // ubah dengan password email Anda
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;

		$mail->setFrom('no.reply@ibsmulti.com', 'Notification System HRIS - IBS'); // ubah dengan alamat email Anda

		// $link_host = "$_SERVER[HTTP_HOST]";
		// if($link_host != "172.19.8.84" && $link_host != "medclaim.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com" || $link_host == "172.19.8.81")){
		// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
		// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
		// }else{
		// 	if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
		// 		$mail->addAddress('ANANDHA.HOKKY@IBSMULTI.COM');
		// 	}else{
		// 		$mail->addAddress($email_to);
		// 	}
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
			if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
				$mail->addAddress('ANANDHA.HOKKY@IBSMULTI.COM');
			}else{
				$mail->addAddress($email_to);
			}
			$mail->addBCC('luffi.utomo@ibsmulti.com');
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
		}
		

		// Isi Email
		$mail->isHTML(true);
		$mail->Subject = $email_subject;
		$mail->Body    = $html;

		$mail->send();
	}
	//////////////////// END TIME MANAGEMENT 2024 ////////////////////

	//////////////////////////////////////////Update Logs 2025//////////////////////////////////////////////////////
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
			
			case 'approved':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

	/////////////////////////////////////////START Performance Appraisal 2025////////////////////////////////////////////

	public function kurva_devisiasi_hr(){
		
		$team_eligible				= $_POST['team_eligible'];
		$total_employee				= $_POST['total_employee'];
		$division_name				= $_POST['division_name'];
		$division 					= encrypt($division_name);
		$total_dbl					= $_POST['total_dbl'];
		$basic_line_a				= $_POST['basic_line_a'];
		$basic_line_b				= $_POST['basic_line_b'];
		$basic_line_c				= $_POST['basic_line_c'];
		$basic_line_d				= $_POST['basic_line_d'];
		$basic_line_e				= $_POST['basic_line_e'];

		$basic_line   = array();
		$basic_line['a'] =  $_POST['basic_line_a'];
		$basic_line['b'] =  $_POST['basic_line_b'];
		$basic_line['c'] =  $_POST['basic_line_c'];
		$basic_line['d'] =  $_POST['basic_line_d'];
		$basic_line['e'] =  $_POST['basic_line_e'];
		
		$year = $this->year-1;
		$count = 0;
		foreach($basic_line as $key => $val){
			$cek = $this->db->query("select * from kurva_devisiasi where division = '$division' and grade = '$key' and year = '$year'")->result();
			if(count($cek) == 0){
				$this->db->insert('kurva_devisiasi', ['year' => $year, 'grade' => $key, 'basic_line' => $val, 'division' => $division]);
			}else{
				$this->db->where('id', $cek[0]->id);
				$this->db->update('kurva_devisiasi', ['year' => $year, 'grade' => $key, 'basic_line' => $val, 'division' => $division]);
			}
			$count++;
		}

		if($count == 5){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	/////////////////////////////////////////END Performance Appraisal 2025////////////////////////////////////////////

	//////////Start 2026 TM///////
	// private function workingHoursT($check_in,$check_out)
    // {

    //     $in  = new DateTime($check_in);
    //     $out = new DateTime($check_out);
    //     $interval = $out->diff($in);

    //     $hours = $interval->h;
    //     $minutes = $interval->i;
    //     $seconds = $interval->s;

    //     return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

    // }

	private function workingHoursT($check_in, $check_out)
	{
		$in  = new DateTime($check_in);
		$out = new DateTime($check_out);

		// Jika check_out lebih kecil dari check_in
		if ($out < $in) {
			return '00:00:00';
		}

		$diff = $out->getTimestamp() - $in->getTimestamp();

		$hours = floor($diff / 3600);
		$minutes = floor(($diff % 3600) / 60);
		$seconds = $diff % 60;

		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
	}

	// private function workingHoursD($check_in,$check_out)
    // {
    //     //Untuk format jam desimal
    //     $in  = strtotime($check_in);
    //     $out = strtotime($check_out);

    //     return round(($out-$in)/3600,2);
    // }
	private function workingHoursD($check_in, $check_out)
	{
		// Untuk format jam desimal
		$in  = strtotime($check_in);
		$out = strtotime($check_out);

		$hours = ($out - $in) / 3600;

		// Jika minus, kembalikan 0.00
		if ($hours < 0) {
			return 0.00;
		}

		return number_format(max(0, $hours), 2, '.', '');
	}

	private function addTime($time1, $time2)
	{
		// ubah ke detik
		$t1 = strtotime("1970-01-01 $time1 UTC");
		$t2 = strtotime("1970-01-01 $time2 UTC");

		$sum = ($t1 + $t2) - strtotime("1970-01-01 00:00:00 UTC");

		return gmdate("H:i:s", $sum);
	}
	//////////End 2026 TM////////
}
