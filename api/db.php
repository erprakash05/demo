<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'postgres';
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

if (!$host || !$username || !$password) {
    error_log('Database environment variables are missing.');
    http_response_code(500);
    exit('Database configuration is missing.');
}

$dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Database connection failed. Please check server logs.');
}