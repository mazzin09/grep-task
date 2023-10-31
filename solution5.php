<?php
$products = array(
    'Home' => array(
        'Electronics & Accessories' => array(
            'items' => array(
                array(
                    'title' => 'SanDisk 256',
                    'price' => '24.45'
                ),
                array(
                    'title' => 'Jabra Wireless Headset',
                    'price' => '55.12'
                )
            )
        ),
        'Accessories' => array(
            'items' => array(
                array (
                    'title' => 'DJI OM 5 Smartphone Gimbal Stabilizer',
                    'price' => '129.99'
                ),
                array (
                    'title' => 'SAMSUNG Galaxy SmartTag',
                    'price' => '30.00'
                )
            )
        )
    )
);

function printProducts($category, $products, $path = []) {
    foreach ($products as $key => $value) {
        // Add the current category to the path
        $currentPath = array_merge($path, [$key]);
        
        if ($key === 'items') {
            // Print the title, price, and category
            foreach ($value as $item) {
                echo "Array\n(\n";
                echo "[title] => {$item['title']}\n";
                echo "[price] => {$item['price']}\n";
                echo "[category] => " . implode(" > ", $currentPath) . "\n)\n\n";
            }
        } else {
            // Recursive call to handle nested categories
            printProducts($key, $value, $currentPath);
        }
    }
}

// Start printing from the root category
printProducts('Home', $products);
?>
