<?php
    session_start();
    include '../db.php';
    require_once '../config.php';

// Listar todos
$resultado = mysqli_query($conn, "SELECT * FROM tipo ORDER BY id DESC");

// Inserir
if (isset($_POST['acao']) && $_POST['acao'] === 'inserir') {
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    $habilitada = isset($_POST['habilitada']) ? 1 : 0;
    mysqli_query($conn, "INSERT INTO tipo (tipo, habilitada) VALUES ('$tipo', $habilitada)");
    header('Location: crud_tipo.php');
    exit;
}

// Atualizar
if (isset($_POST['acao']) && $_POST['acao'] === 'atualizar') {
    $id = (int) $_POST['id'];
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    $habilitada = isset($_POST['habilitada']) ? 1 : 0;
    mysqli_query($conn, "UPDATE tipo SET tipo='$tipo', habilitada=$habilitada WHERE id=$id");
    header('Location: crud_tipo.php');
    exit;
}

// Excluir
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    mysqli_query($conn, "DELETE FROM tipo WHERE id = $id");
    header('Location: crud_tipo.php');
    exit;
}
   include '../header.php';
?>

<body >
  <h2>Cadastro de Tipos</h2>
  <form method="post" class="row g-3 mb-4">
    <input type="hidden" name="acao" value="inserir">
    <div class="col-md-6">
      <label class="form-label">Tipo</label>
      <input type="text" name="tipo" class="form-control" required>
    </div>
    <div class="col-md-2">
      <label class="form-label d-block">Habilitada</label>
      <input type="checkbox" name="habilitada" checked>
    </div>
    <div class="col-md-4 d-flex align-items-end">
      <button type="submit" class="btn btn-success">Adicionar</button>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Habilitada</th>
        <th>Ações</th>
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
              <input type="text" name="tipo" value="<?= htmlspecialchars($row['tipo']) ?>" class="form-control">
            </td>
            <td class="text-center">
              <input type="checkbox" name="habilitada" <?= $row['habilitada'] ? 'checked' : '' ?>>
            </td>
            <td>
              <button class="btn btn-primary btn-sm">Salvar</button>
              <a href="?excluir=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este tipo?')">Excluir</a>
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
<script>
  $(document).ready(function() {
    $('table').DataTable({
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
      }
    });
  });
</script>
