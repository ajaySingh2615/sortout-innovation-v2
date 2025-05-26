<?php
// Test phone functionality
require 'includes/db_connect.php';

echo "<h2>Testing Phone Number Functionality</h2>";

// Test 1: Check if phone field exists in database
echo "<h3>1. Database Schema Check</h3>";
$result = mysqli_query($conn, "DESCRIBE clients");
$phoneFieldExists = false;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Field'] === 'phone') {
        $phoneFieldExists = true;
        echo "✅ Phone field exists: " . $row['Field'] . " (" . $row['Type'] . ")<br>";
        break;
    }
}
if (!$phoneFieldExists) {
    echo "❌ Phone field not found in database<br>";
}

// Test 2: Check sample data
echo "<h3>2. Sample Phone Data</h3>";
$result = mysqli_query($conn, "SELECT id, name, phone, professional FROM clients WHERE phone IS NOT NULL AND phone != '' LIMIT 5");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: {$row['id']}, Name: {$row['name']}, Phone: {$row['phone']}, Type: {$row['professional']}<br>";
    }
} else {
    echo "No clients with phone numbers found<br>";
}

// Test 3: WhatsApp link generation
echo "<h3>3. WhatsApp Link Test</h3>";
$testPhone = "9818559412";
$whatsappLink = "https://wa.me/91" . $testPhone;
echo "Test Phone: $testPhone<br>";
echo "Generated WhatsApp Link: <a href='$whatsappLink' target='_blank' style='color: green;'>$whatsappLink</a><br>";

// Test 4: Check if fetch_clients.php includes phone field
echo "<h3>4. Fetch Clients API Test</h3>";
$fetchUrl = "admin/fetch_clients.php?status=pending&page=1";
echo "Testing API endpoint: $fetchUrl<br>";

// Test 5: Insert test data if no phone numbers exist
echo "<h3>5. Test Data Creation</h3>";
$checkData = mysqli_query($conn, "SELECT COUNT(*) as count FROM clients WHERE phone IS NOT NULL AND phone != ''");
$count = mysqli_fetch_assoc($checkData)['count'];

if ($count == 0) {
    echo "No phone data found. Creating test entry...<br>";
    $insertQuery = "INSERT INTO clients (name, age, gender, professional, category, city, phone, approval_status) 
                    VALUES ('Test User', 25, 'Male', 'Artist', 'Actor', 'Mumbai', '9818559412', 'pending')";
    if (mysqli_query($conn, $insertQuery)) {
        echo "✅ Test entry created successfully<br>";
    } else {
        echo "❌ Failed to create test entry: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "✅ Found $count clients with phone numbers<br>";
}

mysqli_close($conn);
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2 { color: #333; }
h3 { color: #666; margin-top: 20px; }
</style> 