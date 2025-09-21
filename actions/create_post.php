<?php
require_once __DIR__.'/../app/auth.php';
require_admin();

$title       = trim($_POST['title'] ?? '');
$summary     = trim($_POST['summary'] ?? '');
$content     = trim($_POST['content'] ?? '');
$category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;

if (!$title || !$content) {
  exit('Título e conteúdo são obrigatórios.');
}

$pdo = get_pdo();
$u   = current_user();

$image_path = null;

// ====== UPLOAD DE IMAGEM (robusto) ======
if (isset($_FILES['image']) && is_array($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {

  // 1) Erros nativos do PHP
  $err = $_FILES['image']['error'];
  if ($err !== UPLOAD_ERR_OK) {
    $map = [
      UPLOAD_ERR_INI_SIZE   => 'Arquivo maior que upload_max_filesize.',
      UPLOAD_ERR_FORM_SIZE  => 'Arquivo maior que MAX_FILE_SIZE do formulário.',
      UPLOAD_ERR_PARTIAL    => 'Upload foi feito parcialmente.',
      UPLOAD_ERR_NO_FILE    => 'Nenhum arquivo enviado.',
      UPLOAD_ERR_NO_TMP_DIR => 'Pasta temporária ausente no servidor.',
      UPLOAD_ERR_CANT_WRITE => 'Falha ao escrever o arquivo no disco.',
      UPLOAD_ERR_EXTENSION  => 'Uma extensão do PHP bloqueou o upload.'
    ];
    $msg = $map[$err] ?? ('Erro de upload (código '.$err.').');
    exit('Falha no upload da imagem: '.$msg);
  }

  // 2) Validação de tipo MIME real (segurança)
  $tmp = $_FILES['image']['tmp_name'];
  $fi  = new finfo(FILEINFO_MIME_TYPE);
  $mime = $fi->file($tmp);

  $allowed = [
    'image/jpeg' => '.jpg',
    'image/png'  => '.png',
    'image/gif'  => '.gif',
    'image/webp' => '.webp',
  ];
  if (!isset($allowed[$mime])) {
    exit('Tipo de imagem não permitido. Envie JPG, PNG, GIF ou WEBP.');
  }

  // 3) Limite de tamanho (extra, além do php.ini)
  $maxBytes = 16 * 1024 * 1024; // 16 MB
  if (filesize($tmp) > $maxBytes) {
    exit('Imagem muito grande (limite 16MB).');
  }

  // 4) Gera nome seguro e move
  $uploadDir = __DIR__.'/../public/uploads/';
  if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0777, true);
  }

  $safeOriginal = preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['image']['name']);
  $ext = $allowed[$mime];
  $filename = time().'_'.bin2hex(random_bytes(4)).$ext;
  $dest = $uploadDir.$filename;

  if (!move_uploaded_file($tmp, $dest)) {
    exit('Não foi possível salvar a imagem no servidor.');
  }

  // Caminho público para usar nos <img src="">
  $image_path = '/uploads/'.$filename;
}
// ====== FIM UPLOAD ======

// Insere post
$stmt = $pdo->prepare(
  'INSERT INTO posts (title,summary,content,image_path,author_id,category_id)
   VALUES (?,?,?,?,?,?)'
);
$stmt->execute([$title, $summary, $content, $image_path, $u['id'], $category_id]);

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
header('Location: '.$base.'/../public/index.php?created=1');
exit;
