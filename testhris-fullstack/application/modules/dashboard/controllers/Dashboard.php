<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('enc');
		$this->enc->check_session();
		$this->email = $this->session->userdata('user_email');
		$this->division = $this->session->userdata('division');
		$this->directorate = $this->session->userdata('directorate');
		$this->department = $this->session->userdata('department');
		$this->second_division = $this->session->userdata('second_division');
        $this->emp_id = $this->session->userdata('employee_id');

        // if ($this->emp_id == '') {
        //     print_r("You are not authorized to access this apps.");
        //     exit();
        // }
        
        $this->load->helper('general');
        $this->load->model('dashboard_model');
        $this->load->model('inbox/inbox_model');
        $this->load->model('home/home_model');
        $this->load->model('form/form_model');
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
		//dumper($this->session->userdata('access_employee'));
		
		if (($this->session->userdata('access_employee') != '1') && ($this->session->userdata('access_employee') != '12') && ($this->session->userdata('access_employee') != '13') && ($this->session->userdata('access_employee') != '14') && ($this->session->userdata('access_employee') != '2') && ($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '27') && ($this->session->userdata('access_employee') != '3')) {
            print_r('You are not authorized to access this page');die;
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
		$data['InfoEmployee'] = $this->dashboard_model->InfoEmployee();
		$data['info'] = $this->dashboard_model->getInfo();
        $data['formType'] = $this->form_model->getFormType();
        // dumper($data['formType']);
		//$data['content'] = 'dashboard/dashboard';
		if($this->session->userdata('access_employee') == '13'){
			$data['content'] = 'dashboard/dashboardAPFCT';
		}else{
			$data['content'] = 'dashboard/dashboardHRIS';
		}
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function pa_management($year="")
	{
		if (($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '4')) {
			print_r('You are not authorized to access this page');die;
		}
		if($year == ""){
			$year = $this->year - 1;
		}
		$data['year'] = $year;
		$data['header'] = $this->inbox_model->getPAList($year);
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/list_pa_approved';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function gradeView($grade)
	{
		
		if (($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$data['fullapproved'] = $this->dashboard_model->countByStatus('3', $eval_year, 'KPI');
		$data['total_a'] = $this->dashboard_model->getTotalGradeAll('a', $eval_year);
		$data['total_b'] = $this->dashboard_model->getTotalGradeAll('b', $eval_year);
		$data['total_c'] = $this->dashboard_model->getTotalGradeAll('c', $eval_year);
		$data['total_d'] = $this->dashboard_model->getTotalGradeAll('d', $eval_year);
		$data['total_e'] = $this->dashboard_model->getTotalGradeAll('e', $eval_year);
		$data['totalEmployee'] = $this->dashboard_model->countEmployee();
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
		$data['content'] = 'dashboard/gradeView';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function gradeViewC($grade)
	{
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		// vidayat add  && ($this->session->userdata('access_employee') != '99') sementara
		if (($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['fullapproved'] = $this->dashboard_model->countByStatusC($this->directorate, '3', $eval_year);
		$data['revise'] = $this->dashboard_model->countByStatusC($this->directorate, '2', $eval_year);
		$data['waiting'] = $this->dashboard_model->countByStatusC($this->directorate, '1', $eval_year);

		$data['total_a'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'a', $eval_year);
		$data['total_b'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'b', $eval_year);
		$data['total_c'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'c', $eval_year);
		$data['total_d'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'd', $eval_year);
		$data['total_e'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'e', $eval_year);
		$data['totalEmployee'] = $this->dashboard_model->countEmployeeC($this->directorate);
		// echo $data['totalEmployee']." xxx<br>";
		// die;

		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['content'] = 'dashboard/gradeViewC';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function gradeViewHr($grade)
	{
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['fullapproved'] = $this->dashboard_model->countByStatus('3', $eval_year, 'KPI');
		$data['total_a'] = $this->dashboard_model->getTotalGradeAll('a', $eval_year);
		$data['total_b'] = $this->dashboard_model->getTotalGradeAll('b', $eval_year);
		$data['total_c'] = $this->dashboard_model->getTotalGradeAll('c', $eval_year);
		$data['total_d'] = $this->dashboard_model->getTotalGradeAll('d', $eval_year);
		$data['total_e'] = $this->dashboard_model->getTotalGradeAll('e', $eval_year);
		$data['totalEmployee'] = $this->dashboard_model->countEmployee();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/gradeViewHr';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function m()
	{
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		if (($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['eligible'] = $this->dashboard_model->countEligible('1',$this->year-1);
		$data['not_eligible'] = $this->dashboard_model->countEligible('0',$this->year-1);

		$data['unsubmitted'] = $this->dashboard_model->countUnsubmitted($eval_year);

		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['fullapproved'] = $this->dashboard_model->countByStatus('3', $eval_year, 'KPI');
		$data['revise'] = $this->dashboard_model->countByStatus('2', $eval_year, 'KPI');
		$data['waiting'] = $this->dashboard_model->countByStatus('1', $eval_year, 'KPI');
		$data['fullapproved_p'] = $this->dashboard_model->countByStatus('3', $eval_year, 'PLAN');
		$data['revise_p'] = $this->dashboard_model->countByStatus('2', $eval_year, 'PLAN');
		$data['waiting_p'] = $this->dashboard_model->countByStatus('1', $eval_year, 'PLAN');
		$data['total_a'] = $this->dashboard_model->getTotalGradeAll('a', $eval_year);
		$data['total_b'] = $this->dashboard_model->getTotalGradeAll('b', $eval_year);
		$data['total_c'] = $this->dashboard_model->getTotalGradeAll('c', $eval_year);
		$data['total_d'] = $this->dashboard_model->getTotalGradeAll('d', $eval_year);
		$data['total_e'] = $this->dashboard_model->getTotalGradeAll('e', $eval_year);
		$data['totalEmployee'] = $this->dashboard_model->countEmployee();
		$data['totalDivision'] = $this->dashboard_model->countDivision();
		$data['totalConfirmed'] = $this->dashboard_model->countConfirmed($eval_year);
		$data['dataBLAll'] = $this->dashboard_model->countBasicLineAll();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/dashboard';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function c()
	{
		if (($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$data['eligible'] = $this->dashboard_model->countEligibleC($this->directorate, '1',$this->year-1);
		$data['not_eligible'] = $this->dashboard_model->countEligibleC($this->directorate, '0',$this->year-1);

		$data['unsubmitted'] = $this->dashboard_model->countUnsubmittedC($this->directorate, $eval_year);
		$data['fullapproved'] = $this->dashboard_model->countByStatusC($this->directorate, '3', $eval_year);
		$data['revise'] = $this->dashboard_model->countByStatusC($this->directorate, '2', $eval_year);
		$data['waiting'] = $this->dashboard_model->countByStatusC($this->directorate, '1', $eval_year);
		$data['total_a'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'a', $eval_year);
		$data['total_b'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'b', $eval_year);
		$data['total_c'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'c', $eval_year);
		$data['total_d'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'd', $eval_year);
		$data['total_e'] = $this->dashboard_model->getTotalGradeAllC($this->directorate, 'e', $eval_year);
		$data['totalEmployee'] = $this->dashboard_model->countEmployeeC($this->directorate);
		$data['totalDivision'] = $this->dashboard_model->countDivisionC($this->directorate);
		$data['totalConfirmed'] = $this->dashboard_model->countConfirmedC($this->directorate, $eval_year);

		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/dashboard_c';

		$sql = "SELECT division FROM multi_division WHERE nik='".$this->emp_id."' AND eval_year = '".$year."'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		if(!empty($res)){
			foreach($res as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' or division in ('".$div_name."') group by division")->result_array();	
		}else{
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' group by division")->result_array();
			foreach($div as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);

			$director = $this->db->query("select director from v_hris_employee_updated group by director")->result_array();
			foreach($director as $key => $val){
				$data_director[] = decrypt($val['director']);
			}
			$director = implode("','", $data_director);
			
			$sql2 = "SELECT division FROM multi_division WHERE division in ('$div_name') AND nik in ('$director') AND eval_year = '".$year."' group by division";
			$query2 = $this->db->query($sql2);
			$res2 = $query2->result_array();
			$div_name2 = "";
			if(!empty($res2)){
				foreach($res2 as $key => $val){
					$data_collect2[] = $val['division'];
				}
				$div_name2 = implode("','", $data_collect2);
			}
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' AND division not in ('$div_name2') group by division")->result_array();
		}
		// $div = $this->db->query("select division from hris_employee where directorate = '".$this->directorate."' and division != '".encrypt('MANAGEMENT')."' group by division")->result_array();
		// $div = $this->db->query("select division from hris_employee where directorate = '".$this->directorate."' group by division")->result_array();
		$division = "";
		foreach($div as $key => $val){

			$sql = "Select division_name,updated_by,(CASE WHEN is_status is null THEN 0 ELSE is_status END) as is_status from performance_division_status where evaluation_period = '$eval_year' and division_name = '".$val['division']."'";
			$datas = $this->db->query($sql)->result_array();
			
			if(count($datas) > 0){
				foreach($datas as $k => $v){
					$dataz[] = $v['division_name'];//array("division_name_encrypt" => $v['division_name'],"division_name" => decrypt($v['division_name']));
				}
				
			}else{
				$dataz[] = $val['division'];//array("division_name_encrypt" => $val['division'],"division_name" => decrypt($val['division']));
			}
		}
		$data['division'] = $dataz;

		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function h()
	{
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		// echo $eval_year;
		// die;
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['eligible'] = $this->dashboard_model->countEligible('1',$this->year-1);
		$data['not_eligible'] = $this->dashboard_model->countEligible('0',$this->year-1);

		$data['unsubmitted'] = $this->dashboard_model->countUnsubmitted($eval_year);

		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['fullapproved'] = $this->dashboard_model->countByStatus('3', $eval_year, 'KPI');
		$data['revise'] = $this->dashboard_model->countByStatus('2', $eval_year, 'KPI');
		$data['waiting'] = $this->dashboard_model->countByStatus('1', $eval_year, 'KPI');
		$data['fullapproved_p'] = $this->dashboard_model->countByStatus('3', $eval_year, 'PLAN');
		$data['revise_p'] = $this->dashboard_model->countByStatus('2', $eval_year, 'PLAN');
		$data['waiting_p'] = $this->dashboard_model->countByStatus('1', $eval_year, 'PLAN');
		$data['total_a'] = $this->dashboard_model->getTotalGradeAll('a', $eval_year);
		$data['total_b'] = $this->dashboard_model->getTotalGradeAll('b', $eval_year);
		$data['total_c'] = $this->dashboard_model->getTotalGradeAll('c', $eval_year);
		$data['total_d'] = $this->dashboard_model->getTotalGradeAll('d', $eval_year);
		$data['total_e'] = $this->dashboard_model->getTotalGradeAll('e', $eval_year);
		$data['totalEmployee'] = $this->dashboard_model->countEmployee();
		$data['totalDivision'] = $this->dashboard_model->countDivision();
		$data['totalConfirmed'] = $this->dashboard_model->countConfirmed($eval_year);
		$data['dataBLAll'] = $this->dashboard_model->countBasicLineAll();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/dashboard_hr';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read_data_employee($table)
	{
		switch ($table) {

			case 'family_employee':

				$listF = $this->dashboard_model->getFamilyEmployee();
		        if (!empty($listF)) {
		            foreach ($listF as $key) {

						$member_birthdate = decrypt($key->member_birthdate);
						$member_birthdate = DateTime::createFromFormat('Ymd', $member_birthdate);
						$member_birthdate = $member_birthdate->format('d.m.Y');

						$member_names = str_replace("||","'", decrypt($key->member_names));

		                $row   = array();
		                $row[] = decrypt($key->family_members);
		                $row[] = decrypt($key->seqno);
						$row[] = $member_names;
						$row[] = decrypt($key->member_gender);
						$row[] = decrypt($key->member_birthplace);
						$row[] = $member_birthdate;
		                $data[] = $row;
		            }
		            $outputF = array('data' => $data);
		        } else {
		            $outputF = array('data' => new ArrayObject());
		        }
		        echo json_encode($outputF);
				break;

			default:
				break;
		}
	}

	public function read($type)
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

    	switch ($type) {

    		case 'all':
    			$listForm = $this->inbox_model->getAllDataPA($eval_year);
    			break;

    		case 'a':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'a');
    			break;

    		case 'b':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'b');
    			break;

    		case 'c':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'c');
    			break;

    		case 'd':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'd');
    			break;

    		case 'e':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'e');
    			break;
    		
    		default:
    			break;
    	}

    	if (!empty($listForm)) {
            foreach ($listForm as $key) {
                $row   = array();
                $row[] = $key->employee_nik;
                $row[] = decrypt($key->employee_name);
                $row[] = decrypt($key->division);
                $row[] = decrypt($key->departement);
                $row[] = decrypt($key->position);
                $row[] = status_text($key->is_status);
                $row[] = decrypt($key->direct_manager);
                $row[] = decrypt($key->office_location);
                $row[] = $key->join_date;
                $row[] = decrypt($key->employment_status);
                $row[] = decrypt($key->final_score);
                $row[] = grade_pa(decrypt($key->final_score));
                $row[] = $key->full_approved_date;
                $row[] = $key->request_number;
                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
		// die;
    }

	public function read_c($type, $division = "")
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		if($division != ""){
			$division = str_replace("%20"," ",$division);
			$division = str_replace("@", "#", $division);
			if($division == "all"){
				$division = "";
			}
		}
		switch ($type) {

    		case 'all':
    			$listForm = $this->dashboard_model->getAllDataPAC($this->directorate, $eval_year, $division);
    			break;

    		case 'a':
    			$listForm = $this->dashboard_model->getAllbyGradeC($this->directorate, $eval_year, 'a');
    			break;

    		case 'b':
    			$listForm = $this->dashboard_model->getAllbyGradeC($this->directorate, $eval_year, 'b');
    			break;

    		case 'c':
    			$listForm = $this->dashboard_model->getAllbyGradeC($this->directorate, $eval_year, 'c');
    			break;

    		case 'd':
    			$listForm = $this->dashboard_model->getAllbyGradeC($this->directorate, $eval_year, 'd');
    			break;

    		case 'e':
    			$listForm = $this->dashboard_model->getAllbyGradeC($this->directorate, $eval_year, 'e');
    			break;
    		
    		default:
    			break;
    	}

    	if (!empty($listForm)) {
            foreach ($listForm as $key) {
                $row   = array();
                $row[] = $key->employee_nik;
                $row[] = decrypt($key->employee_name);
                $row[] = decrypt($key->division);
                $row[] = decrypt($key->departement);
                $row[] = decrypt($key->position);
                $row[] = status_text($key->is_status);
                $row[] = decrypt($key->direct_manager);
                $row[] = decrypt($key->office_location);
                $row[] = $key->join_date;
                $row[] = decrypt($key->employment_status);
                $row[] = decrypt($key->final_score);
                $row[] = grade_pa(decrypt($key->final_score));
                $row[] = $key->full_approved_date;
                $row[] = $key->request_number;
                if ($key->is_status == 3) {
					$division = "'".str_replace(" ","_",str_replace("#","@",$key->division))."'";
	            	// $row[] = '<div class="btn-group btn-group-sm">
	                //             <a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickViewDashboard(this.id,'.$division.')">
	                //                 <em class="icon ni ni-edit"></em>
	                //             </a>
	                //     	</div>';
					$row[] = "";
                } else {
					$row[] = '';                	
                }

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

    public function read_hr($type, $year = "")
    {
		if($year == ""){	
			$year = $this->year - 1;
		}
		$eval_year = $year.'-01-01';

    	switch ($type) {

    		case 'all':
    			$listForm = $this->inbox_model->getAllDataPAOk($eval_year);
    			break;

    		case 'a':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'a');
    			break;

    		case 'b':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'b');
    			break;

    		case 'c':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'c');
    			break;

    		case 'd':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'd');
    			break;

    		case 'e':
    			$listForm = $this->dashboard_model->getAllbyGrade($eval_year, 'e');
    			break;
			
			case 'pa':
				$listForm = $this->inbox_model->getAllDataOnlyPAOk($eval_year);
				break;
			case 'history_pa':
				$listForm = $this->inbox_model->getAllDataOnlyPAOk($eval_year);
				break;
			case 'ninebox':
				$listForm = $this->inbox_model->getAllDataOnlyPAOk($eval_year);
				break;
			case 'training':
				$listForm = $this->inbox_model->getAllDataTraining($eval_year);
				break;
    		
    		default:
    			break;
    	}
		
		if ($type == "all") {
			if (!empty($listForm)) {
				// dumper($listForm);
				foreach ($listForm as $key) {
					if($key->final_score == "" || $key->final_score == '0' || $key->final_score == 'NaN'){
						$final_1 = 0;
						$final_2 = grade_pa(0);
					}else{
						$final_1 = decrypt($key->final_score);
						$final_2 = grade_pa(decrypt($key->final_score));
					}
					$row   = array();
					$row[] = $key->employee_nik;
					$row[] = decrypt($key->employee_name);
					$row[] = decrypt($key->division);
					$row[] = decrypt($key->departement);
					$row[] = decrypt($key->position);
					$row[] = $key->form_type;
					$row[] = $key->request_number;
					$row[] = status_text($key->is_status);
					$row[] = decrypt($key->direct_manager);
					$row[] = decrypt($key->office_location);
					$row[] = $key->join_date;
					$row[] = decrypt($key->employment_status);
					// $row[] = decrypt($key->final_score);
					// $row[] = grade_pa(decrypt($key->final_score));
					$row[] = $final_1;
					$row[] = $final_2;
					$row[] = $key->ApprovalLayer1;
					$row[] = $key->ApprovalLayer1Date;
					$row[] = $key->ApprovalLayer2;
					$row[] = $key->ApprovalLayer2Date;
					$row[] = $key->full_approved_date;
					$data[] = $row;
				}
				$output = array('data' => $data);
			} else {
				$output = array('data' => new ArrayObject());
			}
		}
		// elseif($type == "ninebox"){
		// 	if (!empty($listForm)) {
		// 		foreach ($listForm as $key) {
		// 			if($key->final_score == "" or $key->final_score == 0){
		// 				$dec = $key->final_score;
		// 			}else{
		// 				$dec = grade_pa(decrypt($key->final_score));
		// 			}
		// 			$row   = array();
		// 			$row[] = $key->employee_nik;
		// 			$row[] = decrypt($key->employee_name);
		// 			$row[] = decrypt($key->division);
		// 			$row[] = decrypt($key->departement);
		// 			$row[] = decrypt($key->position);
		// 			$row[] = status_text($key->is_status);
		// 			$row[] = "<b>".$key->nine_box_note."</b>";
		// 			$data[] = $row;
		// 		}
		// 		$output = array('data' => $data);
		// 	} else {
		// 		$output = array('data' => new ArrayObject());
		// 	}
		// }
		elseif($type == "training"){
			if (!empty($listForm)) {
				foreach ($listForm as $key) {

					$row   = array();
					$row[] = $key->employee_nik;
					$row[] = decrypt($key->employee_name);
					$row[] = decrypt($key->position);
					$row[] = decrypt($key->division);
					$row[] = decrypt($key->category)." skill";
					$row[] = decrypt($key->training_name);
					$data[] = $row;
				}
				$output = array('data' => $data);
			} else {
				$output = array('data' => new ArrayObject());
			}
		}else {
			if (!empty($listForm)) {
				foreach ($listForm as $key) {
					$row   = array();
					if(($key->final_score == "" and $key->final_score == '0') or decrypt($key->final_score) == '0'){
						$final_1 = 0;
						$final_2 = grade_pa(0);
					}else{
						$final_1 = $key->final_score;
						$final_2 = grade_pa(decrypt($key->final_score));
					}
					$row[] = $key->employee_nik;
					$row[] = decrypt($key->employee_name);
					$row[] = decrypt($key->division);
					$row[] = decrypt($key->departement);
					$row[] = decrypt($key->position);
					$row[] = decrypt($key->final_score);
					$row[] = decrypt($key->direct_manager);
					$row[] = decrypt($key->office_location);
					$row[] = $key->join_date;
					$row[] = decrypt($key->employment_status);
					$row[] = status_text($key->is_status);					
					$row[] = $final_2;
					$row[] = $key->full_approved_date;
					$row[] = $key->request_number;
					$data[] = $row;
				}
				$output = array('data' => $data);
			} else {
				$output = array('data' => new ArrayObject());
			}
		}
		
        echo json_encode($output);
    }

    public function mgmt()
	{
		if (($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $this->division, 'evaluation_period' => $eval_year))->row_array();
		if(empty($data['division_status'])){
			$data['division_status']['is_status'] = 0;
		}

		if ($this->session->userdata('second_division') != '') {

			dumper('UNDER CONSTRUCTION');

			$data['second_division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $this->second_division, 'evaluation_period' => $eval_year))->row_array();
			// dumper($data['second_division_status']);
			$data['second_total_team'] = $this->inbox_model->countTeamSecondDivision($this->second_division);
			$data['second_total_inprogress'] = $this->inbox_model->countRequest($this->second_division, '1',$eval_year);
			$data['second_total_approved'] = $this->inbox_model->countRequest($this->second_division, '3',$eval_year);
			$data['second_total_revise'] = $this->inbox_model->countRequest($this->second_division, '2',$eval_year);
			$data['second_total_a'] = $this->inbox_model->getTotalGrade($this->second_division, 'a',$eval_year);
			$data['second_total_b'] = $this->inbox_model->getTotalGrade($this->second_division, 'b',$eval_year);
			$data['second_total_c'] = $this->inbox_model->getTotalGrade($this->second_division, 'c',$eval_year);
			$data['second_total_d'] = $this->inbox_model->getTotalGrade($this->second_division, 'd',$eval_year);
			$data['second_total_e'] = $this->inbox_model->getTotalGrade($this->second_division, 'e',$eval_year);

			$data['low_contributor_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"Low Contributor");
			$data['average_performer_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"Average Performer");
			$data['solid_performer_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"Solid Performer");
			$data['inconsistent_player_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"Inconsistent Player");
			$data['core_player_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"Core Player");
			$data['high_performer_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"High Performer");
			$data['potential_performer_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"Potential Performer");
			$data['high_potential_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"High Potential");
			$data['star_pmo'] = $this->inbox_model->get_nine_box($this->second_division,$eval_year,"Star");
			// $data['total_team_eligible_pmo'] = $this->inbox_model->countTeamEligible($this->second_division);
			$data['total_talent_map_pmo'] = $this->inbox_model->countTalentTeam($this->second_division);

			//====================BASIC LINE DEVISIASI=======================//
			$checkRevise = $this->inbox_model->checkDevisiasi($this->second_division, $year);
			if($checkRevise > 0){
				$data['devisiasi_basic_line_a_second'] = $this->inbox_model->getDevisiasi($this->second_division, 'a', $year);
				$data['devisiasi_basic_line_b_second'] = $this->inbox_model->getDevisiasi($this->second_division, 'b', $year);
				$data['devisiasi_basic_line_c_second'] = $this->inbox_model->getDevisiasi($this->second_division, 'c', $year);
				$data['devisiasi_basic_line_d_second'] = $this->inbox_model->getDevisiasi($this->second_division, 'd', $year);
				$data['devisiasi_basic_line_e_second'] = $this->inbox_model->getDevisiasi($this->second_division, 'e', $year);
				
			}else{
				$data['devisiasi_basic_line_a_second'] = "";
				$data['devisiasi_basic_line_b_second'] = "";
				$data['devisiasi_basic_line_c_second'] = "";
				$data['devisiasi_basic_line_d_second'] = "";
				$data['devisiasi_basic_line_e_second'] = "";
			}
			//===============================================================//

			$content = 'dashboard/pa_multi_division';
		} else {
			$content = 'dashboard/pa_management';
		}

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

		//================= ceo =============================================
		$data['total_team'] = $this->dashboard_model->countTeam();
		// //////////Start Penambahan Nine BOX//////////////
		$data['total_team_eligible'] = $this->inbox_model->countTeamEligible($this->division);
		// $data['total_talent_map'] = $this->inbox_model->countTalentTeam($this->division);
		// //////////End Penambahan Nine BOX//////////////
		$data['total_inprogress'] = $this->dashboard_model->countRequest('1',$eval_year);
		$data['total_approved'] = $this->dashboard_model->countRequest('3',$eval_year);
		$data['total_revise'] = $this->dashboard_model->countRequest('2',$eval_year);
		$data['total_a'] = $this->dashboard_model->getTotalGrade('a',$eval_year);
		$data['total_b'] = $this->dashboard_model->getTotalGrade('b',$eval_year);
		$data['total_c'] = $this->dashboard_model->getTotalGrade('c',$eval_year);
		$data['total_d'] = $this->dashboard_model->getTotalGrade('d',$eval_year);
		$data['total_e'] = $this->dashboard_model->getTotalGrade('e',$eval_year);
		//================= end ceo ===============================================

		
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


		// $data['low_contributor'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Low Contributor");
		// $data['average_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Average Performer");
		// $data['solid_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Solid Performer");
		// $data['inconsistent_player'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Inconsistent Player");
		// $data['core_player'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Core Player");
		// $data['high_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"High Performer");
		// $data['potential_performer'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Potential Performer");
		// $data['high_potential'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"High Potential");
		// $data['star'] = $this->inbox_model->get_nine_box($this->division,$eval_year,"Star");

		
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read_by_division($div)
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$division = str_replace('%20', ' ', $div);
		//dumper($division);
		$division = encrypt($division);
		$listForm = $this->dashboard_model->getDivHeadListByDivision($division,$eval_year);
		//dumper($listForm);
		$second_division_status = isset($this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array()['is_status']);
       
        if (!empty($listForm)) {
            foreach ($listForm as $key) {

            	$count_layer = $this->db->get_where('form_approval', array('request_id' => $key->id))->num_rows();
            	$approval_priority = isset($this->db->get_where('form_approval', array('request_id' => $key->id, 'approval_email' => $this->email))->row_array()['approval_priority']);

            	$show = ($count_layer == $approval_priority) ? '' : 'none';

                $row  = array();
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

	public function read_by_second_division($div)
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$division = str_replace('%20', ' ', $div);
		//dumper($division);
		$division = encrypt($division);
		$listForm = $this->dashboard_model->getDivHeadListBySecondDivision($division,$eval_year);
		
		$second_division_status = isset($this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array()['is_status']);
       
        if (!empty($listForm)) {
            foreach ($listForm as $key) {

				$id_form_request = $this->m_global->find('form_request', 'request_number', $key->request_number)->row_array()['id'];
            	$count_layer = $this->db->get_where('form_approval', array('request_id' => $id_form_request))->num_rows();
            	$approval_priority = isset($this->db->get_where('form_approval', array('request_id' => $id_form_request, 'approval_email' => $this->email))->row_array()['approval_priority']);
				if(decrypt($key->employee_name) == 'ALISTA WIDIASTI'){
				//dumper($count_layer.' - '.$approval_priority);
				}

            	$show = ($count_layer == $approval_priority) ? '' : 'none';

                $row  = array();
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
                
                if ($second_division_status == 1) {
                	$row[] = '';
                
                } else if ($second_division_status == 3) {
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

	public function viewSummary($type)
	{
		$status = $this->input->post('status');

		switch ($type) {
			case 'division':
				$data = $this->db->get_where('performance_appraisal', array('division_root' => '1', 'is_status' => $status))->result_array();
				break;

			case 'second_division':
				$data = $this->db->get_where('performance_appraisal', array('division' => $this->second_division, 'is_status' => $status))->result_array();
				break;
			
			default:
				# code...
				break;
		}
		
		$output = array('data' => $data);
		echo json_encode($output);
	}

	public function m_division()
	{
		if (($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		
		$data['totalDivision'] = $this->dashboard_model->countDivision();
		$data['hr_confirm'] = $this->dashboard_model->countDivisionM('3');
		$data['revise'] = $this->dashboard_model->countDivisionM('2');
		$data['submitted'] = $this->dashboard_model->countDivisionM('1');
		$data['draft'] = $this->dashboard_model->countDivisionM('0');
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/list_division_m';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function c_division()
	{
		if (($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$this->db->where("evaluation_period", $eval_year);

		// if ($this->division == 'Finance') {
		// 	$this->db->where("division_name IN ('Finance & Accounting', 'Procurement')");
		// } else if ($this->division == 'Technology') {
		// 	$this->db->where("division_name IN ('Engineering', 'Master Planning', 'Product Development', 'Transmission Development')");
		// } else if ($this->division == 'Assets') {
		// 	$this->db->where("division_name IN ('Assets Management','Tower Operation & Property Management','NOC & Helpdesk','Strategic Acquisition','Property Management Support')");
		// } else if ($this->division == 'Operations') {
		// 	$this->db->where("division_name IN ('Regional Central')");
		// }
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
		$data['content'] = 'dashboard/list_division';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function m_view($division)
	{
		if (($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$division_name = str_replace(array('%20', '-'), array(' ', '&'), $division);

		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $division_name, 'evaluation_period' => $eval_year))->row_array();

		$data['total_team'] = $this->inbox_model->countTeam($division_name);
		$data['total_approved'] = $this->inbox_model->countRequest($division_name, '3');
		$data['total_inprogress'] = $this->inbox_model->countRequest($division_name, '1');
		$data['total_revise'] = $this->inbox_model->countRequest($division_name, '2');
		$data['total_a'] = $this->inbox_model->getTotalGrade($division_name, 'a');
		$data['total_b'] = $this->inbox_model->getTotalGrade($division_name, 'b');
		$data['total_c'] = $this->inbox_model->getTotalGrade($division_name, 'c');
		$data['total_d'] = $this->inbox_model->getTotalGrade($division_name, 'd');
		$data['total_e'] = $this->inbox_model->getTotalGrade($division_name, 'e');
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/detail_division';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function c_view($division)
	{
		if (($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$division_name = str_replace(array('%20', '-'), array(' ', '&'), $division);
		$data['division_status'] = $this->db->get_where('performance_division_status', array('division_name' => $division_name, 'evaluation_period' => $eval_year))->row_array();

		$data['total_team'] = $this->inbox_model->countTeam($division_name);
		$data['total_approved'] = $this->inbox_model->countRequest($division_name, '3');
		$data['total_inprogress'] = $this->inbox_model->countRequest($division_name, '1');
		$data['total_revise'] = $this->inbox_model->countRequest($division_name, '2');
		$data['total_a'] = $this->inbox_model->getTotalGrade($division_name, 'a');
		$data['total_b'] = $this->inbox_model->getTotalGrade($division_name, 'b');
		$data['total_c'] = $this->inbox_model->getTotalGrade($division_name, 'c');
		$data['total_d'] = $this->inbox_model->getTotalGrade($division_name, 'd');
		$data['total_e'] = $this->inbox_model->getTotalGrade($division_name, 'e');
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/detail_division';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read_c_division($division)
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$division_name = str_replace(array('%20', '-'), array(' ', '&'), $division);

		$listForm = $this->inbox_model->getHRReview($division_name);
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
            	if ($key->is_status == 3) {
	            	$row[] = '<div class="btn-group btn-group-sm">
	                            <a class="btn btn-icon btn-trigger" id="'.$key->id.'" onclick="return quickViewDashboard(this.id)">
	                                <em class="icon ni ni-edit"></em>
	                            </a>
	                    	</div>';
                } else {
					$row[] = '';                	
                }

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

    public function read_all_division()
    {
    	$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$listForm = $this->db->get('performance_division_status')->result();
        if (!empty($listForm)) {
            foreach ($listForm as $key) {
                $row   = array();
                $row[] = decrypt($key->division_name);
                $row[] = decrypt($key->updated_by);
                $row[] = status_division($key->is_status);
                $row[] = $key->response_by;
                $row[] = $key->response_at;
            	$row[] = '<div class="btn-group btn-group-sm">
                            <a href="' . base_url('dashboard/m_view/' . str_replace(array('%20', '&'), array(' ', '-'), $key->division_name)) . '" class="btn btn-icon btn-trigger">
                                <em class="icon ni ni-eye"></em>
                            </a>
                    	</div>';

                $data[] = $row;
            }
            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function viewDivision()
	{

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$sql = "SELECT division FROM multi_division WHERE nik='".$this->emp_id."' AND eval_year = '".$year."'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		if(!empty($res)){
			foreach($res as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' or division in ('".$div_name."') group by division")->result_array();	
		}else{
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' group by division")->result_array();
			foreach($div as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);

			$director = $this->db->query("select director from v_hris_employee_updated group by director")->result_array();
			foreach($director as $key => $val){
				$data_director[] = decrypt($val['director']);
			}
			$director = implode("','", $data_director);
			
			$sql2 = "SELECT division FROM multi_division WHERE division in ('$div_name') AND nik in ('$director') AND eval_year = '".$year."' group by division";
			$query2 = $this->db->query($sql2);
			$res2 = $query2->result_array();
			$div_name2 = "";
			if(!empty($res2)){
				foreach($res2 as $key => $val){
					$data_collect2[] = $val['division'];
				}
				$div_name2 = implode("','", $data_collect2);
			}
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' AND division not in ('$div_name2') group by division")->result_array();
		}

		// $div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' and division != '".encrypt('MANAGEMENT')."' group by division")->result_array();
		// $div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' group by division")->result_array();
		$division = "";
		foreach($div as $key => $val){

			$sql = "Select division_name,updated_by,(CASE WHEN is_status is null THEN 0 ELSE is_status END) as is_status from performance_division_status where evaluation_period = '$eval_year' and division_name = '".$val['division']."'";
			$datas = $this->db->query($sql)->result_array();
			
			if(count($datas) > 0){
				foreach($datas as $k => $v){
					$data[] = array("division_name" => decrypt($v['division_name']),"divhead_name" => $this->getDivHeadName($val['division']), "updated_by" => decrypt($v['updated_by']),"is_status" => $v['is_status']);
				}
				
			}else{
				$data[] = array("division_name" => decrypt($val['division']),"divhead_name" => $this->getDivHeadName($val['division']),"updated_by" => "","is_status" => 0);
			}
		}
		$output = array('data' => $data);
		echo json_encode($output);

	}

	public function viewDivision_M()
	{
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		// $nik = array('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007', '00000008');
		$this->db->where("action !=",encrypt('Leaving'));
		$this->db->where("division !=",encrypt('HR SUPPORT'));
		$this->db->where("division !=",'');
		// $this->db->where_not_in('nik', $nik);
		$cari_tis = $this->db->get('v_hris_employee_updated')->result_array();
		$data_collect = array();
		foreach($cari_tis as $key => $val){
			$personnel_area		= decrypt($val['personnel_area']);
			$pers 				= substr($personnel_area,0,3);
			if($pers != "TIS"){
				$data_collect[] = $val['nik'];
			}
		}
		// dumper($data_collect);
		$this->db->select('division');
		$this->db->where_in('nik', $data_collect);
		$this->db->group_by('division');
		$div = $this->db->get('v_hris_employee_updated')->result_array();
		
		// $div = $this->db->query("select division from v_hris_employee_updated where action != '".encrypt('Leaving')."' AND nik NOT IN ('00000000', '00000001', '00000002', '00000004') group by division")->result_array();
		$division = "";
		foreach($div as $key => $val){

			$sql = "Select division_name, updated_by,(CASE WHEN is_status is null THEN 0 ELSE is_status END) as is_status from performance_division_status where evaluation_period = '$eval_year' and division_name = '".$val['division']."'";
			$datas = $this->db->query($sql)->result_array();
			// dumper($datas);
			if(count($datas) > 0){
				foreach($datas as $k => $v){
					$data[] = array("division_name" => decrypt($v['division_name']),"divhead_name" => $this->getDivHeadName($val['division']), "updated_by" => decrypt($v['updated_by']),"is_status" => $v['is_status']);
				}
				
			}else{
				$data[] = array("division_name" => decrypt($val['division']),"divhead_name" => $this->getDivHeadName($val['division']),"updated_by" => "","is_status" => 0);
			}
		}
		$output = array('data' => $data);
		echo json_encode($output);
	}

	public function viewNotSubmitted($type)
	{
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$year = $year."-09-30";

		switch ($type) {

			case 'all_submission':
				//====================FOR HRD====================//
				$sql = "SELECT *
						FROM v_hris_employee_updated
						WHERE action != '".encrypt('Leaving')."' AND division != '' AND employee_subgroup != '".encrypt('Outsource')."'
							AND nik NOT IN (SELECT employee_nik FROM performance_appraisal WHERE evaluation_period_start = '$eval_year' AND is_status IN (1,2,3)) and nik NOT IN ('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007')";
				
				$datas = $this->db->query($sql)->result_array();
				foreach($datas as $key => $val){
					if($val['prev_joindate'] != ""){
						$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['prev_joindate'])));
						// echo "hehehe ".$val['join_date'];
					}else{
						$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['join_date'])));
					}

					$join_date = $val['join_date'];
					if($join_date <= $year){
						$eligible = 1;
						$personnel_area		= decrypt($val['personnel_area']);
						$pers 				= substr($personnel_area,0,3);
						if($pers != "TIS"){
							$data[] = array('employee_name' => decrypt($val['complete_name']), 'division' => decrypt($val['division']), 'position' => decrypt($val['position']), 'eligible_status' => $eligible);
						}
					}else{
						$eligible = 0;
					}
				}

				$output = array('data' => $data);
				break;
			
			case 'all_not_submission':
				//====================FOR HRD====================//
				// $sql = "SELECT *
				// 		FROM v_hris_employee_updated
				// 		WHERE action != '".encrypt('Leaving')."' AND division != '' AND employee_subgroup != '".encrypt('Outsource')."'
				// 			AND nik NOT IN (SELECT employee_nik FROM performance_appraisal WHERE evaluation_period_start = '$eval_year' AND is_status IN (1,2,3)) and nik NOT IN ('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007')";

				$sql = "SELECT *
						FROM v_hris_employee_updated
						WHERE action != '".encrypt('Leaving')."' AND division != '' AND division != '".encrypt('HR SUPPORT')."' AND employee_subgroup != 'c#w#Wmz#c#b#k#a#' AND nik NOT IN (SELECT employee_nik FROM performance_appraisal WHERE evaluation_period_start = '2023-01-01' AND is_status IN (1,2,3))";
				
				$datas = $this->db->query($sql)->result_array();
				foreach($datas as $key => $val){
					if($val['prev_joindate'] != ""){
						$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['prev_joindate'])));
						// echo "hehehe ".$val['join_date'];
					}else{
						$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['join_date'])));
					}

					$join_date = $val['join_date'];
					// if($join_date <= $year){
					// 	$eligible = 1;
					// 	$personnel_area		= decrypt($val['personnel_area']);
					// 	$pers 				= substr($personnel_area,0,3);
					// 	if($pers != "TIS"){
					// 		$data[] = array('employee_name' => decrypt($val['complete_name']), 'division' => decrypt($val['division']), 'position' => decrypt($val['position']), 'eligible_status' => $eligible);
					// 	}
					// }else{
					// 	$eligible = 0;
					// }
					
					if($join_date <= $year){
						$eligible = 1;
						$personnel_area		= decrypt($val['personnel_area']);
						$pers 				= substr($personnel_area,0,3);
						if($pers != "TIS"){
							$data[] = array('employee_name' => decrypt($val['complete_name']), 'division' => decrypt($val['division']), 'position' => decrypt($val['position']), 'eligible_status' => $eligible);
						}
					}else{
						$eligible = 0;
						$personnel_area		= decrypt($val['personnel_area']);
						$pers 				= substr($personnel_area,0,3);
						if($pers != "TIS"){
							$data[] = array('employee_name' => decrypt($val['complete_name']), 'division' => decrypt($val['division']), 'position' => decrypt($val['position']), 'eligible_status' => $eligible);
						}
					}
				}

				$output = array('data' => $data);
				break;
			
			default:
				//====================FOR C LEVEL====================//
				$data = array();
				$type = str_replace("%20", " ",$type);
				$type = encrypt($type);
				// $div = $this->db->query("select division from v_hris_employee_updated where directorate = '{$type}' and division != '".encrypt('MANAGEMENT')."' group by division")->result_array();
				$div = $this->db->query("select division from v_hris_employee_updated where directorate = '{$type}' group by division")->result_array();
				$division = "";
				foreach($div as $key => $val){
					$division .= ",'".$val['division']."'";
					
				}
				$division_in = " and division IN (".substr($division,1).")";
				
				$sql = "SELECT a.email,
					(SELECT complete_name FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as employee_name,
					(SELECT division FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as division,
					(SELECT position FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as position,
					(SELECT join_date FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as join_date,
						(SELECT prev_joindate FROM v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as prev_joindate
					FROM v_hris_employee_updated as a
					WHERE a.action != '".encrypt('Leaving')."' AND employee_subgroup != '".encrypt('Outsource')."'
					{$division_in}
					AND a.complete_name NOT IN (
						SELECT
							employee_name
						FROM
							(
								SELECT
									employee_name
								FROM
									performance_appraisal
								WHERE
									is_status IN ('1', '2', '3')
									AND
									evaluation_period_start = '$eval_year'
							) AS subquery
					)
					group by a.email";
				$datas = $this->db->query($sql)->result_array();
				foreach($datas as $key => $val){
					if($val['prev_joindate'] != ""){
						$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['prev_joindate'])));
						// echo "hehehe ".$val['join_date'];
					}else{
						$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['join_date'])));
					}
					$join_date = $val['join_date'];
					if($join_date <= $year){
						$eligible = 1;
						$data[] = array('employee_name' => decrypt($val['employee_name']), 'division' => decrypt($val['division']), 'position' => decrypt($val['position']), 'eligible_status' => $eligible);
					}else{
						$eligible = 0;
					}
				}
				$output = array('data' => $data);
				break;
		}
		
		echo json_encode($output);
	}

	public function listDivisionC()
	{
		if (($this->session->userdata('access_employee') != '3' && $this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
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
		$data['content'] = 'dashboard/list_division_adjustment_c';


		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function viewDivisionAdjustment()
	{

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$sql = "SELECT division FROM multi_division WHERE nik='".$this->emp_id."' AND eval_year = '".$year."'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		if(!empty($res)){
			foreach($res as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' or division in ('".$div_name."') group by division")->result_array();	
		}else{
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' group by division")->result_array();
			foreach($div as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);

			$director = $this->db->query("select director from v_hris_employee_updated group by director")->result_array();
			foreach($director as $key => $val){
				$data_director[] = decrypt($val['director']);
			}
			$director = implode("','", $data_director);
			
			$sql2 = "SELECT division FROM multi_division WHERE division in ('$div_name') AND nik in ('$director') AND eval_year = '".$year."' group by division";
			$query2 = $this->db->query($sql2);
			$res2 = $query2->result_array();
			$div_name2 = "";
			if(!empty($res2)){
				foreach($res2 as $key => $val){
					$data_collect2[] = $val['division'];
				}
				$div_name2 = implode("','", $data_collect2);
			}
			
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' AND division not in ('$div_name2') group by division")->result_array();
		}
		
		
		$division = "";
		// print_r($div);
		// die;
		$data = array();
		foreach ($div as $key) {
			// print_r($key);
			// die;
			$divhead = $this->db->query("select divhead_name from v_hris_employee_updated where division = '".$key['division']."' and divhead_name != '' and divhead_name != '##8#####' order by id_employee desc")->result_array();
			
			$division_status = $this->db->get_where('performance_division_status', array('division_name' => $key['division'], 'evaluation_period' => $eval_year))->row_array();
			

			$row   = array();
			$row[] = decrypt($key['division']);
			// if(decrypt($key['division']) == 'HRGA DIVISION'){
			// 	dumper($divhead);
			// }
			if(!empty($divhead[0]['divhead_name'])){
				$row[] = decrypt($divhead[0]['divhead_name']);;
			}else{
				$row[] = "";
			}
			// if($division_status['is_status'] == 1 or $division_status['is_status'] == 3){
			// 	$row[] = '';
			// }else{
				$row[] = '<div class="btn-group btn-group-sm">
						<a href = "dashboard/adjustmentPaC/'.encode_url(decrypt($key['division'])).'" class="btn btn-icon btn-trigger">
							<em class="icon ni ni-edit"></em>
						</a>
					</div>';
			// }
			
			

			$data[] = $row;
		}
		$output = array('data' => $data);
		echo json_encode($output);
	}

	public function getDivHeadName($division){
		$sql = "Select divhead_name from v_hris_employee_updated where division = '$division' and divhead_name != '' group by divhead_name";
		if(!empty($this->db->query($sql)->row_array()['divhead_name'])){
			$datas = decrypt($this->db->query($sql)->row_array()['divhead_name']);
		}else{
			$datas = "";
		}

		return $datas;
	}

	public function adjustmentPaC($division)
	{
		$division = decode_url($division);
		// dumper($division);
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';

		$div = str_replace("%20"," ",$division);


		$division_status = $this->db->get_where('performance_division_status', array('division_name' => encrypt($div), 'evaluation_period' => $eval_year))->row_array();
		$data['division_status'] = 0;
		if(!empty($division_status)){
			$data['division_status'] = $division_status['is_status'];	
		}

		if (($this->session->userdata('access_employee') != '3' && $this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}

		$division = encrypt(str_replace("%20", " ",$division));

		$data['division'] = $division;
		
		if($this->input->post('periodYear') == ""){
			$year = $this->year - 1;
		}else{
			$year = $this->input->post('periodYear');
		}

		$eval_year = $year.'-01-01';
		
		$division_status = $this->db->get_where('performance_division_status', array('division_name' => $division, 'evaluation_period' => $eval_year))->row_array();
		$data['is_status_division'] = 0;
		if(!empty($division_status)){
			$data['is_status_division'] = $division_status['is_status'];	
		}
		
		//===================================Reset dummy score=========================//
		$queryUpdate = "update performance_appraisal set final_score_dummy = null where division = '{$division}' and evaluation_period_start = '{$eval_year}'";
		// echo $queryUpdate;
		// die;
		$this->db->query($queryUpdate);
		//============================================================================//
		
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		
		$content = 'dashboard/adjustment_pa_c';

		$data['total_team'] = $this->inbox_model->countTeamAdjustmentPA($division);
		
		$data['total_team_eligible'] = $this->inbox_model->countTeamEligible($division);
		// $data['total_talent_map'] = $this->inbox_model->countTalentTeam($division);
		

		$data['total_inprogress'] = $this->inbox_model->countRequest($division, '1', $eval_year);
		$data['total_approved'] = $this->inbox_model->countRequest($division, '3', $eval_year);
		$data['total_revise'] = $this->inbox_model->countRequest($division, '2', $eval_year);
		$data['total_a'] = $this->inbox_model->getTotalGrade($division, 'a', $eval_year);
		$data['total_b'] = $this->inbox_model->getTotalGrade($division, 'b', $eval_year);
		$data['total_c'] = $this->inbox_model->getTotalGrade($division, 'c', $eval_year);
		$data['total_d'] = $this->inbox_model->getTotalGrade($division, 'd', $eval_year);
		$data['total_e'] = $this->inbox_model->getTotalGrade($division, 'e', $eval_year);
		
		
		$data['content'] = $content;

		// $data['low_contributor'] = $this->inbox_model->get_nine_box($division,$eval_year,"Low Contributor");
		// $data['average_performer'] = $this->inbox_model->get_nine_box($division,$eval_year,"Average Performer");
		// $data['solid_performer'] = $this->inbox_model->get_nine_box($division,$eval_year,"Solid Performer");
		// $data['inconsistent_player'] = $this->inbox_model->get_nine_box($division,$eval_year,"Inconsistent Player");
		// $data['core_player'] = $this->inbox_model->get_nine_box($division,$eval_year,"Core Player");
		// $data['high_performer'] = $this->inbox_model->get_nine_box($division,$eval_year,"High Performer");
		// $data['potential_performer'] = $this->inbox_model->get_nine_box($division,$eval_year,"Potential Performer");
		// $data['high_potential'] = $this->inbox_model->get_nine_box($division,$eval_year,"High Potential");
		// $data['star'] = $this->inbox_model->get_nine_box($division,$eval_year,"Star");


		//====================BASIC LINE DEVISIASI=======================//
		$checkRevise = $this->inbox_model->checkDevisiasi($division, $year);
		if($checkRevise > 0){
			$data['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi($division, 'a', $year);
			$data['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi($division, 'b', $year);
			$data['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi($division, 'c', $year);
			$data['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi($division, 'd', $year);
			$data['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi($division, 'e', $year);
			
		}else{
			$data['devisiasi_basic_line_a'] = "";
			$data['devisiasi_basic_line_b'] = "";
			$data['devisiasi_basic_line_c'] = "";
			$data['devisiasi_basic_line_d'] = "";
			$data['devisiasi_basic_line_e'] = "";
		}

		
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
		// print_r($listForm);
		// die;
        if (!empty($listForm)) {
            $data['listForm'] = $listForm;
        } else {
            $data['listForm'] = "";
        }

		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function view_kurva_c($division){
		$division = decode_url($division);
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$division = str_replace("_"," ",$division);
		$division = str_replace("@","#",$division);
		$data['total_a'] = $this->inbox_model->getTotalGrade($division, 'a', $eval_year);
		$data['total_b'] = $this->inbox_model->getTotalGrade($division, 'b', $eval_year);
		$data['total_c'] = $this->inbox_model->getTotalGrade($division, 'c', $eval_year);
		$data['total_d'] = $this->inbox_model->getTotalGrade($division, 'd', $eval_year);
		$data['total_e'] = $this->inbox_model->getTotalGrade($division, 'e', $eval_year);

		$checkRevise = $this->inbox_model->checkDevisiasi($division, $year);
		if($checkRevise > 0){
			$data['devisiasi_basic_line_a'] = $this->inbox_model->getDevisiasi($division, 'a', $year);
			$data['devisiasi_basic_line_b'] = $this->inbox_model->getDevisiasi($division, 'b', $year);
			$data['devisiasi_basic_line_c'] = $this->inbox_model->getDevisiasi($division, 'c', $year);
			$data['devisiasi_basic_line_d'] = $this->inbox_model->getDevisiasi($division, 'd', $year);
			$data['devisiasi_basic_line_e'] = $this->inbox_model->getDevisiasi($division, 'e', $year);
			
		}else{
			$data['devisiasi_basic_line_a'] = "";
			$data['devisiasi_basic_line_b'] = "";
			$data['devisiasi_basic_line_c'] = "";
			$data['devisiasi_basic_line_d'] = "";
			$data['devisiasi_basic_line_e'] = "";
		}
		$data['total_team'] = $this->inbox_model->countTeamEligible($division);
		$data['division_decrypt'] = decrypt($division);

		echo json_encode($data);
	}

	public function update_score_dummy(){
		$score_dummy = encrypt($this->input->post('score_dummy'));
		$id = $this->input->post('id');
		$query = "update performance_appraisal set final_score_dummy = '$score_dummy' where id = '$id'";
		// echo $query;
		// die;
		$this->db->query($query);

		echo 1;

	}

	public function reset_score_dummy(){
		$score_dummy = "";
		$id = $this->input->post('id');
		$query = "update performance_appraisal set final_score_dummy = '$score_dummy' where id = '$id'";
		// echo $query;
		// die;
		$this->db->query($query);

		echo 1;

	}

	public function update_dummy_score_to_real(){
		if (($this->session->userdata('access_employee') != '3') && ($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$division = $this->input->post('division');
		
		$division = str_replace("_", " ",str_replace("@","#",$division));
		
		if($this->input->post('periodYear') == ""){
			$year = $this->year - 1;
		}else{
			$year = $this->input->post('periodYear');
		}

		
		$eval_year = $year.'-01-01';
		
		//===================================Dummy score to real=========================//
		$queryUpdate = "update performance_appraisal set final_score = final_score_dummy where final_score_dummy is NOT null and division = '{$division}' and evaluation_period_start = '{$eval_year}'";
		$updateData = $this->db->query($queryUpdate);

		if($updateData){
			echo 1;
		}else{
			echo 0;
		}
		//============================================================================//
	}

	public function report_pa()
	{
		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['eligible'] = $this->dashboard_model->countEligible('1',$this->year-1);
		$data['not_eligible'] = $this->dashboard_model->countEligible('0',$this->year-1);

		$data['unsubmitted'] = $this->dashboard_model->countUnsubmitted($eval_year);

		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/report_pa';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function report_training($c_year="")
	{
		if(($c_year = "") || empty($c_year)){
			$year = $this->year - 1;
		}else{
			$year = $c_year;
		}
		
		$eval_year = $year.'-01-01';
		$data['yearpa'] = $year;
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['eligible'] = $this->dashboard_model->countEligible('1',$this->year-1);
		$data['not_eligible'] = $this->dashboard_model->countEligible('0',$this->year-1);

		$data['unsubmitted'] = $this->dashboard_model->countUnsubmitted($eval_year);

		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/report_training';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function history_pa()
	{
		$year = $this->year - 2;
		$eval_year = $year.'-01-01';
		// echo $eval_year;
		// die;
		if (($this->session->userdata('access_employee') != '11') && ($this->session->userdata('access_employee') != '99')) {
			print_r('You are not authorized to access this page');die;
		}
		$data['yearpa'] = $year;
		$data['eligible'] = $this->dashboard_model->countEligible('1',$this->year-1);
		$data['not_eligible'] = $this->dashboard_model->countEligible('0',$this->year-1);

		$data['unsubmitted'] = $this->dashboard_model->countUnsubmitted($eval_year);

		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'dashboard/history_pa';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function listAllDirectorate()
	{
		if (($this->session->userdata('access_employee') != '4') && ($this->session->userdata('access_employee') != '99')) {
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
		$data['content'] = 'dashboard/list_all_division_dir';


		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function viewDivisionAllDir()
	{

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$div = $this->db->query("select division, directorate from v_hris_employee_updated WHERE nik NOT IN ('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007')  AND division != '' group by division order by directorate ASC")->result_array();
		
		
		$division = "";
		// print_r($div);
		// die;
		$data = array();
		foreach ($div as $key) {
			// print_r($key);
			// die;
			$divhead = $this->db->query("select divhead_name from v_hris_employee_updated where division = '".$key['division']."' and divhead_name != ''")->result_array();
			
			$division_status = $this->db->get_where('performance_division_status', array('division_name' => $key['division'], 'evaluation_period' => $eval_year))->row_array();
			

			$row   = array();
			$row[] = decrypt($key['division']);
			if(!empty($divhead[0]['divhead_name'])){
				$row[] = decrypt($divhead[0]['divhead_name']);;
			}else{
				$row[] = "";
			}
			$row[] = decrypt($key['directorate']);
			
			$row[] = '<div class="btn-group btn-group-sm">
					<a href = "dashboard/adjustmentPaC/'.encode_url(decrypt($key['division'])).'" class="btn btn-icon btn-trigger">
						<em class="icon ni ni-edit"></em>
					</a>
				</div>';
			
			

			$data[] = $row;
		}
		$output = array('data' => $data);
		echo json_encode($output);
	}
	
}
