<?php
require_once __DIR__ . '/db.php';

function autenticarUsuario($username, $password) {
    $pdo = getPDO();
    if (!$pdo) return false;
    $stmt = $pdo->prepare("SELECT id, username, password FROM usuarios WHERE username = :u LIMIT 1");
    $stmt->execute(['u'=>$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) return false;
    return password_verify($password, $row['password']);
}
