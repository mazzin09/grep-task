<?php
$email = "abc@grepsr.com";

$pattern = '/^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/';

// Perform regex match
if (preg_match($pattern, $email, $matches)) {
    // Extracted parts: username, domain, top-level domain
    $result = array($matches[1], $matches[2], $matches[3]);
    print_r($result);
} else {
    echo "Invalid email address.";
}
?>
