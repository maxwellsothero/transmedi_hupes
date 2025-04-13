<?php
session_start();
include 'db.php';
include 'modelo/whatsapp/envio.php'; // função enviazap()
include 'modelo/email/enviamail.php'; // função enviazap()


// Verifica sessão
if (!isset($_SESSION['usuario_nome'])) {
    die("❌ Sessão inválida: usuário não identificado.");
}

// Prepara dados do usuário
$valores['USUARIO'] = mysqli_real_escape_string($conn, $_SESSION['usuario_nome']);

// Define os campos
$campos = ['TIPO','SERVICO','CHAMADO','ORIGEM','DESTINO','PRONTUARIO','NOME_PACIENTE',
           'CONDUTOR','ENFERMAGEM','KM','SAÍDA','CHEGADA','TEMPO_TOTAL','VALOR_UNIT',
           'VALOR_TOTAL','OCORRENCIAS','FASE','USUARIO','data_remocao'];

// Captura os valores
foreach ($campos as $campo) {
    if (!isset($valores[$campo])) {
        $valores[$campo] = mysqli_real_escape_string($conn, $_POST[$campo] ?? '');
    }
}

// Validação obrigatória
if (empty($valores['data_remocao'])) {
    die("❌ Erro: A data de remoção é obrigatória.");
}

// Monta e executa INSERT
$cols = implode(",", array_keys($valores));
$vals = "'" . implode("','", array_values($valores)) . "'";
$query = "INSERT INTO planilha_hupes ($cols) VALUES ($vals)";

if (mysqli_query($conn, $query)) {
    // 🆕 Pega o último ID inserido
    $id = mysqli_insert_id($conn);
    $result = mysqli_query($conn, "SELECT * FROM planilha_hupes WHERE id = $id");
    $dadosInseridos = mysqli_fetch_assoc($result);

    // Envia mensagem zap
    enviazap($dadosInseridos, 'cadastro');
    enviaEmail($dadosInseridos, 'cadastro');


    // Redireciona
    header('Location: index.php');
    exit;
} else {
    die("❌ Erro ao inserir: " . mysqli_error($conn));
}
?>
