<?php
$DB = [
  'host' => 'localhost',
  'port' => 5432,
  'dbname' => 'avaliacoesdb',
  'user' => 'postgres',
  'pass' => 'postgres'
];

$dsn = "pgsql:host={$DB['host']};port={$DB['port']};dbname={$DB['dbname']};";
try {
    $pdo = new PDO($dsn, $DB['user'], $DB['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erro de conexão com o banco: " . $e->getMessage());
}
