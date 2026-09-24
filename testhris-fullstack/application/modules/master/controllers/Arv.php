<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arv extends Admin_Controller
{
	function __construct()
	{
        parent::__construct();
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
		// $this->load->library('curl');
		$this->load->library('email');
		$this->load->library('enc');
		// $this->enc->check_session();

		$this->email = $this->session->userdata('user_email');
		//dumper($this->email);
		$this->emp_id = $this->session->userdata('employee_id');
		$this->emp_nik = $this->session->userdata('nik');
		$this->emp_name = $this->session->userdata('employee_name');
		$this->emp_grade = $this->session->userdata('employee_group');

		$this->load->helper('general');
		$this->load->model('master/master_model');
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('form/form_model');
		$this->load->model('inbox/inbox_model');
		$this->load->model('home/home_model');
		$this->load->model('m_global');
		$this->load->model('services/m_services');

		if (empty($this->session->userdata('nik'))) {
			$this->session->set_flashdata('failure', 'Login failed');
			redirect('login');
		}
        
    }

    public function index(){
		$data['count_mysubmission'] = count($this->home_model->getMySubmissionList());
		$data['count_approval'] = count($this->inbox_model->getApprovalList());
		$data['count_need_mdcr_cek'] = count($this->inbox_model->getApprovalListMDCRCek());
		$data['count_need_mdcr_after_cek'] = count($this->inbox_model->getApprovalListMDCRAfterCek());
		$data['count_mdcr_after_grouping_need_approved'] = count($this->inbox_model->getReqMDCRAfterGroupingNeedApproved());
		$data['count_review'] = count($this->inbox_model->getReviewList());
		$data['count_pa_mgmt'] = count($this->inbox_model->getPAList());
		$data['InfoEmployee'] = $this->dashboard_model->InfoEmployee();
		$data['formType'] = $this->form_model->getFormType();
		$data['content'] = 'master/arv_view';
		$this->templates->show('index', 'templates/eapp/eapp_main', $data);
    }
	
	public function read($table){

		switch ($table) {

				case 'arv':
					$listTO = $this->master_model->getARV();
					if (!empty($listTO)) {
						$no=1;
						foreach ($listTO as $key) {

							$row   = array();
							$row[] = $no;
							$row[] = $key->version_number;
							$row[] = $key->os;
							$row[] = $key->release_date;
							$row[] = $key->vdd;
							
							if($key->status == 1){
								if($this->session->userdata('access_level') == '7' || $this->emp_nik == '20180026' || $this->emp_nik == '20180076'){
									$row[] = '<div class="btn-group btn-group-sm ">
												<a class="btn btn-icon btn-trigger" target="_blank" rel="noopener noreferrer" href="'.base_url().'assets/master/apps/'.$key->link.'">
												<em class="icon ni ni-download"></em>
												</a>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<a class="text-danger btn btn-icon btn-trigger" id="'.$key->id.'" onClick="delete_apps_version('.$key->id.', '."'$key->link'".')">
												<em class="icon ni ni-cross-circle"></em>
										</div>
										';
								}else{
									$row[] = '<div class="btn-group btn-group-sm">
												<a target="_blank" rel="noopener noreferrer" href="'.base_url().'assets/master/apps/'.$key->link.'">
												<em class="icon ni ni-download"></em>
												</a>
										</div>
										';
								}
							}else{
								$row[] = 'Inactive';
							}
							
							$no++;
							$data[] = $row;
						}
						$outputTO = array('data' => $data);
					} else {
						$outputTO = array('data' => new ArrayObject());
					}
					echo json_encode($outputTO);
					break;


				default:
				break;
		}

	}

	public function save_file_application_versions(){
		$config = [
			'upload_path' => './assets/master/apps/',
			'allowed_types' => '*'
		];
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->upload->do_upload('upload_application');
		
		$file = $this->upload->data();
		$file_pattern = $file['file_name'];
		$file_type = strtolower(pathinfo($file_pattern,PATHINFO_EXTENSION));

		if(($_FILES['upload_application']['error'] == 0)){
			// unlink('./assets/documents/documents_hris/' . $file_pattern);
			$data = $file_pattern;
		} else if(($_FILES['upload_application']['error'] == 1) || ($_FILES['upload_application']['error'] == 2)){
			$data = 0;
		} else if (($_FILES['upload_application']['error'] == 3)){
			$data = 1;
		} else if (($_FILES['upload_application']['error'] == 6)){
			$data = 2;
		} else if (($_FILES['upload_application']['error'] == 7)){
			$data = 3;
		} else {
			$data = 5;
		}
		// if($file_type != 'csv'){
		// 	$data = 4;
		// }

		echo json_encode($data);
	}

	public function save_application_versions(){
		$file_name 			= $_POST['file_name'];
		$versions_numbers 	= $_POST['versions_numbers'];
		$operating_system 	= $_POST['operating_system'];
		$vdd 				= $_POST['vdd'];

		$data 	= $this->master_model->save_application_versions($file_name, $versions_numbers, $operating_system, $vdd);

		echo json_encode($data);
	}

	public function DeleteARV(){
		$id = $_POST['id'];
		$file = $_POST['file'];
		$data = $this->master_model->delete_application_versions($id, $file);
		echo json_encode($data);
	}


}