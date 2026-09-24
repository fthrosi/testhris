<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ebast extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->load->library('curl');
        $this->load->library('enc');
        $this->enc->check_session();

        $this->email = $this->session->userdata('user_email');
        $this->role = $this->session->userdata('user_role');

        $this->ilink = $this->load->database('db_ilink', TRUE);
        $this->vm = $this->load->database('db_vendor', TRUE);
        $this->imm = $this->load->database('db_imm', TRUE);

        $this->load->helper('general');
        $this->load->helper('ebast');
        $this->load->model('m_ebast');
        $this->load->model('m_global');
        $this->date = date('Y-m-d H:i:s');
        $this->year = date('Y');
    }

    public function index()
    {
        // if (!$this->enc->access_user()) {
        //     $x = base_url();
        //     redirect($x);
        //     exit();
        // }

        if ($this->role == '10' || $this->role == '11') {
        	$data['ebast'] = $this->m_ebast->getEbastListProcurement($this->email);
        } else {
        	$data['ebast'] = $this->m_ebast->getEbastList($this->email);
        }

        $data['content']  = 'list/ebast_list';
        $this->templates->show('index', 'templates/index', $data);
    }

    public function viewRequest()
    {
        $ebast_id = $this->input->post('id');
        $detail_request = $this->m_ebast->find_select("id, request_number, po_number, evaluation_flag, po_created_date, vendor_id, vendor_name, vendor_email, vendor_title, worktype_id, milestone_id, wbs_id, site_id, site_name, region, is_status, created_by, created_at", array('id' => $ebast_id), 'ebast')->row_array();
        $detail_approval = $this->m_ebast->find_select("id, approval_email, approval_priority, approval_status, is_read, updated_at, updated_by", array('ebast_id' => $ebast_id, 'approval_email' => $this->email), 'ebast_approval')->row_array();
        $progress = $this->m_ebast->find_select("approval_email, approval_title, approval_name, approval_priority, approval_note, approval_status, updated_at, updated_by", array('ebast_id' => $ebast_id), 'ebast_approval')->result_array();
        $approval_status = $detail_approval['approval_status'];
        $priority = $detail_approval['approval_priority'];
        $milestone = $this->m_ebast->getOneById("name", 'master_milestone', array('id' => $detail_request['milestone_id']));
        $worktype = $this->m_ebast->getOneById("category_name", 'master_worktype', array('id' => $detail_request['worktype_id']));
        $status = ebast_status_color($detail_request['is_status']);
        $vendor_code = "vcode_old = '" . $detail_request['vendor_id'] . "' OR vcode_new = '" . $detail_request['vendor_id'] . "' ";
        $data_vendor = $this->ilink->get_where('master_vendor', $vendor_code)->row_array();

        if ($approval_status == 'In Progress') {
            $approval_id = $detail_approval['id'];
        } else {
            $approval_id = '0';
        }

        $bast_approve_date = $this->m_ebast->find_select("updated_at", array('ebast_id' => $ebast_id, 'approval_priority' => 2), 'ebast_approval')->row_array();
        if ($bast_approve_date != null) {
            $bast_date = $bast_approve_date;
        } else {
            $bast_date = '-';
        }

        // development flag evaluation
        if (($detail_request['evaluation_flag'] == '1') && ($detail_approval['approval_priority'] == '2')) {
            $evaluation_flag = '1';
            $evaluation_permit = $this->vm->get_where('evaluasi_vendor_permit', array('ebast_id' => $ebast_id))->result_array();
            $count_permit = count($evaluation_permit);
        } else {
            $evaluation_flag = '0';
            $evaluation_permit = "";
            $count_permit = "0";
        }


        // document_upload
        $doc_upload['scanned_iw'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'scanned_iw'))->row_array();
        $doc_upload['boq_final'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'boq_final'))->row_array();
        $doc_upload['copy_of_cme'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'copy_of_cme'))->row_array();
        $doc_upload['original_bpujl'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'original_bpujl'))->row_array();
        $doc_upload['cme_opname_photos'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'cme_opname_photos'))->row_array();
        $doc_upload['copy_of_document_final'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'copy_of_document_final'))->row_array();
        $doc_upload['ba_stock_opname'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'ba_stock_opname'))->row_array();
        $doc_upload['nod'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'nod'))->row_array();
        $doc_upload['additional'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'others'))->row_array();
        $doc_upload['bukti_bayar'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'bukti_bayar'))->row_array();
        $doc_upload['foto_biaya_koordinasi'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'foto_biaya_koordinasi'))->row_array();
        $doc_upload['ktp_kwitansi'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'ktp_kwitansi'))->row_array();
        $doc_upload['foto_general'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'foto_general'))->row_array();
        $doc_upload['fo_progress_photos'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'fo_progress_photos'))->row_array();
        $doc_upload['add_sitac'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'add_sitac'))->row_array();
        $doc_upload['bamt'] = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'bamt'))->row_array();

        // Preview Document
        $form = $this->m_ebast->find('milestone_name', $milestone, 'permissions_document')->row_array();
        $rfi = $this->m_ebast->find('ebast_id', $ebast_id, 'ebast_rfi')->row_array();
        $receipt = $this->ilink->get_where('ebast_receipt', array('ebast_id' => $ebast_id))->result_array();
        $receipt_notes = $this->ilink->get_where('ebast_receipt_notes', array('ebast_id' => $ebast_id))->row_array();
        $wtcr = $this->m_ebast->find('ebast_id', $ebast_id, 'ebast_wtcr')->row_array();
        $boq_final = $this->m_ebast->find('ebast_id', $ebast_id, 'ebast_boq_final')->row_array();

        if ($worktype == 'SITAC' && $milestone == 'RFC') {
            $masa = "6 bulan dari RFC";
        } elseif ($worktype == 'CME' && $milestone == 'BAST 1') {
            $masa = "9 bulan dari BAST 1";
        } elseif ($worktype == 'CME' && $milestone == 'RFI+BAST1') {
            $masa = "9 bulan dari BAST 1";
        } elseif ($worktype == 'COLO/RESELLER/MCP/STRENGTHENING' && $milestone == 'BAST 1') {
            $masa = "3 bulan dari BAST 1";
        } elseif ($worktype == 'COLO/RESELLER/MCP/STRENGTHENING' && $milestone == 'RFI+BAST 1') {
            $masa = "3 bulan dari BAST 1";
        } elseif ($worktype == 'FIBER OPTIC' && $milestone == 'BAST 1') {
            $masa = "6 bulan dari BAST 1";
        } else {
            $masa = "0 bulan";
        }

        header('Content-type: application/json');
        echo json_encode(array(
            "request" => $detail_request,
            "priority" => $priority,
            "vendor" => $data_vendor,
            "approval_id" => $approval_id,
            "progress" => $progress,
            "status" => $status,
            "milestone" => $milestone,
            "worktype" => $worktype,
            "form" => $form,
            "rfi" => $rfi,
            "receipt" => $receipt,
            "receipt_notes" => $receipt_notes,
            "wtcr" => $wtcr,
            "boq" => $boq_final,
            "masa_bast" => $masa,
            "docs" => $doc_upload,
            "bast_date" => $bast_date,
            "evaluation_flag" => $evaluation_flag,
            "evaluation_permit" => $evaluation_permit,
            "count_permit" => $count_permit
        ));
    }

    public function preview($form = "", $id = "")
    {
        switch ($form) {

            case 'rfi':
                $detail_request = $this->m_ebast->find_select("wbs_id, site_name, region", array('id' => $id), 'ebast')->row_array();
                $rpm = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 2 ), 'ebast_approval')->row_array();
                $rfi = $this->ilink->get_where('ebast_rfi', array('ebast_id' => $id))->row_array();

                header('Content-type: application/json');
                echo json_encode(array(
                    "request" => $detail_request,
                    "rfi" => $rfi,
                    "rpm" => $rpm
                ));
                break;

            case 'boq_final':
                $boq = $this->ilink->get_where('ebast_boq_final', array('ebast_id' => $id))->row_array();
                $doc_boq = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $id, 'document_type' => 'generate_boq_final'))->row_array();
                $approval_priority = $this->m_ebast->find_select("approval_priority", array('ebast_id' => $id, 'approval_email' => $this->email), 'ebast_approval')->row_array()['approval_priority'];

                header('Content-type: application/json');
                echo json_encode(array(
                    "boq" => $boq,
                    "doc_boq" => $doc_boq,
                    "approval_priority" => $approval_priority
                ));
                break;

            case 'inventory_opname':
                $data = $this->ilink->get_where('ebast_material_opname', array('ebast_id' => $id))->result_array();
                echo json_encode($data);
                break;

            case 'receipt':
                $detail_request = $this->m_ebast->find_select("vendor_name, vendor_title, vendor_id, wbs_id, site_name, region", array('id' => $id), 'ebast')->row_array();
                $rpm = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 2), 'ebast_approval')->row_array();
                $item = $this->ilink->get_where('ebast_receipt', array('ebast_id' => $id))->result_array();
                $receipt_notes = $this->ilink->get_where('ebast_receipt_notes', array('ebast_id' => $id))->row_array();
                $notes = ($receipt_notes != null) ? $receipt_notes : '';
                $vendor_code = "vcode_old = '" . $detail_request['vendor_id'] . "' OR vcode_new = '" . $detail_request['vendor_id'] . "' ";
                $data_vendor = $this->ilink->get_where('master_vendor', $vendor_code)->row_array();

                header('Content-type: application/json');
                echo json_encode(array(
                    "request" => $detail_request,
                    "rpm" => $rpm,
                    "item" => $item,
                    "notes" => $notes,
                    "vendor" => $data_vendor
                ));
                break;

            case 'wtcr':
                $detail_request = $this->m_ebast->find_select("po_number, vendor_name, vendor_title, worktype_id, vendor_id, wbs_id, site_name, region", array('id' => $id), 'ebast')->row_array();
                $worktype = $this->m_ebast->getOneById("category_name", 'master_worktype', array('id' => $detail_request['worktype_id']));
                $rpm = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 2), 'ebast_approval')->row_array();
                $procurement = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 4), 'ebast_approval')->row_array();
                $wtcr = $this->ilink->get_where('ebast_wtcr', array('ebast_id' => $id))->result_array();
                $vendor_code = "vcode_old = '" . $detail_request['vendor_id'] . "' OR vcode_new = '" . $detail_request['vendor_id'] . "' ";
                $data_vendor = $this->ilink->get_where('master_vendor', $vendor_code)->row_array();

                $approval_priority = $this->m_ebast->find_select("approval_priority", array('ebast_id' => $id, 'approval_email' => $this->email), 'ebast_approval')->row_array()['approval_priority'];

                header('Content-type: application/json');
                echo json_encode(array(
                    "request" => $detail_request,
                    "worktype" => $worktype,
                    "rpm" => $rpm,
                    "procurement" => $procurement,
                    "wtcr" => $wtcr,
                    "vendor" => $data_vendor,
                    "approval_priority" => $approval_priority
                ));
                break;

            case 'bamt':
                $detail_request = $this->m_ebast->find_select("po_number, vendor_name, vendor_title, worktype_id, vendor_id, wbs_id, site_name, region", array('id' => $id), 'ebast')->row_array();
                $vendor_code = "vcode_old = '" . $detail_request['vendor_id'] . "' OR vcode_new = '" . $detail_request['vendor_id'] . "' ";
                $data_vendor = $this->ilink->get_where('master_vendor', $vendor_code)->row_array();
                $rpm = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 2), 'ebast_approval')->row_array();

				$summary = $this->m_ebast->get_summary_imm($id);
				$header = $this->m_ebast->get_summary_imm_header($id);

                header('Content-type: application/json');
                echo json_encode(array(
                    "request" => $detail_request,
                    "rpm" => $rpm,
                    "vendor" => $data_vendor,
                    "summary" => $summary,
                    "header" => $header,
                ));
                break;

            case 'evaluation':
                $detail_request = $this->m_ebast->find_select("po_number, vendor_name, vendor_title, worktype_id, vendor_id, wbs_id, site_name, region", array('id' => $id), 'ebast')->row_array();

                $worktype = $this->m_ebast->getOneById("category_name", 'master_worktype', array('id' => $detail_request['worktype_id']));
                $rpm = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 2), 'ebast_approval')->row_array();
                $procurement = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 4), 'ebast_approval')->row_array();
                $vendor_code = "vcode_old = '" . $detail_request['vendor_id'] . "' OR vcode_new = '" . $detail_request['vendor_id'] . "' ";
                $data_vendor = $this->ilink->get_where('master_vendor', $vendor_code)->row_array();
                
                // $master_checklist = $this->ilink->get('master_checklist_K3')->order_by('id', 'desc')->result_array();
                $this->ilink->from("master_checklist_K3");
                $this->ilink->order_by("id", "desc");
                $query = $this->ilink->get(); 
                $master_checklist = $query->result_array();

                header('Content-type: application/json');
                echo json_encode(array(
                    "request" => $detail_request,
                    "worktype" => $worktype,
                    "rpm" => $rpm,
                    "procurement" => $procurement,
                    "vendor" => $data_vendor,
                    "master_checklist" => $master_checklist
                ));
                break;

            case 'evaluation_proc':
                $detail_request = $this->m_ebast->find_select("po_number, vendor_name, vendor_title, worktype_id, vendor_id, wbs_id, site_name, region", array('id' => $id), 'ebast')->row_array();
                $detail_evaluasi = $this->vm->get_where('evaluasi_vendor', array('ebast_id' => $id))->result_array();

                $worktype = $this->m_ebast->getOneById("category_name", 'master_worktype', array('id' => $detail_request['worktype_id']));
                $rpm = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 2), 'ebast_approval')->row_array();
                $procurement = $this->m_ebast->find_select("approval_title, approval_name", array('ebast_id' => $id, 'approval_priority' => 4), 'ebast_approval')->row_array();
                $vendor_code = "vcode_old = '" . $detail_request['vendor_id'] . "' OR vcode_new = '" . $detail_request['vendor_id'] . "' ";
                $data_vendor = $this->ilink->get_where('master_vendor', $vendor_code)->row_array();
                
                // $master_checklist = $this->ilink->get('master_checklist_K3')->order_by('id', 'desc')->result_array();
                $this->ilink->from("master_checklist_K3");
                $this->ilink->order_by("id", "desc");
                $query = $this->ilink->get(); 
                $master_checklist = $query->result_array();

                header('Content-type: application/json');
                echo json_encode(array(
                    "request" => $detail_request,
                    "evaluasi" => $detail_evaluasi,
                    "worktype" => $worktype,
                    "rpm" => $rpm,
                    "procurement" => $procurement,
                    "vendor" => $data_vendor,
                    "master_checklist" => $master_checklist
                ));
                break;

            default:
                break;
        }
    }

    // testing insert to IMM
    public function save_bamt_report($ebast_id)
    {
        $transok = false;
        $sql1 = "SELECT 
                    a.nod_id as id,
                    a.nod_number,
                    a.po_number,
                    a.material_code,
                    a.material_type,
                    a.total_qty,
                    a.id_detail_table,
                    a.table_detail_name,
                    b.idle_qty,
                    c.waste_qty,
                    d.loss_qty,
                    e.install_qty
                FROM
                    ebast_imm_nod_summary a
                LEFT JOIN ebast_imm_material_idle b ON a.id_detail_table = b.id
                LEFT JOIN ebast_imm_material_waste c ON a.id_detail_table = c.id
                LEFT JOIN ebast_imm_material_loss d ON a.id_detail_table = d.id
                LEFT JOIN ebast_imm_material_install e ON a.id_detail_table = e.id
                WHERE a.ebast_id = '".$ebast_id."'
                ORDER BY a.nod_id";

        $summary = $this->ilink->query($sql1)->result_array();

        // print_r($summary);die;

        $data['ebast'] = $this->ilink->get_where('ebast', array('id' => $ebast_id))->row_array();
        $bamt_print_link = "https://fad.ibstower.com/ilink4/result/generate/result_document/bamt/".encode_url($ebast_id)."/".$data['ebast']['request_number']." ";

        $idle_evidence = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'idle_evidence'))->row_array()['file_path'];
        $waste_evidence = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'waste_evidence'))->row_array()['file_path'];
        $loss_evidence = $this->ilink->get_where('ebast_document_upload', array('ebast_id' => $ebast_id, 'document_type' => 'loss_evidence'))->row_array()['file_path'];

        foreach ($summary as $key => $value) {

            $idle_loc = $this->ilink->get_where('ebast_imm_material_idle_location', array('ebast_id' => $ebast_id, 'nod_id' => $value['id']))->row_array();
            $location_idle = $idle_loc['location'].'__'.$idle_loc['province'].'__'.$idle_loc['city'];

            $date = date("Y-m-d H:i:s");
            $sql2 = "SELECT *
                    FROM
                      add_material_po_fo
                    WHERE
                      id='".$value['id']."' ";
            
            $query2[0] = $this->imm->query($sql2);
            $res2      = $query2[0]->row();
            $nod       = $res2->nod;
            $no_req    = $res2->no_req;
            $id_po     = $res2->id_po;
            
            $sql3 = "SELECT *
                    FROM
                      add_material_fo
                    WHERE
                      id='".$no_req."'";

            $query3[0] = $this->imm->query($sql3);
            $res3      = $query3[0]->row();
            $wbs       = $res3->wbs;
            $material_code = $res3->material_code;
            $no_req2   = $res3->no_req;
            
            $sql4 = "SELECT *
                    FROM
                      req_nod_fo
                    WHERE
                      no_req='".$no_req2."'";

            $query4[0]  = $this->imm->query($sql4);
            $res4       = $query4[0]->row();
            $project    = $res4->project;
            $contractor = $res4->contractor;

            $wbs_element = $data['ebast']['wbs_id'];
            $not_used = substr($wbs_element, strpos($wbs_element, '-', strpos($wbs_element, '-') + 1));
            $wbs_id = str_replace($not_used, "", $wbs_element);
            
            $id_material = $value['id'];

            if ($value['table_detail_name'] == 'ebast_imm_material_idle' && $value['idle_qty'] != '0') {
                
                $status = 'Idle';
                $qty_insert = $value['idle_qty'];

                $query = "INSERT report_material_fo 
                        SET id_add_material_po_fo ='".$id_material."', ebast_id = '".$ebast_id."', location_idle = '".$location_idle."', qty = '".$qty_insert."', qty_use = '".$qty_insert."', nod='".$value['nod_number']."', project1='".$project."', project2='".$project."', wbs1='".$wbs_id."', wbs2='".$wbs_id."', contractor1='".$contractor."', contractor2='".$contractor."', material_code='".$material_code."', id_po='".$id_po."', status='".$status."', file1='".$bamt_print_link."', file2='".$idle_evidence."', date='".$date."', id_ebast_detil='".$value['id_detail_table']."'";

            
            } else if ($value['table_detail_name'] == 'ebast_imm_material_waste' && $value['waste_qty'] != '0') {

                $status = 'Waste';
                $qty_insert = $value['waste_qty'];

                $query = "INSERT report_material_fo 
                        SET id_add_material_po_fo ='".$id_material."', ebast_id = '".$ebast_id."', location_idle = '-', qty = '".$qty_insert."', qty_use = '".$qty_insert."', nod='".$value['nod_number']."', project1='".$project."', project2='".$project."', wbs1='".$wbs_id."', wbs2='".$wbs_id."', contractor1='".$contractor."', contractor2='".$contractor."', material_code='".$material_code."', id_po='".$id_po."', status='".$status."', file1='".$bamt_print_link."', file2='".$waste_evidence."', date='".$date."', id_ebast_detil='".$value['id_detail_table']."'";

            } else if ($value['table_detail_name'] == 'ebast_imm_material_loss' && $value['loss_qty'] != '0') {

                $status = 'Lost';
                $qty_insert = $value['loss_qty'];

                $query = "INSERT report_material_fo 
                        SET id_add_material_po_fo ='".$id_material."', ebast_id = '".$ebast_id."', location_idle = '-', qty = '".$qty_insert."', qty_use = '".$qty_insert."', nod='".$value['nod_number']."', project1='".$project."', project2='".$project."', wbs1='".$wbs_id."', wbs2='".$wbs_id."', contractor1='".$contractor."', contractor2='".$contractor."', material_code='".$material_code."', id_po='".$id_po."', status='".$status."', file1='".$bamt_print_link."', file2='".$loss_evidence."', date='".$date."', id_ebast_detil='".$value['id_detail_table']."'";

            } else if ($value['table_detail_name'] == 'ebast_imm_material_install' && $value['install_qty'] != '0') {

                $status = 'Installed';
                $qty_insert = $value['install_qty'];

                $query = "INSERT report_material_fo 
                        SET id_add_material_po_fo ='".$id_material."', ebast_id = '".$ebast_id."', location_idle = '-', qty = '".$qty_insert."', qty_use = '".$qty_insert."', nod='".$value['nod_number']."', project1='".$project."', project2='".$project."', wbs1='".$wbs_id."', wbs2='".$wbs_id."', contractor1='".$contractor."', contractor2='".$contractor."', material_code='".$material_code."', id_po='".$id_po."', status='".$status."', file1='".$bamt_print_link."', file2='".$loss_evidence."', date='".$date."', id_ebast_detil='".$value['id_detail_table']."'";
            }

            $query = $this->imm->query($query);

            if ($query){

            	$q_update = "UPDATE add_material_po_fo SET status ='Installed' WHERE id ='".$id_material."' ";
            	$update_status = $this->imm->query($q_update);

                //Update log Report
                $sqli   = " SELECT *
                            FROM
                                report_material_fo
                            WHERE
                                status='".$status."'
                            AND 
                                qty='".$qty_insert."'
                            AND
                                id_add_material_po_fo='".$id_material."'
                            ORDER BY id DESC LIMIT 1";
                          
                $queryi[0]  = $this->imm->query($sqli);
                $resr       = $queryi[0]->row();
                $id_report  = $resr->id;
                
                $sqlii  = " SELECT *
                            FROM
                                log_request_nod_fo_ii
                            WHERE
                                id_nod='".$id_material."'";
                          
                $query1[0] = $this->imm->query($sqlii);
                $res        = $query1[0]->row();
                
                if(!empty($res)){
                
                $no_req     = $res->no_req;
                $fabricant  = $res->fabricant;
                $po_number  = $res->po_number;
                $regional   = $res->regional;
                $release    = $res->release_date;
                
                    if($status == 'Installed'){
                        $sqllog = "UPDATE log_request_nod_fo_ii SET qty='".$qty_insert."', report_date = '".$date."', id_parent='".$id_report."' where id_nod = '".$id_material."' and (id_parent = '' or id_parent is NULL)"; 
                        $this->imm->query($sqllog);
                    }else{
                        $sql = "INSERT log_request_nod_fo_ii SET id_nod ='".$id_material."', qty = '".$qty_insert."', nod='".$value['nod_number']."', wbs1='".$wbs_id."', wbs2='".$wbs_id."', material_code='".$material_code."', po_number='".$po_number."', id_parent='".$id_report."', no_req='".$no_req."', fabricant='".$fabricant."', release_date='".$release."', report_date='".$date."', regional='".$regional."'";
                        $this->imm->query($sql);
                    }
                }

                $transok = true;

            } else{
                $transok = false;
            }
        }
        
        if ($transok){

            // $data['email'] = $this->db->get_where('ebast_imm_summary_header', array('ebast_id' => '1236'))->row_array();
            // $email_vendor_1 = $data['email']['email_vendor_1'];
            // $email_vendor_2 = $data['email']['email_vendor_2'];
            // $email_vendor_3 = $data['email']['email_vendor_3'];
            // $email_requestor = $data['email']['email_requestor'];
            // $email_logistik_1 = $data['email']['email_logistik_1'];
            // $email_logistik_2 = $data['email']['email_logistik_2'];
            // $email_logistik_3 = $data['email']['email_logistik_3'];

            // $email_to = "$email_vendor_1,$email_vendor_2, $email_vendor_3, $email_requestor, $email_logistik_1, $email_logistik_2, $email_logistik_3";

            // $this->sendEmail('bamt_notif', $ebast_id, $email_to);

            return true;

        } else{
            return false;
        }
        
    }

    public function test_bamt_notif()
    {
        $ebast_id = '9907';
        $data['email'] = $this->ilink->get_where('ebast_imm_summary_header', array('ebast_id' => '9907'))->row_array();
        $email_vendor_1 = ($data['email']['email_vendor_1']) == '' ? 'momment@ibstower.com' : $data['email']['email_vendor_1'];
        $email_vendor_2 = ($data['email']['email_vendor_2']) == '' ? 'momment@ibstower.com' : $data['email']['email_vendor_2'];
        $email_vendor_3 = ($data['email']['email_vendor_3']) == '' ? 'momment@ibstower.com' : $data['email']['email_vendor_3'];
        $email_requestor = ($data['email']['email_requestor']) == '' ? 'momment@ibstower.com' : $data['email']['email_requestor'];
        $email_logistik_1 = ($data['email']['email_logistik_1']) == '' ? 'momment@ibstower.com' : $data['email']['email_logistik_1'];
        $email_logistik_2 = ($data['email']['email_logistik_2']) == '' ? 'momment@ibstower.com' : $data['email']['email_logistik_2'];
        $email_logistik_3 = ($data['email']['email_logistik_3']) == '' ? 'momment@ibstower.com' : $data['email']['email_logistik_3'];

        $email_to = "$email_vendor_1,$email_vendor_2, $email_vendor_3, $email_requestor, $email_logistik_1, $email_logistik_2, $email_logistik_3";

        if ($this->sendEmail('bamt_notif', $ebast_id, $email_to)) {
            print_r('Email has been sent');
        } else {
            print_r('bamt notif failed.');
        }
    }

    public function preview_bamt_notif() 
    {
        if (!$this->enc->access_user()) {
            $x = base_url();
            redirect($x);
            exit();
        }

        $requestId = '9907';
        $data['detail'] = $this->m_ebast->find_select("*", array('id' => $requestId), 'ebast')->row_array();
        $data['summary'] = $this->m_ebast->get_summary_imm($requestId);
        $data['header'] = $this->m_ebast->get_summary_imm_header($requestId);
        $data['content']  = 'services/email/bamt_notif';
        $this->templates->show('index', 'templates/index', $data);
    }

    public function calculate($type) 
    {
    	switch ($type) {

    		case 'po_penalty':

				$ebast_id = $this->input->post('ebast_id');
				$po_value = str_replace('.', '', $this->input->post('po_value'));
				$job_acceleration_a_2 = intval ($this->input->post('job_acceleration_a_2'));

				if ($job_acceleration_a_2 >= 0) {
					$job_acceleration_a_2 = 0;
				}

				$late_completion = (0.5/100 * $po_value) * $job_acceleration_a_2; 


				$late_completionn = str_replace('-', '', $late_completion);

				$max = $po_value*(10/100);

				if ($late_completionn > $max) {
				 	$late_completionn = $max;
				}

				$dataCalc = array('late_completion' => $late_completionn);

                // print_r($dataCalc);die;

				$update = $this->ilink->where('ebast_id', $ebast_id)->update('ebast_wtcr', array('late_completion' => $late_completionn, 'po_value' => $po_value));

				if ($update) {
					echo json_encode(array('status' => true, 'data' => $dataCalc));
				} else {
					echo json_encode(array('status' => false));
				}
		       
    			break;

            case 'boq_final':

                $ebast_id = $this->input->post('ebast_id');
                $nominal = str_replace('.', '', $this->input->post('nominal'));

                $data = array('nominal_boq' => $nominal);

                $update = $this->ilink->where('ebast_id', $ebast_id)->update('ebast_boq_final', array('nominal_boq' => $nominal, 'updated_at' => $this->date, 'updated_by' => $this->email));

                if ($update) {
                    echo json_encode(array('status' => true, 'data' => $data));
                } else {
                    echo json_encode(array('status' => false));
                }
               
                break;
    		
    		default:
    			break;
    	}

    }

    public function save_form($form_type = "")
    {
        switch ($form_type) {

            case 'wtcr':

                $ebast_id = $this->input->post('id');

                $start_date = $this->input->post('start_date');
                $finish_date = $this->input->post('finish_date');
                $actual_finish_date = $this->input->post('actual_finish_date');

                $reason_raining = $this->input->post('reason_raining');
                $reason_change_sow = $this->input->post('reason_change_sow');
                $reason_discontinuance = $this->input->post('reason_discontinuance');
                $reason_others_a = $this->input->post('reason_others_a');
                $reason_others_a_days = $this->input->post('reason_others_a_days');
                $reason_others_b = $this->input->post('reason_others_b');
                $reason_others_b_days = $this->input->post('reason_others_b_days');
                $reason_others_c = $this->input->post('reason_others_c');
                $reason_others_c_days = $this->input->post('reason_others_c_days');
                $reason_others_d = $this->input->post('reason_others_d');
                $reason_others_d_days = $this->input->post('reason_others_d_days');

                $execution_time = count(array_date($finish_date, $start_date));
                $actual_execution_time = count(array_date($actual_finish_date, $start_date));
                $job_acceleration_a_1 = $execution_time - $actual_execution_time;
                $total_b = $reason_raining + $reason_change_sow + $reason_discontinuance + $reason_others_a_days + $reason_others_b_days + $reason_others_c_days + $reason_others_d_days;

                $job_acceleration_a_2 = $job_acceleration_a_1 + $total_b;

                $data_wtcr = array(
                    'ebast_id' => $ebast_id,
                    'execution_time' => $execution_time,
                    'actual_execution_time' => $actual_execution_time,
                    'job_acceleration_a_1' => $job_acceleration_a_1,
                    'total_b' => $total_b,
                    'job_acceleration_a_2' => $job_acceleration_a_2,
                    'start_date' => $start_date,
                    'finish_date' => $finish_date,
                    'actual_finish_date' => $actual_finish_date,
                    'reason_raining' => $reason_raining,
                    'reason_change_sow' => $reason_change_sow,
                    'reason_discontinuance' => $reason_discontinuance,
                    'reason_others_a' => $reason_others_a,
                    'reason_others_a_days' => $reason_others_a_days,
                    'reason_others_b' => $reason_others_b,
                    'reason_others_b_days' => $reason_others_b_days,
                    'reason_others_c' => $reason_others_c,
                    'reason_others_c_days' => $reason_others_c_days,
                    'reason_others_d' => $reason_others_d,
                    'reason_others_d_days' => $reason_others_d_days
                );

                $check = $this->ilink->where('ebast_id', $ebast_id)->get('ebast_wtcr');

                if ($check->num_rows() > 0) {
                    $this->ilink->where('id', $check->row_array()['id'])->update('ebast_wtcr', array(
                            'ebast_id' => $ebast_id,
                            'execution_time' => $execution_time,
                            'actual_execution_time' => $actual_execution_time,
                            'job_acceleration_a_1' => $job_acceleration_a_1,
                            'total_b' => $total_b,
                            'job_acceleration_a_2' => $job_acceleration_a_2,
                            'start_date' => $start_date,
                            'finish_date' => $finish_date,
                            'actual_finish_date' => $actual_finish_date,
                            'reason_raining' => $reason_raining,
                            'reason_change_sow' => $reason_change_sow,
                            'reason_discontinuance' => $reason_discontinuance,
                            'reason_others_a' => $reason_others_a,
                            'reason_others_a_days' => $reason_others_a_days,
                            'reason_others_b' => $reason_others_b,
                            'reason_others_b_days' => $reason_others_b_days,
                            'reason_others_c' => $reason_others_c,
                            'reason_others_c_days' => $reason_others_c_days,
                            'reason_others_d' => $reason_others_d,
                            'reason_others_d_days' => $reason_others_d_days
                        ));

                    $this->logs('update_wtcr', $ebast_id);
                } else {
                    $this->ilink->insert('ebast_wtcr', $data_wtcr);
                    $this->logs('save_wtcr', $ebast_id);
                }

                echo json_encode(array('status' => true, 'data' => $data_wtcr));
                break;

            case 'evaluation':

                // print_r($this->input->post());die;

                $transok = false;
                $ebast_id = $this->input->post('eval_ebast_id');
                $requestNumber = $this->ilink->get_where('ebast', array('id' => $ebast_id))->row_array()['request_number'];

                $path =  getcwd() . '/upload/vendor_evaluation/' . $requestNumber . '/';

                if (!is_dir('upload/vendor_evaluation/' . $requestNumber . '/')) {
                    mkdir('./upload/vendor_evaluation/' . $requestNumber . '/', 0777, TRUE);
                }

                $time = $_FILES['fo_criteria_time']['name'];
                $fileNameTime = preg_replace("/[^A-Z0-9._-]/i", "_", $time);
                $new_filename_time = date('Y-m-d').'_'.$fileNameTime;

                $tempFileTime = $_FILES['fo_criteria_time']['tmp_name'];
                $targetFile = $path . $new_filename_time;                        

                if (move_uploaded_file($tempFileTime, $targetFile)) {
                    $transok = true;
                }

                $quality = $_FILES['fo_criteria_quality']['name'];
                $fileNamequality = preg_replace("/[^A-Z0-9._-]/i", "_", $quality);
                $new_filename_quality = date('Y-m-d').'_'.$fileNamequality;

                $tempFilequality = $_FILES['fo_criteria_quality']['tmp_name'];
                $targetFilequality = $path . $new_filename_quality;                        

                if (move_uploaded_file($tempFilequality, $targetFilequality)) {
                    $transok = true;
                }

                // print_r($transok);die;

                $data_eval = array(
                    'ebast_id' => $ebast_id,
                    'vendor_code' => $this->input->post('eval_vendor_code'),
                    'project_manager' => $this->input->post('eval_rpm'),
                    'project_name' => $this->input->post('eval_project_name'),
                    'worktype' => $this->input->post('eval_worktype'),
                    'po_number' => $this->input->post('eval_po_number'),
                    'wbs_id' => $this->input->post('eval_wbs'),
                    'region' => $this->input->post('eval_regional'),
                    'site_name' => $this->input->post('eval_site_name'),
                    'achievement_value' => $this->input->post('eval_achievement'),
                    'quality_value' => $this->input->post('eval_quality'),
                    'safety_value' => $this->input->post('eval_safety'),
                    'k3_penilaian_1' => $this->input->post('input_penilaian-1'),
                    'k3_penilaian_2' => $this->input->post('input_penilaian-2'),
                    'k3_penilaian_3' => $this->input->post('input_penilaian-3'),
                    'k3_penilaian_4' => $this->input->post('input_penilaian-4'),
                    'k3_total_penilaian_1' => $this->input->post('total_penilaian-1'),
                    'k3_total_penilaian_2' => $this->input->post('total_penilaian-2'),
                    'k3_total_penilaian_3' => $this->input->post('total_penilaian-3'),
                    'k3_total_penilaian_4' => $this->input->post('total_penilaian-4'),
                    'eval_remarks_time' => $this->input->post('eval_remarks_time'),
                    'eval_remarks_quality' => $this->input->post('eval_remarks_quality'),
                    'rfs_based_on_kom' => $this->input->post('rfs_start_date'),
                    'rfs_actual_date' => $this->input->post('rfs_end_date'),
                    'wtcr_start_date' => $this->input->post('wtc_start_date'),
                    'wtcr_finish_date' => $this->input->post('wtc_end_date'),
                    'file_time_criteria' => $targetFile,
                    'file_quality_criteria' => $targetFilequality,
                    'created_by' => $this->email,
                    'created_at' => $this->date,
                );

                if ($this->vm->insert('evaluasi_vendor', $data_eval)) {

                    $this->ilink->where('id', $ebast_id)->update('ebast', array('evaluation_flag' => '2'));
                    $this->ilink->insert('logs', array('trans_id' => $ebast_id, 'activity' => 'Save Evaluation Form', 'description' => 'Success', 'created_by' => $this->email,'created_at' => $this->date));
                }

                echo json_encode(array('status' => true));
                break;

            case 'evaluation_permit_date':

                $ebast_id = $this->input->post('ebast_id');

                $data_permit = array(
                    'ebast_id' => $ebast_id,
                    'permit_name' => $this->input->post('permit_name'),
                    'permit_start' => $this->input->post('permit_start'),
                    'permit_end' => $this->input->post('permit_end'),
                    'created_by' => $this->email,
                    'created_at' => $this->date,
                );

                if ($this->vm->insert('evaluasi_vendor_permit', $data_permit)) {
                    $permit_id = $this->vm->insert_id();
                    $this->ilink->insert('logs', array('trans_id' => $ebast_id, 'activity' => 'Save Evaluation Permit', 'description' => 'Success', 'created_by' => $this->email,'created_at' => $this->date));
                }

                echo json_encode(array('status' => true, 'permit_id' => $permit_id));
                break;

            case 'evaluation_permit_del':

                $ebast_id = decode_url($this->input->post('ebast_id'));

                if ($this->vm->where('id', $this->input->post('permit_id'))->delete('evaluasi_vendor_permit')) {
                    $this->logs('permit_delete', $ebast_id);
                    $response = array('status' => 1, 'messages' => 'Delete item succesfully.');
                } else {
                    $this->logs('system', $ebast_id, 'Failed while deleting receipt form data');
                    $response = array('status' => 0, 'messages' => 'Delete item failed.');
                }

                echo json_encode($response);
                break;

            default:
                break;
        }
    }

    // public function responseRequest($response)
    // {
    //     $output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
    //     $request_id = $this->input->post('id');
    //     $approval_id = $this->input->post('approval_id');
    //     $requestor = $this->input->post('requestor');
    //     $notes = $this->input->post('note');

    //     $data_response = array(
    //         'approval_status' => $response,
    //         'approval_note' => $notes,
    //         'updated_at' => $this->date,
    //         'updated_by' => $this->email
    //     );

    //     switch ($response) {
    //         case 'Revised':

    //             if ($this->ilink->where('id', $approval_id)->update('ebast_approval', $data_response)) {

    //                 $progress = $this->m_ebast->find_select("approval_email, approval_priority, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();

    //                 if ($this->ilink->where('id', $request_id)->update('ebast', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

    //                     // $this->sendEmail('revise', $request_id, $requestor);
    //                     $this->logs('revise', $request_id, $notes);
    //                     $progress = $this->m_ebast->find_select("approval_email, approval_name, approval_priority, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();
    //                     $output = array('status' => 1, 'request_status' => ebast_status_color(4), 'progress' => $progress);
    //                 }
    //             }

    //             break;

    //         default:
    //             break;
    //     }

    //     echo json_encode($output);
    // }

    public function response($response)
    {
        $output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
        $request_id = $this->input->post('id');
        $approval_id = $this->input->post('approval_id');
        $requestor = $this->input->post('requestor');
        $notes = $this->input->post('note');
        $data_response = array('approval_note' => $notes,'updated_at' => $this->date,'updated_by' => $this->email);

        switch ($response) {

            case 'revise_vendor':

                $data_response['approval_status'] = 'Revised';

                if ($this->ilink->where('id', $approval_id)->update('ebast_approval', $data_response)) {

                    if ($this->ilink->where('id', $request_id)->update('ebast', array('is_status' => 4, 'updated_by' => $this->email, 'updated_at' => $this->date))) {

                        // $this->sendEmail('revise', $request_id, $requestor);
                        $this->logs($response, $request_id, $notes);
                        $progress = $this->m_ebast->find_select("approval_email, approval_name, approval_priority, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();
                        $output = array('status' => 1, 'request_status' => ebast_status_color(4), 'progress' => $progress);
                    }
                }

                break;

            case 'revise_rpm':

                $data_response['approval_status'] = 'Revised to RPM';

                $id_rpm = $this->m_ebast->find_select("id", array('ebast_id' => $request_id, 'approval_priority' => 2), 'ebast_approval')->row_array()['id'];
                $email_rpm = $this->m_ebast->find_select("approval_email", array('id' => $id_rpm, 'approval_priority' => 2), 'ebast_approval')->row_array()['approval_email'];

                if ($this->ilink->where('id', $approval_id)->update('ebast_approval', $data_response)) {

                    $status_rpm = array('approval_status' => 'In Progress','updated_at' => $this->date,'updated_by' => $this->email);

                    if ($this->ilink->where('id', $id_rpm)->update('ebast_approval', $status_rpm)) {

                        $this->sendEmail('revise_internal', $request_id, $email_rpm);
                        $this->logs($response, $request_id, $notes);
                        $progress = $this->m_ebast->find_select("approval_email, approval_name, approval_priority, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();
                        $output = array('status' => 1, 'request_status' => ebast_status_color(2), 'progress' => $progress);
                    }
                }

                break;

            case 'rollback_ebast':

                $data_response['approval_status'] = 'Rollback';

                $id_pic = $this->m_ebast->find_select("id", array('ebast_id' => $request_id, 'approval_priority' => 1), 'ebast_approval')->row_array()['id'];
                $email_pic = $this->m_ebast->find_select("approval_email", array('id' => $id_pic, 'approval_priority' => 1), 'ebast_approval')->row_array()['approval_email'];

                if ($this->ilink->where('id', $approval_id)->update('ebast_approval', $data_response)) {

                    $status_pic = array('approval_status' => 'In Progress','updated_at' => $this->date,'updated_by' => $this->email);

                    if ($this->ilink->where('id', $id_pic)->update('ebast_approval', $status_pic)) {

                        $this->sendEmail('revise_internal', $request_id, $email_pic);
                        $this->logs($response, $request_id, $notes);
                        $progress = $this->m_ebast->find_select("approval_email, approval_name, approval_priority, approval_status", array('ebast_id' => $request_id), 'ebast_approval')->result_array();
                        $output = array('status' => 1, 'request_status' => ebast_status_color(2), 'progress' => $progress);
                    }
                }

                break;

            default:
                break;
        }

        echo json_encode($output);
    }

    public function logs($type, $id, $message = '')
    {
        $log['request_id'] = $id;
        $log['form_type'] = 'E-BAST';
        $log['created_by'] = ($type == 'system') ? 'system' : $this->email;
        $log['created_at'] = $this->date;

        switch ($type) {

            case 'is_read':
                $log['description'] = 'View request E-BAST';
                $log['activity'] = 'View';
                $this->db->insert('logs', $log);
                break;

            case 'submit_evaluation':
                $log['description'] = 'Success';
                $log['activity'] = 'Submit Evaluation Vendor';
                $this->db->insert('logs', $log);
                break;

            case 'revise_vendor':
                $log['description'] = $message;
                $log['activity'] = 'Revised to Vendor';
                $this->db->insert('logs', $log);
                break;

            case 'revise_rpm':
                $log['description'] = $message;
                $log['activity'] = 'Revised to RPM';
                $this->db->insert('logs', $log);
                break;

            case 'rollback_ebast':
                $log['description'] = $message;
                $log['activity'] = 'Rollback';
                $this->db->insert('logs', $log);
                break;

            case 'update_wtcr':
                $log['description'] = $message;
                $log['activity'] = 'Update WTCR';
                $this->db->insert('logs', $log);
                break;

            case 'save_wtcr':
                $log['description'] = $message;
                $log['activity'] = 'Save WTCR';
                $this->db->insert('logs', $log);
                break;

            case 'permit_delete':
                $log['description'] = $message;
                $log['activity'] = 'Delete Evaluation Permit Item';
                $this->db->insert('logs', $log);
                break;

            default:
                break;
        }
    }

    public function sendEmail($type, $requestId, $email_to)
    {
        $request_number = $this->m_ebast->find_select("request_number", array('id' => $requestId), 'ebast')->row_array()['request_number'];
        $data['detail'] = $this->m_ebast->find_select("*", array('id' => $requestId), 'ebast')->row_array();
        $data['approval'] = $this->m_ebast->find_select("*", array('ebast_id' => $requestId), 'ebast_approval')->result_array();
        $data['email'] = $email_to;
        

        if ($type == 'revise') {
            $html = $this->load->view('services/email/ebast_revise', $data, TRUE);
            $email_subject = $request_number;
        } elseif ($type == 'approved') {
            $html = $this->load->view('services/email/ebast_approved', $data, TRUE);
            $email_subject = $request_number;
        } elseif ($type == 'reject') {
            $html = $this->load->view('services/email/ebast_reject', $data, TRUE);
            $email_subject = $request_number;
        } elseif ($type == 'revise_internal') {
            $html = $this->load->view('services/email/ebast_revise_internal', $data, TRUE);
            $email_subject = $request_number;
            
        } elseif ($type == 'bamt_notif') {
            $data['summary'] = $this->m_ebast->get_summary_imm($requestId);
            $data['header'] = $this->m_ebast->get_summary_imm_header($requestId);
            $html = $this->load->view('services/email/bamt_notif', $data, TRUE);
            $email_subject = '[Test] BAMT Approved - '.$request_number;
        }

        $url = 'https://api.ibstower.com/email_service';
        $params = array(
            'app_name'      => 'E-BAST',
            'ip_address'    => $_SERVER['SERVER_ADDR'],
            'email_to'      => $email_to,
            'email_subject' => $email_subject,
            'email_content' => $html,
            'is_status'     => 0,
            'created_at'    => $this->date,
            'created_by'    => $this->email
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
        return true;
    }

    public function scan()
    {
        $id = $this->input->post('id');
        $requestNumber = $this->m_ebast->find('id', $id, 'form_request')->row_array()['requestNumber'];
        $status = $this->m_ebast->find('id', $id, 'form_request')->row_array()['is_status'];

        $dir =  './upload/' . $requestNumber . '/supporting_files/';
        $path =  '/upload/' . $requestNumber . '/supporting_files/';
        $response = $this->doScan($dir);

        header('Content-type: application/json');
        echo json_encode(array(
            "id" => $id,
            "flag" => $status,
            "items" => $response
        ));
    }

    private function doScan($dir)
    {

        $files = array();
        // Is there actually such a folder/file?

        if (file_exists($dir)) {
            foreach (scandir($dir) as $f) {

                if (!$f || $f[0] == '.') {
                    continue; // Ignore hidden files
                }

                if (is_dir($dir . '/' . $f)) {
                    // The path is a folder
                    $files[] = array(
                        "name" => $f,
                        "type" => "folder",
                        "path" => $dir . '/' . $f,
                        "items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
                    );
                } else {
                    // It is a file
                    $files[] = array(
                        "name" => $f,
                        "type" => "file",
                        "path" => $dir . '/' . $f,
                        "size" => filesize($dir . '/' . $f) // Gets the size of this file
                    );
                }
            }
        }

        return $files;
    }
}
