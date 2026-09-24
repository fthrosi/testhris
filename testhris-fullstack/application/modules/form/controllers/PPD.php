<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PPD extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('curl');
        // $this->load->library('enc');
        // $this->enc->check_session();

        // if (!$this->enc->access_user()) {
        //  $x = base_url();
        //  redirect($x);
        //  exit();
        // }
        
        $this->load->helper('general');
        $this->load->model('m_global');
        $this->load->model('form_model');
        $this->load->model('ppd_model');

        $this->division = $this->session->userdata('division');
        $this->email = $this->session->userdata('user_email');
        $this->emp_id = $this->session->userdata('nik');
        $this->date = date('Y-m-d H:i:s');
        $this->year = date('Y');
    }

    // Class HO
    // class 1 = FGHIJKL = div. head
    // class 2 = DE      = director terkait / c-level
    // class 3 = ABC     = CEO

    private function getClassHO($grade)
    {
        switch ($grade) {

            case 'GOL A':
                $position = 'DIRECTOR';
                $class = '3';
                break;

            case 'GOL B':
                $position = 'DIRECTOR';
                $class = '3';
                break;

            case 'GOL C':
                $position = 'DIRECTOR';
                $class = '3';
                break;

            case 'GOL D':
                $position = 'DIVHEAD';
                $class = '2';
                break;

            case 'GOL E':
                $position = 'DIVHEAD';
                $class = '2';
                break;

            case 'GOL F':
                $position = 'DEPTHEAD';
                $class = '1';
                break;

            case 'GOL G':
                $position = 'DEPTHEAD';
                $class = '1';
                break;

            case 'GOL H':
                $position = 'SECTIONHEAD';
                $class = '1';
                break;

            case 'GOL I':
                $position = 'ASSTMAN';
                $class = '1';
                break;

            case 'GOL J':
                $position = 'SPV';
                $class = '1';
                break;

            case 'GOL K':
                $position = 'SENIORSTAFF';
                $class = '1';
                break;

            case 'GOL L':
                $position = 'STAFF';
                $class = '1';
                break;
            
            default:
                // code...
                break;
        }

        return $class;
    }

    // Class REGIONAL
    // class 1 = FG    = div. head
    // class 2 = HIJKL = RPM

    private function getClassRegional($grade)
    {
        switch ($grade) {

            case 'GOL F':
                $position = 'RPM';
                $class = '1';
                break;

            case 'GOL G':
                $position = 'RPM';
                $class = '1';
                break;

            case 'GOL H':
                $position = 'KOORDINATOR';
                $class = '2';
                break;

            case 'GOL I':
                $position = 'KOORDINATOR';
                $class = '2';
                break;

            case 'GOL J':
                $position = 'KOORDINATOR';
                $class = '2';
                break;

            case 'GOL K':
                $position = 'PIC';
                $class = '2';
                break;

            case 'GOL L':
                $position = 'PIC';
                $class = '2';
                break;
            
            default:
                // code...
                break;
        }

        return $class;
    }

    public function getBankAccount()
    {
        $nik = $this->input->post('nik');
        $bank = $this->input->post('bank');

        $this->db->limit(1);
        $this->db->where('nik', $nik);
        $this->db->order_by('id_employee', 'DESC');
        $employee = $this->db->get('hris_employee')->row_array();

        if (!empty($employee)) {

            switch ($bank) {

                case 'BSM':
                    $acc_number = decrypt($employee['bankn']);
                    $acc_name = decrypt($employee['emftx']);
                    break;

                case 'MDR':
                    $acc_number = decrypt($employee['bankn1']);
                    $acc_name = decrypt($employee['emftx1']);
                    break;

                default:
                    break;
            }

            $response = array('status' => true, 'acc_number' => $acc_number, 'acc_name' => $acc_name);

        } else {
            $response = array('status' => false, 'message' => 'Data not found. Please contact HR or IT.');
        }

        echo json_encode($response);
    }

    private function getLayer1($location, $class, $nik)
    {
        $this->db->limit(1);
        $this->db->where('nik', $nik);
        $this->db->order_by('id_employee', 'DESC');
        $row_employee = $this->db->get('hris_employee')->row_array();
        $layer_1 = '';

        // usrid_long5 = rpm
        // usrid_long2 = dept head
        // usrid_long1 = superior
        // usrid_long3 = div head
        // usrid_long4 = director

        switch ($location) {

            case 'HO':
                
                if ($class === '1') {
                    $layer_1 = strtolower(decrypt($row_employee['usrid_long3'])); // div.head
                } else if ($class === '2') {
                    $layer_1 = strtolower(decrypt($row_employee['usrid_long4'])); // director
                } else if ($class === '3') {
                    $layer_1 = strtolower(decrypt($row_employee['usrid_long4'])); // director
                }
                break;

            case 'Regional':
                
                if ($class === '1') {
                    $layer_1 = strtolower(decrypt($row_employee['usrid_long3'])); // div.head
                } else if ($class === '2') {
                    $layer_1 = strtolower(decrypt($row_employee['usrid_long5'])); // RPM
                } 
                break;
            
            default:
                break;
        }

        return $layer_1;
    }

    public function save($method, $formType = "")
    {

        switch ($method) {

            case 'ppd_draft':

                $detailok = false;
                $request_id = $this->input->post('request_id');
                $id_header = $this->input->post('id_header');

                $detail = array(
                    'header_id'=> $id_header,
                    'beban_pt'=> $this->input->post('beban_pt'),
                    // 'required_date'=> $this->input->post('required_date'),
                    'email_pejalan_dinas'=> $this->input->post('email_pejalan_dinas'),
                    'nama_pejalan_dinas'=> $this->input->post('nama_pejalan_dinas'),
                    'cost_center'=> $this->input->post('cost_center'),
                    'requestor_nik'=> $this->input->post('employee_nik'),
                    'posisi'=> $this->input->post('employee_position'),
                    'divisi'=> $this->input->post('employee_division'),
                    'kota_tujuan'=> $this->input->post('kota_tujuan'),
                    'kota_berangkat'=> $this->input->post('kota_berangkat'),
                    'tgl_berangkat'=> $this->input->post('tgl_berangkat'),
                    'tgl_kembali'=> $this->input->post('tgl_kembali'),
                    'waktu_berangkat'=> $this->input->post('waktu_berangkat'),
                    'waktu_kembali'=> $this->input->post('waktu_kembali'),
                    'x_diem'=> $this->input->post('x_diem'),
                    'nominal_diem'=> $this->input->post('nominal_diem'),
                    'total_diem'=> $this->input->post('total_diem'),
                    'x_hotel'=> $this->input->post('x_hotel'),
                    'nominal_hotel'=> $this->input->post('nominal_hotel'),
                    'total_hotel'=> $this->input->post('total_hotel'),
                    'x_transport'=> $this->input->post('x_transport'),
                    'nominal_transport'=> $this->input->post('nominal_transport'),
                    'total_transport'=> $this->input->post('total_transport'),
                    'x_lain_lain'=> $this->input->post('x_lain_lain'),
                    'nominal_lain_lain'=> $this->input->post('nominal_lain_lain'),
                    'total_lain_lain'=> $this->input->post('total_lain_lain'),
                    'tujuan_keperluan'=> $this->input->post('tujuan_keperluan'),
                    'currency'=> $this->input->post('currency'),
                    'specific_location'=> $this->input->post('specific_location'),
                    'luar_dalam_negeri'=> $this->input->post('luar_dalam_negeri'),
                    'total_hari'=> $this->input->post('total_hari'),
                    'flag_pelatihan'=> $this->input->post('tujuan_pelatihan'),
                    'pesawat'=> $this->input->post('pesawat'),
                    'kendaraan_dinas'=> $this->input->post('kendaraan_dinas'),
                    'kereta_api'=> $this->input->post('kereta_api'),
                    'kendaraan_pribadi'=> $this->input->post('kendaraan_pribadi'),
                    'travel'=> $this->input->post('travel'),
                    'kapal'=> $this->input->post('kapal'),
                    'personnel_subarea'=> $this->input->post('personnel_subarea'),
                    'kendaraan_umum'=> $this->input->post('kendaraan_umum'),
                    'lokasi_kantor'=> $this->input->post('lokasi_kantor'),
                    'range_grade'=> $this->input->post('range_grade'),
                );

                $header = array(
                    'account_number' => $this->input->post('norek'),
                    'paid_to' => $this->input->post('paid_to'),
                    'account_name' => $this->input->post('atas_nama'),
                    'claim_total' => $this->input->post('total_uang_muka'),
                    'currency'=> $this->input->post('currency'),
                    'cost_center'=> $this->input->post('cost_center'),
                    'region'=> $this->input->post('lokasi_kantor'),
                    'requestor'=> $this->input->post('email_pejalan_dinas'),
                    'updated_by' => $this->email,
                    'updated_at' => $this->date,
                    'lpd_flag' => 0
                );

                $this->db->where('header_id', $id_header);
                $check = $this->db->get('bussiness_trip_detail');

                if ($check->num_rows() == 0) {
                    $this->db->insert('bussiness_trip_detail', $detail);
                    $detailok = true;

                } else {
                    $this->db->where('header_id', $id_header);
                    $this->db->update('bussiness_trip_detail', $detail);
                    $detailok = true;
                }
                
                if ($detailok) {

                    $this->db->where('request_id', $request_id);
                    $updateHeader = $this->db->update('bussiness_trip', $header);

                    if ($updateHeader) {

                        # update approval
                        $email_approval = array();
                        if ($this->input->post('requestor_email') != '') { array_push($email_approval, $this->input->post('requestor_email')); }
                        if ($this->input->post('layer_1') != '') { array_push($email_approval, $this->input->post('layer_1')); }
                        if ($this->input->post('hr_layer_1') != '') { array_push($email_approval, $this->input->post('hr_layer_1')); }
                        if ($this->input->post('hr_layer_2') != '') { array_push($email_approval, $this->input->post('hr_layer_2')); }

                        if (!empty($email_approval)) {
                            $save_approval = $this->ppd_model->save_approval($email_approval, $request_id, 'save');
                        } else {
                            $save_approval = true;
                        }

                        if ($save_approval) {
                            $request = array(
                                'form_purpose' => $this->input->post('tujuan_keperluan'),
                                'updated_by' => $this->email,
                                'updated_at' => $this->date
                            );

                            $this->db->where('id', $request_id);
                            $updateRequest = $this->db->update('form_request', $request);

                            if ($updateRequest) {
                                $this->logs('save_draft_ppd', 'PPD', $request_id);
                                $response = array('status' => 1);
                            } else {
                                $this->logs('system', 'PPD', $request_id, 'Save PPD', 'Failed');
                                $response = array('status' => 0);
                            }
                        }

                        

                    } else {
                        $response = array('status' => 0);
                    }

                } else {
                    $response = array('status' => 0);
                }

                echo json_encode($response);
                break;

            case 'submit':

                $detailok = false;
                $request_id = $this->input->post('request_id');
                $id_header = $this->input->post('id_header');

                $detail = array(
                    'header_id'=> $id_header,
                    'beban_pt'=> $this->input->post('beban_pt'),
                    // 'required_date'=> $this->input->post('required_date'),
                    'email_pejalan_dinas'=> $this->input->post('email_pejalan_dinas'),
                    'nama_pejalan_dinas'=> $this->input->post('nama_pejalan_dinas'),
                    'cost_center'=> $this->input->post('cost_center'),
                    'requestor_nik'=> $this->input->post('employee_nik'),
                    'posisi'=> $this->input->post('employee_position'),
                    'divisi'=> $this->input->post('employee_division'),
                    'kota_tujuan'=> $this->input->post('kota_tujuan'),
                    'kota_berangkat'=> $this->input->post('kota_berangkat'),
                    'tgl_berangkat'=> $this->input->post('tgl_berangkat'),
                    'tgl_kembali'=> $this->input->post('tgl_kembali'),
                    'waktu_berangkat'=> $this->input->post('waktu_berangkat'),
                    'waktu_kembali'=> $this->input->post('waktu_kembali'),
                    'x_diem'=> $this->input->post('x_diem'),
                    'nominal_diem'=> $this->input->post('nominal_diem'),
                    'total_diem'=> $this->input->post('total_diem'),
                    'x_hotel'=> $this->input->post('x_hotel'),
                    'nominal_hotel'=> $this->input->post('nominal_hotel'),
                    'total_hotel'=> $this->input->post('total_hotel'),
                    'x_transport'=> $this->input->post('x_transport'),
                    'nominal_transport'=> $this->input->post('nominal_transport'),
                    'total_transport'=> $this->input->post('total_transport'),
                    'x_lain_lain'=> $this->input->post('x_lain_lain'),
                    'nominal_lain_lain'=> $this->input->post('nominal_lain_lain'),
                    'total_lain_lain'=> $this->input->post('total_lain_lain'),
                    'tujuan_keperluan'=> $this->input->post('tujuan_keperluan'),
                    'currency'=> $this->input->post('currency'),
                    'specific_location'=> $this->input->post('specific_location'),
                    'luar_dalam_negeri'=> $this->input->post('luar_dalam_negeri'),
                    'total_hari'=> $this->input->post('total_hari'),
                    'flag_pelatihan'=> $this->input->post('tujuan_pelatihan'),
                    'pesawat'=> $this->input->post('pesawat'),
                    'kendaraan_dinas'=> $this->input->post('kendaraan_dinas'),
                    'kereta_api'=> $this->input->post('kereta_api'),
                    'kendaraan_pribadi'=> $this->input->post('kendaraan_pribadi'),
                    'travel'=> $this->input->post('travel'),
                    'kapal'=> $this->input->post('kapal'),
                    'personnel_subarea'=> $this->input->post('personnel_subarea'),
                    'kendaraan_umum'=> $this->input->post('kendaraan_umum'),
                    'lokasi_kantor'=> $this->input->post('lokasi_kantor'),
                    'range_grade'=> $this->input->post('range_grade'),
                );

                $header = array(
                    'account_number' => $this->input->post('norek'),
                    'paid_to' => $this->input->post('paid_to'),
                    'account_name' => $this->input->post('atas_nama'),
                    'claim_total' => $this->input->post('total_uang_muka'),
                    'currency'=> $this->input->post('currency'),
                    'cost_center'=> $this->input->post('cost_center'),
                    'region'=> $this->input->post('lokasi_kantor'),
                    'requestor'=> $this->input->post('email_pejalan_dinas'),
                    'updated_by' => $this->email,
                    'updated_at' => $this->date,
                    'lpd_flag' => 0
                );

                $this->db->where('header_id', $id_header);
                $check = $this->db->get('bussiness_trip_detail');

                if ($check->num_rows() == 0) {
                    $this->db->insert('bussiness_trip_detail', $detail);
                    $detailok = true;

                } else {
                    $this->db->where('header_id', $id_header);
                    $this->db->update('bussiness_trip_detail', $detail);
                    $detailok = true;
                }
                
                if ($detailok) {

                    $this->db->where('request_id', $request_id);
                    $updateHeader = $this->db->update('bussiness_trip', $header);

                    if ($updateHeader) {

                        # update approval
                        $email_approval = array();
                        if ($this->input->post('requestor_email') != '') { array_push($email_approval, $this->input->post('requestor_email')); }
                        if ($this->input->post('layer_1') != '') { array_push($email_approval, $this->input->post('layer_1')); }
                        if ($this->input->post('hr_layer_1') != '') { array_push($email_approval, $this->input->post('hr_layer_1')); }
                        if ($this->input->post('hr_layer_2') != '') { array_push($email_approval, $this->input->post('hr_layer_2')); }

                        if (!empty($email_approval)) {
                            $save_approval = $this->ppd_model->save_approval($email_approval, $request_id, 'submit');
                        } else {
                            $save_approval = true;
                        }

                        if ($save_approval) {
                            $request = array(
                                'is_status' => 1,
                                'form_purpose' => $this->input->post('tujuan_keperluan'),
                                'updated_by' => $this->email,
                                'updated_at' => $this->date
                            );

                            $this->db->where('id', $request_id);
                            $updateRequest = $this->db->update('form_request', $request);

                            if ($updateRequest) {
                                $this->logs('submit_ppd', 'PPD', $request_id);
                                $response = array('status' => 1, 'request_id' => encode_url($request_id));
                            } else {
                                $this->logs('system', 'PPD', $request_id, 'Submit PPD', 'Failed');
                                $response = array('status' => 0);
                            }
                        }

                        

                    } else {
                        $response = array('status' => 0);
                    }

                } else {
                    $response = array('status' => 0);
                }

                echo json_encode($response);
                break;

            case 'resubmit':

                $detailok = false;
                $request_id = $this->input->post('request_id');
                $id_header = $this->input->post('id_header');

                $nik_after = $this->input->post('employee_nik');
                $nik_before = $this->db->get_where('bussiness_trip_detail', array('header_id' => $id_header))->row_array()['requestor_nik'];

                $detail = array(
                    'header_id'=> $id_header,
                    'beban_pt'=> $this->input->post('beban_pt'),
                    // 'required_date'=> $this->input->post('required_date'),
                    'email_pejalan_dinas'=> $this->input->post('email_pejalan_dinas'),
                    'nama_pejalan_dinas'=> $this->input->post('nama_pejalan_dinas'),
                    'cost_center'=> $this->input->post('cost_center'),
                    'requestor_nik'=> $this->input->post('employee_nik'),
                    'posisi'=> $this->input->post('employee_position'),
                    'divisi'=> $this->input->post('employee_division'),
                    'kota_tujuan'=> $this->input->post('kota_tujuan'),
                    'kota_berangkat'=> $this->input->post('kota_berangkat'),
                    'tgl_berangkat'=> $this->input->post('tgl_berangkat'),
                    'tgl_kembali'=> $this->input->post('tgl_kembali'),
                    'waktu_berangkat'=> $this->input->post('waktu_berangkat'),
                    'waktu_kembali'=> $this->input->post('waktu_kembali'),
                    'x_diem'=> $this->input->post('x_diem'),
                    'nominal_diem'=> $this->input->post('nominal_diem'),
                    'total_diem'=> $this->input->post('total_diem'),
                    'x_hotel'=> $this->input->post('x_hotel'),
                    'nominal_hotel'=> $this->input->post('nominal_hotel'),
                    'total_hotel'=> $this->input->post('total_hotel'),
                    'x_transport'=> $this->input->post('x_transport'),
                    'nominal_transport'=> $this->input->post('nominal_transport'),
                    'total_transport'=> $this->input->post('total_transport'),
                    'x_lain_lain'=> $this->input->post('x_lain_lain'),
                    'nominal_lain_lain'=> $this->input->post('nominal_lain_lain'),
                    'total_lain_lain'=> $this->input->post('total_lain_lain'),
                    'tujuan_keperluan'=> $this->input->post('tujuan_keperluan'),
                    'currency'=> $this->input->post('currency'),
                    'specific_location'=> $this->input->post('specific_location'),
                    'luar_dalam_negeri'=> $this->input->post('luar_dalam_negeri'),
                    'total_hari'=> $this->input->post('total_hari'),
                    'flag_pelatihan'=> $this->input->post('tujuan_pelatihan'),
                    'pesawat'=> $this->input->post('pesawat'),
                    'kendaraan_dinas'=> $this->input->post('kendaraan_dinas'),
                    'kereta_api'=> $this->input->post('kereta_api'),
                    'kendaraan_pribadi'=> $this->input->post('kendaraan_pribadi'),
                    'travel'=> $this->input->post('travel'),
                    'kapal'=> $this->input->post('kapal'),
                    'personnel_subarea'=> $this->input->post('personnel_subarea'),
                    'kendaraan_umum'=> $this->input->post('kendaraan_umum'),
                    'lokasi_kantor'=> $this->input->post('lokasi_kantor'),
                    'range_grade'=> $this->input->post('range_grade'),
                );

                $header = array(
                    'account_number' => $this->input->post('norek'),
                    'paid_to' => $this->input->post('paid_to'),
                    'account_name' => $this->input->post('atas_nama'),
                    'claim_total' => $this->input->post('total_uang_muka'),
                    'currency'=> $this->input->post('currency'),
                    'cost_center'=> $this->input->post('cost_center'),
                    'region'=> $this->input->post('lokasi_kantor'),
                    'requestor'=> $this->input->post('email_pejalan_dinas'),
                    'updated_by' => $this->email,
                    'updated_at' => $this->date,
                    'lpd_flag' => 0
                );

                $this->db->where('header_id', $id_header);
                $check = $this->db->get('bussiness_trip_detail');

                if ($check->num_rows() == 0) {
                    $detailok= $this->db->insert('bussiness_trip_detail', $detail);
                } else {
                    $this->db->where('header_id', $id_header);
                    $detailok = $this->db->update('bussiness_trip_detail', $detail);
                }
                
                if ($detailok) {

                    $this->db->trans_begin();

                    # Update header
                    $this->db->where('request_id', $request_id);
                    $this->db->update('bussiness_trip', $header);

                    # Update Approval



                    # Update Request
                    $this->db->where('id', $request_id);
                    $this->db->update('form_request', array('is_status' => 1, 'updated_by' => $this->email, 'updated_at' => $this->date));


                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->logs('system', 'PPD', $id_request, 'Resubmit.', 'Failed.');
                    } else {
                        $this->db->trans_commit();
                        $this->logs('resubmit_ppd', 'PPD', $id_request);
                        $output = array('status' => 1, 'id' => encode_url($id_request));
                    }

                } else {
                    $response = array('status' => 0);
                }

                echo json_encode($response);
                break;

            case 'pullback_ppd':

                $detailok = false;
                $request_id = $this->input->post('request_id');

                $request = array(
                    'updated_by' => $this->email,
                    'updated_at' => $this->date,
                    'is_status' => 7
                );


                $this->db->where('id', $request_id);
                $pullback = $this->db->update('form_request', $request);
                
                if ($pullback) {

                    $app_id = $this->db->get_where('form_approval', 
                        array('request_id' => $request_id, 'approval_status' => 'In Progress'))->row_array()['id'];
                    $approval = array('approval_status' => 'Cancel');

                    $this->db->where('id', $app_id);
                    $this->db->update('form_approval', $approval);
                    $response = array('status' => 1, 'request_id' => encode_url($request_id));
                    $this->logs('pullback_ppd', 'PPD', $request_id);

                } else {
                    $this->logs('system', 'PPD', $request_id, 'Pullback PPD', 'Failed update form request');
                    $response = array('status' => 0);
                }

                echo json_encode($response);
                break;

            default:
                break;
        }
    }

    public function saveApproval($request_id)
    {
        $transok = false;
        $layer = $this->input->post('approval_layer');
        if (!empty($layer)) {
            return $this->form_model->save_approval($layer, $request_id);
        } else {
            return false;
        }
    }

    public function getDetailEmployee()
    {
        $nik = $this->input->post('employee_nik');
        $this->db->limit(1);
        $this->db->where('nik', $nik);
        $this->db->order_by('id_employee', 'DESC');
        $data = $this->db->get('hris_employee')->row_array();
        $division = decrypt($data['division']);

        $creator_nik = $this->emp_id;
        $creator_division = $this->division;

        if (!empty($data)) {

            $grade = decrypt($data['employee_group']);
            $lokasi_kantor = decrypt($data['personnel_area']);

            $pagu = $this->m_global->find('grade', $grade, 'hris_trip_pagu')->row_array();
            $diem = $pagu['diem'];
            $hotel_primary_cities = $pagu['hotel_primary_cities'];
            $hotel_secondary_cities = $pagu['hotel_secondary_cities'];
            $tipe_penerbangan = $pagu['tipe_penerbangan'];
            $laundry = $pagu['laundry'];
            $bagasi = $pagu['bagasi']; 
            $subarea = decrypt($data['personnel_subarea']);

            switch ($subarea) {
                
                case 'Head Office':
                    $class = $this->getClassHO($grade);
                    $data['layer_1'] = $this->getLayer1('HO', $class, $nik);
                    break;

                case 'Non HO':
                    $class = $this->getClassRegional($grade);
                    $data['layer_1'] = $this->getLayer1('Regional', $class, $nik);
                    break;
                
                default:
                    break;
            }

            if ($nik === '20120006') {
                $data['hr_layer_1'] = 'hr.support@ibstower.com';
                $data['hr_layer_2'] = '';

            } else {

                if ($grade === 'GOL A' || $grade === 'GOL B' || $grade === 'GOL C' || $grade === 'GOL D' || $grade === 'GOL E' || $grade === 'GOL F' || $grade === 'GOL G') {
                    $data['hr_layer_1'] = 'hr.support@ibstower.com';
                    $data['hr_layer_2'] = 'hendry.tjoa@ibstower.com';
                } else {
                    $data['hr_layer_1'] = 'hr.support@ibstower.com';
                    $data['hr_layer_2'] = '';
                }

            }

            $response = array(
                'status' => true, 
                'name' => decrypt($data['complete_name']),
                'email' => strtolower(decrypt($data['email'])),
                'division' => decrypt($data['division']),
                'position' => decrypt($data['position']),
                'cost_center' => decrypt($data['cost_center']),
                'lokasi_kantor' => decrypt($data['personnel_area']),
                'personnel_subarea' => decrypt($data['personnel_subarea']),
                'range_grade' => range_grade($grade),
                'nom_diem' => $diem,
                'nom_hotel' => $hotel_primary_cities,
                'tipe_penerbangan' => $tipe_penerbangan,
                'laundry' => $laundry,
                'bagasi' => $bagasi,
                'layer_1' => $data['layer_1'],
                'hr_layer_1' => $data['hr_layer_1'],
                'hr_layer_2' => $data['hr_layer_2'],
            );

        } else {
            $response = array('status' => false, 'message' => 'NIK tidak ditemukan.');
        }

        echo json_encode($response);
    }

    public function check_ppd($reqnum)
    {
        $request_number = $reqnum;
        $data['request'] = $this->db->get_where('form_request', array('created_by' => strtolower($this->email), 'request_number' => $request_number))->row_array();

        if (empty($data['request'])) {
            $response = array( 'status' => 0, 'message' => 'PPD not found.');
        } else {

            if ($data['request']['is_status'] === 3) {

                $data['header'] = $this->m_global->find('request_id', $data['request']['id'], 'bussiness_trip')->row_array();
                $data['detail'] = $this->m_global->find('header_id', $data['header']['id'], 'bussiness_trip_detail')->row_array();
                $data['layer_1'] = $this->db->get_where('form_approval', 
                                            array('request_id' => $data['request']['id'], 'approval_priority' => 1))->row_array()['approval_email'];
                $data['layer_2'] = $this->db->get_where('form_approval', 
                                            array('request_id' => $data['request']['id'], 'approval_priority' => 2))->row_array()['approval_email'];
                
                $response = array(
                        'status' => 1, 
                        'layer_1' => $data['layer_1'], 
                        'layer_2' => $data['layer_2'], 
                        'header' => $data['header'], 
                        'detail' => $data['detail'] );

            } 
            if ($data['request']['is_status'] !== 3) {

                $response = array(
                        'status' => 0, 
                        'message' => 'PPD not Full Approved. Please complete PPD approval. Current status: '.$data['request']['is_status']);
            
            } 

        }

        header('Content-type: application/json');
        echo json_encode($response);
    }

    public function check_max_hotel()
    {
        $nik = $this->input->post('employee_nik');
        $kota_tujuan = $this->input->post('kota_tujuan');
        $this->db->limit(1);
        $this->db->where('nik', $nik);
        $this->db->order_by('id_employee', 'DESC');
        $data = $this->db->get('hris_employee')->row_array();

        if (!empty($data)) {

            $grade = decrypt($data['employee_group']);
            $pagu = $this->m_global->find('grade', $grade, 'hris_trip_pagu')->row_array();
            $hotel_primary_cities = $pagu['hotel_primary_cities'];
            $hotel_secondary_cities = $pagu['hotel_secondary_cities'];
            $category_city = $this->db->get_where('master_city', array('IDPROVINSI' => $kota_tujuan))->row_array()['CATEGORY'];

            if ($category_city === 'PRIMARY') {
                $max_hotel = $hotel_primary_cities;
            } else {
                $max_hotel = $hotel_secondary_cities;
            }

            $response = array('status' => true, 'nom_hotel' => $max_hotel);

        } else {
            $response = array('status' => false, 'message' => 'NIK tidak ditemukan.');
        }

        echo json_encode($response);
    }

    public function response()
    {
        $output = array('status' => 0, 'message' => 'Something went wrong. Please refresh and try again.');
        $id_request = $this->input->post('id');
        $response = $this->input->post('response');
        $approval_id = $this->db->get_where('form_approval', array('request_id' => $id_request, 'approval_status' => 'In Progress' ))->row_array()['id'];

        // previous layer
        $priority = $this->m_global->find('id', $approval_id, 'form_approval')->row_array()['approval_priority'];
        $prev_priority = $priority-1;
        $prev_layer = $this->db->get_where('form_approval', array('approval_priority' => $prev_priority, 'request_id' => $id_request))->row_array();
        $prev_email = $prev_layer['approval_email'];
        $prev_id = $prev_layer['id'];

        switch ($response) {

            case 'Approved':
                
                $current_layer = array('approval_status' => 'Approved', 'updated_at' => $this->date, 'updated_by' => $this->email);
                $next_layer = array('approval_status' => 'In Progress', 'updated_at' => $this->date, 'updated_by' => $this->email);

                #check approver list
                $sql = "SELECT * FROM form_approval WHERE id >= '$approval_id' AND request_id = '$id_request' ORDER BY approval_priority ASC OFFSET 1 ROWS FETCH NEXT 1 ROWS ONLY";
                $checkleft = $this->db->query($sql);

                if ($checkleft->num_rows() > 0) {

                    $this->db->trans_begin();

                    $this->db->where('id', $approval_id);
                    $this->db->update('form_approval', $current_layer);

                    $this->db->where('id', $checkleft->row_array()['id']);
                    $this->db->update('form_approval', $next_layer);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->logs('system', 'PPD', $id_request, 'Response Approved.', 'Failed.');
                    } else {
                        $this->db->trans_commit();
                        $this->logs('approved', 'PPD', $id_request);
                        $output = array('status' => 1, 'id' => encode_url($id_request));
                    }

                } else {

                    $this->db->trans_begin();

                    $this->db->where('id', $approval_id);
                    $this->db->update('form_approval', $current_layer);

                    $this->db->update('form_request', array('is_status' => 3, 'updated_by' => $this->email, 'updated_at' => $this->date));

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->logs('system', 'PPD', $id_request, 'Response Approved.', 'Failed.');
                    } else {
                        $this->db->trans_commit();
                        $this->logs('approved', 'PPD', $id_request);
                        $output = array('status' => 1, 'id' => encode_url($id_request));
                    }
                    
                }
                
                break;

            case 'Revised':

                $current_layer = array('approval_status' => 'Revised', 'updated_at' => $this->date, 'updated_by' => $this->email);
                
                $this->db->where('id', $approval_id);
                if ($this->db->update('form_approval', $current_layer)) {

                    $this->db->where('id', $id_request);
                    if ($this->db->update('form_request', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
                        // $this->sendEmail('revise', $id_request, $requestor);
                        $this->logs('revised', 'PPD', $id_request);
                        $output = array('status' => 1, 'id' => encode_url($id_request));

                    }
                }

                break;
            
            case 'Revised_Prev':
                
                if ($priority != 1) {

                    $current_layer = array(
                        'approval_status' => 'Revised to previous layer', 
                        'updated_at' => $this->date, 
                        'updated_by' => $this->email
                    );

                    $prev_layer = array(
                        'approval_status' => 'In Progress', 
                        'updated_at' => $this->date, 
                        'updated_by' => $this->email
                    );

                    $this->db->where('id', $approval_id);
                    if ($this->db->update('form_approval', $current_layer)) {

                        $this->db->where('id', $prev_id);
                        if ($this->db->update('form_approval', $prev_layer)) {
                            
                            // $this->sendEmail('revise', $id_request, $prev_email['approval_email']);
                            $this->logs('revised_prev', 'PPD', $id_request);
                            $output = array('status' => 1, 'id' => encode_url($id_request));
                        }
                        
                    }

                } else {

                    $current_layer = array(
                        'approval_status' => 'Revised', 
                        'updated_at' => $this->date, 
                        'updated_by' => $this->email
                    );
                    
                    $this->db->where('id', $approval_id);
                    if ($this->db->update('form_approval', $current_layer)) {

                        $this->db->where('id', $id_request);
                        if ($this->db->update('form_request', array('is_status' => 2, 'updated_by' => $this->email, 'updated_at' => $this->date))) {
                            // $this->sendEmail('revise', $id_request, $requestor);
                            $this->logs('revised', 'PPD', $id_request);
                            $output = array('status' => 1, 'id' => encode_url($id_request));

                        }
                    }

                }

                break;

            default:
                break;
        }

        echo json_encode($output);
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

            case 'submit_ppd':
                $log['activity'] = 'Submit PPD';
                $log['description'] = 'Success';
                $this->db->insert('logs', $log);
                break;

            case 'resubmit_ppd':
                $log['activity'] = 'Re-Submit PPD';
                $log['description'] = 'Success';
                $this->db->insert('logs', $log);
                break;

            case 'save_draft_ppd':
                $log['activity'] = 'Save Draft PPD';
                $log['description'] = 'Success';
                $this->db->insert('logs', $log);
                break;

            case 'pullback_ppd':
                $log['activity'] = 'Pullback PPD';
                $log['description'] = 'Success';
                $this->db->insert('logs', $log);
                break;

            case 'approved':
                $log['activity'] = 'Approved PPD';
                $log['description'] = 'Success';
                $this->db->insert('logs', $log);
                break;

            case 'revised':
                $log['activity'] = 'Revise PPD to requestor';
                $log['description'] = 'Success';
                $this->db->insert('logs', $log);
                break;

            case 'revised_prev':
                $log['activity'] = 'Revise PPD to previous layer';
                $log['description'] = 'Success';
                $this->db->insert('logs', $log);
                break;

            default:
                break;
        }
    }

}
