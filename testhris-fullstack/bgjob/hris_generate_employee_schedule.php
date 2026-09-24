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
    

$conn = new mysqli($localhost, $username, $password, $dbname);

// check connection 
if ($conn->connect_error) {
    die("connection failed : " . $conn->connect_error);
} else {
    echo "Successfully Connected<br>";
}

// ============== MULAI TRANSAKSI ==============
$conn->begin_transaction();

/* ==========================================================
   TAMBAHKAN UNIQUE INDEX (CEGAH DUPLIKAT employee_id + date)
   ========================================================== */
$conn->query("
    ALTER TABLE hris_master_time_management
    ADD UNIQUE KEY uniq_emp_date (employee_id, date)
");

/* ========================================================== */
$condition  = encrypt('Leaving');
$next_year  = date('Y', strtotime("+1 year"));

/* ==========================================================
   CEK TAHUN TERAKHIR DI DATABASE
   ========================================================== */
$sqlCheckYear = "SELECT YEAR(MAX(date)) AS max_year FROM hris_master_time_management";
$queryCheckYear = $conn->query($sqlCheckYear);
$resCheckYear   = mysqli_fetch_array($queryCheckYear);


if (!empty($resCheckYear)) {
    $lastDataYear = $resCheckYear['max_year'];
} else {
    $lastDataYear = '9999';
}

/* ==========================================================
   PROSES INSERT
   ========================================================== */
if ($lastDataYear != $next_year) {

    $sql = "SELECT DISTINCT 
                a.nik, 
                a.complete_name, 
                b.date, 
                b.daily_work_schedule, 
                b.dws_code, 
                b.holiday_calendar
            FROM v_hris_employee_updated a
            JOIN hris_master_calendar b
                ON b.date BETWEEN '$next_year-01-01' AND '$next_year-12-31'
            WHERE a.action NOT LIKE '$condition'
              AND a.nik NOT LIKE '0000%'";

    $query = $conn->query($sql);

    try {

        while ($res = mysqli_fetch_array($query)) {

            $nik        = trim($res['nik']);
            $check_date = $res['date'];

            /* ------------------------------------------
               CEK DATA EXIST (gunakan DATE() agar aman)
               ------------------------------------------ */
            $sqlCheck = "SELECT 1 
                         FROM hris_master_time_management 
                         WHERE employee_id = '$nik' 
                           AND DATE(date) = '$check_date'";

            $queryCheck = $conn->query($sqlCheck);
            $resCheck   = mysqli_fetch_array($queryCheck);

            if (!empty($resCheck)) {
                continue; // skip jika sudah ada
            }

            // Tentukan dws
            $dws = !empty($res['holiday_calendar']) ? 
                   $res['holiday_calendar'] : 
                   $res['daily_work_schedule'];

            $dws_code = $res['dws_code'];

            /* ------------------------------------------
               CEK SCHEDULE
               ------------------------------------------ */
            $sqlSchedule = "SELECT a.schedule_in, a.schedule_out
                            FROM hris_master_schedule AS a
                            LEFT JOIN v_hris_nik_company AS b 
                                   ON a.company_code = b.company_code
                            WHERE a.kode = '$dws_code' 
                              AND a.end_date = '9999-12-31'
                              AND b.nik = '$nik'";

            $querySchedule  = $conn->query($sqlSchedule);
            $resSchedule    = mysqli_fetch_array($querySchedule);

            $complete_name  = decrypt($res['complete_name']);
            $schedule_in    = $resSchedule['schedule_in'];
            $schedule_out   = $resSchedule['schedule_out'];

            /* ------------------------------------------
               INSERT DATA (protected by UNIQUE INDEX)
               ------------------------------------------ */
            $sqlInsert = "INSERT IGNORE INTO hris_master_time_management 
                          (employee_id, full_name, date, dws, schedule_code, schedule_in, schedule_out) 
                          VALUES 
                          ('$nik', '$complete_name', '$check_date', '$dws', 
                           '$dws_code', '$schedule_in', '$schedule_out')";

            $conn->query($sqlInsert);
        }

        // ============== COMMIT ==============
        $conn->commit();
        echo "Transaksi selesai dan COMMIT — data berhasil diproses";

    } catch (Exception $e) {

        // =========== ROLLBACK ===========
        $conn->rollback();
        echo "Transaksi gagal, ROLLBACK. Error: " . $e->getMessage();
    }

} else {
    echo "Data untuk tahun $next_year sudah ada. Tahun terakhir: $lastDataYear";
}

$conn->close();


?>