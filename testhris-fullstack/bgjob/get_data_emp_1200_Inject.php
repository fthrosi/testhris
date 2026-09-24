
<?php
require 'phpmailer/PHPMailerAutoload.php';
class KeyValuePair
{
    public $Key;
    public $Value;
}

function compare($first, $second) {
	return strcmp($first->Value, $second->Value);
}

function GetShiftIndexes($key)
{
	$keyLength = strlen($key);
	$indexes = array();
	$sortedKey = array();
	$i;

	for ($i = 0; $i < $keyLength; ++$i) {
		$pair = new KeyValuePair();
		$pair->Key = $i;
		$pair->Value = $key[$i];
		$sortedKey[] = $pair;
	}

	usort($sortedKey, "compare");
	$i = 0;

	for ($i = 0; $i < $keyLength; ++$i)
		$indexes[$sortedKey[$i]->Key] = $i;

	return $indexes;
}

function encrypt($str) {
	$offset = chr(53);
    $encrypted_text = "";
    $offset = $offset % 26;
    if($offset < 0) {
        $offset += 26;
    }
    
    $offset2 = $offset % 10;
    if($offset2 < 0) {
        $offset2 += 10;
    }
    
    $i = 0;
    while($i < strlen($str)) {
        $c = $str[$i]; 
        if(($c >= "A") && ($c <= "Z")) {
            if((ord($c) + $offset) > ord("Z")) {
                $encrypted_text .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted_text .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "a") && ($c <= "z")) {
            if((ord($c) + $offset) > ord("z")) {
                $encrypted_text .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted_text .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "0") && ($c <= "9")) {
				if((ord($c) + $offset2) > ord("9")) {
					$encrypted_text .= chr(ord($c) + $offset2 - 10);
			} else {
				$encrypted_text .= chr(ord($c) + $offset2);
			}
	  } else {
            $encrypted_text .= $c;
      }
      $i++;
    }
    
	
	$padChar = "#";
	$input 	= $encrypted_text;
	$key 	= "ibswhris";
	$output = "";
	$totalChars = strlen($input);
	$keyLength = strlen($key);
	$input = ($totalChars % $keyLength == 0) ? $input : str_pad($input, $totalChars - ($totalChars % $keyLength) + $keyLength, $padChar, STR_PAD_RIGHT);
	$totalChars = strlen($input);
	$totalColumns = $keyLength;
	$totalRows = ceil($totalChars / $totalColumns);
	$rowChars = array(array());
	$colChars = array(array());
	$sortedColChars = array(array());
	$currentRow = 0; $currentColumn = 0; $i = 0; $j = 0;
	$shiftIndexes = GetShiftIndexes($key);

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalColumns;
		$currentColumn = $i % $totalColumns;
		$rowChars[$currentRow][$currentColumn] = $input[$i];
	}

	for ($i = 0; $i < $totalRows; ++$i)
		for ($j = 0; $j < $totalColumns; ++$j)
			$colChars[$j][$i] = $rowChars[$i][$j];

	for ($i = 0; $i < $totalColumns; ++$i)
		for ($j = 0; $j < $totalRows; ++$j)
			$sortedColChars[$shiftIndexes[$i]][$j] = $colChars[$i][$j];

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalRows;
		$currentColumn = $i % $totalRows;
		$output .= $sortedColChars[$currentRow][$currentColumn];
	}
	
	
	$offset = chr(51);
    $encrypted = "";
    $offset = $offset % 26;
    if($offset < 0) {
        $offset += 26;
    }
    
    $offset2 = $offset % 10;
    if($offset2 < 0) {
        $offset2 += 10;
    }
    
    $i = 0;
    while($i < strlen($output)) {
        $c = $output[$i]; 
        if(($c >= "A") && ($c <= "Z")) {
            if((ord($c) + $offset) > ord("Z")) {
                $encrypted .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "a") && ($c <= "z")) {
            if((ord($c) + $offset) > ord("z")) {
                $encrypted .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "0") && ($c <= "9")) {
				if((ord($c) + $offset2) > ord("9")) {
					$encrypted .= chr(ord($c) + $offset2 - 10);
			} else {
				$encrypted .= chr(ord($c) + $offset2);
			}
	  } else {
            $encrypted .= $c;
      }
      $i++;
    }
	
	return $encrypted;
    }


    function decrypt($input) {
	
        $str = $input;
        $offset = chr(51);
        $decrypted_text = "";
        $offset = $offset % 26;
        if($offset < 0) {
            $offset += 26;
        }
        
        $offset2 = $offset % 10;
        if($offset2 < 0) {
            $offset2 += 10;
        }
        
        $i = 0;
        while($i < strlen($str)) {
            $c = $str[$i]; 
            if(($c >= "A") && ($c <= 'Z')) {
                if((ord($c) - $offset) < ord("A")) {
                    $decrypted_text .= chr(ord($c) - $offset + 26);
                } else {
                    $decrypted_text .= chr(ord($c) - $offset);
                }
          }elseif(($c >= "a") && ($c <= 'z')) {
                if((ord($c) - $offset) < ord("a")) {
                    $decrypted_text .= chr(ord($c) - $offset + 26);
                } else {
                    $decrypted_text .= chr(ord($c) - $offset);
                }
          }elseif(($c >= "0") && ($c <= '9')) {
                if((ord($c) - $offset2) < ord("0")) {
                    $decrypted_text .= chr(ord($c) - $offset2 + 10);
                } else {
                    $decrypted_text .= chr(ord($c) - $offset2);
                }
          } else {
                $decrypted_text .= $c;
          }
          $i++;
        }
        
        
        
        $key="ibswhris";
        $output = "";
        $keyLength = strlen($key);
        $totalChars = strlen($decrypted_text);
        $totalColumns = ceil($totalChars / $keyLength);
        $totalRows = $keyLength;
        $rowChars = array(array());
        $colChars = array(array());
        $unsortedColChars = array(array());
        $currentRow = 0; $currentColumn = 0; $i = 0; $j = 0;
        $shiftIndexes = GetShiftIndexes($key);
    
        for ($i = 0; $i < $totalChars; ++$i)
        {
            $currentRow = $i / $totalColumns;
            $currentColumn = $i % $totalColumns;
            $rowChars[$currentRow][$currentColumn] = $decrypted_text[$i];
        }
    
        for ($i = 0; $i < $totalRows; ++$i)
            for ($j = 0; $j < $totalColumns; ++$j)
                $colChars[$j][$i] = $rowChars[$i][$j];
    
        for ($i = 0; $i < $totalColumns; ++$i)
            for ($j = 0; $j < $totalRows; ++$j)
                $unsortedColChars[$i][$j] = $colChars[$i][$shiftIndexes[$j]];
    
        for ($i = 0; $i < $totalChars; ++$i)
        {
            $currentRow = $i / $totalRows;
            $currentColumn = $i % $totalRows;
            $output .= $unsortedColChars[$currentRow][$currentColumn];
        }
        
        
        
        $offset = chr(53);
        $decrypted = "";
        $offset = $offset % 26;
        if($offset < 0) {
            $offset += 26;
        }
        
        $offset2 = $offset % 10;
        if($offset2 < 0) {
            $offset2 += 10;
        }
        
        $i = 0;
        while($i < strlen($output)) {
            $c = $output[$i]; 
            if(($c >= "A") && ($c <= 'Z')) {
                if((ord($c) - $offset) < ord("A")) {
                    $decrypted .= chr(ord($c) - $offset + 26);
                } else {
                    $decrypted .= chr(ord($c) - $offset);
                }
          }elseif(($c >= "a") && ($c <= 'z')) {
                if((ord($c) - $offset) < ord("a")) {
                    $decrypted .= chr(ord($c) - $offset + 26);
                } else {
                    $decrypted .= chr(ord($c) - $offset);
                }
          }elseif(($c >= "0") && ($c <= '9')) {
                if((ord($c) - $offset2) < ord("0")) {
                    $decrypted .= chr(ord($c) - $offset2 + 10);
                } else {
                    $decrypted .= chr(ord($c) - $offset2);
                }
          } else {
                $decrypted .= $c;
          }
          $i++;
        }
        $decrypted = str_replace('#', '', $decrypted);
        return $decrypted;
    }


    ////////////////////////////////////////////////////////$$$//////////////////////////////////////////////////


$localhost = "localhost"; 
$username = "IBS_HRIS"; 
$password = "IBShris@2025"; 
$dbname = "IBS_HRIS_DB";  
    
// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname); 
    
// check connection 
if($conn->connect_error) {
    die("connection failed : " . $conn->connect_error);
} else {
    echo "Successfully Connected<br>";
}

$file1 = "/var/www/html/bgjob/Temp_File/Insert_Employee_06012026.csv";
$file2 = "/var/www/html/bgjob/Temp_File/Insert_FE_06102025.csv";


if(file_exists("$file1")){

    chmod("$file1",0770);
    echo "File CSV 1 ada";
    echo "<br><br>";

    //Data Employee
    $handle1= fopen("$file1","r"); 
    $flag = true;
    while(($data=fgetcsv($handle1,0,';'))!== FALSE){ 

        $complete_name      = str_replace("'","||", $data[1]);
        $emftx              = str_replace("'","||", $data[31]);
        $emftx1             = str_replace("'","||", $data[33]);
        $complete_name      = str_replace("'","||", $data[1]);
        $complete_name_user = str_replace("'","||", $data[1]);

        $superior_name      = str_replace("'","||", $data[21]);

        $depthead_name      = str_replace("'","||", $data[23]);

        $divhead_name       = str_replace("'","||", $data[25]);

        $director_name      = str_replace("'","||", $data[27]);

        if($flag) { $flag = false; continue; }
        $nik                = $data[0];
        $complete_name      = encrypt($complete_name);
        $start_date         = encrypt($data[2]);
        $action             = encrypt($data[3]);
        $reason_of_action   = encrypt($data[4]);
        $gender             = encrypt($data[5]);
        $birthplace         = encrypt($data[6]);
        $date_of_birth      = encrypt($data[7]);
        $religion           = encrypt($data[8]);
        $marital_status     = encrypt($data[9]);
        $join_date          = encrypt($data[10]);
        $permanent_address  = encrypt($data[11]);
        $temporary_address  = encrypt($data[12]);
        $phone_number       = encrypt($data[13]);
        $sf_phone_number    = encrypt($data[14]);
        $personal_email     = encrypt($data[15]);
        $email              = encrypt($data[16]);
        $no_ktp             = encrypt($data[17]);
        $npwp_id            = encrypt($data[18]);
        $bpjs_ketenagakerjaan = encrypt($data[19]);
        $bpjs_kesehatan     = encrypt($data[20]);
        $status_ptkp        = encrypt($data[21]);
        $company_code       = encrypt($data[22]);
        $company_name       = encrypt($data[23]);
        $personnel_area     = encrypt($data[24]);
        $personnel_subarea  = encrypt($data[25]);
        $employee_group     = encrypt($data[26]);
        $employee_subgroup  = encrypt($data[27]);
        $cost_center        = encrypt($data[28]);
        $cost_center_desc   = encrypt($data[29]);
        $bankn              = encrypt($data[30]);
        $emftx              = encrypt($emftx);
        $bankn1             = encrypt($data[32]);
        $emftx1             = encrypt($emftx1);
        $position           = encrypt($data[34]);
        $department         = encrypt($data[35]);
        $division           = encrypt($data[36]);
        $directorate        = encrypt($data[37]);
        $superior           = encrypt($data[38]);
        $superior_name      = encrypt($data[39]);
        $usrid_long1        = encrypt($data[40]);
        $rpm                = encrypt($data[41]);
        $rpm_name           = encrypt($data[42]);
        $usrid_long5        = encrypt($data[43]);
        $department_head    = encrypt($data[44]);
        $depthead_name      = encrypt($data[45]);
        $usrid_long2        = encrypt($data[46]);
        $division_head      = encrypt($data[47]);
        $divhead_name       = encrypt($data[48]);
        $usrid_long3        = encrypt($data[49]);
        $director           = encrypt($data[50]);
        $director_name      = encrypt($data[51]);
        $usrid_long4        = encrypt($data[52]);

        $sql = "SELECT * FROM hris_employee WHERE nik='".$nik."'";
        $result = $conn->query($sql);
                if($result === false) {
                    print_r('error');die;
                }
                $row = mysqli_fetch_array($result);
        
        if (empty($row[0])){
            if(!empty($nik) && ($nik != '')){
                $sql ="INSERT INTO hris_employee (nik, complete_name, start_date, action, reason_of_action, gender, birthplace, date_of_birth, religion, marital_status, join_date, permanent_address, temporary_address, phone_number, sf_phone_number, personal_email, email, no_ktp, npwp_id, bpjs_ketenagakerjaan, bpjs_kesehatan, status_ptkp, company_code, company_name, personnel_area, personnel_subarea, employee_group, employee_subgroup, cost_center, cost_center_desc, bankn, emftx, bankn1, emftx1, position, department, division, directorate, superior, superior_name, usrid_long1, rpm, rpm_name,  usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4) VALUES ('$nik', '$complete_name', '$start_date', '$action', '$reason_of_action', '$gender', '$birthplace', '$date_of_birth', '$religion', '$marital_status', '$join_date', '$permanent_address', '$temporary_address', '$phone_number', '$sf_phone_number', '$personal_email', '$email', '$no_ktp', '$npwp_id', '$bpjs_ketenagakerjaan', '$bpjs_kesehatan', '$status_ptkp', '$company_code', '$company_name', '$personnel_area', '$personnel_subarea', '$employee_group', '$employee_subgroup', '$cost_center', '$cost_center_desc', '$bankn', '$emftx', '$bankn1', '$emftx1', '$position', '$department', '$division', '$directorate', '$superior', '$superior_name', '$usrid_long1', '$rpm', '$rpm_name', '$usrid_long5', '$department_head', '$depthead_name', '$usrid_long2', '$division_head', '$divhead_name', '$usrid_long3', '$director', '$director_name', '$usrid_long4')";
                $stmt = $conn->query($sql);
                if( $stmt === false ) {
                    die( print_r( mysqli_errors(), true));
                }

                /////////////////////////////////// START CREATE NEW EMPLOYEE YEARLY SCHEDULE TIME MANAGEMENT 2024///////////////////////////////////

                $year_new_employee = date('Y', strtotime($data[10]));
                $end_date_new_employee = $year_new_employee . '-12-31';
                $join_date_new_employee = $data[10];
                $sql = "SELECT a.nik, a.complete_name, b.date, b.daily_work_schedule, b.dws_code, b.holiday_calendar
                        FROM v_hris_employee_updated a LEFT JOIN hris_master_calendar b ON a.nik = $nik
                        WHERE b.date BETWEEN '$join_date_new_employee' AND '$end_date_new_employee'";
                $query = $conn->query($sql); 

                while($res = mysqli_fetch_array($query)){
                    $nik = $res['nik'];  
                    $check_date = $res['date'];
                    $sqlCheck = "SELECT * FROM hris_master_time_management WHERE employee_id = '$nik' AND date = '$check_date'"; 
                    $queryCheck = $conn->query($sqlCheck);
                    $resCheck = mysqli_fetch_array($queryCheck); 
                    
                    if((empty($resCheck)) || ($resCheck == NULL) || ($resCheck == 'NULL')){
                        if(!empty($res['holiday_calendar'])){
                            $dws = $res['holiday_calendar'];
                        } else {
                            $dws = $res['daily_work_schedule'];
                        }
                        $dws_code = $res['dws_code'];

                        $sqlSchedule = "SELECT a.schedule_in, a.schedule_out
                                        FROM hris_master_schedule as a
                                        LEFT JOIN v_hris_nik_company as b ON a.company_code = b.company_code
                                        WHERE a.kode = '$dws_code' AND a.end_date = '9999-12-31' AND b.nik = '$nik'";
                        
                        $querySchedule = $conn->query($sqlSchedule);
                        $resSchedule = mysqli_fetch_array($querySchedule);
                        $complete_name = decrypt($res['complete_name']);
                        $date = $res['date'];
                        $resScheduleIn = $resSchedule['schedule_in'];
                        $resScheduleOut= $resSchedule['schedule_out'];
                        $sqlInsert = "INSERT IGNORE INTO hris_master_time_management(employee_id, full_name, date, dws, schedule_code, schedule_in, schedule_out) VALUES ('$nik', '$complete_name', '$date', '$dws', '$dws_code', '$resScheduleIn', '$resScheduleOut')";
                        $stmt = $conn->query($sqlInsert);
                        
                    }else{
                        continue;
                    }
                }
            }else{
                // continue;
                var_dump('test');die;
            }  

        }elseif(!empty($row[0])){
            
            $sql2 = "SELECT * FROM hris_employee WHERE nik LIKE '$nik' ORDER BY id_employee DESC LIMIT 1";
            $result2 = $conn->query($sql2);
            
            if( $result2 === false ) {
                die( print_r( mysqli_errors(), true));
            }      
            while( $res = mysqli_fetch_array($result2) ) {
                
                $dbcomplete_name              = $res['complete_name'];
                $dbstart_date                 = $res['start_date'];
                $dbaction                     = $res['action'];
                $dbreason_of_action           = $res['reason_of_action'];
                $dbgender                     = $res['gender'];
                $dbbirthplace                 = $res['birthplace'];
                $dbdate_of_birth              = $res['date_of_birth'];
                $dbreligion                   = $res['religion'];
                $dbmarital_status             = $res['marital_status'];
                $dbjoin_date                  = $res['join_date'];
                $dbpermanent_address          = $res['permanent_address'];
                $dbtemporary_address          = $res['temporary_address'];
                $dbphone_number               = $res['phone_number'];
                $dbsf_phone_number            = $res['sf_phone_number'];
                $dbpersonal_email             = $res['personal_email'];
                $dbemail                      = $res['email'];
                $dbno_ktp                     = $res['no_ktp'];
                $dbnpwp_id                    = $res['npwp_id'];
                $dbbpjs_ketenagakerjaan       = $res['bpjs_ketenagakerjaan'];
                $dbbpjs_kesehatan             = $res['bpjs_kesehatan'];
                $dbstatus_ptkp                = $res['status_ptkp'];
                $dbcompany_code               = $res['company_code'];
                $dbcompany_name               = $res['company_name'];
                $dbpersonnel_area             = $res['personnel_area'];
                $dbpersonnel_subarea          = $res['personnel_subarea'];
                $dbemployee_group             = $res['employee_group'];
                $dbemployee_subgroup          = $res['employee_subgroup'];
                $dbcost_center                = $res['cost_center'];
                $dbcost_center_desc           = $res['cost_center_desc'];
                $dbbankn                      = $res['bankn'];
                $dbemftx                      = $res['emftx'];
                $dbbankn1                     = $res['bankn1'];
                $dbemftx1                     = $res['emftx1'];
                $dbposition                   = $res['position'];
                $dbdepartment                 = $res['department'];
                $dbdivision                   = $res['division'];
                $dbdirectorate                = $res['directorate'];
                $dbsuperior                   = $res['superior'];
                $dbsuperior_name              = $res['superior_name'];
                $dbusrid_long1                = $res['usrid_long1'];
                $dbrpm                        = $res['rpm'];
                $dbrpm_name                   = $res['rpm_name'];
                $dbusrid_long5                = $res['usrid_long5'];
                $dbdepartment_head            = $res['department_head'];
                $dbdepthead_name              = $res['depthead_name'];
                $dbusrid_long2                = $res['usrid_long2'];
                $dbdivision_head              = $res['division_head'];
                $dbdivhead_name               = $res['divhead_name'];
                $dbusrid_long3                = $res['usrid_long3'];
                $dbdirector                   = $res['director'];
                $dbdirector_name              = $res['director_name'];
                $dbusrid_long4                = $res['usrid_long4'];

                if(($complete_name != $dbcomplete_name) || ($start_date != $dbstart_date) || ($action != $dbaction) || ($reason_of_action != $dbreason_of_action) || ($gender != $dbgender) || ($birthplace != $dbbirthplace) || ($date_of_birth != $dbdate_of_birth) || ($religion != $dbreligion) || ($marital_status != $dbmarital_status) || ($join_date != $dbjoin_date) || ($permanent_address != $dbpermanent_address) || ($temporary_address != $dbtemporary_address) || ($phone_number != $dbphone_number) || ($sf_phone_number != $dbsf_phone_number) || ($personal_email != $dbpersonal_email) || ($email != $dbemail) || ($no_ktp != $dbno_ktp) || ($npwp_id != $dbnpwp_id) || ($bpjs_ketenagakerjaan != $dbbpjs_ketenagakerjaan) || ($bpjs_kesehatan != $dbbpjs_kesehatan) || ($status_ptkp != $dbstatus_ptkp) || ($company_code != $dbcompany_code) || ($company_name != $dbcompany_name) || ($personnel_area != $dbpersonnel_area) || ($personnel_subarea != $dbpersonnel_subarea) || ($employee_group != $dbemployee_group) || ($employee_subgroup != $dbemployee_subgroup) || ($cost_center != $dbcost_center) || ($cost_center_desc != $dbcost_center_desc) || ($bankn != $dbbankn) || ($emftx != $dbemftx) || ($bankn1 != $dbbankn1) || ($emftx1 != $dbemftx1) || ($position != $dbposition) || ($department != $dbdepartment) || ($division != $dbdivision) || ($directorate != $dbdirectorate) || ($superior != $dbsuperior) || ($superior_name != $dbsuperior_name) || ($usrid_long1 != $dbusrid_long1) || ($rpm != $dbrpm) || ($rpm_name != $dbrpm_name) || ($usrid_long5 != $dbusrid_long5) || ($department_head != $dbdepartment_head) || ($depthead_name != $dbdepthead_name) || ($usrid_long2 != $dbusrid_long2) || ($division_head != $dbdivision_head) || ($divhead_name != $dbdivhead_name) || ($usrid_long3 != $dbusrid_long3) || ($director != $dbdirector) || ($director_name != $dbdirector_name) || ($usrid_long4 != $dbusrid_long4)){

                    $sql2 = "INSERT INTO hris_employee (nik, complete_name, start_date, action, reason_of_action, gender, birthplace, date_of_birth, religion, marital_status, join_date, permanent_address, temporary_address, phone_number, sf_phone_number, personal_email, email, no_ktp, npwp_id, bpjs_ketenagakerjaan, bpjs_kesehatan, status_ptkp, company_code, company_name, personnel_area, personnel_subarea, employee_group, employee_subgroup, cost_center, cost_center_desc, bankn, emftx, bankn1, emftx1, position, department, division, directorate, superior, superior_name, usrid_long1, rpm, rpm_name,  usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4) VALUES ('$nik', '$complete_name', '$start_date', '$action', '$reason_of_action', '$gender', '$birthplace', '$date_of_birth', '$religion', '$marital_status', '$join_date', '$permanent_address', '$temporary_address', '$phone_number', '$sf_phone_number', '$personal_email', '$email', '$no_ktp', '$npwp_id', '$bpjs_ketenagakerjaan', '$bpjs_kesehatan', '$status_ptkp', '$company_code', '$company_name', '$personnel_area', '$personnel_subarea', '$employee_group', '$employee_subgroup', '$cost_center', '$cost_center_desc', '$bankn', '$emftx', '$bankn1', '$emftx1', '$position', '$department', '$division', '$directorate', '$superior', '$superior_name', '$usrid_long1', '$rpm', '$rpm_name', '$usrid_long5', '$department_head', '$depthead_name', '$usrid_long2', '$division_head', '$divhead_name', '$usrid_long3', '$director', '$director_name', '$usrid_long4')";
                    $stmt = $conn->query($sql2);
                    if( $stmt === false ) {
                        die( print_r( mysqli_errors(), true));
                    }                        

                }
            }

            /////////////////////////////////// START DELETE LEAVING EMPLOYEE YEARLY SCHEDULE TIME MANAGEMENT 2024///////////////////////////////////
            if ($action == encrypt('Leaving')){
                
                
                $year_leave_employee = date('Y', strtotime($data[2]));
                $end_date_leave_employee = $year_leave_employee . '-12-31';
                $start_date_leave_employee = date('Y-m-d',strtotime($data[2]));
                
                $sqlDeleteLeaving = "DELETE FROM hris_master_time_management WHERE employee_id='$nik' AND (date BETWEEN '$start_date_leave_employee' AND '$end_date_leave_employee')";
                $queryDeleteLeaving = $conn->query($sqlDeleteLeaving);
                

                /////////////////////////////////START UPDATE USERS INACTIVE///////////////////////////////////////
                // $today                   = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
                $today                   = date('Y-m-d');
                $tgl_action              = DateTime::createFromFormat('Ymd', decrypt($start_date));
                $tgl_action              = $tgl_action->format('Y-m-d');
                $diff                    = abs(strtotime($today) - strtotime($tgl_action));
                $diff_day            	 = round($diff / (60 * 60 * 24));
                /////menghitung jarak karyawan leaving selama durasi 30 hari setelah lebih dari 30 hari akan di non aktifkan//////
                if($diff_day > 30){
                    $sql_users = "UPDATE users SET is_active = 0 WHERE employee_id LIKE '$nik'";
                    $sql_users =  $conn->query($sql_users);
                }
                /////////////////////////////////END UPDATE USERS INACTIVE///////////////////////////////////////
            }
            /////////////////////////////////// END DELETE LEAVING EMPLOYEE YEARLY SCHEDULE TIME MANAGEMENT 2024///////////////////////////////////

        }
    }

    if (!unlink($file_pointer1)) { 
        echo ("File Pointer 1 cannot be deleted due to an error"); 
        echo "<br><br>";
    }else{ 
        echo ("File Pointer 1 has been deleted"); 
        echo "<br><br>";
    } 

}else{

    echo "File CSV 1 tidak ada";
    echo "<br><br>";
    
}




if(file_exists("$file2")){
    chmod("$file2",0770);
    echo "File CSV 2 ada";
    echo "<br><br>";

    $handle2 = fopen("$file2", "r");
    $flag_1 = true;

    while (($data = fgetcsv($handle2, 0, ';')) !== false) {
        if ($flag_1) { $flag_1 = false; continue; }

        // Data pre-processing
        $nik                = $data[0];
        $complete_name      = encrypt(str_replace("'", "||", $data[1]));
        $family_members     = encrypt($data[2]);
        $member_type        = $data[2];
        $seqno_raw          = trim($data[3]);
        $seqno              = encrypt((($member_type === 'Spouse' || $member_type === 'Child') && $seqno_raw === '') ? '00' : $seqno_raw);
        $member_names       = encrypt(str_replace("'", "||", $data[4]));
        $member_gender      = encrypt($data[5]);
        $member_birthplace  = encrypt($data[6]);
        $member_birthdate   = encrypt($data[7]);

        // --- Cek apakah data sudah ada ---
        $stmt_check = $conn->prepare("SELECT 1 FROM hris_family_employee WHERE nik = ? AND seqno = ? AND family_members = ?");
        $stmt_check->bind_param("sss", $nik, $seqno, $family_members);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows === 0) {
            // --- Data belum ada → INSERT ---
            $stmt_insert = $conn->prepare("INSERT INTO hris_family_employee 
                (nik, complete_name, family_members, seqno, member_names, member_gender, member_birthplace, member_birthdate)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("ssssssss", $nik, $complete_name, $family_members, $seqno, $member_names, $member_gender, $member_birthplace, $member_birthdate);

            if (!$stmt_insert->execute()) {
                die("Insert error: " . $stmt_insert->error);
            }

            $stmt_insert->close();
        } else {
            // --- Data sudah ada → UPDATE ---
            $stmt_update = $conn->prepare("UPDATE hris_family_employee 
                SET family_members = ?, seqno = ?, member_names = ?, member_gender = ?, member_birthplace = ?, member_birthdate = ?
                WHERE nik = ? AND seqno = ?");
            $stmt_update->bind_param("ssssssss", $family_members, $seqno, $member_names, $member_gender, $member_birthplace, $member_birthdate, $nik, $seqno);

            if (!$stmt_update->execute()) {
                die("Update error: " . $stmt_update->error);
            }

            $stmt_update->close();
        }

        $stmt_check->close();
    }

    fclose($handle2);

    if (!unlink($file2)) { 
        echo ("File Pointer 2 cannot be deleted due to an error"); 
        echo "<br><br>";
    }else{ 
        echo ("File Pointer 2 has been deleted"); 
        echo "<br><br>";
    } 
    
}else{
    echo "File CSV 2 tidak ada";
    echo "<br><br>";
    
}        
        
    
?>
