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

$conn->begin_transaction(); // BEGIN TRANSACTION

try {

    $last_month = date("F Y", strtotime("-1 month"));
    $condition = encrypt('Leaving');
    $sqlGetEmp = "SELECT * FROM v_hris_employee_updated WHERE action!='$condition' AND nik NOT LIKE '0000%'";
    $queryGetEmp = $conn->query($sqlGetEmp);

    if (!$queryGetEmp) {
        throw new Exception("Query Employees failed: " . $conn->error);
    }    

    $date = date("Y-m-d");
    $sqlUpdateStatus = "UPDATE background_job_status SET status = 0 WHERE task_name LIKE 'hris_monthly_reminder' AND date = '$date'";
    $queryUpdateStatus = $conn->query($sqlUpdateStatus);
    if (!$queryUpdateStatus) {
        throw new Exception("Update status bgjon failed : " . $conn->error);
    }

    $conn->commit(); // COMMIT TRANSACTION   

    while($resGetEmp = mysqli_fetch_array($queryGetEmp, MYSQLI_ASSOC)){
        $mail = new PHPMailer;
        $mail->IsSMTP();  // send via SMTP
        $mail->SMTPDebug = 1;
        $mail->Host = "mail.ibsmulti.com"; // SMTP servers 172.21.1.17
        $mail->Port = 25;
        $mail->SMTPOptions = array( //allow insecure connections via the SMTPOptions
                    'tls' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username ="no.reply@ibsmulti.com";  // SMTP username
        $mail->Password = '1214#$C1k1n1.2026'; // SMTP password
        $complete_name = decrypt($resGetEmp['complete_name']);
        $company_name = decrypt($resGetEmp['company_name']);
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
            $mail->addAddress(strtolower(decrypt($resGetEmp['email'])));
            // $mail->AddBCC('luffi.utomo@ibsmulti.com');
            // $mail->AddBCC('ditha.damayanti@ibsmulti.com');
            // $mail->AddBCC('gilang.cahyo@ibsmulti.com');
            // $mail->AddBCC('abimas.dewangga@ibsmulti.com');
        }
        $mail->ClearReplyTos();
        $mail->AddReplyTo("hr.support@ibsmulti.com","HR Support");
        $mail->WordWrap = 400; // set word wrap
        $mail->IsHTML(true);   
        $mail->Subject  = "HRIS - You have a new announcement";
        $form  = "Dear Bapak / Ibu $complete_name,";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "Karyawan $company_name";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "Dengan Hormat,";
        $form .= "<br/>";
        $form .= "Mohon dapat melakukan pengecekan absensi bulan $last_month bagi masing-masing karyawan :";
        $form .= "<br/>";
        $form .= "<table>";
        $form .= "<tr style='vertical-align: top; text-align: justify'>";
        $form .= "<td>1.</td>";
        $form .= "<td>Waktu kerja normal adalah Hari Senin s.d Jumat Pukul 08.30 s/d 17.30 WIB (Istirahat pukul 12.00 s/d 13.00), waktu kerja shifting disesuaikan pengaturannya pada Department / Division Head terkait sesuai dengan ketentuan Ketenagakerjaan.</td>";
        $form .= "</tr>";
        $form .= "<tr style='vertical-align: top; text-align: justify'>";
        $form .= "<td>2.</td>";
        $form .= "<td>Karyawan yang terlambat masuk kerja atau akan meninggalkan pekerjaan sebelum waktunya wajib memberitahukan dan mendapatkan persetujuan, dengan menyertakan alasan, pada sistem aplikasi https://hris.ibsmulti.com</td>";
        $form .= "</tr>";
        $form .= "<tr style='vertical-align: top; text-align: justify'>";
        $form .= "<td>3.</td>";
        $form .= "<td>Karyawan yang tidak melakukan absensi pada waktu masuk (IN) dan waktu pulang (OUT) akan terpotong otomatis oleh sistem (cuti terpotong ½ hari apabila tidak absen salah satunya), pengajuan lupa absensi dapat diajukan dan divalidasi oleh Department/Division Head maksimal 3 tanggal setiap bulan.</td>";
        $form .= "</tr>";
        $form .= "<tr style='vertical-align: top; text-align: justify'>";
        $form .= "<td>4.</td>";
        $form .= "<td>Silahkan cek secara berkala histori absensi pada web https://hris.ibsmulti.com (cut off absensi pada sistem setiap tanggal 10 setiap bulan).</td>";
        $form .= "</tr>";
        $form .= "<tr style='vertical-align: top; text-align: justify'>";
        $form .= "<td>5.</td>";
        $form .= "<td>Pengajuan Time Off (Sakit, Izin, Cuti, Perjalanan Dinas) wajib diajukan dan mendapatkan approval atasan.</td>";
        $form .= "</tr>";
        $form .= "<tr style='vertical-align: top; text-align: justify'>";
        $form .= "<td>6.</td>";
        $form .= "<td>Mohon bantuan Leader untuk melakukan control absensi secara berkala.</td>";
        $form .= "</tr>";
        $form .= "<tr style='vertical-align: top; text-align: justify'>";
        $form .= "<td>7.</td>";
        $form .= "<td>Apabila terdapat kendala teknis pada sistem aplikasi dapat menghubungi PIC HR - PALUPI (PALUPI.UTAMI@IBSMULTI.COM).</td>";
        $form .= "</tr>";
        $form .= "</table>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "Demikian disampaikan, atas perhatiannya diucapkan terimakasih.";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "Regards,";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "<br/>";
        $form .= "HR Department";
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

} catch (Exception $e) {
    $conn->rollback(); // ROLLBACK TRANSACTION
    echo "Terjadi kesalahan: " . $e->getMessage();
}

?>