<?php require_once __DIR__.'/../app/db.php'; $pdo=get_pdo();
$id=(int)($_GET['id']??0);
$st=$pdo->prepare('SELECT p.*,c.name AS category FROM posts p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id=?'); $st->execute([$id]);
$post=$st->fetch(); if(!$post){ http_response_code(404); echo 'Post não encontrado.'; exit; }
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($post['title']) ?> - Veículos Militares</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>body{background:#556b2f;color:#fff}.card{background:#2f3e1e;border:none;color:#fff}</style></head>
<body class="container py-4">
  <a href="index.php" class="btn btn-outline-light mb-3">← Voltar</a>
  <article class="card p-4">
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <div class="small text-muted mb-2"><?= htmlspecialchars($post['category'] ?? 'Sem categoria') ?> • <?= htmlspecialchars($post['created_at']) ?></div>
    <?php
      $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
      $img  = $post['image_path'] ? $base.'/'.ltrim($post['image_path'],'/') : null;
      ?>
      <?php if ($img): ?>
        <img class="img-fluid rounded mb-3" src="<?= htmlspecialchars($img) ?>" alt="">
      <?php endif; ?> 

    <?php if (!empty($post['summary'])): ?><p class="lead"><?= nl2br(htmlspecialchars($post['summary'])) ?></p><?php endif; ?>
    <div><?= nl2br(htmlspecialchars($post['content'])) ?></div>
  </article>

  <section id="comentarios" class="mt-4">
    <h4>Comentários</h4>
    <?php $c=$pdo->prepare('SELECT user_name,content,created_at FROM comments WHERE approved=1 AND post_id=? ORDER BY created_at DESC'); $c->execute([$id]); foreach($c->fetchAll() as $cm): ?>
      <div class="card p-3 mb-2"><div class="small text-muted"><?= htmlspecialchars($cm['user_name']) ?> • <?= htmlspecialchars($cm['created_at']) ?></div><div><?= nl2br(htmlspecialchars($cm['content'])) ?></div></div>
    <?php endforeach; ?>
    <div class="card p-3 mt-3">
      <form action="../actions/add_comment.php" method="post">
        <input type="hidden" name="post_id" value="<?= (int)$id ?>">
        <div class="mb-2"><label class="form-label">Seu nome *</label><input class="form-control" type="text" name="user_name" required></div>
        <div class="mb-2"><label class="form-label">E-mail (opcional)</label><input class="form-control" type="email" name="user_email"></div>
        <div class="mb-2"><label class="form-label">Comentário *</label><textarea class="form-control" name="content" rows="3" required></textarea></div>
        <button class="btn btn-success">Enviar comentário</button>
      </form>
    </div>
  </section>
</body></html>
