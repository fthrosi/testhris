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
$serverName = ", 1433"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array( "Database"=>"", "UID"=>"", "PWD"=>"");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br/>";
     echo "<br/>";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
$sql2 = "SELECT * FROM users WHERE employee_id LIKE ''";
$result2 = sqlsrv_query($conn, $sql2);
        
                
    while( $res = sqlsrv_fetch_array( $result2, SQLSRV_FETCH_ASSOC) ) {

            $full_name      = $res['full_name'];
            $email          = $res['user_email'];
            $password       = decrypt($res['password']);

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
            $mail->Password ="12345@2022No.Reply" ; // SMTP password
            // pengirim
            $mail->From     ="no.reply@ibsmulti.com";
            $mail->FromName ="Human Resources Information System";
            // penerima
            $emailpenerima = $res['user_email'];
            $namapenerima = $res['full_name'];
            $mail->AddAddress($emailpenerima,$namapenerima);
            $mail->AddBCC('tiopan.wahyudi@ibsmulti.com');
            $mail->WordWrap = 400;                              // set word wrap
            $mail->IsHTML(true);    
            $mail->Subject  = "USER ACCOUNT - Medical Reimbursment";
            $form  = "<b>Dear $full_name</b>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "Berikut informasi untuk login HRIS :";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "<pre>";
            $form .= "User Login            : $email";
            $form .= "<br/>";
            $form .= "Passcode              : $password";
            $form .= "<br/>";
            $form .= "Link HRIS             : hris.ibstower.com";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "Jika ada yang perlu ditanyakan, bisa langsung hubungi ";
            $form .= "</pre>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "<b>Thanks and Regards,</b>";
            $form .= "<br/>";
            $form .= "<b>HRIS Team</b>";
            $form .= "<br/>";
            $form .= "<br/>";
            $form .= "-Please Don't reply this mail-";
            $mail->isHTML(true);
            $mail->Body  = $form;
            if(!$mail->Send())
            {
               $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$emailpenerima;
            }else{
               $message = "sent-HRIS";
            }

    }
?>
