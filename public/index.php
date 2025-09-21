<?php
require_once __DIR__.'/../app/auth.php'; // auth.php já puxa db.php
start_session();
$pdo = get_pdo();
$u   = current_user();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Veículos Militares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background:#556b2f;
      color:#fff;
    }
    .navbar {
      background:#3b4720;
    }
    .card {
      background:#2f3e1e;
      border:none;
      color:#fff;
    }
    /* empurra o conteúdo para baixo da navbar fixed-top */
    main {
      padding-top:80px; /* ajuste para 70–90px se necessário */
    }
    /* padroniza imagens dos cards */
    .card-img-top {
      height:200px;       /* altura fixa */
      object-fit:cover;   /* corta mantendo proporção */
      width:100%;
    }
    /* cor da categoria */
    .card .small {
      color:#d5e8a8 !important;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <?php require __DIR__.'/header.php'; ?>

  <main class="container my-4 flex-grow-1">
    <h2 class="mb-3">Últimas postagens</h2>
    <?php
      $q = $pdo->query('SELECT p.id,p.title,p.summary,p.image_path,c.name AS category
                        FROM posts p
                        LEFT JOIN categories c ON c.id=p.category_id
                        WHERE p.status="published"
                        ORDER BY p.created_at DESC');
      $posts = $q->fetchAll();
      if (!$posts) {
        echo '<div class="alert alert-warning text-dark">Ainda não há posts publicados.</div>';
      }
    ?>
    <div class="row g-3">
      <?php foreach ($posts as $post): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card h-100 d-flex flex-column">
            <?php if (!empty($post['image_path'])): ?>
              <?php
                $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
                $img  = $base.'/'.ltrim($post['image_path'], '/');
              ?>
              <img class="card-img-top" src="<?= htmlspecialchars($img) ?>" alt="">
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
              <div class="small mb-2"><?= htmlspecialchars($post['category'] ?? 'Sem categoria') ?></div>
              <p class="card-text mb-3"><?= nl2br(htmlspecialchars(mb_strimwidth($post['summary'] ?? '', 0, 140, '...'))) ?></p>
              <a class="btn btn-success w-100 mt-auto" href="post.php?id=<?= (int)$post['id'] ?>">Ler mais</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <footer class="mt-auto p-3 text-center bg-dark">
    <p>&copy; 2025 Veículos Militares</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
