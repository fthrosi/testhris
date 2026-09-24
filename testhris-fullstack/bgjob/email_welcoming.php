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

try {

   $today   = date('Ymd');
   // $today   = '20250825';
   $today   = encrypt($today);
   $condition = encrypt('Leaving');
   $sql     = "SELECT * FROM v_hris_employee_updated WHERE join_date LIKE '$today' AND action!='$condition'";
   // $result  = mysqli_query($conn, $sql);
   $result  = $conn->query($sql);

   if (!$result) {
      throw new Exception("Query Employees failed: " . $conn->error);
   }
   
   while( $res = mysqli_fetch_array($result) ) {
      // var_dump($res);die;
      $nik                    = $res['nik'];
      $complete_name_user     = decrypt($res['complete_name']);
      $user_email             = decrypt($res['email']);
      $phone_number           = decrypt($res['phone_number']);

            $mail = new PHPMailer;
            $mail->IsSMTP();  // send via SMTP
            $mail->SMTPDebug = 3;
            $mail->Host = 'mail.ibsmulti.com'; // SMTP servers 172.21.1.17
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
            $emailpenerima = "$user_email";
            $namapenerima = "$complete_name_user";
            $mail->AddAddress($emailpenerima,$namapenerima);
            // $mail->AddAddress('luffi.utomo@ibsmulti.com');
            $mail->AddBCC('luffi.utomo@ibsmulti.com');
            $mail->AddBCC('ditha.damayanti@ibsmulti.com');
            $mail->AddBCC('diana.sari@ibsmulti.com');
            $mail->AddBCC('sarah.lathifah@ibsmulti.com');
            // $mail->AddBCC('gilang.cahyo@ibsmulti.com');
            // $mail->AddBCC('abimas.dewangga@ibsmulti.com');
            // $mail->WordWrap = 400;                              // set word wrap
            $mail->IsHTML(true);    
            $mail->AddEmbeddedImage("WELCOMING_EMAIL_IMAGE.jpg", "gmbr");
            $mail->Subject  = "WELCOME ABOARD";
            // $form .= "<pre>";
            $form .= "<br/>";
            $form  = "<b>Dear $complete_name_user,</b>";
            $form .= "<p style='text-align: justify;'>";
            $form .= "We're so happy to welcome you to <b>PT Infrastruktur Bisnis Sejahtera</b>. Joining a new workplace ";
            $form .= "is a big step, and we want you to know that we're here to make your transition as smooth and ";
            $form .= "enjoyable as possible. ";
            $form .= "Over the next few days, you'll meet your team, get familiar with our work culture, and begin ";
            $form .= "settling into your role. We believe that your skills and energy will make a real difference, and ";
            $form .= "we can't wait to see you thrive.";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "Please feel free to reach out with any questions or if there's anything you need, we're always ";
            $form .= "happy to help!";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "Let's make great things happen together. Welcome aboard!";
            $form .= "<br/></p>";
            $form .= "<br/>";
            $form .= "<img src='cid:gmbr' width='85%' height='70%'>";
            // $form .= "</pre>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "<b>Warm regards,</b>";
            $form .= "<br/>";
            $form .= "<b>HR Department</b>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "-Please don't reply this mail-";
            $mail->isHTML(true);
            $mail->Body  = $form;
            if(!$mail->Send())
            {
               $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$emailpenerima;
               echo $value_error;
            }else{
               $message = "sent-MEDCLAIM";
            }
   }

   $date = date("Y-m-d");
   $sqlUpdateStatus = "UPDATE background_job_status SET status = 0 WHERE task_name LIKE 'email_welcoming' AND date = '$date'";
   $queryUpdateStatus = $conn->query($sqlUpdateStatus);
   if (!$queryUpdateStatus) {
      throw new Exception("Update status bgjon failed : " . $conn->error);
   }

    $conn->commit(); // COMMIT TRANSACTION

} catch (Exception $e) {
    $conn->rollback(); // ROLLBACK TRANSACTION
    echo "Terjadi kesalahan: " . $e->getMessage();
}