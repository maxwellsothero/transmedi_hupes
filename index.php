<?php
session_start();
include 'db.php';
require_once 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$campos = ['TIPO','SERVICO','CHAMADO','ORIGEM','DESTINO','PRONTUARIO','NOME_PACIENTE','CONDUTOR','ENFERMAGEM','KM','SAÍDA','CHEGADA','TEMPO_TOTAL','VALOR_UNIT','VALOR_TOTAL','OCORRENCIAS','FASE','USUARIO','data_remocao'];

function gerar_select($tabela, $coluna, $name, $selected = '') {
    global $conn;
    $res = mysqli_query($conn, "SELECT DISTINCT $coluna FROM $tabela WHERE habilitada = 1 ORDER BY $coluna");
    $html = "<select name='$name' id='edit_$name' class='form-select' required>";
    $html .= "<option value=''>Selecione</option>";
    while ($row = mysqli_fetch_assoc($res)) {
        $valor = htmlspecialchars($row[$coluna]);
        $sel = ($valor == $selected) ? 'selected' : '';
        $html .= "<option value='$valor' $sel>$valor</option>";
    }
    $html .= "</select>";
    return $html;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

<style>
  nav.navbar {
    position: sticky;
    top: 0;
    z-index: 1030;
  }
</style>

<body>
<?php include 'header.php'; ?>

<div class="d-flex justify-content-center align-items-center">
  <h2>Controle de Remoções - HUPES</h2>
</div>
<div class="d-flex justify-content-end align-items-center">
  <a href="logout.php" class="btn btn-outline-danger">Sair</a>
</div>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCadastro">Cadastrar Remoção</button>

<div class="table-responsive">
  <table id="tabela" class="table table-bordered table-striped">
    <thead>
      <tr>
        <?php foreach ($campos as $col) echo "<th>$col</th>"; ?>
        <th>AÇÕES</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Carrega cores da tabela 'fase'
      $fasesCores = [];
      $resFases = mysqli_query($conn, "SELECT nome, cor FROM fase");
      while ($f = mysqli_fetch_assoc($resFases)) {
        $fasesCores[$f['nome']] = $f['cor'];
      }

      // Consulta as remoções
      $query = "SELECT * FROM planilha_hupes";
      $result = mysqli_query($conn, $query);

      if (!$result) {
        echo "<tr><td colspan='" . (count($campos)+1) . "' class='text-danger text-center'>Erro ao carregar dados da tabela.</td></tr>";
      } else {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          foreach ($campos as $col) {
            if ($col === 'data_remocao' && !empty($row[$col])) {
              echo "<td>" . date('d/m/Y', strtotime($row[$col])) . "</td>";
            } elseif ($col === 'FASE') {
              $fase = htmlspecialchars($row[$col]);
              $corFundo = $fasesCores[$fase] ?? '#cccccc';
              echo "<td><span class='badge text-light' style='background-color: $corFundo;'>$fase</span></td>";
            } else {
              echo "<td>" . htmlspecialchars($row[$col]) . "</td>";
            }
          }

          $jsonRow = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

          echo "<td>
                  <div class='d-flex gap-1'>
                    <button class='btn btn-sm btn-warning' onclick='editar($jsonRow)'>Editar</button>
                    <button class='btn btn-sm btn-danger' onclick=\"confirmarExclusao('{$row['id']}')\">Excluir</button>
                    <button class='btn btn-sm btn-secondary' onclick='baixarPDF($jsonRow)'>PDF</button>
                  </div>
                </td></tr>";
        }
      }
      ?>
    </tbody>
  </table>
</div>


<?php include 'modais.php'; ?>

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
    scrollX: true,
    dom: 'Bfrtip',
    buttons: [
      { extend: 'csvHtml5', text: 'CSV' },
      { extend: 'excelHtml5', text: 'Excel' },
      { extend: 'pdfHtml5', text: 'PDF', orientation: 'landscape', pageSize: 'A4' },
      { extend: 'print', text: 'Imprimir' }
    ],
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
    }
  });
});
</script>

<!-- Modal Cadastro -->
<div class="modal fade" id="modalCadastro" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="crud.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Cadastrar Remoção</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <?php foreach ($campos as $campo): ?>
              <div class="col-md-4 mb-3">
                <label class="form-label"><?= $campo ?></label>
                <?php if ($campo === 'TIPO'): ?>
                  <?= gerar_select('tipo', 'tipo', 'TIPO') ?>
                <?php elseif ($campo === 'SERVICO'): ?>
                  <?= gerar_select('servico', 'servico', 'SERVICO') ?>
                <?php elseif ($campo === 'CHAMADO'): ?>
                  <?= gerar_select('chamado', 'chamado', 'CHAMADO') ?>
                <?php elseif ($campo === 'CONDUTOR'): ?>
                  <?= gerar_select('condutor', 'nome', 'CONDUTOR') ?>
                <?php elseif ($campo === 'ENFERMAGEM'): ?>
                  <?= gerar_select('enfermagem', 'nome', 'ENFERMAGEM') ?>
                <?php elseif ($campo === 'FASE'): ?>
                  <?= gerar_select('fase', 'nome', 'FASE') ?>
                <?php elseif ($campo === 'data_remocao'): ?>
                  <input type="date" name="<?= $campo ?>" class="form-control" min="<?= date('Y-m-d') ?>">
                <?php elseif ($campo === 'SAÍDA' || $campo === 'CHEGADA'): ?>
                  <input type="text" name="<?= $campo ?>" class="form-control" id="<?= strtolower($campo) ?>" onclick="preencherHoraAtual('<?= strtolower($campo) ?>')" placeholder="HH:MM">
                  <?php elseif ($campo === 'USUARIO'): ?>
                    <input type="text" name="<?= $campo ?>" class="form-control" value="<?= $_SESSION['usuario_nome'] ?? '' ?>" readonly>  
                <?php else: ?>
                  <input type="text" name="<?= $campo ?>" class="form-control">
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edição -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="atualizar.php" method="post">
        <input type="hidden" name="id" id="edit_id">
        <div class="modal-header">
          <h5 class="modal-title">Editar Remoção</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <?php foreach ($campos as $campo): ?>
              <div class="col-md-4 mb-3">
                <label class="form-label"><?= $campo ?></label>
                <?php if ($campo === 'TIPO'): ?>
                  <?= gerar_select('tipo', 'tipo', $campo) ?>
                <?php elseif ($campo === 'SERVICO'): ?>
                  <?= gerar_select('servico', 'servico', $campo) ?>
                <?php elseif ($campo === 'CHAMADO'): ?>
                  <?= gerar_select('chamado', 'chamado', $campo) ?>
                <?php elseif ($campo === 'CONDUTOR'): ?>
                  <?= gerar_select('condutor', 'nome', $campo) ?>
                <?php elseif ($campo === 'ENFERMAGEM'): ?>
                  <?= gerar_select('enfermagem', 'nome', $campo) ?>
                  <?php elseif ($campo === 'FASE'): ?>
  <?= gerar_select('fase', 'nome', 'FASE') ?>
<?php elseif ($campo === 'data_remocao'): ?>
  <input type="date" name="<?= $campo ?>" id="edit_<?= $campo ?>" class="form-control">
<?php elseif ($campo === 'SAÍDA' || $campo === 'CHEGADA'): ?>
  <input type="text" name="<?= $campo ?>" id="edit_<?= $campo ?>" class="form-control" placeholder="HH:MM" onclick="preencherHoraAtual('edit_<?= $campo ?>')">
<?php elseif ($campo === 'USUARIO'): ?>
  <input type="text" name="<?= $campo ?>" id="edit_<?= $campo ?>" class="form-control" value="<?= $_SESSION['usuario_nome'] ?? '' ?>" readonly>
<?php else: ?>
  <input type="text" name="<?= $campo ?>" id="edit_<?= $campo ?>" class="form-control">
<?php endif; ?>
</div>
<?php endforeach; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Atualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Exclusao -->
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="excluir.php" method="post">
        <input type="hidden" name="id" id="idExcluir">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <p>Digite sua senha para confirmar:</p>
          <input type="password" name="senha" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Excluir</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function editar(dados) {
  const campos = <?= json_encode($campos) ?>;
  campos.forEach(campo => {
    const input = document.getElementById('edit_' + campo);
    if (input) {
      if (input.tagName === 'SELECT') {
        input.value = dados[campo] || '';
      } else if (input.type === 'date') {
        input.value = dados[campo] ? new Date(dados[campo]).toISOString().split('T')[0] : '';
      } else {
        input.value = dados[campo] || '';
      }
    }
  });
  document.getElementById('edit_id').value = dados['id'];
  const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
  modal.show();
}

function confirmarExclusao(id) {
  document.getElementById('idExcluir').value = id;
  const modal = new bootstrap.Modal(document.getElementById('modalExcluir'));
  modal.show();
}

function baixarPDF(dados) {
  const campos = <?= json_encode($campos) ?>;
  const conteudo = campos.map(campo => {
    const valor = dados[campo] || '';
    return { text: `${campo}: ${valor}`, margin: [0, 2] };
  });
  const docDefinition = {
    content: [
      { text: 'Relatório de Remoção - HUPES', style: 'header', alignment: 'center', margin: [0, 0, 0, 10] },
      ...conteudo
    ],
    styles: {
      header: { fontSize: 18, bold: true }
    }
  };
  pdfMake.createPdf(docDefinition).download(`remocao_${dados.id || 'sem_id'}.pdf`);
}

function preencherHoraAtual(id) {
  const agora = new Date();
  const hora = agora.getHours().toString().padStart(2, '0');
  const minuto = agora.getMinutes().toString().padStart(2, '0');
  document.getElementById(id).value = `${hora}:${minuto}`;
}
</script>

<?php include 'footer.php'; ?>
</body>