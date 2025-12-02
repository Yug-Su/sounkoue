<?php
http_response_code(200);

$status = ['status' => 'ok', 'timestamp' => time(), 'php_version' => phpversion()];

// Test database connection if configured
if (file_exists(__DIR__ . '/../.env')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
        
        if ($_ENV['DB_CONNECTION'] === 'pgsql') {
            $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};sslmode=require";
            $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 10
            ]);
            $status['database'] = 'connected';
        }
    } catch (Exception $e) {
        $status['database'] = 'failed: ' . $e->getMessage();
    }
}

echo json_encode($status);
?>