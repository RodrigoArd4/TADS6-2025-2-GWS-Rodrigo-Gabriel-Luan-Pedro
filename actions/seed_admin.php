<?php
require_once __DIR__.'/../app/db.php'; $pdo=get_pdo();
$name='Administrador'; $email='admin@example.com'; $username='admin'; $password_hash=password_hash('admin123',PASSWORD_DEFAULT);
try{
  $pdo->prepare('INSERT INTO users (name,email,username,password_hash,role) VALUES (?,?,?,?,"admin")')
      ->execute([$name,$email,$username,$password_hash]);
  echo 'Admin criado: admin / admin123. Apague este arquivo depois.';
}catch(PDOException $e){
  if($e->getCode()==='23000') echo 'Já existe admin com esse e-mail/usuário.'; else echo 'Erro: '.$e->getMessage();
}
