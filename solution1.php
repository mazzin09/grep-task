<?php
$variable = "Test";

if(isset($variable)) {
    echo "Variable is set." . "\n";
} else {
    echo "Variable is not set." . "\n";
}

$emptyVariable = "";

if(empty($emptyVariable)) {
    echo "Variable is empty." . "\n";
} else {
    echo "Variable is not empty." . "\n";
}

function square($num) {
    return $num * $num;
}

$numbers = array(1, 2, 3, 4, 5);
$squaredNumbers = array_map("square", $numbers);

echo "Original Numbers: " . implode(", ", $numbers) . "\n";
echo "Squared Numbers: " . implode(", ", $squaredNumbers);
?>
