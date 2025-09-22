<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro — Veículos Militares</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #556b2f; /* verde camuflagem */
    }
    main {
      margin-top: 100px; /* espaço para a navbar fixa */
    }
    .card {
      background-color: #3b4720;
      color: #fff;
    }
    .form-label {
      color: #ddd;
    }
    footer {
      background-color: #3b4720;
      color: #fff;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background:#3b4720">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="<?= htmlspecialchars($publicUrl ?? '') ?>public/index.php">Veículos Militares</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- CONTEÚDO -->
  <main class="container" style="max-width: 680px;">
    <h2 class="mb-4 text-white">Cadastro</h2>

    <form action="actions/register.php" method="post" class="card p-4 shadow-sm">
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input class="form-control" name="name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input class="form-control" type="email" name="email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Usuário</label>
        <input class="form-control" name="username" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input class="form-control" type="password" name="password" required>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-success">Cadastrar</button>
        <a class="btn btn-outline-light" href="login.php">Ir para Login</a>
      </div>
    </form>
  </main>

  <!-- RODAPÉ -->
  <footer class="mt-auto p-3 text-center bg-dark">
    <small>&copy; 2025 Veículos Militares</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
