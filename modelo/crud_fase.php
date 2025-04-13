<?php
    session_start();
    include '../db.php';
    require_once '../config.php';

    $resultado = mysqli_query($conn, "SELECT * FROM fase ORDER BY id DESC");

    if (isset($_POST['acao']) && $_POST['acao'] === 'inserir') {
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $cor = mysqli_real_escape_string($conn, $_POST['cor']);
        $habilitada = isset($_POST['habilitada']) ? 1 : 0;
        mysqli_query($conn, "INSERT INTO fase (nome, cor, habilitada) VALUES ('$nome', '$cor', $habilitada)");
        header('Location: crud_fase.php'); exit;
    }
    
    if (isset($_POST['acao']) && $_POST['acao'] === 'atualizar') {
        $id = (int) $_POST['id'];
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $cor = mysqli_real_escape_string($conn, $_POST['cor']);
        $habilitada = isset($_POST['habilitada']) ? 1 : 0;
        mysqli_query($conn, "UPDATE fase SET nome='$nome', cor='$cor', habilitada=$habilitada WHERE id=$id");
        header('Location: crud_fase.php'); exit;
    }
    
    if (isset($_GET['excluir'])) {
        $id = (int) $_GET['excluir'];
        mysqli_query($conn, "DELETE FROM fase WHERE id=$id");
        header('Location: crud_fase.php'); exit;
    }
   include '../header.php';
?>

<body >
<h2>Cadastro de Fases</h2>
<form method="post" class="row g-3 mb-4">
  <input type="hidden" name="acao" value="inserir">
  <div class="col-md-4">
    <label class="form-label">Nome</label>
    <input type="text" name="nome" class="form-control">
  </div>
  <div class="col-md-2">
    <label class="form-label">Cor</label>
    <input type="color" name="cor" class="form-control form-control-color">
  </div>
  <div class="col-md-2 d-flex align-items-end">
    <label class="form-label">Habilitada</label>
    <input type="checkbox" name="habilitada" checked>
  </div>
  <div class="col-md-4 d-flex align-items-end">
    <button type="submit" class="btn btn-success">Adicionar</button>
  </div>
</form>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Nome</th><th>Cor</th><th>Habilitada</th><th>Ações</th>
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
        <td><input type="color" name="cor" value="<?= $row['cor'] ?>" class="form-control form-control-color"></td>
        <td class="text-center">
          <input type="checkbox" name="habilitada" <?= $row['habilitada'] ? 'checked' : '' ?>>
        </td>
        <td>
          <button class="btn btn-primary btn-sm">Salvar</button>
          <a href="?excluir=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir fase?')">Excluir</a>
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
