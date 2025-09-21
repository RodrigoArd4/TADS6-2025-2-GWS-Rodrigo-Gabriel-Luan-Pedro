<?php
require_once __DIR__.'/../app/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Método não permitido');
}

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($name === '' || $email === '' || $username === '' || $password === '') {
  exit('Preencha todos os campos.');
}

$pdo = get_pdo();

try {
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare('INSERT INTO users (name,email,username,password_hash) VALUES (?,?,?,?)');
  $stmt->execute([$name, $email, $username, $hash]);

  // <<<< AQUI estava o problema: precisa ser '/\\'
  $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
  header('Location: '.$base.'/../login.php?registered=1');
  exit;

} catch (PDOException $e) {
  if ($e->getCode() === '23000') {
    exit('E-mail ou usuário já cadastrado.');
  }
  throw $e;
}
