<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inbox extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', '256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M

		$this->load->library('curl');
		$this->load->library('enc');
		$this->enc->check_session();

		if (!$this->enc->access_user()) {
			$x = base_url();
			redirect($x);
			exit();
		}
		
		$this->load->helper('general');
		$this->load->model('inbox_model');
		$this->load->model('form/form_model');
		$this->load->model('m_global');
		$this->email = $this->session->userdata('user_email');
		$this->division = $this->session->userdata('division');
		$this->second_division = $this->session->userdata('second_division');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function index()
	{
		$x = base_url('inbox/approval');
		redirect($x);
		exit();
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
	}

	public function approval()
	{
		$data['header'] = $this->inbox_model->getApprovalList();
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/list_approval';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function pa_management()
	{
		if (($this->session->userdata('access_employee') != '2') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['header'] = $this->inbox_model->getPAList();
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/list_pa_approved';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function mgmt()
	{
		if (($this->session->userdata('access_employee') != '2') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $this->session->userdata('division'), 'evaluation_period' => $eval_year))->row_array();

		$data['total_team'] = $this->inbox_model->countTeam($this->session->userdata('division'));
		$data['total_approved'] = $this->inbox_model->countRequest($this->session->userdata('division'), '3');
		$data['total_inprogress'] = $this->inbox_model->countRequest($this->session->userdata('division'), '1');
		$data['total_revise'] = $this->inbox_model->countRequest($this->session->userdata('division'), '2');
		$data['total_a'] = $this->inbox_model->getTotalGrade($this->session->userdata('division'), 'a');
		$data['total_b'] = $this->inbox_model->getTotalGrade($this->session->userdata('division'), 'b');
		$data['total_c'] = $this->inbox_model->getTotalGrade($this->session->userdata('division'), 'c');
		$data['total_d'] = $this->inbox_model->getTotalGrade($this->session->userdata('division'), 'd');
		$data['total_e'] = $this->inbox_model->getTotalGrade($this->session->userdata('division'), 'e');

		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/pa_management';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hrd()
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['header'] = $this->inbox_model->getPAList();
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/pa_summary';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hr_division()
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$data['division'] = $this->db->get_where('performance_division_status', array('is_status' => 1, 'evaluation_period' => $eval_year))->result_array();
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/list_division';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hr_confirmed()
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/hr_confirmed';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function review()
	{
		$data['header'] = $this->inbox_model->getReviewList();
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/list_approval';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read($user = '')
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		if (!empty($user)) {
			$listForm = $this->inbox_model->getDivHeadList($user);
		} else {
			$listForm = $this->inbox_model->getDivHeadList();
		}

		$division_status = $this->db->get_where('performance_division_status', array('division_name' => $this->session->userdata('division'), 'evaluation_period' => $eval_year))->row_array()['is_status'];
       
        if (!empty($listForm)) {
            foreach ($listForm as $key) {
                $row   = array();
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

                if ($division_status == 3 || $division_status == 1) {
                	$row[] = '';

                } else {
                	$row[] = '<div class="btn-group btn-group-sm">
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

    public function read_hr()
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$listForm = $this->inbox_model->getHRConfirmed();
        if (!empty($listForm)) {
            foreach ($listForm as $key) {
                $row   = array();
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
            	$row[] = '';

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function view($id)
	{
		$request_id = decode_url($id);
		$data['header'] = $this->m_global->find('id', $request_id, 'performance_appraisal')->row_array();
		$data['detail'] = $this->m_global->find('request_id', $request_id, 'performance_appraisal_measurement')->result_array();
		$data['additional'] = $this->m_global->find('request_id', $request_id, 'performance_appraisal_plan')->result_array();
		$data['employee'] = $this->m_global->find('id', $data['header']['employee_id'], 'employee')->row_array();
		$data['notes']   = $this->m_global->find('request_id', $request_id, 'request_notes')->result_array();
		$data['approval'] = $this->m_global->find('request_id', $request_id, 'form_approval')->result_array();
		$data['approval_id'] = $this->inbox_model->find_select("id", array('request_id' => $request_id, 'approval_email' => $this->email), 'form_approval')->row_array();

		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/form/details';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function hr_view($div_head)
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$division_name = $this->db->get_where('employee', array('user_email' => $div_head))->row_array()['division'];
		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $division_name, 'evaluation_period' => $eval_year))->row_array();
		

		$data['division'] = $this->db->get_where('employee', array('user_email' => $div_head))->row_array();
		$data['total_team'] = $this->inbox_model->countTeam($division_name);
		$data['total_approved'] = $this->inbox_model->countRequest($division_name, '3');
		$data['total_inprogress'] = $this->inbox_model->countRequest($division_name, '1');
		$data['total_revise'] = $this->inbox_model->countRequest($division_name, '2');
		$data['total_a'] = $this->inbox_model->getTotalGrade($division_name, 'a');
		$data['total_b'] = $this->inbox_model->getTotalGrade($division_name, 'b');
		$data['total_c'] = $this->inbox_model->getTotalGrade($division_name, 'c');
		$data['total_d'] = $this->inbox_model->getTotalGrade($division_name, 'd');
		$data['total_e'] = $this->inbox_model->getTotalGrade($division_name, 'e');

		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'inbox/form/details_division';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function quickView()
	{
		$id = $this->input->post('id');
		$data = $this->m_global->find('id', $id, 'performance_appraisal')->result_array();
		echo json_encode($data);
	}

	public function responseRequest()
	{
		$output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
		
		$request_id = $this->input->post('id');
		$approval_id = $this->input->post('approval_id');
		$response = $this->input->post('resp');

		$requestor = $this->m_global->find('id', $request_id, 'performance_appraisal')->row_array()['created_by'];
		$data_response = array(
			'approval_status' => $response, 
			'updated_at' => $this->date, 
			'updated_by' => $this->email
		);

		// previous layer
		$priority = $this->m_global->find('id', $approval_id, 'form_approval')->row_array()['approval_priority'];
		$prev_priority = $priority-1;
		$prev_id = $this->inbox_model->find_select("id",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

		$prev_email = $this->inbox_model->find_select("approval_email",array('approval_priority'=>$prev_priority,'request_id'=>$request_id),'form_approval')->row_array();

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

						$this->db->where('id', $prev_id['id']);
						if ($this->db->update('form_approval', $data_prev_layer)) {
						
							$this->sendEmail('revise', $request_id, $prev_email['approval_email']);
							$this->logs('revised', 'KPI', $request_id, 'Response revised', 'Success');
							$output = array('status' => 1);
						}
						
					}

				} else {

					if ($this->db->where('request_id', $request_id)->delete('form_approval')) {

						$this->db->where('id', $request_id);
						if ($this->db->update('performance_appraisal', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
							$this->sendEmail('revise', $request_id, $requestor);
							$this->logs('revised', 'KPI', $request_id, 'Response revised', 'Success');
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

	public function save($type = "", $id_table = "")
    {
        switch ($type) {

        	case 'final_score':

				$request_id = $this->input->post('id');

				$formData = array(
					'final_score' => $this->input->post('final_score'),
					'updated_by' => $this->email,
					'updated_at' => $this->date
				);

				$this->db->where('id', $request_id);
				$updateHeader = $this->db->update('performance_appraisal', $formData);

				if ($updateHeader) {
					$response = array('status' => 1);
				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'submit_to_hr':

				$transok = 0;
				$year = $this->year - 1;
				$eval_year = $year.'-01-01';

				$formData = array(
					'evaluation_period' => $eval_year,
					'division_name' => $this->session->userdata('division'),
					'is_status' => 1,
					'updated_by' => $this->email,
					'updated_at' => $this->date
				);
				
				$check = $this->db->get_where('performance_division_status', 
					array('division_name' => $this->session->userdata('division'), 'evaluation_period' => $eval_year));

				if ($check->num_rows() == 1) {
					$this->db->where('id', $check->row_array()['id']);
					$this->db->update('performance_division_status', $formData);
					
					$this->logs('submit_to_hr', 'KPI', $check->row_array()['id'], 'Submit to HR');

					$this->sendEmail('submit_to_hr', $check->row_array()['id'], 'dawan.malafi@ibstower.com');
					$transok = 1;

				} else {
					$this->db->insert('performance_division_status', $formData);
					$division_status_id = $this->db->insert_id();
					$this->logs('submit_to_hr', 'KPI', $division_status_id, 'Submit to HR');
					$this->sendEmail('submit_to_hr', $division_status_id, 'dawan.malafi@ibstower.com');
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
					'updated_by' => $this->email,
					'updated_at' => $this->date
				);
				
				$check = $this->db->get_where('performance_division_status', 
					array('division_name' => $this->session->userdata('second_division'), 'evaluation_period' => $eval_year));

				if ($check->num_rows() == 1) {
					$this->db->where('id', $check->row_array()['id']);
					$this->db->update('performance_division_status', $formData);
					
					$this->logs('submit_to_hr', 'KPI', $check->row_array()['id'], 'Submit to HR');

					$this->sendEmail('submit_to_hr', $check->row_array()['id'], 'dawan.malafi@ibstower.com');
					$transok = 1;

				} else {
					$this->db->insert('performance_division_status', $formData);
					$division_status_id = $this->db->insert_id();
					$this->logs('submit_to_hr', 'KPI', $division_status_id, 'Submit to HR');
					$this->sendEmail('submit_to_hr', $division_status_id, 'dawan.malafi@ibstower.com');
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

				$formData = array(
					'is_status' => 2,
					'response_by' => $this->email,
					'response_at' => $this->date
				);

				$div_head_email = $this->db->get_where('performance_division_status', array('id' => $id_table))->row_array()['updated_by'];

				$this->db->where('id', $id_table);
				if ($this->db->update('performance_division_status', $formData)) {
					$this->sendEmail('revised_by_hr', $id_table, $div_head_email);
					$this->logs('revised_by_hr', 'KPI', $id_table, 'Revised by HR');
					$response = array('status' => 1);

				} else {
					$this->logs('system', 'KPI', $id_table, 'Revised by HR');
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'Confirm':

				$formData = array(
					'is_status' => 3,
					'response_by' => $this->email,
					'response_at' => $this->date
				);
				
				$div_head_email = $this->db->get_where('performance_division_status', array('id' => $id_table))->row_array()['updated_by'];

				$this->db->where('id', $id_table);
				if ($this->db->update('performance_division_status', $formData)) {
					$this->sendEmail('confirm_by_hr', $id_table, $div_head_email);
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

                if ($this->db->insert('request_notes', $field)) {
                    $this->logs('save_notes', 'KPI', $id, 'Add notes', $this->input->post('notes'));
                    $response = array('status' => 1, 'id' => encode_url($id), 'messages' => 'Notes has been saved.');
                } else {
                    $this->logs('system', $id, 'Failed while saving invoices notes.');
                    $response = array('status' => 0, 'messages' => 'There\s something wrong. Please try again.');
                }

                echo json_encode($response);
                break;

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

			case 'revised':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

	public function sendEmail($type, $requestId, $email_to)
	{
		$employee_name = $this->m_global->find('id', $requestId, 'performance_appraisal')->row_array()['employee_name'];
		$division_name = $this->db->get_where('performance_division_status', array('id' => $requestId))->row_array()['division_name'];
		$data['division_name'] = $division_name;

		$data['detail'] = $this->m_global->find('id', $requestId, 'performance_appraisal')->row_array();
		$data['approval'] = $this->m_global->find('request_id', $requestId, 'form_approval')->result_array();
		$data['email'] = $email_to;

		if ($type == 'need_response') {
			$html = $this->load->view('services/email/need_response', $data, TRUE);
			$email_subject = 'Performance Appraisal - ['. $employee_name .']';
		
		} elseif ($type == 'revise') {
			$html = $this->load->view('services/email/revise', $data, TRUE);
			$email_subject = 'Performance Appraisal - ['. $employee_name .']';

		} elseif ($type == 'approved') {
			$html = $this->load->view('services/email/approved', $data, TRUE);
			$email_subject = 'Performance Appraisal - ['. $employee_name .']';
			
		} elseif ($type == 'submit_to_hr') {
			$html = $this->load->view('services/email/submit_to_hr', $data, TRUE);
			$email_subject = 'PA & Plan - ['. $division_name .'] - [Submitted]';
			
		} elseif ($type == 'revised_by_hr') {
			$html = $this->load->view('services/email/revised_by_hr', $data, TRUE);
			$email_subject = 'PA & Plan - ['. $division_name .'] - [Revised]';
			
		} elseif ($type == 'confirm_by_hr') {
			$html = $this->load->view('services/email/confirm_by_hr', $data, TRUE);
			$email_subject = 'PA & Plan - ['. $division_name .'] - [Confirmed]';
		} 

		$url = 'https://api.ibstower.com/email_service';
		$params = array(
			'app_name'      => 'eApproval',
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
