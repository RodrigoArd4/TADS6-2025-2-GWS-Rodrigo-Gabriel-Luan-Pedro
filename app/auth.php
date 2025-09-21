<?php
// app/auth.php
require_once __DIR__.'/db.php';

function start_session(): void {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
}

function login_user(string $username, string $password): bool {
  start_session();
  $pdo = get_pdo();
  $st = $pdo->prepare('SELECT * FROM users WHERE username = ?');
  $st->execute([$username]);
  $u = $st->fetch();
  if ($u && password_verify($password, $u['password_hash'])) {
    $_SESSION['user'] = [
      'id'       => $u['id'],
      'name'     => $u['name'],
      'username' => $u['username'],
      'role'     => $u['role'],
    ];
    return true;
  }
  return false;
}

function current_user(): ?array {
  start_session();
  return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool {
  return current_user() !== null;
}

function require_login(): void {
  if (!is_logged_in()) {
    // preserva a página atual para voltar depois do login
    $redirect = $_SERVER['REQUEST_URI'] ?? '';
    header('Location: /login.php?redirect=' . urlencode(ltrim($redirect, '/')));
    exit;
  }
}

function require_admin(): void {
  $u = current_user();
  if (!$u || $u['role'] !== 'admin') {
    http_response_code(403);
    exit('Acesso negado.');
  }
}
