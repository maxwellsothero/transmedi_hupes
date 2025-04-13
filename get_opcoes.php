

<?php
// renderiza os dados das varias vinda do banco do menu Editar
include 'db.php';

$tabela = $_GET['tabela'] ?? '';
$coluna = $_GET['coluna'] ?? '';

if (!$tabela || !$coluna) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT DISTINCT $coluna FROM $tabela WHERE habilitada = 1 ORDER BY $coluna";
$res = mysqli_query($conn, $sql);

$options = [];
while ($row = mysqli_fetch_assoc($res)) {
    $options[] = $row[$coluna];
}

header('Content-Type: application/json');
echo json_encode($options);
