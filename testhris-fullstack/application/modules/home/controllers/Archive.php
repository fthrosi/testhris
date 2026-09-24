<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archive extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('curl');
        $this->load->library('enc');
        $this->enc->check_session();

        if (!$this->enc->access_user()) {
            $x = base_url();
            redirect($x);
            exit();
        }

        $this->load->helper('general');
        $this->load->helper('ebast');
        $this->load->model('list/m_approval');
        $this->load->model('list/m_ebast');
        $this->load->model('m_global');

        $this->ilink = $this->load->database('db_ilink', TRUE);

        $this->email = $this->session->userdata('user_email');
        $this->access_level = $this->session->userdata('access_level');
        $this->date = date('Y-m-d H:i:s');
        $this->year = date('Y');
        
        if(empty($this->session->userdata('nik'))){
            $this->session->set_flashdata('failure', 'Login failed');
            redirect('login');
        }
    }

    public function index()
    {
        if (!$this->enc->access_user()) {
            $x = base_url();
            redirect($x);
            exit();
        }

        $data['content']  = 'home/archive';
        $this->templates->show('index', 'templates/index', $data);
    }

    public function read_ebast()
    {
    	if ($this->access_level == '99' || $this->access_level == '10') {
    		$listForm = $this->m_approval->getAllEbast();
    	} else {
    		$listForm = $this->m_approval->getArchiveEbast();
    	}
       
        if (!empty($listForm)) {
            foreach ($listForm as $key) {
                $row   = array();
                $row[] = $key->po_number;
                $row[] = $key->request_number;
                $row[] = str_replace('.000', '', $key->created_at);
                $row[] = $key->wbs_id;
                $row[] = $key->category_name .' - '. $key->name;
                $row[] = $key->region;
                $row[] = ebast_status($key->is_status);
                $row[] = '<div class="btn-group btn-group-sm">
                                <a class="btn btn-sm btn-primary" style="cursor:pointer;" href="' . site_url('home/archive/details/' . encode_url($key->id)) . '">
                                    View Details
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

    public function details($id)
    {
        $ebast_id = decode_url($id);

        $data['detail'] = $this->ilink->get_where('ebast', array('id' => $ebast_id))->row_array();
        $data['approval'] = $this->ilink->get_where('ebast_approval', array('ebast_id' => $ebast_id))->result_array();

        $data['milestone'] = $this->ilink->get_where('master_milestone', array('id' => $data['detail']['milestone_id']))->row_array();
        $data['form'] = $this->ilink->get_where('permissions_document', array('milestone_name' => $data['milestone']['name']) )->row_array();

        $data['worktype'] = $this->ilink->get_where('master_worktype', array('id' => $data['detail']['worktype_id']))->row_array();

        $vendor_code = "vcode_old = '" . $data['detail']['vendor_id'] . "' OR vcode_new = '" . $data['detail']['vendor_id'] . "' ";
        $data['vendor'] = $this->ilink->get_where('master_vendor', $vendor_code)->row_array();

        $data['scanned_iw'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'scanned_iw'))->row_array();
        $data['others'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'others'))->row_array();
        $data['boq_final'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'boq_final'))->row_array();
        $data['copy_of_cme'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'copy_of_cme'))->row_array();
        $data['original_bpujl'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'original_bpujl'))->row_array();
        $data['cme_opname_photos'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'cme_opname_photos'))->row_array();
        $data['copy_of_document_final'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'copy_of_document_final'))->row_array();
        $data['ba_stock_opname'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'ba_stock_opname'))->row_array();
        $data['nod'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'nod'))->row_array();
        $data['additional'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'others'))->row_array();
        $data['add_sitac'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'add_sitac'))->row_array();
        $data['bukti_bayar'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'bukti_bayar'))->row_array();
        $data['progress_document'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'progress_document'))->row_array();
        $data['fo_opname_photos'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'fo_opname_photos'))->row_array();
        $data['fo_progress_photos'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'fo_progress_photos'))->row_array();
        $data['generate_boq_final'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'generate_boq_final'))->row_array();
        $data['foto_biaya_koordinasi'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'foto_biaya_koordinasi'))->row_array();
        $data['ktp_kwitansi'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'ktp_kwitansi'))->row_array();
        $data['foto_general'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'foto_generals'))->row_array();
        $data['bamt'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'bamt'))->row_array();


        $data['content']  = 'home/ebast_archive_details';
        $this->templates->show('index', 'templates/index', $data);
    }

}
