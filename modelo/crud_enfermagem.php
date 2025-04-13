<?php
    session_start();
    include '../db.php';
    require_once '../config.php';

    $resultado = mysqli_query($conn, "SELECT * FROM enfermagem ORDER BY id DESC");
    
    if (isset($_POST['acao']) && $_POST['acao'] === 'inserir') {
        $campos = ['nome','cpf','coren','nascimento','email','telefone','whatsapp','endereco','unidade'];
        $valores = [];
        foreach ($campos as $campo) {
            $valores[$campo] = mysqli_real_escape_string($conn, $_POST[$campo]);
        }
        $habilitada = isset($_POST['habilitada']) ? 1 : 0;
        $sql = "INSERT INTO enfermagem (" . implode(',', array_keys($valores)) . ", habilitada) VALUES ('" . implode("','", array_values($valores)) . "', $habilitada)";
        mysqli_query($conn, $sql);
        header('Location: crud_enfermagem.php'); exit;
    }
    
    if (isset($_POST['acao']) && $_POST['acao'] === 'atualizar') {
        $id = (int) $_POST['id'];
        $campos = ['nome','cpf','coren','nascimento','email','telefone','whatsapp','endereco','unidade'];
        $atualiza = [];
        foreach ($campos as $campo) {
            $valor = mysqli_real_escape_string($conn, $_POST[$campo]);
            $atualiza[] = "$campo='$valor'";
        }
        $habilitada = isset($_POST['habilitada']) ? 1 : 0;
        $atualiza[] = "habilitada=$habilitada";
        mysqli_query($conn, "UPDATE enfermagem SET " . implode(',', $atualiza) . " WHERE id=$id");
        header('Location: crud_enfermagem.php'); exit;
    }
    
    if (isset($_GET['excluir'])) {
        $id = (int) $_GET['excluir'];
        mysqli_query($conn, "DELETE FROM enfermagem WHERE id=$id");
        header('Location: crud_enfermagem.php'); exit;
    }

   include '../header.php';
?>

<body>


  <div class="d-flex justify-content-center align-items-center">
    <h2>Cadastro de Enfermeiros - Trasmedi / HUPES</h2>    
  </div>
  <div class="d-flex justify-content-end align-items-center">
    <a href="/logout.php" class="btn btn-outline-danger">Sair</a>
  </div>
  
 
<form method="post" class="row g-3 mb-4">
  <input type="hidden" name="acao" value="inserir">
  <?php $campos = ['nome','cpf','coren','nascimento','email','telefone','whatsapp','endereco','unidade']; ?>
  <?php foreach ($campos as $c): ?>
    <div class="col-md-3">
      <label class="form-label"><?= ucfirst($c) ?></label>
      <input type="text" name="<?= $c ?>" class="form-control">
    </div>
  <?php endforeach; ?>
  <div class="col-md-2 d-flex align-items-end">
    <label class="form-label">Habilitada</label>
    <input type="checkbox" name="habilitada" checked>
  </div>
  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-success">Adicionar</button>
  </div>
</form>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <?php foreach ($campos as $c): ?><th><?= ucfirst($c) ?></th><?php endforeach; ?>
      <th>Habilitada</th><th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
    <tr>
      <form method="post">
        <td><?= $row['id'] ?></td>
        <?php foreach ($campos as $c): ?>
          <td>
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="text" name="<?= $c ?>" value="<?= htmlspecialchars($row[$c]) ?>" class="form-control">
          </td>
        <?php endforeach; ?>
        <td class="text-center">
          <input type="checkbox" name="habilitada" <?= $row['habilitada'] ? 'checked' : '' ?>>
        </td>
        <td>
          <button class="btn btn-primary btn-sm">Salvar</button>
          <a href="?excluir=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir?')">Excluir</a>
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
