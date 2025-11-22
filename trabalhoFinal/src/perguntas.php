<?php
require_once __DIR__ . '/db.php';

function getPerguntasAtivas() {
    $pdo = getPDO();
    if (!$pdo) return [];
    $stmt = $pdo->prepare("SELECT id, texto FROM perguntas WHERE status = true ORDER BY id ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPerguntas($id) {
    $pdo = getPDO();
    if (!$pdo) return null;
    $stmt = $pdo->prepare("SELECT id, texto FROM perguntas WHERE id = :id");
    $stmt->execute(['id'=>$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
