<?php

function generating_code(){ 

$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789#@"; 
srand((double)microtime()*1000000); 
$i = 0; 
$code = '' ; 

while ($i <= 50) { 
    $num = rand() % 64; 
    $tmp = substr($chars, $num, 1); 
    $code = $code . $tmp; 
    $i++; 
} 

return $code; 

} 