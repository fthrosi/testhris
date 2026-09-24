<?php
include '/Curl.php';
include 'phpmailer/PHPMailerAutoload.php'; 


$serverName = "172.21.1.144, 1433"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array( "Database"=>"db_hris1", "UID"=>"ibshris", "PWD"=>"Ibstowerhris2022");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}

function get_data_absen($email, $pass){

$url = 'https://eztrack.ezsolusi.id/api/auth/presence/list/company';
$today = date("Y-m-d");
$params = array(
     'start_date'  => $today,
     'end_date'    => $today
);
$params = json_encode($params);
$get_bearer = get_token_absen($email, $pass);

$headers = [
     'Accept: application/json',
     'Content-Type: application/json',
     'Authorization: Bearer '.$get_bearer,
     // 'Authorization: Bearer d4cb0a13270fd90eb977688859b1e86fDgVVYsmQ/3UGkMYhZg3jZoQlA/wZKeE+wO8kYBDAWFobdpoIbPYxKtEDTwYqE0uZ',
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 80);
curl_setopt($ch, CURLOPT_TIMEOUT, 80);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);

// TIME MANAGEMENT 2.0
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpcode == 0){
     if ($GLOBALS['m'] <= 3) {
          $GLOBALS['m']++;
          get_data_absen($email, $pass);
     } else if ($GLOBALS['m'] == 4){
          sendEmail($httpcode, 'Error: Unsuccessful Attempt Getting EZTrack Employee Data');
          die;
     }
} else if ($httpcode != 200) {
     sendEmail($httpcode, 'Error: Getting EZTrack Employee Data');
     die;
}
//////////////////////

    if (curl_errno($ch) !== 0) {
        print_r('Oops! cURL error when connecting to ' . $url . ': ' . curl_error($ch));
    }
    curl_close($ch);
    $result = json_decode($result, true);
    if (is_array($result) || is_object($result))
    {
        foreach($result as $key){
            $row   = array();
            $row['id'] = $key['id'];
            $row['user_id'] = $key['user_id'];
            $row['nik'] = $key['nik'];
            $row['name'] = $key['name'];
            $row['position'] = $key['position'];
            $row['wfh'] = $key['wfh'];
            $row['direction'] = $key['direction'];
            $row['lat_in'] = $key['lat'];
            $row['lng_in'] = $key['lng'];
            $row['address_in'] = (!empty(($key['address']))) ? ($key['address']) : '';
            $row['created_at_in'] = $key['created_at'];
            $row['lat_out'] = (!empty(($key['lat_out']))) ? ($key['lat_out']) : '';
            $row['lng_out'] = (!empty(($key['lng_out']))) ? ($key['lng_out']) : '';
            $row['address_out'] = (!empty(($key['address_out']))) ? ($key['address_out']) : '';
            $row['created_at_out'] = (!empty(($key['created_at_out']))) ? ($key['created_at_out']) : '';

            $data[] = (object)$row;
        }
        $result = (json_decode(json_encode($data), true));
        return $result;
    }else{
        echo "error";
    }
}

function sendEmail($http_code, $subject){
    $mail = new PHPMailer;
    $mail->IsSMTP();  // send via SMTP
    $mail->SMTPDebug = 1;
    $mail->Host = "172.21.1.17"; // SMTP servers 172.21.1.17
    $mail->Port = 587;
    $mail->SMTPOptions = array( //allow insecure connections via the SMTPOptions
                   'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                   )
              );
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username ="momment@ibstower.com";  // SMTP username
    $mail->Password ="S4p1b52020&*" ; // SMTP password
    // pengirim
    $mail->From     ="momment@ibstower.com";
    $mail->FromName ="Human Resources Information System";
    // penerima
    $emailpenerima = 'luffi.utomo@ibsmulti.com';
    $namapenerima = 'HR Support';
    $mail->AddAddress($emailpenerima,$namapenerima);
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