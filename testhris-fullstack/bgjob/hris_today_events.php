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

////////////////////////////// SEND BIRTHDAY AND JOIN DATE EMAIL TO EMPLOYEE //////////////////////////////
try {
        $today = date("m-d");
        $today_year = date("Y");
        $condition = encrypt('Leaving');
        // $sqlGetEmp = "SELECT * FROM v_hris_employee_updated WHERE action!='$condition' AND nik NOT LIKE '0000%' AND nik IN ('20140039','20150073','20160163','20160170','20170045','20180026','20180076','20180138','20190023','20210021','20210064','20210086','20210143','20210164','20210165','20210170','20220054','20220058','20220059','20220060','20220063','20220066','20220077','20220085','20220086','20220088','20220091','20230008','20230026','20240031','20240076','20240077')";
        $sqlGetEmp = "SELECT * FROM v_hris_employee_updated WHERE action!='mqTovi#d' AND nik NOT LIKE '0000%' AND email NOT LIKE '' AND email NOT LIKE '##8#####'";
        $queryGetEmp = $conn->query($sqlGetEmp);

        if (!$queryGetEmp) {
            throw new Exception("Query Employees failed: " . $conn->error);
        }


        while($resGetEmp = mysqli_fetch_array($queryGetEmp, MYSQLI_ASSOC)) {
            
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
            $mail->SMTPAuth     = true;     // turn on SMTP authentication
            $mail->Username     ="no.reply@ibsmulti.com";  // SMTP username
            $mail->Password     = '1214#$C1k1n1.2026';

            $birthday = date('m-d', strtotime(decrypt($resGetEmp['date_of_birth'])));
            if (!empty($resGetEmp['prev_joindate'])){
                $join_date = date('m-d', strtotime(decrypt($resGetEmp['prev_joindate'])));
            } else {
                $join_date = date('m-d', strtotime(decrypt($resGetEmp['join_date'])));
            }
            $birthday_year = date('Y', strtotime(decrypt($resGetEmp['date_of_birth'])));
            $age = $today_year - $birthday_year;
            $join_date_year = date('Y', strtotime(decrypt($resGetEmp['join_date'])));
            $anniv = $today_year - $join_date_year;
            $complete_name = decrypt($resGetEmp['complete_name']);
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
                $mail->addBCC('luffi.utomo@ibsmulti.com');
            }
            $mail->ClearReplyTos();
            $mail->AddReplyTo("hr.support@ibsmulti.com","HR Support");
            $mail->WordWrap = 400; // set word wrap
            if ($birthday == $today){ 
                $mail->IsHTML(true);   
                $mail->Subject  = "Happy Birthday from IBS!";
                $form  = "<div style='margin:auto; width: 50%; text-align: center; background-color: #282c94; color: white'>";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<h2 style='margin:5px 0'><b>Happy Birthday,</b></h2>";
                $form .= "<h2 style='margin:5px 0'><b>$complete_name</b></h2>";
                $form .= "<br/>";
                $form .= "You just turned";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<h1 style='font-size:160px'>$age</h1>";
                $form .= "Time to loosen your belt and have some cake.";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "</div>";
                $mail->isHTML(true);
                $mail->Body  = $form;
                if(!$mail->Send())
                {
                    $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".strtolower(decrypt($resGetEmp['email']));
                    echo $value_error;
                }else{
                    $message = "sent-HRIS";
                }
            }

            if ($join_date == $today){
                $mail->IsHTML(true);   
                $mail->Subject  = "Congratulations on your working anniversary from IBS!";
                $form  = "<div style='margin:auto; width:50%; text-align: center; background-color: #982434; color: white'>";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<h2 style='margin:5px 0'><b>Happy Anniversary,</b></h2>";
                $form .= "<h2 style='margin:5px 0'><b>$complete_name</b></h2>";
                $form .= "<br/>";
                $form .= "You just turned";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<h1 style='font-size:160px'>$anniv</h1>";
                $form .= "Have an amazing day and we want you to know that you are totally awesome!";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "<br/>";
                $form .= "</div>";
                $mail->isHTML(true);
                $mail->Body  = $form;
                if(!$mail->Send())
                {
                    $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".strtolower(decrypt($resGetEmp['email']));
                    echo $value_error;
                }else{
                    $message = "sent-HRIS";
                }
            }
            // break;

            $nik                = $resGetEmp['nik'];
            $nama               = ucwords(strtolower($complete_name));
            $gender             = decrypt($resGetEmp['gender']);
            $personnel_subarea  = decrypt($resGetEmp['personnel_subarea']);
            $company_name       = decrypt($resGetEmp['company_name']);

            $sqlTopTotalCuti = "SELECT * FROM hris_time_management_employee WHERE nik='$nik' ORDER BY id DESC LIMIT 1";
            $queryTopTotalCuti = $conn->query($sqlTopTotalCuti);

            if (!$queryTopTotalCuti) {
                throw new Exception("Query total cuti failed: " . $conn->error);
            }

            while ($resultTopTotalCuti = mysqli_fetch_array($queryTopTotalCuti, MYSQLI_ASSOC)){
                $total_cuti = $resultTopTotalCuti['total_cuti'];
                if (empty($resultTopTotalCuti)){
                    continue;
                } 
                if ($gender == 'Male'){
                    $panggil = "Bapak";
                } else {
                    $panggil = "Ibu";
                }

                if ($total_cuti == 23){
                    $mail->IsHTML(true);   
                    $mail->Subject  = "Sisa Cuti 23 Hari";
                    // $form  = "<div style='text-align: justify; text-justify: inter-word>";
                    $form = "<div style='margin:auto; width:50%; text-align: center; background-color: #258B2F; color: white'>";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "<h2 style='margin:5px 0'><b>Attention,</b></h2>";
                    $form .= "<h2 style='margin:5px 0'><b>$complete_name</b></h2>";
                    $form .= "<br/>";
                    $form .= "Leave Balance";
                    $form .= "<br/>";
                    $form .= "<h1 style='font-size:160px'>$total_cuti</h1>";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "Hak cuti tahunan $panggil saat ini adalah 23 hari. Apabila hak cuti sudah mencapai jumlah maksimal yaitu 24 hari, maka otomatis hak cuti $panggil akan berkurang/hangus sebanyak 6 hari.";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "</div>";
                    $mail->isHTML(true);
                    $mail->Body  = $form;
                    if(!$mail->Send())
                    {
                        $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".strtolower(decrypt($resGetEmp['email']));
                        echo $value_error;
                    }else{
                        $message = "sent-HRIS";
                    }
                }
            }   
        }
        
    $date = date("Y-m-d");
    $sqlUpdateStatus = "UPDATE background_job_status SET status = 0 WHERE task_name LIKE 'hris_today_events' AND date = '$date'";
    $queryUpdateStatus = $conn->query($sqlUpdateStatus);
    if (!$queryUpdateStatus) {
        throw new Exception("Update status bgjob failed : " . $conn->error);
    }

    $conn->commit(); // COMMIT TRANSACTION

} catch (Exception $e) {
    $conn->rollback(); // ROLLBACK TRANSACTION
    echo "Terjadi kesalahan: " . $e->getMessage();
}

?>