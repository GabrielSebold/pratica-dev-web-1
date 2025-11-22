<?php
require_once __DIR__ . '/db.php';

function getDispositivos() {
    $pdo = getPDO();
    if (!$pdo) return [];
    $stmt = $pdo->prepare("SELECT id, nome FROM dispositivos WHERE status = true ORDER BY id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSetores() {
    $pdo = getPDO();
    if (!$pdo) return [];
    $stmt = $pdo->prepare("SELECT id, nome FROM setores ORDER BY id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMediaPerguntas($setor_id = null) {
    $pdo = getPDO();
    if (!$pdo) return [];
        $sql = "SELECT p.id, p.texto, AVG(a.resposta) AS avg_resposta, COUNT(a.resposta) AS count_resposta
            FROM perguntas p
            LEFT JOIN avaliacoes a ON a.pergunta_id = p.id AND (:setor_id::int IS NULL OR a.setor_id = :setor_id::int)
            GROUP BY p.id, p.texto ORDER BY p.id";
    $stmt = $pdo->prepare($sql);
    if ($setor_id === null) {
        $stmt->bindValue('setor_id', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue('setor_id', (int)$setor_id, PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeedbackRecente($limit = 20, $setor_id = null) {
    $pdo = getPDO();
    if (!$pdo) return [];

    $sub = "SELECT feedback, setor_id, dispositivo_id, MAX(created_at) AS created_at
        FROM avaliacoes
        WHERE feedback IS NOT NULL AND trim(feedback) <> '' AND (:setor_id::int IS NULL OR setor_id = :setor_id::int)
        GROUP BY feedback, setor_id, dispositivo_id
        ORDER BY created_at DESC
        LIMIT :lim";

    $sql = "SELECT t.feedback, t.created_at, s.nome AS setor, d.nome AS dispositivo
        FROM (".$sub.") t
        LEFT JOIN setores s ON t.setor_id = s.id
        LEFT JOIN dispositivos d ON t.dispositivo_id = d.id
        ORDER BY t.created_at DESC";

    $stmt = $pdo->prepare($sql);
    if ($setor_id === null) {
        $stmt->bindValue('setor_id', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue('setor_id', (int)$setor_id, PDO::PARAM_INT);
    }
    $stmt->bindValue('lim', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
