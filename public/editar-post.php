<?php
// public/editar-post.php
require_once __DIR__.'/../app/auth.php';
require_admin();                  // painel é só para admin (igual ao gerenciar-posts)
require_once __DIR__.'/../app/db.php';

$pdo = get_pdo();

// valida o ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  http_response_code(400);
  exit('ID inválido.');
}

// carrega o post
$st = $pdo->prepare('SELECT id, title, summary, content, image_path, category_id FROM posts WHERE id = ?');
$st->execute([$id]);
$post = $st->fetch();
if (!$post) {
  http_response_code(404);
  exit('Post não encontrado.');
}

// carrega categorias
$cats = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();

// helper para montar URL da imagem (funciona em /public)
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); // ex.: /projeto/public
$imgUrl = !empty($post['image_path']) ? $base.'/'.ltrim($post['image_path'], '/') : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Post — Veículos Militares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background:#556b2f; color:#fff; }
    main { padding-top:80px; }              /* navbar fixed-top */
    .card { background:#2f3e1e; color:#fff; border:none; }
    .navbar { background:#3b4720; }
    a, a:visited { color:#d5e8a8; }
    .form-text { color:#d5e8a8; opacity:.9; }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <?php require __DIR__.'/header.php'; ?>

  <main class="container flex-grow-1 my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Editar Post</h2>
      <a class="btn btn-outline-light" href="gerenciar-posts.php">← Voltar</a>
    </div>

    <div class="card p-4">
      <form action="../actions/update_post.php" method="post" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">

        <div class="col-12">
          <label class="form-label">Título</label>
          <input class="form-control" name="title" required value="<?= htmlspecialchars($post['title']) ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Categoria</label>
          <select class="form-select" name="category_id">
            <option value="">Sem categoria</option>
            <?php foreach ($cats as $c): ?>
              <option value="<?= (int)$c['id'] ?>"
                <?= ($post['category_id'] == $c['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Imagem (opcional)</label>
          <input class="form-control" type="file" name="image" accept="image/*">
          <?php if ($imgUrl): ?>
            <div class="form-text mt-2">Imagem atual:</div>
            <img src="<?= htmlspecialchars($imgUrl) ?>" alt="" class="img-fluid rounded mt-1" style="max-height:160px; object-fit:cover;">
          <?php endif; ?>
        </div>

        <div class="col-12">
          <label class="form-label">Resumo</label>
          <textarea class="form-control" name="summary" rows="3"><?= htmlspecialchars($post['summary'] ?? '') ?></textarea>
        </div>

        <div class="col-12">
          <label class="form-label">Conteúdo</label>
          <textarea class="form-control" name="content" rows="8" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-success">Salvar alterações</button>
          <a class="btn btn-secondary" href="gerenciar-posts.php">Cancelar</a>
        </div>
      </form>
    </div>
  </main>

  <footer class="mt-auto p-3 text-center bg-dark text-white">
    <small>&copy; 2025 Veículos Militares</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
