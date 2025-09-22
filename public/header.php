<?php
// public/header.php
require_once __DIR__.'/../app/db.php';
require_once __DIR__.'/../app/auth.php';
start_session();
$pdo = get_pdo();
$u   = current_user();

/**
 * Descobre a URL base do script atual e calcula:
 * - $publicUrl: aponta para /public (funciona mesmo se já estiver em /public)
 * - $rootUrl:   aponta para a raiz do projeto (um nível acima de /public)
 */
$base     = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');        // ex.: /projeto  ou /projeto/public
$isPublic = (substr($base, -7) === '/public');
$publicUrl = $isPublic ? $base : $base.'/public';                  // ex.: /projeto/public
$rootUrl   = $isPublic ? rtrim(dirname($base), '/\\') : $base;     // ex.: /projeto
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background:#3b4720">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= htmlspecialchars($publicUrl) ?>/index.php">Veículos Militares</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <!-- links principais à esquerda -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($publicUrl) ?>/index.php">Início</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($publicUrl) ?>/categoria.php?slug=avioes">Aviões</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($publicUrl) ?>/categoria.php?slug=tanques">Tanques</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($publicUrl) ?>/categoria.php?slug=navios">Navios</a></li>

        <?php if ($u && ($u['role'] ?? null) === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($publicUrl) ?>/gerenciar-posts.php">Gerenciar posts</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($rootUrl) ?>/cadastrar-noticia.php">Nova Postagem</a></li>
        <?php endif; ?>
      </ul>

      <!-- login / logout à direita -->
      <ul class="navbar-nav ms-auto">
        <?php if ($u): ?>
          <li class="nav-item"><span class="nav-link">Olá, <?= htmlspecialchars($u['name']) ?></span></li>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($rootUrl) ?>/actions/logout.php">Sair</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($rootUrl) ?>/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($rootUrl) ?>/cadastro.php">Cadastre-se</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
