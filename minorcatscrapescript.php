<?php
$url = "https://blink.ucsd.edu/instructors/academic-info/majors/minor-codes.html";

// Initialize a cURL session
$ch = curl_init();

// Set the URL to fetch
curl_setopt($ch, CURLOPT_URL, $url);

// Set options to return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Set a valid User-Agent header to mimic a real browser
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

// Close the cURL session
curl_close($ch);

// Proceed with the rest of your code to process the $response
// Create a DOMDocument to parse the HTML
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Disable libxml errors
$dom->loadHTML($response);
libxml_clear_errors();

// Create a new DOMXPath instance
$xpath = new DOMXPath($dom);

// Find all tables
$tables = $xpath->query('//table');

$minors_info = [];

// Look for the table containing minor codes by inspecting the content
foreach ($tables as $table) {
    if (strpos($table->textContent, 'Minor') !== false) {
        $rows = $table->getElementsByTagName('tr');
        
        foreach ($rows as $row) {
            $cells = $row->getElementsByTagName('td');
            if ($cells->length > 1) {
                $minor_code = trim($cells->item(0)->textContent);
                $minor_name = trim($cells->item(1)->textContent);

                $link = $cells->item(1)->getElementsByTagName('a')->item(0);
                $minor_url = $link ? $link->getAttribute('href') : null;

                $minors_info[] = [
                    'code' => $minor_code,
                    'name' => $minor_name,
                    'url' => $minor_url
                ];
            }
        }
    }
}

// URLs to override
$override_urls = [
    "Accounting" => "https://rady.ucsd.edu/programs/undergraduate/minors/accounting-minor.html#Minor-Requirements",
    "Business Minor" => "https://rady.ucsd.edu/programs/undergraduate/minors/business-minor.html",
    "Entrepreneurship Minor" => "https://rady.ucsd.edu/programs/undergraduate/minors/entrepreneurship-minor.html",
    "Technology, Innovation and Supply Chain Minor" => "https://rady.ucsd.edu/programs/undergraduate/minors/supply-chain-minor.html",
    "Marketing Minor" => "https://rady.ucsd.edu/programs/undergraduate/minors/marketing-minor.html",
    "Finance Minor" => "https://rady.ucsd.edu/programs/undergraduate/minors/finance-minor.html",
    "African Studies" => "https://catalog.ucsd.edu/curric/AFRI.htm",
    "Philosophy of Cognitive Science" => "https://philosophy.ucsd.edu/undergraduate/cogsci.html",
    "Visual Arts (Computing)" => "https://visarts.ucsd.edu/undergrad/minor-req.html"
];

// Override the URLs where necessary
foreach ($minors_info as &$minor_info) {
    if (isset($override_urls[$minor_info['name']])) {
        $minor_info['url'] = $override_urls[$minor_info['name']];
    }
}

// Convert to CSV and save
$output_csv = "/home1/edezbcmy/public_html/website_115199d0/edezbcmy/minors_info.csv";
$fp = fopen($output_csv, 'w');
fputcsv($fp, ['code', 'name', 'url']); // Write the header

foreach ($minors_info as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

echo "CSV file has been created successfully.";
