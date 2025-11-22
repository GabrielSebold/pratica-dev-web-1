<?php
require_once __DIR__ . '/../src/respostas.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$feedback = trim($_POST['feedback'] ?? '');
$dispositivo_id = !empty($_POST['dispositivo_id']) ? intval($_POST['dispositivo_id']) : null;
$setor_id = !empty($_POST['setor_id']) ? intval($_POST['setor_id']) : null;

if (empty($dispositivo_id) || empty($setor_id)) {
    ?>
    <!doctype html>
    <html lang="pt-br">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>Erro - Avaliação</title>
      <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
      <main class="container">
        <h1>Dados incompletos</h1>
        <p>Por favor selecione o dispositivo e o setor antes de enviar a avaliação.</p>
        <div class="actions"><a class="btn-voltar" href="index.php">Voltar ao formulário</a></div>
      </main>
    </body>
    </html>
    <?php
    exit;
}

$answers = [];
foreach ($_POST as $k => $v) {
    if (strpos($k, 'answer_') === 0) {
        $qid = intval(substr($k, 7));
        $answers[$qid] = intval($v);
    }
}

$saved = salvaAvaliacoes($answers, $feedback, $dispositivo_id, $setor_id);
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Obrigado</title>
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
    </nav>
  </header>
  <main class="container">
    <h1>Obrigado!</h1>
    <p>O Estabelecimento agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.</p>
    <?php if (!$saved): ?>
      <p class="error">Houve um erro ao registrar sua avaliação. Tente novamente mais tarde.</p>
    <?php endif; ?>
    <p class="anonimo">Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
    <div class="actions">
      <a class="btn-voltar" href="index.php">Voltar ao formulário</a>
    </div>
  </main>
</body>
</html>
