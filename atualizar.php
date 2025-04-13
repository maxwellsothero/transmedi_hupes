<?php
// atualizar.php
session_start();
include 'db.php';

if (!isset($_POST['id'])) {
    die('ID ausente');
}

$_POST['USUARIO'] = $_SESSION['usuario'];

$id = (int) $_POST['id'];
$campos = ['TIPO','SERVICO','CHAMADO','ORIGEM','DESTINO','PRONTUARIO','NOME_PACIENTE','CONDUTOR','ENFERMAGEM','KM','SAÍDA','CHEGADA','TEMPO_TOTAL','VALOR_UNIT','VALOR_TOTAL','OCORRENCIAS','FASE','USUARIO','data_remocao'];

$updates = [];
foreach ($campos as $campo) {
    if (isset($_POST[$campo])) {
        $valor = mysqli_real_escape_string($conn, $_POST[$campo]);
        $updates[] = "$campo = '$valor'";
    }
}

$update_sql = "UPDATE planilha_hupes SET " . implode(", ", $updates) . " WHERE id = $id";

if (mysqli_query($conn, $update_sql)) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao atualizar: " . mysqli_error($conn);
}
?>