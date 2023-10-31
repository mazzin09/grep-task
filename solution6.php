<?php
function fetchDataFromGitHub($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    echo $data; // Add this line to debug
    return $data;
}

function extractData($html) {
    $dom = new DOMDocument;
    libxml_use_internal_errors(true); // Disable libxml errors and allow parsing of malformed HTML
    $dom->loadHTML($html);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);

    $data = [];
    $repos = $xpath->query('//li[contains(@class, "repo-list-item")]');

    foreach ($repos as $repo) {
        $repoName = $xpath->query('.//h3/a', $repo)[0]->textContent;
        $description = trim($xpath->query('.//p', $repo)[0]->textContent);
        $isSponsored = $xpath->query('.//a[contains(@class, "repo-sponsorship-status")]', $repo)->length > 0 ? 'yes' : 'no';
        $topicsNodeList = $xpath->query('.//div[contains(@class, "topics-row-container")]/a', $repo);
        $topics = [];
        foreach ($topicsNodeList as $topicNode) {
            $topics[] = $topicNode->textContent;
        }
        $topics = implode('|', $topics);
        $stargazers = $xpath->query('.//a[contains(@href, "/stargazers")]', $repo)[0]->textContent;
        $language = trim($xpath->query('.//span[@itemprop="programmingLanguage"]', $repo)[0]->textContent);
        $licenseNode = $xpath->query('.//span[@class="mr-3"]', $repo);
        $license = $licenseNode->length > 0 ? trim($licenseNode[0]->textContent) : 'N/A';
        $date = $xpath->query('.//relative-time', $repo)[0]->getAttribute('datetime');
        $date = date('d/m/Y', strtotime($date));
        $commitsNode = $xpath->query('.//a[contains(@href, "/commits")]', $repo);
        $commits = $commitsNode->length > 0 ? trim($commitsNode[0]->textContent) : 'N/A';

        $data[] = [
            'repo' => $repoName,
            'description' => $description,
            'is_sponsored' => $isSponsored,
            'topics' => $topics,
            'stargazers' => $stargazers,
            'language' => $language,
            'license' => $license,
            'date' => $date,
            'commits' => $commits
        ];
    }

    return $data;
}


// Main function to crawl and extract data from GitHub search results
function crawlGitHubSearchResults($baseUrl, $pages) {
    $result = [];
    for ($page = 1; $page <= $pages; $page++) {
        $url = $baseUrl . '&p=' . $page;
        $html = fetchDataFromGitHub($url);
        $result = array_merge($result, extractData($html));
    }
    return $result;
}

// URL for GitHub search results (sorted by Most stars)
$baseUrl = 'https://github.com/search?q=php&s=stars&type=repositories';

// Number of pages to crawl (first 10 pages)
$pages = 10;

// Extract data from GitHub search results
$searchResults = crawlGitHubSearchResults($baseUrl, $pages);

print_r($searchResults);die;

// Output the extracted data
echo json_encode($searchResults, JSON_PRETTY_PRINT);
?>
