<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->email = $this->session->userdata('user_email');
		$this->nik = $this->session->userdata('nik');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
		$this->today = date('Y-m-d');
	}

	public function getMyRequest()
	{
		$this->db->where("created_by", $this->email);
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('form_request')->result_array();
	}

	public function getMySubmissionList(){
		$this->db->where('employee_id', $this->nik);
		$this->db->where('is_status', '1');
		$approval = $this->db->get('form_request')->result_array();
		$data = array();

		if ($approval) {
			return $approval;
		} else {
			return $data;
		}
	}

	public function getFamilyEmployee($nik="", $no_ref="")
	{
		$no_ref = encrypt($no_ref);
		$this->db->where('seqno', $no_ref);
		$this->db->where('nik', $nik);
		$result = $this->db->get('hris_family_employee')->result();
		return $result;
	}

	public function getMedicalFullApproved($nik, $no_ref){
		//dumper($no_ref);
		$sql = "SELECT *
				FROM form_request
				WHERE (employee_id LIKE '$nik' OR no_req_mdcr LIKE '$no_ref') AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		//dumper($listId);
		//dumper($res);
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			// $sqll = "SELECT TOP 1 id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
			$sqll = "SELECT id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['no_req_mdcr'] =  $key['no_req_mdcr'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			//$data[] = $row;
			$data[] = (object)$row;
		}
		
		return $data;
	}

	public function getMedicalFullApproved_fix($nik, $no_ref){
		
		//dumper($nik." - ".$no_ref);
		if((!empty($nik)) && (!empty($no_ref))){
			$sql = "SELECT *
				FROM form_request
				WHERE (employee_id LIKE '$nik' AND no_req_mdcr LIKE '$no_ref') AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";
		}else if((!empty($nik)) && (empty($no_ref))){
			$sql = "SELECT *
				FROM form_request
				WHERE (employee_id LIKE '$nik') AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";
		}else if((empty($nik)) && (!empty($no_ref))){
			$sql = "SELECT *
				FROM form_request
				WHERE (no_req_mdcr LIKE '$no_ref') AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";
		}
		


		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		$data = array();
		foreach ($res as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			// $sqll = "SELECT TOP 1 id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC";
			$sqll = "SELECT id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['no_req_mdcr'] =  $key['no_req_mdcr'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
			//$data[] = (object)$row;
		}
		//dumper($data);
		return $data;
	}

	public function get_data_claim_per_employee($request_id){

		$sql = "SELECT *
		FROM		
			form_request 
		WHERE id LIKE '$request_id' AND is_status LIKE '3'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$form_request_id = (!empty(($res[0]->id))) ? (($res[0]->id)) : '';
		$employee_id = (!empty(($res[0]->employee_id))) ? (($res[0]->employee_id)) : '';

		$sql = "SELECT *
		FROM		
			hris_medical_reimbursment
		WHERE request_id LIKE '$form_request_id'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$created_at = (!empty(($res[0]->created_at))) ? (($res[0]->created_at)) : '';
		$year = date("Y",strtotime($res[0]->created_at));
    	$start_date 	= $year."-01-01";

		$sql = "SELECT 	
				a.id as id,
				a.request_id as request_id,
				e.is_status as is_status,
				b.grandparent as tor_grandparent,
				c.parent as tor_parent,
				d.child as tor_child,
				a.jumlah_kuitansi as jumlah_kuitansi,
				a.total_nominal_kuitansi as total_kuitansi,
				a.penggantian as penggantian,
				a.keterangan as keterangan,
				a.additional as additional,
				a.docter as docter,
				a.diagnosa as diagnosa,
				a.tanggal_kuitansi as tanggal_kuitansi,
				a.create_date as create_date
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
			LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
			LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
			LEFT JOIN form_request e ON a.request_id = e.id
			WHERE a.request_id LIKE '$form_request_id'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		//dumper($res);
		if($res){
			return $res;
		}else{
			return false;
		}
	}

	public function get_data_total_claim_per_employee($request_id){

		$sql = "SELECT *
		FROM		
			form_request 
		WHERE id LIKE '$request_id' AND is_status LIKE '3'";
		$query 				= $this->db->query($sql);
		$res 				= $query->result();
		$form_request_id 	= (!empty(($res[0]->id))) ? (($res[0]->id)) : '';
		$employee_id 		= (!empty(($res[0]->employee_id))) ? (($res[0]->employee_id)) : '';

		$year_request	=	strtotime($created_at);
		$year_request	=	date("Y",$year_request);

		$year 			= $year_request;
		
		$today = $this->today;

		$sql_eg = "SELECT 	
						employee_group as employee_group,
						start_date as start_date,
						reason_of_action as reason_of_action,
						join_date as join_date
					FROM		
						hris_employee
					WHERE nik = '$employee_id' ORDER BY id_employee DESC";
					
		$query_eg 				= $this->db->query($sql_eg);
		$res_eg					= $query_eg->result();
		$res_eg 				= $this->my_array_unique($res_eg);

		$no = 1;
		$result = [];

		foreach ($res_eg as $rown) {
			$rowArray = (array) $rown;
			$rowArray['no'] = $no++;
			$result[] = $rowArray;
		}

		$res_eg = $result;
		

		$data_eg = [];
		foreach($res_eg as $idx){
			$year_eg_sd = str_replace('-', '', (string) decrypt($idx['start_date']));
			$year_eg_sd = (int) substr($year_eg_sd, 0, 4);
			
			if(($year == $year_eg_sd) && (decrypt($idx['reason_of_action']) == 'Promosi')){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];

				$get_before = $idx['no'] + 1;
				foreach ($res_eg as $rowb) {
					if ($rowb->no == $get_before) {
						$data_before = $rowb;
						break;
					}
				}

				if (!empty($data_before)) {
					$data_eg[] = [
						'employee_group'     => $data_before['employee_group'],
						'start_date'         => $data_before['start_date'],
						'reason_of_action'   => $data_before['reason_of_action'],
						'join_date'   		 => $data_before['join_date']
					];
				}
			}elseif(($year == $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year < $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year > $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}
		}

		
		$res_eg_new 			= decrypt($data_eg[0]['employee_group']);
		$res_sd_new 			= decrypt($data_eg[0]['start_date']);
		$res_jd_new    			= decrypt($data_eg[0]['join_date']);
		$reason_of_action		= decrypt($data_eg[0]['reason_of_action']);
		$res_eg_old 			= (!empty(($data_eg[1]['employee_group']))) ? decrypt(($data_eg[1]['employee_group'])) : '';

		$sql2new = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query2new 	= $this->db->query($sql2new);
		$res2new 	= $query2new->result();
		$pagu_jalan_tahun_new 	= (!empty(($res2new[0]->pagu_tahun))) ? ($res2new[0]->pagu_tahun) : 0;

		$sql3new = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query3new 	= $this->db->query($sql3new);
		$res3new 	= $query3new->result();
		$pagu_inap_tahun_new 	= (!empty(($res3new[0]->pagu_tahun))) ? ($res3new[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_new 	= (!empty(($res3new[0]->pagu_kamar_hari))) ? ($res3new[0]->pagu_kamar_hari) : 0;
		
		
		$sql2old = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query2old 	= $this->db->query($sql2old);
		$res2old 	= $query2old->result();
		$pagu_jalan_tahun_old 	= (!empty(($res2old[0]->pagu_tahun))) ? ($res2old[0]->pagu_tahun) : 0;

		$sql3old = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query3old 	= $this->db->query($sql3old);
		$res3old 	= $query3old->result();
		$pagu_inap_tahun_old 	= (!empty(($res3old[0]->pagu_tahun))) ? ($res3old[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_old 	= (!empty(($res3old[0]->pagu_kamar_hari))) ? ($res3old[0]->pagu_kamar_hari) : 0;

		$start_date = DateTime::createFromFormat('Ymd', $res_sd_new);
		$start_date = $start_date->format('Y');

		if( ($start_date == $year) && (!empty($res_eg_old)) && ($reason_of_action == 'Promosi') ){

			$yearOld = $year-1;
			$yearNew = $year+1;
			$tgl1 = $yearOld."-12-31";
			$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
			$tgl2 = $tgl2->format('Y-m-d');
			$tgl22 = date('Y-m-d', strtotime('-1 days', strtotime($tgl2)));
    		$tgl3 = $yearNew."-01-01";

			$diff_old                = abs(strtotime($tgl22) - strtotime($tgl1));
			
			$join_years_old          = floor($diff_old / (365*60*60*24));
			$join_months_old         = floor(($diff_old - $join_years_old * 365*60*60*24) / (30*60*60*24));
			$join_days_old         	 = round($diff_old / (60 * 60 * 24));

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));
			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun_old = ((!empty(($pagu_inap_tahun_old))) ? ($pagu_inap_tahun_old) : 0);
			$pagu_pro_inap_tahun_old = ($join_days_old/365)* $pagu_inap_tahun_old;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new + $pagu_pro_inap_tahun_old;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun_old = ((!empty($pagu_jalan_tahun_old)) ? ($pagu_jalan_tahun_old) : 0);
			$pagu_pro_jalan_tahun_old = ($join_days_old/365) * $pagu_jalan_tahun_old;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new + $pagu_pro_jalan_tahun_old;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;
			

		}else if( ($start_date == $year) AND ($reason_of_action == 'Hiring') ){

			$yearNew = $year+1;
			$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
			$tgl2 = $tgl2->format('Y-m-d');
    		$tgl3 = $yearNew."-01-01";

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));
			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;
			

		}else{

			if(($year == $start_date) || ($year < $start_date)){
				$pagu_jalan_tahun	= $pagu_jalan_tahun_old;
				$pagu_inap_tahun	= $pagu_inap_tahun_old;
				$pagu_inap_kamar 	= $pagu_inap_kamar_old;

			}else{
				$pagu_jalan_tahun	= $pagu_jalan_tahun_new;
				$pagu_inap_tahun	= $pagu_inap_tahun_new;
				$pagu_inap_kamar 	= $pagu_inap_kamar_new;

			}

		}

		$sql4 = "SELECT 	
					pagu_one_focus_tahun as pagu_one_focus_tahun,
					pagu_two_focus_tahun as pagu_two_focus_tahun,
					pagu_frame_dua_tahun as pagu_frame_dua_tahun
				FROM		
					hris_medical_pagu_kacamata
				WHERE grade = '$res_eg_new' AND start_date <= '$today' AND end_date > '$today'";
		$query4 = $this->db->query($sql4);
		$res4 	= $query4->result();
		$pagu_one_focus_tahun 	= $res4[0]->pagu_one_focus_tahun;
		$pagu_two_focus_tahun 	= $res4[0]->pagu_two_focus_tahun;
		$pagu_frame_dua_tahun 	= $res4[0]->pagu_frame_dua_tahun;


		$sql = "SELECT 
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_jalan,
			SUM(a.penggantian) as total_penggantian_rawat_jalan
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN form_request b ON a.request_id = b.id
		WHERE b.is_status = '3' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '1' AND a.create_date BETWEEN '$start_date' AND '$created_at'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_rawat_jalan = (!empty(($res[0]->total_nominal_kuitansi_rawat_jalan))) ? (($res[0]->total_nominal_kuitansi_rawat_jalan)) : 0;
		$total_penggantian_rawat_jalan = (!empty(($res[0]->total_penggantian_rawat_jalan))) ? (($res[0]->total_penggantian_rawat_jalan)) : 0;
		

		$sql = "SELECT 
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_inap,
			SUM(a.penggantian) as total_penggantian_rawat_inap
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN form_request b ON a.request_id = b.id
		WHERE b.is_status = '3' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '2' AND a.create_date BETWEEN '$start_date' AND '$created_at'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_rawat_inap = (!empty(($res[0]->total_nominal_kuitansi_rawat_inap))) ? (($res[0]->total_nominal_kuitansi_rawat_inap)) : 0;
		$total_penggantian_rawat_inap = (!empty(($res[0]->total_penggantian_rawat_inap))) ? (($res[0]->total_penggantian_rawat_inap)) : 0;

		$sql = "SELECT 
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_kacamata,
			SUM(a.penggantian) as total_penggantian_kacamata
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN form_request b ON a.request_id = b.id
		WHERE b.is_status = '3' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '3' AND a.create_date BETWEEN '$start_date' AND '$created_at'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_kacamata = (!empty(($res[0]->total_nominal_kuitansi_kacamata))) ? (($res[0]->total_nominal_kuitansi_kacamata)) : 0;
		$total_penggantian_kacamata = (!empty(($res[0]->total_penggantian_kacamata))) ? (($res[0]->total_penggantian_kacamata)) : 0;

		$pagu_optic_tahun = ($pagu_one_focus_tahun + $pagu_two_focus_tahun + $pagu_frame_dua_tahun);


		$sql = "SELECT 
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_jalan_per_request,
			SUM(a.penggantian) as total_penggantian_rawat_jalan_per_request
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN form_request b ON a.request_id = b.id
		WHERE b.is_status = '3' AND a.request_id LIKE '$form_request_id' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '1' AND a.create_date BETWEEN '$start_date' AND '$created_at'";

		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_rawat_jalan_per_request = (!empty(($res[0]->total_nominal_kuitansi_rawat_jalan_per_request))) ? (($res[0]->total_nominal_kuitansi_rawat_jalan_per_request)) : 0;
		$total_penggantian_rawat_jalan_per_request = (!empty(($res[0]->total_penggantian_rawat_jalan_per_request))) ? (($res[0]->total_penggantian_rawat_jalan_per_request)) : 0;
		

		$sql = "SELECT 
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_inap_per_request,
			SUM(a.penggantian) as total_penggantian_rawat_inap_per_request
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN form_request b ON a.request_id = b.id
		WHERE b.is_status = '3' AND a.request_id LIKE '$form_request_id' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '2' AND a.create_date BETWEEN '$start_date' AND '$created_at'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_rawat_inap_per_request = (!empty(($res[0]->total_nominal_kuitansi_rawat_inap_per_request))) ? (($res[0]->total_nominal_kuitansi_rawat_inap_per_request)) : 0;
		$total_penggantian_rawat_inap_per_request = (!empty(($res[0]->total_penggantian_rawat_inap_per_request))) ? (($res[0]->total_penggantian_rawat_inap_per_request)) : 0;
		

		$sql = "SELECT 
			SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_kacamata_per_request,
			SUM(a.penggantian) as total_penggantian_kacamata_per_request
		FROM		
			hris_medical_reimbursment_item a
		LEFT JOIN form_request b ON a.request_id = b.id
		WHERE b.is_status = '3' AND a.request_id LIKE '$form_request_id' AND a.employee_id LIKE '$employee_id' AND a.tor_grandparent = '3' AND a.create_date BETWEEN '$start_date' AND '$created_at'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$total_nominal_kuitansi_kacamata_per_request = (!empty(($res[0]->total_nominal_kuitansi_kacamata_per_request))) ? (($res[0]->total_nominal_kuitansi_kacamata_per_request)) : 0;
		$total_penggantian_kacamata_per_request = (!empty(($res[0]->total_penggantian_kacamata_per_request))) ? (($res[0]->total_penggantian_kacamata_per_request)) : 0;


		$data = array(
			'pagu_jalan_tahun' => ( $pagu_jalan_tahun ),
			'total_nominal_kuitansi_rawat_jalan' => ( $total_nominal_kuitansi_rawat_jalan),
			'total_nominal_kuitansi_rawat_jalan_per_request' => ( $total_nominal_kuitansi_rawat_jalan_per_request),
			'total_penggantian_rawat_jalan' => ( $total_penggantian_rawat_jalan),
			'total_penggantian_rawat_jalan_per_request' => ( $total_penggantian_rawat_jalan_per_request),
			'balancing_jalan_tahun' => ( $pagu_jalan_tahun - $total_penggantian_rawat_jalan),
			'pagu_inap_tahun' => ( $pagu_inap_tahun ),
			'total_nominal_kuitansi_rawat_inap' => ( $total_nominal_kuitansi_rawat_inap),
			'total_nominal_kuitansi_rawat_inap_per_request' => ( $total_nominal_kuitansi_rawat_inap_per_request),
			'total_penggantian_rawat_inap' => ( $total_penggantian_rawat_inap),
			'total_penggantian_rawat_inap_per_request' => ( $total_penggantian_rawat_inap_per_request),
			'balancing_inap_tahun' => ( $pagu_inap_tahun - $total_penggantian_rawat_inap),
			'pagu_optic_tahun' => ( $pagu_optic_tahun ),
			'total_nominal_kuitansi_kacamata' => ( $total_nominal_kuitansi_kacamata),
			'total_nominal_kuitansi_kacamata_per_request' => ( $total_nominal_kuitansi_kacamata_per_request),
			'total_penggantian_kacamata' => ( $total_penggantian_kacamata),
			'total_penggantian_kacamata_per_request' => ( $total_penggantian_kacamata_per_request),
			'balancing_optic_tahun' => ( $pagu_optic_tahun - $total_penggantian_kacamata),
			'year_created_at' => $year_created_at
		);
		
		return $data;

	}

	public function get_data_employee_current($employee_id, $nik = null){
		if ($nik != null) {
			$sql = "SELECT * FROM hris_employee WHERE nik LIKE '$nik'";
		} else {
			$sql = "SELECT * FROM hris_employee WHERE id_employee LIKE '$employee_id'";
		}
		
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function get_data_employee_base_on_request($request_id){

		$sql = "SELECT *
		FROM		
			form_request 
		WHERE id LIKE '$request_id' AND is_status LIKE '3'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$form_request_id = (!empty(($res[0]->id))) ? (($res[0]->id)) : '';

		$sql = "SELECT *
		FROM		
			hris_medical_reimbursment
		WHERE request_id LIKE '$form_request_id'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		$id_hr_emp = (!empty(($res[0]->id_hr_emp))) ? (decrypt($res[0]->id_hr_emp)) : '';

		$sql = "SELECT * FROM hris_employee WHERE id_employee = '$id_hr_emp'";
		$query = $this->db->query($sql);
		$res = $query->result();
		
		return $res[0];
	}

	public function get_data_claim_per_employee_base_on_nik_or_noreq($nik, $no_ref){

		if((!empty($nik)) && (!empty($no_ref))){
			$sql = "SELECT *
				FROM form_request
				WHERE (employee_id LIKE '$nik' AND no_req_mdcr LIKE '$no_ref') AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";
		}else if((!empty($nik)) && (empty($no_ref))){
			$sql = "SELECT *
				FROM form_request
				WHERE (employee_id LIKE '$nik') AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";
		}else if((empty($nik)) && (!empty($no_ref))){
			$sql = "SELECT *
				FROM form_request
				WHERE (no_req_mdcr LIKE '$no_ref') AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";
		}

		$query = $this->db->query($sql);
		$res 	= $query->result();

		$form_request_id = array();
		foreach ($res as $key) {
			$form_request_id[] = $key->id;
		}
		
		$form_request_no_ref = array();
		foreach ($res as $key) {
			$form_request_no_ref[] = $key->no_req_mdcr;
		}

		$form_request_id = implode(", ",$form_request_id);
		$form_request_no_ref = implode(", ",$form_request_no_ref);
		//dumper($form_request_id);
		$sql = "SELECT 	
				a.id as id,
				a.request_id as request_id,
				e.is_status as is_status,
				b.grandparent as tor_grandparent,
				c.parent as tor_parent,
				d.child as tor_child,
				a.jumlah_kuitansi as jumlah_kuitansi,
				a.total_nominal_kuitansi as total_kuitansi,
				a.penggantian as penggantian,
				a.keterangan as keterangan,
				a.additional as additional,
				a.docter as docter,
				a.diagnosa as diagnosa,
				a.tanggal_kuitansi as tanggal_kuitansi,
				a.create_date as create_date,
				f.id_hr_emp as id_hr_emp,
				e.request_number as request_number,
				e.no_req_mdcr as no_req_mdcr,
				e.employee_id as employee_id
			FROM		
				hris_medical_reimbursment_item a
			LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
			LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
			LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
			LEFT JOIN form_request e ON a.request_id = e.id
			LEFT JOIN hris_medical_reimbursment f ON e.id = f.request_id
			WHERE a.request_id IN($form_request_id) AND e.is_status = '3' AND e.form_type = 'MDCR' AND e.is_status_admin_hr LIKE '1' AND e.is_status_divhead_hr LIKE '1'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		//dumper($res);
		if($res){
			return $res;
		}else{
			return false;
		}
	}

	public function get_data_fi($nik, $no_ref, $tahun = ''){
		// dumper('jeje');
		$test = [
			'nik' => $nik,
			'no_ref' => $no_ref,
			'tahun' => $tahun,
		];

		// dumper($test);
		if (($tahun != null || $tahun != '') && ($no_ref == null || $no_ref == '' || $no_ref == 'HRIS_MDCR')) {
			// dumper('1');

			//================ old ====================
			// $thn = substr($tahun,2,2);
			// $sql = "SELECT *
			// 	FROM form_request
			// 	WHERE employee_id LIKE '$nik' AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
			// 	AND SUBSTRING(no_req_mdcr, 14, 2) = '$thn' ORDER BY id ASC";
				// dumper($sql);
			//================ new ====================
			$sql = "SELECT *
				FROM form_request
				WHERE employee_id LIKE '$nik' AND is_status_progress >= '2' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
				ORDER BY id ASC";

				// dumper($sql);

			$query = $this->db->query($sql);
			$res = $query->result();

			$listReq_id = array();
			foreach ($res as $key) {
				$listReq_id[] = $key->id;
			}

			$form_request_id = join("','",$listReq_id); 
			$sql = "SELECT 	
					a.id as id,
					a.request_id as request_id,
					e.is_status as is_status,
					b.grandparent as tor_grandparent,
					c.parent as tor_parent,
					d.child as tor_child,
					a.jumlah_kuitansi as jumlah_kuitansi,
					a.total_nominal_kuitansi as total_kuitansi,
					a.penggantian as penggantian,
					a.keterangan as keterangan,
					a.additional as additional,
					a.docter as docter,
					a.diagnosa as diagnosa,
					a.tanggal_kuitansi as tanggal_kuitansi,
					a.create_date as create_date,
					f.id_hr_emp as id_hr_emp,
					e.request_number as request_number,
					e.no_req_mdcr as no_req_mdcr,
					e.employee_id as employee_id
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
				LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
				LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
				LEFT JOIN form_request e ON a.request_id = e.id
				LEFT JOIN hris_medical_reimbursment f ON e.id = f.request_id
				WHERE a.request_id IN('$form_request_id') AND e.is_status_progress >= '2' AND e.form_type = 'MDCR' AND e.is_status_admin_hr LIKE '1' AND e.is_status_divhead_hr LIKE '1'
				AND YEAR(a.tanggal_kuitansi) = '$tahun'";
			$query = $this->db->query($sql);
			// dumper($sql);
			$res 	= $query->result();
		} else if (($tahun != null || $tahun != '') && ($no_ref != null || $no_ref != '' || $no_ref != 'HRIS_MDCR')) {

			$old_no_ref = $no_ref;
			// $year_request	=	$tahun;
			//================ old ====================
			// $sql 	= "SELECT id, no_req_mdcr FROM hris_no_req_mdcr WHERE id <= (SELECT a.id FROM hris_no_req_mdcr a LEFT JOIN form_request b ON a.no_req_mdcr LIKE b.no_req_mdcr WHERE b.no_req_mdcr LIKE '$no_ref' AND b.employee_id LIKE '$nik' LIMIT 1) AND is_status LIKE '3' AND year(created_at) LIKE '%$tahun%'";
			//================ new ====================
			$sql 	= "SELECT id, no_req_mdcr FROM hris_no_req_mdcr WHERE id <= (SELECT a.id FROM hris_no_req_mdcr a LEFT JOIN form_request b ON a.no_req_mdcr LIKE b.no_req_mdcr WHERE b.no_req_mdcr LIKE '$no_ref' AND b.employee_id LIKE '$nik' LIMIT 1) AND is_status_progress >= '2'";
			$query 	= $this->db->query($sql);
			$res 	= $query->result();
			// dumper($sql);

			$listNoReq = array();
			foreach ($res as $key) {
				$listNoReq[] = $key->no_req_mdcr;
			}

			$no_ref = join("','",$listNoReq);   

			$sql = "SELECT *
					FROM form_request
					WHERE ((employee_id LIKE '$nik') AND (no_req_mdcr IN ('$no_ref'))) AND is_status_progress >= '2' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
					ORDER BY id ASC";
			// dumper($sql);

			$query = $this->db->query($sql);
			$res = $query->result();

			// $thn = substr($tahun,2,2);
			// $sql = "SELECT *
			// 		FROM form_request
			// 		WHERE ((employee_id LIKE '$nik') AND (no_req_mdcr IN ('$no_ref'))) AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1' AND SUBSTRING(no_req_mdcr, 14, 2) = '$thn'
			// 		ORDER BY id ASC";
			// 		// dumper($sql);
			// $query = $this->db->query($sql);
			// $res = $query->result_array();

			// dumper($res[0]['id']);
			$listReq_id = array();
			foreach ($res as $key) {
				$listReq_id[] = $key->id;
			}

			$form_request_id = join("','",$listReq_id); 
			// $form_request_id = $res[0]['id']; 
			$sql = "SELECT 	
					a.id as id,
					a.request_id as request_id,
					e.is_status as is_status,
					b.grandparent as tor_grandparent,
					c.parent as tor_parent,
					d.child as tor_child,
					a.jumlah_kuitansi as jumlah_kuitansi,
					a.total_nominal_kuitansi as total_kuitansi,
					a.penggantian as penggantian,
					a.keterangan as keterangan,
					a.additional as additional,
					a.docter as docter,
					a.diagnosa as diagnosa,
					a.tanggal_kuitansi as tanggal_kuitansi,
					a.create_date as create_date,
					f.id_hr_emp as id_hr_emp,
					e.request_number as request_number,
					e.no_req_mdcr as no_req_mdcr,
					e.employee_id as employee_id
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
				LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
				LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
				LEFT JOIN form_request e ON a.request_id = e.id
				LEFT JOIN hris_medical_reimbursment f ON e.id = f.request_id
				WHERE a.request_id IN('$form_request_id') AND e.is_status_progress >= '2' AND e.form_type = 'MDCR' AND e.is_status_admin_hr LIKE '1' AND e.is_status_divhead_hr LIKE '1'
				AND YEAR(a.tanggal_kuitansi) = '$tahun'";
				// dumper($sql);
			$query = $this->db->query($sql);
			$res 	= $query->result();
		} else {
			// dumper('3');
			$old_no_ref = $no_ref;
			$sql 	= "SELECT * FROM hris_no_req_mdcr WHERE no_req_mdcr LIKE '$no_ref' AND is_status_progress >= '2'";
			$query 	= $this->db->query($sql);
			$res 	= $query->result();
			$year_request	=	strtotime($res[0]->created_at);
			$year_request	=	date("Y",$year_request);
			$sql 	= "SELECT id, no_req_mdcr FROM hris_no_req_mdcr WHERE id <= (SELECT a.id FROM hris_no_req_mdcr a LEFT JOIN form_request b ON a.no_req_mdcr LIKE b.no_req_mdcr WHERE b.no_req_mdcr LIKE '$no_ref' AND b.employee_id LIKE '$nik' LIMIT 1) AND is_status_progress >= '2' AND year(created_at) LIKE '%$year_request%'";
			$query 	= $this->db->query($sql);
			$res 	= $query->result();

			$listNoReq = array();
			foreach ($res as $key) {
				$listNoReq[] = $key->no_req_mdcr;
			}

			$no_ref = join("','",$listNoReq);   

			$sql = "SELECT *
					FROM form_request
					WHERE ((employee_id LIKE '$nik') AND (no_req_mdcr IN ('$no_ref'))) AND is_status_progress >= '2' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
					ORDER BY id ASC";

			$query = $this->db->query($sql);
			$res = $query->result();

			$listReq_id = array();
			foreach ($res as $key) {
				$listReq_id[] = $key->id;
			}

			$form_request_id = join("','",$listReq_id); 
			// ---- old ----;

			$sql = "SELECT 	
				a.id as id,
				a.request_id as request_id,
				e.is_status as is_status,
				b.grandparent as tor_grandparent,
				c.parent as tor_parent,
				d.child as tor_child,
				a.jumlah_kuitansi as jumlah_kuitansi,
				a.total_nominal_kuitansi as total_kuitansi,
				a.penggantian as penggantian,
				a.keterangan as keterangan,
				a.additional as additional,
				a.docter as docter,
				a.diagnosa as diagnosa,
				a.tanggal_kuitansi as tanggal_kuitansi,
				a.create_date as create_date,
				f.id_hr_emp as id_hr_emp,
				e.request_number as request_number,
				e.no_req_mdcr as no_req_mdcr,
				e.employee_id as employee_id
				FROM		
					hris_medical_reimbursment_item a
				LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
				LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
				LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
				LEFT JOIN form_request e ON a.request_id = e.id
				LEFT JOIN hris_medical_reimbursment f ON e.id = f.request_id
				WHERE a.request_id IN('$form_request_id') AND e.is_status_progress >= '2' AND e.form_type = 'MDCR' AND e.is_status_admin_hr LIKE '1' AND e.is_status_divhead_hr LIKE '1' 
				AND year(a.tanggal_kuitansi) LIKE '%$year_request%'";
				// ---- new ----;

				// $sql = "SELECT 	
				// 		a.id as id,
				// 		a.request_id as request_id,
				// 		e.is_status as is_status,
				// 		b.grandparent as tor_grandparent,
				// 		c.parent as tor_parent,
				// 		d.child as tor_child,
				// 		a.jumlah_kuitansi as jumlah_kuitansi,
				// 		a.total_nominal_kuitansi as total_kuitansi,
				// 		a.penggantian as penggantian,
				// 		a.keterangan as keterangan,
				// 		a.additional as additional,
				// 		a.docter as docter,
				// 		a.diagnosa as diagnosa,
				// 		a.tanggal_kuitansi as tanggal_kuitansi,
				// 		a.create_date as create_date,
				// 		f.id_hr_emp as id_hr_emp,
				// 		e.request_number as request_number,
				// 		e.no_req_mdcr as no_req_mdcr,
				// 		e.employee_id as employee_id
				// 	FROM		
				// 		hris_medical_reimbursment_item a
				// 	LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
				// 	LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
				// 	LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
				// 	LEFT JOIN form_request e ON a.request_id = e.id
				// 	LEFT JOIN hris_medical_reimbursment f ON e.id = f.request_id
				// 	WHERE a.request_id IN('$form_request_id') AND e.is_status = '3' AND e.form_type = 'MDCR' AND e.is_status_admin_hr LIKE '1' AND e.is_status_divhead_hr LIKE '1' AND  e.no_req_mdcr = '$old_no_ref'";

			$query = $this->db->query($sql);
			$res 	= $query->result();
		}
		
		// ---- old ----;
		// $sql = "SELECT 	
		// 		a.id as id,
		// 		a.request_id as request_id,
		// 		e.is_status as is_status,
		// 		b.grandparent as tor_grandparent,
		// 		c.parent as tor_parent,
		// 		d.child as tor_child,
		// 		a.jumlah_kuitansi as jumlah_kuitansi,
		// 		a.total_nominal_kuitansi as total_kuitansi,
		// 		a.penggantian as penggantian,
		// 		a.keterangan as keterangan,
		// 		a.additional as additional,
		// 		a.docter as docter,
		// 		a.diagnosa as diagnosa,
		// 		a.tanggal_kuitansi as tanggal_kuitansi,
		// 		a.create_date as create_date,
		// 		f.id_hr_emp as id_hr_emp,
		// 		e.request_number as request_number,
		// 		e.no_req_mdcr as no_req_mdcr,
		// 		e.employee_id as employee_id
		// 	FROM		
		// 		hris_medical_reimbursment_item a
		// 	LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
		// 	LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
		// 	LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
		// 	LEFT JOIN form_request e ON a.request_id = e.id
		// 	LEFT JOIN hris_medical_reimbursment f ON e.id = f.request_id
		// 	WHERE a.request_id IN('$form_request_id') AND e.is_status = '3' AND e.form_type = 'MDCR' AND e.is_status_admin_hr LIKE '1' AND e.is_status_divhead_hr LIKE '1' AND year(a.tanggal_kuitansi) LIKE '%$year_request%'";

		// ---- new ----;

		// 	$sql = "SELECT 	
		// 		a.id as id,
		// 		a.request_id as request_id,
		// 		e.is_status as is_status,
		// 		b.grandparent as tor_grandparent,
		// 		c.parent as tor_parent,
		// 		d.child as tor_child,
		// 		a.jumlah_kuitansi as jumlah_kuitansi,
		// 		a.total_nominal_kuitansi as total_kuitansi,
		// 		a.penggantian as penggantian,
		// 		a.keterangan as keterangan,
		// 		a.additional as additional,
		// 		a.docter as docter,
		// 		a.diagnosa as diagnosa,
		// 		a.tanggal_kuitansi as tanggal_kuitansi,
		// 		a.create_date as create_date,
		// 		f.id_hr_emp as id_hr_emp,
		// 		e.request_number as request_number,
		// 		e.no_req_mdcr as no_req_mdcr,
		// 		e.employee_id as employee_id
		// 	FROM		
		// 		hris_medical_reimbursment_item a
		// 	LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.tor_grandparent = b.id
		// 	LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.tor_parent = c.id
		// 	LEFT JOIN hris_medical_type_of_reimbursment_child d ON a.tor_child = d.id
		// 	LEFT JOIN form_request e ON a.request_id = e.id
		// 	LEFT JOIN hris_medical_reimbursment f ON e.id = f.request_id
		// 	WHERE a.request_id IN('$form_request_id') AND e.is_status = '3' AND e.form_type = 'MDCR' AND e.is_status_admin_hr LIKE '1' AND e.is_status_divhead_hr LIKE '1' AND  e.no_req_mdcr = '$old_no_ref'";
		// $query = $this->db->query($sql);
		// $res 	= $query->result();
		// dumper($res);

		if($res){
			return $res;
		}else{
			return false;
		}

	}


	public function get_data_fi_awal($nik, $no_ref, $tahun=''){
		if (($tahun != '' || $tahun != null) && ($no_ref == null || $no_ref == '' || $no_ref == 'HRIS_MDCR')) {
			// dumper('jeje');
			//================ old ====================
			// $thn = substr($tahun,2,2);
			// $sql3 = "SELECT *
			// 	FROM form_request
			// 	WHERE employee_id LIKE '$nik' AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
			// 	AND SUBSTRING(no_req_mdcr, 14, 2) = '$thn' ORDER BY id ASC";
			//================ new ====================
			$sql3 = "SELECT *
				FROM form_request a
				LEFT JOIN hris_medical_reimbursment_item b on a.id = b.request_id
				WHERE a.employee_id LIKE '$nik' AND a.is_status_progress >= '2' AND a.form_type = 'MDCR' AND a.is_status_admin_hr LIKE '1' AND a.is_status_divhead_hr LIKE '1'
				AND YEAR(b.tanggal_kuitansi) = '$tahun'
				ORDER BY a.id ASC";
			$query = $this->db->query($sql3);
			$res3 = $query->result_array();
			
		} else if (($tahun != '' || $tahun != null) && ($no_ref != null || $no_ref != '' || $no_ref != 'HRIS_MDCR')) {
			// dumper('ciojw');

			// $year_request	=	$tahun;
			//=================== old ===================
			// $sql2 	= "SELECT id, no_req_mdcr FROM hris_no_req_mdcr WHERE id <= (SELECT a.id FROM hris_no_req_mdcr a LEFT JOIN form_request b ON a.no_req_mdcr LIKE b.no_req_mdcr WHERE b.no_req_mdcr LIKE '$no_ref' AND b.employee_id LIKE '$nik' LIMIT 1) AND is_status LIKE '3' AND year(created_at) LIKE '%$year_request%'";
			// $query 	= $this->db->query($sql2);
			// $res2 	= $query->result();
			//=================== new ===================
			$sql2 	= "SELECT id, no_req_mdcr FROM hris_no_req_mdcr WHERE id <= (SELECT a.id FROM hris_no_req_mdcr a LEFT JOIN form_request b ON a.no_req_mdcr LIKE b.no_req_mdcr WHERE b.no_req_mdcr LIKE '$no_ref' AND b.employee_id LIKE '$nik' LIMIT 1) AND is_status_progress >= '2'";
			$query 	= $this->db->query($sql2);
			$res2 	= $query->result();
			$listNoReq = array();
			foreach ($res2 as $key) {
				$listNoReq[] = $key->no_req_mdcr;
			}

			$no_ref = join("','",$listNoReq);  
			//=================== old =================== 
			// $thn = substr($tahun,2,2);
			// $sql3 = "SELECT *
			// 		FROM form_request
			// 		WHERE ((employee_id LIKE '$nik') AND (no_req_mdcr IN ('$no_ref'))) AND is_status = '3' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1' AND SUBSTRING(no_req_mdcr, 14, 2) = '$thn'
			// 		ORDER BY id ASC";
			//=================== new ===================
			$sql3 = "SELECT *
					FROM form_request a
					LEFT JOIN hris_medical_reimbursment_item b on a.id = b.request_id
					WHERE ((a.employee_id LIKE '$nik') AND (a.no_req_mdcr IN ('$no_ref'))) AND a.is_status_progress >= '2' AND a.form_type = 'MDCR' AND a.is_status_admin_hr LIKE '1' AND a.is_status_divhead_hr LIKE '1' AND YEAR(b.tanggal_kuitansi) = '$tahun'
					ORDER BY a.id ASC";
			// dumper($sql3);

			$query = $this->db->query($sql3);
			$res3 = $query->result_array();
			
		} else {

			$sql 	= "SELECT * FROM hris_no_req_mdcr WHERE no_req_mdcr LIKE '$no_ref' AND is_status_progress >= '2'";
			$query 	= $this->db->query($sql);
			$res 	= $query->result();
			// dumper($sql);

			if(empty($res)){
				$year_request	= '0000';
			}else{
				$year_request	=	strtotime($res[0]->created_at);
				$year_request	=	date("Y",$year_request);
			}

			$sql2 	= "SELECT id, no_req_mdcr FROM hris_no_req_mdcr WHERE id <= (SELECT a.id FROM hris_no_req_mdcr a LEFT JOIN form_request b ON a.no_req_mdcr LIKE b.no_req_mdcr WHERE b.no_req_mdcr LIKE '$no_ref' AND b.employee_id LIKE '$nik' LIMIT 1) AND is_status_progress >= '2' AND year(created_at) LIKE '%$year_request%'";
			$query 	= $this->db->query($sql2);
			$res2 	= $query->result();

			$listNoReq = array();
			foreach ($res2 as $key) {
				$listNoReq[] = $key->no_req_mdcr;
			}

			$no_ref = join("','",$listNoReq);   
			
			$sql3 = "SELECT *
					FROM form_request
					WHERE ((employee_id LIKE '$nik') AND (no_req_mdcr IN ('$no_ref'))) AND is_status_progress >= '2' AND form_type = 'MDCR' AND is_status_admin_hr LIKE '1' AND is_status_divhead_hr LIKE '1'
					ORDER BY id ASC";
			// dumper($sql3);

			$query = $this->db->query($sql3);
			$res3 = $query->result_array();
		}
		

		// dumper($sql3);

		$data = array();
		foreach ($res3 as $key) {
			$nik = $key['employee_id'];
			$request_number = $key['request_number'];
			$sqll = "SELECT id_employee, complete_name FROM hris_employee WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryy = $this->db->query($sqll);
			$complete_name = $queryy->result();
			$row   = array();

			$row['id'] =  $key['id'];
			$row['request_number'] =  $key['request_number'];
			$row['form_type'] =  $key['form_type'];
			$row['form_purpose'] =  $key['form_purpose'];
			$row['form_notes'] =  $key['form_notes'];
			$row['approval_form_scanned'] =  $key['approval_form_scanned'];
			$row['approved_date'] =  $key['approved_date'];
			$row['result_document'] =  $key['result_document'];
			$row['is_status'] =  $key['is_status'];
			$row['is_status_progress'] =  $key['is_status_progress'];
			$row['created_by'] =  $key['created_by'];
			$row['created_at'] =  $key['created_at'];
			$row['updated_by'] =  $key['updated_by'];
			$row['updated_at'] =  $key['updated_at'];
			$row['deleted_by'] =  $key['deleted_by'];
			$row['deleted_at'] =  $key['deleted_at'];
			$row['employee_id'] =  $key['employee_id'];
			$row['no_req_mdcr'] =  $key['no_req_mdcr'];
			$row['complete_name'] =  $complete_name[0]->complete_name;
			
			$data[] = $row;
			//$data[] = (object)$row;
		}
		
		if($data){
			return $data;
		}else{
			return false;
		}

	}


	public function get_data_pagu($employee_id, $fi_year=""){

		$today 		= $this->today;
		$year 		= (!empty(($fi_year))) ? ($fi_year) : date("Y");

		$sql_eg = "SELECT 	
						employee_group as employee_group,
						start_date as start_date,
						reason_of_action as reason_of_action,
						join_date as join_date
					FROM		
						hris_employee
					WHERE nik = '$employee_id' ORDER BY id_employee DESC";
					
		$query_eg 				= $this->db->query($sql_eg);
		$res_eg					= $query_eg->result();
		$res_eg 				= $this->my_array_unique($res_eg);

		$no = 1;
		$result = [];

		foreach ($res_eg as $rown) {
			$rowArray = (array) $rown;
			$rowArray['no'] = $no++;
			$result[] = $rowArray;
		}

		$res_eg = $result;
		

		$data_eg = [];
		foreach($res_eg as $idx){
			$year_eg_sd = str_replace('-', '', (string) decrypt($idx['start_date']));
			$year_eg_sd = (int) substr($year_eg_sd, 0, 4);
			
			if(($year == $year_eg_sd) && (decrypt($idx['reason_of_action']) == 'Promosi')){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];

				$get_before = $idx['no'] + 1;
				foreach ($res_eg as $rowb) {
					if ($rowb->no == $get_before) {
						$data_before = $rowb;
						break;
					}
				}

				if (!empty($data_before)) {
					$data_eg[] = [
						'employee_group'     => $data_before['employee_group'],
						'start_date'         => $data_before['start_date'],
						'reason_of_action'   => $data_before['reason_of_action'],
						'join_date'   		 => $data_before['join_date']
					];
				}
			}elseif(($year == $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year < $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}elseif(($year > $year_eg_sd)){
				$data_eg[] = [
					'employee_group'           	=> $idx['employee_group'],
					'start_date' 				=> $idx['start_date'],
					'reason_of_action'   		=> $idx['reason_of_action'],
					'join_date'   				=> $idx['join_date']
				];
			}
		}

		
		$res_eg_new 			= decrypt($data_eg[0]['employee_group']);
		$res_sd_new 			= decrypt($data_eg[0]['start_date']);
		$res_jd_new    			= decrypt($data_eg[0]['join_date']);
		$reason_of_action		= decrypt($data_eg[0]['reason_of_action']);
		$res_eg_old 			= (!empty(($data_eg[1]['employee_group']))) ? decrypt(($data_eg[1]['employee_group'])) : '';
		

		$sql2new = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query2new 	= $this->db->query($sql2new);
		$res2new 	= $query2new->result();
		$pagu_jalan_tahun_new 	= (!empty(($res2new[0]->pagu_tahun))) ? ($res2new[0]->pagu_tahun) : 0;

		$sql3new = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
		$query3new 	= $this->db->query($sql3new);
		$res3new 	= $query3new->result();
		$pagu_inap_tahun_new 	= (!empty(($res3new[0]->pagu_tahun))) ? ($res3new[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_new 	= (!empty(($res3new[0]->pagu_kamar_hari))) ? ($res3new[0]->pagu_kamar_hari) : 0;
		
		
		$sql2old = "SELECT 	
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_jalan
				WHERE grade = '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query2old 	= $this->db->query($sql2old);
		$res2old 	= $query2old->result();
		$pagu_jalan_tahun_old 	= (!empty(($res2old[0]->pagu_tahun))) ? ($res2old[0]->pagu_tahun) : 0;

		$sql3old = "SELECT 	
					pagu_kamar_hari as pagu_kamar_hari,
					pagu_tahun as pagu_tahun
				FROM		
					hris_medical_pagu_rawat_inap
				WHERE grade LIKE '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
		$query3old 	= $this->db->query($sql3old);
		$res3old 	= $query3old->result();
		$pagu_inap_tahun_old 	= (!empty(($res3old[0]->pagu_tahun))) ? ($res3old[0]->pagu_tahun) : 0;
		$pagu_inap_kamar_old 	= (!empty(($res3old[0]->pagu_kamar_hari))) ? ($res3old[0]->pagu_kamar_hari) : 0;

		$start_date = DateTime::createFromFormat('Ymd', $res_sd_new);
		$start_date = $start_date->format('Y');

		if( ($start_date == $year) && (!empty($res_eg_old)) && ($reason_of_action == 'Promosi') ){

			$yearOld = $year-1;
			$yearNew = $year+1;
			$tgl1 = $yearOld."-12-31";
			$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
			$tgl2 = $tgl2->format('Y-m-d');
			$tgl22 = date('Y-m-d', strtotime('-1 days', strtotime($tgl2)));
    		$tgl3 = $yearNew."-01-01";

			$diff_old                = abs(strtotime($tgl22) - strtotime($tgl1));

			$join_years_old          = floor($diff_old / (365*60*60*24));
			$join_months_old         = floor(($diff_old - $join_years_old * 365*60*60*24) / (30*60*60*24));
			$join_days_old         	 = round($diff_old / (60 * 60 * 24));

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));
			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun_old = ((!empty(($pagu_inap_tahun_old))) ? ($pagu_inap_tahun_old) : 0);
			$pagu_pro_inap_tahun_old = ($join_days_old/365)* $pagu_inap_tahun_old;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new + $pagu_pro_inap_tahun_old;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun_old = ((!empty($pagu_jalan_tahun_old)) ? ($pagu_jalan_tahun_old) : 0);
			$pagu_pro_jalan_tahun_old = ($join_days_old/365) * $pagu_jalan_tahun_old;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new + $pagu_pro_jalan_tahun_old;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;
			

		}else if( ($start_date == $year) AND ($reason_of_action == 'Hiring') ){

			$yearNew = $year+1;
			$tgl2 = DateTime::createFromFormat('Ymd', $res_sd_new);
			$tgl2 = $tgl2->format('Y-m-d');
    		$tgl3 = $yearNew."-01-01";

			
			$diff_new                = abs(strtotime($tgl3) - strtotime($tgl2));
			$join_years_new          = floor($diff_new / (365*60*60*24));
			$join_months_new         = floor(($diff_new - $join_years_new * 365*60*60*24) / (30*60*60*24));
			$join_days_new         	 = round($diff_new / (60 * 60 * 24));
			
			$pagu_pro_inap_tahun_new = ($join_days_new/365)* $pagu_inap_tahun_new;
			$pagu_inap_tahun = $pagu_pro_inap_tahun_new;
			
			$pagu_pro_jalan_tahun_new = ($join_days_new/365) * $pagu_jalan_tahun_new;
			$pagu_jalan_tahun = $pagu_pro_jalan_tahun_new;

			$pagu_inap_kamar 	= $pagu_inap_kamar_new;
			

		}else{

			if(($year == $start_date) || ($year < $start_date)){
				$pagu_jalan_tahun	= $pagu_jalan_tahun_old;
				$pagu_inap_tahun	= $pagu_inap_tahun_old;
				$pagu_inap_kamar 	= $pagu_inap_kamar_old;

			}else{
				$pagu_jalan_tahun	= $pagu_jalan_tahun_new;
				$pagu_inap_tahun	= $pagu_inap_tahun_new;
				$pagu_inap_kamar 	= $pagu_inap_kamar_new;

			}

		}

		$sql4 = "SELECT 	
					pagu_one_focus_tahun as pagu_one_focus_tahun,
					pagu_two_focus_tahun as pagu_two_focus_tahun,
					pagu_frame_dua_tahun as pagu_frame_dua_tahun
				FROM		
					hris_medical_pagu_kacamata
				WHERE grade = '$res_eg_new' AND start_date <= '$today' AND end_date > '$today'";
		$query4 = $this->db->query($sql4);
		$res4 	= $query4->result();
		$pagu_one_focus_tahun 	= $res4[0]->pagu_one_focus_tahun;
		$pagu_two_focus_tahun 	= $res4[0]->pagu_two_focus_tahun;
		$pagu_frame_dua_tahun 	= $res4[0]->pagu_frame_dua_tahun;

		$pagu_optic_tahun = ($pagu_one_focus_tahun + $pagu_two_focus_tahun + $pagu_frame_dua_tahun);


		$data = array(
			'pagu_jalan_tahun' => ( $pagu_jalan_tahun ),
			'pagu_inap_tahun' => ( $pagu_inap_tahun ),
			'pagu_optic_tahun' => ( $pagu_optic_tahun )
		);
		
		return $data;

	}



	public function my_array_unique($array, $keep_key_assoc = false){
		$duplicate_keys = array();
		$tmp = array();       
	
		foreach ($array as $key => $val){
			if (is_object($val))
				$val = (array)$val;
	
			if (!in_array($val, $tmp))
				$tmp[] = $val;
			else
				$duplicate_keys[] = $key;
		}
	
		foreach ($duplicate_keys as $key)
			unset($array[$key]);
	
		return $keep_key_assoc ? $array : array_values($array);
	}


	public function get_data_fi_total($form_request_id, $fi_year){
		$sql = "SELECT 	
				SUM(CASE
						WHEN tor_grandparent = '1'
							THEN penggantian
						ELSE 0
					END)  as sum_penggantian_jalan,
				SUM(CASE
					WHEN tor_grandparent = '2'
						THEN penggantian
					ELSE 0
				END)  as sum_penggantian_inap,
				SUM(CASE
					WHEN tor_grandparent = '3'
						THEN penggantian
					ELSE 0
				END)  as sum_penggantian_kacamata
			FROM		
				hris_medical_reimbursment_item
			WHERE request_id IN('$form_request_id') AND year(tanggal_kuitansi) LIKE '%$fi_year%'";
		$query = $this->db->query($sql);
		$res 	= $query->result();
		// dumper($sql);
		if($res){
			return $res;
		}else{
			return false;
		}

	}

	////////////////////////////////////////// START TIME MANAGEMENT 2024 //////////////////////////////////////////

	public function getAttendance_ztm($nik, $company_code='', $data='', $filter=''){
		$date = $this->today;
		$start_date = date('Y-m-01');
		$kode = encrypt($company_code);

		if(empty($data)){
			if($this->session->userdata('access_employee') == 12 || $this->session->userdata('access_level') == 5 || $this->session->userdata('access_level') == 6 || $this->session->userdata('access_level') == 7){
				
				$sql = "SELECT a.*, b.personnel_area, b.personnel_subarea FROM hris_master_time_management a
						LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
						WHERE a.employee_id IS NOT NULL AND date='$date' 
						AND b.company_code='$kode' ORDER BY id ASC";
			} else {
				$sql = "SELECT a.*, b.personnel_area, b.personnel_subarea FROM hris_master_time_management a
						LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
						 WHERE a.employee_id = '$nik' AND (date BETWEEN '$start_date' AND '$date') ORDER BY id ASC";
			}

			$query = $this->db->query($sql);
			$result = $query->result();
			return $result;
			
		} else if (!empty($data)){
			// $temp = $sentence = $start_date = $end_date = '';
			// $nik; $nik2;

			// for ($x = 0; $x < strlen($data); $x++){
			// 	if ($data[$x] == '-'){
			// 		$temp = substr($temp, 0, strlen($temp)-1);
			// 		if ($data[$x-1] == 'i'){
			// 			$nik = $temp;
			// 			$temp = '';
			// 			$sentence .= "AND a.employee_id LIKE '%$nik%'";
			// 		} else if ($data[$x-1] == 'n'){
			// 			$nik2 = $temp;
			// 			$temp = '';
			// 			if ($sentence[4] != '('){
			// 				$sentence = substr_replace($sentence, '(', 4, 0);
			// 			}
			// 			if ($sentence[-1] == ')'){
			// 				$sentence = rtrim($sentence, ')');
			// 			} 
			// 			$sentence .= " OR a.employee_id LIKE '%$nik2%')";
						
			// 		} else if ($data[$x-1] == 's'){
			// 			$start_date = DateTime::createFromFormat('Ymd', $temp)->format('Y-m-d');
			// 			$temp = '';
			// 		} else if ($data[$x-1] == 'e'){
			// 			$end_date = DateTime::createFromFormat('Ymd',$temp)->format('Y-m-d');
			// 			$temp = '';
			// 		}
			// 	} else if ($data[$x] == '?') {
			// 		$temp .= ' ';
			// 	} else {
			// 		$temp .= $data[$x];
			// 	}
			// }

			$start_date = '';
			$end_date = '';
			$sentence = '';
			$temp = '';
			$matches = [];

			// Tambahkan "-" di akhir untuk memastikan parsing terakhir tetap jalan
			$data .= '-';

			// Cari semua pola yang berakhiran dengan i/n/s/e
			preg_match_all('/([^-]+)([inse])-/i', $data, $matches, PREG_SET_ORDER);

			foreach ($matches as $match) {
				$value = $match[1];
				$flag  = $match[2];

				switch ($flag) {
					case 'i':
						$sentence .= "AND a.employee_id LIKE '%$value%'";
						break;
					case 'n':
						if (strpos($sentence, '(') === false) {
							$sentence = substr_replace($sentence, '(', 4, 0); // setelah 'AND '
						}
						$sentence = rtrim($sentence, ')');
						$sentence .= " OR a.employee_id LIKE '%$value%')";
						break;
					case 's':
						$start_date = DateTime::createFromFormat('Ymd', $value)->format('Y-m-d');
						break;
					case 'e':
						$end_date = DateTime::createFromFormat('Ymd', $value)->format('Y-m-d');
						break;
				}
			}			



			if (!empty($start_date) && !empty($end_date)){
				$jarak = strtotime($end_date) - strtotime($start_date);
				$jarak_hari = $jarak / 60 / 60 / 24; 
			} else {
				$jarak_hari = 0;
			}

			$filter_data = json_decode(rawurldecode($filter));
			$filter_data = str_replace(array('^', '_'), array('(', ')'), $filter_data);
			if (!empty($filter_data[0])){
				$depart = encrypt($filter_data[0]);
				$sentence .= "AND b.department LIKE '%$depart%'";
			}
			if (!empty($filter_data[1])){
				$division = encrypt($filter_data[1]);
				$sentence .= "AND b.division LIKE '%$division%'";
			}
			if (!empty($filter_data[2])){
				$directorate = encrypt($filter_data[2]);
				$sentence .= "AND b.directorate LIKE '%$directorate%'";
			}

			if ($jarak_hari > 20) { 
				$data = array();
				
				$monthRange = getMonthRanges($start_date, $end_date);
				
				for($i = 0; $i < count($monthRange); $i++){
					$new_start_date = $monthRange[$i]['start'];
					$new_end_date = $monthRange[$i]['end'];
					$sentenceDate = " AND a.date BETWEEN '$new_start_date' AND '$new_end_date'"; 
					$sentence .= $sentenceDate;

					// $this->db->initialize();
					// $sql = "DECLARE @PageNumber AS INT
					// 		DECLARE @RowsOfPage AS INT
					// 		DECLARE @MaxTablePage AS FLOAT
					// 		SET @PageNumber=1
					// 		SET @RowsOfPage=15000
					// 		SELECT @MaxTablePage = COUNT(*) FROM hris_master_time_management a WHERE a.employee_id IS NOT NULL " . $sentence . "
					// 		SET @MaxTablePage = CEILING(@MaxTablePage/@RowsOfPage)
					// 		WHILE @MaxTablePage >= @PageNumber
					// 		BEGIN
					// 			SELECT a.*, b.personnel_area, b.personnel_subarea FROM hris_master_time_management a
					// 			LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
					// 			WHERE a.employee_id IS NOT NULL " . $sentence . " 
					// 			AND b.company_code='$kode'
					// 			ORDER BY id ASC
					// 			OFFSET (@PageNumber-1)*@RowsOfPage ROWS
					// 			FETCH NEXT @RowsOfPage ROWS ONLY
					// 			SET @PageNumber = @PageNumber+1
					// 		END";

					$sql = "SELECT a.*, b.personnel_area, b.personnel_subarea FROM hris_master_time_management a
							LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
							WHERE a.employee_id IS NOT NULL " . $sentence . " 
							AND b.company_code='$kode' ORDER BY id ASC";
							
					$query = $this->db->query($sql); 
					
					while ($row = $query->unbuffered_row())
					{
						$data[]=$row; 
					}
					$sentence = str_replace($sentenceDate, '', $sentence);
					// $this->db->close();
				}
				return $data;

			} else {
				if (!empty($start_date) && !empty($end_date)){
					$sentence .= " AND a.date BETWEEN '$start_date' AND '$end_date'";
				} else if (!empty($start_date) && empty($end_date)){
					$sentence .= " AND a.date = '$start_date'";
				} else {
					$sentence .= " AND a.date <= '$date'";
				}

				$sql = "SELECT a.*, b.personnel_area, b.personnel_subarea FROM hris_master_time_management a
						LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
						WHERE a.employee_id IS NOT NULL " . $sentence . " 
						AND b.company_code='$kode' ORDER BY id ASC";

				$query = $this->db->query($sql);
				$result = $query->result();
				return $result;
			}
		}
	}

	public function attendanceAnalysis_ztm($company_code, $data='', $filter_data=''){
		$date = $this->today;
		if($data == ''){
			$sql = "SELECT 
						SUM(CASE 
							WHEN a.attendance_status = 'on_time' 
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS Aman,

						SUM(CASE 
							WHEN a.attendance_status = 'late_in' 
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS Telat,

						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in is not null THEN 1 ELSE 0 END) AS yes_in,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out is not null THEN 1 ELSE 0 END) AS yes_out,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_in,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_out,

						SUM(CASE WHEN a.time_off_code like 'C%'  THEN 1 ELSE 0 END) AS Ijin,
						SUM(CASE WHEN a.time_off_code = 'S' THEN 1 ELSE 0 END) AS Sakit,

						SUM(
							CASE 
								-- full cuti tahunan
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'CUTI TAHUNAN'
									AND b.status IN (0,1)
								)
								THEN 1

								-- setengah hari
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'Cuti Tahunan Setengah Hari'
									AND b.status IN (0,1)
								)
								THEN 0.5

								WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
								THEN 1 ELSE 0 
							END) AS hari_kerja_sch,

						SUM(
							CASE 
								-- full cuti tahunan dan perjalanan dinas
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND (b.jenis = 'CUTI TAHUNAN' OR b.jenis = 'PERJALANAN DINAS')
									AND b.status IN (0,1)
								)
								THEN 1

								-- setengah hari
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'Cuti Tahunan Setengah Hari'
									AND b.status IN (0,1)
								)
								THEN 0.5

								-- normal hadir
								WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NOT NULL 
								THEN 1

								ELSE 0 
							END
						) AS hari_kerja_act,

						ROUND(
							SUM(
								CASE 
									WHEN a.schedule_code LIKE 'N%' 
									OR a.schedule_code LIKE 'SHF%' 
									THEN GREATEST(
										TIMESTAMPDIFF(SECOND, a.schedule_in, a.schedule_out),
										0
									)
									ELSE 0
								END
							) / 3600
						, 2) AS jam_kerja_sch,

						SUM(COALESCE(a.working_hours_d, 0.00)) AS jam_kerja_act,

						--    sum(case when a.kehadiran != 'off' and a.kehadiran != 'skip' or a.kehadiran IS null then 1 else 0 end) as Active,
						COUNT(distinct a.employee_id) as EMP
					FROM hris_master_time_management a 
					LEFT JOIN v_hris_nik_company c 
							ON a.employee_id = c.nik
					WHERE a.date = '$date' AND c.company_code='$company_code'"; 
		} else {

			// $temp = $sentence = $start_date = $end_date = '';
			// $nik; $nik2;

			
			// for ($x = 0; $x < strlen($data); $x++){
			// 	if ($data[$x] == '-'){
			// 		$temp = substr($temp, 0, strlen($temp)-1);
			// 		if ($data[$x-1] == 'i'){
			// 			$nik = $temp;
			// 			$temp = '';
			// 			$sentence .= "AND a.nik LIKE '%$nik%'";
			// 		} else if ($data[$x-1] == 'n'){
			// 			$nik2 = $temp;
			// 			$temp = '';
			// 			if ($sentence[4] != '('){
			// 				$sentence = substr_replace($sentence, '(', 4, 0);
			// 			}
			// 			if ($sentence[-1] == ')'){
			// 				$sentence = rtrim($sentence, ')');
			// 			} 
			// 			$sentence .= " OR a.nik LIKE '%$nik2%')";
			// 		} else if ($data[$x-1] == 's'){
			// 			$start_date = DateTime::createFromFormat('Ymd', $temp)->format('Y-m-d');
			// 			$temp = '';
			// 		} else if ($data[$x-1] == 'e'){
			// 			$end_date = DateTime::createFromFormat('Ymd',$temp)->format('Y-m-d');
			// 			$temp = '';
			// 		}
			// 	} else if ($data[$x] == '?') {
			// 		$temp .= ' ';
			// 	} else {
			// 		$temp .= $data[$x];
			// 	}
			// }

			$start_date = '';
			$end_date = '';
			$sentence = '';
			$temp = '';
			$matches = [];

			// Tambahkan "-" di akhir untuk memastikan parsing terakhir tetap jalan
			$data .= '-';

			// Cari semua pola yang berakhiran dengan i/n/s/e
			preg_match_all('/([^-]+)([inse])-/i', $data, $matches, PREG_SET_ORDER);

			foreach ($matches as $match) {
				$value = $match[1];
				$flag  = $match[2];

				switch ($flag) {
					case 'i':
						$sentence .= "AND a.employee_id LIKE '%$value%'";
						break;
					case 'n':
						if (strpos($sentence, '(') === false) {
							$sentence = substr_replace($sentence, '(', 4, 0); // setelah 'AND '
						}
						$sentence = rtrim($sentence, ')');
						$sentence .= " OR a.employee_id LIKE '%$value%')";
						break;
					case 's':
						$start_date = DateTime::createFromFormat('Ymd', $value)->format('Y-m-d');
						break;
					case 'e':
						$end_date = DateTime::createFromFormat('Ymd', $value)->format('Y-m-d');
						break;
				}
			}
			// dumper($data." - ".$start_date." - ".$end_date);
			if (!empty($start_date) && !empty($end_date)){
				$sentence .= "AND a.date BETWEEN '$start_date' AND '$end_date'";
			} else if (!empty($start_date) && empty($end_date)){
				$sentence .= "AND a.date = '$start_date'";
			} else {
				$sentence .= "AND a.date <= '$date'";
			}


			$filter_data = str_replace(array('^', '_'), array('(', ')'), $filter_data);
			if (!empty($filter_data[0])){
				$depart = encrypt($filter_data[0]);
				$sentence .= "AND c.department LIKE '%$depart%'";
			}
			if (!empty($filter_data[1])){
				$division = encrypt($filter_data[1]);
				$sentence .= "AND c.division LIKE '%$division%'";
			}
			if (!empty($filter_data[2])){
				$directorate = encrypt($filter_data[2]);
				$sentence .= "AND c.directorate LIKE '%$directorate%'";
			} 
			
			$sql = "SELECT 
						SUM(CASE 
							WHEN a.attendance_status = 'on_time'
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS Aman,

						SUM(CASE 
							WHEN a.attendance_status = 'late_in' 
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%'
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS Telat,

						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in is not null THEN 1 ELSE 0 END) AS yes_in,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out is not null THEN 1 ELSE 0 END) AS yes_out,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_in,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_out,

						SUM(CASE WHEN a.time_off_code like 'C%'  THEN 1 ELSE 0 END) AS Ijin,
						SUM(CASE WHEN a.time_off_code = 'S' THEN 1 ELSE 0 END) AS Sakit,

						SUM(
							CASE 
								-- full cuti tahunan
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'CUTI TAHUNAN'
									AND b.status IN (0,1)
								)
								THEN 1

								-- setengah hari
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'Cuti Tahunan Setengah Hari'
									AND b.status IN (0,1)
								)
								THEN 0.5
								WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
								THEN 1 ELSE 0 
							END) AS hari_kerja_sch,

						SUM(
							CASE 
								-- full cuti tahunan dan perjalanan dinas
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off d
									WHERE d.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN d.start_date AND d.end_date
									AND (d.jenis = 'CUTI TAHUNAN' OR d.jenis = 'PERJALANAN DINAS')
									AND d.status IN (0,1)
								)
								THEN 1

								-- setengah hari
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off d
									WHERE d.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN d.start_date AND d.end_date
									AND d.jenis = 'Cuti Tahunan Setengah Hari'
									AND d.status IN (0,1)
								)
								THEN 0.5

								-- normal hadir
								WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NOT NULL 
								THEN 1

								ELSE 0 
							END
						) AS hari_kerja_act,

						ROUND(
							SUM(
								CASE 
									WHEN a.schedule_code LIKE 'N%' 
									OR a.schedule_code LIKE 'SHF%' 
									THEN GREATEST(
										TIMESTAMPDIFF(SECOND, a.schedule_in, a.schedule_out),
										0
									)
									ELSE 0
								END
							) / 3600
						, 2) AS jam_kerja_sch,

						SUM(COALESCE(a.working_hours_d, 0.00)) AS jam_kerja_act,

						--    sum(case when a.kehadiran != 'off' and a.kehadiran != 'skip' or a.kehadiran IS null then 1 else 0 end) as Active,
						COUNT(distinct a.employee_id) as EMP
					FROM hris_master_time_management a 
					LEFT JOIN v_hris_nik_company b ON a.employee_id = b.nik
					LEFT JOIN v_hris_employee_updated c ON a.employee_id = c.nik
					WHERE a.employee_id IS NOT NULL " . $sentence . "AND b.company_code = '$company_code'";
		}
		

		$query = $this->db->query($sql);
		$result = $query->result_array();
		
		if (!empty($result)) {
			
			$data = [$result[0]['yes_in'], $result[0]['yes_out'], $result[0]['no_in'], $result[0]['no_out'], $result[0]['Ijin'] ,$result[0]['Aman'], $result[0]['Telat'], $result[0]['Sakit'], $result[0]['hari_kerja_sch'], $result[0]['hari_kerja_act'], $result[0]['jam_kerja_sch'], $result[0]['jam_kerja_act'], $result[0]['EMP']];
		} else {
			$data = 0;
		}
		return $data;
	}

	public function getCalendarEvents_ztm(){
		$data = [];
		// COMMENT: SQL SYNTAX
		// SELECT date, holiday_calendar FROM hris_master_calendar WHERE holiday_calendar IS NOT NULL
		$sqlCalendarHoliday = "SELECT dws_code, date, holiday_calendar FROM hris_master_calendar WHERE holiday_calendar NOT LIKE ''";
		$queryCalendarHoliday = $this->db->query($sqlCalendarHoliday);
		foreach($queryCalendarHoliday->result_array() as $value){
			if ($value['dws_code'] == 'DO'){
				$calendar_color = '#eb1a1a';
			} else {
				$calendar_color = '#7242f5';
			}
			$holiday_array = [1, $value['date'], $value['holiday_calendar'], $calendar_color];
			array_push($data, $holiday_array); 
		}
		// SELECT a.start_date, a.end_date, a.nik, b.complete_name, a.jenis 
		//   FROM hris_request_time_off a 
		//   LEFT JOIN v_hris_employee_updated b ON a.nik = b.nik
		//   WHERE status = 1
		$sqlCalendarTO = "SELECT a.start_date, a.end_date, b.complete_name, a.jenis
						  FROM hris_request_time_off a
						  LEFT JOIN v_hris_employee_updated b ON a.nik = b.nik
						  WHERE status = 1 AND jenis!='Request Attendance'";
		$queryCalendarTO = $this->db->query($sqlCalendarTO);
		foreach($queryCalendarTO->result_array() as $value){
			$to_array = [2, ucwords(strtolower(decrypt($value['complete_name']))), $value['jenis'], $value['start_date'], $value['end_date']];
			array_push($data, $to_array); 
		}
		// SELECT complete_name, date_of_birth FROM v_hris_employee_updated 
		$status = encrypt('Leaving');
		$sqlCalendarBDY = "SELECT complete_name, date_of_birth FROM v_hris_employee_updated WHERE action!='$status'";
		$queryCalendarBDY = $this->db->query($sqlCalendarBDY);
		// dumper($queryCalendarBDY);
		foreach($queryCalendarBDY->result_array() as $value){
			$date_of_birth = decrypt($value['date_of_birth']);
			$date_of_birth = DateTime::createFromFormat('Ymd', $date_of_birth);
			$date_of_birth = $date_of_birth->format('m/d/Y');
			$birthday_array = [3, ucwords(strtolower(decrypt($value['complete_name']))), $date_of_birth];
			array_push($data, $birthday_array); 
		}
		return $data;
	}

	public function createEmployeeCalendar_ztm(){
		$condition = encrypt('Leaving');
		$this_year = date('Y');
		
		$sqlCheckYear = "SELECT date FROM hris_master_time_management ORDER BY id DESC LIMIT 1";
		$queryCheckYear = $this->db->query($sqlCheckYear);
		$resCheckYear = $queryCheckYear->result_array();
		$lastDataYear = date('Y',strtotime($resCheckYear[0]['date']));

		if ($lastDataYear != $this_year){
			$sql = "SELECT a.nik, a.complete_name, b.date, b.daily_work_schedule, b.dws_code, b.holiday_calendar
					FROM v_hris_employee_updated a, hris_master_calendar b
					WHERE a.action NOT LIKE '$condition'
					AND (b.date BETWEEN '$this_year-01-01' AND '$this_year-12-31')";
			$query = $this->db->query($sql);
			
			foreach($query->result_array() as $res){
				$nik = $res['nik'];

				if (!empty($res['holiday_calendar'])){
					$dws = $res['holiday_calendar'];
				} else {
					$dws = $res['daily_work_schedule'];
				}
				$dws_code = $res['dws_code'];

				$sqlSchedule = "SELECT a.schedule_in, a.schedule_out
								FROM hris_master_schedule as a
								LEFT JOIN v_hris_nik_company as b ON a.company_code = b.company_code
								WHERE a.kode = '$dws_code' AND a.end_date = '9999-12-31' AND b.nik = '$nik'";
				$querySchedule = $this->db->query($sqlSchedule);
				$resSchedule = $querySchedule->result_array();

				$formCalendar = array(
					'employee_id' => $nik,
					'full_name' => decrypt($res['complete_name']),
					'date' => $res['date'],
					'dws' => $dws,
					'schedule_code' => $res['dws_code'],
					'schedule_in' => $resSchedule['schedule_in'],
					'schedule_out' => $resSchedule['schedule_out']
				);
				$this->db->insert('hris_master_time_management', $formCalendar);
			}
			return true;
		} else {
			return 'already_created';
		}
	}

	//TIME MANAGEMENT 2.0
	public function createHolidayEvent_ztm($nama, $start_date, $end_date, $kode)
	{
		$today = date('Y-m-d');

		// menentukan working hours
		$working_hours_d = null;
		if ($kode == 'CTB') {
			$working_hours_d = '9.00';
			$working_hours_t = '09:00:00';
		} elseif ($kode == 'DON') {
			$working_hours_d = '0.00';
			$working_hours_t = '00:00:00';
		}
		// Tentukan apakah working_hours mau diupdate
		$setWorkingHours = '';
		if (!empty($working_hours_d)) {
			$setWorkingHours = ", working_hours_d = '$working_hours_d', working_hours_t = '$working_hours_t'";
		}
		// =========================
		// UPDATE MASTER CALENDAR
		// =========================

		$sqlUpdCal = "UPDATE hris_master_calendar 
					SET daily_work_schedule='DAY OFF',
						dws_code='$kode',
						holiday_calendar='$nama'
					WHERE date BETWEEN '$start_date' AND '$end_date'";
		$this->db->query($sqlUpdCal);


		// =========================
		// UPDATE TIME MANAGEMENT
		// =========================

		$sqlUpdTM = "UPDATE hris_master_time_management 
					SET dws='$nama',
						schedule_code='$kode',
						schedule_in=NULL,
						schedule_out=NULL
						$setWorkingHours
					WHERE date BETWEEN '$start_date' AND '$end_date'
					AND schedule_code NOT LIKE 'SHF%'
					AND schedule_code NOT LIKE 'DO%'";
		$this->db->query($sqlUpdTM);


		// =========================
		// GET NAMA CTAB
		// =========================

		$namaCTAB = $this->db
			->select('nama')
			->from('hris_master_time_off')
			->where('kode','CTAB')
			->get()
			->row()
			->nama;


		// =====================================================
		// LOGIC CTB
		// =====================================================

		if ($kode == 'CTB' && strtotime($start_date) < strtotime($today))
		{

			$max_date = (strtotime($end_date) >= strtotime($today)) ? $today : $end_date;

			$range = strtotime($max_date) - strtotime($start_date);
			$date_range = $range / 86400;

			$change_log = -1 * ($date_range + 1);

			$sqlGetEmp = "SELECT employee_id 
						FROM hris_master_time_management 
						WHERE schedule_code='CTB'
						AND date='$max_date'";
			$resultGetEmp = $this->db->query($sqlGetEmp)->result_array();

			foreach($resultGetEmp as $value)
			{

				$nik = $value['employee_id'];

				// cek request time off
				$sqlCheckTO = "SELECT status
							FROM hris_request_time_off
							WHERE nik='$nik'
							AND ('$start_date' BETWEEN start_date AND end_date
							OR '$max_date' BETWEEN start_date AND end_date)";
				$resultCheckTO = $this->db->query($sqlCheckTO)->row();

				if (!empty($resultCheckTO) && $resultCheckTO->status == 1){
					continue;
				}

				// update time management
				$sql = "UPDATE hris_master_time_management 
						SET attendence_code='',
							time_off_code='CT',
							working_hours_d='9.00',
							working_hours_t = '09:00:00'
						WHERE employee_id='$nik'
						AND date BETWEEN '$start_date' AND '$max_date'";
				$this->db->query($sql);


				// reset perubahan cuti
				$sqlUpdCuti = "UPDATE hris_time_management_employee 
							SET status=0
							WHERE nik='$nik'
							AND date BETWEEN '$start_date' AND '$max_date'
							AND tipe_perubahan='$namaCTAB'";
				$this->db->query($sqlUpdCuti);


				// ambil total cuti terakhir
				$total_cuti = $this->db
					->select('total_cuti')
					->from('hris_time_management_employee')
					->where('nik',$nik)
					->order_by('id','DESC')
					->limit(1)
					->get()
					->row()
					->total_cuti;

				$total_cuti = $total_cuti + $change_log;

				$flagTME = ($total_cuti < -6) ? 1 : 0;
				$flagMinus = ($total_cuti < 0) ? 1 : 0;

				$formData = array(
					'nik' => $nik,
					'date' => $today,
					'tipe_perubahan' => $nama,
					'start_date' => $start_date,
					'end_date' => $max_date,
					'total_cuti' => $total_cuti,
					'change_log' => $change_log,
					'request_number' => '-',
					'status' => 1,
					'flag' => $flagTME,
					'minus' => $flagMinus
				);

				$this->db->insert("hris_time_management_employee", $formData);
			}

		}

		// =====================================================
		// LOGIC DON
		// =====================================================

		else if ($kode == 'DON')
		{

			$max_date = (strtotime($end_date) >= strtotime($today)) ? $today : $end_date;

			$sqlCheckTO = "SELECT * 
						FROM hris_request_time_off
						WHERE ('$start_date' BETWEEN start_date AND end_date
						OR '$max_date' BETWEEN start_date AND end_date)
						AND jenis='CUTI TAHUNAN'
						AND status=1";

			$resultCheckTO = $this->db->query($sqlCheckTO)->result();

			foreach ($resultCheckTO as $value)
			{

				$nik = $value->nik;

				$sqlGetDateDiff = "SELECT date
								FROM hris_master_time_management
								WHERE employee_id='$nik'
								AND date BETWEEN '$value->start_date' AND '$value->end_date'
								AND date BETWEEN '$start_date' AND '$end_date'
								AND schedule_code='DON'
								AND (time_off_code IS NOT NULL OR time_off_code!='')";
				
				$date_diff = $this->db->query($sqlGetDateDiff)->num_rows();


				$total_cuti = $this->db
					->select('total_cuti')
					->from('hris_time_management_employee')
					->where('nik',$nik)
					->order_by('id','DESC')
					->limit(1)
					->get()
					->row()
					->total_cuti;

				$total_cuti = $total_cuti + $date_diff;

				$flagTME = ($total_cuti < -6) ? 1 : 0;
				$flagMinus = ($total_cuti < 0) ? 1 : 0;

				$formData = array(
					'nik' => $nik,
					'date' => $today,
					'tipe_perubahan' => $nama,
					'start_date' => $start_date,
					'end_date' => $end_date,
					'total_cuti' => $total_cuti,
					'change_log' => $date_diff,
					'request_number' => '-',
					'status' => 1,
					'flag' => $flagTME,
					'minus' => $flagMinus
				);

				$this->db->insert("hris_time_management_employee", $formData);

			}

		}

		return true;
	}
	////////

	//////////////////////// TIME MANAGEMENT 2.0 //////////////////////////////

	public function getTMReport_ztm($data, $emp_nik){
		$temp = ''; $y = 0;
		for ($x = 0; $x < strlen($data); $x++){
			if ($data[$x] == '-'){
				$filter[$y] = substr($temp, 0, strlen($temp));
				// $branch = substr($data, strlen($temp)+1, strlen($data));
				$temp = '';
				
				$y++;
			} else {
				$temp .= $data[$x];
			}
		}
		$status = $filter[0];
		$branch = $filter[1];
		$balance = $filter[2];

		$i = 0;
		$this->db->select('nik, complete_name, company_name');
		$this->db->from('v_hris_employee_updated');
		$this->db->where('company_code', encrypt($branch));
		$this->db->where('NIK NOT LIKE', '0000%');
		if ($status == 'active'){
			$this->db->where('action !=', encrypt('Leaving'));
		} else {
			$this->db->where('action', encrypt('Leaving'));
		}
		if (!empty($emp_nik)){
			$decoded_nik = json_decode(rawurldecode($emp_nik));
			
			if (count($decoded_nik) > 1){
				$this->db->group_start();
				$this->db->where('nik', $decoded_nik[0]);
				for ($i=1; $i<count($decoded_nik); $i++){
					$this->db->or_where('nik', $decoded_nik[$i]);
				}
				$this->db->group_end();
			} else {
				$this->db->where('nik', $decoded_nik[0]);
			}
		}
		$result = $this->db->get()->result_array();
		foreach($result as $value){
			$this->db->select('total_cuti');
			$this->db->from('hris_time_management_employee');
			$this->db->where('nik', $value['nik']);
			$this->db->order_by('id', 'DESC');
			$topTotalCuti = $this->db->get()->result_array();
			if (empty($topTotalCuti)){
				$topTotalCuti[0]['total_cuti'] = 0;
			}
			if ($topTotalCuti[0]['total_cuti'] < 0){
				$this->db->select('date');
				$this->db->from('hris_time_management_employee');
				$this->db->where('nik', $value['nik']);
				$this->db->where('minus', 1);
				if(!empty($get_minus_date = $this->db->get()->result_array())){
					$last_array = end($get_minus_date);
					$last_date = $last_array['date'];
					$first_array = reset($get_minus_date);
					$first_date = $first_array['date'];

					$period = date('F Y', strtotime($first_date)) . ' - ' . date('F Y', strtotime($last_date));
				}
			} else {
				$period = '';
			}
			if ($balance == 'plus'){
				if ($topTotalCuti[0]['total_cuti'] < 0){
					continue;
				}
			} else if ($balance == 'minus'){
				if ($topTotalCuti[0]['total_cuti'] >= 0){
					continue;
				}
			}
			$all_data[$i]= [$value['nik'], decrypt($value['complete_name']), decrypt($value['company_name']), $topTotalCuti[0]['total_cuti'], $period];
			$i++;
		}
		if (!empty($result) && !empty($all_data)){
			return $all_data;
		} else {
			return false;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////

	public function getCompany_ztm($nik=''){
		$this->db->select('company_code, company_name');
		$this->db->where('company_code is NOT NULL', NULL, FALSE);
		$this->db->from('v_hris_nik_company');
		if(empty($nik)){
			$this->db->group_by('company_code, company_name');
			$this->db->order_by('company_code', 'asc');
		} else {
			$this->db->where('nik', $nik);
		}
		return $this->db->get()->result_array();
	}

	public function getWorkSchedule_ztm($company_code){
		$this->db->select('nama, kode, company_name, company_code');
		$this->db->from('hris_master_schedule');
		$this->db->where('company_code', $company_code);
		// $this->db->where('kode NOT LIKE', 'SHF%');
		$this->db->where('end_date', '9999-12-31');
		return $this->db->get()->result_array();
	}

	public function assignWorkSchedule_ztm($emp_name, $work_schedule, $ws_name, $start_date, $end_date){
		$company = $this->getCompany_ztm($emp_name);
		$company_code = $company[0]['company_code'];
		
		$this->db->select('schedule_in, schedule_out');
		$this->db->from('hris_master_schedule');
		$this->db->where('kode', $work_schedule);
		$this->db->where('company_code', $company_code);
		$schedule = $this->db->get()->result_array();
		$schedule_in = $schedule[0]['schedule_in'];
		$schedule_out = $schedule[0]['schedule_out'];

		$sql = "UPDATE hris_master_time_management SET dws='$ws_name', schedule_code='$work_schedule', schedule_in='$schedule_in',
				schedule_out='$schedule_out' WHERE employee_id='$emp_name' AND (date BETWEEN '$start_date' AND '$end_date') 
				AND schedule_code NOT LIKE 'DO%'";
		$query = $this->db->query($sql);

		if ($query){
			return true;
		}
	}

	public function assignWorkScheduleMulti_ztm($branch, $current_schedule, $new_schedule, $start_date, $end_date){
		$this->db->select('*');
		$this->db->from('hris_master_time_management');
		$this->db->where('schedule_code', $current_schedule);
		$this->db->where("date BETWEEN '$start_date' AND '$end_date'");
		if ($this->db->get()->result_array()){
			$this->db->select('*');
			$this->db->from('hris_master_schedule');
			$this->db->where('kode', $new_schedule);
			$this->db->where('company_code', $branch);
			$schedule = $this->db->get()->result_array();
			$new_schedule_name = $schedule[0]['nama'];
			$schedule_in = $schedule[0]['schedule_in'];
			$schedule_out = $schedule[0]['schedule_out'];

			// $sql = "UPDATE hris_master_time_management 
			// 		SET dws='$new_schedule_name', schedule_code='$new_schedule', schedule_in='$schedule_in', schedule_out='$schedule_out'
			// 		FROM hris_master_time_management a LEFT JOIN v_hris_nik_company b ON a.employee_id = b.nik 
			// 		WHERE a.schedule_code='$current_schedule' AND (a.date BETWEEN '$start_date' AND '$end_date') AND b.company_code='$branch'";
			$sql = "UPDATE hris_master_time_management a 
					LEFT JOIN v_hris_nik_company b ON a.employee_id = b.nik 
					SET a.dws='$new_schedule_name', a.schedule_code='$new_schedule', a.schedule_in='$schedule_in', a.schedule_out='$schedule_out' 
					WHERE a.schedule_code='$current_schedule' AND (a.date BETWEEN '$start_date' AND '$end_date') AND b.company_code='$branch'";
			$query = $this->db->query($sql);
		} else {
			return 'not_retrieved';
		}

		if ($query){
			return true;
		}
	}

	public function assignShiftPattern_ztm($file_name){
		$file_name_trim = str_replace('"', '', $file_name);
		$file = "./assets/documents/documents_tm/$file_name_trim";

		if(file_exists("$file")){
			$handle= fopen("$file","r");
			$flag = true;
		
			while(($data=fgetcsv($handle,0,';'))!== FALSE){ 
				if($flag) { $flag = false; continue; }
				$nik  = $data[0];
				$date = $data[2];
				$date = date("Y-m-d", strtotime($date));
				$dws_code = $data[3];

				$this->db->select("company_code");
				$this->db->from("v_hris_nik_company");
				$this->db->where("nik", trim($nik));

				$row = $this->db->get()->row_array();

				if (empty($row) || empty($row['company_code'])) {
					return 'company_not_found';
				}

				$company_code = $row['company_code'];

				if ($dws_code != "DO"){
					$this->db->select("nama, schedule_in, schedule_out");
					$this->db->from("hris_master_schedule");
					$this->db->where("kode", $dws_code);
					$this->db->where("company_code", $company_code);
					$this->db->where("end_date", "9999-12-31");
					$schedule_data = $this->db->get()->result_array();

					if (!empty($schedule_data)){
						$dws = $schedule_data[0]['nama'];
						$schedule_in = $schedule_data[0]['schedule_in'];
						$schedule_out = $schedule_data[0]['schedule_out'];
					} else {
						return 'schedule_not_found';
					}

				} else {
					$dws = "DAY OFF";
					$schedule_in = NULL;
					$schedule_out = NULL;
				}

				$formData = array(
					'dws' => $dws,
					'schedule_code' => $dws_code,
					'schedule_in' => $schedule_in,
					'schedule_out' => $schedule_out
				);
				
				$this->db->where('employee_id', $nik);
				$this->db->where('date', $date);
				$this->db->update("hris_master_time_management", $formData);
			}

			return true;

		} else {
			return 'no_file_exist';
		}
	}

	//////////// TIME MANAGEMENT 2.0 ////////////
	public function getHead_ztm($email, $display){
		$i = 0;

		$this->db->select('*');
		$this->db->from('v_hris_employee_updated');
		$this->db->where('usrid_long5', encrypt($email));
		$this->db->or_where('usrid_long2', encrypt($email));
		$this->db->or_where('usrid_long3', encrypt($email));
		$this->db->or_where('usrid_long4', encrypt($email));
		if ($display == 1){
			$this->db->or_where('email', encrypt($email));
		}
		$resultHead = $this->db->get()->result();

		if ($display == 0){
			if (!empty($resultHead)){
				return true;
			} else {
				return false;
			}
		} else if ($display == 1 || $display == 3){
			return $resultHead;
		} else if ($display == 2){
			foreach($resultHead as $value){
				$this->db->select('total_cuti');
				$this->db->from('hris_time_management_employee');
				$this->db->where('nik', $value->nik);
				$this->db->order_by('id', 'DESC');
				$topTotalCuti = $this->db->get()->result_array();
				if (empty($topTotalCuti)){
					$topTotalCuti[0]['total_cuti'] = 0;
				}

				$all_data[$i]= [$value->nik, decrypt($value->complete_name), decrypt($value->company_name), decrypt($value->department), $topTotalCuti[0]['total_cuti']];
				$i++;
			}

			return $all_data;
		}
	}

	public function getEmployee_ztm(){
		$sql = "SELECT id_employee, email, complete_name, nik FROM v_hris_employee_updated ORDER BY id_employee ASC";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function getEditEmpAtd_ztm($id){
		$sql = "SELECT * FROM hris_master_time_management WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function updateEmpAtd($id, $check_in, $check_out, $check_in_id, $check_out_id, $attendance_code, $time_off_code, $notes, $working_hours_d, $working_hours_t){
		$this->db->select('nama');
		$this->db->from('hris_master_time_off');
		$this->db->where('kode', 'CTAB');
		$resultCTAB = $this->db->get()->result_array();
		$namaCTAB = $resultCTAB[0]['nama'];

		$this->db->select('*');
		$this->db->from('hris_master_time_management');
		$this->db->where('id', $id);
		$empAtd = $this->db->get()->result_array();
		$nik = $empAtd[0]['employee_id'];
		$date = $empAtd[0]['date'];

		if ($check_in_id != 'empty' && $check_in_id != 'same'){
			$this->db->select('*');
			$this->db->from('hris_master_personnel_area');
			$this->db->where('id', $check_in_id);
			$loc_in = $this->db->get()->result_array();

			$check_in_location = $loc_in[0]['address'];
			$lat_in = $loc_in[0]['lattitude'];
			$long_in = $loc_in[0]['longitude'];

			$loc_in_change = ", check_in_location='$check_in_location', lat_in='$lat_in', long_in='$long_in'";
		} else {
			$loc_in_change = "";
		}
		if ($check_out_id != 'empty' && $check_out_id != 'same'){
			$this->db->select('*');
			$this->db->from('hris_master_personnel_area');
			$this->db->where('id', $check_out_id);
			$loc_out = $this->db->get()->result_array();

			$check_out_location = $loc_out[0]['address'];
			$lat_out = $loc_out[0]['lattitude'];
			$long_out = $loc_out[0]['longitude'];

			$loc_out_change = ", check_out_location='$check_out_location', lat_out='$lat_out', long_out='$long_out'";
		} else {
			$loc_out_change = "";
		}

		if ($empAtd[0]['attendence_code'] != 'CTAB'){
			$this->db->select('*');
			$this->db->from('hris_time_management_employee');
			$this->db->where('nik', $nik);
			$this->db->where('date', $date);
			$this->db->where('tipe_perubahan', $namaCTAB);
			$this->db->where('status', 1);
			$checkCTABstatus = $this->db->get()->result_array();

			if (!empty($checkCTABstatus)){
				$sqlUpdCTAB = "UPDATE hris_time_management_employee SET status=0, update_date='$today' WHERE nik='$nik' AND tipe_perubahan='$namaCTAB' AND date='$date'";
				$queryUpdCTAB = $this->db->query($sqlUpdCTAB);

				$sqlTotal = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
				$queryTotal = $this->db->query($sqlTotal);
				$resultTotal = $queryTotal->result_array();

				$totalChange = $resultTotal[0]['total_cuti'] - $checkCTABstatus[0]['change_log'];

				if ($totalChange < -6){
					$flagTME = 1;
				} else {
					$flagTME = 0;
				}
				if($totalChange >= 0){
					$flagMinus = 0;
				} else {
					$flagMinus = 1;
				}

				$formDataEmployee = array(
					'nik' => $nik,
					'date' => date('Y-m-d'),
					'tipe_perubahan' => 'Adjustment Cuti Tidak Absen',
					'start_date' => $date,
					'end_date' => $date,
					'total_cuti' => $totalChange,
					'change_log' => abs($checkCTABstatus[0]['change_log']),
					'request_number' => '-',
					'status' => 1,
					'flag' => $flagTME,
					'minus' => $flagMinus
				);
				$this->db->insert("hris_time_management_employee", $formDataEmployee);
				$queryEmployee = $this->db->insert_id();
			}
		}

		$sql = "UPDATE hris_master_time_management SET check_in='$check_in', check_out='$check_out', working_hours_t = '$working_hours_t', working_hours_d = '$working_hours_d', attendence_code='$attendance_code',
				time_off_code='$time_off_code', note='$notes', flag=1 ".$loc_in_change . $loc_out_change."WHERE id='$id'";
		$query = $this->db->query($sql);

		if($query){
			return true;
		}
	}

	public function getOfficeRadius_ztm($personnel_area, $lat_in, $long_in, $date){
		$this->db->select('*');
		$this->db->from('hris_master_personnel_area');
		$this->db->where('personnel_area', $personnel_area);
		$this->db->where('start_date <=', $date);
		$this->db->where('end_date >=', $date);
		$office_loc = $this->db->get()->result();

		foreach ($office_loc as $area){
			$latFrom = deg2rad($area->lattitude);
			$lonFrom = deg2rad($area->longitude);
			$latTo = deg2rad($lat_in);
			$lonTo = deg2rad($long_in);

			$latDelta = $latTo - $latFrom;
			$lonDelta = $lonTo - $lonFrom;

			$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
			$distance = $angle * 6371000;

			if ($area->radius >= $distance){
				return "Office Area";
			} else {
				continue;
			}
		}

		if (empty($office_loc)){
			return "No Office Set";
		} else {
			return "Non Office Area";
		}

	}

	public function getTO_ztm($nik){
		$this->db->select('company_code');
		$this->db->from('v_hris_nik_company');
		$this->db->where('nik', $nik);
		$res = $this->db->get()->result_array();
		$company_code = $res[0]['company_code'];

		$this->db->select('*');
		$this->db->from('hris_master_time_off');
		$this->db->where('company_code', $company_code);
		$this->db->where('status', 1);
		$this->db->where('kode !=', 'PG');
		$this->db->where('kode !=', 'CTAB');
		return $this->db->get()->result();
	}

	public function getLocation_ztm($nik, $date){
		$this->db->select('*');
		$this->db->from('hris_master_relokasi_sementara');
		$this->db->where('nik', $nik);
		$this->db->where('start_date <=', $date);
		$this->db->where('end_date >=', $date);
		$this->db->where('status', 1);
		$relocation = $this->db->get()->result_array();

		if (!empty($relocation)){
			$personnel_area = $relocation[0]['pa_akhir'];
		} else {
			$this->db->select('personnel_area');
			$this->db->from('v_hris_employee_updated');
			$this->db->where('nik', $nik);
			$res = $this->db->get()->result_array();
			$personnel_area = decrypt($res[0]['personnel_area']);
		}

		$this->db->select('*');
		$this->db->from('hris_master_personnel_area');
		$this->db->where('personnel_area', $personnel_area);
		return $this->db->get()->result();
	}

	public function getHeadSearch_ztm($email, $dept, $emp){
		$i = 0;

		if (!empty($dept)){
			$department = encrypt(str_replace(array("^", "_"), array("(", ")"),$dept[0]));
			$sentence1 = "AND department LIKE '%$department%'";
			if (count($dept) > 1){
				$new = "AND (department LIKE '%$department%' ";
				for ($i=1; $i<count($dept); $i++){
					$department2 = encrypt(str_replace(array("^", "_"), array("(", ")"),$dept[$i]));
					$new .= "OR department LIKE '%$department2%' ";
				}
				$sentence1 = $new . ')';
			}
		} else {
			$sentence1 = '';
		}
		if (!empty($emp)){
			$employee = $emp[0];
			$sentence2 = "AND nik = '$employee'";
			if (count($emp) > 1){
				$new = "AND (nik = '$employee' ";
				for ($j=1; $j<count($emp); $j++){
					$employee2 = $emp[$j];
					$new .= "OR nik = '$employee2' ";
				}
				$sentence2 = $new . ')';
			}
		} else {
			$sentence2 = '';
		}

		$sql = "SELECT * FROM v_hris_employee_updated WHERE (usrid_long5='$email' OR usrid_long2='$email' OR usrid_long3='$email' OR usrid_long4='$email') "
				. $sentence1 . $sentence2;
		$query = $this->db->query($sql);
		$res = $query->result();

		foreach($res as $value){
			$this->db->select('total_cuti');
			$this->db->from('hris_time_management_employee');
			$this->db->where('nik', $value->nik);
			$this->db->order_by('id', 'DESC');
			$topTotalCuti = $this->db->get()->result_array();
			if (empty($topTotalCuti)){
				$topTotalCuti[0]['total_cuti'] = 0;
			}

			$all_data[$i]= [$value->nik, decrypt($value->complete_name), decrypt($value->company_name), decrypt($value->department), $topTotalCuti[0]['total_cuti']];
			$i++;
		}

		if (!empty($res)){
			return $all_data;
		} else {
			return false;
		}
	}

	public function getAttendanceHead_ztm($nik, $type, $data){
		$date = $this->today;
		$email = encrypt($this->email);

		if($type == 0){
			$dept = json_decode(rawurldecode($data));
			$dept = str_replace(
				['|-|', '|_|'],
				['(', ')'],
				$dept
			);

			$department = encrypt(str_replace(array("^", "_"), array("(", ")"),$dept[0]));
			$sentence = "AND (b.department LIKE '%$department%' OR a.employee_id = '$nik')";
			if (count($dept) > 1){
				$new = "AND (b.department LIKE '%$department%' ";
				for ($i=1; $i<count($dept); $i++){
					$department2 = encrypt(str_replace(array("^", "_"), array("(", ")"),$dept[$i]));
					$new .= "OR b.department LIKE '%$department2%' ";
				}
				$sentence = $new . "OR a.employee_id = '$nik')";
			}
			$sql = "SELECT a.*, b.personnel_area, b.personnel_subarea FROM hris_master_time_management a
					LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
					WHERE a.employee_id IS NOT NULL AND date='$date' 
					AND (b.usrid_long5='$email' OR b.usrid_long2='$email' OR b.usrid_long3='$email' OR b.usrid_long4='$email' OR b.email='$email') 
					". $sentence ." ORDER BY id ASC";
					// dumper($sql);
		} else {
			$temp = $sentence = $start_date = $end_date = '';
			$nik; $nik2; $dept; $dept2;

			$data = rawurldecode($data);

			$data = urldecode($data);
			$data = str_replace(
				['|-|', '|_|'],
				['(', ')'],
				$data
			);

			for ($x = 0; $x < strlen($data); $x++){
				if ($data[$x] == '-'){
					$temp = substr($temp, 0, strlen($temp)-1);
					if ($data[$x-1] == 'i'){
						$nik = $temp;
						$temp = '';
						$sentence .= "AND a.employee_id LIKE '%$nik%'";
					} else if ($data[$x-1] == 'n'){
						$nik2 = $temp;
						$temp = '';
						if ($sentence[4] != '('){
							$sentence = substr_replace($sentence, '(', 4, 0);
						}
						if ($sentence[-1] == ')'){
							$sentence = rtrim($sentence, ')');
						} 
						$sentence .= " OR a.employee_id LIKE '%$nik2%')";
						
					} else if ($data[$x-1] == 's'){
						$start_date = DateTime::createFromFormat('Ymd', $temp)->format('Y-m-d');
						$temp = '';
					} else if ($data[$x-1] == 'e'){
						$end_date = DateTime::createFromFormat('Ymd',$temp)->format('Y-m-d');
						$temp = '';
					}  
				} else if ($data[$x] == '@') {
					$temp = substr($temp, 0, strlen($temp)-1);
					if ($data[$x-1] == '.'){
						$dept = encrypt($temp);
						$temp = '';
						$sentence .= "AND b.department LIKE '%$dept%'";
					} else if ($data[$x-1] == ':'){
						$dept2 = encrypt($temp);
						$temp = '';
						if ($sentence[4] != '('){
							$sentence = substr_replace($sentence, '(', 4, 0);
						}
						if ($sentence[-1] == ')'){
							$sentence = rtrim($sentence, ')');
						} 
						$sentence .= " OR b.department LIKE '%$dept2%')";
					}
				} else if ($data[$x] == '~') {
					$temp .= ' ';
				} else if ($data[$x] == '^') {
					$temp .= '(';
				} else if ($data[$x] == '_') {
					$temp .= ')';
				} else {
					$temp .= $data[$x];
				}
			}
			if (!empty($start_date) && !empty($end_date)){
				$sentence .= " AND a.date BETWEEN '$start_date' AND '$end_date'";
			} else if (!empty($start_date) && empty($end_date)){
				$sentence .= " AND a.date = '$start_date'";
			} else {
				$sentence .= " AND a.date <= '$date'";
			}

			$sql = "SELECT a.*, b.personnel_area, b.personnel_subarea FROM hris_master_time_management a
					LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
					WHERE a.employee_id IS NOT NULL " . $sentence . " 
					AND (b.usrid_long5='$email' OR b.usrid_long2='$email' OR b.usrid_long3='$email' OR b.usrid_long4='$email' OR b.email='$email')
					ORDER BY id ASC";
		}
		
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public function attendanceAnalysisHead_ztm($type, $data=''){
		$date = $this->today;
		$email = encrypt($this->email);
		// dumper($data);
		if($type == 0){
			$nik = $this->session->userdata('nik');
			$dept = json_decode(rawurldecode($data));
			// $dept = urldecode($dept);
			// $dept = str_replace(
			// 	['|-|', '|_|'],
			// 	['(', ')'],
			// 	$dept
			// );
			$department = encrypt(str_replace(array("^", "_"), array("(", ")"),$dept[0]));
			// $sentence = "AND (b.department LIKE '%$department%' OR a.nik = '$nik')";
			$sentence = "AND (b.department LIKE '%$department%' OR a.employee_id = '$nik')";
			if (count($dept) > 1){
				$new = "AND (b.department LIKE '%$department%' ";
				for ($i=1; $i<count($dept); $i++){
					$department2 = encrypt(str_replace(array("^", "_"), array("(", ")"),$dept[$i]));
					$new .= "OR b.department LIKE '%$department2%' ";
				}
				// $sentence = $new . "OR a.nik = '$nik')";
				$sentence = $new . "OR a.employee_id = '$nik')";
			}

			$sql = "SELECT 
					SUM(CASE 
						WHEN a.attendance_status = 'on_time' 
							AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
							AND a.check_in is not null 
						THEN 1 ELSE 0 
					END) AS Aman,

					SUM(CASE 
						WHEN a.attendance_status = 'late_in' 
							AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
							AND a.check_in is not null 
						THEN 1 ELSE 0 
					END) AS Telat,

					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in is not null THEN 1 ELSE 0 END) AS yes_in,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out is not null THEN 1 ELSE 0 END) AS yes_out,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_in,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_out,

					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code like 'C%'  THEN 1 ELSE 0 END) AS Ijin,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code = 'S' THEN 1 ELSE 0 END) AS Sakit,

					SUM(CASE 
						WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
						THEN 1 ELSE 0 
					END) AS hari_kerja_sch,

					SUM(
						CASE 
							-- full cuti tahunan dan perjalanan dinas
							WHEN EXISTS (
								SELECT 1
								FROM hris_request_time_off c
								WHERE c.nik = a.employee_id
								AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
								AND a.date BETWEEN c.start_date AND c.end_date
								AND (c.jenis = 'CUTI TAHUNAN' OR c.jenis = 'PERJALANAN DINAS')
								AND c.status IN (0,1)
							)
							THEN 1

							-- setengah hari
							WHEN EXISTS (
								SELECT 1
								FROM hris_request_time_off c
								WHERE c.nik = a.employee_id
								AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
								AND a.date BETWEEN c.start_date AND c.end_date
								AND c.jenis = 'Cuti Tahunan Setengah Hari'
								AND c.status IN (0,1)
							)
							THEN 0.5

							-- normal hadir
							WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NOT NULL 
							THEN 1

							ELSE 0 
						END
					) AS hari_kerja_act,

					SUM(CASE 
						WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
						THEN 9.00 ELSE 0.00 
					END) AS jam_kerja_sch,

					SUM(COALESCE(a.working_hours_d, 0.00)) AS jam_kerja_act

				-- FROM v_full_absensi a
				FROM hris_master_time_management a

				LEFT JOIN v_hris_employee_updated b 
					ON a.employee_id = b.nik

				-- LEFT JOIN hris_master_time_management c 
				-- 	ON a.nik = c.employee_id 
				-- AND a.date = c.date

				WHERE 
					a.date = '$date'
					$sentence
					AND (
						b.usrid_long5 = '$email' OR 
						b.usrid_long2 = '$email' OR 
						b.usrid_long3 = '$email' OR 
						b.usrid_long4 = '$email' OR 
						b.email       = '$email'
					)";
					
		} else {
			$temp = $sentence = $start_date = $end_date = '';
			$nik; $nik2; $dept; $dept2;

			$data = rawurldecode($data);
			// $data = str_replace(
			// 	['|-|', '|_|'],
			// 	['(', ')'],
			// 	$data
			// );

			for ($x = 0; $x < strlen($data); $x++){
				if ($data[$x] == '-'){
					$temp = substr($temp, 0, strlen($temp)-1);
					if ($data[$x-1] == 'i'){
						$nik = $temp;
						$temp = '';
						// $sentence .= "AND a.nik LIKE '%$nik%'";
						$sentence .= "AND a.employee_id LIKE '%$nik%'";
					} else if ($data[$x-1] == 'n'){
						$nik2 = $temp;
						$temp = '';
						if ($sentence[4] != '('){
							$sentence = substr_replace($sentence, '(', 4, 0);
						}
						if ($sentence[-1] == ')'){
							$sentence = rtrim($sentence, ')');
						} 
						// $sentence .= " OR a.nik LIKE '%$nik2%')";
						$sentence .= " OR a.employee_id LIKE '%$nik2%')";
						
					} else if ($data[$x-1] == 's'){
						$start_date = DateTime::createFromFormat('Ymd', $temp)->format('Y-m-d');
						$temp = '';
					} else if ($data[$x-1] == 'e'){
						$end_date = DateTime::createFromFormat('Ymd',$temp)->format('Y-m-d');
						$temp = '';
					}  
				} else if ($data[$x] == '@') {
					$temp = substr($temp, 0, strlen($temp)-1);
					if ($data[$x-1] == '.'){
						$dept = encrypt($temp);
						$temp = '';
						$sentence .= "AND b.department LIKE '%$dept%'";
					} else if ($data[$x-1] == ':'){
						$dept2 = encrypt($temp);
						$temp = '';
						if ($sentence[4] != '('){
							$sentence = substr_replace($sentence, '(', 4, 0);
						}
						if ($sentence[-1] == ')'){
							$sentence = rtrim($sentence, ')');
						} 
						$sentence .= " OR b.department LIKE '%$dept2%')";
					}
				} else if ($data[$x] == '~') {
					$temp .= ' ';
				} else if ($data[$x] == '^') {
					$temp .= '(';
				} else if ($data[$x] == '_') {
					$temp .= ')';
				} else {
					$temp .= $data[$x];
				}
			}
			if (!empty($start_date) && !empty($end_date)){
				$sentence .= " AND a.date BETWEEN '$start_date' AND '$end_date'";
			} else if (!empty($start_date) && empty($end_date)){
				$sentence .= " AND a.date = '$start_date'";
			} else {
				$sentence .= " AND a.date <= '$date'";
			}

			$sql = "SELECT 
					SUM(CASE 
						WHEN a.attendance_status = 'on_time' 
							AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
							AND a.check_in is not null 
						THEN 1 ELSE 0 
					END) AS Aman,

					SUM(CASE 
						WHEN a.attendance_status = 'late_in' 
							AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
							AND a.check_in is not null 
						THEN 1 ELSE 0 
					END) AS Telat,

					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in is not null THEN 1 ELSE 0 END) AS yes_in,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out is not null THEN 1 ELSE 0 END) AS yes_out,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_in,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_out,

					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code like 'C%'  THEN 1 ELSE 0 END) AS Ijin,
					SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code = 'S' THEN 1 ELSE 0 END) AS Sakit,

					SUM(CASE 
						WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
						THEN 1 ELSE 0 
					END) AS hari_kerja_sch,

					SUM(
						CASE 
							-- full cuti tahunan dan perjalanan dinas
							WHEN EXISTS (
								SELECT 1
								FROM hris_request_time_off c
								WHERE c.nik = a.employee_id
								AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
								AND a.date BETWEEN c.start_date AND c.end_date
								AND (c.jenis = 'CUTI TAHUNAN' OR c.jenis = 'PERJALANAN DINAS')
								AND c.status IN (0,1)
							)
							THEN 1

							-- setengah hari
							WHEN EXISTS (
								SELECT 1
								FROM hris_request_time_off c
								WHERE c.nik = a.employee_id
								AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
								AND a.date BETWEEN c.start_date AND c.end_date
								AND c.jenis = 'Cuti Tahunan Setengah Hari'
								AND c.status IN (0,1)
							)
							THEN 0.5

							-- normal hadir
							WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NOT NULL 
							THEN 1

							ELSE 0 
						END
					) AS hari_kerja_act,

					SUM(CASE 
						WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
						THEN 9.00 ELSE 0.00 
					END) AS jam_kerja_sch,

					SUM(COALESCE(a.working_hours_d, 0.00)) AS jam_kerja_act

				-- FROM v_full_absensi a
				FROM hris_master_time_management a

				LEFT JOIN v_hris_employee_updated b 
					ON a.employee_id = b.nik

				-- LEFT JOIN hris_master_time_management c 
				-- 	ON a.nik = c.employee_id 
				-- AND a.date = c.date

				WHERE 
					a.employee_id IS NOT NULL
					$sentence
					AND (
						b.usrid_long5 = '$email' OR 
						b.usrid_long2 = '$email' OR 
						b.usrid_long3 = '$email' OR 
						b.usrid_long4 = '$email' OR 
						b.email       = '$email'
					)";
					
		}
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		
		if (!empty($result)) {
			
			$data = [$result[0]['yes_in'], $result[0]['yes_out'], $result[0]['no_in'], $result[0]['no_out'], $result[0]['Ijin'] ,$result[0]['Aman'], $result[0]['Telat'], $result[0]['Sakit'], $result[0]['hari_kerja_sch'], $result[0]['hari_kerja_act'], $result[0]['jam_kerja_sch'], $result[0]['jam_kerja_act']];
		} else {
			$data = 0;
		}
		return $data;
	}

	public function getRelocation_ztm($nik, $date){

		// $sql = "SELECT * FROM hris_master_relokasi_sementara WHERE nik LIKE '$nik' AND start_date <= '$date' AND end_date >= '$date' AND status = 1";
		// $query = $this->db->query($sql);
		// $relocation = $query->result();

		$this->db->select('*');
		$this->db->from('hris_master_relokasi_sementara');
		$this->db->where('nik',$nik);
		$this->db->where('start_date <=',$date);
		$this->db->where('end_date >=',$date);
		$this->db->where('status', 1);
		$relocation = $this->db->get()->result();
		if($relocation){
			return $relocation[0];	
		}else{
			return $relocation;
		}
		
	}
	//////////// TIME MANAGEMENT 2.0 ////////////

	// START CR 3 TM
	public function getDepartment_ztm(){
		$sql = "SELECT DISTINCT department FROM v_hris_employee_updated WHERE department != ''";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getDivision_ztm(){
		$sql = "SELECT DISTINCT division FROM v_hris_employee_updated WHERE division != ''";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getDirectorate_ztm(){
		$sql = "SELECT DISTINCT directorate FROM v_hris_employee_updated WHERE directorate != ''";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getLocationReq_ztm($nik, $date){
		$this->db->select('*');
		$this->db->from('hris_request_time_off');
		$this->db->where('jenis', 'Request Revised Location');
		$this->db->where('nik', $nik);
		$this->db->where('start_date', $date);
		$this->db->where('status !=', 2);
		$this->db->where('status !=', 3);
		$result = $this->db->get()->result();

		if (empty($result)){
			return 'not-exist';
		} else {
			return 'exist';
		}
	}
	/////////////////// END TIME MANAGEMENT 2024//////////////////////////////

	///////////////////////////////Penambahan Logs Activity 2025///////////////////////////
	public function getLogs(){
		$start_date = date('Y-m-d H:i:s',strtotime("-3 Months"));
		$end_date	= $this->date;
		$sql 		= 	"SELECT a.*, (SELECT b.request_number FROM form_request AS b WHERE b.id = a.request_id) AS request_number
						FROM logs a
						LEFT JOIN users AS c ON a.created_by = c.user_email
						WHERE a.created_at BETWEEN '$start_date' AND '$end_date' AND c.user_role IN ('12','27','11')";
		$query 		= $this->db->query($sql);
		$result 	= $query->result_array();

		return $result;
	}

	/////////////Start Report Summary and Details TM 2026////////////////////

	public function get_summary_tm($year, $start = 0, $length = 10, $search = '', $order = '', $column = '', $nik='', $month=''){
		// $month 			= (!empty($month) && $month != 'All') ? $month : 12;
		// Kolom default untuk sorting
		$orderColumn 	= 'nik';
		$orderDir 		= 'ASC';

		if (!empty($order)) {
			$orderColumn = $column[$order[0]['column']]['data'];
			$orderDir = $order[0]['dir'];
		}

		$this->db->from('v_hris_employee_updated');

		if (!empty($nik)) {

			if (is_array($nik)) {
				$this->db->where_in('nik', $nik);
			} else {
				$this->db->like('nik', $nik);
			}
		}

		$this->db->not_like('nik', '00000', 'after');
		// $this->db->not_like('nik', 'SPN', 'after');

		$this->db->group_by('nik');
    	$this->db->order_by('nik', 'ASC');
		///////////////
		$query = $this->db->get();
		$data = array();
		if($query){
			$res = $query->result_array();
			foreach ($res as $key) {
			
					$nik_emp = $key['nik'];
					$start_date = str_replace('-', '', (string) decrypt($key['start_date'])); // contoh: 2025 atau 20250517

					$year_sd = (int) substr($start_date, 0, 4); // ambil tahun saja
					$action  = decrypt($key['action']);

					$include = false;

						if ($action === 'Leaving') {
							if ($year <= $year_sd) {
								$include = true;
							}
						} else {
							// if ($year >= $year_sd) {
								$include = true;
							// }
						}

						if ($action === 'Leaving') {
							if ($year == $year_sd) {
								$status_emp = 'Leaving';
							}else{
								$status_emp = 'Active';
							}
						} else {
							// if ($year >= $year_sd) {
								$status_emp = 'Active';
							// }
						}

					// push data jika lolos filter
					if ($include) {
						$data[] = [
							'nik'           => $nik_emp,
							'complete_name' => decrypt($key['complete_name']),
							'company_code' 	=> decrypt($key['company_code']),
							'company_name' 	=> decrypt($key['company_name']),
							'personnel_area' => decrypt($key['personnel_area']),
							'position' 		=> decrypt($key['position']),
							'department'	=> decrypt($key['department']),
							'division' 		=> decrypt($key['division']),
							'action'        => $status_emp,
						];
					}



			}
		}else{
			$data = array();
		}

		// Hitung total data sebelum limit
		$totalFiltered = count($data);

		// Tambahkan limit & order
		$orderDir = strtolower($orderDir);
		usort($data, function ($a, $b) use ($orderColumn, $orderDir) {
			if ($a[$orderColumn] == $b[$orderColumn]) return 0;

			if ($orderDir === 'asc') {
				return ($a[$orderColumn] < $b[$orderColumn]) ? -1 : 1;
			} else {
				return ($a[$orderColumn] > $b[$orderColumn]) ? -1 : 1;
			}
		});

		$data = ($length != -1) ? array_slice($data, $start, $length) : $data;

		$today 	= $this->today;

		if($data){
				$data_hasil = array();
				
				foreach ($data as $key) {

					$nik_emp				= $key['nik'];

					if($month == "All"){
						$sentence = "AND a.date BETWEEN '$year-01-01' AND '$year-12-31'";
					}else{
						$sentence = "AND a.date BETWEEN CONCAT('$year','-','$month','-01') AND LAST_DAY(CONCAT('$year','-','$month','-01'))";
					}

					$sql = "SELECT 
						SUM(CASE 
							WHEN a.attendance_status = 'on_time' 
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS aman,

						SUM(CASE 
							WHEN a.attendance_status = 'late_in' 
								AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
								AND a.check_in is not null 
							THEN 1 ELSE 0 
						END) AS telat,

						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in is not null THEN 1 ELSE 0 END) AS yes_in,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out is not null THEN 1 ELSE 0 END) AS yes_out,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_in IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_in,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.check_out IS NULL AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' THEN 1 ELSE 0 END) AS no_out,

						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code like 'C%'  THEN 1 ELSE 0 END) AS ijin,
						SUM(CASE WHEN (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND a.time_off_code = 'S' THEN 1 ELSE 0 END) AS sakit,

						SUM(CASE 
							WHEN a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%'
							THEN 1 ELSE 0 
						END) AS hari_kerja_sch,

						SUM(
							CASE 
								-- full cuti tahunan dan perjalanan dinas
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND (b.jenis = 'CUTI TAHUNAN' OR b.jenis = 'PERJALANAN DINAS')
									AND b.status IN (0,1)
								)
								THEN 1

								-- setengah hari
								WHEN EXISTS (
									SELECT 1
									FROM hris_request_time_off b
									WHERE b.nik = a.employee_id
									AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%')
									AND a.date BETWEEN b.start_date AND b.end_date
									AND b.jenis = 'Cuti Tahunan Setengah Hari'
									AND b.status IN (0,1)
								)
								THEN 0.5

								-- normal hadir
								WHEN a.check_in IS NOT NULL 
								THEN 1

								ELSE 0 
							END
						) AS hari_kerja_act,
						SEC_TO_TIME(
							SUM(
								CASE 
									WHEN (a.schedule_code) LIKE 'N%' 
									OR (a.schedule_code) LIKE 'SHF%' 
									THEN GREATEST(
										TIMESTAMPDIFF(
											SECOND,
											a.schedule_in,
											a.schedule_out
										),
										0
									)
									ELSE 0
								END
							)
						) AS jam_kerja_sch,

						SEC_TO_TIME(
							SUM(
								TIME_TO_SEC(
									a.working_hours_t
								)
							)
						) AS jam_kerja_act,

						CAST(
						SUM(TIME_TO_SEC(a.working_hours_t)) * 100 /
						NULLIF(
							SUM(
								CASE
									WHEN a.schedule_code LIKE 'N%'
									OR a.schedule_code LIKE 'SHF%'
									THEN
										CASE
											WHEN a.schedule_out < a.schedule_in
											THEN TIMESTAMPDIFF(
													SECOND,
													a.schedule_in,
													DATE_ADD(a.schedule_out, INTERVAL 1 DAY)
												)
											ELSE TIMESTAMPDIFF(
													SECOND,
													a.schedule_in,
													a.schedule_out
												)
										END
									ELSE 0
								END
							),
							0
						)
					AS DECIMAL(5,2)) AS attendance_percentage,

						SUM(
							CASE 
								WHEN (
									a.attendence_code = 'H'
									AND COALESCE(TRIM(a.time_off_code),'') NOT IN ('S','PD') AND COALESCE(TRIM(a.time_off_code),'') NOT LIKE 'C%' 
									AND a.check_out IS NOT NULL
									AND a.check_out < a.schedule_out
								)
								THEN 1
								ELSE 0
							END
						) AS pulang_cepat
						-- SUM(COALESCE(a.working_hours_t, 0.00)) AS jam_kerja_act

					FROM hris_master_time_management a 
					WHERE a.employee_id = '$nik_emp' " . $sentence . "";
					// dumper($sql);
					$query = $this->db->query($sql);
					$result = $query->result_array()[0];
		
			


					$row['nik'] 			= $nik_emp;
					$row['complete_name'] 	= $key['complete_name'];
					$row['company_code'] 	= $key['company_code'];
					$row['company_name'] 	= $key['company_name'];
					$row['personnel_area'] 	= $key['personnel_area'];
					$row['position'] 		= $key['position'];
					$row['department'] 		= $key['department'];
					$row['division'] 		= $key['division'];
					$row['jam_kerja_sch'] 	= $result['jam_kerja_sch'];
					$row['jam_kerja_act'] 	= $result['jam_kerja_act'];
					$row['time_off'] 		= $result['ijin'] + $result['sakit'];
					$row['attendance_percentage'] 	= $result['attendance_percentage']. "%";
					$row['telat'] 			= $result['telat'];
					$row['pulang_cepat'] 	= $result['pulang_cepat'];
					
					$row['action'] 			= $key['action'];;					
					$row['month'] 			= (!empty(($month))) ? (($month)) : 'ALL';					
					$row['year'] 			= $year;					

					$data_hasil[] = $row;
				}
			// $data_hasil;
		}else{
			$data_hasil = array();
		}

		// dumper($data_hasil);

		// Hitung total semua data (tanpa filter)
		$this->db->from('v_hris_employee_updated');

		if (!empty($nik)) {

			if (is_array($nik)) {
				$this->db->where_in('nik', $nik);
			} else {
				$this->db->like('nik', $nik);
			}
		}

		$this->db->not_like('nik', '00000', 'after');
		// $this->db->not_like('nik', 'SPN', 'after');

		$this->db->group_by('nik');
    	$this->db->order_by('nik', 'ASC');
		///////////////
		$query = $this->db->get();
		$data_all = array();
		if($query){
			$res = $query->result_array();
			foreach ($res as $key) {
			
					$nik_emp = $key['nik'];
					$start_date = str_replace('-', '', (string) decrypt($key['start_date'])); // contoh: 2025 atau 20250517

					$year_sd = (int) substr($start_date, 0, 4); // ambil tahun saja
					$action  = decrypt($key['action']);

					$include = false;

						if ($action === 'Leaving') {
							if ($year <= $year_sd) {
								$include = true;
							}
						} else {
							// if ($year >= $year_sd) {
								$include = true;
							// }
						}

						if ($action === 'Leaving') {
							if ($year == $year_sd) {
								$status_emp = 'Leaving';
							}else{
								$status_emp = 'Active';
							}
						} else {
							// if ($year >= $year_sd) {
								$status_emp = 'Active';
							// }
						}

					// push data jika lolos filter
					if ($include) {
						$data_all[] = [
							'nik'           => $nik_emp,
							'complete_name' => decrypt($key['complete_name']),
							'action'        => $status_emp,
						];
					}
			}
		}else{
			$data_all = array();
		}
		// Hitung total data sebelum limit
		$totalData = count($data_all);

		// Format output untuk DataTables
		$result = array(
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $data_hasil
		);

		return $result;
	}
	
	
	public function get_detail_tm($year, $start = 0, $length = 10, $search = '', $order = '', $column = '', $nik = '', $month = '')
	{
		// Default sorting
		$orderColumn = 'a.employee_id';
		$orderDir    = 'ASC';

		if (!empty($order)) {
			$orderColumn = $column[$order[0]['column']]['data'];
			$orderDir    = $order[0]['dir'];
		}

		// =========================
		// FILTER TANGGAL
		// =========================
		if ($month === "All") {
			$startDate = "$year-01-01";
			$endDate   = "$year-12-31";
		} else {
			$month     = str_pad($month, 2, "0", STR_PAD_LEFT);
			$startDate = "$year-$month-01";
			$endDate   = date("Y-m-t", strtotime($startDate));
		}

		// =========================
		// BASE QUERY (REUSABLE)
		// =========================
		$this->db->from('hris_master_time_management a');
		$this->db->join('v_hris_employee_updated b', 'b.nik = a.employee_id', 'left');

		// Filter NIK
		if (!empty($nik)) {
			if (is_array($nik)) {
				$this->db->where_in('a.employee_id', $nik);
			} else {
				$this->db->like('a.employee_id', $nik);
			}
		}

		// Filter tanggal
		$this->db->where('a.date >=', $startDate);
		$this->db->where('a.date <=', $endDate);

		$this->db->not_like('a.employee_id', '00000', 'after');

		// =========================
		// CLONE QUERY UNTUK COUNT FILTERED
		// =========================
		$countQuery = clone $this->db;
		$countQuery->group_by(['a.employee_id', 'a.full_name', 'a.date']);
		$totalFiltered = $countQuery->count_all_results();

		// =========================
		// SELECT DATA
		// =========================
		$this->db->select("
			a.employee_id,
			a.full_name,
			a.date,
			a.dws AS schedule,
			a.schedule_in,
			a.schedule_out,
			a.check_in,
			a.check_out,
			a.attendence_code AS attendance_code,
			a.time_off_code,
			a.lat_in,
			a.long_in,
			a.lat_out,
			a.long_out,
			SEC_TO_TIME(
				CASE 
					WHEN a.schedule_code LIKE 'N%' 
					OR a.schedule_code LIKE 'SHF%' 
					THEN TIME_TO_SEC(
						TIMEDIFF(
							COALESCE(a.schedule_out,'00:00:00'),
							COALESCE(a.schedule_in,'00:00:00')
						)
					)
					ELSE 0
				END
			) AS schedule_working_hours,
			a.working_hours_t AS actual_working_hours,
			CASE 
				WHEN (
					a.attendence_code IN ('H')
					AND a.check_out IS NOT NULL
					AND TIME(a.check_out) < STR_TO_DATE(a.schedule_out, '%H:%i:%s')
				)
				THEN 'Early Check Out' 
				ELSE '-' 
			END AS early_check_out,
			CASE
				WHEN a.attendance_status = 'on_time' THEN 'On Time'
				WHEN a.attendance_status = 'late_in' THEN 'Late In'
				WHEN a.attendance_status = 'invalid_time' THEN 'Invalid Time'
				ELSE 'Absent'
			END AS attendance_status,
			a.check_in_location,
			a.check_out_location,
			b.personnel_area,
			b.personnel_subarea,
			b.department
		");

		$this->db->group_by(['a.employee_id', 'a.full_name', 'a.date']);
		$this->db->order_by($orderColumn, $orderDir);

		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		$query = $this->db->get();
		// dumper($query->result_array());
		$result = [];

		foreach ($query->result_array() as $key) {

			$personnel_area = decrypt($key['personnel_area']);

			$office_in  = $this->getOfficeRadius_ztm($personnel_area, $key['lat_in'], $key['long_in'], $key['date']) ?: 'NaN';
			$office_out = $this->getOfficeRadius_ztm($personnel_area, $key['lat_out'], $key['long_out'], $key['date']) ?: 'NaN';

			// Coordinate formatting
			$coordinates_in  = (!empty($key['lat_in']))  ? $key['lat_in'] . ', ' . $key['long_in'] : 'NaN';
			$coordinates_out = (!empty($key['lat_out'])) ? $key['lat_out'] . ', ' . $key['long_out'] : 'NaN';

			$dms_in  = (!empty($key['lat_in']))  ? DECtoDMS($key['lat_in'], 'lat') . ', ' . DECtoDMS($key['long_in'], 'long') : 'NaN';
			$dms_out = (!empty($key['lat_out'])) ? DECtoDMS($key['lat_out'], 'lat') . ', ' . DECtoDMS($key['long_out'], 'long') : 'NaN';

			$result[] = [
				'nik'                    => $key['employee_id'],
				'complete_name'          => $key['full_name'],
				'department'	         => decrypt($key['department']),
				'personnel_area'         => decrypt($key['personnel_area']),
				'personnel_subarea'      => decrypt($key['personnel_subarea']),
				'date'                   => $key['date'],
				'schedule'               => $key['schedule'],
				'schedule_in'            => $key['schedule_in'] ?: '-',
				'schedule_out'           => $key['schedule_out'] ?: '-',
				'check_in'               => $key['check_in'] ?: '-',
				'check_out'              => $key['check_out'] ?: '-',
				'attendance_code'        => $key['attendance_code'] ?: '-',
				'time_off_code'          => $key['time_off_code'] ?: '-',
				'schedule_working_hours' => $key['schedule_working_hours'] ?: '-',
				'actual_working_hours'   => $key['actual_working_hours'] ?: '-',
				'late_in'                => $key['attendance_status'] ?: '-',
				'early_check_out'        => $key['early_check_out'] ?: '-',
				'office_in'              => $office_in,
				'check_in_location'      => $key['check_in_location'] ?: '-',
				'coordinates_in'         => $coordinates_in,
				'dms_in'                 => $dms_in,
				'office_out'             => $office_out,
				'check_out_location'     => $key['check_out_location'] ?: '-',
				'coordinates_out'        => $coordinates_out,
				'dms_out'                => $dms_out
			];
		}

		// =========================
		// TOTAL DATA (SEMUA)
		// =========================
		$totalData = $totalFiltered; // bisa dipisah kalau mau tanpa filter

		return [
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $result
		];
	}

	/////////////End Report Summary and Details TM 2026/////////////////////
	
}