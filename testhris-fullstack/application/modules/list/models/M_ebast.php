<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ebast extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('general');
        $this->user = $this->session->userdata('user_name');
        $this->email = $this->session->userdata('user_email');
        $this->date = date('Y-m-d H:i:s');
        $this->year = date('Y');
        $this->ilink = $this->load->database('db_ilink', TRUE);
        $this->imm = $this->load->database('db_imm', TRUE);
    }

    public function getEbastListProcurement($email)
    {
        $data = array();
        $this->ilink->where('approval_email', $email);
        $this->ilink->where("approval_status == 'In Progress' ");
        $this->ilink->order_by('id', 'ASC');
        $ebast = $this->ilink->get('ebast_approval')->result_array();

        print_r($ebast);die;

        if (!empty($ebast)) {

            foreach ($ebast as $key => $value) {
                $ebast_id = $value['ebast_id'];
                $list[] = $ebast_id;
            }

            $listApproval = implode("','", $list);
            $listEbast = $this->getEbastProcurement($listApproval);
            return $listEbast;
            
        } else {
            return $data;
        }
    }

    public function getEbastList($email)
    {
        $data = array();
        $this->ilink->where('approval_email', $email);
        $this->ilink->where('approval_status', 'In Progress');
        $this->ilink->order_by('id', 'ASC');
        $ebast = $this->ilink->get('ebast_approval')->result_array();

        if (!empty($ebast)) {

            foreach ($ebast as $key => $value) {
                $ebast_id = $value['ebast_id'];
                $list[] = $ebast_id;
            }

            $listApproval = implode("','", $list);
            $listEbast = $this->getEbast($listApproval);
            return $listEbast;
            
        } else {
            return $data;
        }
    }

    public function getEbast($listId = '')
    {
        $this->ilink->select("id, request_number, po_number, vendor_id, vendor_name, vendor_email, vendor_title, worktype_id, milestone_id, wbs_id, site_id, site_name, region, is_status, created_at, created_by");
        $this->ilink->where("id IN ('$listId') ");
        $this->ilink->where("is_status", '2');
        // $this->ilink->where("is_status !=", '3');
        // $this->ilink->where("is_status !=", '5');
        // $this->ilink->where("is_status !=", '6');
        $this->ilink->order_by('created_at', 'DESC');
        return $this->ilink->get('ebast')->result();
    }

    public function getEbastProcurement($listId = '')
    {
        $this->ilink->select("id, request_number, po_number, vendor_id, vendor_name, vendor_email, vendor_title, worktype_id, milestone_id, wbs_id, site_id, site_name, region, is_status, created_at, created_by");
        $this->ilink->where("id IN ('$listId') ");
        $this->ilink->where("is_status !=", '1');
        // $this->ilink->where("is_status !=", '3');
        // $this->ilink->where("is_status !=", '5');
        // $this->ilink->where("is_status !=", '6');
        $this->ilink->order_by('created_at', 'DESC');
        return $this->ilink->get('ebast')->result();
    }

    public function getOneById($field, $table, $where = null)
    {
        return $this->ilink->select($field)->where($where)->get($table)->row_array()[$field];
    }

    public function find($field = '', $value = '', $table, $order_by = '', $order_type = '')
    {
        if ($field != '' && $value != '') {
            $this->ilink->where($field, $value);
        }

        if ($order_by != '') {
            if ($order_type != '') {
                $this->ilink->order_by($order_by, $order_type);
            } else {
                $this->ilink->order_by($order_by, 'ASC');
            }
        }

        return $this->ilink->get($table);
    }

    public function find_select($select, $where = '', $table)
    {
        $this->ilink->select($select);
        if ($where != '') {
            $this->ilink->where($where);
        }
        return $this->ilink->get($table);
    }

    public function checkApproval($id, $email)
    {
        return $this->ilink->get_where('ebast_approval', array('ebast_id' => $id, 'approval_email' => $email))->row_array();
    }

    public function get_summary_imm_header($ebast_id)
    {
        $this->ilink->where('ebast_id', $ebast_id);
        return $this->ilink->get('ebast_imm_summary_header')->row_array();
    }

    public function get_summary_imm($ebast_id)
    {
        $sql = "SELECT
                    a.nod_id AS nod,
                    a.nod_number,
                    a.po_number,
                    a.material_code,
                    a.material_type,
                    a.total_qty,
                    ISNULL((total_idle.idle), 0) AS total_idle,
                    ISNULL((total_waste.waste), 0) AS total_waste,
                    ISNULL((total_loss.loss), 0) AS total_loss,
                    ISNULL((total_install.install), 0) AS total_install
                FROM
                    ebast_imm_nod_summary a
                LEFT JOIN (
                    SELECT
                        nod_id,
                        SUM (idle_qty) idle
                    FROM
                        ebast_imm_material_idle
                    GROUP BY
                        nod_id
                ) AS total_idle ON a.nod_id = total_idle.nod_id
                LEFT JOIN (
                    SELECT
                        nod_id,
                        SUM (waste_qty) waste
                    FROM
                        ebast_imm_material_waste
                    GROUP BY
                        nod_id
                ) AS total_waste ON a.nod_id = total_waste.nod_id
                LEFT JOIN (
                    SELECT
                        nod_id,
                        SUM (loss_qty) loss
                    FROM
                        ebast_imm_material_loss
                    GROUP BY
                        nod_id
                ) AS total_loss ON a.nod_id = total_loss.nod_id
                LEFT JOIN (
                    SELECT
                        nod_id,
                        SUM (install_qty) install
                    FROM
                        ebast_imm_material_install
                    GROUP BY
                        nod_id
                ) AS total_install ON a.nod_id = total_install.nod_id
                
                GROUP BY
                    a.nod_id,
                    total_waste.waste,
                    total_idle.idle,
                    total_loss.loss, 
                    total_install.install, 
                    a.nod_number,
                    a.po_number,
                    a.total_qty,
                    a.material_code,
                    a.material_type";

        return $this->ilink->query($sql)->result_array();
    }

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
            return true;
        } else{
            return false;
        }
        
    }

}
