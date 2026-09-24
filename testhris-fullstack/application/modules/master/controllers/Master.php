<?php
defined('BASEPATH') or exit('No direct script access allowed');

require '/var/www/html/application/vendor/phpmailer/phpmailer/src/Exception.php';
require '/var/www/html/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/var/www/html/application/vendor/phpmailer/phpmailer/src/SMTP.php';

// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/Exception.php';
// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception ;

class Master extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		// $this->load->library('enc');
		// $this->enc->check_session();

		$this->email = $this->session->userdata('user_email');
		$this->division = $this->session->userdata('division');
		$this->second_division = $this->session->userdata('second_division');
		$this->emp_id = $this->session->userdata('employee_id');

		$this->status_apps = $_ENV['CI_ENVIRONMENT'];

		// if ($this->emp_id == '') {
		// 	print_r("You are not authorized to access this apps.");
		// 	exit();
		// }
		
		$this->load->helper('general');
		$this->load->model('master/master_model');
		$this->load->model('inbox/inbox_model');
		$this->load->model('form/form_model');
		$this->load->model('home/home_model');
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
		print_r('Please go back to login.');die;
	}

	public function users()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/users';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function regional_pm()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/regional_pm';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	
	public function mod_edit_rawat_jalan()
	{
		$this->load->view('master/mod/mod_edit_rawat_jalan');
	}
	
	public function employee()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/employee';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function medical_plafon()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/medical_plafon';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function medical_type_of_reimbursment()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/medical_type_of_reimbursment';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function read($table)
	{
		switch ($table) {

			case 'employee':

				$listForm = $this->master_model->getEmployee();
				// dumper($listForm);
		        if (!empty($listForm)) {
				// dumper($listForm);

		        foreach ($listForm as $key) {
						// $start_date = decrypt($key->start_date);
						// $start_date = DateTime::createFromFormat('Ymd', $start_date);
						// $start_date = $start_date->format('d.m.Y');
						$start_date = decrypt($key->start_date);
						$start_date = date("Y-m-d",strtotime($start_date));
						$start_date = DateTime::createFromFormat('Y-m-d', $start_date)->format('d.m.Y');
						//dumper($start_date);

						// $date_of_birth = decrypt($key->date_of_birth);
						// $date_of_birth = DateTime::createFromFormat('Ymd', $date_of_birth);
						// $date_of_birth = $date_of_birth->format('d.m.Y');
						$date_of_birth = decrypt($key->date_of_birth);
						$date_of_birth = date("Y-m-d",strtotime($date_of_birth));
						$date_of_birth = DateTime::createFromFormat('Y-m-d', $date_of_birth)->format('d.m.Y');
						// dumper($date_of_birth);
						// $join_date = decrypt($key->join_date);
						// $join_date = DateTime::createFromFormat('Ymd', $join_date);
						// $join_date = $join_date->format('d.m.Y');
						$join_date = decrypt($key->join_date);
						$join_date = date("d.m.Y",strtotime($join_date));
						// $join_date = DateTime::createFromFormat('Y-m-d', $join_date)->format('d.m.Y');
						//dumper($join_date);

						if((decrypt($key->marital_status)) == 'Marr.'){
							$marital_status = 'Married';
						}else if(((decrypt($key->marital_status)) == 'Div.') || ((decrypt($key->marital_status)) == 'Wid.')){
							////Updating date 16/10/2023
							$marital_status = 'Divorce';
							////End - Mengaktifkan Marital Status Divorce//////////
						}else{
							$marital_status = 'Single';
						}


						$complete_name = str_replace("||","'", decrypt($key->complete_name));

						$emftx = str_replace("||","'", decrypt($key->emftx));

						$emftx1 = str_replace("||","'", decrypt($key->emftx1));

						$superior_name = str_replace("||","'", decrypt($key->superior_name));
						
						$rpm_name 		= str_replace("||","'", decrypt($key->rpm_name));

						$depthead_name = str_replace("||","'", decrypt($key->depthead_name));

						$divhead_name = str_replace("||","'", decrypt($key->divhead_name));

						$director_name = str_replace("||","'", decrypt($key->director_name));

            $row   = array();
            $row[] = $key->nik;
            $row[] = $complete_name;
						$row[] = $start_date;
						$row[] = decrypt($key->action);
						$row[] = decrypt($key->reason_of_action);
						$row[] = decrypt($key->gender);
						$row[] = decrypt($key->birthplace);
						$row[] = $date_of_birth;
						$row[] = decrypt($key->religion);
						$row[] = $marital_status;
						$row[] = $join_date;
						$row[] = decrypt($key->permanent_address);
						$row[] = decrypt($key->temporary_address);
						$row[] = decrypt($key->phone_number);
						$row[] = decrypt($key->sf_phone_number);
						$row[] = decrypt($key->personal_email);
						$row[] = decrypt($key->email);
						$row[] = decrypt($key->no_ktp);
						$row[] = decrypt($key->npwp_id);
						$row[] = decrypt($key->bpjs_ketenagakerjaan);
						$row[] = decrypt($key->bpjs_kesehatan);
						$row[] = decrypt($key->status_ptkp);
						$row[] = decrypt($key->company_code);
						$row[] = decrypt($key->company_name);
						$row[] = decrypt($key->personnel_area);
						$row[] = decrypt($key->personnel_subarea);
						$row[] = decrypt($key->employee_group);
						$row[] = decrypt($key->employee_subgroup);
						$row[] = decrypt($key->cost_center);
						$row[] = decrypt($key->bankn);
						$row[] = $emftx;
						$row[] = decrypt($key->bankn1);
						$row[] = $emftx1;
						$row[] = decrypt($key->position);
						$row[] = decrypt($key->department);
						$row[] = decrypt($key->division);
						$row[] = decrypt($key->directorate);
						$row[] = decrypt($key->superior);
						$row[] = $superior_name;
						$row[] = decrypt($key->usrid_long1);
						$row[] = decrypt($key->rpm);
						$row[] = decrypt($key->usrid_long5);
						$row[] = $rpm_name;
						$row[] = decrypt($key->department_head);
						$row[] = $depthead_name;
						$row[] = decrypt($key->usrid_long2);
						$row[] = decrypt($key->division_head);
						$row[] = $divhead_name;
						$row[] = decrypt($key->usrid_long3);
						$row[] = decrypt($key->director);
						$row[] = $director_name;
						$row[] = decrypt($key->usrid_long4);
		                // $row[] = '<div class="btn-group btn-group-sm">
		                //             <a href="' . base_url('inbox/hr_view_details/' . encode_url($key->id_employee)) . '" class="btn btn-icon btn-trigger">
		                //                 <em class="icon ni ni-eye"></em>
		                //             </a>
		                //     	</div>';

		                $data[] = $row;
		            }
		            $output = array('data' => $data);
		        } else {
		            $output = array('data' => new ArrayObject());
		        }
		        // dumper($output);
		        echo json_encode($output);
				break;
			

			case 'family_employee':

				$listF = $this->master_model->getFamilyEmployee();
		        if (!empty($listF)) {
		            foreach ($listF as $key) {

						$member_birthdate = decrypt($key->member_birthdate);
						//dumper(encrypt('01062020'));
						if($member_birthdate == ''){
							// dumper($key);
						}

						$member_birthdate = decrypt($key->member_birthdate);
						$member_birthdate = date("Y-m-d",strtotime($member_birthdate));
						$member_birthdate = DateTime::createFromFormat('Y-m-d', $member_birthdate)->format('d.m.Y');

						// // $member_birthdate = DateTime::createFromFormat('Ymd', $member_birthdate);
						// $member_birthdate = $member_birthdate->format('d.m.Y');
						// dumper($member_birthdate);

						
						//

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

			case 'couple_employee':

				$listCE = $this->master_model->getCoupleEmployee();
		        if (!empty($listCE)) {
		            foreach ($listCE as $key) {

		                $row   = array();
						$row[] = $key->male_nik;
		                $row[] = decrypt($key->male_employee);
		                $row[] = $key->female_nik;
						$row[] = decrypt($key->female_employee);
						$row[] = $key->start_date;
						$row[] = $key->end_date;
						$close_action = date('Y-m-d',strtotime('+30 days',strtotime($key->start_date)));
						if($close_action > date('Y-m-d')){
							$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteCouple" data-offset="-4,0" id="'.$key->id.'" onClick="delete_couple('.$key->id.')">
		                                <em class="icon ni ni-trash"></em>
		                            	</a>
										&nbsp;&nbsp;&nbsp;&nbsp;
										<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-offset="-4,0" id="'.$key->id.'" onClick="edit_couple('.$key->id.')">
		                                <em class="icon ni ni-edit"></em>
		                            	</a>										
		                    	</div>';		
						}else{
							$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-offset="-4,0" id="'.$key->id.'" onClick="edit_couple('.$key->id.')">
		                                <em class="icon ni ni-edit"></em>
		                            	</a>
		                    	</div>';		
						}
		                $data[] = $row;
		            }
		            $outputCE = array('data' => $data);
		        } else {
		            $outputCE = array('data' => new ArrayObject());
		        }
		        echo json_encode($outputCE);
				break;

			case 'pagu_rawat_jalan':

				$listRJ = $this->master_model->getPaguRawatJalan();
				if (!empty($listRJ)) {
					foreach ($listRJ as $key) {

						$row   = array();
						$row[] = $key->start_date;
						$row[] = $key->end_date;
						$row[] = $key->grade;
						$row[] = number_format($key->pagu_tahun);
						$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditPaguRawatJalan" data-offset="-4,0" id="'.$key->id.'" onClick="edit_pagu_rawat_jalan('.$key->id.')">
										<em class="icon ni ni-edit"></em>
										</a>
										<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeletePaguRawatJalan" data-offset="-4,0" id="'.$key->id.'" onClick="delete_pagu_rawat_jalan('.$key->id.')">
		                                <em class="icon ni ni-trash"></em>
		                            	</a>
		                    	</div>
								';
						$data[] = $row;
					}
					$outputRJ = array('data' => $data);
				} else {
					$outputRJ = array('data' => new ArrayObject());
				}
				echo json_encode($outputRJ);
				break;

				case 'pagu_rawat_inap':

				$listRI = $this->master_model->getPaguRawatInap();
				if (!empty($listRI)) {
					foreach ($listRI as $key) {

						$row   = array();
						$row[] = $key->start_date;
						$row[] = $key->end_date;
						$row[] = $key->grade;
						$row[] = number_format($key->pagu_kamar_hari);
						$row[] = number_format($key->pagu_tahun);
						$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditPaguRawatInap" data-offset="-4,0" id="'.$key->id.'" onClick="edit_pagu_rawat_inap('.$key->id.')">
										<em class="icon ni ni-edit"></em>
										</a>
										<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeletePaguRawatInap" data-offset="-4,0" id="'.$key->id.'" onClick="delete_pagu_rawat_inap('.$key->id.')">
		                                <em class="icon ni ni-trash"></em>
		                            	</a>
		                    	</div>';
						$data[] = $row;
					}
					$outputRI = array('data' => $data);
				} else {
					$outputRI = array('data' => new ArrayObject());
				}
				echo json_encode($outputRI);
				break;

				case 'pagu_maternity':

					$listM = $this->master_model->getPaguMaternity();
					if (!empty($listM)) {
						foreach ($listM as $key) {
	
							$row   = array();
							$row[] = $key->start_date;
							$row[] = $key->end_date;
							$row[] = $key->melahirkan;
							$row[] = $key->grade;
							$row[] = number_format($key->pagu_tahun);
							$row[] = '<div class="btn-group btn-group-sm">
											<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditPaguMaternity" data-offset="-4,0" id="'.$key->id.'" onClick="edit_pagu_maternity('.$key->id.')">
											<em class="icon ni ni-edit"></em>
											</a>
											<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeletePaguMaternity" data-offset="-4,0" id="'.$key->id.'" onClick="delete_pagu_maternity('.$key->id.')">
											<em class="icon ni ni-trash"></em>
											</a>
									</div>';
							$data[] = $row;
						}
						$outputM = array('data' => $data);
					} else {
						$outputM = array('data' => new ArrayObject());
					}
					echo json_encode($outputM);
					break;

				case 'pagu_kacamata':

				$listK = $this->master_model->getPaguKacamata();
				if (!empty($listK)) {
					foreach ($listK as $key) {

						$row   = array();
						$row[] = $key->start_date;
						$row[] = $key->end_date;
						$row[] = $key->grade;
						$row[] = number_format($key->pagu_one_focus_tahun);
						$row[] = number_format($key->pagu_two_focus_tahun);
						$row[] = number_format($key->pagu_frame_dua_tahun);
						$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditPaguKacamata" data-offset="-4,0" id="'.$key->id.'" onClick="edit_pagu_kacamata('.$key->id.')">
										<em class="icon ni ni-edit"></em>
										</a>
										<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeletePaguKacamata" data-offset="-4,0"  id="'.$key->id.'" onClick="delete_pagu_kacamata('.$key->id.')">
		                                <em class="icon ni ni-trash"></em>
		                            	</a>
		                    	</div>';
						$data[] = $row;
					}
					$outputK = array('data' => $data);
				} else {
					$outputK = array('data' => new ArrayObject());
				}
				echo json_encode($outputK);
				break;

				case 'grandparent':

					$listGP = $this->master_model->getGrandparent();
					if (!empty($listGP)) {
						foreach ($listGP as $key) {
	
							$row   = array();
							$row[] = $key->grandparent;
							$row[] = $key->description;
							$row[] = '<div class="btn-group btn-group-sm">
											<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditGrandParent" data-offset="-4,0" id="'.$key->id.'" onClick="edit_grandparent('.$key->id.')">
											<em class="icon ni ni-edit"></em>
											</a>
											<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteGrandParent" data-offset="-4,0" id="'.$key->id.'" onClick="delete_grandparent('.$key->id.')">
											<em class="icon ni ni-trash"></em>
											</a>
									</div>';
							$data[] = $row;
						}
						$outputGP = array('data' => $data);
					} else {
						$outputGP = array('data' => new ArrayObject());
					}
					echo json_encode($outputGP);
					break;

				case 'parent':

					$listP = $this->master_model->getParent();
					if (!empty($listP)) {
						foreach ($listP as $key) {
	
							$row   = array();
							$row[] = $key->grandparent;
							$row[] = $key->parent;
							$row[] = $key->description;
							$row[] = '<div class="btn-group btn-group-sm">
											<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditParent" data-offset="-4,0" id="'.$key->id.'" onClick="edit_parent('.$key->id.')">
											<em class="icon ni ni-edit"></em>
											</a>
											<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteParent" data-offset="-4,0" id="'.$key->id.'" onClick="delete_parent('.$key->id.')">
											<em class="icon ni ni-trash"></em>
											</a>
									</div>';
							$data[] = $row;
						}
						$outputP = array('data' => $data);
					} else {
						$outputP = array('data' => new ArrayObject());
					}
					echo json_encode($outputP);
					break;
				
				case 'child':

					$listC = $this->master_model->getChild();
					if (!empty($listC)) {
						foreach ($listC as $key) {
	
							$row   = array();
							$row[] = $key->start_date;
							$row[] = $key->end_date;
							$row[] = $key->grandparent;
							$row[] = $key->parent;
							$row[] = $key->child;
							$row[] = $key->claim_percentage;
							$row[] = number_format($key->claim_value);
							$row[] = $key->description;
							$row[] = '<div class="btn-group btn-group-sm">
											<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditChild" data-offset="-4,0" id="'.$key->id.'" onClick="edit_child('.$key->id.')">
											<em class="icon ni ni-edit"></em>
											</a>
											<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteChild" data-offset="-4,0" id="'.$key->id.'" onClick="delete_child('.$key->id.')">
											<em class="icon ni ni-trash"></em>
											</a>
									</div>';
							$data[] = $row;
						}
						$outputC = array('data' => $data);
					} else {
						$outputC = array('data' => new ArrayObject());
					}
					echo json_encode($outputC);
					break;
				
					case 'efektifitas_kuitansi':

					$listEK = $this->master_model->getEKuitansi();
					if (!empty($listEK)) {
						foreach ($listEK as $key) {
	
							$row   = array();
							$row[] = $key->start_date;
							$row[] = $key->end_date;
							$row[] = $key->efektif_kuitansi;
							if($key->active == 1){
							$row[] = '<div class="btn-group btn-group-sm">
							<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEKuitansi" data-offset="-4,0" id="'.$key->id.'" onClick="delete_ekuitansi('.$key->id.')">
												<em class="icon ni ni-trash"></em>
												</a>
										</div>';
										
							}else{
								$row[] = '';
							}
							$data[] = $row;
						}
						$outputEK = array('data' => $data);
					} else {
						$outputEK = array('data' => new ArrayObject());
					}
					echo json_encode($outputEK);
					break;

					case 'users':

						$listU = $this->master_model->getUsers();
						//dumper($listU);
						if (!empty($listU)) {
							foreach ($listU as $key) {
		
								$row   = array();
								$row[] = $key->id_user;
								$row[] = $key->employee_id;
								$row[] = $key->full_name;
								$row[] = $key->user_email;
								$row[] = $key->phone_number;
								$row[] = $key->user_role;
								$row[] = $key->access_level;
								$row[] = $key->verification_status;
								$row[] = '<div class="btn-group btn-group-sm">
												<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditUser" data-offset="-4,0" id="'.$key->id_user.'" onClick="edit_user('.$key->id_user.')">
												<em class="icon ni ni-edit"></em>
												</a>
												<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteUser" data-offset="-4,0" id="'.$key->id_user.'" onClick="delete_user('.$key->id_user.')">
												<em class="icon ni ni-trash"></em>
												</a>
										</div>';
								$data[] = $row;
							}
							$outputU = array('data' => $data);
						} else {
							$outputU = array('data' => new ArrayObject());
						}
						echo json_encode($outputU);
						break;

					case 'rpm':

						$listRPM = $this->master_model->getRPM();
						//dumper($listRPM);
						if (!empty($listRPM)) {
							foreach ($listRPM as $key) {
		
								$row   = array();
								$row[] = $key->employee_id;
								$row[] = $key->full_name;
								$row[] = $key->user_email;
								$row[] = $key->region;
								$row[] = '<div class="btn-group btn-group-sm">
												<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditRPM" data-offset="-4,0">
												<em class="icon ni ni-edit"></em>
												</a>
												<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteRPM" data-offset="-4,0">
												<em class="icon ni ni-trash"></em>
												</a>
										</div>';
								$data[] = $row;
							}
							$outputU = array('data' => $data);
						} else {
							$outputU = array('data' => new ArrayObject());
						}
						echo json_encode($outputU);
						break;

			case 'mulDiv':
				$listMD = $this->master_model->getMul_Div();
				if (!empty($listMD)) {
					foreach ($listMD as $key) {

						$row   = array();
						$row[] = $key->nik;
						$row[] = decrypt($key->complete_name);
						$row[] = decrypt($key->division);
						$row[] = $key->eval_year;
						// $row[] = $key->created_at;
						$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteMD" data-offset="-4,0" id="'.$key->id.'" onClick="delete_MD('.$key->id.')">
										<em class="icon ni ni-trash"></em>
										</a>
								</div>';
						$data[] = $row;
					}
					$outputMD = array('data' => $data);
				} else {
					$outputMD = array('data' => new ArrayObject());
				}
				echo json_encode($outputMD);
				break;

			////////////////////////////// START TIME MANAGEMENT 2024 ////////////////////////////////
			case 'time_off':

				$listTO = $this->master_model->getTimeOff();
				if (!empty($listTO)) {
					foreach ($listTO as $key) {

						$row   = array();
						$row[] = $key->nama;
						$row[] = $key->kode;
						$row[] = $key->company_name;
						$row[] = $key->company_code;

						$start_date = $key->start_date;
						$start_date = DateTime::createFromFormat('Y-m-d', $start_date)->format('d.m.Y');
						$end_date = $key->end_date;
						$end_date = DateTime::createFromFormat('Y-m-d', $end_date)->format('d.m.Y');

						$row[] = $start_date;
						$row[] = $end_date;
						$row[] = $key->deskripsi;
						if ($key->status == 1){
							$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditTimeOff" data-offset="-4,0" id="'.$key->id.'" onClick="edit_time_off('.$key->id.')">
										<em class="icon ni ni-edit"></em>
										</a>
										<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteTimeOff" data-offset="-4,0" id="'.$key->id.'" onClick="delete_time_off('.$key->id.', '."'$key->kode'".')">
										<em class="icon ni ni-trash"></em>
										</a>
								</div>
								';
						} else {
							$row[] = 'Inactive';
						}
						$data[] = $row;
					}
					$outputTO = array('data' => $data);
				} else {
					$outputTO = array('data' => new ArrayObject());
				}
				echo json_encode($outputTO);
				break;

			case 'schedule':
				$listSchedule = $this->master_model->getSchedule();
				if (!empty($listSchedule)) {
					foreach ($listSchedule as $key) {

						$row   = array();
						$row[] = $key->nama;
						$row[] = $key->kode;
						$row[] = $key->company_name;
						$row[] = $key->company_code;
						
						$start_date = $key->start_date;
						$start_date = DateTime::createFromFormat('Y-m-d', $start_date)->format('d.m.Y');
						$end_date = $key->end_date;
						$end_date = DateTime::createFromFormat('Y-m-d', $end_date)->format('d.m.Y');

						$row[] = $start_date;
						$row[] = $end_date;
						$row[] = $key->schedule_in;
						$row[] = $key->schedule_out;
						$row[] = $key->shift_type; //TIME MANAGEMENT 2.0
						if ($key->status == 1){
							$row[] = '<div class="btn-group btn-group-sm">
										<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditSchedule" data-offset="-4,0" id="'.$key->id.'" onClick="edit_schedule('.$key->id.')">
										<em class="icon ni ni-edit"></em>
										</a>
										<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteSchedule" data-offset="-4,0" id="'.$key->id.'" onClick="delete_schedule('.$key->id.', '."'$key->kode'".')">
										<em class="icon ni ni-trash"></em>
										</a>
								</div>
								';
						} else {
							$row[] = '';
						}
						$data[] = $row;
					}
					$outputSchedule = array('data' => $data);
				} else {
					$outputSchedule = array('data' => new ArrayObject());
				}
				echo json_encode($outputSchedule);
				break;

			case 'office':
				$listOffice = $this->master_model->getOffice();
				if (!empty($listOffice)) {
					foreach ($listOffice as $key) {

						$row   = array();
						$row[] = '<div class="btn-group btn-group-sm">
									<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalEditOffice" data-offset="-4,0" id="'.$key->id.'" onClick="edit_office('.$key->id.')">
									<em class="icon ni ni-edit"></em>
									</a>
									<a class="text-danger btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDeleteOffice" data-offset="-4,0" id="'.$key->id.'" onClick="delete_office('.$key->id.')">
									<em class="icon ni ni-trash"></em>
									</a>
							</div>
							';
						$row[] = $key->pa_code;
						$row[] = $key->personnel_area;
						$row[] = $key->start_date;
						$row[] = $key->end_date;
						$row[] = $key->address;
						$row[] = $key->lattitude;
						$row[] = $key->longitude;
						$row[] = $key->radius;
						$data[] = $row;
					}
					$outputOffice = array('data' => $data);
				} else {
					$outputOffice = array('data' => new ArrayObject());
				}
				echo json_encode($outputOffice);
				break;

			case 'relocation':
				$listRelocation = $this->master_model->getRelocation_ztm();
				if (!empty($listRelocation)) {
					foreach ($listRelocation as $key) {

						$row   = array();
						$row[] = $key->nik;
						$row[] = $key->full_name;
						$row[] = $key->pa_awal;
						$row[] = $key->pa_akhir;
						$row[] = $key->start_date;
						$row[] = $key->end_date;
						$data[] = $row;
					}
					$outputOffice = array('data' => $data);
				} else {
					$outputOffice = array('data' => new ArrayObject());
				}
				echo json_encode($outputOffice);
				break;
			////////////////////////////// END TIME MANAGEMENT 2024 ////////////////////////////////

			default:
				break;
		}
	}

	public function tambah_pagu_rawat_jalan(){
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$grade 			= $_POST['grade'];
		$pagu_tahun		= $_POST['pagu_tahun'];

		$data = $this->master_model->setPaguRawatJalan($start_date, $end_date, $grade, $pagu_tahun);

		//dumper($data);
		echo json_encode($data);

	}

	public function ubah_pagu_rawat_jalan(){
		$id 			= $_POST['id'];
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$grade 			= $_POST['grade'];
		$pagu_tahun		= $_POST['pagu_tahun'];
		$data = $this->master_model->updatePaguRawatJalan($id, $start_date, $end_date, $grade, $pagu_tahun);
		echo json_encode($data);

	}
	
	public function tambah_pagu_rawat_inap(){
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$grade 			= $_POST['grade'];
		$pagu_kamar		= $_POST['pagu_kamar'];
		$pagu_tahun		= $_POST['pagu_tahun'];
		$data = $this->master_model->setPaguRawatInap($start_date, $end_date, $grade, $pagu_kamar, $pagu_tahun);
		echo json_encode($data);

	}

	public function tambah_pagu_maternity(){
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$melahirkan		= $_POST['melahirkan'];
		$grade 			= $_POST['grade'];
		$pagu_tahun		= $_POST['pagu_tahun'];
		$data = $this->master_model->setPaguMaternity($start_date, $end_date, $melahirkan, $grade, $pagu_tahun);
		echo json_encode($data);

	}

	public function ubah_pagu_rawat_inap(){
		$id 			= $_POST['id'];
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$grade 			= $_POST['grade'];
		$pagu_kamar		= $_POST['pagu_kamar'];
		$pagu_tahun		= $_POST['pagu_tahun'];
		$data = $this->master_model->updatePaguRawatInap($id, $start_date, $end_date, $grade, $pagu_kamar, $pagu_tahun);
		echo json_encode($data);

	}

	public function ubah_pagu_maternity(){
		$id 			= $_POST['id'];
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$melahirkan		= $_POST['melahirkan'];
		$grade 			= $_POST['grade'];
		$pagu_tahun		= $_POST['pagu_tahun'];
		$data = $this->master_model->updatePaguMaternity($id, $start_date, $end_date, $melahirkan, $grade, $pagu_tahun);
		echo json_encode($data);

	}

	public function tambah_pagu_kacamata(){
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$grade 			= $_POST['grade'];
		$pagu_one_focus	= $_POST['pagu_one_focus'];
		$pagu_two_focus	= $_POST['pagu_two_focus'];
		$pagu_frame		= $_POST['pagu_frame'];

		$data = $this->master_model->setPaguKacamata($start_date, $end_date, $grade, $pagu_one_focus, $pagu_two_focus, $pagu_frame);
		echo json_encode($data);

	}

	public function ubah_pagu_kacamata(){
		$id 	 		= $_POST['id'];
		$start_date 	= $_POST['start_date'];
		$end_date 		= $_POST['end_date'];
		$grade 			= $_POST['grade'];
		$pagu_one_focus	= $_POST['pagu_one_focus'];
		$pagu_two_focus	= $_POST['pagu_two_focus'];
		$pagu_frame		= $_POST['pagu_frame'];

		$data = $this->master_model->updatePaguKacamata($id, $start_date, $end_date, $grade, $pagu_one_focus, $pagu_two_focus, $pagu_frame);
		echo json_encode($data);

	}

	public function tambah_grandparent(){
		
		$grandparent 		= $_POST['grandparent_tambah'];
		$description		= $_POST['description_grandparent_tambah'];

		$data = $this->master_model->setGrandparent($grandparent, $description);

		//dumper($data);
		echo json_encode($data);

	}

	public function tambah_parent(){

		$parent_grandparent 		= $_POST['parent_grandparent_tambah'];
		$parent			 			= $_POST['parent_tambah'];
		$description_parent			= $_POST['description_parent_tambah'];

		$data = $this->master_model->setParent($parent_grandparent, $parent, $description_parent);

		//dumper($data);
		echo json_encode($data);

	}

	public function tambah_child(){

		$start_date					= $_POST['start_date'];
		$end_date					= $_POST['end_date'];
		$child_grandparent			= $_POST['child_grandparent_tambah'];
		$child_parent				= $_POST['child_parent_tambah'];
		$child						= $_POST['child_tambah'];
		$claim_percentage_child		= $_POST['claim_percentage_child_tambah'];
		$description_child			= $_POST['description_child_tambah'];

		$data = $this->master_model->setChild($start_date, $end_date, $child_grandparent, $child_parent, $child, $claim_percentage_child, $description_child);

		//dumper($data);
		echo json_encode($data);

	}
	
	public function tambah_efektifitas_kuitansi(){

		$efektif_kuitansi_tambah	= $_POST['efektif_kuitansi_tambah'];
		$start_date_tambah_efektif_kuitansi	= $_POST['start_date_tambah_efektif_kuitansi'];
		//dumper($start_date_tambah_efektif_kuitansi);

		$data = $this->master_model->tambah_efektifitas_kuitansi($efektif_kuitansi_tambah, $start_date_tambah_efektif_kuitansi);

		echo json_encode($data);

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

			case 'add_employee':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			case 'add_rpm':
				$log['activity'] = $activity;
				$log['description'] = $description;
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}


	public function get_Grandparent(){
		$data = $this->master_model->get_Grandparent();
		echo json_encode($data);
	}

	public function edit_get_Grandparent(){
		$id = $_POST['grandparent'];
		$data = $this->master_model->edit_get_Grandparent($id);
		echo json_encode($data);
	}

	public function edit_get_Parent(){
		$id = $_POST['parent'];
		$data = $this->master_model->edit_get_Parent($id);
		echo json_encode($data);
	}

	public function get_Parent(){
		if($this->input->post('grandparent'))
		{
			echo $this->master_model->get_Parent($this->input->post('grandparent'), $this->input->post('employee_group'));
		}
	}

	public function get_Child(){
		if($this->input->post('parent'))
		{
			echo $this->master_model->get_Child($this->input->post('parent'));
		}
	}

	public function getEditPaguRawatJalan(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditPaguRawatJalan($id);
		echo json_encode($data);
	}

	public function getDeletePaguRawatJalan(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeletePaguRawatJalan($id);
		echo json_encode($data);
	}

	public function getEditPaguRawatInap(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditPaguRawatInap($id);
		echo json_encode($data);
	}

	public function getDeletePaguRawatInap(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeletePaguRawatInap($id);
		echo json_encode($data);
	}

	public function getEditPaguMaternity(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditPaguMaternity($id);
		echo json_encode($data);
	}

	public function getDeletePaguMaternity(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeletePaguMaternity($id);
		echo json_encode($data);
	}

	public function getEditPaguKacamata(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditPaguKacamata($id);
		echo json_encode($data);
	}

	public function getDeletePaguKacamata(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeletePaguKacamata($id);
		echo json_encode($data);
	}

	public function getEditGrandparent(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditGrandparent($id);
		echo json_encode($data);
	}

	public function ubah_grandparent(){
		$id = $_POST['id'];
		$grandparent = $_POST['grandparent'];
		$description = $_POST['description'];
		$data = $this->master_model->ubah_grandparent($id, $grandparent, $description);
		echo json_encode($data);
	}

	public function getDeleteGrandparent(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteGrandparent($id);
		echo json_encode($data);
	}

	public function getEditParent(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditParent($id);
		echo json_encode($data);
	}

	public function ubah_parent(){
		$id = $_POST['id'];
		$grandparent 	= $_POST['grandparent'];
		$parent 		= $_POST['parent'];
		$description 	= $_POST['description'];
		$data = $this->master_model->ubah_parent($id, $grandparent, $parent, $description);
		echo json_encode($data);
	}

	public function getDeleteParent(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteParent($id);
		echo json_encode($data);
	}

	public function getEditChild(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditChild($id);
		echo json_encode($data);
	}

	public function ubah_child(){

		$id							= $_POST['id'];
		$start_date					= $_POST['start_date'];
		$end_date					= $_POST['end_date'];
		$child_grandparent			= $_POST['child_grandparent'];
		$child_parent				= $_POST['child_parent'];
		$child						= $_POST['child'];
		$claim_percentage_child		= $_POST['claim_percentage_child'];
		$claim_value_child			= $_POST['claim_value_child'];
		$description_child			= $_POST['description_child'];

		$data = $this->master_model->ubah_child($id, $start_date, $end_date, $child_grandparent, $child_parent, $child, $claim_percentage_child, $claim_value_child, $description_child);

		//dumper($data);
		echo json_encode($data);

	}

	public function getDeleteChild(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteChild($id);
		echo json_encode($data);
	}
	
	public function getDeleteEkuitansi(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteEkuitansi($id);
		echo json_encode($data);
	}
	
	public function delete_couple(){
		$id = $_POST['id'];
		$data = $this->master_model->delete_couple($id);
		echo json_encode($data);
	}


	public function getEmployeeToUsers(){
		$data = $this->master_model->getEmployeeToUsers();
		echo json_encode($data);
	}

	public function get_DataEmployeeToUsers(){
		$full_name_tambah_users = $_POST['full_name_tambah_users'];
		$data = $this->master_model->get_DataEmployeeToUsers($full_name_tambah_users);
		echo json_encode($data);
	}

	public function tambah_user(){

		$nik				= $_POST['nik'];
		$complete_name		= $_POST['complete_name'];
		$email				= $_POST['email'];
		$phone_number		= $_POST['phone_number'];
		$password			= $_POST['password'];
		$role				= $_POST['role'];
		$access				= $_POST['access'];
		$verification		= $_POST['verification'];

		$data = $this->master_model->setUsers($nik, $complete_name, $password, $role, $access, $verification, $email, $phone_number);

		echo json_encode($data);

	}


	public function getMaleEmployee(){
		$data = $this->master_model->getMaleEmployee();
		echo json_encode($data);
	}

	public function getFemaleEmployee(){
		$data = $this->master_model->getFemaleEmployee();
		echo json_encode($data);
	}

	public function get_DataEmployeeMale(){
		$full_name_male_add_couple = $_POST['full_name_male_add_couple'];
		$data = $this->master_model->get_DataEmployeeMale($full_name_male_add_couple);
		echo json_encode($data);
	}

	public function get_DataEmployeeFemale(){
		$full_name_female_add_couple = $_POST['full_name_female_add_couple'];
		//dumper($full_name_female_add_couple);
		$data = $this->master_model->get_DataEmployeeFemale($full_name_female_add_couple);
		echo json_encode($data);
	}

	public function add_couple_employee(){

		$employee_id_male				= $_POST['employee_id_male'];
		$employee_id_female				= $_POST['employee_id_female'];
		$complete_name_male				= $_POST['complete_name_male'];
		$complete_name_female			= $_POST['complete_name_female'];
		$start_date_couple				= date("Y-m-d", strtotime($_POST['start_date_couple']));
		$end_date_couple				= date("Y-m-d", strtotime($_POST['end_date_couple']));

		$data = $this->master_model->add_couple_employee($employee_id_male, $employee_id_female, $complete_name_male, $complete_name_female, $start_date_couple, $end_date_couple);

		echo json_encode($data);

	}

	public function save_act_child(){
		$id_family				= $_POST['id'];
		$st_act					= $_POST['st_act'];
		
		$data = $this->master_model->save_act_child($id_family, $st_act);

		echo json_encode($data);

	}


	// RPM
	public function add_rpm(){

		$data = array(
				'employee_id' => $this->input->post('rpm_employee_id'),
				'full_name' => $this->input->post('rpm_full_name'),
				'user_email' => $this->input->post('rpm_email'),
				'region' => $this->input->post('rpm_region'),
				'created_at' => $this->date,
				'created_by' => $this->email);

		if ($this->db->insert('hris_rpm1', $data)) {
			$response = array('status' => 1);
		} else {
			$response = array('status' => 0);
		}

		echo json_encode($response);
	}


	public function add_multi_division()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/add_multi_division';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function getDataDivisions(){
		$data = $this->master_model->getDataDivisions();
		echo json_encode($data);
	}

	public function save_add_multi_division(){
		$nik 			= $_POST['nik'];
		$divisi 		= $_POST['divisi'];
		$year 			= $_POST['year'];

		$data = $this->master_model->save_add_multi_division($nik, $divisi, $year);
		echo json_encode($data);

	}

	////////////////////////////////////START TIME MANAGEMENT 2024////////////////////////////////

	///////////// Time Management - Time-Off /////////////
	public function time_off()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/time_off';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function tambah_time_off(){
		$nama			= $_POST['nama'];
		$kode			= $_POST['kode'];
		$company_name	= $_POST['company_name'];
		$company_code	= $_POST['company_code'];
		$start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date	 	= date("Y-m-d", strtotime($_POST['end_date']));
		$deskripsi		= $_POST['deskripsi'];

		$data = $this->master_model->setTimeOff($nama, $kode, $company_name, $company_code, $start_date, $end_date, $deskripsi);

		echo json_encode($data);
	}

	public function ubah_time_off(){
		$id 			= $_POST['id'];
		$nama			= $_POST['nama'];
		$kode			= $_POST['kode'];
		$company_name	= $_POST['company_name'];
		$company_code	= $_POST['company_code'];
		$start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date	 	= date("Y-m-d", strtotime($_POST['end_date']));
		$deskripsi		= $_POST['deskripsi'];
		$data = $this->master_model->updateTimeOff($id, $nama, $kode, $company_name, $company_code, $start_date, $end_date, $deskripsi);
		echo json_encode($data);

	}

	public function getEditTimeOff(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditTimeOff($id);
		echo json_encode($data);
	}

	public function getDeleteTimeOff(){
		$id = $_POST['id'];
		$kode = $_POST['kode'];
		$data = $this->master_model->getDeleteTimeOff($id, $kode);
		echo json_encode($data);
	}
	
	///////////// Time Management - Schedule/////////////

	public function schedule()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/schedule';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function tambah_schedule(){
		$nama			= $_POST['nama'];
		$kode			= $_POST['kode'];
		$company_name	= $_POST['company_name'];
		$company_code	= $_POST['company_code'];
		$start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date 		= date("Y-m-d", strtotime($_POST['end_date']));
		$schedule_in	= $_POST['schedule_in'];
		$schedule_out	= $_POST['schedule_out'];
		$tipe_shift		= $_POST['tipe_shift'];

		$data = $this->master_model->setSchedule($nama, $kode, $company_name, $company_code, $start_date, $end_date, $schedule_in, $schedule_out, $tipe_shift);

		echo json_encode($data);
	}

	public function getEditSchedule(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditSchedule($id);
		echo json_encode($data);
	}

	public function ubah_schedule(){
		$id 			= $_POST['id'];
		$nama			= $_POST['nama'];
		$kode			= $_POST['kode'];
		$company_name	= $_POST['company_name'];
		$company_code	= $_POST['company_code'];
		$start_date 	= date("Y-m-d", strtotime($_POST['start_date']));
		$end_date 		= date("Y-m-d", strtotime($_POST['end_date']));
		$schedule_in	= $_POST['schedule_in'];
		$schedule_out	= $_POST['schedule_out'];
		$tipe_shift		= $_POST['tipe_shift'];

		$data = $this->master_model->updateSchedule($id, $nama, $kode, $company_name, $company_code, $start_date, $end_date, $schedule_in, $schedule_out, $tipe_shift);
		echo json_encode($data);

	}

	public function getDeleteSchedule(){
		$id = $_POST['id'];
		$kode = $_POST['kode'];
		$data = $this->master_model->getDeleteSchedule($id, $kode);
		echo json_encode($data);
	}
	public function office()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/office';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function tambah_office(){
		$nama		= $_POST['nama'];
		$kode		= $_POST['kode'];
		// $start_date	= $_POST['start_date'];
		// $end_date	= $_POST['end_date'];
		$start_date = date("Y-m-d", strtotime($_POST['start_date']));
		$end_date	= date("Y-m-d", strtotime($_POST['end_date']));
		$alamat		= $_POST['alamat'];
		$lat		= $_POST['lat'];
		$long 		= $_POST['long'];
		$radius		= $_POST['radius'];

		$data = $this->master_model->setOfficeLoc_ztm($nama, $kode, $start_date, $end_date, $alamat, $lat, $long, $radius);

		echo json_encode($data);
	}

	public function getEditOffice(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditOffice_ztm($id);
		echo json_encode($data);
	}

	public function ubah_office(){
		$id 		= $_POST['id'];
		$nama		= $_POST['nama'];
		$kode		= $_POST['kode'];
		// $start_date	= $_POST['start_date'];
		// $end_date	= $_POST['end_date'];
		$start_date = date("Y-m-d", strtotime($_POST['start_date']));
		$end_date	= date("Y-m-d", strtotime($_POST['end_date']));
		$alamat		= $_POST['alamat'];
		$lat		= $_POST['lat'];
		$long 		= $_POST['long'];
		$radius		= $_POST['radius'];
		$data = $this->master_model->updateOfficeLoc_ztm($id, $nama, $kode, $start_date, $end_date, $alamat, $lat, $long, $radius);
		echo json_encode($data);
	}

	public function getDeleteOffice(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteOffice_ztm($id);
		echo json_encode($data);
	}

	public function getRelocationLocation(){
		$data = $this->master_model->getRelocationLocation_ztm();
		echo json_encode($data);
	}

	public function getEmpPA(){
		$nik = $_POST['nik'];
		$data = $this->master_model->getEmpPA_ztm($nik);
		echo json_encode($data);
	}

	public function getEditReloc(){
		$id = $_POST['id'];
		$data = $this->master_model->getEditReloc_ztm($id);
		echo json_encode($data);
	}

	public function ubah_relokasi(){
		$id 		= $_POST['id'];
		$nama		= $_POST['nama'];
		$nik		= $_POST['nik'];
		// $start_date	= $_POST['start_date'];
		// $end_date	= $_POST['end_date'];
		$start_date = date("Y-m-d", strtotime($_POST['start_date']));
		$end_date	= date("Y-m-d", strtotime($_POST['end_date']));
		$pa_awal	= $_POST['pa_awal'];
		$pa_akhir	= $_POST['pa_akhir'];
		$data = $this->master_model->updateReloc_ztm($id, $nama, $nik, $start_date, $end_date, $pa_awal, $pa_akhir);
		echo json_encode($data);
	}

	public function getDeleteReloc(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteReloc_ztm($id);
		echo json_encode($data);
	}

	public function getDeleteReqReloc(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteReqReloc_ztm($id);
		echo json_encode($data);
	}

	public function req_reloc_table(){
		$no = 0;
		$listReqReloc = $this->master_model->getReqReloc_ztm(); 
		
		if (!empty($listReqReloc)) {
			foreach ($listReqReloc as $key) {
				$no++;
				$row   = array();
				$row[] = $no;
				$row[] = $key->request_number;
				$row[] = $key->full_name;
				$start_date = DateTime::createFromFormat('Y-m-d', $key->start_date)->format('d.m.Y');
				$row[] = $start_date;
				$end_date = DateTime::createFromFormat('Y-m-d', $key->end_date)->format('d.m.Y');
				$row[] = $end_date;
				if ($key->status == 0){
					$row[] = 'Waiting for Approval';
				} else if ($key->status == 1){
					$row[] = 'Approved';
				} else if ($key->status == 2){
					$row[] = 'Rejected';
				} else if ($key->status == 3){
					$row[] = 'Cancelled';
				}
				
				$encoded_url = encode_url($key->request_id);
				if ($key->status == 0){
					$trash = '<a class="text-danger btn btn-icon btn-trigger" id="'.$key->id.'" onClick="delete_request_reloc('.$key->id.')">
							<em class="icon ni ni-trash"></em>
							</a>';	
				} else {
					$trash = '';
				}
				$row[] = '<div class="btn-group btn-group-sm">
								<a class="text-primary btn btn-icon btn-trigger" id="'.$key->id.'" onClick="detail_approval_reloc('."'$encoded_url'".')">
								<em class="icon ni ni-info"></em>
								</a>
								'. $trash .'
							</div>
							';

				$data[] = $row;
			}
			$outputReqReloc = array('data' => $data);
		} else {
			$outputReqReloc = array('data' => new ArrayObject());
		}
		echo json_encode($outputReqReloc);
	}

	public function tambah_relokasi(){
		$nama		= $_POST['nama'];
		$nik		= $_POST['nik'];
		// $start_date	= $_POST['start_date'];
		// $end_date	= $_POST['end_date'];
		$start_date = date("Y-m-d", strtotime($_POST['start_date']));
		$end_date	= date("Y-m-d", strtotime($_POST['end_date']));
		$pa_awal	= $_POST['pa_awal'];
		$pa_akhir	= $_POST['pa_akhir'];
		$data = $this->master_model->addReloc_ztm($nama, $nik, $start_date, $end_date, $pa_awal, $pa_akhir);
		echo json_encode($data);
	}

	public function shifting_menu()
	{
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/shift';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function upload_shift(){
		$no = 0;
		$listReqShift = $this->master_model->getReqShiftSchedule_ztm($this->session->userdata('nik')); 
		
		if (!empty($listReqShift)) {
			foreach ($listReqShift as $key) {
				$no++;
				$row   = array();
				$row[] = $no;
				$row[] = $key->request_number;
				$row[] = $key->periode;
				$start_date = DateTime::createFromFormat('Y-m-d', $key->start_date)->format('d.m.Y');
				$row[] = $start_date;
				$end_date = DateTime::createFromFormat('Y-m-d', $key->end_date)->format('d.m.Y');
				$row[] = $end_date;
				if ($key->status == 0){
					$row[] = 'Waiting for Approval';
				} else if ($key->status == 1){
					$row[] = 'Approved';
				} else if ($key->status == 2){
					$row[] = 'Rejected';
				} else if ($key->status == 3){
					$row[] = 'Cancelled';
				} else if ($key->status == 4){
					$row[] = 'Need to be Revised';
				}
				
				$encoded_url = encode_url($key->request_id);
				$cek	= $this->form_model->CekApprovalLayer($key->request_number)[0]->result;
				if($cek){
					$trash = '';	
				}else{
					if ($key->status == 0){
						$trash = '<a class="text-danger btn btn-icon btn-trigger" id="'.$key->id.'" onClick="delete_request_shift_schedule('.$key->id.')">
								<em class="icon ni ni-trash"></em>
								</a>';	
					} else {
						$trash = '';
					}
				}

				$row[] = '<div class="btn-group btn-group-sm">
								<a class="text-primary btn btn-icon btn-trigger" id="'.$key->id.'" onClick="detail_approval_shift_schedule('."'$encoded_url'".')">
								<em class="icon ni ni-info"></em>
								</a>
								'. $trash .'
							</div>
							';

				$data[] = $row;
			}
			$outputReqShift = array('data' => $data);
		} else {
			$outputReqShift = array('data' => new ArrayObject());
		}
		echo json_encode($outputReqShift);
	}
	
	public function employee_shift_schedule(){
		$listEmpShift = $this->master_model->getEmpShift_ztm(encrypt($this->session->userdata('nik'))); 
		
		if (!empty($listEmpShift)) {
			foreach ($listEmpShift as $key) {
				$row   = array();
				$row[] = $key->nik;
				$name = decrypt($key->complete_name);
				$row[] = $name;
				$row[] = decrypt($key->department);
				$row[] = '<div class="btn-group btn-group-sm">
							<a class="text-primary btn btn-icon btn-trigger" data-toggle="modal" data-target="#modalDetailSchedule" data-offset="-4,0" id="'.$key->nik.'" onClick="detail_shift_schedule('.$key->nik.', '."'$name'".')">
							<em class="icon ni ni-info"></em>
							</a>
						  </div>
						  ';
				
				$data[] = $row;
			}
			$outputEmpShift = array('data' => $data);
		} else {
			$outputEmpShift = array('data' => new ArrayObject());
		}
		echo json_encode($outputEmpShift);
	}

	public function detail_employee_shift_schedule($nik, $date = ''){
		if ($date == ''){
			$date = date('Y-m');
		}
		$listDetailShift = $this->master_model->getDetailEmpShift_ztm($nik, $date);
		
		if (!empty($listDetailShift)) {
			foreach ($listDetailShift as $key) {
				$row   = array();
				$row[] = $key->employee_id;
				$row[] = $key->full_name;
				$view_date = DateTime::createFromFormat('Y-m-d', $key->date)->format('Y.m.d');
				$row[] = $view_date;
				$row[] = $key->dws;
				$row[] = $key->schedule_in;
				$row[] = $key->schedule_out;
				$row[] = $key->check_in;
				$row[] = $key->check_out;
				$row[] = $key->attendence_code;
				$row[] = $key->time_off_code;
				
				$data[] = $row;
			}
			$outputDetailShift = array('data' => $data);
		} else {
			$outputDetailShift = array('data' => new ArrayObject());
		}
		echo json_encode($outputDetailShift);
	}

	public function getYear(){
		$data = $this->master_model->getYear_ztm();
		echo json_encode($data);
	}

	public function requestShiftPattern(){
		$month_name = $_POST['month_name'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		$file_name = $_POST['file_name'];

		$data 	= $this->master_model->requestShiftPattern_ztm($file_name, $month_name, $month, $year);

		echo json_encode($data);
	}

	public function detail_approval($formType, $req_id){
		$request_id = decode_url($req_id);
		$data['form_request'] = $this->m_global->find('form_request', 'id', $request_id)->row_array();

		if ($formType == 'shift'){
			$data['header'] = $this->m_global->find('hris_request_shift_schedule', 'request_id', $request_id)->row_array();
			$employee_id = $data['header']['nik_requestor'];
			$data['personal_detail'] = $this->form_model->getTruePersonal_ztm($employee_id);
		} else if ($formType == 'relokasi') {
			$data['header'] = $this->m_global->find('hris_request_relokasi_sementara', 'request_id', $request_id)->row_array();
		}

		$data['approval'] = $this->m_global->find('form_approval', 'request_id', $request_id)->result_array();
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['notes']   = $this->m_global->find('request_notes', 'request_id', $request_id)->result_array();
		$data['content'] = 'master/approval/'. $formType;
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
	}

	public function getDeleteShiftReq(){
		$id = $_POST['id'];
		$data = $this->master_model->getDeleteShiftReq_ztm($id);
		echo json_encode($data);
	}

	public function newShiftPattern(){
		$id = $_POST['request_id'];
		$file_name = $_POST['file_name'];

		$data 	= $this->master_model->newShiftPattern_ztm($id, $file_name);

		echo json_encode($data);
	}

	public function getDwsTOCode(){
		$listInfoDWS = $this->master_model->getDwsTOCode_ztm();
		
		if (!empty($listInfoDWS)) {
			$data[] = ['DO', 'DAYOFF', '--:--', '--:--'];
			foreach ($listInfoDWS as $key) {
				$row   = array();
				$row[] = $key->kode;
				$row[] = $key->nama;
				if (!empty($key->schedule_in)){
					$row[] = $key->schedule_in;
				} else {
					$row[] = "--:--";
				}
				if (!empty($key->schedule_out)){
					$row[] = $key->schedule_out;
				} else {
					$row[] = "--:--";
				}
								
				$data[] = $row;
			}
			$outputInfoDWS = array('data' => $data);
		} else {
			$outputInfoDWS = array('data' => new ArrayObject());
		}
		echo json_encode($outputInfoDWS);
	}

	///////////////Start Luffi 2024/////////////
	public function show_user(){
		$id_user = $_POST['id'];
		$data = $this->master_model->get_show_user($id_user);
		echo json_encode($data[0]);
	}

	public function save_password_user(){
		$id_user				= $_POST['id_user'];
		$confirm_reset_password	= $_POST['confirm_reset_password'];
		$data = $this->master_model->save_password_user($id_user, $confirm_reset_password);
		if($data == TRUE){
			$this->sendEmail('reset_pass_user', $id_user);
		}
		echo json_encode($data);
	}

	public function delete_user(){
		$id = $_POST['id'];
		$data = $this->master_model->delete_user($id);
		echo json_encode($data);
	}

	///////////////End Luffi 2024/////////////

	public function sendEmail($type, $id_user="")
	{

		$link_host = "$_SERVER[HTTP_HOST]";
		if($link_host != "172.19.8.84" && $link_host != "hris.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com")){
			if ($type == 'reset_pass_user' || $type == 'send_pass_user') {
				$data['data_user'] = $this->master_model->get_show_user($id_user);
				$email_to 	   = 'luffi.utomo@ibsmulti.com';
				$html = $this->load->view('services/email/reset_pass_user', $data, TRUE);
				$email_subject = '[HRIS] USER ACCOUNT';
			}
		}else if($link_host == "hris.ibsmulti.com"){
			if ($type == 'reset_pass_user' || $type == 'send_pass_user') {
				$data['data_user'] = $this->master_model->get_show_user($id_user);
				$email_to 	   = $data['data_user'][0]->user_email;
				$html = $this->load->view('services/email/reset_pass_user', $data, TRUE);
				$email_subject = '[HRIS] USER ACCOUNT';
			}
		}

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
		// if($link_host != "172.19.8.84" && $link_host != "medclaim.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com")){
		// 	$mail->addAddress('luffi.utomo@ibsmulti.com');
		// 	$mail->addCC('ditha.damayanti@ibsmulti.com');
		// }else{
		// 	if($email_to == 'makmur@ibsmulti.com' || $email_to == 'MAKMUR@IBSMULTI.COM'){
		// 		// $data['email'] = 'sudarman@ibsmulti.com';
		// 		$mail->addAddress('sudarman@ibsmulti.com');
		// 	}else{
		// 		$mail->addAddress($email_to);
		// 	}
		// 	// $mail->addAddress($email_to);
		// 	// $mail->addAddress('sudarman@ibsmulti.com');
		// 	// $mail->addBCC('gilang.cahyo@ibsmulti.com');
		// 	$mail->addBCC('ditha.damayanti@ibsmulti.com');
		// 	$mail->addBCC('luffi.utomo@ibsmulti.com');
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
				$mail->addAddress('sudarman@ibsmulti.com');
			}else{
				$mail->addAddress($email_to);
			}
			$mail->addBCC('ditha.damayanti@ibsmulti.com');
			$mail->addBCC('luffi.utomo@ibsmulti.com');
		}

		
		

		// Isi Email
		$mail->isHTML(true);
		$mail->Subject = $email_subject;
		$mail->Body    = $html;

		$mail->send();
	}

	///////////////////////////END TIME MANAGEMENT 2024///////////////////////////////////
	///////////////////////////////START Penambahan Action couple Luffi 2025 //////////////////////////////
	public function edit_couple(){
		$id = $_POST['id'];
		$data = $this->master_model->edit_couple($id);
		echo json_encode($data);
	}

	public function edit_save_couple(){

		$id								= $_POST['id_couple'];
		$start_date_couple				= date("Y-m-d", strtotime($_POST['start_date_couple']));
		$end_date_couple				= date("Y-m-d", strtotime($_POST['end_date_couple']));

		$data = $this->master_model->edit_couple_employee($id, $start_date_couple, $end_date_couple);

		echo json_encode($data);

	}
	///////////////////////////////END Penambahan Action couple Luffi 2025 //////////////////////////////

	public function get_balance_mdcr(){
		$nik   		= $this->input->post('nik');
		$month   	= $this->input->post('month');
        $year  		= $this->input->post('year');

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order  = $this->input->post('order');
		$column = $this->input->post('columns');

		$result = $this->master_model->get_balance_mdcr($year, $start, $length, $search, $order, $column, $nik, $month);
		
		$data = [];
		foreach ($result['data'] as $value) {
			$row = [];
			
			$start_date 	= (string) $value['start_date'];
			$year_sd 		= substr($start_date, 0, 4);
			$action 		= $value['action'];
			
			// if($year > $year_sd && $action != 'Leaving'){
				$row[] = $value['nik'];
				$row[] = $value['name'];
				$row[] = $value['cost_center'];
				$row[] = angka_ribuan($value['outpatient_plafon']);
				$row[] = angka_ribuan($value['outpatient_claimed']);
				$row[] = angka_ribuan($value['outpatient_balance']);
				$row[] = angka_ribuan($value['inpatient_plafon']);
				$row[] = angka_ribuan($value['inpatient_claimed']);
				$row[] = angka_ribuan($value['inpatient_balance']);
				$row[] = angka_ribuan($value['optic_plafon']);
				$row[] = angka_ribuan($value['optic_claimed']);
				$row[] = angka_ribuan($value['optic_balance']);
				$row[] = $value['action'];
				$row[] = get_month($value['month']);
				$row[] = $value['year'];
			// }
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
	
	public function get_detail_balance_mdcr(){
		$nik   		= $this->input->post('nik');
		$month   	= $this->input->post('month');
        $year  		= $this->input->post('year');

		$draw   = intval($this->input->post("draw"));
		$start  = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$search = $this->input->post("search")['value'];
		$order  = $this->input->post('order');
		$column = $this->input->post('columns');

		$result = $this->master_model->get_detail_balance_mdcr($year, $start, $length, $search, $order, $column, $nik, $month);

		$data = [];
		foreach ($result['data'] as $value) {
		// foreach ($result as $value) {
			$row = [];
			
			
			$row[] = $value['employee_id'];
			$row[] = decrypt($value['complete_name']);
			$row[] = decrypt($value['cost_center']);
			$row[] = $value['tor_grandparent'];
			$row[] = $value['tor_parent'];
			$row[] = $value['tor_child'];
			$row[] = $value['diagnosa'];
			$row[] = $value['keterangan'];
			if($value['additional'] !== 'Diri Sendiri'){
				$additional = decrypt($value['additional']);
			}else{
				$additional = $value['additional'];
			}
			$row[] = $additional;
			$row[] = angka_ribuan($value['total_kuitansi']);
			$row[] = angka_ribuan($value['penggantian']);
			$row[] = $value['tanggal_kuitansi'];
			$row[] = ($value['submitted_user_at']);
			$row[] = ($value['checked_by_hr_at']);
			$row[] = ($value['grouped_by_hr_at']);
			$row[] = ($value['approved_divhead_hr_at']);
			$row[] = ($value['sent_to_ap_at']);
			$row[] = ($value['fully_paid_at']);
			$data[] = $row;
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		]);

		
	}

	public function export_report_mdcr_balance_csv()
	{
		// Matikan profiler dan bersihkan output buffer paling atas
		$this->output->enable_profiler(FALSE);
		if (ob_get_level()) {
			ob_end_clean();
		}

		$nik   = $this->input->get('nik');
		$year  = $this->input->get('year');
		$month = $this->input->get('month');
		

        $result 	= $this->master_model->get_balance_mdcr($year,0,1000000,null,null,null,$nik,$month);
        $data 		= isset($result['data']) ? $result['data'] : [];
		$month_i 	= get_month($month);
		// $filename = (!empty($nik)? "Medical_Claim_Balance_$nik-$year.csv" : "Medical_Claim_Balance_$year.csv");
		if (!empty($nik)) {
			// Kasus employee tertentu
			if ($month == 12) {
				$filename = "Medical_Claim_Balance_{$nik}-All_Month-{$year}.csv";
			} else {
				$filename = "Medical_Claim_Balance_{$nik}-{$month_i}-{$year}.csv";
			}
		} else {
			// Kasus semua employee
			if ($month == 12) {
				$filename = "Medical_Claim_Balance_All_Employee-All_Month-{$year}.csv";
			} else {
				$filename = "Medical_Claim_Balance_All_Employee-{$month_i}-{$year}.csv";
			}
		}


		header('Content-Type: text/csv; charset=utf-8');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');

		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

		fputcsv($output, [
			'Employee No','Employee Name','Cost Center',
			'Outpatient Plafon','Outpatient Claimed','Outpatient Balance',
			'Inpatient Plafon','Inpatient Claimed','Inpatient Balance',
			'Optic Plafon','Optic Claimed','Optic Balance',
			'Action','Month','Year'
		], ';');

		foreach ($data as $d) {
			fputcsv($output, [
				$d['nik'],
				$d['name'],
				$d['cost_center'],
				angka_ribuan($d['outpatient_plafon']),
				angka_ribuan($d['outpatient_claimed']),
				angka_ribuan($d['outpatient_balance']),
				angka_ribuan($d['inpatient_plafon']),
				angka_ribuan($d['inpatient_claimed']),
				angka_ribuan($d['inpatient_balance']),
				angka_ribuan($d['optic_plafon']),
				angka_ribuan($d['optic_claimed']),
				angka_ribuan($d['optic_balance']),
				$d['action'],
				get_month($d['month']),
				$d['year']
			], ';');
		}

		fclose($output);
		exit(); 
	}
	
	public function export_report_mdcr_detail_csv()
	{
		// Matikan profiler dan bersihkan output buffer paling atas
		$this->output->enable_profiler(FALSE);
		if (ob_get_level()) {
			ob_end_clean();
		}

		$nik   = $this->input->get('nik');
		$year  = $this->input->get('year');
		$month = $this->input->get('month');
		

        $result 	= $this->master_model->get_detail_balance_mdcr($year,0,1000000,null,null,null,$nik,$month);
        $data 		= isset($result['data']) ? $result['data'] : [];
		$month_i 	= get_month($month);
		// $filename = (!empty($nik)? "Medical_Claim_Balance_$nik-$year.csv" : "Medical_Claim_Balance_$year.csv");
		if (!empty($nik)) {
			// Kasus employee tertentu
			if ($month == 12) {
				$filename = "Medical_Claim_Details_{$nik}-All_Month-{$year}.csv";
			} else {
				$filename = "Medical_Claim_Details_{$nik}-{$month_i}-{$year}.csv";
			}
		} else {
			// Kasus semua employee
			if ($month == 12) {
				$filename = "Medical_Claim_Details_All_Employee-All_Month-{$year}.csv";
			} else {
				$filename = "Medical_Claim_Details_All_Employee-{$month_i}-{$year}.csv";
			}
		}


		header('Content-Type: text/csv; charset=utf-8');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');

		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

		fputcsv($output, [
			'NIK','Nama Karyawan','Cost Center',
			'Jenis Penggantian','Sub Penggantian','Detil Penggantian',
			'Diagnosa','Status Peserta','Keterangan',
			'Nominal Kuitansi','Nominal Penggantian','Submit Date','Checked by HR Date',
			'Bundling FI Date','Approved by HRGA Divhead Date','HR Sent to AP Date', 'Fully Paid Date'
		], ';');

		foreach ($data as $d) {
			if($d['additional'] !== 'Diri Sendiri'){
				$additional = decrypt($d['additional']);
			}else{
				$additional = $d['additional'];
			}
			fputcsv($output, [
				$d['employee_id'],
				decrypt($d['complete_name']),
				decrypt($d['cost_center']),
				$d['tor_grandparent'],
				$d['tor_parent'],
				$d['tor_child'],
				$d['diagnosa'],
				$additional,
				$d['keterangan'],
				angka_ribuan($d['total_kuitansi']),
				angka_ribuan($d['penggantian']),
				$d['submitted_user_at'],
				$d['checked_by_hr_at'],
				$d['grouped_by_hr_at'],
				$d['approved_divhead_hr_at'],
				$d['sent_to_ap_at'],
				$d['fully_paid_at']
			], ';');
		}

		fclose($output);
		exit(); 
	}

	public function getEmployeeToBalance(){
		$data = $this->master_model->getEmployeeToBalance();
		echo json_encode($data);
	}
	
	public function view_req_mdcr_on_tm($nik='', $no_req=''){
		
		$listMDCR = $this->master_model->view_req_mdcr_on_tm($nik, $no_req);
		// dumper($listMDCR);
		if (!empty($listMDCR)) {
			$no = 1;
			foreach ($listMDCR as $key) {

				$row   = array();
				$row[] = $no;
				$row[] = $key['request_number'];
				$row[] = status_color($key['is_status']);
				$row[] = '<a target="_blank" href="form/view_detail_trans/MDCR/'.encode_url($key['id']).'"><em class="icon ni ni-file-docs"></em></a>';
				$data[] = $row;
				$no++;
			}
			$outputMDCR = array('data' => $data);
		} else {
			$outputMDCR = array('data' => new ArrayObject());
		}
		echo json_encode($outputMDCR);
	}
}
