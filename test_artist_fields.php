<?php
// Test script to verify Artist fields in database
require_once 'includes/db_connect.php';

echo "<h2>Testing Artist Fields in Database</h2>";

// Test query to check if new fields exist and have data
$query = "SELECT id, name, professional, email, influencer_category, influencer_type, 
          instagram_profile, expected_payment, work_type_preference 
          FROM clients 
          WHERE professional = 'Artist' 
          LIMIT 5";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<p style='color: red;'>Query Error: " . mysqli_error($conn) . "</p>";
    exit;
}

echo "<h3>Sample Artist Records:</h3>";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr>
        <th>ID</th>
        <th>Name</th>
        <th>Professional</th>
        <th>Email</th>
        <th>Influencer Category</th>
        <th>Influencer Type</th>
        <th>Instagram</th>
        <th>Expected Payment</th>
        <th>Work Type</th>
      </tr>";

$count = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $count++;
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['professional']) . "</td>";
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
    echo "<p>No Artist records found in database.</p>";
} else {
    echo "<p>Found $count Artist record(s).</p>";
}

// Test if columns exist
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

mysqli_close($conn);
?> 