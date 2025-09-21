<?php
require_once __DIR__.'/../app/db.php';
require_once __DIR__.'/../app/auth.php';
start_session();
$pdo = get_pdo();

$slug = trim($_GET['slug'] ?? '');
$cat = null;

if ($slug !== '') {
  $st = $pdo->prepare('SELECT id, name, slug FROM categories WHERE slug = ?');
  $st->execute([$slug]);
  $cat = $st->fetch();
}
if (!$cat) {
  http_response_code(404);
  echo "Categoria não encontrada";
  exit;
}

// Busca posts da categoria
$ps = $pdo->prepare('
  SELECT p.id, p.title, p.summary, p.image_path, p.created_at
  FROM posts p
  WHERE p.status="published" AND p.category_id = ?
  ORDER BY p.created_at DESC
');
$ps->execute([$cat['id']]);
$posts = $ps->fetchAll();

// helper p/ imagem (funciona em subpasta)
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
function img_src($image_path, $base) {
  return $image_path ? $base.'/'.ltrim($image_path, '/') : null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($cat['name']) ?> - Veículos Militares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background:#556b2f; color:#fff; }
    /* Navbar é fixed-top no header.php, então empurra o conteúdo pra baixo */
    main { padding-top: 80px; } /* ajuste para 70–90px se precisar */
    .navbar { background:#3b4720; }
    .card { background:#2f3e1e; border:none; color:#fff; }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <?php require __DIR__.'/header.php'; ?>

  <main class="container flex-grow-1 my-4">
    <h2 class="mb-3"><?= htmlspecialchars($cat['name']) ?></h2>

    <?php if (!$posts): ?>
      <div class="alert alert-warning text-dark">Ainda não há publicações em “<?= htmlspecialchars($cat['name']) ?>”.</div>
    <?php else: ?>
      <div class="row g-3">
        <?php foreach ($posts as $post): $img = img_src($post['image_path'], $base); ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card p-3 h-100">
              <?php if ($img): ?>
                <img class="img-fluid rounded mb-2" src="<?= htmlspecialchars($img) ?>" alt="">
              <?php endif; ?>
              <h5><?= htmlspecialchars($post['title']) ?></h5>
              <p><?= nl2br(htmlspecialchars(mb_strimwidth($post['summary'] ?? '', 0, 140, '...'))) ?></p>
              <a class="btn btn-success" href="post.php?id=<?= (int)$post['id'] ?>">Ler mais</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <footer class="mt-auto p-3 text-center bg-dark text-white">
    <small>&copy; 2025 Veículos Militares</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
