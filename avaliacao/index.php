<?php
require 'config.php';

$stmt = $pdo->query("SELECT id, texto, tipo, ordem, COALESCE(escala_min,1) AS escala_min, COALESCE(escala_max,10) AS escala_max, descricao_min, descricao_max FROM perguntas ORDER BY ordem ASC");
$perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Avaliação de Qualidade</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <h1>Avaliação de Qualidade</h1>
    <p class="lead">Sua opinião é muito importante para nós!</p>

    <form action="enviar.php" method="post" id="avaliacaoForm">

      <?php if (empty($perguntas)): ?>
        <p style="color:#a00">Nenhuma pergunta cadastrada. Cadastre perguntas na tabela <code>perguntas</code>.</p>
      <?php else: ?>

        <?php foreach ($perguntas as $p): 
          $id = (int)$p['id'];
          $texto = htmlspecialchars($p['texto']);
          $tipo = $p['tipo'] ?? 'scale';
          $min = isset($p['escala_min']) ? (int)$p['escala_min'] : 1;
          $max = isset($p['escala_max']) ? (int)$p['escala_max'] : 10;
          $label_min = $p['descricao_min'] ?: 'Pouco satisfeito';
          $label_max = $p['descricao_max'] ?: 'Muito satisfeito';
        ?>
          <div class="pergunta" id="pergunta-<?= $id ?>">
            <div class="pergunta-texto"><strong><?= htmlspecialchars($p['ordem'] ?? $id) ?>. <?= $texto ?></strong></div>

            <?php if ($tipo === 'scale'): ?>
              <div class="escala">
                  <?php for ($i = $min; $i <= $max; $i++): ?>
                    <label class="nota">
                      <input type="radio" name="nota[<?= $id ?>]" value="<?= $i ?>">
                      <span class="num"><?= $i ?></span>
                    </label>
                  <?php endfor; ?>
              </div>

              <div class="escala-legenda baixo">
                  <span class="min"><?= htmlspecialchars($label_min) ?></span>
                  <span class="max"><?= htmlspecialchars($label_max) ?></span>
              </div>


            <?php else: ?>
              <textarea name="texto[<?= $id ?>]" rows="4" placeholder="Seu comentário (opcional)"></textarea>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

      <?php endif; ?>

      <p class="anonimo">Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>

      <button type="submit" class="btn">Enviar avaliação</button>
    </form>
  </div>

  <script>
    document.getElementById('avaliacaoForm').addEventListener('submit', function(e){
      const perguntas = document.querySelectorAll('.pergunta');
      for (let p of perguntas) {
        const radios = p.querySelectorAll('input[type="radio"]');
        if (radios.length > 0) {
          let ok = false;
          radios.forEach(r => { if (r.checked) ok = true; });
          if (!ok) {
            e.preventDefault();
            alert('Por favor responda todas as perguntas de escala antes de enviar.');
            return false;
          }
        }
      }
    });
  </script>
</body>
</html>
