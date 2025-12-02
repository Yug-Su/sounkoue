<?php
echo "=== Debug Database Connection ===\n";
echo "Host: " . ($_ENV['DB_HOST'] ?? 'NOT SET') . "\n";
echo "Port: " . ($_ENV['DB_PORT'] ?? 'NOT SET') . "\n";
echo "Database: " . ($_ENV['DB_DATABASE'] ?? 'NOT SET') . "\n";
echo "Username: " . ($_ENV['DB_USERNAME'] ?? 'NOT SET') . "\n";
echo "Password: " . (isset($_ENV['DB_PASSWORD']) ? '[SET]' : 'NOT SET') . "\n\n";

try {
    $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};sslmode=require";
    echo "DSN: $dsn\n";
    
    $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 30
    ]);
    
    echo "✅ PDO Connection successful!\n";
    
} catch (Exception $e) {
    echo "❌ PDO Connection failed: " . $e->getMessage() . "\n";
}