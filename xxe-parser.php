<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XML File Parser</title>
</head>
<body>
<?php
// WARNING: This version is for demonstration purposes only

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['xmlfile'])) {
    $xmlContent = file_get_contents($_FILES['xmlfile']['tmp_name']);

    $dom = new DOMDocument();

    // Vulnerable to XXE
    $dom->loadXML($xmlContent, LIBXML_NOENT | LIBXML_DTDLOAD);

    // Parse elements from the <employee> node
    $employee = [
        'Name'  => $dom->getElementsByTagName('name')->item(0)?->nodeValue ?? 'N/A',
        'ID'    => $dom->getElementsByTagName('id')->item(0)?->nodeValue ?? 'N/A',
        'Dept'  => $dom->getElementsByTagName('dept')->item(0)?->nodeValue ?? 'N/A',
        'Email' => $dom->getElementsByTagName('email')->item(0)?->nodeValue ?? 'N/A',
    ];

    echo "<h2>Parsed Employee Record:</h2><ul>";
    foreach ($employee as $key => $value) {
        echo "<li><strong>$key:</strong> " . htmlspecialchars($value) . "</li>";
    }
    echo "</ul>";
    echo "<br><a href=\"../xxe/\">Go back</a>";
} else {
    echo "No file uploaded.";
    echo "<br><a href=\"../xxe/\">Go back</a>";
}
?>
</body>
</html>
