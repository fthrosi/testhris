<?php
include 'phpmailer/PHPMailerAutoload.php'; 

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

$localhost = "localhost"; 
$username = "cikini"; 
$password = "@C1k1n1#2022"; 
$dbname = "db_hris1"; 
// $localhost = "localhost"; 
// $username = "SAP-IBS"; 
// $password = "SAPibs2020"; 
// $dbname = "db_hris1"; 
 
// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname); 
 
// check connection 
if($conn->connect_error) {
    die("connection failed : " . $conn->connect_error);
} else {
    echo "Successfully Connected<br>";
}

$yesterday = date("Y-m-d",strtotime("-1 days"));
// $yesterday = date("Y-m-d");
$condition = encrypt('Leaving');
$subgroup = encrypt('Outsource');

$sql = "SELECT a.*, b.company_code, b.employee_group, b.personnel_area FROM hris_master_time_management a
        LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
        WHERE a.date='$yesterday' AND b.action!='$condition' AND b.employee_subgroup!='$subgroup' AND b.nik NOT LIKE '0000%' AND b.nik LIKE '20180026'";
$result = $conn->query($sql);
// var_dump($sql);die;
$sqlCTAB = "SELECT nama FROM hris_master_time_off WHERE kode = 'CTAB'";
$queryCTAB = $conn->query($sqlCTAB);
$resultCTAB = mysqli_fetch_array($queryCTAB, MYSQLI_ASSOC);
$CTAB = $resultCTAB['nama'];

while($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $nik = $res['employee_id'];
    // var_dump($nik);die;
    if (empty($nik)){
        continue;
    }

    $sqlTop = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
    $resultTop = $conn->query($sqlTop);
    $prevTop = mysqli_fetch_array( $resultTop, MYSQLI_ASSOC);
    if (empty($prevTop)){
        $prevTop['total_cuti'] = 0;
    }

    $Hmin2 = date("Y-m-d",strtotime("-2 days"));
    $sqlHmin2 = "SELECT a.* FROM hris_master_time_management a
    LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
    WHERE (a.check_out = '' OR a.check_out IS NULL) AND a.date='$Hmin2' AND (a.time_off_code='' OR a.time_off_code IS NULL OR a.time_off_code='IDT' OR a.time_off_code='IPC') 
    AND (a.schedule_code LIKE 'N%' OR a.schedule_code LIKE 'SHF%') AND b.nik NOT LIKE '0000%' AND b.nik LIKE '$nik'";
    $resultHmin2 = $conn->query($sqlHmin2);
    $resHmin2 = mysqli_fetch_array($resultHmin2, MYSQLI_ASSOC);
    $schedule_in_Hmin2 = $resHmin2['schedule_in'];
    $sch_in_Hmin2 = strtotime($resHmin2['schedule_in']);;
    $schedule_out_Hmin2 = $resHmin2['schedule_out'];
    $sch_out_Hmin2 = strtotime($resHmin2['schedule_out']);;
    $check_out_Hmin2 = $resHmin2['check_out'];
    $date_Hmin2 = $resHmin2['date'];
    $date_time_Hmin2 = strtotime($resHmin2['date']);
    $date_time_ystd = strtotime($yesterday);
    $flag_Hmin2 = $resHmin2['flag'];

    if(($sch_in_Hmin2 > $sch_out_Hmin2) && ($date_time_Hmin2 < $date_time_ystd)){
        
        $sql = "UPDATE hris_master_time_management SET attendence_code = 'CTAB' WHERE employee_id='$nik' AND date='$date_Hmin2'";
        $query = $conn->query($sql);

        if($flag_Hmin2 == 1){
            $change_log = -0.5;
        } else {
            $change_log = -1;
        }

        $total_cuti = $prevTop['total_cuti'] + $change_log;
        if($total_cuti < -6){
            $flagTME = 1;
        } else {
            $flagTME = 0;
        }
        if($total_cuti >= 0){
            $flagMinus = 0;
        } else {
            $flagMinus = 1;
        }

        $date_insert = $date_Hmin2;
        $sqlInsert = "INSERT INTO hris_time_management_employee(nik, date, tipe_perubahan, start_date, end_date, total_cuti, change_log, request_number, status, flag, minus) VALUES ('$nik', '$date_insert', '$CTAB', '$date_insert', '$date_insert', '$total_cuti', '$change_log', '-', '1', '$flagTME', '$flagMinus')";
        $stmt = $conn->query($sqlInsert);
        

        $sqlTopH2 = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
        $resultTopH2 = $conn->query($sqlTopH2);
        $prevTopH2 = mysqli_fetch_array( $resultTopH2, MYSQLI_ASSOC);
        if (empty($prevTopH2)){
            $prevTopH2['total_cuti'] = 0;
        }

        ////////////////////////////////////////////////////////////START H-1 setelah H-2///////////////////////////////////////////////////////
        
        if(strtolower(substr($res['schedule_code'], 0, 1)) == 'n'){
            $schedule_code = 'N';
        }elseif(strtolower(substr($res['schedule_code'], 0, 3)) == 'shf'){
            $schedule_code = 'SHF';
        }else{
            $schedule_code = $res['schedule_code'];
        }

        if($schedule_code == 'DO' || $schedule_code == 'DON'){
            continue;
        }

        $grade = decrypt($res['employee_group']);
        if ($grade == 'GOL A' || $grade == 'GOL B' || $grade == 'GOL C' || $nik == '20130331'){
            $company_code = decrypt($res['company_code']);
            $schedule_in = $res['schedule_in'];
            $schedule_out = $res['schedule_out'];
            
            $personnel_area = decrypt($res['personnel_area']);
            $sqlArea = "SELECT * FROM hris_master_personnel_area WHERE personnel_area = '$personnel_area' ORDER BY id DESC LIMIT 1";
            $resultArea = $conn->query($sqlArea);
            $arrArea = mysqli_fetch_array( $resultArea, MYSQLI_ASSOC);
            $lat = $arrArea['lattitude'];
            $long = $arrArea['longitude'];
            
            if (empty($res['check_in'])){
                $sqlUpdate = "UPDATE hris_master_time_management SET check_in = '$schedule_in', check_out = '$schedule_out', attendence_code = 'H', flag = 1, lat_in = '$lat', long_in = '$long', lat_out = '$lat', long_out = '$long' WHERE employee_id = '$nik' AND date ='$yesterday'";
            } else if (empty($res['check_out'])){
                $sqlUpdate = "UPDATE hris_master_time_management SET check_out = '$schedule_out', attendence_code = 'H', lat_out = '$lat', long_out = '$long' WHERE employee_id = '$nik' AND date ='$yesterday'";
            }
            $stmtUpdate = $conn->query($sqlUpdate);
            continue;
        }

        if ($schedule_code == 'CTB'){
            $sql = "UPDATE hris_master_time_management SET time_off_code = 'CT' WHERE employee_id='$nik' AND date='$yesterday'";
            $query = $conn->query($sql);

            $change_log = -1;

            $total_cutiH2 = $prevTopH2['total_cuti'] + $change_log;
            if($total_cutiH2 < -6){
                $flagTME = 1;
            } else {
                $flagTME = 0;
            }
            if($total_cutiH2 >= 0){
                $flagMinus = 0;
            } else {
                $flagMinus = 1;
            }

            $date_insert = $res['date'];
            $sqlInsert = "INSERT INTO hris_time_management_employee(nik, date, tipe_perubahan, start_date, end_date, total_cuti, change_log, request_number, status, flag, minus) VALUES ('$nik', '$date_insert', 'Cuti Bersama', '$date_insert', '$date_insert', '$total_cutiH2', '$change_log', '-', '1', '$flagTME', '$flagMinus')";
            $stmt = $conn->query($sqlInsert);

        } else {

            if ((empty($res['check_out']) || ($res['check_out'] == NULL)) && ($schedule_code == 'N' || $schedule_code == 'SHF') && ($res['time_off_code'] == '' || $res['time_off_code'] == NULL || $res['time_off_code'] == 'IDT' || $res['time_off_code'] =='IPC')){
                $sql = "UPDATE hris_master_time_management SET attendence_code = 'CTAB' WHERE employee_id='$nik' AND date='$yesterday'";
                $query = $conn->query($sql);

                if($res['flag'] == 1){
                    $change_log = -0.5;
                } else {
                    $change_log = -1;
                }

                $total_cutiH2 = $prevTopH2['total_cuti'] + $change_log;
                if($total_cutiH2 < -6){
                    $flagTME = 1;
                } else {
                    $flagTME = 0;
                }
                if($total_cutiH2 >= 0){
                    $flagMinus = 0;
                } else {
                    $flagMinus = 1;
                }

                $date_insert = $res['date'];
                $sqlInsert = "INSERT INTO hris_time_management_employee(nik, date, tipe_perubahan, start_date, end_date, total_cuti, change_log, request_number, status, flag, minus) VALUES ('$nik', '$date_insert', '$CTAB', '$date_insert', '$date_insert', '$total_cutiH2', '$change_log', '-', '1', '$flagTME', '$flagMinus')";
                $stmt = $conn->query($sqlInsert);
            }else{
                continue;
            }

        }

        ////////////////////////////////////////////////////////////END Cek H-2 dan H-1///////////////////////////////////////////////////////

    }else{

        if(strtolower(substr($res['schedule_code'], 0, 1)) == 'n'){
            $schedule_code = 'N';
        }elseif(strtolower(substr($res['schedule_code'], 0, 3)) == 'shf'){
            $schedule_code = 'SHF';
        }else{
            $schedule_code = $res['schedule_code'];
        }

        if($schedule_code == 'DO' || $schedule_code == 'DON'){
            continue;
        }

        $grade = decrypt($res['employee_group']);
        if ($grade == 'GOL A' || $grade == 'GOL B' || $grade == 'GOL C' || $nik == '20130331'){
            $company_code = decrypt($res['company_code']);
            $schedule_in = $res['schedule_in'];
            $schedule_out = $res['schedule_out'];
            
            $personnel_area = decrypt($res['personnel_area']);
            $sqlArea = "SELECT * FROM hris_master_personnel_area WHERE personnel_area = '$personnel_area' ORDER BY id DESC LIMIT 1";
            $resultArea = $conn->query($sqlArea);
            $arrArea = mysqli_fetch_array( $resultArea, MYSQLI_ASSOC);
            $lat = $arrArea['lattitude'];
            $long = $arrArea['longitude'];
            
            if (empty($res['check_in'])){
                $sqlUpdate = "UPDATE hris_master_time_management SET check_in = '$schedule_in', check_out = '$schedule_out', attendence_code = 'H', flag = 1, lat_in = '$lat', long_in = '$long', lat_out = '$lat', long_out = '$long' WHERE employee_id = '$nik' AND date ='$yesterday'";
            } else if (empty($res['check_out'])){
                $sqlUpdate = "UPDATE hris_master_time_management SET check_out = '$schedule_out', attendence_code = 'H', lat_out = '$lat', long_out = '$long' WHERE employee_id = '$nik' AND date ='$yesterday'";
            }
            $stmtUpdate = $conn->query($sqlUpdate);
            continue;
        }

        if ($schedule_code == 'CTB'){
            $sql = "UPDATE hris_master_time_management SET time_off_code = 'CT' WHERE employee_id='$nik' AND date='$yesterday'";
            $query = $conn->query($sql);

            $change_log = -1;

            $total_cuti = $prevTop['total_cuti'] + $change_log;
            if($total_cuti < -6){
                $flagTME = 1;
            } else {
                $flagTME = 0;
            }
            if($total_cuti >= 0){
                $flagMinus = 0;
            } else {
                $flagMinus = 1;
            }

            $date_insert = $res['date'];
            $sqlInsert = "INSERT INTO hris_time_management_employee(nik, date, tipe_perubahan, start_date, end_date, total_cuti, change_log, request_number, status, flag, minus) VALUES ('$nik', '$date_insert', 'Cuti Bersama', '$date_insert', '$date_insert', '$total_cuti', '$change_log', '-', '1', '$flagTME', '$flagMinus')";
            $stmt = $conn->query($sqlInsert);

        } else {

            if ((empty($res['check_out']) || ($res['check_out'] == NULL)) && ($schedule_code == 'N' || $schedule_code == 'SHF') && ($res['time_off_code'] == '' || $res['time_off_code'] == NULL || $res['time_off_code'] == 'IDT' || $res['time_off_code'] =='IPC')){
                $sql = "UPDATE hris_master_time_management SET attendence_code = 'CTAB' WHERE employee_id='$nik' AND date='$yesterday'";
                $query = $conn->query($sql);

                if($res['flag'] == 1){
                    $change_log = -0.5;
                } else {
                    $change_log = -1;
                }

                $total_cuti = $prevTop['total_cuti'] + $change_log;
                if($total_cuti < -6){
                    $flagTME = 1;
                } else {
                    $flagTME = 0;
                }
                if($total_cuti >= 0){
                    $flagMinus = 0;
                } else {
                    $flagMinus = 1;
                }

                $date_insert = $res['date'];
                $sqlInsert = "INSERT INTO hris_time_management_employee(nik, date, tipe_perubahan, start_date, end_date, total_cuti, change_log, request_number, status, flag, minus) VALUES ('$nik', '$date_insert', '$CTAB', '$date_insert', '$date_insert', '$total_cuti', '$change_log', '-', '1', '$flagTME', '$flagMinus')";
                $stmt = $conn->query($sqlInsert);
            }else{
                continue;
            }

        }

    }
    
    if ($total_cuti <= -1){
        $sqlGetEmp = "SELECT * FROM v_hris_employee_updated WHERE nik='$nik'";
        $queryGetEmp = $conn->query($sqlGetEmp);
        $resGetEmp = mysqli_fetch_array( $queryGetEmp, MYSQLI_ASSOC);

        $gender             = decrypt($resGetEmp['gender']);
        $personnel_subarea  = decrypt($resGetEmp['personnel_subarea']);
        $company_name       = decrypt($resGetEmp['company_name']);

        $mail = new PHPMailer;
        $mail->IsSMTP();  // send via SMTP
        $mail->SMTPDebug = 1;
        $mail->Host = "mail.ibsmulti.com"; // SMTP servers 172.21.1.17
        $mail->Port = 587;
        $mail->SMTPOptions = array( //allow insecure connections via the SMTPOptions
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username ="no.reply@ibsmulti.com";  // SMTP username
        $mail->Password ="2025@54321No.Reply" ; // SMTP password

        $complete_name = $res['full_name'];
        // pengirim
        $mail->From     ="";
        $mail->FromName ="Human Resources Information System";
        $mail->ClearReplyTos();
        $mail->AddReplyTo("hr.support@ibsmulti.com","HR Support");
        $mail->setFrom('no.reply@ibsmulti.com', 'Notification System HRIS - IBS'); // ubah dengan alamat email Anda
        $link_host = "$_SERVER[HTTP_HOST]";
        if($link_host != "172.19.8.84" && $link_host != "medclaim.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com" || $link_host == "172.19.8.81")){
            $mail->addAddress('luffi.utomo@ibsmulti.com');
            $mail->addCC('ditha.damayanti@ibsmulti.com');
        }else{
            // penerima
            // $emailpenerima = strtolower(decrypt($resGetEmp['email']));
            // $namapenerima = ucwords(strtolower($complete_name));
            // $mail->AddAddress($emailpenerima,$complete_name);
            // $mail->addBCC('luffi.utomo@ibsmulti.com');
            // $mail->addAddress('luffi.utomo@ibsmulti.com');
            // $mail->addCC('ditha.damayanti@ibsmulti.com');
        }

        $mail->WordWrap = 400; // set word wrap

        if ($gender == 'Male'){
            $panggil = "Bapak";
        } else {
            $panggil = "Ibu";
        }

        if ($total_cuti <= -1 AND $total_cuti >= -3){
            $isi1 = "<p>&emsp;Mohon segera melakukan pemeriksaan pencatatan data absensi kehadiran $panggil di Perusahaan $company_name, karena terdapat beberapa pencatatan data absensi karyawan $panggil $namapenerima yang masih tidak masuk/tercatat dalam pencatatan <i>record</i> absensi di <i>system HRD</i> perusahaan sebanyak minus cuti $total_cuti Hari. Adapun aturan yang akan berlaku bahwa selama tidak ada konfirmasi dari $panggil terkait sampai dengan batas 3 (Tiga) hari.</p>";
            $isi2 = "<p>&emsp;Apabila data minus cuti karyawan $panggil $namapenerima sudah melewati batas 6 hari maka melihat sanksi bahwa $panggil akan diberikan sanksi berupa: <b>Upah tidak dibayarkan sesuai hari kerja (<i>No Work No Pay</i>)</b>. Jika ada pertanyaan yang lebih lanjut bisa menghubungi bagian HRD.</p>";
        } else if ($total_cuti < -3 AND $total_cuti >= -6){
            if($personnel_subarea == 'Head Office'){
                $info = "hadir ke";
            } else {
                $info = "menghubungi";
            }
            $isi1 = "<p>&emsp;Mohon segera $info HRD untuk melakukan pemeriksaan pencatatan data absensi kehadiran $panggil di Perusahaan $company_name, karena terdapat beberapa pencatatan data absensi karyawan $panggil $namapenerima yang masih tidak masuk/tercatat dalam pencatatan <i>record</i> absensi di <i>system HRD</i> perusahaan sebanyak minus cuti $total_cuti Hari. Adapun aturan yang akan berlaku bahwa selama tidak ada konfirmasi dari $panggil terkait sampai dengan batas 3 (Tiga) hari.</p>";
            $isi2 = "<p>&emsp;Apabila data minus cuti karyawan $panggil $namapenerima sudah melewati batas 6 hari maka melihat sanksi bahwa $panggil akan diberikan sanksi berupa: <b>Upah tidak dibayarkan sesuai hari kerja (<i>No Work No Pay</i>)</b>. Jika ada pertanyaan yang lebih lanjut bisa menghubungi bagian HRD.</p>";
        } else if ($total_cuti < -6){
            $isi1 = "<p>&emsp;Sehubungan dengan pemeriksaan pencatatan data absensi kehadiran karyawan di Perusahaan $company_name, bahwa terdapat data absensi karyawan $panggil $namapenerima yang masih tidak masuk/tercatat dalam pencatatan <i>record</i> absensi di <i>system HRD</i> perusahaan.</p>";
            $isi2 = "<p>&emsp;Kami informasikan bahwa dari data absensi kehadiran $panggil $namapenerima tidak melakukan absensi di perusahaan sebanyak $total_cuti Hari. Adapun aturan yang berlaku bahwa selama tidak ada konfirmasi dari $panggil terkait sampai dengan batas 3 (Tiga) hari, maka melihat sanksi bahwa $panggil dapat diberikan sanksi berupa: <b>Upah tidak dibayarkan sesuai hari kerja (<i>No Work No Pay</i>)</b>. Jika ada pertanyaan yang lebih lanjut bisa menghubungi bagian HRD.</p>";
        }
        $mail->IsHTML(true);   
        $mail->Subject  = "Informasi Cuti Minus!";
        // $form  = "<div style='text-align: justify; text-justify: inter-word>";
        $form = "Dear $panggil <b>$namapenerima</b>,";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= $isi1;
        $form .= $isi2;
        $form .= "Demikian informasi ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "Thanks and Regards";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "HR Department";
        // $form .= "</div>";
        $mail->isHTML(true);
        $mail->Body  = $form;
        if(!$mail->Send())
        {
        $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$emailpenerima;
        }else{
        $message = "sent-HRIS";
        }
    }
}
?>