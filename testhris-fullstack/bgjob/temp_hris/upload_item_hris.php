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
    $dbname = "db_hris"; 
        
    // create connection 
    $conn = new mysqli($localhost, $username, $password, $dbname); 
        
    // check connection 
    if($conn->connect_error) {
        die("connection failed : " . $conn->connect_error);
    } else {
        echo "Successfully Connected<br>";
    }

$file = "Form_item_history.csv";

if(file_exists("$file")){
	echo "File Template Item MDCR tersedia";
    echo "<br><br>";
    //die;

    //Data Employee
    $handle1= fopen("$file","r"); 
    //print_r($handle1); die;
    $flag = true;
    while(($data=fgetcsv($handle1,0,';'))!== FALSE){ 

            if($flag) { $flag = false; continue; }
            $request_id                     = $data[1];
            $tor_grandparent                = $data[2];
            $tor_parent                     = $data[3];
            $tor_child                      = $data[4];
            $jumlah_kuitansi                = $data[5];
            $total_nominal                  = $data[6];
            $penggantian                    = $data[7];
            $keterangan                     = $data[8];
            $additional                     = encrypt($data[9]);
            $docter                         = $data[10];
            $diagnosa                       = $data[11];
            $harga_kamar                    = $data[12];
            $tanggal_kuitansi               = $data[13];
            $create_date                    = $data[14];
            $employee_id                    = $data[15];

            //print_r($id_eg_prj);die;

            $sql = "INSERT INTO hris_medical_reimbursment_item (request_id, tor_grandparent, tor_parent, tor_child, jumlah_kuitansi, total_nominal_kuitansi, penggantian, keterangan, additional, docter, diagnosa, harga_kamar, tanggal_kuitansi, create_date, employee_id) VALUES ('$request_id', '$tor_grandparent', '$tor_parent', '$tor_child', '$jumlah_kuitansi', '$total_nominal', '$penggantian', '$keterangan', '$additional', '$docter', '$diagnosa', '$harga_kamar', '$tanggal_kuitansi', '$create_date', '$employee_id')";
            // var_dump($sql);
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
