<?php
// Clear cache and test script
session_start();

// Simulate admin session for testing
$_SESSION['role'] = 'admin';
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'test_admin';

echo "<h2>Cache Clear and Test Script</h2>";

// Clear any potential PHP opcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "<p>✅ PHP OPcache cleared</p>";
}

// Test database connection
require_once 'includes/db_connect.php';

if ($conn->connect_error) {
    echo "<p>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit;
} else {
    echo "<p>✅ Database connection successful</p>";
}

// Test if new columns exist
echo "<h3>Column Existence Check:</h3>";
$columns = ['email', 'influencer_category', 'influencer_type', 'instagram_profile', 'expected_payment', 'work_type_preference'];

foreach ($columns as $column) {
    $checkQuery = "SELECT 1 FROM information_schema.columns 
                   WHERE table_schema = DATABASE() 
                   AND table_name = 'clients' 
                   AND column_name = '$column'";
    
    $checkResult = mysqli_query($conn, $checkQuery);
    $exists = mysqli_num_rows($checkResult) > 0;
    
    echo "<p>Column '$column': " . ($exists ? "✅ EXISTS" : "❌ MISSING") . "</p>";
}

// Test approved artists with new fields
echo "<h3>Testing Approved Artists:</h3>";
$query = "SELECT id, name, professional, email, influencer_category, influencer_type, 
          instagram_profile, expected_payment, work_type_preference 
          FROM clients 
          WHERE professional = 'Artist' AND approval_status = 'approved'
          LIMIT 3";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<p style='color: red;'>Query Error: " . mysqli_error($conn) . "</p>";
} else {
    $count = 0;
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Influencer Category</th>
            <th>Influencer Type</th>
            <th>Instagram</th>
            <th>Expected Payment</th>
            <th>Work Type</th>
          </tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['influencer_category'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['influencer_type'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['instagram_profile'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['expected_payment'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['work_type_preference'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    if ($count == 0) {
        echo "<p>No approved Artist records found.</p>";
    } else {
        echo "<p>Found $count approved Artist record(s).</p>";
    }
}

// Test the fetch_clients.php endpoint directly
echo "<h3>Testing fetch_clients.php Endpoint:</h3>";

// Create a context for the HTTP request with session cookies
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "Cookie: " . session_name() . "=" . session_id() . "\r\n"
    ]
]);

$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$fetchUrl = $baseUrl . "/admin/fetch_clients.php?status=approved&page=1";

echo "<p><strong>Testing URL:</strong> $fetchUrl</p>";

$response = file_get_contents($fetchUrl, false, $context);

if ($response === false) {
    echo "<p>❌ Failed to fetch data from endpoint</p>";
} else {
    echo "<p>✅ Successfully fetched data from endpoint</p>";
    
    $data = json_decode($response, true);
    
    if ($data && isset($data['clients']) && count($data['clients']) > 0) {
        echo "<p>Found " . count($data['clients']) . " clients in response</p>";
        
        // Check first client for new fields
        $firstClient = $data['clients'][0];
        if ($firstClient['professional'] === 'Artist') {
            echo "<h4>First Artist Client Fields:</h4>";
            foreach ($columns as $field) {
                $value = $firstClient[$field] ?? 'NOT FOUND';
                echo "<p><strong>$field:</strong> " . htmlspecialchars($value) . "</p>";
            }
        }
    } else {
        echo "<p>No clients found in response or error occurred</p>";
        echo "<p><strong>Raw response:</strong></p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
}

mysqli_close($conn);

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Clear your browser cache (Ctrl+F5 or Cmd+Shift+R)</li>";
echo "<li>Go to the admin dashboard</li>";
echo "<li>Check if the Approved Clients table now shows the new fields</li>";
echo "<li>If still not working, check the browser console for JavaScript errors</li>";
echo "</ol>";
?> 