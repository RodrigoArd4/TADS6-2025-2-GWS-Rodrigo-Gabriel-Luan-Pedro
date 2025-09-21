<?php
require_once __DIR__.'/../app/auth.php';
require_admin();
$pdo = get_pdo();
$u   = current_user();

if ($u['role'] === 'admin') {
  $st = $pdo->query(
    'SELECT p.id,p.title,p.created_at,c.name AS category,u.name AS author
     FROM posts p
     LEFT JOIN categories c ON c.id=p.category_id
     JOIN users u ON u.id=p.author_id
     ORDER BY p.created_at DESC'
  );
} else {
  $st = $pdo->prepare(
    'SELECT p.id,p.title,p.created_at,c.name AS category,u.name AS author
     FROM posts p
     LEFT JOIN categories c ON c.id=p.category_id
     JOIN users u ON u.id=p.author_id
     WHERE p.author_id=?
     ORDER BY p.created_at DESC'
  );
  $st->execute([$u['id']]);
}
$posts = $st->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciar Posts - Veículos Militares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background:#556b2f;
      color:#fff;
      padding-top:80px; /* empurra o conteúdo abaixo da navbar fixa */
    }
    .card,.table {
      background:#2f3e1e;
      color:#fff;
    }
    a,a:visited { color:#d5e8a8 }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <?php require __DIR__.'/header.php'; ?>

  <main class="container my-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Gerenciar Posts</h2>
      <div class="d-flex gap-2">
        <a href="index.php" class="btn btn-outline-light">← Voltar</a>
        <a href="../cadastrar-noticia.php" class="btn btn-light">+ Novo Post</a>
      </div>
    </div>

    <?php if (isset($_GET['updated'])): ?>
      <div class="alert alert-success text-dark">Post atualizado com sucesso.</div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])): ?>
      <div class="alert alert-success text-dark">Post excluído com sucesso.</div>
    <?php endif; ?>

    <?php if (!$posts): ?>
      <div class="alert alert-warning text-dark">Você ainda não tem posts.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-borderless align-middle">
          <thead>
            <tr>
              <th>Título</th>
              <th>Categoria</th>
              <th>Autor</th>
              <th>Criado em</th>
              <th class="text-end">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($posts as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['title']) ?></td>
                <td><?= htmlspecialchars($p['category'] ?? 'Sem categoria') ?></td>
                <td><?= htmlspecialchars($p['author']) ?></td>
                <td><?= htmlspecialchars($p['created_at']) ?></td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-light" href="editar-post.php?id=<?= (int)$p['id'] ?>">Editar</a>
                  <form action="../actions/delete_post.php" method="post" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                    <button class="btn btn-sm btn-danger">Excluir</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>

  <footer class="mt-auto p-3 text-center bg-dark text-white">
    <small>&copy; 2025 Veículos Militares</small>
  </footer>
</body>
</html>
