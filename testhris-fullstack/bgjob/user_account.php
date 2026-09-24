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

$conn->begin_transaction(); // BEGIN TRANSACTION
   /////////////////////////////////////////////////Start User HRIS/////////////////////////////////////////////////
try {

   $today   = date('Ymd');
   $today   = encrypt($today);
   $condition = encrypt('Leaving');
   $sql     = "SELECT * FROM v_hris_employee_updated WHERE join_date LIKE '$today' AND action!='$condition'";
   $result  = $conn->query($sql);

   if ($result === false) {

      throw new Exception("Query Employees failed: " . $conn->error);

   } elseif (!$result) {

      throw new Exception("Query Employees failed: " . $conn->error);

   } else {
      // Cek jumlah baris
      $num_rows = $result->num_rows;
      echo "Jumlah baris: " . $num_rows;

      if ($num_rows > 0) {
         
         while( $res = mysqli_fetch_array($result) ) {
            $nik                    = $res['nik'];
            $complete_name_user     = decrypt($res['complete_name']);
            $user_email             = decrypt($res['email']);
            $phone_number           = decrypt($res['phone_number']);
            // var_dump($nik);die;
            
            $password_user = (string)(mt_rand(10000, 99999));
            $enc_password = encrypt($password_user);
            // $sql_user = "INSERT INTO users (full_name, user_email, user_role, access_level, verification_status, phone_number, employee_id, password) VALUES ('$complete_name_user', '$user_email', '1', '1', '1', '$phone_number', '$nik', '$enc_password') ON DUPLICATE KEY UPDATE employee_id = VALUES(employee_id), user_email = VALUES(employee_id)";
            
            $sql_user = "INSERT INTO users (
                           full_name, user_email, user_role, access_level, 
                           verification_status, phone_number, employee_id, password
                        ) VALUES (?, ?, '1', '1', '1', ?, ?, ?)
                        ON DUPLICATE KEY UPDATE 
                           employee_id = VALUES(employee_id),
                           user_email = VALUES(user_email)";

            $stmt = $conn->prepare($sql_user);
            if (!$stmt) {
               throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("sssss", 
               $complete_name_user, 
               $user_email, 
               $phone_number, 
               $nik, 
               $enc_password
            );

            if ($stmt->execute()) {
               echo "User inserted or updated successfully.";
            } else {
               throw new Exception("Execution failed: " . $stmt->error);
            }
            $stmt->close();


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
            // pengirim
            $mail->From     ="";
            $mail->FromName ="Human Resources Information System";
            // penerima
            $emailpenerima = $user_email;
            $namapenerima = $complete_name_user;
            $mail->AddAddress($emailpenerima,$namapenerima);
            $mail->AddBCC('luffi.utomo@ibsmulti.com');
            $mail->AddBCC('ditha.damayanti@ibsmulti.com');
            $mail->IsHTML(true);    
            $mail->Subject  = "USER ACCOUNT - HRIS";
            $form  = "<b>Dear $complete_name_user,</b>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "<b>Welcome aboard!</b>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "<pre>";
            $form .= "Please find below your login credentials to access the HRIS (Human Resources Information System):";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "<b>User Login</b>              : $user_email";
            $form .= "<br/>";
            $form .= "<b>Passcode</b>                : $password_user";
            $form .= "<br/>";
            $form .= "<b>Link HRIS</b>               : hris.ibsmulti.com";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "We recommend logging in as soon as possible to ensure your information is accurate and up to date.";
            $form .= "<br/>";
            $form .= "</pre>";
            $form .= "<br/>";
            $form .= "If you have any questions or need assistance, feel free to contact us at hr.support@ibsmulti.com";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "<b>Thanks and regards,</b>";
            $form .= "<br/>";
            $form .= "<b>HRIS Team</b>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "-Please don't reply this mail-";
            $mail->isHTML(true);
            $mail->Body  = $form;
            if(!$mail->Send())
            {
               $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$emailpenerima;
            }else{
               $message = "sent-HRIS";
            }
         }

      } else {

         echo " Tidak ada data.";

      }
   }

   


   $date = date("Y-m-d");
   $sqlUpdateStatus = "UPDATE background_job_status SET status = 0 WHERE task_name LIKE 'user_account' AND date = '$date'";
   $queryUpdateStatus = $conn->query($sqlUpdateStatus);
   if (!$queryUpdateStatus) {
      echo "error";
      throw new Exception("Update status bgjon failed : " . $conn->error);
   }

   $conn->commit(); // COMMIT TRANSACTION

} catch (Exception $e) {
    $conn->rollback(); // ROLLBACK TRANSACTION
    echo "Terjadi kesalahan: " . $e->getMessage();
}
   /////////////////////////////////////////////////End User HRIS//////////////////////////////////////////////////