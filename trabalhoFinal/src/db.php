<?php
require_once __DIR__ . '/../config.php';

function getPDO() {
    static $pdo = null;
    if ($pdo) return $pdo;

    $host = DB_HOST;
    $port = DB_PORT;
    $db   = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

    $dsn = "pgsql:host={$host};port={$port};dbname={$db}";
    try {
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $pdo;
    } catch (PDOException $e) {
        error_log('DB connection error: '.$e->getMessage());
        return null;
    }
}
