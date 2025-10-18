<?php

define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_USER', 'postgres');
define('DB_PASS', 'postgres');
define('DB_NAME', 'local');

function getConnection() {
    $connectionString = "host=".DB_HOST." port=".DB_PORT." dbname=".DB_NAME." user=".DB_USER." password=".DB_PASS;
    $conn = pg_connect($connectionString);

    if (!$conn) {
        die("Erro ao conectar ao banco de dados.");
    }

    return $conn;
}
?>
