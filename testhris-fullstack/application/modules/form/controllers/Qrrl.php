<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qrrl extends Admin_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('m_global');
		$this->load->model('form_model');
    }

    public function index($request_id = null){
        $id = decrypt($request_id);
		dumper($id);
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
    public function info($request_id = null){
        $id = decryptURL($request_id);
		$resign = $this->m_global->find('exit_clearance_resignation_letters', 'id', $id)->row_array();
		
		$form = $this->m_global->find('form_request', 'id', $resign['id_form_request'])->row_array();
		//dumper($form);
		$employee = $this->form_model->get_data_employee($form['employee_id']);
		// dumper($employee[0]->id_employee);
		if (!$resign) {
			show_404();
		}
		$data['request_id'] = $form['request_number'];
		$data['nama'] = decrypt($employee[0]->complete_name);
		$data['nik'] = $form['employee_id'];
		$data['tanggal_submit'] = date('d F Y', strtotime($resign['submitted_at']));
		
		return $this->load->view('form/exit_clearance/view_qrcode', $data);
    }
	/////////// END ///////////
}