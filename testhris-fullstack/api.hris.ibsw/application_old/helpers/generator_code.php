<?php

function generating_code(){ 

$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789&#@"; 
srand((double)microtime()*1000000); 
$i = 0; 
$code = '' ; 

while ($i <= 20) { 
    $num = rand() % 33; 
    $tmp = substr($chars, $num, 1); 
    $code = $code . $tmp; 
    $i++; 
} 

return $code; 

} 