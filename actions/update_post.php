<?php
require_once __DIR__.'/../app/auth.php';
require_admin();

$pdo = get_pdo();
$u   = current_user();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Método não permitido');
}

$id          = (int)($_POST['id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$summary     = trim($_POST['summary'] ?? '');
$content     = trim($_POST['content'] ?? '');
$category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;

if ($id <= 0 || $title === '' || $content === '') {
  exit('Campos obrigatórios ausentes.');
}

// Carrega o post e verifica permissão (dono ou admin)
$st = $pdo->prepare('SELECT id, author_id, image_path FROM posts WHERE id = ?');
$st->execute([$id]);
$post = $st->fetch();

if (!$post) {
  http_response_code(404);
  exit('Post não encontrado.');
}


$image_path = $post['image_path'];

// Upload de nova imagem (opcional)
if (!empty($_FILES['image']['name'])) {
  $uploadDir = __DIR__ . '/../public/uploads/';
  @mkdir($uploadDir, 0777, true);

  $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['image']['name']);
  $dest     = $uploadDir . $filename;

  if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
    // sem barra inicial para funcionar em subpasta
    $image_path = 'uploads/' . $filename;
  }
}

// Atualiza o post
$pdo->prepare('UPDATE posts
               SET title = ?, summary = ?, content = ?, image_path = ?, category_id = ?, updated_at = NOW()
               WHERE id = ?')
    ->execute([$title, $summary, $content, $image_path, $category_id, $id]);

// Redireciona de volta para gerenciar posts
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
header('Location: ' . $base . '/../public/gerenciar-posts.php?updated=1');
exit;
