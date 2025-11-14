<?php
require 'config.php';

$notas = $_POST['nota'] ?? [];
$textos = $_POST['texto'] ?? [];

try {
    $pdo->beginTransaction();

    $st = $pdo->prepare("INSERT INTO avaliacoes DEFAULT VALUES RETURNING id");
    $st->execute();
    $avaliacao_id = $st->fetchColumn();

    $ids = array_unique(array_merge(array_keys($notas), array_keys($textos)));
    $pergunta_textos = [];
    if (count($ids) > 0) {
        $ids_int = array_map('intval', $ids);
        $in = implode(',', $ids_int);
        $stmtP = $pdo->query("SELECT id, texto FROM perguntas WHERE id IN ($in)");
        while ($row = $stmtP->fetch()) {
            $pergunta_textos[$row['id']] = $row['texto'];
        }
    }

    $stmt = $pdo->prepare(
        "INSERT INTO respostas (avaliacao_id, pergunta_id, nota, texto, pergunta_texto) VALUES (:a, :p, :n, :t, :pt)"
    );

    foreach ($ids as $pid) {
        $pid = (int)$pid;
        $nota = isset($notas[$pid]) && $notas[$pid] !== '' ? (int)$notas[$pid] : null;
        $txt = isset($textos[$pid]) ? trim($textos[$pid]) : null;
        if ($nota === null && ($txt === null || $txt === '')) continue;

        $stmt->execute([
            ':a' => $avaliacao_id,
            ':p' => $pid,
            ':n' => $nota,
            ':t' => $txt,
            ':pt' => $pergunta_textos[$pid] ?? null
        ]);
    }

    $pdo->commit();
    header('Location: mensagem.php');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die('Erro ao salvar: ' . $e->getMessage());
}
