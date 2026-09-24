<?php
$localhost = "localhost"; 
$username = "cikini"; 
$password = "@C1k1n1#2022"; 
$dbname = "db_hris1"; 
    
// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname); 
    
// check connection 
if($conn->connect_error) {
    die("connection failed : " . $conn->connect_error);
} else {
    echo "Successfully Connected<br>";
}


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

        $nik    = '20180138';
        $today  = '2024-11-21';
        $sql = "SELECT *
				FROM
				hris_master_relokasi_sementara 
				WHERE nik LIKE '$nik' AND start_date <= '$today' AND end_date >= '$today' AND status = 1";
                $result = $conn->query($sql);
                $result = mysqli_fetch_array($result, MYSQLI_ASSOC);
		// $query = $this->db->query($sql);
		// $data = $query->result();
        // var_dump($result);
        if(!empty($result)){
            $pa = $result['pa_akhir'];
            $sql_pa = "SELECT *
				FROM
				hris_master_personnel_area 
				WHERE start_date <= '$today' AND end_date >= '$today' AND personnel_area LIKE '$pa'";
                $result_pa = $conn->query($sql_pa);
                // $result_pa = mysqli_fetch_array($result_pa, MYSQLI_ASSOC);
                while($res = mysqli_fetch_array($result_pa, MYSQLI_ASSOC)) {
                    $data = array(
                        'pa_code' => $res['pa_code'],
                        'personnel_area' => $res['personnel_area'],
                        'start_date' => $res['start_date'],
                        'end_date' => $res['end_date'],
                        'address' => $res['address'],
                        'lat' => $res['lattitude'],
                        'long' => $res['longitude'],
                        'radius' => $res['radius'],
                    );
                    $data_employee[] = $data;
                }
                // $query_pa = $this->db->query($sql_pa);
                // $data_pa = $query_pa->result();
                var_dump($data_employee);
        }else{
            $sqlEmployee = "SELECT personnel_area FROM v_hris_employee_updated WHERE nik = '$nik' ORDER BY id_employee DESC LIMIT 1";
            $resultEmp = $conn->query($sqlEmployee);
            $resPA = mysqli_fetch_array($resultEmp, MYSQLI_ASSOC);
            $pa = decrypt($resPA['personnel_area']);

            $sql_pa = "SELECT *
				FROM
				hris_master_personnel_area 
				WHERE start_date <= '$today' AND end_date >= '$today' AND personnel_area LIKE '$pa'";
                $result_pa = $conn->query($sql_pa);
                // $result_pa = mysqli_fetch_array($result_pa, MYSQLI_ASSOC);
                while($res = mysqli_fetch_array($result_pa, MYSQLI_ASSOC)) {
                    $data = array(
                        'pa_code' => $res['pa_code'],
                        'personnel_area' => $res['personnel_area'],
                        'start_date' => $res['start_date'],
                        'end_date' => $res['end_date'],
                        'address' => $res['address'],
                        'lat' => $res['lattitude'],
                        'long' => $res['longitude'],
                        'radius' => $res['radius'],
                    );
                    $data_employee[] = $data;
                };
                // $query_pa = $this->db->query($sql_pa);
                // $data_pa = $query_pa->result();
                var_dump($data_employee);
        }



?>