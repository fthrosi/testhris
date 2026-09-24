
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

    // $file_form = "form_request_pa.csv";
    // $file_form = "MIGRASI_i_form_request.csv";
    // $file_form = "MIGRASI_ii_form_request.csv";
    $file_form = "MIGRASI_vi_form_request.csv";

    if(file_exists("/var/www/html/bgjob/temp_hris/$file_form")){
        echo "File FORM ada";
        echo "<br><br>";
    }else{
        echo "File FORM tidak ada";
        echo "<br><br>";
        die;
    }
    //Data Employee
    $handle= fopen("/var/www/html/bgjob/temp_hris/$file_form","r"); 
    $flag = true;
    while(($data=fgetcsv($handle,0,';'))!== FALSE){ 
                if($flag) { $flag = false; continue; }
                // var_dump($data);die;
                $request_number         = $data[1];
                $form_type              = $data[2];
                $is_status              = 3;
                $created_by             = $data[9];
                $created_at             = '2022-12-12'; //$data[10];
                $employee_id            = $data[16];
                $sql = "SELECT * FROM form_request WHERE request_number='".$request_number."'";
                // var_dump($sql);die;
                $result = $conn->query($sql);
                        if($result === false) {
                            print_r('error1');die;
                        }else{
                            echo '<br>';
                            print_r('Success Reading Data');
                            echo '<br>';
                        }
                $row = mysqli_fetch_array($result);
                        
                if (empty($row[0])){
                    $sql ="INSERT INTO form_request (request_number, form_type, is_status, created_by, created_at, employee_id) VALUES ('$request_number', '$form_type', '$is_status', '$created_by', '$created_at', '$employee_id')";
                    $stmt = $conn->query($sql);
                    
                    if( $stmt === false ) {
                        die( print_r( mysqli_errors(), true));
                    }else{
                        echo '<br>';
                        print_r('Success Input Data '.$request_number);
                        echo '<br>';
                    }

                }else{
                    echo '<br>';
                    print_r('Already Exist '.$request_number);
                    echo '<br>';
                }
            }
?>
