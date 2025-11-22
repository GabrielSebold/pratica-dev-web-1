<?php
require_once __DIR__ . '/db.php';

function salvaAvaliacoes(array $answers, ?string $feedback, ?int $dispositivo_id, ?int $setor_id): bool {
    $pdo = getPDO();
    if (!$pdo) return false;

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO avaliacoes (setor_id, pergunta_id, dispositivo_id, resposta, feedback, created_at) VALUES (:setor,:pergunta,:dispositivo,:resposta,:feedback, now())");
        $first = true;
        foreach ($answers as $qid => $val) {
            $toSaveFeedback = null;
            if ($first && !empty(trim((string)$feedback))) {
                $toSaveFeedback = $feedback;
            }
            $stmt->execute([
                'setor' => $setor_id,
                'pergunta' => $qid,
                'dispositivo' => $dispositivo_id,
                'resposta' => $val,
                'feedback' => $toSaveFeedback
            ]);
            $first = false;
        }
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log('Error saving evaluation: '.$e->getMessage());
        return false;
    }
}
