<?php
function convertDateFormat($inputDate) {
    // Convert input date to timestamp
    $timestamp = strtotime($inputDate);
    
    // Convert timestamp to the desired format
    // For 'October 10 2021' to '10102021' format
    $formatA = date('mdY', $timestamp);
    
    // For '1st November 2022' to '01/11/2022' format
    $formatB = date('d/m/Y', $timestamp);
    
    return array('formatA' => $formatA, 'formatB' => $formatB);
}

// Examples
$inputDateA = 'October 10 2021';
$inputDateB = '1st November 2022';

$formattedDates = convertDateFormat($inputDateA);
echo "Original Date: $inputDateA \n";
echo "Format A: " . $formattedDates['formatA'] . "\n";

$formattedDates = convertDateFormat($inputDateB);
echo "Original Date: $inputDateB \n";
echo "Format B: " . $formattedDates['formatB'];
?>
