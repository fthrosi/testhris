
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


    ////////////////////////////////////////////////////////$$$//////////////////////////////////////////////////


    $localhost = "localhost"; 
    $username = "cikini"; 
    $password = "@C1k1n1#2022"; 
    $dbname = "db_hris1"; 
     
    // create connection 
    $conn = new mysqli($localhost, $username, $password, $dbname); 
     
    // check connection 
    if($conn->connect_error) {
        die("connection failed : " . $con->connect_error);
    } else {
        echo "Successfully Connected<br>";
    }

$today1 = date('Ymd', strtotime("-1 day", strtotime(date("Y-m-d"))));
$today2 = date('dmY', strtotime("-1 day", strtotime(date("d-m-Y"))));
// $today1 = "20230120";
// $today2 = "20012023";
$file = "/home/medclaim/HRIS_1700_$today1.ZIP";
//var_dump($today2);die;
// $file = "/home/ftpuser/HRIS_20221212.ZIP";

if(file_exists("$file")){
    echo "File tersedia";
    echo "<br><br>";
    $zip = new ZipArchive();
    //var_dump($zip);
    if ($zip->open("$file") === true) {
        $zip->setPassword("IBShris@$today2");
        $zip->extractTo("/var/www/html/bgjob/temp_hris/");
        $zip->close();
        echo "File unzipped";
        echo "<br><br>";

        $file1 = "HRIS_E_1700_$today1.CSV";
        $file2 = "HRIS_F_1700_$today1.CSV";

        if(file_exists("/var/www/html/bgjob/temp_hris/$file1")){
            echo "File CSV 1 ada";
            echo "<br><br>";
        }else{
            echo "File CSV 1 tidak ada";
            echo "<br><br>";
            die;
        }
        
        if(file_exists("/var/www/html/bgjob/temp_hris/$file2")){
            echo "File CSV 2 ada";
            echo "<br><br>";
        }else{
            echo "File CSV 2 tidak ada";
            echo "<br><br>";
            die;
        }
        //Data Employee
        $handle1= fopen("/var/www/html/bgjob/temp_hris/$file1","r"); 
        $flag = true;
        while(($data=fgetcsv($handle1,0,';'))!== FALSE){ 

                $complete_name = str_replace("'","||", $data[1]);
                $complete_name_user = str_replace("'","||", $data[1]);

                $superior_name = str_replace("'","||", $data[21]);

                $depthead_name = str_replace("'","||", $data[23]);

                $divhead_name = str_replace("'","||", $data[25]);

                $director_name = str_replace("'","||", $data[27]);

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
                $emftx              = encrypt($data[31]);
                $bankn1             = encrypt($data[32]);
                $emftx1             = encrypt($data[33]);
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
                        // print_r($nik); die;

                if (empty($row[0])){
                    
                    $sql ="INSERT INTO hris_employee (nik, complete_name, start_date, action, reason_of_action, gender, birthplace, date_of_birth, religion, marital_status, join_date, permanent_address, temporary_address, phone_number, sf_phone_number, personal_email, email, no_ktp, npwp_id, bpjs_ketenagakerjaan, bpjs_kesehatan, status_ptkp, company_code, company_name, personnel_area, personnel_subarea, employee_group, employee_subgroup, cost_center, cost_center_desc, bankn, emftx, bankn1, emftx1, position, department, division, directorate, superior, superior_name, usrid_long1, rpm, rpm_name,  usrid_long5, department_head, depthead_name, usrid_long2, division_head, divhead_name, usrid_long3, director, director_name, usrid_long4) VALUES ('$nik', '$complete_name', '$start_date', '$action', '$reason_of_action', '$gender', '$birthplace', '$date_of_birth', '$religion', '$marital_status', '$join_date', '$permanent_address', '$temporary_address', '$phone_number', '$sf_phone_number', '$personal_email', '$email', '$no_ktp', '$npwp_id', '$bpjs_ketenagakerjaan', '$bpjs_kesehatan', '$status_ptkp', '$company_code', '$company_name', '$personnel_area', '$personnel_subarea', '$employee_group', '$employee_subgroup', '$cost_center', '$cost_center_desc', '$bankn', '$emftx', '$bankn1', '$emftx1', '$position', '$department', '$division', '$directorate', '$superior', '$superior_name', '$usrid_long1', '$rpm', '$rpm_name', '$usrid_long5', '$department_head', '$depthead_name', '$usrid_long2', '$division_head', '$divhead_name', '$usrid_long3', '$director', '$director_name', '$usrid_long4')";
                    $stmt = $conn->query($sql);
                    //print_r($sql);die;
                    if( $stmt === false ) {
                        die( print_r( mysqli_errors(), true));
                    }


                    /////////////////////////////////////////////////Start User HRIS/////////////////////////////////////////////////

                    $password_user = (string)(mt_rand(10000, 99999));
                    $enc_password = encrypt($password_user);
                    $sql_user = "INSERT INTO users (full_name, user_email, user_role, access_level, verification_status, phone_number, employee_id, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $params_user = array($complete_name_user, $data[16], '1', '1', '1', $data[13], $nik, $enc_password);
                    $stmt_user = sqlsrv_query( $conn, $sql_user, $params_user);

                    $full_name      = $complete_name_user;
                    $email_user     = $data[16];

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
                    // pengirim
                    $mail->From     ="";
                    $mail->FromName ="Human Resources Information System";
                    // penerima
                    $emailpenerima = $email_user;
                    $namapenerima = $full_name;
                    $mail->AddAddress($emailpenerima,$namapenerima);
                    $mail->AddBCC('tiopan.wahyudi@ibsmulti.com');
                    $mail->WordWrap = 400;                              // set word wrap
                    $mail->IsHTML(true);    
                    $mail->Subject  = "USER ACCOUNT - HRIS";
                    $form  = "<b>Dear $full_name</b>";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "Berikut informasi untuk login HRIS :";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "<pre>";
                    $form .= "User Login            : $email_user";
                    $form .= "<br/>";
                    $form .= "Passcode              : $password_user";
                    $form .= "<br/>";
                    $form .= "Link HRIS             : hris.ibstower.com";
                    $form .= "<br/>";
                    $form .= "<br/>";
                    $form .= "Jika ada yang perlu ditanyakan, bisa langsung hubungi hr.support@ibstower.com";
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

                    /////////////////////////////////////////////////End User HRIS//////////////////////////////////////////////////

                }else if(!empty($row[0])){

                    $sql2 = "SELECT * FROM hris_employee WHERE nik LIKE '$nik' ORDER BY id_employee DESC LIMIT 1";
                    $res = $conn->query($sql2);
                    //print_r($sql2);die;
                    while( $res = mysqli_fetch_array($res) ) {
                        
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

                }
            }

        //Data Family Employee
        $handle2= fopen("/var/www/html/bgjob/temp_hris/$file2","r"); 
        $flag_1 = true;

        while(($data=fgetcsv($handle2,0,';'))!== FALSE){ 
            
            if($flag_1) { $flag_1 = false; continue; }
            $complete_name      = str_replace("'","||", $data[1]);
            $member_names       = str_replace("'","||", $data[4]);
            $nik                = $data[0];
            $complete_name      = encrypt($complete_name);
            $family_members     = encrypt($data[2]);
            if((($data[2] == 'Spouse') || ($data[2] == 'Child')) && (($data[3] == '') || ($data[3] == ' '))){
                $seqno = encrypt('00');
            }else{
                $seqno = encrypt($data[3]);
            }

            $seqno              = $seqno;
            $member_names       = encrypt($member_names);
            $member_gender      = encrypt($data[5]);
            $member_birthplace  = encrypt($data[6]);
            $member_birthdate   = encrypt($data[7]);
            


            $sql = "SELECT * FROM hris_family_employee WHERE nik LIKE '$nik' AND seqno LIKE '$seqno' AND family_members LIKE '$family_members'";
                $result = $conn->query($sql);
                
                if( $result === false ) {
                    die( print_r( mysqli_errors(), true));
                }      
                $row = mysqli_fetch_array($result);
                
                if (empty($row[0])){

                    $sql="INSERT INTO hris_family_employee (nik, complete_name, family_members, seqno, member_names, member_gender, member_birthplace, member_birthdate) VALUES ('$nik', '$complete_name', '$family_members', '$seqno', '$member_names', '$member_gender', '$member_birthplace', '$member_birthdate')"; 
                    $result2 = $conn->query($sql);
                    if( $result2 === false ) {
                        die( print_r( mysqli_errors(), true));
                    }

                }else if(!empty($row[0])){
                    
                    $sql = "UPDATE hris_family_employee
                            SET family_members = '$family_members', seqno= '$seqno', member_names='$member_names', member_gender = '$member_gender', member_birthplace = '$member_birthplace', member_birthdate = '$member_birthdate'
                            WHERE nik LIKE '$nik' AND seqno LIKE '$seqno'";
                    $result3 = $conn->query($sql);
                    if( $result3 === false ) {
                        die( print_r( mysqli_errors(), true));
                    }

                }
        
        }

            $file_pointermaster = "$file";    
            $file_pointer1      = "/var/www/html/bgjob/temp_hris/$file1";
            $file_pointer2      = "/var/www/html/bgjob/temp_hris/$file2";
            if (!unlink($file_pointermaster)) { 
                echo ("File Pointermaster cannot be deleted due to an error"); 
                echo "<br><br>";
            }else{ 
                echo ("File Pointermaster has been deleted"); 
                echo "<br><br>";
            } 
            
            if (!unlink($file_pointer1)) { 
                echo ("File Pointer 1 cannot be deleted due to an error"); 
                echo "<br><br>";
            }else{ 
                echo ("File Pointer 1 has been deleted"); 
                echo "<br><br>";
            } 
            
            if (!unlink($file_pointer2)) { 
                echo ("File Pointer 2 cannot be deleted due to an error"); 
                echo "<br><br>";
            }else{ 
                echo ("File Pointer 2 has been deleted"); 
                echo "<br><br>";
            } 
    }else{
        print_r("Error");  die;
    }   
}else{
	echo "File yang di cari tidak ada !";
    echo "<br><br>";
    //die;
}
?>
