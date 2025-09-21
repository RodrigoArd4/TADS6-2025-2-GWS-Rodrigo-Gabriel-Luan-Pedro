<?php
require_once __DIR__.'/../app/auth.php';

start_session();
session_destroy();

// redireciona para a página inicial
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
header('Location: '.$base.'/../public/index.php');
exit;
