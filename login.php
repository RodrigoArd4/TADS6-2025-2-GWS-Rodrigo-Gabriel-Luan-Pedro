<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login — Veículos Militares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100">

  <main class="container py-5" style="max-width: 680px;">
    <h2 class="mb-4">Entrar</h2>

    <?php if (!empty($_GET['error'])): ?>
      <div class="alert alert-danger">Usuário ou senha inválidos.</div>
    <?php endif; ?>

    <?php if (!empty($_GET['registered'])): ?>
      <div class="alert alert-success">Cadastro realizado! Faça login abaixo.</div>
    <?php endif; ?>

    <?php if (!empty($_GET['redirect'])): ?>
      <div class="alert alert-info">Faça login para continuar.</div>
    <?php endif; ?>

    <form action="actions/login.php" method="post" class="card p-4 shadow-sm">
      <?php if (!empty($_GET['redirect'])): ?>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect']) ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Usuário</label>
        <input class="form-control" name="username" autocomplete="username" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input class="form-control" type="password" name="password" autocomplete="current-password" required>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-success">Entrar</button>
        <a class="btn btn-outline-secondary" href="public/index.php">Voltar</a>
        <a class="btn btn-link ms-auto" href="cadastro.html">Cadastre-se</a>
      </div>
    </form>
  </main>

  <footer class="mt-auto p-3 text-center bg-dark text-white">
    <small>&copy; 2025 Veículos Militares</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
