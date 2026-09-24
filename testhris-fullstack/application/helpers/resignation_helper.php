<?php

if (!function_exists('calculate_last_day')) {
    function calculate_last_day($resignationDate, $noticeMonth)
    {
        $date = new DateTime($resignationDate);

        $originalDay = (int) $date->format('d');

        // Pindah ke tanggal 1 untuk menghindari masalah
        // ketika tanggal asli adalah 29, 30, atau 31
        $date->modify('first day of this month');

        // Tambahkan notice period
        $date->modify("+{$noticeMonth} months");

        // Jumlah hari pada bulan tujuan
        $daysInTargetMonth = (int) $date->format('t');

        // Gunakan tanggal asli jika tersedia,
        // jika tidak gunakan tanggal terakhir bulan tersebut
        $targetDay = min($originalDay, $daysInTargetMonth);

        $date->setDate(
            (int) $date->format('Y'),
            (int) $date->format('m'),
            $targetDay
        );

        // Jika tanggal asli tersedia di bulan tujuan,
        // kurangi 1 hari.
        // Jika tidak tersedia, tetap di akhir bulan.
        if ($originalDay <= $daysInTargetMonth) {
            $date->modify('-1 day');
        }

        return $date->format('Y-m-d');
    }
}