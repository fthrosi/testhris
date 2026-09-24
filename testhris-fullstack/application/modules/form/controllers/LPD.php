<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LPD extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		// $this->load->library('enc');
		// $this->enc->check_session();

		// if (!$this->enc->access_user()) {
		// 	$x = base_url();
		// 	redirect($x);
		// 	exit();
		// }
		
		$this->load->helper('general');
		$this->load->model('m_global');
		$this->load->model('form_model');

		$this->division = $this->session->userdata('division');
        $this->email = $this->session->userdata('user_email');
        $this->emp_id = $this->session->userdata('employee_nik');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

	public function read($lpd_id)
    {
		$lpd_list = $this->m_global->find('header_id', $lpd_id, 'bussiness_trip_settlement_additional')->result();
		// $status = $this->m_global->find('id', $lpd_id, 'form_request')->row_array()['is_status'];
        if (!empty($lpd_list)) {
			$no = 1;
            foreach ($lpd_list as $key) {
                $row   = array();
				// if ($status === '0' || $status === '2' || $status === '7') {
				// 	$row[] = $no.'. <td class="nk-tb-col nk-tb-col-tools">
				// 			<a onclick="delete_lpd_item('.$key->id.');" class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
				// 			<a onclick="update_lpd_item('.$key->id.');" class="btn btn-icon btn-trigger"><em class="icon ni ni-edit-fill"></em></a>
                //         </td>';
				// } else {
				// 	$row[] = $no;
				// }

				$row[] = '<td class="nk-tb-col nk-tb-col-tools">
							<a onclick="delete_lpd_item('.$key->id.');" class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em></a>
							<a onclick="update_lpd_item('.$key->id.');" class="btn btn-icon btn-trigger"><em class="icon ni ni-edit-fill"></em></a>
                        </td>';
				$row[] = $key->date_travel;
                $row[] = wordwrap($key->remarks, 30, "<br>", true);
                $row[] = $key->currency;
                $row[] = rupiah($key->transport);
                $row[] = rupiah($key->hotel);
                $row[] = rupiah($key->diem);
                $row[] = rupiah($key->others);
                $row[] = rupiah($key->subtotal);

                $data[] = $row;
				$no++;
            }

            $output = array('data' => $data);
        } else {
            $output = array('data' => new ArrayObject());
        }

        echo json_encode($output);
    }

	public function save($method, $formType = "")
	{
		switch ($method) {

			case 'lpd_draft':

				$detailok = false;
				$request_id = $this->input->post('request_id');
				$id_header = $this->input->post('id_header');

				$detail = array(
					'header_id' => $id_header,
					'nik_pejalan_dinas' => $this->input->post('employee_nik'),
					'ppd_request_number' => $this->input->post('ppd_request_number'),
					'nama_pejalan_dinas' => $this->input->post('nama_pejalan_dinas'),
					'email_pejalan_dinas' => $this->input->post('email_pejalan_dinas'),
					'kota_berangkat' => $this->input->post('kota_berangkat'),
					'kota_tujuan' => $this->input->post('kota_tujuan'),
					'tgl_berangkat' => $this->input->post('tgl_berangkat'),
					'tgl_kembali' => $this->input->post('tgl_kembali'),
					'waktu_berangkat' => $this->input->post('waktu_berangkat'),
					'waktu_kembali' => $this->input->post('waktu_kembali'),
					'divisi' => $this->input->post('employee_division'),
					'posisi' => $this->input->post('employee_position'),
					'cost_center' => $this->input->post('cost_center'),
					'jarak_mobil_kantor' => $this->input->post('jarak_mobil_kantor'),
					'total_perdiem' => $this->input->post('total_perdiem'),
					'total_hotel' => $this->input->post('total_hotel'),
					'total_transport' => $this->input->post('total_transport'),
					'total_others' => $this->input->post('total_others'),
					'claim_total' => $this->input->post('claim_total'),
					'nominal_ppd' => $this->input->post('nominal_ppd'),
					'sisa_lebih' => $this->input->post('sisa_lebih'),
					'sisa_lebih_sudah_dibayar' => $this->input->post('sisa_lebih_sudah_dibayar'),
					'sisa_lebih_sudah_dibayar' => $this->input->post('sisa_lebih_sudah_dibayar'),
				);

				$header = array(
					'requestor' => $this->input->post('email_pejalan_dinas'),
					'cost_center' => $this->input->post('cost_center'),
					'claim_total' => $this->input->post('claim_total'),
					'updated_at' => $this->date,
					'updated_by' => $this->email,
				);

				$this->db->where('header_id', $id_header);
				$check = $this->db->get('bussiness_trip_settlement_detail');

				if ($check->num_rows() == 0) {
					$detail['created_at'] = $this->date;
					$detail['created_by'] = $this->email;
					$this->db->insert('bussiness_trip_settlement_detail', $detail);
					$detail_id = $this->db->insert_id();
					$detailok = true;

				} else {
					$detail['updated_at'] = $this->date;
					$detail['updated_by'] = $this->email;
					$this->db->where('header_id', $id_header);
					$this->db->update('bussiness_trip_settlement_detail', $detail);
					$detailok = true;
				}
				
				if ($detailok) {

					$this->db->where('request_id', $request_id);
					$updateHeader = $this->db->update('bussiness_trip_settlement', $header);

					if ($updateHeader) {
						$this->logs('save_draft_lpd', 'LPD', $request_id);
						$response = array('status' => 1);

					} else {
						$response = array('status' => 0);
					}

				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'submit_lpd':

				$detailok = false;
				$request_id = $this->input->post('request_id');
				$id_header = $this->input->post('id_header');

				$detail = array(
					'header_id' => $id_header,
					'beban_pt' => $this->input->post('beban_pt'),
					'requestor' => $this->input->post('requestor'),
					'nama_pejalan_dinas' => $this->input->post('nama_pejalan_dinas'),
					'email_pejalan_dinas' => $this->input->post('email_pejalan_dinas'),
					'divisi_posisi' => $this->input->post('divisi_posisi'),
					'kota_berangkat' => $this->input->post('kota_berangkat'),
					'tgl_berangkat' => $this->input->post('tgl_berangkat'),
					'waktu_berangkat' => $this->input->post('waktu_berangkat'),
					'kota_tujuan' => $this->input->post('kota_tujuan'),
					'tgl_kembali' => $this->input->post('tgl_kembali'),
					'waktu_kembali' => $this->input->post('waktu_kembali'),
					'x_diem' => $this->input->post('x_diem'),
					'nominal_diem' => $this->input->post('nominal_diem'),
					'total_diem' => $this->input->post('total_diem'),
					'x_hotel' => $this->input->post('x_hotel'),
					'nominal_hotel' => $this->input->post('nominal_hotel'),
					'total_hotel' => $this->input->post('total_hotel'),
					'x_airport' => $this->input->post('x_airport'),
					'nominal_airport' => $this->input->post('nominal_airport'),
					'total_airport' => $this->input->post('total_airport'),
					'x_transport' => $this->input->post('x_transport'),
					'nominal_transport' => $this->input->post('nominal_transport'),
					'total_transport' => $this->input->post('total_transport'),
					'x_lain_lain' => $this->input->post('x_lain_lain'),
					'nominal_lain_lain' => $this->input->post('nominal_lain_lain'),
					'total_lain_lain' => $this->input->post('total_lain_lain'),
					'tujuan_keperluan' => $this->input->post('tujuan_keperluan'),
					'alat_transportasi' => $this->input->post('alat_transportasi')
				);

				$header = array(
					'account_number' => $this->input->post('norek'),
					'paid_to' => $this->input->post('bank_cabang'),
					'contact_number' => $this->input->post('atas_nama'),
					'claim_total' => $this->input->post('total_uang_muka'),
					'is_status' => 1,
					'updated_by' => $this->email,
					'updated_at' => $this->date
				);

				$request = array(
					'is_status' => 1,
					'updated_by' => $this->email,
					'updated_at' => $this->date
				);

				$this->db->where('header_id', $id_header);
				$check = $this->db->get('cash_advance_travel');

				if ($check->num_rows() == 0) {
					$this->db->insert('cash_advance_travel', $detail);
					$detail_id = $this->db->insert_id();
					$detailok = true;

				} else {
					$this->db->where('header_id', $id_header);
					$this->db->update('cash_advance_travel', $detail);
					$detailok = true;
				}
				
				if ($detailok) {

					$this->db->where('request_id', $request_id);
					$updateHeader = $this->db->update('cash_advance', $header);

					if ($updateHeader) {

						$this->db->where('id', $request_id);
						$updateRequest = $this->db->update('form_request', $request);

						if ($updateRequest) {
							$this->logs('submit_ppd', 'PPD', $request_id);
							$response = array('status' => 1, 'request_id' => encode_url($request_id) );
						} else {
							$response = array('status' => 0);
						}

					} else {
						$response = array('status' => 0);
					}

				} else {
					$response = array('status' => 0);
				}

				echo json_encode($response);
				break;

			case 'add_lpd_item':

				$request_id = $this->input->post('request_id');
				$header_id = $this->input->post('header_id');
				$detail = array(
					'header_id' => $header_id,
					'date_travel' => $this->input->post('date'),
					'remarks' => $this->input->post('remarks'),
					'currency' => $this->input->post('currency'),
					'transport' => $this->input->post('transport'),
					'hotel' => $this->input->post('hotel'),
					'diem' => $this->input->post('perdiem'),
					'others' => $this->input->post('others'),
					'subtotal' => $this->input->post('subtotal'),
					'created_at' => $this->date,
					'created_by' => $this->email
				);

				$header = array(
					'total_transport' => $this->input->post('total_transport'),
					'total_hotel' => $this->input->post('total_hotel'),
					'total_perdiem' => $this->input->post('total_perdiem'),
					'total_others' => $this->input->post('total_others'),
					'claim_total' => $this->input->post('grand_total')
				);

				$this->db->trans_start();

				$check = $this->db->where('header_id', $header_id)->get('bussiness_trip_settlement_detail');

				if ($check->num_rows() > 0) {

					$header['updated_at'] = $this->date;
					$header['updated_by'] = $this->email;
					$this->db->where('header_id', $header_id);
					$this->db->update('bussiness_trip_settlement_detail', $header);	

				} else {

					$header['header_id'] = $header_id;
					$header['created_at'] = $this->date;
					$header['created_by'] = $this->email;
					$this->db->insert('bussiness_trip_settlement_detail', $header);
				}

				$this->db->insert('bussiness_trip_settlement_additional', $detail);

				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$this->logs('system', 'LPD', $request_id,'Add LPD Item', 'Failed while updating data header');
					$response = array('status' => 0 , 'message' => 'Failed while updating data header. Please refresh the page and try again.');
				} else {
					$this->db->trans_commit();
					$this->logs('add_lpd_item', 'LPD', $request_id);
					$response = array('status' => 1);
				}

				echo json_encode($response);
				break;

			case 'update_lpd_item':

				$request_id = $this->input->post('request_id');
				$header_id = $this->input->post('header_id');
				$detail_id = $this->input->post('detail_id');

				$prev_transport = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['transport'];
				$prev_hotel = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['hotel'];
				$prev_diem = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['diem'];
				$prev_others = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['others'];
				$prev_subtotal = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['subtotal'];

				$new_transport = $this->input->post('transport');
				$new_hotel = $this->input->post('hotel');
				$new_perdiem = $this->input->post('perdiem');
				$new_others = $this->input->post('others');
				$new_subtotal = $this->input->post('subtotal');

				$prev_total_transport = $this->input->post('prev_total_transport');
				$prev_total_hotel = $this->input->post('prev_total_hotel');
				$prev_total_perdiem = $this->input->post('prev_total_perdiem');
				$prev_total_others = $this->input->post('prev_total_others');
				$prev_grand_total = $this->input->post('prev_grand_total');

				$new_total_transport = ($prev_total_transport - $prev_transport) + $new_transport;
				$new_total_hotel = ($prev_total_hotel - $prev_hotel) + $new_hotel;
				$new_total_perdiem = ($prev_total_perdiem - $prev_diem) + $new_perdiem;
				$new_total_others = ($prev_total_others - $prev_others) + $new_others;
				$new_grand_total = ($prev_grand_total - $prev_subtotal) + $new_subtotal;

				$detail = array(
					'header_id' => $header_id,
					'date_travel' => $this->input->post('date'),
					'remarks' => $this->input->post('remarks'),
					'currency' => $this->input->post('currency'),
					'transport' => $this->input->post('transport'),
					'hotel' => $this->input->post('hotel'),
					'diem' => $this->input->post('perdiem'),
					'others' => $this->input->post('others'),
					'subtotal' => $this->input->post('subtotal'),
					'updated_at' => $this->date,
					'updated_by' => $this->email,
				);

				$header = array(
					'total_transport' => $new_total_transport,
					'total_hotel' => $new_total_hotel,
					'total_perdiem' => $new_total_perdiem,
					'total_others' => $new_total_others,
					'claim_total' => $new_grand_total,
					'updated_at' => $this->date,
					'updated_by' => $this->email,
				);

				// print_r($header);die;

				$this->db->trans_start();
				$this->db->where('id', $header_id);
				$this->db->update('bussiness_trip_settlement_detail', $header);

				$this->db->where('id', $detail_id);
				$this->db->update('bussiness_trip_settlement_additional', $detail);

				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$this->logs('system', 'LPD', $request_id,'Update LPD Item', 'Failed while updating data detail');
					$response = array('status' => 0 , 'message' => 'Failed while updating data. Please refresh the page and try again.');
				} else {
					$this->db->trans_commit();
					$this->logs('update_lpd_item', 'LPD', $request_id);
					$response = array('status' => 1, 'data' => $header);
				}

				echo json_encode($response);
				break;

			default:
				break;
		}
	}

	public function check()
	{
		$detail_id = '52';
		$transport = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['transport'];
		$hotel = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['hotel'];
		$diem = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['diem'];
		$others = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['others'];
		$subtotal = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['subtotal'];
		print_r($subtotal);die;
	}

	public function delete($type)
	{
		switch ($type) {
			
			case 'lpd_item':

				$header_id = $this->input->post('header_id');
				$detail_id = $this->input->post('detail_id');

				$transport = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['transport'];
				$hotel = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['hotel'];
				$diem = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['diem'];
				$others = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['others'];
				$subtotal = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->row_array()['subtotal'];

				$total_transport = $this->input->post('total_transport');
				$total_hotel = $this->input->post('total_hotel');
				$total_diem = $this->input->post('total_diem');
				$total_others = $this->input->post('total_others');
				$grandtotal = $this->input->post('grand_total');
				
				$new_total_transport = $total_transport - $transport;
				$new_total_hotel = $total_hotel - $hotel;
				$new_total_diem = $total_diem - $diem;
				$new_total_others = $total_others - $others;
				$new_grandtotal = $grandtotal - $subtotal;

				$header = array(
					'total_transport' => $new_total_transport,
					'total_hotel' => $new_total_hotel,
					'total_perdiem' => $new_total_diem,
					'total_others' => $new_total_others,
					'claim_total' => $new_grandtotal,
					'updated_at' => $this->date,
					'updated_by' => $this->email,
				);

				$this->db->trans_start();
				$this->db->where('header_id', $header_id);
				$this->db->update('bussiness_trip_settlement_detail', $header);
				
				$this->db->where('id', $detail_id)->delete('bussiness_trip_settlement_additional');
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$this->logs('system', 'LPD', $header_id, 'Delete LPD item', 'Failed');
					$response = array('status' => 0, 'messages' => 'Delete LPD item failed.');
				} else {
					$this->db->trans_commit();
					$this->logs('delete_lpd_item', 'LPD', $header_id);
					$response = array('status' => 1, 'data' => $header);
				}
				
				echo json_encode($response);
				break;
			
			default:
				break;
		}
	}

	public function get($type)
	{
		switch ($type) {
			
			case 'lpd_item':

				$detail_id = $this->input->post('detail_id');
				$detail = $this->m_global->find('id', $detail_id, 'bussiness_trip_settlement_additional')->result_array();
				if (!empty($detail)) {
					$response = array('status' => 1, 'detail' => $detail);
				} else {
					$response = array('status' => 0, 'messages' => 'Data LPD item not found.');
				}
				echo json_encode($response);
				break;

			default:
				break;
		}
	}

	public function check_ppd($reqnum)
	{
		$request_number = 'EAPP_PPD_'.$reqnum;
		$data['request'] = $this->m_global->find('request_number', $request_number, 'form_request')->row_array();
		$data['header'] = $this->m_global->find('request_id', $data['request']['id'], 'cash_advance')->row_array();
		$data['detail'] = $this->m_global->find('header_id', $data['header']['id'], 'cash_advance_travel')->row_array();

		if ($data['request']['is_status'] == '3') {
			$response = array(
					'status' => 1, 
					'header' => $data['header'], 
					'detail' => $data['detail'] );

		} elseif ($data['request']['is_status'] != '3') {
			$response = array(
					'status' => 0, 
					'message' => 'PPD is not full approved yet. Please complete PPD approval progress.');
		
		} else {
			$response = array(
					'status' => 0, 
					'message' => 'PPD not found.');
		}

		header('Content-type: application/json');
		echo json_encode($response);
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

			case 'submit_lpd':
				$log['activity'] = 'Submit LPD';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'save_draft_lpd':
				$log['activity'] = 'Save Draft LPD';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'add_lpd_item':
				$log['activity'] = 'Add LPD Item';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'update_lpd_item':
				$log['activity'] = 'Update LPD Item';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			case 'delete_lpd_item':
				$log['activity'] = 'Delete LPD Item';
				$log['description'] = 'Success';
				$this->db->insert('logs', $log);
				break;

			default:
				break;
		}
	}

}
