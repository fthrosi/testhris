<?php
defined('BASEPATH') or exit('No direct script access allowed');
require '/var/www/html/application/vendor/phpmailer/phpmailer/src/Exception.php';
require '/var/www/html/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/var/www/html/application/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception ;

// Spreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// chart
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;

class Report extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('enc');
		$this->enc->check_session();

		$this->email = $this->session->userdata('user_email');
		$this->emp_id = $this->session->userdata('employee_id');
		
		$this->load->helper('general');
		$this->load->model('form/form_model');
		$this->load->model('inbox/inbox_model');
		$this->load->model('home/home_model');
		$this->load->model('report/report_model');
		$this->load->model('master/master_model');
		$this->load->model('m_global');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');

		$this->status_apps = $_ENV['CI_ENVIRONMENT'];

		if(empty($this->session->userdata('nik'))){
            $this->session->set_flashdata('failure', 'Login failed');
            redirect('login');
        }
	}

	public function medical_claim_and_balance(){

		$data['fi_year'] = $year_request;
		$data['query'] = $param;
		$data['content_query'] = $query_result;
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
		$data['content'] = 'report/medical_claim_and_balance';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
		
	}

	public function attendance_summary_and_detail(){

		$data['fi_year'] = $year_request;
		$data['query'] = $param;
		$data['content_query'] = $query_result;
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
		$data['content'] = 'report/attendance_summary_and_detail';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
		
	}

	public function medical_control_sheets(){
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url_components = parse_url($url); 
		
		if(!empty($url_components['query'])){
			parse_str($url_components['query'], $params);
			$param = $url_components['query'];
			$nik 	= $params['nik'];
			$no_ref = $params['no_req_group'];
			if (isset($params['tahun'])) {
				$tahun = $params['tahun'];
			} else {
				$tahun = '';
			}
			

			//$listApproved = $this->report_model->getMedicalFullApproved_fix($nik, $no_ref);
			$listApproved = $this->report_model->get_data_fi_awal($nik, $no_ref, $tahun);
			
			if(empty($listApproved)){
				// dumper('nono');

			}else{

				// if((!empty($nik)) && (!empty($no_ref))){
				if (!empty($nik)) {
					$listApp = array();
					foreach ($listApproved as $key => $value) {
						$listApp[$key]['nik']=$value['employee_id'];
						$listApp[$key]['no_req_mdcr']=$value['no_req_mdcr'];
					}
					foreach($listApp as $k=>$v) {
	
					if( ($kt=array_search($v,$listApp))!==false and $k!=$kt )
						{ unset($listApp[$kt]);}
					
					}
					$data['listApp'] = $listApp;

				}else{
					// dumper('bambara');

					redirect('report/medical_control_sheets');
				}			
				// }else if((!empty($nik)) && (empty($no_ref))){
	
				// 	$listApp = array();
				// 	foreach ($listApproved as $key => $value) {
				// 		$listApp[$key]['nik']=$value['employee_id'];
				// 		$listApp[$key]['no_req_mdcr']=$value['no_req_mdcr'];
				// 	}
				// 	foreach($listApp as $k=>$v) {
	
				// 		if( ($kt=array_search($v,$listApp))!==false and $k!=$kt )
				// 			{ unset($listApp[$kt]);}
						
				// 		}
				// 	$data['listApp'] = $listApp;
					
				// }else if((empty($nik)) && (!empty($no_ref))){
				// 	$listApp = array();
				// 	foreach ($listApproved as $key => $value) {
				// 		$listApp[$key]['nik']=$value['employee_id'];
				// 		$listApp[$key]['no_req_mdcr']=$value['no_req_mdcr'];
				// 	}
				// 	foreach($listApp as $k=>$v) {
	
				// 		if( ($kt=array_search($v,$listApp))!==false and $k!=$kt )
				// 			{ unset($listApp[$kt]);}
						
				// 		}
				// 	$data['listApp'] = $listApp;
				// }
	
				$employeeArray = array();
				foreach ($listApproved as $key) {
					$employeeArray[] = $key['employee_id'];
				}
				$employeeArray = array_unique($employeeArray);
				$data['employee'] = $employeeArray;

			}
			
		}else{
			$param = '';
			$nik	= '';
			$no_ref = '';
			$tahun = '';
			$data['employee'] = '00000000';
		}


		$sql 	= "SELECT * FROM hris_no_req_mdcr WHERE is_status_progress >= 2";
		$query 	= $this->db->query($sql);
		$res = (!empty(($query->result()))) ? $query->result() : '';
		// $res 	= $query->result();
		if(empty($res) && ($tahun == '' || $tahun == null)){
			$year_request	= '0000';
			$query_result = 'empty';
		}else if ($tahun != '' || $tahun != null){
			$query_result = 'not empty';
			$year_request	=	$tahun;
		} else{
			$query_result = 'not empty';
			$year_request	=	strtotime($res[0]->created_at);
			$year_request	=	date("Y",$year_request);
		}

		// dumper($res);

		$data['fi_year'] = $year_request;
		$data['query'] = $param;
		$data['content_query'] = $query_result;
		$data['header'] = $this->home_model->getMyRequest();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['formType'] = $this->form_model->getFormType();
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());

		$data['content'] = 'report/medical_control_sheets';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function medical_monthly_report(){
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url_components = parse_url($url); 
		// dumper($url_components['query']);
		if(!empty($url_components['query'])){
			parse_str($url_components['query'], $params);
			$param = $url_components['query'];
			$bulan 	= $params['bulan'];
			// dumper('test');			
			//$listApproved = $this->report_model->getMedicalFullApproved_fix($nik, $no_ref);
			// $listApproved = $this->report_model->get_data_fi_awal($nik, $no_ref, $tahun);
			// dumper($listApproved);
			$start_date = $bulan.'-01';
			$end_date = date("Y-m-t", strtotime($bulan));

			// redirect('report/medical_monthly_report');
			
		}else{
			$start_date = date("Y-m-d");
			$end_date = date("Y-m-t", strtotime($start_date));
			$param = '';
			$bulan	= '';
		}



		// dumper($start_date);

		$sql 	= "SELECT a.employee_id, b.grandparent, c.parent, d.child, a.diagnosa, a.keterangan, a.penggantian
							FROM hris_medical_reimbursment_item a
							LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
							LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
							LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child =  d.id
							LEFT JOIN form_request e ON a.request_id = e.id
							WHERE (a.tanggal_kuitansi BETWEEN '$start_date' AND '$end_date') AND e.no_req_mdcr IS NOT null
							ORDER BY a.create_date ASC;";
		$query 	= $this->db->query($sql);
		$res 	= $query->result();
		// dumper($res);
		if(empty($res)){
			$query_result = 'empty';
		}else {
			$query_result = 'not empty';
		}

		$data['query'] = $param;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['content_query'] = $query_result;
		$data['header'] = $this->home_model->getMyRequest();
		$data['report_monthly'] = $res;
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['formType'] = $this->form_model->getFormType();
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());

		// dumper($data['start_date']);

		$data['content'] = 'report/medical_monthly_report';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read($table){
		switch ($table) {
			case 'medical_control_sheets':
				$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$url_components = parse_url($url); 
				//dumper($url_components);
				if(!empty($url_components['query'])){
					parse_str($url_components['query'], $params);
					$nik 	= $params['nik'];
					$no_ref = $params['no_req_group'];
				}else{
					$nik	= '';
					$no_ref = '';
				}
				
				//dumper($nik);
				$listFA = $this->report_model->getMedicalFullApproved($nik, $no_ref);
				// dumper($listFA);
		        if (!empty($listFA)) {
		            foreach ($listFA as $key) {

		                $row   = array();
						$row[] = $key->employee_id;
		                $row[] = decrypt($key->complete_name);
		                $row[] = $key->request_number;
		                $row[] = $key->no_req_mdcr;
		                $row[] = '';
		                $data[] = $row;
		            }
		            $outputFA = array('data' => $data);
		        } else {
		            $outputFA = array('data' => new ArrayObject());
		        }
		        echo json_encode($outputFA);
				break;
			
			case 'family_employee':
				$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$url_components = parse_url($url); 
				//dumper($url_components);
				if(!empty($url_components['query'])){
					parse_str($url_components['query'], $params);
					$nik 	= $params['nik'];
					$no_ref = $params['no_req_group'];
				}else{
					$nik	= '';
					$no_ref = '';
				}
				
				//dumper($nik);
				$listF = $this->report_model->getFamilyEmployee($nik, $no_ref);
		        if (!empty($listF)) {
		            foreach ($listF as $key) {

						$member_birthdate = decrypt($key->member_birthdate);
						//dumper(encrypt('01062020'));
						$member_birthdate = DateTime::createFromFormat('Ymd', $member_birthdate);
						$member_birthdate = $member_birthdate->format('d.m.Y');

						$member_names = str_replace("||","'", decrypt($key->member_names));
						
						if($key->status_act == "Y"){
							$checked = "checked";
						}else if($key->status_act == "N"){
							$checked = "";
						}else{
							$checked = "";
						}

		                $row   = array();
						$row[] = $key->nik;
		                $row[] = decrypt($key->family_members);
		                $row[] = decrypt($key->seqno);
						$row[] = $member_names;
						$row[] = $member_birthdate;
						$f_member	= encrypt('Spouse');
						if($key->family_members == $f_member){
							$row[] = '';
						}else{
							$row[] = '<div class="custom-control custom-switch act_child"><input type="checkbox" '.$checked.' class="custom-control-input" id="'.$key->id_family.'" data="'.$key->id_family.'" onClick="act_child('.$key->id_family.')"><label class="custom-control-label" for="'.$key->id_family.'">Active</label></div>';
						}
		                $data[] = $row;
		            }
		            $outputF = array('data' => $data);
		        } else {
		            $outputF = array('data' => new ArrayObject());
		        }
		        echo json_encode($outputF);
				break;
			
			case 'medical_monthly_report':
				$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$url_components = parse_url($url); 
				//dumper($url_components);
				if(!empty($url_components['query'])){
					parse_str($url_components['query'], $params);
					$nik 	= $params['nik'];
					$no_ref = $params['no_req_group'];
				}else{
					$nik	= '';
					$no_ref = '';
				}
				
				//dumper($nik);
				$listFA = $this->report_model->getMedicalFullApproved($nik, $no_ref);
				//dumper($listFA);
		        if (!empty($listFA)) {
		            foreach ($listFA as $key) {

		                $row   = array();
						$row[] = $key->employee_id;
		                $row[] = decrypt($key->complete_name);
		                $row[] = $key->request_number;
		                $row[] = $key->no_req_mdcr;
		                $row[] = '';
		                $data[] = $row;
		            }
		            $outputFA = array('data' => $data);
		        } else {
		            $outputFA = array('data' => new ArrayObject());
		        }
		        echo json_encode($outputFA);
				break;
			
			default:
				# code...
				break;
		}
	}

	public function get_data_fi(){
		$data = $this->report_model->get_data_fi();
		dumper($data);
	}


	//////////////////////////////////////////START TIME MANAGEMENT 2024 //////////////////////////////////////////

	public function attendance(){
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval_ec'] = count($this->inbox_model->get_my_ec_approver());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_tm_cek'] = count($this->inbox_model->getApprovalListTMCek_ztm());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['is_head'] = $this->report_model->getHead_ztm($this->session->userdata('user_email'), 0); // TIME MANAGEMENT 2.0
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'report/attendance';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function attendance_table($company_code='', $search='', $filter=''){

		$InOffice = 0;
		$OutOffice = 0;
		$ActiveDays = 0;

		if ($company_code == 0 || $company_code == 1){
			$listAtd = $this->report_model->getAttendanceHead_ztm($this->session->userdata('nik'), $company_code, $search);
		} else {
			$listAtd = $this->report_model->getAttendance_ztm($this->session->userdata('nik'), $company_code, $search, $filter);
		}
		
		if (!empty($listAtd)) {
			foreach ($listAtd as $key) {
				$row   = array();
				if ($this->session->userdata('access_level') == '7' || $this->session->userdata('access_employee') == '12'){
					$row[] = '<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditAttendance" data-offset="-4,0" id="'.$key->id.'" onClick="edit_employee_attend('.$key->id.')">
								<em class="icon ni ni-edit"></em>
								</a>';
				} else {
					$row[] = ' ';
				}
				$row[] = $key->employee_id;
				$row[] = ucwords(strtolower($key->full_name));

				$relocate = $this->report_model->getRelocation_ztm($key->employee_id, $key->date);
				if (!empty($relocate)){
					$personnel_area = $relocate->pa_akhir;
					if ($personnel_area == 'IBSW - JAKARTA'){
						if (decrypt($key->personnel_subarea) == 'Non HO'){
							$personnel_subarea = 'Head Office';
						} else if (decrypt($key->personnel_subarea) == 'Head Office' || decrypt($key->personnel_subarea) != 'Non HO'){
							$personnel_subarea = decrypt($key->personnel_subarea);
						} 
					} else {
						if (decrypt($key->personnel_subarea) == 'Head Office'){
							$personnel_subarea = 'Non HO';
						} else if (decrypt($key->personnel_subarea) == 'Non HO' || decrypt($key->personnel_subarea) != 'Head Office'){
							$personnel_subarea = decrypt($key->personnel_subarea);
						} 
					}
				} else {
					$personnel_area = decrypt($key->personnel_area);
					$personnel_subarea = decrypt($key->personnel_subarea);
				}
				$row[] = $personnel_area;
				$row[] = $personnel_subarea;

				$date = $key->date;
				$date = DateTime::createFromFormat('Y-m-d', $date)->format('Y.m.d');
				$row[] = $date;

				$row[] = $key->dws;
				$row[] = $key->schedule_in;
				$row[] = $key->schedule_out;
				$row[] = $key->check_in;
				$row[] = $key->check_out;
				$row[] = $key->working_hours_t;
				$row[] = $key->attendence_code;
				$row[] = $key->time_off_code;
				$row[] = $key->note;

				$checkOffice1 = '';
				if ($key->lat_in == null || $key->lat_in == 0){
					$row[] = '';
				} else {
					$checkOffice1 = $this->report_model->getOfficeRadius_ztm($personnel_area, $key->lat_in, $key->long_in, $key->date);
					// if($key->date == '2024-10-18'){
					// 	dumper($checkOffice1);
					// }
					$row[] = $checkOffice1;
					if ($checkOffice1 == 'Non Office Area'){
						if ($this->session->userdata('nik') == $key->employee_id){
							$checkLocReq = $this->report_model->getLocationReq_ztm($key->employee_id, $key->date);
							if ($checkLocReq == 'not-exist'){
								$row[0] = '<a class="text-primary btn btn-icon btn-trigger text-dark" data-toggle="modal" data-target="#modalRequestLocation" data-offset="-4,0" id="'.$key->id.'" onClick="req_emp_loc('.$key->id.', 1)">
								<em class="icon ni ni-location"></em>
								</a>'; //CR 3 TM
							} else {
								$row[0] = '<a class="text-primary btn btn-icon btn-trigger text-dark" href="form/overview/TM">
								<em class="icon ni ni-clipboad-check"></em>
								</a>'; //CR 3 TM
							}
						}
						// if (substr($key->schedule_code, 0, 1) == 'N'){
							$InOffice += 1;
						// }
					}
				}

				$row[] = $key->check_in_location;
				
				if (!empty($key->lat_in)){
					$row[] = $key->lat_in . ', ' . $key->long_in;
					$row[] = DECtoDMS($key->lat_in, 'lat') . ', ' . DECtoDMS($key->long_in, 'long');
				} else {
					$row[] = '';
					$row[] = '';
				}

				if ($key->lat_out == null || $key->lat_out == 0){
					$row[] = '';
				} else {
					$checkOffice2 = $this->report_model->getOfficeRadius_ztm($personnel_area, $key->lat_out, $key->long_out,$key->date);
					$row[] = $checkOffice2;
					if ($checkOffice2 == 'Non Office Area'){
						if ($this->session->userdata('nik') == $key->employee_id){
							$checkLocReq = $this->report_model->getLocationReq_ztm($key->employee_id, $key->date);
							if ($checkLocReq == 'not-exist'){
								if ($checkOffice1 == 'Non Office Area'){
									$flag = 2;
								} else {
									$flag = 0;
								}
								$row[0] = '<a class="text-primary btn btn-icon btn-trigger text-dark" data-toggle="modal" data-target="#modalRequestLocation" data-offset="-4,0" id="'.$key->id.'" onClick="req_emp_loc('.$key->id.', '.$flag.')">
										<em class="icon ni ni-location"></em>
										</a>'; //CR 3 TM
							}  else {
								$row[0] = '<a class="text-primary btn btn-icon btn-trigger text-dark" href="form/overview/TM">
								<em class="icon ni ni-clipboad-check"></em>
								</a>'; //CR 3 TM
							}
						}
						// if (substr($key->schedule_code, 0, 1) == 'N'){
							$OutOffice += 1;
						// }
					}
				}

				$row[] = $key->check_out_location;
				if (!empty($key->lat_out)){
					$row[] = $key->lat_out . ', ' . $key->long_out;
					$row[] = DECtoDMS($key->lat_out, 'lat') . ', ' . DECtoDMS($key->long_out, 'long');
				} else {
					$row[] = '';
					$row[] = '';
				}

				// if (substr($key->schedule_code, 0, 1) == 'N'){
					$ActiveDays += 1; 
				// }
				
				$data[] = $row;
			}
			
			if (($InOffice == 0 && $ActiveDays == 0)){
				$InPercent = 0;
			} else {
				$InPercent = round(($InOffice / $ActiveDays) * 100); 
			}
			
			if (($OutOffice == 0 && $ActiveDays == 0)){
				$OutPercent = 0;
			} else {
				$OutPercent = round(($OutOffice / $ActiveDays) * 100);
			}

			$outputAtd = array('data' => $data, 'InOffice' => $InOffice, 'OutOffice' => $OutOffice, 'InPercent' => $InPercent, 'OutPercent' => $OutPercent); 
		} else {
			$outputAtd = array('data' => new ArrayObject());
		}
		echo json_encode($outputAtd);
	}
	
	public function attendanceAnalysis($company_code, $search=''){ 
		$filter = $_POST['filter'];
		
		if ($company_code == 0 || $company_code == 1){
			$data 	= $this->report_model->attendanceAnalysisHead_ztm($company_code, $search);
		} else {	
			$data 	= $this->report_model->attendanceAnalysis_ztm($company_code, $search, $filter);
		}

		echo json_encode($data);
	}

	public function calendar(){
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
		$data['content'] = 'report/calendar';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function getCalendarEvents(){
		$data 	= $this->report_model->getCalendarEvents_ztm();

		echo json_encode($data);
	}

	public function createEmployeeCalendar(){
		$data 	= $this->report_model->createEmployeeCalendar_ztm();

		echo json_encode($data);
	}

	public function createHolidayEvent(){
		$nama			= $_POST['nama'];
		// $start_date		= $_POST['start_date'];
		// $end_date 		= $_POST['end_date'];
		$kode 			= $_POST['kode'];
		$start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date 		= date("Y-m-d", strtotime($_POST['end_date']));

		$data 	= $this->report_model->createHolidayEvent_ztm($nama, $start_date, $end_date, $kode);

		echo json_encode($data);
	}

	public function time_management_report(){
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
		$data['content'] = 'report/time_management_report';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function tm_report_table($search, $emp_nik=''){ // TIME MANAGEMENT 2.0
		$listTMR = $this->report_model->getTMReport_ztm($search, $emp_nik); // TIME MANAGEMENT 2.0
		if (!empty($listTMR)) {
			foreach ($listTMR as $key) {
				$row   = array();
				$row[] = $key[0];
				$row[] = ucwords(strtolower($key[1]));
				$row[] = $key[2];
				$row[] = $key[3];
				$row[] = $key[4];
				$row[] = '<div class="btn-group btn-group-sm">
								<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDetailBalance" data-offset="-4,0" id="'.$key[0].'" onClick="detail_balance_log('.$key[0].', '."'$key[1]'".')">
								<em class="icon ni ni-info"></em>
								</a>
							</div>
							';
				
				$data[] = $row;
			}
			$outputTMR = array('data' => $data);
		} else {
			$outputTMR = array('data' => new ArrayObject());
		}
		echo json_encode($outputTMR);
	}

	public function getCompany(){
		$data 	= $this->report_model->getCompany_ztm();
		
		echo json_encode($data);
	}

	public function getWorkSchedule($nik){
		$company = $this->report_model->getCompany_ztm($nik);
		$company_code = $company[0]['company_code'];
		
		$data 	= $this->report_model->getWorkSchedule_ztm($company_code);
		
		echo json_encode($data);
	}

	public function getWorkSchedule2($company_code){
		$data 	= $this->report_model->getWorkSchedule_ztm($company_code);

		echo json_encode($data);
	}

	public function assignWorkSchedule(){
		$emp_name		= $_POST['emp_name'];
		$work_schedule	= $_POST['work_schedule'];
		$ws_name		= $_POST['ws_name'];
		// $start_date		= $_POST['start_date'];
		// $end_date 		= $_POST['end_date'];
		$start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date 		= date("Y-m-d", strtotime($_POST['end_date']));
		$data 	= $this->report_model->assignWorkSchedule_ztm($emp_name, $work_schedule, $ws_name, $start_date, $end_date);

		echo json_encode($data);
	}

	public function assignWorkScheduleMulti(){
		$branch				= $_POST['branch'];
		$current_schedule	= $_POST['current_schedule'];
		$new_schedule		= $_POST['new_schedule'];
		// $start_date			= $_POST['start_date'];
		// $end_date 			= $_POST['end_date'];
		$start_date 		= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date 			= date("Y-m-d", strtotime($_POST['end_date']));

		$data 	= $this->report_model->assignWorkScheduleMulti_ztm($branch, $current_schedule, $new_schedule, $start_date, $end_date);

		echo json_encode($data);
	}

	public function save_upload_pattern(){
		$config = [
			'upload_path' => './assets/documents/documents_tm/',
			'allowed_types' => 'csv'
		];
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->upload->do_upload('upload_schedule_file');
		
		$file = $this->upload->data();
		$file_pattern = $file['file_name'];
		$file_type = strtolower(pathinfo($file_pattern,PATHINFO_EXTENSION));

		if(($_FILES['upload_schedule_file']['error'] == 0)){
			// unlink('./assets/documents/documents_hris/' . $file_pattern);
			$data = $file_pattern;

		} else if(($_FILES['upload_schedule_file']['error'] == 1) || ($_FILES['upload_schedule_file']['error'] == 2)){

			$data = 0;
		} else if (($_FILES['upload_schedule_file']['error'] == 3)){
			
			$data = 1;
		} else if (($_FILES['upload_schedule_file']['error'] == 6)){
			
			$data = 2;
		} else if (($_FILES['upload_schedule_file']['error'] == 7)){
			
			$data = 3;
		} else {

			$data = 5;
		}

		if($file_type != 'csv'){
			$data = 4;
		}

		echo json_encode($data);
	}

	public function assignShiftPattern(){
		$file_name = $_POST['file_name'];

		$data 	= $this->report_model->assignShiftPattern_ztm($file_name);

		echo json_encode($data);
	}

	// TIME MANAGEMENT 2.0
	public function getBelowHead(){
		$data 	= $this->report_model->getHead_ztm($this->session->userdata('user_email'), 1);

		$x = 0;
		while($x < count($data)) {
			$data[$x]->complete_name = ucwords(strtolower(decrypt($data[$x]->complete_name)));
			$data[$x]->email = decrypt($data[$x]->email);
			$x++;
		}

		echo json_encode($data);
	}

	public function getEmployee(){
		$data = $this->report_model->getEmployee_ztm();
		$x = 0;
		while($x < count($data)) {
			$data[$x]->complete_name = ucwords(strtolower(decrypt($data[$x]->complete_name)));
			$x++;
		}

		echo json_encode($data);
	}

	public function tm_report_head(){
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
		$data['content'] = 'report/tm_report_head';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function tm_report_table_head($dept = '', $emp = ''){
		if ($dept != '' || $emp != ''){
			$listTMR = $this->report_model->getHeadSearch_ztm(encrypt($this->email), json_decode(rawurldecode($dept)), json_decode(rawurldecode($emp))); 
		} else {
			$listTMR = $this->report_model->getHead_ztm($this->email, 2); 
		}
		
		if (!empty($listTMR)) {
			foreach ($listTMR as $key) {
				$row   = array();
				$row[] = $key[0];
				$row[] = ucwords(strtolower($key[1]));
				$row[] = $key[2];
				$row[] = $key[3];
				$row[] = $key[4];
				$row[] = '<div class="btn-group btn-group-sm">
							<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDetailBalance" data-offset="-4,0" id="'.$key[0].'" onClick="detail_balance_log('.$key[0].', '."'$key[1]'".')">
							<em class="icon ni ni-info"></em>
							</a>
						  </div>
						  ';
				
				$data[] = $row;
			}
			$outputTMR = array('data' => $data);
		} else {
			$outputTMR = array('data' => new ArrayObject());
		}
		echo json_encode($outputTMR);
	}

	public function getEditEmpAtd(){
		$id = $_POST['id'];
		$data = $this->report_model->getEditEmpAtd_ztm($id);
		echo json_encode($data);
	}

	public function ubah_emp_atd(){
		$id 				= $_POST['id'];
		$check_in			= $_POST['check_in'];
		$check_out			= $_POST['check_out'];
		$check_in_id		= $_POST['check_in_location'];
		$check_out_id		= $_POST['check_out_location'];
		$attendance_code 	= $_POST['attendance_code'];
		$time_off_code 		= $_POST['time_off_code'];
		$notes				= $_POST['notes'];
		$working_hours_t		= $_POST['working_hour_emp_atd_t'];
		$working_hours_d		= $_POST['working_hour_emp_atd_d'];
		$data = $this->report_model->updateEmpAtd($id, $check_in, $check_out, $check_in_id, $check_out_id, $attendance_code, $time_off_code, $notes, $working_hours_d, $working_hours_t);
		echo json_encode($data);

	}

	public function getTO($nik){
		$data = $this->report_model->getTO_ztm($nik);
		echo json_encode($data);
	}

	public function getLocation($nik, $date){
		$data = $this->report_model->getLocation_ztm($nik, $date);
		echo json_encode($data);
	}

	public function getEmpDept(){
		$data = $this->report_model->getHead_ztm($this->session->userdata('user_email'), 3);

		$x = 0;
		while($x < count($data)) {
			$data[$x]->complete_name = ucwords(strtolower(decrypt($data[$x]->complete_name)));
			$data[$x]->department = decrypt($data[$x]->department);
			$x++;
		}

		echo json_encode($data);
	}

	public function getDepartment(){
		$no = 0;
		$data = $this->report_model->getDepartment_ztm();
		foreach ($data as $key){
			$data[$no] = decrypt($key['department']);
			$no++;
		}
		sort($data);
		echo json_encode($data);
	}
	public function getDivision(){
		$no = 0;
		$data = $this->report_model->getDivision_ztm();
		foreach ($data as $key){
			$data[$no] = decrypt($key['division']);
			$no++;
		}
		sort($data);
		echo json_encode($data);
	}
	public function getDirectorate(){
		$no = 0;
		$data = $this->report_model->getDirectorate_ztm();
		foreach ($data as $key){
			$data[$no] = decrypt($key['directorate']);
			$no++;
		}
		sort($data);
		echo json_encode($data);
	}

	////////////////////////////////END TIME MANAGEMENT 2024////////////////////////////////////


	public function payslip(){
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
		$data['content'] = 'report/payslip';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	///////////////////////////////Penambahan Logs Activity 2025///////////////////////////
	public function time_management_logs(){
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
		$data['content'] = 'report/time_management_logs';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}
	
	public function logs_report_table(){ 
		$listLogs = $this->report_model->getLogs();
		if (!empty($listLogs)) {
			foreach ($listLogs as $key) {
				$row   = array();
				$row[] = $key['form_type'];
				$row[] = $key['request_id'];
				$row[] = $key['request_number'];
				$row[] = $key['activity'];
				$row[] = $key['description'];
				$row[] = $key['created_by'];
				$row[] = $key['created_at'];
				
				$data[] = $row;
			}
			$outputLOGS = array('data' => $data);
		} else {
			$outputLOGS = array('data' => new ArrayObject());
		}
		echo json_encode($outputLOGS);
	}

	///////////////////////////////Start Development 2026///////////////////////////

	public function medical_reports_ap(){
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

		$data['content'] = 'report/medical_report_ap';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);

		// echo json_encode($data);
	}

	public function get_doc_mdcr_ap()
	{
		// Ambil parameter dari DataTables
		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];

		// Ambil total data tanpa filter
		$totalData = $this->inbox_model->countAllMDCRFI();

		// Ambil data sesuai paging dan search
		$dataList = $this->inbox_model->getApprovalListMDCRAfterGroupingServer($start, $length, $search);

		$data = [];
		foreach ($dataList as $value) {
			$no_req    = $value['no_req_mdcr'];
			$no_req_id = str_replace("HRIS_MDCR", "", $no_req);

			$row = [];
			$row[] = $no_req;
			$row[] = status_mdcr_color($value['is_status_progress']);

			// $row[] = '
			// 		<a class="btn btn-outline-warning" data-toggle="modal" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="viewResumeNoReqToFI(this)" ><em class="icon ni ni-list"></em></a>
			// 		<a data-toggle="modal" data-offset="-4,0" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="print_out_req_mdcr_all_per_day(this)" class="btn btn-outline-primary" title="Recap Medical Reimbursement"><em class="icon ni ni-printer"></em></a>
			// 		<a type="button" class="btn btn-outline-warning" data-toggle="modal" onClick="btn_modal_ap(this)" data-target="#modalDefault" data-id="'.$no_req.'"><em class="icon ni ni-list"></em></a>
			// 		';

			$row[] = '
					<a type="button" class="btn btn-outline-warning" data-toggle="modal" onClick="btn_modal_ap(this)" data-target="#modalDefault" data-id="'.$no_req.'"><em class="icon ni ni-list"></em></a>
					<a data-toggle="modal" data-offset="-4,0" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="print_out_req_mdcr_all_per_day_ap(this)" class="btn btn-outline-primary" title="Recap Medical Reimbursement"><em class="icon ni ni-printer"></em></a>
					<a data-toggle="modal" data-offset="-4,0" id="'.$no_req.'" data-no_req="'.$no_req.'" onClick="export_excel_req_mdcr_all_per_day_ap(this)" class="btn btn-outline-primary" title="Recap Medical Reimbursement"><em class="icon ni ni-file-xls"></em></a>
					';

			$row['DT_RowClass'] = 'SearchMDCR';

			$data[] = $row;
		}

		// Hitung total setelah filter
		$filtered = $this->inbox_model->countFilteredMDCRFI($search);

		$output = [
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $filtered,
			"data" => $data
		];

		echo json_encode($output);
	}

	public function mod_resume_no_req_ap($no_req)
	{
		$no_req = $this->uri->segment(3);
		$data['header_mdcr_after_grouping_per_item'] = $this->inbox_model->getApprovalListMDCRAGroupingItem($no_req);
		$data['content'] = 'inbox/mod/mod_resume_no_req_to_fi';
		// $this->templates->show('index', 'templates/eapp/eapp_main_pop_up', $data);
		// $this->load->view('inbox/mod/mod_resume_no_req_to_fi', $data);

		// dumper($data);

		$data['preview'] = $this->load->view('report/detail_grouping_mdcr', $data, TRUE);

		echo json_encode($data);
	}

	public function sendEmail($type, $requestId, $email_to, $employee_id = "")
	{
		
		$data['form_request'] = $this->m_global->find('form_request', 'id', $requestId)->row_array();
		$data['data_employee'] = $this->form_model->get_data_employee($data['form_request']['employee_id']);
		// dumper($data);
		$data['get_data_claim'] = $this->form_model->get_data_claim_per_request($requestId);
		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $requestId)->result_array();

		$data['email'] = decrypt($data['data_employee'][0]->email);
		$email_to 	   = decrypt($data['data_employee'][0]->email);
		$data['complete_name'] = decrypt($data['data_employee'][0]->complete_name);
		$html = $this->load->view('services/email/re_request_full_paid', $data, TRUE);
		$email_subject = 'IBSW-Medical Claim PAID';

		// dumper($data);

		$mail = new PHPMailer();
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->isSMTP();
		$mail->Host       = 'mail.ibsmulti.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
		// $mail->Password   = '2025@54321No.Reply'; // ubah dengan password email Anda
		$mail->Password   = '1214#$C1k1n1.2026';
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;

		$mail->setFrom('no.reply@ibsmulti.com', 'Notification System'); // ubah dengan alamat email Anda

		// dumper($data);

		// $link_host = "$_SERVER[HTTP_HOST]";
		// if($link_host != "172.19.8.84" && $link_host != "hris.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com")){
		// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
		// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
		// 	// $mail->addCC('gilang.cahyo@ibsmulti.com');
		// 	// $mail->addCC('abimas.dewangga@ibsmulti.com');
		// }else{
		// 	$mail->addAddress($email_to);
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
			$mail->addAddress($email_to);
			$mail->addBCC('luffi.utomo@ibsmulti.com');
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
		}
		

		// Isi Email
		$mail->isHTML(true);
		$mail->Subject = $email_subject;
		$mail->Body    = $html;

		$mail->send();
	}

	public function re_send_email()
	{
		// dumper(encrypt("TREASURE@IBSMULTI.COM"));
		$request_number	= $this->uri->segment(3);
		$nik = $this->uri->segment(4);
		
		$res_email = $this->db
		->select('user_email')
		->where('employee_id', $nik)
		->order_by('id_user', 'ASC')
		->limit(1)
		->get('users')
		->row();

		$res_number = $this->db
		->select('id')
		->where('request_number', $request_number)
		->limit(1)
		->get('form_request')
		->row();

		// dumper($res_number);
		
		$email  = $res_email->user_email;
		$request_id = $res_number->id;

		// dumper($request_id);

		$this->sendEmail('request_approve_mdcr',$request_id, $email, $nik);

		echo json_encode('success');
	}


	
	/////////////Start Report Summary and Details TM 2026///////////////////

	public function get_summary_tm(){
		$nik   		= $this->input->post('nik');
		$month   	= $this->input->post('month');
        $year  		= $this->input->post('year');

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order  = $this->input->post('order');
		$column = $this->input->post('columns');

		$result = $this->report_model->get_summary_tm($year, $start, $length, $search, $order, $column, $nik, $month);
		// dumper($result);
		
		$data = [];
		foreach ($result['data'] as $value) {
			$row = [];
			

				$row[] = $value['nik'];
				$row[] = $value['complete_name'];
				$row[] = $value['position'];
				$row[] = $value['department'];
				$row[] = $value['division'];
				$row[] = $value['jam_kerja_sch'];
				$row[] = $value['jam_kerja_act'];
				$row[] = $value['time_off'];
				$row[] = $value['attendance_percentage'];
				$row[] = $value['telat'];
				$row[] = $value['pulang_cepat'];
				// $row[] = $value['action'];
				// $row[] = get_month($value['month']);
				// $row[] = $value['year'];

			$data[] = $row;
			// $row['DT_RowClass'] = 'SearchMDCR';
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);
	}
	
	public function get_detail_tm(){
		$nik   		= $this->input->post('nik');
		$month   	= $this->input->post('month');
        $year  		= $this->input->post('year');

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order  = $this->input->post('order');
		$column = $this->input->post('columns');

		$result = $this->report_model->get_detail_tm($year, $start, $length, $search, $order, $column, $nik, $month);
		
		$data = [];
		foreach ($result['data'] as $value) {
			$row = [];
			
				$row[] = $value['nik'];
				$row[] = $value['complete_name'];
				$row[] = $value['personnel_area'];
				$row[] = $value['personnel_subarea'];
				$row[] = $value['date'];
				$row[] = $value['schedule'];
				$row[] = $value['schedule_in'];
				$row[] = $value['schedule_out'];
				$row[] = $value['check_in'];
				$row[] = $value['check_out'];
				$row[] = $value['attendance_code'];
				$row[] = $value['time_off_code'];
				$row[] = $value['schedule_working_hours'];
				$row[] = $value['actual_working_hours'];
				$row[] = $value['late_in'];
				$row[] = $value['early_check_out'];
				$row[] = $value['office_in'];
				$row[] = $value['check_in_location'];
				$row[] = $value['coordinates_in'];
				$row[] = $value['dms_in'];
				$row[] = $value['office_out'];
				$row[] = $value['check_out_location'];
				$row[] = $value['coordinates_out'];
				$row[] = $value['dms_out'];
				// $row[] = $value['action'];
				// $row[] = get_month($value['month']);
				// $row[] = $value['year'];

			$data[] = $row;
			// $row['DT_RowClass'] = 'SearchMDCR';
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);
	}

	public function export_report_attendance_summary_tm_excel()
	{

		$this->output->enable_profiler(FALSE);
		if (ob_get_level()) ob_end_clean();

		$nik   = $this->input->get('nik');
		$year  = $this->input->get('year');
		$month = $this->input->get('month');

		$result = $this->report_model->get_summary_tm($year,0,1000000,null,null,null,$nik,$month);
		$data   = isset($result['data']) ? $result['data'] : [];

		// =========================
		// IF DEPARTMENT IS NULL OR EMPTY, THEN EXCLUDE FROM DATA
		// =========================		
		$data = array_values(array_filter($data, function($d) {
			return isset($d['department']) && trim($d['department']) !== '';
		}));

		$month_i = get_month($month);

		$spreadsheet = new Spreadsheet();

		// =========================
		// GROUP BY DEPARTMENT
		// =========================
		$departments = [];

		foreach ($data as $d) {
			$departments[$d['department']][] = $d;
		}

		// =========================
		// FUNCTION CREATE TABLE
		// =========================
		$createSheet = function($sheet, $title, $subtitle, $rows) {

			$headers = [
				'Employee ID','Complete Name','Position','Department','Division',
				'Schedule Working Hours','Actual Working Hours','Time Off',
				'Attendance %','Late In','Early Check Out'
			];

			// Title
			$sheet->setCellValue('A1', $title);
			$sheet->setCellValue('A2', $subtitle);
			$sheet->mergeCells('A1:K1');
			$sheet->mergeCells('A2:K2');

			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Header
			$col = 'A';
			foreach ($headers as $h) {
				$sheet->setCellValue($col.'4', $h);
				$col++;
			}

			$sheet->getStyle('A4:K4')->applyFromArray([
				'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => '2F75B5']
				],
				'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
			]);

			// Data + Zebra
			$rowNum = 5;
			foreach ($rows as $i => $d) {

				$sheet->setCellValue('A'.$rowNum, $d['nik']);
				$sheet->setCellValue('B'.$rowNum, $d['complete_name']);
				$sheet->setCellValue('C'.$rowNum, $d['position']);
				$sheet->setCellValue('D'.$rowNum, $d['department']);
				$sheet->setCellValue('E'.$rowNum, $d['division']);
				$sheet->setCellValue('F'.$rowNum, $d['jam_kerja_sch']);
				$sheet->setCellValue('G'.$rowNum, $d['jam_kerja_act']);
				$sheet->setCellValue('H'.$rowNum, $d['time_off']);
				$sheet->setCellValue('I'.$rowNum, $d['attendance_percentage']/100);
				$sheet->setCellValue('J'.$rowNum, $d['telat']);
				$sheet->setCellValue('K'.$rowNum, $d['pulang_cepat']);

				// zebra
				if ($i % 2 == 0) {
					$sheet->getStyle("A{$rowNum}:K{$rowNum}")
						->getFill()->setFillType(Fill::FILL_SOLID)
						->getStartColor()->setRGB('F2F2F2');
				}

				$rowNum++;
			}

			$lastRow = $rowNum - 1;

			// format %
			$sheet->getStyle("I5:I{$lastRow}")
				->getNumberFormat()->setFormatCode('0.00%');

			// border
			$sheet->getStyle("A4:K{$lastRow}")->applyFromArray([
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_THIN]
				]
			]);

			// auto width
			foreach (range('A','K') as $c) {
				$sheet->getColumnDimension($c)->setAutoSize(true);
			}

			// freeze
			$sheet->freezePane('A5');
		};

		// =========================
		// SHEET 1: ALL DATA
		// =========================
		$sheetAll = $spreadsheet->getActiveSheet();
		$sheetAll->setTitle('All Data');

		$createSheet(
			$sheetAll,
			"ATTENDANCE SUMMARY TM",
			"All Employee | {$month_i} {$year}",
			$data
		);

		// =========================
		// SHEET 2: SUMMARY (INDEX 1)
		// =========================
		$pivot = $spreadsheet->createSheet(1);
		$pivot->setTitle('Summary');

		$pivot->setCellValue('A1', 'Department');
		$pivot->setCellValue('B1', 'Total Employee');
		$pivot->setCellValue('C1', 'Avg Attendance %');

		$pivot->getStyle('A1:C1')->getFont()->setBold(true);

		$row = 2;
		foreach ($departments as $dept => $rows) {

			$total = count($rows);
			$sumAttendance = array_sum(array_column($rows, 'attendance_percentage'));
			$avg = $total ? ($sumAttendance / $total)/100 : 0;

			$pivot->setCellValue("A{$row}", $dept);
			$pivot->setCellValue("B{$row}", $total);
			$pivot->setCellValue("C{$row}", $avg);

			$row++;
		}

		$last = $row - 1;

		$pivot->getStyle("C2:C{$last}")
			->getNumberFormat()->setFormatCode('0.00%');

		foreach (range('A','C') as $c) {
			$pivot->getColumnDimension($c)->setAutoSize(true);
		}

		// =========================
		// CHART
		// =========================
		$categories = [new DataSeriesValues(
			DataSeriesValues::DATASERIES_TYPE_STRING,
			"Summary!A2:A{$last}",
			null,
			($last-1)
		)];

		$values = [new DataSeriesValues(
			DataSeriesValues::DATASERIES_TYPE_NUMBER,
			"Summary!C2:C{$last}",
			null,
			($last-1)
		)];

		$series = new DataSeries(
			DataSeries::TYPE_BARCHART,
			DataSeries::GROUPING_CLUSTERED,
			range(0, count($values)-1),
			[],
			$categories,
			$values
		);

		$plotArea = new PlotArea(null, [$series]);
		$legend = new Legend(Legend::POSITION_RIGHT, null, false);
		$title = new Title('Average Attendance per Department');

		$chart = new Chart('chart1', $title, $legend, $plotArea);
		$chart->setTopLeftPosition('E2');
		$chart->setBottomRightPosition('L20');

		$pivot->addChart($chart);

		// =========================
		// SHEET PER DEPARTMENT
		// =========================
		foreach ($departments as $dept => $rows) {
			$sheet = $spreadsheet->createSheet();
			$sheet->setTitle(substr($dept, 0, 30));

			$createSheet(
				$sheet,
				"Department: {$dept}",
				"{$month_i} {$year}",
				$rows
			);
		}

		// =========================
		// SET ACTIVE SHEET
		// =========================
		$spreadsheet->setActiveSheetIndex(0);

		// =========================
		// OUTPUT
		// =========================
		$filename = "Attendance_Summary_TM_{$year}.xlsx";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		// signal selesai
		setcookie("download_done", "1", time() + 30, "/");

		$writer = new Xlsx($spreadsheet);
		$writer->setIncludeCharts(true);
		$writer->save('php://output');

		exit;
	}
	
	public function export_report_attendance_detail_tm_excel()
	{

		ini_set('memory_limit', '1024M');
		set_time_limit(0);

		$this->output->enable_profiler(FALSE);
		if (ob_get_level()) ob_end_clean();

		$nik   = $this->input->get('nik');
		$year  = $this->input->get('year');
		$month = $this->input->get('month');

		$result = $this->report_model->get_detail_tm($year,0,1000000,null,null,null,$nik,$month);
		$data   = isset($result['data']) ? $result['data'] : [];

		// =========================
		// IF DEPARTMENT IS NULL OR EMPTY, THEN EXCLUDE FROM DATA
		// =========================		
		$data = array_values(array_filter($data, function($d) {
			return isset($d['department']) && trim($d['department']) !== '';
		}));

		$month_i = get_month($month);

		$spreadsheet = new Spreadsheet();

		// =========================
		// GROUP BY DEPARTMENT
		// =========================
		$departments = [];
		foreach ($data as $d) {
			$departments[$d['department']][] = $d;
		}

		// =========================
		// FUNCTION CREATE TABLE
		// =========================
		$createSheet = function($sheet, $title, $subtitle, $rows) {

			$headers = [
				'Employee ID','Complete Name','Personnel Area','Personnel Subarea','Date','Schedule','Schedule In',
				'Schedule Out','Check In','Check Out','Attendance Code','Time Off Code','Schedule Working Hours',
				'Actual Working Hours','Late In','Early Check Out','Office In','Check In Location','Coordinates In',
				'DMS In','Office Out','Check Out Location','Coordinates Out','DMS Out'
			];

			// Title
			$sheet->setCellValue('A1', $title);
			$sheet->setCellValue('A2', $subtitle);
			$sheet->mergeCells('A1:X1');
			$sheet->mergeCells('A2:X2');

			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Header
			$col = 'A';
			foreach ($headers as $h) {
				$sheet->setCellValue($col.'4', $h);
				$col++;
			}

			$sheet->getStyle('A4:X4')->applyFromArray([
				'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => '2F75B5']
				],
				'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
			]);

			// Data + Zebra
			$rowNum = 5;
			foreach ($rows as $i => $d) {

				$sheet->setCellValue('A'.$rowNum, $d['nik']);
				$sheet->setCellValue('B'.$rowNum, $d['complete_name']);
				$sheet->setCellValue('C'.$rowNum, $d['personnel_area']);
				$sheet->setCellValue('D'.$rowNum, $d['personnel_subarea']);
				$sheet->setCellValue('E'.$rowNum, $d['date']);
				$sheet->setCellValue('F'.$rowNum, $d['schedule']);
				$sheet->setCellValue('G'.$rowNum, $d['schedule_in']);
				$sheet->setCellValue('H'.$rowNum, $d['schedule_out']);
				$sheet->setCellValue('I'.$rowNum, $d['check_in']);
				$sheet->setCellValue('J'.$rowNum, $d['check_out']);
				$sheet->setCellValue('K'.$rowNum, $d['attendance_code']);
				$sheet->setCellValue('L'.$rowNum, $d['time_off_code']);
				$sheet->setCellValue('M'.$rowNum, $d['schedule_working_hours']);
				$sheet->setCellValue('N'.$rowNum, $d['actual_working_hours']);
				$sheet->setCellValue('O'.$rowNum, $d['late_in']);
				$sheet->setCellValue('P'.$rowNum, $d['early_check_out']);
				$sheet->setCellValue('Q'.$rowNum, $d['office_in']);
				$sheet->setCellValue('R'.$rowNum, $d['check_in_location']);
				$sheet->setCellValue('S'.$rowNum, $d['coordinates_in']);
				$sheet->setCellValue('T'.$rowNum, $d['dms_in']);
				$sheet->setCellValue('U'.$rowNum, $d['office_out']);
				$sheet->setCellValue('V'.$rowNum, $d['check_out_location']);
				$sheet->setCellValue('W'.$rowNum, $d['coordinates_out']);
				$sheet->setCellValue('X'.$rowNum, $d['dms_out']);

				// zebra
				// if ($i % 2 == 0) {
				// 	$sheet->getStyle("A{$rowNum}:X{$rowNum}")
				// 		->getFill()->setFillType(Fill::FILL_SOLID)
				// 		->getStartColor()->setRGB('F2F2F2');
				// }

				$rowNum++;
			}

			$lastRow = $rowNum - 1;

			// format %
			// $sheet->getStyle("K5:K{$lastRow}")
			// 	->getNumberFormat()->setFormatCode('0.00%');

			// border
			$sheet->getStyle("A4:X{$lastRow}")->applyFromArray([
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_THIN]
				]
			]);

			// auto width
			// foreach (range('A','X') as $c) {
			// 	$sheet->getColumnDimension($c)->setAutoSize(true);
			// }
			foreach (range('A','X') as $c) {
				$sheet->getColumnDimension($c)->setWidth(20);
			}

			// freeze
			$sheet->freezePane('A5');
		};

		// =========================
		// SHEET 1: ALL DATA
		// =========================
		$sheetAll = $spreadsheet->getActiveSheet();
		$sheetAll->setTitle('All Data');

		$createSheet(
			$sheetAll,
			"ATTENDANCE DETAIL TM",
			"All Employee | {$month_i} {$year}",
			$data
		);

		// =========================
		// SET ACTIVE SHEET
		// =========================
		$spreadsheet->setActiveSheetIndex(0);

		// =========================
		// OUTPUT
		// =========================
		$month = get_month($month);
		$filename = "Attendance_Detail_TM_{$month}_{$year}.xlsx";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		// signal selesai
		setcookie("download_done", "1", time() + 30, "/");

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		
		exit;
	}

	/////////////End Report Summary and Details TM 2026/////////////////////	

	public function export_excel_req_mdcr_all_per_day_ap()
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);

		$this->output->enable_profiler(FALSE);

		$no_req = $this->input->get('no_req');

		// Param validation
		if (empty($no_req)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode([
					'status'  => 'error',
					'message' => 'Parameter No Request tidak ditemukan.'
				]));
		}

		$data = $this->form_model->get_data_claim($no_req);

		// =========================
		// PENANGANAN DATA KOSONG
		// =========================
		if (empty($data)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode([
					'status'  => 'error',
					'message' => 'Data klaim reimbursement untuk No. Request ini kosong atau tidak ditemukan.'
				]));
		}

		$date_form = $this->form_model->get_date_no_req_mdcr($no_req);

		if (!empty($date_form)) {
			$count = count($date_form);

			$bulan_indo = [
				'01' => 'JAN', '02' => 'FEB', '03' => 'MAR', '04' => 'APR',
				'05' => 'MAY', '06' => 'JUN', '07' => 'JUL', '08' => 'AUG',
				'09' => 'SEP', '10' => 'OCT', '11' => 'NOV', '12' => 'DEC'
			];

			if ($count > 1) {
				$dt1 = date_create($date_form[array_key_first($date_form)]->dateonly);
				$dt2 = date_create($date_form[array_key_last($date_form)]->dateonly);

				// Komponen tanggal $dt1
				$tgl1 = date_format($dt1, 'd');
				$bln_num1 = date_format($dt1, 'm');
				$bln1 = $bulan_indo[$bln_num1];

				// Komponen tanggal $dt2
				$tgl2 = date_format($dt2, 'd');
				$bln_num2 = date_format($dt2, 'm');
				$bln2 = $bulan_indo[$bln_num2];
				$thn2_short = date_format($dt2, 'y'); // Format 2 digit tahun (misal: 26)
				$thn2_full  = date_format($dt2, 'Y'); // Format 4 digit tahun (misal: 2026)

				// Cek apakah bulan sama
				if ($bln_num1 === $bln_num2) {
					// Jika BULAN SAMA
					// Header Text: 07-08.08.26
					$Header_Text = 'REIMB MED ' . $tgl1 . '-' . $tgl2 . '.' . $bln_num2 . '.' . $thn2_short;

					// Text & Subtitle: 08-10 AUG 2026
					$Text     = 'REIMB MED PERIOD ' . $tgl1 . '-' . $tgl2 . ' ' . $bln2 . ' ' . $thn2_full;
					$subtitle = $tgl1 . '-' . $tgl2 . ' ' . $bln2 . ' ' . $thn2_full;
				} else {
					// Jika BULAN BEDA
					// Header Text: 29.07-08.08.26
					$Header_Text = 'REIMB MED ' . $tgl1 . '.' . $bln_num1 . '-' . $tgl2 . '.' . $bln_num2 . '.' . $thn2_short;

					// Text & Subtitle: 29 JUL - 10 AUG 2026
					$Text     = 'REIMB MED PERIOD ' . $tgl1 . ' ' . $bln1 . ' - ' . $tgl2 . ' ' . $bln2 . ' ' . $thn2_full;
					$subtitle = $tgl1 . ' ' . $bln1 . ' - ' . $tgl2 . ' ' . $bln2 . ' ' . $thn2_full;
				}

			} else {
				$dt1 = date_create($date_form[0]->dateonly);

				$Header_Text = 'REIMB MED ' . date_format($dt1, 'd.m.y');

				$tgl1 = date_format($dt1, 'd');
				$bln1 = $bulan_indo[date_format($dt1, 'm')];
				$thn1 = date_format($dt1, 'Y');

				$Text     = 'REIMB MED PERIOD ' . $tgl1 . ' ' . $bln1 . ' ' . $thn1;
				$subtitle = $tgl1 . ' ' . $bln1 . ' ' . $thn1;
			}
		} else {
			$Header_Text = '';
			$Text        = '';
			$subtitle    = 'NO_PERIOD';
		}

		$spreadsheet = new Spreadsheet();

		// Anonymous Function untuk pembuatan sheet
		$createSheet = function($sheet, $title, $subtitle, $rows) use ($Header_Text, $no_req, $Text) {

			$headers = [
				'No','NIK','Complete Name','Header Text','Assignment','Text','Amount','Cost Center'
			];

			// Title
			// $sheet->setCellValue('A1', $title);
			// $sheet->setCellValue('A2', $subtitle);
			// $sheet->mergeCells('A1:H1');
			// $sheet->mergeCells('A2:H2');

			// $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
			// $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			// $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Header
			$col = 'A';
			foreach ($headers as $h) {
				$sheet->setCellValue($col.'1', $h);
				$col++;
			}

			$sheet->getStyle('A1:H1')->applyFromArray([
				'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => '2F75B5']
				],
				'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
			]);

			// Data
			$rowNum = 2;
			$no = 0;
			foreach ($rows as $d) {
				$no++;
				$sheet->setCellValue('A'.$rowNum, $no);
				$sheet->setCellValue('B'.$rowNum, isset($d->employee_id) ? $d->employee_id : '');
				$sheet->setCellValue('C'.$rowNum, isset($d->complete_name) ? $d->complete_name : '');
				$sheet->setCellValue('D'.$rowNum, $Header_Text);
				$sheet->setCellValue('E'.$rowNum, $no_req);
				$sheet->setCellValue('F'.$rowNum, $Text);
				$sheet->setCellValue('G'.$rowNum, isset($d->total) ? $d->total : 0);
				$sheet->setCellValue('H'.$rowNum, isset($d->cost_center) ? $d->cost_center : '');

				$rowNum++;
			}

			$lastRow = max($rowNum - 1, 1);

			// Border
			$sheet->getStyle("A1:H{$lastRow}")->applyFromArray([
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_THIN]
				]
			]);

			// Auto width
			// foreach (range('A','H') as $c) {
			// 	$sheet->getColumnDimension($c)->setWidth(20);
			// }
			foreach (range('A', 'H') as $col) {
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}

			// $sheet->freezePane('A5');
		};

		// SHEET 1
		$sheetAll = $spreadsheet->getActiveSheet();
		$sheetAll->setTitle("Recap_Medical_Reimbursement_" . $clean_subtitle);

		$createSheet(
			$sheetAll,
			"Recap_Medical_Reimbursement_" . $clean_subtitle,
			$subtitle,
			$data
		);

		$spreadsheet->setActiveSheetIndex(0);

		// OUTPUT PROCESS
		// $clean_subtitle = preg_replace('/[^A-Za-z0-9\-]/', '_', $subtitle);
		// $filename = "Recap_Medical_Reimbursement_" . $clean_subtitle . ".xlsx";
		$filename = $no_req . ".xlsx";

		if (ob_get_level()) {
			ob_end_clean();
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
