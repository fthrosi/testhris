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

$conn->begin_transaction(); // BEGIN TRANSACTION

try {
    
    $yesterday = date("Y-m-d",strtotime("-1 days"));
    // $yesterday = date("Y-m-d");
    $condition = encrypt('Leaving');
    // $subgroup = encrypt('Outsource');
    $subgroup = encrypt('X');

    // $sql = "SELECT a.*, b.company_code, b.employee_group, b.personnel_area FROM hris_master_time_management a
    //         LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
    //         WHERE (a.check_out = '' OR a.check_out IS NULL) AND a.date='$yesterday' AND (a.time_off_code='' OR a.time_off_code IS NULL)
    //         AND b.action!='$condition' AND b.employee_subgroup!='$subgroup' AND b.nik NOT LIKE '0000%'";
    //         // AND a.schedule_code LIKE 'N%' AND b.action!='$condition' AND b.employee_subgroup!='$subgroup' AND b.nik NOT LIKE '0000%'";
    $sql = "SELECT a.*, b.company_code, b.employee_group, b.personnel_area 
            FROM hris_master_time_management a
            LEFT JOIN v_hris_employee_updated b ON a.employee_id = b.nik
            WHERE (a.check_out = '' OR a.check_out IS NULL) 
            AND a.date = '$yesterday' 
            AND (a.time_off_code = '' OR a.time_off_code IS NULL)
            AND (a.schedule_code LIKE 'N%')
            AND b.action != '$condition' 
            AND b.employee_subgroup != '$subgroup' 
            AND b.nik NOT LIKE '0000%'";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query Get Employee Data failed: " . $conn->error);
    }    

    $sqlCTAB = "SELECT nama FROM hris_master_time_off WHERE kode = 'CTAB'";
    $queryCTAB = $conn->query($sqlCTAB);

    if (!$queryCTAB) {
        throw new Exception("Query Get hris_master_time_off failed: " . $conn->error);
    }

    $resultCTAB = mysqli_fetch_array($queryCTAB, MYSQLI_ASSOC);
    $CTAB = $resultCTAB['nama'];

    while($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $nik = $res['employee_id'];
        $work_schedule = $res['schedule_code'];
        $schedule_code = $res['schedule_code'];
        if (empty($nik)){
            continue;
        }

        $sqlTop = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
        $resultTop = $conn->query($sqlTop);

        if (!$resultTop) {
            throw new Exception("Query Get total_cuti Employee Data failed: " . $conn->error);
        }           

        $prevTop = mysqli_fetch_array( $resultTop, MYSQLI_ASSOC);
        if (empty($prevTop)){
            $prevTop['total_cuti'] = 0;
        }

        $grade = decrypt($res['employee_group']);
        if ($grade == 'GOL A' || $grade == 'GOL B' || $grade == 'GOL C' || $nik == '20130331' || $nik == '20250004'){
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
                $sqlUpdate = "UPDATE hris_master_time_management SET check_in = '$schedule_in', check_out = '$schedule_out', attendence_code = 'H', flag = 1, lat_in = '$lat', long_in = '$long', lat_out = '$lat', long_out = '$long', working_hours_d = '9.00', working_hours_t = '09:00:00' WHERE employee_id = '$nik' AND date ='$yesterday'";
            } else if (empty($res['check_out'])){
                $sqlUpdate = "UPDATE hris_master_time_management SET check_out = '$schedule_out', attendence_code = 'H', lat_out = '$lat', long_out = '$long', working_hours_d = '9.00', working_hours_t = '09:00:00' WHERE employee_id = '$nik' AND date ='$yesterday'";
            }
            $stmtUpdate = $conn->query($sqlUpdate);
            continue;
        }
        ///////CTB : CUTI BERSAMA////////
        if ($schedule_code == 'CTB'){

                $sql = "UPDATE hris_master_time_management SET time_off_code = 'CT', working_hours_d = '9.00', working_hours_t = '09:00:00' WHERE employee_id='$nik' AND date='$yesterday'";
                $query = $conn->query($sql);

                if (!$query) {
                    throw new Exception("Query Update hris_master_time_management Data Employee $nik failed: " . $conn->error);
                }    

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
                if (!$stmt) {
                    throw new Exception("Query Insert hris_time_management_employee Data Employee $nik failed: " . $conn->error);
                }    

        } else {

                $sql = "UPDATE hris_master_time_management SET attendence_code = 'CTAB' WHERE employee_id='$nik' AND date='$yesterday'";
                $query = $conn->query($sql);
                
                if (!$query) {
                    throw new Exception("Query Update hris_master_time_management Data Employee $nik failed: " . $conn->error);
                }    

                // if($res['flag'] == 1 && strtolower(substr($res['schedule_code'], 0, 3)) != 'shf'){
                //     $change_log = -0.5;
                // } else if($res['flag'] == 1 && strtolower(substr($res['schedule_code'], 0, 3)) == 'shf'){
                //     continue;
                // } else {
                //     $change_log = -1;
                // }
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

                if (!$stmt) {
                    throw new Exception("Query Insert hris_time_management_employee Data Employee $nik failed: " . $conn->error);
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
            $mail->Password ='1214#$C1k1n1.2026'; // SMTP password

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
                $emailpenerima = strtolower(decrypt($resGetEmp['email']));
                $namapenerima = ucwords(strtolower($complete_name));
                $mail->AddAddress($emailpenerima,$complete_name);
                $mail->addBCC('luffi.utomo@ibsmulti.com');
            }

            $mail->WordWrap = 400; // set word wrap

            if ($gender == 'Male'){
                $panggil = "Bapak";
            } else {
                $panggil = "Ibu";
            }

            // if ($total_cuti <= -1 AND $total_cuti >= -3){
            if ($total_cuti == -1){
                $isi1 = "<p>&emsp;Mohon segera melakukan pemeriksaan pencatatan data absensi kehadiran $panggil di Perusahaan $company_name, karena terdapat beberapa pencatatan data absensi karyawan $panggil $namapenerima yang masih tidak masuk/tercatat dalam pencatatan <i>record</i> absensi di <i>system HRD</i> perusahaan sebanyak minus cuti $total_cuti Hari. Adapun aturan yang akan berlaku bahwa selama tidak ada konfirmasi dari $panggil terkait sampai dengan batas 3 (Tiga) hari.</p>";
                $isi2 = "<p>&emsp;Apabila data minus cuti karyawan $panggil $namapenerima sudah melewati batas 3 hari maka melihat sanksi bahwa $panggil akan diberikan sanksi berupa: <b>Upah tidak dibayarkan sesuai hari kerja (<i>No Work No Pay</i>)</b>. Jika ada pertanyaan yang lebih lanjut bisa menghubungi bagian HRD.</p>";
            // } else if ($total_cuti < -3 AND $total_cuti >= -6){
            } else if ($total_cuti < -1 AND $total_cuti >= -3){
                if($personnel_subarea == 'Head Office'){
                    $info = "hadir ke";
                } else {
                    $info = "menghubungi";
                }
                $isi1 = "<p>&emsp;Mohon segera $info HRD untuk melakukan pemeriksaan pencatatan data absensi kehadiran $panggil di Perusahaan $company_name, karena terdapat beberapa pencatatan data absensi karyawan $panggil $namapenerima yang masih tidak masuk/tercatat dalam pencatatan <i>record</i> absensi di <i>system HRD</i> perusahaan sebanyak minus cuti $total_cuti Hari. Adapun aturan yang akan berlaku bahwa selama tidak ada konfirmasi dari $panggil terkait sampai dengan batas 3 (Tiga) hari.</p>";
                $isi2 = "<p>&emsp;Apabila data minus cuti karyawan $panggil $namapenerima sudah melewati batas 3 hari maka melihat sanksi bahwa $panggil akan diberikan sanksi berupa: <b>Upah tidak dibayarkan sesuai hari kerja (<i>No Work No Pay</i>)</b>. Jika ada pertanyaan yang lebih lanjut bisa menghubungi bagian HRD.</p>";
            } else if ($total_cuti < -3){
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
            echo $value_error;
            }else{
            $message = "sent-HRIS";
            }
        }
    }

    $date = date("Y-m-d");
    $sqlUpdateStatus = "UPDATE background_job_status SET status = 0 WHERE task_name LIKE 'hris_cutoff_absen' AND date = '$date'";
    $queryUpdateStatus = $conn->query($sqlUpdateStatus);
    if (!$queryUpdateStatus) {
        throw new Exception("Update status bgjon hris_cutoff_absen failed : " . $conn->error);
    }

    $conn->commit(); // COMMIT TRANSACTION    

} catch (Exception $e) {
    $conn->rollback(); // ROLLBACK TRANSACTION
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>