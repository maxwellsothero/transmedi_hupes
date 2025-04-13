<?php
session_start();
include 'db.php';

// Garante que o nome do usuário logado está na sessão
if (!isset($_SESSION['usuario_nome'])) {
    die("❌ Sessão inválida: usuário não identificado.");
}

// Define o nome do usuário no campo USUARIO
$valores['USUARIO'] = mysqli_real_escape_string($conn, $_SESSION['usuario_nome']);

// Define os campos da tabela
$campos = ['TIPO','SERVICO','CHAMADO','ORIGEM','DESTINO','PRONTUARIO','NOME_PACIENTE',
           'CONDUTOR','ENFERMAGEM','KM','SAÍDA','CHEGADA','TEMPO_TOTAL','VALOR_UNIT',
           'VALOR_TOTAL','OCORRENCIAS','FASE','USUARIO','data_remocao'];

// Captura os valores do POST
foreach ($campos as $campo) {
    if (!isset($valores[$campo])) {
        $valores[$campo] = mysqli_real_escape_string($conn, $_POST[$campo] ?? '');
    }
}

// Validação: Data de remoção obrigatória
if (empty($valores['data_remocao'])) {
    die("❌ Erro: A data de remoção é obrigatória.");
}

// Monta os campos e valores para INSERT
$cols = implode(",", array_keys($valores));
$vals = "'" . implode("','", array_values($valores)) . "'";

// Executa o INSERT
$query = "INSERT INTO planilha_hupes ($cols) VALUES ($vals)";
mysqli_query($conn, $query) or die("❌ Erro ao inserir: " . mysqli_error($conn));

// Redireciona
header('Location: index.php');
exit;
?>
