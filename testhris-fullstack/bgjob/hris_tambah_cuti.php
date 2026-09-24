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

$localhost = "localhost"; 
$username = "IBS_HRIS"; 
$password = "IBShris@2025"; 
$dbname = "IBS_HRIS_DB"; 

// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname); 

// check connection 
if($conn->connect_error) {
    die("connection failed : " . $conn->connect_error);
} else {
    echo "Successfully Connected<br>";
}

function add_cuti($conn, $nik, $today, $join_date, $prevTop){
    // Penambahan jatah cuti karyawan

    // Validasi koneksi database
    if (!($conn instanceof mysqli)) {
        throw new Exception("Koneksi database tidak valid untuk NIK $nik");
    }

    if (date('Y-m-d', strtotime('+1 year', $join_date)) == $today){
        $penambahan = 12;
    } else if ($today > date('Y-m-d', strtotime('+1 year', $join_date))){
        $penambahan = 1;
    } else {
        return;
    }
    
    for($x=0; $x<$penambahan; $x++){
        $prevTop += 1;
    }

    if($prevTop < -6){
        $flagTME = 1;
    } else {
        $flagTME = 0;
    }
    if($prevTop >= 0){
        $flagMinus = 0;
    } else {
        $flagMinus = 1;
    }
    
    $sqlInsert = "INSERT IGNORE INTO hris_time_management_employee(nik, date, tipe_perubahan, start_date, end_date, total_cuti, change_log, request_number, status, flag, minus) VALUES ('$nik', '$today', 'Penambahan Cuti Tahunan', '$today', '$today', '$prevTop', '$penambahan', '-', '1', '$flagTME', '$flagMinus')";
    // $params = array($nik, $today, "Penambahan Cuti Tahunan", $today, $today, $prevTop, $penambahan, "-", 1, $flagTME, $flagMinus); 
    $stmt = $conn->query($sqlInsert);
    
    if (!$stmt) {
        throw new Exception("Query Insert penambahan cuti Employee $nik failed: " . $conn->error);
    }
}

$conn->begin_transaction(); // BEGIN TRANSACTION
try {
    // $today = date('Y-m-d', strtotime('2025-04-22'));
     $today = date('Y-m-d');
    //  $today = '2025-11-31';

    $condition = encrypt('Leaving');
    // $subgroup = encrypt('Outsource');
    $subgroup = encrypt('X');

    $sql = "SELECT * FROM v_hris_employee_updated WHERE action NOT LIKE '$condition' AND nik IS NOT NULL AND employee_subgroup!='$subgroup' AND nik NOT LIKE '0000%'";
    // AND nik NOT IN ('20228888','20189999','20140039','20150073','20160163','20160170','20170045','20180026','20180076','20180138','20190023','20210021','20210064','20210086','20210143','20210164','20210165','20210170','20220054','20220058','20220059','20220060','20220063','20220066','20220077','20220085','20220086','20220088','20220091','20230008','20230026','20240031','20240076','20240077')
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query Get Employee failed: " . $conn->error);
    }

    while($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        
        $nik = $res['nik'];
        
        if (!empty($res['prev_joindate'])){
            $join_date = strtotime(decrypt($res['prev_joindate']));
        } else {
            $join_date = strtotime(decrypt($res['join_date']));
        } 

        $sqlTop = "SELECT total_cuti FROM hris_time_management_employee WHERE nik = '$nik' ORDER BY id DESC LIMIT 1";
        $resultTop = $conn->query($sqlTop);
        if (!$resultTop) {
            throw new Exception("Query Get Total_Cuti Employee $nik failed: " . $conn->error);
        }

        $prevTop = mysqli_fetch_array($resultTop, MYSQLI_ASSOC);
        if (empty($prevTop)){
            $prevTop['total_cuti'] = 0;
        }

        if($nik != '20180115'){
            if ($prevTop['total_cuti'] >= 24){
                
                $sisa_cuti = $prevTop['total_cuti'] - 6;
                $sqlInsert = "INSERT IGNORE INTO hris_time_management_employee(nik, date, tipe_perubahan, start_date, end_date, total_cuti, change_log, request_number, status, flag, minus) VALUES ('$nik', '$today', 'Pemotongan Cuti Maksimum', '$today', '$today', '$sisa_cuti', '-6', '-', '1', '0', '0')";
                // $params = array($nik, $today, "Pemotongan Cuti Maksimum", $today, $today, $sisa_cuti, -6, "-", 1, 0, 0); 
                // $stmt = sqlsrv_query($conn, $sqlInsert, $params);
                $stmt = $conn->query($sqlInsert);

                if (!$stmt) {
                    throw new Exception("Query Insert Total_Cuti >= 24 for -6 Employee $nik failed: " . $conn->error);
                }
                continue;
            }
        }

        $today_day = date('d', strtotime($today));    // Ambil tanggal hari ini (e.g., '28')
        $join_day  = date('d', $join_date);           // Ambil tanggal join (e.g., '29')

        // 1. Tentukan "Tanggal Seharusnya" sistem mengeksekusi cuti untuk orang ini
        $target_day = $join_day;
        if (in_array($join_day, ['29', '30', '31'])) {
            $target_day = '28'; // Jika join date 29/30/31, paksa eksekusi di tanggal 28
        }

        // 2. Cek apakah hari ini adalah tanggal eksekusi yang tepat
        if ($today_day === $target_day) {
            
            // Jika hari ini tanggal 28 dan dia termasuk golongan 29/30/31, 
            // kita perlu cek database apakah bulan ini (atau hari ini) sudah pernah ditambahkan cuti,
            // untuk menghindari double insert jika script running beberapa kali.
            if (in_array($join_day, ['29', '30', '31'])) {
                
                // Gunakan Prepared Statement agar aman dari SQL Injection
                $sqlCekCuti = "SELECT id FROM hris_time_management_employee 
                            WHERE nik = ? AND tipe_perubahan = 'Penambahan Cuti Tahunan' AND date = ? 
                            ORDER BY id DESC LIMIT 1";
                            
                $stmt = $conn->prepare($sqlCekCuti);
                $stmt->bind_param("ss", $nik, $today); // $today di sini berasumsi format 'Y-m-d'
                $stmt->execute();
                $resultCekCuti = $stmt->get_result();
                $cekCuti = $resultCekCuti->fetch_assoc();
                
                if (empty($cekCuti)) {
                    add_cuti($conn, $nik, $today, $join_date, $prevTop['total_cuti']);
                } else {
                    continue; // Sudah pernah ditambahkan hari ini
                }
                
            } else {
                // Untuk tanggal normal (1 - 28), langsung eksekusi tanpa was-was double di tanggal yang sama
                add_cuti($conn, $nik, $today, $join_date, $prevTop['total_cuti']);
            }

        } else {
            // Jika hari ini bukan hari eksekusinya, lewati
            continue;
        }
    }

    // $date = date("Y-m-d");
    $date = $today;
    $sqlUpdateStatus = "UPDATE background_job_status SET status = 0 WHERE task_name LIKE 'hris_tambah_cuti' AND date = '$date'";

    $queryUpdateStatus = $conn->query($sqlUpdateStatus);
    if (!$queryUpdateStatus) {
        throw new Exception("Update status bgjon failed : " . $conn->error);
    }

    $conn->commit(); // COMMIT TRANSACTION    

} catch (Exception $e) {
    $conn->rollback(); // ROLLBACK TRANSACTION
    echo "Terjadi kesalahan: " . $e->getMessage();
}


// Tutup koneksi database
$conn->close();

// catatan script ini digantikan dengan script baru yang lebih efisien dan aman, terutama dalam hal validasi tanggal dan penggunaan prepared statements untuk menghindari SQL injection.

// if(date('d', $join_date) == date('d')){
        // if(date('d', $join_date) == date('d', strtotime($today))){

        //     add_cuti($conn, $nik, $today, $join_date, $prevTop['total_cuti']);

        // } else if ((date('d', strtotime($today)) == '01') && (date('d', $join_date) == '29' || date('d', $join_date) == '30' || date('d', $join_date) == '31')){
        //     $year_month = date('Y-m', strtotime('-1 month'));
        //     $day = date('d', $join_date);
        //     if((date('d', $join_date) == '29' || date('d', $join_date) == '30' || date('d', $join_date) == '31')){
        //         $full_date = $year_month . '-28';
        //     }else{
        //         $full_date = $year_month . '-' . $day;
        //     }
        //     $sqlCekCuti = "SELECT * FROM hris_time_management_employee WHERE nik = '$nik' AND tipe_perubahan = 'Penambahan Cuti Tahunan' AND date='$full_date' ORDER BY id DESC LIMIT 1";
        //     $resultCekCuti = $conn->query($sqlCekCuti);
            
        //     if (!$resultCekCuti) {
        //         throw new Exception("Query Check Cuti Employee $nik failed: " . $conn->error);
        //     }

        //     $cekCuti = mysqli_fetch_array($resultCekCuti, MYSQLI_ASSOC);
            
        //     if (empty($cekCuti)){
        //         add_cuti($conn, $nik, $today, $join_date, $prevTop['total_cuti']);
        //     } else {
        //         continue;
        //     }
        // } else {
        //     continue;
        // }
?>

