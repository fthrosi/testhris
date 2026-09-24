<?php

function generating_token_absen($nik)
{      
    $CI =& get_instance();
    $CI->load->helper('crypto');
    $today = date('Ymd');
    $char  = $nik."AbsenPadaTanggal".$today;
    $token = encrypt($char);
    return $token; 
} 

function generate_token($nik) {
    $secret = "RAHASIA_SUPER_STRONG";
    $timestamp = time() + 60; // expired 60 detik

    $string_to_sign = $nik . "||" . $timestamp;
    $signature = hash_hmac('sha256', $string_to_sign, $secret);

    $raw = $nik . "|_|" . $timestamp . "|_|" . $signature;
    return base64_encode($raw);
}

function validate_token($token_received) {
    $secret = "RAHASIA_SUPER_STRONG";

    $decoded = base64_decode($token_received);
    list($nik, $timestamp, $signature_received) = explode("|_|", $decoded);

    // cek timestamp
    if (time() > $timestamp) {
        return false; // token expired
    }

    $string_to_sign = $nik . "||" . $timestamp;
    $signature_check = hash_hmac('sha256', $string_to_sign, $secret);

    if ($signature_check !== $signature_received) {
        return false; // signature invalid
    }

    return $nik; // token valid → return NIK
}





function validate_token_check($token_received) {
    $secret = "RAHASIA_SUPER_STRONG";

    $decoded = base64_decode($token_received);
    list($nik, $timestamp, $signature_received) = explode("|_|", $decoded);

    // cek timestamp
    if (time() > $timestamp) {
        return time() - $timestamp; // token expired
    }

    $string_to_sign = $nik . "||" . $timestamp;
    $signature_check = hash_hmac('sha256', $string_to_sign, $secret);

    if ($signature_check !== $signature_received) {
        return $signature_check; // signature invalid
    }

    return $nik; // token valid → return NIK
}
