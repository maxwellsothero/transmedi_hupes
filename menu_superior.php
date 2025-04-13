<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
  <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>index.php">
  <img src="<?= BASE_URL ?>transmedi.png" alt="Logo" width="100" height="100">
  <span>Transmedi - HUPES</span>
</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto ">
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>dashboard.php">DASHBOARD</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>index.php">Remoções</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCadastro" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cadastros
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownCadastro">
            <li><a class="dropdown-item" href="<?= BASE_URL ?>modelo/crud_tipo.php">Tipo</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>modelo/crud_chamado.php">Chamado</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>modelo/crud_servico.php">Serviço</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>modelo/crud_condutor.php">Condutor</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>modelo/crud_enfermagem.php">Enfermagem</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>modelo/crud_fase.php">Fases</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>modelo/crud_usuario.php">Usuários</a></li>
          </ul>
        </li>
        <li class="nav-item">
      
          <a class="nav-link" href="<?= BASE_URL ?>relatorio.php">Relatórios</a>

        </li>
      
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-danger" href="<?= BASE_URL ?>logout.php">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
