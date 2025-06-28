<?php
$host = "srv1746.hstgr.io";
$port = 3306; 
$dbname = "u156327359_techauth";
$username = "u156327359_techauth";
$password = "@@Uyioobong155@@"; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
