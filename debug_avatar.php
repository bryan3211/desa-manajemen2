<?php
// Load .env
$env_path = __DIR__ . '/.env';
if (file_exists($env_path)) {
    $lines = file($env_path);
    foreach ($lines as $line) {
        if (strpos(trim($line), 'DB_') === 0 && strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Connect to MySQL
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$database = $_ENV['DB_DATABASE'] ?? 'aplikasi_ppdb_2';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, avatar, provider FROM users LIMIT 5";
$result = $conn->query($sql);

echo "=== Avatar Check ===\n\n";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} | Name: {$row['name']} | Avatar: {$row['avatar']} | Provider: {$row['provider']}\n";
    }
} else {
    echo "No users found\n";
}

$conn->close();
?>
