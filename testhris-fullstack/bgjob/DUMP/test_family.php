<?php

$localhost = "localhost"; 
$username  = "IBS_HRIS"; 
$password  = "IBShris@2025"; 
$dbname    = "IBS_HRIS_OLD"; 
    
// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname); 
    
// check connection 
if($conn->connect_error) {
    die("connection failed : " . $conn->connect_error);
} else {
    echo "Successfully Connected<br>";
}

$sql = "SELECT * FROM hris_family_employee WHERE nik LIKE '20140132' AND seqno LIKE '8#8#####' AND family_members LIKE 'xaA#mw#c';";
$result = $conn->query($sql);

if( $result === false ) {
    die( print_r( mysqli_errors(), true));
}      
$row = mysqli_fetch_array($result);

if (empty($row[0])){

    echo "Insert Baru";

}else if(!empty($row[0])){
    
    echo "Update Lama";

}