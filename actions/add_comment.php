<?php
require_once __DIR__.'/../app/auth.php';
start_session();

// se não estiver logado, manda pro login com redirect de volta pro post
if (!is_logged_in()) {
  $post_id = (int)($_POST['post_id'] ?? 0);
  $redirect = '../login.php';
  if ($post_id > 0) {
    // manda o id do post no querystring pra voltar depois
    $redirect .= '?redirect=post.php?id='.$post_id.'#comentarios';
  }
  header('Location: '.$redirect);
  exit;
}

require_once __DIR__.'/../app/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Método não permitido');
}

$post_id    = (int)($_POST['post_id'] ?? 0);
$user_name  = trim($_POST['user_name'] ?? '');
$user_email = trim($_POST['user_email'] ?? '');
$content    = trim($_POST['content'] ?? '');

if ($post_id <= 0 || $user_name === '' || $content === '') {
  exit('Preencha os campos obrigatórios.');
}

$pdo = get_pdo();
$stmt = $pdo->prepare(
  'INSERT INTO comments (post_id, user_name, user_email, content) VALUES (?,?,?,?)'
);
$stmt->execute([$post_id, $user_name, $user_email !== '' ? $user_email : null, $content]);

// depois de comentar, volta pro post
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
header('Location: ' . $base . '/../public/post.php?id=' . $post_id . '#comentarios');
exit;
