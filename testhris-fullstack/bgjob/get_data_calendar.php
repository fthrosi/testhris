<?php

$localhost = "localhost"; 
$username = "IBS_HRIS"; 
$password = "IBShris@2025"; 
$dbname = "IBS_HRIS_DB";
    
// create connection 
$conn = new mysqli($localhost, $username, $password, $dbname);

// check connection 
if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error);
} else {
    echo "Successfully Connected<br>";
}

$year = date('Y', strtotime('+1 year'));
$file = "/home/ftpuser/HRIS_C_$year.csv";

if (file_exists($file)) {
    echo "File tersedia<br>";
    $handle = fopen($file, "r");

    if (!$handle) {
        die("Gagal membuka file");
    }

    $flag = true;

    // cek apakah kalender tahun ini sudah ada
    $sqlCheckData = "SELECT 1 FROM hris_master_calendar WHERE date = ?";
    $stmtCheck = $conn->prepare($sqlCheckData);
    $checkDate = "$year-12-31";
    $stmtCheck->bind_param("s", $checkDate);
    $stmtCheck->execute();
    $resultCheckData = $stmtCheck->get_result();
    $rowCheckData = $resultCheckData->fetch_assoc();

    if (!empty($rowCheckData)) {
        echo "Data Kalender Tahunan sudah ada!";
        die;
    }

    // --- TRANSACTION START ---
    $conn->begin_transaction();

    try {
        // prepared statement insert
        $sqlInsert = "INSERT IGNORE INTO hris_master_calendar 
            (date, day, daily_work_schedule, dws_code, holiday_calendar) 
            VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        // baca CSV
        while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {

            if ($flag) {   // skip header row
                $flag = false;
                continue;
            }

            $date = $data[0];
            $day = $data[1];
            $dws = $data[2];
            $dws_code = $data[3];
            $holiday = str_replace("'", "", $data[4]); // clean single quotes

            // bind & execute
            $stmtInsert->bind_param("sssss", $date, $day, $dws, $dws_code, $holiday);
            $stmtInsert->execute();
        }

        // COMMIT kalau semua berhasil
        $conn->commit();
        echo "Data berhasil diinsert dan transaksi COMMIT";

    } catch (Exception $e) {

        // ROLLBACK jika terjadi error
        $conn->rollback();
        echo "Terjadi error, transaksi ROLLBACK: " . $e->getMessage();

    }

    fclose($handle);

} else {
    echo "File tidak ditemukan!";
}

$conn->close();

?>