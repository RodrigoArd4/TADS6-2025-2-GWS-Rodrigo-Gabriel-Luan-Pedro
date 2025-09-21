<?php
require_once __DIR__.'/../app/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Método não permitido');
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
  exit('Informe usuário e senha.');
}

// Captura o redirect vindo da querystring (?redirect=...) OU do formulário (hidden)
$redirect = $_GET['redirect'] ?? $_POST['redirect'] ?? null;
// Sanitiza (evita barras iniciais duplas, espaços etc.)
if ($redirect) {
  $redirect = ltrim($redirect, "/\\ \t\r\n");
}

if (login_user($username, $password)) {
  if ($redirect) {
    // Ex.: "post.php?id=3#comentarios" (vamos sempre ancorar em /public/)
    header('Location: ../public/' . $redirect);
    exit;
  }
  // fallback: sem redirect, vai pra home
  $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
  header('Location: ' . $base . '/../public/index.php');
  exit;
} else {
  // mantém o redirect na volta para a tela de login, se existir
  $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
  $suffix = $redirect ? ('&redirect=' . rawurlencode($redirect)) : '';
  header('Location: ' . $base . '/../login.php?error=1' . $suffix);
  exit;
}
