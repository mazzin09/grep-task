<?php
$baseURL = "https://github.com/search?q=php&type=repositories&s=stars&o=desc&p=";

function setHeaders($url)
{
    $userAgents = [
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Firefox/53.0",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Firefox/53.0",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:53.0) Gecko/20100101 Firefox/53.0",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/16.16299",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/16.16299",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Version/11.1.1 Safari/537.36",
    ];

    $headers = array(
        'authority: github.com',
        'accept: application/json',
        'accept-language: en-US,en;q=0.8',
        'user-agent:' . $userAgents[array_rand($userAgents)],
        'x-github-target: dotcom',
        'x-requested-with: XMLHttpRequest'
    );

    return $headers;
}

$fp = fopen('repositories.csv', 'a'); // Open CSV file in append mode

for ($page = 1; $page <= 10; $page++) {
    $try = 1;
    do {
        $url = $baseURL . $page;
        $headers = setHeaders($url);
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

        $json = json_decode($response, true);

        if ($json && isset($json['items'][0])) {
            $repoData = $json['items'][0];

            $data = [
                'repo' => $repoData['full_name'],
                'description' => $repoData['description'],
                'is_sponsored' => 'yes',
                'topics' => implode('|', $repoData['topics']),
                'stargazers' => $repoData['stargazers_count'],
                'language' => $repoData['language'],
                'license' => $repoData['license']['name'],
                'date' => date('d/m/Y', strtotime($repoData['created_at'])),
                'commits' => $repoData['commits'],
            ];

            fputcsv($fp, $data); // Write data to CSV

            echo "Data for Page $page processed successfully.\n";
        } else {
            echo "Failed to retrieve data from the GitHub API for page $page.\n";
        }

        $try++;
        echo("Retrying $try for page $page \n");
        sleep(10);
    } while ($json == "" && $try <= 10);
}

fclose($fp); // Close the CSV file after writing all data
echo "Data has been successfully written to 'repositories.csv' file.\n";
