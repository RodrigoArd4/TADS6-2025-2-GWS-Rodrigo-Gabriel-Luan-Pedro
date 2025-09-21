<?php
require_once __DIR__.'/app/auth.php';
require_admin();
require_once __DIR__.'/app/db.php';
$pdo  = get_pdo();
$cats = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nova notícia - Veículos Militares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* empurra o conteúdo para baixo da navbar fixed-top */
    body { padding-top: 80px; } /* ajuste para 70–90px conforme a altura da sua navbar */
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <?php require __DIR__.'/public/header.php'; ?>

  <main class="container py-4">
    <h2 class="mb-4">Cadastrar Nova Publicação</h2>

    <form action="actions/create_post.php" method="post" enctype="multipart/form-data" class="col-12 col-lg-8 p-0">
      <div class="mb-3">
        <label class="form-label">Título</label>
        <input class="form-control" name="title" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Categoria</label>
        <select class="form-select" name="category_id">
          <option value="">Sem categoria</option>
          <?php foreach ($cats as $c): ?>
            <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Resumo</label>
        <textarea class="form-control" name="summary" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Conteúdo</label>
        <textarea class="form-control" name="content" rows="8" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Imagem</label>
        <input class="form-control" type="file" name="image" accept="image/*">
      </div>

      <button class="btn btn-success">Publicar</button>
      <a class="btn btn-link" href="public/index.php">Voltar</a>
    </form>
  </main>
</body>
</html>
