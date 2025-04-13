<?php
include 'header.php';
include 'db.php';

// Captura filtros
$data_ini = $_GET['data_ini'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';
$fase = $_GET['fase'] ?? '';

// Monta consulta
$sql = "SELECT * FROM planilha_hupes WHERE 1";
if (!empty($data_ini)) {
    $sql .= " AND data_remocao >= '$data_ini'";
}
if (!empty($data_fim)) {
    $sql .= " AND data_remocao <= '$data_fim'";
}
if (!empty($fase)) {
    $fase = mysqli_real_escape_string($conn, $fase);
    $sql .= " AND FASE = '$fase'";
}
$sql .= " ORDER BY data_remocao DESC";
$result = mysqli_query($conn, $sql);

// Carrega fases ativas para o filtro
$fases = mysqli_query($conn, "SELECT nome FROM fase WHERE habilitada = 1 ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Relatórios - Transmedi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
</head>
<body class="container-fluid p-4">

<h2>Relatórios de Remoções</h2>
<form method="get" class="row g-3 mb-4">
  <div class="col-md-3">
    <label class="form-label">Data Início</label>
    <input type="date" name="data_ini" value="<?= htmlspecialchars($data_ini) ?>" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Data Fim</label>
    <input type="date" name="data_fim" value="<?= htmlspecialchars($data_fim) ?>" class="form-control">
  </div>
  <div class="col-md-3">
    <label class="form-label">Fase</label>
    <select name="fase" class="form-select">
      <option value="">Todas</option>
      <?php while ($row = mysqli_fetch_assoc($fases)): ?>
        <option value="<?= $row['nome'] ?>" <?= ($fase == $row['nome']) ? 'selected' : '' ?>><?= $row['nome'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button class="btn btn-primary" type="submit">Filtrar</button>
  </div>
</form>

<table id="tabela" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Data</th>
      <th>Prontuário</th>
      <th>Paciente</th>
      <th>Origem</th>
      <th>Destino</th>
      <th>Fase</th>
      <th>Condutor</th>
      <th>Enfermagem</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= date('d/m/Y', strtotime($row['data_remocao'])) ?></td>
        <td><?= htmlspecialchars($row['PRONTUARIO']) ?></td>
        <td><?= htmlspecialchars($row['NOME_PACIENTE']) ?></td>
        <td><?= htmlspecialchars($row['ORIGEM']) ?></td>
        <td><?= htmlspecialchars($row['DESTINO']) ?></td>
        <td><?= htmlspecialchars($row['FASE']) ?></td>
        <td><?= htmlspecialchars($row['CONDUTOR']) ?></td>
        <td><?= htmlspecialchars($row['ENFERMAGEM']) ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- Scripts necessários -->
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

<script>
$(document).ready(function() {
  $('#tabela').DataTable({
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'csvHtml5',
        text: 'Exportar CSV',
        charset: 'utf-8',
        bom: true,
        filename: 'relatorio_remocoes',
        title: null
      },
      {
        extend: 'pdfHtml5',
        text: 'Exportar PDF',
        orientation: 'landscape',
        pageSize: 'A4',
        filename: 'relatorio_remocoes',
        customize: function (doc) {
          doc.content.splice(0, 0,
            {
              text: 'Relatório de Remoções - Transmedi',
              alignment: 'center',
              fontSize: 16,
              margin: [0, 0, 0, 10]
            },
            {
              text: 'Filtros: <?= $data_ini ?> a <?= $data_fim ?> | Fase: <?= $fase ?: 'Todas' ?>',
              alignment: 'center',
              fontSize: 11,
              margin: [0, 0, 0, 10]
            }
          );
        }
      },
      'print'
    ],
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
    }
  });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>
