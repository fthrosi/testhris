<?php
////////////////////////////////////////////////////////$$$//////////////////////////////////////////////////
//echo "Test";die();

$localhost = "localhost"; 
$username = "cikini"; 
$password = "@C1k1n1#2022"; 
$dbname = "db_hris"; 
 
// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname); 
 
// check connection 
if($conn->connect_error) {
    die("connection failed : " . $con->connect_error);
} else {
    echo "Successfully Connected<br>";
}


$file = "Form_Request_history.csv";

if(file_exists("$file")){
	echo "File Template Form Request tersedia";
    echo "<br><br>";
    //die;

    //Data Employee
    $handle1= fopen("$file","r"); 
    //print_r($handle1); die;
    $flag = true;
    while(($data=fgetcsv($handle1,0,';'))!== FALSE){ 

            if($flag) { $flag = false; continue; }
            $id                 = $data[0];
            $request_number     = $data[1];
            $form_type          = $data[2];
            $employee_id        = $data[3];
            $is_status          = 3;
            $created_by         = $data[4];
            $created_at         = '2022-12-31';
            

                $sql = "INSERT INTO form_request (id, request_number, form_type, is_status, created_by, created_at, employee_id) VALUES ('$id', '$request_number', '$form_type', '$is_status', '$created_by', '$created_at', '$employee_id')";
                // $params = array($id, $request_number, $form_type, $is_status, $created_by, $created_at, $employee_id);
                // $stmt = sqlsrv_query( $conn, $sql, $params);
                $stmt = $conn->query($sql);
                if( $stmt === false ) {
                    die( print_r( mysqli_errors(), true));
                }      
    }
          
}else{
	echo "File yang di cari tidak ada !";
    die;
}
?>