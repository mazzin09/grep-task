<?php
$baseURL = "https://github.com/search?q=php&type=repositories&s=stars&o=desc&p=";

$headers = array(
    'authority: github.com',
    'accept: application/json',
    'accept-language: en-US,en;q=0.8',
    'cookie: _octo=GH1.1.1795783153.1684482544; _device_id=c3df6e2064768fd14a88b78469223589; logged_in=no; preferred_color_mode=light; tz=Asia^%^2FKatmandu; _gh_sess=CTtHYf6p3xrWr79Aa^%^2FjRq^%^2FWv^%^2BbR^%^2FI2P0nPaLiNyA9^%^2BaSWmlQIlJlEL9R6lnXzbn2o^%^2BdeKB2IthcU0XQ^%^2F9fIQXuTF1tCgXVSSlGeyCqBEGqGqnhngXSecad1lZ1jlqxWBhKrgwTma30Kf39eaHoJ^%^2BFdRrpTw8Q0Nv53Df8QWsG^%^2BnIhhW7ooreSii9fwtdn9whPjbCbpuiPSeevUgm^%^2Fjn1Glwpsdfx6sJnwvgfbnRQ43SsrVTT8RZg5VhXPLUAgQm3L7vjYlp3PbIaDYgBzJPu5YRJ6v9Lr9^%^2F0Kr14RGLQabSkKcIq--TSzOdwBkiIbUg0GY--hfFdLXQkTEfrSkGObxMEVA^%^3D^%^3D"',
    'referer: https://github.com/search?q=php&type=repositories&s=stars&o=desc&p=2',
    'sec-ch-ua: "Brave";v="117", "Not;A=Brand";v="8", "Chromium";v="117"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'sec-gpc: 1',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36',
    'x-github-target: dotcom',
    'x-requested-with: XMLHttpRequest'
);

for ($page = 1; $page <= 10; $page++) {
    $url = $baseURL . $page;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Process $response (your data extraction logic here)

    // For example, you can decode the JSON response if it's in JSON format
    // $data = json_decode($response, true);

    // ... (your data processing logic here)

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }
    
    curl_close($ch);
    
    $json = json_decode($response,1);
    file_put_contents(__DIR__."/data.json",$response);
    print_r($json);
    

    echo "Data for Page $page processed successfully.\n";
}

?>
