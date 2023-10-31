<?php

// URL to fetch JSON data
$json_url = "https://dummyjson.com/products/search?q=Laptop";

// Fetch JSON data from the URL
$json_data = file_get_contents($json_url);

// Print the raw JSON response for inspection
echo "<pre>";
echo $json_data;
echo "</pre>";

// Decode JSON data
$data = json_decode($json_data, true);

// print_r($data);die;

// Check if 'data' key exists in the JSON response
if (isset($data['products']) && is_array($data['products'])) {
    // Specify the column names
    $columns = ['Title', 'Price', 'Brand'];

    // Create a CSV file
    $csvFilePath = __DIR__.'/laptop.csv';

    $csv_file = fopen($csvFilePath, 'w');

    if (!$csv_file) {
        die("Error: Unable to create CSV file.");
    }

    // Write column headers to CSV file
    fputcsv($csv_file, $columns);

    // Iterate through laptops and write data to CSV file
    foreach ($data['products'] as $laptop) {
        $title = $laptop['title'];
        $price = $laptop['price'];
        $brand = $laptop['brand'];

        // Write laptop data to CSV file
        if (!fputcsv($csv_file, [$title, $price, $brand])) {
            die("Error: Unable to write data to CSV file.");
        }
    }

    fclose($csv_file);

    echo "CSV file created successfully at: $csvFilePath";

} else {
    echo "Error: Invalid JSON format or missing 'data' key.";
}

?>

