<?php

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

    


require 'phpmailer/PHPMailerAutoload.php';
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

    $data_all = array();
    $data_part = array();

    $sql2 = "SELECT nik FROM v_hris_employee_updated WHERE nik NOT IN ('20130065','20050001','20189999','20228888') AND nik NOT LIKE '%SPN%' AND action != '".encrypt('Leaving')."' AND division != '".encrypt('HR SUPPORT')."' ORDER BY department ASC";
    $result2 = $conn->query($sql2);

    if (!$result2) {
        throw new Exception("Query Get NIK failed: " . $conn->error);
    }    

    while( $res2 = mysqli_fetch_array($result2, MYSQLI_ASSOC) ) {
        // echo json_encode($res2);

        $sql3 = "SELECT a.id, a.nik, b.complete_name, a.total_cuti, b.department, b.depthead_name, b.usrid_long2, b.division, b.divhead_name, b.usrid_long3, b.directorate, b.director_name, b.usrid_long4 FROM hris_time_management_employee a INNER JOIN v_hris_employee_updated AS b ON a.nik = b.nik WHERE a.nik = '".$res2['nik']."' ORDER BY a.id DESC LIMIT 1";
        $result3 = $conn->query($sql3);

        if (!$result3) {
            throw new Exception("Query Get Employee Data failed: " . $conn->error);
        }    
        
        while( $res3 = mysqli_fetch_array($result3, MYSQLI_ASSOC) ) {
            // if($res3['total_cuti'] <= -6)  {
            if($res3['total_cuti'] <= -3)  {
                if(!empty($res3['usrid_long2'])){
                    $part       = decrypt($res3['department']);
                    $head_name  = decrypt($res3['depthead_name']);
                    $head_email = decrypt($res3['usrid_long2']);
                }elseif(!empty($res3['usrid_long3'])){
                    $part       = decrypt($res3['division']);
                    $head_name  = decrypt($res3['divhead_name']);
                    $head_email = decrypt($res3['usrid_long3']);
                }elseif(!empty($res3['usrid_long4'])){
                    $part       = decrypt($res3['directorate']);
                    $head_name  = decrypt($res3['director_name']);
                    $head_email = decrypt($res3['usrid_long4']);
                }
                $data = [
                    'id'            => $res3['id'],
                    'nik'           => $res3['nik'],
                    'complete_name' => decrypt($res3['complete_name']),
                    'total_cuti'    => $res3['total_cuti'],
                    'part'          => $part,
                    'head_name'     => $head_name,
                    'head_email'    => $head_email
                ];
                array_push($data_all, $data);
                array_push($data_part, $part);
            }
            
        }

    }
    $data_part = array_unique($data_part);

    foreach ($data_part as $key => $value_part) {
        foreach ($data_all as $key => $value) {
            if($value['part'] == $value_part){
                $head_name   = $value['head_name'];
                $head_email  = $value['head_email'];
                if($head_email == 'makmur@ibsmulti.com' || $head_email == 'MAKMUR@IBSMULTI.COM' || $head_email == 'FARIDA@IBSMULTI.COM' || $head_email == 'farida@ibsmulti.com'){
					$head_email = 'ANANDHA.HOKKY@IBSMULTI.COM';
					$head_name 	= 'ANANDA HANDOKO HOKKY';
				}else{
                    $head_name   = $value['head_name'];
                    $head_email  = $value['head_email'];
				}
            }
        }

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
        $mail->Password = '1214#$C1k1n1.2026'; // SMTP password
        // pengirim
        $mail->From     ="";
        $mail->FromName ="Human Resources Information System";
        // penerima
        $mail->setFrom('no.reply@ibsmulti.com', 'Notification System HRIS - IBS'); // ubah dengan alamat email Anda
        $link_host = "$_SERVER[HTTP_HOST]";
        if($link_host != "172.19.8.84" && $link_host != "medclaim.ibsmulti.com" && ($link_host == "rnd.ibsmulti.com" || $link_host == "devhris.ibsmulti.com")){
            $mail->addAddress('luffi.utomo@ibsmulti.com');
            $mail->addCC('ditha.damayanti@ibsmulti.com');
        }else{
            if(($head_email == 'MAKMUR@IBSMULTI.COM' || $head_email == 'makmur@ibsmulti.com' || $head_email == 'FARIDA@IBSMULTI.COM' || $head_email == 'farida@ibsmulti.com')){
                $mail->addAddress($head_email);
                $mail->addBCC('gilang.cahyo@ibsmulti.com');  
                $mail->addBCC('hr.support@ibsmulti.com');
                $mail->addBCC('DIRIYANTI.SARI@IBSMULTI.COM');
                $mail->addBCC('PALUPI.UTAMI@IBSMULTI.COM');
            }else{
                $mail->addAddress($head_email);
                $mail->addBCC('gilang.cahyo@ibsmulti.com');
                $mail->addBCC('hr.support@ibsmulti.com');
                $mail->addBCC('DIRIYANTI.SARI@IBSMULTI.COM');
                $mail->addBCC('PALUPI.UTAMI@IBSMULTI.COM');
            }
            $mail->addBCC('luffi.utomo@ibsmulti.com');
            $mail->addBCC('ditha.damayanti@ibsmulti.com');
        }
        $mail->WordWrap = 400;                              // set word wrap
        $mail->IsHTML(true);    
        $mail->Subject  = "HRIS - Informasi Cuti Minus";
        $form  = "Dear <b>$head_name</b>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "Sehubungan dengan pemeriksaan pencatatan data absensi kehadiran karyawan di Perusahaan PT. INFRASTRUKTUR BISNIS SEJAHTERA, bahwa terdapat data absensi dari anggota tim Bapak/Ibu yang memiliki kuota cuti kurang dari/sama dengan -3, dengan detail sebagai berikut :";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<b>$value_part</b>";
        $form .= "<br/>";
        $form .= "<table class='table' width='100%' border=1>
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Employee Name</th>
                            <th>Leave Balance</th>
                        </tr>
                    </thead>
                    <tbody>";
                        foreach ($data_all as $key => $value) {
                            if($value['part'] == $value_part){
                                $form .= "<tr>
                                    <td>".$value['nik']."</td>
                                    <td>".$value['complete_name']."</td>
                                    <td>".$value['total_cuti']."</td>
                                </tr>";
                                }
                            }
        $form .="</tbody></table> <br><br>";
        $form .= "Adapun aturan yang berlaku bahwa selama tidak ada konfirmasi dari karyawan tersebut sampai dengan batas 3 (Tiga) hari, maka karyawan dapat diberikan sanksi berupa: Upah tidak dibayarkan sesuai hari kerja (No Work No Pay). Jika ada pertanyaan yang lebih lanjut bisa menghubungi tim HR Department. ";
        $form .= "<br/>";
        $form .= "Demikian informasi ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih. ";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<b>Thanks and Regards,</b>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<b>HR Department</b>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "-Please Don't reply this mail-";
        $mail->isHTML(true);
        $mail->Body  = $form;
        if(!$mail->Send())
        {
            $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$head_email;
            echo $value_error;
        }else{
            $message = "sent-HRIS";
        }
    }

    $date = date("Y-m-d");
    $sqlUpdateStatus = "UPDATE background_job_status SET status = 0 WHERE task_name LIKE 'absen_minus_blast' AND date = '$date'";
    $queryUpdateStatus = $conn->query($sqlUpdateStatus);
    if (!$queryUpdateStatus) {
        throw new Exception("Update status bgjon failed : " . $conn->error);
    }

    $conn->commit(); // COMMIT TRANSACTION    

} catch (Exception $e) {
    $conn->rollback(); // ROLLBACK TRANSACTION
    echo "Terjadi kesalahan: " . $e->getMessage();
}
    
?>
