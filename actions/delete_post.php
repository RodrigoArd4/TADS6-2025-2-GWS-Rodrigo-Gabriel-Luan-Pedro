<?php
require_once __DIR__.'/../app/auth.php';
require_admin();

$pdo = get_pdo();
$u   = current_user();

// pega o ID: preferir POST, mas aceitar GET
$id = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
} elseif (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
}

if ($id <= 0) {
  http_response_code(400);
  exit('ID inválido.');
}

// carrega e checa permissão
$st = $pdo->prepare('SELECT id, author_id FROM posts WHERE id = ?');
$st->execute([$id]);
$post = $st->fetch();
if (!$post) { http_response_code(404); exit('Post não encontrado.'); }
if (!($u['role'] === 'admin' || $u['id'] == $post['author_id'])) {
  http_response_code(403); exit('Sem permissão.');
}

// exclui
$pdo->prepare('DELETE FROM posts WHERE id = ?')->execute([$id]);

// redirect
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
header('Location: '.$base.'/../public/gerenciar-posts.php?deleted=1');
exit;
