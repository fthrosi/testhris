<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->email = $this->session->userdata('user_email');
		$this->division = $this->session->userdata('division');
		$this->second_division = $this->session->userdata('second_division');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
		$this->today = date('Y-m-d');
	}

	public function getEmployee()
	{
		$result = $this->db->get('v_hris_employee_updated')->result();
		return $result;
	}

	public function getFamilyEmployee()
	{
		$result = $this->db->get('hris_family_employee')->result();
		return $result;
	}

	public function getCoupleEmployee()
	{
		$result = $this->db->get('hris_couple_employee')->result();
		return $result;
	}



	public function getPaguRawatJalan()
	{
		$result = $this->db->get('hris_medical_pagu_rawat_jalan')->result();
		return $result;
	}

	public function getEditPaguRawatJalan($id)
	{

		// $sql = "SELECT a.employee_id, b.complete_name, c.grandparent, d.parent, e.child, a.diagnosa, a.keterangan, a.total_nominal_kuitansi
		// 		FROM hris_medical_reimbursment_item a
		// 		LEFT JOIN hris_employee b ON a.employee_id = b.nik
		// 		LEFT JOIN hris_medical_type_of_reimbursment_grandparent c ON a.tor_grandparent =  c.id
		// 		LEFT JOIN hris_medical_type_of_reimbursment_parent d ON a.tor_parent = d.id
		// 		LEFT JOIN hris_medical_type_of_reimbursment_child e ON a.tor_child = e.id
		// 		ORDER BY a.employee_id ASC"

		$sql = "SELECT * FROM hris_medical_pagu_rawat_jalan WHERE id='$id'";
		$query = $this->db->query($sql);
		// dumper($query);
		$res = $query->result();
		return $res;
	}

	public function getEditPaguRawatInap($id)
	{
		$sql = "SELECT * FROM hris_medical_pagu_rawat_inap WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getEditPaguMaternity($id)
	{
		$sql = "SELECT * FROM hris_medical_pagu_maternity WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getEditPaguKacamata($id)
	{
		$sql = "SELECT * FROM hris_medical_pagu_kacamata WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getPaguRawatInap()
	{
		$result = $this->db->get('hris_medical_pagu_rawat_inap')->result();
		return $result;
	}

	public function getPaguMaternity()
	{
		$result = $this->db->get('hris_medical_pagu_maternity')->result();
		return $result;
	}

	public function getPaguKacamata()
	{
		$result = $this->db->get('hris_medical_pagu_kacamata')->result();
		return $result;
	}
	
	public function setPaguRawatJalan($start_date, $end_date, $grade, $pagu_tahun){		
		$formData = array(
					'start_date' => date('Y-m-d',strtotime($start_date)),
					'end_date' => date('Y-m-d',strtotime($start_date)),
					'grade' => $grade,
					'pagu_tahun' => $pagu_tahun
				);
		$query = $this->db->insert("hris_medical_pagu_rawat_jalan", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function updatePaguRawatJalan($id, $start_date, $end_date, $grade, $pagu_tahun){

		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));

		$sql = "UPDATE hris_medical_pagu_rawat_jalan SET start_date='$start_date', end_date='$end_date', grade='$grade', pagu_tahun='$pagu_tahun' WHERE id='$id'";
		$query = $this->db->query($sql);
		
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function getDeletePaguRawatJalan($id)
	{
		$id = encrypt($id);
		$sql = "SELECT * FROM hris_medical_reimbursment WHERE id_eg_prj='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if($res){
			$res;
			return false;
		}else{
			$id = decrypt($id);
			$sql = "DELETE FROM hris_medical_pagu_rawat_jalan where id = '".$id."'";
			$query = $this->db->query($sql);
			return true;
		}
	}

	public function setPaguRawatInap($start_date, $end_date, $grade, $pagu_kamar, $pagu_tahun){

		$formData = array(
					'start_date' => date('Y-m-d',strtotime($start_date)),
					'end_date' => date('Y-m-d',strtotime($end_date)),
					'grade' => $grade,
					'pagu_kamar_hari' => $pagu_kamar,
					'pagu_tahun' => $pagu_tahun
				);
		
		$query = $this->db->insert("hris_medical_pagu_rawat_inap", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function setPaguMaternity($start_date, $end_date, $melahirkan, $grade, $pagu_tahun){

		$formData = array(
					'start_date' => date('Y-m-d',strtotime($start_date)),
					'end_date' => date('Y-m-d',strtotime($end_date)),
					'melahirkan' => $melahirkan,
					'grade' => $grade,
					'pagu_tahun' => $pagu_tahun
				);
		
		$query = $this->db->insert("hris_medical_pagu_maternity", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function updatePaguRawatInap($id, $start_date, $end_date, $grade, $pagu_kamar, $pagu_tahun){

		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));

		$sql = "UPDATE hris_medical_pagu_rawat_inap SET start_date='$start_date', end_date='$end_date', grade='$grade', pagu_kamar_hari='$pagu_kamar', pagu_tahun='$pagu_tahun' WHERE id='$id'";
		$query = $this->db->query($sql);
		

		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function updatePaguMaternity($id, $start_date, $end_date, $melahirkan, $grade, $pagu_tahun){

		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));

		$sql = "UPDATE hris_medical_pagu_maternity SET start_date='$start_date', end_date='$end_date', melahirkan='$melahirkan', grade='$grade', pagu_tahun='$pagu_tahun' WHERE id='$id'";
		$query = $this->db->query($sql);
		
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function getDeletePaguRawatInap($id)
	{
		$id = encrypt($id);
		$sql = "SELECT * FROM hris_medical_reimbursment WHERE id_eg_pri='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if($res){
			$res;
			return false;
		}else{
			$id = decrypt($id);
			$sql = "DELETE FROM hris_medical_pagu_rawat_inap where id = '".$id."'";
			$query = $this->db->query($sql);
			return true;
		}
	}

	public function getDeletePaguMaternity($id)
	{
		$sql = "DELETE FROM hris_medical_pagu_maternity where id = '".$id."'";
		$query = $this->db->query($sql);
		return true;
	}

	public function setPaguKacamata($start_date, $end_date, $grade, $pagu_one_focus, $pagu_two_focus, $pagu_frame){

		$formData = array(
					'start_date' => date('Y-m-d',strtotime($start_date)),
					'end_date' => date('Y-m-d',strtotime($end_date)),
					'grade' => $grade,
					'pagu_one_focus_tahun' => $pagu_one_focus,
					'pagu_two_focus_tahun' => $pagu_two_focus,
					'pagu_frame_dua_tahun' => $pagu_frame
				);
		
		$query = $this->db->insert("hris_medical_pagu_kacamata", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function updatePaguKacamata($id, $start_date, $end_date, $grade, $pagu_one_focus, $pagu_two_focus, $pagu_frame){
		
		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));
		
		$sql = "UPDATE hris_medical_pagu_kacamata SET start_date='$start_date', end_date='$end_date', grade='$grade', pagu_one_focus_tahun='$pagu_one_focus', pagu_two_focus_tahun='$pagu_two_focus', pagu_frame_dua_tahun='$pagu_frame' WHERE id='$id'";
		$query = $this->db->query($sql);
		
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function getDeletePaguKacamata($id)
	{
		$id = encrypt($id);
		$sql = "SELECT * FROM hris_medical_reimbursment WHERE id_eg_pk='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if($res){
			$res;
			return false;
		}else{
			$id = decrypt($id);
			$sql = "DELETE FROM hris_medical_pagu_kacamata where id = '".$id."'";
			$query = $this->db->query($sql);
			return true;
		}
	}

	public function setGrandparent($grandparent, $description=""){

		$formData = array(
					'grandparent' => $grandparent,
					'description' => $description
				);
		
		$query = $this->db->insert("hris_medical_type_of_reimbursment_grandparent", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function setParent($parent_grandparent, $parent, $description_parent=""){

		$formData = array(
					'grandparent' => $parent_grandparent,
					'parent' => $parent,
					'description' => $description_parent
				);
		
		$query = $this->db->insert("hris_medical_type_of_reimbursment_parent", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function setChild($start_date, $end_date, $child_grandparent, $child_parent, $child, $claim_percentage_child, $description_child=""){

		$formData = array(
					'start_date' => date('Y-m-d',strtotime($start_date)),
					'end_date' => date('Y-m-d',strtotime($end_date)),
					'grandparent' => $child_grandparent,
					'parent' => $child_parent,
					'child' => $child,
					'claim_percentage' => $claim_percentage_child,
					'description' => $description_child
				);
		
		$query = $this->db->insert("hris_medical_type_of_reimbursment_child", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}

	public function getGrandparent()
	{
		$result = $this->db->get('hris_medical_type_of_reimbursment_grandparent')->result();
		return $result;
	}

	public function getParent()
	{
		$sql = "SELECT 	
					a.id as id,
					b.grandparent as grandparent,
					a.parent as parent,
					a.description as description
				FROM		
					hris_medical_type_of_reimbursment_parent a
				LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.grandparent = b.id AND a.is_active=1";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getChild()
	{
		$sql = "SELECT 	
					a.id as id,
					a.grandparent as id_grandparent,
					a.start_date as start_date,
					a.end_date as end_date,
					b.grandparent as grandparent,
					c.parent as parent,
					a.child as child,
					a.claim_percentage as claim_percentage,
					a.claim_value as claim_value,
					a.description as description
				FROM		
					hris_medical_type_of_reimbursment_child a
				LEFT JOIN hris_medical_type_of_reimbursment_grandparent b ON a.grandparent = b.id
				LEFT JOIN hris_medical_type_of_reimbursment_parent c ON a.parent = c.id
				ORDER BY a.grandparent";

		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;


	}

	public function getUsers()
	{
		$sql = "SELECT * FROM users ORDER BY id_user ASC";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getRPM()
	{
		$sql = "SELECT * FROM hris_rpm ORDER BY id ASC";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function get_Grandparent(){
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_grandparent";
		$query  = $this->db->query($sql);
		$output = '<option value="">Jenis Penggantian</option>';
		foreach($query->result() as $row)
		{
			$output .= '<option value="'.$row->id.'">'.$row->grandparent.'</option>';
		}
		return $output;
	}

	public function edit_get_Grandparent($id){
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_grandparent";
		$query  = $this->db->query($sql);

		$output = '';
		foreach($query->result() as $row)
		{
			if ($row->id == $id){
				$output .= '<option value="'.$row->id.'" selected>' .$row->grandparent. '</option>';
			}else{
				$output .= '<option value="'.$row->id.'">'.$row->grandparent.'</option>';
			}
			
		}
		return $output;
	}

	public function get_Parent($id_grandparent, $emp_group = null){
		$joinYears = $this->session->userdata('joindate');
		$user_nik = $this->session->userdata('nik');
		if ($user_nik == '00000000') {
			$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1";
		} else {
			switch ($emp_group) {
			case 'GOL A':
			case 'GOL B':
			case 'GOL C':
			case 'GOL D':
			case 'GOL E':
				$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1";
				break;			
				default:
				if($joinYears < 1){
					$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1 and parent != 'Medical Check Up' and parent != 'Kehamilan' ";
					
				}else if($joinYears !=0 AND $joinYears >= 1){
				$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id_grandparent' and is_active = 1 and parent != 'Medical Check Up'";
				}
				break;
			}
		}
		
		$query  = $this->db->query($sql);
		$output = '<option value="">Sub Penggantian</option>';
		foreach($query->result() as $row)
		{
		$output .= '<option value="'.$row->id.'">'.$row->parent.'</option>';
			//$output .= '<option value="'.$row->id.'">'.$joinYears.'</option>';
		
		}

		// if ($emp_group != 'GOL A' || $emp_group != 'GOL B' || $emp_group != 'GOL C' || $emp_group != 'GOL D' || $emp_group != 'GOL E') {
		// 	$array = array_diff($output,['Medical Check Up']);
		// }
		// dumper($output);
		return $output;
	}

	public function edit_get_Parent($id){
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent";
		$query  = $this->db->query($sql);

		$output = '';
		foreach($query->result() as $row)
		{
			if ($row->id == $id){
				$output .= '<option value="'.$row->id.'" selected>' .$row->parent. '</option>';
			}else{
				$output .= '<option value="'.$row->id.'">'.$row->parent.'</option>';
			}
			
		}
		return $output;
	}

	public function get_Child($id_parent){
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_child WHERE parent='$id_parent'";
		$query  = $this->db->query($sql);
		$output = '<option value="">Penggantian</option>';
		foreach($query->result() as $row)
		{
		$output .= '<option value="'.$row->id.'">'.$row->child.'</option>';
		}
		return $output;
	}

	public function getEditGrandparent($id)
	{
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_grandparent WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getDeleteGrandparent($id)
	{
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if($res){
			$res;
			return false;
		}else{
			$sql = "DELETE FROM hris_medical_type_of_reimbursment_grandparent where id = '".$id."'";
			$query = $this->db->query($sql);
			return true;
		}
	}

	public function ubah_grandparent($id, $grandparent, $description)
	{
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE grandparent='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		// if($res){
		// 	$res;
		// 	return false;
		// }else{
			$sql = "UPDATE hris_medical_type_of_reimbursment_grandparent SET grandparent='$grandparent', description='$description' WHERE id='$id'";
			$query = $this->db->query($sql);
			return true;
		// }
	}

	public function getEditParent($id)
	{
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_parent WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getDeleteParent($id)
	{
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_child WHERE parent='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if($res){
			$res;
			return false;
		}else{
			$sql = "DELETE FROM hris_medical_type_of_reimbursment_parent where id = '".$id."'";
			$query = $this->db->query($sql);
			return true;
		}
	}

	public function ubah_parent($id, $grandparent, $parent, $description)
	{
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_child WHERE parent='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		// dumper($sql);
		// if($res){
		// 	$res;
		// 	return false;
		// }else{
			$sql = "UPDATE hris_medical_type_of_reimbursment_parent SET grandparent='$grandparent', parent='$parent', description='$description' WHERE id='$id'";
			$query = $this->db->query($sql);
			return true;
		// }
	}

	public function getEditChild($id)
	{
		$sql = "SELECT * FROM hris_medical_type_of_reimbursment_child WHERE id='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function ubah_child($id, $start_date, $end_date, $child_grandparent, $child_parent, $child, $claim_percentage_child, $claim_value_child, $description_child)
	{
		$sql = "SELECT * FROM hris_medical_reimbursment_item WHERE tor_child='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		// dumper($sql);
		// if($res){
		// 	$res;
		// 	return false;
		// }else{
			$start_date = date('Y-m-d',strtotime($start_date));
			$end_date = date('Y-m-d',strtotime($end_date));
			
			$sql = "UPDATE hris_medical_type_of_reimbursment_child SET start_date ='$start_date', end_date ='$end_date', grandparent='$child_grandparent', parent='$child_parent', child='$child', claim_percentage='$claim_percentage_child', claim_value='$claim_value_child', description='$description_child' WHERE id='$id'";
			$query = $this->db->query($sql);
			return true;
		// }
	}

	public function getDeleteChild($id)
	{
		$sql = "SELECT * FROM hris_medical_reimbursment_item WHERE tor_child='$id'";
		$query = $this->db->query($sql);
		$res = $query->result();
		if($res){
			$res;
			return false;
		}else{
			$sql = "DELETE FROM hris_medical_type_of_reimbursment_child where id = '".$id."'";
			$query = $this->db->query($sql);
			return true;
		}
	}
	
	public function delete_couple($id)
	{
		$sql = "DELETE FROM hris_couple_employee where id = '".$id."'";
		$query = $this->db->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function getEmployeeToUsers(){

		// $sql = "with cteRowNumber as (
		// 	select nik, complete_name,
		// 		   row_number() over(partition by nik order by id_employee desc) as RowNum
		// 		from hris_employee
		// )
		// select nik, complete_name
		// 	from cteRowNumber
		// 	where RowNum = 1
		// 	";
		
		$sql = "SELECT nik, complete_name FROM v_hris_employee_updated WHERE action != '".encrypt('Leaving')."' AND division !='".encrypt('HR SUPPORT')."' GROUP BY nik, complete_name";
		$query  = $this->db->query($sql);
		//dumper($query);
		$output = '<option value="">Select Employee</option>';
		foreach($query->result() as $row)
		{
			$complete_name = str_replace("||","'", decrypt($row->complete_name));
			$output .= '<option value="'.$row->complete_name.'">'.$complete_name.'</option>';
		}
		return $output;
	}

	public function getMaleEmployee(){
		$gender = encrypt('Male');
		$status1	= encrypt('Single');
		$status2	= encrypt('Div.');
		//$sql = "SELECT nik, complete_name FROM hris_employee WHERE gender = '$gender' AND ( marital_status = '$status1' OR marital_status = '$status2') GROUP BY nik, complete_name";

		////Start Perubahan Tanggal 16/10/2023 Rekon Luffi Dengan Tiopan//////
		$sql = "SELECT nik, complete_name FROM v_hris_employee_updated WHERE gender = '$gender' AND action != '".encrypt('Leaving')."' GROUP BY nik, complete_name";
		////End - Mengganti Table dari hris_employee to v_hris_employee_updated /////////////////

		$query  = $this->db->query($sql);
		$output = '<option value="">Select Employee</option>';
		foreach($query->result() as $row)
		{
			$complete_name = str_replace("||","'", decrypt($row->complete_name));
			$output .= '<option value="'.$row->complete_name.'">'.$complete_name.'</option>';
		}
		return $output;
	}

	public function getFemaleEmployee(){
		$gender = encrypt('Female');
		$status1	= encrypt('Single');
		$status2	= encrypt('Div.');
		//$sql = "SELECT nik, complete_name FROM hris_employee WHERE gender = '$gender' AND ( marital_status = '$status1' OR marital_status = '$status2') GROUP BY nik, complete_name";

		////Start Perubahan Tanggal 16/10/2023 Rekon Luffi Dengan Tiopan//////
		$sql = "SELECT nik, complete_name FROM v_hris_employee_updated WHERE gender = '$gender' AND action != '".encrypt('Leaving')."' GROUP BY nik, complete_name";
		////End - Mengganti Table dari hris_employee to v_hris_employee_updated /////////////////

		$query  = $this->db->query($sql);
		$output = '<option value="">Select Employee</option>';
		foreach($query->result() as $row)
		{
			$complete_name = str_replace("||","'", decrypt($row->complete_name));
			$output .= '<option value="'.$row->complete_name.'">'.$complete_name.'</option>';
		}
		return $output;
	}

	public function get_DataEmployeeToUsers($full_name_tambah_users)
	{
		$sql = "SELECT nik, email, phone_number FROM v_hris_employee_updated WHERE complete_name ='$full_name_tambah_users' AND action != '".encrypt('Leaving')."' ORDER BY id_employee DESC LIMIT 1";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		$nik = $res[0]['nik'];
		$email = decrypt($res[0]['email']);
		$phone_number = decrypt($res[0]['phone_number']);
		$res=array('nik'=>$nik,'email'=>$email,'phone_number'=>$phone_number);
		//dumper($res);
		return $res;
	}

	public function setUsers($nik, $complete_name, $password, $role, $access, $verification, $email="", $phone_number=""){
		$complete_name 	= decrypt($complete_name);
		$password 		= encrypt($password);
		$formData = array(
					'employee_id' => $nik,
					'full_name' => $complete_name,
					'user_email' => $email,
					'phone_number' => $phone_number,
					'password' => $password,
					'user_role' => $role,
					'access_level' => $access,
					'verification_status' => $verification
				);
		
		$query = $this->db->insert("users", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}


	public function get_DataEmployeeMale($full_name_male_add_couple)
	{
		$sql 	= "SELECT nik FROM v_hris_employee_updated WHERE complete_name ='$full_name_male_add_couple'";
		$query 	= $this->db->query($sql);
		$res 	= $query->result_array();
		$nik 	= $res[0]['nik'];
		$res	= array('nik'=>$nik);
		//dumper($res);
		return $res;
	}
	
	public function get_DataEmployeeFemale($full_name_female_add_couple)
	{
		$sql 	= "SELECT nik FROM v_hris_employee_updated WHERE complete_name ='$full_name_female_add_couple'";
		$query 	= $this->db->query($sql);
		$res 	= $query->result_array();
		$nik 	= $res[0]['nik'];
		$res	= array('nik'=>$nik);
		//dumper($res);
		return $res;
	}

	///////////////////////////////Start Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////
	public function add_couple_employee($employee_id_male, $employee_id_female, $complete_name_male, $complete_name_female, $start_date_couple, $end_date_couple){

		$formData = array(
					'male_nik' => $employee_id_male,
					'female_nik' => $employee_id_female,
					'male_employee' => $complete_name_male,
					'female_employee' => $complete_name_female,
					'start_date' => $start_date_couple,
					'end_date' => $end_date_couple
				);
		
		$query = $this->db->insert("hris_couple_employee", $formData);
		// $query = $this->db->insert_id();
		if($query){
			return true;
		}else{
			return false;
		}

	}
	///////////////////////////////End Penambahan Start date dan end date couple Luffi 2025 //////////////////////////////

	public function save_act_child($id_family, $st_act){

		$sql = "UPDATE hris_family_employee SET status_act='$st_act' WHERE id_family='$id_family'";
		$query = $this->db->query($sql);
		
		if($query){
			return true;
		}else{
			return false;
		}

	}

	
	public function tambah_efektifitas_kuitansi($hari, $start_date_tambah_efektif_kuitansi){


		$sqlt 	= "SELECT id, start_date FROM hris_efektifitas_kuitansi ORDER BY id DESC LIMIT 3";
		$queryt = $this->db->query($sqlt);
		$rest 	= $queryt->result_array();
		$start_datet 	= (!empty(($rest[0]['start_date']))) ? $rest[0]['start_date'] : '';
		$idt 	= (!empty(($rest[1]['id']))) ? $rest[1]['id'] : '';
			// dumper($idt);

		$tgl1 = strtotime($start_datet); 
		$tgl2 = strtotime($start_date_tambah_efektif_kuitansi);
		$jarak = $tgl2 - $tgl1;
		$jarak_hari = $jarak / 60 / 60 / 24;
		
		if($jarak_hari > 0){			
			$sql 	= "SELECT id FROM hris_efektifitas_kuitansi WHERE end_date ='9999-12-31' and active = '1' ORDER BY id DESC LIMIT 1";
			$query 	= $this->db->query($sql);
			$res 	= $query->result_array();
			if (!empty($res)){
				$id 	= $res[0]['id'];
				
				$update_end_date = date('Y-m-d', strtotime('-1 days', strtotime($start_date_tambah_efektif_kuitansi)));
				$sql = "UPDATE hris_efektifitas_kuitansi SET end_date = '$update_end_date' WHERE id='$id'";
				$query = $this->db->query($sql);

				$sqla = "UPDATE hris_efektifitas_kuitansi SET active = '0' WHERE id='$id'";
				$querya = $this->db->query($sqla);
			}

			$formData = array(
						'efektif_kuitansi' => $hari,
						'start_date' => date('Y-m-d',strtotime($start_date_tambah_efektif_kuitansi)),
						'end_date' => '9999-12-31',
						'active' => '1'	
					);
			
			$query = $this->db->insert("hris_efektifitas_kuitansi", $formData);
			// $query = $this->db->insert_id();
			
			if($query){
				$query = 'jarak_plus';
			}else{
				$query = false;
			}

		}else{
			$query = 'jarak_minus';
		}

		//dumper($query);
		if($query == 'jarak_minus'){
			return $query;
		}else if($query == 'jarak_plus'){
			return true;
		}else{
			return false;
		}

	}

	public function getEKuitansi()
	{
		$result = $this->db->get('hris_efektifitas_kuitansi')->result();
		return $result;
	}

	public function getDeleteEkuitansi($id)
	{
		$sqlt 	= "SELECT id FROM hris_efektifitas_kuitansi ORDER BY id DESC limit 3";
		$queryt = $this->db->query($sqlt);
		$rest 	= $queryt->result_array();
		$idt0 	= (!empty(($rest[0]['id']))) ? $rest[0]['id'] : '';
		$idt1 	= (!empty(($rest[1]['id']))) ? $rest[1]['id'] : '';
		$idt2 	= (!empty(($rest[2]['id']))) ? $rest[2]['id'] : '';

		if($id == $idt0){
			$sqla = "UPDATE hris_efektifitas_kuitansi SET active = '1' WHERE id='$idt2'";
			$querya = $this->db->query($sqla);	

			$sql = "UPDATE hris_efektifitas_kuitansi SET end_date = '9999-12-31' WHERE id='$idt1'";
			$query = $this->db->query($sql);

			$sqldel = "DELETE FROM hris_efektifitas_kuitansi where id = '".$id."'";
			$querydel = $this->db->query($sqldel);
		}else if($id == $idt1){
			$sqla = "UPDATE hris_efektifitas_kuitansi SET active = '1' WHERE id='$idt2'";
			$querya = $this->db->query($sqla);	

			$sql = "UPDATE hris_efektifitas_kuitansi SET end_date = '9999-12-31' WHERE id='$idt2'";
			$query = $this->db->query($sql);
			
			$sqldel = "DELETE FROM hris_efektifitas_kuitansi where id = '".$id."'";
			$querydel = $this->db->query($sqldel);
		}

		if($querydel){
			return true;
		}else{
			return false;
		}
	}

	public function getMul_Div(){
		$sql = "SELECT a.*, b.complete_name FROM multi_division a LEFT JOIN v_hris_employee_updated AS b ON a.nik=b.nik";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	public function getDataDivisions(){

		$nik = array('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007');
		$this->db->where("action !=",encrypt('Leaving'));
		$this->db->where("division !=",encrypt('HR SUPPORT'));
		$this->db->where("division !=",'');
		$cari_tis = $this->db->get('v_hris_employee_updated')->result_array();
		$data = array();
		foreach($cari_tis as $key => $val){
			$personnel_area		= decrypt($val['personnel_area']);
			$pers 				= substr($personnel_area,0,3);
			if($pers != "TIS"){
				$data[] = $val['nik'];
			}

		}
		$this->db->select('division');
		$this->db->where_in('nik', $data);
		$this->db->group_by('division');
		$divisions = $this->db->get('v_hris_employee_updated')->result_array();
		
		$output = '<option value="">Select Division</option>';
		foreach($divisions as $row => $val)
		{
			$division = str_replace("||","'", decrypt($val['division']));
			$output .= '<option value="'.$division.'">'.$division.'</option>';
		}
		return $output;
	}

	public function save_add_multi_division($nik, $divisi, $year){
		// dumper($divisi);
		$sql = "SELECT * FROM multi_division WHERE nik = '$nik' AND division = '".encrypt($divisi)."' AND eval_year = '$year'";
		$query = $this->db->query($sql);
		$res = $query->row();
		if($res){
			return 2;
		}else{

			$sql2 = "SELECT nik FROM multi_division WHERE division = '".encrypt($divisi)."' AND eval_year = '$year'";
			$query2 = $this->db->query($sql2);
			$res2 = $query2->row();
			if(!empty($res2)){
				if($res2->nik != $nik){
					return 3;
				}else{
					$formData = array(
						'nik' => $nik,
						'division' => encrypt($divisi),
						'eval_year' => $year
					);
					$query = $this->db->insert("multi_division", $formData);
					if($query){
						return true;
					}else{
						return false;
					}
				}
			}else{
					$formData = array(
						'nik' => $nik,
						'division' => encrypt($divisi),
						'eval_year' => $year
					);
					$query = $this->db->insert("multi_division", $formData);
					if($query){
						return true;
					}else{
						return false;
					}
			}
			
		}

	}

		//////////////////////////////////////////// START TIME MANAGEMENT 2024 ////////////////////////////////////////////

		public function getTimeOff()
		{
			$result = $this->db->get('hris_master_time_off')->result();
			return $result;
		}
	
		public function setTimeOff($nama, $kode, $company_name, $company_code, $start_date_tambah, $end_date, $deskripsi){
	
			if(empty($deskripsi)){
				$deskripsi = "None.";
			}
	
			$sql1 = "SELECT id, start_date, end_date FROM hris_master_time_off WHERE kode='$kode' AND company_code='$company_code' ORDER BY id DESC LIMIT 3";
			$query1 = $this->db->query($sql1);
			$rest 	= $query1->result_array();
	
			if(!empty($rest))
			{
				$start_datet = (!empty(($rest[0]['start_date']))) ? $rest[0]['start_date'] : '';
	
				$tgl1 = strtotime($start_datet); 
				$tgl2 = strtotime($start_date_tambah);
	
				$jarak = $tgl2 - $tgl1;
				$jarak_hari = $jarak / 60 / 60 / 24;
	
				if($jarak_hari > 0){
					$check_end_date = $rest[0]['end_date'];
					$sql2 	= "SELECT id FROM hris_master_time_off WHERE kode = '$kode' AND end_date = '$check_end_date' AND company_code = '$company_code' ORDER BY id DESC LIMIT 1";
					$query2 	= $this->db->query($sql2);
					$res 	= $query2->result_array();
					$id 	= $res[0]['id'];
					
					$update_end_date = date('Y-m-d', strtotime('-1 days', strtotime($start_date_tambah)));
					$sqlup = "UPDATE hris_master_time_off SET end_date = '$update_end_date' WHERE id='$id'";
					$queryup = $this->db->query($sqlup);
	
					$sqlup2 = "UPDATE hris_master_time_off SET status = 0 WHERE id='$id'";
					$queryup2 = $this->db->query($sqlup2);
	
					$formData = array(
						'nama' => $nama,
						'kode' => $kode,
						'company_name' => $company_name,
						'company_code' => $company_code,
						'start_date' => $start_date_tambah,
						'end_date' => $end_date,
						'deskripsi' => $deskripsi,
						'status' => 1
					);
					
					$this->db->insert("hris_master_time_off", $formData);
					$query = $this->db->insert_id();
					
					if($query){
						$query = 'jarak_plus';
					}else{
						$query = false;
					}
	
				}else{
					$query = 'jarak_minus';
				}
	
			} else {
				$formData = array(
					'nama' => $nama,
					'kode' => $kode,
					'company_name' => $company_name,
					'company_code' => $company_code,
					'start_date' => $start_date_tambah,
					'end_date' => $end_date,
					'deskripsi' => $deskripsi,
					'status' => 1
				);
				$this->db->insert("hris_master_time_off", $formData);
				$query = $this->db->insert_id();
				if($query){
					$query = true;
				}else{
					$query = false;
				}
	
			}
			
			if($query == 'jarak_minus'){
				return $query;
			}else if($query == 'jarak_plus'){
				return true;
			}else{
				return false;
			}
		}
	
		public function updateTimeOff($id, $nama, $kode, $company_name, $company_code, $start_date_update, $end_date, $deskripsi){
	
			if(empty($deskripsi)){
				$deskripsi = "None.";
			}
	
			$sql1 = "SELECT id, start_date FROM hris_master_time_off WHERE kode='$kode' AND company_code='$company_code' ORDER BY id DESC LIMIT 3";
			$query1 = $this->db->query($sql1);
			$rest 	= $query1->result_array();
	
			if(count($rest)>1){
				$start_datet = (!empty(($rest[0]['start_date']))) ? $rest[0]['start_date'] : '';
	
				$tgl1 = strtotime($start_datet); 
				$tgl2 = strtotime($start_date_update);
	
				$jarak = $tgl2 - $tgl1;
				$jarak_hari = $jarak / 60 / 60 / 24;
	
				if($jarak_hari < 0){
					$query = 'jarak_minus';
					return $query;
				} else {
					$previous_id = $rest[1]['id'];
					$update_end_date = date('Y-m-d', strtotime('-1 days', strtotime($start_date_update)));
					$sqlup = "UPDATE hris_master_time_off SET end_date = '$update_end_date' WHERE id='$previous_id'";
					$queryup = $this->db->query($sqlup);
				}
			}
	
			$sql = "UPDATE hris_master_time_off SET nama='$nama', kode='$kode', company_name='$company_name', company_code='$company_code', start_date='$start_date_update', end_date='$end_date', deskripsi='$deskripsi' WHERE id='$id'";
			$query = $this->db->query($sql);
	
			if($query){
				return true;
			}else{
				return false;
			}
	
		}
	
		public function getEditTimeOff($id)
		{
			$sql = "SELECT * FROM hris_master_time_off WHERE id='$id'";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}
	
		public function getDeleteTimeOff($id, $kode)
		{
	
			$sqlt 	= "SELECT id, end_date FROM hris_master_time_off WHERE kode='$kode' ORDER BY id DESC";
			$queryt = $this->db->query($sqlt);
			$rest 	= $queryt->result_array();
			// print_r(count($rest)); die;
			$idlast	= end($rest)['id'];
	
			if($id != $idlast){
				for ($x = 0; $x <= count($rest); $x++) {
					if ($id == $rest[$x]['id']){
						break;
					}
				}
				$updated_end_date = $rest[$x]['end_date'];
				$next_id = $rest[$x + 1]['id'];
				$sql = "UPDATE hris_master_time_off SET end_date = '$updated_end_date' WHERE id='$next_id'";
				$query = $this->db->query($sql);
	
				$sqlupd = "UPDATE hris_master_time_off SET status = 1 WHERE id='$next_id'";
				$queryupd = $this->db->query($sqlupd);
				
			}else{
			}
			
			$sqldel = "DELETE FROM hris_master_time_off where id = '$id'";
			$querydel = $this->db->query($sqldel);
	
			if($querydel){
				return true;
			}else{
				return false;
			}
	
		}
	
		public function getSchedule(){
			$result = $this->db->get('hris_master_schedule')->result();
			return $result;
		}
	
		public function setSchedule($nama, $kode, $company_name, $company_code, $start_date_tambah, $end_date, $schedule_in, $schedule_out, $tipe_shift){
	
			$sql1 = "SELECT id, start_date, end_date FROM hris_master_schedule WHERE kode='$kode' AND company_code='$company_code' ORDER BY id DESC LIMIT 3";
			$query1 = $this->db->query($sql1);
			$rest 	= $query1->result_array();
	
			if(!empty($rest))
			{
				$start_datet = (!empty(($rest[0]['start_date']))) ? $rest[0]['start_date'] : '';
	
				$tgl1 = strtotime($start_datet); 
				$tgl2 = strtotime($start_date_tambah);
	
				$jarak = $tgl2 - $tgl1;
				$jarak_hari = $jarak / 60 / 60 / 24;
	
				if($jarak_hari > 0){
					$check_end_date = $rest[0]['end_date'];
					$sql2 	= "SELECT id FROM hris_master_schedule WHERE kode = '$kode' AND end_date = '$check_end_date' AND company_code = '$company_code' ORDER BY id DESC LIMIT 1";
					$query2 	= $this->db->query($sql2);
					$res 	= $query2->result_array();
					$id 	= $res[0]['id'];
					
					$update_end_date = date('Y-m-d', strtotime('-1 days', strtotime($start_date_tambah)));
					$sqlup = "UPDATE hris_master_schedule SET end_date = '$update_end_date' WHERE id='$id'";
					$queryup = $this->db->query($sqlup);
	
					$sqlup2 = "UPDATE hris_master_schedule SET status = 0 WHERE id='$id'";
					$queryup2 = $this->db->query($sqlup2);
	
					$formData = array(
						'nama' => $nama,
						'kode' => $kode,
						'company_name' => $company_name,
						'company_code' => $company_code,
						'start_date' => $start_date_tambah,
						'end_date' => $end_date,
						'schedule_in' => $schedule_in,
						'schedule_out' => $schedule_out,
						'shift_type' => $tipe_shift,
						'status' => 1
					);
					
					$this->db->insert("hris_master_schedule", $formData);
					$query = $this->db->insert_id();
					
					if($query){
						$query = 'jarak_plus';
					}else{
						$query = false;
					}
	
				}else{
					$query = 'jarak_minus';
				}
	
			} else {
				$formData = array(
					'nama' => $nama,
					'kode' => $kode,
					'company_name' => $company_name,
					'company_code' => $company_code,
					'start_date' => $start_date_tambah,
					'end_date' => $end_date,
					'schedule_in' => $schedule_in,
					'schedule_out' => $schedule_out,
					'shift_type' => $tipe_shift,
					'status' => 1
				);
				$this->db->insert("hris_master_schedule", $formData);
				$query = $this->db->insert_id();
				if($query){
					$query = true;
				}else{
					$query = false;
				}
	
			}
			
			if(($query == 'jarak_minus') || ($query == 'waktu_minus')){
				return $query;
			}else if($query == 'jarak_plus'){
				return true;
			}else{
				return false;
			}
		}
	
		public function getEditSchedule($id)
		{
			$sql = "SELECT * FROM hris_master_schedule WHERE id='$id'";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}
	
		public function updateSchedule($id, $nama, $kode, $company_name, $company_code, $start_date_update, $end_date, $schedule_in, $schedule_out, $tipe_shift){
	
			$sql1 = "SELECT id, start_date FROM hris_master_schedule WHERE kode='$kode' AND company_code='$company_code' ORDER BY id DESC LIMIT 3";
			$query1 = $this->db->query($sql1);
			$rest 	= $query1->result_array();
			// print_r($rest); die;
	
			if(count($rest)>1){
				$start_datet = (!empty(($rest[0]['start_date']))) ? $rest[0]['start_date'] : '';
	
				$tgl1 = strtotime($start_datet); 
				$tgl2 = strtotime($start_date_update);
	
				$jarak = $tgl2 - $tgl1;
				$jarak_hari = $jarak / 60 / 60 / 24;
	
				if($jarak_hari < 0){
					$query = 'jarak_minus';
					return $query;
				} else {
					$previous_id = $rest[1]['id'];
					$update_end_date = date('Y-m-d', strtotime('-1 days', strtotime($start_date_update)));
					$sqlup = "UPDATE hris_master_schedule SET end_date = '$update_end_date' WHERE id='$previous_id'";
					$queryup = $this->db->query($sqlup);
				}
			}
	
			$sql = "UPDATE hris_master_schedule SET nama='$nama', kode='$kode', company_name='$company_name', company_code='$company_code', start_date='$start_date_update', end_date='$end_date', schedule_in='$schedule_in', schedule_out='$schedule_out', shift_type='$tipe_shift' WHERE id='$id'";
			$query = $this->db->query($sql);
	
			if($query){
				return true;
			}else{
				return false;
			}
	
		}
	
		public function getDeleteSchedule($id, $kode)
		{
	
			$sqlt 	= "SELECT id, end_date FROM hris_master_schedule WHERE kode='$kode' ORDER BY id DESC";
			$queryt = $this->db->query($sqlt);
			$rest 	= $queryt->result_array();
			$idlast	= end($rest)['id'];
	
			if($id != $idlast){
				for ($x = 0; $x <= count($rest); $x++) {
					if ($id == $rest[$x]['id']){
						break;
					}
				}
				$updated_end_date = $rest[$x]['end_date'];
				$next_id = $rest[$x + 1]['id'];
				$sql = "UPDATE hris_master_schedule SET end_date = '$updated_end_date' WHERE id='$next_id'";
				$query = $this->db->query($sql);
	
				$sqlupd = "UPDATE hris_master_schedule SET status = 1 WHERE id='$next_id'";
				$queryupd = $this->db->query($sqlupd);
				
			}else{
			}
			
			$sqldel = "DELETE FROM hris_master_schedule where id = '$id'";
			$querydel = $this->db->query($sqldel);
	
			if($querydel){
				return true;
			}else{
				return false;
			}
	
		}
	
		public function getOffice(){
			$result = $this->db->get('hris_master_personnel_area')->result();
			return $result;
		}
	
		public function setOfficeLoc_ztm($nama, $kode, $start_date, $end_date, $alamat, $lat, $long, $radius){
			$formData = array(
				'personnel_area' => $nama,
				'pa_code' => $kode,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'address' => $alamat,
				'lattitude' => $lat,
				'longitude' => $long,
				'radius' => $radius
			);
			$this->db->insert("hris_master_personnel_area", $formData);
			$query = $this->db->insert_id();
			if($query){
				return true;
			}else{
				return false;
			}
		}
	
		public function getEditOffice_ztm($id)
		{
			$sql = "SELECT * FROM hris_master_personnel_area WHERE id='$id'";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}
	
		public function updateOfficeLoc_ztm($id, $nama, $kode, $start_date, $end_date, $alamat, $lat, $long, $radius){
	
			$sql = "UPDATE hris_master_personnel_area SET personnel_area='$nama', pa_code='$kode', start_date='$start_date', end_date='$end_date', address='$alamat', lattitude='$lat', longitude='$long', radius='$radius' WHERE id='$id'";
			$query = $this->db->query($sql);
	
			if($query){
				return true;
			}else{
				return false;
			}
	
		}
	
		public function getDeleteOffice_ztm($id)
		{
			$sqldel = "DELETE FROM hris_master_personnel_area where id = '$id'";
			$querydel = $this->db->query($sqldel);
	
			if($querydel){
				return true;
			}else{
				return false;
			}
		}
	
		public function getRelocation_ztm(){
			$this->db->where('status', 1); 
			$result = $this->db->get('hris_master_relokasi_sementara')->result();
			return $result;
		}
	
		public function getRelocationLocation_ztm(){
			$sql = "SELECT DISTINCT personnel_area FROM hris_master_personnel_area";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}
	
		public function getEmpPA_ztm($nik){
			$this->db->where('nik', $nik);
			$result = $this->db->get('v_hris_employee_updated')->result_array();
			return decrypt($result[0]['personnel_area']);
		}
	
		public function getEditReloc_ztm($id)
		{
			$sql = "SELECT * FROM hris_master_relokasi_sementara WHERE id='$id'";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}
		
		public function updateReloc_ztm($id, $nama, $nik, $start_date, $end_date, $pa_awal, $pa_akhir){
	
			$sql = "UPDATE hris_master_relokasi_sementara SET nik='$nik', full_name='$nama', start_date='$start_date', end_date='$end_date', pa_awal='$pa_awal', pa_akhir='$pa_akhir' WHERE id='$id'";
			$query = $this->db->query($sql);
	
			if($query){
				return true;
			}else{
				return false;
			}
	
		}
	
		public function getDeleteReloc_ztm($id)
		{
			$sqldel = "DELETE FROM hris_master_relokasi_sementara where id = '$id'";
			$querydel = $this->db->query($sqldel);
	
			if($querydel){
				return true;
			}else{
				return false;
			}
		}
	
		public function getReqReloc_ztm(){
			$this->db->select('*');
			$this->db->from('hris_request_relokasi_sementara');
			$this->db->order_by("id", "desc");
			return $this->db->get()->result();
		}
	
		public function getDeleteReqReloc_ztm($id)
		{
			$sqldel = "DELETE FROM hris_request_relokasi_sementara WHERE id = '$id'";
			$querydel = $this->db->query($sqldel);
	
			if($querydel){
				return true;
			}else{
				return false;
			}
		}
	
		public function addReloc_ztm($nama, $nik, $start_date, $end_date, $pa_awal, $pa_akhir){
			$formData = array(
				'nik' => $nik,
				'full_name' => $nama,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'pa_awal' => $pa_awal,
				'pa_akhir' => $pa_akhir,
				'status' => 0
			);
			$this->db->insert("hris_request_relokasi_sementara", $formData);
			$query = $this->db->insert_id(); 
	
			$req_no = 'HRIS_TMRS' . str_pad($query,6,"0", STR_PAD_LEFT);
	
			$formDataRequest = array(
				'request_number' => $req_no,
				'form_type' => 'TM',
				'is_status' => 1,
				'created_by' => $this->email,
				'created_at' => $this->date,
				'revised_at' => $this->date,
				'employee_id' => $this->session->userdata('employee_id'),
				'is_status_admin_hr' => 7,
				'is_status_divhead_hr' => 0
			);
			$this->db->insert("form_request", $formDataRequest);
			$queryRequest = $this->db->insert_id();
	
			$sqlUpdate = "UPDATE hris_request_relokasi_sementara SET request_id=$queryRequest, request_number='$req_no' WHERE id=$query";
			$queryUpdate = $this->db->query($sqlUpdate);
	
			$hr_user = $this->db->select('user_email, employee_id')
								 ->where('access_level', '7')
								 ->where('employee_id !=', $this->session->userdata('employee_id'))
								 ->order_by('id_user', 'ASC')
								 ->get('users')->result_array();
			$aliasHR = 'HR';
	
			foreach ($hr_user as $key) {
				$approval = array(
					'request_id' => $queryRequest,
					'approval_priority' => 1,
					'approval_employee_id' => $key['employee_id'],
					'approval_email' => $key['user_email'],
					'approval_alias' => $aliasHR,
					'approval_status' => 'In Progress',
					'approval_note' => '',
					'is_read' => 0,
					'created_at' => $this->date,
					'created_by' => $this->email
				);
				$this->db->insert('form_approval', $approval);
			}
	
			if($query){
				return true;
			}else{
				return false;
			}
		}
	
		public function getReqShiftSchedule_ztm($nik){
			$this->db->select('*');
			$this->db->from('hris_request_shift_schedule');
			$this->db->where('nik_requestor', $nik);
			$this->db->order_by("id", "desc");
			return $this->db->get()->result();
		}
	
		public function getEmpShift_ztm($nik){
			$sql = "SELECT * FROM v_hris_employee_updated WHERE (rpm='$nik' OR department_head='$nik') AND division LIKE 'V&TA%'";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}
	
		public function getDetailEmpShift_ztm($nik, $date){
			$this->db->select('*');
			$this->db->from('hris_master_time_management');
			$this->db->where('employee_id', $nik);
			$this->db->where('date LIKE', $date.'%');
			return $this->db->get()->result();
		}
	
		public function getYear_ztm(){
			$sql = "SELECT DISTINCT YEAR(date) AS year FROM hris_master_calendar ORDER BY year DESC";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}
	
		public function requestShiftPattern_ztm($file_name, $month_name, $month, $year){
			$file_name_trim = str_replace('"', '', $file_name);
			$file = "./assets/documents/documents_tm/$file_name_trim"; 
	
			if(file_exists("$file")){
				$handle= fopen("$file","r");
				$flag = true;
			
				while(($data=fgetcsv($handle,0,';'))!== FALSE){ 
					if($flag) { $flag = false; continue; }
					$nik = $data[0]; 
					// $date = date("Y-m-d",strtotime(str_replace('/','-',$data[2])));
					$date = date("Y-m-d",strtotime($data[2]));
					$dws_code = $data[3];
					
					$this->db->select("company_code");
					$this->db->from("v_hris_nik_company");
					$this->db->where("nik", $nik);
					$company_result = $this->db->get()->result_array();
					$company_code = $company_result[0]['company_code'];
	
					if (empty($company_code)){
						return 'company_not_found';
					}
	
					if ($dws_code != "DO"){
						$this->db->select("nama, schedule_in, schedule_out");
						$this->db->from("hris_master_schedule");
						$this->db->where("kode", $dws_code);
						$this->db->where("company_code", $company_code);
						$this->db->where("end_date", "9999-12-31");
						$schedule_data = $this->db->get()->result_array();
	
						if (empty($schedule_data)){
							return 'schedule_not_found';
						}
					}
				}
			} else {
				return 'no_file_exist';
			}
	
			$sql = "SELECT * FROM hris_request_shift_schedule ORDER BY id DESC LIMIT 1";
			$query = $this->db->query($sql);
			$res = $query->result_array();
	
			if (!empty($res)){
				$no = $res[0]['id'] + 1;
			} else {
				$no = 1;
			}
			
			$req_no = 'HRIS_TMSF' . str_pad($no,6,"0", STR_PAD_LEFT);
	
			$formDataRequest = array(
				'request_number' => $req_no,
				'form_type' => 'TM',
				'is_status' => 1,
				'created_by' => $this->email,
				'created_at' => $this->date,
				'revised_at' => $this->date,
				'employee_id' => $this->session->userdata('employee_id'),
				'is_status_admin_hr' => 0,
				'is_status_divhead_hr' => 8
			);
			$this->db->insert("form_request", $formDataRequest);
			$queryRequest = $this->db->insert_id();
	
			$periode = $month_name . ' ' . $year;
			$date = $year . '-' . $month;
			$nik = $this->session->userdata('employee_id');
	
			$sql = "SELECT * FROM hris_request_shift_schedule WHERE nik_requestor='$nik' AND end_date LIKE '$date%' AND (status != 2 AND status != 3) ORDER BY id DESC LIMIT 1";
			$query = $this->db->query($sql);
			$shift_res = $query->result_array();
	
			if (!empty($shift_res)){
				$flag = 1;
	
				$this->db->where('id', $queryRequest);
				$this->db->update("form_request", array('form_notes' => 'R'));
			} else {
				$flag = null;
			}
	
			$start_date = $date . '-01';
			$end_date = date("Y-m-t", strtotime($date));
	
			$formDataSchedule = array(
				'request_id' => $queryRequest,
				'request_number' => $req_no,
				'nik_requestor' => $nik,
				'periode' => $periode,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'files' => $file_name_trim,
				'status' => 0,
				'flag' => $flag
			);
			$this->db->insert("hris_request_shift_schedule", $formDataSchedule);
	
			// $sqlTop = "SELECT division_head, divhead_name, usrid_long3 
			// 		   FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$sqlTop = "SELECT rpm, rpm_name, usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4
					   FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
			$queryTop = $this->db->query($sqlTop);
			$resultTop = $queryTop->result_array();
	
			// $approval_email = $resultTop[0]['usrid_long3'];
			// $approval_id = $resultTop[0]['division_head'];
			if (!empty($resultTop[0]['usrid_long3'])){
				$approval_email = $resultTop[0]['usrid_long3'];
				$approval_id = $resultTop[0]['division_head'];
				$approval_name = $resultTop[0]['divhead_name'];			
			} else if (!empty($resultTop[0]['usrid_long4'])){
				$approval_email = $resultTop[0]['usrid_long4'];
				$approval_em = decrypt($approval_email);
				if($approval_em == 'makmur@ibsmulti.com' || $approval_em == 'MAKMUR@IBSMULTI.COM'){
					$approval_email = encrypt('sudarman@ibsmulti.com');
					$approval_id = '88029019';
					$approval_name = 'CZAIULVI';
				}else{
					$approval_email = $resultTop[0]['usrid_long4'];
					$approval_id = $resultTop[0]['director'];
					$approval_name = $resultTop[0]['director_name'];
				}
				// $approval_email = $resultTop[0]['usrid_long4'];
				// $approval_id = $resultTop[0]['director'];
				// $approval_name = $resultTop[0]['director_name'];
			}

			$alias = str_replace('@IBSMULTI.COM', '', decrypt($approval_email));
	
			$approval = array(
				'request_id' => $queryRequest,
				'approval_priority' => 1,
				'approval_email' => decrypt($approval_email),
				'approval_status' => 'In Progress',
				'created_at' => $this->date,
				'created_by' => $this->email,
				'approval_alias' => strtolower($alias),
				'is_read' => 0,
				'approval_employee_id' => decrypt($approval_id)
			);
			$approve = $this->db->insert('form_approval', $approval);
	
			$hr_user = $this->db->select('user_email, employee_id')
								 ->where('access_level', '7')
								 ->where('employee_id !=', $nik)
								 ->order_by('id_user', 'ASC')
								 ->get('users')->result_array();
	
			$aliasHR = 'HR';
	
			foreach ($hr_user as $key) {
				$approval = array(
					'request_id' => $queryRequest,
					'approval_priority' => 2,
					'approval_employee_id' => $key['employee_id'],
					'approval_email' => $key['user_email'],
					'approval_alias' => $aliasHR,
					'approval_status' => '',
					'approval_note' => '',
					'is_read' => 0,
					'created_at' => $this->date,
					'created_by' => $this->email
				);
				$this->db->insert('form_approval', $approval);
			}
	
			if ($approve){
				return true;
			} else {
				return false;
			}
		}
	
		public function getDeleteShiftReq_ztm($id)
		{
			$this->db->select('*');
			$this->db->from('hris_request_shift_schedule');
			$this->db->where('id', $id);
			$schedule_req = $this->db->get()->result_array();
			
			$request_id = $schedule_req[0]['request_id'];
	
			$sql = "UPDATE hris_request_shift_schedule SET status=3 WHERE id = '$id'";
			$query = $this->db->query($sql);
	
			$update_datetime = $this->date;
			$update_email = $this->email;
	
			$sqlDelAppr = "UPDATE form_approval SET approval_status='Canceled by User', updated_at='$update_datetime', updated_by='$update_email' 
						   WHERE request_id = '$request_id'";
			$queryDelAppr = $this->db->query($sqlDelAppr);
	
			$sqlDelReq = "UPDATE form_request SET is_status=8, deleted_by='$update_email', deleted_at='$update_datetime' WHERE id = '$request_id'";
			$queryDelReq = $this->db->query($sqlDelReq);
	
			$this->db->select('approval_email');
			$this->db->from('form_approval');
			$this->db->where('request_id', $request_id);
			$this->db->where('approval_status', 'Canceled by User');
			$resultEmail = $this->db->get()->result_array();
			$approval_email = $resultEmail[0]['approval_email'];
			
			if ($queryDelAppr){
				return true;
			} else {
				return false;
			}
		}
	
		public function newShiftPattern_ztm($id, $file_name){
			$file_name_trim = str_replace('"', '', $file_name);
			$file = "./assets/documents/documents_tm/$file_name_trim"; 
	
			if(file_exists("$file")){
				$handle= fopen("$file","r");
				$flag = true;
			
				while(($data=fgetcsv($handle,0,';'))!== FALSE){ 
					if($flag) { $flag = false; continue; }
					$nik = $data[0]; 
					$date = date("Y-m-d",strtotime(str_replace('/','-',$data[2])));
					$dws_code = $data[3];
	
					$this->db->select("company_code");
					$this->db->from("v_hris_nik_company");
					$this->db->where("nik", $nik);
					$company_result = $this->db->get()->result_array();
					$company_code = $company_result[0]['company_code'];
	
					if (empty($company_code)){
						return 'company_not_found';
					}
	
					if ($dws_code != "DO"){
						$this->db->select("nama, schedule_in, schedule_out");
						$this->db->from("hris_master_schedule");
						$this->db->where("kode", $dws_code);
						$this->db->where("company_code", $company_code);
						$this->db->where("end_date", "9999-12-31");
						$schedule_data = $this->db->get()->result_array();
	
						if (empty($schedule_data)){
							return 'schedule_not_found';
						}
					}
				}
				
				$sql = "UPDATE hris_request_shift_schedule SET files='$file_name_trim' WHERE request_id='$id'";
				$query = $this->db->query($sql);
				
				if($query){
					return true;
				}else{
					return false;
				}
	
			} else {
				return 'no_file_exist';
			}
		}
	
		public function getDwsTOCode_ztm(){
			$company_code = $this->session->userdata('company_code');
			$sql = "SELECT id, kode, nama, schedule_in, schedule_out FROM hris_master_schedule WHERE (kode LIKE 'SHF%') AND company_code = '".$company_code."'
					UNION
					SELECT id, kode, nama, NULL AS schedule_in, NULL AS schedule_out from hris_master_time_off 
					WHERE (kode ='CT' OR kode ='S') AND company_code = '".$company_code."' ORDER BY id ASC";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}

		public function getARV()
		{
			$this->db->order_by('id', 'DESC');
			$result = $this->db->get('hris_master_arv')->result();
			return $result;
		}
	
		public function save_application_versions($file_name, $versions_numbers, $operating_system, $vdd){
			$file_name = str_replace('"', '', $file_name);
			$file = "./assets/master/apps/" . $file_name;
	
			if(file_exists("$file")){
				
				$formData = array(
					'version_number' => $versions_numbers,
					'os' => $operating_system,
					'vdd' => $vdd,
					'link' => $file_name
				);
				$query = $this->db->insert("hris_master_arv", $formData);
	
				if($query){
					return true;
				}else{
					unlink('./assets/master/apps/' . $file_name);
					return false;
				}
	
			} else {
				return 'no_file_exist';
			}
		}
	
		public function delete_application_versions($id, $file_name)
		{
			$sql = "UPDATE hris_master_arv SET status = 0 WHERE id = '".$id."'";
			$query = $this->db->query($sql);
			if($query){
				// unlink('./assets/master/apps/' . $file_name);
				return true;
			}else{
				return false;
			}
			
			// $sql = "DELETE FROM hris_master_arv where id = '".$id."'";
			// $query = $this->db->query($sql);
			// if($query){
			// 	unlink('./assets/master/apps/' . $file_name);
			// 	return true;
			// }else{
			// 	return false;
			// }
		}

		///////////////Start Luffi 2024/////////////
		public function get_show_user($id_user){
			$sql = "SELECT * FROM users WHERE id_user = '$id_user'";
			$query = $this->db->query($sql);
			$res = $query->result();
			return $res;
		}

		public function get_show_user_by_nik($nik){
			$sql 	= "SELECT * FROM users WHERE employee_id = '$nik' ORDER BY id_user DESC LIMIT 1";
			$query	= $this->db->query($sql);
			$res 	= $query->result_array();
			return $res;
		}
		
		public function save_password_user($id_user, $confirm_reset_password){

			$password = encrypt($confirm_reset_password);
			$sql = "UPDATE users SET password = '$password' WHERE id_user = '$id_user'";
			$query = $this->db->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function delete_user($id)
		{
			$sql = "DELETE FROM users where id_user = '".$id."'";
			$query = $this->db->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}
		/////////////End Luffi 2024///////////////
		
		///////////////////////////////////// END TIME MANAGEMENT 2024 ///////////////////////////////

		public function getINFO()
		{
			$this->db->where('status !=', 0);
			$this->db->order_by('id', 'DESC');
			$result = $this->db->get('information')->result();
			return $result;
		}
		
	///////////////////////////////START Penambahan Action couple Luffi 2025 //////////////////////////////
	public function edit_couple($id)
	{
		$sql = "SELECT * FROM hris_couple_employee where id = '".$id."'";
		$query = $this->db->query($sql);
		if($query){
			$res = $query->result()[0];
			$data = array(
				'male_nik' => $res->male_nik,
				'male_employee' => decrypt($res->male_employee),
				'female_nik' => $res->female_nik,
				'female_employee' => decrypt($res->female_employee),
				'start_date' => $res->start_date,
				'end_date' => $res->end_date,
			);
			return $data;
		}else{
			return false;
		}
	}

	public function edit_couple_employee($id, $start_date_couple, $end_date_couple){

		$sql = "UPDATE hris_couple_employee SET start_date = '$start_date_couple', end_date = '$end_date_couple' WHERE id = '$id'";
		$query = $this->db->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}

	}
	///////////////////////////////END Penambahan Action couple Luffi 2025 //////////////////////////////

	public function view_req_mdcr_on_tm($nik, $no_req) {

		$sql = "SELECT 
					fr.id, 
					fr.request_number,
					fr.is_status
				FROM hris_request_time_off hrto
				INNER JOIN hris_medical_reimbursment_item hmri
					ON hmri.employee_id = hrto.nik
					AND hmri.keterangan = 'Diri Sendiri'
					AND hmri.tanggal_kuitansi BETWEEN DATE_SUB(hrto.start_date, INTERVAL 1 DAY) AND hrto.end_date
				INNER JOIN form_request fr ON fr.id = hmri.request_id
				WHERE hrto.request_number = '$no_req'
				AND hrto.nik = '$nik'
				GROUP BY fr.id;";
		$query  = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}

	}

	public function test_balance($tahun, $nik="", $bulan=""){

		$today 	= $this->today;

		$sql 	= "SELECT * FROM v_hris_employee_updated WHERE nik LIKE '%$nik%' AND nik not like '00000%'";
		$query 	= $this->db->query($sql);
		if($query){
			$res = $query->result_array();
				$data = array();
				foreach ($res as $key) {
					$nik_emp					= $key['nik'];
					
							$sql_eg = "SELECT 	
											employee_group as employee_group,
											start_date as start_date,
											reason_of_action as reason_of_action
										FROM		
											hris_employee
										WHERE nik = '$nik_emp' ORDER BY id_employee DESC LIMIT 2";
										
							$query_eg 				= $this->db->query($sql_eg);
							$res_eg					= $query_eg->result();
							$res_eg					= $this->my_array_unique($res_eg);
							$res_eg_new 			= decrypt($res_eg[0]->employee_group);
							$res_sd_new 			= decrypt($res_eg[0]->start_date);
							$reason_of_action		= decrypt($res_eg[0]->reason_of_action);
							$res_eg_old 			= (!empty(($res_eg[1]->employee_group))) ? decrypt(($res_eg[1]->employee_group)) : '';
							

							$sql2new = "SELECT 	
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_jalan
										WHERE grade = '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
							$query2new 				= $this->db->query($sql2new);
							$res2new 				= $query2new->result();
							$pagu_jalan_tahun_new 	= (!empty(($res2new[0]->pagu_tahun))) ? ($res2new[0]->pagu_tahun) : 0;

							$sql3new = "SELECT 	
											pagu_kamar_hari as pagu_kamar_hari,
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_inap
										WHERE grade LIKE '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
							$query3new 				= $this->db->query($sql3new);
							$res3new 				= $query3new->result();
							$pagu_inap_tahun_new 	= (!empty(($res3new[0]->pagu_tahun))) ? ($res3new[0]->pagu_tahun) : 0;
							$pagu_inap_kamar_new 	= (!empty(($res3new[0]->pagu_kamar_hari))) ? ($res3new[0]->pagu_kamar_hari) : 0;

							$sql4new = "SELECT 	
											pagu_one_focus_tahun as pagu_one_focus_tahun,
											pagu_two_focus_tahun as pagu_two_focus_tahun,
											pagu_frame_dua_tahun as pagu_frame_dua_tahun
										FROM		
											hris_medical_pagu_kacamata
										WHERE grade = '$res_eg_new' AND start_date <= '$today' AND end_date > '$today'";
							$query4new = $this->db->query($sql4new);
							$res4new 	= $query4new->result();
							$pagu_one_focus_tahun 	= $res4new[0]->pagu_one_focus_tahun;
							$pagu_two_focus_tahun 	= $res4new[0]->pagu_two_focus_tahun;
							$pagu_frame_dua_tahun 	= $res4new[0]->pagu_frame_dua_tahun;


							$sql2old = "SELECT 	
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_jalan
										WHERE grade = '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
							$query2old 				= $this->db->query($sql2old);
							$res2old 				= $query2old->result();
							$pagu_jalan_tahun_old 	= (!empty(($res2old[0]->pagu_tahun))) ? ($res2old[0]->pagu_tahun) : 0;

							$sql3old = "SELECT 	
											pagu_kamar_hari as pagu_kamar_hari,
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_inap
										WHERE grade LIKE '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
							$query3old 				= $this->db->query($sql3old);
							$res3old 				= $query3old->result();
							$pagu_inap_tahun_old 	= (!empty(($res3old[0]->pagu_tahun))) ? ($res3old[0]->pagu_tahun) : 0;
							$pagu_inap_kamar_old 	= (!empty(($res3old[0]->pagu_kamar_hari))) ? ($res3old[0]->pagu_kamar_hari) : 0;

							$start_date 			= DateTime::createFromFormat('Ymd', $res_sd_new);
							$start_month			= $start_date->format('m');
							$bulan 					= (!empty(($bulan))) ? ($bulan) : 12;
							// dumper($start_month);
							$start_date 			= $start_date->format('Y');
							$year 					= $tahun;



							if( ($start_date == $year) && ($bulan >= $start_month ) && (!empty($res_eg_old)) && ($reason_of_action == 'Promosi') ){
								
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

								if(($year == $start_date) && ($bulan < $start_month)){

									$pagu_jalan_tahun	= $pagu_jalan_tahun_old;
									$pagu_inap_tahun	= $pagu_inap_tahun_old;
									$pagu_inap_kamar 	= $pagu_inap_kamar_old;

								}else{
									
									$pagu_jalan_tahun	= $pagu_jalan_tahun_new;
									$pagu_inap_tahun	= $pagu_inap_tahun_new;
									$pagu_inap_kamar 	= $pagu_inap_kamar_new;

								}


							}


							$sql_jalan = "SELECT 
											SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_jalan,
											SUM(a.penggantian) as total_penggantian_rawat_jalan
										FROM		
											hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE b.is_status = '3' AND a.employee_id LIKE '$nik_emp' AND a.tor_grandparent = '1' AND a.create_date LIKE '$tahun%'";
							$query_jalan 						= $this->db->query($sql_jalan);
							$res_jalan 							= $query_jalan->result();
							$total_nominal_kuitansi_rawat_jalan = (!empty(($res_jalan[0]->total_nominal_kuitansi_rawat_jalan))) ? (($res_jalan[0]->total_nominal_kuitansi_rawat_jalan)) : 0;
							$total_penggantian_rawat_jalan 		= (!empty(($res_jalan[0]->total_penggantian_rawat_jalan))) ? (($res_jalan[0]->total_penggantian_rawat_jalan)) : 0;

							$sql_inap = "SELECT 
											SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_rawat_inap,
											SUM(a.penggantian) as total_penggantian_rawat_inap
										FROM		
											hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE b.is_status = '3' AND a.employee_id LIKE '$nik_emp' AND a.tor_grandparent = '2' AND a.create_date LIKE '$tahun%'";
							$query_inap 						= $this->db->query($sql_inap);
							$res_inap 							= $query_inap->result();
							$total_nominal_kuitansi_rawat_inap 	= (!empty(($res_inap[0]->total_nominal_kuitansi_rawat_inap))) ? (($res_inap[0]->total_nominal_kuitansi_rawat_inap)) : 0;
							$total_penggantian_rawat_inap 		= (!empty(($res_inap[0]->total_penggantian_rawat_inap))) ? (($res_inap[0]->total_penggantian_rawat_inap)) : 0;


							$sql_optic = "SELECT 
											SUM(a.total_nominal_kuitansi) as total_nominal_kuitansi_kacamata,
											SUM(a.penggantian) as total_penggantian_kacamata
										FROM		
											hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE b.is_status = '3' AND a.employee_id LIKE '$nik_emp' AND a.tor_grandparent = '3' AND a.create_date LIKE '$tahun%'";
							$query_optic 						= $this->db->query($sql_optic);
							$res_optic 							= $query_optic->result();
							$total_nominal_kuitansi_kacamata 	= (!empty(($res_optic[0]->total_nominal_kuitansi_kacamata))) ? (($res_optic[0]->total_nominal_kuitansi_kacamata)) : 0;
							$total_penggantian_kacamata 		= (!empty(($res_optic[0]->total_penggantian_kacamata))) ? (($res_optic[0]->total_penggantian_kacamata)) : 0;
							$pagu_optic_tahun = ($pagu_one_focus_tahun + $pagu_two_focus_tahun + $pagu_frame_dua_tahun);


					$row['nik'] 							= $nik_emp;
					$row['name'] 							= decrypt($key['complete_name']);
					$row['cost_center'] 					= decrypt($key['cost_center']);
					$row['outpatient_plafon'] 				= $pagu_jalan_tahun;
					$row['outpatient_claimed'] 	= $total_penggantian_rawat_jalan;
					$row['outpatient_balance'] 			= ($pagu_jalan_tahun - $total_penggantian_rawat_jalan);
					$row['inpatient_plafon'] 				= $pagu_inap_tahun;
					$row['inpatient_claimed'] 	= $total_penggantian_rawat_inap;
					$row['inpatient_balance'] 			= ( $pagu_inap_tahun - $total_penggantian_rawat_inap);
					$row['optic_plafon'] 				= $pagu_optic_tahun;
					$row['optic_claimed'] 		= $total_penggantian_kacamata;					
					$row['optic_balance'] 			= ( $pagu_optic_tahun - $total_penggantian_kacamata);					
					$row['tahun'] 			= $year;					

					$data[] = $row;
					//$data[] = (object)$row;
				}
			return $data;
		}else{
			return false;
		}
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

	public function getMDCRBalanceServerSide($year, $start = 0, $length = 10, $search = '', $order = '', $column = '', $nik='', $month='')
	{

		// Kolom default untuk sorting
		$orderColumn = 'id';
		$orderDir = 'ASC';

		if (!empty($order)) {
			$orderColumn = $column[$order[0]['column']]['data'];
			$orderDir = $order[0]['dir'];
		}

		// Query utama
		$this->db->select('f.*, e.complete_name');
		$this->db->from('form_request f');
		$this->db->join('v_hris_employee_updated e', 'f.employee_id = e.nik', 'left');
		$this->db->where('f.is_status', '4');
		$this->db->where('f.form_type', 'MDCR');

		// Jika ada pencarian
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('f.request_number', $search);
			$this->db->or_like('f.employee_id', $search);
			$this->db->or_like('e.complete_name', encrypt($search));
			$this->db->group_end();
		}

		$this->db->group_by('f.id');
    	$this->db->order_by('f.id', 'DESC');

		// Hitung total data sebelum limit
		$totalFiltered = $this->db->count_all_results('', false);

		// Tambahkan limit & order
		$this->db->order_by($orderColumn, $orderDir);
		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		// Eksekusi query
		$query = $this->db->get();
		$data = $query->result_array();

		// Hitung total semua data (tanpa filter)
		$this->db->from('form_request');
		$this->db->where('is_status', '4');
		$this->db->where('form_type', 'MDCR');
		$totalData = $this->db->count_all_results();

		// Format output untuk DataTables
		$result = array(
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $data
		);

		return $result;
	}



	public function get_balance_mdcr($year, $start = 0, $length = 10, $search = '', $order = '', $column = '', $nik='', $month=''){
		$month 			= (!empty($month) && $month != 'All') ? $month : 12;
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
		$this->db->not_like('nik', 'SPN', 'after');

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
							'cost_center'   => decrypt($key['cost_center']),
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
							$nik_emp						= $key['nik'];

							$sql_eg = "SELECT 	
											employee_group as employee_group,
											start_date as start_date,
											reason_of_action as reason_of_action
										FROM		
											hris_employee
										WHERE nik = '$nik_emp' ORDER BY id_employee DESC";
										
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
										'reason_of_action'   		=> $idx['reason_of_action']
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
											'reason_of_action'   => $data_before['reason_of_action']
										];
									}
								}elseif(($year == $year_eg_sd)){
									$data_eg[] = [
										'employee_group'           	=> $idx['employee_group'],
										'start_date' 				=> $idx['start_date'],
										'reason_of_action'   		=> $idx['reason_of_action']
									];
								}elseif(($year < $year_eg_sd)){
									$data_eg[] = [
										'employee_group'           	=> $idx['employee_group'],
										'start_date' 				=> $idx['start_date'],
										'reason_of_action'   		=> $idx['reason_of_action']
									];
								}elseif(($year > $year_eg_sd)){
									$data_eg[] = [
										'employee_group'           	=> $idx['employee_group'],
										'start_date' 				=> $idx['start_date'],
										'reason_of_action'   		=> $idx['reason_of_action']
									];
								}
							}

							
							$res_eg_new 			= decrypt($data_eg[0]['employee_group']);
							$res_sd_new 			= decrypt($data_eg[0]['start_date']);
							$reason_of_action		= decrypt($data_eg[0]['reason_of_action']);
							$res_eg_old 			= (!empty(($data_eg[1]['employee_group']))) ? decrypt(($data_eg[1]['employee_group'])) : '';
							

							$sql2new = "SELECT 	
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_jalan
										WHERE grade = '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
							$query2new 				= $this->db->query($sql2new);
							$res2new 				= $query2new->result();
							$pagu_jalan_tahun_new 	= (!empty(($res2new[0]->pagu_tahun))) ? ($res2new[0]->pagu_tahun) : 0;

							$sql3new = "SELECT 	
											pagu_kamar_hari as pagu_kamar_hari,
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_inap
										WHERE grade LIKE '$res_eg_new'  AND start_date <= '$today' AND end_date > '$today'";
							$query3new 				= $this->db->query($sql3new);
							$res3new 				= $query3new->result();
							$pagu_inap_tahun_new 	= (!empty(($res3new[0]->pagu_tahun))) ? ($res3new[0]->pagu_tahun) : 0;
							$pagu_inap_kamar_new 	= (!empty(($res3new[0]->pagu_kamar_hari))) ? ($res3new[0]->pagu_kamar_hari) : 0;

							$sql4new = "SELECT 	
											pagu_one_focus_tahun as pagu_one_focus_tahun,
											pagu_two_focus_tahun as pagu_two_focus_tahun,
											pagu_frame_dua_tahun as pagu_frame_dua_tahun
										FROM		
											hris_medical_pagu_kacamata
										WHERE grade = '$res_eg_new' AND start_date <= '$today' AND end_date > '$today'";
							$query4new = $this->db->query($sql4new);
							$res4new 	= $query4new->result();
							$pagu_one_focus_tahun 	= $res4new[0]->pagu_one_focus_tahun;
							$pagu_two_focus_tahun 	= $res4new[0]->pagu_two_focus_tahun;
							$pagu_frame_dua_tahun 	= $res4new[0]->pagu_frame_dua_tahun;


							$sql2old = "SELECT 	
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_jalan
										WHERE grade = '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
							$query2old 				= $this->db->query($sql2old);
							$res2old 				= $query2old->result();
							$pagu_jalan_tahun_old 	= (!empty(($res2old[0]->pagu_tahun))) ? ($res2old[0]->pagu_tahun) : 0;

							$sql3old = "SELECT 	
											pagu_kamar_hari as pagu_kamar_hari,
											pagu_tahun as pagu_tahun
										FROM		
											hris_medical_pagu_rawat_inap
										WHERE grade LIKE '$res_eg_old' AND start_date <= '$today' AND end_date > '$today'";
							$query3old 				= $this->db->query($sql3old);
							$res3old 				= $query3old->result();
							$pagu_inap_tahun_old 	= (!empty(($res3old[0]->pagu_tahun))) ? ($res3old[0]->pagu_tahun) : 0;
							$pagu_inap_kamar_old 	= (!empty(($res3old[0]->pagu_kamar_hari))) ? ($res3old[0]->pagu_kamar_hari) : 0;

							$start_date 			= DateTime::createFromFormat('Ymd', $res_sd_new);
							$start_month			= $start_date->format('m');
							$bulan 					= (!empty($month) && $month != 'All') ? $month : 12;
							$start_date 			= $start_date->format('Y');



							if( ($start_date == $year) && ($bulan >= $start_month ) && (!empty($res_eg_old)) && ($reason_of_action == 'Promosi') ){
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

								if(($year == $start_date) && ($bulan < $start_month) || ($year < $start_date)){
									$pagu_jalan_tahun	= $pagu_jalan_tahun_old;
									$pagu_inap_tahun	= $pagu_inap_tahun_old;
									$pagu_inap_kamar 	= $pagu_inap_kamar_old;

								}else{
									$pagu_jalan_tahun	= $pagu_jalan_tahun_new;
									$pagu_inap_tahun	= $pagu_inap_tahun_new;
									$pagu_inap_kamar 	= $pagu_inap_kamar_new;

								}


							}

							if (!empty($month)) {
							// $sql_jalan = "SELECT 
							// 				SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_jalan,
							// 				SUM(a.penggantian) AS total_penggantian_rawat_jalan
							// 			FROM hris_medical_reimbursment_item a
							// 			JOIN (
							// 				SELECT request_id, MIN(create_at) AS create_at
							// 				FROM form_logs
							// 				WHERE activity_desc = 'Approved_by_HRGA_Divhead' AND type = 'MDCR'
							// 				GROUP BY request_id
							// 			) fl ON a.request_id = fl.request_id
							// 			WHERE 
							// 				a.employee_id LIKE '$nik_emp'
							// 				AND a.tor_grandparent = '1'
							// 				AND fl.create_at BETWEEN 
							// 					CONCAT('$year','-','01','-01')
							// 					AND LAST_DAY(CONCAT('$year','-','$month','-01'))";
							$sql_jalan = "SELECT 
											SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_jalan,
											SUM(a.penggantian) AS total_penggantian_rawat_jalan
										FROM hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE 
						 					b.is_status_progress >= 2
											AND a.employee_id LIKE '$nik_emp'
											AND a.tor_grandparent = '1'
											AND a.tanggal_kuitansi BETWEEN 
												CONCAT('$year','-','01','-01')
												AND LAST_DAY(CONCAT('$year','-','$month','-01'))";
							}else{
							// $sql_jalan = "SELECT 
							// 				SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_jalan,
							// 				SUM(a.penggantian) AS total_penggantian_rawat_jalan
							// 			FROM hris_medical_reimbursment_item a
							// 			JOIN (
							// 				SELECT request_id, MIN(create_at) AS create_at
							// 				FROM form_logs
							// 				WHERE activity_desc = 'Approved_by_HRGA_Divhead' AND type = 'MDCR'
							// 				GROUP BY request_id
							// 			) fl ON a.request_id = fl.request_id
							// 			WHERE 
							// 				a.employee_id LIKE '$nik_emp'
							// 				AND a.tor_grandparent = '1'
							// 				AND fl.create_at BETWEEN '$year-01-01' AND '$year-12-31'";
							$sql_jalan = "SELECT 
											SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_jalan,
											SUM(a.penggantian) AS total_penggantian_rawat_jalan
										FROM hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE 
						 					b.is_status_progress >= 2
											AND a.employee_id LIKE '$nik_emp'
											AND a.tor_grandparent = '1'
											AND a.tanggal_kuitansi BETWEEN '$year-01-01' AND '$year-12-31'";							

							}
							$query_jalan 						= $this->db->query($sql_jalan);
							$res_jalan 							= $query_jalan->result();
							$total_nominal_kuitansi_rawat_jalan = (!empty(($res_jalan[0]->total_nominal_kuitansi_rawat_jalan))) ? (($res_jalan[0]->total_nominal_kuitansi_rawat_jalan)) : 0;
							$total_penggantian_rawat_jalan 		= (!empty(($res_jalan[0]->total_penggantian_rawat_jalan))) ? (($res_jalan[0]->total_penggantian_rawat_jalan)) : 0;

							if (!empty($month)) {
							// $sql_inap = "SELECT 
							// 				SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_inap,
							// 				SUM(a.penggantian) AS total_penggantian_rawat_inap
							// 			FROM hris_medical_reimbursment_item a
							// 			JOIN (
							// 				SELECT request_id, MIN(create_at) AS create_at
							// 				FROM form_logs
							// 				WHERE activity_desc = 'Approved_by_HRGA_Divhead' AND type = 'MDCR'
							// 				GROUP BY request_id
							// 			) fl ON a.request_id = fl.request_id
							// 			WHERE 
							// 				a.employee_id LIKE '$nik_emp'
							// 				AND a.tor_grandparent = '2'
							// 				AND fl.create_at BETWEEN 
							// 					CONCAT('$year','-','01','-01')
							// 					AND LAST_DAY(CONCAT('$year','-','$month','-01'))";
							$sql_inap = "SELECT 
											SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_inap,
											SUM(a.penggantian) AS total_penggantian_rawat_inap
										FROM hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE 
						 					b.is_status_progress >= 2
											AND a.employee_id LIKE '$nik_emp'
											AND a.tor_grandparent = '2'
											AND a.tanggal_kuitansi BETWEEN 
												CONCAT('$year','-','01','-01')
												AND LAST_DAY(CONCAT('$year','-','$month','-01'))";							

							}else{
							// $sql_inap = "SELECT 
							// 				SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_inap,
							// 				SUM(a.penggantian) AS total_penggantian_rawat_inap
							// 			FROM hris_medical_reimbursment_item a
							// 			JOIN (
							// 				SELECT request_id, MIN(create_at) AS create_at
							// 				FROM form_logs
							// 				WHERE activity_desc = 'Approved_by_HRGA_Divhead' AND type = 'MDCR'
							// 				GROUP BY request_id
							// 			) fl ON a.request_id = fl.request_id
							// 			WHERE 
							// 				a.employee_id LIKE '$nik_emp'
							// 				AND a.tor_grandparent = '2'
							// 				AND fl.create_at BETWEEN '$year-01-01' AND '$year-12-31'";
							$sql_inap = "SELECT 
											SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_rawat_inap,
											SUM(a.penggantian) AS total_penggantian_rawat_inap
										FROM hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE 
						 					b.is_status_progress >= 2
											AND a.employee_id LIKE '$nik_emp'
											AND a.tor_grandparent = '2'
											AND a.tanggal_kuitansi BETWEEN '$year-01-01' AND '$year-12-31'";							
							}
							$query_inap 						= $this->db->query($sql_inap);
							$res_inap 							= $query_inap->result();
							$total_nominal_kuitansi_rawat_inap 	= (!empty(($res_inap[0]->total_nominal_kuitansi_rawat_inap))) ? (($res_inap[0]->total_nominal_kuitansi_rawat_inap)) : 0;
							$total_penggantian_rawat_inap 		= (!empty(($res_inap[0]->total_penggantian_rawat_inap))) ? (($res_inap[0]->total_penggantian_rawat_inap)) : 0;

							if (!empty($month)) {
							// $sql_optic = "SELECT 
							// 				SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_kacamata,
							// 				SUM(a.penggantian) AS total_penggantian_kacamata
							// 			FROM hris_medical_reimbursment_item a
							// 			JOIN (
							// 				SELECT request_id, MIN(create_at) AS create_at
							// 				FROM form_logs
							// 				WHERE activity_desc = 'Approved_by_HRGA_Divhead' AND type = 'MDCR'
							// 				GROUP BY request_id
							// 			) fl ON a.request_id = fl.request_id
							// 			WHERE 
							// 				a.employee_id LIKE '$nik_emp'
							// 				AND a.tor_grandparent = '3'
							// 				AND fl.create_at BETWEEN 
							// 					CONCAT('$year','-','01','-01')
							// 					AND LAST_DAY(CONCAT('$year','-','$month','-01'))";
							$sql_optic = "SELECT 
											SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_kacamata,
											SUM(a.penggantian) AS total_penggantian_kacamata
										FROM hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE 
						 					b.is_status_progress >= 2
											AND a.employee_id LIKE '$nik_emp'
											AND a.tor_grandparent = '3'
											AND a.tanggal_kuitansi BETWEEN 
												CONCAT('$year','-','01','-01')
												AND LAST_DAY(CONCAT('$year','-','$month','-01'))";							
							}else{
							// $sql_optic = "SELECT 
							// 				SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_kacamata,
							// 				SUM(a.penggantian) AS total_penggantian_kacamata
							// 			FROM hris_medical_reimbursment_item a
							// 			JOIN (
							// 				SELECT request_id, MIN(create_at) AS create_at
							// 				FROM form_logs
							// 				WHERE activity_desc = 'Approved_by_HRGA_Divhead' AND type = 'MDCR'
							// 				GROUP BY request_id
							// 			) fl ON a.request_id = fl.request_id
							// 			WHERE 
							// 				a.employee_id LIKE '$nik_emp'
							// 				AND a.tor_grandparent = '3'
							// 				AND fl.create_at BETWEEN '$year-01-01' AND '$year-12-31'";
							$sql_optic = "SELECT 
											SUM(a.total_nominal_kuitansi) AS total_nominal_kuitansi_kacamata,
											SUM(a.penggantian) AS total_penggantian_kacamata
										FROM hris_medical_reimbursment_item a
										LEFT JOIN form_request b ON a.request_id = b.id
										WHERE 
						 					b.is_status_progress >= 2
											AND a.employee_id LIKE '$nik_emp'
											AND a.tor_grandparent = '3'
											AND a.tanggal_kuitansi BETWEEN '$year-01-01' AND '$year-12-31'";							
							}
							$query_optic 						= $this->db->query($sql_optic);
							$res_optic 							= $query_optic->result();
							$total_nominal_kuitansi_kacamata 	= (!empty(($res_optic[0]->total_nominal_kuitansi_kacamata))) ? (($res_optic[0]->total_nominal_kuitansi_kacamata)) : 0;
							$total_penggantian_kacamata 		= (!empty(($res_optic[0]->total_penggantian_kacamata))) ? (($res_optic[0]->total_penggantian_kacamata)) : 0;
							$pagu_optic_tahun = ($pagu_one_focus_tahun + $pagu_two_focus_tahun + $pagu_frame_dua_tahun);
					

					$row['nik'] 							= $nik_emp;
					$row['name'] 							= $key['complete_name'];
					$row['cost_center'] 					= $key['cost_center'];
					$row['outpatient_plafon'] 				= $pagu_jalan_tahun;
					$row['outpatient_claimed'] 				= $total_penggantian_rawat_jalan;
					$row['outpatient_balance'] 				= ($pagu_jalan_tahun - $total_penggantian_rawat_jalan);
					$row['inpatient_plafon'] 				= $pagu_inap_tahun;
					$row['inpatient_claimed'] 				= $total_penggantian_rawat_inap;
					$row['inpatient_balance'] 				= ( $pagu_inap_tahun - $total_penggantian_rawat_inap);
					$row['optic_plafon'] 					= $pagu_optic_tahun;
					$row['optic_claimed'] 					= $total_penggantian_kacamata;					
					$row['optic_balance'] 					= ( $pagu_optic_tahun - $total_penggantian_kacamata);					
					$row['action'] 							= $key['action'];;					
					$row['month'] 							= (!empty(($month))) ? (($month)) : 'ALL';					
					$row['year'] 							= $year;					

					$data_hasil[] = $row;
					//$data[] = (object)$row;
				}
			// $data_hasil;
		}else{
			$data_hasil = array();
		}

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
		$this->db->not_like('nik', 'SPN', 'after');

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
							'cost_center'   => decrypt($key['cost_center']),
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

	public function getEmployeeToBalance(){
		
		$sql = "SELECT nik, complete_name FROM v_hris_employee_updated WHERE division !='".encrypt('HR SUPPORT')."' GROUP BY nik, complete_name";
		$query  = $this->db->query($sql);

		$output = '<option value="">All Employee</option>';
		foreach($query->result() as $row)
		{
			$complete_name = str_replace("||","'", decrypt($row->complete_name));
			$output .= '<option value="'.$row->nik.'">'.$row->nik." - ".$complete_name.'</option>';
		}
		return $output;
	}

	public function get_detail_balance_mdcr($year, $start = 0, $length = 10, $search = '', $order = '', $column = '', $nik = '', $month = '') {

		/* =========================
		ORDERING
		========================== */
		$orderColumn = 'g.nik';
		$orderDir    = 'ASC';

		if (!empty($order)) {
			$orderColumn = $column[$order[0]['column']]['data'];
			$orderDir    = $order[0]['dir'];
		}

		/* =========================
		BASE QUERY
		========================== */
		$this->db->from('hris_medical_reimbursment_item a');
		$this->db->join('form_request e', 'e.id = a.request_id');

		/* === APPROVED DIVHEAD HR (FILTER UTAMA, 1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MAX(create_at) AS approved_divhead_hr_at
			FROM form_logs
			WHERE activity_desc = 'Approved_by_HRGA_Divhead'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_approve",
			'fl_approve.request_id = a.request_id'
		);

		/* === SUBMITED BY USER (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS submitted_by_user_at
			FROM form_logs
			WHERE activity_desc = 'Submitted_by_User'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_su",
			'fl_su.request_id = a.request_id',
			'left'
		);

		/* === CHECKED BY HR (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS checked_by_hr_at
			FROM form_logs
			WHERE activity_desc = 'Checked_by_HR'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_ch",
			'fl_ch.request_id = a.request_id',
			'left'
		);

		/* === GROUPED BY HR (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS grouped_by_hr_at
			FROM form_logs
			WHERE activity_desc = 'Grouped_by_HR'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_gh",
			'fl_gh.request_id = a.request_id',
			'left'
		);

		/* === SENT TO AP BY HR (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS sent_ap_by_hr_at
			FROM form_logs
			WHERE activity_desc = 'Sent_to_AP'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_ap",
			'fl_ap.request_id = a.request_id',
			'left'
		);

		/* === FULLY PAID (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS fully_paid_at
			FROM form_logs
			WHERE activity_desc = 'Approved_by_treasury'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_fp",
			'fl_fp.request_id = a.request_id',
			'left'
		);

		$this->db->join('hris_medical_type_of_reimbursment_grandparent b', 'b.id = a.tor_grandparent', 'left');
		$this->db->join('hris_medical_type_of_reimbursment_parent c', 'c.id = a.tor_parent', 'left');
		$this->db->join('hris_medical_type_of_reimbursment_child d', 'd.id = a.tor_child', 'left');
		$this->db->join('hris_medical_reimbursment f', 'f.request_id = e.id', 'left');
		$this->db->join('v_hris_employee_updated g', 'g.nik = e.employee_id', 'left');


		/* =========================
		FILTER
		========================== */
		if (!empty($nik)) {
			$this->db->like('e.employee_id', $nik);
		}

		$this->db->not_like('e.employee_id', '00000', 'after');
		$this->db->not_like('e.employee_id', 'SPN', 'after');
		$this->db->where('e.form_type', 'MDCR');
		$this->db->where('e.is_status_progress >=', 2);

		// /* =========================
		// DATE FILTER (APPROVAL DATE)
		// ========================== */
		// if (!empty($year) && empty($month)) {

		// 	$this->db->where('fl_approve.approved_divhead_hr_at >=', "$year-01-01 00:00:00");
		// 	$this->db->where('fl_approve.approved_divhead_hr_at <',  ($year + 1) . "-01-01 00:00:00");

		// } elseif (!empty($year) && !empty($month)) {

		// 	$this->db->where('fl_approve.approved_divhead_hr_at >=', "$year-01-01 00:00:00");
		// 	$this->db->where(
		// 		'fl_approve.approved_divhead_hr_at <',
		// 		date('Y-m-d 00:00:00', strtotime("+1 month", strtotime("$year-$month-01")))
		// 	);
		// }

		/* =========================
        DATE FILTER (APPROVAL DATE)
        ========================== */
		if (!empty($year) && (empty($month) || $month == 'All')) {

			// Filter 1 tahun
			$this->db->where('fl_approve.approved_divhead_hr_at >=', "$year-01-01 00:00:00");
			$this->db->where('fl_approve.approved_divhead_hr_at <',  ($year + 1) . "-01-01 00:00:00");

		} elseif (!empty($year) && !empty($month)) {

				// Filter hanya bulan yang dipilih
				$start_date = "$year-$month-01 00:00:00";
				$end_date = date('Y-m-d 00:00:00', strtotime("+1 month", strtotime($start_date)));

				$this->db->where('fl_approve.approved_divhead_hr_at >=', $start_date);
				$this->db->where('fl_approve.approved_divhead_hr_at <', $end_date);
			
		}		

		/* =========================
		COUNT FILTERED
		========================== */
		$totalFiltered = $this->db->count_all_results('', false); // reuse query

		/* =========================
		SELECT DATA
		========================== */
		$this->db->select("
			a.id,
			a.request_id,
			e.is_status,
			b.grandparent AS tor_grandparent,
			c.parent AS tor_parent,
			d.child AS tor_child,
			a.jumlah_kuitansi,
			a.total_nominal_kuitansi AS total_kuitansi,
			a.penggantian,
			a.keterangan,
			a.additional,
			a.docter,
			a.diagnosa,
			a.tanggal_kuitansi,
			a.create_date,
			f.id_hr_emp,
			e.request_number,
			e.no_req_mdcr,
			g.nik AS employee_id,
			g.complete_name,
			g.cost_center,
			fl_approve.approved_divhead_hr_at AS approved_divhead_hr_at,
    		fl_su.submitted_by_user_at AS submitted_user_at,
    		fl_ch.checked_by_hr_at AS checked_by_hr_at,
    		fl_gh.grouped_by_hr_at AS grouped_by_hr_at,
    		fl_ap.sent_ap_by_hr_at AS sent_to_ap_at,
    		fl_fp.fully_paid_at AS fully_paid_at
		");

		$this->db->order_by($orderColumn, $orderDir);

		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		$data = $this->db->get()->result_array();

		/* =========================
		TOTAL DATA (WITHOUT FILTER)
		========================== */

		/* =========================
		BASE QUERY ALL DATA
		========================== */
		$this->db->from('hris_medical_reimbursment_item a');
		$this->db->join('form_request e', 'e.id = a.request_id');

		/* === APPROVED DIVHEAD HR (FILTER UTAMA, 1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MAX(create_at) AS approved_divhead_hr_at
			FROM form_logs
			WHERE activity_desc = 'Approved_by_HRGA_Divhead'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_approve",
			'fl_approve.request_id = a.request_id'
		);

		/* === SUBMITED BY USER (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS submitted_by_user_at
			FROM form_logs
			WHERE activity_desc = 'Submitted_by_User'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_su",
			'fl_su.request_id = a.request_id',
			'left'
		);

		/* === CHECKED BY HR (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS checked_by_hr_at
			FROM form_logs
			WHERE activity_desc = 'Checked_by_HR'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_ch",
			'fl_ch.request_id = a.request_id',
			'left'
		);

		/* === GROUPED BY HR (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS grouped_by_hr_at
			FROM form_logs
			WHERE activity_desc = 'Grouped_by_HR'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_gh",
			'fl_gh.request_id = a.request_id',
			'left'
		);

		/* === SENT TO AP BY HR (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS sent_ap_by_hr_at
			FROM form_logs
			WHERE activity_desc = 'Sent_to_AP'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_ap",
			'fl_ap.request_id = a.request_id',
			'left'
		);

		/* === FULLY PAID (1 ROW) === */
		$this->db->join(
			"(SELECT 
				request_id,
				MIN(create_at) AS fully_paid_at
			FROM form_logs
			WHERE activity_desc = 'Approved_by_treasury'
				AND type = 'MDCR'
			GROUP BY request_id
			) fl_fp",
			'fl_fp.request_id = a.request_id',
			'left'
		);

		$this->db->join('hris_medical_type_of_reimbursment_grandparent b', 'b.id = a.tor_grandparent', 'left');
		$this->db->join('hris_medical_type_of_reimbursment_parent c', 'c.id = a.tor_parent', 'left');
		$this->db->join('hris_medical_type_of_reimbursment_child d', 'd.id = a.tor_child', 'left');
		$this->db->join('hris_medical_reimbursment f', 'f.request_id = e.id', 'left');
		$this->db->join('v_hris_employee_updated g', 'g.nik = e.employee_id', 'left');

		/* =========================
		FILTER
		========================== */

		$this->db->not_like('e.employee_id', '00000', 'after');
		$this->db->not_like('e.employee_id', 'SPN', 'after');
		$this->db->where('e.form_type', 'MDCR');

		/* =========================
		DATE FILTER (APPROVAL DATE)
		========================== */
		if (!empty($year) && (empty($month) || $month == 'All')) {

			// Filter 1 tahun
			$this->db->where('fl_approve.approved_divhead_hr_at >=', "$year-01-01 00:00:00");
			$this->db->where('fl_approve.approved_divhead_hr_at <', ($year + 1) . "-01-01 00:00:00");

		} elseif (!empty($year) && !empty($month)) {

			// Filter hanya bulan yang dipilih
			$this->db->where('fl_approve.approved_divhead_hr_at >=', "$year-$month-01 00:00:00");
			$this->db->where(
				'fl_approve.approved_divhead_hr_at <',
				date('Y-m-d 00:00:00', strtotime("+1 month", strtotime("$year-$month-01")))
			);
		}

		/* =========================
		COUNT FILTERED
		========================== */
		$totalData = $this->db->count_all_results('', false); // reuse query

		/* =========================
		RESPONSE
		========================== */
		return [
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $data
		];
	}

}