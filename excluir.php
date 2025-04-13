
<?php
// excluir.php
session_start();
include 'db.php';

$id = (int) $_POST['id'];
$senha = $_POST['senha'];

$uid = $_SESSION['usuario_id'];
$result = mysqli_query($conn, "SELECT senha FROM usuarios WHERE id = $uid");
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($senha, $user['senha'])) {
    mysqli_query($conn, "DELETE FROM planilha_hupes WHERE id = $id");
    header('Location: index.php');
} else {
    echo "<script>alert('Senha incorreta'); window.location='index.php';</script>";
}
?>
