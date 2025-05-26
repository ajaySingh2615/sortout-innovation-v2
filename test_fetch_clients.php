<?php
// Test script to directly test admin/fetch_clients.php
session_start();

// Simulate admin session for testing
$_SESSION['role'] = 'admin';
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'test_admin';

echo "<h2>Testing admin/fetch_clients.php Endpoint</h2>";

// Test pending clients
echo "<h3>Testing Pending Clients:</h3>";
$pendingUrl = "admin/fetch_clients.php?status=pending&page=1";
echo "<p><strong>URL:</strong> $pendingUrl</p>";

$pendingData = file_get_contents($pendingUrl);
echo "<p><strong>Response:</strong></p>";
echo "<pre>" . htmlspecialchars($pendingData) . "</pre>";

// Test approved clients
echo "<h3>Testing Approved Clients:</h3>";
$approvedUrl = "admin/fetch_clients.php?status=approved&page=1";
echo "<p><strong>URL:</strong> $approvedUrl</p>";

$approvedData = file_get_contents($approvedUrl);
echo "<p><strong>Response:</strong></p>";
echo "<pre>" . htmlspecialchars($approvedData) . "</pre>";

// Parse and check if new fields are present
echo "<h3>Checking for New Fields in Approved Clients:</h3>";
$approvedJson = json_decode($approvedData, true);

if ($approvedJson && isset($approvedJson['clients']) && count($approvedJson['clients']) > 0) {
    $firstClient = $approvedJson['clients'][0];
    
    $newFields = ['email', 'influencer_category', 'influencer_type', 'instagram_profile', 'expected_payment', 'work_type_preference'];
    
    foreach ($newFields as $field) {
        $exists = array_key_exists($field, $firstClient);
        $value = $exists ? $firstClient[$field] : 'NOT FOUND';
        echo "<p><strong>$field:</strong> " . ($exists ? "✅ EXISTS" : "❌ MISSING") . " - Value: " . htmlspecialchars($value ?? 'NULL') . "</p>";
    }
    
    echo "<h4>Full First Client Data:</h4>";
    echo "<pre>" . htmlspecialchars(print_r($firstClient, true)) . "</pre>";
} else {
    echo "<p>No approved clients found or error in response.</p>";
}
?> 