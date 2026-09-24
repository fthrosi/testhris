<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

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
		$this->directorate = $this->session->userdata('directorate');
		$this->emp_id = $this->session->userdata('employee_id');
	}

	public function InfoEmployee(){
		$employee_id = $this->session->userdata('nik');
		//dumper($nik);
		$sql = "SELECT 	
					*
				FROM		
					hris_employee
				WHERE nik = '$employee_id'
				ORDER BY id_employee DESC LIMIT 1";
		$query = $this->db->query($sql);
		$res = $query->result();
		return $res;
	}

	// End C level

	public function getFamilyEmployee()
	{
		$nik 		= $this->session->userdata('employee_id');
		$this->db->order_by('family_members', 'DESC');
		$this->db->where('nik', $nik);
		$result = $this->db->get('hris_family_employee')->result();
		return $result;
	}


	/////////////////////////////////////////START Performance Appraisal 2024////////////////////////////////////////////

	public function countUnsubmitted($eval_year="")
	{
		$count = 0;
		// $sql = "SELECT 
		// 		personnel_area,
		// 		nik,
		// 		join_date,
		// 		employee_subgroup
		// 		FROM v_hris_employee_updated
		// 		WHERE action != '".encrypt('Leaving')."' AND division != '' AND employee_subgroup != '".encrypt('Outsource')."' AND nik NOT IN (SELECT employee_nik FROM performance_appraisal WHERE evaluation_period_start = '{$eval_year}' AND is_status IN (1,2,3)) AND nik NOT IN ('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007') ";
        // $total = $this->db->query($sql)->result_array();


		$sql = "SELECT 
				personnel_area,
				nik,
				join_date,
				employee_subgroup
				FROM v_hris_employee_updated
				WHERE action != '".encrypt('Leaving')."' AND division != '' AND division != '".encrypt('HR SUPPORT')."' AND employee_subgroup != 'c#w#Wmz#c#b#k#a#' AND nik NOT IN (SELECT employee_nik FROM performance_appraisal WHERE evaluation_period_start = '2023-01-01' AND is_status IN (1,2,3))";
		$total = $this->db->query($sql)->result_array();
		// foreach($total as $key => $val){
		// 	if(date("Y-m-d",strtotime(decrypt($val['join_date'])))  <= date("Y-09-30",strtotime($eval_year))){
		// 		// $personnel_area		= decrypt($val['personnel_area']);
		// 		// $pers 				= substr($personnel_area,0,3);
		// 		// if($pers != "TIS"){
		// 		// 	$count++;
		// 		// }
		// 		if($val['employee_subgroup'] != encrypt('Outsource')){
		// 			$count = $count+1;
		// 		}
		// 	}
		// }
		$count = count($total);
		return $count;
	}

	public function countUnsubmittedC($directorate, $eval_year)
	{
		$division = $this->getChildDirectorate($directorate);
		$division_in = " and division IN (".$division.")";
		$sql = "SELECT email
				from v_hris_employee_updated
				WHERE nik NOT IN (SELECT employee_nik FROM performance_appraisal WHERE evaluation_period_start = '{$eval_year}' AND is_status IN (1,2,3))
				{$division_in}
				group by email
				";
		$total = $this->db->query($sql)->result_array();
		return count($total);
		
	}

	public function getDivHeadListByDivision($division,$eval_year)
	{

		
		$this->db->where("is_status", "3");
		$this->db->where("division", $division);
		$this->db->where("evaluation_period_start", $eval_year);
		$result = $this->db->get('performance_appraisal')->result();
		
		return $result;
	}

	public function getDivHeadListBySecondDivision($division,$eval_year)
	{

		
		$query = "select a.id as approval_id,c.id as request_id
				from form_approval as a left join form_request as b on a.request_id = b.id left join performance_appraisal as c on b.request_number = c.request_number where (substring(b.request_number,6,3) = 'KPI') and c.division = '".$division."'";
			
		
		$ListApproval = $this->db->query($query)->result_array();
		
		if (!empty($ListApproval)) {
			foreach ($ListApproval as $key => $value) {
				$reqId = $value['request_id'];
				$list[] = $reqId;
			}

			$approval = implode(",", $list);
			$this->db->select("*");
			$this->db->where("id IN ($approval)");
			$this->db->where("is_status", "3");
			if(decrypt($this->session->userdata('department')) == "GENERAL AFFAIRS"){
				$this->db->where("departement", $this->session->userdata('department'));
			}else{
				$this->db->where("division", $division);
				
			}
			$this->db->where("evaluation_period_start", $eval_year);
			$result = $this->db->get('performance_appraisal')->result();
			
		} else {
			$result = '';
		}

		return $result;

	}
	
	function getChildDirectorate($directorate)
    {

		$year = $this->year - 1;
		$eval_year = $year.'-01-01';
		$sql = "SELECT division FROM multi_division WHERE nik='".$this->emp_id."' AND eval_year = '".$year."'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		
		if(!empty($res)){
			foreach($res as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' or division in ('".$div_name."') group by division")->result_array();	
		}else{
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' group by division")->result_array();
			foreach($div as $key => $val){
				$data_collect[] = $val['division'];
			}
			$div_name = implode("','", $data_collect);

			$director = $this->db->query("select director from v_hris_employee_updated group by director")->result_array();
			foreach($director as $key => $val){
				$data_director[] = decrypt($val['director']);
			}
			$director = implode("','", $data_director);
			
			$sql2 = "SELECT division FROM multi_division WHERE division in ('$div_name') AND nik in ('$director') AND eval_year = '".$year."' group by division";
			$query2 = $this->db->query($sql2);
			$res2 = $query2->result_array();
			$div_name2 = "";
			if(!empty($res2)){
				foreach($res2 as $key => $val){
					$data_collect2[] = $val['division'];
				}
				$div_name2 = implode("','", $data_collect2);
			}
			$div = $this->db->query("select division from v_hris_employee_updated where directorate = '".$this->directorate."' AND division not in ('$div_name2') group by division")->result_array();
		}
		// $div = $this->db->query("select division from v_hris_employee_updated where directorate = '{$directorate}' and division != '".encrypt('MANAGEMENT')."' group by division")->result_array();
		// $div = $this->db->query("select division from v_hris_employee_updated where directorate = '{$directorate}' group by division")->result_array();
		$division = "";
		foreach($div as $key => $val){
			$division .= ",'".$val['division']."'";
		}

		return substr($division,1);
    }

	public function countByStatus($status="", $eval_year="",$type="")
	{
		$sql = "SELECT DISTINCT nik
				from v_hris_employee_updated
				WHERE 
					nik IN (SELECT a.employee_nik FROM performance_appraisal a LEFT JOIN form_request AS b ON a.request_number = b.request_number WHERE a.evaluation_period_start = '$eval_year' AND a.is_status = '$status' AND b.form_type = '$type')";
		$total = $this->db->query($sql)->result_array();
		return count($total);
	}

	public function countEmployee()
	{
		$total_team = 0;
		$nik = array('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007');
		$this->db->select('personnel_area');
		$this->db->where(array('action !=' => encrypt('Leaving') ));
		$this->db->where("division !=",encrypt('HR SUPPORT'));
		$this->db->where("division !=",'');
		$total = $this->db->get('v_hris_employee_updated')->result_array();
		// count($total);
		// die;
		foreach($total as $key => $val){
			$personnel_area		= decrypt($val['personnel_area']);
			// echo $personnel_area."<br>";
			$pers 				= substr($personnel_area,0,3);
			if($pers != "TIS"){
				$total_team++;
			}

		}
		// die;
		return $total_team;
	}

	public function countDivision()
	{
		$nik = array('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007');
		// dumper($nik);
		////cari selain TIS
		$this->db->where("action !=",encrypt('Leaving'));
		// $this->db->where_not_in('nik', $nik);
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
		$total = $this->db->get('v_hris_employee_updated')->result_array();
		
		return count($total);
	}

	public function countConfirmed($eval_year)
	{
		$this->db->select('division_name');
		$this->db->where('is_status', '3');
		$this->db->where('evaluation_period', $eval_year);
		$total = $this->db->get('performance_division_status')->result_array();
		return count($total);
	}

	public function countEligible($status="",$year="")
	{	
		
		if($status == 1){
			$count = 0;
			$total = $this->db->query("select
				personnel_area,
				join_date
				FROM v_hris_employee_updated
				WHERE 
				action != '".encrypt('Leaving')."' AND division != '' AND employee_subgroup != '".encrypt('Outsource')."' and nik NOT IN ('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007') ")->result_array();
			
			foreach($total as $key => $val){
				if(date("Y-m-d",strtotime(decrypt($val['join_date']))) <= $year.'-09-30'){
					$personnel_area		= decrypt($val['personnel_area']);
					$pers 				= substr($personnel_area,0,3);
					if($pers != "TIS"){
						$count = $count+1;
					}
				}
			}

		}else{
			$count = 0;
			$total = $this->db->query("select 
				a.nik, 
				a.personnel_area, 
				a.join_date,
				a.complete_name,
				a.employee_subgroup
				FROM v_hris_employee_updated as a
				WHERE 
				action != '".encrypt('Leaving')."' and a.nik NOT IN ('00000000', '00000001', '00000002', '00000003', '00000004', '00000005', '00000006', '00000007')")->result_array();
			// echo $year."<br>";
			
			foreach($total as $key => $val){
				
				if(date("Y-m-d",strtotime(decrypt($val['join_date']))) > $year.'-09-30'){
					$personnel_area		= decrypt($val['personnel_area']);
					$pers 				= substr($personnel_area,0,3);
					if($pers != "TIS"){
						$count = $count+1;
					}
				}
				if(date("Y-m-d",strtotime(decrypt($val['join_date']))) <= $year.'-09-30'){
					if($val['employee_subgroup'] == encrypt('Outsource')){
						$count = $count+1;
					}
				}
				
			}
		}
		

		return $count;
		
	}

	// C level
	public function countEligibleC($directorate, $status,$year)
	{	
		$division = $this->getChildDirectorate($directorate);
		$division_in = " and division IN (".$division.")";
		$year = $year."-09-30";
		$count = 0;
		
		if($status == 1){
			$total = $this->db->query("select 
				a.email,
				(SELECT join_date from v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as join_date,
				(SELECT prev_joindate from v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as prev_joindate
				from v_hris_employee_updated as a
				WHERE 
				action != '".encrypt('Leaving')."' AND a.employee_subgroup != '".encrypt('Outsource')."'
				$division_in
				group by a.email
			")->result_array();
			foreach($total as $key => $val){
				
				if($val['prev_joindate'] != ""){
					$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['prev_joindate'])));
					
				}else{
					$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['join_date'])));
				}
				
				if($val['join_date'] <= $year.'-09-30'){
					$count++;
				}
			}


		}else{
			$total = $this->db->query("select 
				a.email,
				(SELECT join_date from v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as join_date,
				(SELECT prev_joindate from v_hris_employee_updated where email = a.email ORDER BY id_employee DESC limit 1) as prev_joindate
				from v_hris_employee_updated as a
				WHERE 
				action != '".encrypt('Leaving')."' AND a.employee_subgroup != '".encrypt('Outsource')."'
				$division_in
				group by a.email
			")->result_array();
			foreach($total as $key => $val){
				if($val['prev_joindate'] != ""){
					$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['prev_joindate'])));
				}else{
					$val['join_date'] = date("Y-m-d",strtotime(decrypt($val['join_date'])));
				}
				if($val['join_date'] > $year.'-09-30'){
					$count++;
				}
			}
		}

		
		// die;
		return $count;
		
	}

	public function countByStatusC($directorate, $status, $eval_year)
	{
		$division = $this->getChildDirectorate($directorate);
		$division_in = " division IN (".$division.")";
		$sql = "SELECT DISTINCT nik
				from v_hris_employee_updated
				WHERE  $division_in
				AND nik IN (SELECT employee_nik FROM performance_appraisal WHERE evaluation_period_start = '$eval_year' AND is_status = '$status')";
		$total = $this->db->query($sql)->result_array();
		return count($total);
	}

	public function getTotalGradeAllC($directorate, $grade, $eval_year)
	{		

		$division = $this->getChildDirectorate($directorate);
		$division_in = " and division IN (".$division.")";

		$query = "select final_score from performance_appraisal where is_status = '3' $division_in and evaluation_period_start = '$eval_year'";
		$q = $this->db->query($query)->result_array();
		$total = 0;
		foreach($q as $key => $val){
			$final_score = decrypt($val['final_score']);
			if($grade == 'a'){
				if($final_score >= '9.1'){
					$total++;
				}
			}elseif($grade == 'b'){
				if($final_score >= '8.1' and $final_score < '9.1'){
					$total++;
				}
			}elseif($grade == 'c'){
				if($final_score >= '6.9' and $final_score < '8.1'){
					$total++;
				}
			}elseif($grade == 'd'){
				if($final_score >= '5.6' and $final_score < '6.9'){
					$total++;
				}
			}elseif($grade == 'e'){
				if($final_score >= '0.0' and $final_score < '5.6'){
					$total++;
				}
			}
			
		}

		return $total;
	}

	public function countEmployeeC($directorate)
	{
		
		$division = $this->getChildDirectorate($directorate);
		$division_in = " and division IN (".$division.")";
		$total = $this->db->query("select nik from v_hris_employee_updated where action != '".encrypt('Leaving')."' {$division_in} group by nik")->result_array();
		return count($total);
		
	}

	public function countDivisionC($directorate)
	{
		$division = $this->getChildDirectorate($directorate);
		$division_in = " and division IN (".$division.")";

		$total = $this->db->query("select division from v_hris_employee_updated where action != '".encrypt('Leaving')."' {$division_in} group by division")->result_array();
		return count($total);

	}

	public function countConfirmedC($directorate, $eval_year)
	{
		$division = $this->getChildDirectorate($directorate);
		$division_in = " and division_name IN (".$division.")";

		$total = $this->db->query("select division_name from performance_division_status where is_status = '3' and evaluation_period = '{$eval_year}' {$division_in}")->result_array();
		return count($total);
	}

	public function getAllDataPAC($directorate, $eval_year, $filterDivision = "")
	{
		if($filterDivision == ""){
			$division = $this->getChildDirectorate($directorate);
			$division_in = " and division IN (".$division.")";
		}else{
			$division_in = " and division = '{$filterDivision}'";
		}
		$query = "select * from performance_appraisal where is_status != '0' and evaluation_period_start = '{$eval_year}' {$division_in}";
		return $this->db->query($query)->result();
		
	}

	public function getAllbyGradeC($directorate, $eval_year, $grade)
	{
		
		$division = $this->getChildDirectorate($directorate);
		$division_in = " and division IN (".$division.")";
		$id = "";
		$query = "select final_score,id from performance_appraisal where is_status = '3' AND evaluation_period_start = '$eval_year' $division_in";
		$q = $this->db->query($query)->result_array();
		$total = 0;
		foreach($q as $key => $val){
			if(($val['final_score'] == "" AND $val['final_score'] == 0) or decrypt($val['final_score']) == '0'){
				$final_score = '0';
			}else{
				$final_score = decrypt($val['final_score']);
			}
			if($grade == 'a'){
				if($final_score >= '9.1'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'b'){
				if($final_score >= '8.1' and $final_score < '9.1'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'c'){				
				if($final_score >= '6.9' and $final_score < '8.1'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'd'){
				if($final_score >= '5.6' and $final_score < '6.9'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'e'){
				if($final_score >= '0.0' and $final_score < '5.6'){
					$id .= ",".$val['id'];
				}
			}
			
		}

		

		if($id != ""){
			return $this->db->query("select * from performance_appraisal where id in (".substr($id,1).")")->result();
		}
	}
	// End C level

	//============================ KHUSUS CEO ===============================================================//
	public function countTeam()
	{
		$total = $this->db->get_where('users', array('division_root' => '1', 'user_email != ' => $this->session->userdata('user_email')))->result_array();
		// dumper($total);
		return count($total);
	}

	public function countRequest($status,$eval_year)
	{	
		$where = array('division_root' => '1', 'is_status' => $status, 'evaluation_period_start' => $eval_year);
		$total = $this->db->get_where('performance_appraisal', $where)->result_array();
		return count($total);
	}

	public function getTotalGrade($grade,$eval_year)
	{
		

		$query = "select final_score from performance_appraisal where is_status = '3' and division_root = '1' and evaluation_period_start = '$eval_year'";
		$q = $this->db->query($query)->result_array();
		$total = 0;
		foreach($q as $key => $val){
			$final_score = decrypt($val['final_score']);
			if($grade == 'a'){
				if($final_score >= '9.1'){
					$total++;
				}
			}elseif($grade == 'b'){
				if($final_score >= '8.1' and $final_score < '9.1'){
					$total++;
				}
			}elseif($grade == 'c'){
				if($final_score >= '6.9' and $final_score < '8.1'){
					$total++;
				}
			}elseif($grade == 'd'){
				if($final_score >= '5.6' and $final_score < '6.9'){
					$total++;
				}
			}elseif($grade == 'e'){
				if($final_score >= '0.0' and $final_score < '5.6'){
					$total++;
				}
			}
		}

		return $total;
	}

	//============================ END KHUSUS CEO ===============================================================//

	public function getTotalGradeAll($grade, $eval_year)
	{
		$query = "SELECT a.final_score 
		FROM performance_appraisal a
		LEFT JOIN form_request AS b ON a.request_number = b. request_number
		WHERE a.is_status = '3' AND a.evaluation_period_start = '$eval_year' AND b.form_type = 'KPI'";
		$q = $this->db->query($query)->result_array();
		$total = 0;
		foreach($q as $key => $val){
			$final_score = decrypt($val['final_score']);
			if($grade == 'a'){
				if($final_score >= '9.1'){
					$total++;
				}
			}elseif($grade == 'b'){
				if($final_score >= '8.1' and $final_score < '9.1'){
					$total++;
				}
			}elseif($grade == 'c'){
				if($final_score >= '6.9' and $final_score < '8.1'){
					$total++;
				}
			}elseif($grade == 'd'){
				if($final_score >= '5.6' and $final_score < '6.9'){
					$total++;
				}
			}elseif($grade == 'e'){
				if($final_score >= '0.0' and $final_score < '5.6'){
					$total++;
				}
			}
			
		}
		// echo $total;
		// die;

		return $total;
	}

	public function getAllbyGrade($eval_year, $grade)
	{
		
		$id = "";
		$query = "SELECT a.final_score, a.id
		FROM performance_appraisal a
		LEFT JOIN form_request AS b ON a.request_number = b. request_number
		WHERE a.is_status = '3' AND a.evaluation_period_start = '$eval_year' AND b.form_type = 'KPI'";
		$q = $this->db->query($query)->result_array();
		$total = 0;
		foreach($q as $key => $val){
			$final_score = decrypt($val['final_score']);
			if($grade == 'a'){
				if($final_score >= '9.1'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'b'){
				if($final_score >= '8.1' and $final_score < '9.1'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'c'){
				if($final_score >= '6.9' and $final_score < '8.1'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'd'){
				if($final_score >= '5.6' and $final_score < '6.9'){
					$id .= ",".$val['id'];
				}
			}elseif($grade == 'e'){
				if($final_score >= '0.0' and $final_score < '5.6'){
					$id .= ",".$val['id'];
				}
			}
			
		}

		if($id != ""){
			return $this->db->query("select * from performance_appraisal where id in (".substr($id,1).")")->result();
		}
	}

	public function countDivisionM($status)
	{
		$this->db->select('division_name');
		$this->db->where('is_status', $status);
		$total = $this->db->get('performance_division_status')->result_array();
		return count($total);
	}

	public function countBasicLineAll(){
		$year = 2023;
		$eval_year = $year.'-01-01';
		$this->db->where("action !=",encrypt('Leaving'));
		$this->db->where("division !=",encrypt('HR SUPPORT'));
		$this->db->where("division !=",'');
		$cari_tis = $this->db->get('v_hris_employee_updated')->result_array();
		$data_collect = array();
		foreach($cari_tis as $key => $val){
			$personnel_area		= decrypt($val['personnel_area']);
			$pers 				= substr($personnel_area,0,3);
			if($pers != "TIS"){
				$data_collect[] = $val['nik'];
			}
		}
		$this->db->select('division');
		$this->db->where_in('nik', $data_collect);
		$this->db->group_by('division');
		$div = $this->db->get('v_hris_employee_updated')->result_array();
		
		$division = "";
		foreach($div as $key => $val){

			$sql = "Select division_name, updated_by,(CASE WHEN is_status is null THEN 0 ELSE is_status END) as is_status from performance_division_status where evaluation_period = '$eval_year' and division_name = '".$val['division']."'";
			$datas = $this->db->query($sql)->result_array();
			if(count($datas) > 0){
				foreach($datas as $k => $v){
					$data[] = array("division_name" => ($v['division_name']));
				}
				
			}else{
				$data[] = array("division_name" => ($val['division']));
			}
		}
		$output = $data;

        $devisiasi_basic_line_a = "";
        $devisiasi_basic_line_b = "";
        $devisiasi_basic_line_c = "";
        $devisiasi_basic_line_d = "";
        $devisiasi_basic_line_e = "";

        $basic_line_a_all = 0;
        $basic_line_b_all = 0;
        $basic_line_c_all = 0;
        $basic_line_d_all = 0;
        $basic_line_e_all = 0;
        
        foreach($output as $key => $val){
            
            $year = date("Y")-1;
            $status_emp = encrypt('Leaving');
            $query = "
            SELECT *
            FROM
            v_hris_employee_updated a
            LEFT JOIN employee_update_division_pa as b on a.id_employee = b.id_employee and b.evaluation_year = '$year' 
            where (a.action != '$status_emp' or b.is_leaving = '1') AND a.division != '' AND a.employee_subgroup != '".encrypt('Outsource')."' AND a.nik != '20130331' AND  a.nik != '20130065' AND a.nik != '20130240' AND
            case 
                when b.division != '' then b.division
            else
                a.division
            end  = '".$val['division_name']."'
            ";
            
            $eligible = 0;
            $total = $this->db->query($query)->result();
        
            foreach($total as $item){
                
                    if($item->prev_joindate != ""){
                        $join_date = date("Y-m-d",strtotime(decrypt($item->prev_joindate)));
                    }else{
                        $join_date = date("Y-m-d",strtotime(decrypt($item->join_date)));
                    }
                    if($join_date <= $year.'-09-30'){
                        $eligible++;
                    }
            }

            $total_team_eligible = $eligible;

            ($devisiasi_basic_line_a != "") ? $basic_line_a = $devisiasi_basic_line_a : $basic_line_a = round(($total_team_eligible*5)/100);
            ($devisiasi_basic_line_b != "") ? $basic_line_b = $devisiasi_basic_line_b : $basic_line_b = round(($total_team_eligible*32)/100);
            ($devisiasi_basic_line_c != "") ? $basic_line_c = $devisiasi_basic_line_c : $basic_line_c = round(($total_team_eligible*43)/100);
            ($devisiasi_basic_line_d != "") ? $basic_line_d = $devisiasi_basic_line_d : $basic_line_d = round(($total_team_eligible*15)/100);
            ($devisiasi_basic_line_e != "") ? $basic_line_e = $devisiasi_basic_line_e : $basic_line_e = round(($total_team_eligible*5)/100);

            $total_line_all = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
            if($total_line_all > $total_team_eligible){
                $basic_line_e = $basic_line_e-1;
            }elseif($total_line_all < $total_team_eligible){
                $total_tambah = $total_team_eligible - $total_line_all;
                $basic_line_c = $basic_line_c+$total_tambah;
            }

            $basic_line_a_all += $basic_line_a;
            $basic_line_b_all += $basic_line_b;
            $basic_line_c_all += $basic_line_c;
            $basic_line_d_all += $basic_line_d;
            $basic_line_e_all += $basic_line_e;
        }

		$dataAll = array("basic_line_a_all" => $basic_line_a_all, "basic_line_b_all" => $basic_line_b_all, "basic_line_c_all" => $basic_line_c_all, "basic_line_d_all" => $basic_line_d_all, "basic_line_e_all" => $basic_line_e_all);
		return $dataAll;
	}
	/////////////////////////////////////////END Performance Appraisal 2024////////////////////////////////////////////

	///////////////////////////Penambahan Info 2025////////////////////////////////////////////
	public function getInfo(){
       	$today = date("Y-m-d");
		$sqlInfo = "
			SELECT *
			FROM information
			WHERE start_date <= '$today' COLLATE utf8mb4_general_ci
			AND end_date >= '$today' COLLATE utf8mb4_general_ci
			ORDER BY id DESC
			LIMIT 1
		";
		$this->db->query("SET NAMES utf8mb4 COLLATE utf8mb4_general_ci");

		$result = $this->db->query($sqlInfo);
		$info   = $result->result_array();

		if($info){
			return $info;
		}else{
			$data = array(
				'id'         => 'XX',
				'info'       => '',
				'start_date' => '0000-00-00',
				'end_date'   => '0000-00-00',
				'status'     => '0',
				'created_at' => 'No Information',
				'created_by' => 'No Information'
			);

			$info[] = $data;
			return $info;
		}
        
    }
}