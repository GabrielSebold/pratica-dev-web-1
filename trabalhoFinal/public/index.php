<?php
require_once __DIR__ . '/../src/perguntas.php';
require_once __DIR__ . '/../src/funcoes.php';

session_start();

$perguntas = getPerguntasAtivas();
$dispositivos = getDispositivos();
$setores = getSetores();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Avaliação de Serviços</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="site-header">
    <nav>
      <a href="index.php">Avaliação</a>
      <a href="admin.php">Admin</a>
      <?php if (!empty(
        
        $_SESSION['admin'])): ?>
        <span class="muted">|</span>
        <a href="admin.php">Painel (<?= htmlspecialchars($_SESSION['admin']) ?>)</a>
        <a href="admin.php?logout=1">(Sair)</a>
      <?php endif; ?>
    </nav>
  </header>

  <main class="container">
    <h1>Formulário de Avaliação</h1>

    

    <form id="evalForm" method="post" action="obrigado.php">
      <div class="meta">
        <label>Dispositivo:
          <select name="dispositivo_id" required>
            <option value="" disabled selected>-- Selecione --</option>
            <?php foreach ($dispositivos as $d): ?>
              <option value="<?= htmlspecialchars($d['id']) ?>"><?= htmlspecialchars($d['nome']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Setor:
          <select name="setor_id" required>
            <option value="" disabled selected>-- Selecione --</option>
            <?php foreach ($setores as $s): ?>
              <option value="<?= htmlspecialchars($s['id']) ?>"><?= htmlspecialchars($s['nome']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
      </div>

      <section class="perguntas">
        <?php if (empty($perguntas)): ?>
          <p>Não há perguntas cadastradas no momento.</p>
        <?php else: ?>
          <?php foreach ($perguntas as $q): ?>
            <fieldset class="pergunta">
              <legend class="pergunta-texto"><?= htmlspecialchars($q['texto']) ?></legend>
              <div class="escala">
                <?php for ($i = 0; $i <= 10; $i++): ?>
                  <label class="nota">
                    <input type="radio" name="answer_<?= $q['id'] ?>" value="<?= $i ?>">
                    <span class="num"><?= $i ?></span>
                  </label>
                <?php endfor; ?>
              </div>
              <div class="escala-legenda baixo">
                <span>0 - Muito Insatisfeito</span>
                <span>10 - Completamente Satisfeito</span>
              </div>
            </fieldset>
          <?php endforeach; ?>
        <?php endif; ?>
      </section>

      <div class="feedback">
        <label>Comentário adicional (opcional):
          <textarea name="feedback" rows="4" placeholder="Opinião, sugestão ou comentário"></textarea>
        </label>
      </div>

      <p class="anonimo">Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>

      <div class="actions">
        <button type="submit" class="btn">Enviar Avaliação</button>
      </div>
    </form>
  </main>
  <script src="js/script.js"></script>
</body>
</html>
