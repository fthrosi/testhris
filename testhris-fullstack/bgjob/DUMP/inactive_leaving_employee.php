
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
	$key 	= "hris";
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
        
        
        
        $key="hris";
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


    $serverName = "172.21.1.144, 1433"; //serverName\instanceName, portNumber (default is 1433)
    $connectionInfo = array( "Database"=>"db_hris1", "UID"=>"ibshris", "PWD"=>"Ibstowerhris2022");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

    $sql = "SELECT * FROM v_hris_employee_updated";
    $result = sqlsrv_query($conn, $sql);
    if($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }       
    
    $date1 = date_create('2024-05-01'); 
            $date2 = date_create('2025-06-29'); 
            
            

    while( $res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
    //print_r($res); die;
        $nik                        = $res['nik'];
        $complete_name              = $res['complete_name'];
        $start_date                 = $res['start_date'];
        $action                     = $res['action'];
        $reason_of_action           = $res['reason_of_action'];
        

        if ($action == encrypt('Leaving')){
            /////////////////////////////////UPDATE USERS INACTIVE///////////////////////////////////////
            $today                   = date_create(date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d")))));
            $tgl_action              = DateTime::createFromFormat('Ymd', decrypt($start_date));
            $tgl_action              = date_create($tgl_action->format('Y-m-d'));
            // $diff                    = abs(strtotime($today) - strtotime($tgl_action));
            // $diff_day            	 = round($diff / (60 * 60 * 24));

            $interval = date_diff($tgl_action, $today); 
            // var_dump($interval->m);die();
            // echo $nik . "Selisih: " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";

            /////menghitung jarak karyawan leaving selama durasi 1 Bulan setelah lebih dari 1 Bulan Leaving akan di non aktifkan//////
            if(($interval->m >= 1)){
                if ($interval->y >=1) {
                    $sql_users = "UPDATE users SET is_active = 0 WHERE employee_id LIKE '$nik'";
                    $sql_users = sqlsrv_query( $conn, $sql_users);
                    if( $sql_users === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    echo $nik." - Inactive <br>";
                }else{
                    $sql_users = "UPDATE users SET is_active = 0 WHERE employee_id LIKE '$nik'";
                    $sql_users = sqlsrv_query( $conn, $sql_users);
                    if( $sql_users === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    echo $nik." - Inactive <br>";
                }
            }else{
                if ($interval->y >=1) {
                    $sql_users = "UPDATE users SET is_active = 0 WHERE employee_id LIKE '$nik'";
                    $sql_users = sqlsrv_query( $conn, $sql_users);
                    if( $sql_users === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    echo $nik." - Inactive <br>";
                }else{
                    echo $nik." - Active <br>";
                }
            }

            
            /////menghitung jarak karyawan leaving selama durasi 30 hari setelah lebih dari 30 hari akan di non aktifkan//////
            // if($diff_day > 30){
            //     $sql_users = "UPDATE users SET is_active = 0 WHERE employee_id LIKE '$nik'";
            //     $sql_users = sqlsrv_query( $conn, $sql_users);
            //     if( $sql_users === false ) {
            //         die( print_r( sqlsrv_errors(), true));
            //     }
            // }

        }
    }

?>
