<?php 

$localhost = "172.19.8.81"; 
$username = "glob"; 
$password = "abczyx123456"; 
$dbname = "db_hris1"; 

// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname); 
     
// check connection 
if($conn->connect_error) {
     die("connection failed : " . $conn->connect_error);
} else {
     echo "Successfully Connected<br>";
     die;
}

include '/Curl.php';
include 'phpmailer/PHPMailerAutoload.php'; 

$n = $m = 1;

function get_data_absen(){

     $today = date("Y-m-d");
     // $date = '2024-11-20';
     $params = array(
          'start_date'    => $today,
          'end_date'      => $today,
          'nik'           => ''
     );
    // $params = json_encode($params);
    
    $url = 'https://pegifoto.com/latihan/note_app/get_data_web.php';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 80);
    curl_setopt($ch, CURLOPT_TIMEOUT, 80);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    
    $result = curl_exec($ch);
    if (curl_errno($ch) !== 0) {
        print_r('Oops! cURL error when connecting to ' . $url . ': ' . curl_error($ch));die;
    }

    
     // TIME MANAGEMENT 2.0
     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
     if ($httpcode == 0){
          if ($GLOBALS['m'] <= 3) {
               $GLOBALS['m']++;
               get_data_absen();
          } else if ($GLOBALS['m'] == 4){
               sendEmail($httpcode, 'Error: Unsuccessful Attempt Getting Absen Employee Data');
               die;
          }
     } else if ($httpcode != 200) {
          sendEmail($httpcode, 'Error: Getting Absen Employee Data');
          die;
     }
     //////////////////////
     curl_close($ch);
     $result = json_decode($result, true);
     if (is_array($result) || is_object($result))
     {
          foreach($result as $key){
               $row   = array();
                   $row['id'] = $key['id'];
                   $row['nik_employee'] = $key['nik_employee'];
                   $row['in_date'] = $key['in_tanggal'];
                   $row['in_clock'] = $key['in_jam'];
                   $row['in_latitude'] = $key['in_latitude'];
                   $row['in_longitude'] = $key['in_longitude'];
                   $row['in_address'] = str_replace('"', '', $key['in_address']);
                   $row['in_datetime'] = $key['in_datetime'];
                   $row['out_latitude'] = $key['out_latitude'];
                   $row['out_longitude'] = $key['out_longitude'];
                   $row['out_address'] = str_replace('"', '', $key['out_address']);
                   $row['out_datetime'] = $key['out_datetime'];
                   $row['out_date'] = $key['out_date'];
                   $row['out_clock'] = $key['out_jam'];
               $data[] = (object)$row;
           }
           $result = json_encode($data);
          //  echo $result;
          return $result;
     }else{
          echo "error";
     }
}

function updateTM($data){
     // $localhost = "localhost"; 
     // $username = "cikini"; 
     // $password = "@C1k1n1#2022"; 
     // $dbname = "db_hris1"; 
     $localhost = "172.19.8.81"; 
     $username = "SAP-IBS"; 
     $password = "SAPibs2020"; 
     $dbname = "db_hris1"; 
     
     // create connection 
     $conn = new mysqli($localhost, $username, $password, $dbname); 
     
     // check connection 
     if($conn->connect_error) {
          die("connection failed : " . $conn->connect_error);
     } else {
          echo "Successfully Connected<br>";
          die;
     }
     
     $x = 0;
     $data = json_decode($data, true);
     // while($x < count($data)){
     foreach($data as $key){
          $nik = $key['nik_employee'];
          $date_in = $key['in_date'];
          $time_in = $key['in_clock'];
          $date_out = $key['out_date'];
          $time_out = $key['out_clock'];
          $check_in_location = $key['in_address'];
          $check_out_location = $key['out_address'];
          $date = date("Y-m-d");
          // $date = '2024-11-20';
          // $date = gmdate("Y-m-d", strtotime($time_in));
          $lat_in = $key['in_latitude'];
          $long_in = $key['in_longitude'];
          $lat_out = $key['out_latitude']; //TIME MANAGEMENT 2.0
          $long_out = $key['out_longitude']; //TIME MANAGEMENT 2.0
 
          // if ($data[$x]['id']!=0 && $data[$x]['id']!=null){
          if (!empty($lat_in)){
               $check_in =    $time_in;
               $date_in =     $date_in;
               if (!empty($time_out) && $time_out != NULL && $time_out != "NULL" && $time_out != ""){
                    $check_out     =    $time_out;
                    $date_out      =    $date_out;
                    $attendence_code ="H";
                    $check_in_location = str_replace("'", "", $check_in_location);
                    $check_out_location = str_replace("'", "", $check_out_location);
                    $sql = "UPDATE hris_master_time_management SET check_in = '$check_in', check_in_date='$date_in', check_in_location = '$check_in_location', lat_in = '$lat_in', long_in='$long_in', lat_out='$lat_out', long_out='$long_out', check_out = '$check_out', check_out_date='$date_out', check_out_location = '$check_out_location', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
               } else {
                    $attendence_code ="";
                    $date_out = "";
                    $check_out = "";
                    $check_out_location = "";
                    $check_in_location = str_replace("'", "", $check_in_location);
                    $check_out_location = str_replace("'", "", $check_out_location);
                    $sql = "UPDATE hris_master_time_management SET check_in = '$check_in', check_in_date='$date_in', check_in_location = '$check_in_location', lat_in = '$lat_in', long_in='$long_in', lat_out=NULL, long_out=NULL, check_out = NULL, check_out_date=NULL, check_out_location = '$check_out_location', attendence_code = '$attendence_code', flag = 1 WHERE employee_id = '$nik' AND date ='$date'";
               }
               $stmt = $conn->query($sql);
          } else {
               
          }
          
     }
 }

function sendEmail($http_code, $subject){
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
     $mail->addAddress('luffi.utomo@ibsmulti.com');
     $mail->addCC('ditha.damayanti@ibsmulti.com');
     
     $mail->WordWrap = 400; // set word wrap
     $mail->IsHTML(true);   
     $mail->Subject  = $subject;
     $form .= "Terjadi kesalahan dalam penarikan data absensi.";
     $form .= "<br/>";
     $form .= "Error Code: " . $http_code;
     $mail->isHTML(true);
     $mail->Body  = $form;
     if(!$mail->Send())
     {
          $value_error = "Mailer Error : " . $mail->ErrorInfo ." TO : ".$emailpenerima;
     }else{
          $message = "sent-HRIS";
     }
}

$data_absenIBS = get_data_absen();
updateTM($data_absenIBS);

?>