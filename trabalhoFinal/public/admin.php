<?php
require_once __DIR__ . '/../src/auth.php';
require_once __DIR__ . '/../src/funcoes.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];
    if (autenticarUsuario($u, $p)) {
        $_SESSION['admin'] = $u;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Credenciais inválidas';
    }
}

if (!empty($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

if (empty($_SESSION['admin'])) {
    ?>
    <!doctype html>
    <html lang="pt-br">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>Admin - Login</title>
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
        <h1>Painel Administrativo</h1>
        <?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post">
          <label>Usuário: <input type="text" name="username" required></label>
          <label>Senha: <input name="password" type="password" required></label>
          <div style="margin-top:12px">
            <button type="submit" class="btn">Entrar</button>
          </div>
        </form>
      </main>
    </body>
    </html>
    <?php
    exit;
}

$setores = getSetores();
$setorSelecionado = !empty($_GET['setor_id']) ? intval($_GET['setor_id']) : null;
$media = getMediaPerguntas($setorSelecionado);
$feedbacks = getFeedbackRecente(25, $setorSelecionado);
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Painel Administrativo</title>
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
      <a href="index.php">Ver formulário</a>
      <span class="muted">|</span>
      <a href="admin.php?logout=1">Sair</a>
    </nav>
  </header>
  <main class="container">
    <h1>Painel Administrativo</h1>
    <p>Logado como <?= htmlspecialchars($_SESSION['admin']) ?></p>
    <section>
      <form method="get" style="margin-bottom:12px;display:flex;gap:8px;align-items:center">
        <label style="font-weight:600">Filtrar por setor:
          <select name="setor_id" onchange="this.form.submit()">
            <option value="">Todos</option>
            <?php foreach ($setores as $s): ?>
              <option value="<?= $s['id'] ?>" <?= ($setorSelecionado == $s['id']) ? 'selected' : '' ?>><?= htmlspecialchars($s['nome']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <?php if ($setorSelecionado): ?>
          <a href="admin.php" style="margin-left:8px;color:#666;text-decoration:none">Limpar filtro</a>
        <?php endif; ?>
      </form>

    <section>
      <h2>Médias por pergunta</h2>
      <?php if (empty($media)): ?>
        <p>Sem avaliações ainda.</p>
      <?php else: ?>
        <div style="display:flex;gap:16px;flex-direction:column">
          <canvas id="chartAvg" style="max-width:100%;height:320px"></canvas>
          <div class="table-responsive">
          <table>
            <thead><tr><th style="width:70%">Pergunta</th><th>Média</th><th>Total</th></tr></thead>
            <tbody>
              <?php foreach ($media as $a): ?>
                <tr>
                  <td><?= htmlspecialchars($a['texto']) ?></td>
                  <td><?= number_format($a['avg_resposta'],2,',','.') ?></td>
                  <td><?= intval($a['count_resposta']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          </div>
        </div>
      <?php endif; ?>
    </section>

    <section style="margin-top:22px">
      <h2>Comentários recentes</h2>
      <?php if (empty($feedbacks)): ?>
        <p>Sem comentários registrados.</p>
      <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:12px;margin-top:8px">
          <?php foreach ($feedbacks as $f): ?>
            <div style="padding:12px;border:1px solid #eef2f6;border-radius:8px;background:#fbfdff">
              <div style="font-size:0.95rem;color:#0b67d3;font-weight:600;"><?= htmlspecialchars($f['setor'] ?? '—') ?> · <?= htmlspecialchars($f['dispositivo'] ?? '—') ?></div>
              <div style="margin-top:6px;color:#111"><?= nl2br(htmlspecialchars($f['feedback'])) ?></div>
              <div style="margin-top:8px;font-size:0.85rem;color:#666"><?= htmlspecialchars($f['created_at']) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    (function(){
      const media = <?= json_encode(array_map(function($a){ return [ 'texto'=>$a['texto'], 'avg'=>floatval($a['avg_resposta']) ]; }, $media)) ?>;
      if (!media || media.length === 0) return;
      const labels = media.map(a => a.texto.length>40? a.texto.slice(0,40)+'...': a.texto);
      const data = media.map(a => a.avg);
      const ctx = document.getElementById('chartAvg').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{ label: 'Média', data: data, backgroundColor: 'rgba(11,103,211,0.85)' }]
        },
        options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, max:10}} }
      });
    })();
  </script>
</body>
</html>
