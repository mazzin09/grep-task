<?php
function customFloor($number, $precision) {
    $multiplier = pow(10, $precision);
    return floor($number * $multiplier) / $multiplier;
}

// Examples
echo customFloor(2.99999, 2); 
echo "\n";
echo customFloor(199.99999, 4); 
?>
