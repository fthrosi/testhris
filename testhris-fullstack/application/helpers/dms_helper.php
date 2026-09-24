<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function DMStoDEC($deg,$min,$sec)
{

// Converts DMS ( Degrees / minutes / seconds ) 
// to decimal format longitude / latitude

    return $deg+((($min*60)+($sec))/3600);
}    

function DECtoDMS($coord, $st)
{
    if($st == 'lat'){
        $direction = $coord < 0 ? 'S': 'N';
    }elseif($st == 'long'){
        $direction = $coord < 0 ? 'W': 'E';
    }else{
        $direction = 'Un';
    }
    
    $coord = abs($coord);
    $deg = floor($coord);
    $coord = ($coord-$deg)*60;
    $min = floor($coord);
    //   $sec = floor(($coord-$min)*60);
    $sec = round(($coord-$min)*60,2);
    //   return array($deg, $min, $sec, $isnorth ? 'N' : 'S');
    // or if you want the string representation
    return sprintf("%d&deg;%d'%.2f\"%s", $deg, $min, $sec, $direction);
}    

function DECtoDMS2($latitude, $longitude)
{
    $latitudeDirection = $latitude < 0 ? 'S': 'N';
    $longitudeDirection = $longitude < 0 ? 'W': 'E';

    $latitudeNotation = $latitude < 0 ? '-': '';
    $longitudeNotation = $longitude < 0 ? '-': '';

    $latitudeInDegrees = floor(abs($latitude));
    $longitudeInDegrees = floor(abs($longitude));

    $latitudeDecimal = abs($latitude)-$latitudeInDegrees;
    $longitudeDecimal = abs($longitude)-$longitudeInDegrees;

    $_precision = 3;
    $latitudeMinutes = round($latitudeDecimal*60,$_precision);
    $longitudeMinutes = round($longitudeDecimal*60,$_precision);

    return sprintf('%s%s° %s %s %s%s° %s %s',
        $latitudeNotation,
        $latitudeInDegrees,
        $latitudeMinutes,
        $latitudeDirection,
        $longitudeNotation,
        $longitudeInDegrees,
        $longitudeMinutes,
        $longitudeDirection
    );

}