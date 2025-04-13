<?php
    session_start();
    include '../db.php';
    require_once '../config.php';

    $resultado = mysqli_query($conn, "SELECT * FROM usuarios ORDER BY id DESC");

    if (isset($_POST['acao']) && $_POST['acao'] === 'inserir') {
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $nivel = (int) $_POST['nivel'];
        mysqli_query($conn, "INSERT INTO usuarios (nome, email,usuario, senha, nivel) VALUES ('$nome', '$email','$usuario','$senha', $nivel)");
        header('Location: crud_usuario.php'); exit;
    }
    
    if (isset($_POST['acao']) && $_POST['acao'] === 'atualizar') {
        $id = (int) $_POST['id'];
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $nivel = (int) $_POST['nivel'];
        $atualiza = "nome='$nome', email='$email', nivel=$nivel";
        if (!empty($_POST['senha'])) {
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $atualiza .= ", senha='$senha'";
        }
        mysqli_query($conn, "UPDATE usuarios SET $atualiza WHERE id=$id");
        header('Location: crud_usuario.php'); exit;
    }
    
    if (isset($_GET['excluir'])) {
        $id = (int) $_GET['excluir'];
        mysqli_query($conn, "DELETE FROM usuarios WHERE id=$id");
        header('Location: crud_usuario.php'); exit;
    }
   
?>
  <?php include '../header.php';?>
<body >
<h2>Cadastro de Usuários</h2>
<form method="post" class="row g-3 mb-4">
  <input type="hidden" name="acao" value="inserir">
  <div class="col-md-4">
    <label class="form-label">Nome</label>
    <input type="text" name="nome" class="form-control" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Usuario</label>
    <input type="usuario" name="usuario" class="form-control" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>

  <div class="col-md-2">
    <label class="form-label">Senha</label>
    <input type="password" name="senha" class="form-control" required>
  </div>
  <div class="col-md-2">
    <label class="form-label">Nível</label>
    <select name="nivel" class="form-select">
      <option value="1">Administrador</option>
      <option value="2">Supervisor</option>
      <option value="3">Operador</option>
    </select>
  </div>
  <div class="col-md-12">
    <button type="submit" class="btn btn-success">Adicionar</button>
  </div>
</form>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Nome</th><th>Email</th><th>Usuario</th><th>Nível</th><th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
    <tr>
      <form method="post">
        <td><?= $row['id'] ?></td>
        <td>
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input type="hidden" name="acao" value="atualizar">
          <input type="text" name="nome" value="<?= htmlspecialchars($row['nome']) ?>" class="form-control">
        </td>
        <td><input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control"></td>
        <td><input type="usuario" name="usuario" value="<?= htmlspecialchars($row['usuario']) ?>" class="form-control"></td>
        <td>
          <select name="nivel" class="form-select">
            <option value="1" <?= $row['nivel'] == 1 ? 'selected' : '' ?>>Administrador</option>
            <option value="2" <?= $row['nivel'] == 2 ? 'selected' : '' ?>>Supervisor</option>
            <option value="3" <?= $row['nivel'] == 3 ? 'selected' : '' ?>>Operador</option>
          </select>
        </td>
        <td>
          <input type="password" name="senha" class="form-control mb-1" placeholder="Nova senha (opcional)">
          <button class="btn btn-primary btn-sm">Salvar</button>
          <a href="?excluir=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir usuário?')">Excluir</a>
        </td>
      </form>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
