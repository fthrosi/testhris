
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

    // $file_plan = "performance_appraisal_plan.csv";
    // $file_plan = "MIGRASI_i_performance_appraisal_plan.csv";
    // $file_plan = "MIGRASI_ii_performance_appraisal_plan.csv";
    $file_plan = "MIGRASI_vi_performance_appraisal_plan.csv";

    if(file_exists("/var/www/html/bgjob/temp_hris/$file_plan")){
        echo "File PLAN ada";
        echo "<br><br>";
    }else{
        echo "File PLAN tidak ada";
        echo "<br><br>";
        die;
    }
    //Data Employee
    $handle= fopen("/var/www/html/bgjob/temp_hris/$file_plan","r"); 
    $flag = true;
    while(($data=fgetcsv($handle,0,';'))!== FALSE){ 
                if($flag) { $flag = false; continue; }
                // var_dump($data);die;
                $request_id             = $data[1];
                $objective              = encrypt($data[2]);
                $measurement            = encrypt($data[3]);
                $time                   = encrypt($data[4]);
                $unit                   = encrypt($data[5]);
                $target                 = encrypt($data[6]);
                $semester_1             = encrypt($data[7]);
                $semester_2             = encrypt($data[8]);
                $total                  = encrypt($data[9]);
                $created_by             = encrypt($data[10]);
                $created_at             = '2022-12-12'; //$data[11];
                $updated_by             = encrypt($data[12]);
                $updated_at             = '2022-12-12'; //$data[13];
                $plan_perspective       = encrypt($data[14]);
                $request_id_old         = $data[15];
                $sql = "SELECT * FROM performance_appraisal_plan WHERE request_id='".$request_id."' AND objective='".$objective."' AND measurement = '".$measurement."' AND target='".$target."'";
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
                    $sql ="INSERT INTO performance_appraisal_plan (request_id, objective, measurement, time, unit, target, semester_1, semester_2, total, created_by, created_at, updated_by, updated_at, plan_perspective, request_id_old) VALUES ('$request_id', '$objective', '$measurement', '$time', '$unit', '$target', '$semester_1', '$semester_2', '$total', '$created_by', '$created_at', '$updated_by', '$updated_at', '$plan_perspective', '$request_id_old')";
                    $stmt = $conn->query($sql);
                    if( $stmt === false ) {
                        die( print_r( mysqli_errors(), true));
                    }else{
                        echo '<br>';
                        print_r('Success Input Data '.$request_id);
                        echo '<br>';
                    }

                }else{
                    echo '<br>';
                    print_r('Already Exist '.$request_id);
                    echo '<br>';
                }
            }
?>
