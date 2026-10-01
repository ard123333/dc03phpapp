<?php
// Simple 3-tier demo app: PHP reads DB connection info from environment
// variables that are injected by Kubernetes (from ConfigMap + Secret).

$host = getenv('DB_HOST') ?: 'mysql-service';
$user = getenv('DB_USER') ?: 'appuser';
$pass = getenv('DB_PASSWORD') ?: '';
$db   = getenv('DB_NAME') ?: 'appdb';

echo "<h1>ABC Technologies - PHP 3-Tier App</h1>";
echo "<p>Attempting connection to MySQL host: " . htmlspecialchars($host) . "</p>";

$conn = @new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo "<p style='color:red'>DB connection failed: " . htmlspecialchars($conn->connect_error) . "</p>";
    exit;
}

echo "<p style='color:green'>Successfully connected to MySQL!</p>";

// Create a demo table if it doesn't exist and insert a hit counter row
$conn->query("CREATE TABLE IF NOT EXISTS visits (id INT AUTO_INCREMENT PRIMARY KEY, visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
$conn->query("INSERT INTO visits () VALUES ()");
$result = $conn->query("SELECT COUNT(*) AS total FROM visits");
$row = $result->fetch_assoc();

echo "<p>Total visits recorded in MySQL: " . (int)$row['total'] . "</p>";

$conn->close();
