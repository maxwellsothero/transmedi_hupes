<?php
include 'header.php';
include 'db.php';

$data_ini = $_GET['data_ini'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';

$where = '';
if (!empty($data_ini)) {
    $where .= " AND data_remocao >= '$data_ini'";
}
if (!empty($data_fim)) {
    $where .= " AND data_remocao <= '$data_fim'";
}

// Dados por FASE
$fases = [];
$resFase = mysqli_query($conn, "SELECT FASE, COUNT(*) as total FROM planilha_hupes WHERE 1 $where GROUP BY FASE");
while ($r = mysqli_fetch_assoc($resFase)) {
  $fases[$r['FASE']] = $r['total'];
}

// Dados por SERVIÇO
$servicos = [];
$resServico = mysqli_query($conn, "SELECT SERVICO, COUNT(*) as total FROM planilha_hupes WHERE 1 $where GROUP BY SERVICO");
while ($r = mysqli_fetch_assoc($resServico)) {
  $servicos[$r['SERVICO']] = $r['total'];
}
?>

<div class="container py-4">
  <h2 class="mb-4">Dashboard de Monitoramento</h2>

  <form method="get" class="row g-3 mb-4">
    <div class="col-md-3">
      <label class="form-label">Data Início</label>
      <input type="date" name="data_ini" class="form-control" value="<?= htmlspecialchars($data_ini) ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Data Fim</label>
      <input type="date" name="data_fim" class="form-control" value="<?= htmlspecialchars($data_fim) ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button class="btn btn-primary">Filtrar</button>
    </div>
  </form>

  <div class="row g-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-primary text-white">Comparativo por Fase</div>
        <div class="card-body">
          <canvas id="graficoFase"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-success text-white">Comparativo por Tipo de Serviço</div>
        <div class="card-body">
          <canvas id="graficoServico"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cores = [
    'rgba(54, 162, 235, 0.6)',
    'rgba(255, 99, 132, 0.6)',
    'rgba(255, 206, 86, 0.6)',
    'rgba(75, 192, 192, 0.6)',
    'rgba(153, 102, 255, 0.6)',
    'rgba(255, 159, 64, 0.6)',
    'rgba(201, 203, 207, 0.6)'
  ];

  new Chart(document.getElementById('graficoFase'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_keys($fases)) ?>,
      datasets: [{
        label: 'Total por Fase',
        data: <?= json_encode(array_values($fases)) ?>,
        backgroundColor: cores.slice(0, <?= count($fases) ?>)
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: { display: true, text: 'Fases' }
      }
    }
  });

  new Chart(document.getElementById('graficoServico'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_keys($servicos)) ?>,
      datasets: [{
        label: 'Total por Tipo de Serviço',
        data: <?= json_encode(array_values($servicos)) ?>,
        backgroundColor: cores.slice(0, <?= count($servicos) ?>)
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: { display: true, text: 'Tipo de Serviço' }
      }
    }
  });
});
</script>

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
<?php include 'footer.php'; ?>
