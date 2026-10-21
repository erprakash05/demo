<?php
// Supabase Connection Pooling (Port 6543)
$dsn = "pgsql:host=aws-0-ap-south-1.pooler.supabase.co;port=6543;dbname=postgres;sslmode=require";
$username = "postgres.auchestoiamiwvvcypkr"; // આમાં પ્રોજેક્ટ રેફરન્સ ઉમેરવો પડે છે
$password = "Skynetglobal%40123";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>