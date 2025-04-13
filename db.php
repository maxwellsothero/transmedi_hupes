<?php
// db.php

$conn = mysqli_connect('localhost', 'root', 'maxwell1983', 'sistema_remocao');
if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

if (!isset($_SESSION['usuario_id']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}
?>
